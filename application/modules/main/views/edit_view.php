<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Page</title>
</head>

<body>
    <div class="container  p-3" style="background-color:#FF9900">


        <div class="mt-3 p-3" style="border:solid #ccc 1px; background-color:#F8F8FF;">
            <form action="<?= base_url('main/save_editdata/') ?>" method="POST" id="form1" enctype="multipart/form-data" autocomplete="off">

                <!-- Document Head -->
                <div class="row form-group">
                    <div align="left" class="col-md-6">
                        <h3>CREDIT REQUEST FORM</h3>
                    </div>
                    <div align="right" class="col-md-6">
                        <h5>{getFormCode}</h5>
                    </div>
                </div>


                <!-- Chose Company -->
                <input hidden type="text" name="check_editcom" id="check_editcom" value="{edit_company}">
                <input hidden type="text" name="check_EditFormNo" id="check_EditFormNo" value="{get_formno}">
                <input hidden type="text" name="check_crf_id" id="check_crf_id" value="<?=$get_crfid?>">
                <input hidden type="text" name="check_crfcus_tempid" id="check_crfcus_tempid" value="<?=$crfcus_tempid?>">
                <div id="alert_company"></div>
                <div class="row form-group mt-3 p-2">
                    <div class="col-md-4 form-group">
                        <div class="custom-radio custom-control">
                            <input id="edit_company_sln" class="custom-control-input" type="radio" name="crf_company" value="sln" onclick="return false">
                            <label for="edit_company_sln" class="custom-control-label">Salee Colour Public Company Limited.</label>
                        </div>
                    </div>
                    <div class="col-md-4 form-group">
                        <div class="custom-radio custom-control">
                            <input id="edit_company_poly" class="custom-control-input" type="radio" name="crf_company" value="poly" onclick="return false">
                            <label for="edit_company_poly" class="custom-control-label">Poly Meritasia Co.,Ltd.</label>
                        </div>
                    </div>
                    <div class="col-md-4 form-group">
                        <div class="custom-radio custom-control">
                            <input id="edit_company_ca" class="custom-control-input" type="radio" name="crf_company" value="ca" onclick="return false">
                            <label for="edit_company_ca" class="custom-control-label">Composite Asia Co.,Ltd</label>
                        </div>
                    </div>
                    <div class="col-md-4 form-group">
                        <div class="custom-radio custom-control">
                            <input id="edit_company_tb" class="custom-control-input" type="radio" name="crf_company" value="tb" onclick="return false">
                            <label for="edit_company_tb" class="custom-control-label">The Bubbles Co.,Ltd.</label>
                        </div>
                    </div>
                    <div class="col-md-4 form-group">
                        <div class="custom-radio custom-control">
                            <input id="edit_company_st" class="custom-control-input" type="radio" name="crf_company" value="st" onclick="return false">
                            <label for="edit_company_st" class="custom-control-label">Subterra Co.,Ltd.</label>
                        </div>
                    </div>
                </div>



                <!-- Check ลูกค้าใหม่หรือเดิม -->
                <input hidden type="text" name="check_editcustype" id="check_editcustype" value="{edit_custype}">

                <div id="alert_custype"></div>
                <div class="row form-group p-2">
                    <div class="col-md-3 form-group">
                        <div class="custom-radio custom-control">
                            <input class="custom-control-input" type="radio" name="crf_type" id="edit_custype1" value="1" onclick="return false">
                            <label for="my-input" class="custom-control-label">ลูกค้าใหม่</label>
                        </div>
                    </div>
                    <div class="col-md-3 form-group">
                        <div class="custom-radio custom-control">
                            <input class="custom-control-input" type="radio" name="crf_type" id="edit_custype2" value="2" onclick="return false">
                            <label for="my-input" class="custom-control-label">ลูกค้าเดิม</label>
                        </div>
                    </div>
                </div>





                <div id="alert_custype"></div>
                <input hidden type="text" name="edit_checkCusType" id="edit_checkCusType" value="<?=$edit_personal_type?>">
                <div class="row form-group p-2">
                    <div class="col-md-3 form-group">
                        <div class="custom-radio custom-control">
                            <input class="custom-control-input" type="radio" name="crf_person_type" id="edit_crf_person_type_natural" value="natural" <?=($edit_personal_type == 'natural') ? 'checked' : ''?> onclick="return false">
                            <label for="my-input" class="custom-control-label">บุคคลธรรมดา</label>
                        </div>
                    </div>
                    <div class="col-md-3 form-group">
                        <div class="custom-radio custom-control">
                            <input class="custom-control-input" type="radio" name="crf_person_type" id="edit_crf_person_type_juristic" value="juristic" <?=($edit_personal_type == 'juristic') ? 'checked' : ''?> onclick="return false">
                            <label for="my-input" class="custom-control-label">นิติบุคคล</label>
                        </div>
                    </div>
                </div>





                <!-- Check สิ่งที่ต้องการดำเนินการ -->
                <input hidden type="text" name="check_changearea" id="check_changearea" value="{get_changearea}">
                <input hidden type="text" name="check_changeaddress" id="check_changeaddress" value="{get_changeaddress}">
                <input hidden type="text" name="check_changecredit" id="check_changecredit" value="{get_changecredit}">
                <input hidden type="text" name="check_changefinance" id="check_changefinance" value="{get_changefinance}">
                <input hidden type="text" name="check_editcustomerdetail" id="check_editcustomerdetail" value="{crf_sub_oldcus_editcustomer}">

                <!-- Hidden inputs to preserve checkbox values when disabled by JavaScript -->
                <!-- These ensure Model receives checkbox values even when checkboxes are disabled -->
                <input type="hidden" name="crf_sub_oldcus_changearea" value="<?= ($get_changearea == '1') ? '1' : '' ?>">
                <input type="hidden" name="crf_sub_oldcus_changeaddress_check" value="<?= ($get_changeaddress == '2') ? '2' : '' ?>">
                <input type="hidden" name="crf_sub_oldcus_changecredit_check" value="<?= ($get_changecredit == '3') ? '3' : '' ?>">
                <input type="hidden" name="crf_sub_oldcus_changefinance" value="<?= ($get_changefinance == '4') ? '4' : '' ?>">
                <input type="hidden" name="crf_sub_oldcus_editcustomer_check" value="<?= ($crf_sub_oldcus_editcustomer == '5') ? '5' : '' ?>">

                <div id="alert_crf_sub_oldcus"></div>
                <div class="row form-group p-2 suboldcustomer">
                    <div class="col-md-3 form-group">
                        <div class="form-check">
                            <input class="form-check-input " type="checkbox" name="crf_sub_oldcus_changearea" id="crf_sub_oldcus" value="1" <?= ($get_changearea == '1') ? 'checked' : '' ?> onclick="return false">
                            <label for="my-input" class="form-check-label">เปลี่ยนเขตการขาย</label>
                        </div>
                    </div>
                    <div class="col-md-3 form-group">
                        <div class="form-check">
                            <input class="form-check-input " type="checkbox" name="crf_sub_oldcus_changeaddress" id="crf_sub_oldcus" value="2" <?= ($get_changeaddress == '2') ? 'checked' : '' ?> onclick="return false">
                            <label for="my-input" class="form-check-label">เปลี่ยนที่อยู่</label>
                        </div>
                    </div>
                    <div class="col-md-3 form-group">
                        <div class="form-check">
                            <input class="form-check-input " type="checkbox" name="crf_sub_oldcus_editcustomer" id="crf_sub_oldcus" value="5" <?= ($crf_sub_oldcus_editcustomer == '5') ? 'checked' : '' ?> onclick="return false">
                            <label for="my-input" class="form-check-label">แก้ไขข้อมูลลูกค้า</label>
                        </div>
                    </div>
                    <div class="col-md-3 form-group">
                        <div class="form-check">
                            <input class="form-check-input " type="checkbox" name="crf_sub_oldcus_changecredit" id="crf_sub_oldcus" value="3" <?= ($get_changecredit == '3') ? 'checked' : '' ?> onclick="return false">
                            <label for="my-input" class="form-check-label">ปรับ Credit term. เพิ่ม / ลด</label>
                        </div>
                    </div>
                    <div class="col-md-3 form-group">
                        <div class="form-check">
                            <input class="form-check-input " type="checkbox" name="crf_sub_oldcus_changefinance" id="crf_sub_oldcus" value="4" <?= ($get_changefinance == '4') ? 'checked' : '' ?> onclick="return false">
                            <label for="my-input" class="form-check-label">ปรับวงเงิน เพิ่ม / ลด</label>
                        </div>
                    </div>
                </div>




                <div class="row form-group p-2">
                    <div class="col-md-4 form-group">
                        <label for="">วันที่</label>
                        <input readonly type="text" name="crf_datecreate" id="crf_datecreate" class="form-control form-control-sm" value="{datenow}">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="">Customer code : &nbsp;</label>
                        <input type="text" name="edit_customercode" id="edit_customercode" class="form-control form-control-sm" readonly="false" value="{get_cuscode}">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="">Sales Reps : &nbsp;</label>
                        <input type="text" name="edit_salesreps" id="edit_salesreps" class="form-control form-control-sm" value="{edit_salesreps}">
                        <!-- <input type="text" name="edit_salesreps" id="edit_salesreps" class="form-control form-control-sm edit_salesrepsOld" value="{edit_salesrepsOld}"> -->
                        <div id="alert_salesreps"></div>
                    </div>
                </div>


                <hr>
                <h5 align="left"><u>CUSTOMER PROFILE</u></h5>

                <div class="row form-group">
                    <div class="col-md-8 form-group">
                        <label for="">ชื่อลูกค้า : &nbsp;</label>
                        <input type="text" name="edit_customername" id="edit_customername" class="form-control form-control-sm" value="{edit_cusname}">
                        <div id="alert_customername"></div>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="">วันที่ก่อตั้ง</label>
                        <input type="text" name="edit_cuscompanycreate" id="edit_cuscompanycreate" class="form-control form-control-sm" value="{edit_comcreate}" placeholder="วัน-เดือน-ปี">
                        <div id="alert_cuscompanycreate"></div>
                    </div>
                </div>


                <div class="row form-group">
                    <div class="col-md-6 form-group">
                        <label for="">เลขที่ผู้เสียภาษี</label>
                        <input type="text" name="edit_customertaxid" id="edit_customertaxid" class="form-control form-control-sm" value="{crfcus_taxid}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="">สาขา</label>
                        <input type="text" name="edit_customerbranch" id="edit_customerbranch" class="form-control form-control-sm" value="{crfcus_branch}">
                    </div>
                </div>


                <!-- Check ประเภทที่อยู่ -->
                <input hidden type="text" name="check_addtype" id="check_addtype" value="{edit_ivoicetype}">

                <div class="row form-group">
                    <div class="col-md-4">
                        <label for="">ที่อยู่สำหรับการเปิดใบกำกับภาษี : </label>
                    </div>

                    <div class="col-md-4 form-group">
                        <div class="form-check">
                            <input id="edit_addresstype1" class="form-check-input" type="radio" name="edit_addresstype" value="ตาม ภ.พ.20">
                            <label for="my-input" class="form-check-label">ตาม ภ.พ.20</label>
                        </div>
                    </div>
                    <div class="col-md-4 form-group">
                        <div class="form-check">
                            <input id="edit_addresstype2" class="form-check-input" type="radio" name="edit_addresstype" value="อื่นๆ">
                            <label for="my-input" class="form-check-label">อื่นๆ</label>
                        </div>
                    </div>
                </div>
                <div id="alert_addresstype"></div>


                <div class="row form-group">
                    <div class="col-md-12">
                        <textarea name="edit_addressname" id="edit_addressname" cols="30" rows="3" class="form-control">{edit_address}</textarea>
                        <div id="alert_addressname"></div>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-6 form-group">
                        <label for="">ผู้ติดต่อ</label>
                        <input type="text" name="edit_namecontact" id="edit_namecontact" class="form-control form-control-sm" value="{edit_contactname}">
                        <div id="alert_namecontact"></div>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="">เบอร์โทร</label>
                        <input type="text" name="edit_telcontact" id="edit_telcontact" class="form-control form-control-sm" value="{edit_contacttel}">
                        <div id="alert_telcontact"></div>
                    </div>
                </div>


                <div class="row form-group">
                    <div class="col-md-4 form-group">
                        <label for="">เบอร์แฟกซ์</label>
                        <input type="text" name="edit_faxcontact" id="edit_faxcontact" class="form-control form-control-sm" value="{edit_contactfax}">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="">อีเมล</label>
                        <input type="text" name="edit_emailcontact" id="edit_emailcontact" class="form-control form-control-sm" value="{edit_contactemail}">
                        <div id="alert_emailcontact"></div>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="">e-Tax อีเมล</label>
                        <input type="text" name="edit_etax_emailcontact" id="edit_etax_emailcontact" class="form-control form-control-sm" value="{edit_etax_contactemail}">
                        <div id="alert_emailcontact"></div>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="">ทุนจดทะเบียน</label>
                        <input type="text" name="edit_regiscost" id="edit_regiscost" class="form-control form-control-sm" value="{edit_regiscapital}">
                        <div id="alert_regiscost"></div>
                    </div>


                    <div class="col-md-6">
                        <!-- Get map url -->
                        <input hidden type="text" name="get_crf_mapurl_edit" id="get_crf_mapurl_edit" value="{crfcus_mapurl}">
                        <!-- Get map url -->

                        <div class="notEdit1">
                            <a href="javascript:void(0)"><i id="editMapUrl" class="fas fa-edit" style="color:orange"></i></a>&nbsp;&nbsp;<label for="">แผนที่ (ลิ้งจาก Googlemap) :</label>
                            <a href="{crfcus_mapurl}" target="_blank"><span><i class="fas fa-map-marked-alt" style="font-size:28px;color:green;"></i></span></a>
                        </div>

                        <div class="canEdit1" style="display:none;">
                            <label for="">แผนที่ (ลิ้งจาก Googlemap)</label>
                            <input type="text" name="crf_mapurl_edit" id="crf_mapurl_edit" class="form-control form-control-sm">
                        </div>

                    </div>

                    <div class="col-md-6">
                        <!-- Get map file -->
                        <input hidden type="text" name="get_crf_mapfile_edit" id="get_crf_mapfile_edit" value="{crfcus_mapfile}">
                        <!-- Get map file -->

                        <div class="notEdit2">
                            <a href="javascript:void(0)"><i id="editMapFile" class="fas fa-edit" style="color:orange"></i></a>&nbsp;&nbsp;<label for="">แนบไฟล์แผนที่ (jpg , png , pdf) :</label>
                            <a href="<?= base_url('upload/') ?>{crfcus_mapfile}" target="_blank" style="cursor: pointer;"><b>{crfcus_mapfile}</b></a>
                        </div>

                        <div class="canEdit2" style="display:none;">
                            <label for="">แนบไฟล์แผนที่ (jpg , png , pdf)</label>
                            <input type="file" name="crf_mapfile_edit" id="crf_mapfile_edit" class="form-control form-control-sm" accept=".pdf, .jpg, .png">
                        </div>

                    </div>


                </div><br>


                <!-- Check ประเภทบริษัท -->
                <input hidden type="text" name="check_comtype" id="check_comtype" value="{edit_comtype}">

                <label for="">
                    <h6><b><u>ประเภทบริษัท</u></b></h6>
                </label>
                <div class="row form-group">
                    <div class="col-md-4 form-group">
                        <input type="radio" name="crf_companytype" id="crf_companytype" class="crf_companytype1" value="1">
                        <label for="">บริษัทของคนไทย 100%</label>
                    </div>
                    <div class="col-md-4 form-group">
                        <input type="radio" name="crf_companytype" id="crf_companytype" class="crf_companytype2" value="2">
                        <label for="">บริษัทต่างประเทศ 100%</label>
                    </div>
                    <div class="col-md-4 form-group">
                        <input type="radio" name="crf_companytype" id="crf_companytype" class="crf_companytype3" value="3">
                        <label for="">บริษัทร่วมทุน</label>
                    </div>
                </div>
                <div id="alert_companytype"></div>


                <div id="companytype2" class="row form-group" style="display:none">
                    <div class="col-md-12">
                        <input type="text" name="crf_companytype2" id="crf_companytype2" class="form-control form-control-sm" placeholder="กรุณาระบุสัญชาติ" value="{get_comtype2}">
                    </div>
                </div>


                <div id="companytype3" class="row form-group" style="display:none">
                    <div class="col-md-3 form-inline">
                        <label for="">สัญชาติ :&nbsp;</label>
                        <input type="text" name="crf_companytype3_1_1" id="crf_companytype3_1_1" class="form-control form-control-sm" value="{get_comtype31}">
                    </div>
                    <div class="col-md-3 form-inline">
                        <input type="text" name="crf_companytype3_1_2" id="crf_companytype3_1_2" class="form-control form-control-sm" value="{get_comtype32}">
                        <label for="">&nbsp;%</label>
                    </div>
                    <div class="col-md-3 form-inline">
                        <label for="">สัญชาติ :&nbsp;</label>
                        <input type="text" name="crf_companytype3_2_1" id="crf_companytype3_2_1" class="form-control form-control-sm" value="{get_comtype33}">
                    </div>
                    <div class="col-md-3 form-inline">
                        <input type="text" name="crf_companytype3_2_2" id="crf_companytype3_2_2" class="form-control form-control-sm" value="{get_comtype34}">
                        <label for="">&nbsp;%</label>
                    </div>
                </div><br>


                <label for="">
                    <h6><b><u>บุคคลในแต่ละระดับบริหารที่สำคัญ</u></b></h6>
                </label>
                {editprimanage}
                <div id="priManage{crf_primanage_id}" class="row form-group newPrimanage mt-2 pt-2" style="background-color:#E8E8E8;" data-rowid="{crf_primanage_id}">
                    <div class="col-md-3 form-group">
                        <label for="">หน่วยงาน</label>
                        <input type="text" name="crf_primanage_dept[]" id="crf_primanage_dept" class="form-control form-control-sm" required value="{crf_primanage_dept}">
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="">ชื่อ-สกุล</label>
                        <input type="text" name="crf_primanage_name[]" id="crf_primanage_name" class="form-control form-control-sm" required value="{crf_primanage_name}">
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="">ตำแหน่ง</label>
                        <input type="text" name="crf_primanage_posi[]" id="crf_primanage_posi" class="form-control form-control-sm" required value="{crf_primanage_posi}">
                    </div>
                    <div class="col-md-2 form-group">
                        <label for="">อีเมล</label>
                        <input type="text" name="crf_primanage_email[]" id="crf_primanage_email" class="form-control form-control-sm" required value="{crf_primanage_email}">
                    </div>
                    <div class="col-md-1 form-group mt-4">
                        <button type="button" data-btnid="{crf_primanage_id}" class="btn btn-danger" id="remove_pri"><i class="fas fa-trash-alt"></i></button>
                    </div>
                </div>
                {/editprimanage}
                <div class="row newPrimanage">
                    <div class="col-md-12">
                        <button name="add_more_primanage" id="add_more_primanage" type="button" class="btn btn-success">เพิ่มรายการ</button>
                    </div>
                </div>
                <div id="showPrimanage"></div>
                <div id="alert_primanage"></div>
                <br>


                <!-- Check ประเภทธุรกิจ -->
                <input type="text" name="check_busitype" id="check_busitype" value="{edit_busitype}" style="display:none;">
                <label for="">
                    <h6><b><u>ประเภทของธุรกิจ</u></b></h6>
                </label>
                <div class="row form-group">
                    <div class="col-md-3 form-group">
                        <input type="radio" name="edit_typeofbussi" id="edit_typeofbussi" value="ผู้ผลิต" class="crf_typeofbussi1">
                        <label for="">ผู้ผลิต</label>
                    </div>
                    <div class="col-md-3 form-group">
                        <input type="radio" name="edit_typeofbussi" id="edit_typeofbussi" value="ผู้ค้า" class="crf_typeofbussi2">
                        <label for="">ผู้ค้า</label>
                    </div>
                </div>
                <div id="alert_typeofbussi"></div>


                <label for="">
                    <h6><b><u>กระบวนการผลิตหลักในการผลิตสินค้า</u></b></h6>
                </label>
                <div id="showoldprocesscus" class="row form-group oldprocesscus"></div>

                <div class="row form-group newprocesscus">
                    <?php foreach (getCusProcess() as $rs) {
                        $checked = "";
                        foreach (getProcess($crfcus_id)->result() as $rss) {
                            if ($rs->cuspro_id == $rss->crf_process_name) {
                                $checked = ' checked="" ';
                                continue;
                            }
                        }
                    ?>
                        <div class="col-md-6 ">
                            <input type="checkbox" name="crf_process[]" id="crf_process" value="<?= $rs->cuspro_id ?>" <?= $checked ?>>
                            <label for=""><?= $rs->cuspro_name ?></label>
                        </div>
                    <?php } ?>
                </div>

                <div id="alert_process"></div>
                <br>


                <label for="">
                    <h6><b><u>ผลิตภัณฑ์ของลูกค้า</u></b></h6>
                </label>
                <div class="row form-group">
                    <div class="col-md-12">
                        <textarea name="edit_crf_customer_products" id="edit_crf_customer_products" cols="30" rows="3" class="form-control">{crfcus_products}</textarea>
                    </div>
                </div>


                <label for="">
                    <h6><b><u>คาดการณ์ปริมาณการขาย</u></b></h6>
                </label>
                <div class="row form-group">
                    <div class="col-md-12">
                        <label for="">รายละเอียด</label>
                        <textarea name="edit_forecast" id="edit_forecast" cols="30" rows="4" class="form-control">{edit_forecast}</textarea>
                    </div>
                </div>
                <div id="alert_forecast"></div>
                <br>

                <section>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <label for="">หมายเหตุ</label>
                            <textarea name="edit_crf_textmemo" id="edit_crf_textmemo" cols="30" rows="1" class="form-control">{edit_textmemo}</textarea>
                        </div>
                    </div>
                </section>

                <label for="">
                    <h6><b><u>เอกสารที่จำเป็นในการขอเปิดวงเงินการค้า</u></b></h6>
                </label>


                <div class="row form-group" id="for_natural" style="display:none;">
                    <div class="col-md-4 form-group crf_file_person">
                        <label for="">สำเนาบัตรประชาชน</label><br>
                        <!-- แก้ไขการแสดงผล -->
                        <input hidden type="text" name="editcusoldpersonal" id="editcusoldpersonal" value="{get_personal}">
                        <input type="file" name="crf_file_person" id="crf_file_person" class="form-control form-control-sm" accept=".pdf, .jpg, .png">
                        <?php
                        $output = '';
                        if (substr($get_personal, -3) == "pdf" || substr($get_personal, -3) == "PDF") {
                            $output .= '
                        <span><a href="' . base_url("upload/") . $get_personal . '" target="_blank" style="cursor: pointer;"><b>' . $get_personal . '</b></a></span>
                        ';
                        } else {
                            $output .= '
                        <span><a id="edit_datafilePersonal" href="#" data-toggle="modal" data-target="#show_editfilePersonal" data_editfilepersonal="' . $get_personal . '" style="cursor: pointer;"><b>' . $get_personal . '</b></a></span>
                        ';
                        }
                        echo $output;
                        ?>

                        <!-- <span><a id="datafile1" href="#" data-toggle="modal" data-target="#show_file1" data_file1="<?= $file1 ?>"><b><?= $file1 ?></b></a></span> -->

                    </div>
                </div>


                <div class="row form-group" id="for_juristic">
                    <div class="col-md-4 form-group crf_file1">
                        <label for="">ภพ.20 / ภธ.09</label><br>
                        <input hidden type="text" name="get_crf_file1" id="get_crf_file1" value="{get_file1}">
                        <input type="file" name="crf_file1" id="crf_file1" class="form-control form-control-sm crf_file1_edit" accept=".jpg,.png,.pdf">
                        <?php
                        $file1 = $get_file1;
                        if (substr($file1, -3) == "pdf" || substr($file1, -3) == "PDF") {
                            echo '<a href="' . base_url('upload/') . $file1 . '" target="_blank" style="cursor: pointer;"><b>' . $file1 . '</b></a>';
                        } else {
                            echo '<a id="edit_datafile1" href="#" data-toggle="modal" data-target="#show_editfile1" data_editfile1="' . $file1 . '" style="cursor: pointer;"><b>' . $file1 . '</b></a>';
                        }
                        ?>
                        <div id="alert_file1"></div>
                    </div>
                    <div class="col-md-4 form-group crf_file2">
                        <label for="">หนังสือรับรอง</label><br>
                        <input hidden type="text" name="get_crf_file2" id="get_crf_file2" value="{get_file2}">
                        <input type="file" name="crf_file2" id="crf_file2" class="form-control form-control-sm crf_file2_edit" accept=".jpg,.png,.pdf">
                        <?php
                        $file2 = $get_file2;
                        if (substr($file2, -3) == "pdf" || substr($file2, -3) == "PDF") {
                            echo '<a href="' . base_url('upload/') . $file2 . '" target="_blank" style="cursor: pointer;"><b>' . $file2 . '</b></a>';
                        } else {
                            echo '<a id="edit_datafile2" href="#" data-toggle="modal" data-target="#show_editfile2" data_editfile2="' . $file2 . '" style="cursor: pointer;"><b>' . $file2 . '</b></a>';
                        }
                        ?>
                        <div id="alert_file2"></div>
                    </div>
                    <div class="col-md-4 form-group crf_file3">
                        <label for="">ข้อมูลทั่วไป</label><br>
                        <input hidden type="text" name="get_crf_file3" id="get_crf_file3" value="{get_file3}">
                        <input type="file" name="crf_file3" id="crf_file3" class="form-control form-control-sm crf_file3_edit" accept=".jpg,.png,.pdf">
                        <?php
                        $file3 = $get_file3;
                        if (substr($file3, -3) == "pdf" || substr($file3, -3) == "PDF") {
                            echo '<a href="' . base_url('upload/') . $file3 . '" target="_blank" style="cursor: pointer;"><b>' . $file3 . '</b></a>';
                        } else {
                            echo '<a id="edit_datafile3" href="#" data-toggle="modal" data-target="#show_editfile3" data_editfile3="' . $file3 . '" style="cursor: pointer;"><b>' . $file3 . '</b></a>';
                        }
                        ?>
                        <div id="alert_file3"></div>
                    </div>
                    <div class="col-md-4 form-group crf_file4">
                        <label for="">งบดุล</label><br>
                        <input hidden type="text" name="get_crf_file4" id="get_crf_file4" value="{get_file4}">
                        <input type="file" name="crf_file4" id="crf_file4" class="form-control form-control-sm crf_file4_edit" accept=".jpg,.png,.pdf">
                        <?php
                        $file4 = $get_file4;
                        if (substr($file4, -3) == "pdf" || substr($file4, -3) == "PDF") {
                            echo '<a href="' . base_url('upload/') . $file4 . '" target="_blank" style="cursor: pointer;"><b>' . $file4 . '</b></a>';
                        } else {
                            echo '<a id="edit_datafile4" href="#" data-toggle="modal" data-target="#show_editfile4" data_editfile4="' . $file4 . '" style="cursor: pointer;"><b>' . $file4 . '</b></a>';
                        }
                        ?>
                        <div id="alert_file4"></div>
                    </div>
                    <div class="col-md-4 crf_file5">
                        <label for="">งบกำไรขาดทุน</label><br>
                        <input hidden type="text" name="get_crf_file5" id="get_crf_file5" value="{get_file5}">
                        <input type="file" name="crf_file5" id="crf_file5" class="form-control form-control-sm crf_file5_edit" accept=".jpg,.png,.pdf">
                        <?php
                        $file5 = $get_file5;
                        if (substr($file5, -3) == "pdf" || substr($file5, -3) == "PDF") {
                            echo '<a href="' . base_url('upload/') . $file5 . '" target="_blank" style="cursor: pointer;"><b>' . $file5 . '</b></a>';
                        } else {
                            echo '<a id="edit_datafile5" href="#" data-toggle="modal" data-target="#show_editfile5" data_editfile5="' . $file5 . '" style="cursor: pointer;"><b>' . $file5 . '</b></a>';
                        }
                        ?>
                        <div id="alert_file5"></div>
                    </div>
                    <div class="col-md-4 crf_file6">
                        <label for="">วิเคราะห์ผลการดำเนินงาน</label>
                        <input hidden type="text" name="get_crf_file6" id="get_crf_file6" value="{get_file6}">
                        <input type="file" name="crf_file6" id="crf_file6" class="form-control form-control-sm crf_file6_edit" accept=".jpg,.png,.pdf">
                        <?php
                        $file6 = $get_file6;
                        if (substr($file6, -3) == "pdf" || substr($file6, -3) == "PDF") {
                            echo '<a href="' . base_url('upload/') . $file6 . '" target="_blank" style="cursor: pointer;"><b>' . $file6 . '</b></a>';
                        } else {
                            echo '<a id="edit_datafile6" href="#" data-toggle="modal" data-target="#show_editfile6" data_editfile6="' . $file6 . '" style="cursor: pointer;"><b>' . $file6 . '</b></a>';
                        }
                        ?>
                        <div id="alert_file6"></div>
                    </div>
                </div>


                <label for="">
                    <h6><b><u>Credit term</u></b></h6>
                </label>

                <div class="row change_credit" style="display:none">
                    <div class="col-md-6 form-group">
                        <?php
                            // เช็กว่ามี creditterm2 หรือไม่
                            $hasCreditTerm2 = !empty($crfcus_creditterm2);
                        ?>
                        <input type="checkbox" name="edit_crf_change_creditterm" id="edit_crf_change_creditterm" value="1" <?php echo $hasCreditTerm2 ? 'checked' : ''; ?>>
                        <label for="edit_crf_change_creditterm">ปรับ Credit term</label>
                    </div>
                    <div class="col-md-6 form-group">
                        <?php
                            // เช็กว่ามี Expected Date Payment หรือไม่
                            $hasExpectedPayment = !empty($crf_change_expected_date);
                        ?>
                        <input type="checkbox" name="edit_crf_change_expected_payment" id="edit_crf_change_expected_payment" value="1" <?php echo $hasExpectedPayment ? 'checked' : ''; ?>>
                        <label for="edit_crf_change_expected_payment">Expected Date Payment</label>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-4 form-group">

                        <!-- For Change CreditTerm method -->
                        <input hidden type="text" name="oldCreditTerm" id="edit_oldCreditTerm" value="{edit_creditterm}">

                        <label for="">รายการปัจจุบัน</label>
                        <input type="text" name="showCreditname" id="edit_showCreditname" value="{edit_creditname}" class="form-control" style="display:none;">
                        <select name="edit_crf_creditterm" id="edit_crf_creditterm" class="form-control">
                            <option value="{edit_creditterm}">{edit_creditname}</option>
                            {getCreditTerm}
                            <option value="{credit_id}">{credit_name}</option>
                            {/getCreditTerm}
                        </select>
                    </div>

                    <div class="col-md-4 form-group change_credit_detail">
                        <label for="">เงื่อนไข</label>
                        <select name="edit_crf_condition_credit" id="edit_crf_condition_credit" class="form-control">
                            <option value="{get_condition_credit}">{get_condition_credit}</option>
                            <option value="เพิ่ม">เพิ่ม</option>
                            <option value="ลด">ลด</option>
                        </select>
                        <div id="alert_edit_crf_condition_credit"></div>
                    </div>

                    <div class="col-md-4 form-group change_credit_detail">
                        <label for="">รายการใหม่</label>
                        <div id="edit_showNewCredit"></div>
                        <select name="showcredit2" id="edit_showcredit2" class="form-control showcredit2">
                            <option value="{get_creditterm2code}">{get_creditterm2name}</option>
                        </select>
                        <div id="alert_edit_showcredit2"></div>
                    </div>
                </div>
                <div id="alert_creditterm"></div>

            <!-- Customer Expected Date Payment Term -->
            <div class="row form-group expected_payment_section">
                <div class="col-md-6">
                    <?php
                        // เช็กว่าควร disabled หรือไม่ - เริ่มต้น disabled ถ้าไม่ได้ติ๊ก checkbox
                        $isDisabled = empty($crf_change_expected_date) ? 'disabled' : '';
                    ?>
                    <label for="crf_arcustdueid_edit">Customer Expected Date Payment Term</label>
                    <select name="crf_arcustdueid_edit" id="crf_arcustdueid_edit" class="form-control" <?php echo $isDisabled; ?>>
                        <option value="">-- เลือกกำหนดวันชำระ --</option>
                        <?php if (!empty($dueOptions)) : ?>
                            <?php foreach ($dueOptions as $due) : ?>
                                <option value="<?= $due->arcustdueid ?>" <?= ($crfcus_slc_arcustdueid == $due->arcustdueid) ? 'selected' : '' ?>>
                                    <?= $due->arcustdueid ?> | <?= $due->duedescription ?><?= $due->numsofdays !== null ? ' (' . (int) $due->numsofdays . ' วัน)' : '' ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <option value="">ไม่พบข้อมูลกำหนดชำระ</option>
                        <?php endif; ?>
                    </select>
                    <div id="alert_crf_arcustdueid_edit"></div>
                </div>
            </div>

                <hr>

                <!-- Check Condition bill -->
                <input hidden type="text" name="check_conditionbill" id="check_conditionbill" value="{edit_conditionbill}">

                <label for="">
                    <h6><b><u>เงื่อนไขการวางบิล</u></b></h6>
                </label>
                <div class="row form-group">
                    <div class="col-md-4">
                        <input type="radio" name="crf_condition_bill" id="crf_condition_bill" value="ส่งของพร้อมวางบิล" class="crf_condition_billv1">
                        <label for="">ส่งของพร้อมวางบิล</label>
                    </div>
                    <div class="col-md-4">
                        <input type="radio" name="crf_condition_bill" id="crf_condition_bill" value="วางบิลตามตาราง" class="crf_condition_billv2">
                        <label for="">วางบิลตามตาราง</label>
                    </div>
                    <div class="col-md-4">
                        <input type="radio" name="crf_condition_bill" id="crf_condition_bill" value="วางบิลทุกวันที่" class="crf_condition_billv3">
                        <label for="">วางบิลทุกวันที่</label>
                    </div>
                </div>
                <div id="alert_condition_bill"></div>

                <div class="row form-group crf_condition_bill2edit" style="display:none">
                    <div class="col-md-6">
                        <label for="">ตารางวางบิล</label><br>
                        <input hidden type="text" name="get_crf_file7" id="get_crf_file7" value="{get_file7}">
                        <?php
                        $file7 = $get_file7;
                        if (substr($file7, -3) == "pdf" || substr($file7, -3) == "PDF") {
                            echo '<a href="' . base_url('upload/') . $file7 . '" target="_blank" style="cursor: pointer;"><b>' . $file7 . '</b></a>';
                        } else {
                            echo '<a id="edit_datafile7" href="#" data-toggle="modal" data-target="#show_editfile7" data_editfile7="' . $file7 . '" style="cursor: pointer;"><b>' . $file7 . '</b></a>';
                        }
                        ?>
                        <input type="file" name="crf_file7" id="crf_file7" class="form-control form-control-sm newcustomer1" accept=".jpg,.png,.pdf">
                        <!-- <input type="text" name="crf_tablebill" id="crf_tablebill" class="form-control form-control-sm oldcustomer1" style="display:none"> -->
                    </div>
                    <div class="col-md-6">
                        <label for="">แผนที่ ที่ไปวางบิล</label><br>
                        <input hidden type="text" name="get_crf_file8" id="get_crf_file8" value="{get_file8}">
                        <?php
                        $file8 = $get_file8;
                        if (substr($file8, -3) == "pdf" || substr($file8, -3) == "PDF") {
                            echo '<a href="' . base_url('upload/') . $file8 . '" target="_blank" style="cursor: pointer;"><b>' . $file8 . '</b></a>';
                        } else {
                            echo '<a id="edit_datafile8" href="#" data-toggle="modal" data-target="#show_editfile8" data_editfile8="' . $file8 . '" style="cursor: pointer;"><b>' . $file8 . '</b></a>';
                        }
                        ?>
                        <input type="file" name="crf_file8" id="crf_file8" class="form-control form-control-sm newcustomer2" accept=".jpg,.png,.pdf">
                        <!-- <input type="text" name="crf_mapbill" id="crf_mapbill" class="form-control form-control-sm oldcustomer2" style="display:none"> -->
                    </div>
                </div>

                <div class="row form-group crf_condition_bill3" style="display:none">
                    <div class="col-md-6">
                        <label for="">ทุกวันที่</label>
                        <input type="text" name="crf_datebill" id="crf_datebill" class="form-control form-control-sm" maxlength="2" value="{get_datebill}">
                    </div>
                    <div class="col-md-6">
                        <label for="">แผนที่ ที่ไปวางบิล</label><br>
                        <input hidden type="text" name="get_crf_file9" id="get_crf_file9" value="{get_mapbill2}">
                        <input type="file" name="crf_file9" id="crf_file9" class="form-control form-control-sm newcustomer3" accept=".jpg,.png,.pdf">
                        <?php
                        $file9 = $get_mapbill2;
                        if (substr($file9, -3) == "pdf" || substr($file9, -3) == "PDF") {
                            echo '<a href="' . base_url('upload/') . $file9 . '" target="_blank" style="cursor: pointer;"><b>' . $file9 . '</b></a>';
                        } else {
                            echo '<a id="edit_datafile9" href="#" data-toggle="modal" data-target="#show_editfile9" data_editfile9="' . $file9 . '" style="cursor: pointer;"><b>' . $file9 . '</b></a>';
                        }
                        ?>
                        <!-- <input type="text" name="crf_mapbill2" id="crf_mapbill2" class="form-control form-control-sm oldcustomer3" style="display:none;"> -->
                    </div>
                </div><br>




                <!-- Check condition money -->
                <input hidden type="text" name="check_conditionmoney" id="check_conditionmoney" value="{edit_conditionmoney}">

                <label for="">
                    <h6><b><u>เงื่อนไขการรับชำระเงิน</u></b></h6>
                </label>
                <div class="row form-group">
                    <div class="col-md-4">
                        <input type="radio" name="edit_condition_money" id="edit_condition_money" value="โอนเงิน" class="crf_condition_moneyv1">
                        <label for="">โอนเงิน</label>
                    </div>
                    <div class="col-md-4">
                        <input type="radio" name="edit_condition_money" id="edit_condition_money" value="รับเช็ค" class="crf_condition_moneyv2">
                        <label for="">รับเช็ค</label>
                    </div>
                </div>
                <div id="alert_condition_money"></div>



                <div class="row form-group recive_cheuqe" style="display:none;">
                    <div class="col-md-6 form-group">
                        <label for="">แนบตารางวางบิล / รับเช็ค</label>
                        <input hidden type="text" name="get_cheuqetable" id="get_cheuqetable" value="{get_cheuqetable}">
                        <input type="file" name="crf_recive_cheuqetable" id="crf_recive_cheuqetable" class="form-control form-control-sm newcustomer4" accept=".jpg,.png,.pdf">
                        <span>
                            <b>
                                <a href="<?= base_url('upload/') ?>{get_cheuqetable}" target="_blank" style="cursor: pointer;">{get_cheuqetable}</a>
                            </b>
                        </span>
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="">ระบุรายละเอียด</label>
                        <textarea name="crf_recive_cheuqedetail" id="crf_recive_cheuqedetail" cols="30" rows="4" class="form-control form-control-sm">{get_cheuqedetail}</textarea>
                    </div>
                </div><br>




                <!-- Check finance -->
                <input hidden type="text" name="check_editfinance" id="check_editfinance" value="{edit_finance}">

                <label for="">
                    <h6><b><u>วงเงินการค้าและเงื่อนไขที่ขอเสนอ</u></b></h6>
                </label>
                <div class="row form-group">
                    <div class="col-md-4 from-group">
                        <input type="radio" name="crf_finance" id="crf_finance" value="ขอวงเงิน" class="crf_financev1">
                        <label for="">ขอวงเงิน</label>
                    </div>
                    <div class="col-md-4 from-group">
                        <input type="radio" name="crf_finance" id="crf_finance" value="ปรับวงเงิน" class="crf_financev2">
                        <label for="">ปรับวงเงิน</label>
                    </div>
                </div>


                <!-- สำหรับขอวงเงิน -->
                <div class="row form-group finance_request_detail" style="display:none;">
                    <div class="col-md-6">
                        <label for="">วงเงิน</label>
                        <input type="text" name="crf_finance_req_number" id="crf_finance_req_number" class="form-control form-control-sm" value="{edit_moneylimit}">
                        <input type="hidden" name="crf_finance_req_number_calc" id="crf_finance_req_number_calc" value="{edit_moneylimit}">
                    </div>
                </div>


                <!-- สำหรับปรับวงเงิน -->
                <div class="row form-group finance_change_detail calFinance" style="display:none;">
                    <div class="col-md-6 form-group">
                        <label for="">สถานะวงเงิน</label>
                        <select name="crf_finance_status" id="crf_finance_status" class="form-control form-control-sm">
                            <option value="{edit_crf_finance_status}">{edit_crf_finance_status}</option>
                            <option value="วงเงินชั่วคราว">วงเงินชั่วคราว</option>
                            <option value="วงเงินถาวร">วงเงินถาวร</option>
                        </select>
                        <div id="alert_crf_finance_status"></div>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="">สถานะการขอ</label>
                        <select name="crf_finance_change_status" id="crf_finance_change_status" class="form-control form-control-sm">
                            <option value="{edit_crf_finance_change_status}">{edit_crf_finance_change_status}</option>
                            <option value="เพิ่ม">เพิ่ม</option>
                            <option value="ลด">ลด</option>
                        </select>
                        <input hidden type="text" name="showChangeStatus" id="showChangeStatus">
                        <div id="alert_crf_finance_change_status"></div>
                    </div>
                    <!-- <div class="col-md-4 form-group">
                        <label for="">วงเงินเดิม</label>
                        <input type="number" name="crf_finance_change_old" id="crf_finance_change_old" class="form-control form-control-sm">
                    </div> -->

                    <div class="col-md-6 form-group">
                        <label for="">จำนวนที่ขอเพิ่ม / ลด</label>
                        <input type="text" name="crf_finance_change_number" id="crf_finance_change_number" class="form-control form-control-sm" pattern="[0-9,]*" inputmode="numeric" value="{edit_crf_finance_change_number}">
                        <div id="alert_crf_finance_change_number"></div>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="">รวมทั้งสิ้น</label>
                        <input readonly type="text" name="crf_finance_change_total" id="crf_finance_change_total" class="form-control form-control-sm" value="{edit_crf_finance_change_total}">
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="">เหตุผลในการขอปรับวงเงิน</label>
                        <textarea name="crf_finance_change_detail" id="crf_finance_change_detail" cols="30" rows="3" class="form-control">{edit_crf_finance_change_detail}</textarea>
                    </div>
                </div>

                <!-- เพิ่มหมายเหตุ 25-11-2025 -->
                 <div class="row">
                    <div class="col-md-12">
                        <label for="">หมายเหตุเพิ่มเติม (ถ้ามี)</label>
                        <textarea name="crfcus_memo2_edit" id="crfcus_memo2_edit" cols="30" rows="3" class="form-control"><?=$crfcus_memo2?></textarea>
                    </div>
                 </div>
                <hr>



                <div class="row form-group">

                    <div class="col-md-4 form-group">
                        <label for="">ผู้บันทึกข้อมูล</label>
                        <input readonly type="text" name="crf_userpost" id="crf_userpost" class="form-control form-control-sm" value="<?= getUser()->Fname . "&nbsp;" . getUser()->Lname ?>">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="">แผนก</label>
                        <input readonly type="text" name="crf_userdeptpost" id="crf_userdeptpost" class="form-control form-control-sm" value="<?= getUser()->Dept ?>">
                        <input hidden type="text" name="crf_userdeptcodepost" id="crf_userdeptcodepost" value="<?= getUser()->DeptCode ?>">
                        <input hidden type="text" name="crf_userecodepost" id="crf_userecodepost" value="<?= getUser()->ecode ?>">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="">วันที่บันทึกข้อมูล</label>
                        <input readonly type="text" name="crf_userpostdatetime" id="crf_userpostdatetime" class="form-control form-control-sm" value="<?= date("d-m-Y H:i:s") ?>">
                    </div>
                </div>

                <!-- Customer id -->
                <input hidden type="text" name="getCustomerid_edit" id="getCustomerid_edit" value="{crfcus_id}">
                <!-- Crf ID -->
                <input hidden type="text" name="getCrfid_edit" id="getCrfid_edit" value="{get_crfid}">


                <div class="row form-group">
                    <div class="col-md-4"></div>
                    <div class="col-md-4"><button type="reset" class="btn btn-warning btn-block" id="user_reset" name="user_reset" onclick="return location.reload()">Reset</button></div>
                    <div class="col-md-4"><button type="submit" class="btn btn-info btn-block" id="user_edit" name="user_edit">Edit</button></div>
                </div>
                <hr>
            </form>

    <script>
        // ============================================================================
        // Utility Functions - Number Formatting
        // ============================================================================
        
        /**
         * Format number with comma separators
         * @param {String} value - Number string to format
         * @returns {String} Formatted number string
         */
        function formatNumberWithComma(value) {
            // Handle empty or invalid input
            if (!value) return '';
            
            // Remove existing commas first, then parse as number
            const cleanValue = String(value).replace(/,/g, '');
            const numValue = parseFloat(cleanValue) || 0;
            
            // Format with comma, keeping decimals if they exist
            const parts = numValue.toString().split('.');
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            return parts.join('.');
        }
        
        /**
         * Setup comma formatting for input fields
         * @param {String} selector - jQuery selector for input fields
         */
        function setupCommaFormatting(selector) {
            $(selector).on('keyup', function(event) {
                // Skip for arrow keys
                if (event.which >= 37 && event.which <= 40) return;
                
                $(this).val(function(index, value) {
                    return formatNumberWithComma(value);
                });
            });
        }
        
        $(document).ready(function() {
            // ============================================================================
            // Check for Success Message from URL Parameter
            // ============================================================================
            
            // Get URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            const successMsg = urlParams.get('success');
            const editMsg = urlParams.get('edited');
            
            // Show success alert if parameter exists
            if (successMsg === 'true' || editMsg === '1') {
                alert('บันทึกข้อมูลสำเร็จแล้ว!');
                
                // Optional: Remove parameter from URL without page reload
                if (window.history.replaceState) {
                    const cleanUrl = window.location.href.split('?')[0];
                    window.history.replaceState({}, document.title, cleanUrl);
                }
            }
            
            // ============================================================================
            // Billing and Payment Condition Handlers - Same as add_th.php
            // ============================================================================
            
            // Handle billing condition changes
            $('input:radio[name="crf_condition_bill"]').change(function () {
                if ($(this).val() == "ส่งของพร้อมวางบิล") {
                    $(".crf_condition_bill2edit, .crf_condition_bill3").css("display", "none");
                } else if ($(this).val() == "วางบิลตามตาราง") {
                    $(".crf_condition_bill2edit").css("display", "");
                    $(".crf_condition_bill3").css("display", "none");
                } else if ($(this).val() == "วางบิลทุกวันที่") {
                    $(".crf_condition_bill2edit").css("display", "none");
                    $(".crf_condition_bill3").css("display", "");
                }
            });

            // Handle payment condition changes
            $('input:radio[name="edit_condition_money"]').change(function () {
                if ($(this).val() == "โอนเงิน") {
                    $(".recive_cheuqe").css("display", "none");
                } else if ($(this).val() == "รับเช็ค") {
                    $(".recive_cheuqe").css("display", "");
                }
            });

            // Initialize condition displays based on pre-selected values
            var selectedBilling = $('input:radio[name="crf_condition_bill"]:checked').val();
            var storedBilling = $('#check_conditionbill').val();
            var selectedPayment = $('input:radio[name="edit_condition_money"]:checked').val();
            var storedPayment = $('#check_conditionmoney').val();
            
            // Set billing condition radio buttons and displays based on stored value
            if (storedBilling) {
                $('input:radio[name="crf_condition_bill"][value="' + storedBilling + '"]').prop('checked', true);
                selectedBilling = storedBilling;
                console.log('Setting billing condition to:', storedBilling);
            }
            
            console.log('Current selected billing condition:', selectedBilling);
            console.log('Stored billing condition:', storedBilling);
            
            if (selectedBilling == "ส่งของพร้อมวางบิล") {
                $(".crf_condition_bill2edit, .crf_condition_bill3").css("display", "none");
            } else if (selectedBilling == "วางบิลตามตาราง") {
                $(".crf_condition_bill2edit").css("display", "");
                $(".crf_condition_bill3").css("display", "none");
            } else if (selectedBilling == "วางบิลทุกวันที่") {
                $(".crf_condition_bill2edit").css("display", "none");
                $(".crf_condition_bill3").css("display", "");
            }

            // Set payment condition radio buttons and displays based on stored value
            if (storedPayment) {
                $('input:radio[name="edit_condition_money"][value="' + storedPayment + '"]').prop('checked', true);
                selectedPayment = storedPayment;
            }
            
            if (selectedPayment == "โอนเงิน") {
                $(".recive_cheuqe").css("display", "none");
            } else if (selectedPayment == "รับเช็ค") {
                $(".recive_cheuqe").css("display", "");
            }
            
            // ============================================================================
            // Setup Comma Formatting for Financial Fields
            // ============================================================================
            
            // Format registered capital field
            setupCommaFormatting('input[name="edit_regiscost"]');
            
            // Format finance request number
            setupCommaFormatting('input[name="crf_finance_req_number"]');
            
            // Format finance change number
            setupCommaFormatting('input[name="crf_finance_change_number"]');
            
            // ============================================================================
            // Sync Finance Request Number (Display vs Calc)
            // ============================================================================
            
            $('input[name="crf_finance_req_number"]').on('keyup change blur input', function() {
                // Remove commas and store in the _calc field
                var valueWithoutComma = $(this).val().replace(/,/g, '');
                $('#crf_finance_req_number_calc').val(valueWithoutComma);
            });
            
            // ============================================================================
            // Calculate Finance Change Total (Auto-calculate เพิ่ม/ลด)
            // ============================================================================
            
            $('#crf_finance_change_number').on('keyup change blur', function(event) {
                // Skip for arrow keys
                if (event.which >= 37 && event.which <= 40) return;
                
                // Get old money (วงเงินเดิม) from calc field
                var oldmoneyStr = $('#crf_finance_req_number_calc').val().replace(/,/g, '');
                var newmoneyStr = $(this).val().replace(/,/g, '');
                
                var oldmoney = parseInt(oldmoneyStr) || 0;
                var newmoney = parseInt(newmoneyStr) || 0;
                
                var totalAmount = 0;
                var changeStatus = $('#crf_finance_change_status').val();
                
                if (changeStatus == "เพิ่ม") {
                    totalAmount = oldmoney + newmoney;
                } else if (changeStatus == "ลด") {
                    totalAmount = oldmoney - newmoney;
                }
                
                // Format with commas and update total field
                var formattedTotal = totalAmount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                $('#crf_finance_change_total').val(formattedTotal);
            });
            
            // Recalculate when change status changes
            $('#crf_finance_change_status').on('change', function() {
                $('#showChangeStatus').val($(this).val());
                $('#crf_finance_change_number').trigger('keyup');
            });
            
            // ============================================================================
            // Credit Term Change Handler
            // ============================================================================
            
            $('#crf_condition_credit').change(function() {
                var oldCredit = $('#crf_creditterm').val();
                var creditMethod = $('#crf_condition_credit').val();
                if (oldCredit != '') {
                    $.ajax({
                        url: "<?php echo base_url(); ?>main/filterCreditTerm",
                        method: "POST",
                        data: {
                            oldCredit: oldCredit,
                            creditMethod: creditMethod
                        },
                        success: function(data) {
                            $('#showcredit2').html(data);
                        }
                    })
                }
            });
            
            // ============================================================================
            // Company Create Date Validation
            // ============================================================================
            
            $(document).on('keyup', '#edit_cuscompanycreate', function(){
                let regex = /^(0?[1-9]|[12][0-9]|3[01])-(0?[1-9]|1[0-2])-\d{4}$/;
                let input = $(this);
                
                if(regex.test(input.val()) === true){
                    input.css({
                        'border-color': '#009900',
                        'border-width': '2px'
                    });
                } else {
                    input.css({
                        'border-color': '#CC0000',
                        'border-width': '2px'
                    });
                }
            });
            
            // ============================================================================
            // Form Submit Handler - Sync Values and Debug
            // ============================================================================
            
            $('#form1').on('submit', function(e) {
                // Sync finance request number one more time before submit
                var financeDisplay = $('#crf_finance_req_number').val();
                var financeCalc = financeDisplay.replace(/,/g, '');
                $('#crf_finance_req_number_calc').val(financeCalc);
                
                // Debug: Log condition values before submit
                var selectedBilling = $('input:radio[name="crf_condition_bill"]:checked').val();
                var selectedPayment = $('input:radio[name="edit_condition_money"]:checked').val();
                var isBillingDisabled = $('input:radio[name="crf_condition_bill"]').first().prop('disabled');
                var isPaymentDisabled = $('input:radio[name="edit_condition_money"]').first().prop('disabled');
                
                console.log('=== FORM SUBMIT DEBUG ===');
                console.log('Form submit - Selected billing condition:', selectedBilling);
                console.log('Form submit - Billing disabled:', isBillingDisabled);
                console.log('Form submit - Selected payment condition:', selectedPayment);
                console.log('Form submit - Payment disabled:', isPaymentDisabled);
                console.log('Form submit - Finance Display:', financeDisplay, 'Finance Calc:', financeCalc);
                console.log('========================');
                
                // Only validate billing/payment conditions if they are enabled
                // (i.e., "แก้ไขข้อมูลลูกค้า" checkbox is selected)
                if (!isBillingDisabled && !selectedBilling) {
                    alert('กรุณาเลือกเงื่อนไขการวางบิล');
                    e.preventDefault();
                    return false;
                }
                
                if (!isPaymentDisabled && !selectedPayment) {
                    alert('กรุณาเลือกเงื่อนไขการรับชำระเงิน');
                    e.preventDefault();
                    return false;
                }
                
                // Form is valid, allow submission
                console.log('✓ Form validation passed, submitting...');
            });
        });
    </script>

    <!-- Load Edit View Control Module -->
    <!-- Main controller: locks fields, enables sections, handles credit term logic -->
    <script src="<?= base_url('assets/js/edit_view/edit_view.js?v=') . filemtime('assets/js/edit_view/edit_view.js') ?>"></script>