<?php
	
	//session_start();
	$std_username='';
	$std_id='';
	$std_fName='';
	$std_lName='';
	$std_stream_id='';
	$std_class_id='';

	//initializes all session variables
	function initSessionVariables()
	{
			$_SESSION['std_username']=$GLOBALS['std_username']; #username - student username [used in profile]

			$_SESSION['std_id']=$GLOBALS['std_id']; #student_id - student id [used in profile]
			
			$_SESSION['std_fName']=$GLOBALS['std_fName']; #std_fName - student first name [used in profile]
			
			$_SESSION['std_lName']=$GLOBALS['std_lName']; #std_lName - student last name [used in profile]
			
			$_SESSION['std_stream_id']=$GLOBALS['std_stream_id']; #stream_id - student stream [used in assignments]
			
			$_SESSION['std_class_id']=$GLOBALS['std_class_id']; #class_id - student class [used in assignments]		
	}

	//logs the user in
	function login()
	{

		session_start();
		
		initSessionVariables();

		include_once('../functions/session_functions.php');

		$sessionHandler = new SessionFunctions();

		if(!$sessionHandler->sessionActive())//if session is not active start a new one
		{
			echo "logged in!";
			#redirect the user to another page
		}

		else//we are already logged in - do nothing
		{
			echo "Already logged in!";

		}

		$loginRedirectPath = '../learn.php';#relative path from current location
		sleep(1.5);
		header('Location: '.$loginRedirectPath);

	}



	//returns true if the login credentials are valid and false if they are not
	function loginValid()#returns null if the query could not be run
	{	

		$errorMessage = '';//Error message incase anything happens


		require('../esomoDbConnect.php');
		$query = 'SELECT * FROM accounts WHERE  email =?';
		
		$tmp_email = $_POST['loginUserInput'];
		//initialize the password input to be used for comparison
		$passInput = $_POST['loginPassInput'];
		
		if ($stmt = $dbCon->prepare($query))
		{
			$stmt->bind_param('s',$tmp_email);//Bind the parameters

			

			$stmt->execute();

			$result = $stmt->get_result();

			$rowCount = mysqli_num_rows($result);


			
			//if there exists such a username/email
			if ($rowCount>0)
			{//username exists, check for validity 

				require('../functions/pass_encrypt.php');

            	$passEncrypt = new PasswordEncrypt();

				foreach ($result as $item) {
					# password information from database
					$tmp_salt = $item['salt'];//get the current salt
					$tmp_password = $item['password'];//get the current password

					$passInput =  $passEncrypt->encryptPass($passInput,$tmp_salt);#encrypt the password for comparison

					//student information variables from database
					$tmp_stud_id = $item['student_id'];
					
					//if the password entered is the same as the password in the database
					if ($passInput == $tmp_password)#credentials are valid, return true
					{
						
						
						$student = getStudentInfo($tmp_stud_id);

						if($student!==null)//if the student query ran successfully
						{
						
						//set all the global variables that will be used by session
						$GLOBALS['std_username'] = $item['username'];
						$GLOBALS['std_id'] = $tmp_stud_id;
						$GLOBALS['std_fName'] = $item['first_name'];
						$GLOBALS['std_lName'] = $item['last_name'];
						$GLOBALS['std_stream_id'] = $student['stream_id'];
						$GLOBALS['std_class_id'] = $student['class_id'];

						initSessionVariables();

						return true;
						}else
						{
							return null;
						}

					}
				}
				unset($item);//unset item after usage in the foreach loop
				return false;//if we get to oint - means that the password is incorrect
			}
			else
			{
				return false;
			}

		}else
		{
			// echo "<h3>UNABLE TO PREPARE THE QUERY</h3><p>".$dbCon->error."</p><br>";
			return null;
		}
	}

	//returns  the student array
	function getStudentInfo($studentId)
	{
		require('../esomoDbConnect.php');

		$std_query = 'SELECT class_id,stream_id FROM students WHERE student_id=?';#query to select student information from student table
		
		if($std_stmt = $dbCon->prepare($std_query))
		{
			$std_stmt->bind_param('i',$tmp_id);//bind parameter for getting student info
			$tmp_id = $studentId;#use input from the function parameter as the temporary id
			
			$std_stmt->execute();
			$result = $std_stmt->get_result();#works correctly. gets the result of the student query

			//if the student exists in the student database
			if(mysqli_num_rows($result)>0)
			{
				foreach ($result as $student) {
					#get the student class id and stream id - working correctly
					return $student;
				}
			}
			else//student was not found in the student database
			{
				return null;
			}

			// echo "successfully prepared student query";

		}else
		{
			// echo "failed to prepare the student fetch query.<br>Error: ".$dbCon->error;
		}
	}
	
	//check if the login is valid
	if (loginValid()===true)
	{
		login();#login then exit the file
		exit;
	}
	else if (loginValid()===false)//incorrect login credentials
	{
		header('Location: invalidLogin.php');
		exit;
	}
	else
	{
		echo "<p><b>500 Error [Server error]</b>. Unable to get records from database, try again later</p>If the problem persists, <a>contact the system administrator</a>. Error code : 61311";
	}

