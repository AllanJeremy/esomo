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

switch($_POST['contTypeDropdown'])
{
    case 'article':
    addArticle();
    break;

    case 'book':
    addBook();
    break;

    case 'video':
    addVideo();
    break;

    default:
}

#add an article to the database
function addArticle()
{
    echo '<br><br>added an article to the database';
}

#add a book to the database
function addBook()
{
  echo '<br><br>added a book to the database';
}

#add a video to the database
function addVideo()
{
 echo '<br><br>added a video to the database';
}