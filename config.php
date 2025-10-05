<?php
define("BOT_TOKEN", getenv("BOT_TOKEN") ?: "YOUR_BOT_TOKEN_HERE"); //REPLACE YOUR BOT TOKEN OR SET BOT_TOKEN IN REPLIT SECRETS


/*SEND/DELETE/EDIT MASSAGE FUNCTION 
🚨 WARNING     : DO NOT MODIFY THIS SEND/DELETE/EDIT  MASSAGE FUNCTION OTHERWISE YOUR FULL CODE WAS FUCKED
*/
//@Darkboy22
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
?>
