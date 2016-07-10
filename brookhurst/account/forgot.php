<!DOCTYPE html>

<html lang="en">
    <head>
        <title>Password Recovery</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <link  rel="stylesheet" type="text/css" href="../css/theme.min.css"/>
       <link  rel="stylesheet" type="text/css" href="../css/main.css"/>
    </head>
    
    <body>
<!--Navbar-->
     <?php 
        include_once('../navigation.php');
        $signupNav = new Navigation('../index.php','../learn.php','../tests.php','signup.php','#','../assignment.php');
        $signupNav->updateNav();//updates the nav without setting anything as active
      ?>

      <?php 
      //Include the session functions file once
      
      
      $content = <<<EOD
        <div class="container well">
          <h2>Recover your password here</h2>
        </div>
EOD;
$redirectPath = '../learn.php';#relative path from current location
      $sessionHandler = new SessionFunctions();#contains convenience session functions


      #redirects user if logged in
     $sessionHandler->redirectLoggedUser($content,$redirectPath);

      ?>
    </body>
   <script src="../js/jquery.min.js"></script>
   <script src="../js/bootstrap.min.js"></script>
</html>