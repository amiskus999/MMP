<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Buy Item</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            margin: 0;
            padding: 40px;
        }

        .container {
            width: 600px;
            margin: auto;
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            margin: 0;
            font-size: 28px;
        }

        .divider {
            width: 70%;
            height: 2px;
            background: #333;
            margin: 20px auto 30px;
            border-radius: 2px;
        }

        /* Item Image */
        .item-image {
            width: 220px;
            height: 220px;
            background: #eee;
            border-radius: 25px;
            border: 2px solid #ccc;
            margin: auto;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #666;
            font-size: 18px;
            object-fit: cover;
            overflow: hidden;
        }

        .item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Text info section */
        .info-section {
            margin-top: 25px;
            text-align: center;
        }

        .item-title {
            font-size: 22px;
            margin-bottom: 8px;
        }

        .item-price {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 6px;
        }

        .item-condition {
            font-size: 16px;
            margin-bottom: 10px;
            color: #444;
        }

        .item-description {
            margin: 0 auto;
            margin-top: 10px;
            max-width: 450px;
            font-size: 15px;
            color: #444;
            line-height: 1.4;
        }

        /* Buy Button */
        .buy-button {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 30px;
            margin-top: 15px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }

        .buy-button:hover {
            background: #7fc4ff;
        }
    </style>
</head>

<body>
    <?php
    // 1. Get ID from URL
    if (!isset($_GET['id'])) {
        die("No item ID provided.");
    }

    $id = $_GET['id'];

    // 2. Read listings.json
    $jsonFilePath = "data/listings.json";

    if (!file_exists($jsonFilePath)) {
        die("Listings file missing.");
    }

    $data = json_decode(file_get_contents($jsonFilePath), true);

    // 3. Validate listing exists
    if (!isset($data[$id])) {
        die("Item not found.");
    }

    $item = $data[$id];
    ?>
    <div class="container">

        <h2>Buy Item</h2>

        <div class="divider"></div>

        <!-- Item Image -->
        <div class="item-image" id="itemImageBox">
            <img id="itemImage" src="<?php echo $item['image_paths'][0]; ?>" alt="Item Image">
        </div>

        <!-- Info Section -->
        <div class="info-section">
            <div class="item-title" id="itemTitle"><?php echo htmlspecialchars($item['title']); ?></div>
            <div class="item-price" id="itemPrice"><?php echo htmlspecialchars($item['price']); ?></div>
            <div class="item-condition" id="itemCondition"><?php echo htmlspecialchars($item['condition']); ?></div>
            <div class="item-description" id="itemDescription">
                <?php echo htmlspecialchars($item['description']); ?>
            </div>
        </div>

        <!-- Buy Button -->
        <button class="buy-button" onclick="buyItem()">Buy Item</button>

    </div>

    <script>
        // Example purchase function
        function buyItem() {
            alert("Purchase complete! (Demo)");
        }
    </script>

</body>

</html>