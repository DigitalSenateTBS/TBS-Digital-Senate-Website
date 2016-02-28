<?php $page_name = pathinfo($_SERVER['PHP_SELF'],PATHINFO_FILENAME);?>
<?php require_once 'top_all.php';?>

<!DOCTYPE HTML>
<html>
    <head>

        <?php require_once 'head_all.php';?>
        
        <style>
	        .news-header {
			    background: url(images/newspapers.jpg);
			}
        
        </style>
        
        
        <title>News - <?php echo config::site_title() ?></title>
        
    </head>
    
    <body>
    
    <?php include 'navigation_bar.php'?>   
        
        <div class="news-main">
            <div class = "news-header">
                <h1> News </h1>
            </div>
                <div class = "daily-bulletin">
                <h3> Daily Bulletin </h3>
             <!--   <p> Daily Bulletin may be found in pdf format<a href="db.pdf"> here.</a> </p> -->
            </div>
        </div>
        
        <div class="learn-more">
        	<div class="container-fluid">
        		<div class="row">
        			<div class="col-md-3">
        				<?php 
        					echo news::processArticles(news::leftPosValue)
        				?>
        			</div>
        			<div class="col-md-6">
        				<?php 
	        				echo news::processArticles(news::centerPosValue)
        				?>
        			</div>
        			<div class="col-md-3">
        				<?php 
							echo news::processArticles(news::rightPosValue)
        				?>
        			</div>
        		</div>
        		<div class="row">
        			<div class="col-md-12">
        				<?php 
							echo news::processArticles(news::bottomPosValue)
        				?>
        			</div>
        		</div>
        	</div>
        </div>        
        
    <?php include 'footer.php';?>
        
  	</body>
</html>