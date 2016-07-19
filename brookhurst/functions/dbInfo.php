<?php
#test file

//contains information on the  database that might be of use	
class DbInfo{
	function __construct()
	{

	}
	function getSubjectCount(){
		require_once('esomoDbConnect.php');
		$selectQuery = "SELECT subject_name FROM subjects";
		if($dbCon->query($selectQuery))//set result if the query executes
		{
			$result = $dbCon->query($selectQuery);
			$rowCount = num_rows($result);

			echo "<p style='background-color:black;text-align:center;color:green;font-size:1.2em;'>$rowCount Subjects</p>";
			unset($result);
		}
	}

	function getAttributeName($column,$tableName,$idName,$attrId)
	{
		require('esomoDbConnect.php');
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
}