<!DOCTYPE html>

<html lang="en">
    <head>
        <title>Admin</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <link  rel="stylesheet" type="text/css" href="css/theme.min.css"/>
       <link  rel="stylesheet" type="text/css" href="css/main.css"/>
    </head>
    
    <body id="homeBody">
      <?php 
        session_start();  
         include('../functions/session_functions.php');
        $sessionHandler = new SessionFunctions();

        #logout of student account
        //$sessionHandler->logoutNoRedirect();

        require_once('handlers/content_handler.php');
        $contentHandler = new ContentHandler();

$indexContent = <<<EOD
      
       <div class='container-fluid'>

        <div class='col-sm-3'>
          <h3>Admin Panel</h3>
          <ul class='nav nav-pills nav-stacked' id='nav_parent'>
            
            <li class='active'>
              <a  data-toggle= 'pill' href='#nav_content'>Content</a>
              </li>
            <li>
              <a  data-toggle= 'pill' href='#nav_ass'>Assignments</a>
              </li>
 
            <!-- To consider moving profile to main navigation -->
            <li>
              <a  data-toggle= 'pill' href='#nav_profile'>Profile</a>
            </li>

             <li>
              <a  data-toggle= 'pill' href='#nav_schedule'>Schedules</a>
            </li>
            
            <li>
              <a  data-toggle= 'pill' href='#nav_stats'>Statistics</a>
            </li>


            <li>
              <a href='?admin_action=admin_logout'>Logout</a>
            </li>

          </ul>
       </div>
EOD;
  
  
  //logout functionality
  $admin_action = @$_GET['admin_action'];
  if (isset($admin_action))
  {
    switch($admin_action)
    {
      case 'admin_logout':
        if ($sessionHandler->adminSessionActive())
        {
          $curFilePath = basename($_SERVER['SCRIPT_NAME']);

          #logout and reload the current page
          $sessionHandler->adminLogout($curFilePath);
        }
      break;

      default:#when admin_action is not a handled action
        echo "";

    }
  }

  //if the admin is logged in
  if ($sessionHandler->adminSessionActive())
  {      
    echo $indexContent;
  }
  else
  {
    header('Location:login.php');
    exit;
  }

  //$sessionHandler->printAdminVars();

?>
    <div class='tab-content container-fluid col-sm-8 col-sm-offset-1' id='pageContent'>

      <?php 

        //echo the divs that will be toggled by the pill navigation
        echo $contentHandler->getContent();//Default content is
        echo $contentHandler->getAss();
        echo $contentHandler->getSchedule();
        echo $contentHandler->getStats();
        echo $contentHandler->getProfile();
        echo $contentHandler->getLogout();
        // echo $contentHandler->getSubContent();
        // echo $contentHandler->getTopicContent();
      ?>
    </div>

   </div>
   <!--footer. Will add once I figure a way of having a sticky footer.-->
      
  </body>
   
   <script src="../js/jquery.min.js"></script>
   <script src="../js/bootstrap.min.js"></script>  
   <script src="js/dynamic_content.js"> </script>

</html>