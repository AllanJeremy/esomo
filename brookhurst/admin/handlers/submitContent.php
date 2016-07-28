<?php
require('../../esomoDbConnect.php');
require_once('fileUpload.php');#file that handles file uploads
#adm_contFileInput - content file input name
$fileUpload = new FileUpload();

$fileUpload->uploadContent('adm_contFileInput');

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
            echo "<br>Added article to database";
            #redirect user
        }
        else #query failed to run, display error message
        {
            echo "failed to execute the query to add article<br>";
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
            echo "<br>Added book to database";
            #redirect user
        }
        else #query failed to run, display error message
        {
            echo "failed to execute the query to add book<br>";
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
            echo "<br>Added video to database";
            #redirect user
        }
        else #query failed to run, display error message
        {
            echo "failed to execute the query to add video<br>";
        }
    }
    else #failed to prepare the query
     {
        echo "<p>Error preparing query to add video</p>";
    }
}