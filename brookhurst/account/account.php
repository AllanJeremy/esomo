
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
	$pageContent = "<div class='panel panel-primary col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2' id='pageContent'>
		
		<div class='panel-header'>
			<h4 class='hidden-xs center_text'>Your Account</h4>
			<h4 class='visible-xs center_text'>Profile</h4>
		</div> 

		<div class='panel-body'>
 		<form action='loginHandler.php' method='POST'>
            
            <h4>Change Username</h4>
           <div class='form-group>
            <input type='button' class='btn btn-default'>My Button</input>
           </div>

           <h4>Change Password</h4>
           <div class='form-group>
            <input type='text' placeholder='Username'></input><button class='btn btn-default'>CHANGE</button>
           </div>
         </form>

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
