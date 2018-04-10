<?php

	include('../variable.php');
	include('../messagelog.php');
	
	
	//project Tables
	$mainTable  =   array(
							['pKey'=>'task_id','tbName'=>'hrm_project_task_tb'], // task_id
							['pKey'=>'project_id','tbName'=>'hrm_project_tb'],  //project_id
							['pKey'=>'client_id','tbName'=>'hrm_client_tb'],  //project_id
							
						);							
						
	$subTableArray  =   array(
							//Update - task_id
							array(
									['fKey'=>'task_id','tbName'=>'hrm_project_map_tb'],				
									['fKey'=>'task_id','tbName'=>'hrm_emp_timesheet'],				
								),
							//Update - project_id	
							array(
									['fKey'=>'project_id','tbName'=>'hrm_project_map_tb'],				
									['fKey'=>'project_id','tbName'=>'hrm_project_tb'],				
									['fKey'=>'project_id','tbName'=>'hrm_emp_timesheet'],				
								),	 		
							//Update - client_id
							array(
									['fKey'=>'client_id','tbName'=>'hrm_project_tb'],			
								),	
						);	
				
	
		for($k = 0; $k < count($mainTable); $k++){	
		
			$select_id = mysql_query("SELECT ".$mainTable[$k]['pKey']." as uniq_id from ".$dbArray['srcDB'].".".$mainTable[$k]['tbName']);
			
			$filename='projectModule_'.$mainTable[$k]['tbName'];		
			
			//Inserting One Unique At one Time in all the table
			while($row_id = mysql_fetch_array($select_id)){
				
				$old_unique_id = $row_id['uniq_id'];
				
				//Insert into the main table
				$msg = "Old Unique Id - ".$old_unique_id;	
				msg_log($msg,$filename.'Queries');	
				
				$columnQuery = " SELECT GROUP_CONCAT(COLUMN_NAME) FROM information_schema.columns WHERE table_schema = '".$dbArray['srcDB']."' AND table_name = '".$mainTable[$k]['tbName']."'  and column_name NOT IN ( '".$mainTable[$k]['pKey']."') ";	
				$execolumnQuery = mysql_query($columnQuery);
				$rescolumnQuery = mysql_fetch_array($execolumnQuery);
					
				//Insert into sub tables and update the Unique id with latest Unique id
				 $mainQuery =  "INSERT INTO ".$dbArray['destDB'].".".$mainTable[$k]['tbName'].							
								"(".$rescolumnQuery[0].")".
							   " SELECT ".$rescolumnQuery[0]." from ".$dbArray['srcDB'].".".$mainTable[$k]['tbName']." 
								where .".$mainTable[$k]['tbName'].".".$mainTable[$k]['pKey']." = ".$old_unique_id;	
				
				$latest_query = mysql_query($mainQuery);
				
				if($latest_query){
					
					//Latest Unique Id
					$latest_unique_id = mysql_insert_id();
					$msg = "New Unique Id - ".$latest_unique_id." is successfully migrated to ".$mainTable[$k]['tbName'];
					
					msg_log($msg,$filename.'Queries');	

					for($i=0;$i<count($subTableArray[$k]);$i++){
						
						$subQuery1 = "update ".$dbArray['destDB'].".".$subTableArray[$k][$i]['tbName']." set ".$subTableArray[$k][$i]['fKey']." = ".$latest_unique_id." where ".$subTableArray[$k][$i]['fKey']." = ".$old_unique_id;
						$subTableCopyQuery1 = mysql_query($subQuery1);
						
						if($subTableCopyQuery1){
							$msg = "Sub Table ".($i+1)." : ".$subTableArray[$k][$i]['tbName']." updated Successfully\r\n\n";
							msg_log($msg,$filename.'Success');
						}else{
							$msg = "Sub Table ".($i+1)." : ".$subTableArray[$k][$i]['tbName']." not updated successfully ".mysql_error();				 
							msg_log($msg,$filename.'Fail');
						}
					}	
					
				}else{
					  $msg =  "Main Table : ".$mainTable[$k]['tbName']." Old Unique Id - ".$old_unique_id." not migrated successfully ".mysql_error();
					  msg_log($msg,$filename.'Fail');
				 }
			}	 
		}
?>