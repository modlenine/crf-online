/**
 * ============================================================================
 * addth-main.js - Main Initialization and Event Handlers
 * ============================================================================
 * 
 * Purpose:
 * Main initialization code for Thai customer form (add_th.php)
 * Contains $(document).ready() setup and shared event handlers
 *
 * Dependencies:
 * - jQuery
 * - addth-config.js (must load first)
 * - addth-validators.js
 * - addth-utils.js
 * - addth-api.js
 *
 * Load Order: MUST load last (after all other addth-*.js files)
 * 
 * @version 1.0.0
 * @date 2025-06-01
 */

// ============================================================================
// Main Application Initialization
// ============================================================================

$(document).ready(function () {
	// Ensure this code only runs on the Add Thai Customer page
	if ($("#checkPageAddTH").val() != "addTH") {
		return; // Exit if not on correct page
	}
	
	// ========================================================================
	// Customer Type Quick Switch Handler (NEW/OLD)
	// ========================================================================
	$('input:radio[name="crf_type"]').change(function () {
		if ($(this).val() == CUSTOMER_TYPE.NEW) {
			clearNewCustomerData();
			$("#crf_customercode").prop("disabled", true);
			$(".crf_condition_bill2, .crf_condition_bill3").css("display", "none");
			$(".suboldcustomer").css("display", "none");
			
			// สำหรับลูกค้าใหม่ ให้สามารถแก้ไขเงื่อนไขได้
			$('input:radio[name="crf_condition_bill"]').prop("disabled", false);
			$('input:radio[name="crf_condition_money"]').prop("disabled", false);
		} else if ($(this).val() == CUSTOMER_TYPE.OLD) {
			clearOldCustomerData();
			$("#crf_customercode").prop("disabled", false);
			$("#crf_textmemo").prop("readonly", true);
			
			// สำหรับลูกค้าเก่า ปิดการแก้ไขเงื่อนไขโดยเริ่มต้น
			$('input:radio[name="crf_condition_bill"]').prop("disabled", true);
			$('input:radio[name="crf_condition_money"]').prop("disabled", true);
		}
	});
	
	// ========================================================================
	// Reset Button Handler
	// ========================================================================
	$("#btnResetCustomerSearchTH").click(() => {
		clearCustomerDataTH();
	});
	
	// ========================================================================
	// Initial State Setup
	// ========================================================================
	disableAllFieldsInitial();
	$(".suboldcustomer").css("display", "none");
	
	// ========================================================================
	// Billing Condition Handlers
	// ========================================================================
	$('input:radio[name="crf_condition_bill"]').change(function () {
		if ($(this).val() == "ส่งของพร้อมวางบิล") {
			$(".crf_condition_bill2, .crf_condition_bill3").css("display", "none");
		} else if ($(this).val() == "วางบิลตามตาราง") {
			$(".crf_condition_bill2").css("display", "");
			$(".crf_condition_bill3").css("display", "none");
		} else if ($(this).val() == "วางบิลทุกวันที่") {
			$(".crf_condition_bill2").css("display", "none");
			$(".crf_condition_bill3").css("display", "");
		}
	});
	
	$('input:radio[name="crf_condition_money"]').change(function () {
		if ($(this).val() == "โอนเงิน") {
			$(".recive_cheuqe").css("display", "none");
		} else if ($(this).val() == "รับเช็ค") {
			$(".recive_cheuqe").css("display", "");
		}
	});
	
	// ========================================================================
	// Company Selection Handler - Enable Customer Type Selection
	// ========================================================================
	$('input:radio[name="crf_company"]').change(function () {
		if ($(this).val() != "") {
			$('input:radio[name="crf_type"]').prop("disabled", false);
			console.log('Company selected:', $(this).val());
			getCusProcess($(this).val());
		} else {
			$('input:radio[name="crf_type"]').prop("disabled", true);
		}
	});
	
	// ========================================================================
	// Customer Search Event Handlers
	// ========================================================================
	
	// Click handler for selecting customer by code from autocomplete
	$(document).on('click', '.selectCusCode', function () {
		const element = $(this);
		const customercode = element.attr('data_crf_customercode');
		const customername = element.attr('data_crf_customername');
		const dataareaid = element.attr('data_crf_area');
		
		// เช็คว่ามีรายการค้างหรือไม่ก่อนที่จะโหลดข้อมูล
		checkCustomerPendingOrders(customercode, dataareaid, function(response) {
			if (response.status === 'in_progress') {
				// มีรายการค้างอยู่ - ไม่อนุญาตให้ดำเนินการต่อ
				alert(`ลูกค้า ${customercode} (${customername}) มีรายการค้างอยู่\n\n` +
					  `เลขที่ฟอร์ม: ${response.form_no}\n` +
					  `สถานะ: ${response.status_name}\n\n` +
					  `กรุณาดำเนินการรายการที่ค้างให้เสร็จสิ้นก่อน\n` +
					  `จากนั้นจึงจะสามารถสร้างรายการใหม่ได้`);
				
				// ล้างข้อมูลที่กรอก
				$('#crf_customercode').val('');
				$('#autoCusCode').html('');
			} else if (response.status === 'available') {
				// ไม่มีรายการค้าง โหลดข้อมูลได้เลย
				loaddataforadd(element);
			} else {
				// เกิดข้อผิดพลาด แสดง error แต่ให้ดำเนินการต่อได้
				console.error('Error checking customer status:', response.message);
				loaddataforadd(element);
			}
		});
	});
	
	// Click handler for selecting customer by name from autocomplete
	$(document).on('click', '.selectCusName', function () {
		const element = $(this);
		const customercode = element.attr('data_crf_customercode');
		const customername = element.attr('data_crf_customername');
		const dataareaid = element.attr('data_crf_area');
		
		// เช็คว่ามีรายการค้างหรือไม่ก่อนที่จะโหลดข้อมูล
		checkCustomerPendingOrders(customercode, dataareaid, function(response) {
			if (response.status === 'in_progress') {
				// มีรายการค้างอยู่ - ไม่อนุญาตให้ดำเนินการต่อ
				alert(`ลูกค้า ${customercode} (${customername}) มีรายการค้างอยู่\n\n` +
					  `เลขที่ฟอร์ม: ${response.form_no}\n` +
					  `สถานะ: ${response.status_name}\n\n` +
					  `กรุณาดำเนินการรายการที่ค้างให้เสร็จสิ้นก่อน\n` +
					  `จากนั้นจึงจะสามารถสร้างรายการใหม่ได้`);
				
				// ล้างข้อมูลที่กรอก
				$('#crf_customername').val('');
				$('#autoCusname').html('');
			} else if (response.status === 'available') {
				// ไม่มีรายการค้าง โหลดข้อมูลได้เลย
				loaddataforadd(element);
			} else {
				// เกิดข้อผิดพลาด แสดง error แต่ให้ดำเนินการต่อได้
				console.error('Error checking customer status:', response.message);
				loaddataforadd(element);
			}
		});
	});
	
	// ========================================================================
	// Primary Manager Functions
	// ========================================================================
	
	// Add more primary manager rows
	var iPri = 1;
	$('#add_more_primanage').click(function (e) {
		iPri++;
		e.preventDefault();
		$(this).before('<div id="priManage' + iPri + '" class="row form-group">' +
			'<div class="col-md-3">' +
			'<label for="">หน่วยงาน</label>' +
			'<input type="text" name="crf_primanage_dept[]" id="crf_primanage_dept" class="form-control form-control-sm" required>' +
			'</div>' +
			'<div class="col-md-3">' +
			'<label for="">ชื่อ-สกุล</label>' +
			'<input type="text" name="crf_primanage_name[]" id="crf_primanage_name" class="form-control form-control-sm" required>' +
			'</div>' +
			'<div class="col-md-3">' +
			'<label for="">ตำแหน่ง</label>' +
			'<input type="text" name="crf_primanage_posi[]" id="crf_primanage_posi" class="form-control form-control-sm" required>' +
			'</div>' +
			'<div class="col-md-2">' +
			'<label for="">อีเมล</label>' +
			'<input type="text" name="crf_primanage_email[]" id="crf_primanage_email" class="form-control form-control-sm" required>' +
			'</div>' +
			'<div class="col-md-1 mt-4"><a href="javascript:void(0)"><button type="button" class="btn btn-danger"><i name="remove_pri" id="' + iPri + '" class="fas fa-trash-alt remove_pri"></i></button></a></div>' +
			'</div>');
	});
	
	// Remove primary manager row
	$(document).on('click', '.remove_pri', function () {
		var buttonid = $(this).attr("id");
		$('#priManage' + buttonid + '').remove();
	});
	
	// ========================================================================
	// Global Alert Handlers
	// ========================================================================
	
	// Remove alert when company is selected
	$('input[type="radio"][name=crf_company]').click(function () {
		var crf_company = $('input[type="radio"][name=crf_company]:checked');
		if (crf_company.length > 0) {
			$('#alert_company').fadeOut();
		}
	});
	
	// Check customer type selection before proceeding
	$('#crf_salesreps').focus(function () {
		var crf_type = $('input[type="radio"][name=crf_type]:checked');
		if (crf_type.length < 1) {
			$('#alert_custype').html('<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทลูกค้าด้วยค่ะ</div>');
			$('#crf_salesreps').val('');
		} else {
			$('#alert_custype').fadeOut();
		}
	});
	
	$('#crf_salesreps').keyup(function () {
		var crf_type = $('input[type="radio"][name=crf_type]:checked');
		if (crf_type.length < 1) {
			$('#alert_custype').html('<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทลูกค้าด้วยค่ะ</div>');
			$('#crf_salesreps').val('');
		} else {
			$('#alert_custype').fadeOut();
		}
	});
	
	// ========================================================================
	// Finance Number Formatting and Sync
	// ========================================================================
	
	// Setup comma formatting for financial input fields
	setupCommaFormatting('input[name="crf_regiscost"]');
	
	// Sync formatted value (with commas) to calc field (without commas)
	$('input[name="crf_finance_req_number"]').on('keyup change blur input', function() {
		// Remove commas and store in the _calc field
		var valueWithoutComma = $(this).val().replace(/,/g, '');
		$('#crf_finance_req_number_calc').val(valueWithoutComma);
		console.log('Finance sync - Display:', $(this).val(), 'Calc:', valueWithoutComma);
	});
	
	// Before form submit, ensure values are synced properly
	$('#form1').on('submit', function(e) {
		// Sync finance request number one more time before submit
		var financeDisplay = $('#crf_finance_req_number').val();
		var financeCalc = financeDisplay.replace(/,/g, '');
		$('#crf_finance_req_number_calc').val(financeCalc);
		
		console.log('Form submit - Finance Display:', financeDisplay, 'Finance Calc:', financeCalc);
	});
	
	// ========================================================================
	// File Upload Validation
	// ========================================================================
	
	// Check file format and size for all file inputs
	$('input[type=file][name=crf_file1],[name=crf_file2],[name=crf_file3],[name=crf_file4],[name=crf_file5],[name=crf_file6]').change(function () {
		var ext = $(this).val().split('.').pop().toLowerCase();
		// Allowed file types
		if ($.inArray(ext, ['pdf', 'jpg', 'png', 'jpeg', 'JPG', 'PNG']) == -1) {
			alert('อัพโหลดได้เฉพาะไฟล์นามสกุล .pdf , .jpg , .png เท่านั้น !! ' + ext);
			$(this).val("");
		}
		if (this.files[0] && this.files[0].size > 20971520) {
			alert("Maximum File size is 20MB !!");
			this.value = "";
			return false;
		}
	});
	
	// ========================================================================
	// Company Type Control Handlers
	// ========================================================================
	
	// Control form display based on company type selection
	$(document).on('click', '#crf_companytype:checked', function () {
		if ($(this).val() == 2) {
			$('#companytype2').css('display', '');
		} else {
			$('#companytype2').css('display', 'none');
		}
		
		if ($(this).val() == 3) {
			$('#companytype3').css('display', '');
		} else {
			$('#companytype3').css('display', 'none');
		}
	});
	
	// ========================================================================
	// Condition of Bill Control
	// ========================================================================
	
	$(document).on('click', 'input[name=crf_condition_bill]', function () {
		if ($(this).val() == 'วางบิลตามตาราง') {
			$('.crf_condition_bill2').css('display', '');
		} else {
			$('.crf_condition_bill2').css('display', 'none');
		}
		if ($(this).val() == 'วางบิลทุกวันที่') {
			$('.crf_condition_bill3').css('display', '');
		} else {
			$('.crf_condition_bill3').css('display', 'none');
		}
	});
	
	// ========================================================================
	// Condition of Receive Money Control (Transfer, Cheque)
	// ========================================================================
	
	$(document).on('click', 'input[name=crf_condition_money]', function () {
		if ($(this).val() == 'รับเช็ค') {
			$('.recive_cheuqe').css('display', '');
		} else {
			$('.recive_cheuqe').css('display', 'none');
		}
	});
	
	// ========================================================================
	// Condition of Finance Type
	// ========================================================================
	
	$(document).on('click', 'input[name=crf_finance]', function () {
		if ($(this).val() == 'ขอวงเงิน') {
			$('.finance_request_detail').css('display', '');
		} else {
			$('.finance_request_detail').css('display', 'none');
		}
		
		if ($(this).val() == 'ปรับวงเงิน') {
			$('.finance_change_detail').css('display', '');
		} else {
			$('.finance_change_detail').css('display', 'none');
		}
	});
	
	// ========================================================================
	// Calculate Up and Down Finance
	// ========================================================================
	
	$('#finance_change_number').keyup(function () {
		var finance_change_number = $(this).val();
		var finance_change_old = $('#finance_change_old').val();
		if ($('#finance_change_status').val() == 'เพิ่ม') {
			var total = parseInt(finance_change_old) + parseInt(finance_change_number);
		} else if ($('#finance_change_status').val() == 'ลด') {
			var total = parseInt(finance_change_old) - parseInt(finance_change_number);
		}
		$('#finance_change_total').val(total);
	});
	
	// ========================================================================
	// Credit Term Change Handler
	// >>> MOVED TO: assets/js/addth/oldcus_changecreditterm.js <<<
	// ========================================================================
	// Main Customer Type Handler (Both NEW and OLD Customer Logic)
	// ========================================================================
	
	$("input[name=crf_type]").change(function () {
		$("#checkCompany").val($(this).val());
		$("#checkCusType").val($(this).val());
		
		// Validate company selection first
		if (!validateRadioChecked('crf_company', 'alert_company', ALERT_MESSAGES.REQUIRED_COMPANY)) {
			$("input[name=crf_type]").prop("checked", false);
			return;
		}
		
		// ====================================================================
		// OLD CUSTOMER (2) Logic
		// ====================================================================
		if ($(this).val() == CUSTOMER_TYPE.OLD) {
			initializeOldCustomerHandlers();
		}
		// ====================================================================
		// NEW CUSTOMER (1) Logic
		// ====================================================================
		else if ($(this).val() == CUSTOMER_TYPE.NEW) {
			initializeNewCustomerHandlers();
		}
	});
});

