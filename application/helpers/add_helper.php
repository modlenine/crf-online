<?php
class addfn
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

// Sale , CS Approve
function saveApprove($crfid)
{
    $obj = new addfn();
    $obj->gci()->load->model('main/email_model', 'email');

    if ($obj->gci()->input->post("mgr_appro") == "อนุมัติ") {

        $mgrArray = array(
            "crf_mgrapprove_detail" => $obj->gci()->input->post("crf_mgrapprove_detail"),
            "crf_mgrapprove_name" => $obj->gci()->input->post("crf_mgrapprove_name"),
            "crf_mgrapprove_datetime" => conDatetimeToDb($obj->gci()->input->post("crf_mgrapprove_datetime")),
            "crf_mgrapprove_status" => $obj->gci()->input->post("mgr_appro"),
            "crf_status" => "Manager Approved"
        );
    
        $obj->gci()->db->where("crf_id", $crfid);
        $obj->gci()->db->update("crf_maindata", $mgrArray);
    } else {

        $mgrArray = array(
            "crf_mgrapprove_detail" => $obj->gci()->input->post("crf_mgrapprove_detail"),
            "crf_mgrapprove_name" => $obj->gci()->input->post("crf_mgrapprove_name"),
            "crf_mgrapprove_datetime" => conDatetimeToDb($obj->gci()->input->post("crf_mgrapprove_datetime")),
            "crf_mgrapprove_status" => $obj->gci()->input->post("mgr_appro"),
            "crf_status" => "Manager Not Approve"
        );
        $obj->gci()->db->where("crf_id", $crfid);
        $obj->gci()->db->update("crf_maindata", $mgrArray);

        $arCustomerTemp = array(
            "crfcus_tempstatus" => "Not approve",
            "crfcus_datetimeupdate" => date("Y-m-d H:i:s")
        );
        $obj->gci()->db->where("crfcus_id", $obj->gci()->input->post("saleMgrCusid"));
        $obj->gci()->db->update("crf_customers_temp", $arCustomerTemp);
    }




    if ($obj->gci()->input->post("cusTypeForEmail") == 1) {
        if ($obj->gci()->input->post("mgr_appro") == "อนุมัติ"){
            $obj->gci()->email->sendemail_toCs($obj->gci()->input->post("saleMgrFormno"));
        }else{
            $obj->gci()->db->where("crfcus_id", $obj->gci()->input->post("saleMgrCusid"));
            $obj->gci()->db->delete("crf_customers");
            $obj->gci()->email->sendemail_InMgrNotApprove($obj->gci()->input->post("saleMgrFormno"));
        }
        
    } else if ($obj->gci()->input->post("cusTypeForEmail") == 2) {
        if ($obj->gci()->input->post("mgr_appro") == "อนุมัติ"){
            $obj->gci()->email->sendemail_toAccMgr2($obj->gci()->input->post("saleMgrFormno"));
        }else{
            $obj->gci()->email->sendemail_InMgrNotApprove($obj->gci()->input->post("saleMgrFormno"));
        }
        
    }
}


function saveCsBr($crfid)
{
    $obj = new addfn();
    $obj->gci()->load->model('main/email_model', 'email');
    $arbr = array(
        "crf_brcode" => $obj->gci()->input->post("crf_brcode"),
        "crf_brcode_userpost" => $obj->gci()->input->post("crf_brcode_userpost"),
        "crf_brcode_datetime" => conDateTimeToDb($obj->gci()->input->post("crf_becode_datetime")),
        "crf_status" => "CS POST BR"
    );

    $obj->gci()->db->where("crf_id", $crfid);
    $obj->gci()->db->update("crf_maindata", $arbr);



    $arCustomer = array(
        "crfcus_brcode" => $obj->gci()->input->post("crf_brcode"),
    );

    $obj->gci()->db->where("crfcus_id", getCustomerCode($crfid)->crf_cuscode);
    $obj->gci()->db->update("crf_customers_temp", $arCustomer);
    $obj->gci()->email->sendemail_toAccMgr($obj->gci()->input->post("CsFormno"));
}


function saveAccMgr($crfid)
{
    $obj = new addfn();
    $obj->gci()->load->model('main/email_model', 'email');

    $method1 = $obj->gci()->input->post("mgrCheckmethod1");
    $method2 = $obj->gci()->input->post("mgrCheckmethod2");
    $method3 = $obj->gci()->input->post("mgrCheckmethod3");
    $method4 = $obj->gci()->input->post("mgrCheckmethod4");
    $method5 = $obj->gci()->input->post("mgrCheckmethod5");

    $customerType = $obj->gci()->input->post("accMgr_cusTypeForEmail");

    if ($customerType == 1) {

        if ($obj->gci()->input->post("mgracc_appro") == "อนุมัติ") {
            $arAccMgr = array(
                "crf_accmgr_detail" => $obj->gci()->input->post("crf_accmgr_detail"),
                "crf_accmgr_name" => $obj->gci()->input->post("crf_accmgr_name"),
                "crf_accmgr_datetime" => conDateTimeToDb($obj->gci()->input->post("crf_accmgr_datetime")),
                "crf_accmgrapprove_status" => $obj->gci()->input->post("mgracc_appro"),
                "crf_status" => "Account Manager Approved"
            );
    
            $obj->gci()->db->where("crf_id", $crfid);
            $obj->gci()->db->update("crf_maindata", $arAccMgr);
        } else {

            $arCustomerTemp = array(
                "crfcus_brcode" => "",
                "crfcus_tempstatus" => "Not approve",
                "crfcus_datetimeupdate" => date("Y-m-d H:i:s")
            );
            $obj->gci()->db->where("crfcus_id", $obj->gci()->input->post("accMgrCuscode"));
            $obj->gci()->db->update("crf_customers_temp", $arCustomerTemp);

            $obj->gci()->db->where("crfcus_id", $obj->gci()->input->post("accMgrCuscode"));
            $obj->gci()->db->delete("crf_customers");

            $arAccMgr = array(
                "crf_accmgr_detail" => $obj->gci()->input->post("crf_accmgr_detail"),
                "crf_accmgr_name" => $obj->gci()->input->post("crf_accmgr_name"),
                "crf_accmgr_datetime" => conDateTimeToDb($obj->gci()->input->post("crf_accmgr_datetime")),
                "crf_accmgrapprove_status" => $obj->gci()->input->post("mgracc_appro"),
                "crf_status" => "Account Manager Not approve"
            );
    
            $obj->gci()->db->where("crf_id", $crfid);
            $obj->gci()->db->update("crf_maindata", $arAccMgr);
        }






        if ($obj->gci()->input->post("accMgr_cusTypeForEmail") == 1) {
            if ($obj->gci()->input->post("mgracc_appro") == "อนุมัติ"){
                $obj->gci()->email->sendemail_toDerector1($obj->gci()->input->post("accMgrFormno"));
            }else{
                $obj->gci()->email->sendemail_InAccMgrNotApprove($obj->gci()->input->post("accMgrFormno"));
            }
            
        } else if ($obj->gci()->input->post("accMgr_cusTypeForEmail") == 2) {
            if ($obj->gci()->input->post("mgracc_appro") == "อนุมัติ"){
                $obj->gci()->email->sendemail_toDerector1type2($obj->gci()->input->post("accMgrFormno"));
            }else{
                $obj->gci()->email->sendemail_InAccMgrNotApprove($obj->gci()->input->post("accMgrFormno"));
            }
            
        }

    } else {

        if ($method3 || $method4 != 0) {

            if ($obj->gci()->input->post("mgracc_appro") == "อนุมัติ") {

                $arAccMgr = array(
                    "crf_accmgr_detail" => $obj->gci()->input->post("crf_accmgr_detail"),
                    "crf_accmgr_name" => $obj->gci()->input->post("crf_accmgr_name"),
                    "crf_accmgr_datetime" => conDateTimeToDb($obj->gci()->input->post("crf_accmgr_datetime")),
                    "crf_accmgrapprove_status" => $obj->gci()->input->post("mgracc_appro"),
                    "crf_status" => "Account Manager Approved"
                );
    
                $obj->gci()->db->where("crf_id", $crfid);
                $obj->gci()->db->update("crf_maindata", $arAccMgr);
    
                // if ($obj->gci()->input->post("accMgr_cusTypeForEmail") == 1) {
                //     $obj->gci()->email->sendemail_toDerector1($obj->gci()->input->post("accMgrFormno"));
                // } else if ($obj->gci()->input->post("accMgr_cusTypeForEmail") == 2) {
                //     $obj->gci()->email->sendemail_toDerector1type2($obj->gci()->input->post("accMgrFormno"));
                // }
            } else {

                $arAccMgr = array(
                    "crf_accmgr_detail" => $obj->gci()->input->post("crf_accmgr_detail"),
                    "crf_accmgr_name" => $obj->gci()->input->post("crf_accmgr_name"),
                    "crf_accmgr_datetime" => conDateTimeToDb($obj->gci()->input->post("crf_accmgr_datetime")),
                    "crf_accmgrapprove_status" => $obj->gci()->input->post("mgracc_appro"),
                    "crf_status" => "Account Manager Not approve"
                );
    
                $obj->gci()->db->where("crf_id", $crfid);
                $obj->gci()->db->update("crf_maindata", $arAccMgr);

                $arCustomerTemp = array(
                    "crfcus_tempstatus" => "Not approve",
                    "crfcus_datetimeupdate" => date("Y-m-d H:i:s")
                );
                $obj->gci()->db->where("crfcus_id", $obj->gci()->input->post("accMgrCuscode"));
                $obj->gci()->db->update("crf_customers_temp", $arCustomerTemp);
            }

            if ($obj->gci()->input->post("accMgr_cusTypeForEmail") == 2) {
                if ($obj->gci()->input->post("mgracc_appro") == "อนุมัติ"){
                    $obj->gci()->email->sendemail_toDerector1type2($obj->gci()->input->post("accMgrFormno"));
                }else{
                    $obj->gci()->email->sendemail_InAccMgrNotApprove($obj->gci()->input->post("accMgrFormno"));
                }
                
            }


        } else {

            if ($obj->gci()->input->post("mgracc_appro") == "อนุมัติ") {
                $arAccMgr = array(
                    "crf_accmgr_detail" => $obj->gci()->input->post("crf_accmgr_detail"),
                    "crf_accmgr_name" => $obj->gci()->input->post("crf_accmgr_name"),
                    "crf_accmgr_datetime" => conDateTimeToDb($obj->gci()->input->post("crf_accmgr_datetime")),
                    "crf_accmgrapprove_status" => $obj->gci()->input->post("mgracc_appro"),
                    "crf_status" => "Account staff process"
                );
    
                $obj->gci()->db->where("crf_id", $crfid);
                $obj->gci()->db->update("crf_maindata", $arAccMgr);
                $obj->gci()->email->sendemail_toAccStaff3($obj->gci()->input->post("accMgrFormno"));
            } else {

                $arCustomerTemp = array(
                    "crfcus_tempstatus" => "Not approve",
                    "crfcus_datetimeupdate" => date("Y-m-d H:i:s")
                );
                $obj->gci()->db->where("crfcus_id", $obj->gci()->input->post("accMgrCuscode"));
                $obj->gci()->db->update("crf_customers_temp", $arCustomerTemp);

                $arAccMgr = array(
                    "crf_accmgr_detail" => $obj->gci()->input->post("crf_accmgr_detail"),
                    "crf_accmgr_name" => $obj->gci()->input->post("crf_accmgr_name"),
                    "crf_accmgr_datetime" => conDateTimeToDb($obj->gci()->input->post("crf_accmgr_datetime")),
                    "crf_accmgrapprove_status" => $obj->gci()->input->post("mgracc_appro"),
                    "crf_status" => "Account Manager Not approve"
                );
    
                $obj->gci()->db->where("crf_id", $crfid);
                $obj->gci()->db->update("crf_maindata", $arAccMgr);
                $obj->gci()->email->sendemail_InAccMgrNotApprove($obj->gci()->input->post("accMgrFormno"));
            }
        }
    }
}


