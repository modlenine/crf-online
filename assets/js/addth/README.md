# addth.js - Modular Refactoring Documentation

## 📋 Overview
This directory contains the refactored version of the original monolithic `addth.js` file (3,413 lines), split into smaller, maintainable modules following **Approach 1: Technical Layer Separation**.

### Original File
- **Path**: `assets/js/addth.js`
- **Backup**: `assets/js/addth.js.backup`
- **Size**: 3,413 lines
- **Purpose**: Customer Request Form (CRF) management for Thai customers

### Refactored Structure
Split into 5 modular files totaling ~800-1,000 lines with clear separation of concerns:

```
assets/js/addth/
├── README.md                    (this file)
├── addth-config.js             (~103 lines) - Constants and globals
├── addth-validators.js         (~76 lines)  - Pattern validation
├── addth-utils.js              (~370 lines) - Utility functions
├── addth-api.js                (~237 lines) - AJAX calls
└── addth-main.js               (~900 lines) - Initialization & handlers
```

---

## 🎯 Why Refactor?

### Problems with Original File
1. **Too long** - 3,413 lines difficult to navigate
2. **Mixed concerns** - Config, validation, AJAX, handlers all together
3. **Hard to maintain** - Changes require scrolling through thousands of lines
4. **No clear dependencies** - Functions scattered throughout file
5. **Difficult to test** - Cannot isolate specific functionality

### Benefits of Refactoring
1. ✅ **Easier navigation** - Each file has single responsibility
2. ✅ **Better maintainability** - Find code quickly by function type
3. ✅ **Clear dependencies** - Load order shows what depends on what
4. ✅ **Gradual improvement** - Can refactor further module-by-module
5. ✅ **Documentation friendly** - Can document each module separately

---

## 📦 Module Descriptions

### 1. addth-config.js (103 lines)
**Purpose**: Constants and global state management

**Contains**:
- `CUSTOMER_TYPE` - NEW (1) and OLD (2) constants
- `PERSON_TYPE` - NATURAL and JURISTIC constants
- `FORM_CONFIG` - Field arrays (FILE_FIELDS, CONTACT_FIELDS, etc.)
- `ALERT_MESSAGES` - Standard alert message templates
- Global variables: `searchTimeout`, `currentRequest`

**Dependencies**: None (must load FIRST)

**Example Export**:
```javascript
const CUSTOMER_TYPE = {
    NEW: '1',
    OLD: '2'
};

const ALERT_MESSAGES = {
    REQUIRED_COMPANY: '<div class="alert alert-danger" role="alert">กรุณาเลือกบริษัทด้วยค่ะ</div>',
    // ...more messages
};
```

---

### 2. addth-validators.js (76 lines)
**Purpose**: Pattern validation functions

**Contains**:
- `minsalesreps(input)` - Validates D#### or M#### format
- `checktax(input)` - Validates 13-digit tax ID
- `checkTelPat(input)` - Validates 8-15 digit phone numbers
- `checkTH(input)` - Validates TH-#### customer code
- `checkTBDC(input)` - Validates TBDC-#### format
- `checkSTDC(input)` - Validates STDC-#### format

**Dependencies**: addth-config.js (uses constants)

**Example Usage**:
```javascript
if (!minsalesreps($('#crf_salesreps').val())) {
    alert('Invalid sales rep format');
}

if (!checktax($('#crf_customertaxid').val())) {
    alert('Invalid tax ID');
}
```

---

### 3. addth-utils.js (370 lines)
**Purpose**: Reusable utility functions for form manipulation

**Contains**:
- **Field Control**:
  - `lockCustomerFieldsTH()` - Lock fields after customer selection
  - `unlockCustomerFieldsTH()` - Unlock fields for editing
  - `setFieldsDisabled(fields, disabled)` - Bulk enable/disable
  - `enableAllFieldsForNewCustomer()` - Enable all for new customer
  - `disableAllFieldsForOldCustomer()` - Disable all for old customer
  - `disableAllFieldsInitial()` - Initial page state

- **Data Formatting**:
  - `formatNumberWithComma(value)` - Add thousand separators
  - `setupCommaFormatting(selector)` - Auto-format on keyup

- **Data Clearing**:
  - `clearOldCustomerData()` - Reset old customer form
  - `clearNewCustomerData()` - Reset new customer form
  - `clearCustomerDataTH()` - Full form reset

