<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php

$long_url = 'https://www.saleecolour.com/';
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

if (isset($resultToJson->link)) {
    echo $resultToJson->link;
}
else {
    echo 'Not found';
}

?>


</body>
</html>