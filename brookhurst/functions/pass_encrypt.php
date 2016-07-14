<?php

//USING CLASS SO THAT ENCRYPTION ALGORITHM CAN BE CHANGED ANYTIME
if(!class_exists('PasswordEncrypt'))
{
	class PasswordEncrypt
	{   
	  //returns encrypted password
	  function encryptPass($password)
	  {
	    return password_hash($password,PASSWORD_DEFAULT);
	  }
	}
}