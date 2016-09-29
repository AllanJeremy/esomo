
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
    
    if (!$sessionHandler->sessionActive())#echo content only if not logged in
    {
        session_write_close();
        $sessionHandler->redirectNotLoggedUser($pageContent,'login.php');
        //header('Location:'.$redirectPath);
    }
    else
    {
        $sessionHandler->updateSessionVars('../esomoDbConnect.php');
    }
  
?>

<?php
#load the navigation menu
    include_once('../navigation.php');
    $signupNav = new Navigation('../index.php','../learn.php','../tests.php','signup.php','forgot.php','../assignment.php','#');
    $signupNav->updateNav();//updates the nav without setting anything as active
?>

<?php
  #function definitions 
  #returns whether the variable contains nonAlphanumeric characters
	function containsNonAlphanumeric($variable)
	{
			return preg_match('/[^a-zA-Z0-9]+/', $variable, $matches);
	}

  #For fetching information from the database
  include_once("../functions/dbInfo.php");
  $dbInfo = new DbInfo('../esomoDbConnect.php');

  #Session variables to be used in the body section
  $currentUsername = $_SESSION['std_username'];
  $currentName = $_SESSION['std_name'];#student's name(s)
  
  $currentClass = $dbInfo->getClassName($_SESSION['std_class_id']);
  $currentStream = $dbInfo->getStreamName($_SESSION['std_stream_id']);

  #content of the page
	$pageContent = "<div class='panel panel-primary col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2' id='pageContent'>
		
		<div class='panel-header'>
      <br><h3 class='hidden-xs center_text'>ACCOUNT SETTINGS</h3>
			<h4 class='visible-xs center_text'>Profile</h4>
		</div> 
    
		<div class='panel-body'>

    <ul class='nav nav-tabs'>
            <li class='active'>
             <a class='hidden-xs' data-toggle='tab' href='#accInfo'>Account</a>
             <a class='visible-xs' data-toggle='tab' href='#accInfo'><span class='glyphicon glyphicon-user'></span></a>
            </li>
            <li>
              <a class='hidden-xs' data-toggle='tab' href='#changeUsername'>Username</a>
              <a class='visible-xs' data-toggle='tab' href='#changeUsername'><span class='glyphicon glyphicon-font'></span></a>
            </li>
            <li>
              <a class='hidden-xs' data-toggle='tab' href='#changePassword'>Passwords</a>
              <a class='visible-xs' data-toggle='tab' href='#changePassword'><span class='glyphicon glyphicon-lock'></span></a>
            </li>
    </ul>  
 		
  <div class='tab-content'>
      <div class='tab-pane active clearfix' id='accInfo'>
        <h4 class='center_text'><b>Account Information ($currentUsername)</b></h4>
        <p><b>Username : </b>$currentUsername</p>
        <p><b>Name(s) : </b>$currentName</p>
        <p><b>Class Name :</b> $currentClass</p>
        <p><b>Stream Name :</b> $currentStream</p>
      </div>
            
     <div class='clear-fix tab-pane' id='changeUsername'>         
      <form class='form' action='?' method='POST'>
        <div class='form-group clearfix' id='changeUsername'>
          <h4><b>Change Username</b></h4>
            <p>Current Username : <i>$currentUsername</i></p><br>
          
            <label class='control-label hidden-xs col-md-2' for='f_newUsername'>New Username :</label>
            <input class='col-xs-12 col-md-4' type='text' placeholder='New Username' id='f_newUsername' name='f_newUsernameInput' required></input><br><br>
            <button class='btn btn-default col-xs-offset-4 col-md-offset-4'>CHANGE USERNAME</button>
          </div>
        </form>
      </div> 

      <div class='clear-fix tab-pane' id='changePassword'>
        <form class='form' action='?' method='POST'>
            <div class='form-group clearfix' id='changePassword'>
            <h4><b>Change Password</b></h4>
            <div class='panel panel-info container-fluid hidden-xs'>
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
            <input class='col-xs-12 col-md-4 required' type='password' placeholder='Current Password' id='f_curPass' name='f_curPassInput' ></input><br><br>
            
            <label class='control-label hidden-xs col-md-2' for='f_newPass' required>New Password :</label>
            <input class='col-xs-12 col-md-4 required' type='password' placeholder='New Password' id='f_newPassInput' name='f_newPassInput' minlength='8'></input><br><br>

            <label class='control-label hidden-xs col-md-2' for='curPass' required>Confirm Password :</label>
            <input class='col-xs-12 col-md-4 required' type='password' placeholder='Confirm Password' id='f_confirmInput' name='f_confirmInput' minlength='8'></input><br><br>

            <button type='submit' class='btn btn-default col-xs-offset-4 col-md-offset-4'>CHANGE PASSWORD</button>
            </div>
          </form>
        </div>
      </div>

	</div>

  <div class='panel-footer'>
    <h5>Note : You have to refresh your page for the new Username to be displayed in your profile.</h5>
  </div>
