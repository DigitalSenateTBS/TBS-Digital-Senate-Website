<?php $page_name = pathinfo($_SERVER['PHP_SELF'],PATHINFO_FILENAME);?>
<?php require_once 'top_all.php';?>

<!DOCTYPE HTML>
<html>
    <head>
        
        <?php require_once 'head_all.php';?>
        
    <style>
        .jumbotron {
            background-image: url(images/school.jpg);
        }
        
    </style>
        
        <title>Survey - <?php echo config::site_title() ?></title>
    </head>
    <body>
        <?php include 'navigation_bar.php';?>
   
    <div class="jumbotron">
      <div class="container">
        <h1>Survey</h1>
        <p>Please take this 1 min survey about technology in our school</p>
          
      </div>
    </div> 

    <div class="learn-more">
	  	<center>
<!-- 		  <script>(function(t,e,n,o){var c,s,i;t.SMCX=t.SMCX||[],e.getElementById(o)||(c=e.getElementsByTagName(n),s=c[c.length-1],i=e.createElement(n),i.type="text/javascript",i.async=!0,i.id=o,i.src=["https:"===location.protocol?"https://":"http://","widget.surveymonkey.com/collect/website/js/rowmokMKYcjkzQUuGNBNUZixnqRPzgtp2A0IxNMIFEn_2BVkdSjZpuW1WM2kzVU4LJ.js"].join(""),s.parentNode.insertBefore(i,s))})(window,document,"script","smcx-sdk");</script><a style="font: 12px Helvetica, sans-serif; color: #999; text-decoration: none;" href=https://www.surveymonkey.com/mp/customer-satisfaction-surveys/> Create your own user feedback survey </a>
width="100%" maxwidth="1000px" height="2736" -->    	
			<iframe scrolling="no" class="survey-frame" src="https://www.surveymonkey.com/r/9W5X6GC" ></iframe>
		</center>
	</div>
        
    <?php include 'footer.php';?>
        
  </body>
</html>
