<?php
#THIS FILE HANDLES CONTENT DISPLAYED IN INDEX.PHP
class ContentHandler
{	

	private $accessLevel;#current access level of the admin
	private $errorMessage;#generic error message for insufficient access rights

	private $levelRequired;#minimum access level required
	
	#minimum and maximum for the due date
	private $minDueDate;
	private $maxDueDate;

	private $ass_contentTypes;
	//constructor - when a new content handler is created
	function __construct()
	{	

		#date formatting
		$curYr = date('Y');
		$curMonth = date('m');
		$curDay = date('d');

		$currDate  = '\''.$curYr.'-'.$curMonth.'-'.$curDay.'\'';
		$this->minDueDate = $currDate;
		$this->maxDueDate = ('"2030-12-12"');

		#accepted assignment content types
		$this->ass_contentTypes = '\'.zip .pdf .docx .xls\'';

		#access level stuff
		$this->levelRequired = 1;#by default the level required is 2

		$this->accessLevel = $_SESSION['s_admin_accessLevel'];
		$this->errorMessage = "You do not have sufficient rights to view this content";
	}

	//returns the content management content
	function getContent()
	{	
		$content ="<div class='tab-pane fade in active panel panel-primary col-xs-12' id='nav_content'>";#open div

		#content here
		$content .= "<h3>Manage Content</h3>";
		$content .= "<form class='form-horizontal' method='POST'>";#create form

		$content .= "<label for='contTabTitle'>Content Title</label>";
		$content .= "<input class='form-control' required='yes' placeholder='Content Title' id='contTabTitle' name='adm_contTitleInput'></input><br>";
		
		$content .= "<label for='contTabPath'>Content Path</label>";
		$content .= "<input class='form-control' required='yes' type='url' placeholder='Content Path' id='contTabPath' name='adm_contPathInput'></input><br>";
		
		#generates the subject dropdown
		if($this->getSubjects()!==null)//meaning we have a valid list of subjects
		{
			$subjects =$this->getSubjects();

			$content .= $this->genSubjectDropdown($subjects);
			//dynamically show subject topics

		} else
		{
			$content.="<h5>Could not generate the subject dropdown and subsequent dropdowns in admin_content</h5>";
		}
		
		#generate subject class dropdown
		$curSubLevel = "'high_school'";#should be updated dynamically

		$classes = $this->getSubjectClasses($curSubLevel);
		$content .= $this->genSubjectClassDropdown($classes);
		
		#generate topic dropdown
		$curSubId = '1';
		$curClassId = '1';

		$topics = $this->getTopics($curSubId,$curClassId);
		$content .=$this->genTopicDropdown($topics);

		#generate content type dropdown
		$content .= $this->genContTypeDropdown();

		#submit button
		$content .= "<button type='submit' class='btn btn-primary adminSubmitBtn'>Add Content</button>";#create a submit button

		$content .= "</form>";#close form
		#close div

		$content .= "<div style='margin-top:2.5%;' class='panel-footer'><h5 id='cont_feedback'></h5> </div>";
		$content.="</div>";
		
		#the minimum level admin should be to view this content
		$this->levelRequired=1;
		
		#error to be shown if access level is not valid
		$error = $this->getErrorContent($this->errorMessage);#$this->errorMessage can be swapped with custom error message

		#return the content if the user has access rights else show error
		return ($this->restrictAccess($this->levelRequired,$content,$error));
	
	}#end of getContent function

