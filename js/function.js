function saveCustomerCode() {
    $.ajax({
        url: "main/saveCustomersCode",
        method: "POST",
        data: {},
        success: function (data) {
            console.log(data);
        }
    });
}



function autoSearchCustomerDetailEx(cusCode) {
    $.ajax({
        url: 'main/searchCustomerDetailEx',
        method: 'POST',
        data: {
            cusCode: cusCode
        },
        success: function (data) {
            $('#autoCusCodeEx').html(data);
        }
    });
}

function autoSearchCustomerDetailExName(cusName) {
    $.ajax({
        url: 'main/searchCustomerDetailExName',
        method: 'POST',
        data: {
            cusName: cusName
        },
        success: function (data) {
            $('#autoCusCodeExName').html(data);
        }
    });
}


function setChecked(targetval) {
    $('input:checkbox[name="crf_process"]').each(function () {
        var value = $(this).val();
        if (value == targetval) {
            $(this).prop('checked', true);
        } else {
            $(this).prop('checked', false);
        }
    });
}

function queryProcessUse(cusId) {
    $.ajax({
        url: 'main/queryProcessUse',
        method: 'POST',
        data: {
            cusId: cusId
        },
        success: function (data) {
            $('#showoldprocesscus').html(data);
            $('.newprocesscus').css('display', 'none');
        }
    });
}

function getCusProcess(dataareaid){
    if(dataareaid !== ''){
        $.ajax({
            url:'main/getCusProcess',
            method:'POST',
            data:{
                dataareaid:dataareaid
            },
            success:function(data){
                console.log(JSON.parse(data));
                if(JSON.parse(data).status == "Select Data Success"){
                    let result = JSON.parse(data).result;
                    let output = '';

                    for(let key in result){
                        if(dataareaid == "st" || dataareaid == "tb"){
                            output +=`
                                <div class="col-lg-6 ">
                                    <input type="checkbox" name="crf_process[]" id="crf_process" value="`+result[key].cuspro_id+`">
                                    <label for="">`+result[key].cuspro_name+`</label>
                                </div>
                            `;
                        }else{
                            output +=`
                                <div class="col-md-3 ">
                                    <input type="checkbox" name="crf_process[]" id="crf_process" value="`+result[key].cuspro_id+`">
                                    <label for="">`+result[key].cuspro_name+`</label>
                                </div>
                            `;
                        }
                    }


                    $('.newprocesscus').html(output);
                }
            }
        });
    }
}

function unclick(e) {
    e.preventDefault();
    return false;
}


function queryPrimanageUse(cusId) {
    $.ajax({
        url: 'main/queryPrimanageUse',
        method: 'POST',
        data: {
            cusId: cusId
        },
        success: function (data) {
            if (data == 11) {
                var conF = confirm("พบชื่อลูกค้าที่คล้ายกันในระบบ คุณยืนยันที่จะดำเนินการต่อหรือไม่");
                if (conF == false) {
                    $('#crf_customername').val('');
                }
            }else{

            }

        }
    });
}

function checkDuplicateNameCustomerEx(cusName , comName) {
    $.ajax({
        url: 'main/checkDuplicateNameCustomerEx',
        method: 'POST',
        data: {
            cusName: cusName,
            comName: comName
        },
        success: function (data) {
            if (data == 11) {
                var conF = confirm("Found the customer name in system, Are you sure go to next step.");
                if (conF == false) {
                    $('#crfex_cusnameEN').val('');
                    $('#alert_crfex_cusnameEN').html('');
                }
            }else{

            }

        }
    });
}





// Edit zone on view page
// edit sales reps
function edit_salesreps(editcusid , editsalesreps){
    $.ajax({
        url:'main/editViewPage',
        method:'POST',
        data:{
            "editcusid" : editcusid,
            "editsalesreps" : editsalesreps
        },
        success:function(res){
            console.log(res);
        }
    });
}



//Function for check duplicate BR Code
function checkDupliBR(query)
{
    $.ajax({
        url: "main/checkbrcode",
        method: "post",
        data: { query:query },
        success: function(data){
            console.log(data);
        }
    });

}



