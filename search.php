<?php
// Folder where images are stored
$imageFolder = 'images';

// Get the search query from the URL
$query = isset($_GET['q']) ? $_GET['q'] : '';

// Initialize an array to hold the image filenames
$matchingImages = [];

// Check if the folder exists
if (is_dir($imageFolder)) {
    // Get all files in the folder
    $files = scandir($imageFolder);

    // First, try partial match
    foreach ($files as $file) {
        if (stripos($file, $query) !== false && preg_match('/\.(jpg|jpeg|png|gif)$/i', $file)) {
            $matchingImages[] = $file;
        }
    }

    // If no matches found, use fuzzy matching
    if (empty($matchingImages)) {
        foreach ($files as $file) {
            if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $file)) {
                $distance = levenshtein(strtolower($query), strtolower(pathinfo($file, PATHINFO_FILENAME)));
                if ($distance <= 3) {
                    $matchingImages[] = $file;
                }
            }
        }
    }
}

// Return the matching images as a JSON response
header('Content-Type: application/json');
echo json_encode(['images' => $matchingImages]);
?>
