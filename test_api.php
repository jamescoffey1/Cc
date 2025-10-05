<?php
include "config.php";

echo "Bot Token: " . (BOT_TOKEN ? "SET" : "NOT SET") . "\n";
echo "Testing Telegram API...\n";

$test_response = bot('getMe', []);
echo "Response: ";
var_dump($test_response);

echo "\nTesting sendMessage...\n";
$msg_response = bot('sendMessage', [
    'chat_id' => 999999,
    'text' => 'Test message'
]);
echo "Message Response: ";
var_dump($msg_response);
