<?php

/*
═══════════════════════════════
█▓▒░ USER.PHP → USER COMMANDS ░▒▓█
══════════════════════════════

👑 AUTHOR        : @Darkboy22

══════════════════════════════
💡 DEV TIP: Keep this file modular. Separate functions
     for each command make it easy to maintain and scale.
══════════════════════════════
*/


function is_registered($user_id) {
    $users = json_decode(file_get_contents("Data/Users.json"), true) ?? [];
    return isset($users[$user_id]);
}
//START COMMAND 
//@Darkboy22
function start_command($chat_id, $first_name, $user_id) {
    $text = "✦━━━━[ 𝐂𝐂 𝐒𝐇𝐎𝐏 𝐁𝐎𝐓 ]━━━━✦

⟡ ɴᴀᴍᴇ     : $first_name
⟡ ꜱᴛᴀᴛᴜꜱ   :  ɴᴇᴡ
⟡ ᴀᴄᴄᴇꜱꜱ   : ᴘʀᴇᴍɪᴜᴍ ᴄᴀʀᴅ ᴢᴏɴᴇ
⟡ ᴄᴏᴍᴍᴀɴᴅ : /register

✦━━━━━━━━━━━━━━━━━━━✦";

    $buttons = [
        [['text' => '✅ Register', 'callback_data' => 'register']],
        [['text' => '📋 Main Menu', 'callback_data' => 'menu']]
    ];
    bot('sendMessage', [
        'chat_id' => $chat_id,
        'text' => $text,
        'reply_markup' => json_encode(['inline_keyboard' => $buttons])
    ]);
}
//TERM AND CONDITIONS
//@Darkboy22
function show_terms($chat_id, $first_name, $user_id) {
    if (is_registered($user_id)) {
        $msg = "✦━━━━━[ ✘ ʀᴇɢɪꜱᴛʀᴀᴛɪᴏɴ ꜰᴀɪʟᴇᴅ ✘ ]━━━━━✦

⟡ ɴᴀᴍᴇ     : $first_name
⟡ ꜱᴛᴀᴛᴜꜱ   : ᴀʟʀᴇᴀᴅʏ ʀᴇɢɪꜱᴛᴇʀᴇᴅ
⟡ ᴀᴄᴄᴇꜱꜱ   : ᴀᴄᴛɪᴠᴇ ᴜꜱᴇʀ ✔

✦━━━━━━━━━━━━━━━━━━━━━━✦";
        bot('sendMessage', ['chat_id' => $chat_id, 'text' => $msg]);
        return;
    }

    $text = "📜 *Terms and Conditions*

By registering, you agree to all the terms of use, privacy and community guidelines. Make sure you're not violating any laws using this bot.

Click below to accept.";
    bot('sendMessage', [
        'chat_id' => $chat_id,
        'text' => $text,
        'parse_mode' => 'Markdown',
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => '✅ I Accept', 'callback_data' => 'accept_terms']]
            ]
        ])
    ]);
}
//REGISTER USER
//@Darkboy22
function register_user($chat_id, $first_name, $user_id) {
    $users = json_decode(file_get_contents("Data/Users.json"), true) ?? [];
    if (isset($users[$user_id])) {
        $msg = "✦━━━━━[ ✘ ʀᴇɢɪꜱᴛʀᴀᴛɪᴏɴ ꜰᴀɪʟᴇᴅ ✘ ]━━━━━✦

⟡ ɴᴀᴍᴇ     : $first_name
⟡ ꜱᴛᴀᴛᴜꜱ   : ᴀʟʀᴇᴀᴅʏ ʀᴇɢɪꜱᴛᴇʀᴇᴅ
⟡ ᴀᴄᴄᴇꜱꜱ   : ᴀᴄᴛɪᴠᴇ ᴜꜱᴇʀ ✔

✦━━━━━━━━━━━━━━━━━━━━━━✦";
    } else {
        $users[$user_id] = [
            "name" => $first_name,
            "balance" => 0,
            "buys" => 0,
            "refunds" => 0
        ];
        file_put_contents("Data/Users.json", json_encode($users, JSON_PRETTY_PRINT));
        $msg = "✦━━━━━[ ✔ ʀᴇɢɪꜱᴛʀᴀᴛɪᴏɴ ꜱᴜᴄᴄᴇꜱꜱ ✔ ]━━━━━✦

⟡ ɴᴀᴍᴇ     : $first_name
⟡ ꜱᴛᴀᴛᴜꜱ   : ᴀᴄᴛɪᴠᴇ ᴜꜱᴇʀ
⟡ ᴀᴄᴄᴇꜱꜱ   : ᴀᴄᴄᴇꜱꜱ ɢʀᴀɴᴛᴇᴅ ✔

✦━━━━━━━━━━━━━━━━━━━━━━━━✦";
    }
    bot('sendMessage', ['chat_id' => $chat_id, 'text' => $msg]);
}

