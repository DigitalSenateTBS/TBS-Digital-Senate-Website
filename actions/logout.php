<?php $page_name = pathinfo($_SERVER['PHP_SELF'],PATHINFO_FILENAME);

	include_once __DIR__ . '/../top_all.php';

	unset($_SESSION['sv_user']);
	header("Location: ". config::url() . user::getLinkPath('login'));
	exit();
?>