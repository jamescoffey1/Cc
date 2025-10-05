<?php

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestMethod = $_SERVER['REQUEST_METHOD'];

if (strpos($requestUri, '/api') !== false) {
    header('Content-Type: application/json');
    include 'api.php';
} elseif (strpos($requestUri, '/webhook') !== false || strpos($requestUri, '/bot') !== false) {
    header('Content-Type: application/json');
    include 'bot.php';
} elseif ($requestUri === '/') {
    http_response_code(200);
    header('Content-Type: text/html');
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Telegram Bot Server</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
            }
            .container {
                text-align: center;
                padding: 40px;
                background: rgba(255, 255, 255, 0.1);
                border-radius: 10px;
                backdrop-filter: blur(10px);
            }
            h1 { margin-bottom: 20px; }
            .status { color: #4ade80; }
            .endpoints {
                margin-top: 30px;
                text-align: left;
                background: rgba(0, 0, 0, 0.2);
                padding: 20px;
                border-radius: 5px;
            }
            code {
                background: rgba(255, 255, 255, 0.1);
                padding: 2px 8px;
                border-radius: 3px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>🤖 Telegram Bot Server</h1>
            <p class="status">✅ Server is running</p>
            <div class="endpoints">
                <h3>Available Endpoints:</h3>
                <p>📍 <code>/webhook</code> - Telegram Bot Webhook</p>
                <p>📍 <code>/api</code> - Payment API</p>
            </div>
        </div>
    </body>
    </html>
    <?php
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Endpoint not found']);
}