// ============================================================================
// Helper Functions for Customer Initialization
// ============================================================================

/**
 * Initialize all event handlers for OLD customer type
 */
function initializeOldCustomerHandlers() {
	disableAllFieldsForOldCustomer();
	
	// Person Type Handler for OLD customer
	$('input:radio[name="crf_person_type"]').change(function () {
		if ($(this).val() == PERSON_TYPE.NATURAL) {
			$("#for_natural").css("display", "");
			$("#for_juristic").css("display", "none");
			$("#crf_file_person").prop("disabled", false);
			setFieldsDisabled(FORM_CONFIG.FILE_FIELDS, true);
		} else {
			$("#for_natural").css("display", "none");
			$("#for_juristic").css("display", "");
			setFieldsDisabled(FORM_CONFIG.FILE_FIELDS, false);
			$("#crf_file_person").prop("disabled", true);
		}
		
		// Enable customer code when person type is selected
		if ($(this).val() != "") {
			$("#crf_customercode").prop("disabled", false);
		}
		
		// อัปเดตสถานะ crf_file1 เมื่อเปลี่ยน person type
		updateCrfFile1Status();
	});
	
	// Customer Code Search with Debounce
	$("#crf_customercode").on("keyup", function () {
		const cusCode = $(this).val().trim();
		
		// Cancel previous timeout
		if (searchTimeout) {
			clearTimeout(searchTimeout);
		}
		
		// Cancel previous AJAX request
		if (currentRequest) {
			currentRequest.abort();
		}
		
		if (cusCode !== "") {
			// Show loading state
			$("#autoCusCode").html('<div class="text-muted small p-2"><i>กำลังค้นหา...</i></div>');
			
			// Debounce: wait 300ms after last keystroke
			searchTimeout = setTimeout(() => {
				autoSearchCustomerDetail(cusCode);
			}, 300);
		} else {
			$("#autoCusCode").html("");
		}
	});
	
	// Customer Name Search with Debounce
	$("#crf_customername").on("keyup", function () {
		const cusname = $(this).val().trim();
		
		// Cancel previous timeout
		if (searchTimeout) {
			clearTimeout(searchTimeout);
		}
		
		if (cusname !== "") {
			// Show loading state
			$("#autoCusname").html('<div class="text-muted small p-2"><i>กำลังค้นหา...</i></div>');
			
			// Debounce: wait 300ms
			searchTimeout = setTimeout(() => {
				autoSearchCustomerDetailName(cusname);
			}, 300);
		} else {
			$("#autoCusname").html("");
		}
	});
	
	// Show old customer options
	$(".suboldcustomer").css("display", "");
	$("#crf_customercode").prop("readonly", false);
	$("#crf_customername").prop("disabled", false);
	$(".finance_request_detail").css("display", "");
	$("#crf_finance_req_number").prop("readonly", true);
	
	// Initialize all OLD customer checkbox handlers
	initializeOldCustomerCheckboxHandlers();
	
	// Initialize all OLD customer validation handlers
	initializeOldCustomerValidationHandlers();
	
	// Clear and reset certain fields
	$("#crf_finance").prop("checked", false);
	$("#alert_salesreps").html("");
	$("#crf_salesreps").val("");
}

