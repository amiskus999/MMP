<?php
session_start();
include_once("utilsFunctions.php"); // Assuming this file exists and contains organizeData()

$error_message = '';
$username = '';
$email = '';
$isAdmin = 'false';

function checkDuplicate($headers, $data, $value) {
    foreach ($data as $datum) {
        // Check if the header key exists to avoid errors
        if (isset($headers[$value]) && isset($datum[$headers[$value]]) && trim($_POST[$value]) == trim($datum[$headers[$value]])) {
            return true;
        }
    }
    return false;
}

function validate(&$error_message) {
    $password = $_POST["password"];
    $isValid = true;

    $db = organizeData();
    if ($db !== null) {
        $header = $db[0];
        $data = $db[1];
        if (checkDuplicate($header, $data, "Email")) {
            $error_message = "Email already in use.";
            $isValid = false;
        }
    }

    if (strlen($password) < 8) {
        $error_message = "Password must be at least 8 characters long.";
        $isValid = false;
    }
    if (preg_match('/[a-z]/', $password) == 0) {
        $error_message = "Password must contain at least one lowercase letter.";
        $isValid = false;
    }
    if (preg_match('/[A-Z]/', $password) == 0) {
        $error_message = "Password must contain at least one uppercase letter.";
        $isValid = false;
    }
    if (preg_match('/[0-9]/', $password) == 0) {
        $error_message = "Password must contain at least one number.";
        $isValid = false;
    }
    return $isValid;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $isAdmin = $_POST['isAdmin'] ?? 'false'; //TODO: not sure if this is necessary

    if (validate($error_message)) {
        $file = fopen("data/UserDatabase.txt", "a");
        if ($file) {
            // Add headers if the file is new/empty
            if (filesize("data/UserDatabase.txt") == 0) {
                fwrite($file, "Username\tEmail\tPassword\tIsAdmin\n");
                // ADMIN USER CREDENTIALS:
                // Username: admin
                // Email: admin@admin.org
                // Password: AdminAdmin12
                fwrite($file, "admin" . "\t" . "admin@admin.org" . "\t" .	"$2y$10\$PVm5PlAsjKsMPA4q7DSBzuLEqZWlbvIhd5/TlScKvuNtnuIOdex1K" . "\t" . "true" . "\n");
            }
            $isAdmin = "false";
            $hashedPwd = password_hash($_POST["password"], PASSWORD_DEFAULT);
            $usr = $_POST["username"] . "\t" . $_POST["email"] . "\t" . $hashedPwd . "\t" . $isAdmin .
            "\n";
            fwrite($file, $usr);
            fclose($file);

            // Redirect to login page on success
            header("Location: Login.php");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Midshipman Marketplace - Sign Up</title>

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

    /* Signup box */
    .signup-box {
        max-width: 350px;
        margin: 0 auto;
        text-align: center;
        display: flex;
        flex-direction: column;
    }

    .signup-box h3 {
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

    .signup-btn {
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

    .signup-btn:hover {
        background: #006fe0;
    }

    .login-text {
        margin-top: 12px;
        font-size: 14px;
    }

    .login-text a {
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

    <div class="signup-box">
        <h3>Create an account</h3>

        <?php if (!empty($error_message)): ?>
            <div id="error-message" style="color: red; margin-bottom: 15px;"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <form action="CreateAccount.php" method="POST">
            <input type="email" id="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
            <input type="text" id="username" name="username" placeholder="Username" value="<?php echo htmlspecialchars($username ?? ''); ?>" required>
            <input type="password" name="password" placeholder="Password" required>
            <!-- TODO: Not sure if this works -->
            <input type="hidden" id="isAdmin" value="<?php echo htmlspecialchars($isAdmin ?? 'false'); ?>">
            <button class="signup-btn" type="submit">Sign Up</button>
        </form>

        <div class="login-text">
            Already have an account? <a href="Login.php">Login</a>
        </div>
    </div>

</div>

</body>
</html>