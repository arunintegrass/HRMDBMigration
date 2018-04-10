<?php

	//Database Array
	$dbArray = ["srcDB"=>"check1","destDB"=>"check2"];		
	
	//Main Table Array - Table - test1 
	$mainTable  = [
				   "tableName"=>"test1",
				   "srcColumnName"=>"name,created_by,created_at",
				   "destColumnName"=>"name,created_by,created_at", 
				   "columnArray"=>array('name','created_by','created_at'),
				   "primaryKey"=>"id",
				   "foreignKey"=>array('')
				  ];	
				  
	//Sub Table Array - Table 1 - test2 
	$subTable1  = [
				   "tableName"=>"test2",
				   "srcColumnName"=>"user_id,address1,address2",
				   "destColumnName"=>"address1,address2", 
				   "columnArray"=>array('name','created_by','created_at'),
				   "primaryKey"=>"id",
				   "foreignKey"=>array('user_id')
				  ];	
				  
				  
	/*echo ".$." ."<br>".$mainTable['tableName'];echo "<br>".$mainTable['columnName'];	echo "<br>".$mainTable['columnArray'][0];	echo "<br>".$mainTable['primaryKey'];	echo "<br>".$mainTable['foreignKey'][0];exit;*/
	
	$con = mysql_connect("localhost", "root", ""); 
	$select_id = mysql_query("SELECT ".$mainTable['primaryKey']." from ".$dbArray['srcDB'].".test1");
	
	//Inserting One Employee At one Time in all the table
	while($row_id = mysql_fetch_array($select_id)){
		$old_employee_id = $row_id['id'];
		//Insert into the main table
		echo "\r\n\nEmployee Id ".$old_employee_id."\r\n\n";
		$mainQuery =   "INSERT INTO ".$dbArray['destDB'].".".$mainTable['tableName']."(".$mainTable['srcColumnName'].") 
						SELECT ".$mainTable['destColumnName']." from ".$dbArray['srcDB'].".".$mainTable['tableName']." 
					    where .".$mainTable['tableName'].".".$mainTable['primaryKey']." = ".$old_employee_id;
		$latest_query = mysql_query($mainQuery);
		
		if($latest_query){
			
			//Latest Employee Id
			$latest_employee_id = mysql_insert_id();
			$msg = "Old Employee Id - ".$old_employee_id."\r\n\n Migrated to New Employee Id - ".$latest_employee_id."\r\n\n";
			msg_log($msg,$old_employee_id);			
			//Insert into sub tables and update the employee id with latest employee id
			$subQuery1 =  "INSERT INTO ".$dbArray['destDB'].".".$subTable1['tableName']."(".$subTable1['srcColumnName'].") 
						   SELECT ".$latest_employee_id.",".$subTable1['destColumnName']." from ".$dbArray['srcDB'].".".$subTable1['tableName']." 
						   where .".$subTable1['tableName'].".".$subTable1['foreignKey'][0]." = ".$old_employee_id;					
			$subTableCopyQuery1 = mysql_query($subQuery1);
			
			if($subTableCopyQuery1){
				$msg = "\r\n\nSub Table : test2 migrated Successfully\r\n\n";
				echo $msg;
				msg_log($msg,$old_employee_id);
			}else{
				$msg = "Sub Table : test2 not migrated successfully ".mysql_error()."\r\n\n";				 
				echo $msg;
				msg_log($msg,$old_employee_id);
			}			
			
		}else{
			  $msg =  "\r\n\nMain Table : test1 not migrated successfully ".mysql_error()."\r\n\n";
			  echo $msg;
			  msg_log($msg,$old_employee_id);
		 }
	}	 
 
 
function msg_log($log_msg,$log_id)
{
    $log_filename = "log_".$log_id.".log";
    if (!file_exists('log')) 
    {
        // create directory/folder uploads.
        mkdir('log', 0777, true);
		
    }
    $log_file_data = 'log/'  . $log_filename;
    file_put_contents($log_file_data, $log_msg . "\r\n\n", FILE_APPEND);
}

?>