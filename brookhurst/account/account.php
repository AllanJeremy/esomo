
<!DOCTYPE html>

<html lang="en">
<head>
    <title>Your account</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link  rel="stylesheet" type="text/css" href="../css/theme.min.css"/>
   <link  rel="stylesheet" type="text/css" href="../css/main.css"/>
</head>


<body>
<?php
  session_start();
  //create  a session function handler
  require_once('../functions/session_functions.php');
  $sessionHandler = new SessionFunctions();
?>
<?php
#load the navigation menu
    include_once('../navigation.php');
    $signupNav = new Navigation('../index.php','../learn.php','../tests.php','signup.php','forgot.php','../assignment.php','#');
    $signupNav->updateNav();//updates the nav without setting anything as active
?>

<?php

  #For fetching information from the database
  include_once("../functions/dbInfo.php");
  $dbInfo = new DbInfo('../esomoDbConnect.php');

  #Session variables to be used in the body section
  $currentUsername = $_SESSION['std_username'];
  $currentFirstName = $_SESSION['std_fName'];
  $currentLastName = $_SESSION['std_lName'];
  $currentClass = $dbInfo->getAttributeName('class_name','class_selection','class_id',$_SESSION['std_class_id']);
  $currentStream = $dbInfo->getAttributeName('stream_name','streams','stream_id',$_SESSION['std_stream_id']);

 

  #content of the page
	$pageContent = "<div class='panel panel-primary col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2' id='pageContent'>
		
		<div class='panel-header'>
			<h4 class='hidden-xs center_text'>Your Account</h4>
			<h4 class='visible-xs center_text'>Profile</h4>
		</div> 
    
		<div class='panel-body'>

    <ul class='nav nav-tabs'>
            <li class='active'><a data-toggle='tab' href='#accInfo'>Account</a></li>
            <li><a data-toggle='tab' href='#changeUsername'>Username</a></li>
            <li><a data-toggle='tab' href='#changePassword'>Passwords</a></li>
    </ul>  
 		
  <div class='tab-content'>
      <div class='tab-pane active clearfix' id='accInfo'>
        <h4 class='center_text'><b>Account Information ($currentUsername)</b></h4>
        <p><b>Username : </b>$currentUsername</p>
        <p><b>First Name : </b>$currentFirstName</p>
        <p><b>Last Name : </b>$currentLastName</p>
        <p><b>Class Name :</b> $currentClass</p>
        <p><b>Stream Name :</b> $currentStream</p>
      </div>
            
     <div class='clear-fix tab-pane' id='changeUsername'>         
      <form class='form' method='POST'>
        <div class='form-group clearfix' id='changeUsername'>
          <h4><b>Change Username</b></h4>
            <p>Current Username : <i>$currentUsername</i></p><br>
          
            <label class='control-label hidden-xs col-md-2' for='f_newUsername'>New Username :</label>
            <input class='col-xs-12 col-md-4' type='text' placeholder='New Username' id='f_newUsername'></input><br><br>
            <button class='btn btn-default col-xs-offset-4 col-md-offset-4'>CHANGE USERNAME</button>
          </div>
        </form>
      </div> 

      <div class='clear-fix tab-pane' id='changePassword'>
        <form class='form' method='POST'>
            <div class='form-group clearfix' id='changePassword'>
            <h4><b>Change Password</b></h4>
            <div class='panel panel-info container-fluid'>
                <div class='panel-body'>
                  <p>When creating passwords please note the points below.</p>
                  <ol>
                    <li>Passwords are case sensitive</li>
                    <li>A good password contains a combination of numbers and letters with varying cases</li>
                    <li>Password must be between 8 and 50 characters long</li>
                    <li>Avoid using your name or email as a password</li>
                  </ol>
                </div>
            </div>
            
            <label class='control-label hidden-xs col-md-2' for='curPass'>Current Password :</label>
            <input class='col-xs-12 col-md-4' type='text' placeholder='Current Password' id='f_curPass' required></input><br><br>
            
            <label class='control-label hidden-xs col-md-2' for='f_newPass' required>New Password :</label>
            <input class='col-xs-12 col-md-4' type='text' placeholder='New Password' id='f_newPass' name='f_newPassInput'></input><br><br>

            <label class='control-label hidden-xs col-md-2' for='curPass' required>Confirm Password :</label>
            <input class='col-xs-12 col-md-4' type='text' placeholder='Confirm Password' id='f_confirm'></input><br><br>

            <button type='submit' class='btn btn-default col-xs-offset-4 col-md-offset-4'>CHANGE PASSWORD</button>
            </div>
          </form>
        </div>
      </div>
	    <div class='modal-footer'>

	    </div>
		
	</div>
</div>";

  $sessionHandler->redirectNotLoggedUser($pageContent,'login.php');
?>

</body>

<!-- jquery and bs javascript -->
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>


</script>
</html>
