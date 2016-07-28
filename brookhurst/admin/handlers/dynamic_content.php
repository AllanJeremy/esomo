<?php

//IN FUTURE CONSIDERATIONS OF MAKING EVERY AJAX CALL A FUNCTION IN THIS FILE.

if(isset($_POST['chosenSubjectLevel']) && !empty($_POST['chosenSubjectLevel'])) {
    subjectChange();
} elseif(isset($_POST['chosenGrade']) && !empty($_POST['chosenGrade'])) {
    gradeChange();
} elseif(isset($_POST['scheduleTrId']) && !empty($_POST['scheduleTrId'])) {
    removeScheduleRow();
} elseif(isset($_POST['assignmentTrId']) && !empty($_POST['assignmentTrId'])) {
    removeAssignmentRow();
} else {
    echo 'forbidden';
}

function removeScheduleRow() {
    if(isset($_POST['scheduleTrId']))
    {
        session_start();
        $chosenTrId = $_POST['scheduleTrId'];
        $task_id = $chosenTrId;

        require_once("content_handler.php");
        $handler = new ContentHandler();

        $tr = $handler->deleteAssignment($task_id);

        echo $tr;

    }
}
function removeAssignmentRow() {
    if(isset($_POST['assignmentTrId']))
    {
        session_start();
        $chosenTrId = $_POST['assignmentTrId'];
        $task_id = $chosenTrId;

        require_once("content_handler.php");
        $handler = new ContentHandler();

        $tr = $handler->deleteAssignment($task_id);

        echo $tr;

    }
}

function subjectChange() {
    if(isset($_POST['chosenSubjectLevel']))
    {
        session_start();
        $chosenSubjectLevel = $_POST['chosenSubjectLevel'];
        $subjectLevel = $chosenSubjectLevel;

        require_once("content_handler.php");
        $handler = new ContentHandler();

        //$subjects = $handler->getSubjects();
        $grades = $handler->getSubjectClasses($subjectLevel);
        //$topics = $handler->getTopics($curSubId,$curClassId);

        foreach($grades as $class)
        {
            $tmp_classId = @$class['class_id'];
            $tmp_className = @$class['class_name'];

            echo "<option value=$tmp_classId>".$tmp_className."</option>";

        }


    }
}
function gradeChange() {
    if(isset($_POST['chosenGrade']))
    {
        session_start();
        $chosenSubject = $_POST['chosenSubject'];
        $chosenGrade = $_POST['chosenGrade'];
        
        $subjectId = $chosenSubject;
        $classId = $chosenGrade;
        
        require_once("content_handler.php");
        $handler = new ContentHandler();

        $topics = $handler->getTopics($subjectId,$classId);
        //$topics = $handler->getTopics($curSubId,$curClassId);
        //echo $topics;
        if(is_null($topics)) {
            $message = 'no topic added in the selected subject and grade';
            echo "<option value='' class='grey-text'>".$message."</option>";
            //echo $topics;
            
        } elseif($topics == '') {
            $message = 'no topic added in the selected subject and grade';
            echo "<option value='' class='grey-text'>".$message."</option>";
            
        } else {
            foreach($topics as $topic)
            {
                $tmp_topicId = @$topic['topic_id'];
                $tmp_topicName = @$topic['topic_name'];
                echo $tmp_topicId;
                if($tmp_topicId >0) {
                    echo "<option value=$tmp_topicId>".$tmp_topicName."</option>";
                } else {
                    $message = 'no topic added in the selected subject and grade';
                    echo "<option value='' class='grey-text'>".$message."</option>";
                }
                

            }  
        }
        

    }
}