// Check Customer name for export
function checkCustomersNameEn(cusname)
{
    var checkCusname = /[^ก-เ]{4,100}$/.test(cusname);

    if(checkCusname == true){
        $('#alert_crfex_cusnameEN').html('<div class="alert alert-success" role="alert"><i class="fas fa-check-circle"></i>&nbsp;Customer name correct pattern</div>');
        $('#usercrfex_edit').prop('disabled' , false);
    }else{
        $('#alert_crfex_cusnameEN').html('<div class="alert alert-danger" role="alert">Please use Customer name on english language only.</div>');
        $('#usercrfex_edit').prop('disabled' , true);
    }
}

// Check Customer name for export
function checkCustomersNameTH(cusname)
{
    var checkCusname = /[^A-Za-z0-9]{4,100}$/.test(cusname);

    if(checkCusname == true){
        $('#alert_crfex_cusnameTH').html('<div class="alert alert-success" role="alert"><i class="fas fa-check-circle"></i>&nbsp;Customer name correct pattern</div>');
        $('#usercrfex_edit').prop('disabled' , false);
    }else{
        $('#alert_crfex_cusnameTH').html('<div class="alert alert-danger" role="alert">Please use Customer name on Thai language only.</div>');
        $('#usercrfex_edit').prop('disabled' , true);
    }
}



// Report Zone

function loadreportEx()
{
    $.ajax({
        url:"/intsys/crf/main/reportExport",
        method:"POST",
        data:{

        },
        success:function(data){
            $('#showTable').html(data);

            $('#report_listEx thead th').each(function() {
                var title = $(this).text();
                $(this).html(title + ' <input type="text" class="col-search-input" placeholder="Search ' + title + '" />');
            });

            var table = $('#report_listEx').DataTable({
                "columnDefs": [{
                    "searching": false,
                    "orderable": false,
                    "targets": "_all"
                }],
                dom: 'Bfrtip',
                "buttons": [{
                        extend: 'copyHtml5',
                        title: 'Credit request form export.'
                    },
                    {
                        extend: 'excelHtml5',
                        autoFilter: true,
                        title: 'Credit request form export.'
                    }
                ],
                "order": [
                    [0, 'desc']
                ]
            });


            table.columns().every(function() {
                var table = this;
                $('input', this.header()).on('keyup change', function() {
                    if (table.search() !== this.value) {
                        table.search(this.value).draw();
                    }
                });
            });
        }
    });
}




function loadreportExdate(datestart , dateend)
{
    $.ajax({
        url:"/intsys/crf/main/reportExportdate",
        method:"POST",
        data:{
            datestart: datestart,
            dateend: dateend
        },
        success:function(data){
            $('#showTable').html(data);

            $('#report_listEx thead th').each(function() {
                var title = $(this).text();
                $(this).html(title + ' <input type="text" class="col-search-input" placeholder="Search ' + title + '" />');
            });

            var table = $('#report_listEx').DataTable({
                "columnDefs": [{
                    "searching": false,
                    "orderable": false,
                    "targets": "_all"
                }],
                dom: 'Bfrtip',
                "buttons": [{
                        extend: 'copyHtml5',
                        title: 'Credit request form export.'
                    },
                    {
                        extend: 'excelHtml5',
                        autoFilter: true,
                        title: 'Credit request form export.'
                    }
                ],
                "order": [
                    [0, 'desc']
                ]
            });


            table.columns().every(function() {
                var table = this;
                $('input', this.header()).on('keyup change', function() {
                    if (table.search() !== this.value) {
                        table.search(this.value).draw();
                    }
                });
            });
        }
    });
}


function loadreport()
{
    $.ajax({
        url:"/intsys/crf/main/reportTh",
        method:"POST",
        data:{

        },
        success:function(data){
            $('#showTableTH').html(data);

            $('#report_list thead th').each(function() {
                var title = $(this).text();
                $(this).html(title + ' <input type="text" class="col-search-input" placeholder="Search ' + title + '" />');
            });

            var table = $('#report_list').DataTable({
                "columnDefs": [{
                    "searching": false,
                    "orderable": false,
                    "targets": "_all"
                }],
                dom: 'Bfrtip',
                "buttons": [{
                        extend: 'copyHtml5',
                        title: 'Credit request form.'
                    },
                    {
                        extend: 'excelHtml5',
                        autoFilter: true,
                        title: 'Credit request form.'
                    }
                ],
                "order": [
                    [0, 'desc']
                ]
            });


            table.columns().every(function() {
                var table = this;
                $('input', this.header()).on('keyup change', function() {
                    if (table.search() !== this.value) {
                        table.search(this.value).draw();
                    }
                });
            });
        }
    });
}


