<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends MX_Controller {
  
  public function __construct()
  {
    parent::__construct();
        //Do your magic here
    $this->load->model("customers_model" , "customer");
  }
  

  public function index()
  {
    redirect(base_url('customers/addCustomer'));
  }

  public function addCustomer()
  {
    $data = array(
      "title" => "หน้าเพิ่มข้อมูลลูกค้า",
      "getCusProcess" => getCusProcess(),
      "getCreditTerm" => getCreditTerm(),
      "checkurl" => $this->uri->segment(2)
      
    );
    getHead();
    getContentData("addcustomer" , $data);
    getFooter();
  }

  public function saveCustomer()
  {
    $this->customer->saveCustomer();
  }

  public function customerList()
  {
    $data = array(
      "title" => "รายการลูกค้า",
      "geturl" => $this->uri->segment(2)
    );
    getHead();
    getContentData("customerslist", $data);
    getFooter();
  }

  public function fetchCustomerlist()
  {
    $data['rss'] = getcustomerlist();
    $this->load->view("resultCustomerList" , $data);
  }

  public function fetchCustomercode()
  {
    $this->customer->checkCustomerCode();
  }



     // Export Zone Export Zone Export Zone Export Zone
  public function addCustomerEx()
  {
   $data = array(
     "title" => "Add Customer page",
     "datenow" => date("d-m-Y"),
     "username" => getUser()->Fname." ".getUser()->Lname,
     "deptname" => getUser()->Dept,
     "datetimenow" => date("d-m-Y H:i:s"),
     "deptcode" => getUser()->DeptCode,
     "ecode" => getUser()->ecode,
     "geturl" => $this->uri->segment(2)
     
   );
   getHead();
   getContentData("addcustomerEx" , $data);
   getFooter();
 }
 
 public function saveCustomerEx()
 {
   $this->customer->saveCustomerEx();
  //  header("refresh:0; url=".base_url());
 }
 
 public function customerListEx()
 {
   $data = array(
     "title" => "รายการลูกค้า ต่างประเทศ",
     "geturl" => $this->uri->segment(2)
   );
   getHead();
   getContentData("customerslistEx", $data);
   getFooter();
 }
 public function fetchCustomerlistEx()
 {
   $data['rss'] = getcustomerlistEx();
   $this->load->view("resultCustomerListEx" , $data);
 }
 
 public function fetchCustomercodeEx()
 {
   $this->customer->checkCustomerCodeEx();
 }



 public function view_customerdata($cuscode)
 {
  $data = array(
    "title" => "Customer information",
    "result" => getcustomerdata($cuscode)
  );
  getHead();
  $this->load->view("view_customerdata" , $data);
  getFooter();
}


public function view_customerdataEx($cuscodeex , $areaex)
{
  $data = array(
    "title" => "Customer information Export",
    "result" => getcustomerdataex($cuscodeex , $areaex)
  );
  getHead();
  $this->load->view("view_customerdata_ex" , $data);
  getFooter();
}






// Zone Search customer data
public function searchcustomerdata()
{
    $this->customer->searchcustomerdata();
}

public function searchcustomerdataname()
{
    $this->customer->searchcustomerdataname();
}



public function searchcustomerdataex()
{
    $this->customer->searchcustomerdataex();
}

public function searchcustomerdatanameex()
{
    $this->customer->searchcustomerdatanameex();
}






}

/* End of file Customers.php */






?>