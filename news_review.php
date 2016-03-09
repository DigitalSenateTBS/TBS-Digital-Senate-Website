<?php $page_name = pathinfo($_SERVER['PHP_SELF'],PATHINFO_FILENAME);?>
<?php 
require_once __DIR__ . '/top_all.php';
?>

<!DOCTYPE HTML>
<html>
    <head>
        
        <?php require_once 'head_all.php';?>
        
        <title>Review News - <?php echo config::site_title() ?></title>
 		<script>
			function actionCall (action, id, position) {
				var svc = new SV.Webservice ();
				svc.url = "<?php echo config::url() . user::getLinkPath('news_actions');?>";
				svc.type = 'POST';
				svc.title = "News";
				svc.successFunction = function (result, params) {$('#tab' + params.articlePosition).html(result.new_html);};
				svc.addParam ('articleId', id);
				svc.addParam ('articleAction', action);
				svc.addParam ('articlePosition', position )
				svc.callService();
			}

			function confirmDelete (id,position){
				var ok_function = "actionCall('delete'," + id + "," + position + ");";
				warningModal("Warning","Are you sure you want to delete?", ok_function,"Delete");
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
			  <li class="pull-right"><a href="<?php echo config::url(). user::getLinkPath('news_add')?>">Add an Article</a></li>
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
		
		</div>
			  
        <?php include 'footer.php';?>
        
	</body>
</html>