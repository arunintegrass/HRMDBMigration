<?php


	include('variable.php');
	include('messagelog.php');
	
		$db = mysql_select_db($dbArray['finalDB'],$con);
		//Relation Table (or) Sub Table Array - Table 1 - test2 
		$alterTableArray_fob  =   array(	
								//Truncate the Master Tables 		
								"TRUNCATE `hrm_setting_fields_tb`",
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
								"TRUNCATE `hrm_emp_login_tb`",
								"TRUNCATE `hrm_employee_td`",								
								"UPDATE `hrm_common_table` SET `field_value` = 'timesheet comments_old' WHERE `hrm_common_table`.`id` = 52 and  `field_value` = 'timesheet comments'",
								"UPDATE `hrm_common_table` SET `field_name` = 'timesheet_old' WHERE `hrm_common_table`.`id` = 52",
								"UPDATE `hrm_emp_login_tb` SET `username` = 'subash1@integrass.com' WHERE `hrm_emp_login_tb`.`emp_login_id` = 116 and `username` = 'subash@integrass.com' ",
								"UPDATE `hrm_emp_login_tb` SET `password` = 'a85fef5033968a7be5ae5698890655c9', `rand_key` = '' WHERE `hrm_emp_login_tb`.`emp_login_id` = 122 and `hrm_emp_login_tb`.`username`='demoemp@gmai.com'",								
							);
							
		//Disable Foreign Key Check Temporarily Disable
		$foreignkeyQuery_disable =  " SET FOREIGN_KEY_CHECKS = 0;";
		$foreignkeyQueryExe_disable = mysql_query($foreignkeyQuery_disable);
		
		for($i=0;$i<count($alterTableArray_fob);$i++){
				
			$alterTableQuery_fob = mysql_query($alterTableArray_fob[$i]);
			
			if($alterTableQuery_fob){
				$msg = "Final DB - Alter Query ".($i+1)." : executed Successfully";
				msg_log($msg,'Fobess_ExtraStructure_Success');
			}else{
				$msg = "Final DB - Alter Query".($i+1)." :  not executed  ".mysql_error();				 
				msg_log($msg,'Fobess_ExtraStructure_Fail');
			}
			
		}								
			
		$foreignkeyQuery_enable =  " SET FOREIGN_KEY_CHECKS = 1;";
		$foreignkeyQueryExe_enable = mysql_query($foreignkeyQuery_enable);	

?>