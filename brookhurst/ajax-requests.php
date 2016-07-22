<?php


include_once('esomoDbConnect.php');



  $result = mysql_query("SELECT * FROM subjects");          //query
  $array = mysql_fetch_row($result);                          //fetch result    
echo json_encode($array);
?>