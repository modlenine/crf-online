<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer manual</title>
</head>

<body>

    <div class="container bg-white p-3">


        <div class="mt-3 p-3" style="border:solid #ccc 1px; background-color:#F8F8FF;">
            <form action="<?= base_url('customers/saveCustomerEx') ?>" method="POST" id="form1" enctype="multipart/form-data" autocomplete="off">
                <input hidden type="text" name="checkaddcuspageen" id="checkaddcuspageen" value="{geturl}">
                <!-- Document Head -->
                <div class="row form-group">
                    <div align="left" class="col-md-6">
                        <h3>CREDIT REQUEST FORM FOR EXPORT</h3>
                    </div>
                    <div align="right" class="col-md-6">

                    </div>
                </div>



                <div id="alert_crfex_company"></div>
                <div class="row form-group mt-3 p-2">
                    <div class="col-md-4 form-group">
                        <div class="custom-radio custom-control">
                            <input id="addcusex_company_sln" class="custom-control-input" type="radio" name="addcusex_company" value="sln">
                            <label for="addcusex_company_sln" class="custom-control-label">Salee Colour Public Company Limited.</label>
                        </div>
                    </div>
                    <div class="col-md-4 form-group">
                        <div class="custom-radio custom-control">
                            <input id="addcusex_company_poly" class="custom-control-input" type="radio" name="addcusex_company" value="poly">
                            <label for="addcusex_company_poly" class="custom-control-label">Poly Meritasia Co.,Ltd.</label>
                        </div>
                    </div>
                    <div class="col-md-4 form-group">
                        <div class="custom-radio custom-control">
                            <input id="addcusex_company_ca" class="custom-control-input" type="radio" name="addcusex_company" value="ca">
                            <label for="addcusex_company_ca" class="custom-control-label">Composite Asia Co.,Ltd</label>
                        </div>
                    </div>
                    <div class="col-md-4 form-group">
                        <div class="custom-radio custom-control">
                            <input id="addcusex_company_tb" class="custom-control-input" type="radio" name="addcusex_company" value="tb">
                            <label for="addcusex_company_tb" class="custom-control-label">The Bubbles Co.,Ltd.</label>
                        </div>
                    </div>
                </div>
                <div id="alert_addcusex_company"></div>




                <div class="row form-group">
                    <div class="col-md-4">
                        <label for="">Date</label>
                        <input readonly type="text" name="addcusex_datecreate" id="addcusex_datecreate" value="{datenow}" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-4">
                        <label for="">Customer code</label>
                        <input type="text" name="addcusex_customercode" id="addcusex_customercode" class="form-control form-control-sm" required>
                        <div id="alertCuscodeEx"></div>
                        <div id="autocuscodemanualex"></div>
                    </div>


                    <div class="col-md-4">
                        <label for="">Sales Reps</label>
                        <input type="text" name="addcusex_salesreps" id="addcusex_salesreps" class="form-control form-control-sm" required>
                    </div>
                </div>


                <hr>
                <h5 align="left"><u>CUSTOMER PROFILE</u></h5>

                <div class="row form-group">
                    <div class="col-md-6 form-group">
                        <label for="">Customer name (in English) : &nbsp;</label>
                        <input type="text" name="addcusex_cusnameEN" id="addcusex_cusnameEN" class="form-control form-control-sm" required>
                        <div id="autocuscodemanualnameex"></div>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="">Customer name (in Thai)</label>
                        <input type="text" name="addcusex_cusnameTH" id="addcusex_cusnameTH" class="form-control form-control-sm">
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-12">
                        <label for="">Address for invoicing</label>
                        <textarea name="addcusex_address" id="addcusex_address" cols="30" rows="3" class="form-control form-control-sm" required></textarea>
                    </div>
                </div>


                <div class="row form-group">
                    <div class="col-md-4">
                        <label for="">Tel</label>
                        <input type="text" name="addcusex_tel" id="addcusex_tel" class="form-control form-control-sm" required>
                    </div>
                    <div class="col-md-4">
                        <label for="">Fax</label>
                        <input type="text" name="addcusex_fax" id="addcusex_fax" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-4">
                        <label for="">Email</label>
                        <input type="text" name="addcusex_email" id="addcusex_email" class="form-control form-control-sm" required>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-6 crfex_newfile">
                        <label for="">File upload</label>
                        <input type="file" name="addcusex_file" id="addcusex_file" class="form-control form-control-sm">
                    </div>
                </div>


                <hr>
                <h5 align="left"><u>PROPOSE FOR CREDIT LIMIT , CREDIT TERM AND CONDITION.</u></h5>

                <div class="row form-group mt-3">
                    <div class="col-md-6">
                        <label for="">Payment</label>
                        <input type="text" name="addcusex_payment" id="addcusex_payment" class="form-control form-control-sm" required>
                    </div>
                </div>



                <label class="currentCredit">Current</label>
                <div class="row form-group currentCredit">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <input name="addcusex_creditlimit" id="addcusex_creditlimit" type="text" class="form-control" placeholder="Current credit limit." aria-label="Current credit limit." aria-describedby="basic-addon2" required>
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">THB</span>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-3">
                        <div class="input-group mb-3">
                            <input name="addcusex_term" id="addcusex_term" type="number" class="form-control" placeholder="Term" aria-label="Term" aria-describedby="basic-addon2" required>
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">days</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group mb-3">
                            <input name="addcusex_discount" id="addcusex_discount" type="number" class="form-control" placeholder="Discount" aria-label="Discount" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">%</span>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="row form-group">
                    <div class="col-md-12">
                        <label for="">Company background and reason for credit revision.</label>
                        <textarea name="addcusex_combg" id="addcusex_combg" cols="30" rows="3" class="form-control form-control-sm"></textarea>
                    </div>
                </div>


                <hr>
                <h5><u>FOR USER POST</u></h5>
                <div class="row form-group">
                    <div class="col-md-4">
                        <label for="">User post</label>
                        <input readonly type="text" name="addcusex_usercreate" id="addcusex_usercreate" class="form-control form-control-sm" value="{username}">
                        <input hidden type="text" name="addcusex_userecode" id="addcusex_userecode" value="{ecode}">
                    </div>
                    <div class="col-md-4">
                        <label for="">Dept.</label>
                        <input readonly type="text" name="addcusex_userdeptcodepost" id="addcusex_userdeptcodepost" class="form-control form-control-sm" value="{deptname}">
                        <input hidden type="text" name="addcusex_userdeptcode" id="addcusex_userdeptcode" value="{deptcode}">
                    </div>
                    <div class="col-md-4">
                        <label for="">Datetime</label>
                        <input readonly type="text" name="addcusex_userdatetime" id="addcusex_userdatetime" class="form-control form-control-sm" value="{datetimenow}">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4"></div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4"><button type="submit" name="addcusex_submit" id="addcusex_submit" class="btn btn-info btn-block">Submit</button></div>
                </div>






            </form>
        </div>
        <!-- กรอบฟอร์ม -->

    </div>




</body>

</html>