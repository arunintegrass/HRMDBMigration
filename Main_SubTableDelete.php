<?php


	include('variable.php');
	include('messagelog.php');
	
	$db = mysql_select_db($dbArray['destDB'],$con);	

				
			//Insert into sub tables and update the employee id with latest employee id
			$deleteTableArray  =   array(		
									//Setting Table	
									 'hrm_settings_tb',
									//Expense Tables	
									 'hrm_expense_history_process',
									 'hrm_expense_approvelist_process',
									 'hrm_emp_exp_td',									 
									 'emp_leave_type_td',
									 'events_tb',
									 'event_map_tb',
									 'hrm_applicant_history_process',
									 'hrm_applicant_td',
									// 'hrm_category_tb', // Master
									 'hrm_client_tb',
									// 'hrm_common_table', //Need for migrate master table
									 'hrm_company_td',
									 'hrm_custom_msg',
									// 'hrm_department_td', Master
									 'hrm_document_map_td',
									 'hrm_document_td',
									 'hrm_empdiscount_tb',
									// 'hrm_employee_td', //Master Table
									 'hrm_emp_checklist',
									 'hrm_emp_contact_td',
									 'hrm_emp_descriptionexp_td',
									// 'hrm_emp_designation_td', //Master Table
									 'hrm_emp_education_td',
									 'hrm_emp_experience_tb',
									 'hrm_emp_family_tb',
									 'hrm_emp_leave_bal_tb',
									 'hrm_emp_leave_td',
									 //'hrm_emp_leave_td1',
									 //'hrm_emp_login_tb', // Master
									 'hrm_emp_official_info_tb',
									 'hrm_emp_personal_bank_detail_tb',
									 'hrm_emp_personal_details_td',
									 'hrm_emp_probation_tb',
									 'hrm_emp_reliving_info',
									 'hrm_emp_reporting_td',
									 'hrm_emp_shop_addcart',
									 'hrm_emp_shop_product',
									 'hrm_emp_status_map_td',
									// 'hrm_emp_status_td', Not in Use
									 'hrm_emp_timesheet',
									 'hrm_eventsnewletter_tb',
									 'hrm_expuploadmap_td',
									// 'hrm_general_configure_td', Not in Use
									 'hrm_group_privilege_td',
									 'hrm_holiday_list_td', //hoilday
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
									// 'hrm_setting_fields_tb',
									 'hrm_shift_map_td',
									 'hrm_shift_td',
									//'hrm_table_fields_td',
									// 'hrm_work_shifts', - Master
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
								);	

				//Disable Foreign Key Check Temporarily Disable
				$foreignkeyQuery_disable =  " SET FOREIGN_KEY_CHECKS = 0;";
				$foreignkeyQueryExe_disable = mysql_query($foreignkeyQuery_disable);
		
				for($i=0;$i<count($deleteTableArray);$i++){	
				//for($i=0;$i<1;$i++){	
					$deleteQuery = "DELETE FROM ".$deleteTableArray[$i];
					$deleteTableQuery = mysql_query($deleteQuery);
					if($deleteTableQuery){
						$msg = "Table ".$deleteTableArray[$i]." Successfully";
						msg_log($msg,'Main_SubTableDelete_Success');
					}else{
						$msg = "Table ".$deleteTableArray[$i]." not deleted Successfully ".mysql_error();				 
						msg_log($msg,'Main_SubTableDeleteFail');
					}
				}	
			
				//Disable Foreign Key Check Enable
				$foreignkeyQuery_enable =  " SET FOREIGN_KEY_CHECKS = 1;";
				$foreignkeyQueryExe_enable = mysql_query($foreignkeyQuery_enable);

?>