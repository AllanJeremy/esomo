<?php
@session_start();
//this class handles the navigation system throughout the entire website
class Navigation
{
	//paths
	public $learnPath;
	public $indexPath;
	public $signupPath;
	public $forgotPassPath;
	public $testsPath;
	public $assignmentPath;
	
	public $loginHandlerPath;

	//
	protected $indexClass;
	protected $learnClass;
	protected $testsClass;
	protected $assignmentClass;
	
	
	function __construct($pathIndex,$pathLearn,$pathTests,$pathSignup,$pathForgotPass,$assignmentPath)
	{	
	
		$this->loginHandlerPath = 'loginHandler.php';//By default the login handler path is in the default location

		$this->indexClass = $this->learnClass = $this->testsClass = '';

		$this->indexPath = $pathIndex;
		$this->learnPath = $pathLearn;
		$this->testsPath = $pathTests;
		$this->signupPath = $pathSignup;
		$this->forgotPassPath = $pathForgotPass;
		$this->assignmentPath = $assignmentPath;
	}


	//update the nav and set no active class -called evertime the nav is activated
	function updateNav()
	{	
		$this->genNavPart();
		
		include_once('functions/session_functions.php');

		$sessionHandler = new SessionFunctions();

		if ($sessionHandler->sessionActive())
		{
			$this->genLogoutPart();//generate the logout section of the page

		}
		else //If the session is not active
		{
			$this->genSignupPart();
		}
		
		$this->closeNav();
	}

	function genNavPart()
	{
		$learnPath = $this->learnPath;
		$indexPath = $this->indexPath;
		$testsPath = $this->testsPath;
		$assignmentPath = $this->assignmentPath;

		$indexClass = $this->indexClass;
		$learnClass = $this->learnClass;
		$testsClass = $this->testsClass;
		$assignmentClass = $this->assignmentClass;

		//dynamically determine the active page
		if(!defined('ACTIVE_NAV_CLASS'))
		{define('ACTIVE_NAV_CLASS','class=\'active\'');}

		$navPart = "
		<nav class='navbar navbar-default'>
          <div class='container-fluid'>
                <div class='navbar-head'>
                    <a class='navbar-brand' href='#'>Logo</a>
                </div>
            

    <div class='collapse navbar-collapse'>
        <ul class='nav navbar-nav'>
            <li $indexClass><a href='$indexPath'>HOME
            </a>
            </li>  

            <li $learnClass><a href='$learnPath'>
            	LEARN</a>
            </li>  

            <li $assignmentClass><a href='$assignmentPath'>ASSIGNMENTS
            	</a>
            </li> 

            <li $testsClass><a href='$testsPath'>TESTS
            </a>
            </li>
                 
        </ul>
";
		echo $navPart;
	}

	function genSignupPart()
	{

		$signupPath = $this->signupPath;
		$forgotPassPath = $this->forgotPassPath;
		$loginHandlerPath = $this->loginHandlerPath;

		$signupPart = "

              <div class='myNavInputs'>
                <button class='btn btn-primary' data-toggle='modal' data-target='#loginModal'>Login</button>
                <a href=$signupPath class='btn btn-success'>Sign Up</a>
                
              </div>
               
              <div id='loginModal' class='modal fade' role='dialog'>
              
                <div class='modal-dialog'>

                  
                  <div class='modal-content'>
                    <div class='modal-header'>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                      <h4 class='modal-title'>Login to your E-somo account</h4>
                    </div>

                    <div class='modal-body'>

                    <form action=$loginHandlerPath method='POST'>
                      <input type='email' id='email' class='col-sm-offset-3 col-sm-6' placeholder='Email' name='loginUserInput'><br/><br/><br/>
                      
                      <input type='password' id='pass' class='col-sm-offset-3 col-sm-6'  placeholder='Password' name='loginPassInput'><br/><br/><br/>

                      
                        <button class='btn btn-primary' id='loginButton'>Login</button>
                        <a class='col-sm-offset-1' href='$forgotPassPath'> Forgot password?</a> <br/><br/>
                     </form>

                    </div>

                    <div class='modal-footer'>
                      <h5> Don\'t have an account? <a href='$signupPath'> Sign up now </a></h5>
                    </div>

                    </div>
                  </div>

                </div>
              </div>
";	
	echo $signupPart;

	}

	//generates the logout part
	function genLogoutPart()
	{//if we are here, it means we are logged in
		$logoutPart = '
		<div class="myNavInputs">
		<a href="?action=logout" class="btn btn-success"><span class="glyphicon glyphicon-off"></span>  Logout</a>

		</div>
		';	
		$this->checkLogout();
		echo $logoutPart;
	}

	//closes the navigation and div wrapper tags
	function closeNav()
	{
		echo "</div> \n </nav>";
	}

	//check if the user has logged out - use only when the user is logged in
	private function checkLogout()
	{
		$actionVar = @($_GET['action']);#stores the current action - @ to suppress errors

		//if the user has requested to logout
		if (isset($actionVar))
		{	
			switch($actionVar)
			{
				case 'logout':#if the action is logout
					
					include_once('functions/session_functions.php');

					$sHandler = new SessionFunctions();
					$curFilePath = basename($_SERVER['SCRIPT_NAME']);

					//check if the user is logged in
					if ($sHandler->sessionActive())
					{
						$sHandler->logout($curFilePath);
					}
					break;

				default:#a value was entered for action but it was invalid	
			}
			
		}
	}
	#NOTE : FOR EVERY NEW NAV OPTION ADDED, A setNavOptionActive FUNCTION MUST BE ADDED FOR FUNCTIONALITY
	

	//resets all the active classes
	private function resetAllActive()
	{
		$this->indexClass = '';
		$this->testsClass = '';
		$this->learnClass = '';
		$this->assignmentClass='';
	}

	//sets the index class as active then updates the nav
	function setIndexActive()
	{
		$this->resetAllActive();
		$this->indexClass = 'class=\'active\'';

		$this->updateNav();
	}

	function setAssignmentActive()
	{
		$this->resetAllActive();
		$this->assignmentClass='class=\'active\'';
		$this->updateNav();
	}
	//sets the learn class as active then updates the nav
	function setLearnActive()
	{
		$this->resetAllActive();
		$this->learnClass = 'class=\'active\'';

		$this->updateNav();
	}

	//sets the tests class as active then updates the nav
	function setTestsActive()
	{
		$this->resetAllActive();
		$this->testsClass = 'class=\'active\'';

		$this->updateNav();
	}
}