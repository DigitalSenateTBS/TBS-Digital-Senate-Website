<?php

$page_name = pathinfo($_SERVER['PHP_SELF'],PATHINFO_FILENAME);

require_once __DIR__ . '/../config.php';
require_once config::root_directory() . '/classes/classes.php';

$answer = array();

try {

	if ($_SERVER['REQUEST_METHOD'] != 'POST') {
		throw new Exception ('Invalid call');
	}

	session_start();

	if($_SESSION['sv_user'] == null){
		throw new Exception('User not logged');
	}

	if (! user::checkPermissionByPage($page_name, $_SESSION['sv_user']->getProfileId())) {
		throw new Exception('User does not have permission');
	}

	$profile = "";
	$permission = "";

	if (isset ($_POST['profile'])) {
		$profile = trim ($_POST['profile']);
	}
	if (isset ($_POST['permission'])) {
		$permission = trim ($_POST['permission']);
	}

	if ($profile == "" || $permission == "") {
		throw new Exception('Invalid call');
	}

	$new_permission = user::togglePermission($permission, $profile);
	
	$answer ['status'] = true;
	$answer ['new_permission'] = $new_permission;

} catch (Exception $e) {
	$answer ['status'] = false;
	$answer ['errorMsg'] = $e->getMessage();
}

header ('Content-Type: application/json');
echo json_encode ($answer);
?>