function loadreportdate(datestart,dateend)
{
    $.ajax({
        url:"/intsys/crf/main/reportThdate",
        method:"POST",
        data:{
            datestart: datestart,
            dateend: dateend
        },
        success:function(data){
            $('#showTableTH').html(data);

            $('#report_list thead th').each(function() {
                var title = $(this).text();
                $(this).html(title + ' <input type="text" class="col-search-input" placeholder="Search ' + title + '" />');
            });

            var table = $('#report_list').DataTable({
                "columnDefs": [{
                    "searching": false,
                    "orderable": false,
                    "targets": "_all"
                }],
                dom: 'Bfrtip',
                "buttons": [{
                        extend: 'copyHtml5',
                        title: 'Credit request form.'
                    },
                    {
                        extend: 'excelHtml5',
                        autoFilter: true,
                        title: 'Credit request form.'
                    }
                ],
                "order": [
                    [0, 'desc']
                ]
            });


            table.columns().every(function() {
                var table = this;
                $('input', this.header()).on('keyup change', function() {
                    if (table.search() !== this.value) {
                        table.search(this.value).draw();
                    }
                });
            });
        }
    });
}






// Setting page function
function insertEmailSystem(email_account , email_password)
{
    $.ajax({
        url: "main/saveSettingEmail",
        method: "POST",
        data:{
            email_account: email_account,
            email_password: email_password
        },
        success:function(data){
            alert("Add Email Success");
        }
    });
} 





// Function load customerlist
function loadcustomerlist()
{
    $.ajax({
        url:"/intsys/crf/customers/fetchCustomerlist",
        method:"POST",
        data:{

        },
        success:function(data){
            $('#showCustomersList').html(data);

            $('#customers_list thead th').each(function() {
                var title = $(this).text();
                $(this).html(title + ' <input type="text" class="col-search-input" placeholder="Search ' + title + '" />');
            });

            var table = $('#customers_list').DataTable({
                "columnDefs": [{
                    "searching": false,
                    "orderable": false,
                    "targets": "_all"
                },
                {
                    "width": "8%",
                    "targets": 0
                },
                {
                    "width": "8%",
                    "targets": 1
                },
                {
                    "width": "15%",
                    "targets": 2
                },
                {
                    "width": "35%",
                    "targets": 3
                }],
                dom: 'Bfrtip',
                "buttons": [{
                        extend: 'copyHtml5',
                        title: 'Credit request form.'
                    },
                    {
                        extend: 'excelHtml5',
                        autoFilter: true,
                        title: 'Credit request form.'
                    }
                ],
                "order":false
            });


            table.columns().every(function() {
                var table = this;
                $('input', this.header()).on('keyup change', function() {
                    if (table.search() !== this.value) {
                        table.search(this.value).draw();
                    }
                });
            });
        }
    });
}

function getCallback(status){
    return status;
}






// Export
function loadcustomerlistEx()
{
    $.ajax({
        url:"/intsys/crf/customers/fetchCustomerlistEx",
        method:"POST",
        data:{

        },
        success:function(data){
            $('#showCustomersListEx').html(data);

            $('#customers_listEx thead th').each(function() {
                var title = $(this).text();
                $(this).html(title + ' <input type="text" class="col-search-input" placeholder="Search ' + title + '" />');
            });

            var table = $('#customers_listEx').DataTable({
                "columnDefs": [{
                    "searching": false,
                    "orderable": false,
                    "targets": "_all"
                }],
                dom: 'Bfrtip',
                "buttons": [{
                        extend: 'copyHtml5',
                        title: 'Credit request form.'
                    },
                    {
                        extend: 'excelHtml5',
                        autoFilter: true,
                        title: 'Credit request form.'
                    }
                ],
                "order": [
                    [0, 'desc']
                ]
            });


            table.columns().every(function() {
                var table = this;
                $('input', this.header()).on('keyup change', function() {
                    if (table.search() !== this.value) {
                        table.search(this.value).draw();
                    }
                });
            });
        }
    });
}


