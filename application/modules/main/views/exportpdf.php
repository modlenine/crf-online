<?php

require("vendor/autoload.php");

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
        /* thai */
        @font-face {
            font-family: 'Sarabun';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: local('Sarabun Regular'), local('Sarabun-Regular'), url(<?= base_url('assets/fonts/DtVjJx26TKEr37c9aAFJn2QN.woff2') ?>) format('woff2');
            unicode-range: U+0E01-0E5B, U+200C-200D, U+25CC;
        }

        /* vietnamese */
        @font-face {
            font-family: 'Sarabun';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: local('Sarabun Regular'), local('Sarabun-Regular'), url(<?= base_url('assets/fonts/DtVjJx26TKEr37c9aBpJn2QN.woff2') ?>) format('woff2');
            unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
        }

        /* latin-ext */
        @font-face {
            font-family: 'Sarabun';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: local('Sarabun Regular'), local('Sarabun-Regular'), url(<?= base_url('assets/fonts/DtVjJx26TKEr37c9aBtJn2QN.woff2') ?>) format('woff2');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        /* latin */
        @font-face {
            font-family: 'Sarabun';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: local('Sarabun Regular'), local('Sarabun-Regular'), url(<?= base_url('assets/fonts/DtVjJx26TKEr37c9aBVJnw.woff2') ?>) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        * {
            font-family: 'Sarabun', sans-serif;
        }

        body {
            font-family: 'Sarabun', sans-serif;
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
        <a href="<?= base_url('myreport.pdf') ?>" target="_blank"><button>ดาวน์โหลด</button></a>
    </div>
</body>

</html>