<?php
include("topics.php");//include the topics php file so we can use its variables and functions
require_once("esomoErrorHandler.php");
//function to generate the form page
class FormSelection
{
function generateFormPage($subjectId)
{
	$appendUrl = "learn.php?subId=$subjectId";//stores the appended url format
	$pageTitle = "<h3 style='text-align:center;'>Select form for $subjectName to start reading</h3><br>";
	
	/*$pageContent = <<<EOD
	<div class="formSelectionWrapper container-fluid well">
		$pageTitle
		<div class="col-xs-12 col-xs-offset-0 col-sm-10 col-sm-offset-1 col-md-5 col-md-offset-1">
			<h2 style='text-align:center;'><a class="subjectSelection" href="$appendUrl&formSelected=1">Form 1</a></h2>
		</div>
		<div class="col-xs-12 col-xs-offset-0 col-sm-10 col-sm-offset-1 col-md-5 col-md-offset-1">
			<h2 style='text-align:center;'><a class="subjectSelection" href="$appendUrl&formSelected=2">Form 2</a></h2>
		</div>
		<div class="subjectSelection col-xs-12 col-xs-offset-0 col-sm-10 col-sm-offset-1 col-md-5 col-md-offset-1">
			<h2 style='text-align:center;'><a class="subjectSelection" href="$appendUrl&formSelected=3">Form 3</a></h2>
		</div>
		<div class="col-xs-12 col-xs-offset-0 col-sm-10 col-sm-offset-1 col-md-5 col-md-offset-1">
			<h2 style='text-align:center;'><a class="subjectSelection" href="$appendUrl&formSelected=4">Form 4</a></h2>
		</div>
	</div>
EOD;*/
	

	$formSelected = @($_GET['formSelected']);
	$subId = @($_GET['subId']);
//Only print out the page if we are not in topics, otherwise print the topics page
	if ($formSelected ===null)//if the formSelected has not been set, then show the page content
	{
		echo $pageContent;
	}
	else//otherwise generate the topics page
	{
		$formSelected = (integer)$formSelected;#convert the value of the form selected into an integer
	if($subId!==null)
	{
		$subId = (integer)$subId;

		//only generate the topics page if the formSelected in the url is in range
		if ($formSelected>0 && $formSelected<=4 && $subId>0 &&$subId<=19 )
		{
			//$errHandler = $errHandler = new CustomErrorHandler();
			//if(URL_isValid()=="TRUE")
			{
				$topicPage = new TopicHolder();
				$topicPage->generateTopicsPage();
			}
		}
		else
		{
			$errHandler = new CustomErrorHandler();
			$errHandler->displayPageNotFoundError();
		}
	}
	else
	{
		$errHandler = new CustomErrorHandler();
		$errHandler->displayPageNotFoundError();
	}

	}


}



}