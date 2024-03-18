<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายการ Credit Request Form เลขที่</title>
</head>


<body>
    <div class="container bg-white p-3">
        <h2 align="center">รายการ Credit Request Form</h2>

        <hr>




        <div class="mt-3 p-3" style="border:solid #ccc 1px; background-color:#F8F8FF;">

            <!-- Document Head -->
            <div class="row form-group">
                <div align="left" class="col-md-6">
                    <h3>CREDIT REQUEST FORM</h3>
                </div>
                <div align="right" class="col-md-6">
                   
                </div>
            </div>


            <!-- Chose Company -->
            <input hidden type="text" name="forcrf_company_view" id="forcrf_company_view" value="<?= $result->crfcus_area ?>">

            <div class="row form-group mt-3 p-2">
                <div class="col-md-4 form-group">
                    <div class="form-check">
                        <input id="view_crf_company_sln" class="form-check-input" type="radio" name="view_crf_company" value="sln" onclick="return false;">
                        <label for="my-input" class="form-check-label">Salee Colour Public Company Limited.</label>
                    </div>
                </div>
                <div class="col-md-4 form-group">
                    <div class="form-check">
                        <input id="view_crf_company_poly" class="form-check-input" type="radio" name="view_crf_company" value="poly" onclick="return false;">
                        <label for="my-input" class="form-check-label">Poly Meritasia Co.,Ltd.</label>
                    </div>
                </div>
                <div class="col-md-4 form-group">
                    <div class="form-check">
                        <input id="view_crf_company_ca" class="form-check-input" type="radio" name="view_crf_company" value="ca" onclick="return false;">
                        <label for="my-input" class="form-check-label">Composite Asia Co.,Ltd</label>
                    </div>
                </div>
                <div class="col-md-4 form-group">
                    <div class="custom-radio custom-control">
                        <input type="radio" id="view_crf_company_tb" name="view_crf_company" class="custom-control-input" value="tb" onclick="return false;">
                        <label class="custom-control-label" for="view_crf_company_tb">The Bubbles Co.,Ltd.</label>
                    </div>
                </div>
                <div class="col-md-4 form-group">
                    <div class="custom-radio custom-control">
                        <input type="radio" id="view_crf_company_st" name="view_crf_company" class="custom-control-input" value="st" onclick="return false;">
                        <label class="custom-control-label" for="view_crf_company_st">Subterra Co.,Ltd.</label>
                    </div>
                </div>
            </div>



            <div class="row form-group p-2">
                <div class="col-md-6 form-group">
                    <label for="">Customer code : &nbsp;</label>
                    <input type="text" name="crf_customercode_view" id="crf_customercode_view" class="form-control form-control-sm" readonly value="<?= $result->crfcus_code ?>">
                </div>
                <div class="col-md-6 form-group">
                    <label for="">Sales Reps : &nbsp;</label>
                    <input readonly type="text" name="crf_salesreps_view" id="crf_salesreps_view" class="form-control form-control-sm" value="<?= $result->crfcus_salesreps ?>">
                    <div id="showedit_salesreps"></div>
                </div>
            </div>


            <hr>
            <h5 align="left"><u>CUSTOMER PROFILE</u></h5>

            <div class="row form-group">
                <div class="col-md-8 form-group">
                    <label for="">ชื่อลูกค้า : &nbsp;</label>
                    <input readonly type="text" name="crf_customername_view" id="crf_customername_view" class="form-control form-control-sm" value="<?= $result->crfcus_name ?>">
                </div>
                <div class="col-md-4 form-group">
                    <label for="">วันที่ก่อตั้ง</label>
                    <input readonly type="text" name="crf_cuscompanycreate_view" id="crf_cuscompanycreate_view" class="form-control form-control-sm" value="<?= $result->crfcus_comdatecreate ?>">
                </div>
            </div>


            <div class="row form-group">
                <div class="col-md-6 form-group">
                    <label for="">เลขที่ผู้เสียภาษี</label>
                    <input readonly type="text" name="crf_customertaxid_view" id="crf_customertaxid_view" class="form-control form-control-sm" value="<?=$result->crfcus_taxid?>">
                </div>
                <div class="col-md-6 form-group">
                    <label for="">สาขา</label>
                    <input readonly type="text" name="crf_customerbranch_view" id="crf_customerbranch_view" class="form-control form-control-sm" value="<?=$result->crfcus_branch?>">
                </div>
            </div>


            <input hidden type="text" name="forcrf_addresstype_view" id="forcrf_addresstype_view" value="<?= $result->crfcus_addresstype ?>">
            <div class="row form-group">
                <div class="col-md-4">
                    <label for="">ที่อยู่สำหรับการเปิดใบกำกับภาษี : </label>
                </div>
                <div class="col-md-4 form-group">
                    <div class="form-check">
                        <input id="crf_addresstype1_view" class="form-check-input" type="radio" name="crf_addresstype_view" value="ตาม ภ.พ.20" onclick="return false">
                        <label for="my-input" class="form-check-label">ตาม ภ.พ.20</label>
                    </div>
                </div>
                <div class="col-md-4 form-group">
                    <div class="form-check">
                        <input id="crf_addresstype2_view" class="form-check-input" type="radio" name="crf_addresstype_view" value="อื่นๆ" onclick="return false">
                        <label for="my-input" class="form-check-label">อื่นๆ</label>
                    </div>
                </div>
            </div>


            <div class="row form-group">
                <div class="col-md-12">
                    <textarea readonly name="crf_addressname_view" id="crf_addressname_view" cols="30" rows="3" class="form-control"><?= $result->crfcus_address ?></textarea>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-md-6 form-group">
                    <label for="">ผู้ติดต่อ</label>
                    <input readonly type="text" name="crf_namecontact_view" id="crf_namecontact_view" class="form-control form-control-sm" value="<?= $result->crfcus_contactname ?>">
                </div>
                <div class="col-md-6 form-group">
                    <label for="">เบอร์โทร</label>
                    <input readonly type="text" name="crf_telcontact_view" id="crf_telcontact_view" class="form-control form-control-sm" value="<?= $result->crfcus_phone ?>">
                </div>
            </div>


            <div class="row form-group">
                <div class="col-md-4 form-group">
                    <label for="">เบอร์แฟกซ์</label>
                    <input readonly type="text" name="crf_faxcontact_view" id="crf_faxcontact_view" class="form-control form-control-sm" value="<?= $result->crfcus_fax ?>">
                </div>
                <div class="col-md-4 form-group">
                    <label for="">อีเมล</label>
                    <input readonly type="text" name="crf_emailcontact_view" id="crf_emailcontact_view" class="form-control form-control-sm" value="<?= $result->crfcus_email ?>">
                </div>
                <div class="col-md-4 form-group">
                    <label for="">e-Tax อีเมล</label>
                    <input readonly type="text" name="crf_etax_emailcontact_view" id="crf_etax_emailcontact_view" class="form-control form-control-sm" value="<?= $result->crfcus_etax_email ?>">
                </div>
                <div class="col-md-4 form-group">
                    <label for="">ทุนจดทะเบียน</label>
                    <input readonly type="text" name="crf_regiscost_view" id="crf_regiscost_view" class="form-control form-control-sm" value="<?= $result->crfcus_regiscapital ?>">
                </div>

                <?php