/**
 * Initialize all event handlers for NEW customer type
 */
function initializeNewCustomerHandlers() {
	// Enable all fields for new customer
	enableAllFieldsForNewCustomer();
	
	// Pre-check finance type and show finance detail
	$('input:radio[class="crf_financev1"]').prop("checked", true);
	$(".finance_request_detail").css("display", "");
	
	// Show/hide sections
	$(".newPrimanage").css("display", "");
	$("#showPrimanage").css("display", "none");
	
	// Person Type Handler for NEW customer
	$('input:radio[name="crf_person_type"]').click(function () {
		if ($(this).val() == PERSON_TYPE.NATURAL) {
			$("#for_natural").css("display", "");
			$("#for_juristic").css("display", "none");
			$("#crf_file_person").prop("disabled", false);
			setFieldsDisabled(FORM_CONFIG.FILE_FIELDS, true);
			
			$("#crf_file_person").change(function () {
				if ($(this).val() != "") {
					$("#user_submit").prop("disabled", false);
				}
			});
		} else if ($(this).val() == PERSON_TYPE.JURISTIC) {
			$("#for_natural").css("display", "none");
			$("#for_juristic").css("display", "");
			$("#crf_file_person").prop("disabled", true);
			setFieldsDisabled(FORM_CONFIG.FILE_FIELDS, false);
		}
	});
	
	// Initialize NEW customer validation handlers
	initializeNewCustomerValidationHandlers();
}

