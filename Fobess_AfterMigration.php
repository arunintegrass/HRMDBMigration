<?php


	include('variable.php');
	include('messagelog.php');
	
		$db = mysql_select_db($dbArray['finalDB'],$con);
		
		//Relation Table (or) Sub Table Array - Table 1 - test2 
		$alterTableArray_fob  =   array(	
								//Truncate the Master Tables 		
								"ALTER TABLE `hrm_document_map_td` CHANGE `updated_on` `updated_on` timestamp on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP",
								"ALTER TABLE `hrm_emp_exp_td` CHANGE `updated_on` `updated_on` timestamp on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP",
								"ALTER TABLE `hrm_applicant_history_process` CHANGE `date_time` `date_time` timestamp on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP",
								"ALTER TABLE `hrm_expense_history_process` CHANGE `date_time` `date_time` timestamp on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP",
								"ALTER TABLE `hrm_expense_approvelist_process` CHANGE `date_time` `date_time` timestamp on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP",
								"ALTER TABLE `hrm_emp_reporting_td` CHANGE `track_date` `track_date` timestamp on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP",
								"ALTER TABLE `hrm_emp_designation_td` CHANGE `dept_track_date` `dept_track_date` timestamp on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP",
								"ALTER TABLE `hrm_employee_td` DROP `branch_data` ",
							);
							
		//Disable Foreign Key Check Temporarily Disable
		$foreignkeyQuery_disable =  " SET FOREIGN_KEY_CHECKS = 0;";
		$foreignkeyQueryExe_disable = mysql_query($foreignkeyQuery_disable);
		
		for($i=0;$i<count($alterTableArray_fob);$i++){
				
			$alterTableQuery_fob = mysql_query($alterTableArray_fob[$i]);
			
			if($alterTableQuery_fob){
				$msg = "Final After Migration DB - Alter Query ".($i+1)." : executed Successfully";
				msg_log($msg,'Fobess_ExtraStructure_Success');
			}else{
				$msg = "Final After Migration DB - Alter Query".($i+1)." :  not executed  ".mysql_error();				 
				msg_log($msg,'Fobess_ExtraStructure_Fail');
			}
			
		}								
			
		$foreignkeyQuery_enable =  " SET FOREIGN_KEY_CHECKS = 1;";
		$foreignkeyQueryExe_enable = mysql_query($foreignkeyQuery_enable);	

?>