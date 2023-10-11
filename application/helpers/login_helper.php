<?php
class loginfn
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

// Load Login Model For Use Anothor
function login()
{
    $obj = new loginfn();
    return $obj->gci()->load->model("login/login_model" , "login");
}
// Load Login Model For Use Anothor


// Check Login Session
function callLogin()
{
    return login()->login->call_login();
}
// Check Login Session

// Get User When Have Login
function getUser()
{
    return login()->login->getuser();
}












?>