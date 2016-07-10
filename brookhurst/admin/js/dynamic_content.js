//MANAGES DYNAMIC CONTENT IN INDEX.PHP

//Create an ajax request object
var ajaxRequest = CreateHttpResponseRequest();
function CreateHttpResponseRequest(){var e;if(window.ActiveXObject)try{e=new ActiveXObject("Msxml2.XMLHTTP")}catch(t){try{e=new ActiveXObject("MICROSOFT.XMLHTTP")}catch(t){e=!1}}else try{e=new XMLHttpRequest}catch(t){e=!1}return 0==e?alert("Could not create AJAX object. Some features of this page may not work correctly, please use a modern browser"):console.log("Successfully created an ajax request object - good to go."),e}

//----------------------------------------------------------------------------------

var subjectDropdown = document.getElementById('subjectDropdown');
var gradeDropdown = document.getElementById('gradeDropdown');
var topicsDropdown = document.getElementById('topicDropdown'); 
var url = "../admin/handlers/dynamic_content.php";


var params;//parameters for post
var xmlResponse;
var curSubId,curSubLevel,curClassId;

var feedbackContent = document.getElementById('cont_feedback');

//returns a json object
function getCurSubjectInfo()
{
	var subValue =subjectDropdown.value;
	
	var subObj;
	try
	{
		subObj = JSON.parse(subValue);
	}
	catch(e)
	{
		try
		{
			subObj = eval("("+subValue+")");
		}
		catch(e)
		{
			subObj = false;
			console.log("Unable to parse json to get subject data");
		}
	}
	finally
	{
		console.log("id :" + subObj.curSubId + "\nlevel : " + subObj.curSubLevel + "\ngrade : "+ gradeDropdown.value);
	}
	return subObj;
}

/*
TODO:
Note : the ajax request variable name is ajaxRequest
so any ajax functions are ajaxRequest.function() and attribute access ajaxRequest.attribute

----------------------------------------------------------------------------------------
on subjectChanged set $_POST variables

$_POST variable name |  Corresponding javascript variable
cont_curClassId      | curClassId
cont_curSubjectId    | curSubId
cont_curSubjectLevel | curSubLevel

these are updated in updateParams which creates a params string with updated values everytime the function is called

What I need is a way to send these to the server on the subjectChanged() and gradeChanged()
*/

//updates parameters
function updateParams()
{
	var subObj = getCurSubjectInfo();
	curSubjectId = subObj.curSubId;
	curSubLevel = subObj.curSubLevel;
	curClassId = gradeDropdown.value;
	
	console.log("Current subject ID:  "+curSubjectId+"\nSubject Level :"+curSubLevel+"\nClass id: "+curClassId);
	params = "cont_curClassId="+curClassId+"&cont_curSubjectId="+curSubId+"&cont_curSubjectLevel="+curSubLevel;
}

//when the subject selected changes - when value of subjects changes
function subjectChanged()
{
	console.log("\nSubject changed\n");
	getCurSubjectInfo();
	
	updateGrades();
}

//when the grade selected changes - when value of grades dropdown changes
function gradesChanged()
{
	console.log("\nGrade changed\n");
	getCurSubjectInfo();

	updateTopics();
}


//updates the POST values
function updateGrades()
{
	updateParams();
	if(ajaxRequest.readyState == 0 || ajaxRequest.readyState ==4)
	{
		var docElement;
		console.log("Current status : "+ajaxRequest.status);
		if(ajaxRequest.status==200)
		{
		ajaxRequest.onreadystatechange = updateGrades;
		ajaxRequest.open("POST",url,true);
		ajaxRequest.send(params);
		xmlResponse = ajaxRequest.responseXML;
		 docElement= xmlResponse.documentElement;
		 		feedbackContent.innerHTML = docElement.attributes;
		console.log("Updated grades");
		}




	}else
	{
		setTimeout(updateGrades,500);//wait 1/2 a second then try updating the grades again
	}
}

//update the topics
function updateTopics()
{
	updateParams();
	if(ajaxRequest.readyState == 0 || ajaxRequest.readyState ==4)
	{
		console.log("Updated topics");
	}
}

updateParams();//update the params when the script runs
