<?php
if (!defined("BOT_TOKEN")) {
    define("BOT_TOKEN", getenv("BOT_TOKEN") ?: "YOUR_BOT_TOKEN_HERE");
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
        $result = json_decode($res, true);
        if (isset($result['ok']) && !$result['ok']) {
            file_put_contents("debug.log", date("Y-m-d H:i:s") . " - API Error: " . json_encode($result) . "\n", FILE_APPEND);
        }
        return $result;
    }
}
?>
