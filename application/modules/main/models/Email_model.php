<?php
class Email_model extends CI_Model
{

   public function __construct()
   {
      parent::__construct();
      //Do your magic here
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

      //  Email Zone
      $deptcodeTo = getDataEmail($formno)->crf_userdeptcodepost;
      $posiTo = 75;
      if ($deptcodeTo == 1006) {
         $ecode = "('M0051' , 'M0112')";
         $option = getuserEmailToSl($deptcodeTo , $ecode);
      } else {
         $option = getuserEmailTo($deptcodeTo, $posiTo);
      }


      $to = array();
      foreach ($option->result_array() as $result) {
         $to[] = $result['memberemail'];
      }

      //  $to = array(
      //      "chainarong_k@saleecolour.com",
      //  );

      $ecodecc = getDataEmail($formno)->crf_userecodepost;
      $optioncc = getuserEmailToOwner($ecodecc);

      $cc = array();
      foreach ($optioncc->result_array() as $resultcc) {
         $cc[] = $resultcc['memberemail'];
      }

      emailSaveDataTH($subject, $body, $to, $cc);
      //  Email Zone



      //load library for insert data to notifycenter
      $this->db_saleecolour = $this->load->database("saleecolour" , TRUE);
      
      $sqlfornitifyAction = $this->db_saleecolour->query("SELECT ecode From member WHERE DeptCode = '$deptcodeTo' AND resigned = 0 AND posi = 75 GROUP BY ecode");

      $sqlfornotifyRead = $this->db_saleecolour->query("SELECT ecode From member WHERE ecode = '$ecodecc' AND resigned = 0 GROUP BY ecode");

      $ecodeActionArr = [];
      $ecodeReadArr = [];

      foreach($sqlfornitifyAction->result() as $ecodeArray){
         $ecodeActionArr[] = $ecodeArray->ecode;
      }

      foreach($sqlfornotifyRead->result() as $ecodeArrayRead){
         $ecodeReadArr[] = $ecodeArrayRead->ecode;
      }


      // $ecodeActionArr = array_unique($ecodeActionArr);
      // $ecodeReadArr = array_unique($ecodeReadArr);


      $title = "[crf] มีรายการ Credit request form ใหม่ รออนุมัติ";
      $status = getDataEmail($formno)->crf_status;
      $link = base_url('main/viewdata/').getDataEmail($formno)->crf_id;
      $programname = "credit request form";

      $this->notifycenter->insertdataaction_template($ecodeActionArr , $title , $status , $link , $formno , $programname);
      $this->notifycenter->insertdataRead_template($ecodeReadArr , $title , $status , $link , $formno , $programname);

   }
   //End Step 1




   function sendemail_toCs($formno)
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


      $subject = "[crf] มีรายการ Credit request form ใหม่รอเพิ่ม BRCODE";

      $body = '
        <h2>รายการ Credit Request Form ใหม่รอเพิ่ม BRCODE</h2>
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
            <td colspan="4" class="bghead"><b>ผลการอนุมัติของ Manager</b></td>
         </tr>

