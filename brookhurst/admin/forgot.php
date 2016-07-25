<!DOCTYPE html>

<html lang="en">
    <head>
        <title>Password Recovery</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <link  rel="stylesheet" type="text/css" href="../css/theme.min.css"/>
       <link  rel="stylesheet" type="text/css" href="../css/main.css"/>
        <link  rel="stylesheet" type="text/css" href="../css/color.css"/>
    </head>
    
    <body>
<!--Navbar-->
     <?php 
        include_once('../navigation.php');
        $signupNav = new Navigation('../index.php','../learn.php','../tests.php','signup.php','#','../assignment.php','account.php');
        $signupNav->updateNav();//updates the nav without setting anything as active
      ?>

      <?php 
      //Include the session functions file once
      
      
      $content = <<<EOD
        <div class="container well">
          <h3>Recover your password here</h3>
          <br>
          <form class='form-inline' action="handlers/forgotHandler.php" method="post" id="recovery-form">
            <p><b>Step 1: </b> Enter your email address and we will send you an email with details on recovering your password</p>
            <br>
            <div class="form-group">
	          <label for='recoverEmail' class='control-label'>Email Address : </label>
            <input type='email' name='recoverEmailInput' id='recoverEmail' placeholder='Email Address' class="form-control" class="validate" pattern="[a-zA-Z0-9_]+(?:\.[A-Za-z0-9!#$%&amp;'*+/=?^_`{|}~-]+)*@(?!([a-zA-Z0-9]*\.[a-zA-Z0-9]*\.[a-zA-Z0-9]*\.))(?:[A-Za-z0-9](?:[a-zA-Z0-9-]*[A-Za-z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?" required></input>
            </div>
            <button type='submit' class="btn btn-default action-color" id="recovery-btn" name="submit" >RECOVER</button>
          </form>
          <br>
          <br>
          
        </div>
EOD;
    $redirectPath = '../learn.php';#relative path from current location
      $sessionHandler = new SessionFunctions();#contains convenience session functions
        require('../esomoDbConnect.php');
      #redirects user if logged in
     $sessionHandler->redirectLoggedUser($content,$redirectPath);
        
        
      ?>
    </body>
   <script src="../js/jquery.min.js"></script>
   <script src="../js/bootstrap.min.js"></script>
   <script src="../js/jquery.validate.min.js"></script>

  <!--If the email is in the database
    generate a custom password and expiry date
    store password in database
  -->
    <script type="text/javascript">
        $('#recovery-form').validate();
    </script>
</html>

