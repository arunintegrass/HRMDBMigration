<?php

	include('variable.php');
	include('mainTableMigration.php');	
	
	
	$mainTable  =  $subTableArray  =  array();	
	//Main Table	
	$mainTable  =   array(
							['pKey'=>'company_id','tbName'=>'hrm_company_td','extraUpdate'=>' parent_id=1,is_parent=0 ','companyExtraCond'=>" where hrm_version='US' "], //tree_map_id								
						);							
	//Sub Table					
	$subTableArray  =   array(								
							//Update - org_tree_id
							array(
									['fKey'=>'branche_id','tbName'=>'hrm_employee_td'],
								),	
						);	

				
	mainTableMigration($dbArray,$mainTable,$subTableArray,'CompanyModule_');
	
	
?>