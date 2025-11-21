<?php
    session_start();
    // Print the contents of the $_POST array
    include_once("utilsFunctions.php");
    $alphaErr = "";
    $emailErr = "";
    $pwdErr = "";
    function registrationForm(){
        global $emailErr;
        global $alphaErr;
        global $pwdErr;
        $FN = $_POST["FN"];
        $pwd = $_POST["pwd"];
        $LN = $_POST["LN"];
        $Al = $_POST["Al"];
        $Email = $_POST["Email"];

        $session_links = '';
        if(isset($_SESSION["user_email"])){
            echo "<li><a href='/~m260105/SI350/Lab07/logout.php'>Logout</a></li>";
            echo '<li><a href="/~m260105/SI350/Lab07/requestReport.php">Request Report</a></li>';
        }else{
            echo '<li><a href="/~m260105/SI350/Lab07/login.php">Login</a></li>';
        }

        $form = <<<HTML
            <head>
            <meta charset="utf-8" />
            <title>
            OCF-USNA-Form
            </title>
            <link type="text/css" rel="stylesheet" href="/~m260105/SI350/Lab07/styles.css">
            </head>
            <body class="formbody">
                <ul id="navbar">
                    <li><a href="/~m260105/SI350/Lab07/index.php">Home</a></li>
                    <li><a href="/~m260105/SI350/Lab07/schedule.php">Schedule</a></li>
                    <li><a href="/~m260105/SI350/Lab07/registration.php">Registration</a></li>
                    <li><a href="/~m260105/SI350/Lab07/login.php">Login</a></li>
                    {$session_links}
                <li><a href="https://www.ocfusa.org/">OCF National</a></li>
                <li><a href="https://www.biblegateway.com/">The Holy Bible</a></li>
            </ul>
            <form method="post" action="submit.php" >
            First name <br><input type="text" name="FN" placeholder="First name" value="{$FN}"> 
            <br>Last name <br><input type="text" name="LN" placeholder="Last name" value= "{$LN}">
            <br>Alpha <br><input type="text" name="Al" placeholder="2xxxxx" value="{$Al}">
            <span style = "color: red;"> {$alphaErr}</span>
            <br> First Timer? <br>
            Yes<input type="radio" name="Yes" value="1">
            No<input type="radio" name="Yes" value="2">
            <!-- <br> Color <input type="color" name="colorex"> -->
            <!-- <br> Date <input type="date" name="dateex"> -->
            <br> Email <input class="inputs" type="email" name="Email" placeholder="m2xxxxx@usna.edu" required value="{$Email}">
            <span style = "color: red;"> {$emailErr}</span>
            <br> Enter password below to sign-up 
            <br><input class= "inputs" type="password" name="pwd" value="" placeholder="at least, 8 characters long" required>
            <span style = "color: red;"> {$pwdErr}</span>
            <br><br> Company?
            <select class="inputs" name="Comp#">
                <option value="1">1st</option>
                <option value="2">2nd</option>
                <option value="3">3rd</option>
                <option value="4">4th</option>
                <option value="5">5th</option>
                <option value="6">6th</option>
                <option value="7">7th</option>
                <option value="8">8th</option>
                <option value="9">9th</option>
                <option value="10">10th</option>
                <option value="11">11th</option>
                <option value="12">12th</option>
                <option value="13">13th</option>
                <option value="14">14th</option>
                <option value="15">15th</option>
                <option value="16">16th</option>
                <option value="17">17th</option>
                <option value="18">18th</option>
                <option value="19">19th</option>
                <option value="20">20th</option>
                <option value="21">21st</option>
                <option value="22">22nd</option>
                <option value="23">23rd</option>
                <option value="24">24th</option>
                <option value="25">25th</option>
                <option value="26">26th</option>
                <option value="27">27th</option>
                <option value="28">28th</option>
                <option value="29">29th</option>
                <option value="30">30th</option>
                <option value="31">31st</option>
                <option value="32">32nd</option>
                <option value="33">33rd</option>
                <option value="34">34th</option>
                <option value="35">35th</option>
                <option value="36">36th</option>   
            </select><br>
            <br> By checking this box, you agree you have paid for the retreat at MWF
            <input type="checkbox" name="checkex1" value="paid">
            
            <br>Check this box if you are a 1/C and can drive to the retreat center<input type="checkbox" name="checkex2" value="driver">
            <br> <button class="button" type="submit">Submit Form</button>
            <br> <button class="button" type="reset">Clear Form</button>    
            <br> Comment section <br><textarea class="inputs"  name="comments-section" placeholder="comment here" rows="3" cols="25"></textarea>
            <!-- <footer><a href="/~m260105/SI350/Lab06/index.html">Back to OCF-USNA</a></footer> -->
            </form>
        <body>
        HTML;
        echo $form;
    }

    function  checkDuplicate($headers, $data,$value){
        foreach($data as $datum){
            if ($_POST[$value] == $datum[$headers[$value]]) {
                return true;
            }
        }
        return false;
    }

    function validate(){
        global $emailErr, $alphaErr, $pwdErr;

        $pwd = $_POST["pwd"];
        $isValid = true;

        $db = organizeData();
        if ($db !== null) {
            $header = $db[0];
            $data = $db[1];
            if (checkDuplicate($header, $data, "Email")) {
                $emailErr = "* email already exists";
                $isValid = false;
            }
        }

        if (strlen($pwd) < 8) {
            $pwdErr = "* password must be at least 8 characters long";
            $isValid = false;
        }
        if (preg_match('/[a-z]+/', $pwd) == 0) {
            $pwdErr = "* password must contain at least a lowercase character";
            $isValid = false;
        }
        if (preg_match('/[A-Z]+/', $pwd) == 0) {
            $pwdErr = "* password must contain at least an Uppercase character";
            $isValid = false;
        }
        if (preg_match('/[0-9]+/', $pwd) == 0) {
            $pwdErr = "* password must contain at least a number";
            $isValid = false;
        }
        // if (!is_numeric($_POST["Al"])) {
        //     $alphaErr = "* Alpha Number must be all numbers";
        //     $isValid = false;
        // }
        return $isValid;
    }
    

    if(validate()){
        $file = fopen("UserDatabase.txt",    "a");
        //$comment = str_replace(["\r\n", "\r", "\n"], "&&", $_POST["comments-section"]);
        $hashedPwd = password_hash($_POST["pwd"], PASSWORD_DEFAULT);
        $usr = $_POST["LN"]."\t".$_POST["FN"]."\t".$_POST["Email"]."\t".$hashedPwd."\n";

        //File headers
        if(filesize("UserDatabase.txt") == 0){
            fwrite($file,"Last Name\tFirst Name\tEmail\tPassword\n");
        }

        fwrite($file,$usr);
    }
?>
        