/**
 * ============================================================================
 * AddTH Validator Functions
 * ============================================================================
 * 
 * Purpose: Contains all validation functions for form fields
 * Dependencies: addth-config.js
 * 
 * @file addth-validators.js
 * @version 1.0.0
 * @since 2026-02-19
 */

// ============================================================================
// Pattern Validation Functions
// ============================================================================

/**
 * Function validate sales reps format (D#### or M####)
 * @param {String} salesrepIn - Sales rep code to validate
 * @returns {Boolean} true if valid format, false otherwise
 */
function minsalesreps(salesrepIn) {
	var checkSalesrepIn = /(^D[0-9]{4,4}$|^M[0-9]{4,4}$)/.test(salesrepIn);
	return checkSalesrepIn;
}

/**
 * Function เช็คเลขที่ผู้เสียภาษี (13 digits)
 * @param {String} taxIn - Tax ID to validate
 * @returns {Boolean} true if valid (13 digits), false otherwise
 */
function checktax(taxIn) {
	var checkTax = /(^[0-9]{13}$)/.test(taxIn);
	return checkTax;
}

/**
 * Function เช็ครูปแบบของเบอร์โทรศัพท์ (8-15 digits)
 * @param {String} telIn - Telephone number to validate
 * @returns {Boolean} true if valid (8-15 digits), false otherwise
 */
function checkTelPat(telIn) {
	var checkTelPat = /(^[0-9]{8,15}$)/.test(telIn);
	return checkTelPat;
}

/**
 * ตรวจสอบการกรอกข้อมูล Customer code TH format
 * @param {String} thinput - Customer code to validate (TH-####)
 * @returns {Boolean} true if valid TH format, false otherwise
 */
function checkTH(thinput) {
	var checkTH = /(^[TH]{2}-{1}[0-9]{4}$)/.test(thinput);
	return checkTH;
}

/**
 * ตรวจสอบการกรอกข้อมูล Customer code TBDC format
 * @param {String} tbdcinput - Customer code to validate (TBDC-####)
 * @returns {Boolean} true if valid TBDC format, false otherwise
 */
function checkTBDC(tbdcinput) {
	var checkTBDC = /(^[TBDC]{4}-{1}[0-9]{4}$)/.test(tbdcinput);
	return checkTBDC;
}

/**
 * ตรวจสอบการกรอกข้อมูล Customer code STDC format
 * @param {String} tbdcinput - Customer code to validate (STDC-####)
 * @returns {Boolean} true if valid STDC format, false otherwise
 */
function checkSTDC(tbdcinput) {
	var checkTBDC = /(^[STDC]{4}-{1}[0-9]{4}$)/.test(tbdcinput);
	return checkTBDC;
}
