<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Midshipman Marketplace (Pure CSS)</title>
    <style>
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

        /* Main Container */
        .marketplace-container {
            width: 100%;
            max-width: 1200px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            padding: 32px;
        }

        /* 1. Header (Flexbox) */
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

        /* Sell/Buy Tabs */
        .tabs {
            display: flex;
            background-color: #e5e7eb;
            border-radius: 9999px;
            /* Pill shape */
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
            /* Blue 600 */
            color: #ffffff;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        }

        .tab-button:not(.active) {
            background-color: transparent;
            color: #4b5563;
        }

        .tab-button:not(.active):hover {
            background-color: #d1d5db;
            /* Gray 200 */
        }

        /* Account Icons */
        .account-icon {
            width: 40px;
            height: 40px;
            background-color: #e5e7eb;
            border-radius: 50%;
            border: 2px solid #9ca3af;
            cursor: pointer;
            transition: background-color 5s;
        }

        .account-icon:hover {
            background-color: #d1d5db;
        }

        /* 2. Action Area (Flexbox) */
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
            /* Blue 700 */
        }

        /* Plus Icon inside button */
        .plus-icon {
            width: 20px;
            height: 20px;
            fill: currentColor;
        }

        /* 3. Product Grid (CSS Grid) */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            /* Default 4 columns */
            gap: 24px;
        }

        /* Product Card */
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

        .image-placeholder {
            height: 160px;
            background-color: #d1d5db;
            /* Gray 300 */
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

        .search-input {
            width: 320px;
            padding: 10px 16px;
            font-size: 0.95rem;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            /* Gray 300 – matches your components */
            background-color: #f0f4f8;
            /* Same as page background */
            color: #1f2937;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background-color 0.2s;
        }

        .search-input::placeholder {
            color: #9ca3af;
            /* Gray 400 placeholder */
        }

        .search-input:focus {
            border-color: #2563eb;
            /* Blue 600 — same as active tab */
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
            /* Subtle focus ring */
        }
    </style>
</head>

<body class="min-h-screen">

    <!-- Main Marketplace Container -->
    <div class="marketplace-container">

        <!-- 1. Top Header & Navigation -->
        <header class="header">
            <h1>Midshipman Marketplace</h1>

            <div class="nav-controls">
                <!-- Sell/Buy Tabs -->
                <div class="tabs">
                    <a href="SellPage.php"><button class="tab-button">Sell</button></a>
                    <a href="#"> <button class="tab-button active">Buy</button></a>
                </div>

                <!-- Chat/Account Icons (Placeholder Circles) -->
                <!-- TODO: Add small images here and links to those pages -->
                <div class="account-icon" aria-label="Messages"></div>
                <div class="account-icon" aria-label="User Profile"></div>
            </div>
        </header>

        <!-- 2. Action Area -->
        <div class="action-area">
            <!-- Search bar -->

            <input type="text" id="site-search" name="keyword" class="search-input" placeholder="Search items...">

            <script>
                document.getElementById("site-search").addEventListener("keyup", performSearch);


                function performSearch(e) {
                    const keyword = e.target.value;
                    const url = `search.php?keyword=${encodeURIComponent(keyword)}`;
                    const xhr = new XMLHttpRequest();

                    // 1. Set up the request method and URL
                    xhr.open('GET', url, true); // true = asynchronous

                    // 2. Define the callback function for state changes
                    xhr.onreadystatechange = function () {
                        // readyState 4 means the request is finished
                        if (xhr.readyState === 4) {

                            // status 200 means success
                            if (xhr.status === 200) {
                                try {
                                    // Parse the JSON string response
                                    const data = JSON.parse(xhr.responseText);
                                    renderResults(data);
                                } catch (e) {
                                    console.error("Error parsing JSON response:", e);
                                    //renderError();
                                }
                            } else {
                                console.error("Server responded with status:", xhr.status);
                                //renderError();
                            }
                        }
                    };

                    // 3. Define error handling for network issues
                    xhr.onerror = function () {
                        console.error("Network request failed.");
                        renderError();
                    };

                    // 4. Send the request
                    xhr.send();
                }

                function renderResults(data) {
                    resultsList.innerHTML = '';
                    resultsContainer.classList.remove('hidden');

                    if (!Array.isArray(data) || data.length === 0) {
                        noResults.classList.remove('hidden');
                        return;
                    }

                    noResults.classList.add('hidden');

                    data.forEach((item, index) => {
                        const li = document.createElement('li');
                        li.className = 'result-item hover:bg-blue-50 cursor-pointer transition-colors duration-150 p-4';
                        li.style.animationDelay = `${index * 0.03}s`;

                        li.innerHTML = `
                    <a href="#" class="block">
                        <h3 class="text-sm font-semibold text-gray-900">${escapeHtml(item.title)}</h3>
                        <p class="text-xs text-gray-500 mt-1 line-clamp-1">${escapeHtml(item.description)}</p>
                    </a>
                `;
                        li.addEventListener('click', () => {
                            searchInput.value = item.title;
                            hideResults();
                        });
                        resultsList.appendChild(li);
                    });
                }
            </script>

        </div>

        <!-- 3. Product Grid (4x2 layout, responsive) -->
        <main class="product-grid">

            <!-- Read in the listings.json file -->
            <?php
            $jsonFilePath = 'data/listings.json'; // Path to all selling items
            
            if (file_exists($jsonFilePath)) {
                $jsonData = file_get_contents($jsonFilePath);
                $data = json_decode($jsonData, true); // Decode as associative array
            
                foreach ($data as $key => $value) {

                    // Print each product card
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