<?php
#CONTAINS FUNCTIONS THAT RETURN DATABASE ITEMS



class DbInfo
{
#returns available streams
function getAvailableStreams()
{
	require("../esomoDbConnect.php");
	$q = "SELECT * FROM streams";

	if($result = mysqli_query($dbCon,$q))
	{	
		if(mysqli_num_rows($result)>0)
		{
			return $result;
		}
		else
		{
			return 0;
		}
	}
	else
	{
		return false;
	}
}

#returns available classes
function getAvailableClasses()
{
	require("../esomoDbConnect.php");
	$q = "SELECT * FROM class_selection";

	if($result = mysqli_query($dbCon,$q))
	{	
		if(mysqli_num_rows($result)>0)
		{
			return $result;
		}
		else
		{
			return 0;
		}
	}
	else
	{
		return false;
	}	
}
}#end of class