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
        $assNav = new Navigation('index.php','learn.php','tests.php','account/signup.php','account/forgot.php','#');
        $assNav->loginHandlerPath = 'account/loginHandler.php';
        $assNav->setAssignmentActive();
    ?>
    <?php
      
      $content = ' <div class="container">

        <!--4 segments at the bottom-->
        <div class="hSegmentWrapper">
          <div class="col-sm-10 col-sm-offset-1 col-xs-12">
            <div class="well">
              <h3>Assignments</h3><br>
              <p>Assignments will be posted here</p>
            </div>
          </div>
          
       </div>  ';
      require_once('functions/session_functions.php');
      $sessionHandler = new SessionFunctions();
      $errorMessage = "<div class='container'> <div class='panel panel-info col-sm-12'> <div class='panel-header'> <h2>Restricted access content</h2>  </div><div class='panel-body'> <p>You need to be logged in to access assignments. Login and try again.</p></div></div></div>";

      #message to be shown when there are no assignments
      $nilAssignmentMessage = "<div class='container'> <div class='panel panel-primary col-sm-12'> <div class='panel-header'> <h2>No assignments available</h2>  </div><div class='panel-body'> <p>There are currently no assignments posted for your class or the validity for assignments that were available has expired. Assignments for your will be displayed here when they are posted by your teachers/lecturers.<br> If you believe this is a mistake, contact your teacher/lecturer for further guidance.</p></div></div></div>";

      if($sessionHandler->sessionActive())
      {
        $content = getAssignments();
        //if there are assignments available
        if($content!==0 && $content!=null)
        {
          
          echo $content;
        }else
        {
          echo $nilAssignmentMessage;
        }
        
      }
      else {
        echo $errorMessage;
      }  
    ?>

    <?php
      //functions

      #USE ONLY WHEN USER IS LOGGED IN - otherwise does not work correctly
      function getAssignments()#returns assignment if found and 0 if not
      {
        $assContent = 0;

        

        $ass_query = "SELECT * FROM assignments WHERE class_id=? AND stream_id=?";

        require_once('esomoDbConnect.php');#cinnect to the database

        if($ass_stmt = $dbCon->prepare($ass_query))#set the variable if valid
        {
          $ass_stmt->bind_param('ii',$tmp_class_id,$tmp_stream_id);
          $tmp_class_id = $_SESSION['std_class_id'];
          $tmp_stream_id = $_SESSION['std_stream_id'];

          sleep(0.25);#delay shortly before executing this
          $ass_stmt->execute();#EXECUTE THE QUERY - MUST WORK

          $result = $ass_stmt->get_result();

          #if there are any assignments
          if (mysqli_num_rows($result)>0)#works well
          {
            $assContent = "";
            $assContent .= "<div class='container-fluid well table-responsive'><table class='table'>";#create new table
            $assContent .=  "<tr><th class='center_text'>Title</th>
              <th class='center_text'>Sent by</th>
              <th class='center_text'>Date sent</th>
              <th class='center_text'>Description</th>
              <th class='center_text'>Due On</th>
              <th class='center_text'>Download</th></tr>";#table headers

            
            foreach($result as $tableItem)
            {
              #temporary file path
              $curItem_path = $tableItem['ass_file_path'];
              
              $dl_link = '#';#Download link
              $dl_title = '';#Download title

                           #add content generation here
              $assContent .= "<tr>
               <td>".$tableItem['ass_title']."</td>"#Assignment title
              ."<td>".getTeacherName($tableItem['teacher_id'])."</td>"#Assignment sender
              ."<td>".$tableItem['sent_date']."</td>"#Date sent
              ."<td>".$tableItem['ass_description']."</td>"#Description
              #due date there
              ."<td>".$tableItem['due_date']."</td>";

              #If the current file path is not empty - set the download link
              if($curItem_path!='')
              {
                $dl_link = $curItem_path;
                $dl_title = $tableItem['ass_title'];
                $assContent .= "<td><a href='$dl_link' class='btn btn-info col-xs-12' download='$dl_title'>Download</a></td>"#DownloadButton
              ."</tr>";
              }
              else#if there is no file path, disable download feature
              {
                $assContent .= "<td><a href='javascript:void(0)' class='btn btn-info col-xs-12'>Download</a></td>"#DownloadButton
              ."</tr>";
              }
              
            }

            

            #end of content generation

            $assContent .=  "</table></div>";#close the table tag
            return $assContent;
          }
          else#if there are no assignments available
          {
            $assContent = 0;
            return $assContent;
          }

         echo "<p style='background-color:white'>Successfully prepared query</p>";
        }
        else
        {
          echo "<p style='background-color:black;color:red'>Failed to prepare query<br>Error:".$dbCon->error."</p>";
          return null;
        }

      }

      //gets the name of the teacher given an id
      function getTeacherName($teacherId)
      {
        //selects username in admin_accounts where the admins access level is > 2 [teacher or higher]
        $teacher_query = "SELECT username FROM admin_accounts WHERE admin_acc_id=? AND access_level_id>=2";

        require('esomoDbConnect.php');
        if($t_stmt = $dbCon->prepare($teacher_query)){

          $t_stmt->bind_param('s',$tmp_teacher_id);
          $tmp_teacher_id = $teacherId;//Set the bound param to the teacher id

          $t_stmt->execute();
          $result = $t_stmt->get_result();

          //if the record exists in the database
          if(mysqli_num_rows($result)>0)
          {
            foreach($result as $tr)
            {
              return $tr['username'];
            }
          }
          else//record does not exist in database
          {
            return "invalid tr_id: tr not found";
          }
        }else
        {
         return "<p style='background-color:black;color:red'>Failed to prepare teacher query.<br>Error:".$dbCon->error."</p>";
        }

      }

    ?>
       <!--footer. Will add once I figure a way of having a sticky footer.-->

    </body>
   <script src="js/jquery.min.js"></script>
   <script src="js/bootstrap.min.js"></script>
</html>