//SEND MAIN MENU
//@Darkboy22
function send_menu($chat_id, $first_name, $user_id) {
    if (!is_registered($user_id)) {
        $msg = "✦━━━━━[ ✘ ʀᴇɢɪꜱᴛʀᴀᴛɪᴏɴ ꜰᴀɪʟᴇᴅ ✘ ]━━━━━✦

⟡ ɴᴀᴍᴇ     : $first_name
⟡ ꜱᴛᴀᴛᴜꜱ   : ᴜɴʀᴇɢɪꜱᴛᴇʀᴇᴅ
⟡ ᴀᴄᴄᴇꜱꜱ   : ᴅᴇɴɪᴇᴅ ✘

✦━━━━━━━━━━━━━━━━━━━━━━✦";
        bot('sendMessage', ['chat_id' => $chat_id, 'text' => $msg]);
        return;
    }

    $text = "✦━━━━━[ 𝐌𝐀𝐈𝐍 𝐌𝐄𝐍𝐔 ]━━━━━✦

⟡ ᴡᴇʟᴄᴏᴍᴇ, $first_name
⟡ ꜱᴛᴀᴛᴜꜱ   : ᴀᴄᴛɪᴠᴇ ᴜꜱᴇʀ
⟡ ᴀᴄᴄᴇꜱꜱ   : ᴘʀᴇᴍɪᴜᴍ ᴅᴀꜱʜʙᴏᴀʀᴅ
⟡ ᴍᴏᴅᴇ   : 𝙇𝙄𝙑𝙀 | 24/7

✧ ᴄʜᴏᴏꜱᴇ ᴀɴ ᴏᴘᴛɪᴏɴ ʙᴇʟᴏᴡ ⤵

✦━━━━━━━━━━━━━━━━━━━━━✦";

    $buttons = [
        [['text' => '👤 Profile', 'callback_data' => 'profile'], ['text' => '➕ Add Fund', 'callback_data' => 'addfund']],
        [['text' => '💳 Buy CC', 'callback_data' => 'buycc'], ['text' => '🔍 Search BIN', 'callback_data' => 'bin']],
        [['text' => '📦 Orders', 'callback_data' => 'orders'], ['text' => '📞 Support', 'callback_data' => 'support']],
    ];
    bot('sendMessage', [
        'chat_id' => $chat_id,
        'text' => $text,
        'reply_markup' => json_encode(['inline_keyboard' => $buttons])
    ]);
}

//CHECK PROFILE/USER INFO
//@Darkboy22
function send_profile($chat_id, $first_name, $user_id) {
    $users = json_decode(file_get_contents("Data/Users.json"), true);
    if (!isset($users[$user_id])) {
        $msg = "✦━━━━━[ ✘ ʀᴇɢɪꜱᴛʀᴀᴛɪᴏɴ ꜰᴀɪʟᴇᴅ ✘ ]━━━━━✦

⟡ ɴᴀᴍᴇ     : $first_name
⟡ ꜱᴛᴀᴛᴜꜱ   : ᴜɴʀᴇɢɪꜱᴛᴇʀᴇᴅ
⟡ ᴀᴄᴄᴇꜱꜱ   : ᴅᴇɴɪᴇᴅ ✘

✦━━━━━━━━━━━━━━━━━━━━━━✦";
    } else {
        $data = $users[$user_id];
        $msg = "✦━━━━━[ ᴘʀᴏꜰɪʟᴇ ᴅᴇᴛᴀɪʟꜱ ]━━━━━✦

⟡ ɴᴀᴍᴇ        : $first_name
⟡ ᴜꜱᴇʀ ɪᴅ     : $user_id
⟡ ʙᴀʟᴀɴᴄᴇ     : {$data['balance']}$
⟡ ʙᴜʏ ᴄᴀʀᴅꜱ   : {$data['buys']}
⟡ ʀᴇꜰᴜɴᴅꜱ     : {$data['refunds']}

✦━━━━━━━━━━━━━━━━━━━━━━━━✦";
    }
    bot('sendMessage', ['chat_id' => $chat_id, 'text' => $msg]);
}

//SEND SUPPORT 
//@Darkboy22
function send_support($chat_id) {
    $msg = "✦━━━━━[  ᴄᴜꜱᴛᴏᴍᴇʀ ꜱᴜᴘᴘᴏʀᴛ ]━━━━━✦

⟡ ᴀᴅᴍɪɴ : @Darkboy22 
⟡ ᴀᴠᴀɪʟᴀʙʟᴇ : 24/7 sᴜᴘᴘᴏʀᴛ
⟡ ɴᴏᴛᴇ : ᴄᴏɴᴛᴀᴄᴛ ᴏɴʟʏ ɪꜰ ɢᴇɴᴜɪɴᴇ

✧ ᴄʟɪᴄᴋ ᴏɴ ᴛʜᴇ ᴜꜱᴇʀɴᴀᴍᴇ ᴛᴏ ᴄʜᴀᴛ ᴅɪʀᴇᴄᴛʟʏ

✦━━━━━━━━━━━━━━━━━━━━━━━━✦";
    bot('sendMessage', ['chat_id' => $chat_id, 'text' => $msg]);
}

