<?php
class SessionFunctions
{

	
	//returns true if the user session is active and false if it is not
	function sessionActive()
	{	

		//if the session variables are set abd are not empty
		if (   (@$_SESSION['std_username']!==''&& @$_SESSION['std_username']!==null)
			&& (@$_SESSION['std_id']!=='' && @$_SESSION['std_id']!==null)
			&& (@$_SESSION['std_fName']!=='' && @$_SESSION['std_fName']!==null)
			&& (@$_SESSION['std_lName']!=='' && @$_SESSION['std_lName']!==null)
			&& (@$_SESSION['std_stream_id']!=='' && @$_SESSION['std_stream_id']!==null)
			&& (@$_SESSION['std_class_id']!=='' && @$_SESSION['std_class_id']!==null)
			)
		{
			//echo "session active";
			return true;
		}else
		{
			// echo "session inactive";
			return false;
		}
	}


	//returns true if the user session is active and false if it is not
	public function adminSessionActive()
	{	
		//return true;#works with this on.

		//if the session variables are set abd are not empty
		if (   (@$_SESSION['s_admin_username']!==''&& @$_SESSION['s_admin_username']!==null)
			&& (@$_SESSION['s_admin_id']!=='' && $_SESSION['s_admin_id']!==null)
			&& (@$_SESSION['s_admin_fName']!=='' && @$_SESSION['s_admin_fName']!==null)
			&& (@$_SESSION['s_admin_lName']!=='' && @$_SESSION['s_admin_lName']!==null)
			&& (@$_SESSION['s_admin_accessLevel']!=='' && @$_SESSION['s_admin_accessLevel']!==null)
			&& (@$_SESSION['s_admin_accessTitle']!=='' && @$_SESSION['s_admin_accessTitle']!==null)
			)
		{
			// echo "session active"; #works as expected
			return true;
		}else
		{
			// echo "session inactive";
			return false;
		}
	}

	function printAdminVars()
	{
		
		print_r($_SESSION);
		
	}
	// //when the admin clicks logout
	function adminLogout($currentFilePath)
	{
		session_destroy();
		
		sleep(2);//delay 2 seconds to give the user time to cancel
		
		unset($_SESSION['s_admin_username']);
		unset($_SESSION['s_admin_id']);
		unset($_SESSION['s_admin_fName']);
		unset($_SESSION['s_admin_lName']);
		unset($_SESSION['s_admin_accessLevel']);
		unset($_SESSION['s_admin_accessTitle']);

		session_write_close();
		header('Location:'.$currentFilePath);

	}

	//logs the user out and redirects to another page
	function logout($currentFilePath)
	{
		sleep(2);//delay 2 seconds to give the user time to cancel

		session_destroy();
		
		#unset all session variables and suppress errors
		unset($_SESSION['std_username']);
		unset($_SESSION['std_id']);
		unset($_SESSION['std_fName']);
		unset($_SESSION['std_lName']);
		unset($_SESSION['std_stream_id']);
		unset($_SESSION['std_class_id']);

		session_write_close();
		header('Location:'.$currentFilePath);
	}

	//logs the user out without redirecting them
	function logoutNoRedirect()
	{
		#unset all session variables and suppress errors
		if($this->sessionActive())
		{		

		sleep(2);//delay 2 seconds to give the user time to cancel

		session_destroy();
		unset($_SESSION['std_username']);
		unset($_SESSION['std_id']);
		unset($_SESSION['std_fName']);
		unset($_SESSION['std_lName']);
		unset($_SESSION['std_stream_id']);
		unset($_SESSION['std_class_id']);
		}
	}
//displays pageContent if user !logged in, otherwise, redirects them to $redirectPath
	function redirectLoggedUser($pageContent,$redirectPath)
	{
		if (!$this->sessionActive())#echo content only if not logged in
		{
			echo $pageContent;
		}
		else
		{
			session_write_close();
			header('Location:'.$redirectPath);
		}
	}

	function redirectNotLoggedUser($pageContent,$redirectPath)
	{
		if ($this->sessionActive())#echo content only if not logged in
		{
			echo $pageContent;
		}
		else
		{
			session_write_close();
			header('Location:'.$redirectPath);
		}
	}
	//redirect a logged admin
	function redirectLoggedAdmin($pageContent,$redirectPath)
	{
		if (!$this->adminSessionActive())#echo content only if not logged in
		{
			echo $pageContent;
		}
		else
		{
			session_write_close();
			header('Location:'.$redirectPath);
		}
	}
}