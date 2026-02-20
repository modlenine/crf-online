/**
 * edit_changecreditterm.js
 * 
 * Specialized module for Credit Term section in Edit View
 * - Handles credit term checkbox logic
 * - Handles expected date payment checkbox logic
 * - AJAX for filtering credit terms
 * - Validation for credit term changes
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
    
    var hasCreditCondition = $("#crf_condition_credit").val() != "";
    var hasNewCreditTerm = $("#showcredit2").val() != "";
    
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
    
    // Note: Main field locking and section enabling is done by edit_view.js
    // This module only handles credit term checkbox behavior
    
    // ========================================================================
    // Credit Term Checkbox Control
    // ========================================================================
    
    // Control credit term checkbox (เปลี่ยน Credit term)
    $(document).on('change', '#crf_change_creditterm', function () {
        if ($(this).is(':checked')) {
            $('.change_credit_detail').show();
            $('#crf_condition_credit').prop('disabled', false);
            // showcredit2 will be enabled after condition is selected
        } else {
            $('.change_credit_detail').hide();
            $('#crf_condition_credit').prop('disabled', true).val('');
            $('#showcredit2').prop('disabled', true).val('');
        }
        checkAndUpdateEditButton();
    });
    
    // Control expected date checkbox
    $(document).on('change', '#crf_change_expected_payment', function () {
        if ($(this).is(':checked')) {
            $('.expected_payment_section').show();
            $('#crf_arcustdueid_edit').prop('disabled', false);
        } else {
            $('.expected_payment_section').hide();
            $('#crf_arcustdueid_edit').prop('disabled', true);
        }
        checkAndUpdateEditButton();
    });
    
    // ========================================================================
    // Page Load Initialization - Show sections if data exists
    // ========================================================================
    
    // Initialize Expected Date Payment section visibility
    if ($('#crf_change_expected_payment').is(':checked')) {
        $('.expected_payment_section').show();
        $('#crf_arcustdueid_edit').prop('disabled', false);
    }
    
    // Initialize Credit Term Change section visibility
    if ($('#crf_change_creditterm').is(':checked')) {
        $('.change_credit_detail').show();
        $('#crf_condition_credit').prop('disabled', false);
    }
    
    // Monitor condition credit changes
    $(document).on('change', '#crf_condition_credit', function () {
        var creditMethod = $(this).val();
        var oldCredit = $("#oldCreditTerm").val();
        
        if (oldCredit != '' && creditMethod != '') {
            $.ajax({
                url: $('#check_EditFormNo').closest('form').attr('action').replace('save_editdata', 'filterCreditTerm'),
                method: "POST",
                data: {
                    oldCredit: oldCredit,
                    creditMethod: creditMethod
                },
                success: function(data) {
                    $('#showcredit2').html(data);
                    $('#showcredit2').prop('disabled', false);
                }
            });
        }
        
        checkAndUpdateEditButton();
    });
    
    // Monitor showcredit2 changes
    $(document).on('change', '#showcredit2', function () {
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
            if ($('#crf_change_creditterm').is(':checked')) {
                if (!$('#crf_condition_credit').val()) {
                    alert('กรุณาเลือกเงื่อนไข เพิ่ม หรือ ลด Credit term');
                    $('#alert_crf_condition_credit').html('<div class="alert alert-danger">กรุณาเลือกเงื่อนไข</div>');
                    e.preventDefault();
                    return false;
                }
                
                if (!$('#showcredit2').val()) {
                    alert('กรุณาเลือก Credit term ใหม่');
                    $('#alert_showcredit2').html('<div class="alert alert-danger">กรุณาเลือก Credit term ใหม่</div>');
                    e.preventDefault();
                    return false;
                }
            }
            
            // If neither checkbox is checked, alert
            if (!$('#crf_change_creditterm').is(':checked') && !$('#crf_change_expected_payment').is(':checked')) {
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
