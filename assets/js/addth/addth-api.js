/**
 * ============================================================================
 * AddTH API Functions
 * ============================================================================
 * 
 * Purpose: Contains all AJAX calls and API interactions
 * Dependencies: addth-config.js
 * 
 * @file addth-api.js
 * @version 1.0.0
 * @since 2026-02-19
 */

// ============================================================================
// Customer Search Functions
// ============================================================================

/**
 * Auto search customer detail by customer code
 * @param {String} cusCode - Customer code to search
 */
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

/**
 * Auto search customer detail by customer name
 * @param {String} cusName - Customer name to search
 */
function autoSearchCustomerDetailName(cusName) {
	// Store AJAX request reference (reuse same variable for name search)
	currentRequest = $.ajax({
		url: 'main/searchCustomerDetailName',
		method: 'POST',
		data: {
			cusName: cusName
		},
		timeout: 10000, // 10 second timeout
		success: function(data) {
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
// Customer Process Functions
// ============================================================================

/**
 * Query and display old customer process data
 * @param {String} cusId - Customer ID
 */
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

/**
 * Get customer process based on company (dataareaid)
 * @param {String} dataareaid - Company/area identifier (st, tb, sln, poly, ca)
 */
function getCusProcess(dataareaid) {
	if(dataareaid !== '') {
		$.ajax({
			url:'main/getCusProcess',
			method:'POST',
			data:{
				dataareaid:dataareaid
			},
			success:function(data) {
				console.log(JSON.parse(data));
				if(JSON.parse(data).status == "Select Data Success") {
					let result = JSON.parse(data).result;
					let output = '';

					for(let key in result) {
						if(dataareaid == "st" || dataareaid == "tb") {
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

// ============================================================================
// Primary Manager Functions
// ============================================================================

/**
 * Query and display primary manager data
 * @param {String} cusId - Customer ID
 */
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

// ============================================================================
// Payment Term Functions
// ============================================================================

/**
 * Load customer payment term from AX database
 * @param {String} customercode - Customer account number
 * @param {String} dataareaid - Data area ID (company identifier)
 * @param {Function} callback - Callback function to handle response
 */
function loadCustomerPaymentTerm(customercode, dataareaid, callback) {
	$.ajax({
		url: 'main/getCustomerPaymentTerm',
		method: 'POST',
		data: {
			customercode: customercode,
			dataareaid: dataareaid
		},
		dataType: 'json',
		success: function (response) {
			if (typeof callback === 'function') {
				callback(response);
			}
		},
		error: function (xhr, status, error) {
			console.error('Error loading payment term:', error);
			if (typeof callback === 'function') {
				callback({
					status: 'error',
					message: 'เกิดข้อผิดพลาดในการโหลดข้อมูล Payment Term'
				});
			}
		}
	});
}

// ============================================================================
// Credit Term Functions
// ============================================================================

/**
 * Filter credit term options based on old credit and method
 * @param {String} oldCredit - Current credit term
 * @param {String} creditMethod - Credit adjustment method (increase/decrease)
 */
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

// ============================================================================
// Customer Validation Functions
// ============================================================================

/**
 * Check for duplicate customer names
 * @param {String} cusName - Customer name to check
 * @param {String} comName - Company name
 */
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
 * @param {String} customercode - รหัสลูกค้า TH code
 * @param {String} dataareaid - Company/area identifier
 * @param {Function} callback - Callback function เมื่อได้ผลลัพธ์
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
