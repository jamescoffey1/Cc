<?php
require_once "nowpayments.php";

date_default_timezone_set("Asia/Kolkata");

$nowpayments = new NOWPayments();

$paymentId = isset($_GET['payment_id']) ? trim($_GET['payment_id']) : '';

if (!$paymentId) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing payment_id parameter']);
    exit;
}

$result = $nowpayments->getPaymentStatus($paymentId);

if (isset($result['error'])) {
    http_response_code(404);
    echo json_encode([[
        "PAYMENT_ID" => $paymentId,
        "STATUS" => "NOT FOUND",
        "ERROR" => $result['error']
    ]], JSON_PRETTY_PRINT);
    exit;
}

$status = strtoupper($result['payment_status'] ?? 'unknown');
$amount = $result['price_amount'] ?? 0;
$currency = strtoupper($result['price_currency'] ?? 'USD');
$payCurrency = strtoupper($result['pay_currency'] ?? '');
$actuallyPaid = $result['actually_paid'] ?? 0;

$response = [[
    "PAYMENT_ID" => $paymentId,
    "AMOUNT" => $amount,
    "CURRENCY" => $currency,
    "PAY_CURRENCY" => $payCurrency,
    "ACTUALLY_PAID" => $actuallyPaid,
    "STATUS" => $status,
    "DATE" => date("Y-m-d H:i:s")
]];

if (in_array($status, ['FINISHED', 'CONFIRMED'])) {
    http_response_code(200);
} else {
    http_response_code(202);
}

echo json_encode($response, JSON_PRETTY_PRINT);
