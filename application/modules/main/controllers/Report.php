<?php
class Report extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        // require_once("vendor/autoload.php");
    }



    public function index()
    {
        $this->load->view('report/testpdf');
    }


    public function reportTH()
    {

        $data = array(
            "report_title" => "Report Credit Request Form",
            "getDataToreport" => getdataToReport(),
        );


        getHead();
        getContentData('report/reportTH2', $data);
        getFooter();
    }


    public function fetch_user()
    {
        $this->load->model("report_model");
        $fetch_data = $this->report_model->make_datatables();


        $data = array();
        foreach ($fetch_data as $row) {

            $topic = $row->crf_topic;

            if ($row->crf_topic1 != '') {
                $topic .= " / " . $row->crf_topic1;
            }
            if ($row->crf_topic2 != '') {
                $topic .= " / " . $row->crf_topic2;
            }
            if ($row->crf_topic3 != '') {
                $topic .= " / " . $row->crf_topic3;
            }
            if ($row->crf_topic4 != '') {
                $topic .= " / " . $row->crf_topic4;
            }


            $sub_array = array();
            $sub_array[] = $row->crf_formno;
            $sub_array[] = $row->crfcus_name;
            $sub_array[] = $row->crf_alltype_subname;
            $sub_array[] = $topic;
            $sub_array[] = $row->crfcus_salesreps;
            $sub_array[] = conDateFromDb($row->crf_datecreate);
            $sub_array[] = $row->crf_status;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $this->report_model->get_all_data(),
            "recordsFiltered" => $this->report_model->get_filtered_data(),
            "data" => $data
        );
        echo json_encode($output);
    }



    public function fetch_user_formSearch()
    {
        $this->load->model("report_model");
        $fetch_data = $this->report_model->make_datatables_formSearch();


        $data = array();
        foreach ($fetch_data as $row) {

            $topic = $row->crf_topic;

            if ($row->crf_topic1 != '') {
                $topic .= " / " . $row->crf_topic1;
            }
            if ($row->crf_topic2 != '') {
                $topic .= " / " . $row->crf_topic2;
            }
            if ($row->crf_topic3 != '') {
                $topic .= " / " . $row->crf_topic3;
            }
            if ($row->crf_topic4 != '') {
                $topic .= " / " . $row->crf_topic4;
            }


            $sub_array = array();
            $sub_array[] = $row->crf_formno;
            $sub_array[] = $row->crfcus_name;
            $sub_array[] = $row->crf_alltype_subname;
            $sub_array[] = $topic;
            $sub_array[] = $row->crfcus_salesreps;
            $sub_array[] = conDateFromDb($row->crf_datecreate);
            $sub_array[] = $row->crf_status;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $this->report_model->get_all_data_formSearch(),
            "recordsFiltered" => $this->report_model->get_filtered_data_formSearch(),
            "data" => $data
        );
        echo json_encode($output);
    }




    // For Export Zone  // For Export Zone  // For Export Zone
    // For Export Zone  // For Export Zone  // For Export Zone


    public function reportEX()
    {
        $data['title'] = "Report Export list";
        getHead();
        $this->load->view('report/reportEX', $data);
        getFooter();
    }


    public function fetch_userex()
    {
        $this->load->model("report_model");
        $fetch_data = $this->report_model->make_datatablesEX();
        $data = array();
        foreach ($fetch_data as $row) {

            $topic = $row->crfex_topic;

            if ($row->crfex_curcustopic1 != '') {
                $topic .= " / " . $row->crfex_curcustopic1;
            }
            if ($row->crfex_curcustopic2 != '') {
                $topic .= " / " . $row->crfex_curcustopic2;
            }


            $sub_array = array();
            $sub_array[] = $row->crfex_formno;
            $sub_array[] = $row->crfexcus_nameEN;
            $sub_array[] = $row->crf_alltype_subnameEN;
            $sub_array[] = $topic;
            $sub_array[] = $row->crfexcus_salesreps;
            $sub_array[] = conDateFromDb($row->crfex_datecreate);
            $sub_array[] = $row->crfex_status;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $this->report_model->get_all_dataEX(),
            "recordsFiltered" => $this->report_model->get_filtered_dataEX(),
            "data" => $data
        );
        echo json_encode($output);
    }



    function report2()
    {
        getHead();
        $this->load->view("report/reportTH2");
        getFooter();
    }

    function server()
    {

        // DB table to use
        $table = 'report_th';

        // Table's primary key
        $primaryKey = 'crf_id';

        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes
        $columns = array(
            array('db' => 'crf_formno', 'dt' => 0),
            array('db' => 'crfcus_name',  'dt' => 1),
            array('db' => 'crf_alltype_subname',   'dt' => 2),
            array('db' => 'crf_topic', 'dt' => 3,),
            array('db' => 'crfcus_salesreps', 'dt' => 4,),
            array('db' => 'crf_datecreate', 'dt' => 5,),
            array('db' => 'crf_status', 'dt' => 6,)
        );

        // SQL server connection information
        $sql_details = array(
            'user' => 'chainarong',
            'pass' => 'Admin1234',
            'db'   => 'crf',
            'host' => 'localhost'
        );

        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
*/

        require('server-side/scripts/ssp.class.php');

        echo json_encode(
            SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
        );
    }


    public function blankForm()
    {
        $this->load->view("report/blankForm");
    }



    public function uploadpage()
    {
        $this->load->view("uploadpage");
    }

    public function doupload()
    {
        if($this->input->post("btn-submit")){
            $file_name = $_FILES["upload"]['name'];
            $filenametype = substr($file_name , -4);
            $editfilename = substr_replace($file_name , "CRF1234".$filenametype , 0);
            $file_tmp = $_FILES["upload"]['tmp_name'];
            move_uploaded_file($file_tmp, "upload/" . $editfilename);
            header("refresh:1; url=".base_url('main/report/uploadpage'));
        }
    }


    private function uploadFiles($fileinput = '', $filenameType = '')
    {

        $time = date("H-i-s"); //ดึงวันที่และเวลามาก่อน
        $file_name = $_FILES[$fileinput]['name'];
        $filenametype = substr($file_name , -4);
        $file_name_date = substr_replace($file_name, getFormNo() . "-" . $filenameType . "-" . $time .$filenametype, 0);

        $file_tmp = $_FILES[$fileinput]['tmp_name'];

        move_uploaded_file($file_tmp, "upload/" . $file_name_date);
        $filelocation = "upload";


        // print_r($file_name_date);
        // echo "<br>" . "Copy/Upload Complete" . "<br>";
        return $file_name_date;
    }


}//End Report class
