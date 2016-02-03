<div class="nav-header nav">
  <div class="container">
	<div class="col-md-2">
		<ul class = "logo">
			<li><img src = "images/svlogo.png"></li>
		</ul>
	</div>
	<div class = "col-md-10 options">
		<ul class="pull-left">
			<li><a href="<?php echo config::url() ?>/main.php">Home</a></li>
			<li><a href="<?php echo config::url() ?>/news.php">News</a></li>
			<li><a href="<?php echo config::url() ?>/student_council.php">Student Council</a></li>
			<li><a href="<?php echo config::url() ?>/iris.php">IRIS</a></li>
			<li><a href="<?php echo config::url() ?>/digital_senate.php">Digital Senate</a></li>
	  	</ul>
		<ul class="pull-right">
		  <li><a href="<?php echo config::url() ?>/contact_us.php">Contacts</a></li>
		  <!-- <li><a href="<?php echo config::url() ?>/about_us.php">About Us</a></li> -->
		  <?php if($_SESSION['sv_user']->getProfileId()== 1){echo "<li><a href='". config::url() . "/news_review.php'>News Review</a></li>";}?>
		  <li><a href="<?php echo config::url() ?>/actions/logout.php">Log Out</a></li>
		</ul>
	</div>
  </div>
</div>