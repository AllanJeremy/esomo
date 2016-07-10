<!DOCTYPE html>

<html lang="en">
<head>
    <title>Admin login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link  rel="stylesheet" type="text/css" href="css/theme.min.css"/>
   <link  rel="stylesheet" type="text/css" href="css/main.css"/>
</head>


<body>
<?php
  session_start();
  //create  a session function handler
  require_once('../functions/session_functions.php');
  $sessionHandler = new SessionFunctions();
?>


<?php
	$pageContent = "<div class='panel panel-primary col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2' id='pageContent'>
		
		<div class='panel-header'>
			<h4 class='hidden-xs center_text'>Login to your admin account</h4>
			<h4 class='visible-xs center_text'>Login</h4>
		</div> 

		<div class='panel-body'>
			<form class='form-horizontal' action='admin_login_handler.php' method='post'>
                <div class='form-group col-xs-11 col-sm-10 col-md-9 col-lg-8'>
                  <label class='control-label col-sm-3 hidden-xs' for='login_email_input'>Email</label>
                  <div class='col-sm-9'>
                    <input class='form-control' type='email' name='admin_loginEmailInput' id='login_email_input' placeholder='Email address'>
                  </div>
                </div>

                <div class='form-group col-xs-11 col-sm-10 col-md-9 col-lg-8'>
                  <label class='control-label col-sm-3 hidden-xs' for='login_pass_input'>Password</label>
                  <div class='col-sm-9'>
                    <input class='form-control' type='password' name='admin_loginPassInput' id='login_pass_input' placeholder='Password'>
                  </div>
                </div>

                

               	<div class='md_text_size form_footer col-xs-12'>
               	<button class='btn btn-primary col-xs-8 col-xs-offset-2 col-sm-6 col-sm-3 col-md-4 col-md-offset-4' type='submit'>Login</button>
               	<p class='float_right top_offset'>New admin? <a href='signup.php'>Signup</a></p>
               	</div>
			</form>

		</div>
	</div>";

  $sessionHandler->redirectLoggedAdmin($pageContent,'index.php');

  $loginError = @$_GET['admin_loginError'];
  if(isset($loginError))
  {
    $loginError = htmlspecialchars($loginError);//Sanitize
    
    switch($loginError)
    {
      case 1:
       $content =
       "<div class='container'> <div class='panel panel-warning col-sm-12'> <div class='panel-header'> <h2>Invalid login credentials</h2></div><div class='panel-body'> <p>The email or password you entered is invalid. Please check your credentials and try again. </p></div></div></div>";

       echo $content;
      break;

      default:#admin_loginError is not defined - do nothing

    } 
  }
  //$sessionHandler->printAdminVars();
?>

</body>

<!-- jquery and bs javascript -->
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>


</script>
</html>