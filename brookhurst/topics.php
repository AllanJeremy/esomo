<?php

//THIS FILE CONTROLS HOW TOPICS ARE DISPLAYED ON THE SITE
if(!class_exists('TopicHolder'))
{
class TopicHolder{

	private $topicCount;#will store the total number of topics, used for url validity
	private $startTopicIndex;
	//protected $currentArticleTitle;
	//protected $currentArticlePath;

	function __construct(){
		$this->topicCount=0;
		include_once('esomoErrorHandler.php');	
		
	}

	function generateTopicsPage($subjectName)
	{
		$sId = $_GET['subId'];//subjectId

		$backButton = "<a class='learnPrevBtn hidden-xs' href='?subId=$sId'><span class='glyphicon glyphicon-step-backward' style='font-size:1.25em'>Previous</span></a>";
		
		$subjectSelection="<a class='learnPrevBtn hidden-xs' href='?'><span class='glyphicon glyphicon-fast-backward' style='font-size:1.25em'>Subjects</span></a>";

		$pageTitle =$backButton . $subjectSelection . "<h3 style='text-align:center;margin-bottom:1em'> Grade ". ( @htmlspecialchars($_GET['fId']) ) . " - " . $subjectName . "</h3>";

		echo "<div class='well clearfix'>";//open wrapper well div
		echo $pageTitle;
		$this->createSearchPanel();
		$this->createTopicPanel();//create the topic panel - sets the $topicCount variable
		
		if((@$_GET['tId'])!==null)//if it is a valid number check if the number is valid
		{	
			$errHandler = new CustomErrorHandler();
			if($errHandler->urlTopicIdIsValid($this->getStartTopicIndex(),$this->getTopicCount()))//if the topic Id is valid
			{
				$this->createInfoPanel();//create the info panel
			}else
			{
				$errHandler->displayInvalidTopicPage();
			}
			unset($errHandler);
		}
		else
		{
			$this->createIntroPanel();//create the introduction panel 
		}
		
		echo "</div>";//close well div
	}
	
	//Creates the search panel
	function createSearchPanel()
	{

		$searchPanelStyle = 'background-color:rgba(0,0,0,0.8);margin-bottom:1em;';
		$searchPanel = <<<EOD
		<div class='col-xs-12' style=$searchPanelStyle>
			<div style='float:right;'>
				<input type="text" placeholder="Search">
				<button type="button" class="btn btn-primary" name="btn_topicSearch">
					<span class="glyphicon glyphicon-search"></span>
				</button>
			</div>
		</div>
EOD;

		echo $searchPanel;
	}

	//creates the topic panel
	function createTopicPanel()
	{

		require("eSomoDbConnect.php");// require the connection to the dp, aids generation of topic panel

		$closeDiv = "</div>";

		$currSubjectId = htmlspecialchars($_GET['subId']);
		$currClassId = htmlspecialchars($_GET['fId']);


		#if we got here it means the subject id is a valid integer
		$selectTopicsQuery="SELECT topic_id,topic_name FROM topics WHERE subject_id=$currSubjectId AND class_id=$currClassId";//testing with subjects

		//$dbCon;
		$tPanelStyle = 'background-color:rgba(0,0,0,0.8);overflow:auto;';
		$topicPanel ="<div class='col-md-2 col-lg-3' style=$tPanelStyle >";
		
		echo ($topicPanel);
		
		echo "<p class='center_text' id='topicTitle'>Topics</p>";

		$result;
	
	//try preparing the selectTopics query
	if($dbCon->prepare($selectTopicsQuery))
	{
		$result = $dbCon->query($selectTopicsQuery);

		$tCount=0;#gives us the total number of topics
		$count = 0;#ensures code runs only once below

		echo "<ol id='topicList'>";
		foreach ($result as $topicItem) {

			
			$tmp_topicName = &$topicItem['topic_name'];
			$tmp_topicId = &$topicItem['topic_id'];
			
			if($count==0)//run only once
			{
				#set the value as the start value
				 $this->setStartTopicIndex($tmp_topicId);
				
			}
			$count++;
			$tCount = $tmp_topicId;

			echo "\n<li class='topicItem'>";
			echo "\n<a href='learn.php?subId=$currSubjectId&fId=$currClassId&tId=$tmp_topicId' class='topicLink'>" . $tmp_topicName . "</a>";
			echo "<span class='vSplitter col-xs-12 col-sm-12'/>";
			echo "</li>";
		}

		echo "</ol>";
		$this->setTopicCount($tCount);
		
		//cleanup variables used in the foreach
		unset($topicItem);
		unset($result);
		unset($tmp_topicName);
		unset($tmp_topicId);
	}
	else//query could not be run
	{
		echo "<p class='dbError'>Error:990.<br>Unable to run query to generate topics </p><p class='dbMessage'>".$dbCon->error."</p>";
	}

		

		echo $closeDiv;
		
	}
	//creates the introduction panel
	function createIntroPanel()
	{
		$introPanelContent = <<<EOD
		\n
		<div class='container well col-md-8 col-md-offset-1 col-xs-12 col-sm-12'>
			<h3> Select a topic to show contents</h3>
			<p>Click on any topic on the topics panel to show the contents of that topic</p>
		</div>
EOD;
		echo $introPanelContent;
	}

	//creates the info panel - function called after a topic has been selected 
	function createInfoPanel()
	{#safe to use SQL query to get information on topic for the tabs, no empty tabs at any given point

		$tabStyle = 'margin:0,0.1em';
		$bgColor = 'rgba(0,0,0,0.9)';
		$closeDiv = "</div>";

		$infoPanelTabs = <<<EOD
		<ul class="nav nav-tabs nav-justified">
				<li style=$tabStyle class='active'><a data-toggle="tab" href="#tContentsWrapper">Content</a></li>
				<li style=$tabStyle><a data-toggle="tab" href="#articlesWrapper">Articles</a></li>
				<li style=$tabStyle ><a data-toggle="tab" href="#booksWrapper">Books</a></li>
				<li style=$tabStyle ><a data-toggle="tab" href="#videosWrapper">Videos</a></li>
		</ul>
EOD;
		

		$topicContent=$this->genContentSection();//variable to store the contents of the objective panel

		$articleContent=$this->genArticleSection();#variable to store the contents of the articles tab
		
		$bookContent = $this->genBookSection();#variable to store the contents of the books tab

		$videoContent = $this->genVideoSection();#variable to store the contents of the video tab
	
		$infoPanel = <<<EOD
		<div class='col-lg-8 col-lg-offset-1 col-md-8 col-md-offset-1 col-xs-12 col-sm-12' style='height:100%;background-color:$bgColor;padding:0.5em'>
			
			$infoPanelTabs
			<div class="tab-content well">

				<div class="tab-pane active clearfix" id="tContentsWrapper">
					$topicContent
				</div>
				<div class="tab-pane clearfix" id="articlesWrapper">
					$articleContent
				</div>
				<div class="tab-pane clearfix" id="booksWrapper">
					$bookContent
				</div>
				<div class="tab-pane clearfix" id="videosWrapper">
					$videoContent	
				</div>
			</div>
		</div>
		
EOD;


		$errHandler = new CustomErrorHandler();
		//IF TOPIC_ID VALID
		if ($errHandler->urlTopicIdIsValid($this->getStartTopicIndex(),$this->getTopicCount()) === TRUE)
		{	#prevents any query from running if topic Id is invalid
			
			echo $infoPanel;//print out the info panel to the screen
			echo $closeDiv;
		}else{
			$errHandler->displayInvalidTopicPage();
		}
	}//End of function

	//Generate the content section - done
	function genContentSection()
	{	
			$curTopicId = $this->getCurrentTopicId();

			require('eSomoDbConnect.php');#only require the dp if the url is valid

			$contentQuery = "SELECT sub_topic_name FROM sub_topics WHERE topic_id=$curTopicId";
			$contentHeader = "";
			$contentOutput = "";#initialize the content output

			if($contentResult = $dbCon->query($contentQuery))
			{
				#if no content has been posted for the topic - show the default message
				if (mysqli_num_rows($contentResult)==0)
				{
					$title = "No topic content available";
					$message = "The topic content has not yet been added. Please check back again later";

					return $this->noContentMessage($title,$message);
				}
				else {
					# content header appears above the content output
					$contentHeader = "<h3 class='center_text'> [CONTENT]". $this->getTopicName($curTopicId) ." </h3>";	
				}


				$contentOutput = $contentHeader . "<ol>";
				
				foreach($contentResult as $contentItem)
				{
					$contentOutput .=  "\n<li><p>" . $contentItem['sub_topic_name'] . "</p></li>";
				}
				$contentOutput .="</ol>";
			}

		unset($errHandler);
		$dbCon->close();#close database once we are done using it
		return $contentOutput;
	}
	//Generate the article section - returns article content
	function genArticleSection()
	{
		//variable to store the contents of the article tab
		$curTopicId=$this->getCurrentTopicId();#current topic id - returns 0 if invalid

		if ($curTopicId!=0)//if we have a valid topicId
		{	
			require('eSomoDbConnect.php');
			$articleQuery = "SELECT * FROM esomo_articles WHERE topic_id = $curTopicId";#to add restriction to display only content for the account type logged

			if ($articleResult = $dbCon->query($articleQuery))
			{
				$articlesContent = "<div>";

				//if no books have been posted yet
				if(mysqli_num_rows($articleResult)==0)
				{
					$title ="No articles available";
					$message = "No articles have been posted for this topic as yet. Please check back again later.";
					$articlesContent .= $this->noContentMessage($title,$message);
				}
				else
				{
				$articlesContent .= "<table class='table'>";
				foreach ($articleResult as $result) {
					$tmp_articleName = $result['article_title'];#article title
					$tmp_articlePath = $result['article_path'];#article path
					$tmp_articleId = $result['article_id'];#article id
					$tmp_dateAdded = $result['date_added'];

					//path to the article document handler
					$pathExtension = "#";

					#generate article section using the information above

					if($tmp_articlePath!='' && $tmp_articlePath!==null)
					{
						$pathExtension = $tmp_articlePath;	
						$articleSnippet = "<tr><td>$tmp_articleName <i class='float_right'>- Added $tmp_dateAdded</i></td>
					<td><a class='btn btn-default' href='$pathExtension' download='$tmp_articleName'>Download</a> </td></tr>\n";
					}
					else
					{
						$articleSnippet = "<tr><td>  $tmp_articleName <i class='float_right'>- Added $tmp_dateAdded</i></td>
					<td> <a class='btn btn-default' href='$pathExtension'>Download</a></td></tr>\n";
					}
					
					
					$articlesContent .= $articleSnippet;#customizable snippet.
					$articlesContent .= "</table>";
				}
				}
				$articlesContent .= "</div>";

				unset($tmp_articleName);
				unset($tmp_articlePath);
				unset($articleResult);
				unset($result);
				return $articlesContent;
			}

			else
			{
				$errHandler = new CustomErrorHandler();
				$errHandler->displayInvalidTopicPage();
			}
		}
	
	}
	
	//Generate the book section - returns book content
	function genBookSection()
	{
		//variable to store the contents of the article tab
		$curTopicId=$this->getCurrentTopicId();#current topic id - returns 0 if invalid

		if ($curTopicId!=0)//if we have a valid topicId
		{	
			require('eSomoDbConnect.php');
			$bookQuery = "SELECT * FROM esomo_books WHERE topic_id = $curTopicId";#to add restriction to display only content for the account type logged

			if ($bookResult = $dbCon->query($bookQuery))
			{
				$booksContent = "<div>";

				//if no books have been posted yet
				if(mysqli_num_rows($bookResult)==0)
				{
					$title ="No books available";
					$message = "No books have been posted for this topic as yet. Please check back again later.";
					$booksContent .= $this->noContentMessage($title,$message);
				}
				else
				{

				$booksContent .= "<table class='table'>";
				foreach ($bookResult as $result) {
					$tmp_bookName = $result['book_title'];#article title
					$tmp_bookPath = $result['book_path'];#article path
					$tmp_bookId = $result['book_id'];#article id
					$tmp_dateAdded = $result['date_added'];

					//path to the article document handler
					$pathExtension = "#";

					#generate article section using the information above

					if($tmp_bookPath!='' && $tmp_bookPath!==null)
					{
						$pathExtension = $tmp_bookPath;
						#snippet that controls how content is viewd
						$bookSnippet = "<tr><td> $tmp_bookName  <i class='float_right'>- Added $tmp_dateAdded</i></td>
						<td><a class='btn btn-default' href='$pathExtension' download='$tmp_bookName'>Download</a></td></tr>\n";
				    }
					else
					{
						#snippet that controls how content is viewd
						$bookSnippet = "<tr><td> $tmp_bookName <i class='float_right'>- Added $tmp_dateAdded</i></td>
						<td><a class='btn btn-default' href='$pathExtension'>Download</a></td></tr>\n";
					}


					
					$booksContent .= $bookSnippet;#Customizable snippet - how each item is viewed
					$booksContent .= "</table>";
					}#end of foreach
				}
				$booksContent .= "</div>";

				unset($tmp_bookName);
				unset($tmp_bookPath);
				unset($bookResult);
				unset($result);
				return $booksContent;
			}

			else
			{
				$errHandler = new CustomErrorHandler();
				$errHandler->displayInvalidTopicPage();
			}
		}
	}

	//Generate the video section  - returns the video section
	function genVideoSection()
	{
		//variable to store the contents of the article tab
		$curTopicId=$this->getCurrentTopicId();#current topic id - returns 0 if invalid

		if ($curTopicId!=0)//if we have a valid topicId
		{	
			require('eSomoDbConnect.php');
			$videoQuery = "SELECT * FROM esomo_videos WHERE topic_id = $curTopicId";#to add restriction to display only content for the account type logged

			if ($videoResult = $dbCon->query($videoQuery))
			{
				$videosContent = "<div>";

			   //if no books have been posted yet
				if(mysqli_num_rows($videoResult)==0)
				{
					$title ="No videos available";
					$message = "No videos have been posted for this topic as yet. Please check back again later.";
					$videosContent .= $this->noContentMessage($title,$message);
				}
				else
				{
				$videosContent .= "<table class='table'>";
				foreach ($videoResult as $result) {
					$tmp_videoName = $result['video_title'];#article title
					$tmp_videoPath = $result['video_path'];#article path
					$tmp_videoId = $result['video_id'];#article id
					$tmp_dateAdded = $result['date_added'];

					//path to the article document handler
					$pathExtension = "/esomo/book.php?a=$tmp_videoId";

					#generate book section using the information above
					#generate article section using the information above

					if($tmp_videoPath!='' && $tmp_videoPath!==null)
					{
						$pathExtension = $tmp_videoPath;
						$videoSnippet = "<tr><td> $tmp_videoName <i class='float_right'>- Added $tmp_dateAdded</i></td>
						<td> <a class='btn btn-default' href='$pathExtension' download='$tmp_videoName'>Download</a> </td></tr>\n";
					}
					else
					{
						$videoSnippet = "<tr><td> $tmp_videoName <i class='float_right'>- Added $tmp_dateAdded</i></td>
						<td> <a class='btn btn-default' href='$pathExtension'>Download</a> </td></tr>\n";
					}
					}#end of for loop	
					$videosContent .= $videoSnippet;#snippet customizable
					$videosContent .= "</table>";						
				}

			}#end of query if
				$videosContent .= "</div>";

				unset($tmp_videoName);
				unset($tmp_videoPath);
				unset($videoResult);
				unset($result);
				return $videosContent;
			}

			else
			{
				$errHandler = new CustomErrorHandler();
				$errHandler->displayInvalidTopicPage();
			}
		
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
			$dbCon->close();
			return $currentSubjectName;
		}else
		{
			$dbCon->close();
			return 0;
		}
	}

	function getTopicName($currTopicId){
		#convenience function
		require('esomoDbConnect.php');
		$topicNameQuery = "SELECT topic_name FROM topics WHERE topic_id=$currTopicId";
		$currentTopicName = "";#the name of the current topic

		if($fetchNameQuery = $dbCon->prepare($topicNameQuery))
		{
			$fetchNameQuery->execute();
			$topicNameArray = $fetchNameQuery->get_result();
			
			//get the current topicName
			foreach ($topicNameArray as $topicName) {
				$tmp_curTopicName = $topicName['topic_name'];
				$currentTopicName = $tmp_curTopicName;
				
			}
			//unset temporary variables
			return $currentTopicName;
		}else
		{
			return 0;
		}
	}
	function getCurrentTopicId()
	{
		
		$errHandler = new CustomErrorHandler();

		if ($errHandler->urlTopicIdIsValid($this->getStartTopicIndex(),$this->getTopicCount()) === TRUE)//IF TOPIC_ID VALID
		{

			$currentTopicId = stripslashes(htmlspecialchars($_GET['tId']));
		}else{

			$currentTopicId = 0;
		}

		return $currentTopicId;
	}
	//Setter for topicCount
	private function setTopicCount($topicCount)
	{
		$this->topicCount = $topicCount;
	}

	//Getter for topicCount
	public 	function getTopicCount(){
		return $this->topicCount;
	}


	//Setter for startTopicIndex
	private function setStartTopicIndex($index)
	{
		$this->startTopicIndex = $index;
	}

	//shows a message when there is no content for  a particular section
	private function noContentMessage($title,$message)
	{
		return "<div class='panel panel-info col-xs-12 col-sm-10 col-sm-offset-1'>
		<div class='panel-header' style='background-color:transparent'>
			<h4 class='center_text'>$title</h4>
		</div>
		<div class='panel-body'>
		<p>$message</p>
		</div>
		</div>";
	}
	//Getter for start topic index
	public function getStartTopicIndex()
	{
		return $this->startTopicIndex;
	}
}#end of class
}#end of if