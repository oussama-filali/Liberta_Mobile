<?php
// Include CORS middleware
require_once 'middleware/cors.php';

// Return a simple JSON response
echo json_encode([
    "status" => "success",
    "message" => "CORS test successful",
    "timestamp" => date("Y-m-d H:i:s")
]);