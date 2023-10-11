<?php
class confn
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

function conDateToDb($date)
{
    $credate = date_create($date);
    $datecon = date_format($credate , "Y-m-d");
    return $datecon;
}
function conDateFromDb($date)
{
    $credate = date_create($date);
    $datecon = date_format($credate , "d-m-Y");
    return $datecon;
}
function conDateTimeToDb($datetime)
{
    $credate = date_create($datetime);
    $datecon = date_format($credate , "Y-m-d H:i:s");
    return $datecon;
}
function conDateTimeFromDb($datetime)
{
    $credate = date_create($datetime);
    $datecon = date_format($credate , "d-m-Y H:i:s");
    return $datecon;
}

function conPrice($priceinput)
{
    $oriprice = str_replace("," , "" , $priceinput);
    return $oriprice;
}


