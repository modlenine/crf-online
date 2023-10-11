<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add new form export</title>
</head>

<body>

    <div class="container bg-white p-3">


        <h2 align="center">Credit Request Form Export</h2>

        <!-- Check all data for control page -->
        <input hidden type="text" name="checkStatusView" id="checkStatusView" value="{status}">
        <input hidden type="text" name="checkUserDeptView" id="checkUserDeptView" value="{deptcode}">
        <input hidden type="text" name="checkCusType" id="checkCusType" value="{customertype}">
        <input hidden type="text" name="checkCusPosi" id="checkCusPosi" value="{posi}">

        <hr>


        <div class="mt-3 p-3" style="border:solid #ccc 1px; background-color:#F8F8FF;">

            <!-- Document Head -->
            <div class="row form-group">
                <div align="left" class="col-md-6">
                    <h3>CREDIT REQUEST FORM FOR EXPORT</h3>
                </div>
                <div align="right" class="col-md-6">

                </div>
            </div>


            <input hidden type="text" name="checkPage" id="checkPage" value="viewdataEx">
            <input hidden type="text" name="check_crf_company" id="check_crf_company" value="<?= $result->crfexcus_area ?>">
            <div class="row form-group mt-3 p-2">
                <div class="col-md-4 form-group">
                    <div class="custom-radio custom-control">
                        <input id="crf_company_sln_view" class="custom-control-input" type="radio" name="crf_company_sln_view" value="sln">
                        <label for="crf_company_sln_view" class="custom-control-label">Salee Colour Public Company Limited.</label>
                    </div>
                </div>
                <div class="col-md-4 form-group">
                    <div class="custom-radio custom-control">
                        <input id="crf_company_poly_view" class="custom-control-input" type="radio" name="crf_company_poly_view" value="poly">
                        <label for="crf_company_poly_view" class="custom-control-label">Poly Meritasia Co.,Ltd.</label>
                    </div>
                </div>
                <div class="col-md-4 form-group">
                    <div class="custom-radio custom-control">
                        <input id="crf_company_ca_view" class="custom-control-input" type="radio" name="crf_company_ca_view" value="ca">
                        <label for="crf_company_ca_view" class="custom-control-label">Composite Asia Co.,Ltd</label>
                    </div>
                </div>
                <div class="col-md-4 form-group">
                    <div class="custom-radio custom-control">
                        <input id="crf_company_tb_view" class="custom-control-input" type="radio" name="crf_company_tb_view" value="tb">
                        <label for="crf_company_tb_view" class="custom-control-label">The Bubbles Co.,Ltd.</label>
                    </div>
                </div>
            </div>



            <div class="row form-group">
                <div class="col-md-6">
                    <label for="">Customer code</label>
                    <input readonly type="text" name="crfex_customercode_view" id="crfex_customercode_view" class="form-control form-control-sm" value="<?= $result->crfexcus_code ?>">
                </div>
                <div class="col-md-6">
                    <label for="">Sales Reps</label>
                    <input readonly type="text" name="crfex_salesreps_view" id="crfex_salesreps_view" class="form-control form-control-sm" value="<?= $result->crfexcus_salesreps ?>">
                </div>
            </div>


            <hr>
            <h5 align="left"><u>CUSTOMER PROFILE</u></h5>

            <div class="row form-group">
                <div class="col-md-6 form-group">
                    <label for="">Customer name (in English) : &nbsp;</label>
                    <input readonly type="text" name="crfex_cusnameEN" id="crfex_cusnameEN" class="form-control form-control-sm" value="<?= $result->crfexcus_nameEN ?>">
                </div>
                <div class="col-md-6 form-group">
                    <label for="">Customer name (in Thai)</label>
                    <input readonly type="text" name="crfex_cusnameTH" id="crfex_cusnameTH" class="form-control form-control-sm" value="<?= $result->crfexcus_nameTH ?>">
                </div>
            </div>

            <div class="row form-group">
                <div class="col-md-12">
                    <label for="">Address for invoicing</label>
                    <textarea readonly name="crfex_address" id="crfex_address" cols="30" rows="3" class="form-control form-control-sm"><?= $result->crfexcus_address ?></textarea>
                </div>
            </div>


            <div class="row form-group">
                <div class="col-md-4">
                    <label for="">Tel</label>
                    <input readonly type="text" name="crfex_tel" id="crfex_tel" class="form-control form-control-sm" value="<?= $result->crfexcus_tel ?>">
                </div>
                <div class="col-md-4">
                    <label for="">Fax</label>
                    <input readonly type="text" name="crfex_fax" id="crfex_fax" class="form-control form-control-sm" value="<?= $result->crfexcus_fax ?>">
                </div>
                <div class="col-md-4">
                    <label for="">Email</label>
                    <input readonly type="text" name="crfex_email" id="crfex_email" class="form-control form-control-sm" value="<?= $result->crfexcus_email ?>">
                </div>
            </div>


            <div class="row form-group">
                <div class="col-md-6">
                    <label for="">File upload</label><br>
                    <a id="fileExView" href="javascript:return void(0)" data-toggle="modal" data-target="#show_viewEx" data_file="<?= base_url('upload/export_pdf/') . $result->crfexcus_file ?>"><span id="crfex_fileShow"><?= $result->crfexcus_file ?></span></a>
                </div>
            </div>


            <hr>
            <h5 align="left"><u>PROPOSE FOR CREDIT LIMIT , CREDIT TERM AND CONDITION.</u></h5>

            <div class="row form-group mt-3">
                <div class="col-md-6">
                    <label for="">Payment</label>
                    <input readonly type="text" name="crfex_payment" id="crfex_payment" class="form-control" value="<?= $result->crfexcus_payment ?>">
                </div>
            </div>


            <label for="" class="">Current</label>
            <div class="row form-group ">
                <div class="col-md-6">

                    <div class="input-group mb-3">
                        <input readonly name="crfex_creditlimit2" id="crfex_creditlimit2" type="text" class="form-control" placeholder="Current credit limit." aria-label="Current credit limit." aria-describedby="basic-addon2" value="<?=$result->crfexcus_creditlimit?>">
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">THB</span>
                        </div>
                    </div>

                </div>
                <div class="col-md-3">
                    <div class="input-group mb-3">
                        <input readonly name="crfex_term2" id="crfex_term2" type="text" class="form-control" placeholder="Term" aria-label="Term" aria-describedby="basic-addon2" value="<?=$result->crfexcus_term?>">
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">days</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group mb-3">
                        <input readonly name="crfex_discount2" id="crfex_discount2" type="text" class="form-control" placeholder="Discount" aria-label="Discount" aria-describedby="basic-addon2" value="<?=$result->crfexcus_discount?>">
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">%</span>
                        </div>
                    </div>
                </div>
            </div>



            <div class="row form-group">
                <div class="col-md-12">
                    <label for="">Company background and reason for credit revision.</label>
                    <textarea readonly name="crfex_combg" id="crfex_combg" cols="30" rows="3" class="form-control form-control-sm"><?=$result->crfexcus_bg?></textarea>
                </div>
            </div>








        </div>
        <!-- กรอบฟอร์ม -->

    </div>




</body>

</html>