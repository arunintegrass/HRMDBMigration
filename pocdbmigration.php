<?php

	//Database Array
	$dbArray = ["srcDB"=>"check1","destDB"=>"check2"];		
	$carriageReturn = "\r\n";
	$br = "<br>";
	
	//Main Table Array - Table - test1 
	$mainTable  = [
				   "tableName"=>"test1",
				   "srcColumnName"=>"name,created_by,created_at",
				   "destColumnName"=>"name,created_by,created_at", 
				   "columnArray"=>array('name','created_by','created_at'),
				   "primaryKey"=>"id",
				   "foreignKey"=>array('')
				  ];	
				  
	//Relation Table (or) Sub Table Array - Table 1 - test2 
	$subTableArray  = [
						array(
						   "tableName"=>"test2",
						   "srcColumnName"=>"user_id,address1,address2",
						   "destColumnName"=>"address1,address2", 
						   "columnArray"=>array('name','created_by','created_at'),
						   "primaryKey"=>"id",
						   "foreignKey"=>array('user_id')
						),
					 ];	
				  
				  
	/*echo ".$." ."<br>".$mainTable['tableName'];echo "<br>".$mainTable['columnName'];	echo "<br>".$mainTable['columnArray'][0];	echo "<br>".$mainTable['primaryKey'];	echo "<br>".$mainTable['foreignKey'][0];exit;*/
	
	$con = mysql_connect("localhost", "root", ""); 
	$select_id = mysql_query("SELECT ".$mainTable['primaryKey']." from ".$dbArray['srcDB'].".test1");
	
	//Inserting One Employee At one Time in all the table
	while($row_id = mysql_fetch_array($select_id)){
		$old_employee_id = $row_id['id'];
		
		//Insert into the main table
		$msg = "Old Employee Id - ".$old_employee_id.$carriageReturn;	
		msg_log($msg,$old_employee_id);	
		
		$mainQuery =   "INSERT INTO ".$dbArray['destDB'].".".$mainTable['tableName']."(".$mainTable['srcColumnName'].") 
						SELECT ".$mainTable['destColumnName']." from ".$dbArray['srcDB'].".".$mainTable['tableName']." 
					    where .".$mainTable['tableName'].".".$mainTable['primaryKey']." = ".$old_employee_id;
		$latest_query = mysql_query($mainQuery);
		
		if($latest_query){
			
			//Latest Employee Id
			$latest_employee_id = mysql_insert_id();
			$msg = $carriageReturn."Migrated to New Employee Id - ".$latest_employee_id.$carriageReturn;
			
			msg_log($msg,$old_employee_id);	

			for($i=0;$i<count($subTableArray);$i++){
				
				//Insert into sub tables and update the employee id with latest employee id
				$subQuery1 =  "INSERT INTO ".$dbArray['destDB'].".".$subTableArray[$i]['tableName']."(".$subTableArray[$i]['srcColumnName'].") 
							   SELECT ".$latest_employee_id.",".$subTableArray[$i]['destColumnName']." from ".$dbArray['srcDB'].".".$subTableArray[$i]['tableName']." 
							   where .".$subTableArray[$i]['tableName'].".".$subTableArray[$i]['foreignKey'][0]." = ".$old_employee_id;					
				$subTableCopyQuery1 = mysql_query($subQuery1);
				
				if($subTableCopyQuery1){
					$msg = "\r\n\nSub Table ".($i+1)." : ".$subTableArray[$i]['tableName']." migrated Successfully\r\n\n";
					msg_log($msg,$old_employee_id);
				}else{
					$msg = "Sub Table ".($i+1)." : ".$subTableArray[$i]['tableName']." not migrated successfully ".mysql_error().$carriageReturn;				 
					msg_log($msg,$old_employee_id);
				}
			}	
			
		}else{
			  $msg =  "\r\n\nMain Table : ".$mainTable['tableName']." not migrated successfully ".mysql_error().$carriageReturn;
			  msg_log($msg,$old_employee_id);
		 }
	}	 
 
 
function msg_log($log_msg,$log_id)
{
	$carriageReturn = "\r\n";
	$br = "<br>";
    $log_filename = "log_".$log_id.".log";
    if (!file_exists('log')) 
    {
        // create directory/folder uploads.
        mkdir('log', 0777, true);
		
    }
    $log_file_data = 'log/'  . $log_filename;
    file_put_contents($log_file_data, $log_msg . $carriageReturn, FILE_APPEND);
	echo $log_msg.$br;
}

?>