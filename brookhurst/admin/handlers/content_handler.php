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
	private $chosenSubjectLevelCon;
    
	#class variables to keep page persistent
	public $contentClass;
	public $assignmentClass;
	public $profileClass;
	public $scheduleClass;
	public $statClass;

    #different access level constants
	const NONE_ACCOUNT = 1;
	const CONTENT_CREATOR = 2;
	const TEACHER = 3;
	const PRINCIPAL= 4; 
	const SUPER_USER = 5;

	#constants controlling access level
	const CONTENT_ACCESS_LEVEL = self::CONTENT_CREATOR;
	const ASSIGNMENTS_ACCESS_LEVEL = self::TEACHER;
	const PROFILE_ACCESS_LEVEL = self::NONE_ACCOUNT;
	const SCHEDULE_ACCESS_LEVEL = self::TEACHER;
	const STATS_ACCESS_LEVEL = self::PRINCIPAL;
	
	#assignment content types accepted for files
	private $ass_contentTypes;
	private $content_acceptedTypes;

	//constructor - when a new content handler is created
	function __construct()
	{	

		//$this->chosenSubjectLevelCon = $push;
		$curYr = date('Y');
		$curMonth = date('m');
		$curDay = date('d');

		$currDate  = '\''.$curYr.'-'.$curMonth.'-'.$curDay.'\'';
		$this->minDueDate = $currDate;
		$this->maxDueDate = ('"2030-12-12"');

		$this->contentClass = 'active';
		#accepted assignment content types
		$this->ass_contentTypes = '\'.zip, .pdf, .docx, .xls, .rtf, audio/*, image/*, video/* \'';
		
		$this->content_acceptedTypes = '\'.zip, .pdf, .docx, .xls, .rtf, audio/*, image/*, video/* \'';

		#access level stuff
		$this->levelRequired = 2;#by default the level required is 2

		$this->accessLevel = $_SESSION['s_admin_accessLevel'];
		$this->errorMessage = "'You do not have sufficient rights to view this content'";

		#persistence functions
	}

	//returns the content management content
	function getContent($chosenSubjectLevel = '')
	{	
		$content ="<div class='tab-pane fade in active panel panel-primary col-xs-12' id='nav_content'>";#open div
        global $pushArray;
        global $subjectLevel;
        if(!empty($pushArray)){
            foreach($pushArray as $push) {
                //use $msg
                //echo "inside yes\n";
                echo 'push    ' . $push['class_id'] . '   shows inside the right function\n';
            }
        }
        //$push = $contentHandler->getSubjectClasses($subjectLevel);
        //echo 'push    ' . $push . '   shows inside the right function';
		#content here
		$content .= "<h3>Manage Content</h3>";
		$content .= "<form class='form-horizontal' method='POST' action='handlers/submitContent.php' enctype='multipart/form-data'>";#create form

		$content .= "<label for='contTabTitle'>Content Title</label>";
		$content .= "<input class='form-control' required='yes' placeholder='Content Title' id='contTabTitle' name='adm_contTitleInput'></input><br>";
		
		$content .= "<label for='contTabPath'>Content Path</label>";
		
		#content file input
		$content .= "<input class='form-control' required='yes' accept='$this->content_acceptedTypes' type='file' placeholder='Content Path' id='contTabPath' name='adm_contFileInput'></input><br>";
		
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
        
		#should be updated dynamically
        //$chosenSubject = $_GET['chosenSubjectLevel'];
        global $subjectLevel;
		$classes = $this->getSubjectClasses($subjectLevel);
		$content .= $this->genSubjectClassDropdown($subjectLevel);
		
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
		
		#the minimum level admin should be to view this content [Content tab]
		$this->levelRequired = self::CONTENT_ACCESS_LEVEL;
		
		#error to be shown if access level is not valid
		$error = $this->getErrorContent($this->errorMessage,'nav_content','active');#$this->errorMessage can be swapped with custom error message
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
		$dropdown .= "<select class='form-control' id='subjectDropdown' name='subDropdown' onchange='subjectChange(this.value)'>";#create a selection box
		
		//create individual options
		foreach ($subjects as $subject)
		{
			$tmp_subId = @$subject['subject_id'];
			$tmp_subName = @$subject['subject_name'];
			$tmp_subLevel = @$subject['subject_level'];

			//$subInfoJson = '\'{"curSubId":"'.$tmp_subId.'", "curSubLevel":"'.$tmp_subLevel.'"}\'';
            
            
            $arr = array('curSubId' => $tmp_subId, 'curSubLevel' => $tmp_subLevel);
            $subInfoJson = json_encode($arr);
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
    function genSubjectClassDropdown($subjectLevel) //param subject - mysqli::result
	{
		$dropdown = '<br>';
		#lable for the dropdown
		$dropdown .= "<label class='control-label' for='subjectDropdown'>Grade </label>";
        
		#subject dropdown
		$dropdown .= "<select class='form-control' id='gradeDropdown' name='gradeDropdown' onchange='gradeChange(this.value)'>";#create a selection box
        
        $dropdown .= ("<option value=''></option>");
		#unset the loop variables
		unset($subjectLevel);
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
		$dropdown .= "<select class='form-control' id='topicDropdown' name='topicDropdown'>";#create a selection box
		
		if($topics!==0)
		{
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
			}
			#close select 
			$dropdown.="</select>";

		return $dropdown;
	}#end of generateTopicDropdown

	#returns the content type dropdown
	private function genContTypeDropdown()
	{	
		$dropdown = "<br><label class='control-label' for='contTypeDrop'>Content type</label>";
		$dropdown .= "<select class='form-control' id='contTypeDrop' name='contTypeDropdown'>";
		$dropdown .= "<option value='article'>Article</option>";
		$dropdown .= "<option value='book'>Book</option>";
		$dropdown .= "<option value='video'>Video</option>";
		$dropdown .= "<option value='test'>Test</option>";
		$dropdown .= "</select>";

		return $dropdown;
	}
	//returns the assigmnment management content
	function getAss()
	{	
	    require_once('db_info_handler.php');
		$dbInfo = new DbInfo('esomoDbConnect.php');
		#variables for accessing information from the database
		$streams = $dbInfo->getAvailableStreams();
		$grades = $dbInfo->getAvailableClasses();
		$assignments = $dbInfo->getSpecificAss($_SESSION['s_admin_id']);
		#assignment content
		$content ="<div class='tab-pane fade in panel panel-primary col-xs-12' id='nav_ass'>";#open div

		#content here
		$content .= "<h4 class='center_text'>Assignments</h4>";

		#tab content for assignments
		$content .= "<ul class='nav nav-tabs nav-justified'>
			<li class='active'><a data-toggle='tab' href='#ass_send'>SEND</a></li>
			<li><a data-toggle='tab' href='#ass_manage'>MANAGE</a></li>
		";
		$content .= "<div class='tab-content container-fluid'>";

		#send tab [assignments]
		$content .= "<div class='tab-pane active' id='ass_send'><br>";
		$content .= "<form method='post' action='handlers/submitAss.php' class='form' enctype='multipart/form-data'>";

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
		switch (htmlspecialchars(@$_GET['assfail'])) {
			case 1:
				$content .= "<br><div class='panel-warning'><div class='panel-body'><h6>Error. Ensure you fill in all required information before trying to send an assignment</h6></div></div>";
				break;
			
			default:
				# code...
				break;
		}

		$content .= "</form>";
		$content .= "</div>";#close the tab pane div

		#manage assignments tab
		$content .= "<div class='tab-pane' id='ass_manage'>";
		
		#if there are assignments in the database
		if($assignments !== 0 && $assignments!==false)
		{	$content .= "<div class='ass-table-container'><table class='table table-striped'>
			<tr>
				<th>Title</th>
				<th>Class</th>
				<th>Stream</th>
				<th>Sent Date</th>
				<th>Due Date</th>
				<th>Remove</th>
			</tr>";
			foreach($assignments as $ass )
			{
				$content .= "<tr id='".$ass['ass_id']."'>
				<td>".@$ass['ass_title']."</td>
				<td>".@$dbInfo->getClassName($ass['class_id'])."</td>
				<td>".@$dbInfo->getStreamName($ass['stream_id'])."</td>
				<td>".@$ass['sent_date']."</td>
				<td>".@$ass['due_date']."</td>
				<td><button class='btn btn-warning remove_ass'>Remove</button></td>
			</tr>";
			}
			unset($ass);#cleanup after foreach
		
			$content .= "</table></div>";
		}
		else if($assignments==0)#query ran successfully but there were 0 schedules in the database
		{
			$content .= $this->noContentMessage('<b>There are currently no assignments</b>.<br> Once teachers send assignments, the assignments will appear here');
		}		
		$content .= "</div>";

		$content .= "</div>";#close the tab-content div
		#close div
		$content.="</div>";
        
		
		#the minimum level admin should be to view this content [Assignments tab]
		$this->levelRequired = self::ASSIGNMENTS_ACCESS_LEVEL;
		
		#error to be shown if access level is not valid
		$error = $this->getErrorContent($this->errorMessage,'nav_ass','');#$this->errorMessage can be swapped with custom error message
        
		#return the content if the user has access rights else show error
		return ($this->restrictAccess($this->levelRequired,$content,$error));
	}
	//returns the schedule management content
	function getSchedule() 
	{
		require_once('db_info_handler.php');
		$dbInfo = new DbInfo();
		#variables for accessing information from the database
		$streams = $dbInfo->getAvailableStreams();
		$grades = $dbInfo->getAvailableClasses();
		$schedules = $dbInfo->getAvailableSchedules($_SESSION['s_admin_id']);#get schedules for the currently logged user

		$content ="<div class='tab-pane fade in panel panel-primary col-xs-12' id='nav_schedule'>";#open div

		#content here
		//$content .= "<h3 class='center_text'>Schedules</h3>";
		
		
		$content .= "<ul class='nav nav-tabs nav-justified'>";
		$content .= "<li class='active'><a data-toggle='tab' href='#createSchedule'>CREATE SCHEDULE</a></li>";
		$content .= "<li><a data-toggle='tab' href='#manageSchedule'>MANAGE SCHEDULES</a></li>";
		$content .= "</ul>";

		#tab content
		$content .= "<div class='tab-content'>";
		#create tab
		$content .= "<div class='tab-pane fade in active' id='createSchedule'>";
		#form for creating schedule
		$content .= "<form class ='form top_spacing bottom_spacing' method='post' action='handlers/submitSchedule.php'>";
		
		$content .= "<div class='form-group'>
		<label class='control-label hidden-xs' for='schTitle'> Title *</label>
		<input type='text' id='schTitle' name='schTitleInput' required='yes' class='form-control' placeholder='Schedule Title'></input>
		</div>";
		
		$content .= "<div class='form-group'>
		<label class='control-label hidden-xs' for='schDescr'> Description (Optional)</label>
		<textarea col='3' type='text' id='schDescr' name='schDescrInput' required='yes' class='form-control'  placeholder='Schedule Description'></textarea>
		</div>";

		$content .= "<div class='form-group'><label class='control-label hidden-xs' for='schGrade'> Grade/Class *</label>
			<select id='schGrade' name='schGradeInput' required='yes' class='form-control'>";

		#getting the grades
		foreach($grades as $grade)
		{
			$content .= ("<option value='".$grade['class_id']."'>".$grade['class_name']."</option>");
		}

		$content .= "</select></div>";

		$content .= "<div class='form-group'><label class='control-label hidden-xs' for='schStream'>Stream *</label>
			<select id='schStream' name='schStreamInput' required='yes' class='form-control'>";
			
		#getting the grades
		foreach($streams as $stream)
		{
			$content .= ("<option value='".$stream['stream_id']."'>".$stream['stream_name']."</option>");
		}

		$content .= "</select></div>";
			
		#date and time	
		$content .= "
		<div class='form-group'>
			<label for='sch_date' class='control-label'>Date *</label>
			<input type='date' required='yes' class='form-control' name='sch_dateInput' id='sch_date'></input>
		</div>
		<div class='form-group'>
			<label for='sch_date' class='control-label'>Time * </label>
			<input type='time' required='yes' class='form-control' name='sch_timeInput' id='sch_date'></input>
		</div>";

		$content .= "<button type='submit' class='btn btn-primary col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 bottom_spacing top_spacing'>ADD SCHEDULE</button>";
		$content .= "</form>";
		$content .= "</div>";#close tab pane

		#manage schedules tab
		$content .= "<div id='manageSchedule' class='tab-pane fade in'>";
		$content .= "<h4 class='center_text'>Current Schedules</h4>";
		$content .= "<div>
						<table class='table table-striped'>";
		$content .="<tr><th>Title</th><th>Date</th><th>Class</th><th>Stream</th><th>Remove</th></tr>";

		#if there are currently no schedules
		if($schedules === 0)
		{
			$content .="<tr><td colspan='5'><h5>No Schedules here yet. When you add  a schedule it will appear here.</h5></td></tr>";
		}
		else#if there are schedules
		{
			$curClassName ='';
			$curStreamName ='';

			#generate a table with the details
			foreach($schedules as $schedule)
			{   
				$curClassName = ($dbInfo->getClassName($schedule['class_id']));
				$curStreamName = ($dbInfo->getStreamName($schedule['stream_id']));

				$content .= "<tr id='".$schedule['task_id']."'>";
				$content .= "<td>".$schedule['task_title']."</td>";
				$content .= "<td>".$schedule['task_date']."</td>";
				$content .= "<td>".$curClassName."</td>";
				$content .= "<td>".$curStreamName."</td>";
				$content .= "<td><button class='btn btn-warning remove_schedule'>Remove</button></td>";
				$content .= "</tr>";
			}
			
			#cleanup
			unset($curClassName);
			unset($curStreamName);
		}
		unset($schedule);#clean up after foreach

		$content .= "</table>
		</div>";#close table
		$content .= "</div>";#close manage tab

		#close tab content 
		$content .= "</div>";

		#close wrapper div
		$content.="</div>";
		
		#the minimum level admin should be to view this content [Schedules tab]
		$this->levelRequired = self::SCHEDULE_ACCESS_LEVEL;
		
		#error to be shown if access level is not valid
		$error = $this->getErrorContent($this->errorMessage,'nav_schedule','');#$this->errorMessage can be swapped with custom error message
        
		#return the content if the user has access rights else show error
		return ($this->restrictAccess($this->levelRequired,$content,$error));
	}

	//returns the statistics management content
	function getStats()
	{
		#getting information from the database
	    require_once('db_info_handler.php');
		$dbInfo = new DbInfo();
		$schedules = $dbInfo->getAllSchedules();
		$assignments = $dbInfo->getAllAss();

		$content ="<div class='tab-pane fade in panel panel-primary col-xs-12' id='nav_stats'>";#open div

		#content here
		$content .= "<h3>Statistics</h3>";

		$content .= "<ul class='nav nav-tabs nav-justified'>
			<li class='active'><a data-toggle='tab' href='#stats_schedules'>SCHEDULES</a></li>
			<li><a data-toggle='tab' href='#stats_ass'>ASSIGNMENTS</a></li>
		</ul>";

		$content .= "<div class='tab-content'>";

		#schedules tab pane
		$content .= "<div class='tab-pane active clearfix' id='stats_schedules'>";

		#search schedules
		$content .= "<div class='container-fluid clearfix'>";
		$content .= "<br><input class='col-xs-9 admin-search-btn'id='ScheduleStatsInput' type='search' placeholder='Search Filter'>";#search box
		$content .= "<button class='btn btn-primary col-xs-2 col-xs-offset-1' id='stat_schedule_search' onclick='statisticsSearch()'><span class='glyphicon glyphicon-search hide-on-sm-and-up'></span><span class='sr-only'>SEARCH</span> <span class=' hide-on-sm-and-down'>Search</span> </button><br><br>";
		
		$content .= "<div class='row clearfix' id='scheduleStat'>
		<div class='checkbox col-xs-12 col-sm-4'><label><input type='checkbox' id='byTeacherName'> By Teacher's name</label></div>";
        $content .= "<div class='checkbox col-xs-12 col-sm-4'><label><input type='checkbox' id='byTitle'> By Title</label></div>";
        $content .= "<div class='checkbox col-xs-12 col-sm-4'><label><input type='checkbox' id='byClass'> By class</label></div></div>";
        $content .= "</div>";
		#end of search

		#if there are schedules in the database
		if($schedules !== 0 && $schedules!==false)
		{	$content .= "<div class='schedule-table-container'><table class='table table-striped'>
			<tr>
				<th>Teacher</th>
				<th>Schedule Name</th>
				<th>Class</th>
				<th>Stream</th>
				<th>Date</th>
			</tr>";
			foreach($schedules as $schedule )
			{
				$content .= "<tr>
				<td>".$dbInfo->getTeacherName($schedule['teacher_id'])."</td>
				<td>".$schedule['task_title']."</td>
				<td>".$dbInfo->getClassName($schedule['class_id'])."</td>
				<td>".$dbInfo->getStreamName($schedule['stream_id'])."</td>
				<td>".$schedule['task_date']."</td>
			</tr>";
			}
			unset($schedule);#cleanup after foreach
		
			$content .= "</table></div>";
		}
		else if($schedules==0)#query ran successfully but there were 0 schedules in the database
		{
			$content .= $this->noContentMessage('<b>There are currently no schedules.</b><br> Once teachers make schedules, the schedules will appear here');
		}

		$content .= "</div>";#close assignments tab pane

		#assignments tab panel
		$content .= "<div class='table-responsive tab-pane clearfix' id='stats_ass'>";

		#search assignments
		$content .= "<div class='container-fluid clearfix'>";
		$content .= "<br><input class='col-xs-9 admin-search-btn' id='AssStatsInput' type='search' placeholder='Search Filter'>";#search box
		$content .= "<button class='btn btn-primary col-xs-2 col-xs-offset-1' id='stat_ass_search' onclick='statisticsSearch()'><span class='glyphicon glyphicon-search hide-on-sm-and-up'></span><span class='sr-only'>SEARCH</span> <span class=' hide-on-sm-and-down'>Search</span> </button><br><br>";
        $content .= "<div class='row clearfix' id='assStat'><div class='checkbox col-xs-12 col-sm-4'><label><input type='checkbox' id='byTeacherName'> By Teacher's name</label></div>";
        $content .= "<div class='checkbox col-xs-12 col-sm-4'><label><input type='checkbox' id='byTitle'> By Title</label></div>";
        $content .= "<div class='checkbox col-xs-12 col-sm-4' ><label><input type='checkbox' id='byClass'> By class</label></div></div>";
        $content .= "</div>";
		#end of search

		#if there are assignments in the database
		if($assignments !== 0 && $assignments!==false)
		{	$content .= "<div class='stat-table-container'><table class='table table-striped'>
			<tr>
				<th>Teacher</th>
				<th>Title</th>
				<th>Class</th>
				<th>Stream</th>
				<th>Sent Date</th>
				<th>Due Date</th>
			</tr>";
			foreach($assignments as $ass )
			{
				$content .= "<tr>
				<td>".@$dbInfo->getTeacherName($ass['teacher_id'])."</td>
				<td>".@$ass['ass_title']."</td>
				<td>".@$dbInfo->getClassName($ass['class_id'])."</td>
				<td>".@$dbInfo->getStreamName($ass['stream_id'])."</td>
				<td>".@$ass['sent_date']."</td>
				<td>".@$ass['due_date']."</td>
			</tr>";
			}
			unset($ass);#cleanup after foreach
		
			$content .= "</table></div>";
		}
		else if($assignments==0)#query ran successfully but there were 0 schedules in the database
		{
			$content .= $this->noContentMessage('<b>There are currently no assignments</b>.<br> Once teachers send assignments, the assignments will appear here');
		}

		$content .= "</div>";#close assignments tab pane

		$content .= "</div>";#close tab content

		#close div
		$content.="</div>";
		
		#the minimum level admin should be to view this content
		$this->levelRequired = self::STATS_ACCESS_LEVEL;
		
		#error to be shown if access level is not valid
		$error = $this->getErrorContent($this->errorMessage,'nav_stats','');#$this->errorMessage can be swapped with custom error message
        
		#return the content if the user has access rights else show error
		return ($this->restrictAccess($this->levelRequired,$content,$error));
	}

	//returns the profile content
	function getProfile()
	{		

		$content ="<div class='tab-pane fade in panel panel-primary col-xs-12' id='nav_profile'>";#open div

		#content here
		$content .= "<h3 class='center_text'>Profile</h3>";
		// $content .= "<p>This module is still under construction, please check again later.</p>";
		$content .= "<div class='panel-primary container-fluid clearfix'>
			<form class='form' action='handlers/changePassword.php' method='POST'>
				<h6 class='center_text'><b>Username : </b> " . ($_SESSION['s_admin_username']) . "</h6>

			<div class='form-group'>
				<label class='control-label hidden-sm col-sm-2' for='adm_curPass'>Current Password : </label>
				<input required class='col-xs-10 col-xs-offset-1 col-md-4 col-md-offset-0'type='password' name='adm_curPassInput' id='adm_curPass' placeholder='Current Password'></input><br><br>
			</div>

			<div class='form-group'>
				<label class='control-label hidden-sm col-sm-2' for='adm_newPass'>New Password : </label>
				<input required class='col-xs-10 col-xs-offset-1 col-md-4 col-md-offset-0'type='password' name='adm_newPassInput' id='adm_newPass' placeholder='New Password'></input><br><br>
			</div>
			
			<div class='form-group'>
				<label class='control-label hidden-sm col-sm-2' for='adm_confirmPass'>Confirm Password : </label>
				<input required class='col-xs-10 col-xs-offset-1 col-md-4 col-md-offset-0'type='password' name='adm_confirmInput' id='adm_confirmPass' placeholder='Confirm Password'></input><br><br>
			</div>
			
			<button type='submit' class='btn btn-primary col-xs-offset-1 col-sm-offset-4'>CHANGE PASSWORD</button>
			
			<br><br>
			</form>
		</div>";
		
		#close div
		$content.="</div>";
		
		#the minimum level admin should be to view this content
		$this->levelRequired = self::PROFILE_ACCESS_LEVEL;
		
		#error to be shown if access level is not valid
		$error = $this->getErrorContent($this->errorMessage,'nav_profile','');#$this->errorMessage can be swapped with custom error message
        
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
		$this->levelRequired = self::SUPER_USER;
		
		#error to be shown if access level is not valid
		$error = $this->getErrorContent($this->errorMessage,'nav_subjects','');#$this->errorMessage can be swapped with custom error message
        
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
		$this->levelRequired = self::SUPER_USER;
		
		#error to be shown if access level is not valid
		$error = $this->getErrorContent($this->errorMessage,'nav_topics','');#$this->errorMessage can be swapped with custom error message
        
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
		$this->levelRequired = self::NONE_ACCOUNT;
		
		#error to be shown if access level is not valid
		$error = $this->getErrorContent($this->errorMessage,'nav_logout','');
        
		#return the content if the user has access rights else show error
		return ($this->restrictAccess($this->levelRequired,$content,$error));
	}


	//returns the subjects
	public function getSubjects()
	{
		$q = "SELECT subject_id,subject_name,subject_level FROM subjects";
        set_include_path(dirname(__FILE__)."/../../");
        require 'esomoDbConnect.php';
		//require('../esomoDbConnect.php');
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
		$q = "SELECT class_id,class_name FROM class_selection WHERE class_level='" . $subjectLevel . "'";
        set_include_path(dirname(__FILE__)."/../../");
        require 'esomoDbConnect.php';
		//require('../esomoDbConnect.php');
        
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
        set_include_path(dirname(__FILE__)."/../../");
        require 'esomoDbConnect.php';
		//require('../esomoDbConnect.php');
		if($result = mysqli_query($dbCon, $q))
		{
            
            $rows = '';
            while ($row = $result->fetch_assoc()) {
                //echo $row['classtype']."<br>";

                $rows[] = $row;
                //echo $row['class_name'];
            }
			#If there are rows in the table return the rows
			if(mysqli_num_rows($result)>0)
            {
				return $rows;
			}
			else#otherwise return 0
			{
				return 0;
			}   
	
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
	private function getErrorContent($errorInput,$id,$extraClass)#id is the id of the tab pane
    {
		#changed to be handled by bootstrap
		#cannot have it as multiple lines because js will read incorrectly
        return "<div class='$extraClass tab-pane fade in panel panel-primary col-xs-12' id='$id'><h3>Restricted access</h3><p>$errorInput</p></div>";
	}

	#displays a message when there is no content - convenience function
	private function noContentMessage($message)
	{
		return "<div class='container-fluid panel-primary'>
		<div class='panel-body'><h5>$message</h5></div></div>";
	}

	#function to delete assignment - to use in manage assignment section
	function deleteAssignment($ass_id)
	{
		require('../../esomoDbConnect.php');
		$q = "DELETE FROM assignments WHERE ass_id=?";
		if($stmt = $dbCon->prepare($q))
		{
			$stmt->bind_param('i',$ass_id);
			$stmt->execute();
		}
		else
		{
			echo "<p>Error: Could not delete the assignment from the database.</p>";
		}
	}

	#function to delete schedule - to use in manage schedule section
	function deleteSchedule($task_id)
	{
		require('../../esomoDbConnect.php');
		$q = "DELETE FROM schedules WHERE task_id=?";
		if($stmt = $dbCon->prepare($q))
		{
			$stmt->bind_param('i',$task_id);
			$stmt->execute();
		}
		else
		{
			echo "<p>Error: Could not delete the assignment from the database.</p>";
		}
	}

}