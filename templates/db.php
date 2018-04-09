<?php
	$host="localhost"; // Host name 
	$username = "andreglo_main";
    $password = "yTDK7n{G-nd?";
    $db_name = "andreglo_scds";

    // Connect to server and select databse.
	mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
	mysql_select_db("$db_name")or die("cannot select DB");
?>