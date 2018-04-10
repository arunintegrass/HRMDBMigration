<?php

	include('messagelog.php');
	include('updateCompanyId.php');
	function mainTableMigration($dbArray,$mainTable,$subTableArray,$moduleName){
			
		if(isset($mainTable[0]['extraUpdate'])){
				//include('updateCompanyId.php');
		}
			
		for($k = 0; $k < count($mainTable); $k++){	
		
				
					
			 $select_id = mysql_query("SELECT ".$mainTable[$k]['pKey']." as uniq_id from ".$dbArray['srcDB'].".".$mainTable[$k]['tbName']);
			
			$filename=$moduleName.$mainTable[$k]['tbName'];	

			//Column Name
			$columnQuery = " SELECT GROUP_CONCAT(COLUMN_NAME) FROM information_schema.columns WHERE table_schema = '".$dbArray['srcDB']."' AND table_name = '".$mainTable[$k]['tbName']."'  and column_name NOT IN ( '".$mainTable[$k]['pKey']."') ";	
			$execolumnQuery = mysql_query($columnQuery);
			$rescolumnQuery = mysql_fetch_array($execolumnQuery);			
			
			//Disable Foreign Key Check Temporarily Disable
			$foreignkeyQuery_disable =  " SET FOREIGN_KEY_CHECKS = 0;";
			$foreignkeyQueryExe_disable = mysql_query($foreignkeyQuery_disable);
			
			//Inserting One Unique At one Time in all the table
			while($row_id = mysql_fetch_array($select_id)){
				
				$old_unique_id = $row_id['uniq_id'];
				
				//Insert into the main table
				$msg = "Old Unique Id - ".$old_unique_id;	
				msg_log($msg,$filename.'Queries');	
						
					
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
						
						/*$subQuery1 = "update ".$dbArray['destDB'].".".$subTableArray[$k][$i]['tbName']." set ".$subTableArray[$k][$i]['fKey']." = ".$latest_unique_id." where ".$subTableArray[$k][$i]['fKey']." = ".$old_unique_id;
						if(isset($subTableArray[$k][$i]['extraCond'])){
							$subQuery1 .= $subTableArray[$k][$i]['extraCond'];
						}*/

						$subQueryCond = "";
						if(isset($subTableArray[$k][$i]['extraCond'])){
							$subQueryCond = $subTableArray[$k][$i]['extraCond'];
						}	
						$subQuery1 = " UPDATE 
										  ".$dbArray['destDB'].".".$subTableArray[$k][$i]['tbName']." dest,
										  (SELECT
												(`".$subTableArray[$k][$i]['pKey']."`) as pArray
											FROM
												".$dbArray['destDB'].".".$subTableArray[$k][$i]['tbName']."
											WHERE
												".$subTableArray[$k][$i]['fKey']." = '".$old_unique_id."' 
												".$subQueryCond."
												) src 
										SET
										  dest.".$subTableArray[$k][$i]['fKey']." = '".$latest_unique_id."'
										WHERE 
										   dest.`".$subTableArray[$k][$i]['pKey']."` IN ( src.pArray) " ;
														
						$subTableCopyQuery1 = mysql_query($subQuery1);
						
						if($subTableCopyQuery1){
							$msg = "Sub Table ".($i+1)." : ".$subTableArray[$k][$i]['tbName']." updated Successfully\r\n\n";
							msg_log($msg,$filename.'Success');
						}else{
							$msg = "Sub Table ".($i+1)." : ".$subTableArray[$k][$i]['tbName']." not updated successfully ".mysql_error();				 
							msg_log($msg,$filename.'Fail');
						}
					}	
					
						
					if(isset($mainTable[$k]['extraUpdate'])){
						$extraUpdateQuery = "update ".$dbArray['destDB'].".".$mainTable[$k]['tbName']." set ".$mainTable[$k]['extraUpdate']." where ".$mainTable[$k]['pKey']." = ".$latest_unique_id;
						//$extraUpdateQuery .= " and "; 
						$extraTableUpdateQuery = mysql_query($extraUpdateQuery);
						if($extraTableUpdateQuery){
							$msg = "Extra Update Table ".($i+1)." : ".$mainTable[$k]['tbName']." updated Successfully\r\n\n";
							msg_log($msg,$filename.'Success');
						}else{
							$msg = "Extra Update Table ".($i+1)." : ".$mainTable[$k]['tbName']." not updated successfully ".mysql_error();				 
							msg_log($msg,$filename.'Fail');
						}
						//include('updateCompanyId.php');
						updateCompanyId($dbArray,$mainTable,$old_unique_id,'UpdateCompanyModule_');
					}	
					
					
				}else{
					  $msg =  "Main Table : ".$mainTable[$k]['tbName']." Old Unique Id - ".$old_unique_id." not migrated successfully ".mysql_error();
					  msg_log($msg,$filename.'Fail');
				 }
			}	 
			
			//Disable Foreign Key Check Enable
			$foreignkeyQuery_enable =  " SET FOREIGN_KEY_CHECKS = 1;";
			$foreignkeyQueryExe_enable = mysql_query($foreignkeyQuery_enable);
		}
	}	
		
?>