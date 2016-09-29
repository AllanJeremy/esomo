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
        <main>
     <?php 
        include_once('navigation.php');
        $testsNav = new Navigation('index.php','learn.php','#','account/signup.php','account/forgot.php','assignment.php','account/account.php');
        $testsNav->loginHandlerPath = 'account/loginHandler.php';
        $testsNav->setTestsActive();
      ?>

       <!--Actual body content-->

      <?php
        
        require_once('functions/session_functions.php');
        
        $sessionHandler = new SessionFunctions();
        $errorMessage = "<div class='container'> <div class='panel panel-info col-sm-12'> <div class='panel-header'> <h2>Restricted access content</h2>  </div><div class='panel-body'> <p>You need to be logged in to access tests. Login and try again</p></div></div></div>";
        

        #content of the page
        require("esomoDbConnect.php");#connection to the database
      
        $content = "<div class='container'>";
       
        #query to get the test from database
        $q = "SELECT * FROM tests";

        #class, subject, title, download
       
        if ($tests = mysqli_query($dbCon,$q))
        {
          #if there are tests available
          if (mysqli_num_rows($tests)>0)
          {
            require_once('functions/dbInfo.php');
            $dbInfo = new DbInfo('esomoDbConnect.php');

            $content .= "<table class='table table-striped'><tr><th colspan='4'> <h3 class='center_text'>Some tests to test yourself</h3></tr>";
            $content .= "<tr><th class='center_text'>Subject</th>
            <th class='center_text'>Class</th>
            <th class='center_text'>Title</th>
            <th class='center_text'>Download</th></tr>";

            #loop through the tests found
            foreach($tests as $result)
            {
              $tmp_subject = $dbInfo->getSubjectName($result['subject_id']);
              $tmp_class = $dbInfo->getClassName($result['class_id']);
              $tmp_title = $result['test_title'];
              $tmp_path = $result['test_path'];
              $content .= "<tr>
              <td>$tmp_subject</td>
              <td>$tmp_class</td>
              <td>$tmp_title</td>";

              $content .= "<td>";
              #if the path is empty then don't download anything - else download item in the path specified (tmp_path)
              if ($tmp_path !=='' && $tmp_path!==null)
              {
                $content .= "<a class='btn btn-default center_text col-xs-12' href='$tmp_path' download='$tmp_title'>DOWNLOAD</a>";
              }
              else 
              {
               $content .= "<a class='btn btn-default col-xs-12' disabled href='javascript:void(0)'>DOWNLOAD</a>";
              }

              $content .= "</td></tr>";

            }
            
            unset($result);
            $content .= "</table>";
          }
          else #if no tests have been posted yet
          {
            $content .= "<div class='panel pane-info col-lg-12'>
            <h4>No tests posted yet</h4>
            <p>No tests have been posted yet. Please check back later</p>
            </div>";
          }
        }
        else {// Was unable to fetch the results
          $content .= "<div class='panel pane-warning col-lg-12'><h4>Unable to retrieve tests</h4><p>If the problem persists, contact the web administrator</p></div>";
        }

        $content .= "</div>";
        
        

        if($sessionHandler->sessionActive()){
          echo $content;
          include_once("footer.php"); 
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