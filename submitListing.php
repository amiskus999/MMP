<?php
// --- Step 1: Session & Security ---
session_start(); 

// FOR TESTING: fake login information
$_SESSION['user_id'] = 123;
$_SESSION['user_email'] = "m299999@usna.edu";

// Check user logged in.
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'You are not logged in.']);
    exit;
}

// Set header to return JSON
header('Content-Type: application/json');

// Check submission of form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Check if any files were sent
    if (!isset($_FILES['images']) || empty($_FILES['images']['name'][0])) {
        echo json_encode(['success' => false, 'message' => 'No images were uploaded.']);
        exit;
    }

    $target_dir = "uploads/"; 
    $uploaded_image_paths = []; // Array to store paths of all uploaded images
    $file_count = count($_FILES['images']['name']); // How many files were sent

    // Loop through each uploaded file
    for ($i = 0; $i < $file_count; $i++) {
        
        // Get this file's data
        $file_tmp_name = $_FILES['images']['tmp_name'][$i];
        $file_name = $_FILES['images']['name'][$i];
        $file_size = $_FILES['images']['size'][$i];
        $file_error = $_FILES['images']['error'][$i];

		// Check if there is an error within file
        if ($file_error !== UPLOAD_ERR_OK) {
             echo json_encode(['success' => false, 'message' => 'Error uploading file: ' . $file_name]);
             exit;
        }

        // Create a unique filename
        $unique_filename = uniqid() . '_' . basename($file_name); // basename gets rid of the file path, uniqid creates id based on system time
        $target_file = $target_dir . $unique_filename;
        
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate file: make sure it is an image
        $check = getimagesize($file_tmp_name);
        if ($check === false) {
            echo json_encode(['success' => false, 'message' => 'File is not an image: ' . $file_name]);
            exit;
        }

		// Check file is within size limit (5MB)
        if ($file_size > 5000000) { 
            echo json_encode(['success' => false, 'message' => 'File is too large: ' . $file_name]);
            exit;
        }

		// Check file type is supported
        if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid file type: ' . $file_name]);
            exit;
        }
        
        // If validation passes, move the file to uploads file
        if (move_uploaded_file($file_tmp_name, $target_file)) {
            // Add the new path to our array
            $uploaded_image_paths[] = $target_file;
        } else {
            echo json_encode(['success' => false, 'message' => 'Server error while moving file.']);
            exit;
        }
    }
    
    // Get text data from $_POST (sent by FormData)
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = (float)$_POST['price'];
    $condition = $_POST['condition'];
    $user_id = $_SESSION['user_id'];

	// Create a new listing with all information needed
    $newListing = [
        'id' => uniqid('item_'),
        'user_id' => $user_id,
        'title' => $title,
        'description' => $description,
        'price' => $price,
        'condition' => $condition,
        'image_paths' => $uploaded_image_paths, 
        'posted_at' => date('Y-m-d H:i:s'),
        'is_active' => true
    ];

	// Upload data to listings.json
    $db_file = 'data/listings.json';
    $listings = [];
    if (file_exists($db_file)) {
        $json_data = file_get_contents($db_file);   // Get content from listings.json
        $listings = json_decode($json_data, true);  // Decode into an array
    }

    $listings[] = $newListing;

    file_put_contents($db_file, json_encode($listings, JSON_PRETTY_PRINT));

    
    // The JavaScript from ListNewItem.html will read this and perform the redirect.
    echo json_encode(['success' => true, 'message' => 'Listing created successfully.']);
    exit;

} else {
    // If not a POST request
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}
?>