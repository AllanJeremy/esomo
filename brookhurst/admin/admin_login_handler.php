<?php
	
	session_start();

	$g_admin_username=null;
	$g_admin_id=null;
	$g_admin_fName=null;
	$g_admin_lName=null;
	$g_admin_accessLevel=null;
	$g_admin_accessTitle=null;

	
	//initializes all admin session variables 
	function adminInitSessionVariables()#these are set by adminLoginValid function
	{
			$_SESSION['s_admin_username']=$GLOBALS['g_admin_username']; #admin_username - admin username [used in profile]

			$_SESSION['s_admin_id']=$GLOBALS['g_admin_id']; #admin_id - student id [used in profile]
			
			$_SESSION['s_admin_fName']=$GLOBALS['g_admin_fName']; #admin_fName - student first name [used in profile]
			
			$_SESSION['s_admin_lName']=$GLOBALS['g_admin_lName']; #admin_lName - student last name [used in profile]
			
			$_SESSION['s_admin_accessLevel']=$GLOBALS['g_admin_accessLevel']; #admin_accessLevel - integer representing access level of admin
			
			$_SESSION['s_admin_accessTitle']=$GLOBALS['g_admin_accessTitle']; #admin_accessTitle - text representing the access level id	
			
	}

	//logs the user in
	function adminLogin()
	{

		echo "<b>Pre-if Array in adminLogin() : </b>";
		print_r($_SESSION); 

		session_write_close();
		include_once('../functions/session_functions.php');

		$sessionHandler = new SessionFunctions();


		if(!$sessionHandler::adminSessionActive())//if session is not active start a new one
		{
			echo "logged in!<br><b>Logged in array [in if in adminLogin] : </b>";
			#redirect the user to another page
			print_r($_SESSION);
		}

		else//we are already logged in - do nothing
		{
			echo "<br><br>Already logged in!";

			echo "<br><b>Logged in array [in else in adminLogin] : </b>";
			#redirect the user to another page
			print_r($_SESSION);

		}

		$loginRedirectPath = 'index.php';#relative path from current location
		sleep(1.5);

		echo "<br><br>Session id : " .session_id();
		echo "<br><br><b>JUST BEFORE HEADER</b>";
		
		#redirect the user to another page
		print_r($_SESSION);#SESSION DATA RETAINED UP UNTIL HERE

		header('Location: '.$loginRedirectPath);
		exit();

	}



	//returns true if the login credentials are valid and false if they are not
	function adminLoginValid()#returns null if the query could not be run
	{	

	    #THIS FUNCTION WORKS FINE AND RETURNS CORRECT VALUES
		$errorMessage = '';//Error message incase anything happens
		$emailInput = $_POST['admin_loginEmailInput'];

		require('../esomoDbConnect.php');
	    require_once('../esomoErrorHandler.php');
		require_once('../functions/pass_encrypt.php');

        $passEncrypt = new PasswordEncrypt();//used for encryption

		$errHandler = new CustomErrorHandler();

		//sanitize
		$emailInput = htmlspecialchars($emailInput);

		//the query to select the email
		$query = "SELECT * FROM admin_accounts WHERE email=?";

		//check if the email exists
		if ($stmt = $dbCon->prepare($query))
		{
			$stmt->bind_param('s',$tmp_email);//Bind the parameters

			$tmp_email = $_POST['admin_loginEmailInput'];

			$stmt->execute();

			$result = $stmt->get_result();

			$rowCount = mysqli_num_rows($result);
			
			$passInput = $_POST['admin_loginPassInput'];

			
			//if there exists such a username/email
			if ($rowCount>0)
			{//username exists, check for validity 
			$passInput = htmlspecialchars($passInput);#sanitize

			foreach($result as $admin)
			{
				$tmp_salt = $admin['salt'];
				$tmp_pass = $admin['password'];
				$tmp_salt = $admin['salt'];
				$tmp_accessId = $admin['access_level_id'];

				$passInput = $passEncrypt->encryptPass($passInput,$tmp_salt);//encrypt the current password
										#initSessionVariables

				
				if ($passInput === $tmp_pass)#if the password is correct 
				{
					$accessInfo = getAccessInfo($tmp_accessId);

				//set the values of the globals only if the login input is correct
				$GLOBALS['g_admin_username'] = $admin['username'];
				$GLOBALS['g_admin_id'] = $admin['admin_acc_id'];
				$GLOBALS['g_admin_fName'] = $admin['f_name'];
				$GLOBALS['g_admin_lName'] = $admin['l_name'];
				$GLOBALS['g_admin_accessLevel'] = $admin['access_level_id'];
				$GLOBALS['g_admin_accessTitle'] =$accessInfo['level_name'];
				#correct values being set
				adminInitSessionVariables();	

				echo "<br><b>Valid check array : </b>";
				print_r($_SESSION);//variables set correctly until here
				
				echo "<br>";
				return true;	
				}
				else
				{
					return false;
				}
			}
			
			}	
			return false;
		}
		else//the email does not exist
		{
			return null;
		}
		
	}

	//returns access level info if found or 'Unknown Access level' if not found
	function getAccessInfo($accessLevelId)
	{
		$q = "SELECT level_name,level_description FROM access_levels WHERE access_level_id=$accessLevelId";

		require('../esomoDbConnect.php');//require a connection to the database
		
		$r = mysqli_query($dbCon,$q);#result - no need to prepare, not user input

		//if the value exists in database
		if (mysqli_num_rows($r)>0)
		{
			foreach($r as $accessInfo)//returns first found
			{
				return $accessInfo;
			}
		}else
		{
			return 'Unknown Access level';
		}

	}


include_once('../functions/session_functions.php');

$sessionHandler = new SessionFunctions();

#If user is not logged in yet
if(!$sessionHandler->adminSessionActive())
{	
	echo "ATTEMPTING LOGIN....<BR>";
	//check if the login is valid
	if (adminLoginValid())
	{
		echo "<br><b>Post valid/ pre-login array :</b> ";#does not run
		print_r($_SESSION);#does not run#session data persists to this point
		echo "<br> <br>";
		adminLogin();#login then exit the file

		exit;
	}
	else if (adminLoginValid()===false)//incorrect login credentials
	{
		header('Location:adminInvalidLogin.php');
		exit;
	}
	else
	{
		require('../esomoDbConnect.php');
		echo "<p><b>500 Error [Server error]</b>. Unable to get records from database, try again later</p>If the problem persists, <a>contact the system administrator</a>. <br>Error :".$dbCon->error;
	}

}		