function saveDerector1($crfid)
{
    $obj = new addfn();
    $obj->gci()->load->model('main/email_model', 'email');

    if ($obj->gci()->input->post("director1_appro") == "อนุมัติ") {
        if (check_directorapprove($crfid)->crf_directorapprove_status2 == "อนุมัติ") {
            $status = "Directors approved";
        } else {
            $status = "Waiting for second director approve";
        }
        $arDirector = array(
            "crf_director_detail1" => $obj->gci()->input->post("crf_director_detail1"),
            "crf_director_name1" => $obj->gci()->input->post("crf_director_name1"),
            "crf_director_datetime1" => conDateTimeToDb($obj->gci()->input->post("crf_director_datetime1")),
            "crf_directorapprove_status1" => $obj->gci()->input->post("director1_appro"),
            "crf_status" => $status
        );
    
        $obj->gci()->db->where("crf_id", $crfid);
        $obj->gci()->db->update("crf_maindata", $arDirector);
    } else {
        $status = "Director Not approve";

        $arCustomerTemp = array(
            "crfcus_brcode" => "",
            "crfcus_tempstatus" => "Not approve",
            "crfcus_datetimeupdate" => date("Y-m-d H:i:s")
        );
        $obj->gci()->db->where("crfcus_id", $obj->gci()->input->post("Director1Cuscode"));
        $obj->gci()->db->update("crf_customers_temp", $arCustomerTemp);

        $obj->gci()->db->where("crfcus_id", $obj->gci()->input->post("Director1Cuscode"));
        $obj->gci()->db->delete("crf_customers");

        $arDirector = array(
            "crf_director_detail1" => $obj->gci()->input->post("crf_director_detail1"),
            "crf_director_name1" => $obj->gci()->input->post("crf_director_name1"),
            "crf_director_datetime1" => conDateTimeToDb($obj->gci()->input->post("crf_director_datetime1")),
            "crf_directorapprove_status1" => $obj->gci()->input->post("director1_appro"),
            "crf_status" => $status
        );
    
        $obj->gci()->db->where("crf_id", $crfid);
        $obj->gci()->db->update("crf_maindata", $arDirector);
            $obj->gci()->email->sendemail_InDirectorNotApprove($obj->gci()->input->post("direc2FormNo"));
    }


    // if($obj->gci()->input->post("direc1_cusTypeForEmail") == 1){
    //     $obj->gci()->email->sendemail_toDerector2($obj->gci()->input->post("director1Formno"));
    // }else if($obj->gci()->input->post("direc1_cusTypeForEmail") == 2){
    //     $obj->gci()->email->sendemail_toDerector2type2($obj->gci()->input->post("director1Formno"));
    // }

}


function saveDerector2($crfid)
{
    $obj = new addfn();
    $obj->gci()->load->model('main/email_model', 'email');

    if ($obj->gci()->input->post("director2_appro") == "อนุมัติ") {
        if (check_directorapprove($crfid)->crf_directorapprove_status1 == "อนุมัติ") {
            $status = "Directors approved";
        } else {
            $status = "Waiting for second director approve";
        }

        $arDirector = array(
            "crf_director_detail2" => $obj->gci()->input->post("crf_director_detail2"),
            "crf_director_name2" => $obj->gci()->input->post("crf_director_name2"),
            "crf_director_datetime2" => conDateTimeToDb($obj->gci()->input->post("crf_director_datetime2")),
            "crf_directorapprove_status2" => $obj->gci()->input->post("director2_appro"),
            "crf_status" => $status
        );
    
        $obj->gci()->db->where("crf_id", $crfid);
        $obj->gci()->db->update("crf_maindata", $arDirector);
    } else {
        $status = "Director Not approve";

        $arCustomerTemp = array(
            "crfcus_brcode" => "",
            "crfcus_tempstatus" => "Not approve",
            "crfcus_datetimeupdate" => date("Y-m-d H:i:s")
        );
        $obj->gci()->db->where("crfcus_id", $obj->gci()->input->post("Director2Cuscode"));
        $obj->gci()->db->update("crf_customers_temp", $arCustomerTemp);

        $obj->gci()->db->where("crfcus_id", $obj->gci()->input->post("Director2Cuscode"));
        $obj->gci()->db->delete("crf_customers");

        $arDirector = array(
            "crf_director_detail2" => $obj->gci()->input->post("crf_director_detail2"),
            "crf_director_name2" => $obj->gci()->input->post("crf_director_name2"),
            "crf_director_datetime2" => conDateTimeToDb($obj->gci()->input->post("crf_director_datetime2")),
            "crf_directorapprove_status2" => $obj->gci()->input->post("director2_appro"),
            "crf_status" => $status
        );
    
        $obj->gci()->db->where("crf_id", $crfid);
        $obj->gci()->db->update("crf_maindata", $arDirector);
        $obj->gci()->email->sendemail_InDirectorNotApprove($obj->gci()->input->post("direc2FormNo"));
    }

    // $obj->gci()->email->sendemail_toAccStaff($obj->gci()->input->post("direc2FormNo"));
}



