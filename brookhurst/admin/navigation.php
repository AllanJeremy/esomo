<?php

//this class handles the navigation system throughout the entire website
class AdminNav
{
	//paths
	public $learnPath;
	public $indexPath;
	public $signupPath;
	public $forgotPassPath;
	public $testsPath;
	public $assignmentPath;
	//
	protected $indexClass;
	protected $learnClass;
	protected $testsClass;
	protected $assignmentClass;
	
	function __construct($pathIndex,$pathLearn,$pathTests,$pathSignup,$pathForgotPass,$assignmentPath)
	{		
		$this->indexClass = $this->learnClass = $this->testsClass = '';

		$this->indexPath = $pathIndex;
		$this->learnPath = $pathLearn;
		$this->testsPath = $pathTests;
		$this->signupPath = $pathSignup;
		$this->forgotPassPath = $pathForgotPass;
		$this->assignmentPath = $assignmentPath;
	}

	//update the nav and set no active class
	function updateNav()
	{	
		$this->genNavPart();
		
		if ($this->sessionActive())
		{
			$this->genLogoutPart();
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
                    <a class='navbar-brand' href='#'>Brookhurst</a>
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

                    
                      <input type='email' id='email' class='col-sm-offset-3 col-sm-6' placeholder='Email' name='loginUserInput'><br/><br/><br/>
                      
                      <input type='password' id='pass' class='col-sm-offset-3 col-sm-6'  placeholder='Password' name='loginPassInput'><br/><br/><br/>

                      
                        <button class='btn btn-primary' id='loginButton'>Login</button>
                        <a class='col-sm-offset-1' href='$forgotPassPath'> Forgot password?</a> <br/><br/>
                     
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

	function genLogoutPart()
	{
		$logoutPart = '
  <div class="myNavInputs">
    <a href="#action=logout" class="btn btn-success">Logout</a>
    
  </div>
';
	echo $logoutPart;
	}

	//returns true if the session is active
	function sessionActive()
	{
		return (isset($_SESSION['userId']) && isset($_SESSION['accType']));
	}

	//closes the navigation and div wrapper tags
	function closeNav()
	{
		echo "</div> \n </nav>";
	}


	#NOTE : FOR EVERY NEW NAV OPTION ADDED, A setNavOptionActive FUNCTION MUST BE ADDED FOR FUNCTIONALITY
	

	//resets all the active classes
	function resetAllActive()
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