// Check Duplicate customer code
function checkCuscodeManualEx(cuscode , area)
{
    $.ajax({
        url:"/intsys/crf/customers/fetchCustomercodeEx",
        method:"POST",
        data:{
            cuscode:cuscode,
            area:area
        },
        success:function(data){
            if(data > 0){
                $('#alertCuscodeEx').fadeIn();
                $('#alertCuscodeEx').html('<div class="alert alert-danger" role="alert">Found Duplicate customer code!!</div>').fadeOut(3500);
                $('#addcusex_customercode').val('');
            }

        }
    });
}








// Function control add page th new 05-06-2020
function minsalesreps(salesrepIn)
{
    var checkSalesrepIn = /(^D[0-9]{4,4}$|^M[0-9]{4,4}$)/.test(salesrepIn);
    return checkSalesrepIn;
}

// Function เช็คเลขที่ผู้เสียภาษี
function checktax(taxIn)
{
    var checkTax = /(^[0-9]{13}$)/.test(taxIn);
    return checkTax;
}

// Function เช็ครูปแบบของเบอร์โทรศัพท์ กรอกเฉพาะตัวเลขเท่านั้น
function checkTelPat(telIn)
{
    var checkTelPat = /(^[0-9]{8,15}$)/.test(telIn);
    return checkTelPat;
}

