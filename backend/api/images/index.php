<?php
// CORS Headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Get the image filename from the URL
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$filename = basename($uri);

// Define the images directory
$imagesDir = __DIR__ . '/uploads/';

// Check if the file exists
$filePath = $imagesDir . $filename;
if (file_exists($filePath)) {
    // Get the MIME type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $filePath);
    finfo_close($finfo);
    
    // Set the content type header
    header('Content-Type: ' . $mime);
    
    // Output the file
    readfile($filePath);
} else {
    // Return 404 if image not found
    http_response_code(404);
    echo json_encode(["message" => "Image not found"]);
}