         <tr>
            <td><strong>ผู้อนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_name . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_mgrapprove_datetime) . '</td>
         </tr>

         <tr>
            <td><strong>ผลการอนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_status . '</td>
            <td><strong>เหตุผล</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_detail . '</td>
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



      //  Email Zone


      $ecode = " 'M0019' , 'M1508' , 'M0254' , 'M1909' , 'M1905' , 'M2119' ";

      $option = getuserEmailToCs($ecode);


      $to = array();
      $ecodeAr = array();
      $ecodeccAr = array();
      foreach ($option->result_array() as $result) {
         $to[] = $result['memberemail'];
         $ecodeAr[] = $result['ecode'];
      }

      //  $to = array(
      //      "chainarong_k@saleecolour.com",
      //  );

      $ecodecc = getDataEmail($formno)->crf_userecodepost;
      $optioncc = getuserEmailToOwner($ecodecc);

      $cc = array();
      foreach ($optioncc->result_array() as $resultcc) {
         $cc[] = $resultcc['memberemail'];
         $ecodeccAr[] = $resultcc['ecode'];
      }

      $to = array_unique($to);
      $cc = array_unique($cc);
      $ecodeAr = array_unique($ecodeAr);
      $ecodeccAr = array_unique($ecodeccAr);

      emailSaveDataTH($subject, $body, $to, $cc);
      //  Email Zone


      $ecodeActionArr = $ecodeAr;
      $ecodeReadArr = $ecodeccAr;

      $title = "[crf] มีรายการ Credit request form ใหม่รอเพิ่ม BRCODE";
      $status = getDataEmail($formno)->crf_status;
      $link = base_url('main/viewdata/').getDataEmail($formno)->crf_id;
      $programname = "credit request form";

      $this->notifycenter->insertdataaction_template($ecodeActionArr , $title , $status , $link , $formno , $programname);
      $this->notifycenter->insertdataRead_template($ecodeReadArr , $title , $status , $link , $formno , $programname);

   }





   function sendemail_toAccMgr($formno)
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


      $subject = "[crf] มีรายการ Credit request form ใหม่รอ Account Manager อนุมัติ";

      $body = '
        <h2>รายการ Credit Request Form ใหม่รอ Account Manager อนุมัติ</h2>
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
            <td colspan="4" class="bghead"><b>ผลการอนุมัติของ Manager</b></td>
         </tr>

         <tr>
            <td><strong>ผู้อนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_name . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_mgrapprove_datetime) . '</td>
         </tr>

         <tr>
            <td><strong>ผลการอนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_status . '</td>
            <td><strong>เหตุผล</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_detail . '</td>
         </tr>

         <tr>
            <td colspan="4" class="bghead"><b>ผลการดำเนินงานของ CS</b></td>
         </tr>

         <tr>
            <td><strong>BR CODE</strong></td>
            <td colspan="3">' . getDataEmail($formno)->crf_brcode . '</td>
         </tr>

         <tr>
            <td><strong>ผู้บันทึก</strong></td>
            <td>' . getDataEmail($formno)->crf_brcode_userpost . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_brcode_datetime) . '</td>
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



      //  Email Zone


      $posiTo = "75";
      $deptcodeTo = 1003;
      $option = getuserEmailTo($deptcodeTo, $posiTo);


      $to = array();
      $ecodeAr = array();
      foreach ($option->result_array() as $result) {
         $to[] = $result['memberemail'];
         $ecodeAr[] = $result['ecode'];
      }

      array_push($to , "tassanee_s@saleecolour.com");
      array_push($ecodeAr , "M1767");

      array_push($to , "supawadee.su@saleecolour.com");
      array_push($ecodeAr , "M2217");

      array_push($to , "siriporn_p@saleecolour.com");
      array_push($ecodeAr , "M1260");

      $ecodecc = getDataEmail($formno)->crf_userecodepost;
      $optioncc = getuserEmailToOwner($ecodecc);

      $cc = array();
      $ecodeccAr = array();
      foreach ($optioncc->result_array() as $resultcc) {
         $cc[] = $resultcc['memberemail'];
         $ecodeccAr[] = $resultcc['ecode'];
      }

      $to = array_unique($to);
      $cc = array_unique($cc);
      $ecodeAr = array_unique($ecodeAr);
      $ecodeccAr = array_unique($ecodeccAr);

      emailSaveDataTH($subject, $body, $to, $cc);
      //  Email Zone


      // Notification center program
      $ecodeActionArr = $ecodeAr;
      $ecodeReadArr = $ecodeccAr;

      $title = "[crf] มีรายการ Credit request form ใหม่รอ Account Manager อนุมัติ";
      $status = getDataEmail($formno)->crf_status;
      $link = base_url('main/viewdata/').getDataEmail($formno)->crf_id;
      $programname = "credit request form";

      $this->notifycenter->insertdataaction_template($ecodeActionArr , $title , $status , $link , $formno , $programname);
      $this->notifycenter->insertdataRead_template($ecodeReadArr , $title , $status , $link , $formno , $programname);

   }


   function sendemail_toAccMgr2($formno)
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


      $subject = "[crf] มีรายการ Credit request form ใหม่รอ Account Manager อนุมัติ";

      $body = '
        <h2>รายการ Credit Request Form ใหม่รอ Account Manager อนุมัติ</h2>
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
            <td colspan="4" class="bghead"><b>ผลการอนุมัติของ Manager</b></td>
         </tr>

         <tr>
            <td><strong>ผู้อนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_name . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_mgrapprove_datetime) . '</td>
         </tr>

         <tr>
            <td><strong>ผลการอนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_status . '</td>
            <td><strong>เหตุผล</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_detail . '</td>
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



      //  Email Zone


      $posiTo = "75";
      $deptcodeTo = 1003;
      $option = getuserEmailTo($deptcodeTo, $posiTo);


      $to = array();
      $ecodeAr = array();
      foreach ($option->result_array() as $result) {
         $to[] = $result['memberemail'];
         $ecodeAr[] = $result['ecode'];
      }

      array_push($to , "tassanee_s@saleecolour.com");
      array_push($ecodeAr , "M1767");

      array_push($to , "supawadee.su@saleecolour.com");
      array_push($ecodeAr , "M2217");

      array_push($to , "siriporn_p@saleecolour.com");
      array_push($ecodeAr , "M1260");

      $ecodecc = getDataEmail($formno)->crf_userecodepost;
      $optioncc = getuserEmailToOwner($ecodecc);

      $cc = array();
      $ecodeccAr = array();
      foreach ($optioncc->result_array() as $resultcc) {
         $cc[] = $resultcc['memberemail'];
         $ecodeccAr[] = $resultcc['ecode'];
      }

      $to = array_unique($to);
      $cc = array_unique($cc);
      $ecodeAr = array_unique($ecodeAr);
      $ecodeccAr = array_unique($ecodeccAr);

      emailSaveDataTH($subject, $body, $to, $cc);
      //  Email Zone


      // Notification center program
      $ecodeActionArr = $ecodeAr;
      $ecodeReadArr = $ecodeccAr;

      $title = "[crf] มีรายการ Credit request form ใหม่รอ Account Manager อนุมัติ";
      $status = getDataEmail($formno)->crf_status;
      $link = base_url('main/viewdata/').getDataEmail($formno)->crf_id;
      $programname = "credit request form";

      $this->notifycenter->insertdataaction_template($ecodeActionArr , $title , $status , $link , $formno , $programname);
      $this->notifycenter->insertdataRead_template($ecodeReadArr , $title , $status , $link , $formno , $programname);

   }



   function sendemail_toDerector1($formno)
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


      $subject = "[crf] มีรายการ Credit request form ใหม่รอ Director อนุมัติ";

      $body = '
        <h2>รายการ Credit Request Form ใหม่รอ Director อนุมัติ</h2>
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
            <td colspan="4" class="bghead"><b>ผลการอนุมัติของ Manager</b></td>
         </tr>

         <tr>
            <td><strong>ผู้อนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_name . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_mgrapprove_datetime) . '</td>
         </tr>

         <tr>
            <td><strong>ผลการอนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_status . '</td>
            <td><strong>เหตุผล</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_detail . '</td>
         </tr>

         <tr>
            <td colspan="4" class="bghead"><b>ผลการดำเนินงานของ CS</b></td>
         </tr>

         <tr>
            <td><strong>BR CODE</strong></td>
            <td colspan="3">' . getDataEmail($formno)->crf_brcode . '</td>
         </tr>

         <tr>
            <td><strong>ผู้บันทึก</strong></td>
            <td>' . getDataEmail($formno)->crf_brcode_userpost . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_brcode_datetime) . '</td>
         </tr>

         <tr>
            <td colspan="4" class="bghead"><b>ผลการอนุมัติของ Account Manager</b></td>
         </tr>

         <tr>
            <td><strong>ผู้อนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_accmgr_name . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_accmgr_datetime) . '</td>
         </tr>

         <tr>
            <td><strong>ผลการอนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_accmgrapprove_status . '</td>
            <td><strong>เหตุผล</strong></td>
            <td>' . getDataEmail($formno)->crf_accmgr_detail . '</td>
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



      //  Email Zone


      $posiTo = " '85' , '95' ";
      $option = getuserEmailToDirector($posiTo);


      $to = array();
      $ecodeAr = array();
      foreach ($option->result_array() as $result) {
         $to[] = $result['memberemail'];
         $ecodeAr[] = $result['ecode'];
      }
      array_push($to , "saowanit@saleecolour.com");
      array_push($ecodeAr , "M0025");

      //  $to = array(
      //      "chainarong_k@saleecolour.com",
      //  );

      $ecodecc = getDataEmail($formno)->crf_userecodepost;
      $optioncc = getuserEmailToOwner($ecodecc);

      $cc = array();
      $ecodeccAr = array();
      foreach ($optioncc->result_array() as $resultcc) {
         $cc[] = $resultcc['memberemail'];
         $ecodeccAr[] = $resultcc['ecode'];
      }

      $to = array_unique($to);
      $cc = array_unique($cc);
      $ecodeAr = array_unique($ecodeAr);
      $ecodeccAr = array_unique($ecodeccAr);

      emailSaveDataTH($subject, $body, $to, $cc);
      //  Email Zone


      // Notification center program
      $ecodeActionArr = $ecodeAr;
      $ecodeReadArr = $ecodeccAr;

      $title = "[crf] มีรายการ Credit request form ใหม่รอ Director อนุมัติ";
      $status = getDataEmail($formno)->crf_status;
      $link = base_url('main/viewdata/').getDataEmail($formno)->crf_id;
      $programname = "credit request form";

      $this->notifycenter->insertdataaction_template($ecodeActionArr , $title , $status , $link , $formno , $programname);
      $this->notifycenter->insertdataRead_template($ecodeReadArr , $title , $status , $link , $formno , $programname);

   }



   function sendemail_toDerector1type2($formno)
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


      $subject = "[crf] มีรายการ Credit request form ใหม่รอ Director อนุมัติ";

      $body = '
        <h2>รายการ Credit Request Form ใหม่รอ Director อนุมัติ</h2>
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
            <td colspan="4" class="bghead"><b>ผลการอนุมัติของ Manager</b></td>
         </tr>

         <tr>
            <td><strong>ผู้อนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_name . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_mgrapprove_datetime) . '</td>
         </tr>

         <tr>
            <td><strong>ผลการอนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_status . '</td>
            <td><strong>เหตุผล</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_detail . '</td>
         </tr>


         <tr>
            <td colspan="4" class="bghead"><b>ผลการอนุมัติของ Account Manager</b></td>
         </tr>

         <tr>
            <td><strong>ผู้อนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_accmgr_name . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_accmgr_datetime) . '</td>
         </tr>

         <tr>
            <td><strong>ผลการอนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_accmgrapprove_status . '</td>
            <td><strong>เหตุผล</strong></td>
            <td>' . getDataEmail($formno)->crf_accmgr_detail . '</td>
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



      //  Email Zone


      $posiTo = " '85' , '95' ";
      $option = getuserEmailToDirector($posiTo);


      $to = array();
      $ecodeAr = array();
      foreach ($option->result_array() as $result) {
         $to[] = $result['memberemail'];
         $ecodeAr[] = $result['ecode'];
      }
      
      array_push($to , "saowanit@saleecolour.com");
      array_push($ecodeAr , "M0025");

      $ecodecc = getDataEmail($formno)->crf_userecodepost;
      $optioncc = getuserEmailToOwner($ecodecc);

      $cc = array();
      $ecodeccAr = array();
      foreach ($optioncc->result_array() as $resultcc) {
         $cc[] = $resultcc['memberemail'];
         $ecodeccAr[] = $resultcc['ecode'];
      }

      $to = array_unique($to);
      $cc = array_unique($cc);
      $ecodeAr = array_unique($ecodeAr);
      $ecodeccAr = array_unique($ecodeccAr);

      emailSaveDataTH($subject, $body, $to, $cc);
      //  Email Zone

      // Notification center program
      $ecodeActionArr = $ecodeAr;
      $ecodeReadArr = $ecodeccAr;

      $title = "[crf] มีรายการ Credit request form ใหม่รอ Director อนุมัติ";
      $status = getDataEmail($formno)->crf_status;
      $link = base_url('main/viewdata/').getDataEmail($formno)->crf_id;
      $programname = "credit request form";

      $this->notifycenter->insertdataaction_template($ecodeActionArr , $title , $status , $link , $formno , $programname);
      $this->notifycenter->insertdataRead_template($ecodeReadArr , $title , $status , $link , $formno , $programname);

   }






   function sendemail_toDerector2($formno)
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


      $subject = "[crf] มีรายการ Credit request form ใหม่รอ Director อนุมัติ";

      $body = '
        <h2>รายการ Credit Request Form ใหม่รอ Director อนุมัติ</h2>
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
            <td colspan="4" class="bghead"><b>ผลการอนุมัติของ Manager</b></td>
         </tr>

         <tr>
            <td><strong>ผู้อนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_name . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_mgrapprove_datetime) . '</td>
         </tr>

         <tr>
            <td><strong>ผลการอนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_status . '</td>
            <td><strong>เหตุผล</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_detail . '</td>
         </tr>

         <tr>
            <td colspan="4" class="bghead"><b>ผลการดำเนินงานของ CS</b></td>
         </tr>

         <tr>
            <td><strong>BR CODE</strong></td>
            <td colspan="3">' . getDataEmail($formno)->crf_brcode . '</td>
         </tr>

         <tr>
            <td><strong>ผู้บันทึก</strong></td>
            <td>' . getDataEmail($formno)->crf_brcode_userpost . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_brcode_datetime) . '</td>
         </tr>

         <tr>
            <td colspan="4" class="bghead"><b>ผลการอนุมัติของ Account Manager</b></td>
         </tr>

         <tr>
            <td><strong>ผู้อนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_accmgr_name . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_accmgr_datetime) . '</td>
         </tr>

         <tr>
            <td><strong>ผลการอนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_accmgrapprove_status . '</td>
            <td><strong>เหตุผล</strong></td>
            <td>' . getDataEmail($formno)->crf_accmgr_detail . '</td>
         </tr>

         <tr>
            <td colspan="4" class="bghead"><b>ผลการอนุมัติของ Deputy Managing Director Sales</b></td>
         </tr>

         <tr>
            <td><strong>ผู้อนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_director_name1 . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_director_datetime1) . '</td>
         </tr>

         <tr>
            <td><strong>ผลการอนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_directorapprove_status1 . '</td>
            <td><strong>เหตุผล</strong></td>
            <td>' . getDataEmail($formno)->crf_director_detail1 . '</td>
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



      //  Email Zone


      $posiTo = " '85' , '95' ";
      $option = getuserEmailToDirector($posiTo);


      $to = array();
      $ecodeAr = array();
      foreach ($option->result_array() as $result) {
         $to[] = $result['memberemail'];
         $ecodeAr[] = $result['ecode'];
      }
      array_push($to , "mattana@saleecolour.com" , "saowanit@saleecolour.com");
      array_push($ecodeAr , "M0015" , "M0025");

      //  $to = array(
      //      "chainarong_k@saleecolour.com",
      //  );

      $ecodecc = getDataEmail($formno)->crf_userecodepost;
      $optioncc = getuserEmailToOwner($ecodecc);

      $cc = array();
      $ecodeccAr = array();
      foreach ($optioncc->result_array() as $resultcc) {
         $cc[] = $resultcc['memberemail'];
         $ecodeccAr[] = $resultcc['ecode'];
      }

      $to = array_unique($to);
      $cc = array_unique($cc);
      $ecodeAr = array_unique($ecodeAr);
      $ecodeccAr = array_unique($ecodeccAr);

      emailSaveDataTH($subject, $body, $to, $cc);
      //  Email Zone


      // Notification center program
      $ecodeActionArr = $ecodeAr;
      $ecodeReadArr = $ecodeccAr;

      $title = "[crf] มีรายการ Credit request form ใหม่รอ Director อนุมัติ";
      $status = getDataEmail($formno)->crf_status;
      $link = base_url('main/viewdata/').getDataEmail($formno)->crf_id;
      $programname = "credit request form";

      $this->notifycenter->insertdataaction_template($ecodeActionArr , $title , $status , $link , $formno , $programname);
      $this->notifycenter->insertdataRead_template($ecodeReadArr , $title , $status , $link , $formno , $programname);

   }


   function sendemail_toAccStaff($formno)
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


      $subject = "[crf] มีรายการ Credit request form ใหม่รอบันทึก Customer code";

      $body = '
        <h2>รายการ Credit Request Form ใหม่รอบันทึก Customer code</h2>
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
            <td colspan="4" class="bghead"><b>ผลการอนุมัติของ Manager</b></td>
         </tr>

         <tr>
            <td><strong>ผู้อนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_name . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_mgrapprove_datetime) . '</td>
         </tr>

         <tr>
            <td><strong>ผลการอนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_status . '</td>
            <td><strong>เหตุผล</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_detail . '</td>
         </tr>

         <tr>
            <td colspan="4" class="bghead"><b>ผลการดำเนินงานของ CS</b></td>
         </tr>

         <tr>
            <td><strong>BR CODE</strong></td>
            <td colspan="3">' . getDataEmail($formno)->crf_brcode . '</td>
         </tr>

         <tr>
            <td><strong>ผู้บันทึก</strong></td>
            <td>' . getDataEmail($formno)->crf_brcode_userpost . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_brcode_datetime) . '</td>
         </tr>

         <tr>
            <td colspan="4" class="bghead"><b>ผลการอนุมัติของ Account Manager</b></td>
         </tr>

         <tr>
            <td><strong>ผู้อนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_accmgr_name . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_accmgr_datetime) . '</td>
         </tr>

         <tr>
            <td><strong>ผลการอนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_accmgrapprove_status . '</td>
            <td><strong>เหตุผล</strong></td>
            <td>' . getDataEmail($formno)->crf_accmgr_detail . '</td>
         </tr>

         <tr>
            <td colspan="4" class="bghead"><b>ผลการอนุมัติของ First Deputy Managing Director</b></td>
         </tr>

         <tr>
            <td><strong>ผู้อนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_director_name1 . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_director_datetime1) . '</td>
         </tr>

         <tr>
            <td><strong>ผลการอนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_directorapprove_status1 . '</td>
            <td><strong>เหตุผล</strong></td>
            <td>' . getDataEmail($formno)->crf_director_detail1 . '</td>
         </tr>

         <tr>
            <td colspan="4" class="bghead"><b>ผลการอนุมัติของ Second Deputy Managing Director</b></td>
         </tr>

         <tr>
            <td><strong>ผู้อนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_director_name2 . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_director_datetime2) . '</td>
         </tr>

         <tr>
            <td><strong>ผลการอนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_directorapprove_status2 . '</td>
            <td><strong>เหตุผล</strong></td>
            <td>' . getDataEmail($formno)->crf_director_detail2 . '</td>
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



      //  Email Zone

      $ecode = " 'M1767' , 'M1260' , 'M2017' , 'M2075' , 'M2141' , 'M2217' ";
      $option = getuserEmailToAc($ecode);


      $to = array();
      $ecodeAr = array();
      foreach ($option->result_array() as $result) {
         $to[] = $result['memberemail'];
         $ecodeAr[] = $result['ecode'];
      }

      //  $to = array(
      //      "chainarong_k@saleecolour.com",
      //  );

      $ecodecc = getDataEmail($formno)->crf_userecodepost;
      $optioncc = getuserEmailToOwner($ecodecc);

      $cc = array();
      $ecodeccAr = array();
      foreach ($optioncc->result_array() as $resultcc) {
         $cc[] = $resultcc['memberemail'];
         $ecodeccAr[] = $resultcc['ecode'];
      }

      $to = array_unique($to);
      $cc = array_unique($cc);
      $ecodeAr = array_unique($ecodeAr);
      $ecodeccAr = array_unique($ecodeccAr);

      emailSaveDataTH($subject, $body, $to, $cc);
      //  Email Zone

      // Notification center program
      $ecodeActionArr = $ecodeAr;
      $ecodeReadArr = $ecodeccAr;

      $title = "[crf] มีรายการ Credit request form ใหม่รอบันทึก Customer code";
      $status = getDataEmail($formno)->crf_status;
      $link = base_url('main/viewdata/').getDataEmail($formno)->crf_id;
      $programname = "credit request form";

      $this->notifycenter->insertdataaction_template($ecodeActionArr , $title , $status , $link , $formno , $programname);
      $this->notifycenter->insertdataRead_template($ecodeReadArr , $title , $status , $link , $formno , $programname);



   }



   function sendemail_toAccStaff2($formno)
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


      $subject = "[crf] มีรายการ Credit request form ใหม่ รอฝ่ายบัญชีดำเนินการ";

      $body = '
        <h2>รายการ Credit Request Form ใหม่ รอฝ่ายบัญชีดำเนินการ</h2>
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
            <td colspan="4" class="bghead"><b>ผลการอนุมัติของ Manager</b></td>
         </tr>

         <tr>
            <td><strong>ผู้อนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_name . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_mgrapprove_datetime) . '</td>
         </tr>

         <tr>
            <td><strong>ผลการอนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_status . '</td>
            <td><strong>เหตุผล</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_detail . '</td>
         </tr>


         <tr>
            <td colspan="4" class="bghead"><b>ผลการอนุมัติของ Account Manager</b></td>
         </tr>

         <tr>
            <td><strong>ผู้อนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_accmgr_name . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_accmgr_datetime) . '</td>
         </tr>

         <tr>
            <td><strong>ผลการอนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_accmgrapprove_status . '</td>
            <td><strong>เหตุผล</strong></td>
            <td>' . getDataEmail($formno)->crf_accmgr_detail . '</td>
         </tr>

         <tr>
            <td colspan="4" class="bghead"><b>ผลการอนุมัติของ First Deputy Managing Director</b></td>
         </tr>

         <tr>
            <td><strong>ผู้อนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_director_name1 . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_director_datetime1) . '</td>
         </tr>

         <tr>
            <td><strong>ผลการอนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_directorapprove_status1 . '</td>
            <td><strong>เหตุผล</strong></td>
            <td>' . getDataEmail($formno)->crf_director_detail1 . '</td>
         </tr>

         <tr>
            <td colspan="4" class="bghead"><b>ผลการอนุมัติของ Second Deputy Managing Director</b></td>
         </tr>

         <tr>
            <td><strong>ผู้อนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_director_name2 . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_director_datetime2) . '</td>
         </tr>

         <tr>
            <td><strong>ผลการอนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_directorapprove_status2 . '</td>
            <td><strong>เหตุผล</strong></td>
            <td>' . getDataEmail($formno)->crf_director_detail2 . '</td>
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



      //  Email Zone

      $ecode = " 'M1767' , 'M1260' , 'M2017' , 'M2075' , 'M2141' , 'M2217' ";
      $option = getuserEmailToCs($ecode);


      $to = array();
      $ecodeAr = array();
      foreach ($option->result_array() as $result) {
         $to[] = $result['memberemail'];
         $ecodeAr[] = $result['ecode'];
      }

      //  $to = array(
      //      "chainarong_k@saleecolour.com",
      //  );

      $ecodecc = getDataEmail($formno)->crf_userecodepost;
      $optioncc = getuserEmailToOwner($ecodecc);

      $cc = array();
      $ecodeccAr = array();
      foreach ($optioncc->result_array() as $resultcc) {
         $cc[] = $resultcc['memberemail'];
         $ecodeccAr[] = $resultcc['ecode'];
      }

      $to = array_unique($to);
      $cc = array_unique($cc);
      $ecodeAr = array_unique($ecodeAr);
      $ecodeccAr = array_unique($ecodeccAr);

      emailSaveDataTH($subject, $body, $to, $cc);
      //  Email Zone


      // Notification center program
      $ecodeActionArr = $ecodeAr;
      $ecodeReadArr = $ecodeccAr;

      $title = "[crf] มีรายการ Credit request form ใหม่ รอฝ่ายบัญชีดำเนินการ";
      $status = getDataEmail($formno)->crf_status;
      $link = base_url('main/viewdata/').getDataEmail($formno)->crf_id;
      $programname = "credit request form";

      $this->notifycenter->insertdataaction_template($ecodeActionArr , $title , $status , $link , $formno , $programname);
      $this->notifycenter->insertdataRead_template($ecodeReadArr , $title , $status , $link , $formno , $programname);

   }




   function sendemail_toAccStaff3($formno)
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


      $subject = "[crf] มีรายการ Credit request form ใหม่ รอฝ่ายบัญชีดำเนินการ";

      $body = '
        <h2>รายการ Credit Request Form ใหม่ รอฝ่ายบัญชีดำเนินการ</h2>
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
            <td colspan="4" class="bghead"><b>ผลการอนุมัติของ Manager</b></td>
         </tr>

         <tr>
            <td><strong>ผู้อนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_name . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_mgrapprove_datetime) . '</td>
         </tr>

         <tr>
            <td><strong>ผลการอนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_status . '</td>
            <td><strong>เหตุผล</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_detail . '</td>
         </tr>


         <tr>
            <td colspan="4" class="bghead"><b>ผลการอนุมัติของ Account Manager</b></td>
         </tr>

         <tr>
            <td><strong>ผู้อนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_accmgr_name . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_accmgr_datetime) . '</td>
         </tr>

         <tr>
            <td><strong>ผลการอนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_accmgrapprove_status . '</td>
            <td><strong>เหตุผล</strong></td>
            <td>' . getDataEmail($formno)->crf_accmgr_detail . '</td>
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



      //  Email Zone

      $ecode = " 'M1767' , 'M1260' , 'M2017' , 'M2075' , 'M2141' , 'M2217' ";
      $option = getuserEmailToCs($ecode);


      $to = array();
      $ecodeAr = array();
      foreach ($option->result_array() as $result) {
         $to[] = $result['memberemail'];
         $ecodeAr[] = $result['ecode'];
      }

      //  $to = array(
      //      "chainarong_k@saleecolour.com",
      //  );

      $ecodecc = getDataEmail($formno)->crf_userecodepost;
      $optioncc = getuserEmailToOwner($ecodecc);


      $cc = array();
      $ecodeccAr = array();
      foreach ($optioncc->result_array() as $resultcc) {
         $cc[] = $resultcc['memberemail'];
         $ecodeccAr[] = $resultcc['ecode'];
      }


      $to = array_unique($to);
      $cc = array_unique($cc);
      $ecodeAr = array_unique($ecodeAr);
      $ecodeccAr = array_unique($ecodeccAr);

      emailSaveDataTH($subject, $body, $to, $cc);
      //  Email Zone


      // Notification center program
      $ecodeActionArr = $ecodeAr;
      $ecodeReadArr = $ecodeccAr;

      $title = "[crf] มีรายการ Credit request form ใหม่ รอฝ่ายบัญชีดำเนินการ";
      $status = getDataEmail($formno)->crf_status;
      $link = base_url('main/viewdata/').getDataEmail($formno)->crf_id;
      $programname = "credit request form";

      $this->notifycenter->insertdataaction_template($ecodeActionArr , $title , $status , $link , $formno , $programname);
      $this->notifycenter->insertdataRead_template($ecodeReadArr , $title , $status , $link , $formno , $programname);

   }


   function sendemail_toOwner($formno)
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


      $subject = "[crf]รายการ Credit request form ที่ร้องขอดำเนินการเสร็จสิ้น";

      $body = '
        <h2>รายการ Credit request form ที่ร้องขอดำเนินการเสร็จสิ้น</h2>
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
            <td colspan="4" class="bghead"><b>ผลการอนุมัติของ Manager</b></td>
         </tr>

         <tr>
            <td><strong>ผู้อนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_name . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_mgrapprove_datetime) . '</td>
         </tr>

         <tr>
            <td><strong>ผลการอนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_status . '</td>
            <td><strong>เหตุผล</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_detail . '</td>
         </tr>

         <tr>
            <td colspan="4" class="bghead"><b>ผลการดำเนินงานของ CS</b></td>
         </tr>

         
         <tr>
            <td><strong>BR CODE</strong></td>
            <td colspan="3">' . getDataEmail($formno)->crf_brcode . '</td>
         </tr>

         <tr>
            <td><strong>ผู้บันทึก</strong></td>
            <td>' . getDataEmail($formno)->crf_brcode_userpost . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_brcode_datetime) . '</td>
         </tr>


         <tr>
            <td colspan="4" class="bghead"><b>ผลการอนุมัติของ Account Manager</b></td>
         </tr>

         <tr>
            <td><strong>ผู้อนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_accmgr_name . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_accmgr_datetime) . '</td>
         </tr>

         <tr>
            <td><strong>ผลการอนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_accmgrapprove_status . '</td>
            <td><strong>เหตุผล</strong></td>
            <td>' . getDataEmail($formno)->crf_accmgr_detail . '</td>
         </tr>

         <tr>
            <td colspan="4" class="bghead"><b>ผลการอนุมัติของ First Deputy Managing Director</b></td>
         </tr>

         <tr>
            <td><strong>ผู้อนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_director_name1 . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_director_datetime1) . '</td>
         </tr>

         <tr>
            <td><strong>ผลการอนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_directorapprove_status1 . '</td>
            <td><strong>เหตุผล</strong></td>
            <td>' . getDataEmail($formno)->crf_director_detail1 . '</td>
         </tr>

         <tr>
            <td colspan="4" class="bghead"><b>ผลการอนุมัติของ Second Deputy Managing Director</b></td>
         </tr>

         <tr>
            <td><strong>ผู้อนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_director_name2 . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_director_datetime2) . '</td>
         </tr>

         <tr>
            <td><strong>ผลการอนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_directorapprove_status2 . '</td>
            <td><strong>เหตุผล</strong></td>
            <td>' . getDataEmail($formno)->crf_director_detail2 . '</td>
         </tr>


         <tr>
            <td colspan="4" class="bghead"><b>ผลการดำเนินงานของฝ่ายบัญชี</b></td>
         </tr>

         
         <tr>
            <td><strong>CUSTOMER CODE</strong></td>
            <td colspan="3">' . getDataEmail($formno)->crf_savecustomercode . '</td>
         </tr>

         <tr>
            <td><strong>ผู้บันทึก</strong></td>
            <td>' . getDataEmail($formno)->crf_usersave_customercode . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_datetimesave_customercode) . '</td>
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



      //  Email Zone

      $ecode = getDataEmail($formno)->crf_userecodepost;
      $option = getuserEmailToOwner($ecode);


      $to = array();
      $ecodeAr = array();
      foreach ($option->result_array() as $result) {
         $to[] = $result['memberemail'];
         $ecodeAr[] = $result['ecode'];
      }

      //  $to = array(
      //      "chainarong_k@saleecolour.com",
      //  );

      $deptcode = getDataEmail($formno)->crf_userdeptcodepost;
      $option_cc = getuserEmailccOwner($deptcode);
      $cc = array();
      foreach ($option_cc->result_array() as $result_cc) {
         $cc[] = $result_cc['memberemail'];
      }

      $to = array_unique($to);
      $cc = array_unique($cc);
      $ecodeAr = array_unique($ecodeAr);

      emailSaveDataTH($subject, $body, $to, $cc);
      //  Email Zone


      // Notification center program
      $ecodeReadArr = $ecodeAr;

      $title = "[crf]รายการ Credit request form ที่ร้องขอดำเนินการเสร็จสิ้น";
      $status = getDataEmail($formno)->crf_status;
      $link = base_url('main/viewdata/').getDataEmail($formno)->crf_id;
      $programname = "credit request form";

      $this->notifycenter->insertdataRead_template($ecodeReadArr , $title , $status , $link , $formno , $programname);

   }


   function sendemail_toOwnerType2($formno)
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


      $subject = "[crf]รายการ Credit request form ที่ร้องขอดำเนินการเสร็จสิ้น";

      $body = '
        <h2>รายการ Credit request form ที่ร้องขอดำเนินการเสร็จสิ้น</h2>
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
            <td colspan="4" class="bghead"><b>ผลการอนุมัติของ Manager</b></td>
         </tr>

         <tr>
            <td><strong>ผู้อนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_name . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_mgrapprove_datetime) . '</td>
         </tr>

         <tr>
            <td><strong>ผลการอนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_status . '</td>
            <td><strong>เหตุผล</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_detail . '</td>
         </tr>


         <tr>
            <td colspan="4" class="bghead"><b>ผลการอนุมัติของ Account Manager</b></td>
         </tr>

         <tr>
            <td><strong>ผู้อนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_accmgr_name . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_accmgr_datetime) . '</td>
         </tr>

         <tr>
            <td><strong>ผลการอนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_accmgrapprove_status . '</td>
            <td><strong>เหตุผล</strong></td>
            <td>' . getDataEmail($formno)->crf_accmgr_detail . '</td>
         </tr>

         <tr>
            <td colspan="4" class="bghead"><b>ผลการอนุมัติของ First Deputy Managing Director</b></td>
         </tr>

         <tr>
            <td><strong>ผู้อนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_director_name1 . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_director_datetime1) . '</td>
         </tr>

         <tr>
            <td><strong>ผลการอนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_directorapprove_status1 . '</td>
            <td><strong>เหตุผล</strong></td>
            <td>' . getDataEmail($formno)->crf_director_detail1 . '</td>
         </tr>

         <tr>
            <td colspan="4" class="bghead"><b>ผลการอนุมัติของ Second Deputy Managing Director</b></td>
         </tr>

         <tr>
            <td><strong>ผู้อนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_director_name2 . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_director_datetime2) . '</td>
         </tr>

         <tr>
            <td><strong>ผลการอนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_directorapprove_status2 . '</td>
            <td><strong>เหตุผล</strong></td>
            <td>' . getDataEmail($formno)->crf_director_detail2 . '</td>
         </tr>

         <tr>
            <td colspan="4" class="bghead"><b>ผลการดำเนินงานของฝ่ายบัญชี</b></td>
         </tr>

         
         <tr>
            <td><strong>ผลการดำเนินงาน</strong></td>
            <td colspan="3">' . getDataEmail($formno)->crf_memo_customercode . '</td>
         </tr>

         <tr>
            <td><strong>ผู้บันทึก</strong></td>
            <td>' . getDataEmail($formno)->crf_usersave_customercode . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_datetimesave_customercode) . '</td>
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



      //  Email Zone

      $ecode = getDataEmail($formno)->crf_userecodepost;
      $option = getuserEmailToOwner($ecode);


      $to = array();
      $ecodeAr = array();
      foreach ($option->result_array() as $result) {
         $to[] = $result['memberemail'];
         $ecodeAr[] = $result['ecode'];
      }

      //  $to = array(
      //      "chainarong_k@saleecolour.com",
      //  );

      $deptcode = getDataEmail($formno)->crf_userdeptcodepost;
      $option_cc = getuserEmailccOwner($deptcode);
      $cc = array();
      foreach ($option_cc->result_array() as $result_cc) {
         $cc[] = $result_cc['memberemail'];
      }

      $to = array_unique($to);
      $cc = array_unique($cc);
      $ecodeAr = array_unique($ecodeAr);

      emailSaveDataTH($subject, $body, $to, $cc);
      //  Email Zone


      // Notification center program
      $ecodeReadArr = $ecodeAr;

      $title = "[crf]รายการ Credit request form ที่ร้องขอดำเนินการเสร็จสิ้น";
      $status = getDataEmail($formno)->crf_status;
      $link = base_url('main/viewdata/').getDataEmail($formno)->crf_id;
      $programname = "credit request form";

      $this->notifycenter->insertdataRead_template($ecodeReadArr , $title , $status , $link , $formno , $programname);

   }




   function sendemail_toOwnerType3($formno)
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


      $subject = "[crf]รายการ Credit request form ที่ร้องขอดำเนินการเสร็จสิ้น";

      $body = '
        <h2>รายการ Credit request form ที่ร้องขอดำเนินการเสร็จสิ้น</h2>
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
            <td colspan="4" class="bghead"><b>ผลการอนุมัติของ Manager</b></td>
         </tr>

         <tr>
            <td><strong>ผู้อนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_name . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_mgrapprove_datetime) . '</td>
         </tr>

         <tr>
            <td><strong>ผลการอนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_status . '</td>
            <td><strong>เหตุผล</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_detail . '</td>
         </tr>


         <tr>
            <td colspan="4" class="bghead"><b>ผลการอนุมัติของ Account Manager</b></td>
         </tr>

         <tr>
            <td><strong>ผู้อนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_accmgr_name . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_accmgr_datetime) . '</td>
         </tr>

         <tr>
            <td><strong>ผลการอนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_accmgrapprove_status . '</td>
            <td><strong>เหตุผล</strong></td>
            <td>' . getDataEmail($formno)->crf_accmgr_detail . '</td>
         </tr>


         <tr>
            <td colspan="4" class="bghead"><b>ผลการดำเนินงานของฝ่ายบัญชี</b></td>
         </tr>

         
         <tr>
            <td><strong>ผลการดำเนินงาน</strong></td>
            <td colspan="3">' . getDataEmail($formno)->crf_memo_customercode . '</td>
         </tr>

         <tr>
            <td><strong>ผู้บันทึก</strong></td>
            <td>' . getDataEmail($formno)->crf_usersave_customercode . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_datetimesave_customercode) . '</td>
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



      //  Email Zone

      $ecode = getDataEmail($formno)->crf_userecodepost;
      $option = getuserEmailToOwner($ecode);


      $to = array();
      $ecodeAr = array();
      foreach ($option->result_array() as $result) {
         $to[] = $result['memberemail'];
         $ecodeAr[] = $result['ecode'];
      }

      //  $to = array(
      //      "chainarong_k@saleecolour.com",
      //  );

      $deptcode = getDataEmail($formno)->crf_userdeptcodepost;
      $option_cc = getuserEmailccOwner($deptcode);
      $cc = array();
      foreach ($option_cc->result_array() as $result_cc) {
         $cc[] = $result_cc['memberemail'];
      }

      $to = array_unique($to);
      $cc = array_unique($cc);
      $ecodeAr = array_unique($ecodeAr);

      emailSaveDataTH($subject, $body, $to, $cc);
      //  Email Zone

      // Notification center program
      $ecodeReadArr = $ecodeAr;

      $title = "[crf]รายการ Credit request form ที่ร้องขอดำเนินการเสร็จสิ้น";
      $status = getDataEmail($formno)->crf_status;
      $link = base_url('main/viewdata/').getDataEmail($formno)->crf_id;
      $programname = "credit request form";

      $this->notifycenter->insertdataRead_template($ecodeReadArr , $title , $status , $link , $formno , $programname);

   }


 //Manager not approve
   function sendemail_InMgrNotApprove($formno)
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


      $subject = "[crf]ผู้จัดการฝ่ายไม่อนุมัติ รายการที่ร้องขอ";

      $body = '
        <h2>ผู้จัดการฝ่ายไม่อนุมัติ รายการที่ร้องขอ</h2>
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
            <td colspan="4" class="bghead"><b>ผลการอนุมัติของ Manager</b></td>
         </tr>

         <tr>
            <td><strong>ผู้อนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_name . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_mgrapprove_datetime) . '</td>
         </tr>

         <tr>
            <td><strong>ผลการอนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_status . '</td>
            <td><strong>เหตุผล</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_detail . '</td>
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



      //  Email Zone

      $ecode = getDataEmail($formno)->crf_userecodepost;
      $option = getuserEmailToOwner($ecode);


      $to = array();
      $ecodeAr = array();
      foreach ($option->result_array() as $result) {
         $to[] = $result['memberemail'];
         $ecodeAr[] = $result['ecode'];
      }

      //  $to = array(
      //      "chainarong_k@saleecolour.com",
      //  );

      $deptcode = getDataEmail($formno)->crf_userdeptcodepost;
      $option_cc = getuserEmailccOwner($deptcode);
      $cc = array();
      foreach ($option_cc->result_array() as $result_cc) {
         $cc[] = $result_cc['memberemail'];
      }

      $to = array_unique($to);
      $cc = array_unique($cc);
      $ecodeAr = array_unique($ecodeAr);

      emailSaveDataTH($subject, $body, $to, $cc);
      //  Email Zone

      $ecodeReadArr = $ecodeAr;

      $title = "[crf]ผู้จัดการฝ่ายไม่อนุมัติ รายการที่ร้องขอ";
      $status = getDataEmail($formno)->crf_status;
      $link = base_url('main/viewdata/').getDataEmail($formno)->crf_id;
      $programname = "credit request form";

      $this->notifycenter->insertdataRead_template($ecodeReadArr , $title , $status , $link , $formno , $programname);

   }
   //Manager not approve






