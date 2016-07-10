<?php

		define('DB_USER','test');
		define('DB_PASSWORD','password');
		define('DB_HOST','localhost');
		define('DB_NAME','test_subjects');

		$testVar=10
		$learnSubjectDbConn = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

		if ($learnSubjectDbConn->connect_error)
		{
			echo "Error, could not connect to the database. <br> Error message ". $learnSubjectDbConn->connect_error;
			exit();
		}

		//if we get here it means we have a successful connection
		


