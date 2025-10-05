<?php

$host = '0.0.0.0';
$port = 5000;

echo "Starting Telegram Bot server on {$host}:{$port}\n";
echo "Bot webhook available at: http://{$host}:{$port}/webhook\n";
echo "API endpoint available at: http://{$host}:{$port}/api\n";

$router = function($uri) {
    if (strpos($uri, '/api') !== false) {
        return 'api.php';
    } elseif (strpos($uri, '/webhook') !== false || $uri === '/') {
        return 'bot.php';
    }
    return false;
};

$command = sprintf(
    'php -S %s:%d -t %s %s',
    $host,
    $port,
    __DIR__,
    __FILE__
);

if (php_sapi_name() === 'cli-server') {
    $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $file = $router($requestUri);
    
    if ($file && file_exists($file)) {
        include $file;
        return true;
    } elseif (file_exists(__DIR__ . $requestUri)) {
        return false;
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Not found']);
        return true;
    }
}

passthru($command);