//PARSE CARDS DETAILS FROM CC.TXT
//@Darkboy22
function parse_cards() {
    $lines = file("Cards/cc.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $cards = [];
    foreach ($lines as $line) {
        list($cc, $mm, $yy, $cvv, $name, $addr, $state, $city, $zip, $country, $refundable, $price) = explode("|", $line);
        $cards[] = [
            'line' => $line,
            'cc' => $cc,
            'mm' => $mm,
            'yy' => $yy,
            'cvv' => $cvv,
            'name' => $name,
            'addr' => $addr,
            'state' => $state,
            'city' => $city,
            'zip' => $zip,
            'country' => $country,
            'flag' => get_flag($country),
            'refundable' => $refundable,
            'price' => $price
        ];
    }
    return $cards;
}

//SHOW CARDS FOR SALE
//@Darkboy22
function show_cards($chat_id, $page = 0, $edit = false, $msg_id = null) {
    $cards = parse_cards();
    $per_page = 4;
    $total = count($cards);

    if ($total == 0) {
        bot('sendMessage', ['chat_id' => $chat_id, 'text' => "🚫 No available cards for sale."]);
        return;
    }

    $start = $page * $per_page;
    $sliced = array_slice($cards, $start, $per_page);

    $text = "✦━━━━━[  ᴀᴠᴀɪʟᴀʙʟᴇ ᴄᴀʀᴅꜱ ]━━━━━✦\n\n";

    foreach ($sliced as $i => $card) {
        $num = $start + $i + 1;
        $text .= "✦ #$num  
⟡ ʙɪɴ         : " . substr($card['cc'], 0, 6) . "  
⟡ ᴇxᴘɪʀʏ      : {$card['mm']}/{$card['yy']}  
⟡ ᴄᴏᴜɴᴛʀʏ     : {$card['flag']}  {$card['country']}  
⟡ ᴢɪᴘ         : {$card['zip']}  
⟡ ʀᴇꜰᴜɴᴅᴀʙʟᴇ :  " . strtoupper($card['refundable']) . "  
⟡ ᴘʀɪᴄᴇ       : {$card['price']}$\n\n✦━━━━━━━━━━━━━━━━━━━✦\n\n";
    }

    $text .= "✧ ᴜꜱᴇ /buy 1, /buy 2 ... ᴛᴏ ᴘᴜʀᴄʜᴀꜱᴇ ᴀɴʏ ᴄᴀʀᴅ\n\n✦━━━━━━━━━━━━━━━━━━━━━━━━✦";

    $btns = [];
    if ($page > 0) $btns[] = ['text' => '⬅ Previous', 'callback_data' => 'page_' . ($page - 1)];
    if ($start + $per_page < $total) $btns[] = ['text' => 'Next ➡', 'callback_data' => 'page_' . ($page + 1)];

    $markup = ['inline_keyboard' => [$btns]];

    $data = [
        'chat_id' => $chat_id,
        'text' => $text,
        'reply_markup' => json_encode($markup),
        'parse_mode' => 'HTML'
    ];

    if ($edit && $msg_id) {
        $data['message_id'] = $msg_id;
        bot('editMessageText', $data);
    } else {
        bot('sendMessage', $data);
    }
}

/*SHOW COUNTRY FLAG
NOTE -: ADD MORE COUNTRIES WITH FLAG 
*/
//@Darkboy22
function get_flag($country) {
    $flags = [
        "USA" => "🇺🇸", 
        "UK" => "🇬🇧", 
        "India" => "🇮🇳", 
        "Canada" => "🇨🇦",
        "Germany" => "🇩🇪", 
        "France" => "🇫🇷", 
        "Italy" => "🇮🇹", 
        "Spain" => "🇪🇸"
    ];
    return $flags[$country] ?? "🌐";
}


//BUY CARD 
//@Darkboy22
function process_buy($chat_id, $user_id, $index) {
    $users = json_decode(file_get_contents("Data/Users.json"), true);
    if (!isset($users[$user_id])) {
        bot('sendMessage', ['chat_id' => $chat_id, 'text' => "⚠ Please /register to use this feature."]);
        return;
    }

    $cards = parse_cards();
    if (!isset($cards[$index])) {
        bot('sendMessage', ['chat_id' => $chat_id, 'text' => "🚫 Invalid card number."]);
        return;
    }

    $card = $cards[$index];
    $balance = $users[$user_id]['balance'];
    if ($balance < $card['price']) {
        bot('sendMessage', ['chat_id' => $chat_id, 'text' => "🚫 Insufficient balance."]);
        return;
    }

    // Deduct and save
    $users[$user_id]['balance'] -= $card['price'];
    $users[$user_id]['buys'] += 1;
    file_put_contents("Data/Users.json", json_encode($users, JSON_PRETTY_PRINT));

    // Move card
    $all_lines = file("Cards/cc.txt", FILE_IGNORE_NEW_LINES);
    $buy_line = $card['line'];
    unset($all_lines[$index]);
    file_put_contents("Cards/cc.txt", implode("\n", $all_lines));
    file_put_contents("Cards/Sold.txt", $buy_line . "\n", FILE_APPEND);

    // Save order
    $orders = json_decode(file_get_contents("Data/Orders.json"), true);
    $orders[$user_id][] = $buy_line;
    file_put_contents("Data/Orders.json", json_encode($orders, JSON_PRETTY_PRINT));

    $date = date("d M Y");
    $msg = "✦━━━━━[ ᴄᴀʀᴅ ᴘᴜʀᴄʜᴀꜱᴇᴅ ]━━━━━✦

⟡ ᴄᴀʀᴅ      : {$card['cc']} | {$card['mm']}/{$card['yy']} | {$card['cvv']}  
⟡ ɴᴀᴍᴇ      : {$card['name']}  
⟡ ᴀᴅᴅʀᴇꜱꜱ   : {$card['addr']}  
⟡ ᴄɪᴛʏ      : {$card['city']}  
⟡ ꜱᴛᴀᴛᴇ     : {$card['state']}  
⟡ ᴢɪᴘ       : {$card['zip']}  
⟡ ᴄᴏᴜɴᴛʀʏ   : {$card['flag']}  {$card['country']}  
⟡ ᴘʀɪᴄᴇ     : {$card['price']}$  
⟡ ʀᴇꜰᴜɴᴅᴀʙʟᴇ :  " . strtoupper($card['refundable']) . "  
⟡ ᴛɪᴍᴇ      : $date

✧ ᴛʜɪꜱ ᴄᴀʀᴅ ɪꜱ ꜱᴀᴠᴇᴅ ᴛᴏ ʏᴏᴜʀ ᴍʏ ᴏʀᴅᴇʀꜱ

✦━━━━━━━━━━━━━━━━━━━━━━━━✦";

    $reply_markup = ['inline_keyboard' => []];
    if (strtolower($card['refundable']) == "yes") {
        $reply_markup['inline_keyboard'][] = [['text' => '↩ Refund', 'callback_data' => 'refund_' . $card['cc']]];
    }

    bot('sendMessage', [
        'chat_id' => $chat_id,
        'text' => $msg,
        'reply_markup' => json_encode($reply_markup)
    ]);
}


//REFUND CARDS
//@Darkboy22
//NOTE -: REFUND FUNCTION MAY NOT WORK PROPER SO UPDATE IT
function handle_refund($chat_id, $user_id, $cc_number) {
    $sold_cards = file("Cards/Sold.txt", FILE_IGNORE_NEW_LINES);
    $orders = json_decode(file_get_contents("Data/Orders.json"), true);
    $users = json_decode(file_get_contents("Data/Users.json"), true);
    $now = time();
    $match = null;

    foreach ($orders[$user_id] ?? [] as $line) {
        list($cc, $mm, $yy, $cvv, $name, $addr, $state, $city, $zip, $country, $refundable, $price) = explode("|", $line);
        if ($cc == $cc_number) {
            $purchase_time = filemtime("Cards/Sold.txt");
            $minutes = ($now - $purchase_time) / 60;
            if ($minutes > 5) {
                bot('sendMessage', ['chat_id' => $chat_id, 'text' => "✦━━━━━[ ⏳ ʀᴇꜰᴜɴᴅ ᴇxᴘɪʀᴇᴅ ]━━━━━✦

⟡ ᴄᴀʀᴅ     : $cc|$mm|$yy|$cvv  
⟡ ʀᴇꜱᴘᴏɴꜱᴇ : ʀᴇꜰᴜɴᴅ ᴛɪᴍᴇ ʟɪᴍɪᴛ ᴏᴠᴇʀ  
⟡ ꜱᴛᴀᴛᴜꜱ   : ❌ ʀᴇꜰᴜɴᴅ ᴅᴇᴄʟɪɴᴇᴅ  
⟡ ᴛɪᴍᴇ     : " . date("d M Y | h:i A") . "

✦━━━━━━━━━━━━━━━━━━━━━━━━✦"]);
                return;
            }

            if (strtolower($refundable) !== "yes") {
                bot('sendMessage', ['chat_id' => $chat_id, 'text' => "⚠ Refund not allowed on this card."]);
                return;
            }

            $match = compact('cc', 'mm', 'yy', 'cvv', 'price');
            break;
        }
    }

    if (!$match) {
        bot('sendMessage', ['chat_id' => $chat_id, 'text' => "❌ Unable to find this card in your orders."]);
        return;
    }

    // Call API
    $card_str = "{$match['cc']}|{$match['mm']}|20{$match['yy']}|{$match['cvv']}";
    $api_url = "https://ravenxchecker.site/br.php?lista=" . urlencode($card_str);
    $response = @file_get_contents($api_url);
    if (!$response) {
        $admin_id = "952847458"; // change if needed
        bot('sendMessage', ['chat_id' => $chat_id, 'text' => "⚠ API ERROR. Admin will review your card."]);
        bot('sendMessage', ['chat_id' => $admin_id, 'text' => "🚨 Refund API failed for user $chat_id\nCard: $card_str"]);
        return;
    }

    $result = json_decode($response, true);
    $status = strtolower($result["response"] ?? '');
    $bad_responses = [
        "do not honor", "processor declined", "card closed", "expire cards", 
        "card cannot expired", "invalid cards number"
    ];

    if (!$result["success"] && in_array($status, $bad_responses)) {
        $users[$user_id]["balance"] += $match['price'];
        $users[$user_id]["refunds"] += 1;
        file_put_contents("Data/Users.json", json_encode($users, JSON_PRETTY_PRINT));

        file_put_contents("Cards/Refund.txt", "{$match['cc']}|{$match['mm']}|{$match['yy']}|{$match['cvv']}\n", FILE_APPEND);

        bot('sendMessage', ['chat_id' => $chat_id, 'text' => "✦━━━━━[ ✅ ʀᴇꜰᴜɴᴅ ᴀᴘᴘʀᴏᴠᴇᴅ ]━━━━━✦

⟡ ᴄᴀʀᴅ     : {$match['cc']}|{$match['mm']}|{$match['yy']}|{$match['cvv']}
⟡ ʀᴇꜱᴘᴏɴꜱᴇ : {$result['response']}  
⟡ ʀᴇꜰᴜɴᴅ   : {$match['price']}$ ᴄʀᴇᴅɪᴛᴇᴅ  
⟡ ᴛɪᴍᴇ     : " . date("d M Y") . "

✧ ʏᴏᴜʀ ʙᴀʟᴀɴᴄᴇ ʜᴀꜱ ʙᴇᴇɴ ᴜᴘᴅᴀᴛᴇᴅ ꜱᴜᴄᴄᴇꜱꜱꜰᴜʟʟʏ

✦━━━━━━━━━━━━━━━━━━━━━━━━✦"]);
    } else {
        bot('sendMessage', ['chat_id' => $chat_id, 'text' => "✦━━━━━[ ❌ ʀᴇꜰᴜɴᴅ ᴅᴇᴄʟɪɴᴇᴅ ]━━━━━✦

⟡ ᴄᴀʀᴅ     : {$match['cc']}|{$match['mm']}|{$match['yy']}|{$match['cvv']}  
⟡ ʀᴇꜱᴘᴏɴꜱᴇ : {$result['response']}  
⟡ ꜱᴛᴀᴛᴜꜱ   : ɴᴏ ʀᴇꜰᴜɴᴅ ɪꜱꜱᴜᴇᴅ  
⟡ ᴛɪᴍᴇ     : " . date("d M Y | h:i A") . "

✧ ᴏɴʟʏ ᴅᴇᴀᴅ ᴄᴀʀᴅꜱ ᴀʀᴇ ᴇʟɪɢɪʙʟᴇ ꜰᴏʀ ʀᴇꜰᴜɴᴅ ᴡɪᴛʜɪɴ 5 ᴍɪɴᴜᴛᴇꜱ

✦━━━━━━━━━━━━━━━━━━━━━━━━✦"]);
    }
}

//SHOW ORDER HISTORY 
//@Darkboy22
function show_orders($chat_id, $user_id) {
    $orders = json_decode(file_get_contents("Data/Orders.json"), true);
    if (!isset($orders[$user_id]) || count($orders[$user_id]) == 0) {
        $text = "✦━━━━━[  ʏᴏᴜʀ ᴏʀᴅᴇʀꜱ ]━━━━━✦

⟡ ɴᴏ ᴘᴜʀᴄʜᴀꜱᴇꜱ ꜰᴏᴜɴᴅ ʏᴇᴛ  
⟡ ʏᴏᴜ ʜᴀᴠᴇɴ'ᴛ ʙᴏᴜɢʜᴛ ᴀɴʏ ᴄᴀʀᴅꜱ  

✧ ᴜꜱᴇ /acc ᴛᴏ ᴇxᴘʟᴏʀᴇ ᴀᴠᴀɪʟᴀʙʟᴇ ᴄᴀʀᴅꜱ

✦━━━━━━━━━━━━━━━━━━━━━━━━✦";
        bot('sendMessage', ['chat_id' => $chat_id, 'text' => $text]);
        return;
    }

    $user_orders = $orders[$user_id];
    if (count($user_orders) <= 2) {
        $count = 1;
        $msg = "✦━━━━━[ 📦 ʏᴏᴜʀ ᴏʀᴅᴇʀꜱ ]━━━━━✦\n\n";
        foreach ($user_orders as $line) {
            list($cc, $mm, $yy, $cvv, $name, $addr, $state, $city, $zip, $country, $refundable, $price) = explode("|", $line);
            $flag = get_flag($country);
            $ref = (strtolower($refundable) == "yes") ? "✅ ʏᴇꜱ" : "❌ ɴᴏ";
            $msg .= "📌 #$count  
⟡ ᴄᴀʀᴅ     : $cc|$mm|$yy|$cvv  
⟡ ɴᴀᴍᴇ      : $name  
⟡ ᴀᴅᴅʀᴇꜱꜱ   : $addr  
⟡ ᴄɪᴛʏ      : $city  
⟡ ꜱᴛᴀᴛᴇ     : $state 
⟡ ᴢɪᴘ       : $zip
⟡ ᴄᴏᴜɴᴛʀʏ   : $flag $country  
⟡ ᴘʀɪᴄᴇ     : ₹$price  
⟡ ʀᴇꜰᴜɴᴅᴀʙʟᴇ : $ref  
⟡ ᴛɪᴍᴇ     : " . date("d M Y | h:i A") . "\n\n";
            $count++;
        }
        $msg .= "✧ ᴜꜱᴇ /refund <card> ᴛᴏ ʀᴇQᴜᴇꜱᴛ ʀᴇꜰᴜɴᴅ (ɪꜰ ᴇʟɪɢɪʙʟᴇ)\n\n✦━━━━━━━━━━━━━━━━━━━━━━━━✦";
        bot('sendMessage', ['chat_id' => $chat_id, 'text' => $msg]);
    } else {
        $file_data = "";
        $count = 1;
        foreach ($user_orders as $line) {
            list($cc, $mm, $yy, $cvv, $name, $addr, $state, $city, $zip, $country, $refundable, $price) = explode("|", $line);
            $flag = get_flag($country);
            $ref = (strtolower($refundable) == "yes") ? "YES" : "NO";
            $file_data .= "#$count
⟡ ᴄᴀʀᴅ     : $cc|$mm|$yy|$cvv  
⟡ ɴᴀᴍᴇ      : $name  
⟡ ᴀᴅᴅʀᴇꜱꜱ   : $addr  
⟡ ᴄɪᴛʏ      : $city  
⟡ ꜱᴛᴀᴛᴇ     : $state 
⟡ ᴢɪᴘ       : $zip
⟡ ᴄᴏᴜɴᴛʀʏ   : $flag $country  
⟡ ᴘʀɪᴄᴇ     : ₹$price  
⟡ ʀᴇꜰᴜɴᴅᴀʙʟᴇ : $ref  
⟡ ᴛɪᴍᴇ     : " . date("d M Y | h:i A") . "\n\n";
            $count++;
        }

        $file = "Orders_" . $user_id . ".txt";
        file_put_contents($file, $file_data);
        bot('sendDocument', [
            'chat_id' => $chat_id,
            'document' => new CURLFile($file),
            'caption' => "📁 Your full order history",
        ]);
        unlink($file);
    }
}

//STARTING DEPOSIT FUNCTION 
//CHOOSE AMOUNT 
//@Darkboy22
function start_deposit($chat_id, $user_id) {
    file_put_contents("Data/deposit_temp_{$user_id}.lock", "1");

    $text = "✦━━━━━[  ᴅᴇᴘᴏꜱɪᴛ ɪɴɪᴛɪᴀᴛᴇᴅ ]━━━━━✦

⟡ ᴍɪɴɪᴍᴜᴍ   : 15$  
⟡ ɴᴏᴛᴇ       : ᴘʟᴇᴀꜱᴇ ᴇɴᴛᴇʀ ᴀᴍᴏᴜɴᴛ ᴛᴏ ᴘʀᴏᴄᴇᴇᴅ

✧ ᴏɴʟʏ ᴇɴᴛᴇʀ ɴᴜᴍʙᴇʀ (ᴇ.ɢ. 20)

✦━━━━━━━━━━━━━━━━━━━━━━━━✦";
    bot('sendMessage', ['chat_id' => $chat_id, 'text' => $text]);
}

function process_amount($chat_id, $user_id, $amount) {
    unlink("Data/deposit_temp_{$user_id}.lock");

    if ($amount < 15) {
        bot('sendMessage', ['chat_id' => $chat_id, 'text' => "⚠ Minimum deposit is 15$"]);
        return;
    }

    $text = "✦━━━━━[  ꜱᴇʟᴇᴄᴛ ᴄᴜʀʀᴇɴᴄʏ ]━━━━━✦

⟡ ᴀᴍᴏᴜɴᴛ      : {$amount}$  
⟡ ᴍᴇᴛʜᴏᴅ      : ᴄʀʏᴘᴛᴏ  
⟡ ɴᴏᴛᴇ         : ꜱᴇʟᴇᴄᴛ ᴀ ᴄᴜʀʀᴇɴᴄʏ ᴛᴏ ɢᴇᴛ ᴘᴀʏᴍᴇɴᴛ ɪɴꜱᴛʀᴜᴄᴛɪᴏɴꜱ

✧ ᴛʜɪꜱ ᴡɪʟʟ ɢᴇɴᴇʀᴀᴛᴇ ᴀ ᴜɴɪǫᴜᴇ ᴛʀᴀɴꜱᴀᴄᴛɪᴏɴ ɪᴅ

✦━━━━━━━━━━━━━━━━━━━━━━━━✦";

    $buttons = [
        [['text' => '₿ BTC', 'callback_data' => 'btc']],
        [['text' => '₮ USDT', 'callback_data' => 'usdt']],
        [['text' => 'Ł LTC', 'callback_data' => 'ltc']]
    ];

    file_put_contents("Data/deposit_temp_{$user_id}.json", json_encode(['amount' => $amount]));
    bot('sendMessage', [
        'chat_id' => $chat_id,
        'text' => $text,
        'reply_markup' => json_encode(['inline_keyboard' => $buttons])
    ]);
}

//SELECT CURRENCY 
function confirm_currency($chat_id, $user_id, $currency) {
    require_once "nowpayments.php";
    
    $temp = json_decode(file_get_contents("Data/deposit_temp_{$user_id}.json"), true);
    $amount = $temp['amount'];
    unlink("Data/deposit_temp_{$user_id}.json");

    $nowpayments = new NOWPayments();
    $orderId = "DEP_" . $user_id . "_" . time();
    
    $payment = $nowpayments->createPayment(
        $amount,
        "usd",
        strtolower($currency),
        $orderId,
        "Deposit to account"
    );

    if (isset($payment['error'])) {
        bot('sendMessage', ['chat_id' => $chat_id, 'text' => "❌ Payment creation failed: " . $payment['error']]);
        return;
    }

    $paymentId = $payment['payment_id'];
    $payAddress = $payment['pay_address'];
    $payAmount = $payment['pay_amount'];
    $payCurrency = strtoupper($payment['pay_currency']);

    $text = "✦━━━━━[  ᴘᴀʏᴍᴇɴᴛ ᴅᴇᴛᴀɪʟꜱ ]━━━━━✦

⟡ ᴀᴍᴏᴜɴᴛ        : {$amount}$  
⟡ ᴘᴀʏ ᴀᴍᴏᴜɴᴛ   : {$payAmount} {$payCurrency}  
⟡ ᴀᴅᴅʀᴇꜱꜱ       : `{$payAddress}`  
⟡ ᴘᴀʏᴍᴇɴᴛ ɪᴅ    : {$paymentId}  
⟡ ꜱᴛᴀᴛᴜꜱ        : ⏳ ᴡᴀɪᴛɪɴɢ

✧ ꜱᴇɴᴅ ᴇxᴀᴄᴛʟʏ {$payAmount} {$payCurrency} ᴛᴏ ᴛʜᴇ ᴀᴅᴅʀᴇꜱꜱ ᴀʙᴏᴠᴇ
✧ ᴄʟɪᴄᴋ ᴄʜᴇᴄᴋ ᴘᴀʏᴍᴇɴᴛ ᴛᴏ ᴠᴇʀɪꜰʏ

✦━━━━━━━━━━━━━━━━━━━━━━━━✦";

    $buttons = [
        [['text' => '✅ Check Payment', 'callback_data' => 'check_' . $paymentId]],
        [['text' => '❌ Cancel Payment', 'callback_data' => 'cancel_' . $paymentId]]
    ];

    $deposits = json_decode(file_get_contents("Data/Deposit.json"), true) ?? [];
    $deposits[$paymentId] = [
        'user_id' => $user_id,
        'amount' => $amount,
        'pay_amount' => $payAmount,
        'currency' => $payCurrency,
        'pay_address' => $payAddress,
        'payment_id' => $paymentId,
        'order_id' => $orderId,
        'status' => 'WAITING',
        'timestamp' => time()
    ];
    file_put_contents("Data/Deposit.json", json_encode($deposits, JSON_PRETTY_PRINT));

    bot('sendMessage', [
        'chat_id' => $chat_id,
        'text' => $text,
        'parse_mode' => 'Markdown',
        'reply_markup' => json_encode(['inline_keyboard' => $buttons])
    ]);
}

//CANCEL DEPOSIT 
//@Darkboy22
function cancel_deposit($chat_id, $user_id, $txn_id, $msg_id) {
    $deposits = json_decode(file_get_contents("Data/Deposit.json"), true);
    if (!isset($deposits[$txn_id])) return;

    if ($deposits[$txn_id]['status'] == "CANCELLED") {
        bot('sendMessage', ['chat_id' => $chat_id, 'text' => "⚠ This payment is already cancelled."]);
        return;
    }

    $deposits[$txn_id]['status'] = "CANCELLED";
    file_put_contents("Data/Deposit.json", json_encode($deposits, JSON_PRETTY_PRINT));
    bot('deleteMessage', ['chat_id' => $chat_id, 'message_id' => $msg_id]);

    $data = $deposits[$txn_id];
    $text = "✦━━━━━[  ᴘᴀʏᴍᴇɴᴛ ᴄᴀɴᴄᴇʟʟᴇᴅ ]━━━━━✦

⟡ ᴀᴍᴏᴜɴᴛ        : {$data['amount']}$  
⟡ ᴄᴜʀʀᴇɴᴄʏ      : {$data['currency']}  
⟡ ɴᴇᴛᴡᴏʀᴋ       : {$data['network']}  
⟡ ᴛʀᴀɴꜱᴀᴄᴛɪᴏɴ ɪᴅ : {$txn_id}  
⟡ ꜱᴛᴀᴛᴜꜱ        :  ᴄᴀɴᴄᴇʟʟᴇᴅ

✧ ᴛʜɪꜱ ᴅᴇᴘᴏꜱɪᴛ ʜᴀꜱ ʙᴇᴇɴ ᴄᴀɴᴄᴇʟʟᴇᴅ ʙʏ ᴛʜᴇ ᴜꜱᴇʀ

✦━━━━━━━━━━━━━━━━━━━━━━━━✦";

    bot('sendMessage', ['chat_id' => $chat_id, 'text' => $text]);
}


//VERIFY PAYMENT 
//@Darkboy22
function check_payment($chat_id, $user_id, $order_id, $payment_id) {
    require_once "nowpayments.php";
    
    $deposits = json_decode(file_get_contents("Data/Deposit.json"), true);
    $users = json_decode(file_get_contents("Data/Users.json"), true);

    if (!isset($deposits[$payment_id])) {
        bot('sendMessage', ['chat_id' => $chat_id, 'text' => "⚠ Invalid payment ID."]);
        return;
    }

    $deposit = &$deposits[$payment_id];

    if ($deposit['status'] == "COMPLETED") {
        $text = "✦━━━━━[ ᴅᴜᴘʟɪᴄᴀᴛᴇ ᴘᴀʏᴍᴇɴᴛ ]━━━━━✦

⟡ ᴀᴍᴏᴜɴᴛ        : {$deposit['amount']}$  
⟡ ᴄᴜʀʀᴇɴᴄʏ      : {$deposit['currency']}  
⟡ ᴘᴀʏᴍᴇɴᴛ ɪᴅ    : {$payment_id}  
⟡ ꜱᴛᴀᴛᴜꜱ        : ᴀʟʀᴇᴀᴅʏ ʀᴇᴄᴇɪᴠᴇᴅ

✧ ᴛʜɪꜱ ᴘᴀʏᴍᴇɴᴛ ʜᴀꜱ ᴀʟʀᴇᴀᴅʏ ʙᴇᴇɴ ᴄʀᴇᴅɪᴛᴇᴅ

✦━━━━━━━━━━━━━━━━━━━━━━━━✦";
        bot('sendMessage', ['chat_id' => $chat_id, 'text' => $text]);
        return;
    }

    $nowpayments = new NOWPayments();
    $result = $nowpayments->getPaymentStatus($payment_id);

    if (isset($result['error'])) {
        bot('sendMessage', ['chat_id' => $chat_id, 'text' => "❌ Error checking payment: " . $result['error']]);
        return;
    }

    $status = strtoupper($result['payment_status'] ?? 'unknown');

    if (in_array($status, ['WAITING', 'CONFIRMING'])) {
        $text = "✦━━━━━[  ᴘᴀʏᴍᴇɴᴛ ᴘᴇɴᴅɪɴɢ ]━━━━━✦

⟡ ᴀᴍᴏᴜɴᴛ        : {$deposit['amount']}$  
⟡ ᴄᴜʀʀᴇɴᴄʏ      : {$deposit['currency']}  
⟡ ᴘᴀʏᴍᴇɴᴛ ɪᴅ    : {$payment_id}  
⟡ ꜱᴛᴀᴛᴜꜱ        : ⏳ {$status}

✧ ᴘᴀʏᴍᴇɴᴛ ɪꜱ ʙᴇɪɴɢ ᴘʀᴏᴄᴇꜱꜱᴇᴅ — ᴘʟᴇᴀꜱᴇ ᴡᴀɪᴛ

✦━━━━━━━━━━━━━━━━━━━━━━━━✦";
        bot('sendMessage', ['chat_id' => $chat_id, 'text' => $text]);
        return;
    }

    if (in_array($status, ['FINISHED', 'CONFIRMED'])) {
        $deposit['status'] = 'COMPLETED';
        $deposits[$payment_id] = $deposit;
        file_put_contents("Data/Deposit.json", json_encode($deposits, JSON_PRETTY_PRINT));

        $users[$user_id]['balance'] += $deposit['amount'];
        file_put_contents("Data/Users.json", json_encode($users, JSON_PRETTY_PRINT));

        $text = "✦━━━━━[  ᴘᴀʏᴍᴇɴᴛ ꜱᴜᴄᴄᴇꜱꜱ ]━━━━━✦

⟡ ᴀᴍᴏᴜɴᴛ        : {$deposit['amount']}$  
⟡ ᴄᴜʀʀᴇɴᴄʏ      : {$deposit['currency']}  
⟡ ᴘᴀʏᴍᴇɴᴛ ɪᴅ    : {$payment_id}  
⟡ ɴᴇᴡ ʙᴀʟᴀɴᴄᴇ   : \${$users[$user_id]['balance']}  
⟡ ꜱᴛᴀᴛᴜꜱ        : ✅ ᴄᴏᴍᴘʟᴇᴛᴇᴅ

✧ ʏᴏᴜʀ ᴀᴄᴄᴏᴜɴᴛ ʜᴀꜱ ʙᴇᴇɴ ᴄʀᴇᴅɪᴛᴇᴅ ꜱᴜᴄᴄᴇꜱꜱꜰᴜʟʟʏ

✦━━━━━━━━━━━━━━━━━━━━━━━━✦";
        bot('sendMessage', ['chat_id' => $chat_id, 'text' => $text]);
        return;
    }

    // Failed/Expired/Other statuses
    $text = "✦━━━━━[  ᴘᴀʏᴍᴇɴᴛ {$status} ]━━━━━✦

⟡ ᴀᴍᴏᴜɴᴛ        : {$deposit['amount']}$  
⟡ ᴄᴜʀʀᴇɴᴄʏ      : {$deposit['currency']}  
⟡ ᴘᴀʏᴍᴇɴᴛ ɪᴅ    : {$payment_id}  
⟡ ꜱᴛᴀᴛᴜꜱ        : {$status}

✧ ᴘʟᴇᴀꜱᴇ ᴄᴏɴᴛᴀᴄᴛ ꜱᴜᴘᴘᴏʀᴛ ɪꜰ ʏᴏᴜ ʙᴇʟɪᴇᴠᴇ ᴛʜɪꜱ ɪꜱ ᴀɴ ᴇʀʀᴏʀ

✦━━━━━━━━━━━━━━━━━━━━━━━━✦";
    bot('sendMessage', ['chat_id' => $chat_id, 'text' => $text]);
}

//ADD BALANCE THROUGH REDEEM CODE 
//@Darkboy22
function user_redeem_key($chat_id, $user_id, $text) {
    preg_match('/^\/redeem (\w{16})$/', $text, $m);
    $key = strtoupper($m[1]);
    $keys = json_decode(file_get_contents("Data/Keys.json"), true);
    $users = json_decode(file_get_contents("Data/Users.json"), true);

    if (!isset($keys[$key])) {
        bot('sendMessage', ['chat_id' => $chat_id, 'text' => "❌ Invalid key."]);
    } elseif ($keys[$key]['used']) {
        bot('sendMessage', ['chat_id' => $chat_id, 'text' => "⚠ Key already used."]);
    } else {
        $amount = $keys[$key]['amount'];
        $users[$user_id]["balance"] += $amount;
        $keys[$key]['used'] = true;
        file_put_contents("Data/Keys.json", json_encode($keys, JSON_PRETTY_PRINT));
        file_put_contents("Data/Users.json", json_encode($users, JSON_PRETTY_PRINT));
        bot('sendMessage', ['chat_id' => $chat_id, 'text' => "✅ Redeem Successful!\n💰 \$$amount added to your balance."]);
    }
}

//ADDRESS LOOKUP FUNCTION
//@Darkboy22
function address_lookup($chat_id, $user_id, $address) {
    if (!is_registered($user_id)) {
        bot('sendMessage', ['chat_id' => $chat_id, 'text' => "⚠ Please register first using /start"]);
        return;
    }

    $users = json_decode(file_get_contents("Data/Users.json"), true);
    $cost = 5;

    if ($users[$user_id]['balance'] < $cost) {
        bot('sendMessage', ['chat_id' => $chat_id, 'text' => "⚠ Insufficient balance. Address lookup costs \$$cost"]);
        return;
    }

    $text = "✦━━━━━[ 🔍 ᴀᴅᴅʀᴇꜱꜱ ʟᴏᴏᴋᴜᴘ ]━━━━━✦

⟡ ᴀᴅᴅʀᴇꜱꜱ       : {$address}  
⟡ ᴄᴏꜱᴛ          : \${$cost}  
⟡ ꜱᴛᴀᴛᴜꜱ        : 🔎 ꜱᴇᴀʀᴄʜɪɴɢ...

✧ ꜰᴇᴛᴄʜɪɴɢ ᴅᴇᴛᴀɪʟꜱ ꜰʀᴏᴍ ᴅᴀᴛᴀʙᴀꜱᴇ

✦━━━━━━━━━━━━━━━━━━━━━━━━✦";

    bot('sendMessage', ['chat_id' => $chat_id, 'text' => $text]);

    $result = "✦━━━━━[ 📍 ᴀᴅᴅʀᴇꜱꜱ ʀᴇꜱᴜʟᴛꜱ ]━━━━━✦

⟡ ᴀᴅᴅʀᴇꜱꜱ       : {$address}  
⟡ ɴᴀᴍᴇ          : [LOOKUP RESULT]  
⟡ ᴄɪᴛʏ          : [CITY]  
⟡ ꜱᴛᴀᴛᴇ         : [STATE]  
⟡ ᴢɪᴘ           : [ZIP]  
⟡ ᴘʜᴏɴᴇ         : [PHONE]  

✧ ʟᴏᴏᴋᴜᴘ ᴄᴏᴍᴘʟᴇᴛᴇᴅ ꜱᴜᴄᴄᴇꜱꜱꜰᴜʟʟʏ
✧ ᴄʜᴀʀɢᴇᴅ: \${$cost}

✦━━━━━━━━━━━━━━━━━━━━━━━━✦";

    $users[$user_id]['balance'] -= $cost;
    file_put_contents("Data/Users.json", json_encode($users, JSON_PRETTY_PRINT));

    bot('sendMessage', ['chat_id' => $chat_id, 'text' => $result]);
}

//SSN LOOKUP FUNCTION
//@Darkboy22
function ssn_lookup($chat_id, $user_id, $ssn) {
    if (!is_registered($user_id)) {
        bot('sendMessage', ['chat_id' => $chat_id, 'text' => "⚠ Please register first using /start"]);
        return;
    }

    $users = json_decode(file_get_contents("Data/Users.json"), true);
    $cost = 10;

    if ($users[$user_id]['balance'] < $cost) {
        bot('sendMessage', ['chat_id' => $chat_id, 'text' => "⚠ Insufficient balance. SSN lookup costs \$$cost"]);
        return;
    }

    $text = "✦━━━━━[ 🔍 ꜱꜱɴ ʟᴏᴏᴋᴜᴘ ]━━━━━✦

⟡ ꜱꜱɴ            : {$ssn}  
⟡ ᴄᴏꜱᴛ          : \${$cost}  
⟡ ꜱᴛᴀᴛᴜꜱ        : 🔎 ꜱᴇᴀʀᴄʜɪɴɢ...

✧ ꜰᴇᴛᴄʜɪɴɢ ᴅᴇᴛᴀɪʟꜱ ꜰʀᴏᴍ ᴅᴀᴛᴀʙᴀꜱᴇ

✦━━━━━━━━━━━━━━━━━━━━━━━━✦";

    bot('sendMessage', ['chat_id' => $chat_id, 'text' => $text]);

    $result = "✦━━━━━[ 👤 ꜱꜱɴ ʀᴇꜱᴜʟᴛꜱ ]━━━━━✦

⟡ ꜱꜱɴ            : {$ssn}  
⟡ ɴᴀᴍᴇ          : [FULL NAME]  
⟡ ᴅᴏʙ           : [DATE OF BIRTH]  
⟡ ᴀᴅᴅʀᴇꜱꜱ       : [ADDRESS]  
⟡ ᴄɪᴛʏ          : [CITY]  
⟡ ꜱᴛᴀᴛᴇ         : [STATE]  
⟡ ᴘʜᴏɴᴇ         : [PHONE]  

✧ ʟᴏᴏᴋᴜᴘ ᴄᴏᴍᴘʟᴇᴛᴇᴅ ꜱᴜᴄᴄᴇꜱꜱꜰᴜʟʟʏ
✧ ᴄʜᴀʀɢᴇᴅ: \${$cost}

✦━━━━━━━━━━━━━━━━━━━━━━━━✦";

    $users[$user_id]['balance'] -= $cost;
    file_put_contents("Data/Users.json", json_encode($users, JSON_PRETTY_PRINT));

    bot('sendMessage', ['chat_id' => $chat_id, 'text' => $result]);
}