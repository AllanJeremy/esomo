<?php

//USING CLASS SO THAT ENCRYPTION ALGORITHM CAN BE CHANGED ANYTIME
if(!class_exists('PasswordEncrypt'))
{
	class PasswordEncrypt
	{   
	  //returns encrypted password
	  function encryptPass($password,$saltInput)
	  {
	    return crypt($password,$saltInput);
	  }
	}
}