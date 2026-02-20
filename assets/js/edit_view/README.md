# Edit View JavaScript Modules

## 📁 Folder Structure
```
assets/js/edit_view/
├── README.md                      <- This file
├── edit_changecreditterm.js       <- Main control logic for edit page
└── (future modules...)
```

## 🎯 Purpose

This folder contains JavaScript modules specifically for **edit_view.php** page with **STRICT MODE** control:
- ✅ Users can only edit fields for selected checkboxes
- ✅ Other fields are disabled/readonly
- ✅ Validation before submit
- ✅ Consistent with business workflow

## 📋 Modules

### 1. edit_changecreditterm.js
**Purpose:** Main controller for edit page - handles all checkbox-based field control

**Features:**
- Enable/disable fields based on selected checkboxes
- Credit term section control (ปรับ Credit term)
- Expected date payment control
- Finance section control (ปรับวงเงิน)
- Address section control (เปลี่ยนที่อยู่)
- Customer data control (แก้ไขข้อมูลลูกค้า)
- Sales area control (เปลี่ยนเขตการขาย)
- Form validation before submit

**Dependencies:**
- jQuery
- edit_view.php structure
- Hidden input fields: #check_changecredit, #check_changeaddress, etc.

**Usage:**
```html
<!-- Load in edit_view.php -->
<script src="<?= base_url('assets/js/edit_view/edit_changecreditterm.js?v=') . filemtime('assets/js/edit_view/edit_changecreditterm.js') ?>"></script>
```

## 🔧 How It Works

### 1. Initial State
```javascript
// On page load:
- Get checkbox states from hidden inputs
- Disable ALL editable fields
- Enable only fields for checked checkboxes
```

### 2. Checkbox Changes
```javascript
// When user checks/unchecks main checkbox:
updateFieldsBasedOnCheckboxes() {
    disableAllEditableFields();
    if (checkbox1 checked) enableSection1();
    if (checkbox2 checked) enableSection2();
    // ...
}
```

### 3. Section-Specific Controls

#### Change Credit Term (ปรับ Credit term)
- Shows `.change_credit` section
- Enables credit term checkboxes
- When `crf_change_creditterm` checked → enable condition + new term select
- When `crf_change_expected_payment` checked → enable dropdown

#### Change Finance (ปรับวงเงิน)
- Enables finance radio buttons
- Shows finance detail section based on selection

#### Change Address (เปลี่ยนที่อยู่)
- Enables address textarea
- Enables contact fields
- Shows file upload for ภพ.20

#### Edit Customer Data (แก้ไขข้อมูลลูกค้า)
- Enables customer name
- Enables all contact fields
- Shows all file uploads (file1-6)

#### Change Area (เปลี่ยนเขตการขาย)
- Enables sales reps field only

### 4. Validation
```javascript
// Before submit:
1. Check at least one checkbox selected
2. If credit term → validate condition + new term
3. If finance → validate radio selection
4. Show alerts for missing data
```

## 🎨 Checkbox Mappings

| Checkbox Name | Value | Enables Fields | Hidden Input |
|--------------|-------|----------------|--------------|
| `crf_sub_oldcus_changearea` | 1 | Sales Reps | `#check_changearea` |
| `crf_sub_oldcus_changeaddress` | 2 | Address, Contact, File1 | `#check_changeaddress` |
| `crf_sub_oldcus_changecredit` | 3 | Credit Term Section | `#check_changecredit` |
| `crf_sub_oldcus_changefinance` | 4 | Finance Section | `#check_changefinance` |
| `crf_sub_oldcus_editcustomer` | 5 | Customer Data, Files | `#check_editcustomerdetail` |

## 🔍 Debug Mode

The module includes console logging:
```javascript
console.log('=== Edit Credit Term Control Loaded ===');
console.log('Initial States:', { ... });
console.log('Checkbox changed:', ...);
console.log('✓ Enabled: Credit Term Section');
```

Open browser DevTools to see debug messages.

## 🚨 Important Notes

1. **Strict Mode**: Only selected sections are editable
2. **Validation**: Form cannot submit without required data
3. **Consistent**: Behavior matches business workflow
4. **Isolated**: No conflicts with custom.js (custom.js handles page-load state)

## 🔄 Integration with custom.js

**Division of Responsibility:**
- `custom.js`: Sets initial state on page load (readonly, show/hide)
- `edit_changecreditterm.js`: Dynamic control when user changes checkboxes

**No Conflicts:**
- custom.js runs first (sets initial state)
- edit_changecreditterm.js takes over for user interactions
- Both respect the same logic

## 📝 Future Enhancements

Potential modules to add:
- `edit_validation.js` - Separate validation module
- `edit_api.js` - API calls (filterCreditTerm, etc.)
- `edit_finance.js` - Finance calculation logic
- `edit_fileupload.js` - File upload handling

## 🐛 Troubleshooting

### Issue: Fields not enabling
**Check:**
1. Console logs - is module loaded?
2. Hidden input values - are they set correctly?
3. Checkbox IDs - do they match selectors?

### Issue: Validation not working
**Check:**
1. Form ID is `#form1`
2. Submit button is inside form
3. No other submit handlers blocking

### Issue: Conflicts with custom.js
**Solution:**
- custom.js should only set initial state
- Remove dynamic handlers from custom.js
- Let edit_changecreditterm.js handle interactions

## 📚 References

- Based on: `assets/js/addth/oldcus_changecreditterm.js`
- Page: `application/modules/main/views/edit_view.php`
- Related: `js/custom.js` (page load initialization)
