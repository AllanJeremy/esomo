<?php
#test file

//contains information on the  database that might be of use	
class DbInfo{
	public $dbPath;# so that the database can be accessed from any file
	function __construct($dbPath)
	{
		$this->dbPath = $dbPath;
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

	#column(column whose data we want), tableName(table we want to access the column from), idName (name of the identifier whose id we are using' , attrId(the id of the attribute)
	function getAttributeName($column,$tableName,$idName,$attrId)
	{
		require("$this->dbPath");
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