/**
 * Load customer data into form fields after selection
 * @param {jQuery} element - The clicked customer element with data attributes
 */
function loaddataforadd(element) {
	// Extract all customer data from element attributes
	let data_crf_salesreps = element.attr('data_crf_salesreps');
	let data_crf_customername = element.attr('data_crf_customername');
	let data_crf_cuscompanycreate = element.attr('data_crf_cuscompanycreate');
	let data_crf_addressname = element.attr('data_crf_addressname');
	let data_crf_namecontact = element.attr('data_crf_namecontact');
	let data_crf_telcontact = element.attr('data_crf_telcontact');
	let data_crf_faxcontact = element.attr('data_crf_faxcontact');
	let data_crf_emailcontact = element.attr('data_crf_emailcontact');
	let data_crf_regiscost = element.attr('data_crf_regiscost');
	let data_crf_customercode = element.attr('data_crf_customercode');
	let data_oldcfr_addresstype = element.attr('data_oldcfr_addresstype');
	let data_crf_companytype = element.attr('data_crf_companytype');
	let data_crf_companytype3_1_1 = element.attr('data_crf_companytype3_1_1');
	let data_crf_companytype3_1_2 = element.attr('data_crf_companytype3_1_2');
	let data_crf_companytype3_2_1 = element.attr('data_crf_companytype3_2_1');
	let data_crf_companytype3_2_2 = element.attr('data_crf_companytype3_2_2');
	let data_crf_companytype2 = element.attr('data_crf_companytype2');
	let data_crf_typeofbussi = element.attr('data_crf_typeofbussi');
	let data_crf_forecast = element.attr('data_crf_forecast');
	let data_crf_textmemo = element.attr('data_crf_textmemo');
	let data_credit_name = element.attr('data_credit_name');
	let data_credit_id = element.attr('data_credit_id');
	let data_crf_condition_bill = element.attr('data_crf_condition_bill');
	let data_crf_tablebill = element.attr('data_crf_tablebill');
	let data_crf_mapbill = element.attr('data_crf_mapbill');
	let data_crf_datebill = element.attr('data_crf_datebill');
	let data_crf_mapbill2 = element.attr('data_crf_mapbill2');
	let data_crf_condition_money = element.attr('data_crf_condition_money');
	let data_crf_recive_cheuqetable = element.attr('data_crf_recive_cheuqetable');
	let data_crf_recive_cheuqedetail = element.attr('data_crf_recive_cheuqedetail');
	let data_crf_finance_req_number = element.attr('data_crf_finance_req_number');
	let data_crf_cusid = element.attr('data_crf_cusid');
	let data_crf_creditterm2 = element.attr('data_crf_creditterm2');
	let data_crf_creditterm2name = element.attr('data_crf_creditterm2name');
	let data_crf_moneylimit = element.attr('data_crf_moneylimit');
	let data_crf_area = element.attr('data_crf_area');
	let data_crf_file1 = element.attr('data_crf_file1');
	let data_crf_taxid = element.attr('data_crf_taxid');
	let data_crf_branch = element.attr('data_crf_branch');
	let data_crf_mapurl = element.attr('data_crf_mapurl');
	let data_crf_mapfile = element.attr('data_crf_mapfile');
	let data_crfcus_products = element.attr('data_crfcus_products');
	let data_crfcus_personal = element.attr('data_crfcus_personal');
	let data_crfcus_file1 = element.attr('data_crfcus_file1');
	let data_crfcus_file2 = element.attr('data_crfcus_file2');
	let data_crfcus_file3 = element.attr('data_crfcus_file3');
	let data_crfcus_file4 = element.attr('data_crfcus_file4');
	let data_crfcus_file5 = element.attr('data_crfcus_file5');
	let data_crfcus_file6 = element.attr('data_crfcus_file6');
	let data_crfcus_memo2 = element.attr('data_crfcus_memo2');
	let data_crfcus_countmonthdeli = element.attr('data_crfcus_countmonthdeli');
	let data_ax_creditmaxvalue = element.attr('data_ax_creditmaxvalue');
	let data_ax_creditusedvalue = element.attr('data_ax_creditusedvalue');
	let data_ax_creditavailvalue = element.attr('data_ax_creditavailvalue');
	
	let base_url = $('#checkbaseurl').val();
	
	// Debug log
	console.log('Customer selected:', {
		code: data_crf_customercode,
		name: data_crf_customername,
		area: data_crf_area,
		cusid: data_crf_cusid
	});
	
	// Store old file references (for not changing attached files)
	$('#editcusoldpersonal').val(data_crfcus_personal);
	$('#editcusoldfile1').val(data_crfcus_file1);
	$('#editcusoldfile2').val(data_crfcus_file2);
	$('#editcusoldfile3').val(data_crfcus_file3);
	$('#editcusoldfile4').val(data_crfcus_file4);
	$('#editcusoldfile5').val(data_crfcus_file5);
	$('#editcusoldfile6').val(data_crfcus_file6);
	
	// Set values for billing and payment condition files
	$('#editcusoldtablebill').val(data_crf_tablebill);
	$('#editcusoldmapbill').val(data_crf_mapbill);
	$('#editcusoldmapbill2').val(data_crf_mapbill2);
	$('#editcusoldcheuqetable').val(data_crf_recive_cheuqetable);
	
	// Setup file display links with modal handlers
	setupFileDisplayLinks(base_url, data_crfcus_personal, data_crfcus_file1, data_crfcus_file2, 
						   data_crfcus_file3, data_crfcus_file4, data_crfcus_file5, data_crfcus_file6);
	
	// Set form field values
	$('#crf_customercode').val(data_crf_customercode);
	$('#crf_salesreps').val(data_crf_salesreps);
	$('#crf_customername').val(data_crf_customername);
	$('#crf_cuscompanycreate').val(data_crf_cuscompanycreate);
	$('#crf_addressname').val(data_crf_addressname);
	$('#crf_namecontact').val(data_crf_namecontact);
	$('#crf_telcontact').val(data_crf_telcontact);
	$('#crf_faxcontact').val(data_crf_faxcontact);
	$('#crf_emailcontact').val(data_crf_emailcontact);
	$('#crf_regiscost').val(data_crf_regiscost);
	$('#crf_forecast').val(data_crf_forecast);
	$('#crf_textmemo').val(data_crf_textmemo);
	$('#crf_customertaxid').val(data_crf_taxid);
	$('#crf_customerbranch').val(data_crf_branch);
	$('#getmapurl_addpage').val(data_crf_mapurl);
	$('#getlinkgooglemap').attr('href', data_crf_mapurl);
	$('#mapfilelink').attr('data_mapfile', data_crf_mapfile);
	$('#getmapfile_addpage').val(data_crf_mapfile);
	$('#crf_customer_product').val(data_crfcus_products);
	$('#crf_creditterm option:selected').val(data_credit_id).text(data_credit_name);
	$('#oldCreditTerm').val(data_credit_id);
	
	// Set finance request number with proper formatting
	let financeValue = data_ax_creditmaxvalue;
	console.log('Loading from DB - Raw value:', financeValue);
	$('#crf_finance_req_number_calc').val(financeValue);
	$('#crf_finance_req_number').val(financeValue);
	$('#crf_cusid').val(data_crf_cusid);
	
	// Set company area radio buttons
	if (data_crf_area == 'sln') {
		$('#crf_company_sln').prop('checked', true);
	} else if (data_crf_area == 'poly') {
		$('#crf_company_poly').prop('checked', true);
	} else if (data_crf_area == 'ca') {
		$('#crf_company_ca').prop('checked', true);
	}
	$('#addThArea').val(data_crf_area);
	
	// Set address type
	if (data_oldcfr_addresstype == "ตาม ภ.พ.20") {
		$('input:radio[id="crf_addresstype1"]').prop('checked', true);
	} else {
		$('input:radio[id="crf_addresstype2"]').prop('checked', true);
	}
	
	// Set company type
	setCompanyTypeRadioButtons(data_crf_companytype, data_crf_companytype2, data_crf_companytype3_1_1,
								 data_crf_companytype3_1_2, data_crf_companytype3_2_1, data_crf_companytype3_2_2);
	
	// Set business type
	if (data_crf_typeofbussi == 'ผู้ผลิต') {
		$('input:radio[class="crf_typeofbussi1"]').prop('checked', true);
	} else {
		$('input:radio[class="crf_typeofbussi2"]').prop('checked', true);
	}
	
	// Load process and primary manager data
	$('.newPrimanage').css('display', 'none');
	$('#showPrimanage').css('display', '');
	queryProcessUse(data_crf_cusid);
	queryPrimanageUse(data_crf_cusid);
	
	// Set billing conditions
	setBillingConditions(data_crf_condition_bill, data_crf_tablebill, data_crf_mapbill, 
						 data_crf_datebill, data_crf_mapbill2);
	
	// Set payment conditions
	setPaymentConditions(data_crf_condition_money, data_crf_recive_cheuqetable, data_crf_recive_cheuqedetail);
	
	// Set delivery month counting
	if (data_crfcus_countmonthdeli && data_crfcus_countmonthdeli !== '' && 
		data_crfcus_countmonthdeli !== 'null' && data_crfcus_countmonthdeli !== 'undefined') {
		if (data_crfcus_countmonthdeli == "เดือนส่งของไม่นับ") {
			$('#crfcus_countmonthdeli1').prop('checked', true);
		} else if (data_crfcus_countmonthdeli == "นับเดือนส่งของ") {
			$('#crfcus_countmonthdel2').prop('checked', true);
		}
	} else {
		$('input[name="crfcus_countmonthdeli"]').prop('checked', false);
	}
	
	$('#crfcus_memo2').val(data_crfcus_memo2);
	
	// Format registered cost with commas
	$('#crf_regiscost').val(function (index, value) {
		return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	});
	
	// Clear autocomplete dropdowns
	$('#autoCusCode').html('');
	$('#autoCusname').html('');
	$('input:checkbox[id="crf_sub_oldcus"]').attr('onclick', 'return false');
	
	// Lock customer fields after successful selection
	lockCustomerFieldsTH();
}

