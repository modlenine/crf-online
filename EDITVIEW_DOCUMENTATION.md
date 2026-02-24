# edit_view.js Documentation

## 📋 Overview
`edit_view.js` จัดการฟอร์มแก้ไข Credit Request Form (CRF) สำหรับลูกค้าเดิมที่มีรายการค้างอยู่  
ไฟล์นี้รวม logic ทั้งหมดของการจัดการฟิลด์แบบ **Union Pattern** ซึ่งมีโครงสร้างเหมือน `addth.js` 100%

**ตำแหน่งไฟล์:** `assets/js/edit_view/edit_view.js` (1,185 บรรทัด)  
**หน้า View:** `application/modules/main/views/edit_view.php`  
**วันที่อัปเดตล่าสุด:** 2026-02-25 (Added onclick="return false" pattern)

---

## 🎯 จุดประสงค์และความแตกต่างจาก add_th.js

### หน้า add_th.php
- **เพิ่มลูกค้าใหม่** หรือ **แก้ไขลูกค้าเก่า**
- User เลือกประเภทลูกค้า (ใหม่/เก่า) และติ๊ก checkbox เงื่อนไขเอง
- Checkbox สามารถติ๊ก/เลิกติ๊กได้

### หน้า edit_view.php  
- **แก้ไขรายการที่สร้างไว้แล้ว** (มี `crfcus_id` อยู่แล้ว)
- User ไม่สามารถเปลี่ยนประเภทลูกค้าหรือ checkbox ได้ (ถูก lock ไว้)
- **อ่านค่า checkbox จาก hidden input fields** แทน - เช่น `#check_changeaddress`
- รองรับ **5 เงื่อนไข**:
  1. เปลี่ยนเขตการขาย (`#check_changearea`)
  2. เปลี่ยนที่อยู่ (`#check_changeaddress`)
  3. ปรับวงเงิน (`#check_changefinance`)
  4. ปรับ Credit Term (`#check_changecredit`)
  5. แก้ไขข้อมูลลูกค้า (`#check_editcustomer`)

---

## 🔐 Form Element Locking Strategy

### ปัญหาเดิม: disabled Attribute
```html
<!-- ❌ ปัญหา: disabled elements ไม่ส่งค่าไปใน form submission -->
<input type="checkbox" name="crf_sub_oldcus_changearea" disabled>
<input type="radio" name="crf_company" value="sln" disabled>
```

**ผลกระทบ:**
- ❌ Form submission ไม่ได้ค่าจาก disabled elements
- ❌ Backend ไม่ได้รับข้อมูลที่จำเป็น
- ❌ การบันทึกข้อมูลผิดพลาด

### วิธีแก้: onclick="return false" Pattern ✅

```html
<!-- ✅ แก้ไข: ใช้ onclick="return false" แทน disabled -->
<input type="checkbox" name="crf_sub_oldcus_changearea" value="1" onclick="return false">
<input type="radio" name="crf_company" value="sln" onclick="return false">
```

**ประโยชน์:**
- ✅ ป้องกันการคลิก (UI locked)
- ✅ ส่งค่าไปใน form submission ได้ปกติ
- ✅ Backend ได้รับข้อมูลครบถ้วน
- ✅ CSS styling ยังคงใช้ได้ (เช่น `:disabled` pseudo-class)

### Form Elements ที่ถูก Locked (14 elements)

#### 1. Main Checkboxes (5 elements) - Lines 129-160
```php
<input name="crf_sub_oldcus_changearea" value="1" onclick="return false">
<input name="crf_sub_oldcus_changeaddress" value="2" onclick="return false">
<input name="crf_sub_oldcus_editcustomer" value="5" onclick="return false">
<input name="crf_sub_oldcus_changecredit" value="3" onclick="return false">
<input name="crf_sub_oldcus_changefinance" value="4" onclick="return false">
```

**Purpose:** แสดงเงื่อนไขที่เลือกไว้ตอนสร้าง CRF - user ไม่สามารถเปลี่ยนได้

#### 2. Company Radio Buttons (5 elements) - Lines 34-65
```php
<input name="crf_company" value="sln" onclick="return false">  <!-- สลน. -->
<input name="crf_company" value="poly" onclick="return false"> <!-- พอลีเพล็กซ์ -->
<input name="crf_company" value="ca" onclick="return false">   <!-- คิงคอมพ์ฯ -->
<input name="crf_company" value="tb" onclick="return false">   <!-- ที บี พี -->
<input name="crf_company" value="st" onclick="return false">   <!-- สตาร์เท็กซ์ -->
```

**Purpose:** บริษัทที่ขอเครดิต - ไม่สามารถเปลี่ยนหลังจากสร้างแล้ว

#### 3. Customer Type Radio Buttons (2 elements) - Lines 73-86
```php
<input name="crf_type" value="1" onclick="return false"> <!-- ลูกค้าใหม่ -->
<input name="crf_type" value="2" onclick="return false"> <!-- ลูกค้าเดิม -->
```

