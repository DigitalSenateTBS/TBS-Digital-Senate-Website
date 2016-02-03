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
                          Name <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>
                      </th>
                      <th>
                          Subject
                      </th>
                      <th>
                          Email
                      </th>
                </tr>
              <?php 
              
              	$db = svdb::getInstance();
              	
              	$query = "SELECT u.name, u.subject, u.email
						 FROM sv_teachers_contacts u ;";
    			
    			$result = $db->query($query);
 
    			$num = $result->numRows();
    			
    			for($i = 0; $i < $num; $i++){
    				$row = $result->fetchAssoc();
    				
    				$name = $row['name'];
    				$subject = $row ['subject'];
    				$email = $row ['email'];
    				
    				echo"<tr>";
            			echo "<td>" . $name . "</td>";
            			echo "<td>" . $subject . "</td>";
            			echo "<td> <a href:'mailto:" . $email . "'>" . $email . "</td>";
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