//Account Manager not approve
   function sendemail_InAccMgrNotApprove($formno)
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


      $subject = "[crf]ผู้จัดการฝ่ายบัญชี ไม่อนุมัติ รายการที่ร้องขอ";

      $body = '
        <h2>ผู้จัดการฝ่ายบัญชี ไม่อนุมัติ รายการที่ร้องขอ</h2>
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
            <td colspan="4" class="bghead"><b>ผลการอนุมัติของ Manager</b></td>
         </tr>

         <tr>
            <td><strong>ผู้อนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_name . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_mgrapprove_datetime) . '</td>
         </tr>

         <tr>
            <td><strong>ผลการอนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_status . '</td>
            <td><strong>เหตุผล</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_detail . '</td>
         </tr>


         <tr>
         <td colspan="4" class="bghead"><b>ผลการอนุมัติของ Account Manager</b></td>
      </tr>

      <tr>
         <td><strong>ผู้อนุมัติ</strong></td>
         <td>' . getDataEmail($formno)->crf_accmgr_name . '</td>
         <td><strong>วันที่</strong></td>
         <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_accmgr_datetime) . '</td>
      </tr>

      <tr>
         <td><strong>ผลการอนุมัติ</strong></td>
         <td>' . getDataEmail($formno)->crf_accmgrapprove_status . '</td>
         <td><strong>เหตุผล</strong></td>
         <td>' . getDataEmail($formno)->crf_accmgr_detail . '</td>
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



      //  Email Zone

      $ecode = getDataEmail($formno)->crf_userecodepost;
      $option = getuserEmailToOwner($ecode);


      $to = array();
      $ecodeAr = array();
      foreach ($option->result_array() as $result) {
         $to[] = $result['memberemail'];
         $ecodeAr[] = $result['ecode'];
      }

      //  $to = array(
      //      "chainarong_k@saleecolour.com",
      //  );

      $deptcode = getDataEmail($formno)->crf_userdeptcodepost;
      $option_cc = getuserEmailccOwner($deptcode);
      $cc = array();
      foreach ($option_cc->result_array() as $result_cc) {
         $cc[] = $result_cc['memberemail'];
      }

      $to = array_unique($to);
      $cc = array_unique($cc);
      $ecodeAr = array_unique($ecodeAr);

      emailSaveDataTH($subject, $body, $to, $cc);
      //  Email Zone

      $ecodeReadArr = $ecodeAr;
      $title = "[crf]ผู้จัดการฝ่ายบัญชี ไม่อนุมัติ รายการที่ร้องขอ";
      $status = getDataEmail($formno)->crf_status;
      $link = base_url('main/viewdata/').getDataEmail($formno)->crf_id;
      $programname = "credit request form";
      $this->notifycenter->insertdataRead_template($ecodeReadArr , $title , $status , $link , $formno , $programname);

   }
   //Account Manager not approve






