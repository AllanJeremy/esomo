<html lang="en">
    <head>
        <title>Submit Content</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <link  rel="stylesheet" type="text/css" href="../css/theme.min.css"/>
       <link  rel="stylesheet" type="text/css" href="../css/main.css"/>
       <link  rel="stylesheet" type="text/css" href="../css/color.css"/>
    </head>
    
    <body>


<?php
require('../../esomoDbConnect.php');
require_once('fileUpload.php');#file that handles file uploads
#adm_contFileInput - content file input name
$fileUpload = new FileUpload();

if($fileUpload->uploadContent('adm_contFileInput'))
{
echo "<div class='container col-xs-12 col-sm-6 col-sm-offset-3'><h3 class='grey-text col-xs-12 '>Successfully uploaded the content</h3>
<a class='btn btn-primary col-xs-12 col-sm-6 col-sm-offset-3' href='../index.php'>GO BACK TO ADMIN</a> </div>";
}
else {
    echo "<div class='container col-xs-12 col-sm-6 col-sm-offset-3'><h3 class='grey-text col-xs-12 '>Failed to upload the assignment</h3>
<a class='btn btn-primary col-xs-12 col-sm-6 col-sm-offset-3' href='../index.php'>GO BACK TO ADMIN</a> </div>";
}
		

#adm_contTitleInput - content title
#adm_contFileInput - file input
#gradeDropdown - grade dropdown
#topicDropdown - topic dropdown
#subjectDropdown - subject dropwdown
#contTypeDropdown - content type dropdown
$adm_contTitleInput = htmlspecialchars(@$_POST['adm_contTitleInput']);

switch($_POST['contTypeDropdown'])
{
    case 'article':
    addArticle($fileUpload->storage_path);
    break;

    case 'book':
    addBook($fileUpload->storage_path);
    break;

    case 'video':
    addVideo($fileUpload->storage_path);
    break;

    case 'test':
    addTest($fileUpload->storage_path);
    default:
}

#add an article to the database
function addArticle($storagePath)
{
    $q = "INSERT INTO esomo_articles(article_path,article_title,topic_id,thumbnail_path) VALUES(?,?,?,?)";
    $thumbnailPath = '';#path to the thumbnail

    if($stmt = $GLOBALS['dbCon']->prepare($q))
    {
        // echo '<br>added an article to the database';
        // echo "<br><b>File storage path</b> = ".$storagePath;
        
        $stmt->bind_param('ssis',$storagePath,$GLOBALS['adm_contTitleInput'],$_POST['topicDropdown'],$thumbnailPath);

        #Check if the query executed successfully
        if($stmt->execute())
        {
            echo "<p>Added article to database</p>";
            #redirect user
        }
        else #query failed to run, display error message
        {
            echo "<p>Failed to execute the query to add article</p>";
        }
    }
    else #failed to prepare the query
     {
        echo "<p>Error preparing query to add article</p>";
    }
}

#add a book to the database
function addBook($storagePath)
{
    $q = "INSERT INTO esomo_books(book_path,book_title,topic_id,thumbnail_path) VALUES(?,?,?,?)";
    $thumbnailPath = '';#path to the thumbnail

    if($stmt = $GLOBALS['dbCon']->prepare($q))
    {
        $stmt->bind_param('ssis',$storagePath,$GLOBALS['adm_contTitleInput'],$_POST['topicDropdown'],$thumbnailPath);

        #Check if the query executed successfully
        if($stmt->execute())
        {
            echo "<p>Added book to database</p>";
            #redirect user
        }
        else #query failed to run, display error message
        {
            echo "<p>Failed to execute the query to add book</p>";
        }
    }
    else #failed to prepare the query
     {
        echo "<p>Error preparing query to add book</p>";
    }
}

#add a video to the database
function addVideo($storagePath)
{
    $q = "INSERT INTO esomo_videos(video_path,video_title,topic_id,thumbnail_path) VALUES(?,?,?,?)";
    $thumbnailPath = '';#path to the thumbnail

    if($stmt = $GLOBALS['dbCon']->prepare($q))
    {
        $stmt->bind_param('ssis',$storagePath,$GLOBALS['adm_contTitleInput'],$_POST['topicDropdown'],$thumbnailPath);

        #Check if the query executed successfully
        if($stmt->execute())
        {
            echo "<p>Added video to database</p>";
            #redirect user
        }
        else #query failed to run, display error message
        {
            echo "<p>Failed to execute the query to add video</p>";
        }
    }
    else #failed to prepare the query
     {
        echo "<p>Error preparing query to add video</p>";
    }
}


#add a video to the database
function addTest($storagePath)
{
    $q = "INSERT INTO tests(test_title,test_path,subject_id,class_id) VALUES(?,?,?,?)";

    if($stmt = $GLOBALS['dbCon']->prepare($q))
    {
        $stmt->bind_param('ssii',$GLOBALS['adm_contTitleInput'],$storagePath,$_POST['subDropdown'],$_POST['gradeDropdown']);

        #Check if the query executed successfully
        if($stmt->execute())
        {
            echo "<p>Added test to database</p>";
            #redirect user
        }
        else #query failed to run, display error message
        {
            echo "<p>Failed to execute the query to add test<br>".$GLOBALS['dbCon']->error."</p>";
        }
    }
    else #failed to prepare the query
     {
        echo "<p>Error preparing query to add test</p>";
    }
}
?>
</body>
</html>