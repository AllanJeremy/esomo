<?php

class FileUpload
{
    #CONSTANTS STORING THE UPLOAD PATHS - WHERE FILES WILL BE UPLOADED TO
    const CONTENT_UPLOAD_PATH = '../../test_uploads/content/';
    const ASSIGNMENT_UPLOAD_PATH = '../../test_uploads/ass_content/';

    #variable that stores the storage name of a file
    public $storage_path;

    #constructor
    function __construct()
    {
        $this->storage_path='';#initialize the storage name as an empty string
    }

    #generic upload file function, handles all kinds of uploads [fileName is the name of the input field]
    function uploadFile($fileName,$uploadPath)
    {

        #if the file name is set(we have a file)
        if(isset($fileName))
        {   
            #if a file has been selected
            if(!empty($fileName))
            {
                $name = $_FILES["$fileName"]['name'];
                $tmp_path = $_FILES["$fileName"]['tmp_name'];

                #date format = yy-mm-dd-h-m-s 
                $storage_name = (date('Y-m-d_H-i-s')).'_'.$name;#to prevent duplicate file names consider encrypting for even less duplicate probability
                echo '<p>File selected and will be stored with name : <b>'.$storage_name.'</b></p>';
                try
                {
                    $this->storage_path = $uploadPath.$storage_name;

                    #Try uploading the file
                    if(move_uploaded_file($tmp_path,$this->storage_path))
                    {
                        #truncates the storage path so that we only get the relative path for effective storage in database
                        $this->storage_path = substr($this->storage_path,6);#only use if using the same host as file handler
                        echo "<p>File uploaded successfully to : <b>".$uploadPath."</b></p>";
                    }
                    else#if the upload fails throw an exception
                    { 
                        throw new Exception("<p style='color:red'>There was an error uploading your file</p>",552470); 
                    }
                }
                catch(Exception $e)
                {
                    echo $e;
                }

            }
            else
            {
                echo 'Please select a file';
            }
        }
        else #no file has been selected
        {
            echo 'File name is not set';
        }
    }

    #Upload a content item
    function uploadContent($fileName)
    {
        $this->uploadFile($fileName,self::CONTENT_UPLOAD_PATH);
    }

    #Upload an assignment item
    function uploadAss($fileName)
    {
        $this->uploadFile($fileName,self::ASSIGNMENT_UPLOAD_PATH);
    }
}