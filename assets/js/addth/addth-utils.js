/**
 * ============================================================================
 * AddTH Utility Functions
 * ============================================================================
 * 
 * Purpose: Contains reusable utility functions for form manipulation,
 *          formatting, validation helpers, and UI controls
 * Dependencies: addth-config.js
 * 
 * @file addth-utils.js
 * @version 1.0.0
 * @since 2026-02-19
 */

// ============================================================================
// Form Control Functions
// ============================================================================

/**
 * Lock customer fields after selection
 * Disables specific fields based on old customer sub-type checkboxes
 * NOTE: Customer code is NEVER locked to allow searching for different customers
 */
const lockCustomerFieldsTH = () => {
	// ✅ Customer code remains unlocked to allow user to change customer anytime
	// Do NOT lock crf_customercode - user needs to search/change customers
	
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
 * Re-enables all form fields for editing
 */
const unlockCustomerFieldsTH = () => {
	// ✅ Customer code is never locked, so no need to unlock it
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
 * Refreshes the entire page to reset all form fields
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
// Validation & Alert Functions
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
// Data Formatting Functions
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

// ============================================================================
// Form Data Helper Functions
// ============================================================================

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
// Checkbox Helper Functions
// ============================================================================

/**
 * Set checkbox checked based on target value
 * @param {String} targetval - Value to match
 */
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

/**
 * Prevent default click behavior
 * @param {Event} e - Event object
 */
function unclick(e) {
	e.preventDefault();
	return false;
}
