<?php $page_name = pathinfo($_SERVER['PHP_SELF'],PATHINFO_FILENAME);?>
<?php require_once 'top_all.php';?>

<!DOCTYPE HTML>
<html>
    <head>
        
        <?php require_once 'head_all.php';?>
        
    <style>
        .jumbotron {
            background-image: url(images/school.JPG);
        }
        
    </style>
        
        <title><?php echo config::site_title() ?></title>
    </head>
    <body>
        <?php include 'navigation_bar.php';?>
   
    <div class="jumbotron">
      <div class="container">
        <h1>The Student Vanguard</h1>
        <p>A caring community, striving for excellence, where every individual matters.</p>
          
      </div>
    </div> 

    <div class="learn-more">
	  <div class="container">
		<div class="row">
	  	  <div class="col-md-4">
			<h3>News</h3>
			<p>See what is currently going on at TBS</p>
			<p><a href="<?php echo config::url()  . user::getLinkPath('news')?>">News</a></p>
		  </div>
		  <div class="col-md-4">
			<h3>The Digital Senate</h3>
			<p>Learn more about the digital uprising here at TBS!</p>
			<p><a href="<?php echo config::url() . user::getLinkPath('digital_senate')?>">Digital Senate</a></p>
	      </div>
		  <div class="col-md-4">
              <h3>Contacts</h3>
			<p>Find teacher`s emails!</p>
			<p><a href="<?php echo config::url()  . user::getLinkPath('contact_us')?>">See More</a></p>
		  </div>
	    </div>
	  </div>
	</div>
        
    <?php include 'footer.php';?>
        
  </body>
</html>