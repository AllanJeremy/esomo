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

#get the name of  ateacher
function getTeacherName($trId)
{
	return($this->getAttributeName('username','admin_accounts','admin_acc_id',$trId));
}
#get the name of  a class
function getClassName($classId)
{
	return($this->getAttributeName('class_name','class_selection','class_id',$classId));
}

#get the name of a stream
function getStreamName($streamId)
{
	return($this->getAttributeName('stream_name','streams','stream_id',$streamId));		
}

#gets and returns all schedules
function getAllSchedules()
{
	require("../esomoDbConnect.php");
	$q = "SELECT * FROM schedules";

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

#gets and returns all assignments
function getAllAss()
{
	require("../esomoDbConnect.php");
	$q = "SELECT * FROM assignments";

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

function getSpecificAss($teacherId)
{
		require("../esomoDbConnect.php");
	$q = "SELECT * FROM assignments WHERE teacher_id=$teacherId";

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
	#column(column whose data we want), tableName(table we want to access the column from), idName (name of the identifier whose id we are using' , attrId(the id of the attribute)
	function getAttributeName($column,$tableName,$idName,$attrId)
	{
		require("../esomoDbConnect.php");
		$q = "SELECT $column FROM $tableName WHERE $idName=$attrId";
		if($result = mysqli_query($dbCon,$q))
		{
			if(mysqli_num_rows($result)>0)
			{
				foreach($result as $r)
				{
					return @$r[$column];
				}
			}
			else {#if there are no records
				return 0;
			}
		} else {
			return null;#failed to  run the query
		}
	}

#gets and returns all assignments
function getAllSubjects()
{
	require("../esomoDbConnect.php");
	$q = "SELECT * FROM subjects";

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