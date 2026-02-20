/**
 * ============================================================================
 * addth-handlers.js - Event Handlers for OLD and NEW Customer Types
 * ============================================================================
 * 
 * Purpose:
 * Contains complex event handlers initialization forที่ are called from main
 * Separated to reduce addth-main.js size and improve organization
 *
 * Dependencies:
 * - jQuery
 * - addth-config.js
 * - addth-validators.js
 * - addth-utils.js
 * - addth-api.js
 *
 * Load Order: Load before addth-main.js
 * 
 * @version 1.0.0
 * @date 2025-06-01
 */

// ============================================================================
// OLD CUSTOMER Checkbox Handlers
// ============================================================================

/**
 * Initialize all checkbox handlers for OLD customer type
 * Called from initializeOldCustomerHandlers() in main.js
 */
function initializeOldCustomerCheckboxHandlers() {
	// ========================================================================
	// เปลี่ยนเขตการขาย (Change Sales Area) Checkbox Handler
	// ========================================================================
	$('input:checkbox[name="crf_sub_oldcus_changearea"]').change(function () {
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
		
		// Validation handlers for sales reps
		$("#crf_salesreps").blur(function () {
			if ($(this).val() == "") {
				$("#alert_salesreps").html(
					'<div class="alert alert-danger" role="alert">กรุณาระบุข้อมูล Sales Reps ด้วยค่ะ</div>'
				);
				$("#crf_customername").val("");
			} else {
				if (minsalesreps($(this).val()) == false) {
					$("#alert_salesreps").html(
						'<div class="alert alert-danger" role="alert">กรุณาระบุข้อมูล Sales Reps ให้ถูกต้องด้วยค่ะ ต้องขึ้นต้นด้วย M หรือ D แล้วตามด้วยตัวเลข 4</div>'
					);
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
				if (minsalesreps($(this).val()) == false) {
					$("#alert_salesreps").html(
						'<div class="alert alert-danger" role="alert">กรุณาระบุข้อมูล Sales Reps ให้ถูกต้องด้วยค่ะ ต้องขึ้นต้นด้วย M หรือ D แล้วตามด้วยตัวเลข 4</div>'
					);
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
	});
	
	// ========================================================================
	// เปลี่ยนที่อยู่ (Change Address) Checkbox Handler
	// ========================================================================
	$('input:checkbox[name="crf_sub_oldcus_changeaddress"]').change(function () {
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
			
			if ($('input:radio[name="crf_person_type"]:checked').val() == "natural") {
				$("#crf_file1").removeAttr("required");
				$("#crf_file_person").change(function () {
					if ($(this).val() != "") {
						$("#user_submit").prop("disabled", false);
					} else {
						$("#user_submit").prop("disabled", true);
					}
				});
			} else if ($('input:radio[name="crf_person_type"]:checked').val() == "juristic") {
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
	});
	
	// ========================================================================
	// แก้ไขข้อมูลลูกค้า (Edit Customer) Checkbox Handler
	// ========================================================================
	$('input:checkbox[name="crf_sub_oldcus_editcustomer"]').change(function () {
		if ($(this).prop("checked") == true) {
			// เปิดให้แก้ไขข้อมูลลูกค้าพื้นฐาน
			$("#crf_customername").prop("readonly", false).removeClass("bg-light");
			$("#crf_cuscompanycreate").prop("readonly", false).removeClass("bg-light");
			$("#crf_customertaxid").prop("readonly", false).removeClass("bg-light");
			$("#crf_customerbranch").prop("readonly", false).removeClass("bg-light");
			
			// เปิดให้แก้ไขข้อมูลติดต่อและอื่นๆ
			$("#crf_textmemo").prop("readonly", false);
			$("#crf_namecontact, #crf_telcontact, #crf_faxcontact, #crf_emailcontact, #crf_regiscost, #crf_mapurl")
				.prop("readonly", false);
			$("#crf_mapfile").prop("disabled", false);
			$("#editMapFile_addpage, #editMapUrl_addpage, #editPrimanage_addpage").css("display", "");
			
			// เปิดให้แก้ไขเงื่อนไขการวางบิลและการรับชำระเงิน
			$('input:radio[name="crf_condition_bill"]').prop("disabled", false);
			$('input:radio[name="crf_condition_money"]').prop("disabled", false);
			
			// เรียกใช้ฟังก์ชันอัปเดตสถานะ crf_file1
			updateCrfFile1Status();
			
			$("#editMapUrl_addpage").click(function () {
				$("#foredit1").toggle("display", "");
			});
			$("#editMapFile_addpage").click(function () {
				$("#foredit2").toggle("display", "");
			});
			$("#editPrimanage_addpage").click(function () {
				$(".newPrimanage").show();
				$("#showPrimanage").html("");
				$("#checkprimanagenull").val("1");
			});
			
			if ($('input:radio[name="crf_person_type"]:checked').val() == "natural") {
				$("#for_natural").css("display", "");
				$("#for_juristic").css("display", "none");
				$("#crf_file_person").prop("disabled", false);
			} else if ($('input:radio[name="crf_person_type"]:checked').val() == "juristic") {
				$("#for_natural").css("display", "none");
				$("#for_juristic").css("display", "");
				$("#crf_file_person").prop("disabled", true);
				setFieldsDisabled(FORM_CONFIG.FILE_FIELDS, false);
			}
			
			// Enable change detection for form fields
			var checkpointchange = 0;
			const changeFields = ["#crf_namecontact", "#crf_customername", "#crf_telcontact", 
								  "#crf_faxcontact", "#crf_emailcontact", "#crf_regiscost", 
								  "#crf_mapurl", "#crf_mapfile",
								  "#crf_file1, #crf_file2, #crf_file3, #crf_file4, #crf_file5, #crf_file6"];
			
			changeFields.forEach(selector => {
				$(selector).change(function () {
					checkpointchange = 1;
					if (checkpointchange == 1) {
						$("#user_submit").prop("disabled", false);
					}
				});
			});
		} else {
			$("#crf_namecontact, #crf_telcontact, #crf_faxcontact, #crf_emailcontact, #crf_regiscost, #crf_mapurl, #crf_mapfile")
				.prop("disabled", true);
			$("#editMapFile_addpage, #editMapUrl_addpage, #editPrimanage_addpage").css("display", "none");
			
			// ปิดการแก้ไขเงื่อนไขการวางบิลและการรับชำระเงิน
			$('input:radio[name="crf_condition_bill"]').prop("disabled", true);
			$('input:radio[name="crf_condition_money"]').prop("disabled", true);
			
			// เรียกใช้ฟังก์ชันอัปเดตสถานะ crf_file1
			updateCrfFile1Status();
			$("#crf_file2, #crf_file3, #crf_file4, #crf_file5, #crf_file6, #crf_file_person").prop("disabled", true);
		}
	});
	
	// ========================================================================
	// ปรับ Credit Term Checkbox Handler
	// >>> MOVED TO: assets/js/addth/oldcus_changecreditterm.js <<<
	// ========================================================================
	
	// ========================================================================
	// ปรับวงเงิน (Change Finance) Checkbox Handler
	// ========================================================================
	$('input:checkbox[name="crf_sub_oldcus_changefinance"]').change(function () {
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
	});
	
	// ========================================================================
	// OLD Customer Sub Type Selection Validation
	// ========================================================================
	$('input:checkbox[id="crf_sub_oldcus"]').change(function () {
		const check_crf_sub_oldcus = $('input:checkbox[id="crf_sub_oldcus"]:checked');
		if (check_crf_sub_oldcus.val() != "") {
			$("#crf_customercode").prop("disabled", false);
		}
	});
}

// ============================================================================
// OLD CUSTOMER Validation Handlers
// ============================================================================

/**
 * Initialize all validation handlers for OLD customer type
 * Called from initializeOldCustomerHandlers() in main.js
 */
function initializeOldCustomerValidationHandlers() {
	// Customer code validation on focus
	$("#crf_customercode").focus(function () {
		if ($("#checkCusType").val() == 2) {
			var crf_sub_oldcus = $('input[type="checkbox"][id="crf_sub_oldcus"]:checked');
			var crf_person_type = $('input[type="radio"][name="crf_person_type"]:checked');
			
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
	
	// Customer name validation
	$("#crf_customername").focus(function () {
		if ($("#checkCusType").val() == 2) {
			var crf_sub_oldcus = $('input[type="checkbox"][id="crf_sub_oldcus"]:checked');
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
			var crf_sub_oldcus = $('input[type="checkbox"][id="crf_sub_oldcus"]:checked');
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
			var crf_sub_oldcus = $('input[type="checkbox"][id="crf_sub_oldcus"]:checked');
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
	
	// Remaining validation code (company create date, address, contact...)
	initializeCommonValidationHandlers();
	
	// Credit term validation for old customer
	initializeOldCustomerCreditValidation();
	
	// Finance request validation
	initializeFinanceValidation();
	
	// Final submit button validation
	initializeOldCustomerSubmitValidation();
}

// ============================================================================
// NEW CUSTOMER Validation Handlers
// ============================================================================

/**
 * Initialize all validation handlers for NEW customer type
 * Called from initializeNewCustomerHandlers() in main.js
 */
function initializeNewCustomerValidationHandlers() {
	// ========================================================================
	// Sales Rep Validation (NEW)
	// ========================================================================
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
	
	// ========================================================================
	// Customer Name Validation (NEW)
	// ========================================================================
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
	
	// Remaining validation code
	initializeCommonValidationHandlers();
	
	// File upload and credit term validation
	initializeNewCustomerFileValidation();
	initializeNewCustomerCreditValidation();
	initializeFinanceValidation();
}

// ============================================================================
// Common Validation Handlers (Shared by NEW and OLD)
// ============================================================================

/**
 * Validation handlers used by both NEW and OLD customer types
 */
function initializeCommonValidationHandlers() {
	// Company create date validation
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
	
	// Address type validation
	$("#crf_addressname").focus(function () {
		var crf_addresstype = $('input:radio[name="crf_addresstype"]:checked');
		if (crf_addresstype.length < 1) {
			$("#alert_addresstype").html(
				'<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทที่อยู่ด้วยค่ะ</div>'
			);
			$("#crf_addressname").val("");
		} else {
			$("#alert_addresstype").html("");
		}
	});
	
	// Address name validation
	$("#crf_addressname").blur(function () {
		if (!$(this).val()) {
			$("#alert_addressname").html(
				'<div class="alert alert-danger" role="alert">กรุณาระบุที่อยู่สำหรับการเปิดใบกำกับภาษีด้วยค่ะ</div>'
			);
		} else {
			$("#alert_addressname").html("");
			$("#user_submit").prop("disabled", false);
		}
	});
	
	// Contact name validation
	$("#crf_namecontact").blur(function () {
		if (!$(this).val()) {
			$("#alert_namecontact").html(
				'<div class="alert alert-danger" role="alert">กรุณาระบุชื่อผู้ติดต่อด้วยค่ะ</div>'
			);
		} else {
			$("#alert_namecontact").html("");
			$("#user_submit").prop("disabled", false);
		}
	});
	
	// Phone validation
	$("#crf_telcontact").blur(function () {
		if (!$(this).val()) {
			$("#alert_telcontact").html(
				'<div class="alert alert-danger" role="alert">กรุณาระบุเบอร์ผู้ติดต่อด้วยค่ะ</div>'
			);
		} else {
			if (!checkTelPat($(this).val())) {
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
	
	// Registration cost validation
	$("#crf_regiscost").blur(function () {
		if (!$(this).val()) {
			$("#alert_regiscost").html(
				'<div class="alert alert-danger" role="alert">กรุณาระบุทุนจดทะเบียนด้วยค่ะ</div>'
			);
		} else {
			$("#alert_regiscost").html("");
			$("#user_submit").prop("disabled", false);
		}
	});
	
	// Primary manager validation
	$("#crf_primanage_dept, #crf_primanage_name, #crf_primanage_posi, #crf_primanage_email").blur(function () {
		if (!$(this).val()) {
			$("#alert_primanage").html(
				'<div class="alert alert-danger" role="alert">กรุณาระบุข้อมูลให้ครบถ้วนด้วยค่ะ</div>'
			);
		} else {
			$("#alert_primanage").html("");
		}
	});
	
	// Process validation
	$(document).on("change", 'input[type="checkbox"][id="crf_process"]:checked', function () {
		var crf_typeofbussi = $('input:radio[name="crf_typeofbussi"]:checked');
		if (crf_typeofbussi.length < 1) {
			$("#alert_typeofbussi").html(
				'<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทธุรกิจด้วยค่ะ</div>'
			);
			$(this).prop("checked", false);
		} else {
			$("#alert_typeofbussi").html("");
		}
	});
	
	// Forecast validation
	$("#crf_forecast").blur(function () {
		if (!$(this).val()) {
			$("#alert_forecast").html(
				'<div class="alert alert-danger" role="alert">กรุณาระบุรายละเอียดคาดการปริมาณการขายด้วยค่ะ</div>'
			);
		} else {
			$("#alert_forecast").html("");
		}
	});
}

/**
 * File validation for NEW customer type
 */
function initializeNewCustomerFileValidation() {
	$("#crf_creditterm").change(function () {
		if ($('input:radio[name="crf_person_type"]:checked').val() == PERSON_TYPE.NATURAL) {
			if (!$("#crf_file_person").val()) {
				$("#alert_file_person").html(
					'<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ สำเนาบัตรประชาชน ด้วยค่ะ</div>'
				);
				$("#crf_creditterm").val("");
			} else {
				$("#alert_file_person").html("");
				$("#user_submit").prop("disabled", false);
			}
		} else if ($('input:radio[name="crf_person_type"]:checked').val() == PERSON_TYPE.JURISTIC) {
			// Validate files 1-6 for juristic person
			const files = ['file1', 'file2', 'file3', 'file4', 'file5', 'file6'];
			const fileLabels = ['ภพ.20', 'หนังสือรับรอง', 'ข้อมูลทั่วไป', 'งบแสดงฐานะทางการเงิน', 'งบกำไรขาดทุน', 'อัตราส่วนสภาพคล่อง'];
			
			files.forEach((file, index) => {
				if (!$("#crf_" + file).val()) {
					$("#alert_" + file).html(
						'<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ ' + fileLabels[index] + ' ด้วยค่ะ</div>'
					);
					$("#crf_creditterm").val("");
				} else {
					$("#alert_" + file).html("");
					$("#user_submit").prop("disabled", false);
				}
			});
		}
		
		if ($(this).val()) {
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
	
	// File change handlers
	$("#crf_file1, #crf_file2, #crf_file3, #crf_file4, #crf_file5, #crf_file6").change(function () {
		const fileId = $(this).attr('id').replace('crf_', '');
		if ($(this).val()) {
			$("#alert_" + fileId).html("");
			$("#user_submit").prop("disabled", false);
		}
	});
}

/**
 * Credit term validation for NEW customer
 */
function initializeNewCustomerCreditValidation() {
	$('input:radio[name="crf_condition_bill"]').click(function () {
		if (!$("#crf_creditterm").val()) {
			$("#alert_creditterm").html(
				'<div class="alert alert-danger" role="alert">กรุณาเลือก Credit Term ด้วยค่ะ</div>'
			);
			$('input:radio[name="crf_condition_bill"]').prop("checked", false);
			$('input:radio[name="crf_condition_bill"]').prop("disabled", true);
		} else {
			$("#alert_creditterm").html("");
		}
	});
	
	$('input:radio[name="crf_condition_money"]').click(function () {
		var crf_condition_bill = $("input:radio[name=crf_condition_bill]:checked");
		if (crf_condition_bill.length < 1) {
			$("#alert_condition_bill").html(
				'<div class="alert alert-danger" role="alert">กรุณาเลือกเงื่อนไขการวางบิลด้วยค่ะ</div>'
			);
			$('input:radio[name="crf_condition_money"]').prop("checked", false);
		} else {
			$("#alert_condition_bill").html("");
		}
	});
}

/**
 * Credit term validation for OLD customer
 */
function initializeOldCustomerCreditValidation() {
	$('input:radio[name="crf_condition_bill"]').click(function () {
		if (!$("#crf_creditterm").val()) {
			$("#alert_creditterm").html(
				'<div class="alert alert-danger" role="alert">กรุณาเลือก Credit Term ด้วยค่ะ</div>'
			);
			$('input:radio[name="crf_condition_bill"]').prop("checked", false);
			$('input:radio[name="crf_condition_bill"]').prop("disabled", true);
		} else {
			$("#alert_creditterm").html("");
		}
	});
	
	$('input:radio[name="crf_condition_money"]').click(function () {
		var crf_condition_bill = $("input:radio[name=crf_condition_bill]:checked");
		if (crf_condition_bill.length < 1) {
			$("#alert_condition_bill").html(
				'<div class="alert alert-danger" role="alert">กรุณาเลือกเงื่อนไขการวางบิลด้วยค่ะ</div>'
			);
			$('input:radio[name="crf_condition_money"]').prop("checked", false);
		} else {
			$("#alert_condition_bill").html("");
		}
	});
	
	// File upload validation
	$("#crf_file1, #crf_file2, #crf_file3, #crf_file4, #crf_file5, #crf_file6").change(function () {
		const fileId = $(this).attr('id').replace('crf_', '');
		if ($(this).val()) {
			$("#alert_" + fileId).html("");
		}
	});
}

/**
 * Finance validation (shared by NEW and OLD)
 */
function initializeFinanceValidation() {
	$("#crf_finance_req_number").keyup(function () {
		if ($(this).val()) {
			$("#user_submit").prop("disabled", false);
		}
	});
	
	$("#crf_finance_req_number").blur(function () {
		if ($(this).val()) {
			$("#user_submit").prop("disabled", false);
		} else {
			$("#user_submit").prop("disabled", true);
		}
	});
}

/**
 * Final submit validation for OLD customer
 */
function initializeOldCustomerSubmitValidation() {
	$("#user_submit").click(function () {
		// Check change address - validate file based on person type
		if ($('input:checkbox[name="crf_sub_oldcus_changeaddress"]').prop("checked")) {
			if ($('input:radio[name="crf_person_type"]:checked').val() == PERSON_TYPE.NATURAL) {
				if (!$("#crf_file_person").val()) {
					alert("กรุณาอัพโหลดไฟล์ สำเนาบัตรประชาชน ด้วยค่ะ");
					$("#alert_file1").html(
						'<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ สำเนาบัตรประชาชน ด้วยค่ะ</div>'
					);
					return false;
				}
			} else if ($('input:radio[name="crf_person_type"]:checked').val() == PERSON_TYPE.JURISTIC) {
				if (!$("#crf_file1").val()) {
					alert("กรุณาอัพโหลดไฟล์ ภพ20 ด้วยค่ะ");
					$("#alert_file1").html(
						'<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ ภพ20 ด้วยค่ะ</div>'
					);
					return false;
				}
			}
		}
		
// Check change credit term (แยกจาก expected date)
		if ($('input:checkbox[name="crf_change_creditterm"]').prop("checked")) {
			if (!$("#crf_condition_credit").val()) {
				alert("กรุณาเลือกเงื่อนไขการขอปรับ Credit term ด้วยค่ะ");
				$("#alert_crf_condition_credit").html(
					'<div class="alert alert-danger" role="alert">กรุณาเลือกเงื่อนไขการขอปรับ Credit term ด้วยค่ะ</div>'
				);
				return false;
			}
			
			// เช็ค showcredit2 หรือ crf_creditterm2 (dynamic)
			var hasShowCredit2 = $("#showcredit2").length > 0 && $("#showcredit2").val() != "";
			var hasCreditTerm2 = $("#crf_creditterm2").length > 0 && $("#crf_creditterm2").val() != "";
			
			if (!hasShowCredit2 && !hasCreditTerm2) {
				alert("กรุณาเลือก Credit term ที่ต้องการด้วยค่ะ");
				$("#alert_showcredit2").html(
					'<div class="alert alert-danger" role="alert">กรุณาเลือก Credit term ที่ต้องการด้วยค่ะ</div>'
				);
				return false;
			}
		}
		
		// Check change expected date payment (แยกจาก credit term)
		// Note: ไม่ต้อง validate เพราะใช้ crf_arcustdueid ที่มีอยู่แล้ว แค่ติ๊ก checkbox พอ
		
		// Check change finance
		if ($('input:checkbox[name="crf_sub_oldcus_changefinance"]').prop("checked")) {
			if (!$("#crf_finance_change_total").val()) {
				alert("กรุณาระบุ รายละเอียดการขอเปลี่ยนแปลงแก้ไขวงเงิน ด้วยค่ะ");
				$("#alert_crf_finance_status").html(
					'<div class="alert alert-danger" role="alert">กรุณาเลือก สถานะวงเงิน ด้วยค่ะ</div>'
				);
				return false;
			}
		}
		
		return true; // Allow submit
	});
}
