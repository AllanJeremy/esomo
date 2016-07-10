<?php


if(!class_exists('CustomErrorHandler')){
class CustomErrorHandler
{	
	//THE CONSTANT USED FOR THE MINIMUM PASS LENGTH
	const MIN_PASS_LENGTH = 8;
	const MAX_PASS_LENGTH = 50;

	//checks if the subject ID of the URl is valid - return true if yes, return false if no
	function urlSubIdIsValid()
	{
		$subjectIdCount = 18;
		$subId = $_GET['subId'];

		//sanitize the input
		$subId = stripslashes(htmlspecialchars($subId));
		
		if ($subId!==null && is_numeric($subId))//if we have valid values
		{
			if ($subId>0 && $subId<=$subjectIdCount)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}

	}

	//checks if the form ID(fId) of the URl is valid - return true if yes, return false if no
	function urlFormIdIsValid()
	{
		$f_Id = $_GET['fId'];
		$f_Id = stripslashes(htmlspecialchars($f_Id));#sanitize		

		//Query to determine the number of forms currently available
		$classCountQuery = 'SELECT * FROM class_selection';//gets all records in the class_selection table
		
		require('esomoDbConnect.php');
		$result= $dbCon->query($classCountQuery);//returns the query result

		$classCount = mysqli_num_rows($result);

		//check if the urlFormId is valid
		if ($f_Id!==null && is_numeric($f_Id))
		{
			if ($f_Id>0 && $f_Id<=$classCount) {
				return TRUE;
			
			}else {
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
	}

	function urlTopicIdIsValid($startIndex,$tCount)//tCount is the total number of topics - varies[var]
	{
		$t_Id = $_GET['tId'];
		$t_Id = stripslashes(htmlspecialchars($t_Id));#sanitize

		if ($t_Id!==null && is_numeric($t_Id))
		{

			if ($t_Id>=$startIndex && $t_Id<=$tCount) {
				return TRUE;
				
			}else {

				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
	}
	//returns 1 if contains special chars
	function containsSpecialChars($variable)
	{
		return preg_match('/[^a-zA-Z]+/', $variable, $matches);
	}

	//draws a success panel
	function displaySignupSuccess()
	{
		//$_GET['sUp'] = '1';
		$msg = <<<EOD
        <div class='panel panel-success col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2'>
          <div class='panel-header'>
            <h4>Signup successful</h4>  
          </div>
          <div class='panel-body'>
            <p>Successfully signed up. You are good to go. Use your email and password to login</p>
          </div>
        </div>  
EOD;
		echo $msg;
	}

	//returns the admin_signup error. Returns '' or null if there is no error
	function getAdminSignupError()
	{
		$error = '';

		if (!$this->adminSignupContainsEmpty())
		{

			$_POST['admin_fNameInput'] = htmlspecialchars($_POST['admin_fNameInput']);
			
			//if it contains special characters
			if($this->containsSpecialChars($_POST['admin_fNameInput']))
			{
				$error .= '<p>First name contains special characters. This field only allows for alphanumeric characters(A-Z 0-9)</p> <br>';
			}
		
			$_POST['admin_lNameInput'] = htmlspecialchars($_POST['admin_lNameInput']);
			
			//if the last name contains special characters
			if($this->containsSpecialChars($_POST['admin_lNameInput']))
			{
				$error .= '<p>Last name contains special characters. This field only allows for alphanumeric characters(A-Z  0-9). </p><br>';
			}

			$_POST['admin_usernameInput']	 = htmlspecialchars($_POST['admin_usernameInput']);

			//if it contains special characters - consider allowing numbers to be appended for username
			if($this->containsSpecialChars($_POST['admin_usernameInput']))
			{
				$error .= '<br><p>Username contains special characters. This field only allows for alphanumeric characters(A-Z 0-9).</p>';
			}
			else
			{//if the username is a valid input - code below will run

				//check if there is another entry for that username in the database
				if ($this->usernameInDatabase($_POST['admin_usernameInput'],'admin_accounts'))
				{
					$error .= '<p>Username '.$_POST['admin_usernameInput'].' already exists. Try another username.</p>';
				}
			}		
		
			$_POST['emailInput'] = htmlspecialchars($_POST['admin_emailInput'] );

			//checking if the email exists in the database
			if($this->emailInDatabase($_POST['admin_emailInput'],'admin_accounts'))
			{
				$error .= '<br><p>The email [ '.$_POST['emailInput'].' ] already exists. Try another email address.</p>';
			}
			//sanitize the inputs
			$_POST['admin_phoneInput'] = htmlspecialchars($_POST['admin_phoneInput'] );			
		
			$_POST['admin_passwordInput']	 = htmlspecialchars($_POST['admin_passwordInput']);		
		
			$_POST['admin_passConfirmInput'] = htmlspecialchars($_POST['admin_passConfirmInput']);	
			
			//check if the confirmation password is same as the actual password
			if ($_POST['admin_passConfirmInput']!==$_POST['admin_passwordInput'])#if the passwords don't match
			{
				$error .= '<p>The entered passwords do not match.</p><br>';
			}
			else#if the passwords match
			{
				$passLength = strlen($_POST['admin_passwordInput']);

				if($passLength < self::MIN_PASS_LENGTH)#if the password is too short
				{
					$error .= ('<p>Your password is too short. Ensure it is at least '.self::MIN_PASS_LENGTH.' characters long</p>');
				}
				else if ($passLength > self::MAX_PASS_LENGTH)#if the password is too long
				{
					$error .= ('<p>Your password is too long as it exceeds the maximum password length (' . self::MAX_PASS_LENGTH . ' characters)</p>');
				}#otherwise the password is within the acceptable range
			}


		}
		else//something is null/empty
		{
			$error .= '<p>One or more fields have not been filled, ensure you fill the information in all fields.</p>';
		} 
		
		#if the error is not empty by this point add a tip for the user
		if ($error!=='')
		{
			#admin tip
			$error .= '<br><h5>Tip : you can click back on your browser to retrieve your previously entered information if need be.</h5>';
		}#if the $error is empty it remains empty

		return $error;
	}

	//returns true if admin_signup info contains an empty field
	function adminSignupContainsEmpty()
	{	
		//checks if all the variables in the are set
		if (isset($_POST['admin_fNameInput']) && isset($_POST['admin_lNameInput']) && isset($_POST['admin_usernameInput']) && isset($_POST['admin_emailInput']) && isset($_POST['admin_phoneInput']) && isset($_POST['admin_passwordInput']) && isset($_POST['admin_passConfirmInput']) 

			&& ($_POST['admin_fNameInput']!=='' && $_POST['admin_lNameInput']!=='' && $_POST['admin_usernameInput']!=='' && $_POST['admin_emailInput']!=='' &&   $_POST['admin_phoneInput'] && $_POST['admin_passwordInput']!=='' && $_POST['admin_passConfirmInput']!=='')
			)
		{
			return false;
		}else
		{
			return true;
		}
	}

	//returns the signup error. Returns '' if there is no error
	function getSignupError()
	{
		$error = '';

		if (!$this->signupContainsEmpty())
		{

			$_POST['fNameInput'] = htmlspecialchars($_POST['fNameInput']);
			
			//if it contains special characters
			if($this->containsSpecialChars($_POST['fNameInput']))
			{
				$error .= '<p>First name contains special characters. This field only allows for alphanumeric characters(A-Z 0-9)</p>';
			}
		
			$_POST['lNameInput'] = htmlspecialchars($_POST['lNameInput']);
			
			//if the last name contains special characters
			if($this->containsSpecialChars($_POST['lNameInput']))
			{
				$error .= '<p>Last name contains special characters. This field only allows for alphanumeric characters(A-Z  0-9). </p><br>';
			}

			$_POST['usernameInput']	 = htmlspecialchars($_POST['usernameInput']);

			//if it contains special characters - consider allowing numbers to be appended for username
			if($this->containsSpecialChars($_POST['usernameInput']))
			{
				$error .= '<br><p>Username contains special characters. This field only allows for alphanumeric characters(A-Z 0-9).</p>';
			}
			else
			{//if the username is a valid input - code below will run

				//check if there is another entry for that username in the database
				if ($this->usernameInDatabase($_POST['usernameInput'],'accounts'))
				{
					$error .= '<p>Username '.$_POST['usernameInput'].' already exists. Try another username.</p>';
				}
			}		
		
			$_POST['emailInput'] = htmlspecialchars($_POST['emailInput'] );

			//checking if the email exists in the database
			if($this->emailInDatabase($_POST['emailInput'],'accounts'))
			{
				$error .= '<br><p>The email [ '.$_POST['emailInput'].' ] already exists. Try another email address.</p>';
			}
			//sanitize the inputs
			$_POST['std_id_Input'] = htmlspecialchars($_POST['std_id_Input'] );			
		
			$_POST['passwordInput']	 = htmlspecialchars($_POST['passwordInput']);		
		
			$_POST['passConfirmInput'] = htmlspecialchars($_POST['passConfirmInput']);	
			
			//check if the confirmation password is same as the actual password
			if ($_POST['passConfirmInput']!==$_POST['passwordInput'])
			{
				$error .= 'The passwords do not match.<br>';
			}
			else#if the passwords match check if the length is acceptable
			{
				$passLength = strlen($_POST['passwordInput']);

				if($passLength < self::MIN_PASS_LENGTH)#if the password is too short
				{
					$error .= ('<p>Your password is too short. Ensure it is at least '.self::MIN_PASS_LENGTH.' characters long</p>');
				}
				else if ($passLength > self::MAX_PASS_LENGTH)#if the password is too long
				{
					$error .= ('<p>Your password is too long as it exceeds the maximum password length (' . self::MAX_PASS_LENGTH . ' characters)</p>');
				}#otherwise the password is within the acceptable range
			}



		}
		else//something is null
		{
			$error .= 'One or more fields have not been filled, ensure you fill the information in all fields.';
		} 
		
		#if the error is not empty by this point
		if ($error!=='')
		{
			$error .= '<br><h4>Tip : you can click back on your browser to retrieve your previously entered information if need be.</h4>';
		}#if the $error is empty it remains empty

		#finally return the error
		return $error;
	}
	//returns true if signup info has null
	function signupContainsEmpty()
	{	
		//checks if all the variables in the are set
		if (isset($_POST['fNameInput']) && isset($_POST['lNameInput']) && isset($_POST['usernameInput']) && isset($_POST['emailInput']) && isset($_POST['std_id_Input']) && isset($_POST['passwordInput']) && isset($_POST['passConfirmInput'])
			&&
			($_POST['fNameInput']!=='' && $_POST['lNameInput']!=='' && $_POST['usernameInput']!=='' && $_POST['emailInput']!=='' && $_POST['std_id_Input']!=='' && $_POST['passwordInput']!=='' && $_POST['passConfirmInput']!==''))
		{
			return false;

		}else
		{
			return true;
		}
	}

	//returns result if the email is in the database
	function emailInDatabase($email,$tableName)
	{
		require('esomoDbConnect.php');
		$query = "SELECT * FROM $tableName WHERE email=?";
		
		//prepare the statement
		if($stmt = $dbCon->prepare($query))
		{
			$stmt->bind_param('s',$tmp_email);
			$tmp_email = $email;#make the email parameter same as the user email input
			
			$stmt->execute();
			$result = $stmt->get_result();

			$rowCount = mysqli_num_rows($result);
			//check if the email already exists
			if($rowCount>0)
			{
				return $result;
			}
			else
			{
				return false;
			}
		
		}else
		{
			return null;#return null if we were unable to prepare the query used for the check
		}

	}

	//returns true if the username exists in the database
	function usernameInDatabase($userName,$tableName)
	{
		require('esomoDbConnect.php');
		$query = "SELECT username FROM $tableName WHERE username=?";

		if ($stmt = $dbCon->prepare($query))
		{
			$stmt->bind_param('s',$tmp_username);
			$tmp_username = $userName; #make the username parameter same as the user username input
			$stmt->execute();
			$result = $stmt->get_result();

			$uNameRowCount = mysqli_num_rows($result);

			if ($uNameRowCount > 0 )
			{
				return true;
			}else
			{
				return false;
			}
		}else
		{
			return null;#return null if we were unable to prepare the query used for the check
		}
	}

	//display sign up error
	function displaySignupError($message)
	{ 
		$title = 'Something went wrong with your signup';
		// warning panel
		$error = <<<EOD
        <div class='panel panel-warning col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2'>
          <div class='panel-header'>
            <h3>$title</h3>  
          </div>
          <div class='panel-body'>
            <p>$message</p>
          </div>
        </div>  
EOD;
		echo $error;
	}
	//for when a page is not found
	function displayPageNotFoundError()
	{
		$errorMessage = <<<EOD
		<div class="container well col-md-12 col-xs-12 col-sm-12">
			<h4>The page you are looking for cannot be found or does not exist.</h4><br>
			<p>If you think this is a mistake, <a href="#"> contact the web administrator</a>
			</p>
		</div>
EOD;

	echo $errorMessage;
	}

	function displayInvalidTopicPage()
	{
	$errorMessage = <<<EOD
			<div class="container well col-md-8 col-md-offset-1 col-xs-12 col-sm-12">
				<h4>The page you are looking for cannot be found or does not exist.</h4><br>
				<p>If you think this is a mistake, <a href="#"> contact the web administrator</a>
				</p>
			</div>
EOD;
	echo $errorMessage;
	}

	//removes any special symbols from the 
	function stripSpecialChars($stringInput)
	{
		$stringInput = preg_replace("/[^a-zA-Z0-9]/", "", $stringInput);
		$stringInput = htmlspecialchars($stringInput);
		return $stringInput;
	}

}#end of class

}#end of if