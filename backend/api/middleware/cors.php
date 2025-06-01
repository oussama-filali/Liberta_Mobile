<?php
/**
 * CORS Middleware
 * This file handles Cross-Origin Resource Sharing (CORS) headers
 * Include this file at the top of any API endpoint that needs CORS support
 */

// Ensure no output before headers
if (ob_get_level() === 0) ob_start();

// Set CORS headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Set content type for OPTIONS response
    header("Content-Type: text/plain; charset=UTF-8");
    http_response_code(200);
    exit();
}

// For all other requests, set JSON content type
if ($_SERVER['REQUEST_METHOD'] !== 'OPTIONS') {
    header("Content-Type: application/json; charset=UTF-8");
}