// สำหรับเปลี่ยนเขตการขาย
function saveDirector2ChangSales($crfid)
{
    $obj = new addfn();


    if ($obj->gci()->input->post("director2_appro") == "อนุมัติ" || $obj->gci()->input->post("director1_appro") == "อนุมัติ") {
        if (check_directorapprove($crfid)->crf_directorapprove_status1 == "อนุมัติ" && check_directorapprove($crfid)->crf_directorapprove_status2 == "") {
            $arDirector = array(
                "crf_director_detail2" => $obj->gci()->input->post("crf_director_detail2"),
                "crf_director_name2" => $obj->gci()->input->post("crf_director_name2"),
                "crf_director_datetime2" => conDateTimeToDb($obj->gci()->input->post("crf_director_datetime2")),
                "crf_directorapprove_status2" => $obj->gci()->input->post("director2_appro"),
                "crf_status" => "Directors approved"
            );
            $obj->gci()->db->where("crf_id", $crfid);
            $obj->gci()->db->update("crf_maindata", $arDirector);
        } else if (check_directorapprove($crfid)->crf_directorapprove_status2 == "อนุมัติ" && check_directorapprove($crfid)->crf_directorapprove_status1 == "") {
            $arDirector = array(
                "crf_director_detail1" => $obj->gci()->input->post("crf_director_detail1"),
                "crf_director_name1" => $obj->gci()->input->post("crf_director_name1"),
                "crf_director_datetime1" => conDateTimeToDb($obj->gci()->input->post("crf_director_datetime1")),
                "crf_directorapprove_status1" => $obj->gci()->input->post("director1_appro"),
                "crf_status" => "Directors approved"
            );
            $obj->gci()->db->where("crf_id", $crfid);
            $obj->gci()->db->update("crf_maindata", $arDirector);
        }


        $arUpdateCusTemp = array(
            "crfcus_tempstatus" => "Updated",
            "crfcus_datetimeupdate" => date("Y-m-d H:i:s")
        );
        $obj->gci()->db->where("crfcus_formno", $obj->gci()->input->post("direc2FormNo"));
        if ($obj->gci()->db->update("crf_customers_temp", $arUpdateCusTemp)) {

            $obj->gci()->db->select("crfcus_salesreps");
            $obj->gci()->db->from("crf_customers_temp");
            $obj->gci()->db->where("crfcus_formno", $obj->gci()->input->post("direc2FormNo"));
            $queryTemp = $obj->gci()->db->get();

            foreach ($queryTemp->result() as $result) {
                $arUpdateToCustomers = array(
                    "crfcus_salesreps" => $result->crfcus_salesreps,
                    "crfcus_usermodify_datetime" => date("Y-m-d H:i:s")
                );
                $obj->gci()->db->where("crfcus_id", $obj->gci()->input->post("Director2Cuscode"));
                $obj->gci()->db->update("crf_customers", $arUpdateToCustomers);
            }
        }
    } else {

        $arCustomerTemp = array(
            "crfcus_tempstatus" => "Not approve",
            "crfcus_datetimeupdate" => date("Y-m-d H:i:s")
        );
        $obj->gci()->db->where("crfcus_formno", $obj->gci()->input->post("direc2FormNo"));
        $obj->gci()->db->update("crf_customers_temp", $arCustomerTemp);


        if (check_directorapprove($crfid)->crf_directorapprove_status1 == "อนุมัติ") {
            $arDirector = array(
                "crf_director_detail2" => $obj->gci()->input->post("crf_director_detail2"),
                "crf_director_name2" => $obj->gci()->input->post("crf_director_name2"),
                "crf_director_datetime2" => conDateTimeToDb($obj->gci()->input->post("crf_director_datetime2")),
                "crf_directorapprove_status2" => $obj->gci()->input->post("director2_appro"),
                "crf_status" => "Director Not approved"
            );
        } else if (check_directorapprove($crfid)->crf_directorapprove_status2 == "อนุมัติ") {
            $arDirector = array(
                "crf_director_detail1" => $obj->gci()->input->post("crf_director_detail1"),
                "crf_director_name1" => $obj->gci()->input->post("crf_director_name1"),
                "crf_director_datetime1" => conDateTimeToDb($obj->gci()->input->post("crf_director_datetime1")),
                "crf_directorapprove_status1" => $obj->gci()->input->post("director1_appro"),
                "crf_status" => "Director Not approved"
            );
        }

        // $arDirector = array(
        //     "crf_director_detail2" => $obj->gci()->input->post("crf_director_detail2"),
        //     "crf_director_name2" => $obj->gci()->input->post("crf_director_name2"),
        //     "crf_director_datetime2" => conDateTimeToDb($obj->gci()->input->post("crf_director_datetime2")),
        //     "crf_directorapprove_status2" => $obj->gci()->input->post("director2_appro"),
        //     "crf_status" => "Director Not approved"
        // );
        $obj->gci()->db->where("crf_id", $crfid);
        $obj->gci()->db->update("crf_maindata", $arDirector);
    }
}


// สำหรับเปลี่ยนแปลงที่อยู่
function saveDirector2ChangeAddress($crfid)
{
    $obj = new addfn();


    if ($obj->gci()->input->post("director2_appro") == "อนุมัติ" || $obj->gci()->input->post("director1_appro") == "อนุมัติ") {
        if (check_directorapprove($crfid)->crf_directorapprove_status1 == "อนุมัติ" && check_directorapprove($crfid)->crf_directorapprove_status2 == "") {
            $arDirector = array(
                "crf_director_detail2" => $obj->gci()->input->post("crf_director_detail2"),
                "crf_director_name2" => $obj->gci()->input->post("crf_director_name2"),
                "crf_director_datetime2" => conDateTimeToDb($obj->gci()->input->post("crf_director_datetime2")),
                "crf_directorapprove_status2" => $obj->gci()->input->post("director2_appro"),
                "crf_status" => "Directors approved"
            );
            $obj->gci()->db->where("crf_id", $crfid);
            $obj->gci()->db->update("crf_maindata", $arDirector);
        } else if (check_directorapprove($crfid)->crf_directorapprove_status2 == "อนุมัติ" && check_directorapprove($crfid)->crf_directorapprove_status1 == "") {
            $arDirector = array(
                "crf_director_detail1" => $obj->gci()->input->post("crf_director_detail1"),
                "crf_director_name1" => $obj->gci()->input->post("crf_director_name1"),
                "crf_director_datetime1" => conDateTimeToDb($obj->gci()->input->post("crf_director_datetime1")),
                "crf_directorapprove_status1" => $obj->gci()->input->post("director1_appro"),
                "crf_status" => "Directors approved"
            );
            $obj->gci()->db->where("crf_id", $crfid);
            $obj->gci()->db->update("crf_maindata", $arDirector);
        }


        $arUpdateCusTemp = array(
            "crfcus_tempstatus" => "Updated",
            "crfcus_datetimeupdate" => date("Y-m-d H:i:s")
        );
        $obj->gci()->db->where("crfcus_formno", $obj->gci()->input->post("direc2FormNo"));
        if ($obj->gci()->db->update("crf_customers_temp", $arUpdateCusTemp)) {

            $obj->gci()->db->select("crfcus_addresstype , crfcus_address , crfcus_contactname , crfcus_phone , crfcus_fax , crfcus_email , crfcus_regiscapital , crfcus_file1");
            $obj->gci()->db->from("crf_customers_temp");
            $obj->gci()->db->where("crfcus_formno", $obj->gci()->input->post("direc2FormNo"));
            $queryTemp = $obj->gci()->db->get();

            foreach ($queryTemp->result() as $result) {
                $arUpdateToCustomers = array(
                    "crfcus_addresstype" => $result->crfcus_addresstype,
                    "crfcus_address" => $result->crfcus_address,
                    // "crfcus_contactname" => $result->crfcus_contactname,
                    // "crfcus_phone" => $result->crfcus_phone,
                    // "crfcus_fax" => $result->crfcus_fax,
                    // "crfcus_email" => $result->crfcus_email,
                    // "crfcus_regiscapital" => $result->crfcus_regiscapital,
                    "crfcus_file1" => $result->crfcus_file1,
                    "crfcus_usermodify_datetime" => date("Y-m-d H:i:s")
                );
                $obj->gci()->db->where("crfcus_id", $obj->gci()->input->post("Director2Cuscode"));
                $obj->gci()->db->update("crf_customers", $arUpdateToCustomers);
            }
        }
    } else {

        $arCustomerTemp = array(
            "crfcus_tempstatus" => "Not approve",
            "crfcus_datetimeupdate" => date("Y-m-d H:i:s")
        );
        $obj->gci()->db->where("crfcus_formno", $obj->gci()->input->post("direc2FormNo"));
        $obj->gci()->db->update("crf_customers_temp", $arCustomerTemp);


        if (check_directorapprove($crfid)->crf_directorapprove_status1 == "อนุมัติ") {
            $arDirector = array(
                "crf_director_detail2" => $obj->gci()->input->post("crf_director_detail2"),
                "crf_director_name2" => $obj->gci()->input->post("crf_director_name2"),
                "crf_director_datetime2" => conDateTimeToDb($obj->gci()->input->post("crf_director_datetime2")),
                "crf_directorapprove_status2" => $obj->gci()->input->post("director2_appro"),
                "crf_status" => "Director Not approved"
            );
        } else if (check_directorapprove($crfid)->crf_directorapprove_status2 == "อนุมัติ") {
            $arDirector = array(
                "crf_director_detail1" => $obj->gci()->input->post("crf_director_detail1"),
                "crf_director_name1" => $obj->gci()->input->post("crf_director_name1"),
                "crf_director_datetime1" => conDateTimeToDb($obj->gci()->input->post("crf_director_datetime1")),
                "crf_directorapprove_status1" => $obj->gci()->input->post("director1_appro"),
                "crf_status" => "Director Not approved"
            );
        }
        $obj->gci()->db->where("crf_id", $crfid);
        $obj->gci()->db->update("crf_maindata", $arDirector);
    }
}


