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
    <main>
        
        <?php 
            include_once('navigation.php');
            $learnNav = new Navigation('index.php','learn.php','tests.php','account/signup.php','account/forgot.php','assignment.php','account/account.php');
            $learnNav->loginHandlerPath = 'account/loginHandler.php';
            $learnNav->setLearnActive();
        ?>
        
        <?php
            require_once('functions/session_functions.php');
              $sessionHandler = new SessionFunctions();
              $errorMessage = "<div class='container'> <div class='panel panel-info col-sm-12'> <div class='panel-header'> <h2>Restricted access content</h2>  </div><div class='panel-body'> <p>You need to be logged in to access learning material. Login and try again</p></div></div></div>";

              if($sessionHandler->sessionActive())
              {

                  $bookId = @($_GET['book_id']);
                  
                //$dbCon database connection variable in learnDbController
                if ($bookId == null || empty($bookId))
                {
                
                    echo "<h2 style='text-align:center; line-height:4rem;' class='grey-text'>No topic chosen.<br> Kindly choose a topic to read.</h2>";
            
                }
                else
                {
                    require('esomoDbConnect.php');//includes an opening to the database
                    
                    include("formSelection.php");
                        
                    $formSelection = new FormSelection();
                    
                    $rawQuery = "SELECT * FROM esomo_books WHERE book_id=$bookId";

                    if($fetchBookQuery = $dbCon->prepare($rawQuery))//if we successfully prepared query set fetchSubsQuery
                    {
                        
                    $fetchBookQuery->execute();
                    $bookDataArray = $fetchBookQuery->get_result();

                    foreach ($bookDataArray as $bookData) {
                        
                        $tmp_curBookTitle = $bookData['book_title'];
                        $tmp_curBookTopic = $bookData['topic_id'];
                        $tmp_curBookPath = $bookData['book_path'];
                        $tmp_curBookThumbnailPath = $bookData['thumbnail_path'];
                        $tmp_curBookDateAdded = $bookData['date_added'];

                    }
                     
                        //var_dump($bookData);
                        
                    //Get the topic name and the subject name
                    $rawQuery = "SELECT topic_name, topic_description, subject_id FROM topics WHERE topic_id=$tmp_curBookTopic";
                        
                    if($fetchBookQuery = $dbCon->prepare($rawQuery))//if we successfully prepared query set fetchSubsQuery
                    {
                        
                    $fetchBookQuery->execute();
                    $bookDataArray = $fetchBookQuery->get_result();
                        
                    foreach ($bookDataArray as $bookData) {
                        
                        $tmp_curTopicName = $bookData['topic_name'];
                        $tmp_curTopicDescription = $bookData['topic_description'];
                        $currSubId = $bookData['subject_id'];
                        
                    }
                        
                    $subjectName = $formSelection->getSubjectName($currSubId);
                        
                    }
                        
                    echo "<h2 style='padding-left:2rem; padding-top:1rem; padding-bottom:1rem;' class='grey-text'><b>Subject: </b>$subjectName</h2>";
                    echo "<h3 style='padding-left:2rem; padding-top:0.5rem; padding-bottom:0.5rem;' class='grey-text'><b>Topic: </b>$tmp_curTopicName | <span class='primary-text-color-beige'>$tmp_curBookTitle</span></h3>"; 
                    echo "<br><div class='black'>";
                    echo "<div class='book-container'><header>$tmp_curBookTitle</header>";
                    echo "<div class='divider'></div><br>";
                     
                    //echo $tmp_curBookPath;
                        
                    echo "<object data='$tmp_curBookPath' type='application/pdf' width='100%'><p>Alternative text - include a link <a href='runner.pdf'>to the PDF!</a></p></object>";//Load content here. Book paths may be different between our project files/folders
                    echo "</div></div>";
                        
                } else
                {
                    echo "<p style='background-color:black;text-align:center;color:red;font-size:1.2em;'> could not execute query :".$dbCon->error." </p> ";//LIFE SAVER - HELPED FIND THE ERROR
                    #exit();
                }

                  //done generating content , close the div wrapper
                  echo "</div>";
                }
                include_once("footer.php"); #Footer if person is logged in
              }
              else #do this if the user is not logged in
              {
               echo $errorMessage;
              }
        
        ?>