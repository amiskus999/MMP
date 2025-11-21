<?php
// Set header to return JSON
header('Content-Type: application/json');

// Get search keyword
$keyword = '';
if(isset($_GET['keyword'])){
	$keyword = trim($_GET['keyword']);	// trim the keyword
}

$listingsToReturn = [];
$listings = [];

// If no keyword provided by user
if (empty($keyword)) {
	echo json_encode($listingsToReturn);	// returns an empty json array
	exit;									// exit program
}

$db_file = 'data/listings.json';

if (file_exists($db_file)) {
	$jsonString = file_get_contents($db_file);	// Get contents from listings.json
	$listings = json_decode($jsonString, true);	// Decode the json into an array
}
else{
	echo json_encode(['error' => 'Database not found.']);
	exit;
}


?>
