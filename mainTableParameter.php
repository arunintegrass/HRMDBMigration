<?php

	include('variable.php');
	include('mainTableMigration.php');

	
	$moduleName = strtolower($_REQUEST['modulename']);
	$mainTable  =  $subTableArray  =  array();
	
	if($moduleName == ""){
		echo "Module Name is not Available";
		exit;
	}
	/*//For Settings Module
	else if($moduleName == "settings"){
		//Settings Tables
		$mainTable  =   array(
								['pKey'=>'setting_field_id','tbName'=>'hrm_setting_fields_tb'], // task_id							
							);							
							
		$subTableArray  =   array(
								//Update - setting_field_id
								array(
										['fKey'=>'setting_field_id','tbName'=>'hrm_settings_tb'],			
									),
							);	
				
	}	*/
	//For Expense Module
	else if($moduleName == "expense"){
		//Expense Tables
		$mainTable  =   array(
								['pKey'=>'expense_id','tbName'=>'hrm_emp_exp_td'],		//Newly Added
								['pKey'=>'doc_map_id','tbName'=>'hrm_expuploadmap_td'], // doc_map_id
								['pKey'=>'tracking_id','tbName'=>'hrm_emp_descriptionexp_td'],  //tracking_id
								//Wrong Table ['pKey'=>'shop_category_id','tbName'=>'hrm_emp_shop_category']  //tracking_id
							//wrong	['pKey'=>'category_id','tbName'=>'hrm_category_tb']  //tracking_id
							);							
							
		$subTableArray  =   array(
								//Expense Tables
								array(
										['pKey'=>'notify_id','fKey'=>'ref_id','tbName'=>'hrm_notification_tb','extraCond'=>' and ref_type=3 '],			//Newly Added				
									),
								array(
										['pKey'=>'expense_id','fKey'=>'doc_map_id','tbName'=>'hrm_emp_exp_td'],				
									),
								array(
										['pKey'=>'history_process_id','fKey'=>'tracking_id','tbName'=>'hrm_expense_history_process'],				
										['pKey'=>'history_process_id','fKey'=>'tracking_id','tbName'=>'hrm_expense_approvelist_process'],		
										['pKey'=>'expense_id','fKey'=>'tracking_id','tbName'=>'hrm_emp_exp_td'],												
									),	
								/*Wrong Table array(
										['pKey'=>'expense_id','fKey'=>'category_id','tbName'=>'hrm_emp_exp_td'],				
										['pKey'=>'expense_id','fKey'=>'subcategory_id','tbName'=>'hrm_emp_exp_td'],				
									),	*/	
								/*	array(
										['pKey'=>'category_id','fKey'=>'subcategory_id','tbName'=>'hrm_category_tb'],	
										['pKey'=>'expense_id','fKey'=>'category_id','tbName'=>'hrm_emp_exp_td'],											
										['pKey'=>'expense_id','fKey'=>'subcategory_id','tbName'=>'hrm_emp_exp_td'],				
									), */
									
							);	
	}	
	//For Rewards Module
	else if($moduleName == "rewards"){
		//Rewards Tables
		$mainTable  =   array(
								['pKey'=>'shop_product_id','tbName'=>'hrm_emp_shop_product'], // task_id							
							);							
							
		$subTableArray  =   array(
								//Update - timesheet_id
								array(
										['pKey'=>'shop_addcart_id','fKey'=>'shop_product_id','tbName'=>'hrm_emp_shop_addcart'],			
									),
							);	
				
	}
	
	//For TimeSheet Module
	else if($moduleName == "timesheet"){
		//TimeSheet Tables
		$mainTable  =   array(
								['pKey'=>'timesheet_id','tbName'=>'hrm_emp_timesheet'], // task_id							
							);							
							
		$subTableArray  =   array(
								//Update - timesheet_id
								array(
										['pKey'=>'notify_id','fKey'=>'ref_id','tbName'=>'hrm_notification_tb','extraCond'=>' and ref_type=2 '],			
									),
							);	
				
	}
	//For Project Module
	else if($moduleName == "project"){
		//project Tables
		$mainTable  =   array(
								['pKey'=>'task_id','tbName'=>'hrm_project_task_tb'], // task_id
								['pKey'=>'project_id','tbName'=>'hrm_project_tb'],  //project_id
								['pKey'=>'client_id','tbName'=>'hrm_client_tb'],  //project_id
								
							);							
							
		$subTableArray  =   array(
								//Update - task_id
								array(
										['pKey'=>'map_id','fKey'=>'task_id','tbName'=>'hrm_project_map_tb'],				
										['pKey'=>'timesheet_id','fKey'=>'task_id','tbName'=>'hrm_emp_timesheet'],				
									),
								//Update - project_id	
								array(
										['pKey'=>'map_id','fKey'=>'project_id','tbName'=>'hrm_project_map_tb'],				
										//['pKey'=>'project_id','fKey'=>'project_id','tbName'=>'hrm_project_tb'],				
										['pKey'=>'task_id','fKey'=>'project_id','tbName'=>'hrm_project_task_tb'],				
										['pKey'=>'timesheet_id','fKey'=>'project_id','tbName'=>'hrm_emp_timesheet'],				
									),	 		
								//Update - client_id
								array(
										['pKey'=>'project_id','fKey'=>'client_id','tbName'=>'hrm_project_tb'],			
									),	
							);	
	}		
	//For Event Module
	else if($moduleName == "event"){
		//Event Tables
		$mainTable  =   array(
								['pKey'=>'event_id','tbName'=>'events_tb'], // task_id							
							);							
							
		$subTableArray  =   array(
								//Update - event_id
								array(
										['pKey'=>'event_map_id','fKey'=>'event_id','tbName'=>'event_map_tb'],				
									),
							);	
				
	}
	//For Performance Module
	else if($moduleName == "performance"){
		//Performance Tables
		$mainTable  =   array(
								['pKey'=>'kpi_id','tbName'=>'performance_kpi'], // kpi_id							
								['pKey'=>'review_id','tbName'=>'performance_review'], // review_id							
							);						
							
		$subTableArray  =   array(
								//Update - kpi_id
								array(
										['pKey'=>'appraisal_id','fKey'=>'kpi_id','tbName'=>'performance_appraisal'],				
									),
								//Update - review_id
								array(
										['pKey'=>'appraisal_id','fKey'=>'review_id','tbName'=>'performance_appraisal'],				
									),
							);		
	}		
	//For Recruitment Module
	else if($moduleName == "recruitment"){
		//Recruitment Tables
		$mainTable  =   array(
								['pKey'=>'applicant_id','tbName'=>'hrm_applicant_td'], // applicant_id							
								['pKey'=>'job_id','tbName'=>'hrm_post_job_td'], // job_id							
							);						
							
		$subTableArray  =   array(
								//Update - applicant_id
								array(
										['pKey'=>'history_process_id','fKey'=>'applicant_id','tbName'=>'hrm_applicant_history_process'],				
										['pKey'=>'interview_process_id','fKey'=>'applicant_id','tbName'=>'hrm_interview_process_td'],				
									),
								//Update - job_id
								array(
										['pKey'=>'history_process_id','fKey'=>'job_id','tbName'=>'hrm_applicant_history_process'],				
										['pKey'=>'applicant_id','fKey'=>'job_id','tbName'=>'hrm_applicant_td'],				
									),
							);		
	}			
	//For Payroll Module
	else if($moduleName == "payroll"){
			//Payroll Tables
		$mainTable  =   array(
								['pKey'=>'salary_id','tbName'=>'payroll_salary_tb'], // salary_id	
							);						
							
		$subTableArray  =   array(
								//Update - salary_id
								array(
										['pKey'=>'reduction_id','fKey'=>'salary_id','tbName'=>'payroll_deduction_tb'],				
										['pKey'=>'allowance_id','fKey'=>'salary_id','tbName'=>'payroll_allowance_tb'],				
									),								
							);		
	}		
	//For Payroll Module
	else if($moduleName == "leave"){
			//Payroll Tables
		/*$mainTable  =   array(
								['pKey'=>'leave_type_id','tbName'=>'emp_leave_type_td'], // leave_type_id	
								['pKey'=>'leave_id','tbName'=>'hrm_emp_leave_td'], // leave_type_id	
							);						
							
		$subTableArray  =   array(
								//Update - leave_type_id
								array(
										['fKey'=>'leave_type_id','tbName'=>'hrm_emp_leave_bal_tb'],				
									),	
								//Update - leave_id
								array(
										['fKey'=>'leave_id','tbName'=>'emp_leave_type_td'],		
										['fKey'=>'ref_id','tbName'=>'hrm_notification_tb','extraCond'=>' and ref_type=1 '],			//Newly Added										
									),									
							);	*/
							
		$mainTable  =   array(
								//['pKey'=>'leave_type_id','tbName'=>'emp_leave_type_td'], // leave_type_id	- Not in Use
								['pKey'=>'leave_id','tbName'=>'hrm_emp_leave_td'], // leave_id	
								['pKey'=>'leave_type_id','tbName'=>'hrm_leave_type_tb'], // leave_type_id	
							);						
							
		$subTableArray  =   array(
								//Update - leave_type_id - Not in Use
								/*array(
										['fKey'=>'leave_type_id','tbName'=>'hrm_emp_leave_bal_tb'],				
									),	*/
								//Update - leave_id
								array(
										//['fKey'=>'leave_id','tbName'=>'emp_leave_type_td'],		 - Not in Use
										['pKey'=>'notify_id','fKey'=>'ref_id','tbName'=>'hrm_notification_tb','extraCond'=>' and ref_type=1 '],			//Newly Added										
									),		
								//Update - leave_type_id  -  Newly Added
								array(
										['pKey'=>'leave_rule_id','fKey'=>'leave_type_id','tbName'=>'hrm_leave_type_rule'],													
										['pKey'=>'leave_bal_id','fKey'=>'leave_type_id','tbName'=>'hrm_emp_leave_bal_tb'],	
										['pKey'=>'leave_id','fKey'=>'leave_type','tbName'=>'hrm_emp_leave_td'],		
									),										
							);		
							
	}		
	//For Document Module
	else if($moduleName == "document"){
		//Document Tables
		$mainTable  =   array(
								['pKey'=>'doc_map_id','tbName'=>'hrm_document_map_td'], // task_id							
							);							
							
		$subTableArray  =   array(
								//Update - doc_map_id
								array(
										['pKey'=>'doc_id','fKey'=>'doc_map_id','tbName'=>'hrm_document_td'],				
										['pKey'=>'leave_id','fKey'=>'leave_document_map_id','tbName'=>'hrm_emp_leave_td'],				
									),
							);	
	}	
	//For Field Module
	else if($moduleName == "field"){
		//Field Tables ==> Not Necessary Because already hrm_table_fields_td has US and IN Entries
		/*$mainTable  =   array(
								['pKey'=>'field_id','tbName'=>'hrm_table_fields_td'], // field_id							
							);							
							
		$subTableArray  =   array(
								//Update - field_id
								array(
										['pKey'=>'personal_meta_id','fKey'=>'hrm_table_fields_td_field_id','tbName'=>'hrm_personal_meta_td'],				
									),
							);	
		*/					
	}	
	//For Organization Module
	else if($moduleName == "organization"){
		//Organization Tables
		$mainTable  =   array(
								['pKey'=>'tree_map_id','tbName'=>'tree_parent_tb'], //tree_map_id		
								['pKey'=>'org_tree_id','tbName'=>'organization_tree_tb'], //org_tree_id										
							);							
							
		$subTableArray  =   array(
								//Update - tree_map_id
								array(
										['pKey'=>'timesheet_id','fKey'=>'weak_id','tbName'=>'hrm_emp_timesheet'],				
										//['fKey'=>'user_id','tbName'=>'hrm_notification_tb'],
										['pKey'=>'notify_id','fKey'=>'user_id','tbName'=>'hrm_notification_tb','extraCond'=>' and ref_flag=1 '],										
									),
								//Update - org_tree_id
								array(
										['pKey'=>'tree_map_id','fKey'=>'org_tree_id','tbName'=>'tree_parent_tb'],											
									),	
							);	
	}	
	//For Employee Module
