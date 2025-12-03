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
    elseif ($keyword === '') {
        renderItem($value);
        $found = true;
    }
}

if (!$found) {
    $safe_keyword = htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8');
    echo <<<HTML
    <head>
    <!-- ... other head elements like meta, title ... -->

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Your Custom CSS (must be after Bootstrap) -->
    <!-- <link rel="stylesheet" href="path/to/your/style.css"> -->
</head>
<div class="alert alert-warning text-center" role="alert">
  <h4 class="alert-heading">No Results Found</h4>
  <p>Sorry, we couldn't find any items matching your search for "<strong>{$safe_keyword}</strong>".</p>
  <p class="mb-0">Please try a different search term or browse all items.</p>
</div>
HTML;
}