// สำหรับ ปรับ Credit term
function saveDirector2ChangeCredit($crfid)
{
    $obj = new addfn();

    if ($obj->gci()->input->post("director2_appro") == "อนุมัติ" || $obj->gci()->input->post("director1_appro") == "อนุมัติ") {

        if (check_directorapprove($crfid)->crf_directorapprove_status1 == "อนุมัติ" && check_directorapprove($crfid)->crf_directorapprove_status2 == "") {
            $arDirector = array(
                "crf_director_detail2" => $obj->gci()->input->post("crf_director_detail2"),
                "crf_director_name2" => $obj->gci()->input->post("crf_director_name2"),
                "crf_director_datetime2" => conDateTimeToDb($obj->gci()->input->post("crf_director_datetime2")),
                "crf_directorapprove_status2" => $obj->gci()->input->post("director2_appro"),
                "crf_status" => "Directors approved"
            );
            $obj->gci()->db->where("crf_id", $crfid);
            $obj->gci()->db->update("crf_maindata", $arDirector);
        } else if (check_directorapprove($crfid)->crf_directorapprove_status2 == "อนุมัติ" && check_directorapprove($crfid)->crf_directorapprove_status1 == "") {
            $arDirector = array(
                "crf_director_detail1" => $obj->gci()->input->post("crf_director_detail1"),
                "crf_director_name1" => $obj->gci()->input->post("crf_director_name1"),
                "crf_director_datetime1" => conDateTimeToDb($obj->gci()->input->post("crf_director_datetime1")),
                "crf_directorapprove_status1" => $obj->gci()->input->post("director1_appro"),
                "crf_status" => "Directors approved"
            );
            $obj->gci()->db->where("crf_id", $crfid);
            $obj->gci()->db->update("crf_maindata", $arDirector);
        }

        $arUpdateCusTemp = array(
            "crfcus_tempstatus" => "Updated",
            "crfcus_datetimeupdate" => date("Y-m-d H:i:s")
        );
        $obj->gci()->db->where("crfcus_formno", $obj->gci()->input->post("direc2FormNo"));
        if ($obj->gci()->db->update("crf_customers_temp", $arUpdateCusTemp)) {

            $obj->gci()->db->select("crfcus_creditterm2");
            $obj->gci()->db->from("crf_customers_temp");
            $obj->gci()->db->where("crfcus_formno", $obj->gci()->input->post("direc2FormNo"));
            $queryTemp = $obj->gci()->db->get();

            foreach ($queryTemp->result() as $result) {
                $arUpdateToCustomers = array(
                    "crfcus_creditterm" => $result->crfcus_creditterm2,
                    "crfcus_usermodify_datetime" => date("Y-m-d H:i:s")
                );
                $obj->gci()->db->where("crfcus_id", $obj->gci()->input->post("Director2Cuscode"));
                $obj->gci()->db->update("crf_customers", $arUpdateToCustomers);
            }
        }
    } else {

        $arCustomerTemp = array(
            "crfcus_tempstatus" => "Not approve",
            "crfcus_datetimeupdate" => date("Y-m-d H:i:s")
        );
        $obj->gci()->db->where("crfcus_formno", $obj->gci()->input->post("direc2FormNo"));
        $obj->gci()->db->update("crf_customers_temp", $arCustomerTemp);


        if (check_directorapprove($crfid)->crf_directorapprove_status1 == "อนุมัติ") {
            $arDirector = array(
                "crf_director_detail2" => $obj->gci()->input->post("crf_director_detail2"),
                "crf_director_name2" => $obj->gci()->input->post("crf_director_name2"),
                "crf_director_datetime2" => conDateTimeToDb($obj->gci()->input->post("crf_director_datetime2")),
                "crf_directorapprove_status2" => $obj->gci()->input->post("director2_appro"),
                "crf_status" => "Director Not approved"
            );
        } else if (check_directorapprove($crfid)->crf_directorapprove_status2 == "อนุมัติ") {
            $arDirector = array(
                "crf_director_detail1" => $obj->gci()->input->post("crf_director_detail1"),
                "crf_director_name1" => $obj->gci()->input->post("crf_director_name1"),
                "crf_director_datetime1" => conDateTimeToDb($obj->gci()->input->post("crf_director_datetime1")),
                "crf_directorapprove_status1" => $obj->gci()->input->post("director1_appro"),
                "crf_status" => "Director Not approved"
            );
        }
        $obj->gci()->db->where("crf_id", $crfid);
        $obj->gci()->db->update("crf_maindata", $arDirector);
    }
}




// สำหรับ ปรับ วงเงิน
function saveDirector2ChangeMoney($crfid)
{
    $obj = new addfn();

    if ($obj->gci()->input->post("director2_appro") == "อนุมัติ" || $obj->gci()->input->post("director1_appro") == "อนุมัติ") {

        if (check_directorapprove($crfid)->crf_directorapprove_status1 == "อนุมัติ" && check_directorapprove($crfid)->crf_directorapprove_status2 == "") {
            $arDirector = array(
                "crf_director_detail2" => $obj->gci()->input->post("crf_director_detail2"),
                "crf_director_name2" => $obj->gci()->input->post("crf_director_name2"),
                "crf_director_datetime2" => conDateTimeToDb($obj->gci()->input->post("crf_director_datetime2")),
                "crf_directorapprove_status2" => $obj->gci()->input->post("director2_appro"),
                "crf_status" => "Directors approved"
            );
            $obj->gci()->db->where("crf_id", $crfid);
            $obj->gci()->db->update("crf_maindata", $arDirector);
        } else if (check_directorapprove($crfid)->crf_directorapprove_status2 == "อนุมัติ" && check_directorapprove($crfid)->crf_directorapprove_status1 == "") {
            $arDirector = array(
                "crf_director_detail1" => $obj->gci()->input->post("crf_director_detail1"),
                "crf_director_name1" => $obj->gci()->input->post("crf_director_name1"),
                "crf_director_datetime1" => conDateTimeToDb($obj->gci()->input->post("crf_director_datetime1")),
                "crf_directorapprove_status1" => $obj->gci()->input->post("director1_appro"),
                "crf_status" => "Directors approved"
            );
            $obj->gci()->db->where("crf_id", $crfid);
            $obj->gci()->db->update("crf_maindata", $arDirector);
        }

        $arUpdateCusTemp = array(
            "crfcus_tempstatus" => "Updated",
            "crfcus_datetimeupdate" => date("Y-m-d H:i:s")
        );
        $obj->gci()->db->where("crfcus_formno", $obj->gci()->input->post("direc2FormNo"));
        if ($obj->gci()->db->update("crf_customers_temp", $arUpdateCusTemp)) {

            $obj->gci()->db->select("crfcus_moneylimit2");
            $obj->gci()->db->from("crf_customers_temp");
            $obj->gci()->db->where("crfcus_formno", $obj->gci()->input->post("direc2FormNo"));
            $queryTemp = $obj->gci()->db->get();

            foreach ($queryTemp->result() as $result) {
                $arUpdateToCustomers = array(
                    "crfcus_moneylimit" => $result->crfcus_moneylimit2,
                    "crfcus_usermodify_datetime" => date("Y-m-d H:i:s")
                );
                $obj->gci()->db->where("crfcus_id", $obj->gci()->input->post("Director2Cuscode"));
                $obj->gci()->db->update("crf_customers", $arUpdateToCustomers);
            }
        }
    } else {
        $arCustomerTemp = array(
            "crfcus_tempstatus" => "Not approve",
            "crfcus_datetimeupdate" => date("Y-m-d H:i:s")
        );
        $obj->gci()->db->where("crfcus_formno", $obj->gci()->input->post("direc2FormNo"));
        $obj->gci()->db->update("crf_customers_temp", $arCustomerTemp);


        if (check_directorapprove($crfid)->crf_directorapprove_status1 == "อนุมัติ") {
            $arDirector = array(
                "crf_director_detail2" => $obj->gci()->input->post("crf_director_detail2"),
                "crf_director_name2" => $obj->gci()->input->post("crf_director_name2"),
                "crf_director_datetime2" => conDateTimeToDb($obj->gci()->input->post("crf_director_datetime2")),
                "crf_directorapprove_status2" => $obj->gci()->input->post("director2_appro"),
                "crf_status" => "Director Not approved"
            );
        } else if (check_directorapprove($crfid)->crf_directorapprove_status2 == "อนุมัติ") {
            $arDirector = array(
                "crf_director_detail1" => $obj->gci()->input->post("crf_director_detail1"),
                "crf_director_name1" => $obj->gci()->input->post("crf_director_name1"),
                "crf_director_datetime1" => conDateTimeToDb($obj->gci()->input->post("crf_director_datetime1")),
                "crf_directorapprove_status1" => $obj->gci()->input->post("director1_appro"),
                "crf_status" => "Director Not approved"
            );
        }
        $obj->gci()->db->where("crf_id", $crfid);
        $obj->gci()->db->update("crf_maindata", $arDirector);
    }
}




// สำหรับแก้ไขข้อมูลลูกค้า
function saveDirector2editCustomer($crfid)
{
    $obj = new addfn();

    if ($obj->gci()->input->post("director2_appro") == "อนุมัติ" || $obj->gci()->input->post("director1_appro") == "อนุมัติ") {

        if (check_directorapprove($crfid)->crf_directorapprove_status1 == "อนุมัติ" && check_directorapprove($crfid)->crf_directorapprove_status2 == "") {
            $arDirector = array(
                "crf_director_detail2" => $obj->gci()->input->post("crf_director_detail2"),
                "crf_director_name2" => $obj->gci()->input->post("crf_director_name2"),
                "crf_director_datetime2" => conDateTimeToDb($obj->gci()->input->post("crf_director_datetime2")),
                "crf_directorapprove_status2" => $obj->gci()->input->post("director2_appro"),
                "crf_status" => "Directors approved"
            );
            $obj->gci()->db->where("crf_id", $crfid);
            $obj->gci()->db->update("crf_maindata", $arDirector);
        } else if (check_directorapprove($crfid)->crf_directorapprove_status2 == "อนุมัติ" && check_directorapprove($crfid)->crf_directorapprove_status1 == "") {
            $arDirector = array(
                "crf_director_detail1" => $obj->gci()->input->post("crf_director_detail1"),
                "crf_director_name1" => $obj->gci()->input->post("crf_director_name1"),
                "crf_director_datetime1" => conDateTimeToDb($obj->gci()->input->post("crf_director_datetime1")),
                "crf_directorapprove_status1" => $obj->gci()->input->post("director1_appro"),
                "crf_status" => "Directors approved"
            );
            $obj->gci()->db->where("crf_id", $crfid);
            $obj->gci()->db->update("crf_maindata", $arDirector);
        }

        $arUpdateCusTemp = array(
            "crfcus_tempstatus" => "Updated",
            "crfcus_datetimeupdate" => date("Y-m-d H:i:s")
        );
        $obj->gci()->db->where("crfcus_formno", $obj->gci()->input->post("direc2FormNo"));
        if ($obj->gci()->db->update("crf_customers_temp", $arUpdateCusTemp)) {

            $obj->gci()->db->select("crfcus_contactname , crfcus_phone , crfcus_fax , crfcus_email , crfcus_regiscapital , crfcus_mapurl , crfcus_mapfile");
            $obj->gci()->db->from("crf_customers_temp");
            $obj->gci()->db->where("crfcus_formno", $obj->gci()->input->post("direc2FormNo"));
            $queryTemp = $obj->gci()->db->get();

            foreach ($queryTemp->result() as $result) {
                $arUpdateToCustomers = array(
                    "crfcus_contactname" => $result->crfcus_contactname,
                    "crfcus_phone" => $result->crfcus_phone,
                    "crfcus_fax" => $result->crfcus_fax,
                    "crfcus_email" => $result->crfcus_email,
                    "crfcus_regiscapital" => $result->crfcus_regiscapital,
                    "crfcus_mapurl" => $result->crfcus_mapurl,
                    "crfcus_mapfile" => $result->crfcus_mapfile
                );
                $obj->gci()->db->where("crfcus_id", $obj->gci()->input->post("Director2Cuscode"));
                $obj->gci()->db->update("crf_customers", $arUpdateToCustomers);
            }



            if (deletePrimanage3($obj->gci()->input->post("Director2Cuscode"))) {
                $obj->gci()->db->select("crf_primanage_dept , crf_primanage_name , crf_primanage_posi , crf_primanage_email , crf_pricusid");
                $obj->gci()->db->from("crf_pri_manage_temp");
                $obj->gci()->db->where("crf_pricus_formno", $obj->gci()->input->post("direc2FormNo"));
                $queryPriTemp = $obj->gci()->db->get();

                foreach ($queryPriTemp->result() as $rs) {

                    $arsavePri = array(
                        "crf_pricusid" => $rs->crf_pricusid,
                        "crf_primanage_dept" => $rs->crf_primanage_dept,
                        "crf_primanage_name" => $rs->crf_primanage_name,
                        "crf_primanage_posi" => $rs->crf_primanage_posi,
                        "crf_primanage_email" => $rs->crf_primanage_email
                    );
                    $obj->gci()->db->insert("crf_pri_manage", $arsavePri);
                }
            }
        }
    } else {
        $arCustomerTemp = array(
            "crfcus_tempstatus" => "Not approve",
            "crfcus_datetimeupdate" => date("Y-m-d H:i:s")
        );
        $obj->gci()->db->where("crfcus_formno", $obj->gci()->input->post("direc2FormNo"));
        $obj->gci()->db->update("crf_customers_temp", $arCustomerTemp);


        if (check_directorapprove($crfid)->crf_directorapprove_status1 == "อนุมัติ") {
            $arDirector = array(
                "crf_director_detail2" => $obj->gci()->input->post("crf_director_detail2"),
                "crf_director_name2" => $obj->gci()->input->post("crf_director_name2"),
                "crf_director_datetime2" => conDateTimeToDb($obj->gci()->input->post("crf_director_datetime2")),
                "crf_directorapprove_status2" => $obj->gci()->input->post("director2_appro"),
                "crf_status" => "Director Not approved"
            );
        } else if (check_directorapprove($crfid)->crf_directorapprove_status2 == "อนุมัติ") {
            $arDirector = array(
                "crf_director_detail1" => $obj->gci()->input->post("crf_director_detail1"),
                "crf_director_name1" => $obj->gci()->input->post("crf_director_name1"),
                "crf_director_datetime1" => conDateTimeToDb($obj->gci()->input->post("crf_director_datetime1")),
                "crf_directorapprove_status1" => $obj->gci()->input->post("director1_appro"),
                "crf_status" => "Director Not approved"
            );
        }
        $obj->gci()->db->where("crf_id", $crfid);
        $obj->gci()->db->update("crf_maindata", $arDirector);
    }
}





