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
        return json_decode($res, true);
    }
}
?>
