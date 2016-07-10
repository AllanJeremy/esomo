<!DOCTYPE html>

<html lang="en">
    <head>
        <title>Esomo</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <link  rel="stylesheet" type="text/css" href="css/theme.min.css"/>
       <link  rel="stylesheet" type="text/css" href="css/main.css"/>
    </head>
    
    <body id="homeBody">
      <?php 
        include_once('navigation.php');
        $indexNav = new Navigation('#','learn.php','tests.php','account/signup.php','account/forgot.php','assignment.php');
        $indexNav->loginHandlerPath = 'account/loginHandler.php';
        $indexNav->setIndexActive();
      ?>

      <!--Actual body content-->
       <div class="container-fluid">
        <!--Carousel area-->
        <div class="homeCarousel col-xs-10 col-xs-offset-1">
          <div id="homeSlides" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
              <li data-target="#homeSlides" data-slide-to="0" class="active"></li>
              <li data-target="#homeSlides" data-slide-to="1"></li>
              <li data-target="#homeSlides" data-slide-to="2"></li>
            </ol>

            <div class="carousel-inner" role="listbox">
              <div class="item active">
                <img class="img-responsive" src="media/std1.jpg" alt="First slide">
                <div class="carousel-caption hidden-xs">
                  <h3>Start your free trial today</h3>
                  <p>Get started for as low as 0.00. Paid plans starting at 1,000</p>
                </div>
              </div>
              
              <div class="dark item">
                <img class="img-responsive" src="media/std2.jpg" alt="Second slide">
                <div class="carousel-caption hidden-xs">
                  <h3>Education for everybody</h3>
                  <p>Are you a parent concerned about your child's grades? Or a student looking for an opportunity to perform better? 
                  <br>You have come to the right place.</p>
                </div>
              </div>
              
              <div class="dark item">
                <img class="img-responsive" src="media/std3.jpg" alt="Third slide">
                <div class="carousel-caption hidden-xs">
                  <h3>The perfect place for resources</h3><br>
                  <p>No more getting distracted watching vines and cat videos.<br>The perfect study environment.</p>
                </div>
              </div>
            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#homeSlides" role="button" data-slide="prev">
              <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#homeSlides" role="button" data-slide="next">
              <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>


          </div>
        </div>

        <!--4 segments at the bottom-->
        <div class="hSegmentWrapper">
          <div class="col-sm-10 col-sm-offset-1 col-xs-12">
            <div class="well">
              <h3>Kindergaten</h3><br>
              <p>Learning material for kindergaten students</p>
            </div>
          </div>
          
       </div>    

       <!--footer. Will add once I figure a way of having a sticky footer.-->

    </body>
   <script src="js/jquery.min.js"></script>
   <script src="js/bootstrap.min.js"></script>
</html>