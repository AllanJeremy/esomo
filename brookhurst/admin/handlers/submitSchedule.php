<?php
session_start();#start the session so that we can use session variables
require('../../esomoDbConnect.php');#access to the database

$schTitle = htmlspecialchars($_POST['schTitleInput']);
$schDescr = htmlspecialchars($_POST['schDescrInput']);
$schGrade = htmlspecialchars($_POST['schGradeInput']);
$schStream = htmlspecialchars($_POST['schStreamInput']);
$schDateInput = $_POST['sch_dateInput'];
$schTimeInput = $_POST['sch_timeInput'];

$query = "INSERT INTO schedules (task_title,task_description,task_date,teacher_id,stream_id,class_id)
VALUES(?,?,?,?,?,?)";

#try preparing the statement.
if($stmt = $dbCon->prepare($query))
{
    echo ($schDateInput . " ". $schTimeInput . ":00");
    $stmt->bind_param('sssiii',$title,$descr,$date,$tr_id,$stream_id,$class_id);
    $title=$schTitle;
    $descr=$schDescr;
    $date=($schDateInput . " ". $schTimeInput . ":00");
    $date = date('Y-m-d H:i:s', strtotime($date));
    $tr_id = $_SESSION['s_admin_id'];
    $stream_id=$schStream;
    $class_id=$schGrade;

    try
    {
        $stmt->execute();
        echo "Successfully added the records";
    }
    catch(Exception $e)
    {
        echo "There was a problem submitting your input";
    }
}
else {
    echo "<p>There was a problem adding the schedule".$dbCon->error."</p>";
}