function accProcess($crfid, $crfcusid)
{
    $obj = new addfn();
    $obj->gci()->load->model('main/email_model', 'email');

    $formno = $obj->gci()->input->post("accStaffFormNo");
    $accCheckmethod3 = $obj->gci()->input->post("accCheckmethod3");
    $accCheckmethod4 = $obj->gci()->input->post("accCheckmethod4");

    if ($accCheckmethod3 == 0 || $accCheckmethod4 == 0) {
        accProcessSaleRep($formno, $crfcusid);
        accProcessAddress($formno, $crfcusid);
        accProcessEditcus($formno, $crfcusid);
    }

    $arAccStaff = array(
        "crf_memo_customercode" => $obj->gci()->input->post("accStaffMemo"),
        "crf_usersave_customercode" => $obj->gci()->input->post("cusCode_userPost"),
        "crf_datetimesave_customercode" => conDateTimeToDb($obj->gci()->input->post("cusCode_datetimePost")),
        "crf_status" => "Completed"
    );
    $obj->gci()->db->where("crf_id", $crfid);
    $obj->gci()->db->update("crf_maindata", $arAccStaff);


    $arUpdateStatus = array(
        "crfcus_tempstatus" => "Updated",
        "crfcus_datetimeupdate" => date("Y-m-d H:i:s")
    );
    $obj->gci()->db->where("crfcus_id", $crfcusid);
    $obj->gci()->db->update("crf_customers_temp", $arUpdateStatus);


    if ($accCheckmethod3 == 0 && $accCheckmethod4 == 0) {
        $obj->gci()->email->sendemail_toOwnerType3($formno);
    } else if($accCheckmethod3 != 0 || $accCheckmethod4 != 0){
        $obj->gci()->email->sendemail_toOwnerType2($formno);
    }
}

function accProcessSaleRep($formno, $cusid)
{
    $obj = new addfn();
    $obj->gci()->db->select("crfcus_salesreps");
    $obj->gci()->db->from("crf_customers_temp");
    $obj->gci()->db->where("crfcus_formno", $formno);
    $queryTemp = $obj->gci()->db->get();

    foreach ($queryTemp->result() as $result) {
        $arUpdateToCustomers = array(
            "crfcus_salesreps" => $result->crfcus_salesreps,
            "crfcus_usermodify_datetime" => date("Y-m-d H:i:s")
        );
        $obj->gci()->db->where("crfcus_id", $cusid);
        $obj->gci()->db->update("crf_customers", $arUpdateToCustomers);
    }
}

function accProcessAddress($formno, $cusid)
{
    $obj = new addfn();
    $obj->gci()->db->select("crfcus_addresstype , crfcus_address , crfcus_file1");
    $obj->gci()->db->from("crf_customers_temp");
    $obj->gci()->db->where("crfcus_formno", $formno);
    $queryTemp = $obj->gci()->db->get();

    foreach ($queryTemp->result() as $result) {
        $arUpdateToCustomers = array(
            "crfcus_addresstype" => $result->crfcus_addresstype,
            "crfcus_address" => $result->crfcus_address,
            "crfcus_file1" => $result->crfcus_file1,
            "crfcus_usermodify_datetime" => date("Y-m-d H:i:s")
        );
        $obj->gci()->db->where("crfcus_id", $cusid);
        $obj->gci()->db->update("crf_customers", $arUpdateToCustomers);
    }
}

function accProcessEditcus($formno, $cusid)
{
    $obj = new addfn();
    $obj->gci()->db->select("crfcus_contactname , crfcus_phone , crfcus_fax , crfcus_email , crfcus_regiscapital , crfcus_mapurl , crfcus_mapfile ,crfcus_name, crfcus_file1 , crfcus_file2 , crfcus_file3 , crfcus_file4 , crfcus_file5 , crfcus_file6");
    $obj->gci()->db->from("crf_customers_temp");
    $obj->gci()->db->where("crfcus_formno", $formno);
    $queryTemp = $obj->gci()->db->get();

    foreach ($queryTemp->result() as $result) {
        $arUpdateToCustomers = array(
            "crfcus_name" => $result->crfcus_name,
            "crfcus_contactname" => $result->crfcus_contactname,
            "crfcus_phone" => $result->crfcus_phone,
            "crfcus_fax" => $result->crfcus_fax,
            "crfcus_email" => $result->crfcus_email,
            "crfcus_regiscapital" => $result->crfcus_regiscapital,
            "crfcus_mapurl" => $result->crfcus_mapurl,
            "crfcus_mapfile" => $result->crfcus_mapfile,
            "crfcus_file1" => $result->crfcus_file1,
            "crfcus_file2" => $result->crfcus_file2,
            "crfcus_file3" => $result->crfcus_file3,
            "crfcus_file4" => $result->crfcus_file4,
            "crfcus_file5" => $result->crfcus_file5,
            "crfcus_file6" => $result->crfcus_file6,
        );
        $obj->gci()->db->where("crfcus_id", $cusid);
        $obj->gci()->db->update("crf_customers", $arUpdateToCustomers);
    }



    if (deletePrimanage3($cusid)) {
        $obj->gci()->db->select("crf_primanage_dept , crf_primanage_name , crf_primanage_posi , crf_primanage_email , crf_pricusid");
        $obj->gci()->db->from("crf_pri_manage_temp");
        $obj->gci()->db->where("crf_pricus_formno", $formno);
        $queryPriTemp = $obj->gci()->db->get();

        foreach ($queryPriTemp->result() as $rs) {

            $arsavePri = array(
                "crf_pricusid" => $rs->crf_pricusid,
                "crf_primanage_dept" => $rs->crf_primanage_dept,
                "crf_primanage_name" => $rs->crf_primanage_name,
                "crf_primanage_posi" => $rs->crf_primanage_posi,
                "crf_primanage_email" => $rs->crf_primanage_email
            );
            $obj->gci()->db->insert("crf_pri_manage", $arsavePri);
        }
    }
}


