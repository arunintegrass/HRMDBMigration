<?php


function msg_log($log_msg,$filename)
{
	$carriageReturn = "\r\n";
	$br = "<br>";
    $log_filename = $filename.".log";
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