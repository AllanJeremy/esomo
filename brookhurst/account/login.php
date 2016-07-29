
<!DOCTYPE html>

<html lang="en">
<head>
    <title>Student login</title>
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
    $signupNav = new Navigation('../index.php','../learn.php','../tests.php','signup.php','forgot.php','../assignment.php','account.php');
    $signupNav->updateNav();//updates the nav without setting anything as active
?>

<?php
	$pageContent = "<div class='panel panel-primary col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2' id='pageContent'>
		
		<div class='panel-header'>
			<h4 class='hidden-xs center_text'>Login to your student account</h4>
			<h4 class='visible-xs center_text'>Login</h4>
		</div> 

		<div class='panel-body'>
 		<form action='loginHandler.php' method='POST' id='loginForm'>
	      <input type='email' id='email' class='col-sm-offset-3 col-sm-6' placeholder='Email' name='loginUserInput'><br/><br/><br/>
          
	      <input type='password' id='pass' class='col-sm-offset-3 col-sm-6 required'  placeholder='Password' name='loginPassInput'><br/><br/><br/>

	      
	        <button class='btn btn-primary' id='loginButton'>Login</button>
	        <a class='col-sm-offset-1 required' href='forgot.php'> Forgot password?</a> <br/><br/>
         </form>

	    <div class='modal-footer'>
	      <h5> Don\'t have an account? <a href='signup.php'> Sign up now </a></h5>
	    </div>
		
	</div>
</div>";

  $sessionHandler->redirectLoggedUser($pageContent,'../learn.php');

  $loginError = @$_GET['loginError'];
  if(isset($loginError))
  {
    $loginError = htmlspecialchars($loginError);//Sanitize
    
    switch($loginError)
    {
      case 1:
       $content =
       "<div class='container'> <div class='panel panel-warning col-sm-12'> <div class='panel-header'> <h2>Invalid login credentials</h2></div><div class='panel-body'> <p>The email or password you entered is invalid or empty. Please check your credentials and try again.</p></div></div></div>";

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

<script src="../js/jquery.validate.min.js"></script>
<script type="text/javascript">
    $( "#loginForm" ).validate();
</script>
</html>
