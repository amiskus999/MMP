<?php
session_start();
include("utilsFunctions.php");

// Checks if the submitted password matches any existing password in the data
function checkPasswordAndEmail($headers, $data, $email, $password){
    foreach($data as $datum){
        if (($email == $datum[$headers["Email"]]) && password_verify($password,$datum[$headers["Password"]])) {
            return true;
        }
    }
    return false;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputEmail = isset($_POST['email']) ? trim($_POST['email']) : '';
    $inputPassword = isset($_POST['password']) ? trim($_POST['password']) : '';
    

    $found = false;
    $db = organizeData();
    if($db != null){
        $header = $db[0];
        $data = $db[1];
        
        if (checkPasswordAndEmail($header, $data, $inputEmail, $inputPassword)) {
            $found = true;
        }
            
    }
    if ($found) {
        $_SESSION['user_email'] = $inputEmail;
        header('Location: ListNewItem.html');
        exit();
    } else {
        // Option 1: Display error and show form again
        $error = "Invalid user-email or password.";
    }
}
?>

