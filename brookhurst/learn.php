<!DOCTYPE html>

<html lang="en">
    <head>
        <title>Learn</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link  rel="stylesheet" type="text/css" href="css/theme.min.css"/>
       <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">-->
       <link  rel="stylesheet" type="text/css" href="css/main.css"/>
       <link  rel="stylesheet" type="text/css" href="css/color.css"/>
    </head>
    
    <body>
     <?php 
        include_once('navigation.php');
        $learnNav = new Navigation('index.php','#','tests.php','account/signup.php','account/forgot.php','assignment.php','account/account.php');
        $learnNav->loginHandlerPath = 'account/loginHandler.php';
        $learnNav->setLearnActive();
      ?>
       <!--Actual body content-->
       
        
        <?php
         



          require_once('functions/session_functions.php');
          $sessionHandler = new SessionFunctions();
          $errorMessage = "<div class='container'> <div class='panel panel-info col-sm-12'> <div class='panel-header'> <h2>Restricted access content</h2>  </div><div class='panel-body'> <p>You need to be logged in to access learning material. Login and try again</p></div></div></div>";

          if($sessionHandler->sessionActive())
          {

           $curSubId = @($_GET['subId']); 
            //$dbCon database connection variable in learnDbController
            if ($curSubId!== null)
            {
              include("formSelection.php");
              $formSelection = new FormSelection();
              $formSelection->generateFormPage($curSubId);
            }
            require_once('esomoDbConnect.php');//includes an opening to the database
            echo "<h2 style='padding:2rem;' class='grey-text'>Learning material to get you started as the best student.</h2>";
            echo "<div class='far-grey'>";
            

            $scienceSubs =$languageSubs= $humanitySubs= $extraSubs = "";
            $subContainerClasses = 'panel panel-default col-xs-12 col-sm-5 col-sm-offset-1 col-md- col-md-offset-1 col-lg-2 col-lg-offset-1';//classes for the subject container classes

            $rawQuery = 'SELECT subject_id,subject_name,subject_description,subject_category FROM subjects WHERE subject_category=?';

            if($fetchSubsQuery = $dbCon->prepare($rawQuery))//if we successfully prepared query set fetchSubsQuery
            {
            //

            $fetchSubsQuery->bind_param('s', $tempSubCategory);   //set the information for each category
            $tempSubCategory = SC_SCIENCES;
            $fetchSubsQuery->execute();
            $scienceSubs = $fetchSubsQuery->get_result();

            $tempSubCategory = SC_LANGUAGES;
            $fetchSubsQuery->execute();
            $languageSubs = $fetchSubsQuery->get_result();

            $tempSubCategory = SC_HUMANITIES;
            $fetchSubsQuery->execute();
            $humanitySubs = $fetchSubsQuery->get_result();

            $tempSubCategory = SC_EXTRAS;
            $fetchSubsQuery->execute();
            $extraSubs = $fetchSubsQuery->get_result();
            }else
            {
              echo "<p style='background-color:black;text-align:center;color:red;font-size:1.2em;'> could not execute query :".$dbCon->error." </p> ";//LIFE SAVER - HELPED FIND THE ERROR
              #exit();
            }

            //loops through and categorizes subjects
            loopSubjects($languageSubs,"Languages");
            loopSubjects($scienceSubs,"Sciences");
            loopSubjects($humanitySubs,"Humanities");
            loopSubjects($extraSubs,"Extra Subjects");

            //done generating content , close the div wrapper
            echo "</div>";
          }
          else #do this if the user is not logged in
          {
           echo $errorMessage;
          }
        
    function seoUrl($string) {
        //Lower case everything
        $string = strtolower($string);
        //Make alphanumeric (removes all other characters)
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        //Clean up multiple dashes or whitespaces
        $string = preg_replace("/[\s-]+/", " ", $string);
        //Convert whitespaces and underscore to dash
        $string = preg_replace("/[\s_]/", "-", $string);
        return $string;
    }  
        
      function loopSubjects($subjectQueryResult,$subjectGroupTitle)
      {
          //Making the title of the group title be a css class to apply different color backgrounds for different groups.
          $string = $subjectGroupTitle;
          $subjectType = seoUrl($string);
          
          
          echo "<div class='row padd-top-3-half ".$subjectType."'>";
        echo "<div class='col-sm-3 subject-title white-text'><h3>$subjectGroupTitle</h3></div>";
          echo "<div class='col-sm-9'>
        <div class='col-sx-12 subjectCont'>";
        foreach ($subjectQueryResult as $subject) {
          $tmp_sName = $subject['subject_name'];#temporary variable
          $tmp_sDescr = $subject['subject_description'];#temporary variable
          $tmp_sCategory = $subject['subject_category'];#temporary variable
          $tmp_sId = $subject['subject_id'];#temporary variable
          
          
            
          echo createSubjectContainer($tmp_sName,$tmp_sId);
            
         }
          echo "</div></div>";
        //cleaning up after use - unsetting variables used in the foreach
        unset($subject);
        unset($tmp_sName);
        unset($tmp_sDescr);
        unset($tmp_sCategory);
       

        echo "</div>";
        
        
      }

      //returns the content
      function createSubjectContainer($subjectName,$subjectId)
      { 
       $subContClassesRef = &$GLOBALS['subContainerClasses'];//reference to the subject container classes
       
       $subjectContainer = <<<EOD
        
        <div class="subject">
          <a href="learn.php?subId=$subjectId" class="btn btn-primary white black-text">$subjectName</a>
          </div>
          
EOD;
      return $subjectContainer;//Returns a container that contains a subject
      }
        

?>
                                
         
    </body>
   <script src="js/jquery.min.js"></script>
   <script src="js/bootstrap.min.js"></script>
<script type="text/javascript">
    
    </script>
</html>