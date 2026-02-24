# addth.js Documentation

## 📋 Overview
`addth.js` จัดการฟอร์ม Credit Request Form (CRF) สำหรับการเพิ่มลูกค้าในประเทศ (add_th.php)  
ไฟล์นี้รวม logic ทั้งหมดของการจัดการฟิลด์แบบ **Union Pattern** สำหรับลูกค้าเก่า

**ตำแหน่งไฟล์:** `assets/js/addth.js` (3,632 บรรทัด)  
**หน้า View:** `application/modules/main/views/add_th.php`  
**วันที่อัปเดตล่าสุด:** 2026-02-24

---

## 🏗️ โครงสร้างไฟล์

### 1. Constants & Configuration (บรรทัด 1-58)
```javascript
// Global variables
let searchTimeout = null;        // สำหรับ debounce customer search
let currentRequest = null;       // เก็บ AJAX request ที่กำลังทำงาน

// Constants
CUSTOMER_TYPE = { NEW: '1', OLD: '2' }
PERSON_TYPE = { NATURAL: 'natural', JURISTIC: 'juristic' }
FORM_CONFIG = { CUSTOMER_FIELDS, RADIO_FIELDS, FILE_FIELDS, ... }
ALERT_MESSAGES = { REQUIRED_*, INVALID_* }
```

### 2. Utility Functions (บรรทัด 59-368)
- **Lock/Unlock Fields:** `lockCustomerFieldsTH()`, `unlockCustomerFieldsTH()`
- **Data Management:** `clearCustomerDataTH()`, `clearOldCustomerData()`, `clearNewCustomerData()`
- **Field Control:** `setFieldsDisabled()`, `setRadiosDisabled()`, `enableAllFieldsForNewCustomer()`
- **Validation:** `validateRequired()`, `validateRadioChecked()`, `validateCheckboxChecked()`
- **Formatting:** `formatNumberWithComma()`, `setupCommaFormatting()`
- **Helpers:** `getCurrentCustomerType()`, `getCurrentPersonType()`, `getCurrentCompany()`

### 3. **🌟 Core Function - Union Logic** (บรรทัด 370-558)
```javascript
function updateFieldStatesBasedOnConditions()
```
**ฟังก์ชันสำคัญที่สุด** - จัดการ enable/disable ฟิลด์ทั้งหมดตามเงื่อนไข checkbox ที่ติ๊ก

### 4. Credit Term Management (บรรทัด 559-662)
- `checkAndUpdateSubmitButtonCredit()` - ตรวจสอบว่าควร enable submit button หรือไม่
- `toggleBasicInfoFields()` - เปิด/ปิดฟิลด์ข้อมูลพื้นฐาน
- `toggleContactFields()` - เปิด/ปิดฟิลด์ติดต่อ
- `toggleEditButtons()` - แสดง/ซ่อนปุ่ม edit
- `toggleBillingConditions()` - เปิด/ปิดเงื่อนไขการวางบิล
- `handlePersonTypeFiles()` - จัดการไฟล์ตามประเภทบุคคล
- `setupEditButtonHandlers()`, `setupFieldChangeHandlers()`

### 5. Event Handlers (บรรทัด 663-2788)
- **Document Ready:** ติดตั้ง event listeners ทั้งหมด
- **Customer Type Selection:** ลูกค้าใหม่/เก่า
- **Person Type Selection:** บุคคลธรรมดา/นิติบุคคล
- **Old Customer Checkboxes:** 5 เงื่อนไขหลัก
- **Company Selection, Process Selection, Validation Handlers**

### 6. Customer Selection & Data Loading (บรรทัด 2789-3384)
- **`.selectCusName` handler:** โหลดข้อมูลลูกค้าเมื่อเลือกจาก autocomplete
- **`loaddataforadd()` function:** populate ข้อมูลลูกค้าลงฟอร์ม
- **`checkCustomerPendingOrders()` callback:** ตรวจสอบรายการค้าง

### 7. Search & Utility Functions (บรรทัด 3385-3632)
- `autoSearchCustomerDetail()`, `autoSearchCustomerDetailName()`
- Validation helpers: `minsalesreps()`, `checktax()`, `checkTelPat()`
- Data query functions: `queryProcessUse()`, `getCusProcess()`, `queryPrimanageUse()`
- `checkDuplicateNameCustomer()`, `checkCustomerPendingOrders()`

