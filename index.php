<?php
/** File: index.php
 * Description: Start the session — MUST be the first line before any HTML output.
 * This allows us to check if the user is logged in and access session variables.
 **/
session_start();
?>
<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Midshipman Marketplace</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        /* Reset */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a, #1e3a8a);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* Card container */
        .marketplace-card {
            background: white;
            width: 100%;
            max-width: 440px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 
                0 20px 25px -5px rgba(0, 0, 0, 0.2),
                0 10px 10px -5px rgba(0, 0, 0, 0.1);
            transition: 0.3s ease;
        }

        .marketplace-card:hover {
            transform: translateY(-5px);
        }

        /* Header */
        .card-header {
            background: #1e3a8a;
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }

        /* Decorative glow */
        .card-header::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            filter: blur(20px);
        }

        .header-content {
            position: relative;
            z-index: 2;
        }

        .icon-anchor {
            font-size: 48px;
            color: #fbbf24;
            margin-bottom: 15px;
        }

        .card-header h1 {
            font-family: 'Playfair Display', serif;
            color: white;
            font-size: 28px;
        }

        /* Body */
        .card-body {
            padding: 32px;
            text-align: center;
        }

        .subtitle {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .highlight-text {
            color: #1e3a8a;
        }

        .description {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 30px;
        }

        /* Buttons */
        .btn {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            padding: 14px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            gap: 8px;
            transition: 0.2s ease;
        }

        .btn-primary {
            background: #f59e0b;
            color: #0f172a;
            margin-bottom: 15px;
        }

        .btn-primary:hover {
            background: #fbbf24;
        }

        .btn-secondary {
            background: transparent;
            color: #1e3a8a;
            border: 2px solid #1e3a8a;
        }

        .btn-secondary:hover {
            background: #eff6ff;
        }

        .btn-secondary + .btn-secondary {
            margin-top: 10px;
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
            font-size: 14px;
            margin: 10px 0;
            gap: 10px;
        }

        .divider::before, .divider::after {
            content: "";
            height: 1px;
            background: #e5e7eb;
            flex-grow: 1;
        }

        /* Footer */
        .card-footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #f3f4f6;
        }

        .footer-label {
            font-size: 10px;
            text-transform: uppercase;
            color: #9ca3af;
            margin-bottom: 10px;
        }

        .credits-container {
            display: flex;
            justify-content: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .credit-pill {
            background: #f3f4f6;
            color: #4b5563;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
        }
    </style>
</head>
<body>

    <div class="marketplace-card">

        <!-- Header with icon and title -->
        <div class="card-header">
            <div class="header-content">
                <i class="fa-solid fa-anchor icon-anchor"></i>
                <h1>Midshipman Marketplace</h1>
            </div>
        </div>

        <!-- Main content -->
        <div class="card-body">

            <h2 class="subtitle">
                Think Facebook Marketplace,<br> 
                <span class="highlight-text">but for the Brigade.</span>
            </h2>

            <p class="description">
                Buy gear, sell books, and trade items exclusively with other Midshipmen.
            </p>

            <!-- Create account button -->
            <a href="CreateAccount.php" class="btn btn-primary">
                <span>Create Account</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>

            <div class="divider">or</div>

            <?php 
            // Show different buttons based on login status
            if (isset($_SESSION['user_email'])): 
            ?>

                <!-- Logged-in user options -->
                <a href="BuyPage.php" class="btn btn-secondary">Buy Items</a>
                <a href="SellPage.php" class="btn btn-secondary">Sell Items</a>

                <?php 
                // Show admin option only for admins
                if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 'true'): 
                ?>
                    <a href="RequestReport.php" class="btn btn-secondary">Request Report</a>
                <?php endif; ?>

                <a href="Logout.php" class="btn btn-secondary">Log Out</a>

            <?php else: ?>

                <!-- Not logged in -->
                <a href="Login.php" class="btn btn-secondary">Log In</a>

            <?php endif; ?>

            <!-- Footer credits -->
            <div class="card-footer">
                <p class="footer-label">Developed By</p>

                <div class="credits-container">
                    <span class="credit-pill">Johnson Ampofo</span>
                    <span class="credit-pill">Austin Benigni</span>
                    <span class="credit-pill">Michael Katson</span>
                </div>
            </div>

        </div>
    </div>

</body>
</html>