// ============================================================================
// Helper Functions for Data Loading
// ============================================================================

/**
 * Setup file display links with modal popup handlers
 */
function setupFileDisplayLinks(base_url, personal, file1, file2, file3, file4, file5, file6) {
	const url = base_url + 'upload/';
	
	// Personal file (opens in new tab)
	$('#cus2showfilePersonal').html('<span><a id="custype2filePersonal" href="' + url + personal + '" target="_blank">' +  personal + '</a></span>');
	
	// File 1-6 with modal popups	$('#cus2showfile1').html('<span><a id="custype2file1" href="#" data-toggle="modal" data-target="#show_file1" data_cus2file1="' + file1 + '">' + file1 + '</a></span>');
	setupFileModalHandler('custype2file1', 'data_cus2file1', url, 'embedshowfile1', 'embedshowfile1Img');
	
	$('#cus2showfile2').html('<span><a id="custype2file2" href="#" data-toggle="modal" data-target="#show_file2" data_cus2file2="' + file2 + '">' + file2 + '</a></span>');
	setupFileModalHandler('custype2file2', 'data_cus2file2', url, 'embedshowfile2', 'embedshowfile2Img');
	
	$('#cus2showfile3').html('<span><a id="custype2file3" href="#" data-toggle="modal" data-target="#show_file3" data_cus2file3="' + file3 + '">' + file3 + '</a></span>');
	setupFileModalHandler('custype2file3', 'data_cus2file3', url, 'embedshowfile3', 'embedshowfile3Img');
	
	$('#cus2showfile4').html('<span><a id="custype2file4" href="#" data-toggle="modal" data-target="#show_file4" data_cus2file4="' + file4 + '">' + file4 + '</a></span>');
	setupFileModalHandler('custype2file4', 'data_cus2file4', url, 'embedshowfile4', 'embedshowfile4Img');
	
	$('#cus2showfile5').html('<span><a id="custype2file5" href="#" data-toggle="modal" data-target="#show_file5" data_cus2file5="' + file5 + '">' + file5 + '</a></span>');
	setupFileModalHandler('custype2file5', 'data_cus2file5', url, 'embedshowfile5', 'embedshowfile5Img');
	
	$('#cus2showfile6').html('<span><a id="custype2file6" href="#" data-toggle="modal" data-target="#show_file6" data_cus2file6="' + file6 + '">' + file6 + '</a></span>');
	setupFileModalHandler('custype2file6', 'data_cus2file6', url, 'embedshowfile6', 'embedshowfile6Img');
}

