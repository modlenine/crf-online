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


function autoSearchCustomerDetail(cusCode) {
    $.ajax({
        url: 'main/searchCustomerDetail',
        method: 'POST',
        data: {
            cusCode: cusCode
        },
        success: function (data) {
            $('#autoCusCode').html(data);
        }
    });
}

function autoSearchCustomerDetailName(cusName){
    $.ajax({
        url: 'main/searchCustomerDetailName',
        method: 'POST',
        data: {
            cusName: cusName
        },
        success: function(data){
            $('#autoCusname').html(data);
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
            $('#showPrimanage').html(data);
            // $('.newPrimanage').remove();
        }
    });
}

function filterCreditTerm(oldCredit, creditMethod) {
    $.ajax({
        url: 'main/filterCreditTerm',
        method: 'POST',
        data: {
            oldCredit: oldCredit,
            creditMethod: creditMethod
        },
        success: function (data) {
            $('#showNewCredit').html(data);
        }
    });
}


function checkDuplicateNameCustomer(cusName , comName) {
    $.ajax({
        url: 'main/checkDuplicateNameCustomer',
        method: 'POST',
        data: {
            cusName: cusName,
            comName: comName
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


// Check Cuscode manual duplicate
function checkCuscodeManual(cuscode , area)
{
    $.ajax({
        url:"/intsys/crf/customers/fetchCustomercode",
        method:"POST",
        data:{
            cuscode:cuscode,
            area:area
        },
        success:function(data){
            if(data > 0){
                $('#alertCuscode').fadeIn();
                $('#alertCuscode').html('<div class="alert alert-danger" role="alert">พบข้อมูลซ้ำในระบบ</div>').fadeOut(3500);
                $('#addcus_customercode').val('');
            }
        }
    });
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
        url:"/instsys/crf/customers/fetchCustomercodeEx",
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





