<?php
session_start();
if(isset($_REQUEST['lang'])) {
	//die($_SERVER['HTTP_REFERER']);
	if($_REQUEST['lang'] == "arabic"){
		$_SESSION['lang'] = "arabic";
	}
	else{
		$_SESSION['lang'] = "english";
	}
	header("Location:".$_SERVER['HTTP_REFERER']);
}
?>