<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Email_tb_model extends CI_Model {
    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        date_default_timezone_set("Asia/Bangkok");
    }




    function createQrcode($linkQrcode,$crfid)
    {
       // $obj = new emailfn();
       // $obj->gci()->load->library("Ciqrcode");
       require("phpqrcode/qrlib.php");
       // $this->load->library('phpqrcode/qrlib');
 
       $SERVERFILEPATH = $_SERVER['DOCUMENT_ROOT'] . '/intsys/crf/upload/qrcode/';
       $urlQrcode = $linkQrcode;
       // $filename1 = 'qrcode' . rand(2, 200) . ".png";
       $filename1 = 'qrcode' . $crfid . ".png";
       $folder = $SERVERFILEPATH;
 
       $filename = $folder . $filename1;
 
       QRcode::png(
          $urlQrcode,
          $filename,
          // $outfile = false,
          $level = QR_ECLEVEL_H,
          $size = 4,
          $margin = 2
       );
 
       // echo "<img src='http://192.190.10.27/crf/upload/qrcode/".$filename1."'>";
       return $filename1;
    }








    
       // Step 1
   function sendemail_savedatath($formno)
   {

      $topicTH = getDataEmail($formno)->crf_topic;
      if (getDataEmail($formno)->crf_topic1 != '') {
         $topicTH .= " / " . getDataEmail($formno)->crf_topic1;
      }
      if (getDataEmail($formno)->crf_topic2 != '') {
         $topicTH .= " / " . getDataEmail($formno)->crf_topic2;
      }
      if (getDataEmail($formno)->crf_topic3 != '') {
         $topicTH .= " / " . getDataEmail($formno)->crf_topic3;
      }
      if (getDataEmail($formno)->crf_topic4 != '') {
         $topicTH .= " / " . getDataEmail($formno)->crf_topic4;
      }
      if (getDataEmail($formno)->crf_topic5 != '') {
         $topicTH .= " / " . getDataEmail($formno)->crf_topic5;
      }

      $short_url = base_url('qrcode/') . getDataEmail($formno)->crf_id;
      // $short_url = shorturl($longurl);


      $subject = "[crf] มีรายการ Credit request form ใหม่ รออนุมัติ";

      $body = '
        <h2>รายการ Credit Request Form ใหม่ รออนุมัติ</h2>
        <table>
         <tr>
            <td><strong>เลขที่คำขอ</strong></td>
            <td>' . getDataEmail($formno)->crfcus_formno . '</td>
            <td><strong>วันที่สร้างรายการ</strong></td>
            <td>' . conDateFromDb(getDataEmail($formno)->crf_datecreate) . '</td>
         </tr>

         <tr>
            <td><strong>ประเภทลูกค้า</strong></td>
            <td>' . getDataEmail($formno)->crf_alltype_subname . '</td>
            <td><strong>สถานะ</strong></td>
            <td>' . getDataEmail($formno)->crf_status . '</td>
         </tr>

         <tr>
            <td><strong>หัวข้อ</strong></td>
            <td colspan="3">' . $topicTH . '</td>
         </tr>

         <tr>
            <td><strong>ชื่อลูกค้า</strong></td>
            <td>' . getDataEmail($formno)->crfcus_name . '</td>
            <td><strong>เซลล์ผู้ดูแล</strong></td>
            <td>' . getDataEmail($formno)->crfcus_salesreps . '</td>
         </tr>

         <tr>
            <td><strong>ผู้บันทึกข้อมูล</strong></td>
            <td>' . getDataEmail($formno)->crf_userpost . '</td>
            <td><strong>แผนก</strong></td>
            <td>' . getDataEmail($formno)->crf_userdeptpost . '</td>
         </tr>

         <tr>
            <td><strong>รหัสพนักงาน</strong></td>
            <td>' . getDataEmail($formno)->crf_userecodepost . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_userpostdatetime) . '</td>
         </tr>

         <tr>
            <td><strong>ตรวจสอบรายการ</strong></td>
            <td colspan="3"><a href="' . base_url('main/viewdata/') . getDataEmail($formno)->crf_id . '">' . getDataEmail($formno)->crfcus_formno . '</a></td>
         </tr>

         <tr>
            <td><strong>Scan QrCode</strong></td>
            <td colspan="3"><img src="' . base_url('upload/qrcode/') . $this->createQrcode($short_url,getDataEmail($formno)->crf_id) . '"></td>
         </tr>

         </table>
         ';


    $ecodeTb = getDataEmail($formno)->crf_userecodepost;

    if($ecodeTb == "M1848"){//คุณโสเปิด
        $to = array("sopida_h@saleecolour.com");
        $cc = array("chalouy@saleecolour.com" , "nipon@saleecolour.com");
    }else if($ecodeTb == "M0051"){//พี่พลเปิด
        $to = array("nipon@saleecolour.com");
        $cc = array("chalouy@saleecolour.com" , "sopida_h@saleecolour.com");
    }else if($ecodeTb == "M0003"){//พี่หลวยเปิด
        $to = array("chalouy@saleecolour.com");
        $cc = array("sopida_h@saleecolour.com" , "nipon@saleecolour.com");
    }

      emailSaveDataTH($subject, $body, $to, $cc);
      //  Email Zone
   }
   //End Step 1






}/* End of file ModelName.php */






?>