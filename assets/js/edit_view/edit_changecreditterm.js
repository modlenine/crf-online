/**
 * edit_changecreditterm.js
 * 
 * Specialized module for Credit Term section in Edit View
 * - Handles credit term checkbox logic with DISABLED/ENABLED pattern (like add_th)
 * - Handles expected date payment checkbox logic
 * - AJAX for filtering credit terms
 * - Validation for credit term changes
 * 
 * Pattern (same as add_th):
 * - Initial State: All fields DISABLED
 * - Checkbox checked: ENABLE related fields
 * - Checkbox unchecked: DISABLE related fields
 * - Section visibility controlled by edit_view.js
 * 
 * Dependencies:
 * - edit_view.js (main controller - MUST load first)
 * - jQuery
 * 
 * Load Order:
 * 1. edit_view.js (locks everything, enables sections)
 * 2. edit_changecreditterm.js (THIS FILE - credit term specific)
 * 
 * Adapted from: oldcus_changecreditterm.js
 * Page: edit_view.php
 */

/**
 * Helper function: Check if user_edit button should be enabled
 * Enable button only if selected checkbox has complete data
 */
function checkAndUpdateEditButton() {
    var creditTermChecked = $('input[name=crf_change_creditterm]').is(':checked');
    var expectedDateChecked = $('input[name=crf_change_expected_payment]').is(':checked');
    
    var hasCreditCondition = $("#edit_crf_condition_credit").val() != "";
    var hasNewCreditTerm = $("#edit_showcredit2").val() != "";
    
    // Enable if:
    // 1. Credit term checked AND has condition AND has new term selected
    // 2. OR Expected date checked (uses existing dropdown)
    var shouldEnable = (creditTermChecked && hasCreditCondition && hasNewCreditTerm) || expectedDateChecked;
    
    // Note: Don't disable if other checkboxes are selected
    // Just ensure credit/expected date sections are valid when checked
    
    // For now, we'll let the form submit if ANY checkbox is selected
    // Backend will handle the actual save logic
}

