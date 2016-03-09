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

	$id = "";
	$name = "";
	$subject = "";
	$email = "";

	if (isset ($_POST['action'])) {
		$action = trim ($_POST['action']);
	}
	if (isset ($_POST['id'])) {
		$id = trim ($_POST['id']);
	}
	if (isset ($_POST['name'])) {
		$name = trim ($_POST['name']);
	}
	if (isset ($_POST['subject'])) {
		$subject = trim ($_POST['subject']);
	}
	if (isset ($_POST['email'])) {
		$email = trim ($_POST['email']);
	}
	
	if ($action == "") {
		throw new Exception('Invalid call');
	}
	
	if ($action == "edit") {
		
		if ($id == "") {
			throw new Exception('Invalid call');
		}
	
		$db = svdb::getInstance ();
		
		$query = "	UPDATE sv_teachers_contacts tc
	        			SET tc.name = ?,
							tc.subject = ?,
							tc.email = ?
	        			WHERE tc.id = ?;";
		
		$params = array();
		$params[] = $name;
		$params[] = $subject;
		$params[] = $email;
		$params[] = $id;
		
		$db->execSQLCmd($query,$params);
		
		$answer ['id'] = $id;
		$answer ['status'] = true;
	}
	
	if ($action == "add") {
		
		$db = svdb::getInstance ();
		
		$query = "	INSERT INTO sv_teachers_contacts (name,subject,email,site) values (?,?,?,?);";
		
		$params = array();
		$params[] = $name;
		$params[] = $subject;
		$params[] = $email;
		$params[] = $_SESSION['sv_user']->getSite();
		
		$db->execSQLCmd($query,$params);
		
		$answer ['id'] = $db->lastId();
		$answer ['status'] = true;
	}
	
	if ($action == "delete") {
		
		if ($id == "") {
			throw new Exception('Invalid call');
		}
		
		$db = svdb::getInstance ();
	
		$query = "	DELETE FROM sv_teachers_contacts WHERE id=" . $id . ";";
	
		$db->execSQLCmd($query);
	
		$answer ['status'] = true;
	}
} catch (Exception $e) {
	$answer ['status'] = false;
	$answer ['errorMsg'] = $e->getMessage();
}

header ('Content-Type: application/json');
echo json_encode ($answer);
?>