	//generates the subject dropdown and returns the dropdown
	private function genSubjectDropdown($subjects) //param subject - mysqli::result
	{
		$dropdown = '';
		#lable for the dropdown
		$dropdown .= "<label class='control-label' for='subjectDropdown'>Subject </label>";

		#subject dropdown
		$dropdown .= "<select class='form-control' id='subjectDropdown' name='subDropdown' onchange='subjectChanged()'>";#create a selection box
		
		//create individual options
		foreach ($subjects as $subject)
		{
			$tmp_subId = @$subject['subject_id'];
			$tmp_subName = @$subject['subject_name'];
			$tmp_subLevel = @$subject['subject_level'];

			$subInfoJson = '\'{"curSubId":"'.$tmp_subId.'", "curSubLevel":"'.$tmp_subLevel.'"}\'';

			$dropdown .= ("<option value=$subInfoJson>".$tmp_subName." [".$tmp_subLevel."] </option>");
		}
		#close select 
		$dropdown.="</select>";


		#unset the loop variables
		unset($subject);
		unset($tmp_subId);
		unset($tmp_subName);
		unset($tmp_subLevel);

		return $dropdown;
	}#end of generateSubjectDropdown
	
	//generates the subject class selection dropdown and returns the dropdown
	private function genSubjectClassDropdown($classes) //param subject - mysqli::result
	{
		$dropdown = '<br>';
		#lable for the dropdown
		$dropdown .= "<label class='control-label' for='subjectDropdown'>Grade </label>";

		#subject dropdown
		$dropdown .= "<select class='form-control' id='gradeDropdown' onchange='gradesChanged()'>";#create a selection box
		
		foreach ($classes as $class)
		{
			$tmp_classId = $class['class_id'];
			$tmp_className = @$class['class_name'];

			$dropdown .= ("<option value=$tmp_classId>".$tmp_className."</option>");
		}

		#unset the loop variables
		unset($subject);
		unset($tmp_topicId);
		unset($tmp_topicName);

		#close select 
		$dropdown.="</select>";

		return $dropdown;
	}#end of generateSubjectClassesDropdown

	//generates the subject dropdown and returns the dropdown
	private function genTopicDropdown($topics) //param subject - mysqli::result
	{
		$dropdown = '';
		#label for the dropdown
		$dropdown .= "<br><label class='control-label' for='subjectDropdown'>Topic </label>";

		#subject dropdown
		$dropdown .= "<select class='form-control' id='topicDropdown'>";#create a selection box
		
		foreach ($topics as $topic)
		{
			$tmp_topicId=@$topic['topic_id'];
			$tmp_topicName = @$topic['topic_name'];

			$dropdown .= ("<option value=$tmp_topicId>".$tmp_topicName."</option>");
		}

		#unset the loop variables
		unset($subject);
		unset($tmp_topicId);
		unset($tmp_topicName);

		#close select 
		$dropdown.="</select>";

		return $dropdown;
	}#end of generateTopicDropdown

