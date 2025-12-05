<?php
session_start();

/** 
 * File: SellPage.php
 * Description: This is the Sell page of the Midshipman Marketplace. 
 * It displays all current listings from listings.json in a clean, responsive
 * grid. Users must be logged in to view this page.
 */
if (!isset($_SESSION['user_email'])) {
    header('Location: Login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Midshipman Marketplace (Pure CSS)</title>
    <style>
        /* Reset and basic layout */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f4f8;
            display: flex;
            justify-content: center;
            padding: 32px 16px;
            min-height: 100vh;
        }

        /* Main white card container */
        .marketplace-container {
            width: 100%;
            max-width: 1200px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            padding: 32px;
        }

        /* Header with title and navigation */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 16px;
            margin-bottom: 24px;
            border-bottom: 1px solid #e5e7eb;
        }

        .header h1 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1f2937;
        }

        .nav-controls {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        /* Sell/Buy tab buttons */
        .tabs {
            display: flex;
            background-color: #e5e7eb;
            border-radius: 9999px;
            padding: 4px;
        }

        .tab-button {
            padding: 8px 16px;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 9999px;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
        }

        .tab-button.active {
            background-color: #2563eb;
            color: #ffffff;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        }

        .tab-button:not(.active) {
            background-color: transparent;
            color: #4b5563;
        }

        .tab-button:not(.active):hover {
            background-color: #d1d5db;
        }

        /* Circular icons (home, profile, etc.) */
        .circle-icon {
            width: 40px;
            height: 40px;
            background-color: #e5e7eb;
            border-radius: 50%;
            border: 2px solid #9ca3af;
            cursor: pointer;
            transition: background-color 5s;
        }

        .home-icon {
            background-image: url('house_icon.jpg'); 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .circle-icon:hover {
            background-color: #d1d5db;
        }

        /* Create listing button area */
        .action-area {
            margin-bottom: 24px;
        }

        .create-button {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background-color: #2563eb;
            color: #ffffff;
            font-weight: 500;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
            transition: background-color 0.3s;
        }

        .create-button:hover {
            background-color: #1d4ed8;
        }

        .plus-icon {
            width: 20px;
            height: 20px;
            fill: currentColor;
        }

        /* Product grid layout */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }

        /* Individual product card */
        .product-card {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s, transform 0.3s;
            cursor: pointer;
        }

        .product-card:hover {
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        /* Image placeholder (will show real image from JSON) */
        .image-placeholder {
            height: 160px;
            background-color: #d1d5db;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 16px;
        }

        .image-placeholder span {
            font-size: 0.875rem;
            color: #4b5563;
            font-weight: 500;
        }

        .product-details {
            padding: 12px;
        }

        .product-details .price {
            font-size: 1.125rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 2px;
        }

        .product-details .name {
            font-size: 0.875rem;
            color: #6b7280;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>

<body class="min-h-screen">

    <!-- Main container -->
    <div class="marketplace-container">

        <!-- Header with title, tabs, and icons -->
        <header class="header">
            <h1>Midshipman Marketplace</h1>

            <div class="nav-controls">
                <!-- Sell/Buy tabs -->
                <div class="tabs">
                    <a href="#"><button class="tab-button active">Sell</button></a>
                    <a href="BuyPage.php"> <button class="tab-button">Buy</button></a>
                </div>

                <!-- Home and profile icons -->
                <a href="index.php"> <div class="circle-icon home-icon" aria-label="Home"></div> </a>
                <div class="circle-icon" aria-label="User Profile"></div>
            </div>
        </header>

        <!-- Create listing button -->
        <div class="action-area">
            <a href="ListNewItem.html" style="text-decoration:none"> <button class="create-button">
                    <!-- Plus icon SVG -->
                    <svg class="plus-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>Create Listing</span>
                </button> </a>
        </div>

        <!-- Product grid -->
        <main class="product-grid">

            <?php
            // Load listings from JSON file
            $jsonFilePath = 'data/listings.json';
            
            if (file_exists($jsonFilePath)) {
                $jsonData = file_get_contents($jsonFilePath);
                $data = json_decode($jsonData, true);

                // Loop through each listing and output a card
                foreach ($data as $key => $value) {
                    echo '<div class="product-card">';
                    echo '<div class="image-placeholder">';
                    $imagePath = $value['image_paths'][0];
                    echo '<span>';
                    echo '<img src="' . $imagePath . '" alt="Img unavailable" height="160"';
                    echo '</span>';
                    echo '</div> <div class="product-details">';
                    echo '<p class="price">$' . $value['price'] . '</p>';
                    echo '<p class="name">' . $value['title'] . '</p>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "JSON file not found.";
            }
            ?>
        </main>
    </div>
</body>

</html>