</div>";
    echo $pageContent;

?>

<?php

  #connection to the database
  require('../esomoDbConnect.php');

  #include the pass encrypt file - for encrypting the password
  require_once('../functions/pass_encrypt.php');
  $passEncrypt = new PasswordEncrypt();
  
  #returns true if the password change request is valid,otherwise returns false
  function validatePassword()
  {
    #check if passwords match 
      #and
    #check if password is 8-50 characters long
    $passLength = strlen(@$_POST['f_newPassInput']);

      if((!($passLength < 8))&&(!($passLength > 50)&&(htmlspecialchars($_POST['f_newPassInput']) == htmlspecialchars($_POST['f_confirmInput']))))#if the password is too short
      {#if met conditions - valid
        
        require('../esomoDbConnect.php');
        $q = "SELECT password FROM accounts WHERE acc_id=".$_SESSION['acc_id'];#select the current password
        $result=mysqli_query($dbCon,$q);
        foreach($result as $r)
        {
          if(password_verify($_POST['f_curPassInput'],$r['password']))#verify that the password is valid (compare current password input)
          {
            return true;
          }
          else
          {
            echo "Passwords do not match";
            return false;
          }
        }
        
      }
      else#if invalid
      {
        return false;
      }

  }

  #alters the table data - changes password
  function changePassword()
  {
    $password = htmlspecialchars($_POST['f_newPassInput']);#sanitized password_get_info
    $password = $GLOBALS['passEncrypt']->encryptPass($password);#encrypt the password so it can be stored in the database

    $q = "UPDATE accounts 
    SET password=? WHERE student_id=".$_SESSION['acc_id'];

    #if we could prepare the query - change the password
    if($result = $GLOBALS['dbCon']->prepare($q))#prevent sql injection
    {
      $result->bind_param('s',$tmp_pass);
      $tmp_pass = $password;#bind the new password to the password entry variable for the table

      $result->execute();
    }
    else#failed
    {
      echo "Failed to prepare the password change query ";#debug
    }

    #unset the post variables so that every new request does not use previous data
    unset($_POST['f_curPass']);
    unset($_POST['f_newPassInput']);
    unset($_POST['f_confirmInput']);
  }

  #validate username - returns true if valid and false if invalid
  function validateUsername()
  {
    if(!containsNonAlphanumeric(htmlspecialchars($_POST['f_newUsernameInput'])))#username contains purely alphanumeric characters
    {
      return true;
    }
    else #username contains invalid characters
    {
      return false;
    } 
  }

  #alters the table data  - changes username
  function changeUsername()
  {
    $newUsername = htmlspecialchars($_POST['f_newUsernameInput']);

    $q = "UPDATE accounts 
    SET username=? WHERE student_id=".$_SESSION['acc_id'];

    #if we could prepare the query - change the password
    if($result = $GLOBALS['dbCon']->prepare($q))#prevent sql injection
    {
      $result->bind_param('s',$tmp_username);
      $tmp_username = $newUsername;#bind the new password to the password entry variable for the table

      $result->execute();
      
    }
    else#failed
    {
      echo "Failed to prepare the username change query ";#debug
    }
  }
  
#if the user is logged in
 if($sessionHandler->sessionActive())
{
  //WHEN A FORM IS SUBMITTED ON THIS PAGE
  if($_SERVER['REQUEST_METHOD']=='POST')
  {
    #if this is set then the username form was submitted
    if(@$_POST['f_newUsernameInput']!==null)
    {
      if(validateUsername())
      {
        changeUsername();
      }
      else#username invalid
      {
        echo "<p>Username contains some invalid characters. Your username was not changed</p>";
      }
    }
    
    #if these are set, then the password form was submitted
    if((@$_POST['f_curPassInput']!==null) && (@$_POST['f_newPassInput']!==null) && (@$_POST['f_confirmInput']!==null))
    {
      if(validatePassword())#if password is valid
      {
        changePassword();
        echo "<div class='well'> Changed Password</div>";
      }
      else#password is invalid
      {
        echo "<p>Invalid password information</p>";
      }
    }
  }
}# end of if 
?>
    
</body>

<!-- jquery and bs javascript -->
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/jquery.validate.min.js"></script>

<script type="text/javascript">
    $( "#changePassword" ).validate({
          rules: {
            f_newPassInput: "required",
            f_confirmInput: {
              equalTo: "#f_newPassInput"
            }
          }
        });
</script>
</html>
