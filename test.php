<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<title>TESTE</title>
</head>

<body>

<?php

	require('database/classes.php');
	
	$aux = new Message();
	//$aux->readWebFile("goes");
	
	//$aux->get_info(43199);
	
	
	/*$list = $aux->get_catList();
	
	echo $list;
	*/
	$list = $aux->getSatsToMessage(1);
	date_default_timezone_set('Europe/London');
	$now = date_create();
	echo $now->getTimestamp();
	
	foreach($list as $aa){
		echo $aa['start_time']."<br>";
		$difs = $aa['start_time']-$now->getTimestamp();
		$dife = $aa['end_time']-$now->getTimestamp();
		if($difs < 3600){
			if($difs > 0){
				echo "Vai começar";
			}else if($dife > 0){
				echo "Vai acabar";
			}
		}
	}
	//echo $list;
	/*
	$list = $aux->get_info(39574);
	foreach($list as $a)
		echo $a."<br>";*/
?>
</body>
</html>