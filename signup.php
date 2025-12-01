<?php
    session_start();
    include_once("utilsFunctions.php");

    $emailErr = "";
    $pwdErr = "";

    function  checkDuplicate($headers, $data,$value){
        foreach($data as $datum){
            // Check if the header key exists to avoid errors
            if (isset($headers[$value]) && isset($datum[$headers[$value]]) && $_POST[$value] == $datum[$headers[$value]]) {
                return true;
            }
        }
        return false;
    }

    function validate(){
        global $emailErr, $pwdErr;

        $password = $_POST["password"];
        $isValid = true;

        $db = organizeData();
        if ($db !== null) {
            $header = $db[0];
            $data = $db[1];
            if (checkDuplicate($header, $data, "email")) {
                $emailErr = "Email already in use.";
                $isValid = false;
            }
        }

        if (strlen($password) < 8) {
            $pwdErr = "Password must be at least 8 characters long.";
            $isValid = false;
        }
        if (preg_match('/[a-z]/', $password) == 0) {
            $pwdErr = "Password must contain at least one lowercase letter.";
            $isValid = false;
        }
        if (preg_match('/[A-Z]/', $password) == 0) {
            $pwdErr = "Password must contain at least one uppercase letter.";
            $isValid = false;
        }
        if (preg_match('/[0-9]/', $password) == 0) {
            $pwdErr = "Password must contain at least one number.";
            $isValid = false;
        }
        return $isValid;
    }
    

    if(validate()){
        $file = fopen("UserDatabase.txt", "a");
        $hashedPwd = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $usr = $_POST["username"]."\t".$_POST["email"]."\t".$hashedPwd."\n";

        //File headers
        if(filesize("UserDatabase.txt") == 0){
            fwrite($file,"Username\tEmail\tPassword\n");
        }

        fwrite($file,$usr);
        fclose($file);

        // Redirect to login page on success
        header("Location: Login.html");
        exit();
    } else {
        // If validation fails, redirect back to signup with an error message
        $error = $emailErr ?: $pwdErr; // Use email error if it exists, otherwise use password error
        header("Location: CreateAccount.html?error=" . urlencode($error));
        exit();
    }
?>

