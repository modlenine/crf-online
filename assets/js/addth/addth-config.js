/**
 * ============================================================================
 * AddTH Configuration File
 * ============================================================================
 * 
 * Purpose: Contains all constants, configuration objects, and global variables
 * Used by: All other addth modules
 * 
 * @file addth-config.js
 * @version 1.0.0
 * @since 2026-02-19
 */

// ============================================================================
// Global Variables for Search Management
// ============================================================================

/**
 * Timeout handle for debouncing search input
 * @type {number|null}
 */
let searchTimeout = null;

/**
 * Current AJAX request reference for cancellation
 * @type {jqXHR|null}
 */
let currentRequest = null;

// ============================================================================
// Customer Type Constants
// ============================================================================

/**
 * Customer type identifiers
 * @const {Object}
 */
const CUSTOMER_TYPE = {
	NEW: '1',
	OLD: '2'
};

/**
 * Person type identifiers
 * @const {Object}
 */
const PERSON_TYPE = {
	NATURAL: 'natural',
	JURISTIC: 'juristic'
};

// ============================================================================
// Form Configuration
// ============================================================================

/**
 * Form field configuration for enabling/disabling
 * @const {Object}
 */
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

// ============================================================================
// Alert Messages
// ============================================================================

/**
 * Predefined alert messages for validation
 * @const {Object}
 */
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