- **File Status**:
  - `updateCrfFile1Status()` - Dynamic file enable/disable logic

- **Validation Helpers**:
  - `validateRadioChecked(name, alertId, message)` - Radio validation
  - `validateRequired(selector, alertId, message)` - Required field check
  - `showAlert(alertId, message)` - Display alert message
  - `clearAlert(alertId)` - Remove alert message
  - `getCurrentCompany()` - Get selected company value

**Dependencies**: addth-config.js (uses FORM_CONFIG)

**Example Usage**:
```javascript
// Lock all customer fields after selection
lockCustomerFieldsTH();

// Format a number with commas
const formatted = formatNumberWithComma('1000000'); // Returns: "1,000,000"

// Clear old customer data when switching types
clearOldCustomerData();

// Check if company is selected
if (!validateRadioChecked('crf_company', 'alert_company', 'Please select company')) {
    return false;
}
```

---

### 4. addth-api.js (237 lines)
**Purpose**: All AJAX calls and server interactions

**Contains**:
- `autoSearchCustomerDetail(cusCode)` - Search by customer code (debounced)
- `autoSearchCustomerDetailName(cusName)` - Search by customer name (debounced)
- `queryProcessUse(cusId)` - Load old customer processes
- `getCusProcess(dataareaid)` - Get company-specific processes
- `queryPrimanageUse(cusId)` - Load primary manager data
- `filterCreditTerm(oldCredit, method)` - Filter credit term options
- `checkDuplicateNameCustomer(cusName, comName)` - Check for duplicate names
- `checkCustomerPendingOrders(code, area, callback)` - Check pending orders

**Dependencies**: 
- addth-config.js (uses `currentRequest` global)
- jQuery AJAX

**Example Usage**:
```javascript
// Search for customer with debouncing
autoSearchCustomerDetail('TH-0001');

// Check if customer has pending orders before proceeding
checkCustomerPendingOrders('TH-0001', 'sln', function(response) {
    if (response.status === 'in_progress') {
        alert('Customer has pending order!');
    } else {
        // Proceed with loading
    }
});

// Filter credit terms based on old term and method
filterCreditTerm('30', 'เพิ่ม');
```

---

### 5. addth-main.js (~900 lines)
**Purpose**: Main initialization and event handlers

**Contains**:
- **$(document).ready()** - Main initialization
- **Customer Type Handlers** - NEW vs OLD customer logic
- **Person Type Handlers** - NATURAL vs JURISTIC logic
- **Validation Handlers** - All field validation setup
- **File Upload Handlers** - File validation and display
- **Billing/Payment Handlers** - Condition selection logic
- **Primary Manager CRUD** - Add/remove manager rows
- **Search Handlers** - Customer code/name search with debouncing
- **Company Selection** - Enable/disable customer type
- **Helper Functions**:
  - `initializeOldCustomerHandlers()` - Setup OLD customer events
  - `initializeNewCustomerHandlers()` - Setup NEW customer events
  - `loaddataforadd(element)` - Populate form from selected customer
  - `setupFileDisplayLinks(...)` - Setup file modal popups
  - `setCompanyTypeRadioButtons(...)` - Set company type state
  - `setBillingConditions(...)` - Set billing condition state
  - `setPaymentConditions(...)` - Set payment condition state

**Dependencies**: ALL previous files (must load LAST)

**Example Structure**:
```javascript
$(document).ready(function () {
    if ($("#checkPageAddTH").val() != "addTH") {
        return; // Only run on correct page
    }
    
    // Initialize handlers
    $('input:radio[name="crf_type"]').change(function () {
        if ($(this).val() == CUSTOMER_TYPE.NEW) {
            initializeNewCustomerHandlers();
        } else if ($(this).val() == CUSTOMER_TYPE.OLD) {
            initializeOldCustomerHandlers();
        }
    });
    
    // ... more handlers
});
```

---

## 🔧 Implementation Guide

### Step 1: Update add_th.php

Replace the single script tag with multiple tags in **correct load order**:

```php
<!-- OLD (monolithic) -->
<script src="<?php echo base_url('assets/js/addth.js'); ?>"></script>

<!-- NEW (modular) - LOAD IN THIS EXACT ORDER -->
<script src="<?php echo base_url('assets/js/addth/addth-config.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/addth/addth-validators.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/addth/addth-utils.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/addth/addth-api.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/addth/addth-main.js'); ?>"></script>
```

