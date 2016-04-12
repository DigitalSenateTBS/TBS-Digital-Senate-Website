<?php $page_name = pathinfo($_SERVER['PHP_SELF'],PATHINFO_FILENAME);?>
<?php 
require_once __DIR__ . '/top_all.php';
?>

<!DOCTYPE HTML>
<html>
    <head>
        
        <?php require_once 'head_all.php';?>
        
        <title>Permission Profiles - <?php echo config::site_title() ?></title>
 		<script>
			function buttonClick (action, id) {
				$('#articleId').val(id);
				$('#articleAction').val (action);
				$('#formArticleAction').submit();
			}

			function updateTable (result,params) {
				if (result.new_permission == true){
					var new_html = "<span class='glyphicon glyphicon-ok action-link'></span>"
				} else {
					var new_html = "<span class='glyphicon glyphicon-remove action-link'></span>"
				}
				//should it have animation or not???
				$('#cell' + params.profile + "-" + params.permission).fadeOut(function(){$('#cell' + params.profile + "-" + params.permission).html(new_html);});
				$('#cell' + params.profile + "-" + params.permission).fadeIn();	
				//$('#cell' + params.profile + "-" + params.permission).html(new_html);
			}

			function togglePermission (profile, permission) {
				var svc = new SV.Webservice ();
				svc.url = "<?php echo config::url() . user::getLinkPath('toggle_permissions');?>";
				svc.type = 'POST';
				svc.title = "Permissions";
				svc.successFunction = updateTable;
				svc.addParam ('profile', profile);
				svc.addParam ('permission', permission);
				svc.callService();
			}
 		</script>       
    </head>
    <body>
    	
        <?php include 'navigation_bar.php';?>
        
    	<div class='container review-container'>
    		<table class="table">
    			<?php 
    			$db = svdb::getInstance();
    			
            	echo "<tr>";
                	echo "<th></th>";
		
					$query = "SELECT u.permission_description
							 FROM sv_permissions u ;";
	    			
	    			$result = $db->query($query);
	 
	    			$num_permissions = $result->numRows();
	    			
	    			for($i = 0; $i < $num_permissions; $i++){
	    				$row = $result->fetchAssoc();
	    				
					echo "<th>";
                    	echo $row ['permission_description'];
                    echo "</th>";
                    
	    			}
	    			
               echo "</tr>";
              	
              	$query = "SELECT u.profile_description
						 FROM sv_profiles u ;";
    			
    			$result = $db->query($query);
 
    			$num_profiles = $result->numRows();
    			
    			for($i = 1; $i <= $num_profiles; $i++){
    				$row = $result->fetchAssoc();
    				
    				echo"<tr>";
	    				echo "<td>" . $row['profile_description'] . "</td>";
	    				
	    				for($k = 1; $k <= $num_permissions; $k++){
	    					if (user::checkPermission($i,$k)){
	    						$glyphicon = "ok";
	    					} else {
	    						$glyphicon = "remove";
	    					}
	    					if ($i == 1 & $k == 1){
	    						echo "<td><a id='cell" . $i . "-" . $k . "' title='Toggle Permission'><span class='glyphicon glyphicon-" . $glyphicon . " disabled-link'></span></a></td>";
	    					} else {
	    						echo "<td><a id='cell" . $i . "-" . $k . "' onclick=\"togglePermission(" .$i . "," . $k . ");\" title='Toggle Permission'><span class='glyphicon glyphicon-" . $glyphicon . " action-link'></span></a></td>";
	    					}
	    				}
    				echo"</tr>";
    				
    			}

              ?>
              </table>
              
    		
		
		</div>
			  
        <?php include 'footer.php';?>
        
	</body>
</html>
