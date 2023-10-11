<?php

// require("vendor/autoload.php");
require_once __DIR__ . '/vendor/autoload.php';

$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/tmp',
    ]),
    'fontdata' => $fontData + [
        'sarabun' => [
            'R' => 'THSarabunNew.ttf',
            'I' => 'THSarabunNew Italic.ttf',
            'B' => 'THSarabunNew Bold.ttf'
        ]
    ],
    'default_font' => 'sarabun'
]);

ob_start();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<style>
    body{
        font-family: 'Sarabun' , sans-serif;
    }
</style>
</head>

<body>
    <h2>ทดสอบการ Export ข้อมูล</h2>
    <table class="table table-striped" style="border:1px solid #ccc;">
        <thead>
            <tr>
                <th>ทดสอบ1</th>
                <th>ทดสอบ2</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>ข้อมูลการทดสอบ1</td>
                <td>ข้อมูลการทดสอบ2</td>
            </tr>
        </tbody>
    </table>

    <?php
    $html = ob_get_contents();
    $mpdf->WriteHTML($html);
    $mpdf->Output("myreport.pdf");
    ob_end_flush();
    ?>

    <div>
        <a href="myreport.pdf" target="_blank"><button>ดาวน์โหลด</button></a>
    </div>
</body>

</html>