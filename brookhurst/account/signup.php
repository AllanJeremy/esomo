<!DOCTYPE html>

<html lang="en">
    <head>
        <title>Sign up</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <link  rel="stylesheet" type="text/css" href="../css/theme.min.css"/>
       <link  rel="stylesheet" type="text/css" href="../css/main.css"/>
    </head>
    
    <body>
     <?php 
        include_once('../navigation.php');
        $signupNav = new Navigation('../index.php','../learn.php','../tests.php','#','forgot.php','../assignment.php','account.php');
        $signupNav->updateNav();//updates the nav without setting anything as active
      ?> 

       <!--Actual body content-->
        <div class="container">
           
          <div class="panel panel-primary col-sm-12">

            <div class="panel-header">
              <h2 class='hidden-sm hidden-xs'>Create an account and get started</h2>
              <h2 class='hidden-md hidden-lg'>Sign up</h2>
            </div>

            <div class="panel-body">
              
          <?php

            const SALT_LENGTH = 128;
            

            
            include_once('../esomoErrorHandler.php');
            $handler = new CustomErrorHandler();
            
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
              //only display the error when there is an actual error
              if ($handler->getSignupError()!='')
              {
                $handler->displaySignupError($handler->getSignupError());
              }
              else// if all the information entered is valid
              {
                sleep(2);
                enterSignupInfo();
              }
           }

          ?>

          <?php
          //Include the session functions file once
      require_once('../functions/session_functions.php');  
      
      $sessionHandler = new SessionFunctions();#contains convenience session functions

      $content ='
                <form class="form-horizontal" method="post" action="signup.php?" role="form">

                <!--First name Input-->
                <div class="form-group col-xs-11 col-sm-10 col-md-9 col-lg-8">
                  <label class="control-label col-sm-3 hidden-xs" for="firstName" >First Name</label>
                  <div class="col-sm-9">
                    <input class="form-control" type="text" name="fNameInput" id="firstName" placeholder="First Name">
                  </div>
                </div>
                
                <!--Last name Input-->
                <div class="form-group col-xs-11 col-sm-10 col-md-9 col-lg-8">
                  <label class="control-label col-sm-3 hidden-xs" for="lastName">Last Name</label>
                  <div class="col-sm-9">
                    <input class="form-control" type="text" name="lNameInput" id="lastName" placeholder="Last Name">
                  </div>
                </div>
                
                <!--Username Input-->
                <div class="form-group col-xs-11 col-sm-10 col-md-9 col-lg-8">
                  <label class="control-label col-sm-3 hidden-xs" for="username">Username</label>
                  <div class="col-sm-9">
                    <input class="form-control" type="text" name="usernameInput" id="username" placeholder="Username">
                  </div>
                </div>
                
                <!--Username Input-->
                <div class="form-group col-xs-11 col-sm-10 col-md-9 col-lg-8">
                  <label class="control-label col-sm-3 hidden-xs" for="std_id">Student Id</label>
                  <div class="col-sm-9">
                    <input class="form-control" type="number" name="std_id_Input" id="std_id" placeholder="Student Id">
                  </div>
                </div>
                                
                <!--Email Input-->
                <div class="form-group col-xs-11 col-sm-10 col-md-9 col-lg-8">
                  <label class="control-label col-sm-3 hidden-xs" for="email">Email</label>
                  <div class="col-sm-9">
                    <input class="form-control" type="email" name="emailInput" id="email" placeholder="Email address">
                  </div>
                </div>
                
                <!--Password Input-->
                <div class="form-group col-xs-11 col-sm-10 col-md-9 col-lg-8">
                  <label class="control-label col-sm-3 hidden-xs" for="password">Password</label>
                  <div class="col-sm-9">
                    <input class="form-control" type="password" name="passwordInput" id="password" placeholder="Password">
                  </div>
                </div>
                
                <!--Confirm Password Input-->
                <div class="form-group col-xs-11 col-sm-9 col-md-9 col-lg-8">
                  <label class="control-label col-sm-3 hidden-xs" for="passwordConfirm">Confirm Password</label>
                  <div class="col-sm-9">
                    <input class="form-control" type="password" name="passConfirmInput" id="passwordConfirm" placeholder="Confirm Password">
                  </div>
                </div> 
                                                 
                <div class="form-group col-xs-11 col-sm-10 col-md-9 col-lg-8">
                  <button  type="submit" class="col-sm-4 col-xs-8 col-xs-offset-2 col-sm-offset-5 btn btn-success">Sign up</button>
                </div>
              </form>
        <div class="panel-footer col-xs-12">
          <h5 class="float_right">Already have an account? <a href="login.php">Login now </a> </h5>
        </div>

        </div>
            </div>


        </div>
';     
        $redirectPath = '../learn.php';#relative path from current location
        
        $sessionHandler->redirectLoggedUser($content,$redirectPath);

    ?>
        <?php
          //handles the encryption of passwords and entry of data into database
         

          function enterSignupInfo()
          {
            require('../esomoDbConnect.php');//require the database connection

            $fName = htmlspecialchars($_POST['fNameInput']);
            $lName = htmlspecialchars($_POST['lNameInput']);
            $email = htmlspecialchars($_POST['emailInput']);
            $userName = htmlspecialchars($_POST['usernameInput']);
            $password = htmlspecialchars($_POST['passwordInput']);
            $passConfirm = htmlspecialchars($_POST['passConfirmInput']);
            $std_id = htmlspecialchars($_POST['std_id_Input']);

            require('../functions/pass_encrypt.php');
            $passEncrypt = new PasswordEncrypt();
            
            $password = $passEncrypt->encryptPass($password); //encrypt the password
            $query = "INSERT INTO accounts(first_name,last_name,email,username,student_id,password) VALUES (?,?,?,?,?,?) ";

            if($stmt= $dbCon->prepare($query))
            {
              $stmt->bind_param('ssssis',$tmp_first_name,$tmp_last_name,$tmp_email,$tmp_username,$tmp_student_id,$tmp_password);
              
              $tmp_first_name=$fName;
              $tmp_last_name=$lName;
              $tmp_email=$email;
              $tmp_username=$userName;
              $tmp_student_id=$std_id;
              $tmp_password=$password;

              if($stmt->execute())//if the statement successfully ran
              {
                $GLOBALS['handler']->displaySignupSuccess();
              }
              else
              {
                echo "<h4>The student Id you entered does not exist in the database. Please try a valid student ID</h4>";
              }


            }else
            {
              echo "<h4>Was unable to prepare query - ".$dbCon->error."</h4>";
            }
          }

        ?>
              </div></div></div>
    </body>
   <script src="../js/jquery.min.js"></script>
   <script src="../js/bootstrap.min.js"></script>
</html>