function saveCustomersCode($crfid, $crfcusid)
{
    $obj = new addfn();
    $obj->gci()->load->model('main/email_model', 'email');
    $arAccStaff = array(
        "crf_savecustomercode" => $obj->gci()->input->post("cusCode"),
        "crf_memo_customercode" => $obj->gci()->input->post("accStaffMemo"),
        "crf_usersave_customercode" => $obj->gci()->input->post("cusCode_userPost"),
        "crf_datetimesave_customercode" => conDateTimeToDb($obj->gci()->input->post("cusCode_datetimePost")),
        "crf_status" => "Completed"
    );

    $arUpdateCuscode = array(
        "crfcus_code" => $obj->gci()->input->post("cusCode"),
        "crfcus_tempstatus" => "Updated",
        "crfcus_datetimeupdate" => date("Y-m-d H:i:s")
    );

    $obj->gci()->db->where("crf_id", $crfid);
    $obj->gci()->db->update("crf_maindata", $arAccStaff);

    $obj->gci()->db->where("crfcus_id", $crfcusid);
    $updateCus = $obj->gci()->db->update("crf_customers_temp", $arUpdateCuscode);



    // update priority management
    $obj->gci()->db->select("*");
    $obj->gci()->db->from("crf_pri_manage_temp");
    $obj->gci()->db->where("crf_pricus_formno", $obj->gci()->input->post("accStaffFormNo"));
    $getprimanage = $obj->gci()->db->get();

    foreach ($getprimanage->result() as $rspri) {
        $arcopyToPiamanage = array(
            "crf_primanage_dept" => $rspri->crf_primanage_dept,
            "crf_primanage_name" => $rspri->crf_primanage_name,
            "crf_primanage_posi" => $rspri->crf_primanage_posi,
            "crf_primanage_email" => $rspri->crf_primanage_email,
            "crf_pricusid" => $rspri->crf_pricusid
        );
        $obj->gci()->db->insert("crf_pri_manage", $arcopyToPiamanage);
    }
    // update priority management


    if ($updateCus) {
        $obj->gci()->db->select("*");
        $obj->gci()->db->from("crf_customers_temp");
        $obj->gci()->db->where("crfcus_id", $crfcusid);
        $query = $obj->gci()->db->get();



        foreach ($query->result() as $result) {
            $arCopyToCustomerTable = array(
                "crfcus_id" => $result->crfcus_id,
                "crfcus_code" => $result->crfcus_code,
                "crfcus_brcode" => $result->crfcus_brcode,
                "crfcus_salesreps" => $result->crfcus_salesreps,
                "crfcus_name" => $result->crfcus_name,
                "crfcus_comdatecreate" => $result->crfcus_comdatecreate,
                "crfcus_addresstype" => $result->crfcus_addresstype,
                "crfcus_address" => $result->crfcus_address,
                "crfcus_contactname" => $result->crfcus_contactname,
                "crfcus_phone" => $result->crfcus_phone,
                "crfcus_fax" => $result->crfcus_fax,
                "crfcus_email" => $result->crfcus_email,
                "crfcus_regiscapital" => $result->crfcus_regiscapital,
                "crfcus_companytype" => $result->crfcus_companytype,
                "crfcus_comtype2" => $result->crfcus_comtype2,
                "crfcus_comtype31" => $result->crfcus_comtype31,
                "crfcus_comtype32" => $result->crfcus_comtype32,
                "crfcus_comtype33" => $result->crfcus_comtype33,
                "crfcus_comtype34" => $result->crfcus_comtype34,
                "crfcus_typebussi" => $result->crfcus_typebussi,
                "crfcus_forecast" => $result->crfcus_forecast,
                "crfcus_textmemo" => $result->crfcus_textmemo,
                "crfcus_personal" => $result->crfcus_personal,
                "crfcus_file1" => $result->crfcus_file1,
                "crfcus_file2" => $result->crfcus_file2,
                "crfcus_file3" => $result->crfcus_file3,
                "crfcus_file4" => $result->crfcus_file4,
                "crfcus_file5" => $result->crfcus_file5,
                "crfcus_file6" => $result->crfcus_file6,
                "crfcus_creditterm" => $result->crfcus_creditterm,
                "crfcus_creditterm2" => $result->crfcus_creditterm2,
                "crfcus_conditionbill" => $result->crfcus_conditionbill,
                "crfcus_tablebill" => $result->crfcus_tablebill,
                "crfcus_mapbill" => $result->crfcus_mapbill,
                "crfcus_datebill" => $result->crfcus_datebill,
                "crfcus_mapbill2" => $result->crfcus_mapbill2,
                "crfcus_conditionmoney" => $result->crfcus_conditionmoney,
                "crfcus_cheuqetable" => $result->crfcus_cheuqetable,
                "crfcus_cheuqedetail" => $result->crfcus_cheuqedetail,
                "crfcus_moneylimit" => $result->crfcus_moneylimit,
                "crfcus_moneylimit2" => $result->crfcus_moneylimit2,
                "crfcus_usercreate" => $result->crfcus_usercreate,
                "crfcus_usercreate_ecode" => $result->crfcus_usercreate_ecode,
                "crfcus_usercreate_deptcode" => $result->crfcus_usercreate_deptcode,
                "crfcus_datemodify" => $result->crfcus_datemodify,
                "crfcus_usermodify" => $result->crfcus_usermodify,
                "crfcus_usermodify_ecode" => $result->crfcus_usermodify_ecode,
                "crfcus_usermodify_deptcode" => $result->crfcus_usermodify_deptcode,
                "crfcus_usermodify_datetime" => date("Y-m-d H:i:s"),
                "crfcus_area" => $result->crfcus_area,
                "crfcus_taxid" => $result->crfcus_taxid,
                "crfcus_branch" => $result->crfcus_branch,
                "crfcus_mapurl" => $result->crfcus_mapurl,
                "crfcus_mapfile" => $result->crfcus_mapfile,
                "crfcus_products" => $result->crfcus_products

            );
            $obj->gci()->db->where("crfcus_id" , $crfcusid);
            $obj->gci()->db->update("crf_customers", $arCopyToCustomerTable);
        }
    }
    $obj->gci()->email->sendemail_toOwner($obj->gci()->input->post("accStaffFormNo"));
}






function exManagerApprove($crfexid)
{
    $obj = new addfn();
    $obj->gci()->load->model('main/email_model', 'email');

    if ($obj->gci()->input->post("ex_mgrApprove") == "Approve") {
        $arManager = array(
            "crfex_mgrapp_status" => $obj->gci()->input->post("ex_mgrApprove"),
            "crfex_mgrapp_detail" => $obj->gci()->input->post("ex_mgrApproveDetail"),
            "crfex_mgrapp_username" => $obj->gci()->input->post("ex_mgrApproveName"),
            "crfex_mgrapp_datetime" => conDateTimeToDb($obj->gci()->input->post("ex_mgrApproveDateTime")),
            "crfex_status" => "Manager approved"
        );
        $obj->gci()->db->where("crfex_id", $crfexid);
        $obj->gci()->db->update("crfex_maindata", $arManager);
    } else if ($obj->gci()->input->post("ex_mgrApprove") == "Not approve") {
        $arManager = array(
            "crfex_mgrapp_status" => $obj->gci()->input->post("ex_mgrApprove"),
            "crfex_mgrapp_detail" => $obj->gci()->input->post("ex_mgrApproveDetail"),
            "crfex_mgrapp_username" => $obj->gci()->input->post("ex_mgrApproveName"),
            "crfex_mgrapp_datetime" => conDateTimeToDb($obj->gci()->input->post("ex_mgrApproveDateTime")),
            "crfex_status" => "Manager Not Approve"
        );
        $obj->gci()->db->where("crfex_id", $crfexid);
        $obj->gci()->db->update("crfex_maindata", $arManager);
    }


    if ($obj->gci()->input->post("mgr_cusType") == 1) {

        if ($obj->gci()->input->post("ex_mgrApprove") == "Approve") {
            $obj->gci()->email->sendemail_toCsEx($obj->gci()->input->post("mgr_FormnoEx"));
        } else {
            $obj->gci()->email->sendemail_ManagerNotApprove($obj->gci()->input->post("mgr_FormnoEx"));
        }
    } else if ($obj->gci()->input->post("mgr_cusType") == 2) {
        if ($obj->gci()->input->post("ex_mgrApprove") == "Approve") {
            $obj->gci()->email->sendemail_toAccMgrEx2($obj->gci()->input->post("mgr_FormnoEx"));
        } else {
            $obj->gci()->email->sendemail_ManagerNotApprove($obj->gci()->input->post("mgr_FormnoEx"));
        }
    }
}



function exCsAddBr($crfexid)
{
    $obj = new addfn();
    $obj->gci()->load->model('main/email_model', 'email');


    $arCsToCustomerTemp = array(
        "crfexcus_brcode" => $obj->gci()->input->post("ex_csBrCode"),
    );
    $obj->gci()->db->where("crfexcus_formno", $obj->gci()->input->post("csFromno"));
    if ($obj->gci()->db->update("crfex_customers_temp", $arCsToCustomerTemp)) {
        $arCs = array(
            "crfex_brcode" => $obj->gci()->input->post("ex_csBrCode"),
            // "crfex_csmemo" => $obj->gci()->input->post("ex_csBrMemo"),
            "crfex_csuserpost" => $obj->gci()->input->post("ex_csBrName"),
            "crfex_csdatetime" => conDateTimeToDb($obj->gci()->input->post("excsBrDateTime")),
            "crfex_status" => "CS Added BR CODE"
        );
        $obj->gci()->db->where("crfex_id", $crfexid);
        $obj->gci()->db->update("crfex_maindata", $arCs);

        $obj->gci()->email->sendemail_toAccMgrEx($obj->gci()->input->post("csFromno"));
    }
}