//Director not approve
   function sendemail_InDirectorNotApprove($formno)
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


      $subject = "[crf]ผู้บริหารระดับสูง ไม่อนุมัติ รายการที่ร้องขอ";

      $body = '
        <h2>ผู้บริหารระดับสูง ไม่อนุมัติ รายการที่ร้องขอ</h2>
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
            <td colspan="4" class="bghead"><b>ผลการอนุมัติของ Manager</b></td>
         </tr>

         <tr>
            <td><strong>ผู้อนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_name . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_mgrapprove_datetime) . '</td>
         </tr>

         <tr>
            <td><strong>ผลการอนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_status . '</td>
            <td><strong>เหตุผล</strong></td>
            <td>' . getDataEmail($formno)->crf_mgrapprove_detail . '</td>
         </tr>


         <tr>
         <td colspan="4" class="bghead"><b>ผลการอนุมัติของ Account Manager</b></td>
      </tr>

      <tr>
         <td><strong>ผู้อนุมัติ</strong></td>
         <td>' . getDataEmail($formno)->crf_accmgr_name . '</td>
         <td><strong>วันที่</strong></td>
         <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_accmgr_datetime) . '</td>
      </tr>

      <tr>
         <td><strong>ผลการอนุมัติ</strong></td>
         <td>' . getDataEmail($formno)->crf_accmgrapprove_status . '</td>
         <td><strong>เหตุผล</strong></td>
         <td>' . getDataEmail($formno)->crf_accmgr_detail . '</td>
      </tr>


      <tr>
            <td colspan="4" class="bghead"><b>ผลการอนุมัติของ First Deputy Managing Director</b></td>
         </tr>

         <tr>
            <td><strong>ผู้อนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_director_name1 . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_director_datetime1) . '</td>
         </tr>

         <tr>
            <td><strong>ผลการอนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_directorapprove_status1 . '</td>
            <td><strong>เหตุผล</strong></td>
            <td>' . getDataEmail($formno)->crf_director_detail1 . '</td>
         </tr>

         <tr>
            <td colspan="4" class="bghead"><b>ผลการอนุมัติของ Second Deputy Managing Director</b></td>
         </tr>

         <tr>
            <td><strong>ผู้อนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_director_name2 . '</td>
            <td><strong>วันที่</strong></td>
            <td>' . conDateTimeFromDb(getDataEmail($formno)->crf_director_datetime2) . '</td>
         </tr>

         <tr>
            <td><strong>ผลการอนุมัติ</strong></td>
            <td>' . getDataEmail($formno)->crf_directorapprove_status2 . '</td>
            <td><strong>เหตุผล</strong></td>
            <td>' . getDataEmail($formno)->crf_director_detail2 . '</td>
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



      //  Email Zone

      $ecode = getDataEmail($formno)->crf_userecodepost;
      $option = getuserEmailToOwner($ecode);


      $to = array();
      $ecodeAr = array();
      foreach ($option->result_array() as $result) {
         $to[] = $result['memberemail'];
         $ecodeAr[] = $result['ecode'];
      }

      //  $to = array(
      //      "chainarong_k@saleecolour.com",
      //  );

      $deptcode = getDataEmail($formno)->crf_userdeptcodepost;
      $option_cc = getuserEmailccOwner($deptcode);
      $cc = array();
      foreach ($option_cc->result_array() as $result_cc) {
         $cc[] = $result_cc['memberemail'];
      }

      $to = array_unique($to);
      $cc = array_unique($cc);
      $ecodeAr = array_unique($ecodeAr);

      emailSaveDataTH($subject, $body, $to, $cc);
      //  Email Zone

      $ecodeReadArr = $ecodeAr;
      $title = "[crf]ผู้บริหารระดับสูง ไม่อนุมัติ รายการที่ร้องขอ";
      $status = getDataEmail($formno)->crf_status;
      $link = base_url('main/viewdata/').getDataEmail($formno)->crf_id;
      $programname = "credit request form";
      $this->notifycenter->insertdataRead_template($ecodeReadArr , $title , $status , $link , $formno , $programname);

   }
   //Director not approve











   // Export zone Export zone Export zone Export zone Export zone Export zone
   // Export zone Export zone Export zone Export zone Export zone Export zone
   function sendemail_savedataEx($formno)
   {

      $topicEX = getDataEmailEx($formno)->crfex_topic;
      if (getDataEmailEx($formno)->crfex_curcustopic1 != '') {
         $topicEX .= " / " . getDataEmailEx($formno)->crfex_curcustopic1;
      }
      if (getDataEmailEx($formno)->crfex_curcustopic2 != '') {
         $topicEX .= " / " . getDataEmailEx($formno)->crfex_curcustopic2;
      }

      $short_urlex = base_url('qrcodeex/') . getDataEmailEx($formno)->crfex_id;
      // $short_urlex = shorturl($longurlex);


      $subject = "[crf export] You have credit request form waiting for approve";

      $body = '
        <h2>You have credit request form waiting for approve</h2>
        <table>
         <tr>
            <td><strong>Form no.</strong></td>
            <td>' . getDataEmailEx($formno)->crfexcus_formno . '</td>
            <td><strong>Date create.</strong></td>
            <td>' . conDateFromDb(getDataEmailEx($formno)->crfex_datecreate) . '</td>
         </tr>

         <tr>
            <td><strong>Customer type.</strong></td>
            <td>' . getDataEmailEx($formno)->crf_alltype_subnameEN . '</td>
            <td><strong>Status.</strong></td>
            <td>' . getDataEmailEx($formno)->crfex_status . '</td>
         </tr>

         <tr>
            <td><strong>Topic</strong></td>
            <td colspan="3">' . $topicEX . '</td>
         </tr>

         <tr>
            <td><strong>Customer name.</strong></td>
            <td>' . getDataEmailEx($formno)->crfexcus_nameEN . '</td>
            <td><strong>Sales reps</strong></td>
            <td>' . getDataEmailEx($formno)->crfexcus_salesreps . '</td>
         </tr>

         <tr>
            <td><strong>User post.</strong></td>
            <td>' . getDataEmailEx($formno)->crfex_userpost . '</td>
            <td><strong>User Dept.</strong></td>
            <td>' . getDataEmailEx($formno)->crfex_userdept . '</td>
         </tr>

         <tr>
            <td><strong>User code.</strong></td>
            <td>' . getDataEmailEx($formno)->crfexcus_userecode . '</td>
            <td><strong>Date.</strong></td>
            <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_userdatetime) . '</td>
         </tr>

         <tr>
            <td><strong>Go to form.</strong></td>
            <td colspan="3"><a href="' . base_url('main/viewdataEx/') . getDataEmailEx($formno)->crfex_id . '">' . getDataEmailEx($formno)->crfexcus_formno . '</a></td>
         </tr>

         <tr>
            <td><strong>Scan QrCode</strong></td>
            <td colspan="3"><img src="' . base_url('upload/qrcode/') . $this->createQrcode($short_urlex,getDataEmailEx($formno)->crfex_id) . '"></td>
         </tr>

         </table>
         ';



      //  Email Zone
      $ecode = " 'M0025' ";

      $option = getuserEmailToCs($ecode);


      $to = array();
      $ecodeAr = array();
      foreach ($option->result_array() as $result) {
         $to[] = $result['memberemail'];
         $ecodeAr[] = $result['ecode'];
      }

      //  $cc = array(
      //      "",
      //  );

      $ecodecc = getDataEmailEx($formno)->crfexcus_userecode;
      $optioncc = getuserEmailToOwner($ecodecc);

      $cc = array();
      $ecodeccAr = array();
      foreach ($optioncc->result_array() as $resultcc) {
         $cc[] = $resultcc['memberemail'];
         $ecodeccAr[] = $resultcc['ecode'];
      }

      $to = array_unique($to);
      $cc = array_unique($cc);
      $ecodeAr = array_unique($ecodeAr);
      $ecodeccAr = array_unique($ecodeccAr);

      emailSaveDataTH($subject, $body, $to, $cc);
      //  Email Zone

      // Notification center program
      $ecodeActionArr = $ecodeAr;
      $ecodeReadArr = $ecodeccAr;

      $title = "[crf export] You have credit request form waiting for approve";
      $status = getDataEmailEx($formno)->crfex_status;
      $link = base_url('main/viewdataEx/').getDataEmailEx($formno)->crfex_id;
      $programname = "credit request form";

      $this->notifycenter->insertdataaction_template($ecodeActionArr , $title , $status , $link , $formno , $programname);
      $this->notifycenter->insertdataRead_template($ecodeReadArr , $title , $status , $link , $formno , $programname);
   }
   //End Step 1


   //End Step 2
   function sendemail_toCsEx($formno)
   {

      $topicEX = getDataEmailEx($formno)->crfex_topic;
      if (getDataEmailEx($formno)->crfex_curcustopic1 != '') {
         $topicEX .= " / " . getDataEmailEx($formno)->crfex_curcustopic1;
      }
      if (getDataEmailEx($formno)->crfex_curcustopic2 != '') {
         $topicEX .= " / " . getDataEmailEx($formno)->crfex_curcustopic2;
      }

      $short_urlex = base_url('qrcodeex/') . getDataEmailEx($formno)->crfex_id;
      // $short_urlex = shorturl($longurlex);


      $subject = "[crf export] You have credit request form waiting for Add BR CODE";

      $body = '
        <h2>You have credit request form waiting for Add BR CODE</h2>
        <table>
         <tr>
            <td><strong>Form no.</strong></td>
            <td>' . getDataEmailEx($formno)->crfexcus_formno . '</td>
            <td><strong>Date create.</strong></td>
            <td>' . conDateFromDb(getDataEmailEx($formno)->crfex_datecreate) . '</td>
         </tr>

         <tr>
            <td><strong>Customer type.</strong></td>
            <td>' . getDataEmailEx($formno)->crf_alltype_subnameEN . '</td>
            <td><strong>Status.</strong></td>
            <td>' . getDataEmailEx($formno)->crfex_status . '</td>
         </tr>

         <tr>
            <td><strong>Topic</strong></td>
            <td colspan="3">' . $topicEX . '</td>
         </tr>

         <tr>
            <td><strong>Customer name.</strong></td>
            <td>' . getDataEmailEx($formno)->crfexcus_nameEN . '</td>
            <td><strong>Sales reps</strong></td>
            <td>' . getDataEmailEx($formno)->crfexcus_salesreps . '</td>
         </tr>

         <tr>
            <td><strong>User post.</strong></td>
            <td>' . getDataEmailEx($formno)->crfex_userpost . '</td>
            <td><strong>User Dept.</strong></td>
            <td>' . getDataEmailEx($formno)->crfex_userdept . '</td>
         </tr>

         <tr>
            <td><strong>User code.</strong></td>
            <td>' . getDataEmailEx($formno)->crfexcus_userecode . '</td>
            <td><strong>Date.</strong></td>
            <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_userdatetime) . '</td>
         </tr>

         <tr>
            <td colspan="4" class="bghead"><b>Manager Approval results.</b></td>
         </tr>

         <tr>
            <td><strong>Manager name.</strong></td>
            <td>' . getDataEmailEx($formno)->crfex_mgrapp_username . '</td>
            <td><strong>Date</strong></td>
            <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_mgrapp_datetime) . '</td>
         </tr>

         <tr>
            <td><strong>Status</strong></td>
            <td>' . getDataEmailEx($formno)->crfex_mgrapp_status . '</td>
            <td><strong>Reason</strong></td>
            <td>' . getDataEmailEx($formno)->crfex_mgrapp_detail . '</td>
         </tr>

         <tr>
            <td><strong>Go to form.</strong></td>
            <td colspan="3"><a href="' . base_url('main/viewdataEx/') . getDataEmailEx($formno)->crfex_id . '">' . getDataEmailEx($formno)->crfexcus_formno . '</a></td>
         </tr>

         <tr>
            <td><strong>Scan QrCode</strong></td>
            <td colspan="3"><img src="' . base_url('upload/qrcode/') . $this->createQrcode($short_urlex,getDataEmailEx($formno)->crfex_id) . '"></td>
         </tr>

         </table>
         ';



      //  Email Zone
      $ecode = " 'M0019' , 'M1508' , 'M0254' ";

      $option = getuserEmailToCs($ecode);


      $to = array();
      $ecodeAr = array();
      foreach ($option->result_array() as $result) {
         $to[] = $result['memberemail'];
         $ecodeAr[] = $result['ecode'];
      }

      //  $to = array(
      //      "chainarong_k@saleecolour.com",
      //  );

      $ecodecc = getDataEmailEx($formno)->crfexcus_userecode;
      $optioncc = getuserEmailToOwner($ecodecc);

      $cc = array();
      $ecodeccAr = array();
      foreach ($optioncc->result_array() as $resultcc) {
         $cc[] = $resultcc['memberemail'];
         $ecodeccAr[] = $resultcc['ecode'];
      }

      $to = array_unique($to);
      $cc = array_unique($cc);
      $ecodeAr = array_unique($ecodeAr);
      $ecodeccAr = array_unique($ecodeccAr);

      emailSaveDataTH($subject, $body, $to, $cc);
      //  Email Zone

      // Notification center program
      $ecodeActionArr = $ecodeAr;
      $ecodeReadArr = $ecodeccAr;

      $title = "[crf export] You have credit request form waiting for Add BR CODE";
      $status = getDataEmailEx($formno)->crfex_status;
      $link = base_url('main/viewdataEx/').getDataEmailEx($formno)->crfex_id;
      $programname = "credit request form";

      $this->notifycenter->insertdataaction_template($ecodeActionArr , $title , $status , $link , $formno , $programname);
      $this->notifycenter->insertdataRead_template($ecodeReadArr , $title , $status , $link , $formno , $programname);
   }
   //End Step 2


   //End Step 3
   function sendemail_toAccMgrEx($formno)
   {

      $topicEX = getDataEmailEx($formno)->crfex_topic;
      if (getDataEmailEx($formno)->crfex_curcustopic1 != '') {
         $topicEX .= " / " . getDataEmailEx($formno)->crfex_curcustopic1;
      }
      if (getDataEmailEx($formno)->crfex_curcustopic2 != '') {
         $topicEX .= " / " . getDataEmailEx($formno)->crfex_curcustopic2;
      }

      $short_urlex = base_url('qrcodeex/') . getDataEmailEx($formno)->crfex_id;
      // $short_urlex = shorturl($longurlex);


      $subject = "[crf export] You have credit request form waiting for approve.";

      $body = '
        <h2>You have credit request form waiting for approve.</h2>
        <table>
         <tr>
            <td><strong>Form no.</strong></td>
            <td>' . getDataEmailEx($formno)->crfexcus_formno . '</td>
            <td><strong>Date create.</strong></td>
            <td>' . conDateFromDb(getDataEmailEx($formno)->crfex_datecreate) . '</td>
         </tr>

         <tr>
            <td><strong>Customer type.</strong></td>
            <td>' . getDataEmailEx($formno)->crf_alltype_subnameEN . '</td>
            <td><strong>Status.</strong></td>
            <td>' . getDataEmailEx($formno)->crfex_status . '</td>
         </tr>

         <tr>
            <td><strong>Topic</strong></td>
            <td colspan="3">' . $topicEX . '</td>
         </tr>

         <tr>
            <td><strong>Customer name.</strong></td>
            <td>' . getDataEmailEx($formno)->crfexcus_nameEN . '</td>
            <td><strong>Sales reps</strong></td>
            <td>' . getDataEmailEx($formno)->crfexcus_salesreps . '</td>
         </tr>

         <tr>
            <td><strong>User post.</strong></td>
            <td>' . getDataEmailEx($formno)->crfex_userpost . '</td>
            <td><strong>User Dept.</strong></td>
            <td>' . getDataEmailEx($formno)->crfex_userdept . '</td>
         </tr>

         <tr>
            <td><strong>User code.</strong></td>
            <td>' . getDataEmailEx($formno)->crfexcus_userecode . '</td>
            <td><strong>Date.</strong></td>
            <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_userdatetime) . '</td>
         </tr>

         <tr>
            <td colspan="4" class="bghead"><b>Manager Approval results.</b></td>
         </tr>

         <tr>
            <td><strong>Manager name.</strong></td>
            <td>' . getDataEmailEx($formno)->crfex_mgrapp_username . '</td>
            <td><strong>Date</strong></td>
            <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_mgrapp_datetime) . '</td>
         </tr>

         <tr>
            <td><strong>Status</strong></td>
            <td>' . getDataEmailEx($formno)->crfex_mgrapp_status . '</td>
            <td><strong>Reason</strong></td>
            <td>' . getDataEmailEx($formno)->crfex_mgrapp_detail . '</td>
         </tr>

         <tr>
            <td colspan="4" class="bghead"><b>CS Process.</b></td>
         </tr>

         <tr>
            <td><strong>BR CODE.</strong></td>
            <td colspan="3">' . getDataEmailEx($formno)->crfex_brcode . '</td>
         </tr>

         <tr>
            <td><strong>CS Sign.</strong></td>
            <td>' . getDataEmailEx($formno)->crfex_csuserpost . '</td>
            <td><strong>Date.</strong></td>
            <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_csdatetime) . '</td>
         </tr>

         <tr>
            <td><strong>Go to form.</strong></td>
            <td colspan="3"><a href="' . base_url('main/viewdataEx/') . getDataEmailEx($formno)->crfex_id . '">' . getDataEmailEx($formno)->crfexcus_formno . '</a></td>
         </tr>

         <tr>
            <td><strong>Scan QrCode</strong></td>
            <td colspan="3"><img src="' . base_url('upload/qrcode/') . $this->createQrcode($short_urlex,getDataEmailEx($formno)->crfex_id) . '"></td>
         </tr>

         </table>
         ';



      //  Email Zone
      $posiTo = "75";
      $deptcodeTo = 1003;
      $option = getuserEmailTo($deptcodeTo, $posiTo);


      $to = array();
      $ecodeAr = array();
      foreach ($option->result_array() as $result) {
         $to[] = $result['memberemail'];
         $ecodeAr[] = $result['ecode'];
      }

      array_push($to , "tassanee_s@saleecolour.com");
      array_push($ecodeAr , "M1767");

      array_push($to , "supawadee.su@saleecolour.com");
      array_push($ecodeAr , "M2217");

      array_push($to , "siriporn_p@saleecolour.com");
      array_push($ecodeAr , "M1260");

      $ecodecc = getDataEmailEx($formno)->crfexcus_userecode;
      $optioncc = getuserEmailToOwner($ecodecc);

      $cc = array();
      $ecodeccAr = array();
      foreach ($optioncc->result_array() as $resultcc) {
         $cc[] = $resultcc['memberemail'];
         $ecodeccAr[] = $resultcc['ecode'];
      }

      $to = array_unique($to);
      $cc = array_unique($cc);
      $ecodeAr = array_unique($ecodeAr);
      $ecodeccAr = array_unique($ecodeccAr);

      emailSaveDataTH($subject, $body, $to, $cc);
      //  Email Zone

      // Notification center program
      $ecodeActionArr = $ecodeAr;
      $ecodeReadArr = $ecodeccAr;

      $title = "[crf export] You have credit request form waiting for approve.";
      $status = getDataEmailEx($formno)->crfex_status;
      $link = base_url('main/viewdataEx/').getDataEmailEx($formno)->crfex_id;
      $programname = "credit request form";

      $this->notifycenter->insertdataaction_template($ecodeActionArr , $title , $status , $link , $formno , $programname);
      $this->notifycenter->insertdataRead_template($ecodeReadArr , $title , $status , $link , $formno , $programname);
   }
   //End Step 3


   //End Step 3-2
   function sendemail_toAccMgrEx2($formno)
   {

      $topicEX = getDataEmailEx($formno)->crfex_topic;
      if (getDataEmailEx($formno)->crfex_curcustopic1 != '') {
         $topicEX .= " / " . getDataEmailEx($formno)->crfex_curcustopic1;
      }
      if (getDataEmailEx($formno)->crfex_curcustopic2 != '') {
         $topicEX .= " / " . getDataEmailEx($formno)->crfex_curcustopic2;
      }

      $short_urlex = base_url('qrcodeex/') . getDataEmailEx($formno)->crfex_id;
      // $short_urlex = shorturl($longurlex);


      $subject = "[crf export] You have credit request form waiting for approve.";

      $body = '
         <h2>You have credit request form waiting for approve.</h2>
         <table>
            <tr>
               <td><strong>Form no.</strong></td>
               <td>' . getDataEmailEx($formno)->crfexcus_formno . '</td>
               <td><strong>Date create.</strong></td>
               <td>' . conDateFromDb(getDataEmailEx($formno)->crfex_datecreate) . '</td>
            </tr>

            <tr>
               <td><strong>Customer type.</strong></td>
               <td>' . getDataEmailEx($formno)->crf_alltype_subnameEN . '</td>
               <td><strong>Status.</strong></td>
               <td>' . getDataEmailEx($formno)->crfex_status . '</td>
            </tr>

            <tr>
               <td><strong>Topic</strong></td>
               <td colspan="3">' . $topicEX . '</td>
            </tr>

            <tr>
               <td><strong>Customer name.</strong></td>
               <td>' . getDataEmailEx($formno)->crfexcus_nameEN . '</td>
               <td><strong>Sales reps</strong></td>
               <td>' . getDataEmailEx($formno)->crfexcus_salesreps . '</td>
            </tr>

            <tr>
               <td><strong>User post.</strong></td>
               <td>' . getDataEmailEx($formno)->crfex_userpost . '</td>
               <td><strong>User Dept.</strong></td>
               <td>' . getDataEmailEx($formno)->crfex_userdept . '</td>
            </tr>

            <tr>
               <td><strong>User code.</strong></td>
               <td>' . getDataEmailEx($formno)->crfexcus_userecode . '</td>
               <td><strong>Date.</strong></td>
               <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_userdatetime) . '</td>
            </tr>

            <tr>
               <td colspan="4" class="bghead"><b>Manager Approval results.</b></td>
            </tr>

            <tr>
               <td><strong>Manager name.</strong></td>
               <td>' . getDataEmailEx($formno)->crfex_mgrapp_username . '</td>
               <td><strong>Date</strong></td>
               <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_mgrapp_datetime) . '</td>
            </tr>

            <tr>
               <td><strong>Status</strong></td>
               <td>' . getDataEmailEx($formno)->crfex_mgrapp_status . '</td>
               <td><strong>Reason</strong></td>
               <td>' . getDataEmailEx($formno)->crfex_mgrapp_detail . '</td>
            </tr>


            <tr>
               <td><strong>Go to form.</strong></td>
               <td colspan="3"><a href="' . base_url('main/viewdataEx/') . getDataEmailEx($formno)->crfex_id . '">' . getDataEmailEx($formno)->crfexcus_formno . '</a></td>
            </tr>

            <tr>
               <td><strong>Scan QrCode</strong></td>
               <td colspan="3"><img src="' . base_url('upload/qrcode/') . $this->createQrcode($short_urlex,getDataEmailEx($formno)->crfex_id) . '"></td>
            </tr>

         </table>
      ';

      //  Email Zone
      $posiTo = "75";
      $deptcodeTo = 1003;
      $option = getuserEmailTo($deptcodeTo, $posiTo);


      $to = array();
      $ecodeAr = array();
      foreach ($option->result_array() as $result) {
         $to[] = $result['memberemail'];
         $ecodeAr[] = $result['ecode'];
      }

      array_push($to , "tassanee_s@saleecolour.com");
      array_push($ecodeAr , "M1767");

      array_push($to , "supawadee.su@saleecolour.com");
      array_push($ecodeAr , "M2217");

      array_push($to , "siriporn_p@saleecolour.com");
      array_push($ecodeAr , "M1260");

      $ecodecc = getDataEmailEx($formno)->crfexcus_userecode;
      $optioncc = getuserEmailToOwner($ecodecc);

      $cc = array();
      $ecodeccAr = array();
      foreach ($optioncc->result_array() as $resultcc) {
         $cc[] = $resultcc['memberemail'];
         $ecodeccAr[] = $resultcc['ecode'];
      }

      $to = array_unique($to);
      $cc = array_unique($cc);
      $ecodeAr = array_unique($ecodeAr);
      $ecodeccAr = array_unique($ecodeccAr);

      emailSaveDataTH($subject, $body, $to, $cc);
      //  Email Zone

      // Notification center program
      $ecodeActionArr = $ecodeAr;
      $ecodeReadArr = $ecodeccAr;

      $title = "[crf export] You have credit request form waiting for approve.";
      $status = getDataEmailEx($formno)->crfex_status;
      $link = base_url('main/viewdataEx/').getDataEmailEx($formno)->crfex_id;
      $programname = "credit request form";

      $this->notifycenter->insertdataaction_template($ecodeActionArr , $title , $status , $link , $formno , $programname);
      $this->notifycenter->insertdataRead_template($ecodeReadArr , $title , $status , $link , $formno , $programname);
   }
   //End Step 3-2


   //End Step 4
   function sendemail_toDirectorEx($formno)
   {

      $topicEX = getDataEmailEx($formno)->crfex_topic;
      if (getDataEmailEx($formno)->crfex_curcustopic1 != '') {
         $topicEX .= " / " . getDataEmailEx($formno)->crfex_curcustopic1;
      }
      if (getDataEmailEx($formno)->crfex_curcustopic2 != '') {
         $topicEX .= " / " . getDataEmailEx($formno)->crfex_curcustopic2;
      }

      $short_urlex = base_url('qrcodeex/') . getDataEmailEx($formno)->crfex_id;
      // $short_urlex = shorturl($longurlex);


      $subject = "[crf export] You have credit request form waiting for approve.";

      $body = '
         <h2>You have credit request form waiting for approve.</h2>
         <table>
          <tr>
             <td><strong>Form no.</strong></td>
             <td>' . getDataEmailEx($formno)->crfexcus_formno . '</td>
             <td><strong>Date create.</strong></td>
             <td>' . conDateFromDb(getDataEmailEx($formno)->crfex_datecreate) . '</td>
          </tr>
 
          <tr>
             <td><strong>Customer type.</strong></td>
             <td>' . getDataEmailEx($formno)->crf_alltype_subnameEN . '</td>
             <td><strong>Status.</strong></td>
             <td>' . getDataEmailEx($formno)->crfex_status . '</td>
          </tr>
 
          <tr>
             <td><strong>Topic</strong></td>
             <td colspan="3">' . $topicEX . '</td>
          </tr>
 
          <tr>
             <td><strong>Customer name.</strong></td>
             <td>' . getDataEmailEx($formno)->crfexcus_nameEN . '</td>
             <td><strong>Sales reps</strong></td>
             <td>' . getDataEmailEx($formno)->crfexcus_salesreps . '</td>
          </tr>
 
          <tr>
             <td><strong>User post.</strong></td>
             <td>' . getDataEmailEx($formno)->crfex_userpost . '</td>
             <td><strong>User Dept.</strong></td>
             <td>' . getDataEmailEx($formno)->crfex_userdept . '</td>
          </tr>
 
          <tr>
             <td><strong>User code.</strong></td>
             <td>' . getDataEmailEx($formno)->crfexcus_userecode . '</td>
             <td><strong>Date.</strong></td>
             <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_userdatetime) . '</td>
          </tr>
 
          <tr>
             <td colspan="4" class="bghead"><b>Manager Approval results.</b></td>
          </tr>
 
          <tr>
             <td><strong>Manager name.</strong></td>
             <td>' . getDataEmailEx($formno)->crfex_mgrapp_username . '</td>
             <td><strong>Date</strong></td>
             <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_mgrapp_datetime) . '</td>
          </tr>
 
          <tr>
             <td><strong>Status</strong></td>
             <td>' . getDataEmailEx($formno)->crfex_mgrapp_status . '</td>
             <td><strong>Reason</strong></td>
             <td>' . getDataEmailEx($formno)->crfex_mgrapp_detail . '</td>
          </tr>
 
          <tr>
             <td colspan="4" class="bghead"><b>CS Process.</b></td>
          </tr>
 
          <tr>
             <td><strong>BR CODE.</strong></td>
             <td colspan="3">' . getDataEmailEx($formno)->crfex_brcode . '</td>
          </tr>
 
          <tr>
             <td><strong>CS Sign.</strong></td>
             <td>' . getDataEmailEx($formno)->crfex_csuserpost . '</td>
             <td><strong>Date.</strong></td>
             <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_csdatetime) . '</td>
          </tr>

          <tr>
             <td colspan="4" class="bghead"><b>Account Manager Approval results.</b></td>
          </tr>
 
          <tr>
             <td><strong>Account Manager sign.</strong></td>
             <td>' . getDataEmailEx($formno)->crfex_accmgr_username . '</td>
             <td><strong>Date</strong></td>
             <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_accmgr_datetime) . '</td>
          </tr>
 
          <tr>
             <td><strong>Status</strong></td>
             <td>' . getDataEmailEx($formno)->crfex_accmgr_status . '</td>
             <td><strong>Reason</strong></td>
             <td>' . getDataEmailEx($formno)->crfex_accmgr_detail . '</td>
          </tr>
 
          <tr>
             <td><strong>Go to form.</strong></td>
             <td colspan="3"><a href="' . base_url('main/viewdataEx/') . getDataEmailEx($formno)->crfex_id . '">' . getDataEmailEx($formno)->crfexcus_formno . '</a></td>
          </tr>
 
          <tr>
             <td><strong>Scan QrCode</strong></td>
             <td colspan="3"><img src="' . base_url('upload/qrcode/') . $this->createQrcode($short_urlex,getDataEmailEx($formno)->crfex_id) . '"></td>
          </tr>
 
          </table>
          ';



      //  Email Zone
      $posiTo = " '85' , '95' ";
      $option = getuserEmailToDirector($posiTo);


      $to = array();
      $ecodeAr = array();
      foreach ($option->result_array() as $result) {
         $to[] = $result['memberemail'];
         $ecodeAr[] = $result['ecode'];
      }
      array_push($to , "mattana@saleecolour.com" , "saowanit@saleecolour.com");
      array_push($ecodeAr , "M0015" , "M0025");

      $ecodecc = getDataEmailEx($formno)->crfexcus_userecode;
      $optioncc = getuserEmailToOwner($ecodecc);

      $cc = array();
      $ecodeccAr = array();
      foreach ($optioncc->result_array() as $resultcc) {
         $cc[] = $resultcc['memberemail'];
         $ecodeccAr[] = $resultcc['ecode'];
      }

      $to = array_unique($to);
      $cc = array_unique($cc);
      $ecodeAr = array_unique($ecodeAr);
      $ecodeccAr = array_unique($ecodeccAr);

      emailSaveDataTH($subject, $body, $to, $cc);
      //  Email Zone

      // Notification center program
      $ecodeActionArr = $ecodeAr;
      $ecodeReadArr = $ecodeccAr;

      $title = "[crf export] You have credit request form waiting for approve.";
      $status = getDataEmailEx($formno)->crfex_status;
      $link = base_url('main/viewdataEx/').getDataEmailEx($formno)->crfex_id;
      $programname = "credit request form";

      $this->notifycenter->insertdataaction_template($ecodeActionArr , $title , $status , $link , $formno , $programname);
      $this->notifycenter->insertdataRead_template($ecodeReadArr , $title , $status , $link , $formno , $programname);
   }
   //End Step 4


   //End Step 4-2
   function sendemail_toDirectorEx2($formno)
   {

      $topicEX = getDataEmailEx($formno)->crfex_topic;
      if (getDataEmailEx($formno)->crfex_curcustopic1 != '') {
         $topicEX .= " / " . getDataEmailEx($formno)->crfex_curcustopic1;
      }
      if (getDataEmailEx($formno)->crfex_curcustopic2 != '') {
         $topicEX .= " / " . getDataEmailEx($formno)->crfex_curcustopic2;
      }

      $short_urlex = base_url('qrcodeex/') . getDataEmailEx($formno)->crfex_id;
      // $short_urlex = shorturl($longurlex);


      $subject = "[crf export] You have credit request form waiting for approve.";

      $body = '
             <h2>You have credit request form waiting for approve.</h2>
             <table>
              <tr>
                 <td><strong>Form no.</strong></td>
                 <td>' . getDataEmailEx($formno)->crfexcus_formno . '</td>
                 <td><strong>Date create.</strong></td>
                 <td>' . conDateFromDb(getDataEmailEx($formno)->crfex_datecreate) . '</td>
              </tr>
     
              <tr>
                 <td><strong>Customer type.</strong></td>
                 <td>' . getDataEmailEx($formno)->crf_alltype_subnameEN . '</td>
                 <td><strong>Status.</strong></td>
                 <td>' . getDataEmailEx($formno)->crfex_status . '</td>
              </tr>
     
              <tr>
                 <td><strong>Topic</strong></td>
                 <td colspan="3">' . $topicEX . '</td>
              </tr>
     
              <tr>
                 <td><strong>Customer name.</strong></td>
                 <td>' . getDataEmailEx($formno)->crfexcus_nameEN . '</td>
                 <td><strong>Sales reps</strong></td>
                 <td>' . getDataEmailEx($formno)->crfexcus_salesreps . '</td>
              </tr>
     
              <tr>
                 <td><strong>User post.</strong></td>
                 <td>' . getDataEmailEx($formno)->crfex_userpost . '</td>
                 <td><strong>User Dept.</strong></td>
                 <td>' . getDataEmailEx($formno)->crfex_userdept . '</td>
              </tr>
     
              <tr>
                 <td><strong>User code.</strong></td>
                 <td>' . getDataEmailEx($formno)->crfexcus_userecode . '</td>
                 <td><strong>Date.</strong></td>
                 <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_userdatetime) . '</td>
              </tr>
     
              <tr>
                 <td colspan="4" class="bghead"><b>Manager Approval results.</b></td>
              </tr>
     
              <tr>
                 <td><strong>Manager name.</strong></td>
                 <td>' . getDataEmailEx($formno)->crfex_mgrapp_username . '</td>
                 <td><strong>Date</strong></td>
                 <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_mgrapp_datetime) . '</td>
              </tr>
     
              <tr>
                 <td><strong>Status</strong></td>
                 <td>' . getDataEmailEx($formno)->crfex_mgrapp_status . '</td>
                 <td><strong>Reason</strong></td>
                 <td>' . getDataEmailEx($formno)->crfex_mgrapp_detail . '</td>
              </tr>
     
    
              <tr>
                 <td colspan="4" class="bghead"><b>Account Manager Approval results.</b></td>
              </tr>
     
              <tr>
                 <td><strong>Account Manager sign.</strong></td>
                 <td>' . getDataEmailEx($formno)->crfex_accmgr_username . '</td>
                 <td><strong>Date</strong></td>
                 <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_accmgr_datetime) . '</td>
              </tr>
     
              <tr>
                 <td><strong>Status</strong></td>
                 <td>' . getDataEmailEx($formno)->crfex_accmgr_status . '</td>
                 <td><strong>Reason</strong></td>
                 <td>' . getDataEmailEx($formno)->crfex_accmgr_detail . '</td>
              </tr>
     
              <tr>
                 <td><strong>Go to form.</strong></td>
                 <td colspan="3"><a href="' . base_url('main/viewdataEx/') . getDataEmailEx($formno)->crfex_id . '">' . getDataEmailEx($formno)->crfexcus_formno . '</a></td>
              </tr>
     
              <tr>
                 <td><strong>Scan QrCode</strong></td>
                 <td colspan="3"><img src="' . base_url('upload/qrcode/') . $this->createQrcode($short_urlex,getDataEmailEx($formno)->crfex_id) . '"></td>
              </tr>
     
              </table>
              ';



      //  Email Zone
      $posiTo = " '85' , '95' ";
      $option = getuserEmailToDirector($posiTo);


      $to = array();
      $ecodeAr = array();
      foreach ($option->result_array() as $result) {
         $to[] = $result['memberemail'];
         $ecodeAr[] = $result['ecode'];
      }
      array_push($to , "mattana@saleecolour.com" , "saowanit@saleecolour.com");
      array_push($ecodeAr , "M0015" , "M0025");

      //  $to = array(
      //      "chainarong_k@saleecolour.com",
      //  );

      $ecodecc = getDataEmailEx($formno)->crfexcus_userecode;
      $optioncc = getuserEmailToOwner($ecodecc);

      $cc = array();
      $ecodeccAr = array();
      foreach ($optioncc->result_array() as $resultcc) {
         $cc[] = $resultcc['memberemail'];
         $ecodeccAr[] = $resultcc['ecode'];
      }

      $to = array_unique($to);
      $cc = array_unique($cc);
      $ecodeAr = array_unique($ecodeAr);
      $ecodeccAr = array_unique($ecodeccAr);

      emailSaveDataTH($subject, $body, $to, $cc);
      //  Email Zone

      // Notification center program
      $ecodeActionArr = $ecodeAr;
      $ecodeReadArr = $ecodeccAr;

      $title = "[crf export] You have credit request form waiting for approve.";
      $status = getDataEmailEx($formno)->crfex_status;
      $link = base_url('main/viewdataEx/').getDataEmailEx($formno)->crfex_id;
      $programname = "credit request form";

      $this->notifycenter->insertdataaction_template($ecodeActionArr , $title , $status , $link , $formno , $programname);
      $this->notifycenter->insertdataRead_template($ecodeReadArr , $title , $status , $link , $formno , $programname);
   }
   //End Step 4-2


   //End Step 5
   function sendemail_toAccStaffEx($formno)
   {
      $topicEX = getDataEmailEx($formno)->crfex_topic;
      if (getDataEmailEx($formno)->crfex_curcustopic1 != '') {
         $topicEX .= " / " . getDataEmailEx($formno)->crfex_curcustopic1;
      }
      if (getDataEmailEx($formno)->crfex_curcustopic2 != '') {
         $topicEX .= " / " . getDataEmailEx($formno)->crfex_curcustopic2;
      }

      $short_urlex = base_url('qrcodeex/') . getDataEmailEx($formno)->crfex_id;
      // $short_urlex = shorturl($longurlex);


      $subject = "[crf export] You have credit request form waiting for add customer code.";

      $body = '
             <h2>You have credit request form waiting for add customer code.</h2>
             <table>
              <tr>
                 <td><strong>Form no.</strong></td>
                 <td>' . getDataEmailEx($formno)->crfexcus_formno . '</td>
                 <td><strong>Date create.</strong></td>
                 <td>' . conDateFromDb(getDataEmailEx($formno)->crfex_datecreate) . '</td>
              </tr>
     
              <tr>
                 <td><strong>Customer type.</strong></td>
                 <td>' . getDataEmailEx($formno)->crf_alltype_subnameEN . '</td>
                 <td><strong>Status.</strong></td>
                 <td>' . getDataEmailEx($formno)->crfex_status . '</td>
              </tr>
     
              <tr>
                 <td><strong>Topic</strong></td>
                 <td colspan="3">' . $topicEX . '</td>
              </tr>
     
              <tr>
                 <td><strong>Customer name.</strong></td>
                 <td>' . getDataEmailEx($formno)->crfexcus_nameEN . '</td>
                 <td><strong>Sales reps</strong></td>
                 <td>' . getDataEmailEx($formno)->crfexcus_salesreps . '</td>
              </tr>
     
              <tr>
                 <td><strong>User post.</strong></td>
                 <td>' . getDataEmailEx($formno)->crfex_userpost . '</td>
                 <td><strong>User Dept.</strong></td>
                 <td>' . getDataEmailEx($formno)->crfex_userdept . '</td>
              </tr>
     
              <tr>
                 <td><strong>User code.</strong></td>
                 <td>' . getDataEmailEx($formno)->crfexcus_userecode . '</td>
                 <td><strong>Date.</strong></td>
                 <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_userdatetime) . '</td>
              </tr>
     
              <tr>
                 <td colspan="4" class="bghead"><b>Manager Approval results.</b></td>
              </tr>
     
              <tr>
                 <td><strong>Manager name.</strong></td>
                 <td>' . getDataEmailEx($formno)->crfex_mgrapp_username . '</td>
                 <td><strong>Date</strong></td>
                 <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_mgrapp_datetime) . '</td>
              </tr>
     
              <tr>
                 <td><strong>Status</strong></td>
                 <td>' . getDataEmailEx($formno)->crfex_mgrapp_status . '</td>
                 <td><strong>Reason</strong></td>
                 <td>' . getDataEmailEx($formno)->crfex_mgrapp_detail . '</td>
              </tr>
     
              <tr>
                 <td colspan="4" class="bghead"><b>CS Process.</b></td>
              </tr>
     
              <tr>
                 <td><strong>BR CODE.</strong></td>
                 <td colspan="3">' . getDataEmailEx($formno)->crfex_brcode . '</td>
              </tr>
     
              <tr>
                 <td><strong>CS Sign.</strong></td>
                 <td>' . getDataEmailEx($formno)->crfex_csuserpost . '</td>
                 <td><strong>Date.</strong></td>
                 <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_csdatetime) . '</td>
              </tr>
    
              <tr>
                 <td colspan="4" class="bghead"><b>Account Manager Approval results.</b></td>
              </tr>
     
              <tr>
                 <td><strong>Account Manager sign.</strong></td>
                 <td>' . getDataEmailEx($formno)->crfex_accmgr_username . '</td>
                 <td><strong>Date</strong></td>
                 <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_accmgr_datetime) . '</td>
              </tr>
     
              <tr>
                 <td><strong>Status</strong></td>
                 <td>' . getDataEmailEx($formno)->crfex_accmgr_status . '</td>
                 <td><strong>Reason</strong></td>
                 <td>' . getDataEmailEx($formno)->crfex_accmgr_detail . '</td>
              </tr>

              <tr>
                 <td colspan="4" class="bghead"><b>Frist Deputy Managing Director Approval results.</b></td>
              </tr>
     
              <tr>
                 <td><strong>Director Sales sign.</strong></td>
                 <td>' . getDataEmailEx($formno)->crfex_directorapp_username . '</td>
                 <td><strong>Date</strong></td>
                 <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_directorapp_datetime) . '</td>
              </tr>
     
              <tr>
                 <td><strong>Status</strong></td>
                 <td>' . getDataEmailEx($formno)->crfex_directorapp_status . '</td>
                 <td><strong>Reason</strong></td>
                 <td>' . getDataEmailEx($formno)->crfex_directorapp_detail . '</td>
              </tr>

              <tr>
                 <td colspan="4" class="bghead"><b>Second Deputy Managing Director Approval results.</b></td>
              </tr>
     
              <tr>
                 <td><strong>Director Sales sign.</strong></td>
                 <td>' . getDataEmailEx($formno)->crfex_directorapp_username2 . '</td>
                 <td><strong>Date</strong></td>
                 <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_directorapp_datetime2) . '</td>
              </tr>
     
              <tr>
                 <td><strong>Status</strong></td>
                 <td>' . getDataEmailEx($formno)->crfex_directorapp_status2 . '</td>
                 <td><strong>Reason</strong></td>
                 <td>' . getDataEmailEx($formno)->crfex_directorapp_detail2 . '</td>
              </tr>
     
              <tr>
                 <td><strong>Go to form.</strong></td>
                 <td colspan="3"><a href="' . base_url('main/viewdataEx/') . getDataEmailEx($formno)->crfex_id . '">' . getDataEmailEx($formno)->crfexcus_formno . '</a></td>
              </tr>
     
              <tr>
                 <td><strong>Scan QrCode</strong></td>
                 <td colspan="3"><img src="' . base_url('upload/qrcode/') . $this->createQrcode($short_urlex,getDataEmailEx($formno)->crfex_id) . '"></td>
              </tr>
     
              </table>
              ';



      //  Email Zone
      // $deptcode = 1003;
      // $posi = "15";
      // $option = getuserEmailTo($deptcode, $posi);
      $ecode = " 'M1767' , 'M1260' , 'M2017' , 'M2138' ";
      $option = getuserEmailToCs($ecode);


      $to = array();
      $ecodeAr = array();
      foreach ($option->result_array() as $result) {
         $to[] = $result['memberemail'];
         $ecodeAr[] = $result['ecode'];
      }

      $ecodecc = getDataEmailEx($formno)->crfexcus_userecode;
      $optioncc = getuserEmailToOwner($ecodecc);

      $cc = array();
      $ecodeccAr = array();
      foreach ($optioncc->result_array() as $resultcc) {
         $cc[] = $resultcc['memberemail'];
         $ecodeccAr[] = $resultcc['ecode'];
      }

      $to = array_unique($to);
      $cc = array_unique($cc);
      $ecodeAr = array_unique($ecodeAr);
      $ecodeccAr = array_unique($ecodeccAr);

      emailSaveDataTH($subject, $body, $to, $cc);
      //  Email Zone

      // Notification center program
      $ecodeActionArr = $ecodeAr;
      $ecodeReadArr = $ecodeccAr;

      $title = "[crf export] You have credit request form waiting for add customer code.";
      $status = getDataEmailEx($formno)->crfex_status;
      $link = base_url('main/viewdataEx/').getDataEmailEx($formno)->crfex_id;
      $programname = "credit request form";

      $this->notifycenter->insertdataaction_template($ecodeActionArr , $title , $status , $link , $formno , $programname);
      $this->notifycenter->insertdataRead_template($ecodeReadArr , $title , $status , $link , $formno , $programname);
   }
   //End Step 5


   //End Step 5-2
   function sendemail_toAccStaffEx2($formno)
   {

      $topicEX = getDataEmailEx($formno)->crfex_topic;
      if (getDataEmailEx($formno)->crfex_curcustopic1 != '') {
         $topicEX .= " / " . getDataEmailEx($formno)->crfex_curcustopic1;
      }
      if (getDataEmailEx($formno)->crfex_curcustopic2 != '') {
         $topicEX .= " / " . getDataEmailEx($formno)->crfex_curcustopic2;
      }

      $short_urlex = base_url('qrcodeex/') . getDataEmailEx($formno)->crfex_id;
      // $short_urlex = shorturl($longurlex);


      $subject = "[crf export] You have pending credit request form..";

      $body = '
              <h2>You have pending credit request form..</h2>
              <table>
               <tr>
                  <td><strong>Form no.</strong></td>
                  <td>' . getDataEmailEx($formno)->crfexcus_formno . '</td>
                  <td><strong>Date create.</strong></td>
                  <td>' . conDateFromDb(getDataEmailEx($formno)->crfex_datecreate) . '</td>
               </tr>
      
               <tr>
                  <td><strong>Customer type.</strong></td>
                  <td>' . getDataEmailEx($formno)->crf_alltype_subnameEN . '</td>
                  <td><strong>Status.</strong></td>
                  <td>' . getDataEmailEx($formno)->crfex_status . '</td>
               </tr>
      
               <tr>
                  <td><strong>Topic</strong></td>
                  <td colspan="3">' . $topicEX . '</td>
               </tr>
      
               <tr>
                  <td><strong>Customer name.</strong></td>
                  <td>' . getDataEmailEx($formno)->crfexcus_nameEN . '</td>
                  <td><strong>Sales reps</strong></td>
                  <td>' . getDataEmailEx($formno)->crfexcus_salesreps . '</td>
               </tr>
      
               <tr>
                  <td><strong>User post.</strong></td>
                  <td>' . getDataEmailEx($formno)->crfex_userpost . '</td>
                  <td><strong>User Dept.</strong></td>
                  <td>' . getDataEmailEx($formno)->crfex_userdept . '</td>
               </tr>
      
               <tr>
                  <td><strong>User code.</strong></td>
                  <td>' . getDataEmailEx($formno)->crfexcus_userecode . '</td>
                  <td><strong>Date.</strong></td>
                  <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_userdatetime) . '</td>
               </tr>
      
               <tr>
                  <td colspan="4" class="bghead"><b>Manager Approval results.</b></td>
               </tr>
      
               <tr>
                  <td><strong>Manager name.</strong></td>
                  <td>' . getDataEmailEx($formno)->crfex_mgrapp_username . '</td>
                  <td><strong>Date</strong></td>
                  <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_mgrapp_datetime) . '</td>
               </tr>
      
               <tr>
                  <td><strong>Status</strong></td>
                  <td>' . getDataEmailEx($formno)->crfex_mgrapp_status . '</td>
                  <td><strong>Reason</strong></td>
                  <td>' . getDataEmailEx($formno)->crfex_mgrapp_detail . '</td>
               </tr>
      

     
               <tr>
                  <td colspan="4" class="bghead"><b>Account Manager Approval results.</b></td>
               </tr>
      
               <tr>
                  <td><strong>Account Manager sign.</strong></td>
                  <td>' . getDataEmailEx($formno)->crfex_accmgr_username . '</td>
                  <td><strong>Date</strong></td>
                  <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_accmgr_datetime) . '</td>
               </tr>
      
               <tr>
                  <td><strong>Status</strong></td>
                  <td>' . getDataEmailEx($formno)->crfex_accmgr_status . '</td>
                  <td><strong>Reason</strong></td>
                  <td>' . getDataEmailEx($formno)->crfex_accmgr_detail . '</td>
               </tr>
 
               <tr>
                 <td colspan="4" class="bghead"><b>Frist Deputy Managing Director Approval results.</b></td>
              </tr>
     
              <tr>
                 <td><strong>Director Sales sign.</strong></td>
                 <td>' . getDataEmailEx($formno)->crfex_directorapp_username . '</td>
                 <td><strong>Date</strong></td>
                 <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_directorapp_datetime) . '</td>
              </tr>
     
              <tr>
                 <td><strong>Status</strong></td>
                 <td>' . getDataEmailEx($formno)->crfex_directorapp_status . '</td>
                 <td><strong>Reason</strong></td>
                 <td>' . getDataEmailEx($formno)->crfex_directorapp_detail . '</td>
              </tr>

              <tr>
                 <td colspan="4" class="bghead"><b>Second Deputy Managing Director Approval results.</b></td>
              </tr>
     
              <tr>
                 <td><strong>Director Sales sign.</strong></td>
                 <td>' . getDataEmailEx($formno)->crfex_directorapp_username2 . '</td>
                 <td><strong>Date</strong></td>
                 <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_directorapp_datetime2) . '</td>
              </tr>
     
              <tr>
                 <td><strong>Status</strong></td>
                 <td>' . getDataEmailEx($formno)->crfex_directorapp_status2 . '</td>
                 <td><strong>Reason</strong></td>
                 <td>' . getDataEmailEx($formno)->crfex_directorapp_detail2 . '</td>
              </tr>
      
               <tr>
                  <td><strong>Go to form.</strong></td>
                  <td colspan="3"><a href="' . base_url('main/viewdataEx/') . getDataEmailEx($formno)->crfex_id . '">' . getDataEmailEx($formno)->crfexcus_formno . '</a></td>
               </tr>
      
               <tr>
                  <td><strong>Scan QrCode</strong></td>
                  <td colspan="3"><img src="' . base_url('upload/qrcode/') . $this->createQrcode($short_urlex,getDataEmailEx($formno)->crfex_id) . '"></td>
               </tr>
      
               </table>
               ';



      //  Email Zone
      // $deptcode = 1003;
      // $posi = "15";
      // $option = getuserEmailTo($deptcode, $posi);
      $ecode = " 'M1767' , 'M1260' , 'M2017' , 'M2138' , 'M2217' ";
      $option = getuserEmailToCs($ecode);


      $to = array();
      $ecodeAr = array();
      foreach ($option->result_array() as $result) {
         $to[] = $result['memberemail'];
         $ecodeAr[] = $result['ecode'];
      }

      $ecodecc = getDataEmailEx($formno)->crfexcus_userecode;
      $optioncc = getuserEmailToOwner($ecodecc);

      $cc = array();
      $ecodeccAr = array();
      foreach ($optioncc->result_array() as $resultcc) {
         $cc[] = $resultcc['memberemail'];
         $ecodeccAr[] = $resultcc['ecode'];
      }

      $to = array_unique($to);
      $cc = array_unique($cc);
      $ecodeAr = array_unique($ecodeAr);
      $ecodeccAr = array_unique($ecodeccAr);

      emailSaveDataTH($subject, $body, $to, $cc);
      //  Email Zone

      // Notification center program
      $ecodeActionArr = $ecodeAr;
      $ecodeReadArr = $ecodeccAr;

      $title = "[crf export] You have pending credit request form.";
      $status = getDataEmailEx($formno)->crfex_status;
      $link = base_url('main/viewdataEx/').getDataEmailEx($formno)->crfex_id;
      $programname = "credit request form";

      $this->notifycenter->insertdataaction_template($ecodeActionArr , $title , $status , $link , $formno , $programname);
      $this->notifycenter->insertdataRead_template($ecodeReadArr , $title , $status , $link , $formno , $programname);
   }
   //End Step 5-2


    //End Step 5-2
    function sendemail_toAccStaffEx3($formno)
    {
 
       $topicEX = getDataEmailEx($formno)->crfex_topic;
       if (getDataEmailEx($formno)->crfex_curcustopic1 != '') {
          $topicEX .= " / " . getDataEmailEx($formno)->crfex_curcustopic1;
       }
       if (getDataEmailEx($formno)->crfex_curcustopic2 != '') {
          $topicEX .= " / " . getDataEmailEx($formno)->crfex_curcustopic2;
       }
 
       $short_urlex = base_url('qrcodeex/') . getDataEmailEx($formno)->crfex_id;
      //  $short_urlex = shorturl($longurlex);
 
 
       $subject = "[crf export] You have pending credit request form..";
 
       $body = '
               <h2>You have pending credit request form..</h2>
               <table>
                <tr>
                   <td><strong>Form no.</strong></td>
                   <td>' . getDataEmailEx($formno)->crfexcus_formno . '</td>
                   <td><strong>Date create.</strong></td>
                   <td>' . conDateFromDb(getDataEmailEx($formno)->crfex_datecreate) . '</td>
                </tr>
       
                <tr>
                   <td><strong>Customer type.</strong></td>
                   <td>' . getDataEmailEx($formno)->crf_alltype_subnameEN . '</td>
                   <td><strong>Status.</strong></td>
                   <td>' . getDataEmailEx($formno)->crfex_status . '</td>
                </tr>
       
                <tr>
                   <td><strong>Topic</strong></td>
                   <td colspan="3">' . $topicEX . '</td>
                </tr>
       
                <tr>
                   <td><strong>Customer name.</strong></td>
                   <td>' . getDataEmailEx($formno)->crfexcus_nameEN . '</td>
                   <td><strong>Sales reps</strong></td>
                   <td>' . getDataEmailEx($formno)->crfexcus_salesreps . '</td>
                </tr>
       
                <tr>
                   <td><strong>User post.</strong></td>
                   <td>' . getDataEmailEx($formno)->crfex_userpost . '</td>
                   <td><strong>User Dept.</strong></td>
                   <td>' . getDataEmailEx($formno)->crfex_userdept . '</td>
                </tr>
       
                <tr>
                   <td><strong>User code.</strong></td>
                   <td>' . getDataEmailEx($formno)->crfexcus_userecode . '</td>
                   <td><strong>Date.</strong></td>
                   <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_userdatetime) . '</td>
                </tr>
       
                <tr>
                   <td colspan="4" class="bghead"><b>Manager Approval results.</b></td>
                </tr>
       
                <tr>
                   <td><strong>Manager name.</strong></td>
                   <td>' . getDataEmailEx($formno)->crfex_mgrapp_username . '</td>
                   <td><strong>Date</strong></td>
                   <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_mgrapp_datetime) . '</td>
                </tr>
       
                <tr>
                   <td><strong>Status</strong></td>
                   <td>' . getDataEmailEx($formno)->crfex_mgrapp_status . '</td>
                   <td><strong>Reason</strong></td>
                   <td>' . getDataEmailEx($formno)->crfex_mgrapp_detail . '</td>
                </tr>
       
 
      
                <tr>
                   <td colspan="4" class="bghead"><b>Account Manager Approval results.</b></td>
                </tr>
       
                <tr>
                   <td><strong>Account Manager sign.</strong></td>
                   <td>' . getDataEmailEx($formno)->crfex_accmgr_username . '</td>
                   <td><strong>Date</strong></td>
                   <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_accmgr_datetime) . '</td>
                </tr>
       
                <tr>
                   <td><strong>Status</strong></td>
                   <td>' . getDataEmailEx($formno)->crfex_accmgr_status . '</td>
                   <td><strong>Reason</strong></td>
                   <td>' . getDataEmailEx($formno)->crfex_accmgr_detail . '</td>
                </tr>
  
       
                <tr>
                   <td><strong>Go to form.</strong></td>
                   <td colspan="3"><a href="' . base_url('main/viewdataEx/') . getDataEmailEx($formno)->crfex_id . '">' . getDataEmailEx($formno)->crfexcus_formno . '</a></td>
                </tr>
       
                <tr>
                   <td><strong>Scan QrCode</strong></td>
                   <td colspan="3"><img src="' . base_url('upload/qrcode/') . $this->createQrcode($short_urlex,getDataEmailEx($formno)->crfex_id) . '"></td>
                </tr>
       
                </table>
                ';
 
 
 
       //  Email Zone
      //  $deptcode = 1003;
      //  $posi = "15";
      //  $option = getuserEmailTo($deptcode, $posi);
      $ecode = " 'M1767' , 'M1260' , 'M2017' , 'M2138' , 'M2217' ";
      $option = getuserEmailToCs($ecode);
 
 
       $to = array();
       $ecodeAr = array();
       foreach ($option->result_array() as $result) {
          $to[] = $result['memberemail'];
          $ecodeAr[] = $result['ecode'];
       }
 
 
       $ecodecc = getDataEmailEx($formno)->crfexcus_userecode;
       $optioncc = getuserEmailToOwner($ecodecc);
 
       $cc = array();
       $ecodeccAr = array();
       foreach ($optioncc->result_array() as $resultcc) {
          $cc[] = $resultcc['memberemail'];
          $ecodeccAr[] = $resultcc['ecode'];
       }

       $to = array_unique($to);
       $cc = array_unique($cc);
       $ecodeAr = array_unique($ecodeAr);
       $ecodeccAr = array_unique($ecodeccAr);
 
       emailSaveDataTH($subject, $body, $to, $cc);
       //  Email Zone

             // Notification center program
      $ecodeActionArr = $ecodeAr;
      $ecodeReadArr = $ecodeccAr;

      $title = "[crf export] You have pending credit request form.";
      $status = getDataEmailEx($formno)->crfex_status;
      $link = base_url('main/viewdataEx/').getDataEmailEx($formno)->crfex_id;
      $programname = "credit request form";

      $this->notifycenter->insertdataaction_template($ecodeActionArr , $title , $status , $link , $formno , $programname);
      $this->notifycenter->insertdataRead_template($ecodeReadArr , $title , $status , $link , $formno , $programname);
    }
    //End Step 5-2


   //End Step 6
   function sendemail_toOwnerEx($formno)
   {

      $topicEX = getDataEmailEx($formno)->crfex_topic;
      if (getDataEmailEx($formno)->crfex_curcustopic1 != '') {
         $topicEX .= " / " . getDataEmailEx($formno)->crfex_curcustopic1;
      }
      if (getDataEmailEx($formno)->crfex_curcustopic2 != '') {
         $topicEX .= " / " . getDataEmailEx($formno)->crfex_curcustopic2;
      }

      $short_urlex = base_url('qrcodeex/') . getDataEmailEx($formno)->crfex_id;
      // $short_urlex = shorturl($longurlex);


      $subject = "[crf export] Your credit request form is completed.";

      $body = '
               <h2>Your credit request form is completed.</h2>
               <table>
                <tr>
                   <td><strong>Form no.</strong></td>
                   <td>' . getDataEmailEx($formno)->crfexcus_formno . '</td>
                   <td><strong>Date create.</strong></td>
                   <td>' . conDateFromDb(getDataEmailEx($formno)->crfex_datecreate) . '</td>
                </tr>
       
                <tr>
                   <td><strong>Customer type.</strong></td>
                   <td>' . getDataEmailEx($formno)->crf_alltype_subnameEN . '</td>
                   <td><strong>Status.</strong></td>
                   <td>' . getDataEmailEx($formno)->crfex_status . '</td>
                </tr>
       
                <tr>
                   <td><strong>Topic</strong></td>
                   <td colspan="3">' . $topicEX . '</td>
                </tr>
       
                <tr>
                   <td><strong>Customer name.</strong></td>
                   <td>' . getDataEmailEx($formno)->crfexcus_nameEN . '</td>
                   <td><strong>Sales reps</strong></td>
                   <td>' . getDataEmailEx($formno)->crfexcus_salesreps . '</td>
                </tr>
       
                <tr>
                   <td><strong>User post.</strong></td>
                   <td>' . getDataEmailEx($formno)->crfex_userpost . '</td>
                   <td><strong>User Dept.</strong></td>
                   <td>' . getDataEmailEx($formno)->crfex_userdept . '</td>
                </tr>
       
                <tr>
                   <td><strong>User code.</strong></td>
                   <td>' . getDataEmailEx($formno)->crfexcus_userecode . '</td>
                   <td><strong>Date.</strong></td>
                   <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_userdatetime) . '</td>
                </tr>
       
                <tr>
                   <td colspan="4" class="bghead"><b>Manager Approval results.</b></td>
                </tr>
       
                <tr>
                   <td><strong>Manager name.</strong></td>
                   <td>' . getDataEmailEx($formno)->crfex_mgrapp_username . '</td>
                   <td><strong>Date</strong></td>
                   <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_mgrapp_datetime) . '</td>
                </tr>
       
                <tr>
                   <td><strong>Status</strong></td>
                   <td>' . getDataEmailEx($formno)->crfex_mgrapp_status . '</td>
                   <td><strong>Reason</strong></td>
                   <td>' . getDataEmailEx($formno)->crfex_mgrapp_detail . '</td>
                </tr>
       
                <tr>
                   <td colspan="4" class="bghead"><b>CS Process.</b></td>
                </tr>
       
                <tr>
                   <td><strong>BR CODE.</strong></td>
                   <td colspan="3">' . getDataEmailEx($formno)->crfex_brcode . '</td>
                </tr>
       
                <tr>
                   <td><strong>CS Sign.</strong></td>
                   <td>' . getDataEmailEx($formno)->crfex_csuserpost . '</td>
                   <td><strong>Date.</strong></td>
                   <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_csdatetime) . '</td>
                </tr>
      
                <tr>
                   <td colspan="4" class="bghead"><b>Account Manager Approval results.</b></td>
                </tr>
       
                <tr>
                   <td><strong>Account Manager sign.</strong></td>
                   <td>' . getDataEmailEx($formno)->crfex_accmgr_username . '</td>
                   <td><strong>Date</strong></td>
                   <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_accmgr_datetime) . '</td>
                </tr>
       
                <tr>
                   <td><strong>Status</strong></td>
                   <td>' . getDataEmailEx($formno)->crfex_accmgr_status . '</td>
                   <td><strong>Reason</strong></td>
                   <td>' . getDataEmailEx($formno)->crfex_accmgr_detail . '</td>
                </tr>
  
                <tr>
                   <td colspan="4" class="bghead"><b>Frist Deputy Managing Director Approval results.</b></td>
                </tr>
       
                <tr>
                   <td><strong>Director Sales sign.</strong></td>
                   <td>' . getDataEmailEx($formno)->crfex_directorapp_username . '</td>
                   <td><strong>Date</strong></td>
                   <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_directorapp_datetime) . '</td>
                </tr>
       
                <tr>
                   <td><strong>Status</strong></td>
                   <td>' . getDataEmailEx($formno)->crfex_directorapp_status . '</td>
                   <td><strong>Reason</strong></td>
                   <td>' . getDataEmailEx($formno)->crfex_directorapp_detail . '</td>
                </tr>

                <tr>
                   <td colspan="4" class="bghead"><b>Second Deputy Managing Director Approval results.</b></td>
                </tr>
       
                <tr>
                   <td><strong>Director Sales sign.</strong></td>
                   <td>' . getDataEmailEx($formno)->crfex_directorapp_username2 . '</td>
                   <td><strong>Date</strong></td>
                   <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_directorapp_datetime2) . '</td>
                </tr>
       
                <tr>
                   <td><strong>Status</strong></td>
                   <td>' . getDataEmailEx($formno)->crfex_directorapp_status2 . '</td>
                   <td><strong>Reason</strong></td>
                   <td>' . getDataEmailEx($formno)->crfex_directorapp_detail2 . '</td>
                </tr>

                <tr>
                   <td colspan="4" class="bghead"><b>Account Process.</b></td>
                </tr>
       
                <tr>
                   <td><strong>CUSTOMER CODE.</strong></td>
                   <td colspan="3">' . getDataEmailEx($formno)->crfex_acccuscode . '</td>
                </tr>
       
                <tr>
                   <td><strong>Account Sign.</strong></td>
                   <td>' . getDataEmailEx($formno)->crfex_accuserpost . '</td>
                   <td><strong>Date.</strong></td>
                   <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_accdatetime) . '</td>
                </tr>
       
                <tr>
                   <td><strong>Go to form.</strong></td>
                   <td colspan="3"><a href="' . base_url('main/viewdataEx/') . getDataEmailEx($formno)->crfex_id . '">' . getDataEmailEx($formno)->crfexcus_formno . '</a></td>
                </tr>
       
                <tr>
                   <td><strong>Scan QrCode</strong></td>
                   <td colspan="3"><img src="' . base_url('upload/qrcode/') . $this->createQrcode($short_urlex,getDataEmailEx($formno)->crfex_id) . '"></td>
                </tr>
       
                </table>
                ';



      //  Email Zone

      $ecode = getDataEmailEx($formno)->crfexcus_userecode;
      $option = getuserEmailToOwner($ecode);


      $to = array();
      $ecodeAr = array();
      foreach ($option->result_array() as $result) {
         $to[] = $result['memberemail'];
         $ecodeAr[] = $result['ecode'];
      }


      $deptcode = getDataEmailEx($formno)->crfexcus_userdeptcode;
      $option_cc = getuserEmailccOwner($deptcode);
      $cc = array();
      foreach ($option_cc->result_array() as $result_cc) {
         $cc[] = $result_cc['memberemail'];
      }

      $to = array_unique($to);
      $cc = array_unique($cc);
      $ecodeAr = array_unique($ecodeAr);

      emailSaveDataTH($subject, $body, $to, $cc);
      //  Email Zone

      // Notification center program
      $ecodeReadArr = $ecodeAr;

      $title = "[crf export] Your credit request form is completed.";
      $status = getDataEmailEx($formno)->crfex_status;
      $link = base_url('main/viewdataEx/').getDataEmailEx($formno)->crfex_id;
      $programname = "credit request form";

      $this->notifycenter->insertdataRead_template($ecodeReadArr , $title , $status , $link , $formno , $programname);
   }
   //End Step 6


   //End Step 6-2
   function sendemail_toOwnerEx2($formno)
   {

      $topicEX = getDataEmailEx($formno)->crfex_topic;
      if (getDataEmailEx($formno)->crfex_curcustopic1 != '') {
         $topicEX .= " / " . getDataEmailEx($formno)->crfex_curcustopic1;
      }
      if (getDataEmailEx($formno)->crfex_curcustopic2 != '') {
         $topicEX .= " / " . getDataEmailEx($formno)->crfex_curcustopic2;
      }

      $short_urlex = base_url('qrcodeex/') . getDataEmailEx($formno)->crfex_id;
      // $short_urlex = shorturl($longurlex);


      $subject = "[crf export] Your credit request form is completed.";

      $body = '
                <h2>Your credit request form is completed.</h2>
                <table>
                 <tr>
                    <td><strong>Form no.</strong></td>
                    <td>' . getDataEmailEx($formno)->crfexcus_formno . '</td>
                    <td><strong>Date create.</strong></td>
                    <td>' . conDateFromDb(getDataEmailEx($formno)->crfex_datecreate) . '</td>
                 </tr>
        
                 <tr>
                    <td><strong>Customer type.</strong></td>
                    <td>' . getDataEmailEx($formno)->crf_alltype_subnameEN . '</td>
                    <td><strong>Status.</strong></td>
                    <td>' . getDataEmailEx($formno)->crfex_status . '</td>
                 </tr>
        
                 <tr>
                    <td><strong>Topic</strong></td>
                    <td colspan="3">' . $topicEX . '</td>
                 </tr>
        
                 <tr>
                    <td><strong>Customer name.</strong></td>
                    <td>' . getDataEmailEx($formno)->crfexcus_nameEN . '</td>
                    <td><strong>Sales reps</strong></td>
                    <td>' . getDataEmailEx($formno)->crfexcus_salesreps . '</td>
                 </tr>
        
                 <tr>
                    <td><strong>User post.</strong></td>
                    <td>' . getDataEmailEx($formno)->crfex_userpost . '</td>
                    <td><strong>User Dept.</strong></td>
                    <td>' . getDataEmailEx($formno)->crfex_userdept . '</td>
                 </tr>
        
                 <tr>
                    <td><strong>User code.</strong></td>
                    <td>' . getDataEmailEx($formno)->crfexcus_userecode . '</td>
                    <td><strong>Date.</strong></td>
                    <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_userdatetime) . '</td>
                 </tr>
        
                 <tr>
                    <td colspan="4" class="bghead"><b>Manager Approval results.</b></td>
                 </tr>
        
                 <tr>
                    <td><strong>Manager name.</strong></td>
                    <td>' . getDataEmailEx($formno)->crfex_mgrapp_username . '</td>
                    <td><strong>Date</strong></td>
                    <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_mgrapp_datetime) . '</td>
                 </tr>
        
                 <tr>
                    <td><strong>Status</strong></td>
                    <td>' . getDataEmailEx($formno)->crfex_mgrapp_status . '</td>
                    <td><strong>Reason</strong></td>
                    <td>' . getDataEmailEx($formno)->crfex_mgrapp_detail . '</td>
                 </tr>
        
       
                 <tr>
                    <td colspan="4" class="bghead"><b>Account Manager Approval results.</b></td>
                 </tr>
        
                 <tr>
                    <td><strong>Account Manager sign.</strong></td>
                    <td>' . getDataEmailEx($formno)->crfex_accmgr_username . '</td>
                    <td><strong>Date</strong></td>
                    <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_accmgr_datetime) . '</td>
                 </tr>
        
                 <tr>
                    <td><strong>Status</strong></td>
                    <td>' . getDataEmailEx($formno)->crfex_accmgr_status . '</td>
                    <td><strong>Reason</strong></td>
                    <td>' . getDataEmailEx($formno)->crfex_accmgr_detail . '</td>
                 </tr>
   


                 <tr>
                    <td colspan="4" class="bghead"><b>Account process.</b></td>
                 </tr>

                 <tr>
                 <td><strong>Memo.</strong></td>
                 <td colspan="3">' . getDataEmailEx($formno)->crfex_accmemo . '</td>
              </tr>
        
                 <tr>
                    <td><strong>Account sign.</strong></td>
                    <td>' . getDataEmailEx($formno)->crfex_accuserpost . '</td>
                    <td><strong>Date</strong></td>
                    <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_accdatetime) . '</td>
                 </tr>
        
                
                 <tr>
                    <td><strong>Go to form.</strong></td>
                    <td colspan="3"><a href="' . base_url('main/viewdataEx/') . getDataEmailEx($formno)->crfex_id . '">' . getDataEmailEx($formno)->crfexcus_formno . '</a></td>
                 </tr>
        
                 <tr>
                    <td><strong>Scan QrCode</strong></td>
                    <td colspan="3"><img src="' . base_url('upload/qrcode/') . $this->createQrcode($short_urlex,getDataEmailEx($formno)->crfex_id) . '"></td>
                 </tr>
        
                 </table>
                 ';



      //  Email Zone

      $ecode = getDataEmailEx($formno)->crfexcus_userecode;
      $option = getuserEmailToOwner($ecode);


      $to = array();
      $ecodeAr = array();
      foreach ($option->result_array() as $result) {
         $to[] = $result['memberemail'];
         $ecodeAr[] = $result['ecode'];
      }

      $deptcode = getDataEmailEx($formno)->crfexcus_userdeptcode;
      $option_cc = getuserEmailccOwner($deptcode);
      $cc = array();
      foreach ($option_cc->result_array() as $result_cc) {
         $cc[] = $result_cc['memberemail'];
      }

      emailSaveDataTH($subject, $body, $to, $cc);
      //  Email Zone

      // Notification center program
      $ecodeReadArr = $ecodeAr;

      $title = "[crf export] Your credit request form is completed.";
      $status = getDataEmailEx($formno)->crfex_status;
      $link = base_url('main/viewdataEx/').getDataEmailEx($formno)->crfex_id;
      $programname = "credit request form";

      $this->notifycenter->insertdataRead_template($ecodeReadArr , $title , $status , $link , $formno , $programname);
   }
   //End Step 6-2


