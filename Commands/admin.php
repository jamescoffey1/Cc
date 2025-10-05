<?php

/*
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
★ ADMIN.PHP ──── [ ⚙️ ADMIN CONTROL PANEL | SUPERUSER ACCESS ] ──── ★
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

👑 AUTHOR        : @Darkboy22

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
*/

function is_admin($user_id) {
    $admin_id = getenv("ADMIN_ID") ?: "8052469770"; // Set ADMIN_ID in Replit Secrets or replace here
    return $user_id == $admin_id;
}

//SEND BROADCAST 
//@Darkboy22
function admin_broadcast($chat_id, $text) {
    $msg = substr($text, 7);
    $users = json_decode(file_get_contents("Data/Users.json"), true);
    foreach ($users as $uid => $u) {
        bot('sendMessage', ['chat_id' => $uid, 'text' => "📢 Broadcast:\n\n" . $msg]);
    }
    bot('sendMessage', ['chat_id' => $chat_id, 'text' => "✅ Broadcast sent to all users."]);
}

//CHECK USER STATUS 
//@Darkboy22
function admin_stats($chat_id) {
    $users = json_decode(file_get_contents("Data/Users.json"), true);
    $sold = count(file("Cards/Sold.txt", FILE_IGNORE_NEW_LINES));
    $refund = count(file("Cards/Refund.txt", FILE_IGNORE_NEW_LINES));
    $available = count(file("Cards/cc.txt", FILE_IGNORE_NEW_LINES));
    $text = "✦━━━━━[ 📊 ʙᴏᴛ ꜱᴛᴀᴛꜱ ]━━━━━✦

👥 Total Users: " . count($users) . "
💳 Sold CCs  : $sold
♻ Refunded   : $refund
🟢 Available : $available

✦━━━━━━━━━━━━━━━━━━━━━✦";
    bot('sendMessage', ['chat_id' => $chat_id, 'text' => $text]);
}

//GENERATE KEY FOR BALANCE 
//@Darkboy22
function admin_generate_key($chat_id, $text) {
    preg_match('/^\/key (\d+)$/', $text, $m);
    $amount = $m[1];
    $key = strtoupper(bin2hex(random_bytes(8))); // 16-char
    $keys = json_decode(file_get_contents("Data/Keys.json"), true);
    $keys[$key] = ['amount' => $amount, 'used' => false];
    file_put_contents("Data/Keys.json", json_encode($keys, JSON_PRETTY_PRINT));
    bot('sendMessage', [
        'chat_id' => $chat_id,
        'text' => "🧾 Key Generated:\n\n🔑 `$key`\n💰 Amount: \$$amount",
        'parse_mode' => 'Markdown'
    ]);
}

function admin_add_cc($chat_id, $text) {
    $cc = trim(substr($text, 7));
    $parts = explode("|", $cc);
    if (count($parts) == 13) {
        file_put_contents("Cards/cc.txt", $cc . "\n", FILE_APPEND);
        bot('sendMessage', ['chat_id' => $chat_id, 'text' => "✅ Card added for sale."]);
    } else {
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'text' => "❌ Invalid format. Use:\n`cc|mm|yy|cvv|name|address|state|city|zip|country|refundable|price`",
            'parse_mode' => 'Markdown'
        ]);
    }
}
