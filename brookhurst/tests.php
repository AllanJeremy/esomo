<!DOCTYPE html>

<html lang="en">
    <head>
        <title>Tests</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link  rel="stylesheet" type="text/css" href="css/theme.min.css"/>
       <link  rel="stylesheet" type="text/css" href="css/main.css"/>
    </head>
    
    <body>
    <!--Navbar-->
     <?php 
        include_once('navigation.php');
        $testsNav = new Navigation('index.php','learn.php','#','account/signup.php','account/forgot.php','assignment.php');
        $testsNav->loginHandlerPath = 'account/loginHandler.php';
        $testsNav->setTestsActive();
      ?>

       <!--Actual body content-->

      <?php
        require_once('functions/session_functions.php');
        $sessionHandler = new SessionFunctions();
        $errorMessage = "<div class='container'> <div class='panel panel-info col-sm-12'> <div class='panel-header'> <h2>Restricted access content</h2>  </div><div class='panel-body'> <p>You need to be logged in to access tests. Login and try again</p></div></div></div>";
        #content of the page
        $content = '<div class="container jumbotron">
        <h2>Some tests to test yourself</h2>
        <p>This module is still under construction, please check again later</p>
        </div>';

        if($sessionHandler->sessionActive()){
          echo $content;
        }
        else#do this if the user is not logged in
        {
          echo $errorMessage;
        }
    ?>      
    </body>
   <script src="js/jquery.min.js"></script>
   <script src="js/bootstrap.min.js"></script>
</html>