---

## 🎯 Core Concept: Union Logic Pattern

### ปัญหาเดิม
ลูกค้าเก่ามี 5 เงื่อนไขที่ติ๊กได้:
1. เปลี่ยนเขตการขาย (changearea)
2. เปลี่ยนที่อยู่ (changeaddress)
3. ปรับวงเงิน (changefinance)
4. ปรับ Credit Term (changecredit)
5. แก้ไขข้อมูลลูกค้า (editcustomer)

**ปัญหา:** เมื่อติ๊กหลายเงื่อนไข ฟิลด์จะ "ตีกัน" - เงื่อนไขหนึ่ง enable แล้วอีกเงื่อนไข disable ทับ

### วิธีแก้: Reset → Apply Union
```javascript
function updateFieldStatesBasedOnConditions() {
    // Step 1: ตรวจสอบว่าติ๊ก checkbox อะไรบ้าง
    const isChangeArea = $('input:checkbox[name="crf_sub_oldcus_changearea"]').prop("checked");
    const isChangeAddress = ...
    const isChangeFinance = ...
    const isChangeCredit = ...
    const isEditCustomer = ...
    const isJuristicPerson = ...
    
    // Step 2: Reset ทุกฟิลด์เป็น disabled/readonly
    $("#crf_salesreps").prop("readonly", true).addClass("bg-light");
    $("#crf_customername").prop("readonly", true).addClass("bg-light");
    // ... reset ~50 fields ...
    
    // Step 3: เปิดฟิลด์ตามเงื่อนไขที่ติ๊ก (UNION)
    if (isChangeArea) {
        $("#crf_salesreps").prop("readonly", false).removeClass("bg-light");
        // ... enable relevant fields ...
    }
    
    if (isChangeAddress) {
        $("#crf_addressname").prop("readonly", false).removeClass("bg-light");
        // ... enable relevant fields ...
    }
    
    if (isChangeFinance) { ... }
    if (isChangeCredit) { ... }
    if (isEditCustomer) { ... }
    
    // Step 4: จัดการ Special Cases (files ตามประเภทบุคคล, edit buttons)
}
```

### 📌 หลักการ Union Logic
- **ติ๊ก 1 เงื่อนไข:** เปิดฟิลด์ของเงื่อนไขนั้น
- **ติ๊ก 2+ เงื่อนไข:** เปิดฟิลด์ทั้งหมดจากทุกเงื่อนไข (รวมกัน)
- **ยกเลิกติ๊ก:** เรียก function อีกรอบ → ฟิลด์ที่เหลือยังเปิดอยู่

---

## 📦 5 Checkbox Conditions Reference

### 1. เปลี่ยนเขตการขาย (changearea)
**Checkbox:** `crf_sub_oldcus_changearea`  
**Enable Fields:**
- `crf_salesreps` - Sales Representative
- `crf_customercode` - รหัสลูกค้า
- `crf_customername` - ชื่อลูกค้า

### 2. เปลี่ยนที่อยู่ (changeaddress)
**Checkbox:** `crf_sub_oldcus_changeaddress`  
**Enable Fields:**
- `crf_addressname` - ที่อยู่
- `crf_addresstype` (radio) - ประเภทที่อยู่
- `crf_file1` - ไฟล์ ภพ20 (สำหรับนิติบุคคล)

### 3. ปรับวงเงิน (changefinance)
**Checkbox:** `crf_sub_oldcus_changefinance`  
**Enable Fields:**
- `crf_finance` (radio) - ขอวงเงิน/ปรับวงเงิน
- `crf_finance_change_status` - สถานะปรับวงเงิน
- `crf_finance_change_number` - เลขที่เอกสาร Finance
- `crf_finance_change_total` - จำนวนเงิน

### 4. ปรับ Credit Term (changecredit)
**Checkbox:** `crf_sub_oldcus_changecredit`  
**Enable Fields:**
- `crf_condition_credit` - เงื่อนไขเครดิต
- `showcredit2` - แสดง credit term ใหม่
- `crf_creditterm2` - Credit term ใหม่
- `crf_creditterm` - **ยังคง disabled** (ข้อมูลจาก DB, read-only)