/*	else if($moduleName == "employee"){
		//Employee Tables
		$mainTable  =   array(
								['pKey'=>'employee_id','tbName'=>'hrm_employee_td'], 								
							);							
							
		$subTableArray  =   array(
								//Update - employee_id
								array(
										['pKey'=>'employee_id','fKey'=>'employee_id','tbName'=>'hrm_emp_checklist'],				
										['pKey'=>'emp_official_info_id','fKey'=>'employee_id','tbName'=>'hrm_emp_official_info_tb'],	
										['pKey'=>'emp_education_id','fKey'=>'employee_id','tbName'=>'hrm_emp_education_td'],	
										['pKey'=>'personal_bank_id','fKey'=>'employee_id','tbName'=>'hrm_emp_personal_bank_detail_tb'],	
										['pKey'=>'emp_personal_details_id','fKey'=>'employee_id','tbName'=>'hrm_emp_personal_details_td'],	
										['pKey'=>'emp_family_id','fKey'=>'employee_id','tbName'=>'hrm_emp_family_tb'],	
										['pKey'=>'emp_contact_id','fKey'=>'employee_id','tbName'=>'hrm_emp_contact_td'],
										['pKey'=>'tracking_id','fKey'=>'employee_id','tbName'=>'hrm_emp_descriptionexp_td'],
										['pKey'=>'emp_experience_id','fKey'=>'employee_id','tbName'=>'hrm_emp_experience_tb'],
										['pKey'=>'expense_id','fKey'=>'employee_id','tbName'=>'hrm_emp_exp_td'],
										['pKey'=>'expense_id','fKey'=>'expense_send_to','tbName'=>'hrm_emp_exp_td'],
										['pKey'=>'leave_bal_id','fKey'=>'employee_id','tbName'=>'hrm_emp_leave_bal_tb'],
										['pKey'=>'emp_login_id','fKey'=>'employee_id','tbName'=>'hrm_emp_login_tb'],
										['pKey'=>'emp_official_info_id','fKey'=>'employee_id','tbName'=>'hrm_emp_official_info_tb'],
										['pKey'=>'reliving_info_id','fKey'=>'employee_id','tbName'=>'hrm_emp_reliving_info'],
										['pKey'=>'shop_addcart_id','fKey'=>'employee_id','tbName'=>'hrm_emp_shop_addcart'],
										['pKey'=>'emp_status_map_id','fKey'=>'employee_id','tbName'=>'hrm_emp_status_map_td'],
										['pKey'=>'timesheet_id','fKey'=>'employee_id','tbName'=>'hrm_emp_timesheet'],
										['pKey'=>'timesheet_id','fKey'=>'weak_id','tbName'=>'hrm_emp_timesheet'], //Newly  Added
										['pKey'=>'newletter_id','fKey'=>'employee_id','tbName'=>'hrm_eventsnewletter_tb'],
										['pKey'=>'history_process_id','fKey'=>'employee_id','tbName'=>'hrm_expense_approvelist_process'],
										['pKey'=>'history_process_id','fKey'=>'employee_id','tbName'=>'hrm_expense_history_process'],
										//['fKey'=>'employee_id','tbName'=>'hrm_notification_setting_tb'],
									//	['pKey'=>'','fKey'=>'user_id','tbName'=>'hrm_notification_tb','extraCond'=>' and ref_type=0 '],
										['pKey'=>'notify_id','fKey'=>'user_id','tbName'=>'hrm_notification_tb','extraCond'=>' and ref_flag=0 '],		
										['pKey'=>'payroll_id','fKey'=>'employee_id','tbName'=>'hrm_payroll_td'],
										['pKey'=>'personal_meta_id','fKey'=>'hrm_employee_td_employee_id','tbName'=>'hrm_personal_meta_td'],
										['pKey'=>'privilege_map_id','fKey'=>'employee_id','tbName'=>'hrm_privilege_map_td'],
										['pKey'=>'map_id','fKey'=>'employee_id','tbName'=>'hrm_project_map_tb'],
										['pKey'=>'project_id','fKey'=>'employee_id','tbName'=>'hrm_project_tb'],
										['pKey'=>'setting_id','fKey'=>'ref_id','tbName'=>'hrm_settings_tb','extraCond'=>' and ref_type=3 '],
										//['fKey'=>'employee_id','tbName'=>'hrm_shift_map_td'],
										['pKey'=>'org_tree_id','fKey'=>'employee_tb_employee_id','tbName'=>'organization_tree_tb'],
										['pKey'=>'salary_id','fKey'=>'user_id','tbName'=>'payroll_salary_tb'],
										['pKey'=>'review_id','fKey'=>'user_id','tbName'=>'performance_review'],
										['pKey'=>'review_id','fKey'=>'reviewer_id','tbName'=>'performance_review'],
										['pKey'=>'event_id','fKey'=>'ref_id','tbName'=>'events_tb'],
										['pKey'=>'history_process_id','fKey'=>'ref_user_id','tbName'=>'hrm_applicant_history_process'],
										['pKey'=>'custom_msg_id','fKey'=>'created_by','tbName'=>'hrm_custom_msg'],	
										['pKey'=>'shop_category_id','fKey'=>'shop_category_creby','tbName'=>'hrm_emp_shop_category'],	
										['pKey'=>'applicant_id','fKey'=>'posted_by','tbName'=>'hrm_applicant_td'],	//Newly Added
										['pKey'=>'doc_map_id','fKey'=>'upload_by','tbName'=>'hrm_document_map_td'],
										['pKey'=>'doc_id','fKey'=>'emp_id','tbName'=>'hrm_document_td'],
										['pKey'=>'discount_id','fKey'=>'employee_id','tbName'=>'hrm_empdiscount_tb'],
										['pKey'=>'discount_id','fKey'=>'upload_by','tbName'=>'hrm_empdiscount_tb'],
										['pKey'=>'tracking_id','fKey'=>'send_to','tbName'=>'hrm_emp_descriptionexp_td'],
										['pKey'=>'tracking_id','fKey'=>'posted_by','tbName'=>'hrm_emp_descriptionexp_td'],
										['pKey'=>'expense_id','fKey'=>'upload_by','tbName'=>'hrm_emp_exp_td'],
										['pKey'=>'emp_reporting_id','fKey'=>'reporting_to','tbName'=>'hrm_emp_reporting_td'],
										['pKey'=>'shop_product_id','fKey'=>'shop_product_creby','tbName'=>'hrm_emp_shop_product'],
										['pKey'=>'emp_status_map_id','fKey'=>'status_changed_by','tbName'=>'hrm_emp_status_map_td'],
										['pKey'=>'newletter_id','fKey'=>'upload_by','tbName'=>'hrm_eventsnewletter_tb'],
										['pKey'=>'doc_map_id','fKey'=>'upload_by','tbName'=>'hrm_expuploadmap_td'],
										['pKey'=>'tree_map_id','fKey'=>'parent_org_tree_id','tbName'=>'tree_parent_tb'],
										['pKey'=>'leave_id','fKey'=>'employee_id','tbName'=>'hrm_emp_leave_td'],
										['pKey'=>'leave_id','fKey'=>'leave_send_to','tbName'=>'hrm_emp_leave_td'],
										['pKey'=>'job_id','fKey'=>'posted_by','tbName'=>'hrm_post_job_td'],
									),								
							);	
	} */
	//For Company Module
	else if($moduleName == "company"){
	
		$mainTable  =   array(
								//['pKey'=>'company_id','tbName'=>'hrm_company_td','extraUpdate'=>' parent_id=1,is_parent=0 ','companyExtraCond'=>" where hrm_version='US' "], //company_id								
								['pKey'=>'company_id','tbName'=>'hrm_company_td','extraUpdate'=>' parent_id=1,is_parent=0,currency_type=1 ','companyExtraCond'=>" where is_parent='1' "], //company_id								
							);							
		//Sub Table					
		$subTableArray  =   array(								
								//Update - company_id
								array(
										['pKey'=>'employee_id','fKey'=>'branche_id','tbName'=>'hrm_employee_td','extraCond'=>" and branch_data = 'IN' "],
										['pKey'=>'job_id','fKey'=>'branche_id','tbName'=>'hrm_post_job_td','extraCond'=>" and branch_data = 'IN' "],
										['pKey'=>'newletter_id','fKey'=>'branche_id','tbName'=>'hrm_eventsnewletter_tb','extraCond'=>" and branch_data = 'IN' "],
										['pKey'=>'discount_id','fKey'=>'branche_id','tbName'=>'hrm_empdiscount_tb','extraCond'=>" and branch_data = 'IN' "],
										['pKey'=>'shop_category_id','fKey'=>'branche_id','tbName'=>'hrm_emp_shop_category','extraCond'=>" and branch_data = 'IN' "],
									),	
							);	
	}		
	mainTableMigration($dbArray,$mainTable,$subTableArray,ucfirst($moduleName).'Module_',$con);
	
	
?>