<?php
class getfn
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


function useget()
{
    $obj = new getfn();
    return $obj->gci();
}


// GET HEAD , FOOTER , CONTENT ZONE
function getHead()
{
    $obj = new getfn();
    $obj->gci()->load->view("template/head");
}
function getFooter()
{
    $obj = new getfn();
    $obj->gci()->load->view("template/footer");
}
function getContent($content)
{
    $obj = new getfn();
    $obj->gci()->load->view($content);
}
function getContentData($content,$data)
{
    $obj = new getfn();
    $obj->gci()->parser->parse($content,$data);
}
function getModal()
{
    $obj = new getfn();
    $obj->gci()->load->view("template/modal");
}


// GET Formcode
function getFormCode()
{
    return 'SA-F-004-11-01-08-61';
}

function getFormCodeEN()
{
    return 'SA-F-014-02-16-08-60';
}


// Get Form Number
// Get Form Number
function getFormNo()
{
    $obj = new getfn();
    // check formno ซ้ำในระบบ
    $checkRowdata = $obj->gci()->db->query("SELECT
    crf_formno FROM crf_maindata ORDER BY crf_id DESC LIMIT 1 
    ");
    $result = $checkRowdata->num_rows();

    $cutYear = substr(date("Y"), 2, 2);
    $getMonth = substr(date("m"), 0, 2);
    $formno = "";
    if ($result == 0) {
        $formno = "CRF" . $cutYear . $getMonth . "001";
    } else {

        $getFormno = $checkRowdata->row()->crf_formno; //อันนี้ดึงเอามาทั้งหมด CRF2003001
        $cutGetFormno = substr($getFormno, 3, 2); //อันนี้ตัดเอาเฉพาะปีจาก 2020 ตัดเหลือ 20
        $cutNo = substr($getFormno, 7, 3); //อันนี้ตัดเอามาแค่ตัวเลขจาก CRF2003001 ตัดเหลือ 001
        $cutNo++;

        if ($cutNo < 10) {
            $cutNo = "00" . $cutNo;
        } else if ($cutNo < 100) {
            $cutNo = "0" . $cutNo;
        }

        if ($cutGetFormno != $cutYear) {
            $formno = "CRF" . $cutYear . $getMonth . "001";
        } else {
            $formno = "CRF" . $cutGetFormno . $getMonth . $cutNo;
        }
    }

    return $formno;
}



function getFormNoEX()
{
    $obj = new getfn();
    // check formno ซ้ำในระบบ
    $checkRowdata = $obj->gci()->db->query("SELECT
    crfex_formno FROM crfex_maindata ORDER BY crfex_id DESC LIMIT 1 
    ");
    $result = $checkRowdata->num_rows();

    $cutYear = substr(date("Y"), 2, 2);
    $getMonth = substr(date("m"), 0, 2);
    $formno = "";
    if ($result == 0) {
        $formno = "CRFEX" . $cutYear . $getMonth . "001";
    } else {

        $getFormno = $checkRowdata->row()->crfex_formno; //อันนี้ดึงเอามาทั้งหมด CRF2003001
        $cutGetFormno = substr($getFormno, 5, 2); //อันนี้ตัดเอาเฉพาะปีจาก 2020 ตัดเหลือ 20
        $cutNo = substr($getFormno, 9, 3); //อันนี้ตัดเอามาแค่ตัวเลขจาก CRF2003001 ตัดเหลือ 001
        $cutNo++;

        if ($cutNo < 10) {
            $cutNo = "00" . $cutNo;
        } else if ($cutNo < 100) {
            $cutNo = "0" . $cutNo;
        }

        if ($cutGetFormno != $cutYear) {
            $formno = "CRFEX" . $cutYear . $getMonth . "001";
        } else {
            $formno = "CRFEX" . $cutGetFormno . $getMonth . $cutNo;
        }
    }

    return $formno;
}
// Get Form Number
// Get Form Number

// GetCustomer Number
function getCustomerNumber()
{
    $obj = new getfn();
    // check formno ซ้ำในระบบ
    $checkRowdata = $obj->gci()->db->query("SELECT
    crfcus_id FROM crf_customers ORDER BY crfcus_id DESC LIMIT 1 
    ");
    $result = $checkRowdata->num_rows();

    $cusnumber = "";
    if ($result == 0) {
        $cusnumber = 1;
    } else {

        $getFormno = $checkRowdata->row()->crfcus_id; //อันนี้ดึงเอามาทั้งหมด CRF2003001
        $cutNo =  $getFormno;
        $cutNo++;

        $cusnumber = $cutNo;
    }

    return $cusnumber;
}

function getCustomerNumberEX()
{
    $obj = new getfn();
    // check formno ซ้ำในระบบ
    $checkRowdata = $obj->gci()->db->query("SELECT
    crfexcus_id FROM crfex_customers ORDER BY crfexcus_id DESC LIMIT 1
    ");
    $result = $checkRowdata->num_rows();

    $cusnumber = "";
    if ($result == 0) {
        $cusnumber = 1;
    } else {

        $getFormno = $checkRowdata->row()->crfexcus_id; //อันนี้ดึงเอามาทั้งหมด CRF2003001
        $cutNo =  $getFormno;
        $cutNo++;

        $cusnumber = $cutNo;
    }

    return $cusnumber;
}



// GET Customer process #Form add
function getCusProcess()
{
    $obj = new getfn();
    $obj->gci()->db->order_by("cuspro_name", "ASC");
    $result = $obj->gci()->db->get("crf_process");
    return $result->result();
}

function getCusProcessByAreaid($dataareaid)
{
    if(!empty($dataareaid)){
        $obj = new getfn();
        $obj->gci()->db->order_by("cuspro_name" , "ASC");
        if($dataareaid == "st" || $dataareaid == "tb"){
            $obj->gci()->db->where("cuspro_type" , "tb-st");
        }else{
            $obj->gci()->db->where("cuspro_type" , NULL);
        }
        
        $result = $obj->gci()->db->get("crf_process");
        return $result->result();
    }
}

//Get Credit term #Form add
function getCreditTerm()
{
    $obj = new getfn();
    $obj->gci()->db->order_by("credit_order", "ASC");
    $result = $obj->gci()->db->get("credit_term_category");
    return $result->result();
}


// Get Data For view_data page
function getViewData($crf_id)
{
    $obj = new getfn();
    $query = $obj->gci()->db->query("SELECT
    crf_maindata.crf_id,
    crf_maindata.crf_formno,
    crf_maindata.crf_cuscode,
    crf_maindata.crf_company,
    crf_maindata.crf_datecreate,
    crf_customers_temp.crfcus_id,
    crf_customers_temp.crfcus_code,
    crf_customers_temp.crfcus_salesreps,
    crf_customers_temp.crfcus_name,
    crf_customers_temp.crfcus_comdatecreate,
    crf_customers_temp.crfcus_addresstype,
    crf_customers_temp.crfcus_address,
    crf_customers_temp.crfcus_contactname,
    crf_customers_temp.crfcus_phone,
    crf_customers_temp.crfcus_fax,
    crf_customers_temp.crfcus_email,
    crf_customers_temp.crfcus_etax_email,
    crf_customers_temp.crfcus_regiscapital,
    crf_customers_temp.crfcus_companytype,
    crf_company_type.crf_comname,
    crf_customers_temp.crfcus_comtype2,
    crf_customers_temp.crfcus_comtype31,
    crf_customers_temp.crfcus_comtype32,
    crf_customers_temp.crfcus_comtype33,
    crf_customers_temp.crfcus_comtype34,
    crf_customers_temp.crfcus_typebussi,
    crf_customers_temp.crfcus_forecast,
    crf_customers_temp.crfcus_textmemo,
    crf_customers_temp.crfcus_personal,
    crf_customers_temp.crfcus_file1,
    crf_customers_temp.crfcus_file2,
    crf_customers_temp.crfcus_file3,
    crf_customers_temp.crfcus_file4,
    crf_customers_temp.crfcus_file5,
    crf_customers_temp.crfcus_file6,
    crf_customers_temp.crfcus_creditterm,
    crf_customers_temp.crfcus_creditterm2,
    credit_term_category.credit_name,
    crf_customers_temp.crfcus_conditionbill,
    crf_customers_temp.crfcus_tablebill,
    crf_customers_temp.crfcus_mapbill,
    crf_customers_temp.crfcus_datebill,
    crf_customers_temp.crfcus_mapbill2,
    crf_customers_temp.crfcus_conditionmoney,
    crf_customers_temp.crfcus_cheuqetable,
    crf_customers_temp.crfcus_cheuqedetail,
    crf_customers_temp.crfcus_moneylimit,
    crf_customers_temp.crfcus_moneylimit2,
    crf_maindata.crf_type,
    crf_maindata.crf_personal_type,
    crf_alltype.crf_alltype_subname,
    crf_maindata.crf_sub_oldcus_changearea,
    crf_maindata.crf_sub_oldcus_changeaddress,
    crf_maindata.crf_sub_oldcus_changecredit,
    crf_maindata.crf_sub_oldcus_changefinance,
    crf_maindata.crf_sub_oldcus_editcustomer,
    crf_maindata.crf_creditterm,
    crf_maindata.crf_change_creditterm,
    crf_maindata.crf_condition_credit,
    crf_maindata.crf_creditterm2,
    crf_maindata.crf_finance,
    crf_maindata.crf_finance_req_number,
    crf_maindata.crf_finance_status,
    crf_maindata.crf_finance_change_status,
    crf_maindata.crf_finance_change_number,
    crf_maindata.crf_finance_change_total,
    crf_maindata.crf_finance_change_detail,
    crf_maindata.crf_userpost,
    crf_maindata.crf_userdeptpost,
    crf_maindata.crf_userecodepost,
    crf_maindata.crf_userdeptcodepost,
    crf_maindata.crf_userpostdatetime,
    crf_maindata.crf_mgrapprove_detail,
    crf_maindata.crf_mgrapprove_name,
    crf_maindata.crf_mgrapprove_datetime,
    crf_maindata.crf_mgrapprove_status,
    crf_maindata.crf_brcode,
    crf_maindata.crf_brcode_userpost,
    crf_maindata.crf_brcode_datetime,
    crf_maindata.crf_accmgr_detail,
    crf_maindata.crf_accmgr_name,
    crf_maindata.crf_accmgr_datetime,
    crf_maindata.crf_accmgrapprove_status,
    crf_maindata.crf_director_detail1,
    crf_maindata.crf_director_name1,
    crf_maindata.crf_director_datetime1,
    crf_maindata.crf_directorapprove_status1,
    crf_maindata.crf_director_detail2,
    crf_maindata.crf_director_name2,
    crf_maindata.crf_director_datetime2,
    crf_maindata.crf_directorapprove_status2,
    crf_maindata.crf_savecustomercode,
    crf_maindata.crf_usersave_customercode,
    crf_maindata.crf_datetimesave_customercode,
    crf_maindata.crf_status,
    crf_maindata.crfw_salesreps,
    crf_maindata.crfw_cusaddresstype,
    crf_maindata.crfw_cusaddress,
    crf_maindata.crfw_cusfile1,
    crf_customers_temp.crfcus_formno,
    crf_customers_temp.crfcus_taxid,
    crf_customers_temp.crfcus_branch,
    crf_customers_temp.crfcus_mapurl,
    crf_customers_temp.crfcus_mapfile,
    crf_customers_temp.crfcus_products,
    crf_maindata.crf_memo_customercode,
    crf_maindata.crf_personal_type,
    crf_customers_temp.crfcus_personal,
    crf_customers_temp.crfcus_area,
    crf_customers_temp.crfcus_memo2,
    crf_customers_temp.crfcus_countmonthdeli

    FROM
    crf_maindata
    INNER JOIN crf_customers_temp ON crf_customers_temp.crfcus_formno = crf_maindata.crf_formno
    INNER JOIN crf_company_type ON crf_company_type.crf_comid = crf_customers_temp.crfcus_companytype
    INNER JOIN credit_term_category ON credit_term_category.credit_id = crf_customers_temp.crfcus_creditterm
    INNER JOIN crf_alltype ON crf_alltype.crf_alltype_subcode = crf_maindata.crf_type
    
    
    WHERE crf_id = '$crf_id' ORDER BY crfcus_tempid DESC LIMIT 1
    ");

    return $query->row();
}
function getPrimanage($crfcus_formno)
{
    $obj = new getfn();
    $query = $obj->gci()->db->query("SELECT
    crf_primanage_id , crf_primanage_dept , crf_primanage_name , crf_primanage_posi , crf_primanage_email
    FROM crf_pri_manage_temp WHERE crf_pricus_formno = '$crfcus_formno' ORDER BY crf_primanage_id DESC
    ");
    return $query;
}

function getPrimanageEdit($crfcus_formno)
{
    $obj = new getfn();
    $obj->gci()->db->select("crf_primanage_id , crf_primanage_dept , crf_primanage_name , crf_primanage_posi , crf_primanage_email");
    $obj->gci()->db->from("crf_pri_manage_temp");
    $obj->gci()->db->where("crf_pricus_formno" , $crfcus_formno);
    $obj->gci()->db->order_by("crf_primanage_id" , "DESC");
    $result = $obj->gci()->db->get();
    return $result->result_array();
}

function getProcess($crfcus_id)
{
    $obj = new getfn();
    $query = $obj->gci()->db->query("SELECT
    crf_process_id , crf_process_name , crf_cusid FROM crf_process_use WHERE crf_cusid = '$crfcus_id'
    ");
    return $query;
}
function getFileToModal($crf_formno)
{
    $obj = new getfn();
    $query = $obj->gci()->db->query("SELECT crf_file1 , crf_file2 , crf_file3 , crf_file4 , crf_file5 , crf_file6 FROM crf_maindata WHERE crf_formno = '$crf_formno'
    ");
    return $query->row();
}


function getSuboldCus($crfid)
{
    $obj = new getfn();
    $query = $obj->gci()->db->query("SELECT 
    crf_sub_oldcus_changearea , 
    crf_sub_oldcus_changeaddress , 
    crf_sub_oldcus_changecredit , 
    crf_sub_oldcus_changefinance,
    crf_sub_oldcus_editcustomer
    FROM crf_maindata
    WHERE crf_id = '$crfid'
    ");
    return $query->row();
}

function getWhenComplate($crfid)
{
    $obj = new getfn();
    $query = $obj->gci()->db->query("SELECT
    crfw_salesreps , crf_cuscode , crfw_cusaddresstype , crfw_cusaddress , crfw_cusfile1 , crf_creditterm , crf_creditterm2 , crf_finance_change_total
    FROM crf_maindata
    WHERE crf_id = '$crfid'
    ");
    return $query->row();
}

function conCreditTerm($creditid)
{
    $obj = new getfn();
    $query = $obj->gci()->db->query("SELECT credit_name FROM credit_term_category WHERE credit_id = '$creditid'
    ");
    $result = $query->row();
    if($creditid == ''){
        return false;
    }else{
        return $result->credit_name;
    }
    
}

function getFormBeforeSave($formno)
{
    $obj = new getfn();
    $query = $obj->gci()->db->query("SELECT crf_formno FROM crf_maindata WHERE crf_formno = '$formno' ");
    $numrow = $query->num_rows();
    return $numrow;
}
function getFormBeforeSaveEx($formno)
{
    $obj = new getfn();
    $query = $obj->gci()->db->query("SELECT crfex_formno FROM crfex_maindata WHERE crfex_formno = '$formno' ");
    $numrow = $query->num_rows();
    return $numrow;
}


// Check Director approve
function check_directorapprove($crfid)
{
    $obj = new getfn();
    $query = $obj->gci()->db->query("SELECT crf_directorapprove_status1 , crf_directorapprove_status2 FROM crf_maindata WHERE crf_id = '$crfid' ");
    return $query->row();
}







// Export Zone
function viewdataEX($crfexid)
{
    $obj = new getfn();
    $query = $obj->gci()->db->query("SELECT
    crfex_maindata.crfex_id,
    crfex_maindata.crfex_formno,
    crfex_maindata.crfex_customerid,
    crfex_maindata.crfex_company,
    crfex_maindata.crfex_datecreate,
    crfex_maindata.crfex_custype,
    crfex_maindata.crfex_pcreditlimit,
    crfex_maindata.crfex_pterm,
    crfex_maindata.crfex_pdiscount,

    crfex_maindata.crfex_ccreditlimit,
    crfex_maindata.crfex_cterm,
    crfex_maindata.crfex_cdiscount,
    crfex_maindata.crfex_creditlimit_condition,
    crfex_maindata.crfex_term_condition,
    crfex_maindata.crfex_discount_condition,
    crfex_maindata.crfex_creditlimit_need,
    crfex_maindata.crfex_term_need,
    crfex_maindata.crfex_discount_need,
    crfex_maindata.crfex_creditlimit_sum,
    crfex_maindata.crfex_term_sum,
    crfex_maindata.crfex_discount_sum,

    crfex_maindata.crfex_brcode,
    crfex_maindata.crfex_userpost,
    crfex_maindata.crfex_userdept,
    crfex_maindata.crfex_userdatetime,
    crfex_maindata.crfex_status,
    crfex_maindata.crfex_csuserpost,
    crfex_maindata.crfex_csmemo,
    crfex_maindata.crfex_csdept,
    crfex_maindata.crfex_csdatetime,
    crfex_maindata.crfex_mgrapp_status,
    crfex_maindata.crfex_mgrapp_username,
    crfex_maindata.crfex_mgrapp_datetime,
    crfex_maindata.crfex_mgrapp_detail,
    crfex_maindata.crfex_accmgr_status,
    crfex_maindata.crfex_accmgr_username,
    crfex_maindata.crfex_accmgr_datetime,
    crfex_maindata.crfex_accmgr_detail,
    crfex_maindata.crfex_directorapp_status,
    crfex_maindata.crfex_directorapp_username,
    crfex_maindata.crfex_directorapp_datetime,
    crfex_maindata.crfex_directorapp_detail,
    crfex_maindata.crfex_accmemo,
    crfex_maindata.crfex_accuserpost,
    crfex_maindata.crfex_accdatetime,
    crfex_maindata.crfex_report_date,
    crfex_maindata.crfex_report_month,
    crfex_maindata.crfex_report_year,
    crfex_maindata.crfex_topic,
    crfex_maindata.crfex_curcustopic1,
    crfex_maindata.crfex_curcustopic2,
    crfex_maindata.crfex_directorapp_status2,
    crfex_maindata.crfex_directorapp_username2,
    crfex_maindata.crfex_directorapp_datetime2,
    crfex_maindata.crfex_directorapp_detail2,
    crfex_maindata.crfex_m1_sales,
    crfex_maindata.crfex_m1_volume,
    crfex_maindata.crfex_m1_text,
    crfex_maindata.crfex_m2_sales,
    crfex_maindata.crfex_m2_volume,
    crfex_maindata.crfex_m2_text,
    crfex_maindata.crfex_m3_sales,
    crfex_maindata.crfex_m3_volume,
    crfex_maindata.crfex_m3_text,

    crfex_customers_temp.crfexcus_code,
    crfex_customers_temp.crfexcus_datecreate,
    crfex_customers_temp.crfexcus_salesreps,
    crfex_customers_temp.crfexcus_nameEN,
    crfex_customers_temp.crfexcus_nameTH,
    crfex_customers_temp.crfexcus_address,
    crfex_customers_temp.crfexcus_file,
    crfex_customers_temp.crfexcus_tel,
    crfex_customers_temp.crfexcus_fax,
    crfex_customers_temp.crfexcus_email,
    crfex_customers_temp.crfexcus_creditlimit,
    crfex_customers_temp.crfexcus_term,
    crfex_customers_temp.crfexcus_discount,
    crfex_customers_temp.crfexcus_bg,
    crfex_customers_temp.crfexcus_his_month1,
    crfex_customers_temp.crfexcus_his_tvolume1,
    crfex_customers_temp.crfexcus_histsales1,
    crfex_customers_temp.crfexcus_his_month2,
    crfex_customers_temp.crfexcus_his_tvolume2,
    crfex_customers_temp.crfexcus_histsales2,
    crfex_customers_temp.crfexcus_his_month3,
    crfex_customers_temp.crfexcus_his_tvolume3,
    crfex_customers_temp.crfexcus_histsales3,
    crfex_customers_temp.crfexcus_usercreate,
    crfex_customers_temp.crfexcus_userecode,
    crfex_customers_temp.crfexcus_userdeptcode,
    crfex_customers_temp.crfexcus_userdatetimecreate,
    crfex_customers_temp.crfexcus_usermodify,
    crfex_customers_temp.crfexcus_userecodemodify,
    crfex_customers_temp.crfexcus_userdeptcodemodify,
    crfex_customers_temp.crfexcus_datetimemodify,
    crfex_customers_temp.crfexcus_id,
    crfex_customers_temp.crfexcus_payment,
    crf_alltype.crf_alltype_subnameEN
    FROM
    crfex_maindata
    INNER JOIN crfex_customers_temp ON crfex_customers_temp.crfexcus_formno = crfex_maindata.crfex_formno
    INNER JOIN crf_alltype ON crf_alltype.crf_alltype_subcode = crfex_maindata.crfex_custype
    WHERE crfex_id = '$crfexid'
    ");
    return $query->row();
}


function getMethodCus($crfexid)
{
    $obj = new getfn();
    $query = $obj->gci()->db->query("SELECT crfex_methodcurcus FROM crfex_maindata WHERE crfex_id = '$crfexid' ");
    return $query->row();
}


// For Delete Primanage
function deletePrimanage($cusid)
{
    $obj = new getfn();
    $obj->gci()->db->where("crf_pricusid" , $cusid);
    $query = $obj->gci()->db->delete("crf_pri_manage_temp");

    return $query;
}


function deletePrimanage2($formno)
{
    $obj = new getfn();
    $obj->gci()->db->where("crf_pricus_formno" , $formno);
    $query = $obj->gci()->db->delete("crf_pri_manage_temp");

    return $query;
}

function deletePrimanage3($cusid)
{
    $obj = new getfn();
    $obj->gci()->db->where("crf_pricusid" , $cusid);
    $query = $obj->gci()->db->delete("crf_pri_manage");

    return $query;
}


// For delete Process Used
function deleteProcess($cusid)
{
    $obj = new getfn();
    $obj->gci()->db->where("crf_cusid" , $cusid);
    $query = $obj->gci()->db->delete("crf_process_use");

    return $query;
}


//Get customer code
function getCustomerCode($crfid)
{
    $obj = new getfn();
    $obj->gci()->db->select("crf_cuscode");
    $obj->gci()->db->from("crf_maindata");
    $obj->gci()->db->where("crf_id" , $crfid);
    $result = $obj->gci()->db->get();
    return $result->row();
}




function checkCusnameEng($cusnameEng)
{
    return preg_match('/([ก-เa-zA-Z0-9_])/',$cusnameEng);
}




// Report Getdata
function getdataToReport()
{
    $obj = new getfn();
    $obj->gci()->db->select('*');
    $obj->gci()->db->from('report_th');
    $obj->gci()->db->order_by('crf_formno' , 'desc');
    $result = $obj->gci()->db->get();
    return $result->result();
}


function getdataToReportEx()
{
    $obj = new getfn();
    $obj->gci()->db->select('*');
    $obj->gci()->db->from('report_ex');
    $obj->gci()->db->order_by('crfex_formno' , 'desc');
    $result = $obj->gci()->db->get();
    return $result->result();
}



function checkdirecStatus($crfexid , $diretype)
{
    $obj = new getfn();
    if($diretype == 1){
        $query = $obj->gci()->db->query("SELECT crfex_directorapp_status FROM crfex_maindata WHERE crfex_id ='$crfexid' ");
    }else if($diretype == 2){
        $query = $obj->gci()->db->query("SELECT crfex_directorapp_status2 FROM crfex_maindata WHERE crfex_id ='$crfexid' ");
    }
    return $query->row();
}
// export end



function getcustomerlist()
{
    $obj = new getfn();
    $query = $obj->gci()->db->query("SELECT
    crf_customers.crfcus_id,
    crf_customers.crfcus_code,
    crf_customers.crfcus_brcode,
    crf_customers.crfcus_salesreps,
    crf_customers.crfcus_name,
    crf_customers.crfcus_comdatecreate,
    crf_customers.crfcus_taxid,
    crf_customers.crfcus_branch,
    crf_customers.crfcus_addresstype,
    crf_customers.crfcus_address,
    crf_customers.crfcus_contactname,
    crf_customers.crfcus_phone,
    crf_customers.crfcus_fax,
    crf_customers.crfcus_email,
    crf_customers.crfcus_regiscapital,
    crf_customers.crfcus_mapurl,
    crf_customers.crfcus_mapfile,
    crf_customers.crfcus_companytype,
    crf_customers.crfcus_comtype2,
    crf_customers.crfcus_comtype31,
    crf_customers.crfcus_comtype32,
    crf_customers.crfcus_comtype33,
    crf_customers.crfcus_comtype34,
    crf_customers.crfcus_typebussi,
    crf_customers.crfcus_products,
    crf_customers.crfcus_forecast,
    crf_customers.crfcus_file1,
    crf_customers.crfcus_file2,
    crf_customers.crfcus_file3,
    crf_customers.crfcus_file4,
    crf_customers.crfcus_file5,
    crf_customers.crfcus_file6,
    crf_customers.crfcus_creditterm,
    crf_customers.crfcus_creditterm2,
    crf_customers.crfcus_conditionbill,
    crf_customers.crfcus_tablebill,
    crf_customers.crfcus_mapbill,
    crf_customers.crfcus_datebill,
    crf_customers.crfcus_mapbill2,
    crf_customers.crfcus_conditionmoney,
    crf_customers.crfcus_cheuqetable,
    crf_customers.crfcus_cheuqedetail,
    crf_customers.crfcus_moneylimit,
    crf_customers.crfcus_moneylimit2,
    crf_customers.crfcus_usercreate,
    crf_customers.crfcus_usercreate_ecode,
    crf_customers.crfcus_usercreate_deptcode,
    crf_customers.crfcus_datemodify,
    crf_customers.crfcus_usermodify,
    crf_customers.crfcus_usermodify_ecode,
    crf_customers.crfcus_usermodify_deptcode,
    crf_customers.crfcus_usermodify_datetime,
    crf_customers.crfcus_area
    FROM
    crf_customers
    WHERE crfcus_code != ''
    ORDER BY crf_customers.crfcus_id DESC");
    return $query;
}




function getcustomerlistEx()
{
    $obj = new getfn();
    $query = $obj->gci()->db->query("SELECT
    crfex_customers.crfexcus_id,
    crfex_customers.crfexcus_area,
    crfex_customers.crfexcus_code,
    crfex_customers.crfexcus_brcode,
    crfex_customers.crfexcus_datecreate,
    crfex_customers.crfexcus_salesreps,
    crfex_customers.crfexcus_nameEN,
    crfex_customers.crfexcus_nameTH,
    crfex_customers.crfexcus_address,
    crfex_customers.crfexcus_file,
    crfex_customers.crfexcus_tel,
    crfex_customers.crfexcus_fax,
    crfex_customers.crfexcus_email,
    crfex_customers.crfexcus_payment,
    crfex_customers.crfexcus_creditlimit,
    crfex_customers.crfexcus_term,
    crfex_customers.crfexcus_discount,
    crfex_customers.crfexcus_bg,
    crfex_customers.crfexcus_his_month1,
    crfex_customers.crfexcus_his_tvolume1,
    crfex_customers.crfexcus_histsales1,
    crfex_customers.crfexcus_his_month2,
    crfex_customers.crfexcus_his_tvolume2,
    crfex_customers.crfexcus_histsales2,
    crfex_customers.crfexcus_his_month3,
    crfex_customers.crfexcus_his_tvolume3,
    crfex_customers.crfexcus_histsales3,
    crfex_customers.crfexcus_usercreate,
    crfex_customers.crfexcus_userecode,
    crfex_customers.crfexcus_userdeptcode,
    crfex_customers.crfexcus_userdatetimecreate,
    crfex_customers.crfexcus_usermodify,
    crfex_customers.crfexcus_userecodemodify,
    crfex_customers.crfexcus_userdeptcodemodify,
    crfex_customers.crfexcus_datetimemodify
    FROM
    crfex_customers
    WHERE crfexcus_code != ''
    ORDER BY crfexcus_id DESC
    ");
    return $query;
}




// Fuction get customer information
function getcustomerdata($cuscode)
{
    $obj = new getfn();
    $query = $obj->gci()->db->query("SELECT
    crf_customers.crfcus_id,
    crf_customers.crfcus_code,
    crf_customers.crfcus_brcode,
    crf_customers.crfcus_salesreps,
    crf_customers.crfcus_name,
    crf_customers.crfcus_comdatecreate,
    crf_customers.crfcus_taxid,
    crf_customers.crfcus_branch,
    crf_customers.crfcus_addresstype,
    crf_customers.crfcus_address,
    crf_customers.crfcus_contactname,
    crf_customers.crfcus_phone,
    crf_customers.crfcus_fax,
    crf_customers.crfcus_email,
    crf_customers.crfcus_etax_email,
    crf_customers.crfcus_regiscapital,
    crf_customers.crfcus_mapurl,
    crf_customers.crfcus_mapfile,
    crf_customers.crfcus_companytype,
    crf_customers.crfcus_comtype2,
    crf_customers.crfcus_comtype31,
    crf_customers.crfcus_comtype32,
    crf_customers.crfcus_comtype33,
    crf_customers.crfcus_comtype34,
    crf_customers.crfcus_typebussi,
    crf_customers.crfcus_products,
    crf_customers.crfcus_forecast,
    crf_customers.crfcus_file1,
    crf_customers.crfcus_file2,
    crf_customers.crfcus_file3,
    crf_customers.crfcus_file4,
    crf_customers.crfcus_file5,
    crf_customers.crfcus_file6,
    crf_customers.crfcus_creditterm,
    crf_customers.crfcus_creditterm2,
    crf_customers.crfcus_conditionbill,
    crf_customers.crfcus_tablebill,
    crf_customers.crfcus_mapbill,
    crf_customers.crfcus_datebill,
    crf_customers.crfcus_mapbill2,
    crf_customers.crfcus_conditionmoney,
    crf_customers.crfcus_cheuqetable,
    crf_customers.crfcus_cheuqedetail,
    crf_customers.crfcus_moneylimit,
    crf_customers.crfcus_moneylimit2,
    crf_customers.crfcus_usercreate,
    crf_customers.crfcus_usercreate_ecode,
    crf_customers.crfcus_usercreate_deptcode,
    crf_customers.crfcus_datemodify,
    crf_customers.crfcus_usermodify,
    crf_customers.crfcus_usermodify_ecode,
    crf_customers.crfcus_usermodify_deptcode,
    crf_customers.crfcus_usermodify_datetime,
    crf_customers.crfcus_area,
    credit_term_category.credit_name
    FROM
    crf_customers
    INNER JOIN credit_term_category ON credit_term_category.credit_id = crf_customers.crfcus_creditterm    
    WHERE crfcus_code = '$cuscode'
    ");
    return $query->row();
}

function getPrimanageCus($crfcus_id)
{
    $obj = new getfn();
    $query = $obj->gci()->db->query("SELECT
    crf_primanage_id , crf_primanage_dept , crf_primanage_name , crf_primanage_posi , crf_primanage_email
    FROM crf_pri_manage WHERE crf_pricusid = '$crfcus_id' ORDER BY crf_primanage_id DESC
    ");
    return $query;
}


// Function get customer information export
function getcustomerdataex($cuscodeex , $areaex)
{
    $obj = new getfn();
    $query = $obj->gci()->db->query("SELECT
    crfex_customers.crfexcus_id,
    crfex_customers.crfexcus_area,
    crfex_customers.crfexcus_code,
    crfex_customers.crfexcus_brcode,
    crfex_customers.crfexcus_datecreate,
    crfex_customers.crfexcus_salesreps,
    crfex_customers.crfexcus_nameEN,
    crfex_customers.crfexcus_nameTH,
    crfex_customers.crfexcus_address,
    crfex_customers.crfexcus_file,
    crfex_customers.crfexcus_tel,
    crfex_customers.crfexcus_fax,
    crfex_customers.crfexcus_email,
    crfex_customers.crfexcus_payment,
    crfex_customers.crfexcus_creditlimit,
    crfex_customers.crfexcus_term,
    crfex_customers.crfexcus_discount,
    crfex_customers.crfexcus_bg,
    crfex_customers.crfexcus_his_month1,
    crfex_customers.crfexcus_his_tvolume1,
    crfex_customers.crfexcus_histsales1,
    crfex_customers.crfexcus_his_month2,
    crfex_customers.crfexcus_his_tvolume2,
    crfex_customers.crfexcus_histsales2,
    crfex_customers.crfexcus_his_month3,
    crfex_customers.crfexcus_his_tvolume3,
    crfex_customers.crfexcus_histsales3,
    crfex_customers.crfexcus_usercreate,
    crfex_customers.crfexcus_userecode,
    crfex_customers.crfexcus_userdeptcode,
    crfex_customers.crfexcus_userdatetimecreate,
    crfex_customers.crfexcus_usermodify,
    crfex_customers.crfexcus_userecodemodify,
    crfex_customers.crfexcus_userdeptcodemodify,
    crfex_customers.crfexcus_datetimemodify
    FROM
    crfex_customers
    WHERE crfexcus_code = '$cuscodeex' and crfexcus_area = '$areaex'
    ");
    return $query->row();
}



//เพิ่ม Feture ใหม่ 23/09/2020
// เพิ่มการแสดงผล สถานะ รายการว่าของ User นั้นๆมีสถานะอะไรบ้างและในแต่สถานะนั้นมีกี่รายการอยู่ในนั้น
function showCountStatus($ecode)
{
    $sql = useget()->db->query("SELECT crf_status , count(crf_status)as statusnumber from crf_maindata where crf_userecodepost = '$ecode' group by crf_status order by crf_status desc");
    $output = '';
    foreach($sql->result() as $rs){

        if($rs->crf_status == "Open"){
            $txtColor = '#0066FF';
        }else if($rs->crf_status == "Completed"){
            $txtColor = '#009900';
        }else if($rs->crf_status == "Cancel" || $rs->crf_status == "Sales Manager Not Approve" || $rs->crf_status == "Account Manager Not approved" || $rs->crf_status == "Manager Not Approve" || $rs->crf_status == "Account Manager Not approve" || $rs->crf_status == "Director Not approve"){
            $txtColor = '#CC0000';
        }else{
            $txtColor = '#363636';
        }

        $output .= '
        <div class="col-md-3">
            <a class="statusFilter" href="javascript:void(0)"
            data_status = '."$rs->crf_status".'
            data_ecode = '."$ecode".'
            ><span style="color:'.$txtColor.'"><b>'.$rs->crf_status.'</b></span>&nbsp;<span class="badge badge-pill badge-warning">'.$rs->statusnumber.'</span></a>
        </div>
    ';

    }

    return $output;
}


//เพิ่ม Feture ใหม่ 08/10/2020
// เพิ่มการแสดงผล สถานะ รายการที่รอบัญชีดำเนินการ
function showCountStatusAcc($deptcode)
{
    $sql = useget()->db->query("SELECT crf_status , count(crf_status)as statusnumber from crf_maindata where crf_status in ('Manager approved' , 'Director approved' , 'CS POST BR' , 'Waiting for second director approve') group by crf_status order by crf_status desc");
    $output = '';
    foreach($sql->result() as $rs){

        if($rs->crf_status == "Open"){
            $txtColor = '#0066FF';
        }else if($rs->crf_status == "Completed"){
            $txtColor = '#009900';
        }else if($rs->crf_status == "Cancel" || $rs->crf_status == "Sales Manager Not Approve" || $rs->crf_status == "Account Manager Not approved" || $rs->crf_status == "Manager Not Approve" || $rs->crf_status == "Account Manager Not approve" || $rs->crf_status == "Director Not approve"){
            $txtColor = '#CC0000';
        }else{
            $txtColor = '#d29912';
        }

        $output .= '
        <div class="col-md-3">
            <a class="statusFilterAcc" href="javascript:void(0)"
            data_statusAcc = '."$rs->crf_status".'
            data_deptcodeAcc = '."$deptcode".'
            ><span style="color:'.$txtColor.'"><b>'.$rs->crf_status.'</b></span>&nbsp;<span class="badge badge-pill badge-warning">'.$rs->statusnumber.'</span></a>
        </div>
    ';

    }

    return $output;
}



function checkExcuscode($cuscode , $area)
{
    $sql = useget()->db->query("SELECT crfexcus_code , crfexcus_area FROM crfex_customers WHERE crfexcus_code = '$cuscode' and crfexcus_area = '$area' ");
    return $sql;
}

function checkCuscode($cuscode , $area)
{
    $sql = useget()->db->query("SELECT crfcus_code , crfcus_area FROM crf_customers WHERE crfcus_code = '$cuscode' and crfcus_area = '$area' ");
    return $sql;
}


function getCreditMax($cuscode , $area)
{
    if($cuscode != "" && $area != ""){
        useget()->dbsqlcusttable = useget()->load->database('sql_custtable', TRUE);
        $sql = useget()->dbsqlcusttable->query("SELECT
        accountnum,
        dataAreaId,
        CreditMax
        FROM custtable where accountnum = '$cuscode' AND dataAreaId = '$area'");

        if($sql->num_rows() != 0){
            return $sql->row()->CreditMax;
        }
    }
}