//End Step 6
    function sendemail_toOwnerEx3($formno)
    {
 
       $topicEX = getDataEmailEx($formno)->crfex_topic;
       if (getDataEmailEx($formno)->crfex_curcustopic1 != '') {
          $topicEX .= " / " . getDataEmailEx($formno)->crfex_curcustopic1;
       }
       if (getDataEmailEx($formno)->crfex_curcustopic2 != '') {
          $topicEX .= " / " . getDataEmailEx($formno)->crfex_curcustopic2;
       }
 
       $short_urlex = base_url('qrcodeex/') . getDataEmailEx($formno)->crfex_id;
      //  $short_urlex = shorturl($longurlex);
 
 
       $subject = "[crf export] Your credit request form is completed.";
 
       $body = '
                <h2>Your credit request form is completed.</h2>
                <table>
                 <tr>
                    <td><strong>Form no.</strong></td>
                    <td>' . getDataEmailEx($formno)->crfexcus_formno . '</td>
                    <td><strong>Date create.</strong></td>
                    <td>' . conDateFromDb(getDataEmailEx($formno)->crfex_datecreate) . '</td>
                 </tr>
        
                 <tr>
                    <td><strong>Customer type.</strong></td>
                    <td>' . getDataEmailEx($formno)->crf_alltype_subnameEN . '</td>
                    <td><strong>Status.</strong></td>
                    <td>' . getDataEmailEx($formno)->crfex_status . '</td>
                 </tr>
        
                 <tr>
                    <td><strong>Topic</strong></td>
                    <td colspan="3">' . $topicEX . '</td>
                 </tr>
        
                 <tr>
                    <td><strong>Customer name.</strong></td>
                    <td>' . getDataEmailEx($formno)->crfexcus_nameEN . '</td>
                    <td><strong>Sales reps</strong></td>
                    <td>' . getDataEmailEx($formno)->crfexcus_salesreps . '</td>
                 </tr>
        
                 <tr>
                    <td><strong>User post.</strong></td>
                    <td>' . getDataEmailEx($formno)->crfex_userpost . '</td>
                    <td><strong>User Dept.</strong></td>
                    <td>' . getDataEmailEx($formno)->crfex_userdept . '</td>
                 </tr>
        
                 <tr>
                    <td><strong>User code.</strong></td>
                    <td>' . getDataEmailEx($formno)->crfexcus_userecode . '</td>
                    <td><strong>Date.</strong></td>
                    <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_userdatetime) . '</td>
                 </tr>
        
                 <tr>
                    <td colspan="4" class="bghead"><b>Manager Approval results.</b></td>
                 </tr>
        
                 <tr>
                    <td><strong>Manager name.</strong></td>
                    <td>' . getDataEmailEx($formno)->crfex_mgrapp_username . '</td>
                    <td><strong>Date</strong></td>
                    <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_mgrapp_datetime) . '</td>
                 </tr>
        
                 <tr>
                    <td><strong>Status</strong></td>
                    <td>' . getDataEmailEx($formno)->crfex_mgrapp_status . '</td>
                    <td><strong>Reason</strong></td>
                    <td>' . getDataEmailEx($formno)->crfex_mgrapp_detail . '</td>
                 </tr>
        
       
                 <tr>
                    <td colspan="4" class="bghead"><b>Account Manager Approval results.</b></td>
                 </tr>
        
                 <tr>
                    <td><strong>Account Manager sign.</strong></td>
                    <td>' . getDataEmailEx($formno)->crfex_accmgr_username . '</td>
                    <td><strong>Date</strong></td>
                    <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_accmgr_datetime) . '</td>
                 </tr>
        
                 <tr>
                    <td><strong>Status</strong></td>
                    <td>' . getDataEmailEx($formno)->crfex_accmgr_status . '</td>
                    <td><strong>Reason</strong></td>
                    <td>' . getDataEmailEx($formno)->crfex_accmgr_detail . '</td>
                 </tr>
   
                 <tr>
                    <td colspan="4" class="bghead"><b>Frist Deputy Managing Director Approval results.</b></td>
                 </tr>
        
                 <tr>
                    <td><strong>Director Sales sign.</strong></td>
                    <td>' . getDataEmailEx($formno)->crfex_directorapp_username . '</td>
                    <td><strong>Date</strong></td>
                    <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_directorapp_datetime) . '</td>
                 </tr>
        
                 <tr>
                    <td><strong>Status</strong></td>
                    <td>' . getDataEmailEx($formno)->crfex_directorapp_status . '</td>
                    <td><strong>Reason</strong></td>
                    <td>' . getDataEmailEx($formno)->crfex_directorapp_detail . '</td>
                 </tr>
 
                 <tr>
                    <td colspan="4" class="bghead"><b>Second Deputy Managing Director Approval results.</b></td>
                 </tr>
        
                 <tr>
                    <td><strong>Director Sales sign.</strong></td>
                    <td>' . getDataEmailEx($formno)->crfex_directorapp_username2 . '</td>
                    <td><strong>Date</strong></td>
                    <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_directorapp_datetime2) . '</td>
                 </tr>
        
                 <tr>
                    <td><strong>Status</strong></td>
                    <td>' . getDataEmailEx($formno)->crfex_directorapp_status2 . '</td>
                    <td><strong>Reason</strong></td>
                    <td>' . getDataEmailEx($formno)->crfex_directorapp_detail2 . '</td>
                 </tr>
 
                 <tr>
                 <td colspan="4" class="bghead"><b>Account process.</b></td>
              </tr>

              <tr>
              <td><strong>Memo.</strong></td>
              <td colspan="3">' . getDataEmailEx($formno)->crfex_accmemo . '</td>
           </tr>
     
              <tr>
                 <td><strong>Account sign.</strong></td>
                 <td>' . getDataEmailEx($formno)->crfex_accuserpost . '</td>
                 <td><strong>Date</strong></td>
                 <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_accdatetime) . '</td>
              </tr>
        
                 <tr>
                    <td><strong>Go to form.</strong></td>
                    <td colspan="3"><a href="' . base_url('main/viewdataEx/') . getDataEmailEx($formno)->crfex_id . '">' . getDataEmailEx($formno)->crfexcus_formno . '</a></td>
                 </tr>
        
                 <tr>
                    <td><strong>Scan QrCode</strong></td>
                    <td colspan="3"><img src="' . base_url('upload/qrcode/') . $this->createQrcode($short_urlex,getDataEmailEx($formno)->crfex_id) . '"></td>
                 </tr>
        
                 </table>
                 ';
 
 
 
       //  Email Zone
 
       $ecode = getDataEmailEx($formno)->crfexcus_userecode;
       $option = getuserEmailToOwner($ecode);
 
 
       $to = array();
       $ecodeAr = array();
       foreach ($option->result_array() as $result) {
          $to[] = $result['memberemail'];
          $ecodeAr[] = $result['ecode'];
       }
 
 
       $deptcode = getDataEmailEx($formno)->crfexcus_userdeptcode;
       $option_cc = getuserEmailccOwner($deptcode);
       $cc = array();
       foreach ($option_cc->result_array() as $result_cc) {
          $cc[] = $result_cc['memberemail'];
       }
 
       emailSaveDataTH($subject, $body, $to, $cc);
       //  Email Zone

      // Notification center program
      $ecodeReadArr = $ecodeAr;

      $title = "[crf export] Your credit request form is completed.";
      $status = getDataEmailEx($formno)->crfex_status;
      $link = base_url('main/viewdataEx/').getDataEmailEx($formno)->crfex_id;
      $programname = "credit request form";

      $this->notifycenter->insertdataRead_template($ecodeReadArr , $title , $status , $link , $formno , $programname);
    }
