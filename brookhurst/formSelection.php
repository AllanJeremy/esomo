<?php
include("topics.php");//include the topics php file so we can use its variables and functions


//function to generate the form page
class FormSelection
{

	function __construct()
	{
		include_once('esomoErrorHandler.php');
		
	}
	//main function - generates the form page
	function generateFormPage($subjectId)
	{
		$subjectId = htmlspecialchars($subjectId);//remove any special characters that may be in the  subject id
		$f_Id = (@$_GET['fId']);

		//use error handler to check for url validity
		$errHandler = new CustomErrorHandler();


		if($f_Id!== null)//if there is a value for the $f_Id, then open the topics page
		{
			$currSubName = $this->getSubjectName($subjectId);
			
			//if the url is valid, then generate the topics page
			if (($errHandler->urlFormIdIsValid()===TRUE) && ($errHandler->urlSubIdIsValid()===TRUE) )
			{
				include('topics.php');
				$tHolder = new TopicHolder();
				$tHolder->generateTopicsPage($currSubName);
			}else{
			  $errHandler->displayPageNotFoundError();
			}
		}
		else
		{
			if($errHandler->urlSubIdIsValid()===TRUE)//if this block executes, the url is valid in the current context
			{

				 $this->genPageContent($subjectId);

			}else{
			  $errHandler->displayPageNotFoundError();
			}
		}
	}

	//generates the page content - subfunction
	function genPageContent($currSubId)
	{

			$currSubName = $this->getSubjectName($currSubId);

			$backButton = "<a class='learnPrevBtn hidden-xs' href='learn.php'><span class='glyphicon glyphicon-step-backward' style='font-size:1.25em'>Previous</span></a>";

			$pageContent = "
			<div class='container'>
				<div class='well'>
				$backButton
				<h3  class='center_text'>Select study level for $currSubName</h3>
				</div>";

			echo $pageContent;
			echo $this->getFormLevels();
			echo "</div>";
		
	}

	//returns the current name of a subject - or 0 if the name could not be retrieved
	function getSubjectName($currSubId){
		#convenience function
		require_once('esomoDbConnect.php');
		$subjectNameQuery = "SELECT subject_name FROM subjects WHERE subject_id=$currSubId";
		$currentSubjectName = "";#the name of the current subject

		if($fetchNameQuery = $dbCon->prepare($subjectNameQuery))
		{
			$fetchNameQuery->execute();
			$subjectNameArray = $fetchNameQuery->get_result();
			
			//get the current subjectName
			foreach ($subjectNameArray as $subjectName) {
				$tmp_curSubName = $subjectName['subject_name'];
				$currentSubjectName = $tmp_curSubName;
				
			}
			//unset temporary variables
			return $currentSubjectName;
		}else
		{
			return 0;
		}
	}

	function getFormLevels(){
		require('esomoDbConnect.php');

		//to use for esomo - education level restricted access
		//$formQuery = "SELECT class_name,class_id FROM class_selection WHERE class_level= '" . HIGH_SCHOOL ."'";

		$formQuery = "SELECT class_name,class_id FROM class_selection";
		$contentClasses = 'col-xs-12 col-sm-3 col-sm-offset-1 form_selection center_text form_selection';
		
		$subjectId =  stripslashes(htmlspecialchars(@($_GET['subId']))); //sanitized subject Id

		if($fetchFormQuery = $dbCon->prepare($formQuery))
		{
			$fetchFormQuery->execute();
			$formResult = $fetchFormQuery->get_result();

			echo "<div>";
			foreach ($formResult as $result) {
				$tmp_curFormName = $result['class_name'];
				$tmp_fId = $result['class_id'];

				$formSnippet = "<a href='learn.php?subId=$subjectId&fId=$tmp_fId'><div class= '$contentClasses'> <h2>$tmp_curFormName</h2> </div></a>";
				//$formContent .= $formSnippet;
				
				echo $formSnippet;
			}
			echo "</div>";
			unset($result);
			unset($formResult);
			unset($tmp_curFormName);

		}else
		{
			echo "<p style='background-color:black;text-align:center;color:red;font-size:1.2em;'> unable to prepare query with error : ".$dbCon->error."</p>";
		}
	}

}