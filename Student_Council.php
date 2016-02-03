<?php require_once 'top_all.php';?>

<!DOCTYPE HTML>
<html>
    <head>
    
    <?php require_once 'head_all.php';?>
    
    <style>
        .jumbotron {
            background-image:url('images/school.JPG');
        }
    </style>
        <title>Student Council - <?php echo config::site_title() ?></title>
    </head>
    
    <body>
    
    <?php include 'navigation_bar.php';?>

        <div class="jumbotron">
          <div class="container">
            <h1>TBS Student Council</h1>
            <p>See what they are doingS!</p>
          </div>
        </div>
        
    <?php include 'footer.php';?>
      
    </body>
</html>