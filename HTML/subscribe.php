<?php
$apiKey = 'cf517b01dc4e71e0b28c7304a2a95409-us8'; // Ваш API-ключ
$listId = 'eaff04d171'; // Ваш ID списка
$email = $_POST['email'];

$dataCenter = substr($apiKey, strpos($apiKey, '-') + 1); // Извлечение datacenter из API-ключа
$url = "https://$dataCenter.api.mailchimp.com/3.0/lists/$listId/members/";

$data = [
    'email_address' => $email,
    'status' => 'subscribed', // "subscribed", "pending" или "unsubscribed"
];

$payload = json_encode($data);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Basic ' . base64_encode('user:' . $apiKey)
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

$result = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Получение HTTP-статуса
curl_close($ch);

if ($httpCode === 200) {
    echo "Got it, you've been added to our email list.";
} else {
    $response = json_decode($result, true);
    echo "Error: " . ($response['detail'] ?? 'Unknown error');
}
?>
