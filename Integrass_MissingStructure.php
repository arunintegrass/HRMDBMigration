<?php


	include('variable.php');
	include('messagelog.php');
	
	
	$db = mysql_select_db($dbArray['srcDB'],$con);
	
	//Relation Table (or) Sub Table Array - Table 1 - test2 
	$alterTableArray_int  =   array(
								"ALTER TABLE `hrm_document_td` ADD `view_type` INT NOT NULL AFTER `doc_flag`",
								"ALTER TABLE `hrm_emp_personal_details_td` ADD `marriage_date` DATE NOT NULL AFTER `flag`",
								"ALTER TABLE `hrm_common_table` ADD `notification` INT NOT NULL AFTER `field_flag`, ADD `menu_config` INT NOT NULL DEFAULT '1' AFTER `notification`",
								"ALTER TABLE `hrm_emp_reliving_info`
											  ADD `relocation` text NOT NULL AFTER `terminated_date`,
											  ADD `notice_period` text NOT NULL AFTER `relocation`,
											  ADD `breach_of_contract` text NOT NULL AFTER `notice_period`,
											  ADD `req_cancellation_company_email` date NOT NULL DEFAULT '0000-00-00' AFTER `breach_of_contract`,
											  ADD `k_enrollment_form` date NOT NULL DEFAULT '0000-00-00' AFTER `req_cancellation_company_email`,
											  ADD `national_general_benifits` date NOT NULL DEFAULT '0000-00-00' AFTER `k_enrollment_form`,
											  ADD `principal` date NOT NULL DEFAULT '0000-00-00' AFTER `national_general_benifits`,
											  ADD `terminated_paycheck` date NOT NULL AFTER `principal`,
											  ADD `terminated_hrm` date NOT NULL DEFAULT '0000-00-00' AFTER `terminated_paycheck`,
											  ADD `terminated_unum_coverage` date NOT NULL DEFAULT '0000-00-00' AFTER `terminated_hrm`,
											  ADD `terminated_employee_close_file` date NOT NULL DEFAULT '0000-00-00' AFTER `terminated_unum_coverage`,
											  ADD `employee_cancellation_document` date NOT NULL DEFAULT '0000-00-00' AFTER `terminated_employee_close_file`,
											  ADD `offer_letter_and_employee_agreement` date NOT NULL DEFAULT '0000-00-00' AFTER `employee_cancellation_document`,
											  ADD `cancellation_emp_type` date NOT NULL DEFAULT '0000-00-00' AFTER `offer_letter_and_employee_agreement`",
								"ALTER TABLE `hrm_emp_leave_td` ADD `is_half_hour` INT(11) NOT NULL",
								"ALTER TABLE `hrm_emp_timesheet` ADD `timesheet_doc` VARCHAR(255) NOT NULL AFTER `week_no`, ADD `timesheet_adate` DATETIME NOT NULL AFTER `timesheet_doc`",
								"ALTER TABLE `hrm_leave_type_rule` ADD `leave_after_one` INT(11) NOT NULL AFTER `leave_mini_opt_days`",
								"ALTER TABLE `hrm_leave_type_rule` ADD `leave_bal_year` INT(11) NOT NULL AFTER `attachment_mand`",								
								"ALTER TABLE `hrm_notification_tb` ADD `employee_id` INT(11) NOT NULL AFTER `ref_status`",
								"ALTER TABLE `hrm_project_map_tb` ADD `task_show` INT(11) NOT NULL AFTER `date`",
								"ALTER TABLE `hrm_project_task_tb` ADD `is_common` INT(11) NOT NULL AFTER `task_status`",
								"ALTER TABLE `hrm_project_task_tb` ADD `task_show` INT(11) NOT NULL AFTER `task_flag`",	
								"ALTER TABLE `hrm_emp_designation_td` CHANGE ` designation_depth` `designation_depth` INT(11) NULL DEFAULT NULL",
								"ALTER TABLE `hrm_emp_designation_td` CHANGE `	designation_depth` `designation_depth` INT( 11 ) NULL DEFAULT NULL",
								"ALTER TABLE `hrm_company_td` ADD `hrm_version` VARCHAR(10) NOT NULL DEFAULT 'IN' AFTER `currency_type`",	
								"ALTER TABLE `hrm_company_td` ADD `hrm_date_format` INT(11) NOT NULL DEFAULT '2' AFTER `hrm_version`",	
								"ALTER TABLE `hrm_company_td` ADD `hrm_payroll_sdate` INT(11) NOT NULL DEFAULT '8' AFTER `hrm_date_format`",	
								"ALTER TABLE `hrm_company_td` ADD `hrm_payroll_edate` INT(11) NOT NULL DEFAULT '0' AFTER `hrm_payroll_sdate`",	
								"ALTER TABLE `hrm_employee_td` ADD `branch_data` VARCHAR(10) NOT NULL DEFAULT 'IN' ",	
								"ALTER TABLE `hrm_leave_type_tb` ADD `type_leave` INT NOT NULL AFTER `leave_mon_up`, ADD `add_balance_year` INT NOT NULL AFTER `type_leave`",
								"ALTER TABLE `hrm_leave_type_tb` ADD `hrm_version` VARCHAR(10) NOT NULL DEFAULT 'IN'",	
								"UPDATE `hrm_company_td` SET `currency_type` = '1' ",
								"ALTER TABLE `payroll_salary_tb` ADD `currency_type` INT NOT NULL DEFAULT '1' AFTER `grade_id`",
								"ALTER TABLE `hrm_emp_designation_td` ADD `dept_track_date` TIMESTAMP NOT NULL AFTER `designation_flag`",								
								//"UPDATE `hrm_employee_td` SET `emp_first_name` = 'ABMCG' WHERE `hrm_employee_td`.`employee_id` = 1",
								//"UPDATE `hrm_employee_td` SET `emp_last_name` = 'Fobess' WHERE `hrm_employee_td`.`employee_id` = 1",
							);
		for($i=0;$i<count($alterTableArray_int);$i++){
				
			$alterTableQuery_int = mysql_query($alterTableArray_int[$i]);
			
			if($alterTableQuery_int){
				$msg = "temp_integrasshrm_stage - Query ".($i+1)." : executed Successfully";
				msg_log($msg,'temp_integrasshrm_stage_Success');
			}else{
				$msg = "temp_integrasshrm_stage - Query".($i+1)." :  not executed  ".mysql_error();				 
				msg_log($msg,'temp_integrasshrm_stage_Fail');
			}
			
		}		
		
		$db = mysql_select_db($dbArray['destDB'],$con);
		//Relation Table (or) Sub Table Array - Table 1 - test2 
		$alterTableArray_fob  =   array(	
	
								"CREATE TABLE `hrm_expense_approvelist_process` (
										  `tracking_id` int(11) NOT NULL,
										  `action_type` int(11) NOT NULL,
										  `payment_method` text,
										  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
										  `payment_description` text,
										  `history_process_flag` int(11) NOT NULL,
										  `approval_status` int(11) NOT NULL,
										  `employee_id` int(11) NOT NULL,
										  `payment_date` text,
										  `history_process_id` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1",
								"ALTER TABLE `hrm_expense_approvelist_process` ADD PRIMARY KEY (`history_process_id`)",
								"ALTER TABLE `hrm_expense_approvelist_process` MODIFY `history_process_id` int(11) NOT NULL AUTO_INCREMENT",
								"ALTER TABLE `hrm_leave_type_rule` ADD `emp_apply_leave_lop` INT(11) NOT NULL AFTER `status`",
								"CREATE TABLE `hrm_expense_history_process` (
											  `tracking_id` int(11) NOT NULL,
											  `action_type` int(11) NOT NULL,
											  `payment_method` text,
											  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
											  `payment_description` text,
											  `history_process_flag` int(11) NOT NULL,
											  `approval_status` int(11) NOT NULL,
											  `employee_id` int(11) NOT NULL,
											  `payment_date` text,
											  `history_process_id` int(11) NOT NULL
											) ENGINE=InnoDB DEFAULT CHARSET=latin1",
								"ALTER TABLE `hrm_expense_history_process` ADD PRIMARY KEY (`history_process_id`)",
								"ALTER TABLE `hrm_expense_history_process`  MODIFY `history_process_id` int(11) NOT NULL AUTO_INCREMENT",	
								"ALTER TABLE `organization_tree_tb` DROP `org_tree_id`",
								"ALTER TABLE `organization_tree_tb` ADD `org_tree_id` INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`org_tree_id`)",
								"ALTER TABLE `hrm_employee_td` ADD `finance_notification` INT NOT NULL AFTER `checklist_status`, ADD `expense_limit` INT NOT NULL AFTER `finance_notification`",
								"ALTER TABLE `hrm_group_fields_td` ADD `field_expense_limit` INT NOT NULL AFTER `field_group_flag`",
								"ALTER TABLE `hrm_emp_designation_td` CHANGE ` designation_depth` `designation_depth` INT(11) NULL DEFAULT NULL",
								"ALTER TABLE `hrm_emp_designation_td` CHANGE `	designation_depth` `designation_depth` INT( 11 ) NULL DEFAULT NULL",
								"ALTER TABLE `hrm_company_td` ADD `hrm_version` VARCHAR(10) NOT NULL DEFAULT 'US' AFTER `currency_type`",
								"ALTER TABLE `hrm_emp_leave_bal_tb` ADD `leave_bal_det` VARCHAR(255) NOT NULL AFTER `leavey_mon_year`",								
								"ALTER TABLE `hrm_leave_type_tb` ADD `leave_mon_up` DATE NOT NULL AFTER `leave_des`",								
								"ALTER TABLE `hrm_leave_type_tb` ADD `hrm_version` VARCHAR(10) NOT NULL DEFAULT 'US'",								
								"ALTER TABLE `hrm_category_tb` ADD `category_flag` INT NOT NULL DEFAULT '0' AFTER `subcategory_id`",	
								"ALTER TABLE `hrm_document_map_td` CHANGE `updated_on` `updated_on` DATETIME",
								"ALTER TABLE `hrm_emp_exp_td` CHANGE `updated_on` `updated_on` DATETIME",
								"ALTER TABLE `hrm_applicant_history_process` CHANGE `date_time` `date_time` DATETIME",
								"ALTER TABLE `hrm_expense_history_process` CHANGE `date_time` `date_time` DATETIME",
								"ALTER TABLE `hrm_expense_approvelist_process` CHANGE `date_time` `date_time` DATETIME",
								"ALTER TABLE `hrm_emp_reporting_td` CHANGE `track_date` `track_date` DATETIME",
								"ALTER TABLE `hrm_employee_td` ADD `branch_data` VARCHAR(10) NOT NULL DEFAULT 'US' ",
								"UPDATE `hrm_company_td` SET `currency_type` = '2' ",			
								"ALTER TABLE `hrm_company_td` ADD `hrm_date_format` INT(11) NOT NULL DEFAULT '0' AFTER `hrm_version`",		
								"ALTER TABLE `hrm_company_td` ADD `hrm_payroll_sdate` INT(11) NOT NULL DEFAULT '25' AFTER `hrm_date_format`",	
								"ALTER TABLE `hrm_company_td` ADD `hrm_payroll_edate` INT(11) NOT NULL DEFAULT '0' AFTER `hrm_payroll_sdate`",	
								"ALTER TABLE `payroll_salary_tb` ADD `currency_type` INT NOT NULL DEFAULT '2' AFTER `grade_id`",
								"ALTER TABLE `hrm_emp_designation_td` ADD `dept_track_date` TIMESTAMP NOT NULL AFTER `designation_flag`",								
							);
							
		for($i=0;$i<count($alterTableArray_fob);$i++){
				
			$alterTableQuery_fob = mysql_query($alterTableArray_fob[$i]);
			
			if($alterTableQuery_fob){
				$msg = "temp_fobesshrm_stage - Query ".($i+1)." : executed Successfully";
				msg_log($msg,'Integrass_MissingStructure_Success');
			}else{
				$msg = "temp_fobesshrm_stage - Query".($i+1)." :  not executed  ".mysql_error();				 
				msg_log($msg,'Integrass_MissingStructure_Fail');
			}
			
		}								
			

?>