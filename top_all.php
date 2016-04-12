<?php
	require_once __DIR__ . '/config.php';
	require_once config::root_directory() . '/classes/classes.php';
	require_once config::root_directory() . '/packages/password_compat/lib/password.php';
	session_start();
		
	if(!isset ($publicaccess)){
		if(!isset ($_SESSION['sv_user']) || $_SESSION['sv_user'] == null){
			header("Location: ". config::url() . "/login.php");
			exit();
		}
		
		//echo password_hash('', PASSWORD_DEFAULT);
		
		if (! user::checkPermissionByPage($page_name, $_SESSION['sv_user']->getProfileId())) {
			//TODO Make this code better - only provisional. Needs to redirect to error page,
			//     but also need to think about the case when its tbsvanguard.com/
			
			header("Location: ". config::url() . user::HomePageLink());
			//echo "You do not have access to this page.";
			//exit();
		}
	}
?>