// Check ข้อมูลทุกฟิลด์ที่จำเป็น
function checkBeforeSave()
{
    let regex = /^(0?[1-9]|[12][0-9]|3[01])-(0?[1-9]|1[0-2])-\d{4}$/;
    let input = $('#crf_cuscompanycreate');

    if($('input:radio[name="crf_type"]:checked').val() == 1){


        if($('input:radio[name="crf_person_type"]:checked').val() == "natural"){

    // เช็ค sales reps
    if($('#crf_salesreps').val() == ''){
        $('#alert_salesreps').html('<div class="alert alert-danger" role="alert">กรุณาระบุข้อมูล Sales Reps ด้วยค่ะ</div>');
        $('#alert_submit').html('<div class="alert alert-danger" role="alert">กรุณาระบุข้อมูล Sales Reps ด้วยค่ะ</div>');
        $('#user_submit').prop('disabled' , true);
        return false;

    }else if($('#crf_customername').val() == ''){
        // เช็คชื่อบริษัท
        $('#alert_customername').html('<div class="alert alert-danger" role="alert">กรุณาระบุชื่อลูกค้าด้วยค่ะ</div>');
        $('#alert_submit').html('<div class="alert alert-danger" role="alert">กรุณาระบุชื่อลูกค้าด้วยค่ะ</div>');
        $('#user_submit').prop('disabled' , true);

    }else if($('#crf_cuscompanycreate').val() == '' || regex.test(input.val()) === false){
        // เช็ควันที่ก่อตั้ง
        $('#alert_cuscompanycreate').html('<div class="alert alert-danger" role="alert">กรุณาระบุวันที่ก่อตั้งด้วยค่ะ</div>');
        $('#alert_submit').html('<div class="alert alert-danger" role="alert">กรุณาระบุวันที่ก่อตั้งด้วยค่ะ</div>');
        $('#user_submit').prop('disabled' , true);

    }else if($('#crf_customertaxid').val() == ''){
        // เช็คเลขที่ผู้เสียภาษี
        $('#alert_crf_customertaxid').html('<div class="alert alert-danger" role="alert">กรุณาระบุเลขที่ประจำตัวผู้เสียภาษีด้วยค่ะ</div>');
        $('#alert_submit').html('<div class="alert alert-danger" role="alert">กรุณาระบุเลขที่ประจำตัวผู้เสียภาษีด้วยค่ะ</div>');
        $('#user_submit').prop('disabled' , true);

    }else if(checktax($('#crf_customertaxid').val()) == false){
    
            $('#alert_crf_customertaxid').html('<div class="alert alert-danger" role="alert">กรุณาระบุเลขที่ประจำตัวผู้เสียภาษีให้ครบถ้วยทั้ง 13 หลักโดยต้องระบุเป็นตัวเลขเท่านั้น</div>');
            $('#alert_submit').html('<div class="alert alert-danger" role="alert">กรุณาระบุเลขที่ประจำตัวผู้เสียภาษีให้ครบถ้วยทั้ง 13 หลักโดยต้องระบุเป็นตัวเลขเท่านั้น</div>');
            $('#user_submit').prop('disabled' , true);

    }else if($('#crf_customerbranch').val() == ''){
        // เช็คสาขา
        $('#alert_crf_customerbranch').html('<div class="alert alert-danger" role="alert">กรุณาระบุสาขา ด้วยค่ะ</div>');
        $('#alert_submit').html('<div class="alert alert-danger" role="alert">กรุณาระบุสาขา ด้วยค่ะ</div>');
        $('#user_submit').prop('disabled' , true);

    }else if($('input:radio[name="crf_addresstype"]:checked').length < 1){
        // เช็คประเภทของที่อยู่ลูกค้า
        $('#alert_addresstype').html('<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทที่อยู่ด้วยค่ะ ด้วยค่ะ</div>');
        $('#alert_submit').html('<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทที่อยู่ด้วยค่ะ ด้วยค่ะ</div>');
        $('#user_submit').prop('disabled' , true);

    }else if($('#crf_addressname').val() == ''){
        // เช็คที่อยู่ของลูกค้า
        $('#alert_addressname').html('<div class="alert alert-danger" role="alert">กรุณาระบุที่อยู่สำหรับการเปิดใบกำกับภาษีด้วยค่ะ</div>');
        $('#alert_submit').html('<div class="alert alert-danger" role="alert">กรุณาระบุที่อยู่สำหรับการเปิดใบกำกับภาษีด้วยค่ะ</div>');
        $('#user_submit').prop('disabled' , true);

    }else if($('#crf_namecontact').val() == ''){
        $('#alert_namecontact').html('<div class="alert alert-danger" role="alert">กรุณาระบุชื่อผู้ติดต่อด้วยค่ะ</div>');
        $('#alert_submit').html('<div class="alert alert-danger" role="alert">กรุณาระบุชื่อผู้ติดต่อด้วยค่ะ</div>');
        $('#user_submit').prop('disabled' , true);

    }else if($('#crf_telcontact').val() == ''){
        $('#alert_telcontact').html('<div class="alert alert-danger" role="alert">กรุณาระบุเบอร์ผู้ติดต่อด้วยค่ะ</div>');
        $('#alert_submit').html('<div class="alert alert-danger" role="alert">กรุณาระบุเบอร์ผู้ติดต่อด้วยค่ะ</div>');
        $('#user_submit').prop('disabled' , true);

    }else if($('#crf_regiscost').val() == ''){
        $('#alert_regiscost').html('<div class="alert alert-danger" role="alert">กรุณาระบุทุนจดทะเบียนด้วยค่ะ</div>');
        $('#alert_submit').html('<div class="alert alert-danger" role="alert">กรุณาระบุทุนจดทะเบียนด้วยค่ะ</div>');
        $('#user_submit').prop('disabled' , true);

    }else if($('input:radio[name="crf_companytype"]:checked').length < 1){
        $('#alert_companytype').html('<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทบริษัทด้วยค่ะ</div>');
        $('#alert_submit').html('<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทบริษัทด้วยค่ะ</div>');
        $('#user_submit').prop('disabled' , true);

    }else if($('input:radio[name="crf_typeofbussi"]:checked').length < 1){
        $('#alert_typeofbussi').html('<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทธุรกิจด้วยค่ะ</div>');
        $('#alert_submit').html('<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทธุรกิจด้วยค่ะ</div>');
        $('#user_submit').prop('disabled' , true);

    }else if($('#crf_file_person').val() == ''){
        $('#alert_file_person').html('<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ ภพ.20 ด้วยค่ะ</div>');
        $('#alert_submit').html('<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ ภพ.20 ด้วยค่ะ</div>');
        $('#user_submit').prop('disabled' , true);

    }else if($('#crf_creditterm').val() == ''){
        $('#alert_creditterm').html('<div class="alert alert-danger" role="alert">กรุณาเลือก Credit Term ด้วยค่ะ</div>');
        $('#alert_submit').html('<div class="alert alert-danger" role="alert">กรุณาเลือก Credit Term ด้วยค่ะ</div>');
        $('#user_submit').prop('disabled' , true);
    }else if($('input:radio[name=crf_condition_bill]:checked').length < 1){
        $('#alert_condition_bill').html('<div class="alert alert-danger" role="alert">กรุณาเลือกเงื่อนไขการวางบิลด้วยค่ะ</div>');
        $('#alert_submit').html('<div class="alert alert-danger" role="alert">กรุณาเลือกเงื่อนไขการวางบิลด้วยค่ะ</div>');
        $('#user_submit').prop('disabled' , true);
    }else if($('input:radio[name="crf_condition_money"]:checked').length < 1){
        $('#alert_condition_money').html('<div class="alert alert-danger" role="alert">กรุณาเลือกเงื่อนไขการชำระเงินด้วยค่ะ</div>');
        $('#alert_submit').html('<div class="alert alert-danger" role="alert">กรุณาเลือกเงื่อนไขการชำระเงินด้วยค่ะ</div>');
        $('#user_submit').prop('disabled' , true);
    }
    else{
        $('#user_submit').prop('disabled' , false);
    }

        }else if($('input:radio[name="crf_person_type"]:checked').val() == "juristic"){
                // เช็ค sales reps
    if($('#crf_salesreps').val() == ''){
        $('#alert_salesreps').html('<div class="alert alert-danger" role="alert">กรุณาระบุข้อมูล Sales Reps ด้วยค่ะ</div>');
        $('#alert_submit').html('<div class="alert alert-danger" role="alert">กรุณาระบุข้อมูล Sales Reps ด้วยค่ะ</div>');
        $('#user_submit').prop('disabled' , true);
        return false;

    }else if($('#crf_customername').val() == ''){
        // เช็คชื่อบริษัท
        $('#alert_customername').html('<div class="alert alert-danger" role="alert">กรุณาระบุชื่อลูกค้าด้วยค่ะ</div>');
        $('#alert_submit').html('<div class="alert alert-danger" role="alert">กรุณาระบุชื่อลูกค้าด้วยค่ะ</div>');
        $('#user_submit').prop('disabled' , true);

    }else if($('#crf_cuscompanycreate').val() == '' || regex.test(input.val()) === false){
        // เช็ควันที่ก่อตั้ง
        $('#alert_cuscompanycreate').html('<div class="alert alert-danger" role="alert">กรุณาระบุวันที่ก่อตั้งด้วยค่ะ</div>');
        $('#alert_submit').html('<div class="alert alert-danger" role="alert">กรุณาระบุวันที่ก่อตั้งด้วยค่ะ</div>');
        $('#user_submit').prop('disabled' , true);

    }else if($('#crf_customertaxid').val() == ''){
        // เช็คเลขที่ผู้เสียภาษี
        $('#alert_crf_customertaxid').html('<div class="alert alert-danger" role="alert">กรุณาระบุเลขที่ประจำตัวผู้เสียภาษีด้วยค่ะ</div>');
        $('#alert_submit').html('<div class="alert alert-danger" role="alert">กรุณาระบุเลขที่ประจำตัวผู้เสียภาษีด้วยค่ะ</div>');
        $('#user_submit').prop('disabled' , true);

    }else if(checktax($('#crf_customertaxid').val()) == false){
    
            $('#alert_crf_customertaxid').html('<div class="alert alert-danger" role="alert">กรุณาระบุเลขที่ประจำตัวผู้เสียภาษีให้ครบถ้วยทั้ง 13 หลักโดยต้องระบุเป็นตัวเลขเท่านั้น</div>');
            $('#alert_submit').html('<div class="alert alert-danger" role="alert">กรุณาระบุเลขที่ประจำตัวผู้เสียภาษีให้ครบถ้วยทั้ง 13 หลักโดยต้องระบุเป็นตัวเลขเท่านั้น</div>');
            $('#user_submit').prop('disabled' , true);

    }else if($('#crf_customerbranch').val() == ''){
        // เช็คสาขา
        $('#alert_crf_customerbranch').html('<div class="alert alert-danger" role="alert">กรุณาระบุสาขา ด้วยค่ะ</div>');
        $('#alert_submit').html('<div class="alert alert-danger" role="alert">กรุณาระบุสาขา ด้วยค่ะ</div>');
        $('#user_submit').prop('disabled' , true);

    }else if($('input:radio[name="crf_addresstype"]:checked').length < 1){
        // เช็คประเภทของที่อยู่ลูกค้า
        $('#alert_addresstype').html('<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทที่อยู่ด้วยค่ะ ด้วยค่ะ</div>');
        $('#alert_submit').html('<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทที่อยู่ด้วยค่ะ ด้วยค่ะ</div>');
        $('#user_submit').prop('disabled' , true);

    }else if($('#crf_addressname').val() == ''){
        // เช็คที่อยู่ของลูกค้า
        $('#alert_addressname').html('<div class="alert alert-danger" role="alert">กรุณาระบุที่อยู่สำหรับการเปิดใบกำกับภาษีด้วยค่ะ</div>');
        $('#alert_submit').html('<div class="alert alert-danger" role="alert">กรุณาระบุที่อยู่สำหรับการเปิดใบกำกับภาษีด้วยค่ะ</div>');
        $('#user_submit').prop('disabled' , true);

    }else if($('#crf_namecontact').val() == ''){
        $('#alert_namecontact').html('<div class="alert alert-danger" role="alert">กรุณาระบุชื่อผู้ติดต่อด้วยค่ะ</div>');
        $('#alert_submit').html('<div class="alert alert-danger" role="alert">กรุณาระบุชื่อผู้ติดต่อด้วยค่ะ</div>');
        $('#user_submit').prop('disabled' , true);

    }else if($('#crf_telcontact').val() == ''){
        $('#alert_telcontact').html('<div class="alert alert-danger" role="alert">กรุณาระบุเบอร์ผู้ติดต่อด้วยค่ะ</div>');
        $('#alert_submit').html('<div class="alert alert-danger" role="alert">กรุณาระบุเบอร์ผู้ติดต่อด้วยค่ะ</div>');
        $('#user_submit').prop('disabled' , true);

    }else if($('#crf_regiscost').val() == ''){
        $('#alert_regiscost').html('<div class="alert alert-danger" role="alert">กรุณาระบุทุนจดทะเบียนด้วยค่ะ</div>');
        $('#alert_submit').html('<div class="alert alert-danger" role="alert">กรุณาระบุทุนจดทะเบียนด้วยค่ะ</div>');
        $('#user_submit').prop('disabled' , true);

    }else if($('input:radio[name="crf_companytype"]:checked').length < 1){
        $('#alert_companytype').html('<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทบริษัทด้วยค่ะ</div>');
        $('#alert_submit').html('<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทบริษัทด้วยค่ะ</div>');
        $('#user_submit').prop('disabled' , true);

    }else if($('input:radio[name="crf_typeofbussi"]:checked').length < 1){
        $('#alert_typeofbussi').html('<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทธุรกิจด้วยค่ะ</div>');
        $('#alert_submit').html('<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทธุรกิจด้วยค่ะ</div>');
        $('#user_submit').prop('disabled' , true);

    }else if($('#crf_file1').val() == ''){
        $('#alert_file1').html('<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ ภพ.20 ด้วยค่ะ</div>');
        $('#alert_submit').html('<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ ภพ.20 ด้วยค่ะ</div>');
        $('#user_submit').prop('disabled' , true);

    }else if($('#crf_file2').val() == ''){
        $('#alert_file2').html('<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ หนังสือรับรอง ด้วยค่ะ</div>');
        $('#alert_submit').html('<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ หนังสือรับรอง ด้วยค่ะ</div>');
        $('#user_submit').prop('disabled' , true);

    }else if($('#crf_file3').val() == ''){
        $('#alert_file3').html('<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ ข้อมูลทั่วไป ด้วยค่ะ</div>');
        $('#alert_submit').html('<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ ข้อมูลทั่วไป ด้วยค่ะ</div>');
        $('#user_submit').prop('disabled' , true);

    }else if($('#crf_file4').val() == ''){
        $('#alert_file4').html('<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ งบแสดงฐานะทางการเงิน ด้วยค่ะ</div>');
        $('#alert_submit').html('<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ งบแสดงฐานะทางการเงิน ด้วยค่ะ</div>');
        $('#user_submit').prop('disabled' , true);

    }else if($('#crf_file5').val() == ''){
        $('#alert_file5').html('<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ งบกำไรขาดทุน ด้วยค่ะ</div>');
        $('#alert_submit').html('<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ งบกำไรขาดทุน ด้วยค่ะ</div>');
        $('#user_submit').prop('disabled' , true);

    }else if($('#crf_file6').val() == ''){
        $('#alert_file6').html('<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ อัตราส่วนสภาพคล่อง ด้วยค่ะ</div>');
        $('#alert_submit').html('<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ อัตราส่วนสภาพคล่อง ด้วยค่ะ</div>');
        $('#user_submit').prop('disabled' , true);

    }else if($('#crf_creditterm').val() == ''){
        $('#alert_creditterm').html('<div class="alert alert-danger" role="alert">กรุณาเลือก Credit Term ด้วยค่ะ</div>');
        $('#alert_submit').html('<div class="alert alert-danger" role="alert">กรุณาเลือก Credit Term ด้วยค่ะ</div>');
        $('#user_submit').prop('disabled' , true);
    }else if($('input:radio[name=crf_condition_bill]:checked').length < 1){
        $('#alert_condition_bill').html('<div class="alert alert-danger" role="alert">กรุณาเลือกเงื่อนไขการวางบิลด้วยค่ะ</div>');
        $('#alert_submit').html('<div class="alert alert-danger" role="alert">กรุณาเลือกเงื่อนไขการวางบิลด้วยค่ะ</div>');
        $('#user_submit').prop('disabled' , true);
    }else if($('input:radio[name="crf_condition_money"]:checked').length < 1){
        $('#alert_condition_money').html('<div class="alert alert-danger" role="alert">กรุณาเลือกเงื่อนไขการชำระเงินด้วยค่ะ</div>');
        $('#alert_submit').html('<div class="alert alert-danger" role="alert">กรุณาเลือกเงื่อนไขการชำระเงินด้วยค่ะ</div>');
        $('#user_submit').prop('disabled' , true);
    }
    else{
        $('#user_submit').prop('disabled' , false);
    }
        }
   

}else if($('input:radio[name="crf_type"]:checked').val() == 2){
    
}
    
}




// New function for control add customer manual page
function autosearchCustomermanualex(cuscode)
{
    $.ajax({
        url: '/intsys/crf/customers/searchcustomerdataex',
        method: 'POST',
        data: {
            cuscode: cuscode
        },
        success: function (data) {
            $('#autocuscodemanualex').html(data);
        }
    });
}


function autosearchCustomermanualnameex(cusname)
{
    $.ajax({
        url: '/intsys/crf/customers/searchcustomerdatanameex',
        method: 'POST',
        data: {
            cusname: cusname
        },
        success: function (data) {
            $('#autocuscodemanualnameex').html(data);
        }
    });
}



// เพิ่มล่าสุด 14-07-2020
// ตรวจสอบการกรอกข้อมูล Customer code
function checkTH(thinput) {
    var checkTH = /(^[TH]{2}-{1}[0-9]{4}$)/.test(thinput);
    return checkTH;
}

function checkTBDC(tbdcinput){
    var checkTBDC = /(^[TBDC]{4}-{1}[0-9]{4}$)/.test(tbdcinput);
    return checkTBDC;
}

function checkSTDC(tbdcinput){
    var checkTBDC = /(^[STDC]{4}-{1}[0-9]{4}$)/.test(tbdcinput);
    return checkTBDC;
}






