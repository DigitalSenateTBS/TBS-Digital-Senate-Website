<?php 
require_once __DIR__ . '/top_all.php';
?>

<!DOCTYPE HTML>
<html>
    <head>
        
        <?php require_once 'head_all.php';?>
        
        <title>Review News - <?php echo config::site_title() ?></title>
 		<script>
			function buttonClick (action, id) {
				$('#articleId').val(id);
				$('#articleAction').val (action);
				$('#formArticleAction').submit();
			}
 		</script>       
    </head>
    <body>
    	
        <?php include 'navigation_bar.php';?>
        
    	<div class='container review-container'>
    	
	    	<ul class="nav nav-tabs" id='mytab'>
			  <li class="active"><a data-toggle="tab" href="#tab<?php echo news::leftPosValue?>">Left</a></li>
			  <li><a data-toggle="tab" href="#tab<?php echo news::centerPosValue?>">Center</a></li>
			  <li><a data-toggle="tab" href="#tab<?php echo news::rightPosValue?>">Right</a></li>
			  <li><a data-toggle="tab" href="#tab<?php echo news::bottomPosValue?>">Bottom</a></li>
			  <li class="pull-right"><a href="<?php echo config::url()?>/news_add.php">Add an Article</a></li>
			</ul>
			
			<div class="tab-content">
			  <div id="tab<?php echo news::leftPosValue?>" class="tab-pane fade in active">
			   	<?php echo news::reviewArticlesTable(news::leftPosValue); ?>
			  </div>
			  <div id="tab<?php echo news::centerPosValue?>" class="tab-pane fade">
			    <?php echo news::reviewArticlesTable(news::centerPosValue); ?>
			  </div>
			  <div id="tab<?php echo news::rightPosValue?>" class="tab-pane fade">
			    <?php echo news::reviewArticlesTable(news::rightPosValue); ?>
			  </div>
			  <div id="tab<?php echo news::bottomPosValue?>" class="tab-pane fade">
			    <?php echo news::reviewArticlesTable(news::bottomPosValue); ?>
			  </div>
			</div>
			
			<form action='<?php echo config::url(); ?>/actions/toggle_article_hide.php' method='post' id='formArticleAction'><input type='text' id='articleId' name='articleId' value='' hidden='hidden'><input type='text' id='articleAction' name='articleAction' value='' hidden='hidden'></form>
			
		
		</div>
			  
        <?php include 'footer.php';?>
        
	</body>
</html>