$mapurldisplay = "";
$checkType = substr($result->crfcus_mapurl, 0 , 5);
if($checkType != "https"){
    $mapurldisplay = 'display:none;';
}else{
    $mapurldisplay = "";
}

                ?>

                <div class="col-md-3" style="<?=$mapurldisplay?>">
                        <label for="">แผนที่ (ลิ้งจาก Googlemap) : </label>
                        <a href="<?=$result->crfcus_mapurl?>" target="_blank"><span><i class="fas fa-map-marked-alt" style="font-size:28px;color:green;"></i></span></a>
                    </div>

            <?php 
            $display = "";
            if($result->crfcus_mapfile == ""){
                $image = "noimage.png";
                $display = 'display:none;';
            }else{
                $image = $result->crfcus_mapfile;
                $display = '';
            }
            ?>        
                    <div class="col-md-3" style="<?=$display?>">
                        <label for="">แนบไฟล์แผนที่ (jpg , png , pdf) :</label>
                        <a id="mapfilelink" href="#" data-toggle="modal" data-target="#showmapfile" data_mapfile = "<?=$image?>"><span><i class="fas fa-map-marked-alt" style="font-size:28px;color:orange;"></i></span></a>
                    </div>
            </div><br>


            <input hidden type="text" name="forcrf_companytype_view" id="forcrf_companytype_view" value="<?= $result->crfcus_companytype ?>">

            <label for="">
                <h6><b><u>ประเภทบริษัท</u></b></h6>
            </label>
            <div class="row form-group">
                <div class="col-md-4 form-group">
                    <input type="radio" name="crf_companytype_view" id="crf_companytype1_view" value="1" onclick="return false;">
                    <label for="">บริษัทของคนไทย 100%</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="radio" name="crf_companytype_view" id="crf_companytype2_view" value="2" onclick="return false;">
                    <label for="">บริษัทต่างประเทศ 100%</label>
                </div>
                <div class="col-md-4 form-group">
                    <input type="radio" name="crf_companytype_view" id="crf_companytype3_view" value="3" onclick="return false;">
                    <label for="">บริษัทร่วมทุน</label>
                </div>
            </div>



            <div id="companytype2_view" class="row form-group" style="display:none">
                <div class="col-md-12">
                    <input readonly type="text" name="crf_companytype2_view" id="crf_companytype2_view" class="form-control form-control-sm" placeholder="กรุณาระบุสัญชาติ" value="<?= $result->crfcus_comtype2 ?>">
                </div>
            </div>


            <div id="companytype3_view" class="row form-group" style="display:none">
                <div class="col-md-3 form-inline">
                    <label for="">สัญชาติ :&nbsp;</label>
                    <input readonly type="text" name="crf_companytype3_1_1_view" id="crf_companytype3_1_1_view" class="form-control form-control-sm" value="<?= $result->crfcus_comtype31 ?>">
                </div>
                <div class="col-md-3 form-inline">
                    <input readonly type="text" name="crf_companytype3_1_2_view" id="crf_companytype3_1_2_view" class="form-control form-control-sm" value="<?= $result->crfcus_comtype32 ?>">
                    <label for="">&nbsp;%</label>
                </div>
                <div class="col-md-3 form-inline">
                    <label for="">สัญชาติ :&nbsp;</label>
                    <input readonly type="text" name="crf_companytype3_2_1_view" id="crf_companytype3_2_1_view" class="form-control form-control-sm" value="<?= $result->crfcus_comtype33 ?>">
                </div>
                <div class="col-md-3 form-inline">
                    <input readonly type="text" name="crf_companytype3_2_2_view" id="crf_companytype3_2_2_view" class="form-control form-control-sm" value="<?= $result->crfcus_comtype34 ?>">
                    <label for="">&nbsp;%</label>
                </div>
            </div><br>


            <label for="">
                <h6><b><u>บุคคลในแต่ละระดับบริหารที่สำคัญ</u></b></h6>
            </label>
            <?php
            foreach (getPrimanageCus($result->crfcus_id)->result() as $rs) {

            ?>
                <div id="priManage" class="row form-group">
                    <div class="col-md-3 form-group">
                        <label for="">หน่วยงาน</label>
                        <input readonly type="text" name="crf_primanage_dept[]" id="crf_primanage_dept" class="form-control form-control-sm" value="<?= $rs->crf_primanage_dept ?>">
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="">ชื่อ-สกุล</label>
                        <input readonly type="text" name="crf_primanage_name[]" id="crf_primanage_name" class="form-control form-control-sm" value="<?= $rs->crf_primanage_name ?>">
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="">ตำแหน่ง</label>
                        <input readonly type="text" name="crf_primanage_posi[]" id="crf_primanage_posi" class="form-control form-control-sm" value="<?= $rs->crf_primanage_posi ?>">
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="">อีเมล</label>
                        <input readonly type="text" name="crf_primanage_email[]" id="crf_primanage_email" class="form-control form-control-sm" value="<?= $rs->crf_primanage_email ?>">
                    </div>
                </div>

            <?php } ?>
            <br>


            <input hidden type="text" name="forcrf_typeofbussi_view" id="forcrf_typeofbussi_view" value="<?= $result->crfcus_typebussi ?>">

            <label for="">
                <h6><b><u>ประเภทของธุรกิจ</u></b></h6>
            </label>
            <div class="row form-group">
                <div class="col-md-3 form-group">
                    <input type="radio" name="crf_typeofbussi_view" id="crf_typeofbussi1_view" value="ผู้ผลิต" onclick="return false;">
                    <label for="">ผู้ผลิต</label>
                </div>
                <div class="col-md-3 form-group">
                    <input type="radio" name="crf_typeofbussi_view" id="crf_typeofbussi2_view" value="ผู้ค้า" onclick="return false;">
                    <label for="">ผู้ค้า</label>
                </div>
            </div>


            <label for="">
                <h6><b><u>กระบวนการผลิตหลักในการผลิตสินค้า</u></b></h6>
            </label>
            <div class="row form-group">
                <?php foreach (getCusProcess() as $rs) {
                    $checked = "";
                    foreach (getProcess($result->crfcus_id)->result() as $rss) {
                        if ($rs->cuspro_id == $rss->crf_process_name) {
                            $checked = ' checked="" ';
                            continue;
                        }
                    }
                ?>
                    <div class="col-md-3 ">
                        <input onclick="return false;" type="checkbox" name="crf_process[]" id="crf_process" value="<?= $rs->cuspro_id ?>" <?= $checked ?>>
                        <label for=""><?= $rs->cuspro_name ?></label>
                    </div>
                <?php } ?>
            </div>
            <br>



            <label for="">
                    <h6><b><u>ผลิตภัณฑ์ของลูกค้า</u></b></h6>
                </label>
                <div class="row form-group">
                    <div class="col-md-12">
                        <textarea readonly name="crf_customer_product" id="crf_customer_product" cols="30" rows="3" class="form-control"><?= $result->crfcus_products ?></textarea>
                    </div>
                </div>




            <label for="">
                <h6><b><u>คาดการณ์ปริมาณการขาย</u></b></h6>
            </label>
            <div class="row form-group">
                <div class="col-md-12">
                    <label for="">รายละเอียด</label>
                    <textarea readonly name="crf_forecast_view" id="crf_forecast_view" cols="30" rows="4" class="form-control"><?= $result->crfcus_forecast ?></textarea>
                </div>
            </div>
            <br>



            <label for="">
                <h6><b><u>เอกสารที่จำเป็นในการขอเปิดวงเงินการค้า</u></b></h6>
            </label>
            <div class="row form-group">
                <div class="col-md-4 form-group crf_file1">
                    <label for="">ภพ.20 / ภธ.09</label><br>

                    <?php 
                    $output = '';
                    if(substr($result->crfcus_file1 , -3) == "pdf" || substr($result->crfcus_file1 , -3) == "PDF"){
                        $output .='
                        <span><a href="'.base_url("upload/").$result->crfcus_file1.'" target="_blank"><b>'.$result->crfcus_file1.'</b></a></span>
                        ';
                    }else{
                        $output .='
                        <span><a id="datafile1" href="#" data-toggle="modal" data-target="#show_file1" data_file1="'.$result->crfcus_file1.'"><b>'.$result->crfcus_file1.'</b></a></span>
                        ';
                    }
                    echo $output;
                    ?>

                    <!-- <span><a id="datafile1" href="#" data-toggle="modal" data-target="#show_file1" data_file1="<?= $result->crfcus_file1 ?>"><b><?= $result->crfcus_file1 ?></b></a></span> -->

                </div>
                <div class="col-md-4 form-group crf_file2">
                    <label for="">หนังสือรับรอง</label><br>
                    <?php 
                    $output = '';
                    if(substr($result->crfcus_file2 , -3) == "pdf" || substr($result->crfcus_file2 , -3) == "PDF"){
                        $output .='
                        <span><a href="'.base_url("upload/").$result->crfcus_file2.'" target="_blank"><b>'.$result->crfcus_file2.'</b></a></span>
                        ';
                    }else{
                        $output .='
                        <span><a id="datafile2" href="#" data-toggle="modal" data-target="#show_file2" data_file2="'.$result->crfcus_file2.'"><b>'.$result->crfcus_file2.'</b></a></span>
                        ';
                    }
                    echo $output;
                    ?>


                    <!-- <span><a id="datafile2" href="#" data-toggle="modal" data-target="#show_file2" data_file2="<?= $result->crfcus_file2 ?>"><b><?= $result->crfcus_file2 ?></b></a></span> -->

                </div>
                <div class="col-md-4 form-group crf_file3">
                    <label for="">ข้อมูลทั่วไป</label><br>
                    <?php 
                    $output = '';
                    if(substr($result->crfcus_file3 , -3) == "pdf" || substr($result->crfcus_file3 , -3) == "PDF"){
                        $output .='
                        <span><a href="'.base_url("upload/").$result->crfcus_file3.'" target="_blank"><b>'.$result->crfcus_file3.'</b></a></span>
                        ';
                    }else{
                        $output .='
                        <span><a id="datafile3" href="#" data-toggle="modal" data-target="#show_file3" data_file3="'.$result->crfcus_file3.'"><b>'.$result->crfcus_file3.'</b></a></span>
                        ';
                    }
                    echo $output;
                    ?>

                    <!-- <span><a id="datafile3" href="#" data-toggle="modal" data-target="#show_file3" data_file3="<?= $result->crfcus_file3 ?>"><b><?= $result->crfcus_file3 ?></b></a></span> -->

                </div>
                <div class="col-md-4 form-group crf_file4">
                    <label for="">งบดุล</label><br>

                    <?php 
                    $output = '';
                    if(substr($result->crfcus_file4 , -3) == "pdf" || substr($result->crfcus_file4 , -3) == "PDF"){
                        $output .='
                        <span><a href="'.base_url("upload/").$result->crfcus_file4.'" target="_blank"><b>'.$result->crfcus_file4.'</b></a></span>
                        ';
                    }else{
                        $output .='
                        <span><a id="datafile4" href="#" data-toggle="modal" data-target="#show_file4" data_file4="'.$result->crfcus_file4.'"><b>'.$result->crfcus_file4.'</b></a></span>
                        ';
                    }
                    echo $output;
                    ?>

                    <!-- <span><a id="datafile4" href="#" data-toggle="modal" data-target="#show_file4" data_file4="<?= $result->crfcus_file4 ?>"><b><?= $result->crfcus_file4 ?></b></a></span> -->

                </div>
                <div class="col-md-4 crf_file5">
                    <label for="">งบกำไรขาดทุน</label><br>

                    <?php 
                    $output = '';
                    if(substr($result->crfcus_file5 , -3) == "pdf" || substr($result->crfcus_file5 , -3) == "PDF"){
                        $output .='
                        <span><a href="'.base_url("upload/").$result->crfcus_file5.'" target="_blank"><b>'.$result->crfcus_file5.'</b></a></span>
                        ';
                    }else{
                        $output .='
                        <span><a id="datafile5" href="#" data-toggle="modal" data-target="#show_file5" data_file5="'.$result->crfcus_file5.'"><b>'.$result->crfcus_file5.'</b></a></span>
                        ';
                    }
                    echo $output;
                    ?>

                    <!-- <span><a id="datafile5" href="#" data-toggle="modal" data-target="#show_file5" data_file5="<?= $result->crfcus_file5 ?>"><b><?= $result->crfcus_file5 ?></b></a></span> -->

                </div>
                <div class="col-md-4 crf_file6">
                    <label for="">อัตราส่วนสภาพคล่อง</label><br>

                    <?php 
                    $output = '';
                    if(substr($result->crfcus_file6 , -3) == "pdf" || substr($result->crfcus_file6 , -3) == "PDF"){
                        $output .='
                        <span><a href="'.base_url("upload/").$result->crfcus_file6.'" target="_blank"><b>'.$result->crfcus_file6.'</b></a></span>
                        ';
                    }else{
                        $output .='
                        <span><a id="datafile6" href="#" data-toggle="modal" data-target="#show_file6" data_file6="'.$result->crfcus_file6.'"><b>'.$result->crfcus_file6.'</b></a></span>
                        ';
                    }
                    echo $output;
                    ?>

                    <!-- <span><a id="datafile6" href="#" data-toggle="modal" data-target="#show_file6" data_file6="<?= $result->crfcus_file6 ?>"><b><?= $result->crfcus_file6 ?></b></a></span> -->

                </div>
            </div>


            <label for="">
                <h6><b><u>Credit term</u></b></h6>
            </label>

            <div class="row change_credit" style="display:none">
                <div class="col-md-6 form-group">
                    <input type="checkbox" name="crf_change_creditterm" id="crf_change_creditterm" value="1" checked>
                    <label for="">ปรับ Credit term</label>
                </div>
            </div>

            <div class="row form-group creditTermOpen">
                <div class="col-md-4 form-group">
                    <label for="">รายการปัจจุบัน</label>
                    <input readonly class="form-control form-control-sm" type="text" name="crf_creditterm_view" id="crf_creditterm_view" value="<?= $result->credit_name ?>">
                </div>

            </div>


            <br>

            <label for="">
                <h6><b><u>เงื่อนไขการวางบิล</u></b></h6>
            </label>
            <input hidden type="text" name="forcrf_condition_bill_view" id="forcrf_condition_bill_view" value="<?= $result->crfcus_conditionbill ?>">
            <div class="row form-group">
                <div class="col-md-4">
                    <input type="radio" name="crf_condition_bill1_view" id="crf_condition_bill1_view" value="ส่งของพร้อมวางบิล" onclick="return false">
                    <label for="">ส่งของพร้อมวางบิล</label>
                </div>
                <div class="col-md-4">
                    <input type="radio" name="crf_condition_bill2_view" id="crf_condition_bill2_view" value="วางบิลตามตาราง" onclick="return false">
                    <label for="">วางบิลตามตาราง</label>
                </div>
                <div class="col-md-4">
                    <input type="radio" name="crf_condition_bill3_view" id="crf_condition_bill3_view" value="วางบิลทุกวันที่" onclick="return false">
                    <label for="">วางบิลทุกวันที่</label>
                </div>
            </div>
            <div id="alert_condition_bill"></div>

            <div class="row form-group crf_condition_bill2" style="display:none">
                <div class="col-md-6">
                    <label for="">ตารางวางบิล</label><br>
                    <span><b><a id="tablebill" href="#" data-toggle="modal" data-target="#show_file7" data_tablebill="<?= $result->crfcus_tablebill ?>"><?= $result->crfcus_tablebill ?></a></b></span>
                </div>
                <div class="col-md-6">
                    <label for="">แผนที่ ที่ไปวางบิล</label><br>
                    <span><b><a id="mapbill" href="#" data-toggle="modal" data-target="#show_file8" data_mapbill="<?= $result->crfcus_mapbill ?>"><?= $result->crfcus_mapbill ?></a></b></span>
                </div>
            </div>

            <div class="row form-group crf_condition_bill3" style="display:none">
                <div class="col-md-6">
                    <label for="">ทุกวันที่</label>
                    <input readonly type="text" name="crf_datebill_view" id="crf_datebill_view" class="form-control form-control-sm" value="<?= $result->crfcus_datebill ?>">
                </div>
                <div class="col-md-6">
                    <label for="">แผนที่ ที่ไปวางบิล</label><br>
                    <span><b><a id="mapbill2" href="#" data-toggle="modal" data-target="#show_file9" data_mapbill2="<?= $result->crfcus_mapbill2 ?>"><?= $result->crfcus_mapbill2 ?></a></b></span>
                </div>
            </div><br>




            <label for="">
                <h6><b><u>เงื่อนไขการรับชำระเงิน</u></b></h6>
            </label>
            <input hidden type="text" name="forcrf_condition_money_view" id="forcrf_condition_money_view" value="<?= $result->crfcus_conditionmoney ?>">
            <div class="row form-group">
                <div class="col-md-4">
                    <input type="radio" name="crf_condition_money_view" id="crf_condition_money1_view" value="โอนเงิน" onclick="return false">
                    <label for="">โอนเงิน</label>
                </div>
                <div class="col-md-4">
                    <input type="radio" name="crf_condition_money_view" id="crf_condition_money2_view" value="รับเช็ค" onclick="return false">
                    <label for="">รับเช็ค</label>
                </div>
            </div>



            <div class="row form-group recive_cheuqe" style="display:none;">
                <div class="col-md-6 form-group">
                    <label for="">แนบตารางวางบิล / รับเช็ค</label><br>
                    <span><b><a id="recive_cheuqetable" href="#" data-toggle="modal" data-target="#show_file10" data_recive_cheuqetable="<?= $result->crfcus_cheuqetable ?>"><?= $result->crfcus_cheuqetable ?></a></b></span>

                </div>
                <div class="col-md-12 form-group">
                    <label for="">ระบุรายละเอียด</label>
                    <textarea readonly name="crf_recive_cheuqedetail_view" id="crf_recive_cheuqedetail_view" cols="30" rows="4" class="form-control form-control-sm"><?= $result->crfcus_cheuqedetail ?></textarea>

                </div>
            </div><br>




            <label for="">
                <h6><b><u>วงเงิน</u></b></h6>
            </label>

            <div class="row form-group">
                <div class="col-md-6">
                    <label for="">วงเงิน</label>
                    <input readonly type="text" name="crf_finance_old_view" id="crf_finance_old_view" class="form-control form-control-sm" value="<?= getCreditMax($result->crfcus_code , $result->crfcus_area)?>">
                </div>
            </div>

            <hr>

        </div>
        <!-- กรอบฟอร์ม -->



    </div>








</body>