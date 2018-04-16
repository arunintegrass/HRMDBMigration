<?php

	include('variable.php');
	include('masterTableMigration.php');

	
	$moduleName = strtolower($_REQUEST['modulename']);
	$masterTable  =  $subTableArray  =  array();
	
	if($moduleName == ""){
		echo "Module Name is not Available";
		exit;
	}
	//For Settings Module
	else if($moduleName == "settings"){
		//Settings Tables
		$masterTable  =   array(
								//['pKey'=>'setting_field_id','tbName'=>'hrm_setting_fields_tb','uniqData1'=>'setting_name','uniqData2'=>'setting_val','uniqData3'=>'type','uniqData4'=>'status'], // setting_field_id							
								['pKey'=>'setting_field_id','tbName'=>'hrm_setting_fields_tb','uniqData1'=>'setting_val','uniqData2'=>'type'], // setting_field_id	- If Checking with "status"	it may occur Duplicate Entry
							);							
							
		$subTableArray  =   array(
								//Update - setting_field_id
								array(
										['pKey'=>'setting_id','fKey'=>'setting_field_id','tbName'=>'hrm_settings_tb'],			
									),
							);	
				
	}	
	else if($moduleName == "employee"){
		//Employee Tables
		$masterTable  =   array(
		//Need to add extra column in two tables beneath ==> Fobess Data (or) Integrass Data Need to add extra column in Fobess and Integrass table data and add extracondition for not to update "branch-id"
								//['pKey'=>'emp_login_id','tbName'=>'hrm_emp_login_tb','uniqData1'=>'username','uniqData2'=>'password','uniqData3'=>'user_level','uniqData4'=>'status'], 								
								//['pKey'=>'employee_id','tbName'=>'hrm_employee_td','uniqData1'=>'emp_first_name','uniqData2'=>'emp_last_name','uniqData3'=>'work_email'], 											
								['pKey'=>'emp_login_id','tbName'=>'hrm_emp_login_tb','uniqData1'=>'username','uniqData2'=>'status'], 								
								//['pKey'=>'employee_id','tbName'=>'hrm_employee_td','uniqData1'=>'work_email','uniqData2'=>'emp_status'], 								
								['pKey'=>'employee_id','tbName'=>'hrm_employee_td','uniqData1'=>'work_email'], 								
							);							
							
		$subTableArray  =   array(
								//Update - employee_id
								array(),
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
										['pKey'=>'leave_bal_id','fKey'=>'employee_id','tbName'=>'hrm_emp_leave_bal_tb'],
										//Old['pKey'=>'emp_login_id','fKey'=>'employee_id','tbName'=>'hrm_emp_login_tb'],
										['pKey'=>'emp_login_id','fKey'=>'employee_id','tbName'=>'hrm_emp_login_tb','extraCond'=>' and branch_data="IN" '],
										//Extra['pKey'=>'emp_official_info_id','fKey'=>'employee_id','tbName'=>'hrm_emp_official_info_tb'],
										['pKey'=>'reliving_info_id','fKey'=>'employee_id','tbName'=>'hrm_emp_reliving_info'],
										['pKey'=>'shop_addcart_id','fKey'=>'employee_id','tbName'=>'hrm_emp_shop_addcart'],
										['pKey'=>'emp_status_map_id','fKey'=>'employee_id','tbName'=>'hrm_emp_status_map_td'],
										['pKey'=>'timesheet_id','fKey'=>'employee_id','tbName'=>'hrm_emp_timesheet','migrateUpdate'=>'1'],
										['pKey'=>'timesheet_id','fKey'=>'weak_id','tbName'=>'hrm_emp_timesheet','migrateUpdate'=>'2'], //Newly  Added										
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
										['pKey'=>'review_id','fKey'=>'user_id','tbName'=>'performance_review','migrateUpdate'=>'1'],
										['pKey'=>'review_id','fKey'=>'reviewer_id','tbName'=>'performance_review','migrateUpdate'=>'2'],
										['pKey'=>'event_id','fKey'=>'ref_id','tbName'=>'events_tb'],
										['pKey'=>'history_process_id','fKey'=>'ref_user_id','tbName'=>'hrm_applicant_history_process'],
										['pKey'=>'custom_msg_id','fKey'=>'created_by','tbName'=>'hrm_custom_msg'],	
										['pKey'=>'shop_category_id','fKey'=>'shop_category_creby','tbName'=>'hrm_emp_shop_category'],	
										['pKey'=>'applicant_id','fKey'=>'posted_by','tbName'=>'hrm_applicant_td'],	//Newly Added
										['pKey'=>'doc_map_id','fKey'=>'upload_by','tbName'=>'hrm_document_map_td'],
										['pKey'=>'doc_id','fKey'=>'emp_id','tbName'=>'hrm_document_td'],
										['pKey'=>'discount_id','fKey'=>'employee_id','tbName'=>'hrm_empdiscount_tb','migrateUpdate'=>'1'],
										['pKey'=>'discount_id','fKey'=>'upload_by','tbName'=>'hrm_empdiscount_tb','migrateUpdate'=>'2'],
										['pKey'=>'tracking_id','fKey'=>'send_to','tbName'=>'hrm_emp_descriptionexp_td','migrateUpdate'=>'1'],
										['pKey'=>'tracking_id','fKey'=>'posted_by','tbName'=>'hrm_emp_descriptionexp_td','migrateUpdate'=>'2'],
										['pKey'=>'expense_id','fKey'=>'employee_id','tbName'=>'hrm_emp_exp_td','migrateUpdate'=>'1'],
										['pKey'=>'expense_id','fKey'=>'upload_by','tbName'=>'hrm_emp_exp_td','migrateUpdate'=>'2'],
										['pKey'=>'emp_reporting_id','fKey'=>'reporting_to','tbName'=>'hrm_emp_reporting_td'],
										['pKey'=>'shop_product_id','fKey'=>'shop_product_creby','tbName'=>'hrm_emp_shop_product'],
										['pKey'=>'emp_status_map_id','fKey'=>'status_changed_by','tbName'=>'hrm_emp_status_map_td'],
										['pKey'=>'newletter_id','fKey'=>'employee_id','tbName'=>'hrm_eventsnewletter_tb','migrateUpdate'=>'1'],
										['pKey'=>'newletter_id','fKey'=>'upload_by','tbName'=>'hrm_eventsnewletter_tb','migrateUpdate'=>'2'],
										['pKey'=>'doc_map_id','fKey'=>'upload_by','tbName'=>'hrm_expuploadmap_td'],
										['pKey'=>'tree_map_id','fKey'=>'parent_org_tree_id','tbName'=>'tree_parent_tb'],
										['pKey'=>'leave_id','fKey'=>'employee_id','tbName'=>'hrm_emp_leave_td','migrateUpdate'=>'1'],
										['pKey'=>'leave_id','fKey'=>'leave_send_to','tbName'=>'hrm_emp_leave_td','migrateUpdate'=>'2'],
									),								
							);	
	}
	//For Expense Category Module
	else if($moduleName == "expensecategory"){
		$masterTable  =   array(
								['pKey'=>'category_id','tbName'=>'hrm_category_tb','uniqData1'=>'name','uniqData2'=>'category_status','uniqData3'=>'is_parent','uniqData4'=>'subcategory_id'], 
							);							
							
		$subTableArray  =   array(
								//Update - category_id
								array(
										['pKey'=>'expense_id','fKey'=>'category_id','tbName'=>'hrm_emp_exp_td'],				
										['pKey'=>'expense_id','fKey'=>'subcategory_id','tbName'=>'hrm_emp_exp_td'],											
									),
							);	
	}	
	//For Reward Category Module
	else if($moduleName == "rewardcategory"){
		$masterTable  =   array(
								['pKey'=>'shop_category_id','tbName'=>'hrm_emp_shop_category','uniqData1'=>'shop_category_name','uniqData2'=>'shop_category_desc','uniqData3'=>'shop_category_status','uniqData4'=>'shop_category_flag'], 
							);							
							
		$subTableArray  =   array(
								//Update - shop_category_id
								array(
										['pKey'=>'shop_product_id','fKey'=>'shop_category_id','tbName'=>'hrm_emp_shop_product'],				
										['pKey'=>'shop_addcart_id','fKey'=>'shop_product_id','tbName'=>'hrm_emp_shop_addcart'],											
									),
							);	
	}	
	
	//For Payroll Grade Module
	else if($moduleName == "grade"){
		//Payroll Grade Tables
		$masterTable  =   array(
								['pKey'=>'grade_id','tbName'=>'payroll_paygrade','uniqData1'=>'grade_name','uniqData2'=>'amt_percentage'], // grade_id
							);							
							
		$subTableArray  =   array(
								//grade_id Tables
								array(
										['pKey'=>'temp_id','fKey'=>'grade_id','tbName'=>'payroll_temp'],	
										['pKey'=>'salary_id','fKey'=>'grade_id','tbName'=>'payroll_salary_tb'],	
								),								
							);	
	}else if($moduleName == "group"){  //For Payroll Group Module - Not in Use
		//Payroll Group Tables
		$masterTable  =   array(
								['pKey'=>'emp_group_id','tbName'=>'hrm_emp_group_td','uniqData1'=>'group_name','uniqData2'=>'group_flag','uniqData3'=>'track_group_date'], // grade_id
							);							
							
		$subTableArray  =   array(
								//emp_group_id Tables
								array(
									//	['fKey'=>'ref_id','tbName'=>'hrm_settings_tb','extraCond'=>' and ref_type=2 '],
								),								
							);	
	}else if($moduleName == "type"){ //For Employee Type Module
		// Employee Type Tables
		$masterTable  =   array(
								['pKey'=>'employment_type_id','tbName'=>'hrm_emp_type_tb','uniqData1'=>'employment_type_name','uniqData2'=>'employment_type_flag','uniqData3'=>'employment_type_status'], // grade_id
							);							
							
		$subTableArray  =   array(
								//emp_group_id Tables
								array(
										['pKey'=>'employee_id','fKey'=>'emp_type','tbName'=>'hrm_employee_td'],
										['pKey'=>'leave_type_id','fKey'=>'leave_type_id','tbName'=>'hrm_leave_type_tb'],
								),								
							);	
	}else if($moduleName == "groupfield"){  //For Group Field Module
		//Group Field Tables
		$masterTable  =   array(
								['pKey'=>'fieled_group_id','tbName'=>'hrm_group_fields_td','uniqData1'=>'field_group_name','uniqData2'=>'field_group_desctiption','uniqData3'=>'fieled_group_weight','uniqData4'=>'field_group_flag','uniqData5'=>'field_expense_limit'], // grade_id
							);							
							
		$subTableArray  =   array(
								//emp_group_id Tables
								array(
										['pKey'=>'setting_id','fKey'=>'ref_id','tbName'=>'hrm_settings_tb','extraCond'=>' and ref_type=2 '],
										['pKey'=>'field_id','fKey'=>'fieled_group_id','tbName'=>'hrm_table_fields_td'],
										['pKey'=>'employee_id','fKey'=>'group_id','tbName'=>'hrm_employee_td'],
								),								
							);	
	}else if($moduleName == "empgrade"){  //For Employee Grade Module
		//Employee Grade Tables
		$masterTable  =   array(
								['pKey'=>'grade_id','tbName'=>'hrm_emp_grade_tb','uniqData1'=>'grade_name','uniqData2'=>'status','uniqData3'=>'flag'], // grade_id
							);							
							
		$subTableArray  =   array(
								//grade_id Tables - It is available only in Fobeess so no need for relationship
								array(),								
							);	
	}else if($moduleName == "menu"){  //For Menu Bar Module
		//Menu Bar Tables
		$masterTable  =   array(
								['pKey'=>'id','tbName'=>'hrm_common_table','uniqData1'=>'field_name','uniqData2'=>'field_value','uniqData3'=>'field_status','uniqData4'=>'field_flag','uniqData5'=>'notification','uniqData6'=>'menu_config'], // grade_id
							);							
							
		$subTableArray  =   array(
								//Nod for relationship
								array(),								
							);	
	}else if($moduleName == "workshift"){  //For Menu Bar Module
		//Menu Bar Tables
		$masterTable  =   array(
								['pKey'=>'work_shift_id','tbName'=>'hrm_work_shifts','uniqData1'=>'shift_name','uniqData2'=>'shift_start_time','uniqData3'=>'shift_end_time','uniqData4'=>'status'], // grade_id
							);							
							
		$subTableArray  =   array(
								//Nod for relationship
								array(
									['pKey'=>'employee_id','fKey'=>'shift_timing','tbName'=>'hrm_employee_td'],
									['pKey'=>'leave_type_id','fKey'=>'work_shift_id','tbName'=>'hrm_leave_type_tb'],
								),								
							);	
	}else if($moduleName == "designation"){  //For Designation Table Module
		//Designation Tables
		$masterTable  =   array(
								['pKey'=>'emp_designation_id','tbName'=>'hrm_emp_designation_td','uniqData1'=>'designation_name','uniqData2'=>'designation_parent_id','uniqData3'=>'designation_depth','uniqData4'=>'designation_flag'], // grade_id
							);							
							
		$subTableArray  =   array(
								//Nod for relationship
								array(
									['pKey'=>'setting_id','fKey'=>'ref_id','tbName'=>'hrm_settings_tb','extraCond'=>' and ref_type=1 '],
									['pKey'=>'org_tree_id','fKey'=>'emp_designation_tb_emp_designation_id','tbName'=>'organization_tree_tb'],
									['pKey'=>'kpi_id','fKey'=>'job_title','tbName'=>'performance_kpi'],
									['pKey'=>'review_id','fKey'=>'job_title','tbName'=>'performance_review'],
								),								
							);	
	}else if($moduleName == "department"){  //For Department Table Module
		//Department Tables
		$masterTable  =   array(
								['pKey'=>'department_id','tbName'=>'hrm_department_td','uniqData1'=>'department_name','uniqData2'=>'department_date','uniqData3'=>'department_description','uniqData4'=>'department_flag'], // grade_id
							);							
							
		$subTableArray  =   array(
								//Nod for relationship
								array(
									['pKey'=>'org_tree_id','fKey'=>'tree_department_id','tbName'=>'organization_tree_tb'],									
								),								
							);	
	}									
	
	
	masterTableMigration($dbArray,$masterTable,$subTableArray,ucfirst($moduleName).'Module_',$con);
	
	
?>