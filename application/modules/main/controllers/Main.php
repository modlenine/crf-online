<?php
class Main extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model("main_model", "main");
        $this->load->model("edit_model", "edit");
        date_default_timezone_set("Asia/Bangkok");
        $this->load->library("pagination");
    }

    public function index()
    {
        calllogin();
        getHead();
        getContent('index');
        getFooter();
        // redirect("main/home/");
    }

    public function home()
    {
        $this->load->view("template/headtest");
        // getContent('testpage');
        // $this->load->view("template/footertest");
    }


    public function history_list()
    {
        getHead();
        $this->load->view("versionlist");
        getFooter();
    }
    
    public function addTH()
    {
        calllogin();
        // Check Permission For Sales and CS only
        //M1848 = คุณโส , M0003 = คุณฉลวย
        if (getUser()->DeptCode == 1006 || getUser()->DeptCode == 1010 || getUser()->DeptCode == 1002 || getUser()->ecode == "M1848" || getUser()->ecode == "M0003") {
            $data['getFormCode'] = getFormCode();
            $data['getCusProcess'] = getCusProcess();
            $data['getCreditTerm'] = getCreditTerm();
            getHead();
            getContentData('add_th', $data);
            getFooter();
        } else {
            echo "<script>alert('ขออภัยคุณไม่สามารถสร้างรายการได้ โปรดติดต่อ ฝ่ายไอที')</script>";
            header("refresh:0; url=" . base_url('main/showlist'));
            die();
        }
    }

    public function savedata()
    {
        calllogin();
        if (isset($_POST["user_submit"])) {
            if ($this->main->savedata() == 1) {
                echo "Insert Data Success<br>";
                header("refresh:0; url=" . base_url('main/showlist'));
                die();
            } else {
                echo "Insert Data Not Success";
                header("refresh:0; url=" . base_url());
            }
        }
    }


    public function showlist()
    {
        calllogin();
        getHead();
        getContent('list');
        getFooter();
    }


    public function pagination()
    {
        //  $this->load->model("ajax_pagination_model");
        //  $this->load->library("pagination");
        $config = array();
        $config["base_url"] = "#";
        $config["total_rows"] = $this->main->count_all();
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;
        $config["use_page_numbers"] = TRUE;
        $config["full_tag_open"] = '<ul class="pagination">';
        $config["full_tag_close"] = '</ul>';
        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';
        $config['next_link'] = '&gt;';
        $config["next_tag_open"] = '<li>';
        $config["next_tag_close"] = '</li>';
        $config["prev_link"] = "&lt;";
        $config["prev_tag_open"] = "<li>";
        $config["prev_tag_close"] = "</li>";
        $config["cur_tag_open"] = "<li class='active'><a href='#'>";
        $config["cur_tag_close"] = "</a></li>";
        $config["num_tag_open"] = "<li>";
        $config["num_tag_close"] = "</li>";
        $config["num_links"] = 2;
        $this->pagination->initialize($config);
        $page = $this->uri->segment(3);
        $start = ($page - 1) * $config["per_page"];

        $output = array(
            'pagination_link'  => $this->pagination->create_links(),
            'countTotal' => $this->main->count_all(),
            'country_table'   => $this->main->fetch_details($config["per_page"], $start)
        );
        echo json_encode($output);
    }


    public function paginationByDate()
    {
        //  $this->load->model("ajax_pagination_model");
        //  $this->load->library("pagination");
        $dateStart = $this->uri->segment(4);
        $dateEnd = $this->uri->segment(5);

        $config = array();
        $config["base_url"] = "#";
        $config["total_rows"] = $this->main->count_all_Date($dateStart, $dateEnd);
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;
        $config["use_page_numbers"] = TRUE;
        $config["full_tag_open"] = '<ul class="pagination">';
        $config["full_tag_close"] = '</ul>';
        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';
        $config['next_link'] = '&gt;';
        $config["next_tag_open"] = '<li>';
        $config["next_tag_close"] = '</li>';
        $config["prev_link"] = "&lt;";
        $config["prev_tag_open"] = "<li>";
        $config["prev_tag_close"] = "</li>";
        $config["cur_tag_open"] = "<li class='active'><a href='#'>";
        $config["cur_tag_close"] = "</a></li>";
        $config["num_tag_open"] = "<li>";
        $config["num_tag_close"] = "</li>";
        $config["num_links"] = 1;
        $this->pagination->initialize($config);
        $page = $this->uri->segment(3);
        $start = ($page - 1) * $config["per_page"];



        $output = array(
            'pagination_link'  => $this->pagination->create_links(),
            'countTotal' => $this->main->count_all_Date($dateStart, $dateEnd),
            'country_table'   => $this->main->fetch_detailsByDate($config["per_page"], $start, $dateStart, $dateEnd)
        );
        echo json_encode($output);
    }


    public function paginationByFormNo()
    {
        //  $this->load->model("ajax_pagination_model");
        //  $this->load->library("pagination");
        $formNo = $this->uri->segment(4);

        $config = array();
        $config["base_url"] = "#";
        $config["total_rows"] = $this->main->count_all_FormNo($formNo);
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;
        $config["use_page_numbers"] = TRUE;
        $config["full_tag_open"] = '<ul class="pagination">';
        $config["full_tag_close"] = '</ul>';
        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';
        $config['next_link'] = '&gt;';
        $config["next_tag_open"] = '<li>';
        $config["next_tag_close"] = '</li>';
        $config["prev_link"] = "&lt;";
        $config["prev_tag_open"] = "<li>";
        $config["prev_tag_close"] = "</li>";
        $config["cur_tag_open"] = "<li class='active'><a href='#'>";
        $config["cur_tag_close"] = "</a></li>";
        $config["num_tag_open"] = "<li>";
        $config["num_tag_close"] = "</li>";
        $config["num_links"] = 1;
        $this->pagination->initialize($config);
        $page = $this->uri->segment(3);
        $start = ($page - 1) * $config["per_page"];



        $output = array(
            'pagination_link'  => $this->pagination->create_links(),
            'countTotal' => $this->main->count_all_FormNo($formNo),
            'country_table'   => $this->main->fetch_detailsByFormNo($config["per_page"], $start, $formNo)
        );
        echo json_encode($output);
    }


    public function paginationByCompany()
    {
        //  $this->load->model("ajax_pagination_model");
        //  $this->load->library("pagination");
        $companyname = "";
        $companyname = $this->input->post("companyName");

        $config = array();
        $config["base_url"] = "#";
        $config["total_rows"] = $this->main->count_all_Company($companyname);
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;
        $config["use_page_numbers"] = TRUE;
        $config["full_tag_open"] = '<ul class="pagination">';
        $config["full_tag_close"] = '</ul>';
        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';
        $config['next_link'] = '&gt;';
        $config["next_tag_open"] = '<li>';
        $config["next_tag_close"] = '</li>';
        $config["prev_link"] = "&lt;";
        $config["prev_tag_open"] = "<li>";
        $config["prev_tag_close"] = "</li>";
        $config["cur_tag_open"] = "<li class='active'><a href='#'>";
        $config["cur_tag_close"] = "</a></li>";
        $config["num_tag_open"] = "<li>";
        $config["num_tag_close"] = "</li>";
        $config["num_links"] = 1;
        $this->pagination->initialize($config);
        $page = $this->uri->segment(3);
        $start = ($page - 1) * $config["per_page"];



        $output = array(
            'pagination_link'  => $this->pagination->create_links(),
            'countTotal' => $this->main->count_all_Company($companyname),
            'country_table'   => $this->main->fetch_detailsByCompany($config["per_page"], $start, $companyname)
        );
        echo json_encode($output);
    }

    public function paginationByStatusUser()
    {
        //  $this->load->model("ajax_pagination_model");
        //  $this->load->library("pagination");
        $status = "";
        $ecode = "";
        $status = $this->input->post("status");
        $ecode = $this->input->post("ecode");

        $config = array();
        $config["base_url"] = "#";
        $config["total_rows"] = $this->main->count_all_StatusEcode($status ,  $ecode);
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;
        $config["use_page_numbers"] = TRUE;
        $config["full_tag_open"] = '<ul class="pagination">';
        $config["full_tag_close"] = '</ul>';
        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';
        $config['next_link'] = '&gt;';
        $config["next_tag_open"] = '<li>';
        $config["next_tag_close"] = '</li>';
        $config["prev_link"] = "&lt;";
        $config["prev_tag_open"] = "<li>";
        $config["prev_tag_close"] = "</li>";
        $config["cur_tag_open"] = "<li class='active'><a href='#'>";
        $config["cur_tag_close"] = "</a></li>";
        $config["num_tag_open"] = "<li>";
        $config["num_tag_close"] = "</li>";
        $config["num_links"] = 1;
        $this->pagination->initialize($config);
        $page = $this->uri->segment(3);
        $start = ($page - 1) * $config["per_page"];



        $output = array(
            'pagination_link'  => $this->pagination->create_links(),
            'countTotal' => $this->main->count_all_StatusEcode($status ,  $ecode),
            'country_table'   => $this->main->fetch_detailsByStatusEcode($config["per_page"], $start, $status ,  $ecode)
        );
        echo json_encode($output);
    }


    public function paginationByStatusAcc()
    {
        //  $this->load->model("ajax_pagination_model");
        //  $this->load->library("pagination");
        $status = "";
        $status = $this->input->post("status");

        $config = array();
        $config["base_url"] = "#";
        $config["total_rows"] = $this->main->count_all_StatusAcc($status);
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;
        $config["use_page_numbers"] = TRUE;
        $config["full_tag_open"] = '<ul class="pagination">';
        $config["full_tag_close"] = '</ul>';
        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';
        $config['next_link'] = '&gt;';
        $config["next_tag_open"] = '<li>';
        $config["next_tag_close"] = '</li>';
        $config["prev_link"] = "&lt;";
        $config["prev_tag_open"] = "<li>";
        $config["prev_tag_close"] = "</li>";
        $config["cur_tag_open"] = "<li class='active'><a href='#'>";
        $config["cur_tag_close"] = "</a></li>";
        $config["num_tag_open"] = "<li>";
        $config["num_tag_close"] = "</li>";
        $config["num_links"] = 1;
        $this->pagination->initialize($config);
        $page = $this->uri->segment(3);
        $start = ($page - 1) * $config["per_page"];



        $output = array(
            'pagination_link'  => $this->pagination->create_links(),
            'countTotal' => $this->main->count_all_StatusAcc($status),
            'country_table'   => $this->main->fetch_detailsByStatusAcc($config["per_page"], $start, $status)
        );
        echo json_encode($output);
    }


    public function viewdata($crf_id)
    {
        calllogin();
        $data['result'] = getViewData($crf_id);

        getHead();
        $this->load->view('view_data', $data);
        getFooter();
    }


    public function exportpdf()
    {
        getContent('exportpdf');
    }


    public function managerApprove($crfid)
    {
        if (isset($_POST['mgr_submit'])) {
            $this->main->managerApprove($crfid);
            header("refresh:0; url=" . base_url('main/showlist'));
        }
    }


    public function csBr($crfid)
    {
        if (isset($_POST['br_submit'])) {
            $this->main->csbr($crfid);
        }
    }


    public function accMgr($crfid)
    {
        if (isset($_POST['accmgr_submit'])) {
            $this->main->accMgr($crfid);
            header("refresh:0; url=" . base_url('main/showlist'));
        }
    }


    public function director1($crfid)
    {
        if (isset($_POST['director_submit1'])) {
            $this->main->director1($crfid);
            header("refresh:0; url=" . base_url('main/showlist'));
        }
    }


    public function director2($crfid)
    {
        if (isset($_POST['director_submit2'])) {
            $this->main->director2($crfid);
            header("refresh:0; url=" . base_url('main/showlist'));
        }
    }


    public function saveCustomersCode($crfid, $crfcusid)
    {
        if (isset($_POST['acc_staff'])) {
            $this->main->saveCustomersCode($crfid, $crfcusid);
        }
    }

    public function searchCustomerDetail()
    {
        $this->main->searchCustomerDetail();
    }
    public function searchCustomerDetailName()
    {
        $this->main->searchCustomerDetailName();
    }


    public function searchCustomerDetailEx()
    {
        $this->main->searchCustomerDetailEx();
    }
    public function searchCustomerDetailExName()
    {
        $this->main->searchCustomerDetailExName();
    }

    public function queryProcessUse()
    {
        $this->main->queryProcessUse();
    }

    public function getCusProcess()
    {
        $this->main->getCusProcess();
    }

    public function queryPrimanageUse()
    {
        $this->main->queryPrimanageUse();
    }

    public function filterCreditTerm()
    {
        $this->main->filterCreditTerm();
    }

    public function filterCredit()
    {
        if ($this->input->post("oldCredit")) {
            $oldCredit = $this->input->post("oldCredit");
            $creditMethod = $this->input->post("creditMethod");
            echo $this->main->fetch_filterCredit($oldCredit, $creditMethod);
        }
    }









    // Export Zone // Export Zone // Export Zone // Export Zone // Export Zone // Export Zone
    // Export Zone // Export Zone // Export Zone // Export Zone // Export Zone // Export Zone
    public function addEx()
    {
        callLogin();
        if (getUser()->DeptCode == 1006 || getUser()->DeptCode == 1010 || getUser()->DeptCode == 1004 || getUser()->DeptCode == 1012) {
            $data = array(
                'username' => getUser()->Fname . " " . getUser()->Lname,
                'deptcode' => getUser()->DeptCode,
                'deptname' => getUser()->Dept,
                'ecode' => getUser()->ecode,
                'datenow' => date("d-m-Y H:i:s"),
                'formcode' => getFormCodeEN(),
                'test' => array(
                    array('title' => 'Title1', 'body' => 'Body1'),
                    array('title' => 'Title2', 'body' => 'Body2')
                ),
                'addExPage' => $this->uri->segment(2),
            );
            getHead();
            getContentData('add_en', $data);
            getFooter();
        } else {
            echo "<script>alert('Sorry you can not access to this page , Please contact admin !')</script>";
            header("refresh:0; url=" . base_url('main/listex'));
            die();
        }
    }

    public function savedataEX()
    {
        calllogin();
        if (isset($_POST["usercrfex_submit"])) {
            if ($this->main->savedataEX() == 1) {
                echo "Insert Data Success<br>";
                header("refresh:0; url=" . base_url('main/listex'));
                die();
            } else {
                echo "Insert Data Not Success";
                header("refresh:0; url=" . base_url());
            }
        }
    }



    public function listex()
    {
        calllogin();
        getHead();
        getContent('listex');
        getFooter();
    }


    public function paginationex()
    {
        //  $this->load->model("ajax_pagination_model");
        //  $this->load->library("pagination");
        $config = array();
        $config["base_url"] = "#";
        $config["total_rows"] = $this->main->count_allex();
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;
        $config["use_page_numbers"] = TRUE;
        $config["full_tag_open"] = '<ul class="pagination">';
        $config["full_tag_close"] = '</ul>';
        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';
        $config['next_link'] = '&gt;';
        $config["next_tag_open"] = '<li>';
        $config["next_tag_close"] = '</li>';
        $config["prev_link"] = "&lt;";
        $config["prev_tag_open"] = "<li>";
        $config["prev_tag_close"] = "</li>";
        $config["cur_tag_open"] = "<li class='active'><a href='#'>";
        $config["cur_tag_close"] = "</a></li>";
        $config["num_tag_open"] = "<li>";
        $config["num_tag_close"] = "</li>";
        $config["num_links"] = 1;
        $this->pagination->initialize($config);
        $page = $this->uri->segment(3);
        $start = ($page - 1) * $config["per_page"];

        $output = array(
            'pagination_link'  => $this->pagination->create_links(),
            'countTotal' => $this->main->count_allex(),
            'country_table'   => $this->main->fetch_detailsex($config["per_page"], $start)
        );
        echo json_encode($output);
    }


    public function paginationByDateex()
    {
        //  $this->load->model("ajax_pagination_model");
        //  $this->load->library("pagination");
        $dateStart = $this->uri->segment(4);
        $dateEnd = $this->uri->segment(5);

        $config = array();
        $config["base_url"] = "#";
        $config["total_rows"] = $this->main->count_all_Dateex($dateStart, $dateEnd);
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;
        $config["use_page_numbers"] = TRUE;
        $config["full_tag_open"] = '<ul class="pagination">';
        $config["full_tag_close"] = '</ul>';
        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';
        $config['next_link'] = '&gt;';
        $config["next_tag_open"] = '<li>';
        $config["next_tag_close"] = '</li>';
        $config["prev_link"] = "&lt;";
        $config["prev_tag_open"] = "<li>";
        $config["prev_tag_close"] = "</li>";
        $config["cur_tag_open"] = "<li class='active'><a href='#'>";
        $config["cur_tag_close"] = "</a></li>";
        $config["num_tag_open"] = "<li>";
        $config["num_tag_close"] = "</li>";
        $config["num_links"] = 1;
        $this->pagination->initialize($config);
        $page = $this->uri->segment(3);
        $start = ($page - 1) * $config["per_page"];



        $output = array(
            'pagination_link'  => $this->pagination->create_links(),
            'countTotal' => $this->main->count_all_Dateex($dateStart, $dateEnd),
            'country_table'   => $this->main->fetch_detailsByDateex($config["per_page"], $start, $dateStart, $dateEnd)
        );
        echo json_encode($output);
    }


    public function paginationByFormNoex()
    {
        //  $this->load->model("ajax_pagination_model");
        //  $this->load->library("pagination");
        $formNo = $this->uri->segment(4);

        $config = array();
        $config["base_url"] = "#";
        $config["total_rows"] = $this->main->count_all_FormNoex($formNo);
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;
        $config["use_page_numbers"] = TRUE;
        $config["full_tag_open"] = '<ul class="pagination">';
        $config["full_tag_close"] = '</ul>';
        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';
        $config['next_link'] = '&gt;';
        $config["next_tag_open"] = '<li>';
        $config["next_tag_close"] = '</li>';
        $config["prev_link"] = "&lt;";
        $config["prev_tag_open"] = "<li>";
        $config["prev_tag_close"] = "</li>";
        $config["cur_tag_open"] = "<li class='active'><a href='#'>";
        $config["cur_tag_close"] = "</a></li>";
        $config["num_tag_open"] = "<li>";
        $config["num_tag_close"] = "</li>";
        $config["num_links"] = 1;
        $this->pagination->initialize($config);
        $page = $this->uri->segment(3);
        $start = ($page - 1) * $config["per_page"];



        $output = array(
            'pagination_link'  => $this->pagination->create_links(),
            'countTotal' => $this->main->count_all_FormNoex($formNo),
            'country_table'   => $this->main->fetch_detailsByFormNoex($config["per_page"], $start, $formNo)
        );
        echo json_encode($output);
    }





    public function paginationByCompanyex()
    {
        //  $this->load->model("ajax_pagination_model");
        //  $this->load->library("pagination");
        $companyname = $this->uri->segment(4);

        $config = array();
        $config["base_url"] = "#";
        $config["total_rows"] = $this->main->count_all_Companyex($companyname);
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;
        $config["use_page_numbers"] = TRUE;
        $config["full_tag_open"] = '<ul class="pagination">';
        $config["full_tag_close"] = '</ul>';
        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';
        $config['next_link'] = '&gt;';
        $config["next_tag_open"] = '<li>';
        $config["next_tag_close"] = '</li>';
        $config["prev_link"] = "&lt;";
        $config["prev_tag_open"] = "<li>";
        $config["prev_tag_close"] = "</li>";
        $config["cur_tag_open"] = "<li class='active'><a href='#'>";
        $config["cur_tag_close"] = "</a></li>";
        $config["num_tag_open"] = "<li>";
        $config["num_tag_close"] = "</li>";
        $config["num_links"] = 1;
        $this->pagination->initialize($config);
        $page = $this->uri->segment(3);
        $start = ($page - 1) * $config["per_page"];



        $output = array(
            'pagination_link'  => $this->pagination->create_links(),
            'countTotal' => $this->main->count_all_Companyex($companyname),
            'country_table'   => $this->main->fetch_detailsByCompanyex($config["per_page"], $start, $companyname)
        );
        echo json_encode($output);
    }


    public function viewdataEx($crfexid)
    {
        callLogin();
        $crfex_formno = viewdataEx($crfexid)->crfex_formno;

        if (viewdataEX($crfexid)->crfex_custype == 1) {
            $salesreps = viewdataEX($crfexid)->crfexcus_salesreps;
            $customernameEN = viewdataEX($crfexid)->crfexcus_nameEN;
            $customernameTH = viewdataEX($crfexid)->crfexcus_nameTH;
            $cusaddress = viewdataEX($crfexid)->crfexcus_address;
            $tel = viewdataEX($crfexid)->crfexcus_tel;
            $fax = viewdataEX($crfexid)->crfexcus_fax;
            $email = viewdataEX($crfexid)->crfexcus_email;
            $creditlimit = viewdataEX($crfexid)->crfex_ccreditlimit;
            $cterm = viewdataEX($crfexid)->crfex_cterm;
            $cdiscount = viewdataEX($crfexid)->crfex_cdiscount;
            $crfex_bg = viewdataEX($crfexid)->crfexcus_bg;
            $crfexm_pcreditlimit = viewdataEX($crfexid)->crfexcus_creditlimit;
            $crfexm_pterm = viewdataEX($crfexid)->crfexcus_term;
            $crfexm_pdiscount = viewdataEX($crfexid)->crfexcus_discount;
        } else if (viewdataEX($crfexid)->crfex_custype == 2) {
            if (viewdataEX($crfexid)->crfex_status == 'Complated') {
                $salesreps = viewdataEX($crfexid)->crfexcus_salesreps;
                $customernameEN = viewdataEX($crfexid)->crfexcus_nameEN;
                $customernameTH = viewdataEX($crfexid)->crfexcus_nameTH;
                $cusaddress = viewdataEX($crfexid)->crfexcus_address;
                $tel = viewdataEX($crfexid)->crfexcus_tel;
                $fax = viewdataEX($crfexid)->crfexcus_fax;
                $email = viewdataEX($crfexid)->crfexcus_email;
                $creditlimit = viewdataEX($crfexid)->crfex_ccreditlimit;
                $cterm = viewdataEX($crfexid)->crfex_cterm;
                $cdiscount = viewdataEX($crfexid)->crfex_cdiscount;
                $crfex_bg = viewdataEX($crfexid)->crfexcus_bg;
                $crfexm_pcreditlimit = viewdataEX($crfexid)->crfex_pcreditlimit;
                $crfexm_pterm = viewdataEX($crfexid)->crfex_pterm;
                $crfexm_pdiscount = viewdataEX($crfexid)->crfex_pdiscount;
            } else {
                $salesreps = viewdataEX($crfexid)->crfexcus_salesreps;
                $customernameEN = viewdataEX($crfexid)->crfexcus_nameEN;
                $customernameTH = viewdataEX($crfexid)->crfexcus_nameTH;
                $cusaddress = viewdataEX($crfexid)->crfexcus_address;
                $tel = viewdataEX($crfexid)->crfexcus_tel;
                $fax = viewdataEX($crfexid)->crfexcus_fax;
                $email = viewdataEX($crfexid)->crfexcus_email;
                $creditlimit = viewdataEX($crfexid)->crfex_ccreditlimit;
                $cterm = viewdataEX($crfexid)->crfex_cterm;
                $cdiscount = viewdataEX($crfexid)->crfex_cdiscount;
                $crfex_bg = viewdataEX($crfexid)->crfexcus_bg;
                $crfexm_pcreditlimit = viewdataEX($crfexid)->crfex_pcreditlimit;
                $crfexm_pterm = viewdataEX($crfexid)->crfex_pterm;
                $crfexm_pdiscount = viewdataEX($crfexid)->crfex_pdiscount;
            }
        }



        $data = array(
            'username' => getUser()->Fname . " " . getUser()->Lname,
            'deptcode' => getUser()->DeptCode,
            'deptname' => getUser()->Dept,
            'ecode' => getUser()->ecode,
            'posi' => getUser()->posi,
            'datenow' => date("d-m-Y H:i:s"),
            'formcode' => getFormCodeEN(),
            'company' => viewdataEX($crfexid)->crfex_company,
            'customertype' => viewdataEX($crfexid)->crfex_custype,
            'datecreate' => conDateFromDb(viewdataEX($crfexid)->crfex_datecreate),
            'customercode' => viewdataEX($crfexid)->crfexcus_code,
            'salesreps' => viewdataEX($crfexid)->crfexcus_salesreps,
            'customernameEN' => viewdataEX($crfexid)->crfexcus_nameEN,
            'customernameTH' => viewdataEX($crfexid)->crfexcus_nameTH,
            'cusaddress' => viewdataEX($crfexid)->crfexcus_address,
            'tel' => viewdataEX($crfexid)->crfexcus_tel,
            'fax' => viewdataEX($crfexid)->crfexcus_fax,
            'email' => viewdataEX($crfexid)->crfexcus_email,
            'pcreditlimit' => $crfexm_pcreditlimit,
            'pterm' => $crfexm_pterm,
            'pdiscount' =>  $crfexm_pdiscount,
            'ccreditlimit' => $creditlimit,
            'cterm' => $cterm,
            'cdiscount' => $cdiscount,
            'crfex_bg' => $crfex_bg,
            'brcode' => viewdataEX($crfexid)->crfex_brcode,
            'userpost' => viewdataEX($crfexid)->crfex_userpost,
            'userdept' => viewdataEX($crfexid)->crfex_userdept,
            'userdatetime' => conDateTimeFromDb(viewdataEX($crfexid)->crfex_userdatetime),
            'status' => viewdataEX($crfexid)->crfex_status,
            'checkpage' => $this->uri->segment(2),
            'exManagerApprove' => base_url('main/exManagerApprove/') . $crfexid,
            'show_crfex_mgrapp_status' => viewdataEX($crfexid)->crfex_mgrapp_status,
            'show_crfex_mgrapp_detail' => viewdataEX($crfexid)->crfex_mgrapp_detail,
            'show_crfex_mgrapp_username' => viewdataEX($crfexid)->crfex_mgrapp_username,
            'show_crfex_mgrapp_datetime' => conDateTimeFromDb(viewdataEX($crfexid)->crfex_mgrapp_datetime),
            'exCsAddBr' => base_url('main/exCsAddBr/') . $crfexid,
            'crfex_csuserpost' => viewdataEX($crfexid)->crfex_csuserpost,
            'crfex_csmemo' => viewdataEX($crfexid)->crfex_csmemo,
            'crfex_csdept' => viewdataEX($crfexid)->crfex_csdept,
            'crfex_csdatetime' => conDateTimeFromDb(viewdataEX($crfexid)->crfex_csdatetime),
            'exAccMgrApprove' => base_url('main/exAccMgrApprove/') . $crfexid,
            'crfex_accmgr_status' => viewdataEX($crfexid)->crfex_accmgr_status,
            'crfex_accmgr_username' => viewdataEX($crfexid)->crfex_accmgr_username,
            'crfex_accmgr_datetime' => conDateTimeFromDb(viewdataEX($crfexid)->crfex_accmgr_datetime),
            'crfex_accmgr_detail' => viewdataEX($crfexid)->crfex_accmgr_detail,
            'exDirectorApprove' => base_url('main/exDirectorApprove/') . $crfexid,
            'exDirectorApprove2' => base_url('main/exDirectorApprove2/') . $crfexid,
            'crfex_directorapp_status' => viewdataEX($crfexid)->crfex_directorapp_status,
            'crfex_directorapp_username' => viewdataEX($crfexid)->crfex_directorapp_username,
            'crfex_directorapp_datetime' => conDateTimeFromDb(viewdataEX($crfexid)->crfex_directorapp_datetime),
            'crfex_directorapp_detail' => viewdataEX($crfexid)->crfex_directorapp_detail,
            'crfex_directorapp_status2' => viewdataEX($crfexid)->crfex_directorapp_status2,
            'crfex_directorapp_username2' => viewdataEX($crfexid)->crfex_directorapp_username2,
            'crfex_directorapp_datetime2' => conDateTimeFromDb(viewdataEX($crfexid)->crfex_directorapp_datetime2),
            'crfex_directorapp_detail2' => viewdataEX($crfexid)->crfex_directorapp_detail2,
            'crfex_customerid' => viewdataEX($crfexid)->crfex_customerid,
            'exAccountAddCusCode' => base_url('main/exAccountAddCusCode/') . $crfexid,
            'crfex_accmemo' => viewdataEX($crfexid)->crfex_accmemo,
            'crfex_accuserpost' => viewdataEX($crfexid)->crfex_accuserpost,
            'crfex_accdatetime' => conDateTimeFromDb(viewdataEX($crfexid)->crfex_accdatetime),
            'crfex_formno' => $crfex_formno,
            'crfex_curcustopic1' => viewdataEX($crfexid)->crfex_curcustopic1,
            'crfex_curcustopic2' => viewdataEX($crfexid)->crfex_curcustopic2,
            'crfexcus_id' => viewdataEX($crfexid)->crfexcus_id,
            'crfex_cancelForm' => base_url('main/canceldataEx/') . viewdataEX($crfexid)->crfex_id . "/" . viewdataEX($crfexid)->crfex_formno,
            'crfex_editdata' => base_url('main/editdataEx/') . viewdataEX($crfexid)->crfex_id,
            'file' => viewdataEX($crfexid)->crfexcus_file,
            'fileAddress' => base_url('upload/') . viewdataEX($crfexid)->crfexcus_file,
            'get_area' => viewdataEX($crfexid)->crfex_company,
            'get_payment' => viewdataEX($crfexid)->crfexcus_payment,

            'get_crfex_month1' => viewdataEX($crfexid)->crfex_m1_text,
            'get_crfex_totalvolume1' => viewdataEX($crfexid)->crfex_m1_volume,
            'get_crfex_totalsales1' => viewdataEX($crfexid)->crfex_m1_sales,

            'get_crfex_month2' => viewdataEX($crfexid)->crfex_m2_text,
            'get_crfex_totalvolume2' => viewdataEX($crfexid)->crfex_m2_volume,
            'get_crfex_totalsales2' => viewdataEX($crfexid)->crfex_m2_sales,

            'get_crfex_month3' => viewdataEX($crfexid)->crfex_m3_text,
            'get_crfex_totalvolume3' => viewdataEX($crfexid)->crfex_m3_volume,
            'get_crfex_totalsales3' => viewdataEX($crfexid)->crfex_m3_sales,

            'crfex_creditlimit_condition' => viewdataEx($crfexid)->crfex_creditlimit_condition,
            'crfex_term_condition' => viewdataEx($crfexid)->crfex_term_condition,
            'crfex_discount_condition' => viewdataEx($crfexid)->crfex_discount_condition,
            'crfex_creditlimit_need' => viewdataEx($crfexid)->crfex_creditlimit_need,
            'crfex_term_need' => viewdataEx($crfexid)->crfex_term_need,
            'crfex_discount_need' => viewdataEx($crfexid)->crfex_discount_need,
            'crfex_creditlimit_sum' => viewdataEx($crfexid)->crfex_creditlimit_sum,
            'crfex_term_sum' => viewdataEx($crfexid)->crfex_term_sum,
            'crfex_discount_sum' => viewdataEx($crfexid)->crfex_discount_sum,


        );

        getHead();
        getContentData('view_data_ex', $data);
        getFooter();
    }



    public function exManagerApprove($crfexid)
    {
        if (isset($_POST['ex_mgrSubmit'])) {
            $this->main->exManagerApprove($crfexid);
            header("refresh:0; url=" . base_url('main/listex'));
        }
    }


    public function exCsAddBr($crfexid)
    {
        if (isset($_POST['ex_csSubmit'])) {
            $this->main->exCsAddBr($crfexid);
            
        }
    }


    public function exAccMgrApprove($crfexid)
    {
        if (isset($_POST['ex_accManagerSubmit'])) {
            $this->main->exAccMgrApprove($crfexid);
            header("refresh:0; url=" . base_url('main/listex'));
        }
    }


    public function exDirectorApprove($crfexid)
    {
        if (isset($_POST['ex_directorSubmit'])) {
            $this->main->exDirectorApprove($crfexid);
            header("refresh:0; url=" . base_url('main/listex'));
        }
    }

    public function exDirectorApprove2($crfexid)
    {
        if (isset($_POST['ex_directorSubmit2'])) {
            $this->main->exDirectorApprove2($crfexid);
            header("refresh:0; url=" . base_url('main/listex'));
        }
    }


    public function exAccountAddCusCode($crfexid)
    {
        if (isset($_POST['ex_accSubmit'])) {
            $this->main->exAccountAddCusCode($crfexid);
            header("refresh:0; url=" . base_url('main/listex'));
        }
    }


    // Check Duplicate customer name
    public function checkDuplicateNameCustomer()
    {
        echo $this->main->checkDuplicateNameCustomer();
    }

    // Check Duplicate customer name
    public function checkDuplicateNameCustomerEx()
    {
        echo $this->main->checkDuplicateNameCustomerEx();
    }







    // EDIT ZONE EDIT ZONE EDIT ZONE EDIT ZONE EDIT ZONE EDIT ZONE EDIT ZONE EDIT ZONE
    // EDIT ZONE EDIT ZONE EDIT ZONE EDIT ZONE EDIT ZONE EDIT ZONE EDIT ZONE EDIT ZONE
    function editViewPage()
    {

        $customerid = $this->input->post("editcusid");
        $salesreps = $this->input->post("editsalesreps");

        $arsalereps = array(
            "crfcus_id" => $customerid,
            "crfcus_salesreps" => $salesreps
        );

        $this->db->insert("crf_customers", $arsalereps);
    }


    public function editdata($crf_id)
    {
        // Check Status 
        if(getViewData($crf_id)->crf_status == "Open" || getViewData($crf_id)->crf_status == "Edited"){
            $crfcus_id = getViewData($crf_id)->crfcus_id;

            if (getViewData($crf_id)->crfcus_creditterm2 == '') {
                $creditterm1 = getViewData($crf_id)->crfcus_creditterm;
                $creditname1 = conCreditTerm($creditterm1);
    
                $creditterm2 = "";
                $creditname2 = "";
            } else {
                $creditterm1 = getViewData($crf_id)->crfcus_creditterm;
                $creditname1 = conCreditTerm($creditterm1);
    
                $creditterm2 = getViewData($crf_id)->crfcus_creditterm2;
                $creditname2 = conCreditTerm($creditterm2);
            }


            // Get money limit on ax
            // $creditmaxOnAx =  floatval(getCreditMax(getViewData($crf_id)->crfcus_code , getViewData($crf_id)->crfcus_area));
            // if($creditmaxOnAx != $rs->crfcus_moneylimit){
            //     $creditmaxOnAx = $creditmaxOnAx;
            // }else{
            //     $creditmaxOnAx = $rs->crfcus_moneylimit;
            // }
            // check money limit with ax
    
            $data = array(
                "getFormCode" => getFormCode(),
                "getCusProcess" => getCusProcess(),
                "getCreditTerm" => getCreditTerm(),
                "edit_company" => getViewData($crf_id)->crf_company,
                "edit_custype" => getViewData($crf_id)->crf_type,
                "edit_personal_type" => getViewData($crf_id)->crf_personal_type,
                "edit_datecreate" => conDateFromDb(getViewData($crf_id)->crf_datecreate),
                "edit_salesreps" => getViewData($crf_id)->crfcus_salesreps,
                "edit_cusname" => getViewData($crf_id)->crfcus_name,
                "edit_comcreate" => getViewData($crf_id)->crfcus_comdatecreate,
                "edit_ivoicetype" => getViewData($crf_id)->crfcus_addresstype,
                "edit_address" => getViewData($crf_id)->crfcus_address,
                "edit_contactname" => getViewData($crf_id)->crfcus_contactname,
                "edit_contacttel" => getViewData($crf_id)->crfcus_phone,
                "edit_contactfax" => getViewData($crf_id)->crfcus_fax,
                "edit_contactemail" => getViewData($crf_id)->crfcus_email,
                "edit_etax_contactemail" => getViewData($crf_id)->crfcus_etax_email,
                "edit_regiscapital" => getViewData($crf_id)->crfcus_regiscapital,
                "edit_comtype" => getViewData($crf_id)->crfcus_companytype,
                "editprimanage" => getPrimanageEdit(getViewData($crf_id)->crfcus_formno),
                "edit_busitype" => getViewData($crf_id)->crfcus_typebussi,
                "crfcus_id" => getViewData($crf_id)->crfcus_id,
                "edit_forecast" => getViewData($crf_id)->crfcus_forecast,
                "edit_textmemo" => getViewData($crf_id)->crfcus_textmemo,
                "edit_creditterm" =>  $creditterm1,
                "edit_creditname" => $creditname1,
                "edit_conditionbill" => getViewData($crf_id)->crfcus_conditionbill,
                "edit_conditionmoney" => getViewData($crf_id)->crfcus_conditionmoney,
                "edit_finance" => getViewData($crf_id)->crf_finance,
                "datenow" => date("d-m-Y"),
                "edit_moneylimit" => getViewData($crf_id)->crfcus_moneylimit,
                "get_personal" => getViewData($crf_id)->crfcus_personal,
                "get_file1" => getViewData($crf_id)->crfcus_file1,
                "get_file2" => getViewData($crf_id)->crfcus_file2,
                "get_file3" => getViewData($crf_id)->crfcus_file3,
                "get_file4" => getViewData($crf_id)->crfcus_file4,
                "get_file5" => getViewData($crf_id)->crfcus_file5,
                "get_file6" => getViewData($crf_id)->crfcus_file6,
                "get_crfid" => getViewData($crf_id)->crf_id,
                "get_changearea" => getViewData($crf_id)->crf_sub_oldcus_changearea,
                "get_changeaddress" => getViewData($crf_id)->crf_sub_oldcus_changeaddress,
                "get_changecredit" => getViewData($crf_id)->crf_sub_oldcus_changecredit,
                "get_changefinance" => getViewData($crf_id)->crf_sub_oldcus_changefinance,
                "get_cuscode" => getViewData($crf_id)->crfcus_code,
                "get_file7" => getViewData($crf_id)->crfcus_tablebill,
                "get_file8" => getViewData($crf_id)->crfcus_mapbill,
                "get_datebill" => getViewData($crf_id)->crfcus_datebill,
                "get_mapbill2" => getViewData($crf_id)->crfcus_mapbill2,
                "get_cheuqetable" => getViewData($crf_id)->crfcus_cheuqetable,
                "get_cheuqedetail" => getViewData($crf_id)->crfcus_cheuqedetail,
                "geturl" => $this->uri->segment(2),
                "get_comtype2" => getViewData($crf_id)->crfcus_comtype2,
                "get_formno" => getViewData($crf_id)->crfcus_formno,
                "get_comtype31" => getViewData($crf_id)->crfcus_comtype31,
                "get_comtype32" => getViewData($crf_id)->crfcus_comtype32,
                "get_comtype33" => getViewData($crf_id)->crfcus_comtype33,
                "get_comtype34" => getViewData($crf_id)->crfcus_comtype34,
                "get_condition_credit" => getViewData($crf_id)->crf_condition_credit,
                "get_creditterm2code" => $creditterm2,
                "get_creditterm2name" => $creditname2,
    
                "edit_crf_finance_status" => getViewData($crf_id)->crf_finance_status,
                "edit_crf_finance_change_status" => getViewData($crf_id)->crf_finance_change_status,
                "edit_crf_finance_change_number" => getViewData($crf_id)->crf_finance_change_number,
                "edit_crf_finance_change_total" => getViewData($crf_id)->crf_finance_change_total,
                "edit_crf_finance_change_detail" => getViewData($crf_id)->crf_finance_change_detail,
                "crfcus_mapurl" => getViewData($crf_id)->crfcus_mapurl,
                "crfcus_mapfile" => getViewData($crf_id)->crfcus_mapfile,
                "crfcus_taxid" => getViewData($crf_id)->crfcus_taxid,
                "crfcus_branch" => getViewData($crf_id)->crfcus_branch,
                "crfcus_products" => getViewData($crf_id)->crfcus_products,
                "crf_sub_oldcus_editcustomer" => getViewData($crf_id)->crf_sub_oldcus_editcustomer
    
            );
    
    
    
            getHead();
            getContentData("edit_view", $data);
            getFooter();
        }else{
            $data = array(
                "title" => "ไม่สามารถเข้าใช้งานหน้านี้ได้"
            );
            getHead();
            getContentData("testpage", $data);
            getFooter();
        }
    }

    public function save_editdata()
    {
        $this->main->save_editdata();
    }


    public function canceldata($crfid, $crfformno)
    {
        $this->main->canceldata($crfid, $crfformno);
    }
    public function canceldataEx($crfid, $crfformno)
    {
        $this->main->canceldataEx($crfid, $crfformno);
    }




    // EDIT ZONE EDIT ZONE EDIT ZONE EDIT ZONE EDIT ZONE EDIT ZONE EDIT ZONE EDIT ZONE
    // EDIT ZONE EDIT ZONE EDIT ZONE EDIT ZONE EDIT ZONE EDIT ZONE EDIT ZONE EDIT ZONE







    // Edit data export zone // Edit data export zone // Edit data export zone // Edit data export zone // Edit data export zone
    // Edit data export zone // Edit data export zone // Edit data export zone // Edit data export zone // Edit data export zone
    // Edit data export zone // Edit data export zone // Edit data export zone // Edit data export zone // Edit data export zone
    // Edit data export zone // Edit data export zone // Edit data export zone // Edit data export zone // Edit data export zone


    public function editdataEx($crfexid)
    {


        if (viewdataEX($crfexid)->crfexcus_file == "") {
            $file = 'ไม่มีไฟล์อยู่ในระบบ';
        } else {
            $file = viewdataEX($crfexid)->crfexcus_file;
        }


        $data = array(
            'username' => getUser()->Fname . " " . getUser()->Lname,
            'deptcode' => getUser()->DeptCode,
            'deptname' => getUser()->Dept,
            'ecode' => getUser()->ecode,
            'posi' => getUser()->posi,
            'datenow' => date("d-m-Y H:i:s"),
            'formcode' => getFormCodeEN(),

            'checkEdit-crfex_company' => viewdataEX($crfexid)->crfex_company,
            'checkEdit-crfex_custype' => viewdataEX($crfexid)->crfex_custype,
            'checkEdit-crfex_curcustopic1' => viewdataEX($crfexid)->crfex_curcustopic1,
            'checkEdit-crfex_curcustopic2' => viewdataEX($crfexid)->crfex_curcustopic2,
            'checkEdit-crfex_formno' => viewdataEX($crfexid)->crfex_formno,
            'checkEdit-crfex_id' => viewdataEX($crfexid)->crfex_id,
            'checkEditPage' => $this->uri->segment(2),


            'edit-crfex_datecreate' => conDateFromDb(viewdataEX($crfexid)->crfex_datecreate),
            'edit-crfex_customercode' => viewdataEX($crfexid)->crfexcus_code,
            'edit-crfex_salesreps' => viewdataEX($crfexid)->crfexcus_salesreps,
            'edit-crfex_cusnameEN' => viewdataEX($crfexid)->crfexcus_nameEN,
            'edit-crfex_cusnameTH' => viewdataEX($crfexid)->crfexcus_nameTH,
            'edit-crfex_address' => viewdataEX($crfexid)->crfexcus_address,
            'edit-crfex_tel' => viewdataEX($crfexid)->crfexcus_tel,
            'edit-crfex_fax' => viewdataEX($crfexid)->crfexcus_fax,
            'edit-crfex_email' => viewdataEX($crfexid)->crfexcus_email,
            'edit-crfex_file' => $file,
            'edit-crfex_fileAdd' => base_url('upload/') . $file,
            'edit-crfex_payment' => viewdataEX($crfexid)->crfexcus_payment,
            'edit-crfex_creditlimit' => viewdataEX($crfexid)->crfex_pcreditlimit,
            'edit-crfex_term' => viewdataEX($crfexid)->crfex_pterm,
            'edit-crfex_discount' => viewdataEX($crfexid)->crfex_pdiscount,
            'edit-crfex_creditlimit2' => viewdataEX($crfexid)->crfex_ccreditlimit,
            'edit-crfex_term2' => viewdataEX($crfexid)->crfex_cterm,
            'edit-crfex_discount2' => viewdataEX($crfexid)->crfex_cdiscount,
            'edit-crfex_combg' => viewdataEX($crfexid)->crfexcus_bg,

            'edit-crfex_his_month1' => viewdataEX($crfexid)->crfex_m1_text,
            'edit-crfex_his_tvolume1' => viewdataEX($crfexid)->crfex_m1_volume,
            'edit-crfex_histsales1' => viewdataEX($crfexid)->crfex_m1_sales,

            'edit-crfex_his_month2' => viewdataEX($crfexid)->crfex_m2_text,
            'edit-crfex_his_tvolume2' => viewdataEX($crfexid)->crfex_m2_volume,
            'edit-crfex_histsales2' => viewdataEX($crfexid)->crfex_m2_sales,

            'edit-crfex_his_month3' => viewdataEX($crfexid)->crfex_m3_text,
            'edit-crfex_his_tvolume3' => viewdataEX($crfexid)->crfex_m3_volume,
            'edit-crfex_histsales3' => viewdataEX($crfexid)->crfex_m3_sales,

            'crfex_creditlimit_condition' => viewdataEx($crfexid)->crfex_creditlimit_condition,
            'crfex_term_condition' => viewdataEx($crfexid)->crfex_term_condition,
            'crfex_discount_condition' => viewdataEx($crfexid)->crfex_discount_condition,
            'crfex_creditlimit_need' => viewdataEx($crfexid)->crfex_creditlimit_need,
            'crfex_term_need' => viewdataEx($crfexid)->crfex_term_need,
            'crfex_discount_need' => viewdataEx($crfexid)->crfex_discount_need,
            'crfex_creditlimit_sum' => viewdataEx($crfexid)->crfex_creditlimit_sum,
            'crfex_term_sum' => viewdataEx($crfexid)->crfex_term_sum,
            'crfex_discount_sum' => viewdataEx($crfexid)->crfex_discount_sum,



        );




        getHead();
        getContentData("edit_viewEx", $data);
        getFooter();
    }



    public function saveEditdataEx()
    {
        $this->main->saveEditdataEx();
    }




    // Edit data export zone // Edit data export zone // Edit data export zone // Edit data export zone // Edit data export zone
    // Edit data export zone // Edit data export zone // Edit data export zone // Edit data export zone // Edit data export zone
    // Edit data export zone // Edit data export zone // Edit data export zone // Edit data export zone // Edit data export zone
    // Edit data export zone // Edit data export zone // Edit data export zone // Edit data export zone // Edit data export zone






    public function testcode()
    {
        echo $_SERVER['HTTP_HOST'];
    }




    // Report Zone
    public function reportExport()
    {
        $this->main->reportExport();
    }


    public function reportExportdate()
    {
        $this->main->reportExportdate();
    }

    public function reportTh()
    {
        $this->main->reportTh();
    }
    public function reportThdate()
    {
        $this->main->reportThdate();
    }




    // Config zone
    public function configemail()
    {
        $data = array(
            "title" => "test"
        );

        getHead();
        getContent("configemail", $data);
        getFooter();
    }
    public function saveSettingEmail()
    {
        $this->load->model("email_model");
        $this->email_model->saveSettingEmail();
    }




    public function loaddata_all()
    {
        $limit = "5";
        $page = $this->uri->segment(3);
        $start = ($page - 1) * $limit;
        $output = '';
        $this->db->select("crf_formno , crf_id , crf_datecreate , crf_alltype_subname , crf_status , crfcus_name , crfcus_address , crfcus_salesreps , crfsubold_name , crf_topic , crf_topic1 , crf_topic2 , crf_topic3 , crf_topic4 , crfw_salesreps , crf_sub_oldcus_changearea , crf_sub_oldcus_changeaddress , crf_sub_oldcus_changecredit , crf_sub_oldcus_changefinance , crfw_cusaddress");
        $this->db->from("crf_maindata");
        $this->db->join('crf_alltype', 'crf_alltype.crf_alltype_subcode = crf_maindata.crf_type');
        $this->db->join('crf_customers_temp', 'crf_customers_temp.crfcus_formno = crf_maindata.crf_formno');
        $this->db->join('crf_suboldcus', 'crf_suboldcus.crfsubold_id = crf_maindata.crf_sub_oldcus_changearea');

        $this->db->order_by("crf_formno", "DESC");
        $this->db->limit($limit, $start);
        $query = $this->db->get();

        foreach ($query->result() as $row) {

            $bgcolor = "background-color:#E8E8E8;";
            $fontcolor = "color:#000000;";

            if ($row->crf_status == "Open") {
                $statusColor = "color:#0066FF;";
                $lineStatusColor = "background-color:#0066FF;height:3px;";
            } else if ($row->crf_status == "Completed") {
                $statusColor = "color:#009900;";
                $lineStatusColor = "background-color:#009900;height:3px;";
            } else if ($row->crf_status == "Cancel" || $row->crf_status == "Sales Manager Not Approve" || $row->crf_status == "Account Manager Not approved") {
                $statusColor = "color:#CC0000;";
                $lineStatusColor = "background-color:#CC0000;height:3px;";
            } else {
                $statusColor = "color:#0066FF;";
                $lineStatusColor = "background-color:#0066FF;height:3px;";
            }

            if ($row->crf_sub_oldcus_changearea == 1 && $row->crf_status != "Completed") {
                $salesreps = $row->crfw_salesreps;
            } else {
                $salesreps = $row->crfcus_salesreps;
            }

            if ($row->crf_sub_oldcus_changeaddress == 2 && $row->crf_status != "Completed") {
                $address = $row->crfcus_address;
            } else {
                $address = $row->crfcus_address;
            }

            $topicTH = $row->crf_topic;

            if ($row->crf_topic1 != '') {
                $topicTH .= " / " . $row->crf_topic1;
            }
            if ($row->crf_topic2 != '') {
                $topicTH .= " / " . $row->crf_topic2;
            }
            if ($row->crf_topic3 != '') {
                $topicTH .= " / " . $row->crf_topic3;
            }
            if ($row->crf_topic4 != '') {
                $topicTH .= " / " . $row->crf_topic4;
            }

            $output .= '
  <div class="card mt-3">
  <div class="card-header" style="' . $bgcolor . $fontcolor . '">
        <div class="col-md-3 col-sm-12">
            เลขที่คำขอ &nbsp;<a href="' . base_url('main/viewdata/') . $row->crf_id . '">' . $row->crf_formno . '</a>
        </div>
        <div class="col-md-3 col-sm-12">
            วันที่สร้างรายการ : &nbsp;<span style="">' . conDateFromDb($row->crf_datecreate) . '</span>
        </div>
        <div class="col-md-3 col-sm-12">
            ประเภทลูกค้า : &nbsp;<span style="">' . $row->crf_alltype_subname . '</span>
        </div>
        <div class="col-md-3 statustext">
            สถานะ : &nbsp;<span style="' . $statusColor . '">' . $row->crf_status . '</span>
        </div>
  </div>
  <div style="' . $lineStatusColor . '"></div>
  <div class="card-body">
    <div class="row">
        <div class="col-md-3">
        <p><label><b>หัวข้อ :</b></label>&nbsp;' . $topicTH . '</p>
        <p><label><b>ชื่อบริษัท : </b></label>&nbsp;' . $row->crfcus_name . '</p>
        </div>

        <div class="col-md-6">
        <label><b>ที่อยู่ : </b></label>&nbsp;' . $address . '
        </div>

        <div class="col-md-3">
        <label><b>Sales Reps : </b></label>&nbsp;' . $salesreps . '
        </div>
    </div>

  </div>
</div>
  ';
        }
        $output .= '</table>';


        $queryCount = $this->db->get("crf_maindata");
        $numrowCount = $queryCount->num_rows();

        $numofpage = ceil($numrowCount / $limit);
        // display the links to the pages
        $output .= '
    <div class="row">
        <div class="col-md-12">
        <nav aria-label="Page navigation example">
        <ul class="pagination">
    ';
        for ($page = 1; $page <= $numofpage; $page++) {
            // echo '<a href="index.php?page=' . $page . '">' . $page . '</a> ';
            $output .= '


    <li class="page-item"><a class="page-link" id="pagination_link" href="#">' . $page . '</a></li>


    
    ';
        }
        $output .= '
  </ul>
  </nav>
  <div align="center" class="mt-2">
					<span>รวมทั้งสิ้น</span>&nbsp;' . $numrowCount . '&nbsp;<span>รายการ</span>
				</div>
  </div>
  </div>
  ';


        echo $output;
    }


