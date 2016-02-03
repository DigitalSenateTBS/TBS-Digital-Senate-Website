<?php
	include_once __DIR__ . '/../top_all.php';

	unset($_SESSION['sv_user']);
	header("Location: ". config::url() . "/");
	exit();
?>