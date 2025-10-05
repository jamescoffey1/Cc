<?php

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestUri === '/api' || strpos($requestUri, '/api.php') !== false) {
    include 'api.php';
} elseif ($requestUri === '/webhook' || $requestUri === '/' || strpos($requestUri, '/bot.php') !== false) {
    include 'bot.php';
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Endpoint not found']);
}
