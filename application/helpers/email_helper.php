<?php
class emailfn
{
    public $ci;

    function __construct()
    {
        $this->ci = &get_instance();
        date_default_timezone_set("Asia/Bangkok");
        
    }

    public function gci()
    {
        return $this->ci;
    }
}



function getEmailUser()
{
    $obj = new emailfn();
    $query = $obj->gci()->db->query("SELECT * FROM email_information");
    return $query->row();
}




function getDataEmail($formno)
{
    $obj = new emailfn();
    $sql = $obj->gci()->db->query("SELECT
    crf_id,
    a.crf_company,
    a.crf_datecreate,
    b.crf_alltype_subname,
    crf_status,
    crf_topic,
    crf_topic1,
    crf_topic2,
    crf_topic3,
    crf_topic4,
    crf_topic5,
    c.crfcus_name,
    c.crfcus_salesreps,
    c.crfcus_formno,
    c.crfcus_usercreate_deptcode,
    a.crf_userpost,
    a.crf_userdeptpost,
    a.crf_userecodepost,
    a.crf_userpostdatetime,
    a.crf_mgrapprove_name,
    a.crf_mgrapprove_detail,
    a.crf_mgrapprove_datetime,
    a.crf_mgrapprove_status,
    a.crf_brcode,
    a.crf_brcode_userpost,
    a.crf_brcode_datetime,
    a.crf_accmgr_name,
    a.crf_accmgr_detail,
    a.crf_accmgr_datetime,
    a.crf_accmgrapprove_status,
    a.crf_director_name1,
    a.crf_director_datetime1,
    a.crf_directorapprove_status1,
    a.crf_director_detail1,
    a.crf_director_name2,
    a.crf_director_datetime2,
    a.crf_directorapprove_status2,
    a.crf_director_detail2,
    a.crf_userecodepost,
    a.crf_userdeptcodepost,
    a.crf_savecustomercode,
    a.crf_usersave_customercode,
    a.crf_datetimesave_customercode,
    a.crf_memo_customercode

    FROM
    crf_maindata AS a
    INNER JOIN crf_alltype AS b ON a.crf_type = b.crf_alltype_subcode
    INNER JOIN crf_customers_temp AS c ON a.crf_formno = c.crfcus_formno
    WHERE crf_formno = '$formno'
    ");

    return $sql->row();
}


function getDataEmailEx($formno)
{
    $obj = new emailfn();
    $sql = $obj->gci()->db->query("SELECT
    a.crfex_id,
    a.crfex_company,
    a.crfex_datecreate,
    b.crf_alltype_subnameEN,
    a.crfex_status,
    a.crfex_topic,
    a.crfex_curcustopic1,
    a.crfex_curcustopic2,
    c.crfexcus_nameEN,
    c.crfexcus_salesreps,
    c.crfexcus_formno,
    a.crfex_userpost,
    a.crfex_userdept,
    c.crfexcus_userecode,
    c.crfexcus_userdeptcode,
    a.crfex_userdatetime,
    a.crfex_mgrapp_status,
    a.crfex_mgrapp_username,
    a.crfex_mgrapp_datetime,
    a.crfex_mgrapp_detail,
    a.crfex_brcode,
    a.crfex_csuserpost,
    a.crfex_csdatetime,
    a.crfex_accmgr_username,
    a.crfex_accmgr_datetime,
    a.crfex_accmgr_status,
    a.crfex_accmgr_detail,
    a.crfex_directorapp_username,
    a.crfex_directorapp_datetime,
    a.crfex_directorapp_status,
    a.crfex_directorapp_detail,
    a.crfex_directorapp_username2,
    a.crfex_directorapp_datetime2,
    a.crfex_directorapp_status2,
    a.crfex_directorapp_detail2,
    a.crfex_acccuscode,
    a.crfex_accuserpost,
    a.crfex_accdatetime,
    a.crfex_accmemo

    FROM
    crfex_maindata AS a
    INNER JOIN crf_alltype AS b ON a.crfex_custype = b.crf_alltype_subcode
    INNER JOIN crfex_customers_temp AS c ON a.crfex_formno = c.crfexcus_formno
    WHERE crfex_formno = '$formno'
    ");

    return $sql->row();
}


function shorturl($long_url)
{
    // $long_url = 'https://www.saleecolour.com/';
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
        return $resultToJson->link;
    } else {
        echo 'Not found';
    }
}



// function createQrcode($linkQrcode)
// {
//     $obj = new emailfn();
//     $obj->gci()->load->library("Ciqrcode");

//     $SERVERFILEPATH = $_SERVER['DOCUMENT_ROOT'].'upload/qrcode/';
//     $urlQrcode = $linkQrcode;
//     $filename1 = 'qrcode'.rand(2,200).".png";
//     $folder = $SERVERFILEPATH;

//     $filename = $folder.$filename1;

//    QRcode::png(
//         $urlQrcode,
//         $filename
//         // $outfile = false,
//         // $level = QR_ECLEVEL_H,
//         // $size = 6,
//         // $margin =2
//     );

//     echo "<img src='http://192.190.10.27/crf/upload/qrcode/".$filename1."'>";

// }


function emailSaveDataTH($subject, $body, $to, $cc)
{
    require("PHPMailer_5.2.0/class.phpmailer.php");

    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->CharSet = "utf-8";  // ในส่วนนี้ ถ้าระบบเราใช้ tis-620 หรือ windows-874 สามารถแก้ไขเปลี่ยนได้
    $mail->SMTPDebug = 1;                                      // set mailer to use SMTP
    $mail->Host = "mail.saleecolour.net";  // specify main and backup server

    $mail->Port = 25; // พอร์ท

    $mail->SMTPAuth = true;     // turn on SMTP authentication
    $mail->Username = getEmailUser()->email_user;  // SMTP username

    $mail->Password = getEmailUser()->email_password; // SMTP password

    $mail->From = getEmailUser()->email_user;
    $mail->FromName = "Credit request form system.";


    foreach ($to as $email) {
        $mail->AddAddress($email);
    }

    foreach ($cc as $email) {
        $mail->AddCC($email);
    }

    // $mail->AddAddress($to);
    $mail->AddCC("chainarong_k@saleecolour.com");

    $mail->WordWrap = 50;                                 // set word wrap to 50 characters
    $mail->IsHTML(true);                                  // set email format to HTML
    $mail->Subject = $subject;
    $mail->Body = '
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Sarabun&display=swap");

        h3{
            font-family: Tahoma, sans-serif;
            font-size:14px;
        }

        table {
            font-family: Tahoma, sans-serif;
            font-size:14px;
            border-collapse: collapse;
            width: 70%;
          }
          
          td, th {
            border: 1px solid #ccc;
            text-align: left;
            padding: 8px;
          }
          
          tr:nth-child(even) {
            background-color: #F5F5F5;
          }

          .bghead{
              text-align:center;
              background-color:#D3D3D3;
          }
        </style>
    ' . $body;
    // $mail->send();

    if($_SERVER['HTTP_HOST'] != "localhost"){
        $mail->send();
    }

}


function getuserEmailToDirector($posi)
{
    $obj = new emailfn();
    $obj->gci()->db2 = $obj->gci()->load->database('saleecolour', TRUE);

    $query = $obj->gci()->db2->query("SELECT memberemail FROM member WHERE posi in ($posi) AND resigned = 0 AND ecode NOT IN ('M0195' , 'M0001' , 'M0002')");
    return $query;
}



function getuserEmailTo($deptcode, $posi)
{
    $obj = new emailfn();
    $obj->gci()->db2 = $obj->gci()->load->database('saleecolour', TRUE);

    $query = $obj->gci()->db2->query("SELECT memberemail FROM member WHERE DeptCode = '$deptcode' AND posi in ($posi) AND resigned = 0");
    return $query;
}


function getuserEmailToCs($ecode)
{
    $obj = new emailfn();
    $obj->gci()->db2 = $obj->gci()->load->database('saleecolour', TRUE);

    $query = $obj->gci()->db2->query("SELECT memberemail FROM member WHERE ecode in ($ecode) AND resigned = 0");
    return $query;
}


function getuserEmailToSl($deptcode, $ecode)
{
    $obj = new emailfn();
    $obj->gci()->db2 = $obj->gci()->load->database('saleecolour', TRUE);

    $query = $obj->gci()->db2->query("SELECT memberemail FROM member WHERE DeptCode = '$deptcode' AND ecode IN $ecode AND resigned = 0");
    return $query;
}


function getuserEmailCc($ecode)
{
    $obj = new emailfn();
    $obj->gci()->db2 = $obj->gci()->load->database('saleecolour', TRUE);

    $query = $obj->gci()->db2->query("SELECT memberemail FROM member WHERE ecode = '$ecode' AND resigned = 0");
    return $query;
}

function getuserEmailToOwner($ecode)
{
    $obj = new emailfn();
    $obj->gci()->db2 = $obj->gci()->load->database('saleecolour', TRUE);

    $query = $obj->gci()->db2->query("SELECT memberemail FROM member WHERE ecode = '$ecode' AND resigned = 0");
    return $query;
}

function getuserEmailccOwner($deptcode)
{
    $obj = new emailfn();
    $obj->gci()->db2 = $obj->gci()->load->database('saleecolour', TRUE);

    $query = $obj->gci()->db2->query("SELECT memberemail FROM member WHERE DeptCode = '$deptcode' AND resigned = 0");
    return $query;
}