//End Step 6


//Manager not approve
function sendemail_ManagerNotApprove($formno)
{

   $topicEX = getDataEmailEx($formno)->crfex_topic;
   if (getDataEmailEx($formno)->crfex_curcustopic1 != '') {
      $topicEX .= " / " . getDataEmailEx($formno)->crfex_curcustopic1;
   }
   if (getDataEmailEx($formno)->crfex_curcustopic2 != '') {
      $topicEX .= " / " . getDataEmailEx($formno)->crfex_curcustopic2;
   }

   $short_urlex = base_url('qrcodeex/') . getDataEmailEx($formno)->crfex_id;
   // $short_urlex = shorturl($longurlex);


   $subject = "[crf export] Manager is not approve this form.";

   $body = '
                  <h2>Manager is not approve this form.</h2>
                  <table>
                  <tr>
                     <td><strong>Form no.</strong></td>
                     <td>' . getDataEmailEx($formno)->crfexcus_formno . '</td>
                     <td><strong>Date create.</strong></td>
                     <td>' . conDateFromDb(getDataEmailEx($formno)->crfex_datecreate) . '</td>
                  </tr>
         
                  <tr>
                     <td><strong>Customer type.</strong></td>
                     <td>' . getDataEmailEx($formno)->crf_alltype_subnameEN . '</td>
                     <td><strong>Status.</strong></td>
                     <td>' . getDataEmailEx($formno)->crfex_status . '</td>
                  </tr>
         
                  <tr>
                     <td><strong>Topic</strong></td>
                     <td colspan="3">' . $topicEX . '</td>
                  </tr>
         
                  <tr>
                     <td><strong>Customer name.</strong></td>
                     <td>' . getDataEmailEx($formno)->crfexcus_nameEN . '</td>
                     <td><strong>Sales reps</strong></td>
                     <td>' . getDataEmailEx($formno)->crfexcus_salesreps . '</td>
                  </tr>
         
                  <tr>
                     <td><strong>User post.</strong></td>
                     <td>' . getDataEmailEx($formno)->crfex_userpost . '</td>
                     <td><strong>User Dept.</strong></td>
                     <td>' . getDataEmailEx($formno)->crfex_userdept . '</td>
                  </tr>
         
                  <tr>
                     <td><strong>User code.</strong></td>
                     <td>' . getDataEmailEx($formno)->crfexcus_userecode . '</td>
                     <td><strong>Date.</strong></td>
                     <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_userdatetime) . '</td>
                  </tr>
         
                  <tr>
                     <td colspan="4" class="bghead"><b>Manager Approval results.</b></td>
                  </tr>
         
                  <tr>
                     <td><strong>Manager name.</strong></td>
                     <td>' . getDataEmailEx($formno)->crfex_mgrapp_username . '</td>
                     <td><strong>Date</strong></td>
                     <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_mgrapp_datetime) . '</td>
                  </tr>
         
                  <tr>
                     <td><strong>Status</strong></td>
                     <td>' . getDataEmailEx($formno)->crfex_mgrapp_status . '</td>
                     <td><strong>Reason</strong></td>
                     <td>' . getDataEmailEx($formno)->crfex_mgrapp_detail . '</td>
                  </tr>
         
                  
                  <tr>
                     <td><strong>Go to form.</strong></td>
                     <td colspan="3"><a href="' . base_url('main/viewdataEx/') . getDataEmailEx($formno)->crfex_id . '">' . getDataEmailEx($formno)->crfexcus_formno . '</a></td>
                  </tr>
         
                  <tr>
                     <td><strong>Scan QrCode</strong></td>
                     <td colspan="3"><img src="' . base_url('upload/qrcode/') . $this->createQrcode($short_urlex,getDataEmailEx($formno)->crfex_id) . '"></td>
                  </tr>
         
                  </table>
                  ';



   //  Email Zone

   $ecode = getDataEmailEx($formno)->crfexcus_userecode;
   $option = getuserEmailToOwner($ecode);


   $to = array();
   $ecodeAr = array();
   foreach ($option->result_array() as $result) {
      $to[] = $result['memberemail'];
      $ecodeAr[] = $result['ecode'];
   }

   //  $to = array(
   //      "chainarong_k@saleecolour.com",
   //  );

   $deptcode = getDataEmailEx($formno)->crfexcus_userdeptcode;
   $option_cc = getuserEmailccOwner($deptcode);
   $cc = array();
   foreach ($option_cc->result_array() as $result_cc) {
      $cc[] = $result_cc['memberemail'];
   }

   $to = array_unique($to);
   $cc = array_unique($cc);
   $ecodeAr = array_unique($ecodeAr);

   emailSaveDataTH($subject, $body, $to, $cc);
   //  Email Zone

   // Notification center program
   $ecodeReadArr = $ecodeAr;

   $title = "[crf export] Manager is not approve this form.";
   $status = getDataEmailEx($formno)->crfex_status;
   $link = base_url('main/viewdataEx/').getDataEmailEx($formno)->crfex_id;
   $programname = "credit request form";

   $this->notifycenter->insertdataRead_template($ecodeReadArr , $title , $status , $link , $formno , $programname);
}
//Manager not approve



