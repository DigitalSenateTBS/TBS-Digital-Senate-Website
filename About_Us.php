<?php $page_name = pathinfo($_SERVER['PHP_SELF'],PATHINFO_FILENAME);?>
<?php $page_permission = 2?>
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
    
    <title>About Us - <?php echo config::site_title() ?></title>
    
        <script src="https://maps.googleapis.com/maps/api/js"></script>
        <script>
          function initialize() {
        var mapCanvas = document.getElementById('map');
        var mapOptions = {
          center: new google.maps.LatLng(-22.995850, -43.393564),
          zoom: 8,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(mapCanvas, mapOptions)
      }
      google.maps.event.addDomListener(window, 'load', initialize);
        </script>
        
    </head>
    
    <body>
    
	<?php include 'navigation_bar.php';?>
        
        <div class="jumbotron">
      <div class="container">
        <h1>About Us</h1>
        <p>Find out more!</p>
          
      </div>
    </div> 
    

                <!-- need three pages, HTML, for nav2 -->
            <div id = "contentMenu" class = "left">
            <li class= "parent">                         
                <ul>
                <li> <p>About</p></li>
                    <li> <a href = "About_Us_History.html">History</a></li>
                    <li> <a href = "About_Us_Facilities.html"> Facilities</a></li>
                </ul>
                </li>
                <div id = "contentText">
                    <h1> Contact </h1>
                        <h2><a href:"mailto:edu@britishschool.g12.br">edu@britishschool.g12.br</a></h2>
                        <h2><a href:"mailto:admissions@britishschool.g12.br">admissions@britishschool.g12.br</a></h2>
                    <h1>Barra Location</h1>
                    <h2>Rua Mario Autuori,100,Barra</h2>
                    <h2>Riode Janeiro,RJ,Brazil</h2>
                    <h2>CEP 22793-270</h2>  
                    <h2>Tel.: 55(21)3329-2854</h2>
                    <h2><a href = "http://www.britishschool.g12.br/wp-content/uploads/2013/10/TBS-Barra-Unit.pdf">Directions</a></h2>
                </div>
            </div>   
                
        <div id="map">
         </div>
        
    <?php include 'footer.php';?>        
        
    </body>
</html>