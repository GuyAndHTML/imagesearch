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

    // Loop through the files and check for matches
    foreach ($files as $file) {
        // If the file is an image and contains the search query (case-insensitive)
        if (stripos($file, $query) !== false && preg_match('/\.(jpg|jpeg|png|gif)$/i', $file)) {
            $matchingImages[] = $file;
        }
    }
}

// Return the matching images as a JSON response
header('Content-Type: application/json');
echo json_encode(['images' => $matchingImages]);
?>