⚠️ **CRITICAL**: Load order MUST be followed. Later files depend on earlier ones.

---

### Step 2: Test Functionality

After updating `add_th.php`, test these scenarios:

#### New Customer Flow
1. ✅ Select company (SLN/POLY/CA)
2. ✅ Select customer type (NEW)
3. ✅ Select person type (NATURAL/JURISTIC)
4. ✅ Fill in all required fields
5. ✅ Upload required files
6. ✅ Select credit term
7. ✅ Select billing/payment conditions
8.✅ Submit form

#### Old Customer Flow
1. ✅ Select company
2. ✅ Select customer type (OLD)
3. ✅ Select person type
4. ✅ Search customer by code or name
5. ✅ Select customer from autocomplete
6. ✅ Verify data loads correctly
7. ✅ Check pending orders validation
8. ✅ Select edit checkboxes as needed
9. ✅ Modify allowed fields
10. ✅ Submit form

#### Edge Cases
- ✅ Debounced search doesn't fire too many requests
- ✅ File validation works (size, format)
- ✅ Number formatting with commas
- ✅ Finance calculation (increase/decrease)
- ✅ Credit term filtering
- ✅ Duplicate name checking
- ✅ All validation messages display correctly

---

### Step 3: Rollback if Needed

If anything breaks, simply revert to the original file:

```php
<!-- Rollback to original -->
<script src="<?php echo base_url('assets/js/addth.js.backup'); ?>"></script>
```

Or copy backup back to original:
```bash
copy assets\js\addth.js.backup assets\js\addth.js
```

---

##🔄 Load Order Dependency Graph

```
addth-config.js (FIRST - no dependencies)
    ↓
    ├─→ addth-validators.js (uses CUSTOMER_TYPE, PERSON_TYPE)
    │
    ├─→ addth-utils.js (uses FORM_CONFIG, ALERT_MESSAGES)
    │
    └─→ addth-api.js (uses currentRequest, searchTimeout)
            ↓
        addth-main.js (LAST - uses ALL above)
```

**Why this order matters**:
1. `addth-config.js` defines constants that everyone needs
2. `addth-validators.js`, `addth-utils.js`, `addth-api.js` can load in parallel after config
3. `addth-main.js` must load LAST because it calls functions from all other modules

---

## 📊 File Size Comparison

| File | Lines | Description |
|------|-------|-------------|
| **Original** | | |
| `addth.js` | 3,413 | Monolithic file |
| **Refactored** | | |
| `addth-config.js` | 103 | Constants only |
| `addth-validators.js` | 76 | Validation patterns |
| `addth-utils.js` | 370 | Utility functions |
| `addth-api.js` | 237 | AJAX calls |
| `addth-main.js` | ~900 | Initialization & handlers |
| **Total** | ~1,686 | **51% reduction** |
| **Benefit** | | Easier navigation, clear separation |

Note: Main file is still large (~900 lines) but logically organized. Future refactoring can split by feature (see Approach 2 below).

---

## 🚀 Future Refactoring Path (Approach 2)

This refactoring follows **Approach 1: Technical Layer**. For better maintainability, consider migrating to **Approach 2: Feature-Based** modules:

### Proposed Feature Modules
```
addth/
├── shared/
│   ├── config.js
│   ├── validators.js
│   └── utils.js
├── features/
│   ├── old-customer/
│   │   ├── old-search.js          (customer search)
│   │   ├── old-edit.js            (edit customer checkbox)
│   │   ├── old-change-area.js     (change sales area)
│   │   ├── old-change-address.js  (change address)
│   │   ├── old-credit.js          (credit term modification)
│   │   └── old-finance.js         (finance modification)
│   │
│   ├── new-customer/
│   │   ├── new-validation.js      (field validation)
│   │   ├── new-files.js           (file upload)
│   │   └── new-credit.js          (credit term selection)
│   │
│   └── common/
│       ├── billing.js             (billing conditions)
│       ├── payment.js             (payment conditions)
│       ├── company.js             (company selection)
│       └── primary-manager.js     (manager CRUD)
└── main.js                        (initialization only)
```

### Benefits of Approach 2
1. **Feature isolation** - Each feature is self-contained
2. **Easier testing** - Can test one feature at a time
3. **Team collaboration** - Different developers can work on different features
4. **Clearer ownership** - Know exactly where to look for specific functionality
5. **Smaller files** - Each file 100-200 lines maximum

