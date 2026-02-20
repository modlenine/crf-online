// ============================================================================
// Constants & Configuration
// ============================================================================

// Global variables for search management
let searchTimeout = null;
let currentRequest = null;

const CUSTOMER_TYPE = {
	NEW: '1',
	OLD: '2'
};

const PERSON_TYPE = {
	NATURAL: 'natural',
	JURISTIC: 'juristic'
};

const FORM_CONFIG = {
	CUSTOMER_FIELDS: [
		'#crf_salesreps', '#crf_customername', '#crf_cuscompanycreate',
		'#crf_customertaxid', '#crf_customerbranch', '#crf_addressname',
		'#crf_namecontact', '#crf_telcontact', '#crf_faxcontact',
		'#crf_emailcontact', '#crf_regiscost', '#crf_mapurl', '#crf_mapfile'
	],
	RADIO_FIELDS: [
		'crf_addresstype', 'crf_companytype', 'crf_typeofbussi',
		'crf_condition_bill', 'crf_condition_money', 'crf_finance'
	],
	FILE_FIELDS: [
		'#crf_file1', '#crf_file2', '#crf_file3',
		'#crf_file4', '#crf_file5', '#crf_file6'
	],
	OTHER_FIELDS: [
		'#crf_customer_product', '#crf_forecast', '#crf_creditterm'
	]
};

const ALERT_MESSAGES = {
	REQUIRED_COMPANY: 'กรุณาเลือกบริษัทด้วยค่ะ',
	REQUIRED_CUSTOMER_TYPE: 'กรุณาเลือกประเภทลูกค้าด้วยค่ะ',
	REQUIRED_PERSON_TYPE: 'กรุณาเลือกประเภทลูกค้าด้วยค่ะ',
	REQUIRED_SUB_TYPE: 'กรุณาเลือกประเภทการดำเนินการด้วยค่ะ',
	REQUIRED_SALES_REPS: 'กรุณาระบุข้อมูล Sales Reps ด้วยค่ะ',
	INVALID_SALES_REPS: 'รูปแบบ Sales Reps ไม่ถูกต้อง (D#### หรือ M####)',
	REQUIRED_CUSTOMER_NAME: 'กรุณาระบุชื่อลูกค้าด้วยค่ะ',
	REQUIRED_COMPANY_DATE: 'กรุณาระบุวันที่ก่อตั้งด้วยค่ะ',
	REQUIRED_ADDRESS_TYPE: 'กรุณาเลือกที่อยู่สำหรับเปิดใบกำกับภาษีด้วยค่ะ',
	REQUIRED_FILE_PP20: 'กรุณาอัพโหลดไฟล์ ภพ20 ด้วยค่ะ',
	REQUIRED_FILE_ID: 'กรุณาอัพโหลดไฟล์ สำเนาบัตรประชาชน ด้วยค่ะ',
	INVALID_TAX_ID: 'เลขที่ผู้เสียภาษีต้องเป็นตัวเลข 13 หลัก',
	INVALID_TELEPHONE: 'เบอร์โทรศัพท์ต้องเป็นตัวเลข 8-15 หลัก'
};

// ============================================================================
// Utility Functions - Form Control
// ============================================================================

/**
 * Lock customer fields after selection
 */
const lockCustomerFieldsTH = () => {
	$("#crf_customercode").prop("readonly", true).addClass("bg-light");
	
	// ตรวจสอบว่าได้ติ๊ก "เปลี่ยนที่อยู่" หรือไม่ ถ้าติ๊กอยู่ก็ไม่ล็อกฟิลด์ที่อยู่และข้อมูลติดต่อ
	const isChangeAddress = $('input:checkbox[name="crf_sub_oldcus_changeaddress"]').prop("checked");
	// ตรวจสอบว่าได้ติ๊ก "แก้ไขข้อมูลลูกค้า" หรือไม่
	const isEditCustomer = $('input:checkbox[name="crf_sub_oldcus_editcustomer"]').prop("checked");
	// ตรวจสอบว่าได้ติ๊ก "เปลี่ยนเขตการขาย" หรือไม่
	const isChangeArea = $('input:checkbox[name="crf_sub_oldcus_changearea"]').prop("checked");
	
	// ล็อกฟิลด์ข้อมูลลูกค้าพื้นฐาน (ถ้าไม่ได้ติ๊ก "แก้ไขข้อมูลลูกค้า")
	if (!isEditCustomer) {
		$("#crf_customername").prop("readonly", true).addClass("bg-light");
		$("#crf_customertaxid").prop("readonly", true).addClass("bg-light");
		$("#crf_customerbranch").prop("readonly", true).addClass("bg-light");
		$("#crf_cuscompanycreate").prop("readonly", true).addClass("bg-light");
	}
	
	// ล็อก Sales Reps (ถ้าไม่ได้ติ๊ก "เปลี่ยนเขตการขาย")
	if (!isChangeArea) {
		$("#crf_salesreps").prop("readonly", true).addClass("bg-light");
	}
	
	// ล็อกฟิลด์ที่อยู่และข้อมูลติดต่อ (ถ้าไม่ได้ติ๊ก "เปลี่ยนที่อยู่")
	if (!isChangeAddress) {
		$("#crf_addressname").prop("readonly", true).addClass("bg-light");
		$("#crf_telcontact").prop("readonly", true).addClass("bg-light");
		$("#crf_faxcontact").prop("readonly", true).addClass("bg-light");
		$("#crf_emailcontact").prop("readonly", true).addClass("bg-light");
		$("#crf_namecontact").prop("readonly", true).addClass("bg-light");
	}
	
	// ล็อกเงื่อนไขการวางบิลและการรับชำระเงิน (ถ้าไม่ได้ติ๊ก "แก้ไขข้อมูลลูกค้า")
	if (!isEditCustomer) {
		$('input:radio[name="crf_condition_bill"]').prop("disabled", true);
		$('input:radio[name="crf_condition_money"]').prop("disabled", true);
	}
	
	// Show reset button
	$("#btnResetCustomerSearchTH").fadeIn();
};

/**
 * Unlock customer fields
 */
const unlockCustomerFieldsTH = () => {
	$("#crf_customercode").prop("readonly", false).removeClass("bg-light");
	$("#crf_customername").prop("readonly", false).removeClass("bg-light");
	$("#crf_customertaxid").prop("readonly", false).removeClass("bg-light");
	$("#crf_addressname").prop("readonly", false).removeClass("bg-light");
	$("#crf_telcontact").prop("readonly", false).removeClass("bg-light");
	$("#crf_faxcontact").prop("readonly", false).removeClass("bg-light");
	$("#crf_emailcontact").prop("readonly", false).removeClass("bg-light");
	$("#crf_namecontact").prop("readonly", false).removeClass("bg-light");
	
	// ปลดล็อกเงื่อนไขการวางบิลและการรับชำระเงิน
	$('input:radio[name="crf_condition_bill"]').prop("disabled", false);
	$('input:radio[name="crf_condition_money"]').prop("disabled", false);
	
	// Hide reset button
	$("#btnResetCustomerSearchTH").fadeOut();
};

/**
 * Clear customer data and reload page
 */
const clearCustomerDataTH = () => {
	// Refresh the page to reset all fields
	location.reload();
};

/**
 * Toggle multiple form fields disabled state
 * @param {Array} selectors - Array of jQuery selectors
 * @param {Boolean} disabled - true to disable, false to enable
 */
function setFieldsDisabled(selectors, disabled) {
	selectors.forEach(selector => {
		// Use 'readonly' for text inputs and textareas, 'disabled' for file inputs
		if ($(selector).is('input[type="file"]')) {
			$(selector).prop('disabled', disabled);
		} else {
			$(selector).prop('readonly', disabled);
		}
	});
}

/**
 * Toggle radio button groups disabled state
 * @param {Array} names - Array of radio button names
 * @param {Boolean} disabled - true to disable, false to enable
 */
function setRadiosDisabled(names, disabled) {
	names.forEach(name => {
		$(`input:radio[name="${name}"]`).prop('disabled', disabled);
	});
}

/**
 * Enable all form fields for new customer
 */
function enableAllFieldsForNewCustomer() {
	setFieldsDisabled(FORM_CONFIG.CUSTOMER_FIELDS, false);
	setFieldsDisabled(FORM_CONFIG.FILE_FIELDS, false);
	setFieldsDisabled(FORM_CONFIG.OTHER_FIELDS, false);
	setRadiosDisabled(FORM_CONFIG.RADIO_FIELDS, false);
	$('#user_submit').prop('disabled', false);
}

/**
 * Disable all form fields for old customer
 */
function disableAllFieldsForOldCustomer() {
	setFieldsDisabled(FORM_CONFIG.CUSTOMER_FIELDS, true);
	setFieldsDisabled(FORM_CONFIG.FILE_FIELDS, true);
	setFieldsDisabled(FORM_CONFIG.OTHER_FIELDS, true);
	setRadiosDisabled(FORM_CONFIG.RADIO_FIELDS, true);
	$('#user_submit').prop('disabled', true);
}

/**
 * Disable all fields on initial page load
 */
function disableAllFieldsInitial() {
	$('input:radio[name="crf_type"]').prop("disabled", true);
	disableAllFieldsForOldCustomer();
}

// ============================================================================
// Utility Functions - Validation & Alerts
// ============================================================================

/**
 * Show alert message in specified container
 * @param {String} containerId - ID of alert container (without #)
 * @param {String} message - Alert message to display
 * @param {String} type - Alert type (danger, success, warning, info)
 */
function showAlert(containerId, message, type = 'danger') {
	$(`#${containerId}`).html(
		`<div class="alert alert-${type}" role="alert">${message}</div>`
	).fadeIn();
}

/**
 * Clear alert message from container
 * @param {String} containerId - ID of alert container (without #)
 */
function clearAlert(containerId) {
	$(`#${containerId}`).html('').fadeOut();
}

/**
 * Validate field is not empty
 * @param {String} fieldId - Field ID to validate (with #)
 * @param {String} alertId - Alert container ID (without #)
 * @param {String} message - Error message
 * @returns {Boolean} true if valid, false if invalid
 */
function validateRequired(fieldId, alertId, message) {
	const value = $(fieldId).val();
	if (!value || value.trim() === '') {
		showAlert(alertId, message);
		return false;
	}
	clearAlert(alertId);
	return true;
}

/**
 * Validate radio button group is checked
 * @param {String} radioName - Radio button name
 * @param {String} alertId - Alert container ID (without #)
 * @param {String} message - Error message
 * @returns {Boolean} true if checked, false if not
 */
function validateRadioChecked(radioName, alertId, message) {
	const checked = $(`input:radio[name="${radioName}"]:checked`);
	if (checked.length < 1) {
		showAlert(alertId, message);
		return false;
	}
	clearAlert(alertId);
	return true;
}

/**
 * Validate checkbox is checked
 * @param {String} checkboxId - Checkbox ID
 * @param {String} alertId - Alert container ID (without #)
 * @param {String} message - Error message
 * @returns {Boolean} true if checked, false if not
 */
function validateCheckboxChecked(checkboxId, alertId, message) {
	const checked = $(`input:checkbox[id="${checkboxId}"]:checked`);
	if (checked.length < 1) {
		showAlert(alertId, message);
		return false;
	}
	clearAlert(alertId);
	return true;
}

// ============================================================================
// Utility Functions - Form Data
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

/**
 * Get current customer type (1=new, 2=old)
 * @returns {String} Customer type value
 */
function getCurrentCustomerType() {
	return $('input:radio[name="crf_type"]:checked').val();
}

/**
 * Get current person type (natural/juristic)
 * @returns {String} Person type value
 */
function getCurrentPersonType() {
	return $('input:radio[name="crf_person_type"]:checked').val();
}

/**
 * Get current company
 * @returns {String} Company value
 */
function getCurrentCompany() {
	return $('input:radio[name="crf_company"]:checked').val();
}

/**
 * Clear old customer specific data
 */
function clearOldCustomerData() {
	$(
		"#crf_customercode , #crf_cusid , #crf_salesreps , #crf_customername , #crf_cuscompanycreate , #crf_customertaxid , #crf_customerbranch , #crf_addressname , #crf_namecontact , #crf_telcontact , #crf_faxcontact , #crf_emailcontact , #crf_regiscost , #crf_mapurl , #crf_mapfile , #crf_customer_product , #crf_forecast , #crf_file1 ,#crf_file2 , #crf_file3 , #crf_file4 , #crf_file5 , #crf_file6 ,  #crf_finance_req_number ,#oldCreditTerm"
	).val("");
	
	$('input:radio[name="crf_addresstype"]').prop("checked", false);
	$('input:radio[name="crf_companytype"]').prop("checked", false);
	$('input:radio[name="crf_typeofbussi"]').prop("checked", false);
	$('input:radio[name="crf_condition_bill"]').prop("checked", false);
	$('input:radio[name="crf_condition_money"]').prop("checked", false);
	$('input:radio[name="crf_finance"]').prop("checked", false);
}

/**
 * Clear new customer specific data
 */
function clearNewCustomerData() {
	$(
		"#crf_customercode , #crf_cusid , #crf_customername , #crf_cuscompanycreate , #crf_customertaxid , #crf_customerbranch , #crf_addressname , #crf_namecontact , #crf_telcontact , #crf_faxcontact , #crf_emailcontact , #crf_regiscost , #crf_mapurl , #crf_mapfile , #crf_customer_product , #crf_forecast , #crf_file1 ,#crf_file2 , #crf_file3 , #crf_file4 , #crf_file5 , #crf_file6 , #crf_finance_req_number , #oldCreditTerm , #crf_creditterm"
	).val("");
	
	$("#crf_salesreps").val($("#crf_userecodepost").val());
	
	$('input:radio[name="crf_addresstype"]').prop("checked", false);
	$('input:radio[name="crf_companytype"]').prop("checked", false);
	$('input:radio[name="crf_typeofbussi"]').prop("checked", false);
	$('input:radio[name="crf_condition_bill"]').prop("checked", false);
	$('input:radio[name="crf_condition_money"]').prop("checked", false);
	$('input:radio[class="crf_financev1"]').prop("checked", true);
	$("input:checkbox").prop("checked", false);
}

