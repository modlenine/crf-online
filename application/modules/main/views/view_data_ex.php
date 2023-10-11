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
        <h4 align="center">{formcode}&nbsp;Status :<span>&nbsp;{status}</span></h4>

        <!-- Check all data for control page -->
        <input hidden type="text" name="checkStatusView" id="checkStatusView" value="{status}">
        <input hidden type="text" name="checkUserDeptView" id="checkUserDeptView" value="{deptcode}">
        <input hidden type="text" name="checkCusType" id="checkCusType" value="{customertype}">
        <input hidden type="text" name="checkCusPosi" id="checkCusPosi" value="{posi}">
        <input hidden type="text" name="checkUserEcodeEx" id="checkUserEcodeEx" value="<?=getUser()->ecode?>">

        <hr>
        <div id="btnEditZoneEx" class="row" style="display:none;">
            <div class="col-md-12">
                <a href="{crfex_editdata}"><button class="btn btn-warning mt-2">Edit Form</button></a>
                <a href="{crfex_cancelForm}"><button class="btn btn-danger mt-2" onclick="return confirm('คุณต้องการยกเลิกเอกสารนี้ใช่หรือไม่')">Cancel Form</button></a>
            </div>
        </div>

        <div class="mt-3 p-3" style="border:solid #ccc 1px; background-color:#F8F8FF;">

            <!-- Document Head -->
            <div class="row form-group">
                <div align="left" class="col-md-6">
                    <h3>CREDIT REQUEST FORM FOR EXPORT</h3>
                </div>
                <div align="right" class="col-md-6">
                    <h5>{formcode}</h5>
                </div>
            </div>


            <input hidden type="text" name="checkPage" id="checkPage" value="{checkpage}">
            <input style="display:none;" type="text" name="check_crf_company" id="check_crf_company" value="{company}">
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



            <!-- check customer type -->
            <input hidden type="text" name="check_crfex_custype" id="check_crfex_custype" value="{customertype}">

            <div class="row form-group mt-3 p-2">
                <div class="col-md-4 form-group">
                    <div class="custom-radio custom-control">
                        <input id="crfex_custype1v" class="custom-control-input" type="radio" name="crfex_custype1" value="newcustomer">
                        <label for="crfex_custype1v" class="custom-control-label">New customer.</label>
                    </div>
                </div>
                <div class="col-md-4 form-group">
                    <div class="custom-radio custom-control">
                        <input id="crfex_custype2v" class="custom-control-input" type="radio" name="crfex_custype2" value="currentcustomer">
                        <label for="crfex_custype2v" class="custom-control-label">Current customer.</label>
                    </div>
                </div>
            </div>


            <!-- Check Method -->
            <input hidden type="text" name="checkcurcustopic1" id="checkcurcustopic1" value="{crfex_curcustopic1}">
            <input hidden type="text" name="checkcurcustopic2" id="checkcurcustopic2" value="{crfex_curcustopic2}">

            <div class="row form-group mt-3 p-2 excurcusmethod" style="display:none;">
                    <div class="col-md-3 form-group">
                        <div class="form-check">
                            <input class="form-check-input " type="checkbox" name="crfex_curcustopic1" id="crfex_curcustopic1" value="1">
                            <label for="my-input" class="form-check-label">Change customer information.</label>
                        </div>
                    </div>
                    <div class="col-md-3 form-group">
                        <div class="form-check">
                            <input class="form-check-input " type="checkbox" name="crfex_curcustopic2" id="crfex_curcustopic2" value="1">
                            <label for="my-input" class="form-check-label">Change credit & term</label>
                        </div>
                    </div>
                </div>


            <div class="row form-group">
                <div class="col-md-4">
                    <label for="">Date</label>
                    <input readonly type="text" name="crfex_datecreate_view" id="crfex_datecreate_view" value="{datecreate}" class="form-control form-control-sm">
                </div>
                <div class="col-md-4">
                    <label for="">Customer code</label>
                    <input readonly type="text" name="crfex_customercode_view" id="crfex_customercode_view" class="form-control form-control-sm" value="{customercode}">
                </div>
                <div class="col-md-4">
                    <label for="">Sales Reps</label>
                    <input readonly type="text" name="crfex_salesreps_view" id="crfex_salesreps_view" class="form-control form-control-sm" value="{salesreps}">
                </div>
            </div>


            <hr>
            <h5 align="left"><u>CUSTOMER PROFILE</u></h5>

            <div class="row form-group">
                <div class="col-md-6 form-group">
                    <label for="">Customer name (in English) : &nbsp;</label>
                    <input readonly type="text" name="crfex_cusnameEN" id="crfex_cusnameEN" class="form-control form-control-sm" value="{customernameEN}">
                </div>
                <div class="col-md-6 form-group">
                    <label for="">Customer name (in Thai)</label>
                    <input readonly type="text" name="crfex_cusnameTH" id="crfex_cusnameTH" class="form-control form-control-sm" value="{customernameTH}">
                </div>
            </div>

            <div class="row form-group">
                <div class="col-md-12">
                    <label for="">Address for invoicing</label>
                    <textarea readonly name="crfex_address" id="crfex_address" cols="30" rows="3" class="form-control form-control-sm">{cusaddress}</textarea>
                </div>
            </div>


            <div class="row form-group">
                <div class="col-md-4">
                    <label for="">Tel</label>
                    <input readonly type="text" name="crfex_tel" id="crfex_tel" class="form-control form-control-sm" value="{tel}">
                </div>
                <div class="col-md-4">
                    <label for="">Fax</label>
                    <input readonly type="text" name="crfex_fax" id="crfex_fax" class="form-control form-control-sm" value="{fax}">
                </div>
                <div class="col-md-4">
                    <label for="">Email</label>
                    <input readonly type="text" name="crfex_email" id="crfex_email" class="form-control form-control-sm" value="{email}">
                </div>
            </div>


            <div class="row form-group">
                    <div class="col-md-6">
                        <label for="">File upload</label><br>
                        <a id="fileExView" href="javascript:return void(0)" data-toggle="modal" data-target="#show_viewEx" data_file="{fileAddress}"><span id="crfex_fileShow">{file}</span></a>
                    </div>
                </div>


            <hr>
            <h5 align="left"><u>PROPOSE FOR CREDIT LIMIT , CREDIT TERM AND CONDITION.</u></h5>

            <div class="row form-group mt-3">
                    <div class="col-md-6">
                        <label for="">Payment</label>
                        <input readonly type="text" name="crfex_payment" id="crfex_payment" class="form-control" value="{get_payment}">
                    </div>
                </div>

                <label for="" class="view_proposeCredit">Propose</label>
            <div class="row form-group view_proposeCredit">
                <div class="col-md-6">

                    <div class="input-group mb-3">
                        <input readonly name="crfex_creditlimit" id="crfex_creditlimit" type="text" class="form-control" placeholder="Propose credit limit." aria-label="Propose credit limit." aria-describedby="basic-addon2" value="{pcreditlimit}">
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">THB</span>
                        </div>
                    </div>

                </div>
                <div class="col-md-3">
                    <div class="input-group mb-3">
                        <input readonly name="crfex_term" id="crfex_term" type="text" class="form-control" placeholder="Term" aria-label="Term" aria-describedby="basic-addon2" value="{pterm}">
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">days</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group mb-3">
                        <input readonly name="crfex_discount" id="crfex_discount" type="text" class="form-control" placeholder="Discount" aria-label="Discount" aria-describedby="basic-addon2" value="{pdiscount}">
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">%</span>
                        </div>
                    </div>
                </div>
            </div>



            <label for="" class="view_currentCredit">Current</label>
            <div class="row form-group view_currentCredit">
                <div class="col-md-6">

                    <div class="input-group mb-3">
                        <input readonly name="crfex_creditlimit2" id="crfex_creditlimit2" type="text" class="form-control" placeholder="Current credit limit." aria-label="Current credit limit." aria-describedby="basic-addon2" value="{ccreditlimit}">
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">THB</span>
                        </div>
                    </div>

                </div>
                <div class="col-md-3">
                    <div class="input-group mb-3">
                        <input readonly name="crfex_term2" id="crfex_term2" type="text" class="form-control" placeholder="Term" aria-label="Term" aria-describedby="basic-addon2" value="{cterm}">
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">days</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group mb-3">
                        <input readonly name="crfex_discount2" id="crfex_discount2" type="text" class="form-control" placeholder="Discount" aria-label="Discount" aria-describedby="basic-addon2" value="{cdiscount}">
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">%</span>
                        </div>
                    </div>
                </div>
            </div>





                <!-- For condition -->
                <h5>Change</h5>
                <div class="row form-group creditlimitCondition_view" style="display:none;">
                    <div class="col-md-6">
                    <label for="">Condition of credit limit</label>
                        <select readonly name="creditlimit_condition" id="creditlimit_condition" class="form-control form-control-sm">
                            <option value="">{crfex_creditlimit_condition}</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                    <label for="">Condition of term</label>
                        <select readonly name="term_condition" id="term_condition" class="form-control form-control-sm">
                            <option value="">{crfex_term_condition}</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                    <label for="">Condition of discount</label>
                        <select readonly name="discount_condition" id="discount_condition" class="form-control form-control-sm">
                            <option value="">{crfex_discount_condition}</option>
                        </select>
                    </div>
                </div>

                <!-- For calculate -->
                <div class="row form-group calCurrentCus_view">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <input readonly name="cal_crfex_creditlimit2" id="cal_crfex_creditlimit2" type="text" class="form-control" placeholder="Request credit limit." aria-label="Request credit limit." aria-describedby="basic-addon2" value="{crfex_creditlimit_need}">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">THB</span>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-3">
                        <div class="input-group mb-3">
                            <input readonly name="cal_crfex_term2" id="cal_crfex_term2" type="number" class="form-control" placeholder="Request Term" aria-label="Request Term" aria-describedby="basic-addon2" value="{crfex_term_need}">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">days</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group mb-3">
                            <input readonly name="cal_crfex_discount2" id="cal_crfex_discount2" type="number" class="form-control" placeholder="Request Discount" aria-label="Request Discount" aria-describedby="basic-addon2" value="{crfex_discount_need}">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- For sum -->
                <h5>Total</h5>
                <div class="row form-group SumCurrentCus_view">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <input readonly name="sum_crfex_creditlimit2" id="sum_crfex_creditlimit2" type="text" class="form-control" placeholder="Summary credit limit." aria-label="CuSummaryrrent credit limit." aria-describedby="basic-addon2" value="{crfex_creditlimit_sum}">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">THB</span>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-3">
                        <div class="input-group mb-3">
                            <input readonly name="sum_crfex_term2" id="sum_crfex_term2" type="number" class="form-control" placeholder="Summary Term" aria-label="Summary Term" aria-describedby="basic-addon2" value="{crfex_term_sum}">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">days</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group mb-3">
                            <input readonly name="sum_crfex_discount2" id="sum_crfex_discount2" type="number" class="form-control" placeholder="Summary Discount" aria-label="Summary Discount" aria-describedby="basic-addon2" value="{crfex_discount_sum}">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">%</span>
                            </div>
                        </div>
                    </div>
                </div>








            <div class="row form-group">
                <div class="col-md-12">
                    <label for="">Company background and reason for credit revision.</label>
                    <textarea readonly name="crfex_combg" id="crfex_combg" cols="30" rows="3" class="form-control form-control-sm">{crfex_bg}</textarea>
                </div>
            </div>


            <label for="">History sales record ( previous 3 months )</label>
            <div class="row form-group">
                <div class="col-md-4">
                    <div class="input-group mb-3">
                        <input readonly name="crfex_month1" id="crfex_month1" type="text" class="form-control" placeholder="Month" aria-label="Month" aria-describedby="basic-addon2" value="{get_crfex_month1}">
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group mb-3">
                        <input readonly name="crfex_totalvolume1" id="crfex_totalvolume1" type="text" class="form-control" placeholder="Total volume" aria-label="Total volume" aria-describedby="basic-addon2" value="{get_crfex_totalvolume1}">
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">kg.</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group mb-3">
                        <input readonly name="crfex_totalsales1" id="crfex_totalsales1" type="text" class="form-control" placeholder="Total sales" aria-label="Total sales" aria-describedby="basic-addon2" value="{get_crfex_totalsales1}">
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">THB</span>
                        </div>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="input-group mb-3">
                        <input readonly name="crfex_month2" id="crfex_month2" type="text" class="form-control" placeholder="Month" aria-label="Month" aria-describedby="basic-addon2" value="{get_crfex_month2}">
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group mb-3">
                        <input readonly name="crfex_totalvolume2" id="crfex_totalvolume2" type="text" class="form-control" placeholder="Total volume" aria-label="Total volume" aria-describedby="basic-addon2" value="{get_crfex_totalvolume2}">
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">kg.</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group mb-3">
                        <input readonly name="crfex_totalsales2" id="crfex_totalsales2" type="text" class="form-control" placeholder="Total sales" aria-label="Total sales" aria-describedby="basic-addon2" value="{get_crfex_totalsales2}">
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">THB</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="input-group mb-3">
                        <input readonly name="crfex_month3" id="crfex_month3" type="text" class="form-control" placeholder="Month" aria-label="Month" aria-describedby="basic-addon2" value="{get_crfex_month3}">
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group mb-3">
                        <input readonly name="crfex_totalvolume3" id="crfex_totalvolume3" type="text" class="form-control" placeholder="Total volume" aria-label="Total volume" aria-describedby="basic-addon2" value="{get_crfex_totalvolume3}">
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">kg.</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group mb-3">
                        <input readonly name="crfex_totalsales3" id="crfex_totalsales3" type="text" class="form-control" placeholder="Total sales" aria-label="Total sales" aria-describedby="basic-addon2" value="{get_crfex_totalsales3}">
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">THB</span>
                        </div>
                    </div>
                </div>
            </div>


            <hr>
            <h6><b><u>FOR USER POST</u></b></h6>
            <div class="row form-group">
                <div class="col-md-4">
                    <label for="">User post</label>
                    <input readonly type="text" name="crfex_userpost" id="crfex_userpost" class="form-control form-control-sm" value="{userpost}">
                </div>
                <div class="col-md-4">
                    <label for="">Dept.</label>
                    <input readonly type="text" name="crfex_userdept" id="crfex_userdept" class="form-control form-control-sm" value="{userdept}">
                </div>
                <div class="col-md-4">
                    <label for="">Datetime</label>
                    <input readonly type="text" name="crfex_usercredatetime" id="crfex_usercredatetime" class="form-control form-control-sm" value="{userdatetime}">
                </div>
            </div>



            <!-- Sale manager & CS manager Section -->
            <form action="{exManagerApprove}" method="POST" name="" class="managerSection" style="display:none;">
                <hr>
                <h6><b><u>FOR SALES OR CS MANAGER APPROVE</u></b></h6>
                <!-- Check Zone -->
                <input hidden type="text" name="mgr_FormnoEx" id="mgr_FormnoEx" value="{crfex_formno}">
                <input hidden type="text" name="mgr_cusType" id="mgr_cusType" value="{customertype}">


                <div class="row form-group">
                    <div class="col-md-12 form-group">
                        <input type="radio" name="ex_mgrApprove" id="ex_mgrApprove" value="Approve">&nbsp;<label for="">Approve</label>&nbsp;&nbsp;
                        <input type="radio" name="ex_mgrApprove" id="ex_mgrApprove" value="Not approve">&nbsp;<label for="">Not approve</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <label for="">Reasons for approval.</label>
                        <textarea name="ex_mgrApproveDetail" id="ex_mgrApproveDetail" cols="30" rows="3" class="form-control form-control-sm"></textarea>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="">Approver.</label>
                        <input readonly type="text" name="ex_mgrApproveName" id="ex_mgrApproveName" class="form-control form-control-sm" value="{username}">
                        <input readonly type="text" name="ex_mgrApproveDateTime" id="ex_mgrApproveDateTime" class="form-control form-control-sm mt-1" value="{datenow}">
                    </div>
                </div>
                <div class="row form-group ">
                    <div class="col-md-4"></div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4"><button type="submit" class="btn btn-info btn-block" id="ex_mgrSubmit" name="ex_mgrSubmit">Submit</button></div>
                </div>
            </form>

            <form method="POST" name="" class="managerSection1" style="display:none;">
                <hr>
                <h6><b><u>FOR SALES OR CS MANAGER APPROVE</u></b></h6>
                <div class="row form-group">
                    <!-- check status after action -->
                <input hidden type="text" name="show_crfex_mgrapp_status" id="show_crfex_mgrapp_status" value="{show_crfex_mgrapp_status}">

                    <div class="col-md-12 form-group">
                        <input type="radio" name="ex_mgrApprove1" id="ex_mgrApprove1" value="Approve">&nbsp;<label for="">Approve</label>&nbsp;&nbsp;
                        <input type="radio" name="ex_mgrApprove2" id="ex_mgrApprove2" value="Not approve">&nbsp;<label for="">Not approve</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <label for="">Reasons for approval.</label>
                        <textarea readonly name="ex_mgrApproveDetail" id="ex_mgrApproveDetail" cols="30" rows="3" class="form-control form-control-sm">{show_crfex_mgrapp_detail}</textarea>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="">Approver.</label>
                        <input readonly type="text" name="ex_mgrApproveName" id="ex_mgrApproveName" class="form-control form-control-sm" value="{show_crfex_mgrapp_username}">
                        <input readonly type="text" name="ex_mgrApproveDateTime" id="ex_mgrApproveDateTime" class="form-control form-control-sm mt-1" value="{show_crfex_mgrapp_datetime}">
                    </div>
                </div>
            </form>
            <!-- Sale manager & CS manager Section -->






            <!-- CS get br for account convert to customer code -->
            <form action="{exCsAddBr}" method="POST" name="" class="csAddBrDection" style="display:none;">
                <hr>
                <h6><b><u>FOR CS ADD BR CODE</u></b></h6>
                <!-- Check formno -->
                <input hidden type="text" name="csFromno" id="csFromno" value="{crfex_formno}">
                <input hidden type="text" name="csArea" id="csArea" value="{get_area}">

                <div class="row form-group">
                    <div class="col-md-8 form-group">
                        <label for="">BR CODE</label>
                        <input type="text" name="ex_csBrCode" id="ex_csBrCode" class="form-control form-control-sm">
                    </div>
                    <!-- <div class="col-md-8 form-group">
                        <label for="">Memo.</label>
                        <textarea name="ex_csBrMemo" id="ex_csBrMemo" cols="30" rows="3" class="form-control form-control-sm"></textarea>
                    </div> -->
                    <div class="col-md-4 form-group">
                        <label for="">CS Sign.</label>
                        <input readonly type="text" name="ex_csBrName" id="ex_csBrName" class="form-control form-control-sm" value="{username}">
                        <input readonly type="text" name="excsBrDateTime" id="excsBrDateTime" class="form-control form-control-sm mt-1" value="{datenow}">
                    </div>
                </div>
                <div class="row form-group ">
                    <div class="col-md-4"></div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4"><button type="submit" class="btn btn-info btn-block" id="ex_csSubmit" name="ex_csSubmit">Submit</button></div>
                </div>
            </form>


            <form method="POST" name="" class="csAddBrDection1" style="display:none;">
                <hr>
                <h6><b><u>FOR CS ADD BR CODE</u></b></h6>
                <div class="row form-group">
                    <div class="col-md-8 form-group">
                        <label for="">BR CODE</label>
                        <input readonly type="text" name="ex_csBrCode" id="ex_csBrCode" class="form-control form-control-sm" value="{brcode}">
                    </div>
                    <!-- <div class="col-md-8 form-group">
                        <label for="">Memo.</label>
                        <textarea readonly name="ex_csBrMemo" id="ex_csBrMemo" cols="30" rows="3" class="form-control form-control-sm">{crfex_csmemo}</textarea>
                    </div> -->
                    <div class="col-md-4 form-group">
                        <label for="">CS Sign.</label>
                        <input readonly type="text" name="ex_csBrName" id="ex_csBrName" class="form-control form-control-sm" value="{crfex_csuserpost}">
                        <input readonly type="text" name="excsBrDateTime" id="excsBrDateTime" class="form-control form-control-sm mt-1" value="{crfex_csdatetime}">
                    </div>
                </div>
            </form>
            <!-- CS get br for account convert to customer code -->







            <!-- account manager apparove zone -->
            <form action="{exAccMgrApprove}" method="POST" name="" class="accManagerApprove" style="display:none;">
                <hr>
                <h6><b><u>FOR ACCOUNT MANAGER</u></b></h6>
            <!-- Check Zone -->
            <input hidden type="text" name="accMgrFromno" id="accMgrFromno" value="{crfex_formno}">
            <input hidden type="text" name="accMgr_cusType" id="accMgr_cusType" value="{customertype}">
            <input hidden type="text" name="accMgr_curcustopic1" id="accMgr_curcustopic1" value="{crfex_curcustopic1}">
            <input hidden type="text" name="accMgr_curcustopic2" id="accMgr_curcustopic2" value="{crfex_curcustopic2}">

                <div class="row form-group">

                    <div class="col-md-12 form-group">
                        <input type="radio" name="ex_accMgrApprove" id="ex_accMgrApprove" value="Approve">&nbsp;<label for="">Approve</label>&nbsp;&nbsp;
                        <input type="radio" name="ex_accMgrApprove" id="ex_accMgrApprove" value="Not approve">&nbsp;<label for="">Not approve</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <label for="">Reasons for approval.</label>
                        <textarea name="ex_accMgrApproveDetail" id="ex_accMgrApproveDetail" cols="30" rows="3" class="form-control form-control-sm"></textarea>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="">Account Manager Approver.</label>
                        <input readonly type="text" name="ex_accMgrApproveName" id="ex_accMgrApproveName" class="form-control form-control-sm" value="{username}">
                        <input readonly type="text" name="ex_accMgrApproveDateTime" id="ex_accMgrApproveDateTime" class="form-control form-control-sm mt-1" value="{datenow}">
                    </div>
                </div>
                <div class="row form-group ">
                    <div class="col-md-4"></div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4"><button type="submit" class="btn btn-info btn-block" id="ex_accManagerSubmit" name="ex_accManagerSubmit">Submit</button></div>
                </div>
            </form>


            <form method="POST" name="" class="accManagerApprove1" style="display:none;">
                <hr>
                <h6><b><u>FOR ACCOUNT MANAGER</u></b></h6>
                <div class="row form-group">

                <!-- For check account manager approve status -->
                <input hidden type="text" name="check_ex_accMgrApprove" id="check_ex_accMgrApprove" value="{crfex_accmgr_status}">
                    <div class="col-md-12 form-group">
                        <input type="radio" name="ex_accMgrApprove1" id="ex_accMgrApprove1" value="Approve">&nbsp;<label for="">Approve</label>&nbsp;&nbsp;
                        <input type="radio" name="ex_accMgrApprove2" id="ex_accMgrApprove2" value="Not approve">&nbsp;<label for="">Not approve</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <label for="">Reasons for approval.</label>
                        <textarea readonly name="ex_accMgrApproveDetail" id="ex_accMgrApproveDetail" cols="30" rows="3" class="form-control form-control-sm">{crfex_accmgr_detail}</textarea>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="">Account Manager Approver.</label>
                        <input readonly type="text" name="ex_accMgrApproveName" id="ex_accMgrApproveName" class="form-control form-control-sm" value="{crfex_accmgr_username}">
                        <input readonly type="text" name="ex_accMgrApproveDateTime" id="ex_accMgrApproveDateTime" class="form-control form-control-sm mt-1" value="{crfex_accmgr_datetime}">
                    </div>
                </div>
            </form>
            <!-- account manager apparove zone -->






            <!-- Director apparove zone1 -->
            <form action="{exDirectorApprove}" method="POST" name="" class="directorApprove" style="display:none;">
            <input hidden type="text" name="check_custype_direc" id="check_custype_direc" value="{customertype}">
            <input hidden type="text" name="check_methodcurcus" id="check_methodcurcus" value="{crfex_methodcurcus}">

            <input hidden type="text" name="checkDirecFormNo" id="checkDirecFormNo" value="{crfex_formno}">

            <input hidden type="text" name="checkDireccurcustopic1" id="checkDireccurcustopic1" value="{crfex_curcustopic1}">
            <input hidden type="text" name="checkDireccurcustopic2" id="checkDireccurcustopic2" value="{crfex_curcustopic2}">

            <input hidden type="text" name="checkDirecCusid" id="checkDirecCusid" value="{crfexcus_id}">

                <hr>
                <h6><b><u>FOR DIRECTOR</u></b></h6>
                <div class="row form-group">

                    <div class="col-md-12 form-group">
                        <input type="radio" name="ex_directorApprove" id="ex_directorApprove" value="Approve">&nbsp;<label for="">Approve</label>&nbsp;&nbsp;
                        <input type="radio" name="ex_directorApprove" id="ex_directorApprove" value="Not approve">&nbsp;<label for="">Not approve</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <label for="">Reasons for approval.</label>
                        <textarea name="ex_directorApproveDetail" id="ex_directorApproveDetail" cols="30" rows="3" class="form-control form-control-sm"></textarea>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="">Director Approver.</label>
                        <input readonly type="text" name="ex_directorApproveName" id="ex_directorApproveName" class="form-control form-control-sm" value="{username}">
                        <input readonly type="text" name="ex_directorApproveDateTime" id="ex_directorApproveDateTime" class="form-control form-control-sm mt-1" value="{datenow}">
                    </div>
                </div>

                 <!-- Check Director approve 2 -->
                 <?php 
                    $notdisplay1 = '';
                    if($crfex_directorapp_status2 == "Approve"){
                        if($crfex_directorapp_username2 == $username){
                            $notdisplay1 = 'style="display:none;"';
                        }else{
                            $notdisplay1 = '';
                        }
                    }
                ?>


                <div class="row form-group" <?=$notdisplay1?>>
                    <div class="col-md-4"></div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4"><button type="submit" class="btn btn-info btn-block" id="ex_directorSubmit" name="ex_directorSubmit">Submit</button></div>
                </div>
            </form>


            <form method="POST" name="" class="directorApprove1show" style="display:none;">
                <hr>
                <h6><b><u>FOR DIRECTOR</u></b></h6>
                <div class="row form-group">

                <!-- Check director approve status -->
                <input hidden type="text" name="check_director_status" id="check_director_status" value="{crfex_directorapp_status}">
                    <div class="col-md-12 form-group">
                        <input type="radio" name="ex_directorApprove1" id="ex_directorApprove1" value="Approve">&nbsp;<label for="">Approve</label>&nbsp;&nbsp;
                        <input type="radio" name="ex_directorApprove2" id="ex_directorApprove2" value="Not approve">&nbsp;<label for="">Not approve</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <label for="">Reasons for approval.</label>
                        <textarea readonly name="ex_directorApproveDetail" id="ex_directorApproveDetail" cols="30" rows="3" class="form-control form-control-sm">{crfex_directorapp_detail}</textarea>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="">Director Approver.</label>
                        <input readonly type="text" name="ex_directorApproveName" id="ex_directorApproveName" class="form-control form-control-sm" value="{crfex_directorapp_username}">
                        <input readonly type="text" name="ex_directorApproveDateTime" id="ex_directorApproveDateTime" class="form-control form-control-sm mt-1" value="{crfex_directorapp_datetime}">
                    </div>
                </div>
            </form>
            <!-- Director apparove zone1 -->




                <!-- Director apparove zone2 -->
            <form action="{exDirectorApprove2}" method="POST" name="" class="directorApprove2" style="display:none;">
            <input hidden type="text" name="check_custype_direc" id="check_custype_direc" value="{customertype}">
            <input hidden type="text" name="check_methodcurcus" id="check_methodcurcus" value="{crfex_methodcurcus}">

            <input hidden type="text" name="checkDirecFormNo" id="checkDirecFormNo" value="{crfex_formno}">

            <input hidden type="text" name="checkDireccurcustopic1" id="checkDireccurcustopic1" value="{crfex_curcustopic1}">
            <input hidden type="text" name="checkDireccurcustopic2" id="checkDireccurcustopic2" value="{crfex_curcustopic2}">

            <input hidden type="text" name="checkDirecCusid" id="checkDirecCusid" value="{crfexcus_id}">

                <h6><b><u>FOR DIRECTOR</u></b></h6>
                <div class="row form-group">

                    <div class="col-md-12 form-group">
                        <input type="radio" name="ex_directorApprove2" id="ex_directorApprove2" value="Approve">&nbsp;<label for="">Approve</label>&nbsp;&nbsp;
                        <input type="radio" name="ex_directorApprove2" id="ex_directorApprove2" value="Not approve">&nbsp;<label for="">Not approve</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <label for="">Reasons for approval.</label>
                        <textarea name="ex_directorApproveDetail2" id="ex_directorApproveDetail2" cols="30" rows="3" class="form-control form-control-sm"></textarea>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="">Director Approver.</label>
                        <input readonly type="text" name="ex_directorApproveName2" id="ex_directorApproveName2" class="form-control form-control-sm" value="{username}">
                        <input readonly type="text" name="ex_directorApproveDateTime2" id="ex_directorApproveDateTime2" class="form-control form-control-sm mt-1" value="{datenow}">
                    </div>
                </div>

                <!-- Check Director approve 1 -->
                <?php 
                    $notdisplay = '';
                    if($crfex_directorapp_status == "Approve"){
                        if($crfex_directorapp_username == $username){
                            $notdisplay = 'style="display:none;"';
                        }else{
                            $notdisplay = '';
                        }
                    }
                ?>

                <div class="row form-group" <?=$notdisplay?>>
                    <div class="col-md-4"></div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4"><button type="submit" class="btn btn-info btn-block" id="ex_directorSubmit2" name="ex_directorSubmit2">Submit</button></div>
                </div>
            </form>


            <form method="POST" name="" class="directorApprove2show" style="display:none;">
                <hr>
                <h6><b><u>FOR DIRECTOR</u></b></h6>
                <div class="row form-group">

                <!-- Check director approve status -->
                <input hidden type="text" name="check_director_status2" id="check_director_status2" value="{crfex_directorapp_status2}">
                    <div class="col-md-12 form-group">
                        <input type="radio" name="ex_directorApprove21" id="ex_directorApprove21" value="Approve">&nbsp;<label for="">Approve</label>&nbsp;&nbsp;
                        <input type="radio" name="ex_directorApprove22" id="ex_directorApprove22" value="Not approve">&nbsp;<label for="">Not approve</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <label for="">Reasons for approval.</label>
                        <textarea readonly name="ex_directorApproveDetail" id="ex_directorApproveDetail" cols="30" rows="3" class="form-control form-control-sm">{crfex_directorapp_detail2}</textarea>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="">Director Approver.</label>
                        <input readonly type="text" name="ex_directorApproveName" id="ex_directorApproveName" class="form-control form-control-sm" value="{crfex_directorapp_username2}">
                        <input readonly type="text" name="ex_directorApproveDateTime" id="ex_directorApproveDateTime" class="form-control form-control-sm mt-1" value="{crfex_directorapp_datetime2}">
                    </div>
                </div>
            </form>
            <!-- Director apparove zone2 -->










            <!-- account staff zone -->
            <form action="{exAccountAddCusCode}" method="POST" name="" class="accAddCustomerCode" style="display:none;">

            <!-- For check data to update table -->
            <input hidden type="text" name="check_custype_accstaff" id="check_custype_accstaff" value="{customertype}">
            <input hidden type="text" name="acc_curcustopic1" id="acc_curcustopic1" value="{crfex_curcustopic1}">
            <input hidden type="text" name="acc_curcustopic2" id="acc_curcustopic2" value="{crfex_curcustopic2}">
                <hr>
                <h6><b><u>FOR ACCOUNT</u></b></h6>

                <div class="row form-group">
                    <div class="col-md-8 form-group filcuscode">
                        <label for="">CUSTOMER CODE</label>
                        <input type="text" name="ex_accCostomerCode" id="ex_accCostomerCode" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-8 form-group">
                        <label for="">Memo.</label>
                        <textarea name="ex_accMemo" id="ex_accMemo" cols="30" rows="3" class="form-control form-control-sm"></textarea>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="">ACCOUNT Sign.</label>
                        <input readonly type="text" name="ex_accName" id="ex_accName" class="form-control form-control-sm" value="{username}">
                        <input readonly type="text" name="ex_accDateTime" id="ex_accDateTime" class="form-control form-control-sm mt-1" value="{datenow}">
                    </div>
                </div>
                <input hidden type="text" name="crfex_userecodemodify" id="crfex_userecodemodify" value="{ecode}">
                <input hidden type="text" name="crfex_userdeptcodemodify" id="crfex_userdeptcodemodify" value="{deptcode}">
                <input hidden type="text" name="accCusCode_getCusid" id="accCusCode_getCusid" value="{crfex_customerid}">
                <input hidden type="text" name="accFormno" id="accFormno" value="{crfex_formno}">
                <div class="row form-group ">
                    <div class="col-md-4"></div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4"><button type="submit" class="btn btn-info btn-block" id="ex_accSubmit" name="ex_accSubmit">Submit</button></div>
                </div>
            </form>


            <form method="POST" name="" class="accAddCustomerCode1" style="display:none;">
                <hr>
                <h6><b><u>FOR ACCOUNT</u></b></h6>
                <div class="row form-group">
                    <div class="col-md-8 form-group showcuscodeacc">
                        <label for="">CUSTOMER CODE</label>
                        <input readonly type="text" name="ex_accCostomerCode" id="ex_accCostomerCode" class="form-control form-control-sm" value="{customercode}">
                    </div>
                    <div class="col-md-8 form-group">
                        <label for="">Memo.</label>
                        <textarea readonly name="ex_accMemo" id="ex_accMemo" cols="30" rows="3" class="form-control form-control-sm">{crfex_accmemo}</textarea>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="">ACCOUNT Sign.</label>
                        <input readonly type="text" name="ex_accName" id="ex_accName" class="form-control form-control-sm" value="{crfex_accuserpost}">
                        <input readonly type="text" name="ex_accDateTime" id="ex_accDateTime" class="form-control form-control-sm mt-1" value="{crfex_accdatetime}">
                    </div>
                </div>
            </form>
            <!-- account staff zone -->





        </div>
        <!-- กรอบฟอร์ม -->

    </div>




</body>

</html>