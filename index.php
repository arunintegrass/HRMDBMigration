<?php

 $con = mysql_connect("localhost", "root", "");
 $db = mysql_select_db("fobesshrm_stage",$con);
 $query = mysql_query("show tables");
while($row = mysql_fetch_array($query)){
	$tbname = $row[0];
	echo "<table border='1'><tr><td colspan='5'>".$tbname."</td></tr>";
	echo "<tr><th>Field Name</th><th>Type</th><th>Key</th><th>Null</th><th>Default</th></tr>";
	$query1 = mysql_query("describe ".$tbname);
	while($row1 = mysql_fetch_array($query1)){
		echo "<tr><td>".$row1[0]."</td><td>".$row1[1]."</td><td>".$row1[3]."</td><td>".$row1[2]."</td><td>".$row1[4]."</td></tr>";
	}	
	echo "</table><br><br><br><br>";	
	
}

 
 

?>