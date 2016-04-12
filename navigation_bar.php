<?php 
	$db = svdb::getInstance ();
	
	$user_id = $_SESSION['sv_user']->getId();
	$user_profile_id = $_SESSION['sv_user']->getProfileId();
	
	$dropdown = false;
	
	$query = "	SELECT pg.page_name
				FROM sv_users u
				JOIN sv_profiles_permissions p on (p.profile_id = u.profile_id)
				JOIN sv_pages pg on (pg.page_permission = p.permission_id)
				WHERE pg.position = 3 and p.allow = 1 and u.id = ? ;";
	
	$params = array();
	$params[] = $user_id;
	
	$result = $db->query($query,$params);
	
	if ($result->hasRows()){
		$dropdown = true;
	}

?>
<div class="nav-header nav">
  <div class="container">
	<div class="col-md-2">
		<ul class = "logo">
			<li><a href="<?php echo config::url() . user::HomePageLink() ?>"><img src = "images/svlogo.png"></a></li>
		</ul>
	</div>
	<div class = "col-md-10 options">
		<ul class="pull-left">			
			<?php user::getLinks(1, $user_profile_id)?>
	  	</ul>
		<ul class="pull-right">		  
			<?php user::getLinks(2, $user_profile_id)?>
					  
		  <?php	
		  	if ($dropdown){
		  		echo"
			  		<li>
						<span class='dropdown'>
							<button class='button-glyphicon dropdown-toggle' type='button' data-toggle='dropdown'>
							<span class='glyphicon glyphicon-menu-hamburger'></span></button>
							<ul class='dropdown-menu dropdown-menu-right'>";
		  		
		  						user::getLinks(3, $user_profile_id);

				echo "		</ul>
						</span>
					</li>";  
			}
		  ?>
		</ul>
	</div>
  </div>
</div>