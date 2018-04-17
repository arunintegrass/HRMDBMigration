<?php

	include('messagelog.php');
	
	function masterTableMigration($dbArray,$mainTable,$subTableArray,$moduleName,$con){
		
		
		
		
		for($k = 0; $k < count($mainTable); $k++){	
			
			//Adding Extra Column Where the data are migrated or not - migratestatus
			for($i=0;$i<count($subTableArray[$k]);$i++){
				//if((!isset($subTableArray[$k][$i]['migrateUpdate']))||((isset($subTableArray[$k][$i]['migrateUpdate']))&&($subTableArray[$k][$i]['migrateUpdate'] == 1))){
					//$destExtraColumn = "ALTER TABLE ".$dbArray['destDB'].".".$subTableArray[$k][$i]['tbName']." ADD `migratestatus` VARCHAR(10) NOT NULL DEFAULT '0'";
					$destExtraColumn = "ALTER TABLE ".$dbArray['destDB'].".".$subTableArray[$k][$i]['tbName']." ADD `migratestatus` INT(11) NOT NULL DEFAULT '0'";
					//echo $destExtraColumn;
					$exedestExtraColumn = mysql_query($destExtraColumn);
				//}	
			}
		
			$extraColumn = "";
			$new_id = $up_id = 0;
			if(isset($mainTable[$k]['uniqData2'])){
				$extraColumn .= ",".$mainTable[$k]['uniqData2']." as uniq_data_2 ";				
			}	
			if(isset($mainTable[$k]['uniqData3'])){
				$extraColumn .= ",".$mainTable[$k]['uniqData3']." as uniq_data_3 ";				
			}	
			if(isset($mainTable[$k]['uniqData4'])){
				$extraColumn .= ",".$mainTable[$k]['uniqData4']." as uniq_data_4 ";				
			}			
			if(isset($mainTable[$k]['uniqData5'])){
				$extraColumn .= ",".$mainTable[$k]['uniqData5']." as uniq_data_5 ";				
			}
			if(isset($mainTable[$k]['uniqData6'])){
				$extraColumn .= ",".$mainTable[$k]['uniqData6']." as uniq_data_6 ";				
			}				
			
			
			//$select_id = mysql_query("SELECT ".$mainTable[$k]['pKey']." as uniq_id,".$mainTable[$k]['uniqData1']." as uniq_data_1,".$mainTable[$k]['uniqData2']." as uniq_data_2 ".$extraColumn." from ".$dbArray['srcDB'].".".$mainTable[$k]['tbName']);
			$select_id = mysql_query("SELECT ".$mainTable[$k]['pKey']." as uniq_id,".$mainTable[$k]['uniqData1']." as uniq_data_1 ".$extraColumn." from ".$dbArray['srcDB'].".".$mainTable[$k]['tbName']);
			//echo $k." SELECT ".$mainTable[$k]['pKey']." as uniq_id,".$mainTable[$k]['uniqData1']." as uniq_data_1,".$mainTable[$k]['uniqData2']." as uniq_data_2 ".$extraColumn." from ".$dbArray['srcDB'].".".$mainTable[$k]['tbName']."<br>";
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
				$extraCond = "";
				$old_unique_id = trim($row_id['uniq_id']);
				$uniq_data_1 = trim($row_id['uniq_data_1']);
				//$uniq_data_2 = trim($row_id['uniq_data_2']);
				$uniq_data_2 = $uniq_data_3 = $uniq_data_4 = $uniq_data_5 = $uniq_data_6 = "";
				if(isset($mainTable[$k]['uniqData2'])){
					$uniq_data_2 = trim($row_id['uniq_data_2']);
					$extraCond .= " and ".$mainTable[$k]['uniqData2']."='".$uniq_data_2."'  ";
				}
				if(isset($mainTable[$k]['uniqData3'])){
					$uniq_data_3 = trim($row_id['uniq_data_3']);
					$extraCond .= "and ".$mainTable[$k]['uniqData3']."='".$uniq_data_3."' ";
				}
				if(isset($mainTable[$k]['uniqData4'])){
					$uniq_data_4 = trim($row_id['uniq_data_4']);
					$extraCond .= "and ".$mainTable[$k]['uniqData4']."='".$uniq_data_4."' ";
				}
				if(isset($mainTable[$k]['uniqData5'])){
					$uniq_data_5 = trim($row_id['uniq_data_5']);
					$extraCond .= "and ".$mainTable[$k]['uniqData5']."='".$uniq_data_5."' ";
				}
				if(isset($mainTable[$k]['uniqData6'])){
					$uniq_data_6 = trim($row_id['uniq_data_6']);
					$extraCond .= "and ".$mainTable[$k]['uniqData6']."='".$uniq_data_6."' ";
				}
				
				//Insert into the main table
				$msg = "Old Unique Id - ".$old_unique_id.' Unique Name - '.$uniq_data_1;	
				msg_log($msg,$filename.'Queries');							
				
				/*
				//Check whether the Destination table having the same data is previous available or not
				$dataPreviousAvailQuery = "SELECT ".$mainTable[$k]['pKey']." as new_uniq_id,".$mainTable[$k]['uniqData1']." as new_uniq_data_1,".$mainTable[$k]['uniqData2']." as new_uniq_data_2 from ".$dbArray['destDB'].".".$mainTable[$k]['tbName'].
											" where ".$mainTable[$k]['uniqData1']."='".$uniq_data_1."' and ".$mainTable[$k]['uniqData2']."='".$uniq_data_2."' ".$extraCond ; */
									
									
									
				//Check whether the Destination table having the same data is previous available or not
				$dataPreviousAvailQuery = "SELECT ".$mainTable[$k]['pKey']." as new_uniq_id,".$mainTable[$k]['uniqData1']." as new_uniq_data_1 from ".$dbArray['destDB'].".".$mainTable[$k]['tbName'].
											" where ".$mainTable[$k]['uniqData1']."='".$uniq_data_1."' ".$extraCond ;									
											
						
				$dataPreviousAvail = mysql_query($dataPreviousAvailQuery,$con);
				//$fetchdataPreviousAvail = mysql_fetch_array($dataPreviousAvail);
				$countdataPreviousAvail = mysql_num_rows($dataPreviousAvail);
				//$countdataPreviousAvail = count($fetchdataPreviousAvail);
				//echo ' Count -  '.$countdataPreviousAvail.' -  '."<br>";	
				//echo $dataPreviousAvailQuery.'<br>';					
				
				if($countdataPreviousAvail <= 0)
				{	
						//If Data if not available	
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
								
								$migrateCheckStatus = "0";
								$migrateUpdateStatus = "1";
								if(isset($subTableArray[$k][$i]['migrateUpdate'])){
									//First Time To Change the hrm_emp_leave_td
									if($subTableArray[$k][$i]['migrateUpdate'] == 1){
										//$migrateCheckStatus = "0";
										$migrateCheckStatus = "0";
										$migrateUpdateStatus = "2";
									 }	
									 //Second Time To Change the hrm_emp_leave_td
									 if($subTableArray[$k][$i]['migrateUpdate'] == 2){
										//$migrateCheckStatus = "2";
										$migrateCheckStatus = "0,2";
										$migrateUpdateStatus = "1";
									 }	
								}	
								
												
								//Old Update Query - Not Working Same Column Update and Same Column Fetch is not working fine
								//$subQuery1 = "update ".$dbArray['destDB'].".".$subTableArray[$k][$i]['tbName']." set ".$subTableArray[$k][$i]['fKey']." = ".$latest_unique_id." where ".$subTableArray[$k][$i]['fKey']." = ".$old_unique_id;
								//Getting SubTable Primary Key and Update the Value 
								$subQueryCond = "";
								if(isset($subTableArray[$k][$i]['extraCond'])){
									$subQueryCond = $subTableArray[$k][$i]['extraCond'];
								}	
								//".$subTableArray[$k][$i]['fKey']." = '".$old_unique_id."'  and (`migratestatus` = '0' or `migratestatus` = '$migrateCheckStatus')
								//(`".$subTableArray[$k][$i]['pKey']."`) as pArray
								
								//Extra Condition Except hrm_emp_leave_td - Condition not working for particular hrm_emp_leave_td table
								$extraQuery = " and `migratestatus` IN (".$migrateCheckStatus.") ";
								if( $subTableArray[$k][$i]['tbName'] == "hrm_emp_leave_td"){
									$extraQuery = "";
								}	
								
								//Count
								$count = "SELECT
														count(`".$subTableArray[$k][$i]['pKey']."`) as pArray
													FROM
														".$dbArray['destDB'].".".$subTableArray[$k][$i]['tbName']."
													WHERE
														".$subTableArray[$k][$i]['fKey']." = '".$old_unique_id."'  ".$extraQuery."
														".$subQueryCond;
								$countQue = mysql_query($count);						
								$fetchdataPreviousAvail = mysql_fetch_array($countQue);
								$countdataAvail = $fetchdataPreviousAvail['pArray'];
								
								
								
								$subQuery1 = " UPDATE 
												  ".$dbArray['destDB'].".".$subTableArray[$k][$i]['tbName']." dest,
												  (SELECT
														concat(`".$subTableArray[$k][$i]['pKey']."`,',') as pArray
													FROM
														".$dbArray['destDB'].".".$subTableArray[$k][$i]['tbName']."
													WHERE
														".$subTableArray[$k][$i]['fKey']." = '".$old_unique_id."'  ".$extraQuery."
														".$subQueryCond."
														) src 
												SET
												  dest.".$subTableArray[$k][$i]['fKey']." = '".$latest_unique_id."'
												  ,dest.migratestatus = '$migrateUpdateStatus'
												WHERE 
												   dest.`".$subTableArray[$k][$i]['pKey']."` IN ( src.pArray) " ;
												   
								
								
								
								$subTableCopyQuery1 = mysql_query($subQuery1);
								//echo ' Sub Query New = '.$subQuery1."<br>";
								msg_log($subQuery1,$filename.'Extra');
								if($subTableCopyQuery1){
									$msg = "Total Count - ".$countdataAvail."\n<br>Sub Table ".($i+1)." : ".$subTableArray[$k][$i]['tbName']." rows affected ".mysql_affected_rows()." updated Successfully\r\n\n<br>Total Count  ".$countdataAvail."  - Rows Count ".mysql_affected_rows()."\n = ";$msg.=($countdataAvail==mysql_affected_rows())?"Same":"Not";
									msg_log($msg,$filename.'Success');
								}else{
									$msg = "Sub Table ".($i+1)." : ".$subTableArray[$k][$i]['tbName']." not updated successfully ".mysql_error();				 
									msg_log($msg,$filename.'Fail');
								}
							}	

								//HIstory Table
								if(($_REQUEST['modulename'] == "employee")&&($mainTable[$k]['tbName'] == "hrm_employee_td" )){
									//Insert the old Id in new Table 
									$insertOldNewIdQuery = "INSERT INTO ".$dbArray['destDB'].".hrm_emp_history(user_id,old_user_id,description) VALUES (".
														    "'".$latest_unique_id."','".$old_unique_id."','Migration')";
															
									$insertOldNewIdExe = mysql_query($insertOldNewIdQuery);
									msg_log($insertOldNewIdQuery,$filename.'History');
								}								
						}else{
							  $msg =  "Main Table Insert : ".$mainTable[$k]['tbName']." Old Unique Id - ".$old_unique_id." not migrated successfully ".mysql_error();
							  msg_log($msg,$filename.'Fail');
						 }
						 $new_id++;
				}else{	
						//If Data is available	
						//Need to update Old Uniq_id as New Uniq_id
						$fetchdataPreviousAvail = mysql_fetch_array($dataPreviousAvail);
						$new_uniq_data = trim($fetchdataPreviousAvail['new_uniq_id']);					
						//$mainQuery = "update ".$dbArray['destDB'].".".$mainTable[$k]['tbName']." set ".$mainTable[$k]['pKey']." = ".$new_uniq_data." where ".$mainTable[$k]['pKey']." = ".$old_unique_id;
						//echo $mainQuery."<br>";
						//$latest_query = mysql_query($mainQuery);
						//if($latest_query){					
						if($new_uniq_data != $old_unique_id ){
							//Latest Unique Id
							$latest_unique_id = $new_uniq_data;
							$msg = "Not Same - New Unique Id - ".$latest_unique_id." is successfully updated to ".$mainTable[$k]['tbName'];
							
							msg_log($msg,$filename.'Queries');	

							for($i=0;$i<count($subTableArray[$k]);$i++){
								
								$migrateCheckStatus = "0";
								$migrateUpdateStatus = "1";
								if(isset($subTableArray[$k][$i]['migrateUpdate'])){
									//First Time To Change the hrm_emp_leave_td
									if($subTableArray[$k][$i]['migrateUpdate'] == 1){
										$migrateCheckStatus = "0";
										$migrateUpdateStatus = "2";
									 }	
									 //Second Time To Change the hrm_emp_leave_td
									 if($subTableArray[$k][$i]['migrateUpdate'] == 2){
										$migrateCheckStatus = "0,2";
										$migrateUpdateStatus = "1";
									 }	
								}	
								
								
								//Old Update Query - Not Working Same Column Update and Same Column Fetch is not working fine
								//$subQuery1 = "update ".$dbArray['destDB'].".".$subTableArray[$k][$i]['tbName']." set ".$subTableArray[$k][$i]['fKey']." = '".$latest_unique_id."' where ".$subTableArray[$k][$i]['fKey']." = '".$old_unique_id."'";
								//Getting SubTable Primary Key and Update the Value 
								$subQueryCond = "";
								if(isset($subTableArray[$k][$i]['extraCond'])){
									$subQueryCond = $subTableArray[$k][$i]['extraCond'];
								}	
								
								//Extra Condition Except hrm_emp_leave_td - Condition not working for particular hrm_emp_leave_td table
								$extraQuery = " and `migratestatus` IN (".$migrateCheckStatus.") ";
								if( $subTableArray[$k][$i]['tbName'] == "hrm_emp_leave_td"){
									$extraQuery = " ";
								}	
								
								//Count
								$count = "SELECT
														count(`".$subTableArray[$k][$i]['pKey']."`) as pArray
													FROM
														".$dbArray['destDB'].".".$subTableArray[$k][$i]['tbName']."
													WHERE
														".$subTableArray[$k][$i]['fKey']." = '".$old_unique_id."'  ".$extraQuery."
														".$subQueryCond;
														echo $count;
								$countQue = mysql_query($count);						
								$fetchdataPreviousAvail = mysql_fetch_array($countQue);
								$countdataAvail = $fetchdataPreviousAvail['pArray'];
								
								
								//(`".$subTableArray[$k][$i]['pKey']."`) as pArray
								$subQuery1 = " UPDATE 
												  ".$dbArray['destDB'].".".$subTableArray[$k][$i]['tbName']." dest,
												  (SELECT
														concat(`".$subTableArray[$k][$i]['pKey']."`,',') as pArray														 
													FROM
														".$dbArray['destDB'].".".$subTableArray[$k][$i]['tbName']."
													WHERE
														".$subTableArray[$k][$i]['fKey']." = '".$old_unique_id."' ".$extraQuery."
														".$subQueryCond."
														) src 
												SET
												  dest.".$subTableArray[$k][$i]['fKey']." = '".$latest_unique_id."'
												  ,dest.migratestatus = '$migrateUpdateStatus'
												WHERE 
												   dest.`".$subTableArray[$k][$i]['pKey']."` IN ( src.pArray) " ;
								
								/*if(isset($subTableArray[$k][$i]['extraCond'])){
									$subQuery1 .= $subTableArray[$k][$i]['extraCond'];
								}*/	
								//echo ' Sub Query Old = '.$subQuery1."<br>";
								msg_log($subQuery1,$filename.'Extra');
								$subTableCopyQuery1 = mysql_query($subQuery1);
								
								if($subTableCopyQuery1){
									//$msg = "Sub Table ".($i+1)." : ".$subTableArray[$k][$i]['tbName']." rows affected ".mysql_affected_rows()." updated Successfully\r\n\n";
									$msg = "Total Count - ".$countdataAvail."\n<br>Sub Table ".($i+1)." : ".$subTableArray[$k][$i]['tbName']." rows affected ".mysql_affected_rows()." updated Successfully\r\n\n<br>Total Count  ".$countdataAvail."  - Rows Count ".mysql_affected_rows()."\n = ";$msg.=($countdataAvail==mysql_affected_rows())?"Same":"Not";
									msg_log($msg,$filename.'Success');
								}else{
									$msg = "Sub Table ".($i+1)." : ".$subTableArray[$k][$i]['tbName']." not updated successfully ".mysql_error();				 
									msg_log($msg,$filename.'Fail');
								}								
							}	
								//HIstory Table
								if(($_REQUEST['modulename'] == "employee")&&($mainTable[$k]['tbName'] == "hrm_employee_td" )){
									//Insert the old Id in new Table 
									$insertOldNewIdQuery = "INSERT INTO ".$dbArray['destDB'].".hrm_emp_history(user_id,old_user_id,description) VALUES (".
														    "'".$latest_unique_id."','".$old_unique_id."','Migration')";															
									$insertOldNewIdExe = mysql_query($insertOldNewIdQuery);
									msg_log($insertOldNewIdQuery,$filename.'History');
								}							
						}else{
							  $msg =  "Main Table Update : ".$mainTable[$k]['tbName']." Old Unique Id - ".$old_unique_id." and New Unique Id - ".$new_uniq_data." is equal  need not be updated ".mysql_error();
							  //HIstory Table
								if(($_REQUEST['modulename'] == "employee")&&($mainTable[$k]['tbName'] == "hrm_employee_td" )){
									//Insert the old Id in new Table 
									$insertOldNewIdQuery = "INSERT INTO ".$dbArray['destDB'].".hrm_emp_history(user_id,old_user_id,description) VALUES (".
														    "'".$new_uniq_data."','".$old_unique_id."','Same Id - Migration not done')";
															//echo '<br><br>'.$insertOldNewIdQuery.'<br><br>';
									$insertOldNewIdExe = mysql_query($insertOldNewIdQuery);
									msg_log($insertOldNewIdQuery,$filename.'History');
								}	
							  msg_log($msg,$filename.'Fail');
						 }		
					$up_id++;						 
				}	
				//exit;
			}	 
			
			
			 msg_log('No. of Newly Added Count - '.$new_id,$filename.'Success');
			 msg_log('No. of Updated Count - '.$up_id,$filename);
			//Disable Foreign Key Check Enable
			$foreignkeyQuery_enable =  " SET FOREIGN_KEY_CHECKS = 1;";
			$foreignkeyQueryExe_enable = mysql_query($foreignkeyQuery_enable);
			
			//Delete Extra Column Where the data are after migrated - migratestatus
			for($i=0;$i<count($subTableArray[$k]);$i++){
				//if((!isset($subTableArray[$k][$i]['migrateUpdate']))||((isset($subTableArray[$k][$i]['migrateUpdate']))&&($subTableArray[$k][$i]['migrateUpdate'] == 2))){
					$destExtraColumn = "ALTER TABLE ".$dbArray['destDB'].".".$subTableArray[$k][$i]['tbName']." DROP `migratestatus`";
					$exedestExtraColumn = mysql_query($destExtraColumn);
				//}
				//Delete Employee
				if(($_REQUEST['modulename'] == "employee")&&($subTableArray[$k][$i]['tbName'] == "hrm_emp_login_tb" )){
					//Delete Extra Column Where the data are after migrated -  branch_data
					$destExtraColumn = "ALTER TABLE ".$dbArray['destDB'].".".$subTableArray[$k][$i]['tbName']." DROP `branch_data`";
					//echo '<br><br>'.$destExtraColumn;
					$exedestExtraColumn = mysql_query($destExtraColumn);
				}
			}
		
		}
		
			
		
	}	
		
?>