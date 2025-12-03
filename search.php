<?php
include_once("utilsFunctions.php");

$keyword = $_GET['keyword'] ?? '';
$jsonFilePath = 'data/listings.json';

if (!file_exists($jsonFilePath)) {
    echo "<p>Error: Listings data not found.</p>";
    exit();
}

$jsonData = file_get_contents($jsonFilePath);
$data = json_decode($jsonData, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo "<p>Error: Could not parse listings data.</p>";
    exit();
}

$found = false;
foreach ($data as $key => $value) {
    // Case-insensitive search in title and description
    if (stripos(strtolower($value['title']), strtolower($keyword)) || stripos(strtolower($value['description']), strtolower($keyword))) {
        renderItem($value);
        $found = true;
    }
}

if (!$found) {
    echo "<p>No items found matching your search.</p>";
}