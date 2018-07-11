<?php

	include('variable.php');
	include('messagelog.php');
	
	//Relation Table (or) Sub Table Array - Table 1 - test2 
	$subTableArray  =   array(
							//Settings Table
							['pkey'=>'setting_id','tbName'=>'hrm_settings_tb'],
							//Expense Tables
							['pkey'=>'history_process_id','tbName'=>'hrm_expense_history_process'],			
						    ['pkey'=>'history_process_id','tbName'=>'hrm_expense_approvelist_process'],
							//Expense Table
						    //['pkey'=>'expense_id','tbName'=>'hrm_emp_exp_td'],		
							//TimeSheet Table
							//['pkey'=>'timesheet_id','tbName'=>'hrm_emp_timesheet'],			
							//Document Table
							['pkey'=>'doc_id','tbName'=>'hrm_document_td'],
							//Newsletter
							['pkey'=>'newletter_id','tbName'=>'hrm_eventsnewletter_tb'],
							//Events
							['pkey'=>'event_map_id','tbName'=>'event_map_tb'],	
							//Recuritment
							['pkey'=>'history_process_id','tbName'=>'hrm_applicant_history_process'],
							['pkey'=>'interview_process_id','tbName'=>'hrm_interview_process_td'],					
							['pkey'=>'probation_period_id','tbName'=>'hrm_emp_probation_tb'],
							['pkey'=>'emp_reporting_id','tbName'=>'hrm_emp_reporting_td'],
							//REwards
							['pkey'=>'shop_addcart_id','tbName'=>'hrm_emp_shop_addcart'],
							['pkey'=>'emp_status_map_id','tbName'=>'hrm_emp_status_map_td'],
							//Leave
							['pkey'=>'leave_bal_id','tbName'=>'hrm_emp_leave_bal_tb'],		
							['pkey'=>'leave_rule_id','tbName'=>'hrm_leave_type_rule'],
							//Notification
							['pkey'=>'notify_id','tbName'=>'hrm_notification_tb'],
							//['pkey'=>'payroll_id','tbName'=>'hrm_payroll_td'],
							//['pkey'=>'job_id','tbName'=>'hrm_post_job_td'],
							['pkey'=>'privilege_map_id','tbName'=>'hrm_privilege_map_td'],
							['pkey'=>'map_id','tbName'=>'hrm_project_map_tb'],
							//['pkey'=>'task_id','tbName'=>'hrm_project_task_tb'],
							//['pkey'=>'field_id','tbName'=>'hrm_table_fields_td'],
							//['pkey'=>'','tbName'=>'keys'],
							//['pkey'=>'','tbName'=>'logs'],							
							//Payroll
							['pkey'=>'reduction_id','tbName'=>'payroll_deduction_tb'],
							['pkey'=>'allowance_id','tbName'=>'payroll_allowance_tb'],
							['pkey'=>'reliving_info_id','tbName'=>'hrm_emp_reliving_info'],
							['pkey'=>'temp_id','tbName'=>'payroll_temp'],
							//['pkey'=>'salary_id','tbName'=>'payroll_salary_tb'],							
							
							//['pkey'=>'leave_type_id','tbName'=>'emp_leave_type_td'],									
							['pkey'=>'appraisal_id','tbName'=>'performance_appraisal'],
							//['pkey'=>'kpi_id','tbName'=>'performance_kpi'],
							//['pkey'=>'review_id','tbName'=>'performance_review'],		
							//Login		
							//['pkey'=>'emp_login_id','tbName'=>'hrm_emp_login_tb'],
							//Discount
							['pkey'=>'discount_id','tbName'=>'hrm_empdiscount_tb'],
							//Field
							['pkey'=>'personal_meta_id','tbName'=>'hrm_personal_meta_td'],
							//Main Table Not Necessary - Organization Tree
							//['pkey'=>'tree_map_id','tbName'=>'tree_parent_tb'], 
							//employee
							['pkey'=>'emp_official_info_id','tbName'=>'hrm_emp_official_info_tb'],
							['pkey'=>'emp_experience_id','tbName'=>'hrm_emp_experience_tb'],
							['pkey'=>'emp_education_id','tbName'=>'hrm_emp_education_td'],
							['pkey'=>'personal_bank_id','tbName'=>'hrm_emp_personal_bank_detail_tb'],	
							['pkey'=>'emp_personal_details_id','tbName'=>'hrm_emp_personal_details_td'],
							['pkey'=>'emp_family_id','tbName'=>'hrm_emp_family_tb'],
							['pkey'=>'emp_contact_id','tbName'=>'hrm_emp_contact_td'],
							//Hoilday
							['pkey'=>'holiday_id','tbName'=>'hrm_holiday_list_td'],
							//Custom Message
							['pkey'=>'custom_msg_id','tbName'=>'hrm_custom_msg'],

							
						);
		//Disable Foreign Key Check Temporarily Disable
		$foreignkeyQuery_disable =  " SET FOREIGN_KEY_CHECKS = 0;";
		$foreignkeyQueryExe_disable = mysql_query($foreignkeyQuery_disable);
			
		for($i=0;$i<count($subTableArray);$i++){
			//for($i=0;$i<1;$i++){
			
			$columnQuery = " SELECT GROUP_CONCAT(COLUMN_NAME) FROM information_schema.columns WHERE table_schema = '".$dbArray['srcDB']."' AND table_name = '".$subTableArray[$i]['tbName']."'  and column_name NOT IN ( '".$subTableArray[$i]['pkey']."') ";	
			$execolumnQuery = mysql_query($columnQuery);
			$rescolumnQuery = mysql_fetch_array($execolumnQuery);	
			
			//Total Count Before Migrate
			$countQuery = " SELECT count( '".$subTableArray[$i]['pkey']."') as countData from ".$dbArray['srcDB'].".".$subTableArray[$i]['tbName'];
			$execountQuery = mysql_query($countQuery);
			$rescountQuery = mysql_fetch_array($execountQuery);
			$countData = $rescountQuery['countData'];
				
			//Insert into sub tables and update the employee id with latest employee id
			 $subQuery1 =  "INSERT INTO ".$dbArray['destDB'].".".$subTableArray[$i]['tbName'].							
							"(".$rescolumnQuery[0].")".
						   " SELECT ".$rescolumnQuery[0]." from ".$dbArray['srcDB'].".".$subTableArray[$i]['tbName'];	
			
			$subTableCopyQuery1 = mysql_query($subQuery1);
			msg_log($subQuery1,'subTableMigrations_Queries');
			if($subTableCopyQuery1){
				$msg = "Sub Table ".($i+1)." : ".$subTableArray[$i]['tbName']." migrated Successfully";
				$msg .= "<br>\n\nTotal Data - ".$countData." && Migrated Data Count - ".mysql_affected_rows()." - ";
				$msg .= "<br>\n\nTable Status - ".($countData==mysql_affected_rows())?"Same":"Not";
				msg_log($msg,'subTableMigrations_Success');
			}else{
				$msg = "Sub Table ".($i+1)." : ".$subTableArray[$i]['tbName']." not migrated successfully ".mysql_error();				 
				msg_log($msg,'subTableMigrations_Fail');
			}
			
		}	
		
		//Disable Foreign Key Check Enable
		$foreignkeyQuery_enable =  " SET FOREIGN_KEY_CHECKS = 1;";
		$foreignkeyQueryExe_enable = mysql_query($foreignkeyQuery_enable);
			

?>