$(document).ready(function () {
    
    // ========================================================================
    // Check if we're on edit page
    // ========================================================================
    var isEditPage = $('#check_EditFormNo').length > 0;
    if (!isEditPage) {
        return; // Only run on edit page
    }

    console.log('=== Edit Credit Term Module Loaded ===');
    
    // ========================================================================
    // Initial State - Check main checkbox status
    // ========================================================================
    
    // Check if main "ปรับ Credit term" checkbox is selected
    // If selected, edit_view.js already enabled the fields - don't disable them!
    var isChangeCreditSelected = $('#check_changecredit').val() == '3';
    
    if (!isChangeCreditSelected) {
        // Only disable if main checkbox is NOT selected
        $('#edit_crf_creditterm').prop('disabled', true);
        $('#edit_crf_condition_credit').prop('disabled', true);
        $('#edit_showcredit2').prop('disabled', true);
        $('#crf_arcustdueid_edit').prop('disabled', true);
        console.log('  ✓ Initial state: Credit term fields disabled (main checkbox not selected)');
    } else {
        // Main checkbox IS selected
        // But fields should still be disabled until sub-checkbox is ticked (same as add_th)
        // edit_view.js will handle based on sub-checkbox checked state
        console.log('  ✓ Initial state: Credit term section enabled (main checkbox selected)');
        console.log('  ℹ Main dropdown controlled by "ปรับ Credit term" checkbox');
    }
    
    // ========================================================================
    // Credit Term Checkbox Control (Disabled/Enabled - like add_th)
    // ========================================================================
    
    // Control credit term checkbox (เปลี่ยน Credit term)
    // Pattern: Keep sections visible, disable/enable fields only
    // NOTE: edit_crf_creditterm (รายการปัจจุบัน) is always disabled - never toggle it
    // Only toggle edit_crf_condition_credit and edit_showcredit2
    $(document).on('change', '#edit_crf_change_creditterm', function () {
        if ($(this).is(':checked')) {
            // Enable condition and new credit fields only (not main dropdown)
            $('#edit_crf_condition_credit').prop('disabled', false);
            $('#edit_showcredit2').prop('disabled', false);
        } else {
            // Disable condition and new credit fields
            $('#edit_crf_condition_credit').prop('disabled', true).val('');
            $('#edit_showcredit2').prop('disabled', true).val('');
        }
        checkAndUpdateEditButton();
    });
    
    // Control expected date checkbox
    // Pattern: Disable/enable field only (section visibility controlled by edit_view.js)
    $(document).on('change', '#edit_crf_change_expected_payment', function () {
        if ($(this).is(':checked')) {
            // Enable expected date field when checked
            $('#crf_arcustdueid_edit').prop('disabled', false);
        } else {
            // Disable expected date field when unchecked
            $('#crf_arcustdueid_edit').prop('disabled', true);
        }
        checkAndUpdateEditButton();
    });
    
    // ========================================================================
    // Page Load Initialization - Enable fields if checkboxes are checked
    // ========================================================================
    
    // Only initialize if main checkbox (changecredit) is selected
    var isChangeCreditSelected = $('#check_changecredit').val() == '3';
    
    if (isChangeCreditSelected) {
        // Initialize Expected Date Payment field state
        if ($('#edit_crf_change_expected_payment').is(':checked')) {
            $('#crf_arcustdueid_edit').prop('disabled', false);
            console.log('  ✓ Expected date payment enabled (checkbox checked)');
        } else {
            $('#crf_arcustdueid_edit').prop('disabled', true);
        }
        
        // Initialize Credit Term Change field state
        // NOTE: edit_crf_creditterm always remains disabled
        if ($('#edit_crf_change_creditterm').is(':checked')) {
            // Enable condition + showcredit2 only (not main dropdown)
            $('#edit_crf_condition_credit').prop('disabled', false);
            $('#edit_showcredit2').prop('disabled', false);
            console.log('  ✓ Credit term change enabled (checkbox checked)');
        } else {
            // Disable condition + showcredit2 (main dropdown always disabled)
            $('#edit_crf_condition_credit').prop('disabled', true);
            $('#edit_showcredit2').prop('disabled', true);
        }
    }
    
    // Monitor condition credit changes
    $(document).on('change', '#edit_crf_condition_credit', function () {
        var creditMethod = $(this).val();
        var oldCredit = $("#edit_oldCreditTerm").val();
        
        if (oldCredit != '' && creditMethod != '') {
            $.ajax({
                url: $('#check_EditFormNo').closest('form').attr('action').replace('save_editdata', 'filterCreditTerm'),
                method: "POST",
                data: {
                    oldCredit: oldCredit,
                    creditMethod: creditMethod
                },
                success: function(data) {
                    $('#edit_showcredit2').html(data);
                    // Enable edit_showcredit2 only if checkbox is checked
                    var isChecked = $('#edit_crf_change_creditterm').is(':checked');
                    $('#edit_showcredit2').prop('disabled', !isChecked);
                }
            });
        }
        
        checkAndUpdateEditButton();
    });
    
    // Monitor edit_showcredit2 changes
    $(document).on('change', '#edit_showcredit2', function () {
        checkAndUpdateEditButton();
    });
    
    // ========================================================================
    // Finance Specific Controls
    // ========================================================================
    
    $('input[name="crf_finance"]').change(function() {
        if ($(this).val() == 'ปรับวงเงิน') {
            $('.finance_change_detail').show();
            $('#crf_finance_status').prop('disabled', false);
            $('#crf_finance_change_status').prop('disabled', false);
            $('#crf_finance_change_number').prop('readonly', false);
            $('#crf_finance_change_detail').prop('readonly', false);
        } else if ($(this).val() == 'ขอวงเงิน') {
            $('.finance_change_detail').hide();
            $('#crf_finance_req_number').prop('readonly', false);
        }
    });
    
    // ========================================================================
    // Form Validation Before Submit
    // ========================================================================
    
    $('#form1').on('submit', function(e) {
        console.log('=== Form Submit Validation ===');
        
        // Note: Main checkboxes are locked (disabled) in edit mode
        // So at least one checkbox must already be checked from initial state
        // We still validate to ensure data consistency
        
        var hasAnyCheckbox = 
            $('input[name="crf_sub_oldcus_changearea"]').is(':checked') ||
            $('input[name="crf_sub_oldcus_changeaddress"]').is(':checked') ||
            $('input[name="crf_sub_oldcus_editcustomer"]').is(':checked') ||
            $('input[name="crf_sub_oldcus_changecredit"]').is(':checked') ||
            $('input[name="crf_sub_oldcus_changefinance"]').is(':checked');
        
        if (!hasAnyCheckbox) {
            alert('ข้อมูลไม่ถูกต้อง: ไม่พบหัวข้อที่เลือกไว้');
            e.preventDefault();
            return false;
        }
        
        // Validate credit term section if checked
        if ($('input[name="crf_sub_oldcus_changecredit"]').is(':checked')) {
            
            // Check if credit term checkbox is checked
            if ($('#edit_crf_change_creditterm').is(':checked')) {
                if (!$('#edit_crf_condition_credit').val()) {
                    alert('กรุณาเลือกเงื่อนไข เพิ่ม หรือ ลด Credit term');
                    $('#alert_edit_crf_condition_credit').html('<div class="alert alert-danger">กรุณาเลือกเงื่อนไข</div>');
                    e.preventDefault();
                    return false;
                }
                
                if (!$('#edit_showcredit2').val()) {
                    alert('กรุณาเลือก Credit term ใหม่');
                    $('#alert_edit_showcredit2').html('<div class="alert alert-danger">กรุณาเลือก Credit term ใหม่</div>');
                    e.preventDefault();
                    return false;
                }
            }
            
            // If neither checkbox is checked, alert
            if (!$('#edit_crf_change_creditterm').is(':checked') && !$('#edit_crf_change_expected_payment').is(':checked')) {
                alert('กรุณาเลือก ปรับ Credit term หรือ Expected Date Payment');
                e.preventDefault();
                return false;
            }
        }
        
        // Validate finance section if checked
        if ($('input[name="crf_sub_oldcus_changefinance"]').is(':checked')) {
            if (!$('input[name="crf_finance"]:checked').val()) {
                alert('กรุณาเลือก ขอวงเงิน หรือ ปรับวงเงิน');
                e.preventDefault();
                return false;
            }
        }
        
        console.log('✓ Validation passed');
        return true;
    });
    
    console.log('=== Edit Credit Term Control Initialized ===');
});
