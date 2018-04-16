<?php

include('variable.php');
include('messagelog.php');
include('updateCompanyId.php');

$mainTable  =  $subTableArray  =  array();
	
	$foreignkeyQuery_enable =  " SET FOREIGN_KEY_CHECKS = 0;";
			$foreignkeyQueryExe_enable = mysql_query($foreignkeyQuery_enable);
	$mainTable  =   array(
								['pKey'=>'company_id','tbName'=>'hrm_company_td','extraUpdate'=>' parent_id=1,is_parent=0,currency_type=1 ','companyExtraCond'=>" where is_parent='1' "], //company_id								
							);				
							
updateCompanyId($dbArray,$mainTable,'1','UpdateCompanyModule_CompanyId');


$db = mysql_select_db($dbArray['destDB'],$con);

//$alterTableQuery_fob = mysql_query("ALTER TABLE `hrm_leave_type_tb` ADD `hrm_version` VARCHAR(10) NOT NULL DEFAULT 'IN'");
//echo $alterTableQuery_fob;
	$foreignkeyQuery_enable =  " SET FOREIGN_KEY_CHECKS = 1;";
			$foreignkeyQueryExe_enable = mysql_query($foreignkeyQuery_enable);