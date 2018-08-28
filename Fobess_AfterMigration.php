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
								"ALTER TABLE `hrm_post_job_td` DROP `branch_data` ",
								"ALTER TABLE `hrm_eventsnewletter_tb` DROP `branch_data` ",
								"ALTER TABLE `hrm_empdiscount_tb` DROP `branch_data` ",
								"ALTER TABLE `hrm_emp_shop_category` DROP `branch_data` ",
								"ALTER TABLE `hrm_holiday_list_td` DROP `branch_data` ",
								"ALTER TABLE `events_tb` DROP `branch_data` ",
								"ALTER TABLE `hrm_category_tb` DROP `branch_data` ",
								"ALTER TABLE `hrm_project_tb` DROP `branch_data` ",
								//"ALTER TABLE `hrm_emp_designation_td` DROP `branch_data` ",
								//"ALTER TABLE `hrm_department_td` DROP `branch_data` ",
								"ALTER TABLE `hrm_work_shifts` DROP `branch_data` ",
								"ALTER TABLE `hrm_week_days_tb` DROP `branch_data` ",
								"ALTER TABLE `hrm_emp_timesheet` DROP `branch_data` ",
								"ALTER TABLE `hrm_custom_msg` DROP `branch_data` ",
								//"ALTER TABLE `hrm_leave_type_tb` DROP `branch_data` ",
								"UPDATE  `hrm_common_table` SET  `field_name` =  'timesheet_old', `field_value` =  'timesheet comments_old' WHERE  `hrm_common_table`.`id` =27",
								"ALTER TABLE `hrm_emp_timesheet` ADD `timesheet_deletestatus` INT(10) NOT NULL DEFAULT '0' COMMENT 'Active – 0,Delete – 1' AFTER `timesheet_reject_reason`, ADD `timesheet_deletedby` INT(11) NOT NULL AFTER `timesheet_deletestatus`, ADD `timesheet_deletetime` DATETIME NOT NULL AFTER `timesheet_deletedby`",
								"ALTER TABLE `hrm_emp_timesheet` CHANGE `timesheet_deletetime` `timesheet_deletetime` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP",
								"ALTER TABLE `hrm_emp_reliving_info` CHANGE `k_enrollment_form` `k_enrollment_form` VARCHAR(100) NULL DEFAULT NULL",
								"ALTER TABLE `hrm_emp_checklist` CHANGE `k_enrollment_form_completed` `k_enrollment_form_completed` VARCHAR(100) NULL DEFAULT NULL",
								"ALTER TABLE `hrm_custom_msg` ADD `branche_id` INT(11) NOT NULL DEFAULT '1'",
								"CREATE TABLE `hrm_emp_worklocation` ( `emp_workloc_id`INT(11) NOT NULL AUTO_INCREMENT , `employee_id` INT(11) NOT NULL ,`company_name` VARCHAR(500) NOT NULL , `company_address` TEXT NOT NULL ,`company_city` VARCHAR(45) NOT NULL , `company_state` VARCHAR(45) NOT NULL, `company_country` VARCHAR(45) NOT NULL , `company_zip_code` VARCHAR(45)NOT NULL , `company_start_date` DATE NOT NULL , `company_end_date` DATE NOT NULL , `onsite_mgr_name` VARCHAR(45) NOT NULL , `onsite_mgr_phone`VARCHAR(40) NOT NULL , `work_loc_status` INT(11) NOT NULL DEFAULT '0'COMMENT '0 - Active, 1 - Deactive' , PRIMARY KEY (`emp_workloc_id`)) ENGINE= InnoDB",
								"ALTER TABLE `hrm_employee_td` ADD `branch_permission` INT(11) NOT NULL DEFAULT '0' COMMENT '0 – No branch permission, 1 – Branch permission enabled' ",
								"ALTER TABLE `hrm_emp_leave_td` ADD `approval_reason` VARCHAR(500) NOT NULL AFTER `leave_reason`",
								"ALTER TABLE `hrm_emp_timesheet` ADD `approval_reason` VARCHAR(500) NOT NULL AFTER `timesheet_adate`",
								"ALTER TABLE `hrm_department_td` ADD `department_status` INT NOT NULL DEFAULT '0' AFTER `dept_track_date`",
								"ALTER TABLE `hrm_emp_designation_td` ADD `designation_status` INT NOT NULL DEFAULT '0' AFTER `dept_track_date`",
								"ALTER TABLE `hrm_emp_descriptionexp_td` ADD `approval_reason` VARCHAR(500) NOT NULL AFTER `send_to`",
								"ALTER TABLE `time_tracker` ADD `comments` VARCHAR(500) NULL DEFAULT NULL AFTER `pause_count`",
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