<?php
session_start();
// If the user is already logged in, redirect them to the BuyPage.
if (isset($_SESSION['user_email'])) {
    header('Location: BuyPage.php');
    exit();
}
include_once("utilsFunctions.php");

$error_message = '';
$email = '';
$isAdmin = 'false';

// Checks if the submitted password matches any existing password in the data
function checkPasswordAndEmail($headers, $data, $email, $password, $isAdmin){
    foreach($data as $datum){
        // Check if header for Email and Password exists and if the data matches
        if (isset($headers["Email"]) && isset($datum[$headers["Email"]]) &&
            isset($headers["Password"]) && isset($datum[$headers["Password"]]) &&
            $email == trim($datum[$headers["Email"]]) && password_verify($password, trim($datum[$headers["Password"]]))) {
            return true;
        }
    }
    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    //$isAdmin = $_POST['isAdmin'] ?? 'false'; //TODO: not sure if this line would work; where is POST made?

    $found = false;
    $db = organizeData();
    $isAdmin == trim($db[$headers["IsAdmin"]]);
    if($db != null){
        $header = $db[0];
        $data = $db[1];
        
        if (checkPasswordAndEmail($header, $data, $email, $password, $isAdmin)) {
            $found = true;
        }
    }

    if ($found) {
        $_SESSION['user_email'] = $email;
        $_SESSION['isAdmin'] = $isAdmin;
        header('Location: SellPage.php'); // Redirect to a user-specific page
        exit();
    } else {
        $error_message = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Midshipman Marketplace - Login</title>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        background: #f8f8f8;
        padding: 40px;
    }

    .container {
        width: 650px;
        margin: auto;
        background: white;
        padding: 40px;
        border-radius: 18px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        min-height: 500px;
    }

    /* Header */
    .header {
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 25px;
    }

    /* Back link */
    .back {
        display: flex;
        align-items: center;
        color: #333;
        text-decoration: none;
        margin-bottom: 25px;
        font-size: 16px;
    }

    .back span {
        margin-left: 5px;
    }

    /* Login box */
    .login-box {
        width: 350px;
        margin: 70px auto 0 auto;
        text-align: center;
    }

    .login-box h3 {
        font-weight: normal;
        margin-bottom: 25px;
    }

    input {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 10px;
        margin-bottom: 18px;
        font-size: 16px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.08);
    }

    .login-btn {
        width: 75%;
        padding: 12px;
        border: none;
        border-radius: 10px;
        margin-left: 15px;
        background: #007bff;
        color: white;
        font-size: 17px;
        cursor: pointer;
    }

    .login-btn:hover {
        background: #006fe0;
    }

    .signup-text {
        margin-top: 12px;
        font-size: 14px;
    }

    .signup-text a {
        color: #007bff;
        text-decoration: none;
        font-weight: bold;
    }
</style>

</head>
<body>

<div class="container">

    <div class="header">Midshipman Marketplace</div>

    <a href="index.php" class="back">
        &#8592; <span>Home</span>
    </a>

    <div class="login-box">
        <h3>Please enter your login details</h3>

        <?php if (!empty($error_message)): ?>
            <div id="error-message" style="color: red; margin-bottom: 15px;"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <form action="Login.php" method="POST">
            <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>" required>
            <input type="password" name="password" placeholder="Password" required>
            <button class="login-btn" type="submit">Login</button>
        </form>

        <div class="signup-text">
            Don't have an account? <a href="CreateAccount.php">Sign Up</a>
        </div>
    </div>

</div>

</body>
</html>
