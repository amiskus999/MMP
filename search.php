<?php
/**
 * File: search.php
 * Description: Uses a search keyword to find a listing in listings.json and uses the utilFunction
 * renderitem() to display all of the matching listings.
 */

include_once("utilsFunctions.php");

// Get the search keyword (empty if not provided)
$keyword = $_GET['keyword'] ?? '';

// Path to the JSON listings file
$jsonFilePath = 'data/listings.json';

// Verify the JSON file exists
if (!file_exists($jsonFilePath)) {
    echo "<p>Error: Listings data not found.</p>";
    exit();
}

// Load the JSON file
$jsonData = file_get_contents($jsonFilePath);

// Decode JSON into associative array
$data = json_decode($jsonData, true);

// Check for JSON parsing errors
if (json_last_error() !== JSON_ERROR_NONE) {
    echo "<p>Error: Could not parse listings data.</p>";
    exit();
}

$found = false;

// Loop through each listing
foreach ($data as $key => $value) {

    // Check if keyword matches title or description (case-insensitive)
    if (
        stripos(strtolower($value['title']), strtolower($keyword)) ||
        stripos(strtolower($value['description']), strtolower($keyword))
    ) {
        renderItem($value);    // Display item
        $found = true;
    }
    // If no keyword, show all listings
    elseif ($keyword === '') {
        renderItem($value);    // Display item
        $found = true;
    }
}

// If nothing matched, show the Bootstrap "No Results" alert
if (!$found) {
    $safe_keyword = htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8');

    echo <<<HTML
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<div class="alert alert-warning text-center" role="alert">
  <h4 class="alert-heading">No Results Found</h4>
  <p>Sorry, we couldn't find any items matching your search for "<strong>{$safe_keyword}</strong>".</p>
  <p class="mb-0">Please try a different search term or browse all items.</p>
</div>
HTML;
}
?>
