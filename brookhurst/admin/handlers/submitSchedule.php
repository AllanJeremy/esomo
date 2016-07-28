<html lang="en">
    <head>
        <title>Submit Schedule</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <link  rel="stylesheet" type="text/css" href="../css/theme.min.css"/>
       <link  rel="stylesheet" type="text/css" href="../css/main.css"/>
       <link  rel="stylesheet" type="text/css" href="../css/color.css"/>
    </head>
    
    <body>

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
        echo "<div class='container col-xs-12 col-sm-6 col-sm-offset-3'><h3 class='grey-text col-xs-12 '>Successfully uploaded the content</h3>
<a class='btn btn-primary col-xs-12 col-sm-6 col-sm-offset-3' href='../index.php'>GO BACK TO ADMIN</a> </div>";
    }
    catch(Exception $e)
    {
        echo "<div class='container col-xs-12 col-sm-6 col-sm-offset-3'><h3 class='grey-text col-xs-12 '>Successfully uploaded the content</h3>
<a class='btn btn-primary col-xs-12 col-sm-6 col-sm-offset-3' href='../index.php'>GO BACK TO ADMIN</a> </div>";
    }
}
else {
    echo "<p>There was a problem adding the schedule".$dbCon->error."</p>";
}

?>

</body>
</html>