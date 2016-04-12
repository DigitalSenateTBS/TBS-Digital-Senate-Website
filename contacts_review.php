<?php $page_name = pathinfo($_SERVER['PHP_SELF'],PATHINFO_FILENAME);?>
<?php 
require_once __DIR__ . '/top_all.php';
?>

<!DOCTYPE HTML>
<html>
    <head>
        
        <?php require_once 'head_all.php';?>
        
        <title>Edit Contacts - <?php echo config::site_title() ?></title>
 		<script>
 			function validateEmail(email) {
 				var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
 				  return regex.test(email);
 			}
 			
 			function hasNumber(string) {
 				  return (/\d/.test(string));
 			}
				
			function validateInfo(name,subject,email){
				var errors = [];
				if (name == ""){
					errors.push('The name is empty');
				}
				if (hasNumber(name)){
					errors.push('The name contains numbers');
				}
				if (subject == ""){
					errors.push('The subject is empty');
				}
				if (email == ""){
					errors.push('The email is empty');
				} else if (!validateEmail(email)){
					errors.push('The email is not a valid email address');
				}
				return errors;
			}
			
	 		function appendForm () {
		 		last_row_id++;
				var row_id = last_row_id;
	 			var new_html = "<tr id='row" + row_id + "'><form><td><input id='input" + row_id + "-1' type='text' class='form-control' name='title' value=''></td><td><input id='input" + row_id + "-2' type='text' class='form-control' name='title' value=''></td><td><input id='input" + row_id + "-3' type='text' class='form-control' name='title' value=''></td><td><a onclick=\"callWebservice(" + row_id + ",'','createcontact')\" title='Save'><span class='glyphicon glyphicon-ok action-link'></span></a></td><td></td></form></tr>";
				$('#contacts_table').append(new_html);
				$('#row' + row_id)
				 .find('td')
				 .wrapInner('<div style="display: none;" />')
				 .parent()
				 .find('td > div')
				 .slideDown(700, function(){

				  var $set = $(this);
				  $set.replaceWith($set.contents());

				 });
			}
			
	 		function createContact (row_id,name,subject,email) {
				var svc = new SV.Webservice ();
				svc.url = "<?php echo config::url() . user::getLinkPath('edit_contacts');?>";
				svc.type = 'POST';
				svc.title = "Contact Addition";
				svc.successFunction = revertTable;
				svc.addParam ('action', 'add');
				svc.addParam ('row_id', row_id);
				svc.addParam ('name', name);
				svc.addParam ('subject', subject);
				svc.addParam ('email', email);
				svc.callService();
			}

	 		function removeRow (results,params) {
 				$('#row' + params.row_id)
 				 .find('td')
 				 .wrapInner('<div style="display: block;" />')
 				 .parent()
 				 .find('td > div')
 				 .slideUp(700, function(){

 				  $(this).parent().parent().remove();

 				 });

 				//$('#row' + params.row_id).remove();
			}
			
	 		function deleteContact (row_id,id) {
				var svc = new SV.Webservice ();
				svc.url = "<?php echo config::url() . user::getLinkPath('edit_contacts');?>";
				svc.type = 'POST';
				svc.title = "Contact Addition";
				svc.successFunction = removeRow;
				svc.addParam ('action', 'delete');
				svc.addParam ('row_id', row_id);
				svc.addParam ('id', id);
				svc.callService();
			}

			function confirmDelete (row_id,id,name,subject,email){

				var errors = 0;
				if (name == ""){
					errors++;
				}
				if (subject == ""){
					errors++;
				}
				if (email == ""){
					errors++;
				}
				
				if (errors>0){
					deleteContact(row_id,id)
				} else {
					var ok_function = "deleteContact(" + row_id + "," + id + ");";
					warningModal("Warning","Are you sure you want to delete?", ok_function,"Delete");
				}
			}
	
			function revertTable (results,params) {
				var new_html = "<td>" + params.name + "</td><td>" + params.subject + "</td><td>" + params.email + "</td><td> <a onclick=\"setEdit(" + params.row_id + "," + results.id + ",'" + params.name + "','" + params.subject + "','" + params.email + "');\" title='Edit'><span class='glyphicon glyphicon-pencil action-link'></span></a></td><td><a onclick=\"confirmDelete(" + params.row_id + "," + results.id + ",'" + params.name + "','" + params.subject + "','" + params.email + "');\" title='Delete'><span class='glyphicon glyphicon-remove action-link'></span></a> </td>";
				$('#row' + params.row_id).fadeOut(function(){$('#row' + params.row_id).html(new_html);});
				$('#row' + params.row_id).fadeIn();
				
			}

			function setEdit (row_id,id,name,subject,email) {
				var new_html = "<form><td><input id='input" + row_id + "-1' type='text' class='form-control' name='title' value='" + name + "'></td><td><input id='input" + row_id + "-2' type='text' class='form-control' name='title' value='" + subject + "'></td><td><input id='input" + row_id + "-3' type='text' class='form-control' name='title' value='" + email + "'></td><td><a onclick= \"callWebservice(" + row_id + "," + id + ",'savechanges')\" title='Save'><span class='glyphicon glyphicon-ok action-link'></span></a></td><td></td></form>";
				$('#row' + row_id).fadeOut(function(){$('#row' + row_id).html(new_html);});
				$('#row' + row_id).fadeIn();
			}

			function callWebservice (row_id,id,action){
				var name = $('#input' + row_id + '-1').val()
				var subject = $('#input' + row_id + '-2').val()
				var email = $('#input' + row_id + '-3').val()
				
				errors = validateInfo(name,subject,email);

				var msg =  "I noticed some strange stuff: <br> <ul>"
				
				for (i = 0; i < errors.length; i++) { 
				    msg += "<li>" + errors[i] + "</li>";
				}

				msg += "</ul> Are you sure you want to continue?"
					
				if (action == 'savechanges'){

					if (errors.length > 0){
						var ok_function = "saveContactChanges(" + row_id + "," + id + ",\'" + name + "\',\'" + subject + "\',\'" + email + "\');";
						warningModal("Wait!", msg , ok_function,"Continue");
					} else { 
						saveContactChanges(row_id,id,name,subject,email);
					}
				}

				if (action == 'createcontact') {
					if (errors.length > 0){
						warningModal("Wait!", msg ,"createContact(" + row_id + ",\'" + name + "\',\'" + subject + "\',\'" + email + "\');","Continue");
					} else { 
						createContact(row_id,name,subject,email);
					}
					
				}
			}
			
			function saveContactChanges (row_id,id,name,subject,email) {
				var svc = new SV.Webservice ();
				svc.url = "<?php echo config::url() . user::getLinkPath('edit_contacts');?>";
				svc.type = 'POST';
				svc.title = "Contact Changes";
				svc.successFunction = revertTable;
				svc.addParam ('action', 'edit');
				svc.addParam ('row_id', row_id);
				svc.addParam ('id', id);
				svc.addParam ('name', name);
				svc.addParam ('subject', subject);
				svc.addParam ('email', email);
				svc.callService();
			}
 		</script>       
    </head>
    <body>
    	
        <?php include 'navigation_bar.php';?>
        
    	<div class='container review-container'>
    		<table class="table table-hover" id="contacts_table">
    			<tr>
	    			<th width='30%'>
	    				Name
	    			</th>
	    			<th width='30%'>
	    				Subject
	    			</th>
	    			<th width='30%'>
	    				Email
	    			</th>
	    			<th width='5%'>
	    			</th>
	    			<th width='5%'>
	    			</th>
    			</tr>
    			<?php
    			
    			$db = svdb::getInstance();
    			 
    			$query = "SELECT tc.id, tc.name, tc.subject, tc.email
						  FROM sv_teachers_contacts tc
						  WHERE site = ?;";
    			 
    			$params = array();
              	$params[] = $_SESSION['sv_user']->getSite();
    			
    			$result = $db->query($query,$params);
    			
    			$num = $result->numRows();
    			 
    			for($i = 1; $i <= $num; $i++){
    				$row = $result->fetchAssoc();
    			
    				$id = $row['id'];
    				$name = $row['name'];
    				$subject = $row ['subject'];
    				$email = $row ['email'];
    			
    				echo "<tr id='row" . $i . "'>";
    				echo "<td>" . $name . "</td>";
    				echo "<td>" . $subject . "</td>";
    				echo "<td>" . $email . "</td>";
    				echo "<td> <a onclick=\"setEdit(" . $i . "," .$id . ",'" . $name . "','" . $subject . "','" . $email . "');\" title='Edit'><span class='glyphicon glyphicon-pencil action-link'></span></a> </td>";
    				echo "<td> <a onclick=\"confirmDelete(" . $i . "," .$id . ",'" . $name . "','" . $subject . "','" . $email . "');\" title='Delete'><span class='glyphicon glyphicon-remove action-link'></span></a> </td>";
    				echo"</tr>";
    			}
    			
    			?>
    			
              </table>
              <a onclick='appendForm();'><span class='glyphicon glyphicon-plus pull-right'></span></a>
    		
    		<script> var last_row_id = <?php echo $i?>;</script>
		
		</div>
			  
        <?php include 'footer.php';?>
        
	</body>
</html>