public function geturl()
{
    // // echo $_SERVER['DOCUMENT_ROOT']. '/intsys/crf/upload/qrcode/';
    $long_url = base_url('qrcode/');

    // // $long_url = 'https://www.saleecolour.com/';
    // $apiv4 = 'https://api-ssl.bitly.com/v4/bitlinks';
    // $genericAccessToken = '29ad665eadf5cb5aead471257fe29a333eb00fab';
    
    // $data = array(
    //     'long_url' => $long_url
    // );
    // $payload = json_encode($data);
    
    // $header = array(
    //     'Authorization: Bearer ' . $genericAccessToken,
    //     'Content-Type: application/json',
    //     'Content-Length: ' . strlen($payload)
    // );
    
    // $ch = curl_init($apiv4);
    // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    // curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    // $result = curl_exec($ch);
    // $resultToJson = json_decode($result);


    
    // echo $resultToJson->link;

}


public function test_notifycenter_function()
{
    $this->load->library('notifycenter');

    $this->notifycenter->test1();
}


public function test_api_request()
{
    // ข้อมูลที่ต้องการส่ง
    $data = array('key1' => 'value1', 'key2' => 'value2');

    // แปลงข้อมูลเป็น JSON string
    $json_data = json_encode($data);

    // กำหนด URL ของ API
    $url = "http://localhost/intranet/api/request_api";

    // สร้าง cURL resource
    $curl = curl_init($url);

    // ตั้งค่าสำหรับ cURL
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($json_data))
    );

    // ส่ง API request และรับ response
    $response = curl_exec($curl);

    // ตรวจสอบว่ามีข้อผิดพลาดหรือไม่
    if ($response === false) {
        $error_message = curl_error($curl);
        // จัดการข้อผิดพลาด
    } else {
        // ดำเนินการต่อไปกับ response
        echo $response;
    }

    // ปิด cURL resource
    curl_close($curl);

}












}
// Main Controller
