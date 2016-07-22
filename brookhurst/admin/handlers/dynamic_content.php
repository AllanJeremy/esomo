<?php

//header("Content-type: text/xml");

//IN FUTURE CONSIDERATIONS OF MAKING EVERY AJAX CALL A FUNCTION IN THIS FILE.

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

	#stores list of topic options
	/*echo '<topics>';
	
	foreach($topics as $topic)
	{
		$tmp_topicId=@$topic['topic_id'];
		$tmp_topicName = @$topic['topic_name'];

		echo "<option value=$tmp_topicId>".$tmp_topicName."</option>";
	}

	echo '</topics>';
    */
	//echo '</div>';
    
}

