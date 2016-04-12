<?php $page_name = pathinfo($_SERVER['PHP_SELF'],PATHINFO_FILENAME);?>
<?php require_once 'top_all.php';?>

<!DOCTYPE HTML>
<html>
    <head>
    
    <?php require_once 'head_all.php';?>
        
    <style>
        .jumbotron {
            background-image:url('images/contacts.jpg');
        }
    </style>
        <title>Contacts - <?php echo config::site_title() ?></title>
    </head>
    
    <body>
    
    <?php include 'navigation_bar.php';?>

        <div class="jumbotron">
          <div class="container">
            <h1>Contacts</h1>
            <p>Find who you want to contact!</p>
          </div>
        </div>
        
        <div class="learn-more">
	  <div class="container">
		<div class="row">
	  	  <div class="col-md-12">
          	<table class="table table-bordered table-striped table-hover">
            	<tr>
                      <th>
                          Name <span class="caret" aria-hidden="true"></span>
                      </th>
                      <th>
                          Subject <span class="caret" aria-hidden="true"></span>
                      </th>
                      <th>
                          Email <span class="caret" aria-hidden="true"></span>
                      </th>
                </tr>
              <?php 
              	//TODO Be able to order results
              	$db = svdb::getInstance();
              	
              	$query = "SELECT tc.name, tc.subject, tc.email
						  FROM sv_teachers_contacts tc
						  WHERE site = ?;";
              	
              	$params = array();
              	$params[] = $_SESSION['sv_user']->getSite();
    			
    			$result = $db->query($query,$params);
 
    			$num = $result->numRows();
    			
    			for($i = 0; $i < $num; $i++){
    				$row = $result->fetchAssoc();
    				
    				$name = $row['name'];
    				$subject = $row ['subject'];
    				$email = $row ['email'];
    				
    				echo"<tr>";
            		echo "<td>" . $name . "</td>";
            		echo "<td>" . $subject . "</td>";
	    			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
							echo "<td><a href='mailto:" . $email . "'>" . $email . "</a></td>";
					} else {
							echo "<td>" . $email . "</td>";
					}
            		echo"</tr>";
    			}
              		
              
              ?>
              </table>
		  </div>
	    </div>
	  </div>
	</div>
        
    <?php include 'footer.php';?>
        
    </body>
</html>