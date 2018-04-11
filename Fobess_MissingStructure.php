<?php


	include('variable.php');
	include('messagelog.php');
	
		$db = mysql_select_db($dbArray['finalDB'],$con);
		
		//Disable Foreign Key Check Temporarily Disable
		$foreignkeyQuery_disable =  " SET FOREIGN_KEY_CHECKS = 0;";
		$foreignkeyQueryExe_disable = mysql_query($foreignkeyQuery_disable);
		
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
								"ALTER TABLE `hrm_company_td` ADD `hrm_version` VARCHAR(10) NOT NULL DEFAULT 'US' AFTER `currency_type`",
								"ALTER TABLE `hrm_emp_leave_bal_tb` ADD `leave_bal_det` VARCHAR(255) NOT NULL AFTER `leavey_mon_year`",
								"ALTER TABLE `hrm_leave_type_tb` ADD `leave_mon_up` DATE NOT NULL AFTER `leave_des`",
								"ALTER TABLE `hrm_emp_designation_td` ADD `dept_track_date` TIMESTAMP NOT NULL AFTER `designation_flag`",
								"ALTER TABLE `hrm_category_tb` ADD `category_flag` INT NOT NULL DEFAULT '0' AFTER `subcategory_id`",
								"ALTER TABLE `hrm_document_map_td` CHANGE `updated_on` `updated_on` DATETIME",
								"ALTER TABLE `hrm_emp_exp_td` CHANGE `updated_on` `updated_on` DATETIME",
								"ALTER TABLE `hrm_applicant_history_process` CHANGE `date_time` `date_time` DATETIME",
								"ALTER TABLE `hrm_expense_history_process` CHANGE `date_time` `date_time` DATETIME",
								"ALTER TABLE `hrm_expense_approvelist_process` CHANGE `date_time` `date_time` DATETIME",
								"ALTER TABLE `hrm_emp_reporting_td` CHANGE `track_date` `track_date` DATETIME",
								"UPDATE `hrm_company_td` SET `currency_type` = '2' ",	
								"ALTER TABLE `hrm_company_td` ADD `hrm_date_format` INT(11) NOT NULL DEFAULT '0' AFTER `hrm_version`",		
								"ALTER TABLE `hrm_company_td` ADD `hrm_payroll_sdate` INT(11) NOT NULL DEFAULT '25' AFTER `hrm_date_format`",	
								"ALTER TABLE `hrm_company_td` ADD `hrm_payroll_edate` INT(11) NOT NULL DEFAULT '0' AFTER `hrm_payroll_sdate`",	
								"ALTER TABLE `payroll_salary_tb` ADD `currency_type` INT NOT NULL DEFAULT '2' AFTER `grade_id`",								
								
								//Truncate the Master Tables 		
								/*"TRUNCATE `hrm_setting_fields_tb`",
								"TRUNCATE `payroll_paygrade`",
								"TRUNCATE `hrm_emp_group_td`",
								"TRUNCATE `hrm_emp_type_tb`",
								"TRUNCATE `hrm_group_fields_td`",
								"TRUNCATE `hrm_emp_grade_tb`",
								"TRUNCATE `hrm_common_table`",
								"TRUNCATE `hrm_work_shifts`",
								"TRUNCATE `hrm_emp_designation_td`",
								"TRUNCATE `hrm_department_td`",
								"TRUNCATE `hrm_category_tb`",
								"TRUNCATE `hrm_emp_shop_category`",
								//"TRUNCATE `hrm_emp_login_tb`",
								//"TRUNCATE `hrm_employee_td`", */
							);
							
		for($i=0;$i<count($alterTableArray_fob);$i++){
				
			$alterTableQuery_fob = mysql_query($alterTableArray_fob[$i]);
			
			if($alterTableQuery_fob){
				$msg = "Final DB - Query ".($i+1)." : executed Successfully";
				msg_log($msg,'Fobess_MissingStructure_Success');
			}else{
				$msg = "Final DB - Query".($i+1)." :  not executed  ".mysql_error();				 
				msg_log($msg,'Fobess_MissingStructure_Fail');
			}
			
		}								
			
		//Disable Foreign Key Check Enable
		$foreignkeyQuery_enable =  " SET FOREIGN_KEY_CHECKS = 1;";
		$foreignkeyQueryExe_enable = mysql_query($foreignkeyQuery_enable);	

?>