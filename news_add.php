<?php $page_name = pathinfo($_SERVER['PHP_SELF'],PATHINFO_FILENAME);?>
<?php 
require_once __DIR__ . '/top_all.php';
?>
<?php
	
	$position = "";
	$audience = "";
	$title = "";
	$content = "";
	$status = "";
	
	if ($_SERVER['REQUEST_METHOD'] == 'GET'){
		if (isset ($_GET['id'])) {
			// editing
			$id = $_GET ['id'];
			$article = News::readArticle($id);
			$action = "edit";
		} else {
			// adding
			$article = new News();
			$action = "add";
			if (isset ($_GET['pos'])) {
				$article->setPosition($_GET['pos']);
			}
		}
		
	}
	
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$position = $_POST ['position'];
		$audience = 1;
		$title = $_POST['title'];
		$content = $_POST['content'];
		$status = $_POST['status'];	
		
		
		if ( $_POST ['action'] == "edit") {
			$id = $_POST['id'];
			news::editArticle($id,$position,$audience,$title,$content,$status);
		} else if ( $_POST ['action'] == "add"){	
			news::createArticle($position,$audience,$title,$content,$status);
		}
		
		header("Location: ". config::url() . user::getLinkPath('news_review'));
	}
?>
<!DOCTYPE HTML>
<html>
    <head>
        
        <?php require_once 'head_all.php';?>
        
        <title>Add News - <?php echo config::site_title() ?></title>
    </head>
    <body>
    	
        <?php include 'navigation_bar.php';?>
    	
    	<div class="container form-container">
    		<form method='post' action='<?php echo $_SERVER['PHP_SELF'];?>' role="form" class="form-horizontal">
    			<input type='text' name='id' value='<?php echo $article->getId(); ?>' hidden='hidden'>
    			<input type='text' name='action' value='<?php echo $action ?>' hidden='hidden'>
    			<div class="form-group">
    				<label for="position"> Position/Column: </label>
	    			<label class="radio-inline"><input type="radio" name="position" value="<?php echo news::leftPosValue?>" <?php if ($article->getPosition() == news::leftPosValue) {echo "checked";} ?>>Left</label>
					<label class="radio-inline"><input type="radio" name="position" value="<?php echo news::centerPosValue?>" <?php if ($article->getPosition() == news::centerPosValue){echo "checked";}?>>Center</label>
					<label class="radio-inline"><input type="radio" name="position" value="<?php echo news::rightPosValue?>" <?php if ($article->getPosition() == news::rightPosValue){echo "checked";}?>>Right</label>
					<label class="radio-inline"><input type="radio" name="position" value="<?php echo news::bottomPosValue?>" <?php if ($article->getPosition() == news::bottomPosValue){echo "checked";}?>>Bottom</label>
	    		</div>
	    		<div class="form-group">
	    			<label for="title">Article Title:</label>
    				<input type="text" class="form-control" name="title" value="<?php echo $article->getTitle();?>">
	    		</div>
	    		<div class="form-group">
					<label for="content">Content:</label>
					<textarea class="form-control" rows="5" name="content"><?php echo $article->getText();?></textarea>
				</div>
				<div class="form-group">
    				<label for="status"> Status: </label>
	    			<label class="radio-inline"><input type="radio" name="status" value="active" <?php if ($article->getStatus() == "active"){echo "checked";}?>>Active</label>
					<label class="radio-inline"><input type="radio" name="status" value="hidden" <?php if ($article->getStatus() == "hidden"){echo "checked";}?>>Hidden</label>
	    		</div>
	    		
				<div>
					<a href="<?php echo config::url() . user::getLinkPath('news_review')?>" class="btn btn-danger">Cancel</a>
					<button type="submit" class="btn btn-success pull-right">Submit</button>
				</div>
			</form>
    	</div>
    	
        <?php include 'footer.php';?>
        
	</body>
</html>