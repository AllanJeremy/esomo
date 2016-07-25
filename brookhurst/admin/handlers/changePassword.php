<?php

session_start();#start session so we can use the session variables
require_once('../../functions/pass_encrypt.php');
require_once('../../esomoDbConnect.php');
$passEncrypt = new PasswordEncrypt();


#if the values are set we can proceed to change the password
if((@$_POST['adm_curPassInput']!==null) && (@$_POST['adm_newPassInput']!==null) && (@$_POST['adm_confirmInput']!==null))
{
    if(validatePassword())
    {
        changePassword();
        echo "<div class='well'> Changed Password</div>";
        #redirect user to the admin page
    }
    else
    {
        echo "<p>invalid password</p>";
    }


}
else#the value are not set for the new password input for some reason
{
    echo 'variables not set';
}

  #returns true if the password change request is valid,otherwise returns false
 function validatePassword()
  {
    #check if passwords match 
      #and
    #check if password is 8-50 characters long
    $passLength = strlen(@$_POST['adm_newPassInput']);

      if((!($passLength < 8))&&(!($passLength > 50)&&(htmlspecialchars($_POST['adm_newPassInput']) == htmlspecialchars($_POST['adm_confirmInput']))))#if the password is too short
      {#if met conditions - valid
        
       
        $q = "SELECT password FROM accounts WHERE acc_id=".$_SESSION['acc_id'];#select the current password
       
        $result=mysqli_query($GLOBALS['dbCon'],$q);
       
        foreach($result as $r)
        {
          if(password_verify($_POST['adm_curPassInput'],$r['password']))#verify that the password is valid (compare current password input)
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
    $password = htmlspecialchars($_POST['adm_newPassInput']);#sanitized password_get_info
    $password = $GLOBALS['passEncrypt']->encryptPass($password);#encrypt the password so it can be stored in the database

    $q = "UPDATE admin_accounts 
    SET password=? WHERE admin_acc_id=".$_SESSION['s_admin_id'];

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
    unset($_POST['adm_newPassInput']);
    unset($_POST['f_confirmInput']);
  }
