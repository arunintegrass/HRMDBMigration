<?php
	
	function updateCompanyId($dbArray,$mainTable,$old_unique_id,$moduleName){
	
	//Update Table					
	$updateTableArray  =   array(								
								//Update - org_tree_id
								array(
										['fKey'=>'company_id','tbName'=>'hrm_emp_designation_td'],	
										['fKey'=>'company_id','tbName'=>'hrm_emp_probation_tb'],	
										['fKey'=>'company_id','tbName'=>'hrm_emp_status_td'],	
										['fKey'=>'company_id','tbName'=>'hrm_emp_type_tb'],	
										['fKey'=>'company_id','tbName'=>'hrm_general_configure_td'],	
										['fKey'=>'company_id','tbName'=>'hrm_leave_type_tb'],	
										['fKey'=>'company_id','tbName'=>'hrm_post_job_td'],	
										['fKey'=>'company_id','tbName'=>'hrm_privilege_td'],	
										['fKey'=>'company_id','tbName'=>'hrm_table_fields_td'],	
										['fKey'=>'company_id','tbName'=>'payroll_salary_tb'],	
										['fKey'=>'company_id','tbName'=>'payroll_temp'],	
										['fKey'=>'company_id','tbName'=>'performance_appraisal'],	
										['fKey'=>'company_id','tbName'=>'performance_kpi'],	
										['fKey'=>'company_id','tbName'=>'performance_review'],	
										['fKey'=>'company_id','tbName'=>'hrm_department_td'],	
										['fKey'=>'company_id','tbName'=>'hrm_department_td'],	
										['fKey'=>'company_id','tbName'=>'hrm_emp_grade_tb'],	
										['fKey'=>'company_id','tbName'=>'hrm_emp_group_td'],	
										['fKey'=>'company_id','tbName'=>'payroll_paygrade'],	
										['fKey'=>'company_id','tbName'=>'hrm_emp_exp_td'],	
										['fKey'=>'cmp_id','tbName'=>'hrm_document_map_td'],	
										['fKey'=>'cmp_id','tbName'=>'hrm_expuploadmap_td'],	
										
									),	
							);	
						
						
		for($k = 0; $k < count($mainTable); $k++){		
		
			//$parentCompanyQuery = "SELECT ".$dbArray['mainTableColumn']." as uniq_id from ".$dbArray['mainDB'].".".$dbArray['mainTable'];		
			$parentCompanyQuery = "SELECT ".$dbArray['mainTableColumn']." as uniq_id from ".$dbArray['finalDB'].".".$dbArray['mainTable'];		
			if(isset($mainTable[$k]['companyExtraCond'])){
				$parentCompanyQuery .= $mainTable[$k]['companyExtraCond'];
			}	
			//echo $parentCompanyQuery;
			$parentCompanyQueryExe = mysql_query($parentCompanyQuery);				
			$parentCompanyExe = mysql_fetch_array($parentCompanyQueryExe);				
			$mainCompanyId = $parentCompanyExe[0];
		
			for($i=0;$i<count($updateTableArray[$k]);$i++){
				
				$subQuery1 = "update ".$dbArray['destDB'].".".$updateTableArray[$k][$i]['tbName']." set ".$updateTableArray[$k][$i]['fKey']." = ".$mainCompanyId;
				$subTableCopyQuery1 = mysql_query($subQuery1);
				
				$subQuery2 = "update ".$dbArray['finalDB'].".".$updateTableArray[$k][$i]['tbName']." set ".$updateTableArray[$k][$i]['fKey']." = ".$mainCompanyId;
				$subTableCopyQuery2 = mysql_query($subQuery2);
				
				if($subTableCopyQuery1){
					$msg = "Sub Table ".($i+1)." : ".$updateTableArray[$k][$i]['tbName']." updated Successfully\r\n\n";
					msg_log($msg,'UpdateCompanyId_Success');
				}else{
					$msg = "Sub Table ".($i+1)." : ".$updateTableArray[$k][$i]['tbName']." not updated successfully ".mysql_error();				 
					msg_log($msg,'UpdateCompanyId_Fail');
				}
			}	
		}
	}		