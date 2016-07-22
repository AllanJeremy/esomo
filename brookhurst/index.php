<!DOCTYPE html>

<html lang="en">
    <head>
        <title>Esomo</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
       <!--<link  rel="stylesheet" type="text/css" href="css/theme.css"/>-->
       <!--<link  rel="stylesheet" type="text/css" href="css/bootstrap-theme.css"/>
       <link  rel="stylesheet" type="text/css" href="css/bootstrap.css"/>-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
       <link  rel="stylesheet" type="text/css" href="css/main.css"/>
       <link  rel="stylesheet" type="text/css" href="css/color.css"/>
    </head>
    
    <body id="homeBody">
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
                    <a class='col-xs-12 primary-color-beige white-text' href='learn.php'>
                        Learn
                    </a>
                </div>
                <div class="col-sm-4 col-xs-12">
                    <a class='col-xs-12 primary-color-beige white-text' href='assignment.php'>
                        Assignments
                    </a>
                </div>
                <div class="col-sm-4 col-xs-12">
                    <a class='col-xs-12 primary-color-beige white-text' href='tests.php'>
                        Tests
                    </a>
                </div>
              </div>
        </div>
        <br>
        <br>
        <!--4 segments at the bottom-->
        <div class="container-fluid my-container">
            <div class="container-fluid">
            <div class="row shelves">
                <div class="col-sm-4 col-xs-12">

                <h3 class="white-text">New in Shelves</h3>

                </div>
                <div class="col-sm-8 col-xs-12">
                </div>
            </div>
            </div>   
        </div>
           

       <!--footer. Will add once I figure a way of having a sticky footer.-->

    </body>
   <script src="js/jquery.min.js"></script>
   <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</html>