/**
 * Setup individual file modal handler (checks file type to show image vs PDF)
 */
function setupFileModalHandler(linkId, dataAttr, baseUrl, embedId, imgId) {
	$('#' + linkId).click(function () {
		var dataFile = $(this).attr(dataAttr);
		var cutFileType = dataFile.substr(-3, 4).toLowerCase();
		
		if (cutFileType == 'jpg' || cutFileType == 'png') {
			$('#' + imgId).attr('src', baseUrl + dataFile).show();
			$('#' + embedId).hide();
		} else {
			$('#' + embedId).attr('src', baseUrl + dataFile).show();
			$('#' + imgId).hide();
		}
	});
}

/**
 * Set company type radio buttons and display appropriate fields
 */
function setCompanyTypeRadioButtons(type, type2, type3_1_1, type3_1_2, type3_2_1, type3_2_2) {
	if (type == 1) {
		$('input:radio[class="crf_companytype1"]').prop('checked', true);
	} else if (type == 2) {
		$('input:radio[class="crf_companytype2"]').prop('checked', true);
		$('#companytype2').css('display', '');
		$('#crf_companytype2').val(type2);
	} else {
		$('input:radio[class="crf_companytype3"]').prop('checked', true);
		$('#companytype3').css('display', '');
		$('#crf_companytype3_1_1').val(type3_1_1);
		$('#crf_companytype3_1_2').val(type3_1_2);
		$('#crf_companytype3_2_1').val(type3_2_1);
		$('#crf_companytype3_2_2').val(type3_2_2);
	}
}

