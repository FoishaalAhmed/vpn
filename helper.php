<?php
$ip = $_GET['ip']; // Get the IP address from the query string

// Call the HTTP API using cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://ip-api.com/json/$ip");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

// Send the response back to the client
header('Content-Type: application/json');
echo $response;
?>