### 5. แก้ไขข้อมูลลูกค้า (editcustomer)
**Checkbox:** `crf_sub_oldcus_editcustomer`  
**Enable Fields:**
- **Basic Info:** `crf_customercode`, `crf_customername`, `crf_cuscompanycreate`, `crf_customertaxid`, `crf_customerbranch`, `crf_textmemo`
- **Contact:** `crf_namecontact`, `crf_telcontact`, `crf_faxcontact`, `crf_emailcontact`
- **Other:** `crf_regiscost`, `crf_mapurl`, `crf_mapfile`
- **Billing Conditions:** `crf_condition_bill`, `crf_condition_money`
- **Billing Details:** `crf_datebill`, `crf_mapbill2`, `crf_recive_cheuqetable`, `crf_recive_cheuqedetail`
- **Files:** ทั้งหมด (file1-6 สำหรับนิติบุคคล, file_person สำหรับบุคคลธรรมดา)
- **Edit Buttons:** แสดง edit buttons (map file, map url, primary manager)

**⚠️ สำคัญ:** เงื่อนไขนี้**ไม่รวมที่อยู่ (address)**  
ถ้าต้องการแก้ที่อยู่ ต้องติ๊ก "เปลี่ยนที่อยู่" (changeaddress) แยกต่างหาก

---

## 🔄 Data Loading Flow

### เมื่อผู้ใช้เลือกลูกค้าจาก Autocomplete:

```
1. User clicks .selectCusName
   ↓
2. checkCustomerPendingOrders(customercode, dataareaid, callback)
   ↓ (if no pending orders)
3. loaddataforadd(element)
   - Populate ~70+ fields with customer data
   - Set radio buttons, show file links
   - Load payment term from AX database
   ↓
4. lockCustomerFieldsTH()
   - Lock fields based on current checkbox states
   - Check isEditCustomer, isChangeAddress, isChangeArea
   ↓
5. updateFieldStatesBasedOnConditions() ← ⭐ CRITICAL STEP
   - Re-apply field states based on checked conditions
   - Ensure Union logic overrides any hard-coded disables
```

### ⚠️ หากขาด Step 5 → ฟิลด์จะถูก lock ทั้งหมดแม้ว่าผู้ใช้ติ๊กเงื่อนไขไว้แล้ว

---

## 📍 14 Call Sites สำหรับ `updateFieldStatesBasedOnConditions()`

ฟังก์ชันนี้ถูกเรียกทุกครั้งที่:

1. **Old customer checkbox ถูกเปลี่ยน** (5 ครั้ง):
   - `crf_sub_oldcus_changearea` change
   - `crf_sub_oldcus_changeaddress` change
   - `crf_sub_oldcus_changefinance` change
   - `crf_sub_oldcus_changecredit` change
   - `crf_sub_oldcus_editcustomer` change

2. **Person type ถูกเปลี่ยน** (2 ครั้ง):
   - Natural person radio clicked
   - Juristic person radio clicked

3. **Customer type เปลี่ยน** (2 ครั้ง):
   - เปลี่ยนจากลูกค้าเก่า → ใหม่
   - เปลี่ยนจากลูกค้าใหม่ → เก่า

4. **Old customer sub-type unchecked** (1 ครั้ง)

5. **Person type changed while old customer selected** (3 ครั้ง):
   - Natural person while old customer
   - Juristic person while old customer  
   - Person type change handler

6. **After loading customer data** (1 ครั้ง - **ที่บรรทัด 3212**)

**รวม 14 call sites** (บรรทัด: 797, 879, 905, 964, 974, 1011, 1022, 1031, 1108, 1116, 1136, 1176, 3212)

---

## ⚠️ Critical Points & Common Pitfalls

### 1. ห้าม Hard-Code disable/enable ฟิลด์
❌ **ผิด:**
```javascript
$('#crf_datebill').prop('disabled', true);  // ทำให้ Union logic พัง
```

✅ **ถูก:**
```javascript
// ไม่ต้องทำอะไร - ให้ updateFieldStatesBasedOnConditions() จัดการ
```

### 2. โหลดข้อมูลลูกค้า → ต้องเรียก `updateFieldStatesBasedOnConditions()`
❌ **ผิด:**
```javascript
$('#crf_recive_cheuqedetail').val(data_crf_recive_cheuqedetail);
$('#crf_recive_cheuqedetail').prop('readonly', true);  // ทับเงื่อนไข!
lockCustomerFieldsTH();
// ไม่มี updateFieldStatesBasedOnConditions()
```

