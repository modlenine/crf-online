<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Customers_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->db3 = $this->load->database('sql_custtable', TRUE);
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index()
    {
    }

    private function uploadFiles($fileinput = '', $filenameType = '', $cusid)
    {

        $time = date("H-i-s"); //ดึงวันที่และเวลามาก่อน
        $file_name = $_FILES[$fileinput]['name'];
        $filename_type = substr($file_name, -4);
        $file_name_date = substr_replace($file_name, $cusid . "-" . $filenameType . "-" . $time . $filename_type, 0);

        $file_tmp = $_FILES[$fileinput]['tmp_name'];
        move_uploaded_file($file_tmp, "upload/" . $file_name_date);
        $filelocation = "upload";


        // print_r($file_name_date);
        // echo "<br>" . "Copy/Upload Complete" . "<br>";
        return $file_name_date;
    }

    public function saveCustomer()
    {

        $getCustomerNumber = getCustomerNumber();

        $report_date = "";
        $report_month = "";
        $report_year = "";

        $resultFilePersonal = "";
        $resultFile1 = "";
        $resultFile2 = "";
        $resultFile3 = "";
        $resultFile4 = "";
        $resultFile5 = "";
        $resultFile6 = "";

        $conReportDate = date_create($this->input->post("crf_datecreate"));
        $report_date = date_format($conReportDate, "d");

        $conReportMonth = date_create($this->input->post("crf_datecreate"));
        $report_month = date_format($conReportMonth, "m");

        $conReportYear = date_create($this->input->post("crf_datecreate"));
        $report_year = date_format($conReportYear, "Y");

        if (isset($_POST["addcus_submit"])) {
            // ถ้าเลือกประเภทลูกค้า = ลูกค้าใหม่
            $cuscode = $this->input->post("addcus_customercode");
            $area = $this->input->post("addcus_company");
            if(checkCuscode($cuscode , $area)->num_rows() != 0){
                echo "<script>";
                echo "alert('ลูกค้าดังกล่าวมีอยู่ในฐานข้อมูลแล้ว')";
                echo "</script>";
                header("refresh:0; url=".base_url("customers/addCustomer"));
            }else{

                if ($this->input->post("crf_person_type") == "natural"){

                    if ($_FILES["crf_file_person"]["name"] != "") {
                        $fileperson = "crf_file_person";
                        $fileTypeperson = "personalid";
                        $this->uploadFiles($fileperson, $fileTypeperson, $getCustomerNumber);
                        $resultFilePersonal = $this->uploadFiles($fileperson, $fileTypeperson, $getCustomerNumber);
                    } else {
                        $resultFilePersonal = "";
                        echo "ไม่พบการแนบไฟล์ในการอัพโหลดไฟล์ สำเนาบัตรประชาชน<br>";
                    }
    
                }else if($this->input->post("crf_person_type") == "juristic"){
    
                    if ($_FILES["addcus_file1"]["name"] != "") {
                        $file1 = "addcus_file1";
                        $fileType1 = "ภพ20";
                        $this->uploadFiles($file1, $fileType1, $getCustomerNumber);
                        $resultFile1 = $this->uploadFiles($file1, $fileType1, $getCustomerNumber);
                    } else {
                        $resultFile1 = "";
                        echo "ไม่พบการแนบไฟล์ในการอัพโหลดไฟล์ ภพ.20<br>";
                    }
        
                    if ($_FILES["addcus_file2"]["name"] != "") {
                        $file2 = "addcus_file2";
                        $fileType2 = "หนังสือรับรอง";
                        $this->uploadFiles($file2, $fileType2, $getCustomerNumber);
                        $resultFile2 = $this->uploadFiles($file2, $fileType2, $getCustomerNumber);
                    } else {
                        $resultFile2 = "";
                        echo "ไม่พบการแนบไฟล์ในการอัพโหลดไฟล์ หนังสือรับรอง<br>";
                    }
        
                    if ($_FILES["addcus_file3"]["name"] != "") {
                        $file3 = "addcus_file3";
                        $fileType3 = "ข้อมูลทั่วไป";
                        $this->uploadFiles($file3, $fileType3, $getCustomerNumber);
                        $resultFile3 = $this->uploadFiles($file3, $fileType3, $getCustomerNumber);
                    } else {
                        $resultFile3 = "";
                        echo "ไม่พบการแนบไฟล์ในการอัพโหลดไฟล์ ข้อมูลทั่วไป<br>";
                    }
        
                    if ($_FILES["addcus_file4"]["name"] != "") {
                        $file4 = "addcus_file4";
                        $fileType4 = "งบแสดงฐานะทางการเงิน";
                        $this->uploadFiles($file4, $fileType4, $getCustomerNumber);
                        $resultFile4 = $this->uploadFiles($file4, $fileType4, $getCustomerNumber);
                    } else {
                        $resultFile4 = "";
                        echo "ไม่พบการแนบไฟล์ในการอัพโหลดไฟล์ งบแสดงฐานะทางการเงิน<br>";
                    }
        
                    if ($_FILES["addcus_file5"]["name"] != "") {
                        $file5 = "addcus_file5";
                        $fileType5 = "งบกำไรขาดทุน";
                        $this->uploadFiles($file5, $fileType5, $getCustomerNumber);
                        $resultFile5 = $this->uploadFiles($file5, $fileType5, $getCustomerNumber);
                    } else {
                        $resultFile5 = "";
                        echo "ไม่พบการแนบไฟล์ในการอัพโหลดไฟล์ งบกำไรขาดทุน<br>";
                    }
        
                    if ($_FILES["addcus_file6"]["name"] != "") {
                        $file6 = "addcus_file6";
                        $fileType6 = "อัตราส่วนสภาพคล่อง";
                        $this->uploadFiles($file6, $fileType6, $getCustomerNumber);
                        $resultFile6 = $this->uploadFiles($file6, $fileType6, $getCustomerNumber);
                    } else {
                        $resultFile6 = "";
                        echo "ไม่พบการแนบไฟล์ในการอัพโหลดไฟล์ อัตราส่วนสภาพคล่อง<br>";
                    }
    
                }
                
    
     
    
                // แนบไฟล์แผนที่วางบิล
                $resulttablebill = "";
                if ($_FILES["crf_tablebill"]["name"] != "") {
                    $tablebill = "crf_tablebill";
                    $tablebillname = "ตารางวางบิล";
                    $this->uploadFiles($tablebill, $tablebillname, $getCustomerNumber);
                    $resulttablebill = $this->uploadFiles($tablebill, $tablebillname, $getCustomerNumber);
                } else {
                    echo "ไม่พบการแนบไฟล์ในการอัพโหลดไฟล์ ตารางวางบิล<br>";
                }
                $resultmapbill = "";
                if ($_FILES["crf_mapbill"]["name"] != "") {
                    $mapbill = "crf_mapbill";
                    $mapbillname = "แผนที่ที่ไปวางบิล";
                    $this->uploadFiles($mapbill, $mapbillname, $getCustomerNumber);
                    $resultmapbill = $this->uploadFiles($mapbill, $mapbillname, $getCustomerNumber);
                } else {
                    echo "ไม่พบการแนบไฟล์ในการอัพโหลดไฟล์ แผนที่ที่ไปวางบิล<br>";
                }
    
                $resultmapbill2 = "";
                if ($_FILES["crf_mapbill2"]["name"] != "") {
                    $mapbill2 = "crf_mapbill2";
                    $mapbillname2 = "แผนที่ที่ไปวางบิล2";
                    $this->uploadFiles($mapbill2, $mapbillname2, $getCustomerNumber);
                    $resultmapbill2 = $this->uploadFiles($mapbill2, $mapbillname2, $getCustomerNumber);
                } else {
                    echo "ไม่พบการแนบไฟล์ในการอัพโหลดไฟล์ แผนที่ที่ไปวางบิล<br>";
                }
                // แนบไฟล์แผนที่วางบิล
    
    
                // แนบตารางวางบิลรับเช็ค
                $result_recive_cheuqetable = "";
                if ($_FILES["crf_recive_cheuqetable"]["name"] != "") {
                    $recive_cheuqetable = "crf_recive_cheuqetable";
                    $recive_cheuqetablename = "ตารางวางบิลรับเช็ค";
                    $this->uploadFiles($recive_cheuqetable, $recive_cheuqetablename, $getCustomerNumber);
                    $result_recive_cheuqetable = $this->uploadFiles($recive_cheuqetable, $recive_cheuqetablename, $getCustomerNumber);
                } else {
                    echo "ไม่พบการแนบไฟล์ในการอัพโหลดไฟล์ ตารางวางบิลรับเช็ค<br>";
                }
    
                // แนบไฟล์แผนที่ลูกค้า
                $customermapfile = "";
                if ($_FILES["addcus_mapfile"]["name"] != "") {
                    $crf_mapfile = "addcus_mapfile";
                    $crf_mapfilename = "แผนที่ตั้งของลูกค้า";
                    $this->uploadFiles($crf_mapfile, $crf_mapfilename, $getCustomerNumber);
                    $customermapfile = $this->uploadFiles($crf_mapfile, $crf_mapfilename, $getCustomerNumber);
                } else {
                    echo "ไม่พบการแนบไฟล์ในการอัพโหลดไฟล์ แผนที่ตั้งของลูกค้า<br>";
                }
    
    
    
                $arcustomer = array(
                    "crfcus_id" => $getCustomerNumber,
                    // "crfcus_formno" => $getFormNo,
                    "crfcus_area" => $this->input->post("addcus_company"),
                    "crfcus_code" => $this->input->post("addcus_customercode"),
                    "crfcus_salesreps" => $this->input->post("addcus_salesreps"),
                    "crfcus_name" => $this->input->post("addcus_customername"),
                    "crfcus_comdatecreate" => $this->input->post("addcus_cuscompanycreate"),
                    "crfcus_addresstype" => $this->input->post("addcus_addresstype"),
                    "crfcus_address" => $this->input->post("addcus_addressname"),
                    "crfcus_contactname" => $this->input->post("addcus_namecontact"),
                    "crfcus_phone" => $this->input->post("addcus_telcontact"),
                    "crfcus_fax" => $this->input->post("addcus_faxcontact"),
                    "crfcus_email" => $this->input->post("addcus_emailcontact"),
                    "crfcus_etax_email" => $this->input->post("addcus_etax_emailcontact"),
                    "crfcus_regiscapital" => conPrice($this->input->post("addcus_regiscost")),
                    "crfcus_companytype" => $this->input->post("crf_companytype"),
                    "crfcus_comtype2" => $this->input->post("crf_companytype2"),
                    "crfcus_comtype31" => $this->input->post("crf_companytype3_1_1"),
                    "crfcus_comtype32" => $this->input->post("crf_companytype3_1_2"),
                    "crfcus_comtype33" => $this->input->post("crf_companytype3_2_1"),
                    "crfcus_comtype34" => $this->input->post("crf_companytype3_2_2"),
                    "crfcus_typebussi" => $this->input->post("crf_typeofbussi"),
                    "crfcus_forecast" => $this->input->post("addcus_forecast"),
                    "crfcus_personal" => $resultFilePersonal,
                    "crfcus_file1" => $resultFile1,
                    "crfcus_file2" => $resultFile2,
                    "crfcus_file3" => $resultFile3,
                    "crfcus_file4" => $resultFile4,
                    "crfcus_file5" => $resultFile5,
                    "crfcus_file6" => $resultFile6,
                    "crfcus_creditterm" => $this->input->post("addcus_creditterm"),
                    "crfcus_conditionbill" => $this->input->post("crf_condition_bill"),
                    "crfcus_tablebill" => $resulttablebill,
                    "crfcus_mapbill" => $resultmapbill,
                    "crfcus_datebill" => $this->input->post("crf_datebill"),
                    "crfcus_mapbill2" => $resultmapbill2,
                    "crfcus_conditionmoney" => $this->input->post("crf_condition_money"),
                    "crfcus_cheuqetable" => $result_recive_cheuqetable,
                    "crfcus_cheuqedetail" => $this->input->post("crf_recive_cheuqedetail"),
                    "crfcus_moneylimit" => conPrice($this->input->post("crf_finance_req_number")),
                    "crfcus_usercreate" => $this->input->post("crf_userpost"),
                    "crfcus_usercreate_ecode" => $this->input->post("crf_userecodepost"),
                    "crfcus_usercreate_deptcode" => $this->input->post("crf_userdeptcodepost"),
                    "crfcus_datemodify" => date("Y-m-d H:i:s"),
                    "crfcus_taxid" => $this->input->post("addcus_customertaxid"), //update 12-05-2020
                    "crfcus_branch" => $this->input->post("addcus_customerbranch"), //update 12-05-2020
                    "crfcus_mapurl" => $this->input->post("addcus_mapurl"), //update 12-05-2020
                    "crfcus_mapfile" => $customermapfile, //update 12-05-2020
                    "crfcus_products" => $this->input->post("addcus_customer_product") //update 12-05-2020
                );
                $this->db->insert("crf_customers",  $arcustomer);
    
    
    
                if (isset($_POST["crf_primanage_dept"])) {
                    $crf_primanage_dept = $this->input->post('crf_primanage_dept');
    
                    foreach ($crf_primanage_dept as $key => $rs) {
    
                        $arsavePri = array(
                            "crf_pricusid" => $getCustomerNumber,
                            "crf_primanage_dept" => $rs,
                            "crf_primanage_name" => $this->input->post("crf_primanage_name")[$key],
                            "crf_primanage_posi" => $this->input->post("crf_primanage_posi")[$key],
                            "crf_primanage_email" => $this->input->post("crf_primanage_email")[$key]
                        );
                        $this->db->insert("crf_pri_manage", $arsavePri);
                    }
                }
    
                if (isset($_POST["crf_process"])) {
                    $crf_process = $this->input->post("crf_process");
    
                    foreach ($crf_process as $key => $rs) {
    
                        $arsaveProcess = array(
                            "crf_cusid" => $getCustomerNumber,
                            "crf_process_name" => $rs
                        );
                        $this->db->insert("crf_process_use",  $arsaveProcess);
                    }
                }
    
    
                //Update User log table
                $aruserlog = array(
                    "crfuserlog_datetime" => date("Y-m-d H:i:s"),
                    "crfuserlog_activity" => "สร้างลูกค้าใหม่",
                    "crfuserlog_username" => $this->input->post("crf_userpost"),
                    "crfuserlog_deptcode" => $this->input->post("crf_userdeptcodepost"),
                    "crfuserlog_ecode" => $this->input->post("crf_userecodepost")
                );
                $this->db->insert("crf_userlog", $aruserlog);
    
                // $this->email_model->sendemail_savedatath($getFormNo);

                header("refresh:0; url=".base_url());

            }

        }
    }


    public function checkCustomerCode()
    {
        $cuscode = $this->input->post("cuscode");
        $cusarea = $this->input->post("area");

        $queryforcheckcuscode = $this->db->query("SELECT crfcus_code FROM crf_customers WHERE crfcus_code = '$cuscode' and crfcus_area = '$cusarea' ");
        echo $queryforcheckcuscode->num_rows();
    }


    public function saveCustomerEx()
    {
        $getCustomerNumber = getCustomerNumberEX();


        if (isset($_POST['addcusex_submit'])) {

            $cuscode = $this->input->post("addcusex_customercode");
            $area = $this->input->post("addcusex_company");

            if(checkExcuscode($cuscode , $area)->num_rows() != 0){
                echo "<script>";
                echo "alert('ลูกค้าดังกล่าวมีอยู่ในฐานข้อมูลแล้ว')";
                echo "</script>";
                header("refresh:0; url=".base_url("customers/addCustomerEx"));
            }else{
                if ($_FILES["addcusex_file"]["name"] != "") {
                    $file = "addcusex_file";
                    $fileType = "Document";
                    $this->uploadFiles($file, $fileType, $getCustomerNumber);
                    $resultFile = $this->uploadFiles($file, $fileType, $getCustomerNumber);
                } else {
                    $resultFile = "";
                    echo "Not found document !<br>";
                }
    
    
                $arcustomer = array(
                    "crfexcus_code" => $this->input->post("addcusex_customercode"),
                    "crfexcus_area" => $this->input->post("addcusex_company"),
                    "crfexcus_id" => $getCustomerNumber,
                    "crfexcus_datecreate" => conDateToDb($this->input->post("addcusex_datecreate")),
                    "crfexcus_salesreps" => $this->input->post("addcusex_salesreps"),
                    "crfexcus_nameEN" => $this->input->post("addcusex_cusnameEN"),
                    "crfexcus_nameTH" => $this->input->post("addcusex_cusnameTH"),
                    "crfexcus_address" => $this->input->post("addcusex_address"),
                    "crfexcus_file" => $resultFile,
                    "crfexcus_tel" => $this->input->post("addcusex_tel"),
                    "crfexcus_fax" => $this->input->post("addcusex_fax"),
                    "crfexcus_email" => $this->input->post("addcusex_email"),
                    "crfexcus_payment" => $this->input->post("addcusex_payment"),
                    "crfexcus_creditlimit" => conPrice($this->input->post("addcusex_creditlimit")),
                    "crfexcus_term" => $this->input->post("addcusex_term"),
                    "crfexcus_discount" => $this->input->post("addcusex_discount"),
                    "crfexcus_bg" => $this->input->post("addcusex_combg"),
                    "crfexcus_usercreate" => $this->input->post("addcusex_usercreate"),
                    "crfexcus_userecode" => $this->input->post("addcusex_userecode"),
                    "crfexcus_userdeptcode" => $this->input->post("addcusex_userdeptcode"),
                    "crfexcus_userdatetimecreate" => conDateTimeToDb($this->input->post("addcusex_userdatetime"))
                );
    
                $this->db->insert("crfex_customers", $arcustomer);
                header("refresh:0; url=".base_url(""));
            }

           
        }
    }

    public function checkCustomerCodeEx()
    {
        $cuscode = $this->input->post("cuscode");
        $cusarea = $this->input->post("area");

        $queryforcheckcuscode = $this->db->query("SELECT crfexcus_code FROM crfex_customers WHERE crfexcus_code = '$cuscode' and crfexcus_area = '$cusarea' ");
        echo $queryforcheckcuscode->num_rows();
    }



    // Search customer data zone
    public function searchcustomerdata()
    {
        $cuscode = $this->input->post("cuscode");
        $query = $this->db3->query("SELECT TOP 10 
        accountnum,
        paymtermid,
        name,
        address,
        phone,
        telefax,
        email,
        bpc_whtid,
        dataAreaId,
        -- SLC_idBranchTxt,
        slc_fname,
        CreditMax
         FROM custtable where accountnum like '$cuscode%' and accountnum NOT LIKE 'EX%' and accountnum NOT LIKE 'BR%' ");
        $output = "";
        foreach ($query->result() as $rs) {

            switch ($rs->paymtermid) {
                case "Advance":
                    $creditid = 1;
                    $creditname = "Advance ( โอนเงินก่อนส่งของ )";
                    break;
                case "CASH":
                    $creditid = 2;
                    $creditname = "Cash";
                    break;
                case "7D":
                    $creditid = 3;
                    $creditname = "7 Day";
                    break;
                case "15D":
                    $creditid = 4;
                    $creditname = "15 Day";
                    break;
                case "30D":
                    $creditid = 5;
                    $creditname = "30 Day";
                    break;
                case "45D":
                    $creditid = 6;
                    $creditname = "45 Day";
                    break;
                case "60D":
                    $creditid = 7;
                    $creditname = "60 Day";
                    break;
                case "75D":
                    $creditid = 8;
                    $creditname = "75 Day";
                    break;
                case "90D":
                    $creditid = 9;
                    $creditname = "90 Day";
                    break;
                case "120D":
                    $creditid = 10;
                    $creditname = "120 Day";
                    break;
                default:
                    $creditid = "";
                    $creditname = "";
                break;
            }
        $conCredit = number_format($rs->CreditMax,2);
            $output .= "<ul class='list-group'>";
            $output .= "<a href='javascript:void(0)' class='selectCusCodeManualcode'

        data_addcus_code = '$rs->accountnum'
        data_addcus_name = '$rs->name'
        data_addcus_address = '$rs->address'
        data_addcus_phone = '$rs->phone'
        data_addcus_fax = '$rs->telefax'
        data_addcus_email = '$rs->email'
        data_addcus_taxid = '$rs->bpc_whtid'
        data_addcus_area = '$rs->dataAreaId'
        data_addcus_branch = ''
        data_addcus_termid = '$creditid'
        data_addcus_termname = '$creditname'
        data_addcus_creditlimit = '$conCredit'
        data_addcus_fristname = '$rs->slc_fname'
        
        ><li class='list-group-item'>" . $rs->accountnum . "&nbsp;" . $rs->name . " (" . $rs->dataAreaId . ")" . "</li></a>";
            $output .= "</ul>";
        }

        echo $output;
    }


    // Search customer data zone
    public function searchcustomerdataname()
    {
        $cusname = $this->input->post("cusname");
        $query = $this->db3->query("SELECT TOP 10 
        accountnum,
        paymtermid,
        name,
        address,
        phone,
        telefax,
        email,
        bpc_whtid,
        dataAreaId,
        -- SLC_idBranchTxt,
        slc_fname,
        CreditMax
         FROM custtable where name like '$cusname%' and accountnum NOT LIKE 'EX%' and accountnum NOT LIKE 'BR%' ");
        $output = "";
        foreach ($query->result() as $rs) {

            switch ($rs->paymtermid) {
                case "Advance":
                    $creditid = 1;
                    $creditname = "Advance ( โอนเงินก่อนส่งของ )";
                    break;
                case "CASH":
                    $creditid = 2;
                    $creditname = "Cash";
                    break;
                case "7D":
                    $creditid = 3;
                    $creditname = "7 Day";
                    break;
                case "15D":
                    $creditid = 4;
                    $creditname = "15 Day";
                    break;
                case "30D":
                    $creditid = 5;
                    $creditname = "30 Day";
                    break;
                case "45D":
                    $creditid = 6;
                    $creditname = "45 Day";
                    break;
                case "60D":
                    $creditid = 7;
                    $creditname = "60 Day";
                    break;
                case "75D":
                    $creditid = 8;
                    $creditname = "75 Day";
                    break;
                case "90D":
                    $creditid = 9;
                    $creditname = "90 Day";
                    break;
                case "120D":
                    $creditid = 10;
                    $creditname = "120 Day";
                    break;
                default:
                    $creditid = "";
                    $creditname = "";
                break;
            }
        $conCredit = number_format($rs->CreditMax,2);
            $output .= "<ul class='list-group'>";
            $output .= "<a href='javascript:void(0)' class='selectCusCodeManualcode'

        data_addcus_code = '$rs->accountnum'
        data_addcus_name = '$rs->name'
        data_addcus_address = '$rs->address'
        data_addcus_phone = '$rs->phone'
        data_addcus_fax = '$rs->telefax'
        data_addcus_email = '$rs->email'
        data_addcus_taxid = '$rs->bpc_whtid'
        data_addcus_area = '$rs->dataAreaId'
        data_addcus_branch = ''
        data_addcus_termid = '$creditid'
        data_addcus_termname = '$creditname'
        data_addcus_creditlimit = '$conCredit'
        data_addcus_fristname = '$rs->slc_fname'
        
        ><li class='list-group-item'>" . $rs->accountnum . "&nbsp;" . $rs->name . " (" . $rs->dataAreaId . ")" . "</li></a>";
            $output .= "</ul>";
        }

        echo $output;
    }



    // Search customer data zone
    public function searchcustomerdataex()
    {
        $cuscode = $this->input->post("cuscode");
        $query = $this->db3->query("SELECT * FROM getcusforcrf_en where accountnum like '$cuscode%' LIMIT 10 ");
        $output = "";
        foreach ($query->result() as $rs) {
            $output .= "<ul class='list-group'>";
            $output .= "<a href='javascript:void(0)' class='selectCusCodeManualcodeex'

        data_addcus_codeex = '$rs->accountnum'
        data_addcus_nameex = '$rs->name'
        data_addcus_addressex = '$rs->address'
        data_addcus_phoneex = '$rs->phone'
        data_addcus_faxex = '$rs->telefax'
        data_addcus_emailex = '$rs->email'
        data_addcus_taxidex = '$rs->bpc_whtid'
        data_addcus_areaex = '$rs->dataAreaId'
        
        ><li class='list-group-item'>" . $rs->accountnum . "&nbsp;" . $rs->name . " (" . $rs->dataAreaId . ")" . "</li></a>";
            $output .= "</ul>";
        }

        echo $output;
    }


    // Search customer data zone
    public function searchcustomerdatanameex()
    {
        $cusname = $this->input->post("cusname");
        $query = $this->db3->query("SELECT * FROM getcusforcrf_en where name like '%$cusname%' LIMIT 10 ");
        $output = "";
        foreach ($query->result() as $rs) {
            $output .= "<ul class='list-group'>";
            $output .= "<a href='javascript:void(0)' class='selectCusCodeManualcodeex'

        data_addcus_codeex = '$rs->accountnum'
        data_addcus_nameex = '$rs->name'
        data_addcus_addressex = '$rs->address'
        data_addcus_phoneex = '$rs->phone'
        data_addcus_faxex = '$rs->telefax'
        data_addcus_emailex = '$rs->email'
        data_addcus_taxidex = '$rs->bpc_whtid'
        data_addcus_areaex = '$rs->dataAreaId'
        
        ><li class='list-group-item'>" . $rs->name . "&nbsp;" . $rs->accountnum . " (" . $rs->dataAreaId . ")" . "</li></a>";
            $output .= "</ul>";
        }

        echo $output;
    }
}

/* End of file ModelName.php */
