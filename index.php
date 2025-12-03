<?php
session_start(); // Must be the very first thing on the page
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
    
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        /* --- Reset & Base --- */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            /* Navy Gradient Background */
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: #333;
        }

        /* --- Main Card --- */
        .marketplace-card {
            background-color: #ffffff;
            width: 100%;
            max-width: 440px;
            border-radius: 16px;
            overflow: hidden; /* Ensures child elements don't spill out of rounded corners */
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .marketplace-card:hover {
            transform: translateY(-5px);
        }

        /* --- Header Section --- */
        .card-header {
            background-color: #1e3a8a; /* Navy Blue */
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }

        /* Decorative circle effect */
        .card-header::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 120px;
            height: 120px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            filter: blur(20px);
            z-index: 1;
        }

        .header-content {
            position: relative;
            z-index: 2;
        }

        .icon-anchor {
            font-size: 48px;
            color: #fbbf24; /* Gold */
            margin-bottom: 15px;
            display: inline-block;
            text-shadow: 0 4px 6px rgba(0,0,0,0.2);
        }

        .card-header h1 {
            font-family: 'Playfair Display', serif;
            color: white;
            font-size: 28px;
            letter-spacing: 0.5px;
        }

        /* --- Body Section --- */
        .card-body {
            padding: 32px;
            text-align: center;
        }

        .subtitle {
            font-size: 18px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 10px;
            line-height: 1.4;
        }

        .highlight-text {
            color: #1e3a8a; /* Blue highlight */
        }

        .description {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        /* --- Buttons --- */
        .btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 14px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.2s ease;
            cursor: pointer;
            gap: 8px; /* Space between text and icon */
        }

        /* Primary Button (Gold) */
        .btn-primary {
            background-color: #f59e0b;
            color: #0f172a;
            border: none;
            box-shadow: 0 4px 6px -1px rgba(245, 158, 11, 0.3);
            margin-bottom: 15px;
        }

        .btn-primary:hover {
            background-color: #fbbf24;
            transform: translateY(-1px);
        }

        /* Secondary Button (Outline) */
        .btn-secondary {
            background-color: transparent;
            color: #1e3a8a;
            border: 2px solid #1e3a8a;
        }

        .btn-secondary:hover {
            background-color: #eff6ff;
        }

        /* Add margin to subsequent secondary buttons */
        .btn-secondary + .btn-secondary {
            margin-top: 10px;
        }

        /* Divider text */
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
            background-color: #e5e7eb;
            flex-grow: 1;
        }

        /* --- Footer / Credits --- */
        .card-footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #f3f4f6;
        }

        .footer-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #9ca3af;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .credits-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 8px;
        }

        .credit-pill {
            background-color: #f3f4f6;
            color: #4b5563;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
        }
    </style>
</head>
<body>

    <div class="marketplace-card">
        
        <!-- Header -->
        <div class="card-header">
            <div class="header-content">
                <i class="fa-solid fa-anchor icon-anchor"></i>
                <h1>Midshipman Marketplace</h1>
            </div>
        </div>

        <!-- Content -->
        <div class="card-body">
            
            <h2 class="subtitle">
                Think Facebook Marketplace,<br> 
                <span class="highlight-text">but for the Brigade.</span>
            </h2>
            
            <p class="description">
                Buy gear, sell books, and trade items exclusively with other Midshipmen in a trusted environment.
            </p>

            <!-- Buttons -->
            <a href="CreateAccount.php" class="btn btn-primary">
                <span>Create Account</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>

            <div class="divider">or</div>

            <?php if (isset($_SESSION['user_email'])): ?>
                
                <a href="BuyPage.php" class="btn btn-secondary">Buy Items</a>
                <a href="SellPage.php" class="btn btn-secondary">Sell Items</a>
                <a href="Logout.php" class="btn btn-secondary">Log Out</a>

            <?php else: ?>

                <a href="Login.php" class="btn btn-secondary">Log In</a>

            <?php endif; ?>

            <!-- Footer -->
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