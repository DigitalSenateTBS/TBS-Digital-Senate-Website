<?php
	require_once __DIR__ . '/config.php';
	require_once config::root_directory() . '/classes/classes.php';
	require_once config::root_directory() . '/packages/password_compat/lib/password.php';
	session_start();
	
	if(!isset ($publicaccess)){
		if($_SESSION['sv_user'] == null){
			header("Location: ". config::url() . user::getLinkPath('login'));
			exit();
		}
				
		if (! user::checkPermissionByPage($page_name, $_SESSION['sv_user']->getProfileId())) {
			exit();
		}
	}
?>