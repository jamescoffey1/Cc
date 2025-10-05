<?php
if (!defined("BOT_TOKEN")) {
    // Try to get token from environment first
    $token = getenv("BOT_TOKEN") ?: ($_ENV["BOT_TOKEN"] ?? ($_SERVER["BOT_TOKEN"] ?? ""));
    
    // If not in environment (web context), read from file
    if (empty($token) && file_exists(".bot_token")) {
        $token = trim(file_get_contents(".bot_token"));
    }
    
    // Fallback to placeholder
    if (empty($token)) {
        $token = "YOUR_BOT_TOKEN_HERE";
    }
    
    define("BOT_TOKEN", $token);
}

if (!function_exists('bot')) {
    function bot($method, $datas = []) {
        $url = "https://api.telegram.org/bot" . BOT_TOKEN . "/" . $method;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
        $res = curl_exec($ch);
        curl_close($ch);
        return json_decode($res, true);
    }
}
?>