function exAccMgrApprove($crfexid)
{
    $obj = new addfn();
    $obj->gci()->load->model('main/email_model', 'email');


    if ($obj->gci()->input->post("accMgr_cusType") == 1) {
        if ($obj->gci()->input->post("ex_accMgrApprove") == "Approve") {
            $arAccMgr = array(
                "crfex_accmgr_status" => $obj->gci()->input->post("ex_accMgrApprove"),
                "crfex_accmgr_username" => $obj->gci()->input->post("ex_accMgrApproveName"),
                "crfex_accmgr_datetime" => conDateTimeToDb($obj->gci()->input->post("ex_accMgrApproveDateTime")),
                "crfex_accmgr_detail" => $obj->gci()->input->post("ex_accMgrApproveDetail"),
                "crfex_status" => "Account Manager Approved"
            );
            $obj->gci()->db->where("crfex_id", $crfexid);
            $obj->gci()->db->update("crfex_maindata", $arAccMgr);
            $obj->gci()->email->sendemail_toDirectorEx($obj->gci()->input->post("accMgrFromno"));
        } else if ($obj->gci()->input->post("ex_accMgrApprove") == "Not approve") {
            $arAccMgr = array(
                "crfex_accmgr_status" => $obj->gci()->input->post("ex_accMgrApprove"),
                "crfex_accmgr_username" => $obj->gci()->input->post("ex_accMgrApproveName"),
                "crfex_accmgr_datetime" => conDateTimeToDb($obj->gci()->input->post("ex_accMgrApproveDateTime")),
                "crfex_accmgr_detail" => $obj->gci()->input->post("ex_accMgrApproveDetail"),
                "crfex_status" => "Account Manager Not Approve"
            );
            $obj->gci()->db->where("crfex_id", $crfexid);
            $obj->gci()->db->update("crfex_maindata", $arAccMgr);

            //Delete br code when acc mgr not approve
            $arDeleteBecode = array(
                "crfexcus_brcode" => "",
                "crfexcus_datetimeupdate" => date("Y-m-d H:i:s"),
                "crfexcus_tempstatus" => "Updated"
            );
            $obj->gci()->db->where("crfexcus_formno", $obj->gci()->input->post("accMgrFromno"));
            $obj->gci()->db->update("crfex_customers_temp", $arDeleteBecode);

            $obj->gci()->email->sendemail_AccMgrNotApprove($obj->gci()->input->post("accMgrFromno"));
        }
    } else if ($obj->gci()->input->post("accMgr_cusType") == 2) {

        if ($obj->gci()->input->post("ex_accMgrApprove") == "Approve") {
            if ($obj->gci()->input->post("accMgr_curcustopic2") == "") {
                $status = "Wait account staff process";
            } else {
                $status = "Account Manager Approved";
            }
            $arAccMgr = array(
                "crfex_accmgr_status" => $obj->gci()->input->post("ex_accMgrApprove"),
                "crfex_accmgr_username" => $obj->gci()->input->post("ex_accMgrApproveName"),
                "crfex_accmgr_datetime" => conDateTimeToDb($obj->gci()->input->post("ex_accMgrApproveDateTime")),
                "crfex_accmgr_detail" => $obj->gci()->input->post("ex_accMgrApproveDetail"),
                "crfex_status" => $status
            );
            $obj->gci()->db->where("crfex_id", $crfexid);
            $obj->gci()->db->update("crfex_maindata", $arAccMgr);


            $obj->gci()->email->sendemail_toDirectorEx2($obj->gci()->input->post("accMgrFromno"));
        } else if ($obj->gci()->input->post("ex_accMgrApprove") == "Not approve") {
            $arAccMgr = array(
                "crfex_accmgr_status" => $obj->gci()->input->post("ex_accMgrApprove"),
                "crfex_accmgr_username" => $obj->gci()->input->post("ex_accMgrApproveName"),
                "crfex_accmgr_datetime" => conDateTimeToDb($obj->gci()->input->post("ex_accMgrApproveDateTime")),
                "crfex_accmgr_detail" => $obj->gci()->input->post("ex_accMgrApproveDetail"),
                "crfex_status" => "Account Manager Not Approve"
            );
            $obj->gci()->db->where("crfex_id", $crfexid);
            $obj->gci()->db->update("crfex_maindata", $arAccMgr);

            //Delete br code when acc mgr not approve
            $arDeleteBecode = array(
                "crfexcus_datetimeupdate" => date("Y-m-d H:i:s"),
                "crfexcus_tempstatus" => "Updated"
            );
            $obj->gci()->db->where("crfexcus_formno", $obj->gci()->input->post("accMgrFromno"));
            $obj->gci()->db->update("crfex_customers_temp", $arDeleteBecode);

            $obj->gci()->email->sendemail_AccMgrNotApprove($obj->gci()->input->post("accMgrFromno"));
        }
    }
}



function exDirectorApprove($crfexid)
{
    $obj = new addfn();
    $obj->gci()->load->model('main/email_model', 'email');

    if ($obj->gci()->input->post("ex_directorApprove") == "Approve") {
        if (checkdirecStatus($crfexid, 2)->crfex_directorapp_status2 == "Approve") {
            // Maindata table
            $arDirector = array(
                "crfex_directorapp_status" => $obj->gci()->input->post("ex_directorApprove"),
                "crfex_directorapp_username" => $obj->gci()->input->post("ex_directorApproveName"),
                "crfex_directorapp_datetime" => conDateTimeToDb($obj->gci()->input->post("ex_directorApproveDateTime")),
                "crfex_directorapp_detail" => $obj->gci()->input->post("ex_directorApproveDetail"),
                "crfex_status" => "Director Approved"
            );
            $obj->gci()->db->where("crfex_id", $crfexid);
            $obj->gci()->db->update("crfex_maindata", $arDirector);

            if($obj->gci()->input->post("check_custype_direc") == 1){
                $obj->gci()->email->sendemail_toAccStaffEx($obj->gci()->input->post("checkDirecFormNo"));
            }else if($obj->gci()->input->post("check_custype_direc") == 2){
                if($obj->gci()->input->post("checkDireccurcustopic2") != ""){
                    $obj->gci()->email->sendemail_toAccStaffEx2($obj->gci()->input->post("checkDirecFormNo"));
                }else{
                    $obj->gci()->email->sendemail_toAccStaffEx3($obj->gci()->input->post("checkDirecFormNo"));
                }
            }
        } else {
            // Maindata table
            $arDirector = array(
                "crfex_directorapp_status" => $obj->gci()->input->post("ex_directorApprove"),
                "crfex_directorapp_username" => $obj->gci()->input->post("ex_directorApproveName"),
                "crfex_directorapp_datetime" => conDateTimeToDb($obj->gci()->input->post("ex_directorApproveDateTime")),
                "crfex_directorapp_detail" => $obj->gci()->input->post("ex_directorApproveDetail"),
                "crfex_status" => "Waiting for second director approve"
            );
            $obj->gci()->db->where("crfex_id", $crfexid);
            $obj->gci()->db->update("crfex_maindata", $arDirector);
        }
    } else if ($obj->gci()->input->post("ex_directorApprove") == "Not approve") {
        // Maindata table
        $arDirector = array(
            "crfex_directorapp_status" => $obj->gci()->input->post("ex_directorApprove"),
            "crfex_directorapp_username" => $obj->gci()->input->post("ex_directorApproveName"),
            "crfex_directorapp_datetime" => conDateTimeToDb($obj->gci()->input->post("ex_directorApproveDateTime")),
            "crfex_directorapp_detail" => $obj->gci()->input->post("ex_directorApproveDetail"),
            "crfex_status" => "Director Not Approve"
        );
        $obj->gci()->db->where("crfex_id", $crfexid);
        $obj->gci()->db->update("crfex_maindata", $arDirector);


        //Delete br code when acc mgr not approve
        $arDeleteBecode = array(
            "crfexcus_brcode" => "",
            "crfexcus_datetimeupdate" => date("Y-m-d H:i:s"),
            "crfexcus_tempstatus" => "Updated"
        );
        $obj->gci()->db->where("crfexcus_formno", $obj->gci()->input->post("checkDirecFormNo"));
        $obj->gci()->db->update("crfex_customers_temp", $arDeleteBecode);
        $obj->gci()->email->sendemail_DirectorNotApprove($obj->gci()->input->post("checkDirecFormNo"));
    }
}



function exDirectorApprove2($crfexid)
{
    $obj = new addfn();
    $obj->gci()->load->model('main/email_model', 'email');

    if ($obj->gci()->input->post("ex_directorApprove2") == "Approve") {
        if (checkdirecStatus($crfexid, 1)->crfex_directorapp_status == "Approve") {
            // Maindata table
            $arDirector = array(
                "crfex_directorapp_status2" => $obj->gci()->input->post("ex_directorApprove2"),
                "crfex_directorapp_username2" => $obj->gci()->input->post("ex_directorApproveName2"),
                "crfex_directorapp_datetime2" => conDateTimeToDb($obj->gci()->input->post("ex_directorApproveDateTime2")),
                "crfex_directorapp_detail2" => $obj->gci()->input->post("ex_directorApproveDetail2"),
                "crfex_status" => "Director Approved"
            );
            $obj->gci()->db->where("crfex_id", $crfexid);
            $obj->gci()->db->update("crfex_maindata", $arDirector);

            if($obj->gci()->input->post("check_custype_direc") == 1){
                $obj->gci()->email->sendemail_toAccStaffEx($obj->gci()->input->post("checkDirecFormNo"));
            }else if($obj->gci()->input->post("check_custype_direc") == 2){
                if($obj->gci()->input->post("checkDireccurcustopic2") != ""){
                    $obj->gci()->email->sendemail_toAccStaffEx2($obj->gci()->input->post("checkDirecFormNo"));
                }else{
                    $obj->gci()->email->sendemail_toAccStaffEx3($obj->gci()->input->post("checkDirecFormNo"));
                }
            }

            
        } else {
            // Maindata table
            $arDirector = array(
                "crfex_directorapp_status2" => $obj->gci()->input->post("ex_directorApprove2"),
                "crfex_directorapp_username2" => $obj->gci()->input->post("ex_directorApproveName2"),
                "crfex_directorapp_datetime2" => conDateTimeToDb($obj->gci()->input->post("ex_directorApproveDateTime2")),
                "crfex_directorapp_detail2" => $obj->gci()->input->post("ex_directorApproveDetail2"),
                "crfex_status" => "Waiting for second director approve"
            );
            $obj->gci()->db->where("crfex_id", $crfexid);
            $obj->gci()->db->update("crfex_maindata", $arDirector);
        }
    } else if ($obj->gci()->input->post("ex_directorApprove2") == "Not approve") {
        // Maindata table
        $arDirector = array(
            "crfex_directorapp_status2" => $obj->gci()->input->post("ex_directorApprove2"),
            "crfex_directorapp_username2" => $obj->gci()->input->post("ex_directorApproveName2"),
            "crfex_directorapp_datetime2" => conDateTimeToDb($obj->gci()->input->post("ex_directorApproveDateTime2")),
            "crfex_directorapp_detail2" => $obj->gci()->input->post("ex_directorApproveDetail2"),
            "crfex_status" => "Director Not Approve"
        );
        $obj->gci()->db->where("crfex_id", $crfexid);
        $obj->gci()->db->update("crfex_maindata", $arDirector);


        //Delete br code when acc mgr not approve
        $arDeleteBecode = array(
            "crfexcus_brcode" => "",
            "crfexcus_datetimeupdate" => date("Y-m-d H:i:s"),
            "crfexcus_tempstatus" => "Updated"
        );
        $obj->gci()->db->where("crfexcus_formno", $obj->gci()->input->post("checkDirecFormNo"));
        $obj->gci()->db->update("crfex_customers_temp", $arDeleteBecode);
        $obj->gci()->email->sendemail_DirectorNotApprove($obj->gci()->input->post("checkDirecFormNo"));
    }
}