**Purpose:** ประเภทลูกค้า - กำหนดตั้งแต่เริ่มและไม่เปลี่ยนแปลง

#### 4. Person Type Radio Buttons (2 elements) - Lines 94-107
```php
<input name="crf_person_type" value="natural" onclick="return false">  <!-- บุคคลธรรมดา -->
<input name="crf_person_type" value="juristic" onclick="return false"> <!-- นิติบุคคล -->
```

**Purpose:** ประเภทผู้ขอเครดิต - ต้องคงที่เพื่อจัดการเอกสารที่ต้องแนบ

### JavaScript Changes: Disable Old Locking Functions

#### edit_view.js - 3 Sections Commented

**1. Line 71 - Phase 2: lockMainCheckboxes() Call**
```javascript
// ===== PHASE 2: Lock checkboxes =====
// DISABLED 2026-02-25: Checkboxes now locked via onclick="return false" in PHP template
// console.log("🔒 Phase 2: Locking main checkboxes...");
// lockMainCheckboxes();
```

**2. Line 126 - Company Radio Disable**
```javascript
// Lock company selection (already set)
// DISABLED 2026-02-25: Company radio buttons now locked via onclick="return false" in PHP template
// $('input[name="crf_company"]').prop('disabled', true);
```

**3. Lines 817-818 - Address Fields in "Edit Customer" Section**
```javascript
// Address type - DISABLED 2026-02-25: Address fields should only be unlocked with "เปลี่ยนที่อยู่" checkbox
// $('input[name="edit_addresstype"]').prop('disabled', false);
// $('#edit_addressname').prop('readonly', false).removeClass('bg-light');
```

**Reason for Line 817-818:** Address fields should ONLY be editable when "เปลี่ยนที่อยู่" checkbox is active, NOT with "แก้ไขข้อมูลลูกค้า"

#### custom.js - 2 Lines Commented

**1. Line 2658 - New Customer Type Disable**
```javascript
// DISABLED 2026-02-25: Customer type radios now locked via onclick="return false" in edit_view.php
// $('input:radio[name="crf_type"]').prop('disabled', true);
```

**2. Line 2762 - Existing Customer Type Disable**
```javascript
// DISABLED 2026-02-25: Customer type radios now locked via onclick="return false" in edit_view.php
// $('input:radio[name="crf_type"]').prop('disabled', true);
```

**Why custom.js?** This file was also attempting to disable customer type radios using JavaScript. Discovered during debugging with F12 inspection showing `disabled=""` attribute still present.

### Migration from disabled to onclick="return false"

