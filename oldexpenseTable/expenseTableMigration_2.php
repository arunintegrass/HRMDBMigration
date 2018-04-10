<?php

	include('../variable.php');
	include('../messagelog.php');
	
		
	//Expense Tables
	$mainTable  =   ['pKey'=>'tracking_id','tbName'=>'hrm_emp_descriptionexp_td'];
	
	$subTableArray  =   array(
							//Expense Tables
							['fKey'=>'tracking_id','tbName'=>'hrm_expense_history_process'],				
						);	
	$filename='expenseTableMigration_2_';				
	
	$con = mysql_connect("localhost", "root", ""); 
	$select_id = mysql_query("SELECT ".$mainTable['pKey']." as uniq_id from ".$dbArray['srcDB'].".".$mainTable['tbName']);
	
	//Inserting One Unique At one Time in all the table
	while($row_id = mysql_fetch_array($select_id)){
		
		$old_unique_id = $row_id['uniq_id'];
		
		//Insert into the main table
		$msg = "Old Unique Id - ".$old_unique_id;	
		msg_log($msg,$filename.'Queries');	
		
		$columnQuery = " SELECT GROUP_CONCAT(COLUMN_NAME) FROM information_schema.columns WHERE table_schema = '".$dbArray['srcDB']."' AND table_name = '".$mainTable['tbName']."'  and column_name NOT IN ( '".$mainTable['pKey']."') ";	
		$execolumnQuery = mysql_query($columnQuery);
		$rescolumnQuery = mysql_fetch_array($execolumnQuery);
			
		//Insert into sub tables and update the Unique id with latest Unique id
		 $mainQuery =  "INSERT INTO ".$dbArray['destDB'].".".$mainTable['tbName'].							
						"(".$rescolumnQuery[0].")".
					   " SELECT ".$rescolumnQuery[0]." from ".$dbArray['srcDB'].".".$mainTable['tbName']." 
					    where .".$mainTable['tbName'].".".$mainTable['pKey']." = ".$old_unique_id;	
		
		$latest_query = mysql_query($mainQuery);
		
		if($latest_query){
			
			//Latest Unique Id
			$latest_unique_id = mysql_insert_id();
			$msg = "Migrated to New Unique Id - ".$latest_unique_id;
			
			msg_log($msg,$filename.'Queries');	

			for($i=0;$i<count($subTableArray);$i++){
				
				$subQuery1 = "update ".$dbArray['destDB'].".".$subTableArray[$i]['tbName']." set ".$subTableArray[$i]['fKey']." = ".$latest_unique_id." where ".$subTableArray[$i]['fKey']." = ".$old_unique_id;
				$subTableCopyQuery1 = mysql_query($subQuery1);
				
				if($subTableCopyQuery1){
					$msg = "Sub Table ".($i+1)." : ".$subTableArray[$i]['tbName']." migrated Successfully\r\n\n";
					msg_log($msg,$filename.'Success');
				}else{
					$msg = "Sub Table ".($i+1)." : ".$subTableArray[$i]['tbName']." not migrated successfully ".mysql_error();				 
					msg_log($msg,$filename.'Fail');
				}
			}	
			
		}else{
			  $msg =  "Main Table : ".$mainTable['tbName']." not migrated successfully ".mysql_error();
			  msg_log($msg,$filename.'Fail');
		 }
	}	 
  
?>