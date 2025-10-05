<?php

class NOWPayments {
    private $apiKey;
    private $baseUrl = "https://api.nowpayments.io/v1";
    
    public function __construct() {
        $this->apiKey = getenv("NOWPAYMENTS_API_KEY") ?: "YOUR_NOWPAYMENTS_API_KEY";
    }
    
    private function makeRequest($endpoint, $method = "GET", $data = null) {
        $url = $this->baseUrl . $endpoint;
        $ch = curl_init();
        
        $headers = [
            "x-api-key: " . $this->apiKey,
            "Content-Type: application/json"
        ];
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        if ($method == "POST") {
            curl_setopt($ch, CURLOPT_POST, true);
            if ($data) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            }
        }
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        $result = json_decode($response, true);
        
        if ($httpCode >= 400) {
            return ['error' => $result['message'] ?? 'API Error', 'code' => $httpCode];
        }
        
        return $result;
    }
    
    public function getStatus() {
        return $this->makeRequest("/status");
    }
    
    public function getCurrencies() {
        return $this->makeRequest("/currencies");
    }
    
    public function getMinAmount($currencyFrom, $currencyTo = "usd") {
        return $this->makeRequest("/min-amount?currency_from={$currencyFrom}&currency_to={$currencyTo}");
    }
    
    public function estimatePrice($amount, $currencyFrom = "usd", $currencyTo = "btc") {
        return $this->makeRequest("/estimate?amount={$amount}&currency_from={$currencyFrom}&currency_to={$currencyTo}");
    }
    
    public function createPayment($priceAmount, $priceCurrency = "usd", $payCurrency = "btc", $orderId = null, $description = null) {
        $data = [
            "price_amount" => $priceAmount,
            "price_currency" => $priceCurrency,
            "pay_currency" => $payCurrency,
            "order_id" => $orderId ?? uniqid("order_"),
            "order_description" => $description ?? "Deposit"
        ];
        
        return $this->makeRequest("/payment", "POST", $data);
    }
    
    public function getPaymentStatus($paymentId) {
        return $this->makeRequest("/payment/{$paymentId}");
    }
    
    public function createInvoice($priceAmount, $priceCurrency = "usd", $orderId = null, $description = null, $successUrl = null) {
        $data = [
            "price_amount" => $priceAmount,
            "price_currency" => $priceCurrency,
            "order_id" => $orderId ?? uniqid("order_"),
            "order_description" => $description ?? "Deposit",
            "success_url" => $successUrl
        ];
        
        return $this->makeRequest("/invoice", "POST", $data);
    }
}
?>
