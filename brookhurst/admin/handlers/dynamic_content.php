<?php

header("Content-type: text/xml");

if(!isset($_POST['cont_curClassId']) && !isset($_POST['cont_curSubjectId']) && !isset($_POST['cont_curSubjectLevel']))
{
	echo "<result>";
	echo "ERROR!!!!";
	echo "</result>";
}else//all the information is set
{
	$curClassId = $_POST['cont_curClassId'];
	$curSubId = $_POST['cont_curSubjectId'];
	$curSubLevel = $_POST['cont_curSubjectLevel'];

	require_once("content_handler.php");
	$handler = new ContentHandler();

	//$subjects = $handler->getSubjects();
	$grades = $handler->getSubjectClasses($curSubLevel);
	$topics = $handler->getTopics($curSubId,$curClassId);

	echo '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>';
	echo '<response>';

	#stores list of subject options - considered theoretically computationally uneconomical
	// echo '<subjects>';

	// echo '</subjects>';

	#stores list of grade options
	echo '<grades>';

	foreach($grades as $class)
	{
		$tmp_classId = @$class['class_id'];
		$tmp_className = @$class['class_name'];

		echo "<option value=$tmp_classId>".$tmp_className."</option>";
	}

	echo '</grades>';

	#stores list of topic options
	echo '<topics>';
	
	foreach($topics as $topic)
	{
		$tmp_topicId=@$topic['topic_id'];
		$tmp_topicName = @$topic['topic_name'];

		echo "<option value=$tmp_topicId>".$tmp_topicName."</option>";
	}

	echo '</topics>';
	echo '</response>';
}

