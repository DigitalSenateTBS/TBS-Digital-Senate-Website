<!DOCTYPE html>
<html lang="en">
<head>
  <title>Home</title>
  <meta charset="utf-8">
  <meta name="format-detection" content="telephone=no"/>
  <link rel="icon" href="images/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="css2/grid.css">
  <link rel="stylesheet" href="css2/style.css">
  <link rel="stylesheet" href="css2/booking.css"/>
  <link rel="stylesheet" href="css2/jquery.fancybox.css"/>
  <link rel="stylesheet" href="css2/owl-carousel.css"/>

  <script src="js2/jquery.js"></script>
  <script src="js2/jquery-migrate-1.2.1.js"></script>

  <!--[if lt IE 9]>
  <html class="lt-ie9">
  <div style=' clear: both; text-align:center; position: relative;'>
    <a href="http://windows.microsoft.com/en-US/internet-explorer/..">
      <img src="images/ie8-panel/warning_bar_0000_us.jpg" border="0" height="42" width="820"
           alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."/>
    </a>
  </div>
  <script src="js/html5shiv.js"></script>
  <![endif]-->
  <script src='js/device.min.js'></script>
  <?php
		if (isset($_POST['login'])) 
		{
			echo"S";
    	}
    	?>
	
</head>

<body>
<div class="page">
  <!--========================================================
                            HEADER
  =========================================================-->
  <header class="vide" data-vide-bg="">
    <div class="container vide_content">
      <div class="brand">
        <img src="Student Vanguard Logo BIG.png" alt=""/>

        <h1 class="brand_name">
          <a href="./">
            The Student Vanguard
          </a>
        </h1>
        <p class="brand_slogan">
          The British School of Barra
        </p>
      </div>

      <h2> </h2>

      <h3> Log In</h3>
		<?php
			
		?>
      <form id="bookingForm" class="booking-form">
        <div class="tmInput">
          <input name="Name" placeHolder="Name" type="text" data-constraints='@NotEmpty @Required @AlphaSpecial'>
        </div>
        <div class="tmInput">
          <input name="Phone" placeHolder="Phone" type="text" data-constraints="@NotEmpty @Required @Phone">
        </div>
        <div class="booking-form_controls">
        	<a class="btn" data-type="submit" name="login"> Confirm </a>
      	<!--<script>
        		$(document).ready(function(){
    				$('.btn').click(function(){
        				var clickBtnValue = $(this).val();
        				var ajaxurl = 'ajax.php',
       					data =  {'action': clickBtnValue};
        				$.post(ajaxurl, data, function (response) {
            			alert("action performed successfully");
       					 });
    				});

				});
        	</script> --!>
        	
        </div>
      </form>
    </div>
  </header>
  <!--========================================================
                            CONTENT
  =========================================================-->
  <main>
    <section class="well">
      <div class="container center">
        <h2>
          Our creative team consists of the experts <br/>
          skilled in all areas of web design
        </h2>
        <hr/>
        <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et <br/>
           dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
           commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat
           nulla pariatur.
        </p>

        <div class="row">
          <div class="grid_4">
            <div class="lazy-img" style="padding-bottom:70.27027027027027%;">
              <img data-src="images/page-1_img01.jpg" src="#" alt=""/>
            </div>
            <h3 class="primary">Sam Kromstain</h3>

            <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
               etdolore magna aliqua. </p>
          </div>
          <div class="grid_4">
            <div class="lazy-img" style="padding-bottom:70.27027027027027%;">
              <img data-src="images/page-1_img02.jpg" src="#" alt=""/>
            </div>
            <h3 class="primary">Alan Smith</h3>

            <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
               etdolore magna aliqua. </p>
          </div>
          <div class="grid_4">
            <div class="lazy-img" style="padding-bottom:70.27027027027027%;">
              <img data-src="images/page-1_img03.jpg" src="#" alt=""/>
            </div>
            <h3 class="primary">John Franklin </h3>

            <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
               etdolore magna aliqua. </p>
          </div>
        </div>
      </div>
    </section>

    <section class="well well__ins1 center">
      <div class="container">
        <div class="row">
          <div class="grid_4">
            <div class="flaticon-toilets1"></div>
            <hr/>
            <h3>WE ARE CREATIVE</h3>

            <p>Lorem ipsum dolor sit amet conse ctetur <br/> adipisicing elit, sed do eiusmod tempor incididunt ut
               labore
               et </p>
          </div>
          <div class="grid_4">
            <div class="flaticon-coffee69"></div>
            <hr/>
            <h3>WE ARE MODERN</h3>

            <p>Lorem ipsum dolor sit amet conse ctetur <br/> adipisicing elit, sed do eiusmod tempor incididunt ut
               labore
               et </p>
          </div>
          <div class="grid_4">
            <div class="flaticon-hotel70"></div>
            <hr/>
            <h3>WE ARE EXPERTS</h3>

            <p>Lorem ipsum dolor sit amet conse ctetur <br/> adipisicing elit, sed do eiusmod tempor incididunt ut
               labore
               et </p>
          </div>
        </div>
      </div>
    </section>

    <section class="thumb-container">
      <div class="item">
        <a class="lazy-img thumb" style="padding-bottom:73.17073170731707%;" href="images/page-1_img04_original.jpg">
          <img data-src="images/page-1_img04.jpg" src="#" alt=""/>
          <span class="thumb_overlay"></span>
        </a>
      </div>
      <div class="item">
        <a class="lazy-img thumb" style="padding-bottom:73.17073170731707%;" href="images/page-1_img05_original.jpg">
          <img data-src="images/page-1_img05.jpg" src="#" alt=""/>
          <span class="thumb_overlay"></span>
        </a>
      </div>
      <div class="item">
        <a class="lazy-img thumb" style="padding-bottom:73.17073170731707%;" href="images/page-1_img06_original.jpg">
          <img data-src="images/page-1_img06.jpg" src="#" alt=""/>
          <span class="thumb_overlay"></span>
        </a>
      </div>
      <div class="item">
        <a class="lazy-img thumb" style="padding-bottom:73.17073170731707%;" href="images/page-1_img07_original.jpg">
          <img data-src="images/page-1_img07.jpg" src="#" alt=""/>
          <span class="thumb_overlay"></span>
        </a>
      </div>
      <div class="item">
        <a class="lazy-img thumb" style="padding-bottom:73.17073170731707%;" href="images/page-1_img08_original.jpg">
          <img data-src="images/page-1_img08.jpg" src="#" alt=""/>
          <span class="thumb_overlay"></span>
        </a>
      </div>
    </section>

  <!--========================================================
                            FOOTER
  =========================================================-->
  <footer>
    <div class = "footnote">
        <div class = "container-fluid">
            <div class="row align-center">
	  	        <div class="col-md-12">
                    <div class="pull-left">
                        <h6>Powered by SSP and The Digital Senates</h6>
                        <p>This is a non-licensed website created by students of The British School of Barra. Feel free to contact us at: digitalsenatebarra@britishschool.g12.br<p>
                    </div>
                    <div class="pull-right">
                        <img src="TBS_Logo.png">
                    </div>
                </div>
            </div>
        </div>
  </footer>
</div>

<script src="js/script.js"></script>
<!-- coded by Diversant -->
</body>
</html>