/**
 * Set billing condition radio buttons and display appropriate fields
 */
function setBillingConditions(condition, tablebill, mapbill, datebill, mapbill2) {
	if (condition == 'ส่งของพร้อมวางบิล') {
		$('input:radio[class="crf_condition_billv1"]').prop('checked', true);
	} else if (condition == 'วางบิลตามตาราง') {
		$('input:radio[class="crf_condition_billv2"]').prop('checked', true);
		$('.crf_condition_bill2').css('display', '');
		$('.oldcustomer1').css('display', '').val(tablebill).prop('readonly', true);
		$('.oldcustomer2').css('display', '').val(mapbill).prop('readonly', true);
		$('.newcustomer1, .newcustomer2').remove();
	} else if (condition == 'วางบิลทุกวันที่') {
		$('input:radio[class="crf_condition_billv3"]').prop('checked', true);
		$('.crf_condition_bill3').css('display', '');
		$('#crf_datebill').val(datebill);
		$('.newcustomer3').remove();
		$('.oldcustomer3').css('display', '').val(mapbill2);
	}
}

/**
 * Set payment condition radio buttons and display appropriate fields
 */
function setPaymentConditions(condition, chequetable, chequedetail) {
	if (condition == "โอนเงิน") {
		$('input:radio[class="crf_condition_moneyv1"]').prop('checked', true);
	} else if (condition == "รับเช็ค") {
		$('input:radio[class="crf_condition_moneyv2"]').prop('checked', true);
		$('.recive_cheuqe').css('display', '');
		$('.newcustomer4').remove();
		$('.oldcustomer4').css('display', '').val(chequetable).prop('readonly', true);
		$('#crf_recive_cheuqedetail').val(chequedetail).prop('readonly', true);
	}
}
