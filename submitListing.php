<?php
/** 
 *  File: submitListing.php
 *  Description: This script handles the creation of a new marketplace listing. 
 *  It receives form data + image uploads from ListNewItem.html, validates everything,
 *  saves images to /uploads/, and appends the new listing to data/listings.json.
 *  Returns JSON success/error messages.
 */

// --- Step 1: Session & Security ---
session_start(); 

// FOR TESTING: fake login information
$_SESSION['user_id'] = 123;
$_SESSION['user_email'] = "m299999@usna.edu";

// Check user logged in.
if (!isset($_SESSION['user_id'])) {
    // User is not logged in - return JSON error
    echo json_encode(['success' => false, 'message' => 'You are not logged in.']);
    exit;
}

// Tell browser we are returning JSON
header('Content-Type: application/json');

// Only accept POST requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Make sure images were actually uploaded
    if (!isset($_FILES['images']) || empty($_FILES['images']['name'][0])) {
        echo json_encode(['success' => false, 'message' => 'No images were uploaded.']);
        exit;
    }

    $target_dir = "uploads/"; 
    $uploaded_image_paths = []; // Will hold final paths of all saved images
    $file_count = count($_FILES['images']['name']); // Number of files sent

    // Process each uploaded image one by one
    for ($i = 0; $i < $file_count; $i++) {
        
        // Grab info for this specific file
        $file_tmp_name = $_FILES['images']['tmp_name'][$i];
        $file_name = $_FILES['images']['name'][$i];
        $file_size = $_FILES['images']['size'][$i];
        $file_error = $_FILES['images']['error'][$i];

        // Check for upload errors
        if ($file_error !== UPLOAD_ERR_OK) {
             echo json_encode(['success' => false, 'message' => 'Error uploading file: ' . $file_name]);
             exit;
        }

        // Generate a unique filename to prevent conflicts
        $unique_filename = uniqid() . '_' . basename($file_name);
        $target_file = $target_dir . $unique_filename;
        
        // Get file extension (lowercase)
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Verify the file is actually an image
        $check = getimagesize($file_tmp_name);
        if ($check === false) {
            echo json_encode(['success' => false, 'message' => 'File is not an image: ' . $file_name]);
            exit;
        }

        // Enforce 5MB size limit per image
        if ($file_size > 5000000) { 
            echo json_encode(['success' => false, 'message' => 'File is too large: ' . $file_name]);
            exit;
        }

        // Only allow common image types
        if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid file type: ' . $file_name]);
            exit;
        }
        
        // Move the uploaded file to the permanent uploads folder
        if (move_uploaded_file($file_tmp_name, $target_file)) {
            $uploaded_image_paths[] = $target_file; // Save path for later
        } else {
            echo json_encode(['success' => false, 'message' => 'Server error while moving file.']);
            exit;
        }
    }
    
    // Collect text fields from the form
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = (float)$_POST['price'];
    $condition = $_POST['condition'];
    $user_id = $_SESSION['user_id'];

    // Build the new listing array
    $newListing = [
        'id' => uniqid('item_'),           // Unique ID for this item
        'user_id' => $user_id,             // Who posted it
        'title' => $title,
        'description' => $description,
        'price' => $price,
        'condition' => $condition,
        'image_paths' => $uploaded_image_paths, 
        'posted_at' => date('Y-m-d H:i:s'), // Timestamp
        'is_active' => true                // Visible on marketplace
    ];

    // Load existing listings (or start fresh if file doesn't exist)
    $db_file = 'data/listings.json';
    $listings = [];
    if (file_exists($db_file)) {
        $json_data = file_get_contents($db_file);
        $listings = json_decode($json_data, true);
    }

    // Add the new listing to the array
    $listings[] = $newListing;

    // Save everything back to listings.json (pretty printed for readability)
    file_put_contents($db_file, json_encode($listings, JSON_PRETTY_PRINT));

    // Success - let the frontend know everything worked
    echo json_encode(['success' => true, 'message' => 'Listing created successfully.']);
    exit;

} else {
    // Wrong request method (not POST)
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}
?>