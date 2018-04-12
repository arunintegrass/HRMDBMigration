<?php

include('variable.php');
include('messagelog.php');
include('updateCompanyId.php');

$mainTable  =  $subTableArray  =  array();
	

	$mainTable  =   array(
								['pKey'=>'company_id','tbName'=>'hrm_company_td','extraUpdate'=>' parent_id=1,is_parent=0,currency_type=1 ','companyExtraCond'=>" where is_parent='1' "], //company_id								
							);				
							
updateCompanyId($dbArray,$mainTable,'1','UpdateCompanyModule_CompanyId');