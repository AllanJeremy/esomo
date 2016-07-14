
<!DOCTYPE html>

<html lang='en'>
<head>
    <title>Admin sign up</title>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
   <link  rel='stylesheet' type='text/css' href='css/theme.min.css'/>
   <link  rel='stylesheet' type='text/css' href='css/main.css'/>
</head>


<body>
<?php
  session_start();
  const SALT_LENGTH = 256;
  
  //create  a session function handler
  require_once('../functions/session_functions.php');
  $sessionHandler = new SessionFunctions();
  
  include_once('../esomoErrorHandler.php');
  $handler = new CustomErrorHandler();
  
  //WHEN THE SUBMIT BUTTON IS PRESSED
  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    //only display the error when there is an actual error
    if ($handler->getAdminSignupError()!='')
    {
      $handler->displaySignupError($handler->getAdminSignupError());
    }
    else// if all the information entered is valid
    {
      sleep(2);
      enterAdminSignupInfo();
    }
 }
?>
<?php
	$pageContent = "<div class='panel panel-primary col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2' id='pageContent'>
		
		<div class='panel-header'>
			<h4 class='hidden-xs center_text'>Sign up for an admin account</h4>
			<h4 class='visible-xs center_text'>Sign up</h4>
		</div> 

		<div class='panel-body'>
	 <form class='form-horizontal' method='post' action='signup.php?' role='form'>

                <!--First name Input-->
                <div class='form-group col-xs-11 col-sm-10 col-md-9 col-lg-8'>
                  <label class='control-label col-sm-3 hidden-xs' for='admin_firstName'>First Name</label>
                  <div class='col-sm-9'>
                    <input class='form-control' type='text' name='admin_fNameInput' id='admin_firstName' placeholder='First Name'>
                  </div>
                </div>
                
                <!--Last name Input-->
                <div class='form-group col-xs-11 col-sm-10 col-md-9 col-lg-8'>
                  <label class='control-label col-sm-3 hidden-xs' for='admin_lastName'>Last Name</label>
                  <div class='col-sm-9'>
                    <input class='form-control' type='text' name='admin_lNameInput' id='admin_lastName' placeholder='Last Name'>
                  </div>
                </div>
                
                <!--Username Input-->
                <div class='form-group col-xs-11 col-sm-10 col-md-9 col-lg-8'>
                  <label class='control-label col-sm-3 hidden-xs' for='admin_username'>Username</label>
                  <div class='col-sm-9'>
                    <input class='form-control' type='text' name='admin_usernameInput' id='admin_username' placeholder='Username'>
                  </div>
                </div>
                
                                
                <!--Email Input-->
                <div class='form-group col-xs-11 col-sm-10 col-md-9 col-lg-8'>
                  <label class='control-label col-sm-3 hidden-xs' for='admin_email'>Email</label>
                  <div class='col-sm-9'>
                    <input class='form-control' type='email' name='admin_emailInput' id='admin_email' placeholder='Email address'>
                  </div>
                </div>
                
                <!--Phone number Input-->
                <div class='form-group col-xs-11 col-sm-10 col-md-9 col-lg-8'>
                  <label class='control-label col-sm-3 hidden-xs' for='admin_phone'>Phone</label>
                  <div class='col-sm-9'>
                    <input class='form-control' type='tel' name='admin_phoneInput' id='admin_phone' placeholder='Phone number'>
                  </div>
                </div>

                <!--Password Input-->
                <div class='form-group col-xs-11 col-sm-10 col-md-9 col-lg-8'>
                  <label class='control-label col-sm-3 hidden-xs' for='admin_password'>Password</label>
                  <div class='col-sm-9'>
                    <input class='form-control' type='password' name='admin_passwordInput' id='admin_password' placeholder='Password'>
                  </div>
                </div>
                
                <!--Confirm Password Input-->
                <div class='form-group col-xs-11 col-sm-9 col-md-9 col-lg-8'>
                  <label class='control-label col-sm-3 hidden-xs' for='admin_passwordConfirm'>Confirm</label>
                  <div class='col-sm-9'>
                    <input class='form-control' type='password' name='admin_passConfirmInput' id='admin_passwordConfirm' placeholder='Confirm password'>
                  </div>
                </div> 
                                                 
                <div class='form-group col-xs-11 col-sm-10 col-md-9 col-lg-8'>
                  <button  type='submit' class='col-sm-4 col-xs-4 col-xs-offset-4 col-sm-offset-5 btn btn-success'>Sign up</button>
                </div>
              </form>
		</div>

        <div class='panel-footer col-xs-12'>
          <h5 class='float_right'>Already have an account? <a href='login.php'>Login now </a> </h5>
        </div>
	</div>";

	$sessionHandler->redirectLoggedAdmin($pageContent,'index.php');
?>

<?php
          function enterAdminSignupInfo()
          {
            require('../esomoDbConnect.php');//require the database connection
            require('../functions/pass_encrypt.php');

            $passEncrypt = new PasswordEncrypt();

            $fName = $_POST['admin_fNameInput'];
            $lName = $_POST['admin_lNameInput'];
            $email = $_POST['admin_emailInput'];
            $userName = $_POST['admin_usernameInput'];
            $password = $_POST['admin_passwordInput'];
            $passConfirm = $_POST['admin_passConfirmInput'];
            $phone_number = $_POST['admin_phoneInput'];

            $password = $passEncrypt->encryptPass($password); //encrypt the password

            $query = "INSERT INTO admin_accounts(f_name,l_name,email,username,phone,password) VALUES (?,?,?,?,?,?) ";

            if($stmt= $dbCon->prepare($query))
            {
              $stmt->bind_param('ssssis',$tmp_first_name,$tmp_last_name,$tmp_email,$tmp_username,$tmp_phone,$tmp_password);
              
              $tmp_first_name=$fName;
              $tmp_last_name=$lName;
              $tmp_email=$email;
              $tmp_username=$userName;
              $tmp_phone=$phone_number;
              $tmp_password=$password;

               
              if($stmt->execute())//if the statement successfully ran
              {
                $GLOBALS['handler']->displaySignupSuccess();
              }
              else
              {
                echo "Error signing you up -> " . $dbCon->error;
              }


            }else
            {
              echo "<h2>Was unable to prepare query".$dbCon->error."</h2>";
            }


          }



?>
</body>

<!-- jquery and bs javascript -->
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>

</html>