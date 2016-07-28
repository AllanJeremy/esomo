<?php

require_once('fileUpload.php');#file that handles file uploads
#adm_contFileInput - content file input name
$fileUpload = new FileUpload();

$fileUpload->uploadContent('adm_contFileInput');