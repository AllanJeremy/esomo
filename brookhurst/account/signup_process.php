 <?php

    //initialize all variables
    $fName = $lName = $username = $email = $confirmEmail = $pass = $confrimPass = $accType = "";

    //validates data and returns valid form of the data
    function validateData($data)
    {
      $data = trim($data);#remove whitespace
      $data = stripslashes($data);#remove slashes
      $data = htmlspecialchars($data);#remove html special characters
      return $data;
    }

    //Check if the request method is post and act accordingly
    if ($_POST)
    {
      $fName = validateData($_POST['firstNameInput']);
      $lName = validateData($_POST['lastNameInput']);
      $username = validateData($_POST['usernameInput']);
      $email = validateData($_POST['emailInput']);
      $confirmEmail = validateData($_POST['emailConfirmInput']);
      $pass = validateData($_POST['passwordInput']);
      $confirmPass = validateData($_POST['passwordConfirmInput']);
      $accType = validateData($_POST['accTypeOption']);

     
    }