/**
 * ฟังก์ชันตรวจสอบและควบคุมสถานะของฟิลด์ crf_file1
 */
function updateCrfFile1Status() {
	const isChangeAddress = $('input:checkbox[name="crf_sub_oldcus_changeaddress"]').prop("checked");
	const isEditCustomer = $('input:checkbox[name="crf_sub_oldcus_editcustomer"]').prop("checked");
	const isJuristicPerson = $('input:radio[name="crf_person_type"]:checked').val() === "juristic";
	
	// เปิดใช้งาน crf_file1 หาก:
	// 1. เลือก "เปลี่ยนที่อยู่" และเป็น juristic person
	// 2. เลือก "แก้ไขข้อมูลลูกค้า" และเป็น juristic person
	if ((isChangeAddress || isEditCustomer) && isJuristicPerson) {
		$("#crf_file1").prop("disabled", false);
	} else {
		$("#crf_file1").prop("disabled", true);
	}
}

// ============================================================================
// Main Application Code
// ============================================================================

$(document).ready(function () {
	if ($("#checkPageAddTH").val() == "addTH") {
		// Quick switch handler for customer type (NEW/OLD) at top of form
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
				
				// สำหรับลูกค้าเก่า ปิดการแก้ไขเงื่อนไขโดยเริ่มต้น (ต้องเลือก checkbox แก้ไขข้อมูลลูกค้า)
				$('input:radio[name="crf_condition_bill"]').prop("disabled", true);
				$('input:radio[name="crf_condition_money"]').prop("disabled", true);
			}
		});
	}

	if ($("#checkPageAddTH").val() == "addTH") {
		// Reset button click handler
		$("#btnResetCustomerSearchTH").click(() => {
			clearCustomerDataTH();
		});

		disableAllFieldsInitial();

		// เพิ่ม change handlers สำหรับเงื่อนไขการวางบิลและการรับชำระเงิน
		$('input:radio[name="crf_condition_bill"]').change(function () {
			if ($(this).val() == "ส่งของพร้อมวางบิル") {
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

		// Company selection handler - enable customer type selection
		$('input:radio[name="crf_company"]').change(function () {
			if ($(this).val() != "") {
				$('input:radio[name="crf_type"]').prop("disabled", false);
				console.log($(this).val());
				getCusProcess($(this).val());
			} else {
				$('input:radio[name="crf_type"]').prop("disabled", true);
			}
		});

		// Initialize
		$(".suboldcustomer").css("display", "none");

		///////////////////////////////////////////////////////////
		// Main Customer Type Selection Handler (NEW/OLD)
		///////////////////////////////////////////////////////////
		$("input[name=crf_type]").change(function () {
			$("#checkCompany").val($(this).val());
			$("#checkCusType").val($(this).val());

			// Validate company selection first
			if (!validateRadioChecked('crf_company', 'alert_company', ALERT_MESSAGES.REQUIRED_COMPANY)) {
				$("input[name=crf_type]").prop("checked", false);
				return;
			}

			// Handle OLD CUSTOMER (2)
			if ($(this).val() == CUSTOMER_TYPE.OLD) {
				disableAllFieldsForOldCustomer();

				///////////////////////////////////////////////
				// Control Person Type (Natural/Juristic) for OLD customer
				///////////////////////////////////////////////
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

				// Variable ที่ไม่ได้ใช้งานถูกลบออก

				// Control Save Data ลูกค้าเก่า with debounce
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
						$("#autoCusCode").html(
							'<div class="text-muted small p-2"><i>กำลังค้นหา...</i></div>'
						);

						// Debounce: รอ 300ms หลังจากพิมพ์ค่าสุดท้าย
						searchTimeout = setTimeout(() => {
							autoSearchCustomerDetail(cusCode);
						}, 300);
					} else {
						$("#autoCusCode").html("");
					}
				});

				// Auto search customer name with debounce
				$("#crf_customername").on("keyup", function () {
					const cusname = $(this).val().trim();

					// Cancel previous timeout
					if (searchTimeout) {
						clearTimeout(searchTimeout);
					}

					if (cusname !== "") {
						// Show loading state
						$("#autoCusname").html(
							'<div class="text-muted small p-2"><i>กำลังค้นหา...</i></div>'
						);

						// Debounce: รอ 300ms
						searchTimeout = setTimeout(() => {
							autoSearchCustomerDetailName(cusname);
						}, 300);
					} else {
						$("#autoCusname").html("");
					}
				});

				$('input:radio[name="crf_person_type"]').change(function () {
					if (
						$(
							'input:checkbox[name="crf_sub_oldcus_editcustomer"]:checked'
						).val() == 5
					) {
						if ($(this).val() == PERSON_TYPE.NATURAL) {
							$("#for_natural").css("display", "");
							$("#for_juristic").css("display", "none");
							// ไฟล์1
							$("#crf_file_person").prop("disabled", false);
						} else if ($(this).val() == PERSON_TYPE.JURISTIC) {
							$("#for_natural").css("display", "none");
							$("#for_juristic").css("display", "");
							// ไฟล์1
							$("#crf_file_person").prop("disabled", true);
							// ไฟล์1
							$("#crf_file1").prop("disabled", false);

							// ไฟล์1
							$("#crf_file2").prop("disabled", false);

							// ไฟล์1
							$("#crf_file3").prop("disabled", false);

							// ไฟล์1
							$("#crf_file4").prop("disabled", false);

							// ไฟล์1
							$("#crf_file5").prop("disabled", false);

							// ไฟล์1
							$("#crf_file6").prop("disabled", false);
						}
					}
				});

				$(".suboldcustomer").css("display", "");

				// // Set Readonly

				// Customer Code
				$("#crf_customercode").prop("readonly", false);

				// // Sales Reps
				// $('#crf_salesreps').prop('readonly', true);

				// ชื่อลูกค้า :
				$("#crf_customername").prop("disabled", false);

				//วงเงิน
				$(".finance_request_detail").css("display", "");
				$("#crf_finance_req_number").prop("readonly", true);

				// Control กรณีเลือก เปลี่ยนเขตการขาย
				$('input:checkbox[name="crf_sub_oldcus_changearea"]').change(
					function () {
						if ($(this).prop("checked") == true) {
							$("#crf_salesreps").prop("readonly", false).removeClass("bg-light");
							$("#crf_salesreps").keyup(function () {
								if ($(this).val() != "") {
									$("#user_submit").prop("disabled", false);
								}
							});
						} else {
							$("#crf_salesreps").prop("readonly", true).addClass("bg-light");
						}

						// เช็คความถูกต้องของการกรอกข้อมูล
						$("#crf_salesreps").blur(function () {
							if ($(this).val() == "") {
								$("#alert_salesreps").html(
									'<div class="alert alert-danger" role="alert">กรุณาระบุข้อมูล Sales Reps ด้วยค่ะ</div>'
								);
								$("#crf_customername").val("");
							} else {
								// เช็คความถูกต้องของการกรอก sales reps
								if (minsalesreps($(this).val()) == false) {
									$("#alert_salesreps").html(
										'<div class="alert alert-danger" role="alert">กรุณาระบุข้อมูล Sales Reps ให้ถูกต้องด้วยค่ะ ต้องขึ้นต้นด้วย M หรือ D แล้วตามด้วยตัวเลข 4</div>'
									);
									// $(this).val('');
									$("#user_submit").prop("disabled", true);
								} else {
									$("#alert_salesreps").html("");
									$("#user_submit").prop("disabled", false);
								}
							}
						});
						$("#crf_salesreps").focusout(function () {
							if ($(this).val() == "") {
								$("#alert_salesreps").html(
									'<div class="alert alert-danger" role="alert">กรุณาระบุข้อมูล Sales Reps ด้วยค่ะ</div>'
								);
								$("#crf_customername").val("");
							} else {
								// เช็คความถูกต้องของการกรอก sales reps
								if (minsalesreps($(this).val()) == false) {
									$("#alert_salesreps").html(
										'<div class="alert alert-danger" role="alert">กรุณาระบุข้อมูล Sales Reps ให้ถูกต้องด้วยค่ะ ต้องขึ้นต้นด้วย M หรือ D แล้วตามด้วยตัวเลข 4</div>'
									);
									// $(this).val('');
									$("#user_submit").prop("disabled", true);
								} else {
									$("#alert_salesreps").html("");
									$("#user_submit").prop("disabled", false);
								}
							}
						});
						$("#crf_salesreps").keyup(function () {
							if ($(this).val() == "") {
								$("#alert_salesreps").html(
									'<div class="alert alert-danger" role="alert">กรุณาระบุข้อมูล Sales Reps ด้วยค่ะ</div>'
								);
								$("#crf_customername").val("");
							} else {
								$("#alert_salesreps").html("");
							}
						});
						// Check ข้อมูลช่อง Sale Rep ว่ามีการกรอกข้อมูลหรือไม่
					}
				);

				// Control กรณีเลือก เปลี่ยนที่อยู่
				$('input:checkbox[name="crf_sub_oldcus_changeaddress"]').change(
					function () {
						if ($(this).prop("checked") == true) {
							$("#crf_addressname").prop("readonly", false);
							$("#crf_namecontact").prop("readonly", false);
							$("#crf_telcontact").prop("readonly", false);
							$("#crf_faxcontact").prop("readonly", false);
							$("#crf_emailcontact").prop("readonly", false);
							$("#crf_file1").prop("disabled", false);
							$("#crf_file1").attr("required", "");
							$('input:radio[name="crf_addresstype"]').prop("disabled", false);
							
							// เรียกใช้ฟังก์ชันอัปเดตสถานะ crf_file1
							updateCrfFile1Status();

							$("#crf_addressname").blur(function () {
								if ($(this).val() == "") {
									$("#crf_file1").prop("disabled", true);
									$("#user_submit").prop("disabled", true);
								} else {
									updateCrfFile1Status();
								}
							});

							if (
								$('input:radio[name="crf_person_type"]:checked').val() ==
								"natural"
							) {
								$("#crf_file1").removeAttr("required");
								$("#crf_file_person").change(function () {
									if ($(this).val() != "") {
										$("#user_submit").prop("disabled", false);
									} else {
										$("#user_submit").prop("disabled", true);
									}
								});
							} else if (
								$('input:radio[name="crf_person_type"]:checked').val() ==
								"juristic"
							) {
								$("#crf_file1").change(function () {
									if ($(this).val() != "") {
										$("#user_submit").prop("disabled", false);
									} else {
										$("#user_submit").prop("disabled", true);
									}
								});
							}
						} else {
							$("#crf_addressname").prop("readonly", true);
							$("#crf_namecontact").prop("readonly", true);
							$("#crf_telcontact").prop("readonly", true);
							$("#crf_faxcontact").prop("readonly", true);
							$("#crf_emailcontact").prop("readonly", true);
							$('input:radio[name="crf_addresstype"]').prop("disabled", true);
							
							// เรียกใช้ฟังก์ชันอัปเดตสถานะ crf_file1
							updateCrfFile1Status();
						}
					}
				);

				// ============================================
				// Control กรณีแก้ไขข้อมูลลูกค้า
				// โค้ดส่วนนี้ถูกย้ายไปที่: assets/js/addth/oldcus_editcusdata.js
				// เพื่อให้จัดการและดูแลรักษาง่ายขึ้น (Refactored on 2026-02-19)
				// ============================================

				// Control กรณีเลือกปรับ Credit term
				// >>> MOVED TO: assets/js/addth/oldcus_changecreditterm.js <<<

				// Control กรณีเลือกปรับ ปรับวงเงิน
				$('input:checkbox[name="crf_sub_oldcus_changefinance"]').change(
					function () {
						if ($(this).prop("checked") == true) {
							$(".finance_change_detail").css("display", "");
							$("input[name=crf_finance]").prop("checked", true);

							$("#crf_finance_change_status").change(function () {
								$("#showChangeStatus").val($(this).val());
							});

							$("#value_crf_finance").val("ปรับวงเงิน");

							// ไม่ disable crf_file1 หากมีการเลือก "เปลี่ยนที่อยู่" หรือ "แก้ไขข้อมูลลูกค้า"
							if (!$('input:checkbox[name="crf_sub_oldcus_changeaddress"]').prop("checked") && 
							    !$('input:checkbox[name="crf_sub_oldcus_editcustomer"]').prop("checked")) {
								$("#crf_file1").prop("disabled", true);
							}

						$("#crf_finance_change_number").keyup(function (event) {
							// Skip for arrow keys
							if (event.which >= 37 && event.which <= 40) return;
							
							// Format current input with commas
					var oldValue = $(this).val();
					var formattedInput = formatNumberWithComma(oldValue);
					$(this).val(formattedInput);
					
					// Calculate total amount
					// Remove commas before parsing to integer
					var oldmoneyStr = $("#crf_finance_req_number_calc").val().replace(/,/g, "");
					var newmoneyStr = $(this).val().replace(/,/g, "");
					
					var oldmoney = parseInt(oldmoneyStr) || 0;
					var newmoney = parseInt(newmoneyStr) || 0;
					
					var totalAmount = 0;
					if ($("#showChangeStatus").val() == "เพิ่ม") {
						totalAmount = oldmoney + newmoney;
					} else if ($("#showChangeStatus").val() == "ลด") {
						totalAmount = oldmoney - newmoney;
					}
					// Format with commas
					var formattedTotal = totalAmount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
					$("#crf_finance_change_total").val(formattedTotal);
					
					if ($(this).val() != "") {
						$("#user_submit").prop("disabled", false);
					} else {
						$("#user_submit").prop("disabled", true);
					}
				});
			} else {
							$(".finance_change_detail").css("display", "none");
							$("input[name=crf_finance]").prop("checked", false);
						}
					}
				);

				$('input:checkbox[id="crf_sub_oldcus"]').change(function () {
					const check_crf_sub_oldcus = $(
						'input:checkbox[id="crf_sub_oldcus"]:checked'
					);
					if (check_crf_sub_oldcus.val() != "") {
						$("#crf_customercode").prop("disabled", false);
					}
				});

				// Check Sub old Customer ว่ามีการเลือกประเภทหรือไม่
				$("#crf_customercode").focus(function () {
					if ($("#checkCusType").val() == 2) {
						var crf_sub_oldcus = $(
							'input[type="checkbox"][id="crf_sub_oldcus"]:checked'
						);
						var crf_person_type = $(
							'input[type="radio"][name="crf_person_type"]:checked'
						);

						if (crf_person_type.length < 1) {
							$("#alert_crf_sub_oldcus").html(
								'<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทลูกค้าด้วยค่ะ</div>'
							);
							$("#crf_customercode").val("").prop("disabled", true);
							$("#autoCusCode").html("");
						} else if (crf_sub_oldcus.length < 1) {
							$("#alert_crf_sub_oldcus").html(
								'<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทการดำเนินการด้วยค่ะ</div>'
							);
							$("#crf_customercode").val("").prop("disabled", true);
							$("#autoCusCode").html("");
						} else {
							$("#crf_customercode").prop("disabled", false);
						}
					}
				});

				$("#crf_customername").focus(function () {
					if ($("#checkCusType").val() == 2) {
						var crf_sub_oldcus = $(
							'input[type="checkbox"][id="crf_sub_oldcus"]:checked'
						);
						if (crf_sub_oldcus.length < 1) {
							$("#alert_crf_sub_oldcus").html(
								'<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทการดำเนินการด้วยค่ะ</div>'
							);
							$("#crf_customername").val("");
						} else {
							$("#alert_crf_sub_oldcus").html("");
						}
					}
				});
				$("#crf_customercode").keyup(function () {
					if ($("#checkCusType").val() == 2) {
						var crf_sub_oldcus = $(
							'input[type="checkbox"][id="crf_sub_oldcus"]:checked'
						);
						if (crf_sub_oldcus.length < 1) {
							$("#alert_crf_sub_oldcus").html(
								'<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทการดำเนินการด้วยค่ะ</div>'
							);
							$("#crf_customercode").val("");
						} else {
							$("#alert_crf_sub_oldcus").html("");
						}
					}
				});
				$("#crf_customername").keyup(function () {
					if ($("#checkCusType").val() == 2) {
						var crf_sub_oldcus = $(
							'input[type="checkbox"][id="crf_sub_oldcus"]:checked'
						);
						if (crf_sub_oldcus.length < 1) {
							$("#alert_crf_sub_oldcus").html(
								'<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทการดำเนินการด้วยค่ะ</div>'
							);
							$("#crf_customername").val("");
						} else {
							$("#alert_crf_sub_oldcus").html("");
						}
					}
				});
				$("#alert_crf_sub_oldcus").fadeIn();
				// Check Sub old Customer ว่ามีการเลือกประเภทหรือไม่

				$("#crf_finance").prop("checked", false);
				// $('.finance_request_detail').css('display', 'none');

				// Alert Sales Reps
				$("#alert_salesreps").html("");
				// Clear Sales Reps
				$("#crf_salesreps").val("");

				// Check ข้อมูลช่อง Sale Rep ว่ามีการกรอกข้อมูลหรือไม่
				// $('#crf_salesreps').blur(function () {
				//     if ($(this).val() == '') {
				//         $('#alert_salesreps').html('<div class="alert alert-danger" role="alert">กรุณาระบุข้อมูล Sales Reps ด้วยค่ะ</div>');
				//         $('#crf_customername').val('');
				//     }
				// });
				// $('#crf_customername').focus(function () {
				//     if ($('#crf_salesreps').val() == '') {
				//         $('#alert_salesreps').html('<div class="alert alert-danger" role="alert">กรุณาระบุข้อมูล Sales Reps ด้วยค่ะ</div>');
				//     } else {
				//         $('#alert_salesreps').html('');
				//     }
				// });
				// $('#crf_customername').keyup(function () {
				//     if ($('#crf_salesreps').val() == '') {
				//         $('#alert_salesreps').html('<div class="alert alert-danger" role="alert">กรุณาระบุข้อมูล Sales Reps ด้วยค่ะ</div>');
				//         $('#crf_customername').val('');
				//     } else {
				//         $('#alert_salesreps').html('');
				//         $('#alert_customername').html('');
				//     }
				// });
				// Check ข้อมูลช่อง Sale Rep ว่ามีการกรอกข้อมูลหรือไม่

				// Check ข้อมูลช่อง ชื่อลูกค้าว่ามีการกรอกข้อมูลหรือไม่
				$("#crf_cuscompanycreate").focus(function () {
					if ($("#crf_customername").val() == "") {
						$("#alert_customername").html(
							'<div class="alert alert-danger" role="alert">กรุณาระบุชื่อลูกค้าด้วยค่ะ</div>'
						);
						$("#crf_cuscompanycreate").val("");
					} else {
						$("#alert_customername").html("");
					}
				});
				// $('#crf_customername').blur(function () {
				//     if ($(this).val() == '') {
				//         $('#alert_customername').html('<div class="alert alert-danger" role="alert">กรุณาระบุชื่อลูกค้าด้วยค่ะ</div>');
				//     } else {
				//         $('#alert_customername').html();
				//     }
				// });
				// Check ข้อมูลช่อง ชื่อลูกค้าว่ามีการกรอกข้อมูลหรือไม่

				// Check วันที่ก่อตั้งว่ามีการเลือกหรือไม่ // Check วันที่ก่อตั้งว่ามีการเลือกหรือไม่
				$("#crf_cuscompanycreate").blur(function () {
					if ($(this).val() == "") {
						$("#alert_cuscompanycreate").html(
							'<div class="alert alert-danger" role="alert">กรุณาระบุวันที่ก่อตั้งด้วยค่ะ</div>'
						);
					} else {
						$("#alert_cuscompanycreate").html("");
					}
				});

				$("#crf_cuscompanycreate").change(function () {
					if ($(this).val() == "") {
						$("#alert_cuscompanycreate").html(
							'<div class="alert alert-danger" role="alert">กรุณาระบุวันที่ก่อตั้งด้วยค่ะ</div>'
						);
					} else {
						$("#alert_cuscompanycreate").html("");
					}
				});

				$("#crf_addressname").focus(function () {
					if ($("#crf_cuscompanycreate").val() == "") {
						$("#alert_cuscompanycreate").html(
							'<div class="alert alert-danger" role="alert">กรุณาระบุวันที่ก่อตั้งด้วยค่ะ</div>'
						);
						$("#crf_addressname").val("");
					} else {
						$("#alert_cuscompanycreate").html("");
					}

					var crf_addresstype = $(
						'input:radio[name="crf_addresstype"]:checked'
					);
					if (crf_addresstype.length < 1) {
						$("#alert_addresstype").html(
							'<div class="alert alert-danger" role="alert">กรุณาเลือกที่อยู่สำหรับเปิดใบกำกับภาษีด้วยค่ะ</div>'
						);
						$("#crf_addressname").val("");
					} else {
						$("#alert_addresstype").html("");
					}
				});

				$("#crf_addressname").keyup(function () {
					if ($("#crf_cuscompanycreate").val() == "") {
						$("#alert_cuscompanycreate").html(
							'<div class="alert alert-danger" role="alert">กรุณาระบุวันที่ก่อตั้งด้วยค่ะ</div>'
						);
						$("#crf_addressname").val("");
					}

					var crf_addresstype = $(
						'input:radio[name="crf_addresstype"]:checked'
					);
					if (crf_addresstype.length < 1) {
						$("#alert_addresstype").html(
							'<div class="alert alert-danger" role="alert">กรุณาเลือกที่อยู่สำหรับเปิดใบกำกับภาษีด้วยค่ะ</div>'
						);
						$("#crf_addressname").val("");
					} else {
						$("#alert_addresstype").html("");
					}
				});
				// Check วันที่ก่อตั้งว่ามีการเลือกหรือไม่ // Check วันที่ก่อตั้งว่ามีการเลือกหรือไม่

				// Check Address Name Check Address Name Check Address Name
				$("#crf_addressname").blur(function () {
					if ($(this).val() == "") {
						$("#alert_addressname").html(
							'<div class="alert alert-danger" role="alert">กรุณาระบุที่อยู่สำหรับการเปิดใบกำกับภาษีด้วยค่ะ</div>'
						);
					} else {
						$("#alert_addressname").html("");
					}
				});
				$("#crf_addressname").keyup(function () {
					if ($(this).val() != "") {
						$("#alert_addressname").html("");
					}
				});
				$("#crf_namecontact").focus(function () {
					if ($("#crf_addressname").val() == "") {
						$("#alert_addressname").html(
							'<div class="alert alert-danger" role="alert">กรุณาระบุที่อยู่สำหรับการเปิดใบกำกับภาษีด้วยค่ะ</div>'
						);
						$("#crf_namecontact").val("");
					} else {
						$("#alert_addressname").html("");
					}
				});
				$("#crf_namecontact").keyup(function () {
					if ($("#crf_addressname").val() == "") {
						$("#alert_addressname").html(
							'<div class="alert alert-danger" role="alert">กรุณาระบุที่อยู่สำหรับการเปิดใบกำกับภาษีด้วยค่ะ</div>'
						);
						$("#crf_namecontact").val("");
					} else {
						$("#alert_addressname").html("");
					}
				});
				// Check Address Name Check Address Name Check Address Name

				// Check ช่องผู้ติดต่อว่ามีการกรอกข้อมูลเข้ามาหรือไม่
				$("#crf_namecontact").blur(function () {
					if ($(this).val() == "") {
						$("#alert_namecontact").html(
							'<div class="alert alert-danger" role="alert">กรุณาระบุชื่อผู้ติดต่อด้วยค่ะ</div>'
						);
					} else {
						$("#alert_namecontact").html("");
					}
				});
				$("#crf_telcontact").focus(function () {
					if ($("#crf_namecontact").val() == "") {
						$("#alert_namecontact").html(
							'<div class="alert alert-danger" role="alert">กรุณาระบุชื่อผู้ติดต่อด้วยค่ะ</div>'
						);
						$("#crf_telcontact").val("");
					} else {
						$("#alert_namecontact").html("");
					}
				});
				$("#crf_telcontact").keyup(function () {
					if ($("#crf_namecontact").val() == "") {
						$("#alert_namecontact").html(
							'<div class="alert alert-danger" role="alert">กรุณาระบุชื่อผู้ติดต่อด้วยค่ะ</div>'
						);
						$("#crf_telcontact").val("");
					} else {
						$("#alert_namecontact").html("");
					}
				});
				$("#crf_namecontact").keyup(function () {
					if ($(this).val() != "") {
						$("#alert_namecontact").html("");
					}
				});
				// Check ช่องผู้ติดต่อว่ามีการกรอกข้อมูลเข้ามาหรือไม่

				// Check ช่องเบอร์โทรว่ามีการกรอกข้อมูลหรือไม่
				$("#crf_telcontact").blur(function () {
					if ($(this).val() == "") {
						$("#alert_telcontact").html(
							'<div class="alert alert-danger" role="alert">กรุณาระบุเบอร์ผู้ติดต่อด้วยค่ะ</div>'
						);
					} else {
						$("#alert_telcontact").html("");
					}
				});
				$("#crf_emailcontact").focus(function () {
					if ($("#crf_telcontact").val() == "") {
						$("#alert_telcontact").html(
							'<div class="alert alert-danger" role="alert">กรุณาระบุเบอร์ผู้ติดต่อด้วยค่ะ</div>'
						);
						$("#crf_emailcontact").val("");
					} else {
						$("#alert_telcontact").html("");
					}
				});
				$("#crf_emailcontact").keyup(function () {
					if ($("#crf_telcontact").val() == "") {
						$("#alert_telcontact").html(
							'<div class="alert alert-danger" role="alert">กรุณาระบุเบอร์ผู้ติดต่อด้วยค่ะ</div>'
						);
						$("#crf_emailcontact").val("");
					} else {
						$("#alert_telcontact").html("");
					}
				});
				$("#crf_telcontact").keyup(function () {
					if ($(this).val() != "") {
						$("#alert_telcontact").html("");
					}
				});
				// Check ช่องเบอร์โทรว่ามีการกรอกข้อมูลหรือไม่

				// Check ช่อง อีเมลว่ามีการกรอกข้อมูลหรือไม่
				// $('#crf_emailcontact').blur(function () {
				//     if ($(this).val() == '') {
				//         $('#alert_emailcontact').html('<div class="alert alert-danger" role="alert">กรุณาระบุอีเมลผู้ติดต่อด้วยค่ะ</div>');
				//     } else {
				//         $('#alert_emailcontact').html('');
				//     }
				// });
				// $('#crf_regiscost').focus(function () {
				//     if ($('#crf_emailcontact').val() == '') {
				//         $('#alert_emailcontact').html('<div class="alert alert-danger" role="alert">กรุณาระบุอีเมลผู้ติดต่อด้วยค่ะ</div>');
				//         $('#crf_regiscost').val('');
				//     } else {
				//         $('#alert_emailcontact').html('');
				//     }
				// });
				// $('#crf_regiscost').keyup(function () {
				//     if ($('#crf_emailcontact').val() == '') {
				//         $('#alert_emailcontact').html('<div class="alert alert-danger" role="alert">กรุณาระบุอีเมลผู้ติดต่อด้วยค่ะ</div>');
				//         $('#crf_regiscost').val('');
				//     } else {
				//         $('#alert_emailcontact').html('');
				//     }
				// });
				// $('#crf_emailcontact').keyup(function () {
				//     if ($(this).val() != '') {
				//         $('#alert_emailcontact').html('');
				//     }
				// });
				// Check ช่อง อีเมลว่ามีการกรอกข้อมูลหรือไม่

				// Check ช่อง ทุนจดทะเบียน
				$("#crf_regiscost").blur(function () {
					if ($(this).val() == "") {
						$("#alert_regiscost").html(
							'<div class="alert alert-danger" role="alert">กรุณาระบุทุนจดทะเบียนด้วยค่ะ</div>'
						);
					} else {
						$("#alert_regiscost").html("");
					}
				});
				$('input:radio[name="crf_companytype"]').click(function () {
					if ($("#crf_regiscost").val() == "") {
						$("#alert_regiscost").html(
							'<div class="alert alert-danger" role="alert">กรุณาระบุทุนจดทะเบียนด้วยค่ะ</div>'
						);
						$("#crf_regiscost").val("");
					} else {
						$("#alert_regiscost").html("");
					}

					$(
						"#crf_companytype2 , #crf_companytype3_1_1 , #crf_companytype3_1_2 , #crf_companytype3_2_1 , #crf_companytype3_2_2"
					).val("");
				});
				// $('#crf_regiscost').keyup(function(){
				//     if($('#crf_emailcontact').val() == ''){
				//         $('#alert_emailcontact').html('<div class="alert alert-danger" role="alert">กรุณาระบุอีเมลผู้ติดต่อด้วยค่ะ</div>');
				//         $('#user_submit').prop('disabled' , true);
				//         $('#crf_regiscost').val('');
				//     }else{
				//         $('#alert_emailcontact').html('');
				//         $('#user_submit').prop('disabled' , false);
				//     }
				// });
				$("#crf_regiscost").keyup(function () {
					if ($(this).val() != "") {
						$("#alert_regiscost").html("");
					}
				});
				// Check ช่อง ทุนจดทะเบียน

				// Check ช่องรายชื่อบุคคลในแต่ระดับบริหารที่สำคัญ
				// $('#crf_primanage_dept , #crf_primanage_name , #crf_primanage_posi , #crf_primanage_email').blur(function () {
				//     if ($(this).val() == '') {
				//         $('#alert_primanage').html('<div class="alert alert-danger" role="alert">กรุณาระบุข้อมูลให้ครบถ้วนด้วยค่ะ</div>');
				//         // $('input:radio[name="crf_typeofbussi"]').prop('checked', false);
				//         $('#user_submit').prop('disabled' , true);
				//         exit;
				//     } else {
				//         $('#alert_primanage').html('');
				//         $('#user_submit').prop('disabled' , false);
				//     }
				// });

				$('input:radio[name="crf_typeofbussi"]').click(function () {
					if (
						$("#crf_primanage_dept").val() == "" ||
						$("#crf_primanage_name").val() == "" ||
						$("#crf_primanage_posi").val() == "" ||
						$("#crf_primanage_email").val() == ""
					) {
						$("#alert_primanage").html(
							'<div class="alert alert-danger" role="alert">กรุณาระบุข้อมูลให้ครบถ้วนด้วยค่ะ</div>'
						);
						// $('input:radio[name="crf_typeofbussi"]').prop('checked', false);
						exit;
					} else {
						$("#alert_primanage").html("");
					}
				});

				// $('#crf_regiscost').keyup(function(){
				//     if($('#crf_emailcontact').val() == ''){
				//         $('#alert_emailcontact').html('<div class="alert alert-danger" role="alert">กรุณาระบุอีเมลผู้ติดต่อด้วยค่ะ</div>');
				//         $('#user_submit').prop('disabled' , true);
				//         $('#crf_regiscost').val('');
				//     }else{
				//         $('#alert_emailcontact').html('');
				//         $('#user_submit').prop('disabled' , false);
				//     }
				// });
				$(
					"#crf_primanage_dept , #crf_primanage_name , #crf_primanage_posi , #crf_primanage_email"
				).keyup(function () {
					if ($(this).val() != "") {
						$("#alert_primanage").html("");
					}

					var crf_companytype = $(
						'input:radio[name="crf_companytype"]:checked'
					);
					if (crf_companytype.length < 1) {
						$(this).val("");
						$("#alert_companytype").html(
							'<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทบริษัทด้วยค่ะ</div>'
						);
					} else {
						$("#alert_primanage").html("");
						$("#alert_companytype").html("");
					}
				});
				// Check ช่องรายชื่อบุคคลในแต่ระดับบริหารที่สำคัญ

				// Check ประเภทของ ธุรกิจว่ามีการเลือกข้อมูลหรือไม่
				$(document).on(
					"change",
					'input[type="checkbox"][id="crf_process"]:checked',
					function () {
						var crf_typeofbussi = $(
							'input:radio[name="crf_typeofbussi"]:checked'
						);
						if (crf_typeofbussi.length < 1) {
							$("#alert_typeofbussi").html(
								'<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทธุรกิจด้วยค่ะ</div>'
							);
							$(this).prop("checked", false);
							exit;
						} else {
							$("#alert_typeofbussi").html("");
						}
					}
				);
				// Check ประเภทของ ธุรกิจว่ามีการเลือกข้อมูลหรือไม่

				// Check กระบวนการผลิตว่ามีการเลือกข้อมูลเข้ามาหรือไม่
				$("#crf_forecast").focus(function () {
					var crf_process = $(
						'input[type="checkbox"][id="crf_process"]:checked'
					);
					if (crf_process.length < 1) {
						$("#alert_process").html(
							'<div class="alert alert-danger" role="alert">กรุณาเลือกกระบวนการผลิตหลักด้วยค่ะ</div>'
						);
						$(this).val("");
					} else {
						$("#alert_process").html("");
					}
				});
				$("#crf_forecast").keyup(function () {
					var crf_process = $(
						'input[type="checkbox"][id="crf_process"]:checked'
					);
					if (crf_process.length < 1) {
						$("#alert_process").html(
							'<div class="alert alert-danger" role="alert">กรุณาเลือกกระบวนการผลิตหลักด้วยค่ะ</div>'
						);
						$(this).val("");
					} else {
						$("#alert_process").html("");
					}

					if ($(this).val() != "") {
						$("#alert_forecast").html("");
					}
				});
				// Check กระบวนการผลิตว่ามีการเลือกข้อมูลเข้ามาหรือไม่

				// Check คาดการปริมาณการขายว่ามีการกรอกข้อมูลงไปหรือไม่
				$("#crf_forecast").blur(function () {
					if ($(this).val() == "") {
						$("#alert_forecast").html(
							'<div class="alert alert-danger" role="alert">กรุณาระบุรายละเอียดคาดการปริมาณการขายด้วยค่ะ</div>'
						);
					} else {
						$("#alert_forecast").html("");
					}
				});
				// Check คาดการปริมาณการขายว่ามีการกรอกข้อมูลงไปหรือไม่

				// Check File Upload ว่ามีการอัพโหลดไฟล์หรือยังก่อ่นที่จะเลือก Credit term
				// $('#crf_creditterm').change(function () {

				//     if ($(this).val() != '') {
				//         $('#alert_creditterm').html('');
				//         $('input:radio[name="crf_condition_bill"]').prop('disabled', false);
				//     } else {
				//         $('#alert_creditterm').html('<div class="alert alert-danger" role="alert">กรุณาเลือก Credit Term ด้วยค่ะ</div>');
				//         $('input:radio[name="crf_condition_bill"]').prop('checked', false);
				//         $('input:radio[name="crf_condition_bill"]').prop('disabled', true);

				//         $('input:radio[name="crf_condition_money"]').prop('checked', false);
				//     }

				//     if ($('#crf_file1').val() == '') {
				//         $('#alert_file1').html('<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ ภพ.20 ด้วยค่ะ</div>');
				//         $('#crf_creditterm').val('');
				//     } else {
				//         $('#alert_file1').html('');
				//     }

				//     if ($('#crf_file2').val() == '') {
				//         $('#alert_file2').html('<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ หนังสือรับรอง ด้วยค่ะ</div>');
				//         $('#crf_creditterm').val('');
				//     } else {
				//         $('#alert_file2').html('');
				//     }

				//     if ($('#crf_file3').val() == '') {
				//         $('#alert_file3').html('<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ ข้อมูลทั่วไป ด้วยค่ะ</div>');
				//         $('#crf_creditterm').val('');
				//     } else {
				//         $('#alert_file3').html('');
				//     }

				//     if ($('#crf_file4').val() == '') {
				//         $('#alert_file4').html('<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ งบแสดงฐานะทางการเงิน ด้วยค่ะ</div>');
				//         $('#crf_creditterm').val('');
				//     } else {
				//         $('#alert_file4').html('');
				//     }

				//     if ($('#crf_file5').val() == '') {
				//         $('#alert_file5').html('<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ งบกำไรขาดทุน ด้วยค่ะ</div>');
				//         $('#crf_creditterm').val('');
				//     } else {
				//         $('#alert_file5').html('');
				//     }

				//     if ($('#crf_file6').val() == '') {
				//         $('#alert_file6').html('<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ อัตราส่วนสภาพคล่อง ด้วยค่ะ</div>');
				//         $('#crf_creditterm').val('');
				//     } else {
				//         $('#alert_file6').html('');
				//     }
				// });
				// Check File Upload ว่ามีการอัพโหลดไฟล์หรือยังก่อ่นที่จะเลือก Credit term

				// Check Upload File 1 - 6 Element
				$("#crf_file1").change(function () {
					if ($(this).val() != "") {
						$("#alert_file1").html("");
					}
				});

				$("#crf_file2").change(function () {
					if ($(this).val() != "") {
						$("#alert_file2").html("");
					}
				});

				$("#crf_file3").change(function () {
					if ($(this).val() != "") {
						$("#alert_file3").html("");
					}
				});

				$("#crf_file4").change(function () {
					if ($(this).val() != "") {
						$("#alert_file4").html("");
					}
				});

				$("#crf_file5").change(function () {
					if ($(this).val() != "") {
						$("#alert_file5").html("");
					}
				});

				$("#crf_file6").change(function () {
					if ($(this).val() != "") {
						$("#alert_file6").html("");
					}
				});
				// Check Upload File 1 - 6 Element

				// Check Credit Term ว่ามีการเลือกหรือไม่
				$('input:radio[name="crf_condition_bill"]').click(function () {
					if ($("#crf_creditterm").val() == "") {
						$("#alert_creditterm").html(
							'<div class="alert alert-danger" role="alert">กรุณาเลือก Credit Term ด้วยค่ะ</div>'
						);
						$('input:radio[name="crf_condition_bill"]').prop("checked", false);
						$('input:radio[name="crf_condition_bill"]').prop("disabled", true);
						exit;
					} else {
						$("#alert_creditterm").html("");
					}
				});
				// Check Credit Term ว่ามีการเลือกหรือไม่

				// Check เงื่อนไขการวางบิล ว่าได้มีการเลือกแล้วหรือยัง
				$('input:radio[name="crf_condition_money"]').click(function () {
					var crf_condition_bill = $(
						"input:radio[name=crf_condition_bill]:checked"
					);
					if (crf_condition_bill.length < 1) {
						$("#alert_condition_bill").html(
							'<div class="alert alert-danger" role="alert">กรุณาเลือกเงื่อนไขการวางบิลด้วยค่ะ</div>'
						);
						$('input:radio[name="crf_condition_money"]').prop("checked", false);
						exit;
					} else {
						$("#alert_condition_bill").html("");
					}
				});
				// Check เงื่อนไขการวางบิล ว่าได้มีการเลือกแล้วหรือยัง

				// Check เงื่อนไขการรับชำระเงินว่ามีการเลือกข้อมูลถูกต้องหรือไม่
				// $('#crf_finance_req_number').focus(function () {
				//     var crf_condition_money = $('input:radio[name="crf_condition_money"]:checked');
				//     if (crf_condition_money.length < 1) {
				//         $('#alert_condition_money').html('<div class="alert alert-danger" role="alert">กรุณาเลือกเงื่อนไขการชำระเงินด้วยค่ะ</div>');
				//         $('#crf_finance_req_number').val('');
				//     } else {
				//         if (crf_condition_money.val() == 'รับเช็ค') {
				//             if ($('#crf_recive_cheuqetable').val() == '') {
				//                 $('#alert_recive_cheuqetable').html('<div class="alert alert-danger" role="alert">กรุณา แนบตารางวางบิล / รับเช็ค ด้วยค่ะ</div>');
				//                 $('#crf_finance_req_number').val('');
				//             } else {
				//                 $('#alert_recive_cheuqetable').html('');
				//             }

				//             if ($('#crf_recive_cheuqedetail').val() == '') {
				//                 $('#alert_recive_cheuqedetail').html('<div class="alert alert-danger" role="alert">กรุณา รายละเอียดเพิ่มเติม ด้วยค่ะ</div>');
				//                 $('#crf_finance_req_number').val('');
				//             } else {
				//                 $('#alert_recive_cheuqedetail').html('');
				//             }
				//         } else {
				//             $('#alert_condition_money').html('');
				//         }
				//     }
				// });

				// $('#crf_finance_req_number').keyup(function () {
				//     var crf_condition_money = $('input:radio[name="crf_condition_money"]:checked');
				//     if (crf_condition_money.length < 1) {
				//         $('#alert_condition_money').html('<div class="alert alert-danger" role="alert">กรุณาเลือกเงื่อนไขการชำระเงินด้วยค่ะ</div>');
				//         $('#crf_finance_req_number').val('');
				//     } else {
				//         if (crf_condition_money.val() == 'รับเช็ค') {
				//             if ($('#crf_recive_cheuqetable').val() == '') {
				//                 $('#alert_recive_cheuqetable').html('<div class="alert alert-danger" role="alert">กรุณา แนบตารางวางบิล / รับเช็ค ด้วยค่ะ</div>');
				//                 $('#crf_finance_req_number').val('');
				//             } else {
				//                 $('#alert_recive_cheuqetable').html('');
				//             }

				//             if ($('#crf_recive_cheuqedetail').val() == '') {
				//                 $('#alert_recive_cheuqedetail').html('<div class="alert alert-danger" role="alert">กรุณา รายละเอียดเพิ่มเติม ด้วยค่ะ</div>');
				//                 $('#crf_finance_req_number').val('');
				//             } else {
				//                 $('#alert_recive_cheuqedetail').html('');
				//             }
				//         } else {
				//             $('#alert_condition_money').html('');
				//         }
				//     }
				// });
				// Check เงื่อนไขการรับชำระเงินว่ามีการเลือกข้อมูลถูกต้องหรือไม่

				// Check ช่องวงเงินที่ต้องการว่ามีการกรอกข้อมูลหรือไม่
				$("#crf_finance_req_number").keyup(function () {
					if ($("#crf_finance_req_number").val() != "") {
						// $('#user_submit').prop('disabled', false);
					}
				});

				$("#crf_finance_req_number").blur(function () {
					if ($("#crf_finance_req_number").val() != "") {
						// $('#user_submit').prop('disabled', false);
					} else {
						// $('#user_submit').prop('disabled', true);
					}
				});
				// Check ช่องวงเงินที่ต้องการว่ามีการกรอกข้อมูลหรือไม่

				// test check file 1
				$("#user_submit").click(function () {
					if (
						$('input:checkbox[name="crf_sub_oldcus_changeaddress"]').prop(
							"checked"
						)
					) {
						if (
							$('input:radio[name="crf_person_type"]:checked').val() ==
							PERSON_TYPE.NATURAL
						) {
							if ($("#crf_file_person").val() == "") {
								alert("กรุณาอัพโหลดไฟล์ สำเนาบัตรประชาชน ด้วยค่ะ");
								$("#user_submit").prop("disabled", true);
								$("#alert_file1").html(
									'<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ สำเนาบัตรประชาชน ด้วยค่ะ</div>'
								);
								return;
							} else {
								$("#user_submit").prop("disabled", false);
								$("#alert_file1").html("");
							}
						} else if (
							$('input:radio[name="crf_person_type"]:checked').val() ==
							PERSON_TYPE.JURISTIC
						) {
							if ($("#crf_file1").val() == "") {
								alert("กรุณาอัพโหลดไฟล์ ภพ20 ด้วยค่ะ");
								$("#user_submit").prop("disabled", true);
								$("#alert_file1").html(
									'<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ ภพ20 ด้วยค่ะ</div>'
								);
								return;
							} else {
								$("#user_submit").prop("disabled", false);
								$("#alert_file1").html("");
							}
						}
					}

					// Validation สำหรับ ปรับ Credit term
					if (
						$('input:checkbox[name="crf_change_creditterm"]').prop(
							"checked"
						)
					) {
						if ($("#crf_condition_credit").val() == "") {
							alert("กรุณาเลือกเงื่อนไขการขอปรับ Credit term ด้วย ค่ะ");
							$("#alert_crf_condition_credit").html(
								'<div class="alert alert-danger" role="alert">กรุณาเลือกเงื่อนไขการขอปรับ Credit term ด้วย ค่ะ</div>'
							);
							$("#user_submit").prop("disabled", true);
							return;
						} else {
							$("#alert_crf_condition_credit").html("");
							$("#user_submit").prop("disabled", false);
						}

						// เช็ค showcredit2 และ crf_creditterm2 (dynamic element จาก AJAX)
						var hasShowCredit2 = $("#showcredit2").length > 0 && $("#showcredit2").val() != "";
						var hasCreditTerm2 = $("#crf_creditterm2").length > 0 && $("#crf_creditterm2").val() != "";
						
						if (!hasShowCredit2 && !hasCreditTerm2) {
							alert("กรุณาเลือก Credit term ที่ต้องการด้วย ค่ะ");
							$("#alert_showcredit2").html(
								'<div class="alert alert-danger" role="alert">กรุณาเลือก Credit term ที่ต้องการด้วย ค่ะ</div>'
							);
							$("#user_submit").prop("disabled", true);
							return;
						} else {
							$("#alert_showcredit2").html("");
							$("#user_submit").prop("disabled", false);
						}
					}

					// Validation สำหรับ ปรับ Expected Date Payment
					// Note: ไม่ต้อง validate เพราะใช้ crf_arcustdueid ที่มีอยู่แล้ว (required field)
					// แค่ติ๊ก checkbox พอ

					if (
						$('input:checkbox[name="crf_sub_oldcus_changefinance"]').prop(
							"checked"
						)
					) {
						if ($("#crf_finance_change_total").val() == "") {
							alert("กรุณาระบุ รายละเอียดการขอเปลี่ยนแปลงแก้ไขวงเงิน ด้วยค่ะ");
							$("#alert_crf_finance_status").html(
								'<div class="alert alert-danger" role="alert">กรุณาเลือก สถานะวงเงิน ด้วยค่ะ</div>'
							);
							$("#alert_crf_finance_change_status").html(
								'<div class="alert alert-danger" role="alert">กรุณาเลือก สถานะการขอวงเงิน ด้วยค่ะ</div>'
							);
							$("#alert_crf_finance_change_number").html(
								'<div class="alert alert-danger" role="alert">กรุณาระบุ จำนวนเงิน ที่ต้องการด้วยค่ะ</div>'
							);
							$("#user_submit").prop("disabled", true);
							return;
						} else {
							$("#alert_crf_finance_status").html("");
							$("#alert_crf_finance_change_status").html("");
							$("#alert_crf_finance_change_number").html("");
							$("#user_submit").prop("disabled", false);
						}
					}
				});

			// Handle NEW CUSTOMER (1)
			} else if ($(this).val() == CUSTOMER_TYPE.NEW) {
				// Enable all fields for new customer
				enableAllFieldsForNewCustomer();
				
				// Pre-check finance type and show finance detail
				$('input:radio[class="crf_financev1"]').prop("checked", true);
				$(".finance_request_detail").css("display", "");
				
				// Show/hide sections
				$(".newPrimanage").css("display", "");
				$("#showPrimanage").css("display", "none");

				///////////////////////////////////////////////
				// Control Person Type (Natural/Juristic) for NEW customer
				///////////////////////////////////////////////
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

				///////////////////////////////////////////////
				// Validation Handlers for NEW customer
				///////////////////////////////////////////////
				
				// Sales Rep validation with reusable function
				const validateSalesRep = function() {
					const value = $(this).val();
					if (!value) {
						showAlert('alert_salesreps', ALERT_MESSAGES.REQUIRED_SALES_REPS);
						$("#crf_customername").val("");
						return false;
					}
					
					if (!minsalesreps(value)) {
						showAlert('alert_salesreps', ALERT_MESSAGES.INVALID_SALES_REPS);
						$(this).val("");
						return false;
					}
					
					clearAlert('alert_salesreps');
					$("#user_submit").prop("disabled", false);
					return true;
				};

				$("#crf_salesreps").blur(validateSalesRep).focusout(validateSalesRep);
				
				$("#crf_salesreps").keyup(function () {
					if (!$(this).val()) {
						showAlert('alert_salesreps', ALERT_MESSAGES.REQUIRED_SALES_REPS);
						$("#crf_customername").val("");
					} else {
						clearAlert('alert_salesreps');
					}
				});

				///////////////////////////////////////////////
				// Validation Handlers - Customer Name
				///////////////////////////////////////////////
				const validateCustomerName = function() {
					const cusname = $("#crf_customername").val();
					const comname = getCurrentCompany();
					
					if (!cusname) {
						showAlert('alert_customername', ALERT_MESSAGES.REQUIRED_CUSTOMER_NAME);
						return false;
					}
					
					clearAlert('alert_customername');
					if ($("#checkCompany").val() == CUSTOMER_TYPE.NEW) {
						checkDuplicateNameCustomer(cusname, comname);
					}
					$("#user_submit").prop("disabled", false);
					return true;
				};

				$("#crf_customername").blur(validateCustomerName).focusout(validateCustomerName);

				///////////////////////////////////////////////
				// Validation Handlers - Company Create Date
				///////////////////////////////////////////////
				const validateCompanyDate = function() {
					if (!validateRequired('#crf_cuscompanycreate', 'alert_cuscompanycreate', ALERT_MESSAGES.REQUIRED_COMPANY_DATE)) {
						return false;
					}
					$("#user_submit").prop("disabled", false);
					return true;
				};

				$("#crf_cuscompanycreate").blur(validateCompanyDate)
					.focusout(validateCompanyDate)
					.change(validateCompanyDate);

				///////////////////////////////////////////////
				// Validation Handlers - Tax ID
				///////////////////////////////////////////////
				const validateTaxID = function() {
					const value = $(this).val();
					
					if (!value) {
						showAlert('alert_crf_customertaxid', 'กรุณาระบุเลขที่ประจำตัวผู้เสียภาษีด้วยค่ะ');
						return false;
					}
					
					if (!checktax(value)) {
						showAlert('alert_crf_customertaxid', ALERT_MESSAGES.INVALID_TAX_ID);
						$("#user_submit").prop("disabled", true);
						return false;
					}
					
					clearAlert('alert_crf_customertaxid');
					$("#user_submit").prop("disabled", false);
					return true;
				};

				$("#crf_customertaxid").blur(validateTaxID).focusout(validateTaxID);

				// Check สาขา
				$("#crf_customerbranch").blur(function () {
					if ($(this).val() == "") {
						$("#alert_crf_customerbranch").html(
							'<div class="alert alert-danger" role="alert">กรุณาระบุสาขา ด้วยค่ะ</div>'
						);
					} else {
						$("#alert_crf_customerbranch").html("");
						$("#user_submit").prop("disabled", false);
					}
				});
				$("#crf_customerbranch").focusout(function () {
					if ($(this).val() == "") {
						$("#alert_crf_customerbranch").html(
							'<div class="alert alert-danger" role="alert">กรุณาระบุสาขา ด้วยค่ะ</div>'
						);
					} else {
						$("#alert_crf_customerbranch").html("");
						$("#user_submit").prop("disabled", false);
					}
				});
				//Check สาขา

				// Check เลือกประเภทที่อยู่
				$("#crf_addressname").focus(function () {
					var crf_addresstype = $(
						'input:radio[name="crf_addresstype"]:checked'
					);
					if (crf_addresstype.length < 1) {
						$("#alert_addresstype").html(
							'<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทที่อยู่ด้วยค่ะ ด้วยค่ะ</div>'
						);
					} else {
						$("#alert_addresstype").html("");
						$("#user_submit").prop("disabled", false);
					}
				});
				$('input:radio[name="crf_addresstype"]').click(function () {
					if ($(this).val() == "") {
						$("#alert_addresstype").html(
							'<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทที่อยู่ด้วยค่ะ ด้วยค่ะ</div>'
						);
					} else {
						$("#alert_addresstype").html("");
						$("#user_submit").prop("disabled", false);
					}
				});

				// Check เลือกประเภทที่อยู่

				// Check Address Name Check Address Name Check Address Name
				$("#crf_addressname").blur(function () {
					if ($(this).val() == "") {
						$("#alert_addressname").html(
							'<div class="alert alert-danger" role="alert">กรุณาระบุที่อยู่สำหรับการเปิดใบกำกับภาษีด้วยค่ะ</div>'
						);
					} else {
						$("#alert_addressname").html("");
						$("#user_submit").prop("disabled", false);
					}
				});
				$("#crf_addressname").focusout(function () {
					if ($(this).val() == "") {
						$("#alert_addressname").html(
							'<div class="alert alert-danger" role="alert">กรุณาระบุที่อยู่สำหรับการเปิดใบกำกับภาษีด้วยค่ะ</div>'
						);
					} else {
						$("#alert_addressname").html("");
						$("#user_submit").prop("disabled", false);
					}
				});
				$("#crf_addressname").keyup(function () {
					if ($(this).val() == "") {
						$("#alert_addressname").html(
							'<div class="alert alert-danger" role="alert">กรุณาระบุที่อยู่สำหรับการเปิดใบกำกับภาษีด้วยค่ะ</div>'
						);
					} else {
						$("#alert_addressname").html("");
					}
				});
				// Check Address Name Check Address Name Check Address Name

				// Check ช่องผู้ติดต่อว่ามีการกรอกข้อมูลเข้ามาหรือไม่
				$("#crf_namecontact").blur(function () {
					if ($(this).val() == "") {
						$("#alert_namecontact").html(
							'<div class="alert alert-danger" role="alert">กรุณาระบุชื่อผู้ติดต่อด้วยค่ะ</div>'
						);
					} else {
						$("#alert_namecontact").html("");
						$("#user_submit").prop("disabled", false);
					}
				});
				$("#crf_namecontact").focusout(function () {
					if ($(this).val() == "") {
						$("#alert_namecontact").html(
							'<div class="alert alert-danger" role="alert">กรุณาระบุชื่อผู้ติดต่อด้วยค่ะ</div>'
						);
					} else {
						$("#alert_namecontact").html("");
						$("#user_submit").prop("disabled", false);
					}
				});

				$("#crf_namecontact").keyup(function () {
					if ($(this).val() == "") {
						$("#alert_namecontact").html(
							'<div class="alert alert-danger" role="alert">กรุณาระบุชื่อผู้ติดต่อด้วยค่ะ</div>'
						);
					} else {
						$("#alert_namecontact").html("");
					}
				});
				// Check ช่องผู้ติดต่อว่ามีการกรอกข้อมูลเข้ามาหรือไม่

				// Check ช่องเบอร์โทรว่ามีการกรอกข้อมูลหรือไม่
				$("#crf_telcontact").blur(function () {
					if ($(this).val() == "") {
						$("#alert_telcontact").html(
							'<div class="alert alert-danger" role="alert">กรุณาระบุเบอร์ผู้ติดต่อด้วยค่ะ</div>'
						);
					} else {
						if (checkTelPat($(this).val()) == false) {
							$("#alert_telcontact").html(
								'<div class="alert alert-danger" role="alert">กรุณาระบุเฉพาะตัวเลขเท่านั้น</div>'
							);
							$("#user_submit").prop("disabled", true);
						} else {
							$("#alert_telcontact").html("");
							$("#user_submit").prop("disabled", false);
						}
					}
				});

				$("#crf_telcontact").focusout(function () {
					if ($(this).val() == "") {
						$("#alert_telcontact").html(
							'<div class="alert alert-danger" role="alert">กรุณาระบุเบอร์ผู้ติดต่อด้วยค่ะ</div>'
						);
					} else {
						if (checkTelPat($(this).val()) == false) {
							$("#alert_telcontact").html(
								'<div class="alert alert-danger" role="alert">กรุณาระบุเฉพาะตัวเลขเท่านั้น</div>'
							);
							$("#user_submit").prop("disabled", true);
						} else {
							$("#alert_telcontact").html("");
							$("#user_submit").prop("disabled", false);
						}
					}
				});

				$("#crf_telcontact").keyup(function () {
					if ($(this).val() != "") {
						$("#alert_telcontact").html(
							'<div class="alert alert-danger" role="alert">กรุณาระบุเบอร์ผู้ติดต่อด้วยค่ะ</div>'
						);
					} else {
						$("#alert_telcontact").html("");
					}
				});
				// Check ช่องเบอร์โทรว่ามีการกรอกข้อมูลหรือไม่

				// Check ช่อง อีเมลว่ามีการกรอกข้อมูลหรือไม่
				// $('#crf_emailcontact').blur(function () {
				//     if ($(this).val() == '') {
				//         $('#alert_emailcontact').html('<div class="alert alert-danger" role="alert">กรุณาระบุอีเมลผู้ติดต่อด้วยค่ะ</div>');
				//     } else {
				//         $('#alert_emailcontact').html('');
				//     }
				// });
				// $('#crf_regiscost').focus(function () {
				//     if ($('#crf_emailcontact').val() == '') {
				//         $('#alert_emailcontact').html('<div class="alert alert-danger" role="alert">กรุณาระบุอีเมลผู้ติดต่อด้วยค่ะ</div>');
				//         $('#crf_regiscost').val('');
				//     } else {
				//         $('#alert_emailcontact').html('');
				//     }
				// });
				// $('#crf_regiscost').keyup(function () {
				//     if ($('#crf_emailcontact').val() == '') {
				//         $('#alert_emailcontact').html('<div class="alert alert-danger" role="alert">กรุณาระบุอีเมลผู้ติดต่อด้วยค่ะ</div>');
				//         $('#crf_regiscost').val('');
				//     } else {
				//         $('#alert_emailcontact').html('');
				//     }
				// });
				// $('#crf_emailcontact').keyup(function () {
				//     if ($(this).val() != '') {
				//         $('#alert_emailcontact').html('');
				//     }
				// });
				// Check ช่อง อีเมลว่ามีการกรอกข้อมูลหรือไม่

				// Check ช่อง ทุนจดทะเบียน
				$("#crf_regiscost").blur(function () {
					if ($(this).val() == "") {
						$("#alert_regiscost").html(
							'<div class="alert alert-danger" role="alert">กรุณาระบุทุนจดทะเบียนด้วยค่ะ</div>'
						);
					} else {
						$("#alert_regiscost").html("");
						$("#user_submit").prop("disabled", false);
					}
				});
				$("#crf_regiscost").focusout(function () {
					if ($(this).val() == "") {
						$("#alert_regiscost").html(
							'<div class="alert alert-danger" role="alert">กรุณาระบุทุนจดทะเบียนด้วยค่ะ</div>'
						);
					} else {
						$("#alert_regiscost").html("");
						$("#user_submit").prop("disabled", false);
					}
				});

				$("#crf_regiscost").keyup(function () {
					if ($(this).val() == "") {
						$("#alert_regiscost").html(
							'<div class="alert alert-danger" role="alert">กรุณาระบุทุนจดทะเบียนด้วยค่ะ</div>'
						);
					} else {
						$("#alert_regiscost").html("");
					}
				});
				// Check ช่อง ทุนจดทะเบียน

				// Check ประเภทบริษัท

				// Check ประเภทบริษัท

				// Check ช่องรายชื่อบุคคลในแต่ระดับบริหารที่สำคัญ
				$(
					"#crf_primanage_dept , #crf_primanage_name , #crf_primanage_posi , #crf_primanage_email"
				).blur(function () {
					if ($(this).val() == "") {
						$("#alert_primanage").html(
							'<div class="alert alert-danger" role="alert">กรุณาระบุข้อมูลให้ครบถ้วนด้วยค่ะ</div>'
						);
						$('input:radio[name="crf_typeofbussi"]').prop("checked", false);
						exit;
					} else {
						$("#alert_primanage").html("");
					}
				});

				$('input:radio[name="crf_typeofbussi"]').click(function () {
					if (
						$("#crf_primanage_dept").val() == "" ||
						$("#crf_primanage_name").val() == "" ||
						$("#crf_primanage_posi").val() == "" ||
						$("#crf_primanage_email").val() == ""
					) {
						$("#alert_primanage").html(
							'<div class="alert alert-danger" role="alert">กรุณาระบุข้อมูลให้ครบถ้วนด้วยค่ะ</div>'
						);
						$('input:radio[name="crf_typeofbussi"]').prop("checked", false);
						exit;
					} else {
						$("#alert_primanage").html("");
					}
				});

				$(
					"#crf_primanage_dept , #crf_primanage_name , #crf_primanage_posi , #crf_primanage_email"
				).keyup(function () {
					if ($(this).val() != "") {
						$("#alert_primanage").html("");
					}

					var crf_companytype = $(
						'input:radio[name="crf_companytype"]:checked'
					);
					if (crf_companytype.length < 1) {
						$(this).val("");
						$("#alert_companytype").html(
							'<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทบริษัทด้วยค่ะ</div>'
						);
					} else {
						$("#alert_primanage").html("");
						$("#alert_companytype").html("");
					}
				});
				// Check ช่องรายชื่อบุคคลในแต่ระดับบริหารที่สำคัญ

				// Check ประเภทของ ธุรกิจว่ามีการเลือกข้อมูลหรือไม่
				$(document).on(
					"change",
					'input[type="checkbox"][id="crf_process"]:checked',
					function () {
						var crf_typeofbussi = $(
							'input:radio[name="crf_typeofbussi"]:checked'
						);
						if (crf_typeofbussi.length < 1) {
							$("#alert_typeofbussi").html(
								'<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทธุรกิจด้วยค่ะ</div>'
							);
							$(this).prop("checked", false);
							exit;
						} else {
							$("#alert_typeofbussi").html("");
						}
					}
				);
				// Check ประเภทของ ธุรกิจว่ามีการเลือกข้อมูลหรือไม่

				// Check กระบวนการผลิตว่ามีการเลือกข้อมูลเข้ามาหรือไม่
				$("#crf_forecast").focus(function () {
					var crf_process = $(
						'input[type="checkbox"][id="crf_process"]:checked'
					);
					if (crf_process.length < 1) {
						$("#alert_process").html(
							'<div class="alert alert-danger" role="alert">กรุณาเลือกกระบวนการผลิตหลักด้วยค่ะ</div>'
						);
						$(this).val("");
					} else {
						$("#alert_process").html("");
					}
				});
				$("#crf_forecast").keyup(function () {
					var crf_process = $(
						'input[type="checkbox"][id="crf_process"]:checked'
					);
					if (crf_process.length < 1) {
						$("#alert_process").html(
							'<div class="alert alert-danger" role="alert">กรุณาเลือกกระบวนการผลิตหลักด้วยค่ะ</div>'
						);
						$(this).val("");
					} else {
						$("#alert_process").html("");
					}

					if ($(this).val() != "") {
						$("#alert_forecast").html("");
					}
				});
				// Check กระบวนการผลิตว่ามีการเลือกข้อมูลเข้ามาหรือไม่

				// Check คาดการปริมาณการขายว่ามีการกรอกข้อมูลงไปหรือไม่
				$("#crf_forecast").blur(function () {
					if ($(this).val() == "") {
						$("#alert_forecast").html(
							'<div class="alert alert-danger" role="alert">กรุณาระบุรายละเอียดคาดการปริมาณการขายด้วยค่ะ</div>'
						);
					} else {
						$("#alert_forecast").html("");
					}
				});
				// Check คาดการปริมาณการขายว่ามีการกรอกข้อมูลงไปหรือไม่

				// Check File Upload ว่ามีการอัพโหลดไฟล์หรือยังก่อ่นที่จะเลือก Credit term
				$("#crf_creditterm").change(function () {
					/////////////////////////////////////////////////////
					// Check เงื่อนไขว่าเป็นลูกค้า บุคคล หรือ นิติบุคคล
					////////////////////////////////////////////////////

					if (
						$('input:radio[name="crf_person_type"]:checked').val() == PERSON_TYPE.NATURAL
					) {
						if ($("#crf_file_person").val() == "") {
							$("#alert_file_person").html(
								'<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ สำเนาบัตรประชาชน ด้วยค่ะ</div>'
							);
							$("#crf_creditterm").val("");
						} else {
							$("#alert_file_person").html("");
							$("#user_submit").prop("disabled", false);
						}
					} else if (
						$('input:radio[name="crf_person_type"]:checked').val() == PERSON_TYPE.JURISTIC
					) {
						if ($("#crf_file1").val() == "") {
							$("#alert_file1").html(
								'<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ ภพ.20 ด้วยค่ะ</div>'
							);
							$("#crf_creditterm").val("");
						} else {
							$("#alert_file1").html("");
							$("#user_submit").prop("disabled", false);
						}

						if ($("#crf_file2").val() == "") {
							$("#alert_file2").html(
								'<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ หนังสือรับรอง ด้วยค่ะ</div>'
							);
							$("#crf_creditterm").val("");
						} else {
							$("#alert_file2").html("");
							$("#user_submit").prop("disabled", false);
						}

						if ($("#crf_file3").val() == "") {
							$("#alert_file3").html(
								'<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ ข้อมูลทั่วไป ด้วยค่ะ</div>'
							);
							$("#crf_creditterm").val("");
						} else {
							$("#alert_file3").html("");
							$("#user_submit").prop("disabled", false);
						}

						if ($("#crf_file4").val() == "") {
							$("#alert_file4").html(
								'<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ งบแสดงฐานะทางการเงิน ด้วยค่ะ</div>'
							);
							$("#crf_creditterm").val("");
						} else {
							$("#alert_file4").html("");
							$("#user_submit").prop("disabled", false);
						}

						if ($("#crf_file5").val() == "") {
							$("#alert_file5").html(
								'<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ งบกำไรขาดทุน ด้วยค่ะ</div>'
							);
							$("#crf_creditterm").val("");
						} else {
							$("#alert_file5").html("");
							$("#user_submit").prop("disabled", false);
						}

						if ($("#crf_file6").val() == "") {
							$("#alert_file6").html(
								'<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ อัตราส่วนสภาพคล่อง ด้วยค่ะ</div>'
							);
							$("#crf_creditterm").val("");
						} else {
							$("#alert_file6").html("");
							$("#user_submit").prop("disabled", false);
						}
					}

					/////////////////////////////////////////////////////
					// Check เงื่อนไขว่าเป็นลูกค้า บุคคล หรือ นิติบุคคล
					////////////////////////////////////////////////////

					if ($(this).val() != "") {
						$("#alert_creditterm").html("");
						$('input:radio[name="crf_condition_bill"]').prop("disabled", false);
					} else {
						$("#alert_creditterm").html(
							'<div class="alert alert-danger" role="alert">กรุณาเลือก Credit Term ด้วยค่ะ</div>'
						);
						$('input:radio[name="crf_condition_bill"]').prop("checked", false);
						$('input:radio[name="crf_condition_bill"]').prop("disabled", true);

						$('input:radio[name="crf_condition_money"]').prop("checked", false);
					}
				});
				// Check File Upload ว่ามีการอัพโหลดไฟล์หรือยังก่อ่นที่จะเลือก Credit term

				// Check Upload File 1 - 6 Element
				$("#crf_file1").change(function () {
					if ($(this).val() != "") {
						$("#alert_file1").html("");
						$("#user_submit").prop("disabled", false);
					}
				});

				$("#crf_file2").change(function () {
					if ($(this).val() != "") {
						$("#alert_file2").html("");
						$("#user_submit").prop("disabled", false);
					}
				});

				$("#crf_file3").change(function () {
					if ($(this).val() != "") {
						$("#alert_file3").html("");
						$("#user_submit").prop("disabled", false);
					}
				});

				$("#crf_file4").change(function () {
					if ($(this).val() != "") {
						$("#alert_file4").html("");
						$("#user_submit").prop("disabled", false);
					}
				});

				$("#crf_file5").change(function () {
					if ($(this).val() != "") {
						$("#alert_file5").html("");
						$("#user_submit").prop("disabled", false);
					}
				});

				$("#crf_file6").change(function () {
					if ($(this).val() != "") {
						$("#alert_file6").html("");
						$("#user_submit").prop("disabled", false);
					}
				});

				// Check Upload File 1 - 6 Element

				// Check Credit Term ว่ามีการเลือกหรือไม่
				$('input:radio[name="crf_condition_bill"]').click(function () {
					if ($("#crf_creditterm").val() == "") {
						$("#alert_creditterm").html(
							'<div class="alert alert-danger" role="alert">กรุณาเลือก Credit Term ด้วยค่ะ</div>'
						);
						$('input:radio[name="crf_condition_bill"]').prop("checked", false);
						$('input:radio[name="crf_condition_bill"]').prop("disabled", true);
						exit;
					} else {
						$("#alert_creditterm").html("");
					}
				});
				// Check Credit Term ว่ามีการเลือกหรือไม่

				// Check เงื่อนไขการวางบิล ว่าได้มีการเลือกแล้วหรือยัง
				$('input:radio[name="crf_condition_money"]').click(function () {
					var crf_condition_bill = $(
						"input:radio[name=crf_condition_bill]:checked"
					);
					if (crf_condition_bill.length < 1) {
						$("#alert_condition_bill").html(
							'<div class="alert alert-danger" role="alert">กรุณาเลือกเงื่อนไขการวางบิลด้วยค่ะ</div>'
						);
						$('input:radio[name="crf_condition_money"]').prop("checked", false);
						exit;
					} else {
						$("#alert_condition_bill").html("");
					}
				});
				// Check เงื่อนไขการวางบิล ว่าได้มีการเลือกแล้วหรือยัง

				// Check เงื่อนไขการรับชำระเงินว่ามีการเลือกข้อมูลถูกต้องหรือไม่
				if ($("#checkCusType").val() == 1) {
					$("#crf_finance_req_number").focus(function () {
						var crf_condition_money = $(
							'input:radio[name="crf_condition_money"]:checked'
						);
						if (crf_condition_money.length < 1) {
							$("#alert_condition_money").html(
								'<div class="alert alert-danger" role="alert">กรุณาเลือกเงื่อนไขการชำระเงินด้วยค่ะ</div>'
							);
							$("#crf_finance_req_number").val("");
						} else {
							if (crf_condition_money.val() == "รับเช็ค") {
								if ($("#crf_recive_cheuqetable").val() == "") {
									$("#alert_recive_cheuqetable").html(
										'<div class="alert alert-danger" role="alert">กรุณา แนบตารางวางบิล / รับเช็ค ด้วยค่ะ</div>'
									);
									$("#crf_finance_req_number").val("");
								} else {
									$("#alert_recive_cheuqetable").html("");
								}

								if ($("#crf_recive_cheuqedetail").val() == "") {
									$("#alert_recive_cheuqedetail").html(
										'<div class="alert alert-danger" role="alert">กรุณา รายละเอียดเพิ่มเติม ด้วยค่ะ</div>'
									);
									$("#crf_finance_req_number").val("");
								} else {
									$("#alert_recive_cheuqedetail").html("");
								}
							} else {
								$("#alert_condition_money").html("");
							}
						}
					});

					$("#crf_finance_req_number").keyup(function () {
						var crf_condition_money = $(
							'input:radio[name="crf_condition_money"]:checked'
						);
						if (crf_condition_money.length < 1) {
							$("#alert_condition_money").html(
								'<div class="alert alert-danger" role="alert">กรุณาเลือกเงื่อนไขการชำระเงินด้วยค่ะ</div>'
							);
							$("#crf_finance_req_number").val("");
						} else {
							if (crf_condition_money.val() == "รับเช็ค") {
								if ($("#crf_recive_cheuqetable").val() == "") {
									$("#alert_recive_cheuqetable").html(
										'<div class="alert alert-danger" role="alert">กรุณา แนบตารางวางบิล / รับเช็ค ด้วยค่ะ</div>'
									);
									$("#crf_finance_req_number").val("");
								} else {
									$("#alert_recive_cheuqetable").html("");
								}

								if ($("#crf_recive_cheuqedetail").val() == "") {
									$("#alert_recive_cheuqedetail").html(
										'<div class="alert alert-danger" role="alert">กรุณา รายละเอียดเพิ่มเติม ด้วยค่ะ</div>'
									);
									$("#crf_finance_req_number").val("");
								} else {
									$("#alert_recive_cheuqedetail").html("");
								}
							} else {
								$("#alert_condition_money").html("");
							}
						}
					});
					// Check เงื่อนไขการรับชำระเงินว่ามีการเลือกข้อมูลถูกต้องหรือไม่
				}

				// Check ช่องวงเงินที่ต้องการว่ามีการกรอกข้อมูลหรือไม่
				$("#crf_finance_req_number").keyup(function () {
					if ($("#crf_finance_req_number").val() != "") {
						$("#user_submit").prop("disabled", false);
					}
				});

				$("#crf_finance_req_number").blur(function () {
					if ($("#crf_finance_req_number").val() != "") {
						$("#user_submit").prop("disabled", false);
					} else {
						$("#user_submit").prop("disabled", true);
					}
				});
				// Check ช่องวงเงินที่ต้องการว่ามีการกรอกข้อมูลหรือไม่

				// Check ขั้นตอนสุดท้าย
				// $('#user_submit').click(function(){
				//     checkBeforeSave();
				// })
			} else {
			}
			//Control credit term
		});
	}
	// End Control Add page

    $(document).on('click', '.selectCusCode', function () {
        const element = $(this);
        const customercode = element.attr('data_crf_customercode');
        const customername = element.attr('data_crf_customername');
		const dataareaid = element.attr('data_crf_area');
        
        // เช็คว่ามีรายการค้างหรือไม่ก่อนที่จะโหลดข้อมูล
        checkCustomerPendingOrders(customercode , dataareaid , function(response) {
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

    function loaddataforadd(element)
    {
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

        // เพิ่มข้อมูลใหม่ 04/08/2020
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
        // let data_crf_finance = element.attr('data_crf_finance');
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

        let base_url = $('#checkbaseurl').val();
        let data_crfcus_memo2 = element.attr('data_crfcus_memo2');
        let data_crfcus_countmonthdeli = element.attr('data_crfcus_countmonthdeli');

		let data_ax_creditmaxvalue = element.attr('data_ax_creditmaxvalue');
		let data_ax_creditusedvalue = element.attr('data_ax_creditusedvalue');
		let data_ax_creditavailvalue = element.attr('data_ax_creditavailvalue');
        
        // Debug log
        console.log('Customer selected:', {
            code: data_crf_customercode,
            name: data_crf_customername,
            area: data_crf_area,
            cusid: data_crf_cusid
        });
        
        // check money limit
        
        // For not change attach file
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


        // Zone get file to add page
        $('#cus2showfilePersonal').html('<span><a id="custype2filePersonal" href="' + base_url + 'upload/' + data_crfcus_personal + '" target="_blank">' + data_crfcus_personal + '</a></span>');


        $('#cus2showfile1').html('<span><a id="custype2file1" href="#" data-toggle="modal" data-target="#show_file1" data_cus2file1="' + data_crfcus_file1 + '">' + data_crfcus_file1 + '</a></span>');

        $('#custype2file1').click(function () {
            var dataFile1 = $(this).attr('data_cus2file1');
            var url = base_url + 'upload/';

            // $('#embedshowfile1').attr('src', url + dataFile1);

            var cutFileType1 = dataFile1.substr(-3, 4);
            if (cutFileType1 == 'jpg' || cutFileType1 == 'JPG' || cutFileType1 == 'png' || cutFileType1 == 'PNG') {
                $('#embedshowfile1Img').attr('src', url + dataFile1);
                $('#embedshowfile1').hide();
            } else {
                $('#embedshowfile1').attr('src', url + dataFile1);
                $('#embedshowfile1Img').hide();
            }
        });


        $('#cus2showfile2').html('<span><a id="custype2file2" href="#" data-toggle="modal" data-target="#show_file2" data_cus2file2="' + data_crfcus_file2 + '">' + data_crfcus_file2 + '</a></span>');

        $('#custype2file2').click(function () {
            var dataFile2 = $(this).attr('data_cus2file2');
            var url = base_url + 'upload/';

            // $('#embedshowfile1').attr('src', url + dataFile1);

            var cutFileType2 = dataFile2.substr(-3, 4);
            if (cutFileType2 == 'jpg' || cutFileType2 == 'JPG' || cutFileType2 == 'png' || cutFileType2 == 'PNG') {
                $('#embedshowfile2Img').attr('src', url + dataFile2);
                $('#embedshowfile2').hide();
            } else {
                $('#embedshowfile2').attr('src', url + dataFile2);
                $('#embedshowfile2Img').hide();
            }
        });


        $('#cus2showfile3').html('<span><a id="custype2file3" href="#" data-toggle="modal" data-target="#show_file3" data_cus2file3="' + data_crfcus_file3 + '">' + data_crfcus_file3 + '</a></span>');

        $('#custype2file3').click(function () {
            var dataFile3 = $(this).attr('data_cus2file3');
            var url = base_url + 'upload/';

            // $('#embedshowfile1').attr('src', url + dataFile1);

            var cutFileType3 = dataFile3.substr(-3, 4);
            if (cutFileType3 == 'jpg' || cutFileType3 == 'JPG' || cutFileType3 == 'png' || cutFileType3 == 'PNG') {
                $('#embedshowfile3Img').attr('src', url + dataFile3);
                $('#embedshowfile3').hide();
            } else {
                $('#embedshowfile3').attr('src', url + dataFile3);
                $('#embedshowfile3Img').hide();
            }
        });


        $('#cus2showfile4').html('<span><a id="custype2file4" href="#" data-toggle="modal" data-target="#show_file4" data_cus2file4="' + data_crfcus_file4 + '">' + data_crfcus_file4 + '</a></span>');

        $('#custype2file4').click(function () {
            var dataFile4 = $(this).attr('data_cus2file4');
            var url = base_url + 'upload/';

            // $('#embedshowfile1').attr('src', url + dataFile1);

            var cutFileType4 = dataFile4.substr(-3, 4);
            if (cutFileType4 == 'jpg' || cutFileType4 == 'JPG' || cutFileType4 == 'png' || cutFileType4 == 'PNG') {
                $('#embedshowfile4Img').attr('src', url + dataFile4);
                $('#embedshowfile4').hide();
            } else {
                $('#embedshowfile4').attr('src', url + dataFile4);
                $('#embedshowfile4Img').hide();
            }
        });


        $('#cus2showfile5').html('<span><a id="custype2file5" href="#" data-toggle="modal" data-target="#show_file5" data_cus2file5="' + data_crfcus_file5 + '">' + data_crfcus_file5 + '</a></span>');

        $('#custype2file5').click(function () {
            var dataFile5 = $(this).attr('data_cus2file5');
            var url = base_url + 'upload/';

            // $('#embedshowfile1').attr('src', url + dataFile1);

            var cutFileType5 = dataFile5.substr(-3, 4);
            if (cutFileType5 == 'jpg' || cutFileType5 == 'JPG' || cutFileType5 == 'png' || cutFileType5 == 'PNG') {
                $('#embedshowfile5Img').attr('src', url + dataFile5);
                $('#embedshowfile5').hide();
            } else {
                $('#embedshowfile5').attr('src', url + dataFile5);
                $('#embedshowfile5Img').hide();
            }
        });


        $('#cus2showfile6').html('<span><a id="custype2file6" href="#" data-toggle="modal" data-target="#show_file6" data_cus2file6="' + data_crfcus_file6 + '">' + data_crfcus_file6 + '</a></span>');

        $('#custype2file6').click(function () {
            var dataFile6 = $(this).attr('data_cus2file6');
            var url = base_url + 'upload/';

            // $('#embedshowfile1').attr('src', url + dataFile1);

            var cutFileType6 = dataFile6.substr(-3, 4);
            if (cutFileType6 == 'jpg' || cutFileType6 == 'JPG' || cutFileType6 == 'png' || cutFileType6 == 'PNG') {
                $('#embedshowfile6Img').attr('src', url + dataFile6);
                $('#embedshowfile6').hide();
            } else {
                $('#embedshowfile6').attr('src', url + dataFile6);
                $('#embedshowfile6Img').hide();
            }
        });



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

        // เพิ่มข้อมูลใหม่ 04/08/2020
        $('#crf_textmemo').val(data_crf_textmemo);

        $('#crf_customertaxid').val(data_crf_taxid);
        $('#crf_customerbranch').val(data_crf_branch);
        $('#getmapurl_addpage').val(data_crf_mapurl);
        $('#getlinkgooglemap').attr('href', data_crf_mapurl);
        $('#mapfilelink').attr('data_mapfile', data_crf_mapfile);
        $('#getmapfile_addpage').val(data_crf_mapfile);
        $('#crf_customer_product').val(data_crfcus_products);

        // $('#value_crf_finance').val(data_crf_finance);

        $('#crf_creditterm option:selected').val(data_credit_id).text(data_credit_name);
        $('#oldCreditTerm').val(data_credit_id);


        // Set finance request number with proper formatting
        let financeValue = data_ax_creditmaxvalue;
        console.log('Loading from DB - Raw value:', financeValue);
        $('#crf_finance_req_number_calc').val(financeValue); // Store raw value without comma
        $('#crf_finance_req_number').val(financeValue); // Display with comma
        $('#crf_cusid').val(data_crf_cusid);

        if (data_crf_area == 'sln') {
            $('#crf_company_sln').prop('checked', true);
        }
        if (data_crf_area == 'poly') {
            $('#crf_company_poly').prop('checked', true);
        }
        if (data_crf_area == 'ca') {
            $('#crf_company_ca').prop('checked', true);
        }

        $('#addThArea').val(data_crf_area);



        if (data_oldcfr_addresstype == "ตาม ภ.พ.20") {
            $('input:radio[id="crf_addresstype1"]').prop('checked', true);
        } else {
            $('input:radio[id="crf_addresstype2"]').prop('checked', true);
        }


        if (data_crf_companytype == 1) {
            $('input:radio[class="crf_companytype1"]').prop('checked', true);
        } else if (data_crf_companytype == 2) {
            $('input:radio[class="crf_companytype2"]').prop('checked', true);
            $('#companytype2').css('display', '');
            $('#crf_companytype2').val(data_crf_companytype2);
        } else {
            $('input:radio[class="crf_companytype3"]').prop('checked', true);
            $('#companytype3').css('display', '');
            $('#crf_companytype3_1_1').val(data_crf_companytype3_1_1);
            $('#crf_companytype3_1_2').val(data_crf_companytype3_1_2);
            $('#crf_companytype3_2_1').val(data_crf_companytype3_2_1);
            $('#crf_companytype3_2_2').val(data_crf_companytype3_2_2);
        }


        if (data_crf_typeofbussi == 'ผู้ผลิต') {
            $('input:radio[class="crf_typeofbussi1"]').prop('checked', true);
        } else {
            $('input:radio[class="crf_typeofbussi2"]').prop('checked', true);
        }

        $('.newPrimanage').css('display', 'none');
        $('#showPrimanage').css('display', '');
        queryProcessUse(data_crf_cusid);
        queryPrimanageUse(data_crf_cusid);

        // Debug: ดูค่าที่ได้มา
        console.log('=== DEBUG CONDITION VALUES ===');
        console.log('data_crf_condition_bill:', data_crf_condition_bill);
        console.log('data_crf_condition_money:', data_crf_condition_money);
        console.log('data_crf_tablebill:', data_crf_tablebill);
        console.log('data_crf_mapbill:', data_crf_mapbill);
        console.log('data_crf_mapbill2:', data_crf_mapbill2);
        console.log('data_crf_recive_cheuqetable:', data_crf_recive_cheuqetable);

        if (data_crf_condition_bill == 'ส่งของพร้อมวางบิล') {
            $('input:radio[class="crf_condition_billv1"]').prop('checked', true);
        } else if (data_crf_condition_bill == 'วางบิลตามตาราง') {
            $('input:radio[class="crf_condition_billv2"]').prop('checked', true);
            $('.crf_condition_bill2').css('display', '');
            
            // แสดงไฟล์เดิมเป็นลิงก์ใน span และเก็บค่าไว้ใน hidden input
            if (data_crf_tablebill && data_crf_tablebill !== '' && data_crf_tablebill !== 'undefined') {
                $('#crf_tablebill_filename').html('<br><a href="' + base_url + 'upload/' + data_crf_tablebill + '" target="_blank" style="color: #0066cc; font-weight: bold;">' + data_crf_tablebill + '</a>');
                $('#editcusoldtablebill').val(data_crf_tablebill);
            }
            if (data_crf_mapbill && data_crf_mapbill !== '' && data_crf_mapbill !== 'undefined') {
                $('#crf_mapbill_filename').html('<br><a href="' + base_url + 'upload/' + data_crf_mapbill + '" target="_blank" style="color: #0066cc; font-weight: bold;">' + data_crf_mapbill + '</a>');
                $('#editcusoldmapbill').val(data_crf_mapbill);
            }
        } else if (data_crf_condition_bill == 'วางบิลทุกวันที่') {
            $('input:radio[class="crf_condition_billv3"]').prop('checked', true);
            $('.crf_condition_bill3').css('display', '');
            $('#crf_datebill').val(data_crf_datebill);
            
            // แสดงไฟล์เดิมเป็นลิงก์ใน span
            if (data_crf_mapbill2 && data_crf_mapbill2 !== '' && data_crf_mapbill2 !== 'undefined') {
                $('#crf_mapbill2_filename').html('<br><a href="' + base_url + 'upload/' + data_crf_mapbill2 + '" target="_blank" style="color: #0066cc; font-weight: bold;">' + data_crf_mapbill2 + '</a>');
                $('#editcusoldmapbill2').val(data_crf_mapbill2);
            }
        }

        if (data_crf_condition_money == "โอนเงิน") {
            $('input:radio[class="crf_condition_moneyv1"]').prop('checked', true);
        } else if (data_crf_condition_money == "รับเช็ค") {
            $('input:radio[class="crf_condition_moneyv2"]').prop('checked', true);
            $('.recive_cheuqe').css('display', '');
            
            // แสดงไฟล์เดิมเป็นลิงก์ใน span
            if (data_crf_recive_cheuqetable && data_crf_recive_cheuqetable !== '' && data_crf_recive_cheuqetable !== 'undefined') {
                $('#crf_recive_cheuqetable_filename').html('<br><a href="' + base_url + 'upload/' + data_crf_recive_cheuqetable + '" target="_blank" style="color: #0066cc; font-weight: bold;">' + data_crf_recive_cheuqetable + '</a>');
                $('#editcusoldcheuqetable').val(data_crf_recive_cheuqetable);
            }
            
            $('#crf_recive_cheuqedetail').val(data_crf_recive_cheuqedetail);
            $('#crf_recive_cheuqedetail').prop('readonly', true);
        }

        // Check radio button for crfcus_countmonthdeli - เช็คว่ามีข้อมูลก่อนถึงจะติ๊ก
        if (data_crfcus_countmonthdeli && data_crfcus_countmonthdeli !== '' && data_crfcus_countmonthdeli !== 'null' && data_crfcus_countmonthdeli !== 'undefined') {
            if (data_crfcus_countmonthdeli == "เดือนส่งของไม่นับ") {
                $('#crfcus_countmonthdeli1').prop('checked', true);
            } else if (data_crfcus_countmonthdeli == "นับเดือนส่งของ") {
                $('#crfcus_countmonthdel2').prop('checked', true);
            }
        } else {
            // ไม่มีข้อมูล - ไม่ติ๊กอะไรเลย
            $('input[name="crfcus_countmonthdeli"]').prop('checked', false);
        }

        $('#crfcus_memo2').val(data_crfcus_memo2);


        $('#crf_regiscost').val(function (index, value) {
            return value
                .replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                ;
        });



        // Clear autocomplete dropdowns
        $('#autoCusCode').html('');
        $('#autoCusname').html('');
        $('input:checkbox[id="crf_sub_oldcus"]').attr('onclick' , 'return false');
        
        // Load customer payment term from AX database and auto-select
        loadCustomerPaymentTerm(data_crf_customercode, data_crf_area, function(response) {
            if (response.status === 'success' && response.data) {
                // มีข้อมูล payment term จาก AX → auto select
                $('#crf_arcustdueid').val(response.data.arcustdueid);
                console.log('Payment term loaded:', response.data);
            } else {
                // ไม่มีข้อมูล payment term → ปล่อยว่าง (default option)
                $('#crf_arcustdueid').val('');
                console.log('No payment term found for customer:', data_crf_customercode);
            }
        });
        
        // Lock customer fields after successful selection
        lockCustomerFieldsTH();
    }

});

// ============================================================================
// Code ที่ย้ายมาจาก custom.js สำหรับหน้า add_th.php
// ============================================================================

// Remove Alert เมื่อมีการเลือกบริษัท
$('input[type="radio"][name=crf_company]').click(function () {
    var crf_company = $('input[type="radio"][name=crf_company]:checked');
    if (crf_company.length > 0) {
        $('#alert_company').fadeOut();
    }
});

// Check การเลือกประเภทลูกค้า หากไม่ได้เลือกอะไรเลยจะไม่สามารถดำเนินการขั้นต่อไปได้
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

// Control if change credit term is clicked
// >>> MOVED TO: assets/js/addth/oldcus_changecreditterm.js <<<

// Control Form Main ประเภทบริษัท
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

// Zone Customer Profile - เพิ่มรายการบุคคลสำคัญ
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

$(document).on('click', '.remove_pri', function () {
    var buttonid = $(this).attr("id");
    $('#priManage' + buttonid + '').remove();
});

// Condition of bill Control
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

// Condition of recive money control (Transfer , cheuqe)
$(document).on('click', 'input[name=crf_condition_money]', function () {
    if ($(this).val() == 'รับเช็ค') {
        $('.recive_cheuqe').css('display', '');
    } else {
        $('.recive_cheuqe').css('display', 'none');
    }
});

// Condition of finance type
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

// Calculate up and down finance
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

// Setup comma formatting for financial fields (using utility function)
setupCommaFormatting('input[name="crf_regiscost"]');

// Sync formatted value (with commas) to calc field (without commas) for finance_req_number
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

// Check File Format And Size
$('input[type=file][name=crf_file1],[name=crf_file2],[name=crf_file3],[name=crf_file4],[name=crf_file5],[name=crf_file6]').change(function () {
    var ext = $(this).val().split('.').pop().toLowerCase();
    // Allowed file types
    if ($.inArray(ext, ['pdf', 'jpg', 'png', 'jpeg', 'JPG', 'PNG']) == -1) {
        alert('อัพโหลดได้เฉพาะไฟล์นามสกุล .pdf , .jpg , .png เท่านั้น !!' + ext);
        $(this).val("");
    }
    if (this.files[0].size > 20971520) {
        alert("Maximum File size is 10MB !!");
        this.value = "";
        exit;
    }
});

// ============================================================================
// End of code ที่ย้ายมาจาก custom.js
// ============================================================================

function autoSearchCustomerDetail(cusCode) {
    // Store AJAX request reference
    currentRequest = $.ajax({
        url: 'main/searchCustomerDetail',
        method: 'POST',
        data: {
            cusCode: cusCode
        },
        timeout: 10000, // 10 second timeout
        success: function (data) {
            $('#autoCusCode').html(data);
            currentRequest = null;
        },
        error: function (xhr, status, error) {
            // Don't show error if request was aborted
            if (status !== "abort") {
                $('#autoCusCode').html(
                    '<div class="alert alert-warning small" role="alert">' +
                    'เกิดข้อผิดพลาดในการค้นหา กรุณาลองใหม่อีกครั้ง' +
                    '</div>'
                );
            }
            currentRequest = null;
        }
    });
}

function autoSearchCustomerDetailName(cusName){
    // Store AJAX request reference (reuse same variable for name search)
    currentRequest = $.ajax({
        url: 'main/searchCustomerDetailName',
        method: 'POST',
        data: {
            cusName: cusName
        },
        timeout: 10000, // 10 second timeout
        success: function(data){
            $('#autoCusname').html(data);
            currentRequest = null;
        },
        error: function (xhr, status, error) {
            // Don't show error if request was aborted
            if (status !== "abort") {
                $('#autoCusname').html(
                    '<div class="alert alert-warning small" role="alert">' +
                    'เกิดข้อผิดพลาดในการค้นหา กรุณาลองใหม่อีกครั้ง' +
                    '</div>'
                );
            }
            currentRequest = null;
        }
    });
}

// ============================================================================
// Utility Functions (ย้ายมาจาก function.js)
// ============================================================================

// Validation Functions
// Function validate sales reps format (D#### or M####)
function minsalesreps(salesrepIn)
{
    var checkSalesrepIn = /(^D[0-9]{4,4}$|^M[0-9]{4,4}$)/.test(salesrepIn);
    return checkSalesrepIn;
}

// Function เช็คเลขที่ผู้เสียภาษี (13 digits)
function checktax(taxIn)
{
    var checkTax = /(^[0-9]{13}$)/.test(taxIn);
    return checkTax;
}

// Function เช็ครูปแบบของเบอร์โทรศัพท์ (8-15 digits)
function checkTelPat(telIn)
{
    var checkTelPat = /(^[0-9]{8,15}$)/.test(telIn);
    return checkTelPat;
}

// ตรวจสอบการกรอกข้อมูล Customer code TH format
function checkTH(thinput) {
    var checkTH = /(^[TH]{2}-{1}[0-9]{4}$)/.test(thinput);
    return checkTH;
}

// ตรวจสอบการกรอกข้อมูล Customer code TBDC format
function checkTBDC(tbdcinput){
    var checkTBDC = /(^[TBDC]{4}-{1}[0-9]{4}$)/.test(tbdcinput);
    return checkTBDC;
}

// ตรวจสอบการกรอกข้อมูล Customer code STDC format
function checkSTDC(tbdcinput){
    var checkTBDC = /(^[STDC]{4}-{1}[0-9]{4}$)/.test(tbdcinput);
    return checkTBDC;
}

// Set checkbox checked based on target value
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

// Prevent default click behavior
function unclick(e) {
    e.preventDefault();
    return false;
}

// Query and display old customer process data
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

// Get customer process based on company (dataareaid)
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

// Query and display primary manager data
function queryPrimanageUse(cusId) {
    $.ajax({
        url: 'main/queryPrimanageUse',
        method: 'POST',
        data: {
            cusId: cusId
        },
        success: function (data) {
            $('#showPrimanage').html(data);
        }
    });
}

// Filter credit term options based on old credit and method
// filterCreditTerm() function has been moved to assets/js/addth/oldcus_changecreditterm.js

// Check for duplicate customer names
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
            }
        }
    });
}

/**
 * ตรวจสอบว่าลูกค้ามีรายการค้างอยู่หรือไม่
 * @param {string} customercode - รหัสลูกค้า TH code
 * @param {function} callback - Callback function เมื่อได้ผลลัพธ์
 */
function checkCustomerPendingOrders(customercode , dataareaid , callback) {
    $.ajax({
        url: 'main/checkCustomerInProgress',
        method: 'POST',
        dataType: 'json',
        data: {
            customercode: customercode,
			dataareaid: dataareaid
        },
        success: function (response) {
            if (typeof callback === 'function') {
                callback(response);
            }
        },
        error: function (xhr, status, error) {
            console.error('Error checking customer status:', error);
            if (typeof callback === 'function') {
                callback({
                    status: 'error',
                    message: 'เกิดข้อผิดพลาดในการตรวจสอบข้อมูล'
                });
            }
        }
    });
}

// ============================================================================
// End of Utility Functions
// ============================================================================

