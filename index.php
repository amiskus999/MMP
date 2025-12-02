<?php
session_start();

// If the user is already logged in, redirect them to the Sell page.
if (isset($_SESSION['user_email'])) {
    header('Location: SellPage.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to Midshipman Marketplace</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            background-color: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            text-align: center;
            padding: 16px;
        }

        .welcome-container {
            max-width: 650px;
            padding: 50px 40px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 16px;
        }

        p {
            font-size: 1.125rem;
            color: #4b5563;
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 14px 28px;
            font-size: 1rem;
            font-weight: 500;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background-color: #2563eb;
            color: white;
            box-shadow: 0 4px 6px rgba(37, 99, 235, 0.1);
        }

        .btn-primary:hover {
            background-color: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 7px 10px rgba(37, 99, 235, 0.15);
        }

        .btn-secondary {
            background-color: #e5e7eb;
            color: #1f2937;
        }

        .btn-secondary:hover {
            background-color: #d1d5db;
            transform: translateY(-2px);
        }

        .guest-link {
            margin-top: 32px;
            font-size: 0.9rem;
        }

        .guest-link a {
            color: #4b5563;
            text-decoration: none;
            font-weight: 500;
        }

        .guest-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <h1>Welcome to Midshipman Marketplace</h1>
        <p>The exclusive online marketplace for the Brigade of Midshipmen to buy, sell, and trade goods within the Yard.</p>
        <div class="action-buttons">
            <a href="Login.php" class="btn btn-primary">Login</a>
            <a href="CreateAccount.php" class="btn btn-secondary">Sign Up</a>
        </div>
        <div class="guest-link">
            <a href="BuyPage.php">or continue as a guest &rarr;</a>
        </div>
    </div>
</body>
</html>