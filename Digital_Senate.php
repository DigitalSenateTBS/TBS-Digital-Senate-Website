<?php $page_name = pathinfo($_SERVER['PHP_SELF'],PATHINFO_FILENAME);?>
<?php require_once 'top_all.php';?>

<!DOCTYPE HTML>
<html>
    <head>
    
    <?php require_once 'head_all.php';?>
        
    <style>
        .jumbotron {
            background-image: url('images/school.JPG');
        }
        .title {
            font-size: 8;
            font-family:'Shift', sans-serif; 
            color: darkblue;
            margin-left: 50px; 
}
        .info {
            margin-left:20px;
            font-family:'Shift',sans-serif;
            font-size:15px;
}
    </style>
        <title>Digital Senate - <?php echo config::site_title() ?></title>
    </head>
    
    <body>
    
    <?php include 'navigation_bar.php';?>

        <div class="jumbotron">
          <div class="container">
            <h1>TBS Digital Senate</h1>
            <p>Check out the digital uprising taking place in our school!</p>
          </div>
        </div>
       <h1 class="title"><b>Who Are We</b></h1> <br>
        <P class="info"> We are a technological communiy within the school created to help with the technology we have now.<br> </P>
        <!--Place holder for photo-->
        <div id="photo">
        photo
        </div>
        
    <?php include 'footer.php';?>
        
    </body>
</html>
