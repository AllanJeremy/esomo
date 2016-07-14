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

function getAvailableSchedules($teacher_id)
{
	require("../esomoDbConnect.php");
	$q = "SELECT * FROM schedules WHERE teacher_id=$teacher_id";

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

function getClassName($class_id)
{
	{
	require("../esomoDbConnect.php");
	$q = "SELECT class_name FROM class_selection WHERE class_id=$class_id";

	if($result = mysqli_query($dbCon,$q))
	{	
		if(mysqli_num_rows($result)>0)
		{	
			#return the first classname under the id provided
			foreach($result as $r)
			{return $r;}
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

function getStreamName($stream_id)
{
	{
	require("../esomoDbConnect.php");
	$q = "SELECT stream_name FROM streams WHERE stream_id=$stream_id";

	if($result = mysqli_query($dbCon,$q))
	{	
		if(mysqli_num_rows($result)>0)
		{	
			#return the first classname under the id provided
			foreach($result as $r)
			{return $r;}
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