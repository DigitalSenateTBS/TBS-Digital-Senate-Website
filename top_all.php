<?php
	require_once __DIR__ . '/config.php';
	require_once config::root_directory() . '/classes/classes.php';
	session_start();
	
	if(!isset ($loginpage)){
		if($_SESSION['sv_user'] == null){
			header("Location: ". config::url() . "/");
			exit();
		}
	}
?>