<?php
session_start();

// We just check if the user is logged in.
/*
We check if Admin's flag is set in the post session. If is set, we allow access to the report page.
This program employs the user logic from Lab07. It was modified with the help of Gemini, especially the CSS part.
*/
if (!isset($_SESSION['user_email'])) {
    header('Location: Login.php');
    exit();
}
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 'true') {
    header('Location: Login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Marketplace - Request Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f8f8f8;
            padding: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            width: 500px;
            background: white;
            padding: 40px;
            border-radius: 18px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            text-align: center;
        }

        .header {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 25px;
        }

        .back {
            display: inline-block;
            color: #333;
            text-decoration: none;
            margin-bottom: 25px;
            font-size: 16px;
        }

        label {
            font-size: 18px;
            font-weight: 500;
            display: block;
            margin-bottom: 15px;
        }

        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 10px;
            margin-bottom: 25px;
            font-size: 16px;
        }

        .report-btn {
            width: 50%;
            padding: 12px;
            border: none;
            border-radius: 10px;
            background: #007bff;
            color: white;
            font-size: 17px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .report-btn:hover {
            background: #006fe0;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">Admin Reports</div>
    <a href="index.php" class="back">&#8592; <span>Home</span></a>

    <form action="AdminReport.php" method="POST">
        <label for="report_criteria">Select a report to generate:</label>
        <select name="report_criteria" id="report_criteria">
            <option value="all">All Listings</option>
            <option value="New">Listings: New</option>
            <option value="Used - Good">Listings: Used - Good</option>
            <option value="Used - Fair">Listings: Used - Fair</option>
            <option value="users">All Users</option>
        </select>
        <button type="submit" class="report-btn">Generate Report</button>
    </form>
</div>

</body>
</html>
