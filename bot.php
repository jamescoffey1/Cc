<?php
/*
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
⟡ ⟡   [🔥 BOT.PHP →  MAIN FILE 🔥]  ⟡ ⟡ 
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
🧠 PURPOSE     : MAIN WEBHOOK FILE
📦 HANDLES     : HANDLE COMMAND AND BUTTON 
🚨 WARNING     : DO NOT MODIFY UNLESS YOU KNOW WHAT YOU'RE DOING!
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

👑 AUTHOR        : @Darkboy22

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
*/
include "Config.php";
include "Commands/user.php";
include "Commands/admin.php";

$update = json_decode(file_get_contents("php://input"), true);
$chat_id = $update["message"]["chat"]["id"] ?? $update["callback_query"]["message"]["chat"]["id"];
$text = $update["message"]["text"] ?? $update["callback_query"]["data"];
$first_name = $update["message"]["chat"]["first_name"] ?? $update["callback_query"]["from"]["first_name"];
$user_id = $update["message"]["from"]["id"] ?? $update["callback_query"]["from"]["id"];

//COMMAND HANDLER
//@Darkboy22
if (strpos($text, "/start") === 0) start_command($chat_id, $first_name, $user_id);
elseif (strpos($text, "/register") === 0) show_terms($chat_id, $first_name, $user_id);
elseif (strpos($text, "/menu") === 0 || strpos($text, "/home") === 0) send_menu($chat_id, $first_name, $user_id);
elseif (strpos($text, "/info") === 0 || strpos($text, "/profile") === 0) send_profile($chat_id, $first_name, $user_id);
elseif (strpos($text, "/support") === 0 || strpos($text, "/help") === 0) send_support($chat_id);
elseif (strpos($text, "/acc") === 0 || strpos($text, "/buycc") === 0 || strpos($text, "/bcc") === 0 || strpos($text, "/cc") === 0) show_cards($chat_id, 0);
elseif (preg_match('/^\/buy (\d+)/', $text, $m)) process_buy($chat_id, $user_id, intval($m[1]) - 1);
elseif (in_array($text, ["/orders", "/order"])) show_orders($chat_id, $user_id);
elseif (in_array($text, ['/addfund', '/fund', '/deposit', '/dep'])) {
    start_deposit($chat_id, $user_id);
}
elseif (is_numeric($text) && file_exists("Data/deposit_temp_{$user_id}.lock")) {
    process_amount($chat_id, $user_id, $text);
}
elseif (preg_match('/^[a-zA-Z0-9\-_]{5,}$/', $text) && file_exists("Data/check_temp_{$user_id}.lock")) {
    $order_id = trim($text);
    $txn_id = file_get_contents("Data/check_temp_{$user_id}.lock");
    unlink("Data/check_temp_{$user_id}.lock");
    check_payment($chat_id, $user_id, $order_id, $txn_id);
}
if (is_admin($user_id)) {
    if (strpos($text, "/broad ") === 0) admin_broadcast($chat_id, $text);
    elseif ($text == "/stat") admin_stats($chat_id);
    elseif (preg_match('/^\/key (\d+)$/', $text)) admin_generate_key($chat_id, $text);
    elseif (strpos($text, "/addcc ") === 0) admin_add_cc($chat_id, $text);
}

if (preg_match('/^\/redeem (\w{16})$/', $text)) user_redeem_key($chat_id, $user_id, $text);



//BUTTON HANDLER
//@Darkboy22
if (isset($update["callback_query"])) {
    $data = $update["callback_query"]["data"];
    if ($data == "register") show_terms($chat_id, $first_name, $user_id);
    elseif ($data == "accept_terms") register_user($chat_id, $first_name, $user_id);
    elseif ($data == "menu") send_menu($chat_id, $first_name, $user_id);
    elseif ($data == "profile") send_profile($chat_id, $first_name, $user_id);
    elseif ($data == "support") send_support($chat_id);
    elseif ($data == "buycc") show_cards($chat_id, 0);
    elseif ($data == "addfund") start_deposit($chat_id, $user_id);
    if (strpos($data, "page_") === 0) {
        $page = intval(str_replace("page_", "", $data));
        show_cards($chat_id, $page, true, $update["callback_query"]["message"]["message_id"]);
    }
    elseif (strpos($data, "refund_") === 0) {
    $cc_number = str_replace("refund_", "", $data);
    $msg_id = $update["callback_query"]["message"]["message_id"];
    bot('deleteMessage', ['chat_id' => $chat_id, 'message_id' => $msg_id]);
    handle_refund($chat_id, $user_id, $cc_number);
}
    if ($data == "orders") show_orders($chat_id, $user_id);
    if (in_array($data, ['btc', 'usdt', 'ltc'])) {
        $msg_id = $update["callback_query"]["message"]["message_id"];
        bot('deleteMessage', ['chat_id' => $chat_id, 'message_id' => $msg_id]);
        confirm_currency($chat_id, $user_id, $data);
    } elseif (strpos($data, "cancel_") === 0) {
        list(, $txn_id) = explode("_", $data);
        $msg_id = $update["callback_query"]["message"]["message_id"];
        cancel_deposit($chat_id, $user_id, $txn_id, $msg_id);
    }
    elseif (strpos($data, "check_") === 0) {
    $txn_id = str_replace("check_", "", $data);
    file_put_contents("Data/check_temp_{$user_id}.lock", $txn_id);
    bot('sendMessage', [
        'chat_id' => $chat_id,
        'text' => "📨 Please send your *Order ID* to verify payment:",
        'parse_mode' => 'Markdown'
    ]);
}
    elseif (file_exists("Data/check_temp_{$user_id}.lock")) {
    $order_id = trim($text);
    if (preg_match('/^[a-zA-Z0-9\-_]{5,}$/', $order_id)) {
        $txn_id = file_get_contents("Data/check_temp_{$user_id}.lock");
        unlink("Data/check_temp_{$user_id}.lock");
        check_payment($chat_id, $user_id, $order_id, $txn_id);
    } else {
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'text' => "⚠ Invalid Order ID format. Please enter a valid one (e.g. `TXN123456`)",
            'parse_mode' => 'Markdown'
        ]);
    }
}
}
?>
