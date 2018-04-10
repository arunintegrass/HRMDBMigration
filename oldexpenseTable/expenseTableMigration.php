<?php

	include('../variable.php');
	include('../messagelog.php');
	
	
		//Expense Tables
	$mainTable  =   array(
							['pKey'=>'doc_map_id','tbName'=>'hrm_expuploadmap_td'], // doc_map_id
							['pKey'=>'tracking_id','tbName'=>'hrm_emp_descriptionexp_td']  //tracking_id
						);							
						
	$subTableArray  =   array(
							//Expense Tables
							array(
									['fKey'=>'doc_map_id','tbName'=>'hrm_emp_exp_td'],				
								),
							array(
									['fKey'=>'tracking_id','tbName'=>'hrm_expense_history_process'],				
								),	 								 
						);	
				
	
		for($k = 0; $k < count($mainTable); $k++){	
		
			$select_id = mysql_query("SELECT ".$mainTable[$k]['pKey']." as uniq_id from ".$dbArray['srcDB'].".".$mainTable[$k]['tbName']);
			
			$filename='expenseModule_'.$mainTable[$k]['tbName'];		
			
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
					$msg = "Migrated to New Unique Id - ".$latest_unique_id;
					
					msg_log($msg,$filename.'Queries');	

					for($i=0;$i<count($subTableArray[$k]);$i++){
						
						$subQuery1 = "update ".$dbArray['destDB'].".".$subTableArray[$k][$i]['tbName']." set ".$subTableArray[$k][$i]['fKey']." = ".$latest_unique_id." where ".$subTableArray[$k][$i]['fKey']." = ".$old_unique_id;
						$subTableCopyQuery1 = mysql_query($subQuery1);
						
						if($subTableCopyQuery1){
							$msg = "Sub Table ".($i+1)." : ".$subTableArray[$k][$i]['tbName']." migrated Successfully\r\n\n";
							msg_log($msg,$filename.'Success');
						}else{
							$msg = "Sub Table ".($i+1)." : ".$subTableArray[$k][$i]['tbName']." not migrated successfully ".mysql_error();				 
							msg_log($msg,$filename.'Fail');
						}
					}	
					
				}else{
					  $msg =  "Main Table : ".$mainTable[$k]['tbName']." not migrated successfully ".mysql_error();
					  msg_log($msg,$filename.'Fail');
				 }
			}	 
		}
?>