| Aspect | Before (disabled) | After (onclick="return false") |
|--------|-------------------|--------------------------------|
| **User Interaction** | ✅ Blocked | ✅ Blocked (same) |
| **Form Submission** | ❌ Value NOT sent | ✅ Value sent |
| **Visual Appearance** | ✅ Grayed out | ✅ Grayed out (same) |
| **CSS Styling** | `:disabled` works | `:disabled` works (onclick doesn't affect this) |
| **Accessibility** | May confuse screen readers | Clear semantic meaning |
| **Backend Impact** | ❌ Missing data | ✅ Complete data |

### Testing Checklist ✅

**Visual Test:**
- ✅ Elements appear locked (grayed out, cursor not allowed)
- ✅ User cannot click or change values
- ✅ Form displays correctly

**Functional Test:**
- ✅ Form submission includes all locked element values
- ✅ Backend receives complete data
- ✅ No JavaScript errors in console
- ✅ F12 inspection shows onclick="return false" instead of disabled=""

**Confirmed Working:** 2026-02-25 ✅

---

## 🏗️ โครงสร้างไฟล์

### 1. Documentation & Constants (บรรทัด 1-48)
```javascript
/**
 * Core Concept: Union Logic Pattern (ยึดโครงสร้างเดียวกับ add_th.js)
 * Step 1: Read checkbox states from hidden inputs
 * Step 2: Reset ALL fields to disabled/readonly  
 * Step 3: Enable fields for EACH selected checkbox (Union logic)
 * Step 4: Handle special cases (file inputs based on person type)
 * Step 5: Enable memos (always available)
 */

// Phase Initialization:
// Phase 1: Lock all fields (strict mode)
// Phase 1.5: Handle person type file containers visibility
// Phase 2: Lock checkboxes (cannot change after creation)  
// Phase 3: Enable fields based on checkbox conditions (Union Logic)
```

**Link to Code:**  
- Documentation: [edit_view.js#L1-L30](c:\xampp\htdocs\intsys\crf\assets\js\edit_view\edit_view.js#L1-L30)
- Initialization Phases: [edit_view.js#L35-L95](c:\xampp\htdocs\intsys\crf\assets\js\edit_view\edit_view.js#L35-L95)

---

### 2. Initialization Code (บรรทัด 35-95)

```javascript
$(document).ready(function () {
    // ===== PHASE 1: Lock all fields =====
    console.log("🔒 Phase 1: Locking all customer fields...");
    lockCustomerFieldsTH();
    
    // ===== PHASE 1.5: Handle person type file containers =====
    console.log("📁 Phase 1.5: Setting up file containers based on person type...");
    handlePersonTypeFileContainers();
    
    // ===== PHASE 2: Lock checkboxes =====
    // **DISABLED 2026-02-25:** Checkboxes and radios now locked via onclick="return false" in PHP template
    // console.log("🔒 Phase 2: Locking main checkboxes...");
    // lockMainCheckboxes();
    
    // **DISABLED 2026-02-25:** Company radios also locked in PHP template
    // $('input[name="crf_company"]').prop('disabled', true);
    
    // ===== PHASE 3: Enable fields based on checkbox conditions =====
    console.log("✅ Phase 3: Enabling fields for selected topics...");
    updateFieldStatesBasedOnConditions();
    
    // ... Event Handlers Setup ...
});
```

**🔄 Change Notes (2026-02-25):**
- Phase 2 components (lockMainCheckboxes, company disable) are now commented out
- Form elements locked using `onclick="return false"` pattern in HTML instead of JavaScript
- This ensures form values are submitted while preventing user interaction
- See section "🔐 Form Element Locking Strategy" for complete details

**Link to Code:** [edit_view.js#L35-L95](c:\xampp\htdocs\intsys\crf\assets\js\edit_view\edit_view.js#L35-L95)

---

### 3. Core Utility Functions (บรรทัด 97-240)

#### 3.1 Field Control Functions
| Function | Purpose | Status | Link |
|----------|---------|--------|------|
| `lockCustomerFieldsTH()` | Lock all fields to readonly/disabled (strict mode) | ✅ Active | [#L97-L180](c:\xampp\htdocs\intsys\crf\assets\js\edit_view\edit_view.js#L97-L180) |
| `lockMainCheckboxes()` | ~~Disable main checkboxes (cannot change after creation)~~ | ⚠️ DEPRECATED | [#L182-L205](c:\xampp\htdocs\intsys\crf\assets\js\edit_view\edit_view.js#L182-L205) |
| `handlePersonTypeFileContainers()` | Show/hide file upload containers based on person type | ✅ Active | [#L207-L238](c:\xampp\htdocs\intsys\crf\assets\js\edit_view\edit_view.js#L207-L238) |

**⚠️ Deprecation Notice (2026-02-25):**
- `lockMainCheckboxes()` function still exists in code but is **NOT CALLED** anymore
- Checkboxes and radio buttons now locked using `onclick="return false"` pattern in HTML
- JavaScript disable approach caused form submission issues (disabled elements don't send values)
- See section "🔐 Form Element Locking Strategy" for migration details

#### 3.2 Person Type File Container Logic

```javascript
function handlePersonTypeFileContainers() {
    const personType = $('#edit_checkCusType').val(); // 'natural' or 'juristic'
    
    if (personType === "natural") {
        $("#for_natural").show();   // Show สำเนาบัตรประชาชน container
        $("#for_juristic").hide();  // Hide 6 juristic documents
    } else if (personType === "juristic") {
        $("#for_natural").hide();   // Hide บัตรประชาชน
        $("#for_juristic").show();  // Show ภพ.20, หนังสือรับรอง, etc.
    }
}
```

**Key Points:**
- ✅ Affects **outer container visibility only** (#for_natural, #for_juristic)
- ✅ Does NOT directly enable/disable input elements
- ✅ Input state controlled separately by Union Logic (Step 4)
- ✅ Structure 100% identical to `add_th.js` → `handlePersonTypeFiles()`

**Link to Code:** [edit_view.js#L207-L238](c:\xampp\htdocs\intsys\crf\assets\js\edit_view\edit_view.js#L207-L238)

---

### 4. 🌟 **Core Function: Union Logic** (บรรทัด 610-920)

```javascript
function updateFieldStatesBasedOnConditions()
```

**ฟังก์ชันสำคัญที่สุด** - จัดการ enable/disable ฟิลด์ทั้งหมดตามเงื่อนไข checkbox  
โครงสร้างเหมือน `addth.js::updateFieldStatesBasedOnConditions()` 100%

**Link to Code:** [edit_view.js#L610-L920](c:\xampp\htdocs\intsys\crf\assets\js\edit_view\edit_view.js#L610-L920)

---

## 🎯 Core Concept: Union Logic Pattern

### ปัญหาเดิม (Before 2026-02-24)
- Logic กระจัดกระจายใน `custom.js` และ inline script
- ใช้ show/hide แต่ไม่ได้ควบคุม enabled state
- เมื่อติ๊กหลาย checkbox ฟิลด์จะ "ตีกัน" เพราะแต่ละเงื่อนไข enable/disable fields แยกกัน

### วิธีแก้: Reset → Apply Union (Same as add_th.js)

```javascript
function updateFieldStatesBasedOnConditions() {
    // ===== STEP 1: Read checkbox states from HIDDEN INPUTS =====
    const isChangeArea = ($('#check_changearea').val() == "1");
    const isChangeAddress = ($('#check_changeaddress').val() == "2");
    const isChangeFinance = ($('#check_changefinance').val() == "4");
    const isChangeCredit = ($('#check_changecredit').val() == "3");
    const isEditCustomer = ($('#check_editcustomer').val() == "5");
    const isJuristicPerson = ($('#edit_checkCusType').val() === "juristic");
    
    console.log("📋 Current conditions:", {
        changeArea: isChangeArea,
        changeAddress: isChangeAddress,
        changeFinance: isChangeFinance,
        changeCredit: isChangeCredit,
        editCustomer: isEditCustomer,
        personType: isJuristicPerson ? "juristic" : "natural"
    });

    // ===== STEP 2: RESET ALL FIELDS =====
    // Lock everything first
    $("#crf_salesreps").prop("readonly", true).addClass("bg-light");
    $("#crf_customername").prop("readonly", true).addClass("bg-light");
    $("#crf_customertaxid").prop("readonly", true).addClass("bg-light");
    // ... (50+ fields) ...
    
    // ===== STEP 3: ENABLE FIELDS PER CONDITION (UNION) =====
    
    // Condition 1: Change Sales Area
    if (isChangeArea) {
        console.log("✅ Enabling fields for: Change Sales Area");
        $("#crf_salesreps").prop("readonly", false).removeClass("bg-light");
    }
    
    // Condition 2: Change Address
    if (isChangeAddress) {
        console.log("✅ Enabling fields for: Change Address");
        $('input[name="crf_addresstype"]').prop("disabled", false);
        $("#crf_addressname").prop("readonly", false).removeClass("bg-light");
        // ... enable address-related fields ...
    }
    
    // Condition 3: Change Finance (Adjust Credit Limit)
    if (isChangeFinance) {
        console.log("✅ Enabling fields for: Change Finance");
        $(".finance_change_detail").show();
        $("#crf_finance_status").prop("disabled", false);
        $("#crf_finance_change_status").prop("disabled", false);
        // ... enable finance fields ...
    }
    
    // Condition 4: Change Credit Term
    if (isChangeCredit) {
        console.log("✅ Enabling fields for: Change Credit Term");
        $(".change_credit, .change_credit_detail").show();
        $("#crf_condition_credit").prop("disabled", false);
        $("#showcredit2").prop("disabled", false);
        $("#crf_new_arcustdueid").prop("disabled", false);
    }
    
    // Condition 5: Edit Customer Info
    if (isEditCustomer) {
        console.log("✅ Enabling fields for: Edit Customer Info");
        $("#crf_customername").prop("readonly", false).removeClass("bg-light");
        $("#crf_customertaxid").prop("readonly", false).removeClass("bg-light");
        $("#crf_customerbranch").prop("readonly", false).removeClass("bg-light");
        // ... enable customer profile fields (40+ fields) ...
        // NOTE: File inputs handled in STEP 4 (by person type)
    }
    
    // ===== STEP 4: HANDLE SPECIAL CASES =====
    // File inputs enabled based on BOTH conditions AND person type
    if (isJuristicPerson) {
        if (isEditCustomer) {
            console.log("📁 Enabling juristic person file uploads...");
            $('#crf_file1').prop('disabled', false);
            $('#crf_file2').prop('disabled', false);
            $('#crf_file3').prop('disabled', false);
            $('#crf_file4').prop('disabled', false);
            $('#crf_file5').prop('disabled', false);
            $('#crf_file6').prop('disabled', false);
        }
    } else {
        // Natural person
        if (isEditCustomer) {
            console.log("📁 Enabling natural person file upload...");
            $('#crf_file_person').prop('disabled', false);
        }
    }
    
    // ===== STEP 5: ENABLE MEMOS =====
    // Always available regardless of conditions
    $("#crf_textmemo").prop("readonly", false).removeClass("bg-light");
    $("#crfcus_memo2").prop("readonly", false).removeClass("bg-light");
}
```

**Key Principles:**
1. ✅ **Reset First**: Lock everything to clean slate
2. ✅ **Union Pattern**: Each condition independently enables its fields - NO CONFLICTS
3. ✅ **Special Cases**: File uploads use AND logic (condition + person type)
4. ✅ **Memos Always Available**: Users can add notes regardless of condition
5. ✅ **Console Logging**: Clear visibility of what's being enabled

**Link to Code:** [edit_view.js#L610-L920](c:\xampp\htdocs\intsys\crf\assets\js\edit_view\edit_view.js#L610-L920)

---

### 5. Credit Term Management (บรรทัด 240-398)

| Function | Purpose | Link |
|----------|---------|------|
| `checkAndUpdateSubmitButtonCredit()` | Validate credit term fields and enable/disable submit button | [#L240-L286](c:\xampp\htdocs\intsys\crf\assets\js\edit_view\edit_view.js#L240-L286) |
| `filterCreditTermOptions()` | Filter credit terms based on condition (increase/decrease) | [#L288-L340](c:\xampp\htdocs\intsys\crf\assets\js\edit_view\edit_view.js#L288-L340) |
| `ajaxLoadCreditOptions()` | AJAX call to load credit term options | [#L342-L398](c:\xampp\htdocs\intsys\crf\assets\js\edit_view\edit_view.js#L342-L398) |

#### 5.1 Submit Button Validation Logic

```javascript
function checkAndUpdateSubmitButtonCredit() {
    const isChangeCredit = ($('#check_changecredit').val() == "3");
    
    if (!isChangeCredit) {
        console.log("✅ Submit enabled: Credit term change not required");
        $("#user_submit").prop("disabled", false);
        return;
    }
    
    // Check if all required fields are filled
    const hasOldCredit = $("#oldCreditTerm").val() != "";
    const hasCondition = $("#crf_condition_credit").val() != "";
    const hasNewCredit = $("#showcredit2").val() != "";
    const hasNewExpectedDate = $("#crf_new_arcustdueid").val() != "";
    
    const isValid = hasOldCredit && hasCondition && hasNewCredit && hasNewExpectedDate;
    
    console.log("🔍 Credit term validation:", {
        oldCredit: hasOldCredit,
        condition: hasCondition,
        newCredit: hasNewCredit,
        newExpectedDate: hasNewExpectedDate,
        isValid: isValid
    });
    
    $("#user_submit").prop("disabled", !isValid);
}
```

**Validation Rules:**
- ✅ If NOT changing credit → Submit enabled
- ✅ If changing credit → Must fill: old credit, condition (increase/decrease), new credit, new expected date
- ✅ Real-time validation - button state updates instantly

**Link to Code:** [edit_view.js#L240-L286](c:\xampp\htdocs\intsys\crf\assets\js\edit_view\edit_view.js#L240-L286)

---

#### 5.2 Credit Term Filtering Logic

```javascript
function filterCreditTermOptions() {
    const condition = $('#crf_condition_credit').val();
    const oldCreditId = $('#oldCreditTerm').val();
    
    if (condition === "เพิ่ม") {
        // Show only credit terms > current
        ajaxLoadCreditOptions(oldCreditId, 'increase');
    } else if (condition === "ลด") {
        // Show only credit terms < current
        ajaxLoadCreditOptions(oldCreditId, 'decrease');
    }
}
```

**AJAX Request:**
```javascript
function ajaxLoadCreditOptions(currentCreditId, filterType) {
    $.ajax({
        url: $("#checkbaseurl").val() + "main/ajax_getFilteredCreditTerms",
        type: "POST",
        dataType: "json",
        data: {
            current_credit_id: currentCreditId,
            filter_type: filterType  // 'increase' or 'decrease'
        },
        success: function (response) {
            $('#showcredit2').html(response.options);
        }
    });
}
```

**Link to Code:**
- Filtering: [edit_view.js#L288-L340](c:\xampp\htdocs\intsys\crf\assets\js\edit_view\edit_view.js#L288-L340)
- AJAX: [edit_view.js#L342-L398](c:\xampp\htdocs\intsys\crf\assets\js\edit_view\edit_view.js#L342-L398)

---

### 6. Finance Management (บรรทัด 400-526)

| Function | Purpose | Link |
|----------|---------|------|
| `checkFinanceChangeStatus()` | Determine finance adjustment type (temporary/permanent) | [#L400-L445](c:\xampp\htdocs\intsys\crf\assets\js\edit_view\edit_view.js#L400-L445) |
| `calculateFinanceTotal()` | Calculate total finance limit (old ± adjustment) | [#L447-L526](c:\xampp\htdocs\intsys\crf\assets\js\edit_view\edit_view.js#L447-L526) |

#### 6.1 Finance Status Logic

```javascript
function checkFinanceChangeStatus() {
    const financeStatus = $('#crf_finance_status').val();
    const changeStatus = $('#crf_finance_change_status').val();
    
    if (financeStatus === "วงเงินชั่วคราว") {
        if (changeStatus === "เพิ่ม") {
            $('#showChangeStatus').val('temporary_increase');
        } else if (changeStatus === "ลด") {
            $('#showChangeStatus').val('temporary_decrease');
        }
    } else if (financeStatus === "วงเงินถาวร") {
        if (changeStatus === "เพิ่ม") {
            $('#showChangeStatus').val('permanent_increase');
        } else if (changeStatus === "ลด") {
            $('#showChangeStatus').val('permanent_decrease');
        }
    }
}
```

**Link to Code:** [edit_view.js#L400-L445](c:\xampp\htdocs\intsys\crf\assets\js\edit_view\edit_view.js#L400-L445)

---

#### 6.2 Finance Calculation Logic

```javascript
function calculateFinanceTotal() {
    // Get old finance limit from hidden field
    const oldFinanceStr = $('#oldFinanceLimit').val().replace(/,/g, '');
    const oldFinance = parseFloat(oldFinanceStr) || 0;
    
    // Get adjustment amount (remove commas)
    const changeAmountStr = $('#crf_finance_change_number').val().replace(/,/g, '');
    const changeAmount = parseFloat(changeAmountStr) || 0;
    
    // Get adjustment type (increase/decrease)
    const changeStatus = $('#crf_finance_change_status').val();
    
    let total;
    if (changeStatus === "เพิ่ม") {
        total = oldFinance + changeAmount;
    } else if (changeStatus === "ลด") {
        total = oldFinance - changeAmount;
    } else {
        total = oldFinance;
    }
    
    // Display with comma formatting
    const formattedTotal = total.toLocaleString('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
    
    $('#crf_finance_change_total').val(formattedTotal);
}
```

**Features:**
- ✅ Auto-calculation on input change
- ✅ Handles comma-formatted numbers
- ✅ Displays result with 2 decimal places
- ✅ Real-time updates

**Link to Code:** [edit_view.js#L447-L526](c:\xampp\htdocs\intsys\crf\assets\js\edit_view\edit_view.js#L447-L526)

---

### 7. Form Validation (บรรทัด 528-608)

| Function | Purpose | Link |
|----------|---------|------|
| `validateFormBeforeSubmit()` | Main validation function called on form submit | [#L528-L608](c:\xampp\htdocs\intsys\crf\assets\js\edit_view\edit_view.js#L528-L608) |

#### 7.1 Validation Rules

```javascript
function validateFormBeforeSubmit(e) {
    let errors = [];
    
    // 1. Validate Credit Term (if checkbox is checked)
    if ($('#check_changecredit').val() == "3") {
        if ($('#crf_condition_credit').val() === "") {
            errors.push("กรุณาเลือกเงื่อนไขการปรับ Credit Term");
        }
        if ($('#showcredit2').val() === "") {
            errors.push("กรุณาเลือก Credit Term ใหม่");
        }
        if ($('#crf_new_arcustdueid').val() === "") {
            errors.push("กรุณาเลือก Expected Date Payment ใหม่");
        }
    }
    
    // 2. Validate Finance (if checkbox is checked)
    if ($('#check_changefinance').val() == "4") {
        if ($('#crf_finance_status').val() === "") {
            errors.push("กรุณาเลือกสถานะวงเงิน");
        }
        if ($('#crf_finance_change_status').val() === "") {
            errors.push("กรุณาเลือกสถานะการขอ (เพิ่ม/ลด)");
        }
        if ($('#crf_finance_change_number').val() === "") {
            errors.push("กรุณาระบุจำนวนเงินที่ต้องการปรับ");
        }
    }
    
    // 3. Display errors
    if (errors.length > 0) {
        e.preventDefault();
        alert("กรุณากรอกข้อมูลให้ครบถ้วน:\n\n" + errors.join("\n"));
        return false;
    }
    
    return true;
}
```

**Validation Triggers:**
- ✅ Form submit event
- ✅ Before AJAX call
- ✅ Shows grouped error messages

**Link to Code:** [edit_view.js#L528-L608](c:\xampp\htdocs\intsys\crf\assets\js\edit_view\edit_view.js#L528-L608)

---

### 8. Event Handlers (บรรทัด 922-1185)

#### 8.1 Document Ready Setup (บรรทัด 35-95)

```javascript
$(document).ready(function () {
    // Phase 1: Lock all fields
    lockCustomerFieldsTH();
    
    // Phase 1.5: Handle person type file containers
    handlePersonTypeFileContainers();
    
    // Phase 2: Lock checkboxes
    lockMainCheckboxes();
    
    // Phase 3: Union Logic - Enable fields
    updateFieldStatesBasedOnConditions();
    
    // Setup all event handlers...
});
```

**Link to Code:** [edit_view.js#L35-L95](c:\xampp\htdocs\intsys\crf\assets\js\edit_view\edit_view.js#L35-L95)

---

#### 8.2 Key Event Handlers

| Event | Trigger | Action | Link |
|-------|---------|--------|------|
| Credit Condition Change | `#crf_condition_credit` change | Filter credit term options | [#L1148-L1152](c:\xampp\htdocs\intsys\crf\assets\js\edit_view\edit_view.js#L1148-L1152) |
| Credit Term Select | `#showcredit2` change | Update submit button state | [#L1154-L1158](c:\xampp\htdocs\intsys\crf\assets\js\edit_view\edit_view.js#L1154-L1158) |
| Expected Date Select | `#crf_new_arcustdueid` change | Update submit button state | [#L1160-L1164](c:\xampp\htdocs\intsys\crf\assets\js\edit_view\edit_view.js#L1160-L1164) |
| Finance Status Change | `#crf_finance_status` change | Check finance status | [#L1120-L1124](c:\xampp\htdocs\intsys\crf\assets\js\edit_view\edit_view.js#L1120-L1124) |
| Finance Amount Input | `#crf_finance_change_number` input | Calculate total | [#L1126-L1130](c:\xampp\htdocs\intsys\crf\assets\js\edit_view\edit_view.js#L1126-L1130) |
| Form Submit | `#form1` submit | Validate before submit | [#L1095-L1099](c:\xampp\htdocs\intsys\crf\assets\js\edit_view\edit_view.js#L1095-L1099) |

**Link to Complete Event Handlers Section:** [edit_view.js#L922-L1185](c:\xampp\htdocs\intsys\crf\assets\js\edit_view\edit_view.js#L922-L1185)

---

## 🔄 Multi-Layer Architecture: Why No Conflicts?

### Layer 1: Container Visibility (Phase 1.5)
```javascript
handlePersonTypeFileContainers()  // Show/hide #for_natural or #for_juristic
```
- **Controls:** `display` CSS property of **containers**
- **Timing:** Runs ONCE during initialization
- **Affected Elements:** `#for_natural`, `#for_juristic`

### Layer 2: Input State (Union Logic Step 4)
```javascript
updateFieldStatesBasedOnConditions()  // Enable/disable file inputs
```
- **Controls:** `disabled` property of **input elements**
- **Timing:** Runs MULTIPLE times (on condition change)
- **Affected Elements:** `#crf_file_person`, `#crf_file1-6`

### Why No Conflicts?

| Aspect | Layer 1 (Container) | Layer 2 (Input) | Conflict? |
|--------|--------------------|--------------------|-----------|
| **Property** | `.show()` / `.hide()` | `.prop('disabled', ...)` | ❌ Different properties |
| **Target** | Outer `<div>` containers | Inner `<input>` elements | ❌ Different elements |
| **Timing** | Once at page load | Multiple times (dynamic) | ❌ Different timing |
| **Purpose** | Structure (what's visible) | State (what's editable) | ❌ Different concerns |

**Conclusion:** ✅ **Clean separation of concerns - No conflicts possible**

---

## 📊 Control Flow Diagram

```
Page Load
    ↓
custom.js loads initial state from DB
- Sets hidden inputs: #check_changearea, #check_changeaddress, etc.
- Sets person type: #edit_checkCusType
    ↓
edit_view.js Document Ready
    ↓
┌─────────────────────────────────────┐
│ PHASE 1: Lock All Fields           │
│ lockCustomerFieldsTH()              │
│ → Everything disabled/readonly      │
└─────────────────────────────────────┘
    ↓
┌─────────────────────────────────────┐
│ PHASE 1.5: File Containers          │
│ handlePersonTypeFileContainers()    │
│ → Show natural OR juristic container│
└─────────────────────────────────────┘
    ↓
┌─────────────────────────────────────┐
│ PHASE 2: Lock Checkboxes            │
│ lockMainCheckboxes()                │
│ → User cannot change conditions     │
└─────────────────────────────────────┘
    ↓
┌─────────────────────────────────────────────────────────┐
│ PHASE 3: UNION LOGIC                                    │
│ updateFieldStatesBasedOnConditions()                    │
│                                                          │
│ Step 1: Read checkbox states from hidden inputs         │
│ Step 2: RESET all fields to disabled                    │
│ Step 3: ENABLE fields for EACH condition independently  │
│         → No conflicts (Union Pattern)                   │
│ Step 4: Handle file inputs (condition + person type)    │
│ Step 5: Enable memos (always)                           │
└─────────────────────────────────────────────────────────┘
    ↓
Event Handlers Active
    ↓
User makes changes → Real-time validation → Enable/disable submit
```

---

## 🔧 Maintenance Guide

### Adding a New Field

**Scenario:** Need to add field `#new_field` that should be editable when "Edit Customer" is checked

**Steps:**

1. **Add to Lock Function** (edit_view.js#L97-L180)
```javascript
function lockCustomerFieldsTH() {
    // ... existing locks ...
    $("#new_field").prop("readonly", true).addClass("bg-light");
}
```

2. **Add to Union Logic** (edit_view.js#L610-L920)
```javascript
// Inside Condition 5: Edit Customer Info
if (isEditCustomer) {
    // ... existing enables ...
    $("#new_field").prop("readonly", false).removeClass("bg-light");
}
```

3. **Test:** Verify field is locked on load, enabled only when "Edit Customer" is active

---

### Adding a New Condition

**Scenario:** New checkbox "Change Payment Method"

**Steps:**

1. **Add hidden input** in edit_view.php
```html
<input type="hidden" id="check_changepayment" value="<?= $condition6 ?>">
```

2. **Read in Union Logic** (edit_view.js#L610-L920)
```javascript
const isChangePayment = ($('#check_changepayment').val() == "6");
```

3. **Add enable logic** 
```javascript
if (isChangePayment) {
    console.log("✅ Enabling fields for: Change Payment Method");
    $("#payment_field1").prop("disabled", false);
    $("#payment_field2").prop("readonly", false).removeClass("bg-light");
}
```

---

### Debugging Tips

**Enable verbose logging:**
```javascript
// Union Logic already has extensive console.log statements
// Check browser console for:
// - "📋 Current conditions:" (Step 1)
// - "✅ Enabling fields for: [condition]" (Step 3)
// - "📁 Enabling file uploads..." (Step 4)
```

**Common Issues:**

| Issue | Check | Solution |
|-------|-------|----------|
| Field always locked | Union Logic Step 3 | Ensure condition is properly enabled |
| Files not showing | Phase 1.5 | Check person type value |
| Submit always disabled | Credit validation | Check `checkAndUpdateSubmitButtonCredit()` |
| Fields "fighting" | Union Logic | Should not happen with Reset→Union pattern |

---

## 📝 Change Log

### 2026-02-25: Form Element Locking Pattern Migration
- ✅ Migrated from `disabled` attribute to `onclick="return false"` pattern
- ✅ Updated 14 form elements in edit_view.php:
  - 5 main checkboxes (changearea, changeaddress, editcustomer, changecredit, changefinance)
  - 5 company radio buttons (sln, poly, ca, tb, st)
  - 2 customer type radios (ลูกค้าใหม่, ลูกค้าเดิม)
  - 2 person type radios (บุคคลธรรมดา, นิติบุคคล)
- ✅ Commented out JavaScript disable code in edit_view.js (3 locations):
  - Line 71: lockMainCheckboxes() call
  - Line 126: company radio disable
  - Lines 817-818: address field unlock in "Edit Customer Data" section
- ✅ Commented out JavaScript disable code in custom.js (2 locations):
  - Line 2658: customer type disable for new customers
  - Line 2762: customer type disable for existing customers
- ✅ Fixed address field logic: only unlocked with "เปลี่ยนที่อยู่" checkbox, NOT with "แก้ไขข้อมูลลูกค้า"
- ✅ Benefits: Form submission now works correctly, all values sent to backend
- ✅ Testing: Confirmed working with F12 inspection and form submission tests

### 2026-02-24: Complete Refactor
- ✅ Consolidated all logic from edit_changecreditterm.js into edit_view.js
- ✅ Deleted edit_changecreditterm.js (obsolete)
- ✅ Implemented full Union Logic Pattern (same structure as add_th.js)
- ✅ Removed hardcode conflicts from custom.js (lines 2976-2987)
- ✅ Added Phase 1.5 for person type file container handling
- ✅ Fixed HTML structure in edit_view.php:
  - Changed `edit_file_natural` → `for_natural`
  - Changed `edit_file_juristic` → `for_juristic`
  - Added `style="display:none;"` to containers
  - Changed class `crf_file1` → `crf_file_person` for natural person
- ✅ Aligned file input behavior with add_th.php exactly
- ✅ Validated no code conflicts in multi-layer architecture

**Before:**
- Logic scattered across multiple files
- No clear separation of concerns
- File inputs didn't work correctly
- Hardcoded controls in custom.js

**After:**
- Single source of truth (edit_view.js)
- Clear 5-step Union Logic pattern
- File inputs work identically to add_th.php
- Clean architecture with no conflicts
- 100% structural alignment with add_th.js

---

## 🔗 Related Documentation

- **ADDTH_DOCUMENTATION.md** - Documentation for add_th.js (template reference)
- **COMPARISON_ADD_VS_EDIT.md** - Comparison between add_th and edit_view (updated 2026-02-24)
- **DEBUG_FINANCE.md** - Finance calculation debugging guide

---

## 👥 Key Takeaways

### For Developers
1. ✅ **edit_view.js = add_th.js structure** - Same 5-step Union Logic pattern
2. ✅ **Read from hidden inputs** - Checkboxes are locked, values in `#check_*` fields
3. ✅ **Reset → Union → Special Cases** - Prevents field conflicts
4. ✅ **Multi-layer architecture** - Container visibility ≠ Input state (no conflicts)
5. ✅ **Real-time validation** - Submit button state updates dynamically

### For Maintainers
1. ✅ **Single source of truth** - All edit_view logic in edit_view.js
2. ✅ **Console logging** - Extensive debugging info in browser console
3. ✅ **Separation of concerns** - Phase 1.5 (containers) vs Union Logic (inputs)
4. ✅ **Documented structure** - Each function has clear purpose and link
5. ✅ **Template pattern** - Follow add_th.js when adding new features

---

**End of Documentation**  
Version: 1.0.0  
Last Updated: 2026-02-24  
Maintained by: Development Team
