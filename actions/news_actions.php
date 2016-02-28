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
	$action = "";
	$pos = "";
	
	if (isset ($_POST['articleId'])) {
		$id = trim ($_POST['articleId']);
	}
	if (isset ($_POST['articleAction'])) {
		$action = trim ($_POST['articleAction']);
	}
	if (isset ($_POST['articlePosition'])) {
		$pos = trim ($_POST['articlePosition']);
	}
	
	if ($id == "" || $action == "" || $pos == "") {
		throw new Exception('Invalid call');
	}
	
	switch ($action) {
		case "moveUp":
			news::moveArticle($id,"up");
			break;
		case "moveDown":
			news::moveArticle($id,"down");
			break;
		case "toggleHide":
			news::toggleHide($id);
			break;
		case "delete":
			news::deleteArticle($id);
			break;
		default:
			throw new Exception ('Invalid action');
	}
	
	$answer ['status'] = true;
	$answer ['new_html'] = news::reviewArticlesTable($pos); 
	
} catch (Exception $e) {
	$answer ['status'] = false;
	$answer ['errorMsg'] = $e->getMessage();
}

header ('Content-Type: application/json');
echo json_encode ($answer);
?>