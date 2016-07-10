<?php
	//Define the constants if they have not been defined

	// class DbConnection{}
	if(!defined('SC_SCIENCES'))
	{	define('SC_SCIENCES','sciences');  }

	if (!defined('SC_HUMANITIES'))
	{	define('SC_HUMANITIES','humanities');  }

	if (!defined('SC_LANGUAGES'))
	{	define('SC_LANGUAGES','languages');  }
	
	if (!defined('SC_EXTRAS'))
	{	define('SC_EXTRAS','extras');  }
	
	//database variables
	if (!defined('DB_HOST'))
	{	define('DB_HOST','localhost');  }

	if (!defined('DB_USERNAME'))
	{	define('DB_USERNAME','root');  }
	
	if (!defined('DB_PASSWORD'))
	{	define('DB_PASSWORD','');  }

	if (!defined('DB_NAME'))
	{	define('DB_NAME','esomo');  }
	
	if(!isset($dbCon))//makes sure we don't open multiple connections
	{
		$dbCon = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);//create a new conn if no connection exists

		if ($dbCon->error)//check if there is any error when connecting to the database
		{
			$errorStyle = 'height:100%;color:red;background-color:black;font-size:1.2em;';
			echo "<p style=$errorStyle>" . $dbCon->error . "</p>";
			exit();//exit the file execution i we did not get a successful connection to the database
		}
	}
	#code below this will run if the database connection is successful

	//define constants for class_selection table
	if (!defined('HIGH_SCHOOL'))
	{	define('HIGH_SCHOOL','high_school');  }
	if (!defined('PRIMARY_SCHOOL'))
	{	define('PRIMARY_SCHOOL','primary_school');  }
	if (!defined('KINDERGATEN'))
	{	define('KINDERGATEN','kindergaten');  }