//Account manager not approve
function sendemail_AccMgrNotApprove($formno)
{

   $topicEX = getDataEmailEx($formno)->crfex_topic;
   if (getDataEmailEx($formno)->crfex_curcustopic1 != '') {
      $topicEX .= " / " . getDataEmailEx($formno)->crfex_curcustopic1;
   }
   if (getDataEmailEx($formno)->crfex_curcustopic2 != '') {
      $topicEX .= " / " . getDataEmailEx($formno)->crfex_curcustopic2;
   }

   $short_urlex = base_url('qrcodeex/') . getDataEmailEx($formno)->crfex_id;
   // $short_urlex = shorturl($longurlex);


   $subject = "[crf export] Account manager not approve this form.";

   $body = '
               <h2>Account manager not approve this form.</h2>
               <table>
                  <tr>
                     <td><strong>Form no.</strong></td>
                     <td>' . getDataEmailEx($formno)->crfexcus_formno . '</td>
                     <td><strong>Date create.</strong></td>
                     <td>' . conDateFromDb(getDataEmailEx($formno)->crfex_datecreate) . '</td>
                  </tr>
         
                  <tr>
                     <td><strong>Customer type.</strong></td>
                     <td>' . getDataEmailEx($formno)->crf_alltype_subnameEN . '</td>
                     <td><strong>Status.</strong></td>
                     <td>' . getDataEmailEx($formno)->crfex_status . '</td>
                  </tr>
         
                  <tr>
                     <td><strong>Topic</strong></td>
                     <td colspan="3">' . $topicEX . '</td>
                  </tr>
         
                  <tr>
                     <td><strong>Customer name.</strong></td>
                     <td>' . getDataEmailEx($formno)->crfexcus_nameEN . '</td>
                     <td><strong>Sales reps</strong></td>
                     <td>' . getDataEmailEx($formno)->crfexcus_salesreps . '</td>
                  </tr>
         
                  <tr>
                     <td><strong>User post.</strong></td>
                     <td>' . getDataEmailEx($formno)->crfex_userpost . '</td>
                     <td><strong>User Dept.</strong></td>
                     <td>' . getDataEmailEx($formno)->crfex_userdept . '</td>
                  </tr>
         
                  <tr>
                     <td><strong>User code.</strong></td>
                     <td>' . getDataEmailEx($formno)->crfexcus_userecode . '</td>
                     <td><strong>Date.</strong></td>
                     <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_userdatetime) . '</td>
                  </tr>
         
                  <tr>
                     <td colspan="4" class="bghead"><b>Manager Approval results.</b></td>
                  </tr>
         
                  <tr>
                     <td><strong>Manager name.</strong></td>
                     <td>' . getDataEmailEx($formno)->crfex_mgrapp_username . '</td>
                     <td><strong>Date</strong></td>
                     <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_mgrapp_datetime) . '</td>
                  </tr>
         
                  <tr>
                     <td><strong>Status</strong></td>
                     <td>' . getDataEmailEx($formno)->crfex_mgrapp_status . '</td>
                     <td><strong>Reason</strong></td>
                     <td>' . getDataEmailEx($formno)->crfex_mgrapp_detail . '</td>
                  </tr>

                  
         
      
                  <tr>
                     <td colspan="4" class="bghead"><b>Account Manager Approval results.</b></td>
                  </tr>
         
                  <tr>
                     <td><strong>Account Manager sign.</strong></td>
                     <td>' . getDataEmailEx($formno)->crfex_accmgr_username . '</td>
                     <td><strong>Date</strong></td>
                     <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_accmgr_datetime) . '</td>
                  </tr>
         
                  <tr>
                     <td><strong>Status</strong></td>
                     <td>' . getDataEmailEx($formno)->crfex_accmgr_status . '</td>
                     <td><strong>Reason</strong></td>
                     <td>' . getDataEmailEx($formno)->crfex_accmgr_detail . '</td>
                  </tr>
   
                  
         
               
                  <tr>
                     <td><strong>Go to form.</strong></td>
                     <td colspan="3"><a href="' . base_url('main/viewdataEx/') . getDataEmailEx($formno)->crfex_id . '">' . getDataEmailEx($formno)->crfexcus_formno . '</a></td>
                  </tr>
         
                  <tr>
                     <td><strong>Scan QrCode</strong></td>
                     <td colspan="3"><img src="' . base_url('upload/qrcode/') . $this->createQrcode($short_urlex,getDataEmailEx($formno)->crfex_id) . '"></td>
                  </tr>
         
                  </table>
                  ';



   //  Email Zone

   $ecode = getDataEmailEx($formno)->crfexcus_userecode;
   $option = getuserEmailToOwner($ecode);


   $to = array();
   $ecodeAr = array();
   foreach ($option->result_array() as $result) {
      $to[] = $result['memberemail'];
      $ecodeAr[] = $result['ecode'];
   }


   $deptcode = getDataEmailEx($formno)->crfexcus_userdeptcode;
   $option_cc = getuserEmailccOwner($deptcode);
   $cc = array();
   foreach ($option_cc->result_array() as $result_cc) {
      $cc[] = $result_cc['memberemail'];
   }

   $to = array_unique($to);
   $cc = array_unique($cc);
   $ecodeAr = array_unique($ecodeAr);

   emailSaveDataTH($subject, $body, $to, $cc);
   //  Email Zone

   // Notification center program
   $ecodeReadArr = $ecodeAr;

   $title = "[crf export] Account manager not approve this form.";
   $status = getDataEmailEx($formno)->crfex_status;
   $link = base_url('main/viewdataEx/').getDataEmailEx($formno)->crfex_id;
   $programname = "credit request form";

   $this->notifycenter->insertdataRead_template($ecodeReadArr , $title , $status , $link , $formno , $programname);
}
//Account manager not approve



