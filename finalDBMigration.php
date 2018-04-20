<?php


	include('variable.php');
	include('messagelog.php');
	
	$db = mysql_select_db($dbArray['finalDB'],$con);	

				
			//Insert into sub tables and update the employee id with latest employee id
			$migrateTableArray  =   array(		
									//Document
									'hrm_document_map_td',
									//Expense Tables	
									 'hrm_expense_history_process',
									 'hrm_expense_approvelist_process',
									 'hrm_emp_exp_td',									 
									 'emp_leave_type_td',
									 'events_tb',
									 'event_map_tb',
									 'hrm_applicant_history_process',
									 'hrm_applicant_td',
									 'hrm_client_tb',
									 'hrm_company_td',
									 'hrm_custom_msg',
									 //'hrm_department_td',
									 //'hrm_document_map_td',
									 'hrm_document_td',
									 'hrm_empdiscount_tb',
									 'hrm_employee_td',
									 'hrm_emp_checklist',
									 'hrm_emp_contact_td',
									 'hrm_emp_descriptionexp_td',
									 //'hrm_emp_designation_td',
									 'hrm_emp_education_td',
									 'hrm_emp_experience_tb',
									 'hrm_emp_family_tb',
									 'hrm_emp_leave_bal_tb',
									 'hrm_emp_leave_td',
									 //'hrm_emp_leave_td1',
									 'hrm_emp_login_tb',
									 'hrm_emp_official_info_tb',
									 'hrm_emp_personal_bank_detail_tb',
									 'hrm_emp_personal_details_td',
									 'hrm_emp_probation_tb',
									 'hrm_emp_reliving_info',
									 'hrm_emp_reporting_td',
									 'hrm_emp_shop_addcart',
									 'hrm_emp_shop_product',
									 'hrm_emp_status_map_td',
									 'hrm_emp_status_td',
									 'hrm_emp_timesheet',
									 'hrm_eventsnewletter_tb',
									 'hrm_expuploadmap_td',
									 'hrm_general_configure_td',
									 'hrm_group_privilege_td',
									 'hrm_holiday_list_td',
									 'hrm_interview_process_td',
									 'hrm_leave_type_rule',
									 'hrm_leave_type_tb',
									 'hrm_notification_setting_tb',
									 'hrm_notification_tb',
									 'hrm_payroll_td',
									 'hrm_personal_meta_td',
									 'hrm_post_job_td',
									 'hrm_privilege_map_td',
									 'hrm_privilege_td',
									 'hrm_project_map_tb',
									 'hrm_project_task_tb',
									 'hrm_project_tb',
									 'hrm_settings_tb',									
									 'hrm_shift_map_td',
									 'hrm_shift_td',
									 //'hrm_table_fields_td',
									 'hrm_emp_history',
									// 'hrm_work_shifts',
									 'organization_tree_tb',
									 'payroll_allowance_tb',
									 'payroll_deduction_tb',
									 'payroll_salary_tb',
									 'payroll_temp',
									 'performance_appraisal',
									 'performance_kpi',
									 'performance_review',
									 'religion_tb',
									 'state_tb1',
									 'tree_parent_tb',	
									 'hrm_setting_fields_tb', //Master
									 'payroll_paygrade',
									 'hrm_emp_group_td',
									 'hrm_emp_type_tb',									 
									 'hrm_group_fields_td',									 
									 'hrm_emp_grade_tb',
									 'hrm_common_table',
									 'hrm_work_shifts',
									 'hrm_emp_designation_td',
									 'hrm_department_td',
									 'hrm_category_tb',
									 'hrm_emp_shop_category',
									 'hrm_week_days_tb',
								);				
		
			
			//Disable Foreign Key Check Temporarily Disable
		$foreignkeyQuery_disable =  " SET FOREIGN_KEY_CHECKS = 0;";
		$foreignkeyQueryExe_disable = mysql_query($foreignkeyQuery_disable);
		
		
		for($i=0;$i<count($migrateTableArray);$i++){
		
		//Total Count Before Migrate
		$countQuery =  " SELECT count(*) as countData from ".$dbArray['destDB'].".".$migrateTableArray[$i];	
		$execountQuery = mysql_query($countQuery);
		$rescountQuery = mysql_fetch_array($execountQuery);
		$countData = $rescountQuery['countData'];
			
			//Insert into sub tables and update the employee id with latest employee id
			 $subQuery1 =  "INSERT INTO ".$dbArray['finalDB'].".".$migrateTableArray[$i].						
						   " SELECT * from ".$dbArray['destDB'].".".$migrateTableArray[$i];	
			
			$subTableCopyQuery1 = mysql_query($subQuery1);
			msg_log($subQuery1,'FinalDB_TableMigrations_Queries');
			if($subTableCopyQuery1){
				$msg = "Sub Table ".($i+1)." : ".$migrateTableArray[$i]." migrated Successfully";
				$msg .= "<br>\n\nTotal Data - ".$countData." && Migrated Data Count - ".mysql_affected_rows()." - ";
				$msg .= "<br>\n\nTable Status - ".($countData == mysql_affected_rows())?"Same":"Not";
				msg_log($msg,'FinalDB_TableMigrations_Success');
			}else{
				$msg = "Sub Table ".($i+1)." : ".$migrateTableArray[$i]." not migrated successfully ".mysql_error();				 
				msg_log($msg,'FinalDB_TableMigrations_Fail');
			}
			
			
		}
		//Disable Foreign Key Check Enable
		$foreignkeyQuery_enable =  " SET FOREIGN_KEY_CHECKS = 1;";
		$foreignkeyQueryExe_enable = mysql_query($foreignkeyQuery_enable);
		
		
?>