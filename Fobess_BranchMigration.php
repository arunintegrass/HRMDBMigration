<?php

	include('variable.php');
	include('messagelog.php');
		
	$moduleName = "Fobess_BranchMigration";	
	
	$mainTable  =   array(
							['pKey'=>'company_id','tbName'=>'hrm_company_td','extraUpdate'=>' parent_id=1,is_parent=0,currency_type=2,company_status=1,company_name="Integrass - US" ','newUpdate'=>' company_status=1,company_name="Integrass" ','companyExtraCond'=>" where is_parent='1' ",'deactiveCompany'=>" company_status=0 "], //company_id								
						);							
	//Sub Table					
	$subTableArray  =   array(								
							//Update - company_id
							array(
									['pKey'=>'employee_id','fKey'=>'branche_id','tbName'=>'hrm_employee_td','extraCond'=>"  branch_data = 'US' "],
									['pKey'=>'job_id','fKey'=>'branche_id','tbName'=>'hrm_post_job_td','extraCond'=>"  branch_data = 'US' "],
									['pKey'=>'newletter_id','fKey'=>'branche_id','tbName'=>'hrm_eventsnewletter_tb','extraCond'=>"  branch_data = 'US' "],
									['pKey'=>'discount_id','fKey'=>'branche_id','tbName'=>'hrm_empdiscount_tb','extraCond'=>"  branch_data = 'US' "],
									['pKey'=>'shop_category_id','fKey'=>'branche_id','tbName'=>'hrm_emp_shop_category','extraCond'=>"  branch_data = 'US' "],
									['pKey'=>'holiday_id','fKey'=>'branche_id','tbName'=>'hrm_holiday_list_td','extraCond'=>"  branch_data = 'US' "],
									['pKey'=>'event_id','fKey'=>'branche_id','tbName'=>'events_tb','extraCond'=>"  branch_data = 'US' "],
									['pKey'=>'category_id','fKey'=>'branche_id','tbName'=>'hrm_category_tb','extraCond'=>"  branch_data = 'US' "],
									['pKey'=>'employment_type_id','fKey'=>'branche_id','tbName'=>'hrm_emp_type_tb','extraCond'=>"  branch_data = 'US' "],
									['pKey'=>'work_shift_id','fKey'=>'branche_id','tbName'=>'hrm_work_shifts','extraCond'=>"  branch_data = 'US' "],
									['pKey'=>'leave_type_id','fKey'=>'branche_id','tbName'=>'hrm_leave_type_tb','extraCond'=>"  hrm_version = 'US' "],
								),	
						);	
	branchTableMigration($dbArray,$mainTable,$subTableArray,ucfirst($moduleName).'Module_',$con,$dbArray['finalDB']);
	branchTableMigration($dbArray,$mainTable,$subTableArray,ucfirst($moduleName).'Module_',$con,$dbArray['destDB']);
	
	
	function branchTableMigration($dbArray,$mainTable,$subTableArray,$moduleName,$con,$currentDB){
			
			for($k = 0; $k < count($mainTable); $k++){	
			
				$parentCompanyQuery = "";
				if(isset($mainTable[$k]['companyExtraCond'])){
					$parentCompanyQuery .= $mainTable[$k]['companyExtraCond'];
				}	
				
				$db = mysql_select_db($currentDB,$con);
					
				$select_id = mysql_query("SELECT ".$mainTable[$k]['pKey']." as uniq_id from ".$currentDB.".".$mainTable[$k]['tbName']."  ".$parentCompanyQuery);
				echo "SELECT ".$mainTable[$k]['pKey']." as uniq_id from ".$currentDB.".".$mainTable[$k]['tbName']."  ".$parentCompanyQuery;
				$filename=$moduleName.$mainTable[$k]['tbName'];	

				//Column Name
				$columnQuery = " SELECT GROUP_CONCAT(COLUMN_NAME) FROM information_schema.columns WHERE table_schema = '".$currentDB."' AND table_name = '".$mainTable[$k]['tbName']."'  and column_name NOT IN ( '".$mainTable[$k]['pKey']."') ";	
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
							
						
					//Latest Unique Id
					$latest_unique_id = $old_unique_id;
					$msg = "New Unique Id - ".$latest_unique_id." is successfully migrated to ".$mainTable[$k]['tbName'];					
					msg_log($msg,$filename.'Queries');	
				
					
					for($i=0;$i<count($subTableArray[$k]);$i++){
						
						
						$subQueryCond = "";
						if(isset($subTableArray[$k][$i]['extraCond'])){
							$subQueryCond = $subTableArray[$k][$i]['extraCond'];
						}	
						
						$extraQuery = " ";
								
						//Count
						$count = "SELECT
												count(`".$subTableArray[$k][$i]['pKey']."`) as pArray			
											FROM
												".$currentDB.".".$subTableArray[$k][$i]['tbName']."
											WHERE
												".$subQueryCond;
						$countQue = mysql_query($count);						
						$fetchdataPreviousAvail = mysql_fetch_array($countQue);
						$countdataAvail = $fetchdataPreviousAvail['pArray'];
						
						$subQuery1 = " UPDATE 
										  ".$currentDB.".".$subTableArray[$k][$i]['tbName']." dest,
										  (SELECT
												concat(`".$subTableArray[$k][$i]['pKey']."`,',') as pArray			
											FROM
												".$currentDB.".".$subTableArray[$k][$i]['tbName']."
											WHERE
												".$subQueryCond."
												) src 
										SET
										  dest.".$subTableArray[$k][$i]['fKey']." = '".$latest_unique_id."'										  
										WHERE 
										   dest.`".$subTableArray[$k][$i]['pKey']."` IN ( src.pArray) " ;
													
						$subTableCopyQuery1 = mysql_query($subQuery1);
						
						if($subTableCopyQuery1){
							//$msg = "Sub Table ".($i+1)." : ".$subTableArray[$k][$i]['tbName']." updated Successfully\r\n\n";
							$msg = "Total Count - ".$countdataAvail."\n<br>Sub Table ".($i+1)." : ".$subTableArray[$k][$i]['tbName']." rows affected ".mysql_affected_rows()." updated Successfully\r\n\n<br>Total Count  ".$countdataAvail."  - Rows Count ".mysql_affected_rows()."\n = ";$msg.=($countdataAvail==mysql_affected_rows())?"Same":"Not";
							msg_log($msg,$filename.'Success');
						}else{
							$msg = "Sub Table ".($i+1)." : ".$subTableArray[$k][$i]['tbName']." not updated successfully ".mysql_error();				 
							msg_log($msg,$filename.'Fail');
						}
					}	
					
					//Deactive All the branch
					$subQuery1 = "update ".$currentDB.".".$mainTable[$k]['tbName']." set ".$mainTable[$k]['deactiveCompany'];
					$subTableCopyQuery1 = mysql_query($subQuery1);
					
					
					//Copy ABMCG as Integrass
					//Insert into sub tables and update the Unique id with latest Unique id
					 $mainQuery =  "INSERT INTO ".$currentDB.".".$mainTable[$k]['tbName'].							
									"(".$rescolumnQuery[0].")".
								   " SELECT ".$rescolumnQuery[0]." from ".$currentDB.".".$mainTable[$k]['tbName'].$parentCompanyQuery;	
					$latest_query = mysql_query($mainQuery);
					
					if($latest_query){
						
						//Latest Unique Id
						$newlatest_unique_id = mysql_insert_id();
						
						//For Update AMBCG as Integrass as Main Branch
						if(isset($mainTable[$k]['newUpdate'])){
							$extraUpdateQuery = "update ".$currentDB.".".$mainTable[$k]['tbName']." set ".$mainTable[$k]['newUpdate']." where ".$mainTable[$k]['pKey']." = ".$newlatest_unique_id;
							$extraTableUpdateQuery = mysql_query($extraUpdateQuery);
							if($extraTableUpdateQuery){
								$msg = "New Update Table ".($i+1)." : ".$mainTable[$k]['tbName']." updated Successfully\r\n\n";
								msg_log($msg,$filename.'Success');
							}else{
								$msg = "New Update Table ".($i+1)." : ".$mainTable[$k]['tbName']." not updated successfully ".mysql_error();				 
								msg_log($msg,$filename.'Fail');
							}						
						}	
					}			
					
					//For Update AMBCG as Integrass - US as Sub Branch
					if(isset($mainTable[$k]['extraUpdate'])){
						$extraUpdateQuery = "update ".$currentDB.".".$mainTable[$k]['tbName']." set ".$mainTable[$k]['extraUpdate']." where ".$mainTable[$k]['pKey']." = ".$old_unique_id;
						$extraTableUpdateQuery = mysql_query($extraUpdateQuery);
						if($extraTableUpdateQuery){
							$msg = "Extra Update Table ".($i+1)." : ".$mainTable[$k]['tbName']." updated Successfully\r\n\n";
							msg_log($msg,$filename.'Success');
						}else{
							$msg = "Extra Update Table ".($i+1)." : ".$mainTable[$k]['tbName']." not updated successfully ".mysql_error();				 
							msg_log($msg,$filename.'Fail');
						}						
					}		
				
				}	 
				
				//Disable Foreign Key Check Enable
				$foreignkeyQuery_enable =  " SET FOREIGN_KEY_CHECKS = 1;";
				$foreignkeyQueryExe_enable = mysql_query($foreignkeyQuery_enable);			
			
			}
				
	}	
		
?>