<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{title}</title>
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
            <form action="<?= base_url('customers/saveCustomer') ?>" method="POST" id="form1" enctype="multipart/form-data" autocomplete="off" class="needs-validation" novalidate>
<input hidden type="text" name="checkaddcuspage" id="checkaddcuspage" value="{checkurl}">
                <!-- Document Head -->
                <div class="row form-group">
                    <div align="left" class="col-md-6">
                        <h3>เพิ่มข้อมูลลูกค้า</h3>
                    </div>
                    <!-- <div align="right" class="col-md-6">
                        <h5>{getFormCode}</h5>
                    </div> -->
                </div>

                <!-- Check area add page internal -->
                <input hidden type="text" name="addThArea" id="addThArea">

                <!-- Chose Company -->
                <div id="alert_company"></div>
                <div class="row form-group mt-3 p-2">
                    <div class="col-md-4 form-group">
                        <div class="custom-radio custom-control">
                            <input type="radio" id="addcus_company_sln" name="addcus_company" class="custom-control-input" value="sln" required>
                            <label class="custom-control-label" for="addcus_company_sln">Salee Colour Public Company Limited.</label>
                        </div>
                    </div>
                    <div class="col-md-4 form-group">
                        <div class="custom-radio custom-control">
                            <input type="radio" id="addcus_company_poly" name="addcus_company" class="custom-control-input" value="poly" required>
                            <label class="custom-control-label" for="addcus_company_poly">Poly Meritasia Co.,Ltd.</label>
                        </div>
                    </div>
                    <div class="col-md-4 form-group">
                        <div class="custom-radio custom-control">
                            <input type="radio" id="addcus_company_ca" name="addcus_company" class="custom-control-input" value="ca" required>
                            <label class="custom-control-label" for="addcus_company_ca">Composite Asia Co.,Ltd.</label>
                        </div>
                    </div>
                    <div class="col-md-4 form-group">
                        <div class="custom-radio custom-control">
                            <input type="radio" id="addcus_company_tb" name="addcus_company" class="custom-control-input" value="tb" required>
                            <label class="custom-control-label" for="addcus_company_tb">The Bubbles Co.,Ltd.</label>
                        </div>
                    </div>
                </div>
                <div id="alert_addcus_company"></div>


                <div class="row form-group p-2">
                    <div class="col-md-3 form-group">
                        <div class="custom-radio custom-control">
                            <input type="radio" id="crf_person_type_natural" name="crf_person_type" class="custom-control-input" value="natural" required>
                            <label class="custom-control-label" for="crf_person_type_natural">บุคคลธรรมดา</label>
                        </div>
                    </div>
                    <div class="col-md-3 form-group">
                        <div class="custom-radio custom-control">
                            <input type="radio" id="crf_person_type_juristic" name="crf_person_type" class="custom-control-input" value="juristic" required>
                            <label class="custom-control-label" for="crf_person_type_juristic">นิติบุคคล</label>
                        </div>
                    </div>
                </div>


                <div class="row form-group p-2">
                    <div class="col-md-4 form-group">
                        <label for="">วันที่</label>
                        <input readonly type="text" name="addcus_datecreate" id="addcus_datecreate" class="form-control form-control-sm" value="<?= date("d-m-Y") ?>">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="">Customer code : &nbsp;</label>
                        <input type="text" name="addcus_customercode" id="addcus_customercode" class="form-control form-control-sm" required>
                        <div id="alertCuscode"></div>
                        <div id="autocuscodemanual"></div>
                    </div>
                    
                    <div class="col-md-4 form-group">
                        <label for="">Sales Reps : &nbsp;</label>
                        <input type="text" name="addcus_salesreps" id="addcus_salesreps" class="form-control form-control-sm" value="<?=getUser()->ecode?>">
                    </div>
                </div>


                <hr>
                <h5 align="left"><u>CUSTOMER PROFILE</u></h5>

                <div class="row form-group">
                    <div class="col-md-8 form-group">
                        <label for="">ชื่อลูกค้า : &nbsp;</label>
                        <input type="text" name="addcus_customername" id="addcus_customername" class="form-control form-control-sm" required>
                        <div id="autocuscodemanualname"></div>
                    </div>
                    <div class="col-md-4 form-group">
                        <label id="labelDateCreate">วันที่ก่อตั้ง</label>
                        <input type="text" name="addcus_cuscompanycreate" id="addcus_cuscompanycreate" data-zdp_readonly_element="false" class="form-control form-control-sm" placeholder="วัน-เดือน-ปี" required>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-6 form-group">
                        <label for="">เลขที่ผู้เสียภาษี</label>
                        <input type="text" name="addcus_customertaxid" id="addcus_customertaxid" class="form-control form-control-sm" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="">สาขา</label>
                        <input type="text" name="addcus_customerbranch" id="addcus_customerbranch" class="form-control form-control-sm" required>
                    </div>
                </div>


                <div class="row form-group">
                    <div class="col-md-4">
                        <label for="">ที่อยู่สำหรับการเปิดใบกำกับภาษี : </label>
                    </div>

                    <div class="col-md-4 form-group">
                        <div class="form-check">
                            <input id="addcus_addresstype1" class="form-check-input" type="radio" name="addcus_addresstype" value="ตาม ภ.พ.20" required>
                            <label for="my-input" class="form-check-label">ตาม ภ.พ.20</label>
                        </div>
                    </div>
                    <div class="col-md-4 form-group">
                        <div class="form-check">
                            <input id="addcus_addresstype2" class="form-check-input" type="radio" name="addcus_addresstype" value="อื่นๆ" required>
                            <label for="my-input" class="form-check-label">อื่นๆ</label>
                        </div>
                    </div>
                </div>


                <div class="row form-group">
                    <div class="col-md-12">
                        <textarea name="addcus_addressname" id="addcus_addressname" cols="30" rows="3" class="form-control" required></textarea>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-6 form-group">
                        <label for="">ผู้ติดต่อ</label>
                        <input type="text" name="addcus_namecontact" id="addcus_namecontact" class="form-control form-control-sm" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="">เบอร์โทร</label>
                        <input type="text" name="addcus_telcontact" id="addcus_telcontact" class="form-control form-control-sm" required>
                    </div>
                </div>


                <div class="row form-group">
                    <div class="col-md-4 form-group">
                        <label for="">เบอร์แฟกซ์</label>
                        <input type="text" name="addcus_faxcontact" id="addcus_faxcontact" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="">อีเมล</label>
                        <input type="text" name="addcus_emailcontact" id="addcus_emailcontact" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="">e-Tax อีเมล</label>
                        <input type="text" name="addcus_etax_emailcontact" id="addcus_etax_emailcontact" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="">ทุนจดทะเบียน</label>
                        <input type="text" name="addcus_regiscost" id="addcus_regiscost" class="form-control form-control-sm" required>
                    </div>

                    <div class="col-md-6">
                        <div id="">
                            <label for="">แผนที่ (ลิ้งจาก Googlemap)</label>
                            <input type="text" name="addcus_mapurl" id="addcus_mapurl" class="form-control form-control-sm" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div id="">
                            <label for="">แนบไฟล์แผนที่ (jpg , png , pdf)</label>
                            <input type="file" name="addcus_mapfile" id="addcus_mapfile" class="form-control form-control-sm" accept=".pdf, .jpg, .png">
                        </div>

                    </div>

                </div><br>


                <label for="">
                    <h6><b><u>ประเภทบริษัท</u></b></h6>
                </label>
                <div class="row form-group">
                    <div class="col-md-4 form-group">
                        <input type="radio" name="crf_companytype" id="crf_companytype1" class="crf_companytype1" value="1" required>
                        <label for="">บริษัทของคนไทย 100%</label>
                    </div>
                    <div class="col-md-4 form-group">
                        <input type="radio" name="crf_companytype" id="crf_companytype2" class="crf_companytype2" value="2" required>
                        <label for="">บริษัทต่างประเทศ 100%</label>
                    </div>
                    <div class="col-md-4 form-group">
                        <input type="radio" name="crf_companytype" id="crf_companytype3" class="crf_companytype3" value="3" required>
                        <label for="">บริษัทร่วมทุน</label>
                    </div>
                </div>


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
                    <h6><b><u>บุคคลในแต่ละระดับบริหารที่สำคัญ</u></b></h6>
                </label>
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
                <br>


                <label for="">
                    <h6><b><u>ประเภทของธุรกิจ</u></b></h6>
                </label>
                <div class="row form-group">
                    <div class="col-md-3 form-group">
                        <input type="radio" name="crf_typeofbussi" id="crf_typeofbussi" value="ผู้ผลิต" class="crf_typeofbussi1" required>
                        <label for="">ผู้ผลิต</label>
                    </div>
                    <div class="col-md-3 form-group">
                        <input type="radio" name="crf_typeofbussi" id="crf_typeofbussi" value="ผู้ค้า" class="crf_typeofbussi2" required>
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
                        <textarea name="addcus_customer_product" id="addcus_customer_product" cols="30" rows="3" class="form-control" required></textarea>
                    </div>
                </div>




                <label for="">
                    <h6><b><u>คาดการณ์ปริมาณการขาย</u></b></h6>
                </label>
                <div class="row form-group">
                    <div class="col-md-12">
                        <label for="">รายละเอียด</label>
                        <textarea name="addcus_forecast" id="addcus_forecast" cols="30" rows="4" class="form-control" required></textarea>
                    </div>
                </div>
                <div id="alert_forecast"></div>
                <br>



                <label for="">
                    <h6><b><u>เอกสารที่จำเป็นในการขอเปิดวงเงินการค้า</u></b></h6>
                    <span style="color:red;">ไฟล์ต้องมีขนาดไม่เกิน 10MB และรองรับเฉพาะไฟล์ pdf , jpg , png เท่านั้น.</span>
                </label>


                <div class="row form-group" id="for_natural_manual" style="display:none;">
                    <div class="col-md-4 form-group crf_file_person">
                        <label for="">สำเนาบัตรประชาชน</label><br>
                        <div id="cus2showfilePersonal"></div>
                        <input hidden type="text" name="editcusoldpersonal" id="editcusoldpersonal">
                        <input type="file" name="crf_file_person" id="crf_file_person" class="form-control form-control-sm" accept=".pdf, .jpg, .png" required="">
                        <div id="alert_file_person"></div>
                    </div>
                </div>


                <div class="row form-group" id="for_juristic_manual">
                    <div class="col-md-4 form-group crf_file1">
                        <label for="">ภพ.20 / ภธ.09</label><br>
                        <input type="file" name="addcus_file1" id="addcus_file1" class="form-control form-control-sm" accept=".pdf, .jpg, .png">
                    </div>
                    <div class="col-md-4 form-group crf_file2">
                        <label for="">หนังสือรับรอง</label><br>
                        <input type="file" name="addcus_file2" id="addcus_file2" class="form-control form-control-sm" accept=".pdf, .jpg, .png">
                    </div>
                    <div class="col-md-4 form-group crf_file3">
                        <label for="">ข้อมูลทั่วไป</label><br>
                        <input type="file" name="addcus_file3" id="addcus_file3" class="form-control form-control-sm" accept=".pdf, .jpg, .png" required="">
                    </div>
                    <div class="col-md-4 form-group crf_file4">
                        <label for="">งบดุล</label><br>
                        <input type="file" name="addcus_file4" id="addcus_file4" class="form-control form-control-sm" accept=".pdf, .jpg, .png" required="">
                    </div>
                    <div class="col-md-4 crf_file5">
                        <label for="">งบกำไรขาดทุน</label><br>
                        <input type="file" name="addcus_file5" id="addcus_file5" class="form-control form-control-sm" accept=".pdf, .jpg, .png" required="">
                    </div>
                    <div class="col-md-4 crf_file6">
                        <label for="">วิเคราะห์ผลการดำเนินงาน</label>
                        <input type="file" name="addcus_file6" id="addcus_file6" class="form-control form-control-sm" accept=".pdf, .jpg, .png" required="">
                    </div>
                </div>


                <label for="">
                    <h6><b><u>Credit term</u></b></h6>
                </label>
                <div class="row form-group">
                    <div class="col-md-4 form-group">

                        <label for="">โปรดเลือกรายการ</label>
                        <select name="addcus_creditterm" id="addcus_creditterm" class="form-control" required>
                            <option value=""></option>
                            {getCreditTerm}
                            <option value="{credit_id}">{credit_name}</option>
                            {/getCreditTerm}
                        </select>
                        <div id="alertOldCusCredit"></div>
                    </div>
                    
                </div>

                <br>



                <label for="">
                    <h6><b><u>เงื่อนไขการวางบิล</u></b></h6>
                </label>
                <div class="row form-group">
                    <div class="col-md-4">
                        <input type="radio" name="crf_condition_bill" id="crf_condition_bill" value="ส่งของพร้อมวางบิล" class="crf_condition_billv1" required="">
                        <label for="">ส่งของพร้อมวางบิล</label>
                    </div>
                    <div class="col-md-4">
                        <input type="radio" name="crf_condition_bill" id="crf_condition_bill" value="วางบิลตามตาราง" class="crf_condition_billv2" required="">
                        <label for="">วางบิลตามตาราง</label>
                    </div>
                    <div class="col-md-4">
                        <input type="radio" name="crf_condition_bill" id="crf_condition_bill" value="วางบิลทุกวันที่" class="crf_condition_billv3" required="">
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
                        <input type="radio" name="crf_condition_money" id="crf_condition_money" value="โอนเงิน" class="crf_condition_moneyv1" required="">
                        <label for="">โอนเงิน</label>
                    </div>
                    <div class="col-md-4">
                        <input type="radio" name="crf_condition_money" id="crf_condition_money" value="รับเช็ค" class="crf_condition_moneyv2" required="">
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
                        <input type="radio" name="crf_finance" id="crf_finance" value="ขอวงเงิน" class="crf_financev1" checked>
                        <label for="">ขอวงเงิน</label>
                    </div>
                </div>


                <!-- สำหรับขอวงเงิน -->
                <div class="row form-group finance_request_detail">
                    <div class="col-md-6">
                        <label for="">วงเงิน</label>
                        <input type="text" name="crf_finance_req_number" id="crf_finance_req_number" class="form-control form-control-sm" required>
                    </div>
                </div>




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
                    <div class="col-md-4"><button type="submit" class="btn btn-info btn-block" id="addcus_submit" name="addcus_submit">Submit</button></div>
                </div>
                <hr>
            </form>

            <script>
                // Example starter JavaScript for disabling form submissions if there are invalid fields
                (function() {
                    'use strict';
                    window.addEventListener('load', function() {
                        // Fetch all the forms we want to apply custom Bootstrap validation styles to
                        var forms = document.getElementsByClassName('needs-validation');
                        // Loop over them and prevent submission
                        var validation = Array.prototype.filter.call(forms, function(form) {
                            form.addEventListener('submit', function(event) {
                                if (form.checkValidity() === false) {
                                    event.preventDefault();
                                    event.stopPropagation();
                                }
                                form.classList.add('was-validated');
                            }, false);
                        });
                    }, false);
                })();
            </script>
        </div>
        <!-- กรอบฟอร์ม -->

    </div>

</body>

<script>

$(document).ready(function(){
    $('#addcus_cuscompanycreate').Zebra_DatePicker({
        format: 'd-m-Y'
    });
});

    function checkNullValue()
    {
        alert('test');
        return false;
    }

</script>


</html>