✅ **ถูก:**
```javascript
$('#crf_recive_cheuqedetail').val(data_crf_recive_cheuqedetail);
// ไม่ hard-code prop('readonly', true)
lockCustomerFieldsTH();
updateFieldStatesBasedOnConditions();  // ⭐ Re-apply field states
```

### 3. ไฟล์ถูกจัดการตามประเภทบุคคล
- **นิติบุคคล (juristic):** ใช้ `crf_file1` - `crf_file6`
- **บุคคลธรรมดา (natural):** ใช้ `crf_file_person`

Logic นี้อยู่ใน Step 4 ของ `updateFieldStatesBasedOnConditions()`

### 4. ฟิลด์ที่ต้องระวัง
- `crf_customercode` - เปิดได้ทั้ง changearea และ editcustomer
- `crf_datebill`, `crf_mapbill2`, `crf_recive_cheuqetable`, `crf_recive_cheuqedetail` - เปิดได้เฉพาะ editcustomer
- `crf_file1` - เปิดได้ทั้ง changeaddress (นิติบุคคล) และ editcustomer (นิติบุคคล)

### 5. Edit Buttons Visibility
```javascript
if (isEditCustomer) {
    $("#editMapFile_addpage, #editMapUrl_addpage, #editPrimanage_addpage").css("display", "");
}
```
ปุ่ม edit จะแสดงเฉพาะเมื่อติ๊ก "แก้ไขข้อมูลลูกค้า"

---

## 🔧 การแก้ไข/เพิ่มเติม Function

### ถ้าต้องการเพิ่มฟิลด์ใหม่ให้เงื่อนไข editcustomer:

1. เพิ่มใน **Step 2 (Reset)**:
```javascript
$("#new_field").prop("readonly", true).addClass("bg-light");
```

2. เพิ่มใน **Step 3 - isEditCustomer section**:
```javascript
if (isEditCustomer) {
    // ... existing fields ...
    $("#new_field").prop("readonly", false).removeClass("bg-light");
}
```

### ถ้าต้องการเพิ่มเงื่อนไขใหม่:

1. เพิ่ม checkbox ใน HTML:
```html
<input type="checkbox" name="crf_sub_oldcus_newcondition" id="crf_sub_oldcus_newcondition">
```

2. เพิ่มใน `updateFieldStatesBasedOnConditions()`:
```javascript
// Step 1
const isNewCondition = $('input:checkbox[name="crf_sub_oldcus_newcondition"]').prop("checked");

// Step 3
if (isNewCondition) {
    $("#some_field").prop("readonly", false).removeClass("bg-light");
}
```

3. เพิ่ม event handler:
```javascript
$('input:checkbox[name="crf_sub_oldcus_newcondition"]').change(function() {
    if ($(this).prop("checked")) {
        // Show relevant sections
        $('.newcondition_section').css('display', '');
    } else {
        // Hide sections
        $('.newcondition_section').css('display', 'none');
    }
    updateFieldStatesBasedOnConditions();
});
```

---

## 🐛 Troubleshooting

### ปัญหา: ฟิลด์ไม่เปิดแม้ว่าติ๊กเงื่อนไขแล้ว

**สาเหตุ:**
1. มี hard-code `.prop('readonly', true)` ทับหลังจาก `updateFieldStatesBasedOnConditions()`
2. ลืมเรียก `updateFieldStatesBasedOnConditions()` หลังโหลดข้อมูล
3. ฟิลด์ไม่ได้อยู่ในเงื่อนไขที่ติ๊ก

**วิธีแก้:**
```javascript
// 1. หา hard-code prop() ที่ทับฟิลด์
grep -n "prop.*readonly.*true" addth.js | grep field_name

// 2. ตรวจสอบว่าเรียก updateFieldStatesBasedOnConditions() หรือยัง
// ดูที่บรรทัด 3211 (หลัง lockCustomerFieldsTH)

// 3. เพิ่มฟิลด์เข้าไปในเงื่อนไขที่ต้องการ (Step 3)
```

### ปัญหา: Browser cache ไม่อัปเดต JavaScript

