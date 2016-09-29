<!DOCTYPE html>

<html lang="en">
    <head>
        <title>Esomo</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
       <link  rel="stylesheet" type="text/css" href="css/theme.min.css"/>
       <!--   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">-->
       <link  rel="stylesheet" type="text/css" href="css/main.css"/>
       <link  rel="stylesheet" type="text/css" href="css/color.css"/>
    </head>
    
    <body id="homeBody">
    <main>
      <?php 
        include_once('landing-navigation.php');
        $indexNav = new Navigation('#','learn.php','tests.php','account/signup.php','account/forgot.php','assignment.php');
        $indexNav->loginHandlerPath = 'account/loginHandler.php';
        $indexNav->setIndexActive();
      ?>

      <!--Actual body content-->
       <div class="container-fluid my-container">
           <div class="row">
               <div class="col-sm-3 col-xs-12">
                   <img alt="brookhurst logo" class="logo" src="media/brookhurstlogo.png">
               </div>
               <div class="col-sm-9 col-xs-12 landing-text">
                   <p class="lg-title-text">Brookhurst e-Learning</p>
                   <h2 class="grey-text">Learn anywhere at your convenience.</h2>
               
               </div>
           </div>
           <br>
           <br>
           <br>
           
            <div class='row landing-links'>
                <div class="col-sm-4 col-xs-12">
                    <a class='col-xs-12 primary-color-maroon beige-text center_text' href='learn.php'>
                        Learn
                    </a>
                </div>
                <div class="col-sm-4 col-xs-12">
                    <a class='col-xs-12 primary-color-maroon beige-text center_text' href='assignment.php'>
                        <span class="hidden-sm hidden-xs">Assignments</span>
                        <span class="visible-sm visible-xs">ASGMNT</span>
                    </a>
                </div>
                <div class="col-sm-4 col-xs-12">
                    <a class='col-xs-12 primary-color-maroon beige-text center_text' href='tests.php'>
                        Tests
                    </a>
                </div>
              </div>
        </div>
        <br>
        <!--video segment at the bottom-->
        <div class="container-fluid my-container">
            <video class="col-xs-12 col-sm-10 col-sm-offset-1" controls>
            <source src="media/tutorial.mp4" type="video/mp4">
            <source src="media/tutorial.ogg" type="video/ogg">
            
            <p>Your browser cannot recognize the video. Please try a different browser. We recommend using the latest version of Google Chrome or Mozilla Firefox</p>
            </video>
        </div>
           
        <br><br>
        <?php include_once("footer.php"); ?>
    </body>
   <script src="js/jquery.min.js"></script>
   <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</html>