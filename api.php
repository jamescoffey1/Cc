<?php
date_default_timezone_set("Asia/Kolkata");

// === Your Binance API Keys ===
$apiKey = 'REPLACE_YOUR_BINANCE_API_KEY';
$apiSecret = 'REPLACE_YOUR_BINANCE_SECERET_KEY';

// === Get Input Parameter ===
$checkAmount = isset($_GET['check']) ? floatval($_GET['check']) : 0;

if (!$checkAmount) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing or invalid check amount']);
    exit;
}

// === Time Range: Last 24 Hours ===
$endTime = round(microtime(true) * 1000);
$startTime = $endTime - (24 * 60 * 60 * 1000);

// === Binance API Details ===
$baseUrl = "https://api.binance.com";
$endpoint = "/sapi/v1/capital/deposit/hisrec";

$params = [
    "startTime" => $startTime,
    "endTime" => $endTime,
    "timestamp" => $endTime
];

ksort($params);
$query = http_build_query($params);
$signature = hash_hmac('sha256', $query, $apiSecret);
$query .= "&signature=$signature";

// === CURL Request ===
$ch = curl_init("$baseUrl$endpoint?$query");
curl_setopt($ch, CURLOPT_HTTPHEADER, ["X-MBX-APIKEY: $apiKey"]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

// === Parse Binance Response ===
$data = json_decode($response, true);

if (!is_array($data)) {
    http_response_code(500);
    echo json_encode(['error' => 'Binance API error or invalid credentials']);
    exit;
}

$matched = null;
$expectedAmount = round($checkAmount, 2);

foreach ($data as $deposit) {
    if (!is_array($deposit)) continue;
    $depositAmount = round(floatval($deposit['amount'] ?? 0), 2);
    $status = intval($deposit['status'] ?? 0);

    if ($depositAmount == $expectedAmount && $status === 1) {
        $matched = [
            "AMOUNT" => $deposit['amount'],
            "ORDER ID" => $deposit['txId'],
            "DATE" => date("Y-m-d H:i:s", $deposit['insertTime'] / 1000),
            "CURRENCY" => strtoupper($deposit['coin']),
            "NETWORK" => strtoupper($deposit['network']),
            "STATUS" => "RECEIVED"
        ];
        break;
    }
}

// === Response Output ===
if ($matched) {
    http_response_code(200);
    echo json_encode([$matched], JSON_PRETTY_PRINT);
} else {
    http_response_code(404);
    echo json_encode([[
        "AMOUNT" => "0",
        "ORDER ID" => "NOT FOUND",
        "DATE" => date("Y-m-d H:i:s"),
        "CURRENCY" => "UNABLE TO DETECT",
        "NETWORK" => "NOT FOUND",
        "STATUS" => "NOT RECEIVED"
    ]], JSON_PRETTY_PRINT);
}