//Director not approve
function sendemail_DirectorNotApprove($formno)
{

   $topicEX = getDataEmailEx($formno)->crfex_topic;
   if (getDataEmailEx($formno)->crfex_curcustopic1 != '') {
      $topicEX .= " / " . getDataEmailEx($formno)->crfex_curcustopic1;
   }
   if (getDataEmailEx($formno)->crfex_curcustopic2 != '') {
      $topicEX .= " / " . getDataEmailEx($formno)->crfex_curcustopic2;
   }

   $short_urlex = base_url('qrcodeex/') . getDataEmailEx($formno)->crfex_id;
   // $short_urlex = shorturl($longurlex);


   $subject = "[crf export] Director not approve this form.";

   $body = '
            <h2>Director not approve this form.</h2>
            <table>
             <tr>
                <td><strong>Form no.</strong></td>
                <td>' . getDataEmailEx($formno)->crfexcus_formno . '</td>
                <td><strong>Date create.</strong></td>
                <td>' . conDateFromDb(getDataEmailEx($formno)->crfex_datecreate) . '</td>
             </tr>
    
             <tr>
                <td><strong>Customer type.</strong></td>
                <td>' . getDataEmailEx($formno)->crf_alltype_subnameEN . '</td>
                <td><strong>Status.</strong></td>
                <td>' . getDataEmailEx($formno)->crfex_status . '</td>
             </tr>
    
             <tr>
                <td><strong>Topic</strong></td>
                <td colspan="3">' . $topicEX . '</td>
             </tr>
    
             <tr>
                <td><strong>Customer name.</strong></td>
                <td>' . getDataEmailEx($formno)->crfexcus_nameEN . '</td>
                <td><strong>Sales reps</strong></td>
                <td>' . getDataEmailEx($formno)->crfexcus_salesreps . '</td>
             </tr>
    
             <tr>
                <td><strong>User post.</strong></td>
                <td>' . getDataEmailEx($formno)->crfex_userpost . '</td>
                <td><strong>User Dept.</strong></td>
                <td>' . getDataEmailEx($formno)->crfex_userdept . '</td>
             </tr>
    
             <tr>
                <td><strong>User code.</strong></td>
                <td>' . getDataEmailEx($formno)->crfexcus_userecode . '</td>
                <td><strong>Date.</strong></td>
                <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_userdatetime) . '</td>
             </tr>
    
             <tr>
                <td colspan="4" class="bghead"><b>Manager Approval results.</b></td>
             </tr>
    
             <tr>
                <td><strong>Manager name.</strong></td>
                <td>' . getDataEmailEx($formno)->crfex_mgrapp_username . '</td>
                <td><strong>Date</strong></td>
                <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_mgrapp_datetime) . '</td>
             </tr>
    
             <tr>
                <td><strong>Status</strong></td>
                <td>' . getDataEmailEx($formno)->crfex_mgrapp_status . '</td>
                <td><strong>Reason</strong></td>
                <td>' . getDataEmailEx($formno)->crfex_mgrapp_detail . '</td>
             </tr>
    
             
             <tr>
                <td colspan="4" class="bghead"><b>Account Manager Approval results.</b></td>
             </tr>
    
             <tr>
                <td><strong>Account Manager sign.</strong></td>
                <td>' . getDataEmailEx($formno)->crfex_accmgr_username . '</td>
                <td><strong>Date</strong></td>
                <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_accmgr_datetime) . '</td>
             </tr>
    
             <tr>
                <td><strong>Status</strong></td>
                <td>' . getDataEmailEx($formno)->crfex_accmgr_status . '</td>
                <td><strong>Reason</strong></td>
                <td>' . getDataEmailEx($formno)->crfex_accmgr_detail . '</td>
             </tr>

             <tr>
                <td colspan="4" class="bghead"><b>Frist Deputy Managing Director Approval results.</b></td>
             </tr>
    
             <tr>
                <td><strong>Director Sales sign.</strong></td>
                <td>' . getDataEmailEx($formno)->crfex_directorapp_username . '</td>
                <td><strong>Date</strong></td>
                <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_directorapp_datetime) . '</td>
             </tr>
    
             <tr>
                <td><strong>Status</strong></td>
                <td>' . getDataEmailEx($formno)->crfex_directorapp_status . '</td>
                <td><strong>Reason</strong></td>
                <td>' . getDataEmailEx($formno)->crfex_directorapp_detail . '</td>
             </tr>

             <tr>
                <td colspan="4" class="bghead"><b>Second Deputy Managing Director Approval results.</b></td>
             </tr>
    
             <tr>
                <td><strong>Director Sales sign.</strong></td>
                <td>' . getDataEmailEx($formno)->crfex_directorapp_username2 . '</td>
                <td><strong>Date</strong></td>
                <td>' . conDateTimeFromDb(getDataEmailEx($formno)->crfex_directorapp_datetime2) . '</td>
             </tr>
    
             <tr>
                <td><strong>Status</strong></td>
                <td>' . getDataEmailEx($formno)->crfex_directorapp_status2 . '</td>
                <td><strong>Reason</strong></td>
                <td>' . getDataEmailEx($formno)->crfex_directorapp_detail2 . '</td>
             </tr>

             
    
             <tr>
                <td><strong>Go to form.</strong></td>
                <td colspan="3"><a href="' . base_url('main/viewdataEx/') . getDataEmailEx($formno)->crfex_id . '">' . getDataEmailEx($formno)->crfexcus_formno . '</a></td>
             </tr>
    
             <tr>
                <td><strong>Scan QrCode</strong></td>
                <td colspan="3"><img src="' . base_url('upload/qrcode/') . $this->createQrcode($short_urlex,getDataEmailEx($formno)->crfex_id) . '"></td>
             </tr>
    
             </table>
             ';



   //  Email Zone

   $ecode = getDataEmailEx($formno)->crfexcus_userecode;
   $option = getuserEmailToOwner($ecode);


   $to = array();
   $ecodeAr = array();
   foreach ($option->result_array() as $result) {
      $to[] = $result['memberemail'];
      $ecodeAr[] = $result['ecode'];
   }


   $deptcode = getDataEmailEx($formno)->crfexcus_userdeptcode;
   $option_cc = getuserEmailccOwner($deptcode);
   $cc = array();
   foreach ($option_cc->result_array() as $result_cc) {
      $cc[] = $result_cc['memberemail'];
   }

   emailSaveDataTH($subject, $body, $to, $cc);
   //  Email Zone

   // Notification center program
   $ecodeReadArr = $ecodeAr;

   $title = "[crf export] Director not approve this form.";
   $status = getDataEmailEx($formno)->crfex_status;
   $link = base_url('main/viewdataEx/').getDataEmailEx($formno)->crfex_id;
   $programname = "credit request form";

   $this->notifycenter->insertdataRead_template($ecodeReadArr , $title , $status , $link , $formno , $programname);
}
//Director not approve



   public function saveSettingEmail()
   {
      $email_account = "";
      $email_password = "";

      $email_account = $this->input->post("email_account");
      $email_password = md5($this->input->post("email_password"));

      $arSaveEmail = array(
         "email_user" => $email_account,
         "email_password" => $email_password
      );

      if ($this->db->insert("email_information", $arSaveEmail)) {
         echo "Save data success";
      } else {
         echo "Save data failed";
      }
   }



}
// End Email model