**วิธีแก้:**
```php
// add_th.php มี versioning อัตโนมัติ
<script src="<?= base_url('assets/js/addth.js?v=') . filemtime('assets/js/addth.js') ?>"></script>
```
ผู้ใช้ควร hard refresh: **Ctrl + F5**

### ปัญหา: ฟิลด์บางตัวเปิดไม่พร้อมกัน

**สาเหตุ:** ลำดับการเปิดฟิลด์ไม่ตรงตาม Step 3  
**วิธีแก้:** ตรวจสอบ if-block ใน `updateFieldStatesBasedOnConditions()` → ฟิลด์ต้องอยู่ในเงื่อนไขที่ถูกต้อง

---

## 📚 Related Files

### JavaScript Files
- **`addth.js`** (3,632 lines) - ไฟล์หลัก (consolidated)
- **`assets/js/addth/addth-api.js`** - AJAX API functions (เช่น `loadCustomerPaymentTerm`)
- ~~`oldcus_editcusdata.js`~~ - **ถูกลบ** (logic รวมเข้า addth.js แล้ว)
- ~~`oldcus_changecreditterm.js`~~ - **ถูกลบ** (logic รวมเข้า addth.js แล้ว)
- **`custom.js`** - ใช้กับหน้า view/edit (suffix `_view`) → **ไม่กระทบ add_th.php**

### PHP/View Files
- **`application/modules/main/views/add_th.php`** - หน้าฟอร์มหลัก
- **`application/modules/main/controllers/Main.php`** - Controller สำหรับ AJAX/submit

### Other
- **`COMPARISON_ADD_VS_EDIT.md`** - เปรียบเทียบโหมด Add vs Edit
- **`DEBUG_FINANCE.md`** - Debug guide สำหรับ Finance section

---

## 📝 Version History

### v1.0 (2025-01-15) - Initial Implementation
- แยกฟังก์ชันต่างๆ ออกเป็นไฟล์ย่อย
- มีปัญหา: checkboxes "ตีกัน"

### v2.0 (2025-02-10) - Satellite Files
- สร้าง `oldcus_editcusdata.js`, `oldcus_changecreditterm.js`
- ยังมีปัญหา: inline code ทับ field states

### v3.0 (2026-02-24) - Union Logic Consolidation ⭐ **CURRENT**
- รวม logic ทั้งหมดเข้า `addth.js`
- สร้าง `updateFieldStatesBasedOnConditions()` - Reset → Apply Union
- ลบ hard-code `.prop()` ทั้งหมด
- เพิ่ม `updateFieldStatesBasedOnConditions()` call หลัง `lockCustomerFieldsTH()`
- ลบไฟล์ satellite: `oldcus_editcusdata.js`, `oldcus_changecreditterm.js`
- อัปเดต `add_th.php` ให้ load เฉพาะ `addth.js`

---

## 🤝 Contributing Guidelines

เมื่อแก้ไขไฟล์นี้:

1. **อย่า** hard-code `.prop('readonly', true)` หรือ `.prop('disabled', true)` นอก `updateFieldStatesBasedOnConditions()`
2. **ให้** เรียก `updateFieldStatesBasedOnConditions()` หลังโหลดข้อมูลหรือเปลี่ยน state
3. **ทำ** เพิ่มฟิลด์ใหม่ใน Step 2 (Reset) และ Step 3 (Conditions) พร้อมกัน
4. **ทดสอบ** Union logic: ติ๊กหลายเงื่อนไข → ฟิลด์ต้องเปิดรวมกัน
5. **สื่อสาร** ไปยัง AI ถัดไป: อ่านเอกสารนี้ก่อนแก้ไข

---

## 📧 Contact / Support

หากมีปัญหาหรือคำถาม:
1. อ่าน **Troubleshooting** section ข้างต้น
2. ตรวจสอบ **13 Call Sites** ว่าเรียก `updateFieldStatesBasedOnConditions()` ครบหรือไม่
3. ใช้ `console.log()` ตรวจสอบ checkbox state และ field state
4. ดู **Version History** เพื่อเข้าใจ evolution ของโค้ด

---

**Last Updated:** 2026-02-24  
**File Version:** 3.0  
**Total Lines:** 3,632  
**Key Function:** `updateFieldStatesBasedOnConditions()` (line 370-558)  
**Critical Integration Point:** line 3211 (after `lockCustomerFieldsTH()`)
