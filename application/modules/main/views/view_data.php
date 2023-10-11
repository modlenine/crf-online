<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายการ Credit Request Form เลขที่</title>
</head>
<?php
if ($result->crf_status == "Open") {
    $colorFont = ' style="color:#228B22;" ';
} else {
    $colorFont = "";
}
?>

<body>
    <div class="container bg-white p-3">
        <h2 align="center">รายการ Credit Request Form</h2>
        <h4 align="center"><?= $result->crf_formno . "&nbsp;&nbsp;<b>สถานะ : </b>&nbsp;<span " . $colorFont . ">" . $result->crf_status . "</span>" ?></h4>

        <hr>
        <div id="btnEditZone" class="row" style="display:none;">
            <div class="col-md-12">
                <a href="<?= base_url('main/editdata/') . $result->crf_id ?>"><button class="btn btn-warning mt-2">แก้ไขข้อมูล</button></a>
                <a href="<?= base_url('main/canceldata/') . $result->crf_id . "/" . $result->crf_formno ?>"><button class="btn btn-danger mt-2" onclick="return confirm('คุณต้องการยกเลิกเอกสารนี้ใช่หรือไม่')">ยกเลิกเอกสาร</button></a>
            </div>
        </div>



        <div class="mt-3 p-3" style="border:solid #ccc 1px; background-color:#F8F8FF;">

            <!-- Document Head -->
            <div class="row form-group">
                <div align="left" class="col-md-6">
                    <h3>CREDIT REQUEST FORM</h3>
                </div>
                <div align="right" class="col-md-6">
                    <h5><?= getFormCode() ?></h5>
                </div>
            </div>


            <!-- Chose Company -->
            <input hidden type="text" name="forcrf_company_view" id="forcrf_company_view" value="<?= $result->crf_company ?>">

            <div class="row form-group mt-3 p-2">
                <div class="col-md-4 form-group">
                    <div class="custom-radio custom-control">
                        <input id="view_crf_company_sln" class="custom-control-input" type="radio" name="view_crf_company" value="sln" onclick="return false;">
                        <label for="my-input" class="custom-control-label">Salee Colour Public Company Limited.</label>
                    </div>
                </div>
                <div class="col-md-4 form-group">
                    <div class="custom-radio custom-control">
                        <input id="view_crf_company_poly" class="custom-control-input" type="radio" name="view_crf_company" value="poly" onclick="return false;">
                        <label for="my-input" class="custom-control-label">Poly Meritasia Co.,Ltd.</label>
                    </div>
                </div>
                <div class="col-md-4 form-group">
                    <div class="custom-radio custom-control">
                        <input id="view_crf_company_ca" class="custom-control-input" type="radio" name="view_crf_company" value="ca" onclick="return false;">
                        <label for="my-input" class="custom-control-label">Composite Asia Co.,Ltd</label>
                    </div>
                </div>
                <div class="col-md-4 form-group">
                    <div class="custom-radio custom-control">
                        <input id="view_crf_company_tb" class="custom-control-input" type="radio" name="view_crf_company" value="tb" onclick="return false;">
                        <label for="my-input" class="custom-control-label">The Bubbles Co.,Ltd.</label>
                    </div>
                </div>
            </div>



            <input hidden type="text" name="forcrf_type_view" id="forcrf_type_view" value="<?= $result->crf_type ?>">

            <div class="row form-group p-2">
                <div class="col-md-3 form-group">
                    <div class="custom-radio custom-control">
                        <input class="custom-control-input" type="radio" name="crf_type_view" id="crf_type1_view" value="1" onclick="return false;">
                        <label for="" class="custom-control-label">ลูกค้าใหม่</label>
                    </div>
                </div>
                <div class="col-md-3 form-group">
                    <div class="custom-radio custom-control">
                        <input class="custom-control-input" type="radio" name="crf_type_view" id="crf_type2_view" value="2" onclick="return false;">
                        <label for="" class="custom-control-label">ลูกค้าเดิม</label>
                    </div>
                </div>
            </div>




                <input hidden type="text" name="forcrf_personal_type_view" id="forcrf_personal_type_view" value="<?= $result->crf_personal_type ?>">
                <div class="row form-group p-2">
                    <div class="col-md-3 form-group">
                        <div class="custom-radio custom-control">
                            <input class="custom-control-input" type="radio" name="crf_person_type" id="crf_person_type_natural" value="natural" onclick="return false;">
                            <label class="custom-control-label">บุคคลธรรมดา</label>
                        </div>
                    </div>
                    <div class="col-md-3 form-group">
                        <div class="custom-radio custom-control">
                            <input class="custom-control-input" type="radio" name="crf_person_type" id="crf_person_type_juristic" value="juristic" onclick="return false;">
                            <label class="custom-control-label">นิติบุคคล</label>
                        </div>
                    </div>
                </div>



            <input style="display:none" type="text" name="forcrf_sub_oldcus_changearea_view" id="forcrf_sub_oldcus_changearea_view" value="<?= $result->crf_sub_oldcus_changearea ?>">
            <input style="display:none" type="text" name="forcrf_sub_oldcus_changeaddress_view" id="forcrf_sub_oldcus_changeaddress_view" value="<?= $result->crf_sub_oldcus_changeaddress ?>">
            <input style="display:none" type="text" name="forcrf_sub_oldcus_changecredit_view" id="forcrf_sub_oldcus_changecredit_view" value="<?= $result->crf_sub_oldcus_changecredit ?>">
            <input style="display:none" type="text" name="forcrf_sub_oldcus_changefinance_view" id="forcrf_sub_oldcus_changefinance_view" value="<?= $result->crf_sub_oldcus_changefinance ?>">
            <input style="display:none" type="text" name="forcrf_sub_oldcus_editcustomer_view" id="forcrf_sub_oldcus_editcustomer_view" value="<?= $result->crf_sub_oldcus_editcustomer ?>">

            <div class="row form-group p-2">
                <div class="col-md-3 form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="crf_sub_oldcus_changearea_view" id="crf_sub_oldcus_changearea_view" value="1" onclick="return false;">
                        <label for="my-input" class="form-check-label">เปลี่ยนเขตการขาย</label>
                    </div>
                </div>
                <div class="col-md-3 form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="crf_sub_oldcus_changeaddress_view" id="crf_sub_oldcus_changeaddress_view" value="1" onclick="return false;">
                        <label for="my-input" class="form-check-label">เปลี่ยนที่อยู่</label>
                    </div>
                </div>
                <div class="col-md-3 form-group">
                        <div class="form-check">
                            <input class="form-check-input " type="checkbox" name="crf_sub_oldcus_editcustomer_view" id="crf_sub_oldcus_editcustomer_view" value="1" onclick="return false;">
                            <label for="my-input" class="form-check-label">แก้ไขข้อมูลลูกค้า</label>
                        </div>
                    </div>
                <div class="col-md-3 form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="crf_sub_oldcus_changecredit_view" id="crf_sub_oldcus_changecredit_view" value="1" onclick="return false;">
                        <label for="my-input" class="form-check-label">ปรับ Credit term. เพิ่ม / ลด</label>
                    </div>
                </div>
                <div class="col-md-3 form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="crf_sub_oldcus_changefinance_view" id="crf_sub_oldcus_changefinance_view" value="1" onclick="return false;">
                        <label for="my-input" class="form-check-label">ปรับวงเงิน เพิ่ม / ลด</label>
                    </div>
                </div>
            </div>




            <div class="row form-group p-2">
                <div class="col-md-4 form-group">
                    <label for="">วันที่</label>
                    <input readonly type="text" name="crf_datecreate_view" id="crf_datecreate_view" class="form-control form-control-sm" value="<?= conDateFromDb($result->crf_datecreate) ?>">
                </div>
                <div class="col-md-4 form-group">
                    <label for="">Customer code : &nbsp;</label>
                    <input type="text" name="crf_customercode_view" id="crf_customercode_view" class="form-control form-control-sm" readonly value="<?= $result->crfcus_code ?>">
                </div>
                <div class="col-md-4 form-group">
                    <?php
                    if ($result->crf_sub_oldcus_changearea == 1 && $result->crf_status != "Complated") {
                        $salesReps = $result->crfcus_salesreps;
                    } else {
                        $salesReps = $result->crfcus_salesreps;
                    }
                    ?>
                    <label for="">Sales Reps : &nbsp;</label>
                    <input readonly type="text" name="crf_salesreps_view" id="crf_salesreps_view" class="form-control form-control-sm" value="<?= $salesReps ?>">
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


            <?php
            if ($result->crf_sub_oldcus_changeaddress == 2 && $result->crf_status != "Complated") {
                $addresstype = $result->crfcus_addresstype;
                $address = $result->crfcus_address;
                $file1 = $result->crfcus_file1;
            } else {
                $addresstype = $result->crfcus_addresstype;
                $address = $result->crfcus_address;
                $file1 = $result->crfcus_file1;
            }
            ?>
            <input hidden type="text" name="forcrf_addresstype_view" id="forcrf_addresstype_view" value="<?= $addresstype ?>">

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
                    <textarea readonly name="crf_addressname_view" id="crf_addressname_view" cols="30" rows="3" class="form-control"><?= $address ?></textarea>
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

                <div class="col-md-3" id="viewmapurl">
                        <label for="">แผนที่ (ลิ้งจาก Googlemap) :</label>
                        <input hidden type="text" name="checkfilelink" id="checkfilelink" value="<?=$result->crfcus_mapurl?>">
                        <?php
                        $hidegooglemap = "";
                        if($result->crfcus_mapurl == "-"){
                            $hidegooglemap = "javascript:void(0)";
                        }else{
                            
                            $hidegooglemap = $result->crfcus_mapurl;
                        }
                        ?>
                        <a id="maplink" href="<?=$hidegooglemap?>" target="_blank"><span><i class="fas fa-map-marked-alt" style="font-size:28px;color:green;"></i></span></a>
                    </div>
                    <div class="col-md-3" id="viewmapfile">
                        <label for="">แนบไฟล์แผนที่ (jpg , png , pdf) :</label>
                        <input hidden type="text" name="checkmapfile" id="checkmapfile" value="<?=$result->crfcus_mapfile?>">
                        <a id="mapfilelink" href="<?=base_url('upload/').$result->crfcus_mapfile?>" target="_blank" data-toggle="modal" data-target="#" data_mapfile = "<?=$result->crfcus_mapfile?>"><span><i class="fas fa-map-marked-alt" style="font-size:28px;color:orange;"></i></span></a>
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
            foreach (getPrimanage($result->crfcus_formno)->result() as $rs) {

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


            <section>
                <div class="row form-group">
                    <div class="col-md-12">
                        <label for="">หมายเหตุ</label>
                        <textarea readonly name="crf_textmemo_view" id="crf_textmemo_view" cols="30" rows="1" class="form-control"><?= $result->crfcus_textmemo ?></textarea>
                    </div>
                </div>
            </section>



            <label for="">
                <h6><b><u>เอกสารที่จำเป็นในการขอเปิดวงเงินการค้า</u></b></h6>
            </label>


            <div class="row form-group" id="view_file_natural">
            <div class="col-md-4 form-group crf_file1">
                    <label for="">สำเนาบัตรประชาชน</label><br>
                    <!-- แก้ไขการแสดงผล -->
                    <?php 
                    $output = '';
                    if(substr($result->crfcus_personal , -3) == "pdf" || substr($result->crfcus_personal , -3) == "PDF"){
                        $output .='
                        <span><a href="'.base_url("upload/").$result->crfcus_personal.'" target="_blank"><b>'.$result->crfcus_personal.'</b></a></span>
                        ';
                    }else{
                        $output .='
                        <span><a href="'.base_url("upload/").$result->crfcus_personal.'" target="_blank"><b>'.$result->crfcus_personal.'</b></a></span>
                        ';
                    }
                    echo $output;
                    ?>
                    
                    <!-- <span><a id="datafile1" href="#" data-toggle="modal" data-target="#show_file1" data_file1="<?= $file1 ?>"><b><?= $file1 ?></b></a></span> -->

                </div>
            </div>


            <div class="row form-group" id="view_file_juristic">
                <div class="col-md-4 form-group crf_file1">
                    <label for="">ภพ.20 / ภธ.09</label><br>
                    <!-- แก้ไขการแสดงผล -->
                    <?php 
                    $output = '';
                    if(substr($file1 , -3) == "pdf" || substr($file1 , -3) == "PDF"){
                        $output .='
                        <span><a href="'.base_url("upload/").$file1.'" target="_blank"><b>'.$file1.'</b></a></span>
                        ';
                    }else{
                        $output .='
                        <span><a id="datafile1" href="#" data-toggle="modal" data-target="#show_file1" data_file1="'.$file1.'"><b>'.$file1.'</b></a></span>
                        ';
                    }
                    echo $output;
                    ?>
                    
                    <!-- <span><a id="datafile1" href="#" data-toggle="modal" data-target="#show_file1" data_file1="<?= $file1 ?>"><b><?= $file1 ?></b></a></span> -->

                </div>
                <div class="col-md-4 form-group crf_file2">
                    <label for="">หนังสือรับรอง</label><br>
                    <!-- แก้ไขการแสดงผล -->
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
                    <!-- แก้ไขการแสดงผล -->
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
                    <!-- แก้ไขการแสดงผล -->
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
                    <!-- แก้ไขการแสดงผล -->
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
                    <!-- แก้ไขการแสดงผล -->
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

                </div>
            </div>


            <label for="">
                <h6><b><u>Credit term</u></b></h6>
            </label>

            <div class="row change_credit" style="display:none">
                <div class="col-md-6 form-group">
                    <input type="checkbox" name="crf_change_creditterm" id="crf_change_creditterm" value="1" checked disabled>
                    <label for="">ปรับ Credit term</label>
                </div>
            </div>

            <div class="row form-group creditTermOpen">
                <div class="col-md-4 form-group">
                    <?php
                    if ($result->crfcus_creditterm2 != '') {
                        $creditnow = conCreditTerm($result->crfcus_creditterm);
                    } else {
                        $creditnow = $result->credit_name;
                    }

                    ?>
                    <label for="">รายการปัจจุบัน</label>
                    <input readonly class="form-control form-control-sm" type="text" name="crf_creditterm_view" id="crf_creditterm_view" value="<?= $creditnow ?>">
                </div>
                <div class="col-md-4 form-group change_credit_detail" style="display:none">
                    <label for="">เงื่อนไข</label>
                    <input readonly type="text" name="crf_condition_credit_view" id="crf_condition_credit_view" class="form-control form-control-sm" value="<?= $result->crf_condition_credit ?>">
                </div>
                <?php
                $creditterm2 = "";
                $oldcreditterm = "";
                if ($result->crf_creditterm2 != 0) {
                    $creditterm2 = conCreditTerm($result->crf_creditterm2);
                    $oldcreditterm = conCreditTerm($result->crf_creditterm);
                } else if ($result->crf_creditterm2 == 0) {
                    $creditterm2 = "";
                    $oldcreditterm = conCreditTerm($result->crfcus_creditterm);
                }

                ?>
                <div class="col-md-4 form-group change_credit_detail" style="display:none">
                    <label for="">รายการที่ร้องขอ</label>
                    <input readonly type="text" name="crf_creditterm2_view" id="crf_creditterm2_view" class="form-control form-control-sm" value="<?= $creditterm2 ?>">
                </div>
            </div>

            <div class="row form-group creditTermComplete" style="display:none;">
                <div class="col-md-4 form-group">
                    <label for="">รายการเดิม</label>
                    <input readonly class="form-control form-control-sm" type="text" name="crf_creditterm_view" id="crf_creditterm_view" value="<?= $oldcreditterm ?>">
                </div>

                <div class="col-md-4 form-group change_credit_detail" style="display:none">
                    <label for="">เงื่อนไข</label>
                    <input readonly type="text" name="crf_condition_credit_view" id="crf_condition_credit_view" class="form-control form-control-sm" value="<?= $result->crf_condition_credit ?>">
                </div>

                <div class="col-md-4 form-group change_credit_detail" style="display:none">
                    <label for="">รายการใหม่</label>
                    <input readonly type="text" name="crf_creditterm2_view" id="crf_creditterm2_view" class="form-control form-control-sm" value="<?= $creditterm2 ?>">
                </div>
            </div>



            <br>

            <label for="">
                <h6><b><u>เงื่อนไขการวางบิล</u></b></h6>
            </label>
            <input hidden type="text" name="forcrf_condition_bill_view" id="forcrf_condition_bill_view" value="<?= $result->crfcus_conditionbill ?>">
            <div class="row form-group">
                <div class="col-md-4">
                    <input type="radio" name="crf_condition_bill_view" id="crf_condition_bill1_view" value="ส่งของพร้อมวางบิล" onclick="return false">
                    <label for="">ส่งของพร้อมวางบิล</label>
                </div>
                <div class="col-md-4">
                    <input type="radio" name="crf_condition_bill_view" id="crf_condition_bill2_view" value="วางบิลตามตาราง" onclick="return false">
                    <label for="">วางบิลตามตาราง</label>
                </div>
                <div class="col-md-4">
                    <input type="radio" name="crf_condition_bill_view" id="crf_condition_bill3_view" value="วางบิลทุกวันที่" onclick="return false">
                    <label for="">วางบิลทุกวันที่</label>
                </div>
            </div>
            <div id="alert_condition_bill"></div>

            <div class="row form-group crf_condition_bill2" style="display:none">
                <div class="col-md-6">
                    <label for="">ตารางวางบิล</label><br>
                    <span><b><a id="tablebill" href="<?=base_url('upload/').$result->crfcus_tablebill?>" target="_blank"><?= $result->crfcus_tablebill ?></a></b></span>
                </div>
                <div class="col-md-6">
                    <label for="">แผนที่ ที่ไปวางบิล</label><br>
                    <span><b><a id="mapbill" href="<?=base_url('upload/').$result->crfcus_mapbill?>" target="_blank"><?= $result->crfcus_mapbill ?></a></b></span>
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
                    <span><b><a id="recive_cheuqetable" href="<?=base_url('upload/').$result->crfcus_cheuqetable?>" target="_blank"><?= $result->crfcus_cheuqetable ?></a></b></span>

                </div>
                <div class="col-md-12 form-group">
                    <label for="">ระบุรายละเอียด</label>
                    <textarea readonly name="crf_recive_cheuqedetail_view" id="crf_recive_cheuqedetail_view" cols="30" rows="4" class="form-control form-control-sm"><?= $result->crfcus_cheuqedetail ?></textarea>

                </div>
            </div><br>




            <label for="">
                <h6><b><u>วงเงินการค้าและเงื่อนไขที่ขอเสนอ</u></b></h6>
            </label>
            <!-- For check -->
            <input hidden type="text" name="forcrf_finance_view" id="forcrf_finance_view" value="<?= $result->crf_finance ?>">
            <div class="row form-group">
                <div class="col-md-4 from-group">
                    <input type="radio" name="crf_finance_view" id="crf_finance1_view" value="ขอวงเงิน" onclick="return false">
                    <label for="">ขอวงเงิน</label>
                </div>
                <div class="col-md-4 from-group">
                    <input type="radio" name="crf_finance_view" id="crf_finance2_view" value="ปรับวงเงิน" onclick="return false">
                    <label for="">ปรับวงเงิน</label>
                </div>
            </div>


            <!-- สำหรับขอวงเงิน -->
            <div class="row form-group finance_request_detail" style="display:none;">
                <div class="col-md-6">
                    <label for="">วงเงินที่ต้องการ</label>
                    <input readonly type="text" name="crf_finance_req_number_view" id="crf_finance_req_number_view" class="form-control form-control-sm" value="<?= $result->crfcus_moneylimit ?>">
                </div>
            </div>

            <div class="row form-group">
                <div class="col-md-6">
                    <?php
                    if ($result->crf_finance_req_number == '') {
                        $moneylimitnow = $result->crfcus_moneylimit;
                    } else {
                        $moneylimitnow = $result->crf_finance_req_number;
                    }
                    ?>
                    <label for="" class="labelcrf_finance_old_view">วงเงิน</label>
                    <input readonly type="text" name="crf_finance_old_view" id="crf_finance_old_view" class="form-control form-control-sm" value="<?= $moneylimitnow ?>">
                </div>
            </div>



            <!-- สำหรับปรับวงเงิน -->
            <div class="row form-group finance_change_detail calFinance" style="display:none;">
                <div class="col-md-6 form-group">
                    <label for="">สถานะวงเงิน</label>
                    <input readonly type="text" name="crf_finance_status_view" id="crf_finance_status_view" class="form-control form-control-sm" value="<?= $result->crf_finance_status ?>">
                    <!-- <select name="crf_finance_status" id="crf_finance_status" class="form-control form-control-sm">
                            <option value=""></option>
                            <option value="วงเงินชั่วคราว">วงเงินชั่วคราว</option>
                            <option value="วงเงินถาวร">วงเงินถาวร</option>
                        </select> -->
                </div>
                <div class="col-md-6 form-group">
                    <label for="">สถานะการขอ</label>
                    <input readonly type="text" name="crf_finance_change_status_view" id="crf_finance_change_status_view" class="form-control form-control-sm" value="<?= $result->crf_finance_change_status ?>">
                    <!-- <select name="crf_finance_change_status" id="crf_finance_change_status" class="form-control form-control-sm">
                            <option value=""></option>
                            <option value="เพิ่ม">เพิ่ม</option>
                            <option value="ลด">ลด</option>
                        </select> -->
                </div>


                <div class="col-md-6 form-group">
                    <label for="">จำนวนที่ขอเพิ่ม / ลด</label>
                    <input readonly type="text" name="crf_finance_change_number_view" id="crf_finance_change_number_view" class="form-control form-control-sm" value="<?= $result->crf_finance_change_number ?>">
                </div>
                <div class="col-md-6 form-group">
                    <label for="">รวมทั้งสิ้น</label>
                    <input readonly type="text" name="crf_finance_change_total_view" id="crf_finance_change_total_view" class="form-control form-control-sm" value="<?= $result->crf_finance_change_total ?>">
                </div>
                <div class="col-md-12 form-group">
                    <label for="">เหตุผลในการขอปรับวงเงิน</label>
                    <textarea readonly name="crf_finance_change_reson" id="crf_finance_change_reson" cols="30" rows="3" class="form-control"><?= $result->crf_finance_change_detail ?></textarea>
                </div>
            </div>
            <hr>



            <div class="row form-group">

                <div class="col-md-4 form-group">
                    <label for="">ผู้บันทึกข้อมูล</label>
                    <input readonly type="text" name="crf_userpost_view" id="crf_userpost_view" class="form-control form-control-sm" value="<?= $result->crf_userpost ?>">
                </div>
                <div class="col-md-4 form-group">
                    <label for="">แผนก</label>
                    <input readonly type="text" name="crf_userdeptpost_view" id="crf_userdeptpost_view" class="form-control form-control-sm" value="<?= $result->crf_userdeptpost ?>">
                </div>
                <div class="col-md-4 form-group">
                    <label for="">วันที่บันทึกข้อมูล</label>
                    <input readonly type="text" name="crf_userpostdatetime_view" id="crf_userpostdatetime_view" class="form-control form-control-sm" value="<?= conDateTimeFromDb($result->crf_userpostdatetime) ?>">
                </div>
            </div>
            <hr>

            <!-- Data Check From Data base -->
            <input hidden type="text" name="checkStatus" id="checkStatus" value="<?= $result->crf_status ?>">
            <input hidden type="text" name="checkUserPost" id="checkUserPost" value="<?= $result->crf_userpost ?>">
            <input hidden type="text" name="checkDeptCode" id="checkDeptCode" value="<?= $result->crf_userdeptcodepost ?>">
            <input hidden type="text" name="checkUserecode" id="checkUserecode" value="<?= $result->crf_userecodepost ?>">

            <!-- Data Check From Login -->
            <br>
            <input hidden type="text" name="checkDeptCodeL" id="checkDeptCodeL" value="<?= getUser()->DeptCode ?>">
            <input hidden type="text" name="checkUserecodeL" id="checkUserecodeL" value="<?= getUser()->ecode ?>">
            <input hidden type="text" name="checkUserPosi" id="checkUserPosi" value="<?= getUser()->posi ?>">










            <!-- For Control when cancel -->
            <div id="cancel">
                <!-- Section สำหรับ CS , Sales Manager -->
                <form action="<?= base_url('main/managerApprove/') . $result->crf_id ?>" method="post" id="mgrAppr" class="author_manager" style="display:none;">
                    <div id="alertMgrApprove"></div>
                    <h6 class=""><b><u>สำหรับผู้จัดการ</u></b></h6>
                    <div class="row form-group">
                        <!-- Check data -->
                        <input hidden type="text" name="formgr_appro" id="formgr_appro" value="<?= $result->crf_mgrapprove_status ?>">
                        <input hidden type="text" name="saleMgrCusid" id="saleMgrCusid" value="<?= $result->crf_cuscode ?>">
                        <input hidden type="text" name="saleMgrFormno" id="saleMgrFormno" value="<?= $result->crf_formno ?>">
                        <input hidden type="text" name="cusTypeForEmail" id="cusTypeForEmail" value="<?= $result->crf_type ?>">

                        <div class="col-md-12" id="mgr_appro">
                            <input type="radio" name="mgr_appro" id="mgr_appro1" value="อนุมัติ">&nbsp;<label>อนุมัติ</label>&nbsp;&nbsp;
                            <input type="radio" name="mgr_appro" id="mgr_appro0" value="ไม่อนุมัติ">&nbsp;<label>ไม่อนุมัติ</label>
                        </div>
                        <div class="col-md-12" id="formgr_appro">
                            <input onclick="return false" type="radio" name="formgr_appro" id="formgr_appro1" value="อนุมัติ">&nbsp;<label>อนุมัติ</label>&nbsp;&nbsp;
                            <input onclick="return false" type="radio" name="formgr_appro" id="formgr_appro0" value="ไม่อนุมัติ">&nbsp;<label>ไม่อนุมัติ</label>
                        </div>


                        <div class="col-md-8 form-group">
                            <label>เหตุผลการอนุมัติ</label>
                            <textarea name="crf_mgrapprove_detail" id="crf_mgrapprovedetail" cols="30" rows="2" class="form-control"></textarea>
                            <textarea readonly name="forcrf_mgrapprove_detail" id="forcrf_mgrapprove_detail" cols="30" rows="2" class="form-control"><?= $result->crf_mgrapprove_detail ?></textarea>
                        </div>

                        <!-- Check data -->
                        <div class="col-md-4 form-group">
                            <label for="">ผู้อนุมัติ</label>
                            <input readonly type="text" name="crf_mgrapprove_name" id="crf_mgrapprove_name" class="form-control form-control-sm" value="<?= getUser()->Fname . " " . getUser()->Lname ?>">
                            <input readonly type="text" name="forcrf_mgrapprove_name" id="forcrf_mgrapprove_name" class="form-control form-control-sm" value="<?= $result->crf_mgrapprove_name ?>">
                            <input readonly type="text" name="crf_mgrapprove_datetime" id="crf_mgrapprove_datetime" class="form-control form-control-sm mt-1" value="<?= date("d-m-Y H:i:s"); ?>">
                            <input readonly type="text" name="forcrf_mgrapprove_datetime" id="forcrf_mgrapprove_datetime" class="form-control form-control-sm mt-1" value="<?= conDateTimeFromDb($result->crf_mgrapprove_datetime) ?>">

                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-4"></div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4"><button type="submit" class="btn btn-info btn-block" id="mgr_submit" name="mgr_submit">Submit</button></div>
                    </div>
                </form>
                <!-- Section สำหรับ CS , Sales Manager -->




                <!-- Section สำหรับ CS -->
                <form action="<?= base_url('main/csBr/') . $result->crf_id ?>" method="post" style="display:none;" class="cs_br">
                    <h6 class=""><b><u>สำหรับ CS</u></b></h6>

                    <!-- BRCODE CHECK -->
                    <input hidden type="text" name="forcheckcrf_brcode" id="forcheckcrf_brcode" value="<?= $result->crf_brcode ?>">
                    <input hidden type="text" name="forcheckcrf_area" id="forcheckcrf_area" value="<?= $result->crf_company ?>">
                    <input hidden type="text" name="CsFormno" id="CsFormno" value="<?= $result->crf_formno ?>">

                    <div class="row form-group">
                        <div class="col-md-8 form-group">
                            <label for="">เลขที่ BR</label>
                            <input readonly type="text" name="forcrf_brcode" id="forcrf_brcode" class="form-control form-control-sm" value="<?= $result->crf_brcode ?>">
                            <input type="text" name="crf_brcode" id="crf_brcode" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="">ผู้บันทึก</label>
                            <input readonly type="text" name="forcrf_brcode_userpost" id="forcrf_brcode_userpost" class="form-control form-control-sm" value="<?= $result->crf_brcode_userpost ?>">
                            <input readonly type="text" name="crf_brcode_userpost" id="crf_brcode_userpost" class="form-control form-control-sm" value="<?= getUser()->Fname . " " . getUser()->Lname ?>">
                            <input readonly type="text" name="forcrf_becode_datetime" id="forcrf_becode_datetime" class="form-control form-control-sm mt-1" value="<?= conDateTimeFromDb($result->crf_brcode_datetime) ?>">
                            <input readonly type="text" name="crf_becode_datetime" id="crf_becode_datetime" class="form-control form-control-sm mt-1" value="<?= date("d-m-Y H:i:s") ?>">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-4"></div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4"><button type="submit" class="btn btn-info btn-block" id="br_submit" name="br_submit">Submit</button></div>
                    </div>
                    <hr class="">
                </form>
                <!-- Section สำหรับ CS -->







                <!-- Section สำหรับ Account Manager -->
                <form action="<?= base_url('main/accMgr/') . $result->crf_id ?>" method="post" class="acc_manager" style="display:none;">
                    <h6 class=""><b><u>ความเห็นประกอบการพิจารณาจากฝ่ายบัญชีและการเงิน</u></b></h6>
                    <!-- Check data Zone -->
                    <input hidden type="text" name="formgraccappro" id="formgraccappro" value="<?= $result->crf_accmgrapprove_status ?>">
                    <input hidden type="text" name="accMgrCuscode" id="accMgrCuscode" value="<?= $result->crf_cuscode ?>">
                    <input hidden type="text" name="accMgrFormno" id="accMgrFormno" value="<?= $result->crf_formno ?>">
                    <input hidden type="text" name="accMgr_cusTypeForEmail" id="accMgr_cusTypeForEmail" value="<?= $result->crf_type ?>">

                    <!-- Check method for redirect section -->
                    <input hidden type="text" name="mgrCheckmethod1" id="mgrCheckmethod1" value="<?=$result->crf_sub_oldcus_changearea?>">
                    <input hidden type="text" name="mgrCheckmethod2" id="mgrCheckmethod2" value="<?=$result->crf_sub_oldcus_changeaddress?>">
                    <input hidden type="text" name="mgrCheckmethod3" id="mgrCheckmethod3" value="<?=$result->crf_sub_oldcus_changecredit?>">
                    <input hidden type="text" name="mgrCheckmethod4" id="mgrCheckmethod4" value="<?=$result->crf_sub_oldcus_changefinance?>">
                    <input hidden type="text" name="mgrCheckmethod5" id="mgrCheckmethod5" value="<?=$result->crf_sub_oldcus_editcustomer?>">
                    <!-- Check method for redirect section -->

                    <div class="row form-group">
                        <div class="col-md-12 mgr_appro">
                            <input type="radio" name="mgracc_appro" id="mgracc_appro" value="อนุมัติ">&nbsp;<label>อนุมัติ</label>&nbsp;&nbsp;
                            <input type="radio" name="mgracc_appro" id="mgracc_appro" value="ไม่อนุมัติ">&nbsp;<label>ไม่อนุมัติ</label>
                        </div>

                        <!-- When Have Data on Database -->
                        <div class="col-md-12 formgr_appro">
                            <input onclick="return false;" type="radio" name="formgracc_appro" id="formgracc_appro1" value="อนุมัติ">&nbsp;<label>อนุมัติ</label>&nbsp;&nbsp;
                            <input onclick="return false;" type="radio" name="formgracc_appro" id="formgracc_appro2" value="ไม่อนุมัติ">&nbsp;<label>ไม่อนุมัติ</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <label for="">ความเห็นอื่นๆ</label>
                            <textarea name="crf_accmgr_detail" id="crf_accmgr_detail" cols="30" rows="2" class="form-control"></textarea>
                            <textarea readonly name="forcrf_accmgr_detail" id="forcrf_accmgr_detail" cols="30" rows="2" class="form-control"><?= $result->crf_accmgr_detail ?></textarea>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="">ผู้อนุมัติ</label>
                            <input readonly type="text" name="crf_accmgr_name" id="crf_accmgr_name" class="form-control form-control-sm" value="<?= getUser()->Fname . " " . getUser()->Lname ?>">
                            <input readonly type="text" name="forcrf_accmgr_name" id="forcrf_accmgr_name" class="form-control form-control-sm" value="<?= $result->crf_accmgr_name ?>">
                            <input readonly type="text" name="crf_accmgr_datatime" id="crf_accmgr_datatime" class="form-control form-control-sm mt-1" value="<?= date("d-m-Y H:i:s") ?>">
                            <input readonly type="text" name="forcrf_accmgr_datatime" id="forcrf_accmgr_datatime" class="form-control form-control-sm mt-1" value="<?= conDateTimeFromDb($result->crf_accmgr_datetime) ?>">
                        </div>
                    </div>
                    <div class="row form-group ">
                        <div class="col-md-4"></div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4"><button type="submit" class="btn btn-info btn-block" id="accmgr_submit" name="accmgr_submit">Submit</button></div>
                    </div>
                    <hr class="">
                </form>
                <!-- Section สำหรับ Account Manager -->







                <!-- Section สำหรับ Directorคนที่1 -->
                <form action="<?= base_url('main/director1/') . $result->crf_id ?>" method="post" class="director1" style="display:none;">
                    <h6 class=""><b><u>สำหรับฝ่ายบริหาร1</u></b></h6>

                    <!-- Check Data -->
                    <input hidden type="text" name="checkfordirector1_appro" id="checkfordirector1_appro" value="<?= $result->crf_directorapprove_status1 ?>">
                    <input hidden type="text" name="Director1Cuscode" id="Director1Cuscode" value="<?= $result->crf_cuscode ?>">
                    <input hidden type="text" name="director1Formno" id="director1Formno" value="<?= $result->crf_formno ?>">
                    <input hidden type="text" name="direc1_cusTypeForEmail" id="direc1_cusTypeForEmail" value="<?= $result->crf_type ?>">
                    <input hidden type="text" name="Director2Cuscode" id="Director2Cuscode" value="<?= $result->crf_cuscode ?>">
                    <input hidden type="text" name="direc2FormNo" id="direc2FormNo" value="<?= $result->crfcus_formno ?>">

                    <div id="di1" class="row form-group ">
                        <div class="col-md-12 director1_appro">
                            <input type="radio" name="director1_appro" id="director1_appro" value="อนุมัติ">&nbsp;<label>อนุมัติ</label>&nbsp;&nbsp;
                            <input type="radio" name="director1_appro" id="director1_appro" value="ไม่อนุมัติ">&nbsp;<label>ไม่อนุมัติ</label>
                        </div>

                        <div class="col-md-12 fordirector1_appro">
                            <input onclick="return false;" type="radio" name="fordirector1_appro" id="fordirector1_appro1" value="อนุมัติ">&nbsp;<label>อนุมัติ</label>&nbsp;&nbsp;
                            <input onclick="return false;" type="radio" name="fordirector1_appro" id="fordirector1_appro2" value="ไม่อนุมัติ">&nbsp;<label>ไม่อนุมัติ</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <label for="">ความเห็นของฝ่ายบริหาร</label>
                            <textarea name="crf_director_detail1" id="crf_director_detail1" cols="30" rows="2" class="form-control"></textarea>
                            <textarea readonly name="forcrf_director_detail1" id="forcrf_director_detail1" cols="30" rows="2" class="form-control"><?= $result->crf_director_detail1 ?></textarea>
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="">ผู้อนุมัติ</label>
                            <input readonly type="text" name="crf_director_name1" id="crf_director_name1" class="form-control form-control-sm" value="<?= getUser()->Fname . " " . getUser()->Lname ?>">
                            <input readonly type="text" name="forcrf_director_name1" id="forcrf_director_name1" class="form-control form-control-sm" value="<?= $result->crf_director_name1 ?>">
                            <input readonly type="text" name="crf_director_datatime1" id="crf_director_datatime1" class="form-control form-control-sm mt-1" value="<?= date("d-m-Y H:i:s") ?>">
                            <input readonly type="text" name="forcrf_director_datatime1" id="forcrf_director_datatime1" class="form-control form-control-sm mt-1" value="<?= conDateTimeFromDb($result->crf_director_datetime1) ?>">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-4"></div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4"><button type="submit" class="btn btn-info btn-block" id="director_submit1" name="director_submit1">Submit</button></div>
                    </div>
                    <hr class="">
                </form>
                <!-- Section สำหรับ Directorคนที่1 -->







                <!-- Section สำหรับ Directorคนที่2 -->
                <form action="<?= base_url('main/director2/') . $result->crf_id ?>" method="post" class="director2" style="display:none">

                    <!-- Check data -->
                    <input style="display:none" type="text" name="userpostD2" id="userpostD2" value="<?= $result->crf_userpost ?>">
                    <input style="display:none" type="text" name="ecodepostD2" id="ecodepostD2" value="<?= $result->crf_userecodepost ?>">
                    <input style="display:none" type="text" name="deptcodeD2" id="deptcodeD2" value="<?= $result->crf_userdeptcodepost ?>">
                    <input hidden type="text" name="Director2Cuscode" id="Director2Cuscode" value="<?= $result->crf_cuscode ?>">
                    <input hidden type="text" name="direc2FormNo" id="direc2FormNo" value="<?= $result->crfcus_formno ?>">
                    <input hidden type="text" name="direc2_cusTypeForEmail" id="direc2_cusTypeForEmail" value="<?= $result->crf_type ?>">

                    <h6 class=""><b><u>สำหรับฝ่ายบริหาร2</u></b></h6>
                    <input hidden type="text" name="checkfordirector2_appro" id="checkfordirector2_appro" value="<?= $result->crf_directorapprove_status2 ?>">
                    <div class="row form-group">
                        <div class="col-md-12 director2_appro">
                            <input type="radio" name="director2_appro" id="director2_appro" value="อนุมัติ">&nbsp;<label>อนุมัติ</label>&nbsp;&nbsp;
                            <input type="radio" name="director2_appro" id="director2_appro" value="ไม่อนุมัติ">&nbsp;<label>ไม่อนุมัติ</label>
                        </div>

                        <div class="col-md-12 fordirector2_appro">
                            <input onclick="return false;" type="radio" name="fordirector2_appro" id="fordirector2_appro1" value="อนุมัติ">&nbsp;<label>อนุมัติ</label>&nbsp;&nbsp;
                            <input onclick="return false;" type="radio" name="fordirector2_appro" id="fordirector2_appro2" value="ไม่อนุมัติ">&nbsp;<label>ไม่อนุมัติ</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <label for="">ความเห็นของฝ่ายบริหาร</label>
                            <textarea name="crf_director_detail2" id="crf_director_detail2" cols="30" rows="2" class="form-control"></textarea>
                            <textarea readonly name="forcrf_director_detail2" id="forcrf_director_detail2" cols="30" rows="2" class="form-control"><?= $result->crf_director_detail2 ?></textarea>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="">ผู้อนุมัติ</label>
                            <input readonly type="text" name="crf_director_name2" id="crf_director_name2" class="form-control form-control-sm" value="<?= getUser()->Fname . " " . getUser()->Lname ?>">
                            <input readonly type="text" name="forcrf_director_name2" id="forcrf_director_name2" class="form-control form-control-sm" value="<?= $result->crf_director_name2 ?>">
                            <input readonly type="text" name="crf_director_datatime2" id="crf_director_datatime2" class="form-control form-control-sm mt-1" value="<?= date("d-m-Y H:i:s") ?>">
                            <input readonly type="text" name="forcrf_director_datatime2" id="forcrf_director_datatime2" class="form-control form-control-sm mt-1" value="<?= conDateTimeFromDb($result->crf_director_datetime2) ?>">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-4"></div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4"><button type="submit" class="btn btn-info btn-block" id="director_submit2" name="director_submit2">Submit</button></div>
                    </div>
                    <hr>
                </form>
                <!-- Section สำหรับ Directorคนที่2 -->



                <!-- Section สำหรับเจ้าหน้าที่บัญชี -->
                <form action="<?= base_url('main/saveCustomersCode/') . $result->crf_id . "/" . $result->crfcus_id ?>" method="post" class="account_staff" style="display:none;">
                    <h6 class=""><b><u>สำหรับเจ้าหน้าที่บัญชี</u></b></h6>

                    <input hidden type="text" name="checkCustomercode" id="checkCustomercode" value="<?= $result->crf_savecustomercode ?>">
                    <input hidden type="text" name="accCheckAreacode" id="accCheckAreacode" value="<?= $result->crf_company ?>">
                    <input hidden type="text" name="accStaffFormNo" id="accStaffFormNo" value="<?= $result->crfcus_formno ?>">
                    <input hidden type="text" name="accStaffCustype" id="accStaffCustype" value="<?= $result->crf_type ?>">

                    <!-- Check method -->
                    <input hidden type="text" name="accCheckmethod3" id="accCheckmethod3" value="<?=$result->crf_sub_oldcus_changecredit?>">
                    <input hidden type="text" name="accCheckmethod4" id="accCheckmethod4" value="<?=$result->crf_sub_oldcus_changefinance?>">

                    <div class="row form-group">
                        <div class="form-group col-md-8 accForcus1">
                            <label for="">รหัสลูกค้า</label>
                            <input type="text" name="cusCode" id="cusCode" class="form-control form-control-sm">
                            <input readonly type="text" name="forcusCode" id="forcusCode" class="form-control form-control-sm" value="<?= $result->crf_savecustomercode ?>">
                            <div id="alertCheckTH"></div>
                        </div>

                        <div class="form-group col-md-8 accForcus2">
                            <label for="">ผลการดำเนินงาน</label>
                            <textarea id="accStaffMemo" name="accStaffMemo" class="form-control" col="3" rows="2"></textarea>
                            <textarea readonly id="foraccStaffMemo" name="foraccStaffMemo" class="form-control" col="3" rows="2"><?=$result->crf_memo_customercode?></textarea>
                        </div>

                        <div class="col-md-4">
                            <label for="">ผู้บันทึก</label>
                            <input readonly type="text" name="cusCode_userPost" id="cusCode_userPost" class="form-control form-control-sm" value="<?= getUser()->Fname . " " . getUser()->Lname ?>">
                            <input readonly type="text" name="forcusCode_userPost" id="forcusCode_userPost" class="form-control form-control-sm" value="<?= $result->crf_usersave_customercode ?>">
                            <input readonly type="text" name="cusCode_datetimePost" id="cusCode_datetimePost" class="form-control form-control-sm mt-1" value="<?= date("d-m-Y H:i:s") ?>">
                            <input readonly type="text" name="fcusCode_datetimePost" id="fcusCode_datetimePost" class="form-control form-control-sm mt-1" value="<?= conDateTimeFromDb($result->crf_datetimesave_customercode) ?>">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-4"></div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4"><button type="submit" class="btn btn-info btn-block" id="acc_staff" name="acc_staff">Submit</button></div>
                    </div>
                </form>

                <!-- Section สำหรับเจ้าหน้าที่บัญชี -->
            </div>


        </div>
        <!-- กรอบฟอร์ม -->



    </div>








</body>