function exAccountAddCusCode($crfexid)
{
    $obj = new addfn();
    $obj->gci()->load->model('main/email_model', 'email');

    if ($obj->gci()->input->post("check_custype_accstaff") == 1) {
        $arCustomerTemp = array(
            "crfexcus_code" => $obj->gci()->input->post("ex_accCostomerCode"),
            "crfexcus_tempstatus" => "Updated",
            "crfexcus_datetimeupdate" => date("Y-m-d H:i:s")
        );
        $obj->gci()->db->where("crfexcus_formno", $obj->gci()->input->post("accFormno"));
        if ($obj->gci()->db->update("crfex_customers_temp", $arCustomerTemp)) {

            // Maindata table
            $arAccCusCodeMain = array(
                "crfex_acccuscode" => $obj->gci()->input->post("ex_accCostomerCode"),
                "crfex_accuserpost" => $obj->gci()->input->post("ex_accName"),
                "crfex_accdatetime" => conDateTimeToDb($obj->gci()->input->post("ex_accDateTime")),
                "crfex_accmemo" => $obj->gci()->input->post("ex_accMemo"),
                "crfex_status" => "Completed"
            );
            $obj->gci()->db->where("crfex_id", $crfexid);
            if ($obj->gci()->db->update("crfex_maindata", $arAccCusCodeMain)) {
                $obj->gci()->db->select("*");
                $obj->gci()->db->from("crfex_customers_temp");
                $obj->gci()->db->where("crfexcus_formno", $obj->gci()->input->post("accFormno"));

                $query = $obj->gci()->db->get();
                foreach ($query->result() as $result) {

                    $arUpdateTocustomers = array(
                        "crfexcus_area" => $result->crfexcus_area,
                        "crfexcus_id" => $result->crfexcus_id,
                        "crfexcus_code" => $result->crfexcus_code,
                        "crfexcus_brcode" => $result->crfexcus_brcode,
                        "crfexcus_datecreate" => $result->crfexcus_datecreate,
                        "crfexcus_salesreps" => $result->crfexcus_salesreps,
                        "crfexcus_nameEN" => $result->crfexcus_nameEN,
                        "crfexcus_nameTH" => $result->crfexcus_nameTH,
                        "crfexcus_address" => $result->crfexcus_address,
                        "crfexcus_file" => $result->crfexcus_file,
                        "crfexcus_tel" => $result->crfexcus_tel,
                        "crfexcus_fax" => $result->crfexcus_fax,
                        "crfexcus_email" => $result->crfexcus_email,
                        "crfexcus_payment" => $result->crfexcus_payment,
                        "crfexcus_creditlimit" => $result->crfexcus_creditlimit,
                        "crfexcus_term" => $result->crfexcus_term,
                        "crfexcus_discount" => $result->crfexcus_discount,
                        "crfexcus_bg" => $result->crfexcus_bg,
                        "crfexcus_his_month1" => $result->crfexcus_his_month1,
                        "crfexcus_his_tvolume1" => $result->crfexcus_his_tvolume1,
                        "crfexcus_histsales1" => $result->crfexcus_histsales1,
                        "crfexcus_his_month2" => $result->crfexcus_his_month2,
                        "crfexcus_his_tvolume2" => $result->crfexcus_his_tvolume2,
                        "crfexcus_histsales2" => $result->crfexcus_histsales2,
                        "crfexcus_his_month3" => $result->crfexcus_his_month3,
                        "crfexcus_his_tvolume3" => $result->crfexcus_his_tvolume3,
                        "crfexcus_histsales3" => $result->crfexcus_histsales3,
                        "crfexcus_usercreate" => $result->crfexcus_usercreate,
                        "crfexcus_userecode" => $result->crfexcus_userecode,
                        "crfexcus_userdeptcode" => $result->crfexcus_userdeptcode,
                        "crfexcus_userdatetimecreate" => $result->crfexcus_userdatetimecreate,
                        "crfexcus_usermodify" => $result->crfexcus_usermodify,
                        "crfexcus_userecodemodify" => $result->crfexcus_userecodemodify,
                        "crfexcus_userdeptcodemodify" => $result->crfexcus_userdeptcodemodify,
                        "crfexcus_datetimemodify" => $result->crfexcus_datetimemodify
                    );
                    $obj->gci()->db->insert("crfex_customers", $arUpdateTocustomers);
                }
            }
            $obj->gci()->email->sendemail_toOwnerEx($obj->gci()->input->post("accFormno"));
        }
    }
}




function accChangeInformation()
{
    $obj = new addfn();

    $formno = $obj->gci()->input->post("accFormno");
    $cusid = $obj->gci()->input->post("accCusCode_getCusid");
    $query = $obj->gci()->db->query("SELECT 
    crfexcus_salesreps,
    crfexcus_nameEN,
    crfexcus_nameTH,
    crfexcus_address,
    crfexcus_tel,
    crfexcus_fax,
    crfexcus_email,
    crfexcus_his_month1,
    crfexcus_his_tvolume1,
    crfexcus_histsales1,
    crfexcus_his_month2,
    crfexcus_his_tvolume2,
    crfexcus_histsales2,
    crfexcus_his_month3,
    crfexcus_his_tvolume3,
    crfexcus_histsales3
    FROM crfex_customers_temp
    WHERE crfexcus_formno = '$formno'
    ");

    foreach ($query->result() as $rss) {
        $arUpdateTocus = array(
            "crfexcus_salesreps" => $rss->crfexcus_salesreps,
            "crfexcus_nameEN" => $rss->crfexcus_nameEN,
            "crfexcus_nameTH" => $rss->crfexcus_nameTH,
            "crfexcus_address" => $rss->crfexcus_address,
            "crfexcus_tel" => $rss->crfexcus_tel,
            "crfexcus_fax" => $rss->crfexcus_fax,
            "crfexcus_email" => $rss->crfexcus_email,
            "crfexcus_his_month1" => $rss->crfexcus_his_month1,
            "crfexcus_his_tvolume1" => $rss->crfexcus_his_tvolume1,
            "crfexcus_histsales1" => $rss->crfexcus_histsales1,
            "crfexcus_his_month2" => $rss->crfexcus_his_month2,
            "crfexcus_his_tvolume2" => $rss->crfexcus_his_tvolume2,
            "crfexcus_histsales2" => $rss->crfexcus_histsales2,
            "crfexcus_his_month3" => $rss->crfexcus_his_month3,
            "crfexcus_his_tvolume3" => $rss->crfexcus_his_tvolume3,
            "crfexcus_histsales3" => $rss->crfexcus_histsales3
        );
        $obj->gci()->db->where("crfexcus_id", $cusid);
        $obj->gci()->db->update("crfex_customers", $arUpdateTocus);
    }

    $arUpdateTemp = array(
        "crfexcus_tempstatus" => "Updated",
        "crfexcus_datetimeupdate" => date("Y-m-d H:i:s")
    );
    $obj->gci()->db->where("crfexcus_formno", $formno);
    $obj->gci()->db->update("crfex_customers_temp", $arUpdateTemp);
}



function accChangeCreditlimit()
{
    $obj = new addfn();

    $obj = new addfn();

    $formno = $obj->gci()->input->post("accFormno");
    $cusid = $obj->gci()->input->post("accCusCode_getCusid");
    $query = $obj->gci()->db->query("SELECT 
    crfexcus_creditlimit2new,
    crfexcus_term2new,
    crfexcus_discount2new,
    crfexcus_creditlimit,
    crfexcus_term,
    crfexcus_discount
    FROM crfex_customers_temp
    WHERE crfexcus_formno = '$formno'
    ");

    foreach ($query->result() as $rss) {

        if ($rss->crfexcus_creditlimit2new != "") {
            $creditlimit2new = $rss->crfexcus_creditlimit2new;
        } else {
            $creditlimit2new = $rss->crfexcus_creditlimit;
        }

        if ($rss->crfexcus_term2new == 0) {
            $term2new = $rss->crfexcus_term;
        } else {
            $term2new = $rss->crfexcus_term2new;
        }

        if ($rss->crfexcus_discount2new == 0) {
            $discount2new = $rss->crfexcus_discount;
        } else {
            $discount2new = $rss->crfexcus_discount2new;
        }




        $arUpdateTocus = array(
            "crfexcus_creditlimit" => $creditlimit2new,
            "crfexcus_term" => $term2new,
            "crfexcus_discount" => $discount2new,

        );
        $obj->gci()->db->where("crfexcus_id", $cusid);
        $obj->gci()->db->update("crfex_customers", $arUpdateTocus);
    }
}
