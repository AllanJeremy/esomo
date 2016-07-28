<html lang="en">
    <head>
        <title>Submit Assignment</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <link  rel="stylesheet" type="text/css" href="../css/theme.min.css"/>
       <link  rel="stylesheet" type="text/css" href="../css/main.css"/>
       <link  rel="stylesheet" type="text/css" href="../css/color.css"/>
    </head>
    
    <body>

<?php
session_start();
$q = "INSERT INTO assignments (ass_title,ass_description,class_id,stream_id,teacher_id,due_date,ass_file_path) VALUES(?,?,?,?,?,?,?)";

require('../../esomoDbConnect.php');

require_once('fileUpload.php');#file that handles file uploads
#assResourceInput - content file input name
$fileUpload = new FileUpload();



//Only enter the information if the assignment is valid
if(assInfoValid())
{
	if($stmt=$dbCon->prepare($q))
	{
		if($fileUpload->uploadAss('assResourceInput'))
		{
		echo "<div class='container col-xs-12 col-sm-6 col-sm-offset-3'><h3 class='grey-text col-xs-12 '>Successfully sent assignment</h3>
		<a class='btn btn-primary col-xs-12 col-sm-6 col-sm-offset-3' href='../index.php'>GO BACK TO ADMIN</a> </div>";
		}
		else {
			echo "<div class='container col-xs-12 col-sm-6 col-sm-offset-3'><h3 class='grey-text col-xs-12 '>Failed to upload the assignment</h3>
		<a class='btn btn-primary col-xs-12 col-sm-6 col-sm-offset-3' href='../index.php'>GO BACK TO ADMIN</a> </div>";
		}
		
		
		$stmt->bind_param('ssiiiss',$title,$descr,$class_id,$stream_id,$teacher_id,$due_date,$fileUpload->storage_path);
		$title = @htmlspecialchars($_POST['assTitleInput']);
		$descr = @htmlspecialchars($_POST['assDescrInput']);
		$class_id = @htmlspecialchars($_POST['assGradeInput']);
		$stream_id = @htmlspecialchars($_POST['assStreamInput']);
		$teacher_id = @htmlspecialchars($_SESSION['s_admin_id']);#set the teacher id to the current logged teacher id
		$due_date = @htmlspecialchars($_POST['assDueDateInput']);
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

?>
</body>
</html>