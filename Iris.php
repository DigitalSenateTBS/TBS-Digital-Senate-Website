<?php require_once 'top_all.php';?>

<!DOCTYPE HTML>
<html>
    <head>
    
    <?php require_once 'head_all.php';?>
       
    <style>
        .jumbotron {
         background-image: url("images/iris.jpg")
        }
    </style>
        <title>Iris - <?php echo config::site_title() ?></title>
    </head>
    
    <body>
    
    <?php include 'navigation_bar.php';?>

                <div class = "jumbotron">
                    <div class = "container">
                    <div class = "iris-headline">
                    <h1> IRIS </h1>
                    </div>
                </div>
            </div>
        
        <div class = "background-iris">
            <div class = container>
                <h3> IRIS Editions </h3>
            </div>
        </div>
        
        <div class = "comments-iris">
            <div class = "container">
                <h3> Editors' Comments</h3>
            </div>
        </div>
        
        
    <?php include 'footer.php';?>
        
    </body>
</html>