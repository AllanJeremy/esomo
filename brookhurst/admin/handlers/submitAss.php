<?php
session_start();
$q = "INSERT INTO assignments (ass_title,ass_description,class_id,stream_id,teacher_id,due_date) VALUES(?,?,?,?,?,?)";

require('../../esomoDbConnect.php');

//Only enter the information if the assignment is valid
if(assInfoValid())
{
	if($stmt=$dbCon->prepare($q))
	{

		$stmt->bind_param('ssiiis',$title,$descr,$class_id,$stream_id,$teacher_id,$due_date);
		$title = htmlspecialchars($_POST['assTitleInput']);
		$descr = htmlspecialchars($_POST['assDescrInput']);
		$class_id = htmlspecialchars($_POST['assGradeInput']);
		$stream_id = htmlspecialchars($_POST['assStreamInput']);
		$teacher_id = htmlspecialchars($_SESSION['s_admin_id']);#set the teacher id to the current logged teacher id
		$due_date = htmlspecialchars($_POST['assDueDateInput']);
		$stmt->execute();#execute the query and insert the values into the database
	}
	else
	{
		echo "Error preparing query ".$dbCon->error;
	}
}else
{
	echo "Please fill in all the required fields(*).";
	sleep(1);
	header('Location: ../index.php#');
}

//returns true if the information is valud
function assInfoValid()
{
	if($_POST['assTitleInput']==''||$_POST['assTitleInput']===null||
	$_POST['assDescrInput']==''||$_POST['assDescrInput']===null||
	$_POST['assGradeInput']==''||$_POST['assGradeInput']===null||
	$_POST['assStreamInput']==''||$_POST['assStreamInput']===null||
	$_POST['assDueDateInput']==''||$_POST['assDueDateInput']===null)
	{
		return false;
	}
	else
	{
		return true;
	}
}