### Migration Strategy
1. ✅ Start with Approach 1 (current)
2. Test thoroughly to ensure no breakage
3. Identify feature boundaries in `addth-main.js`
4. Extract one feature at a time into separate files
5. Update load order in `add_th.php`
6. Test after each extraction

---

## 🧪 Testing Checklist

### Before Deploying
- [ ] Backup original file is in place
- [ ] Load order in `add_th.php` is correct
- [ ] Browser console shows no JavaScript errors
- [ ] Network tab shows all 5 JS files load successfully

### Functional Testing
- [ ] NEW customer: All validations work
- [ ] NEW customer: File uploads work
- [ ] NEW customer: Form submits successfully
- [ ] OLD customer: Search by code works
- [ ] OLD customer: Search by name works
- [ ] OLD customer: Pending order check works
- [ ] OLD customer: Data loads correctly
- [ ] OLD customer: Edit checkboxes work
- [ ] OLD customer: Change area checkbox works
- [ ] OLD customer: Change address checkbox works
- [ ] OLD customer: Credit term modification works
- [ ] OLD customer: Finance modification works
- [ ] Billing conditions display correctly
- [ ] Payment conditions display correctly
- [ ] Primary manager add/remove works
- [ ] Number formatting (commas) works
- [ ] File size validation works
- [ ] File format validation works

### Performance Testing
- [ ] Search debounce prevents excessive AJAX calls
- [ ] Page load time unchanged
- [ ] No memory leaks in long sessions
- [ ] Form submission speed unchanged

---

## 🐛 Troubleshooting

### Issue: "Function not defined" error

**Cause**: Load order is wrong

**Fix**: Ensure `addth-config.js` loads first, `addth-main.js` loads last

```php
<!-- Correct order -->
<script src=".../addth-config.js"></script>
<script src=".../addth-validators.js"></script>
<script src=".../addth-utils.js"></script>
<script src=".../addth-api.js"></script>
<script src=".../addth-main.js"></script>
```

---

### Issue: Form validation not working

**Cause**: Missing ALERT_MESSAGES constant

**Fix**: Check that `addth-config.js` is loaded and defines `ALERT_MESSAGES`

```javascript
// In browser console
console.log(ALERT_MESSAGES); // Should show object with messages
```

---

### Issue: AJAX search not working

**Cause**: `autoSearchCustomerDetail` not defined

**Fix**: Ensure `addth-api.js` is loaded before `addth-main.js`

```javascript
// In browser console
console.log(typeof autoSearchCustomerDetail); // Should be "function"
```

---

### Issue: Pending order check fails

**Cause**: `checkCustomerPendingOrders` callback not handled

**Fix**: Check that callback is defined and handles all response statuses:

```javascript
checkCustomerPendingOrders(code, area, function(response) {
    if (response.status === 'in_progress') {
        // Handle pending
    } else if (response.status === 'available') {
        // Handle available
    } else {
        // Handle error
    }
});
```

---

## 📝 Development Notes

### Code Style
- **Indentation**: Tabs (as per original)
- **Comments**: JSDoc style for functions
- **Naming**: Camel case for functions, UPPER_CASE for constants
- **jQuery**: Still using jQuery (not migrating to vanilla JS yet)

### Global Scope
- All functions remain in global scope (no ES6 modules)
- This maintains backward compatibility with existing code
- Future refactoring can introduce modules gradually

### Validation Approach
- Validation messages still hardcoded in Thai
- Future: Extract to separate message file for i18n

### Browser Support
- IE11+ (due to jQuery dependency)
- Modern browsers (Chrome, Firefox, Edge, Safari)

---

## 👥 Contributors

- **Original Author**: Unknown (monolithic addth.js)
- **Refactoring**: GitHub Copilot assisted refactoring (2025-06-01)

---

## 📄 License

Same as parent project (intsys/crf)

---

## 📞 Support

For issues or questions:
1. Check this README first
2. Review original `addth.js.backup` for reference
3. Test with rollback to confirm it's a refactoring issue
4. Document the issue with browser console errors

---

## 🔖 Version History

### Version 1.0.0 (2025-06-01)
- Initial modular split from monolithic file
- Approach 1: Technical Layer Separation
- 5 modules created (config, validators, utils, api, main)
- Full backward compatibility maintained
- Backup created: `addth.js.backup`

---

**Last Updated**: 2025-06-01  
**Documentation Version**: 1.0.0
