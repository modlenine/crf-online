<?php

$long_url = 'https://www.saleecolour.com';
$apiv4 = 'https://api-ssl.bitly.com/v4/bitlinks';
$genericAccessToken = '29ad665eadf5cb5aead471257fe29a333eb00fab';

$data = array(
    'long_url' => $long_url
);
$payload = json_encode($data);

$header = array(
    'Authorization: Bearer ' . $genericAccessToken,
    'Content-Type: application/json',
    'Content-Length: ' . strlen($payload)
);

$ch = curl_init($apiv4);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
$result = curl_exec($ch);
$resultToJson = json_decode($result);

print_r($result);
echo "<br>";
echo $resultToJson->id;
echo "<br>";
echo "testtest";


// echo phpinfo();

?>