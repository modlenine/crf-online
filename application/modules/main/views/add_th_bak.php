<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <script type="text/javascript">
            function noBack(){
                window.history.forward()
            }
             
            noBack();
            window.onload = noBack;
            window.onpageshow = function(evt) { if (evt.persisted) noBack() }
            window.onunload = function() { void (0) }
        </script> -->
</head>

<body>
    <div class="container bg-white p-3">


        <div class="mt-3 p-3" style="border:solid #ccc 1px; background-color:#F8F8FF;">
            <form action="<?= base_url('main/savedata') ?>" method="POST" id="form1" enctype="multipart/form-data">

                <!-- Document Head -->
                <div class="row form-group">
                    <div align="left" class="col-md-6">
                        <h3>CREDIT REQUEST FORM</h3>
                    </div>
                    <div align="right" class="col-md-6">
                        <h5>{getFormCode}</h5>
                    </div>
                </div>

                <!-- Check area add page internal -->
                <input hidden type="text" name="addThArea" id="addThArea">

                <!-- Chose Company -->
                <div id="alert_company"></div>
                <div class="row form-group mt-3 p-2">
                    <div class="col-md-4 form-group">
                        <div class="form-check">
                            <input id="crf_company_sln" class="form-check-input" type="radio" name="crf_company" value="sln">
                            <label for="my-input" class="form-check-label">Salee Colour Public Company Limited.</label>
                        </div>
                    </div>
                    <div class="col-md-4 form-group">
                        <div class="form-check">
                            <input id="crf_company_poly" class="form-check-input" type="radio" name="crf_company" value="poly">
                            <label for="my-input" class="form-check-label">Poly Meritasia Co.,Ltd.</label>
                        </div>
                    </div>
                    <div class="col-md-4 form-group">
                        <div class="form-check">
                            <input id="crf_company_ca" class="form-check-input" type="radio" name="crf_company" value="ca">
                            <label for="my-input" class="form-check-label">Composite Asia Co.,Ltd</label>
                        </div>
                    </div>
                </div>



                <div id="alert_custype"></div>
                <div class="row form-group p-2">
                    <div class="col-md-3 form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="crf_type" id="crf_type" value="1">
                            <label for="my-input" class="form-check-label">ลูกค้าใหม่</label>
                        </div>
                    </div>
                    <div class="col-md-3 form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="crf_type" id="crf_type" value="2">
                            <label for="my-input" class="form-check-label">ลูกค้าเดิม</label>
                        </div>
                    </div>
                </div>



                <div id="alert_crf_sub_oldcus"></div>
                <div class="row form-group p-2 suboldcustomer">
                    <div class="col-md-3 form-group">
                        <div class="form-check">
                            <input class="form-check-input " type="checkbox" name="crf_sub_oldcus_changearea" id="crf_sub_oldcus" value="1">
                            <label for="my-input" class="form-check-label">เปลี่ยนเขตการขาย</label>
                        </div>
                    </div>
                    <div class="col-md-3 form-group">
                        <div class="form-check">
                            <input class="form-check-input " type="checkbox" name="crf_sub_oldcus_changeaddress" id="crf_sub_oldcus" value="2">
                            <label for="my-input" class="form-check-label">เปลี่ยนที่อยู่</label>
                        </div>
                    </div>
                    <div class="col-md-3 form-group">
                        <div class="form-check">
                            <input class="form-check-input " type="checkbox" name="crf_sub_oldcus_editcustomer" id="crf_sub_oldcus" value="5">
                            <label for="my-input" class="form-check-label">แก้ไขข้อมูลลูกค้า</label>
                        </div>
                    </div>
                    <div class="col-md-3 form-group">
                        <div class="form-check">
                            <input class="form-check-input " type="checkbox" name="crf_sub_oldcus_changecredit" id="crf_sub_oldcus" value="3">
                            <label for="my-input" class="form-check-label">ปรับ Credit term. เพิ่ม / ลด</label>
                        </div>
                    </div>
                    <div class="col-md-3 form-group">
                        <div class="form-check">
                            <input class="form-check-input " type="checkbox" name="crf_sub_oldcus_changefinance" id="crf_sub_oldcus" value="4">
                            <label for="my-input" class="form-check-label">ปรับวงเงิน เพิ่ม / ลด</label>
                        </div>
                    </div>
                </div>




                <div class="row form-group p-2">
                    <div class="col-md-4 form-group">
                        <label for="">วันที่</label>
                        <input readonly type="text" name="crf_datecreate" id="crf_datecreate" class="form-control form-control-sm" value="<?= date("d-m-Y") ?>">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="">Customer code : &nbsp;</label>
                        <input type="text" name="crf_customercode" id="crf_customercode" class="form-control form-control-sm" readonly="false">
                        <input type="text" name="crf_cusid" id="crf_cusid" style="display:none;">
                        <div id="autoCusCode"></div>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="">Sales Reps : &nbsp;</label>
                        <input type="text" name="crf_salesreps" id="crf_salesreps" class="form-control form-control-sm">
                        <div id="alert_salesreps"></div>
                    </div>
                </div>


                <hr>
                <h5 align="left"><u>CUSTOMER PROFILE</u></h5>

                <div class="row form-group">
                    <div class="col-md-8 form-group">
                        <label for="">ชื่อลูกค้า : &nbsp;</label>
                        <input type="text" name="crf_customername" id="crf_customername" class="form-control form-control-sm">
                        <div id="autoCusname"></div>
                        <div id="alert_customername"></div>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="">วันที่ก่อตั้ง</label>
                        <input type="date" name="crf_cuscompanycreate" id="crf_cuscompanycreate" class="form-control form-control-sm">
                        <div id="alert_cuscompanycreate"></div>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-6 form-group">
                        <label for="">เลขที่ผู้เสียภาษี</label>
                        <input type="text" name="crf_customertaxid" id="crf_customertaxid" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="">สาขา</label>
                        <input type="text" name="crf_customerbranch" id="crf_customerbranch" class="form-control form-control-sm">
                    </div>
                </div>


                <div class="row form-group">
                    <div class="col-md-4">
                        <label for="">ที่อยู่สำหรับการเปิดใบกำกับภาษี : </label>
                    </div>

                    <div class="col-md-4 form-group">
                        <div class="form-check">
                            <input id="crf_addresstype1" class="form-check-input" type="radio" name="crf_addresstype" value="ตาม ภ.พ.20">
                            <label for="my-input" class="form-check-label">ตาม ภ.พ.20</label>
                        </div>
                    </div>
                    <div class="col-md-4 form-group">
                        <div class="form-check">
                            <input id="crf_addresstype2" class="form-check-input" type="radio" name="crf_addresstype" value="อื่นๆ">
                            <label for="my-input" class="form-check-label">อื่นๆ</label>
                        </div>
                    </div>
                </div>
                <div id="alert_addresstype"></div>


                <div class="row form-group">
                    <div class="col-md-12">
                        <textarea name="crf_addressname" id="crf_addressname" cols="30" rows="3" class="form-control"></textarea>
                        <div id="alert_addressname"></div>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-6 form-group">
                        <label for="">ผู้ติดต่อ</label>
                        <input type="text" name="crf_namecontact" id="crf_namecontact" class="form-control form-control-sm">
                        <div id="alert_namecontact"></div>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="">เบอร์โทร</label>
                        <input type="text" name="crf_telcontact" id="crf_telcontact" class="form-control form-control-sm">
                        <div id="alert_telcontact"></div>
                    </div>
                </div>


                <div class="row form-group">
                    <div class="col-md-4 form-group">
                        <label for="">เบอร์แฟกซ์</label>
                        <input type="text" name="crf_faxcontact" id="crf_faxcontact" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="">อีเมล</label>
                        <input type="text" name="crf_emailcontact" id="crf_emailcontact" class="form-control form-control-sm">
                        <div id="alert_emailcontact"></div>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="">ทุนจดทะเบียน</label>
                        <input type="text" name="crf_regiscost" id="crf_regiscost" class="form-control form-control-sm">
                        <div id="alert_regiscost"></div>
                    </div>

                    <div class="col-md-6">
                        <!-- For not change -->
                        <input hidden type="text" name="getmapurl_addpage" id="getmapurl_addpage">
                        <!-- For not change -->
                        <div id="fromoldcus1" style="display:none;">
                            <a href="javascript:void(0)"><i id="editMapUrl_addpage" class="fas fa-edit" style="color:orange;display:none;"></i></a>&nbsp;&nbsp;<label for="">แผนที่ (ลิ้งจาก Googlemap) :</label>
                            <a id="getlinkgooglemap" target="_blank"><span><i class="fas fa-map-marked-alt" style="font-size:28px;color:green;"></i></span></a>
                        </div>

                        <div id="foredit1">
                            <label for="">แผนที่ (ลิ้งจาก Googlemap)</label>
                            <input type="text" name="crf_mapurl" id="crf_mapurl" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- For not change -->
                        <input hidden type="text" name="getmapfile_addpage" id="getmapfile_addpage">
                        <!-- For not change -->
                        <div id="fromoldcus2" style="display:none;">
                            <a href="javascript:void(0)"><i id="editMapFile_addpage" class="fas fa-edit" style="color:orange;display:none;"></i></a>&nbsp;&nbsp;<label for="">แนบไฟล์แผนที่ (jpg , png , pdf) :</label>
                            <a id="mapfilelink" href="#" data-toggle="modal" data-target="#showmapfile" data_mapfile=""><span><i class="fas fa-map-marked-alt" style="font-size:28px;color:#FF6600;"></i></span></a>
                        </div>

                        <div id="foredit2">
                            <label for="">แนบไฟล์แผนที่ (jpg , png , pdf)</label>
                            <input type="file" name="crf_mapfile" id="crf_mapfile" class="form-control form-control-sm" accept=".pdf, .jpg, .png">
                        </div>

                    </div>

                </div><br>


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
                        <input type="text" name="crf_companytype2" id="crf_companytype2" class="form-control form-control-sm" placeholder="กรุณาระบุสัญชาติ">
                    </div>
                </div>


                <div id="companytype3" class="row form-group" style="display:none">
                    <div class="col-md-3 form-inline">
                        <label for="">สัญชาติ :&nbsp;</label>
                        <input type="text" name="crf_companytype3_1_1" id="crf_companytype3_1_1" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-3 form-inline">
                        <input type="text" name="crf_companytype3_1_2" id="crf_companytype3_1_2" class="form-control form-control-sm">
                        <label for="">&nbsp;%</label>
                    </div>
                    <div class="col-md-3 form-inline">
                        <label for="">สัญชาติ :&nbsp;</label>
                        <input type="text" name="crf_companytype3_2_1" id="crf_companytype3_2_1" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-3 form-inline">
                        <input type="text" name="crf_companytype3_2_2" id="crf_companytype3_2_2" class="form-control form-control-sm">
                        <label for="">&nbsp;%</label>
                    </div>
                </div><br>


                <label for="">
                    <h6><b><u>บุคคลในแต่ละระดับบริหารที่สำคัญ</u></b>&nbsp;&nbsp;<a href="javascript:void(0)"><i id="editPrimanage_addpage" class="fas fa-edit" style="color:orange;display:none;"></i></a></h6>
                </label>
                <input hidden type="text" name="checkprimanagenull" id="checkprimanagenull">
                <div id="priManage" class="row form-group newPrimanage">
                    <div class="col-md-3 form-group">
                        <label for="">หน่วยงาน</label>
                        <input type="text" name="crf_primanage_dept[]" id="crf_primanage_dept" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="">ชื่อ-สกุล</label>
                        <input type="text" name="crf_primanage_name[]" id="crf_primanage_name" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="">ตำแหน่ง</label>
                        <input type="text" name="crf_primanage_posi[]" id="crf_primanage_posi" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="">อีเมล</label>
                        <input type="text" name="crf_primanage_email[]" id="crf_primanage_email" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="row newPrimanage">
                    <div class="col-md-12">
                        <button name="add_more_primanage" id="add_more_primanage" type="button" class="btn btn-success">เพิ่มรายการ</button>
                    </div>
                </div>
                <div id="showPrimanage"></div>
                <div id="alert_primanage"></div>
                <br>


                <label for="">
                    <h6><b><u>ประเภทของธุรกิจ</u></b></h6>
                </label>
                <div class="row form-group">
                    <div class="col-md-3 form-group">
                        <input type="radio" name="crf_typeofbussi" id="crf_typeofbussi" value="ผู้ผลิต" class="crf_typeofbussi1">
                        <label for="">ผู้ผลิต</label>
                    </div>
                    <div class="col-md-3 form-group">
                        <input type="radio" name="crf_typeofbussi" id="crf_typeofbussi" value="ผู้ค้า" class="crf_typeofbussi2">
                        <label for="">ผู้ค้า</label>
                    </div>
                </div>
                <div id="alert_typeofbussi"></div>


                <label for="">
                    <h6><b><u>กระบวนการผลิตหลักในการผลิตสินค้า</u></b></h6>
                </label>
                <div id="showoldprocesscus" class="row form-group oldprocesscus"></div>
                <div class="row form-group newprocesscus">
                    {getCusProcess}
                    <div class="col-md-3 ">
                        <input type="checkbox" name="crf_process[]" id="crf_process" value="{cuspro_id}">
                        <label for="">{cuspro_name}</label>
                    </div>
                    {/getCusProcess}
                </div>
                <div id="alert_process"></div>
                <br>




                <label for="">
                    <h6><b><u>ผลิตภัณฑ์ของลูกค้า</u></b></h6>
                </label>
                <div class="row form-group">
                    <div class="col-md-12">
                        <textarea name="crf_customer_product" id="crf_customer_product" cols="30" rows="3" class="form-control"></textarea>
                    </div>
                </div>




                <label for="">
                    <h6><b><u>คาดการณ์ปริมาณการขาย</u></b></h6>
                </label>
                <div class="row form-group">
                    <div class="col-md-12">
                        <label for="">รายละเอียด</label>
                        <textarea name="crf_forecast" id="crf_forecast" cols="30" rows="4" class="form-control"></textarea>
                    </div>
                </div>
                <div id="alert_forecast"></div>
                <br>



                <label for="">
                    <h6><b><u>เอกสารที่จำเป็นในการขอเปิดวงเงินการค้า</u></b></h6>
                    <span style="color:red;">ไฟล์ต้องมีขนาดไม่เกิน 10MB และรองรับเฉพาะไฟล์ pdf , jpg , png เท่านั้น.</span>
                </label>
                <div class="row form-group">
                    <div class="col-md-4 form-group crf_file1">
                        <label for="">ภพ.20 / ภธ.09</label><br>
                        <input type="file" name="crf_file1" id="crf_file1" class="form-control form-control-sm" accept=".pdf, .jpg, .png">
                        <div id="alert_file1"></div>
                    </div>
                    <div class="col-md-4 form-group crf_file2">
                        <label for="">หนังสือรับรอง</label><br>
                        <input type="file" name="crf_file2" id="crf_file2" class="form-control form-control-sm" accept=".pdf, .jpg, .png">
                        <div id="alert_file2"></div>
                    </div>
                    <div class="col-md-4 form-group crf_file3">
                        <label for="">ข้อมูลทั่วไป</label><br>
                        <input type="file" name="crf_file3" id="crf_file3" class="form-control form-control-sm" accept=".pdf, .jpg, .png">
                        <div id="alert_file3"></div>
                    </div>
                    <div class="col-md-4 form-group crf_file4">
                        <label for="">งบแสดงฐานะทางการเงิน</label><br>
                        <input type="file" name="crf_file4" id="crf_file4" class="form-control form-control-sm" accept=".pdf, .jpg, .png">
                        <div id="alert_file4"></div>
                    </div>
                    <div class="col-md-4 crf_file5">
                        <label for="">งบกำไรขาดทุน</label><br>
                        <input type="file" name="crf_file5" id="crf_file5" class="form-control form-control-sm" accept=".pdf, .jpg, .png">
                        <div id="alert_file5"></div>
                    </div>
                    <div class="col-md-4 crf_file6">
                        <label for="">อัตราส่วนสภาพคล่อง</label>
                        <input type="file" name="crf_file6" id="crf_file6" class="form-control form-control-sm" accept=".pdf, .jpg, .png">
                        <div id="alert_file6"></div>
                    </div>
                </div>


                <label for="">
                    <h6><b><u>Credit term</u></b></h6>
                </label>

                <div class="row change_credit" style="display:none">
                    <div class="col-md-6 form-group change_credit">
                        <input type="checkbox" name="crf_change_creditterm" id="crf_change_creditterm" value="1">
                        <label for="">ปรับ Credit term</label>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-4 form-group">

                        <!-- For Change CreditTerm method -->
                        <input type="text" name="oldCreditTerm" id="oldCreditTerm" style="display:none;">
                        <label for="">โปรดเลือกรายการ</label>
                        <select name="crf_creditterm" id="crf_creditterm" class="form-control">
                            <option value=""></option>
                            {getCreditTerm}
                            <option value="{credit_id}">{credit_name}</option>
                            {/getCreditTerm}
                        </select>
                    </div>

                    <div class="col-md-4 form-group change_credit_detail" style="display:none">
                        <label for="">เงื่อนไข</label>
                        <select name="crf_condition_credit" id="crf_condition_credit" class="form-control">
                            <option value="">กรุณาเลือกรายการ</option>
                            <option value="เพิ่ม">เพิ่ม</option>
                            <option value="ลด">ลด</option>
                        </select>
                        <div id="alert_crf_condition_credit"></div>
                    </div>

                    <div class="col-md-4 form-group change_credit_detail" style="display:none">
                        <label for="">โปรดเลือกรายการ</label>
                        <div id="showNewCredit"></div>
                        <select name="showcredit2" id="showcredit2" class="form-control showcredit2">
                            <option value="">กรุณาเลือกรายการ</option>
                        </select>
                        <div id="alert_showcredit2"></div>
                    </div>
                </div>
                <div id="alert_creditterm"></div>

                <!-- <div class="row change_credit" style="display:none">
                    <div class="col-md-6 form-group change_credit">
                        <input type="checkbox" name="crf_change_creditterm" id="crf_change_creditterm" value="1">
                        <label for="">ปรับ Credit term</label>
                    </div>
                </div> -->

                <!-- <div class="row form-group change_credit_detail" style="display:none">
                    <div class="col-md-6 form-group change_credit_detail">
                        <label for="">เงื่อนไข</label>
                        <select name="crf_condition_credit" id="crf_condition_credit" class="form-control">
                            <option value="">กรุณาเลือกรายการ</option>
                            <option value="เพิ่ม">เพิ่ม</option>
                            <option value="ลด">ลด</option>
                        </select>
                    </div>

                    <div class="col-md-6 form-group change_credit_detail" style="display:none">
                        <label for="">โปรดเลือกรายการ</label>
                        <div id="showNewCredit"></div>
                        <select name="showcredit2" id="showcredit2" class="form-control showcredit2">
                            <option value="">กรุณาเลือกรายการ</option>
                        </select>
                    </div>
                </div> -->
                <br>



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

                <div class="row form-group crf_condition_bill2" style="display:none">
                    <div class="col-md-6">
                        <label for="">ตารางวางบิล</label><br>
                        <input type="file" name="crf_tablebill" id="crf_tablebill" class="form-control form-control-sm newcustomer1" accept=".jpg,.png,.pdf">
                        <input type="text" name="crf_tablebill" id="crf_tablebill" class="form-control form-control-sm oldcustomer1" style="display:none">
                    </div>
                    <div class="col-md-6">
                        <label for="">แผนที่ ที่ไปวางบิล</label><br>
                        <input type="file" name="crf_mapbill" id="crf_mapbill" class="form-control form-control-sm newcustomer2" accept=".jpg,.png,.pdf">
                        <input type="text" name="crf_mapbill" id="crf_mapbill" class="form-control form-control-sm oldcustomer2" style="display:none">
                    </div>
                </div>

                <div class="row form-group crf_condition_bill3" style="display:none">
                    <div class="col-md-6">
                        <label for="">ทุกวันที่</label>
                        <input type="text" name="crf_datebill" id="crf_datebill" class="form-control form-control-sm" maxlength="2">
                    </div>
                    <div class="col-md-6">
                        <label for="">แผนที่ ที่ไปวางบิล</label><br>
                        <input type="file" name="crf_mapbill2" id="crf_mapbill2" class="form-control form-control-sm newcustomer3" accept=".jpg,.png,.pdf">
                        <input type="text" name="crf_mapbill2" id="crf_mapbill2" class="form-control form-control-sm oldcustomer3" style="display:none;">
                    </div>
                </div><br>




                <label for="">
                    <h6><b><u>เงื่อนไขการรับชำระเงิน</u></b></h6>
                </label>
                <div class="row form-group">
                    <div class="col-md-4">
                        <input type="radio" name="crf_condition_money" id="crf_condition_money" value="โอนเงิน" class="crf_condition_moneyv1">
                        <label for="">โอนเงิน</label>
                    </div>
                    <div class="col-md-4">
                        <input type="radio" name="crf_condition_money" id="crf_condition_money" value="รับเช็ค" class="crf_condition_moneyv2">
                        <label for="">รับเช็ค</label>
                    </div>
                </div>
                <div id="alert_condition_money"></div>



                <div class="row form-group recive_cheuqe" style="display:none;">
                    <div class="col-md-6 form-group">
                        <label for="">แนบตารางวางบิล / รับเช็ค</label>
                        <input type="file" name="crf_recive_cheuqetable" id="crf_recive_cheuqetable" class="form-control form-control-sm newcustomer4" accept=".jpg,.png,.pdf">
                        <input type="text" name="crf_recive_cheuqetable" id="crf_recive_cheuqetable" class="form-control form-control-sm oldcustomer4" style="display:none;">
                        <div id="alert_recive_cheuqetable"></div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="">ระบุรายละเอียด</label>
                        <textarea name="crf_recive_cheuqedetail" id="crf_recive_cheuqedetail" cols="30" rows="4" class="form-control form-control-sm"></textarea>
                        <div id="alert_recive_cheuqedetail"></div>
                    </div>
                </div><br>




                <label for="">
                    <h6><b><u>วงเงินการค้าและเงื่อนไขที่ขอเสนอ</u></b></h6>
                </label>
                <div class="row form-group">
                    <input hidden type="text" name="value_crf_finance" id="value_crf_finance">

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
                        <input type="text" name="crf_finance_req_number" id="crf_finance_req_number" class="form-control form-control-sm">
                        <input hidden type="text" name="crf_finance_req_number_calc" id="crf_finance_req_number_calc">
                    </div>
                </div>


                <!-- สำหรับปรับวงเงิน -->
                <div class="row form-group finance_change_detail calFinance" style="display:none;">
                    <div class="col-md-6 form-group">
                        <label for="">สถานะวงเงิน</label>
                        <select name="crf_finance_status" id="crf_finance_status" class="form-control form-control-sm">
                            <option value=""></option>
                            <option value="วงเงินชั่วคราว">วงเงินชั่วคราว</option>
                            <option value="วงเงินถาวร">วงเงินถาวร</option>
                        </select>
                        <div id="alert_crf_finance_status"></div>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="">สถานะการขอ</label>
                        <select name="crf_finance_change_status" id="crf_finance_change_status" class="form-control form-control-sm">
                            <option value=""></option>
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
                        <input type="number" name="crf_finance_change_number" id="crf_finance_change_number" class="form-control form-control-sm">
                        <div id="alert_crf_finance_change_number"></div>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="">รวมทั้งสิ้น</label>
                        <input readonly type="text" name="crf_finance_change_total" id="crf_finance_change_total" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="">เหตุผลในการขอปรับวงเงิน</label>
                        <textarea name="crf_finance_change_detail" id="crf_finance_change_detail" cols="30" rows="3" class="form-control"></textarea>
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
                <div class="row form-group">
                    <div class="col-md-4"></div>
                    <div class="col-md-4"><button type="reset" class="btn btn-warning btn-block" id="user_reset" name="user_reset" onclick="return location.reload()">Reset</button></div>
                    <div class="col-md-4"><button type="submit" class="btn btn-info btn-block" id="user_submit" name="user_submit">Submit</button></div>
                </div>
                <hr>
            </form>




            <!-- Section สำหรับ CS , Sales Manager -->
            <form action="">
                <h6 class="author_manager"><b><u>สำหรับผู้จัดการ</u></b></h6>
                <div class="row form-group author_manager">
                    <div class="col-md-12">
                        <input type="radio" name="mgr_appro" id="mgr_appro" value="อนุมัติ">&nbsp;<label>อนุมัติ</label>&nbsp;&nbsp;
                        <input type="radio" name="mgr_appro" id="mgr_appro" value="ไม่อนุมัติ">&nbsp;<label>ไม่อนุมัติ</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <label>เหตุผลการอนุมัติ</label>
                        <textarea name="crf_mgrapprove_detail" id="crf_mgrapprovedetail" cols="30" rows="2" class="form-control"></textarea>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="">ผู้อนุมัติ</label>
                        <input type="text" name="crf_mgrapprove_name" id="crf_mgeapprove_name" class="form-control form-control-sm">
                        <input type="text" name="crf_mgrapprove_datetime" id="crf_mgrapprove_datetime" class="form-control form-control-sm mt-1" value="<?= date("d-m-Y H:i:s"); ?>">
                    </div>
                </div>
                <div class="row form-group author_manager">
                    <div class="col-md-4"></div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4"><button type="button" class="btn btn-info btn-block" id="mgr_submit" name="mgr_submit">Submit</button></div>
                </div>
                <hr class="author_manager">
            </form>
            <!-- Section สำหรับ CS , Sales Manager -->


        </div>
        <!-- กรอบฟอร์ม -->

    </div>

</body>



</html>