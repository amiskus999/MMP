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

// Loop through the listings[] and find matching items
foreach($listings as $item){

	// Only check active listings
	if(isset($item['active']) && $item['active']){

		// Check if the keyword is contained within the title or description of the item
		if(str_contains(strtolower($item['title']), strtolower($keyword)) || 
		   str_contains(strtolower($item['description']), strtolower($keyword))){
			$listingsToReturn[] = $item;		// If it is: add the item to the return array
		}
	}
}

// Return the json
echo json_encode($listingsToReturn);
exit;

?>
