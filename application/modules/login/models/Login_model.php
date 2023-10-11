<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    $this->db2 = $this->load->database('saleecolour',TRUE);
    date_default_timezone_set("Asia/Bangkok");
  }

  private function escape_string() {
    if($_SERVER['HTTP_HOST'] == "localhost"){
        return mysqli_connect("192.168.20.22", "ant", "Ant1234", "saleecolour");
    }else{
        return mysqli_connect("localhost", "ant", "Ant1234", "saleecolour");
    }
  }


  public function check_login(){

    $this->load->library('user_agent');
      $user = mysqli_real_escape_string($this->escape_string() , $_POST['username']);
      $pass = mysqli_real_escape_string($this->escape_string() , md5($_POST['password']));
      // If System go on Please add md5 to element name password 'md5'


      $checkuser = $this->db2->query(sprintf("SELECT * FROM member WHERE username = '%s' and password = '%s'  ", $user, $pass
      ));

      $checkdata = $checkuser->num_rows();

      if ($checkdata == 0) {
          echo $this->session->set_flashdata('msg','<div class="alert alert-danger" role="alert" style="font-size:15px;text-align: center;">ชื่อผู้ใช้ หรือ รหัสผ่านไม่ถูกต้อง</div>');
        redirect('login');
          die();
      } else {
          

          foreach ($checkuser->result_array() as $r) {
              $_SESSION['username'] = $r['username'];
              $_SESSION['password'] = $r['password'];
              $_SESSION['Fname'] = $r['Fname'];
              $_SESSION['Lname'] = $r['Lname'];
              $_SESSION['Dept'] = $r['Dept'];
              $_SESSION['ecode'] = $r['ecode'];
              $_SESSION['DeptCode'] = $r['DeptCode'];
              $_SESSION['memberemail'] = $r['memberemail'];
              $_SESSION['posi'] = $r['posi'];
              $_SESSION['file_img'] = $r['file_img'];

              // insert login log

              session_write_close();
          }
          $uri = isset($_SESSION['RedirectKe']) ? $_SESSION['RedirectKe'] : '/intsys/crf/';
          header('refresh:0; url=' . $uri);
          // header("refresh:0; url=".base_url());
      }
  }



  public function call_login() {//*****Check Session******//
      if (isset($_SESSION['username']) == "") {
          $_SESSION['RedirectKe'] = $_SERVER['REQUEST_URI'];
          header("refresh:0; url=".base_url('login'));
          die();
      }
  }


  public function logout(){
      session_destroy();
      // $this->session->unset_userdata('referrer_url');
      header("refresh:0; url=".base_url('login'));
  }

  public function getuser(){
    $result = $this->db2->query("SELECT * FROM member WHERE username = '".$_SESSION['username']."' ");
    return $result->row();
  }


  







}