	#returns the content type dropdown
	private function genContTypeDropdown()
	{	
		$dropdown = "<br><label class='control-label' for='contTypeDrop'>Content type</label>";
		$dropdown .= "<select class='form-control' id='contTypeDrop'>";
		$dropdown .= "<option value='article'>Article</option>";
		$dropdown .= "<option value='book'>Book</option>";
		$dropdown .= "<option value='video'>Video</option>";
		$dropdown .= "</select>";

		return $dropdown;
	}
	//returns the assigmnment management content
	function getAss()
	{	
	    require_once('db_info_handler.php');
		$dbInfo = new DbInfo();
		#variables for accessing information from the database
		$streams = $dbInfo->getAvailableStreams();
		$grades = $dbInfo->getAvailableClasses();

		#assignment content - escape every newline with \ for js usage
		$content ="<div class='tab-pane fade in panel panel-primary col-xs-12' id='nav_ass'>";#open div

		#content here
		$content .= "<h2>Assignments</h2>";
		$content .= "<form method='post' action='handlers/submitAss.php' class='form'>";

		$content .= "<div class='form-group'><label class='control-label hidden-xs' for='assTitle'>Assignment Title *</label>
		<input class='form-control' type='text' name='assTitleInput' required='yes' id='assTitle' placeholder='Assignment Title *'/> </div>";

		$content .= "<div class='form-group'><label class='control-label hidden-xs' for='assDescr'>Assignment Description *</label>
		<textarea class='form-control' name='assDescrInput' id='assDescr' required='yes' placeholder='Assignment description/instructions *' rows='5'></textarea></div>";

		$content .= "<div class='form-group'><label class='control-label hidden-xs' for='assGrade'>Assignment Grade *</label>
			<select id='assGrade' name='assGradeInput' required='yes' class='form-control'>";
			
		#getting the grades
		foreach($grades as $grade)
		{
			$content .= ("<option value='".$grade['class_id']."'>".$grade['class_name']."</option>");
		}

		$content .= "</select></div>";

		$content .= "<div class='form-group'><label class='control-label hidden-xs' for='assStream'>Class Stream *</label>
			<select id='assStream' name='assStreamInput' required='yes' class='form-control'>";
			
		#getting the grades
		foreach($streams as $stream)
		{
			$content .= ("<option value='".$stream['stream_id']."'>".$stream['stream_name']."</option>");
		}

		$content .= "</select></div>";

		#due date
		$content .= "<div class='form-group'><label class='control-label hidden-xs' for='assDueDate'>Due date *</label>
		<input class='form-control' type='date' name='assDueDateInput' required='yes' id='assDueDate' placeholder='Due date' min=$this->minDueDate max=$this->maxDueDate/> </div>";

		#resource url
		$content .= "<div class='form-group'><label class='control-label hidden-xs' for='assResource'>Resources path (optional)</label>
		<input class='form-control' type='file' name='assResourceInput' id='assResource' placeholder='Resource path' accept='$this->ass_contentTypes'/> </div>";

		$content .= "<button type='submit' class='btn btn-primary adminSubmitBtn'>Send Assignment</button>";#create a submit button
		
		//show error message at the bottom of the page
		switch (htmlspecialchars(@$_GET['nassfail'])) {
			case 1:
				$content .= "<br><div class='panel-warning'><div class='panel-body'><h6>Error. Ensure you fill in all required information before trying to send an assignment</h6></div></div>";
				break;
			
			default:
				# code...
				break;
		}

		$content .= "</form>";

		#close div
		$content.="</div>";

		
		#the minimum level admin should be to view this content
		$this->levelRequired=1;
		
		#error to be shown if access level is not valid
		$error = $this->getErrorContent($this->errorMessage);#$this->errorMessage can be swapped with custom error message

		#return the content if the user has access rights else show error
		return ($this->restrictAccess($this->levelRequired,$content,$error));
	}
	//returns the schedule management content
	function getSchedule() 
	{
		$content ="<div class='tab-pane fade in panel panel-primary col-xs-12' id='nav_schedule'>";#open div

		#content here
		$content .= "<h2>Schedule</h2>";
		$content .= "<p>This module is still under construction, please check again later.</p>";
		#close div
		$content.="</div>";
		
		#the minimum level admin should be to view this content
		$this->levelRequired=1;
		
		#error to be shown if access level is not valid
		$error = $this->getErrorContent($this->errorMessage);#$this->errorMessage can be swapped with custom error message

		#return the content if the user has access rights else show error
		return ($this->restrictAccess($this->levelRequired,$content,$error));
	}

	//returns the statistics management content
	function getStats()
	{
		$content ="<div class='tab-pane fade in panel panel-primary col-xs-12' id='nav_stats'>";#open div

		#content here
		$content .= "<h2>Statistics</h2>";
		$content .= "<p>This module is still under construction, please check again later.</p>";
		#close div
		$content.="</div>";
		
		#the minimum level admin should be to view this content
		$this->levelRequired=1;
		
		#error to be shown if access level is not valid
		$error = $this->getErrorContent($this->errorMessage);#$this->errorMessage can be swapped with custom error message

		#return the content if the user has access rights else show error
		return ($this->restrictAccess($this->levelRequired,$content,$error));
	}

