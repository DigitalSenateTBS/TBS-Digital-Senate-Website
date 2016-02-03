<?php
	include_once __DIR__ . '/../top_all.php';

	$id = "";
	$action = "";
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (isset ($_POST['articleId'])) {
			$id = $_POST['articleId'];
		}
		if (isset ($_POST['articleAction'])) {
			$action = $_POST['articleAction'];
		} else {
			header("Location: ". config::url() . "/news_review.php");
		}
		
		if ($action == "moveUp"){
			news::moveArticle($id,"up");
		}
		if ($action == "moveDown"){
			news::moveArticle($id,"down");
		}
		if ($action == "edit"){
			header("Location: ". config::url() . "/news_add.php?id=" . $id);
			exit;
		}
		if ($action == "toggleHide"){
			news::toggleHide($id);
		}
		if ($action == "delete"){
			news::deleteArticle($id);
		}
	}

	header("Location: " . config::url() . "/news_review.php");
?>