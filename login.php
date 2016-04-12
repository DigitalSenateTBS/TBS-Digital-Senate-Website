<?php 
$page_name = pathinfo($_SERVER['PHP_SELF'],PATHINFO_FILENAME);
$publicaccess = true;
//MEANS THAT ANYONE CAN ACCESS THIS PAGE IF THEY TYPE IT INTO THEIR BROWSER
//EXERT EXTREME CAUTION WITH THE CONTENTS OF THIS PAGE AS THEY ARE A SECURITY RISK
require_once __DIR__ . '/top_all.php';
?>

<?php
	
	$pwd = "";
	$wrongPwd = false;
	$no_connection = false;
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$pwd = $_POST['pwd'];
		
		try {
			$u = User::login ($pwd);
			$_SESSION["sv_user"] = $u;
			header("Location: ". config::url() . user::HomePageLink() );
			exit ();
		} catch (DbSqlException $e) {
			$no_connection = true;
		} catch (Exception $e) {
			$wrongPwd = true;
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Login - <?php echo config::site_title() ?></title>
<meta charset="utf-8">
<link rel="icon" href="images/sv.ico" type="image/x-icon">
<link rel="stylesheet" href="css/grid.css">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/booking.css" />
<script src="js/jquery.js"></script>
  
</head>

<body class="darkpage">
	<div class="page">
		<div class="container login_page">
			<div class="brand">
				<img src="images/svlogo.png" alt="" width="100px" />

				<h1 class="brand_name">The <?php echo config::site_title() ?></h1>
				<p class="brand_slogan">
					The British School Rio de Janeiro <br> Barra Site
				</p>
			</div>

			<form method='post' action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' class="login-form booking-form">
				<div class="tmInput<?php if($wrongPwd || $no_connection) { echo " invalid"; }?>">
					<input id="pwd" name="pwd" placeHolder="Password" type="password"
						data-constraints='@NotEmpty @Required @AlphaSpecial' autofocus>
						<?php 
							if($wrongPwd) { echo "<p class='invalid'> <strong> Invalid Password </strong> </p>"; }
							if($no_connection) { echo "<p class='invalid'> <strong> Error Connecting to Server </strong> </p>"; }
						?>
				</div>
				<div class="booking-form_controls">
					<a class="btn" onclick="$('form').submit();">Login</a>
				</div>
			</form>
		</div>
	</div>
	<!-- 
	<?php
	//if ($wrongPwd) { ?>
		<script>alert ('Invalid password');</script>
	<?php
	//}?>
	 -->
</body>
</html>