	//returns the profile content
	function getProfile()
	{		

		$content ="<div class='tab-pane fade in panel panel-primary col-xs-12' id='nav_profile'>";#open div

		#content here
		$content .= "<h2>Profile</h2>";
		$content .= "<p>This module is still under construction, please check again later.</p>";
		#close div
		$content.="</div>";
		
		#the minimum level admin should be to view this content
		$this->levelRequired=1;
		
		#error to be shown if access level is not valid
		$error = $this->getErrorContent($this->errorMessage);#$this->errorMessage can be swapped with custom error message

		#return the content if the user has access rights else show error
		return ($this->restrictAccess($this->levelRequired,$content,$error));
	}

	function getSubContent()
	{
		$content ="<div class='tab-pane fade in panel panel-primary col-xs-12' id='nav_subjects'>";#open div

		#content here
		$content .= "<h2>Subjects</h2>";

		#close div
		$content.="</div>";
		
		#the minimum level admin should be to view this content
		$this->levelRequired=1;
		
		#error to be shown if access level is not valid
		$error = $this->getErrorContent($this->errorMessage);#$this->errorMessage can be swapped with custom error message

		#return the content if the user has access rights else show error
		return ($this->restrictAccess($this->levelRequired,$content,$error));
	}

	function getTopicContent()
	{
		$content ="<div class='tab-pane fade in panel panel-primary col-xs-12' id='nav_topics'>";#open div

		#content here
		$content .= "<h2>Topics</h2>";

		#close div
		$content.="</div>";
		
		#the minimum level admin should be to view this content
		$this->levelRequired=1;
		
		#error to be shown if access level is not valid
		$error = $this->getErrorContent($this->errorMessage);#$this->errorMessage can be swapped with custom error message

		#return the content if the user has access rights else show error
		return ($this->restrictAccess($this->levelRequired,$content,$error));
	}

	//returns logout
	function getLogout()
	{
		require_once('../functions/session_functions.php');
        $sessionHandler = new SessionFunctions();
	
		$content ="<div class='tab-pane fade in panel panel-warning col-xs-12' id='nav_logout'>";#open div

		#content here
		$content .= "<h5>Logging you out...</h5>";
		
		#close div
		$content.="</div>";
		
		#the minimum level admin should be to view this content
		$this->levelRequired=1;
		
		#error to be shown if access level is not valid
		$error = $this->getErrorContent($this->errorMessage);

		#return the content if the user has access rights else show error
		return ($this->restrictAccess($this->levelRequired,$content,$error));
	}


	//returns the subjects
	public function getSubjects()
	{
		$q = "SELECT subject_id,subject_name,subject_level FROM subjects";

		require('../esomoDbConnect.php');
		if($result = mysqli_query($dbCon, $q))
		{
			return $result;
		}
		else
		{
			echo "Error running query<br> ".$dbCon->error;#debug
			return null;
		}
	}

	//returns the classes available for the current subject level
	public function getSubjectClasses($subjectLevel)
	{
		$q = "SELECT class_id,class_name FROM class_selection WHERE class_level=$subjectLevel";

		require('../esomoDbConnect.php');
		if($result = mysqli_query($dbCon, $q))
		{
			return $result;
		}
		else
		{
			echo "Error running query<br> ".$dbCon->error;#debug
			return null;
		}
	}
	//returns the topics
	public function getTopics($subjectId,$classId)
	{
		$q = "SELECT topic_id,topic_name FROM topics WHERE subject_id=$subjectId AND class_id=$classId";

		require('../esomoDbConnect.php');
		if($result = mysqli_query($dbCon, $q))
		{
			return $result;
		}
		else
		{
			echo "Error running query<br> ".$dbCon->error;#debug
			return null;
		}
	}
	//if the user meets the min access level, return content, else return error
	private function restrictAccess($minAccessLevel,$contentInput,$errorInput)
	{
		//check if the criteria to view the content is met
		if($this->accessLevel!==null && $this->accessLevel>=$minAccessLevel)
		{
			return $contentInput;
		}else
		{
			return $errorInput;
		}
	}
	private function getErrorContent($errorInput)
	{	
		#changed to be handled by bootstrap
		#cannot have it as multiple lines because js will read incorrectly
		return "<div class='well'><h3>Restricted access</h3><p>$errorInput</p></div>";
	}
}