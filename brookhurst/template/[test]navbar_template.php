<?php   

//constants defining the current available directories for html/php
#add any directories needed by the project php here
define('ROOT_DIR','Esomo');#root directory for the project - will be empty if the project is plain on a server
define('ACCOUNT_DIR',(ROOT_DIR .'\account'));
define('TEMPLATE_DIR',(ROOT_DIR .'\template'));
define('CURRENT_HOST','localhost:1234/');//current host directory
define('SIGNUP_PAGE_NAME','signup.php');

//variable to store the generated path to the sign up page based on current position
$genSignupPage;



//updates the navigation bar using correct paths
function updateNavbar()
{
  if (getcwd())
  {
    $curDir = getcwd(); //Current full directory path
    $curFileName = basename($_SERVER['REQUEST_URI']);//current file name 

    $dirPathLen = strlen($curDir);
    $rootPos = strpos($curDir,ROOT_DIR);//the number representing the position of the occurence of the root directory

    $currentRelPath= trim(substr($curDir,$rootPos,$dirPathLen));//getting the actual path, trim to ensure no whitespace

    $testVar = basename($curDir);

    //checks the current path and sets a relative path based on the current path
    switch($currentRelPath)
    {
      case  ROOT_DIR:
        echo "<p style='color:white'>In root directory</p>";#debug line - to delete
        $GLOBALS["genSignupPage"] = ACCOUNT_DIR . SIGNUP_PAGE_NAME;
        break;
      
      case ACCOUNT_DIR:
        //echo "<p style='color:green'>In account directory</p>";#debug line - to delete
        
        
        //check if the file is in the sign up page directory
        if($curFileName == SIGNUP_PAGE_NAME)//if we are in the sign up page, then # as the path
        {
          $GLOBALS["genSignupPage"]="#";//access the global value the genSignupPage variable
        }
        else
        {
          $GLOBALS["genSignupPage"]=  SIGNUP_PAGE_NAME;//set the variable to the file name in the same page
        }
        break;
      
      case TEMPLATE_DIR:#not supposed to be accessed directly
        echo "<p style='color:yellow'>In template directory</p>";#debug line - to delete
        $GLOBALS["genSignupPage"] = ("../" . ACCOUNT_DIR . SIGNUP_PAGE_NAME);
        break;

      default:
        echo "Unknown path";#debug line - to delete
    }
  }

  else
  {
    echo "<p> Error, unable to get the current working directory</p>";
    
  }

  //If the code gets here it means we were able to get into the current directory
}



$curDir;//current working directory


//echo $str1;

updateNavbar();

//String representing our navigation bar- edits to the navbar go here
$navCodeStr = <<<EOD
      <nav class="navbar navbar-default">
          <div class="container-fluid">
                <div class="navbar-head">
                    <a class="navbar-brand">Logo</a>
                </div>
            

            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">HOME</a></li>  
                    <li><a href="learn.html">LEARN</a></li>    
                    <li><a href="tests.html">TESTS</a></li>      
                </ul>

              <!--Nav inputs, for if I need to add any more navigation controls at the end of the navigation bar-->
              <div class="myNavInputs">
                <button class="btn btn-primary" data-toggle="modal" data-target="#loginModal">Login</button>
                <a href="$genSignupPage" class="btn btn-success">Sign Up</a>
                
              </div>
               
              <div id="loginModal" class="modal fade" role="dialog">
              
                <div class="modal-dialog">

                  <!-- Content for modal window-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Login to your E-somo account</h4>
                    </div>

                    <div class="modal-body">
                      <input type="email" id="email" class="col-sm-offset-3 col-sm-6" placeholder="Email"><br/><br/><br/>
                      <input type="password" id="pass" class="col-sm-offset-3 col-sm-6"  placeholder="Password"><br/><br/><br/>

                      <div class="loginControls">
                        <button class="btn btn-primary" id="loginButton">Login</button>
                        <a class="col-sm-offset-1" href="account/forgot.html">Forgot password?</a> <br/><br/>
                      </div>
                    </div>

                    <div class="modal-footer">
                      <h5> Don't have an account? <a href="$genSignupPage"> Sign up now </a></h5>
                    </div>

                    </div>
                  </div>

                </div>
              </div>

             </div>
          </div>
       </nav>
EOD;

echo $navCodeStr;
?> 