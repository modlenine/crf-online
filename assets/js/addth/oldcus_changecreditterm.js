/**
 * oldcus_changecreditterm.js
 * 
 * Handles credit term change functionality for old customers
 * - Toggle behavior for credit term and expected date payment checkboxes
 * - Main checkbox handler for old customer credit term changes
 * - Uses filterCreditTerm() from addth-api.js
 */

/**
 * Helper function: Check if user_submit button should be enabled
 * Enable button if ANY of these conditions are met:
 * 1. crf_change_creditterm is checked AND condition is selected
 * 2. crf_change_expected_date is checked (ไม่ต้องเช็ค dropdown เพราะใช้ crf_arcustdueid ที่มีอยู่แล้ว)
 */
function checkAndUpdateSubmitButton() {
    var creditTermChecked = $('input[name=crf_change_creditterm]').is(':checked');
    var expectedDateChecked = $('input[name=crf_change_expected_date]').is(':checked');
    
    var hasCreditCondition = $("#crf_condition_credit").val() != "";
    
    // Enable if: (credit term checked AND has condition) OR (expected date checked)
    var shouldEnable = (creditTermChecked && hasCreditCondition) || expectedDateChecked;
    
    $("#user_submit").prop("disabled", !shouldEnable);
}

$(document).ready(function () {
    
    // ========================================================================
    // Initial State - Disable fields on page load
    // ========================================================================
    
    // Disable credit term fields initially (until checkbox is checked)
    $('#crf_creditterm').prop('disabled', true);
    $('#crf_condition_credit').prop('disabled', true);
    $('#showcredit2').prop('disabled', true);
    $('#crf_creditterm2').prop('disabled', true); // Dynamic element from AJAX
    
    // Disable expected date payment field initially (until checkbox is checked)
    $('#crf_arcustdueid').prop('disabled', true);
    
    // ========================================================================
    // Toggle Handlers - Enable/Disable Detail Fields
    // ========================================================================
    
    // Control if change credit term is clicked (enable/disable instead of hide/show)
    $(document).on('click', 'input[name=crf_change_creditterm]', function () {
        if ($(this).is(':checked')) {
            // Keep crf_creditterm disabled (ข้อมูลจาก DB ไม่ต้องการให้แก้ไข)
            // Enable condition fields only
            $('#crf_condition_credit').prop('disabled', false);
            $('#showcredit2').prop('disabled', false);
            $('#crf_creditterm2').prop('disabled', false); // Dynamic element
        } else {
            // Disable all credit term fields
            $('#crf_creditterm').prop('disabled', true);
            $('#crf_condition_credit').prop('disabled', true);
            $('#showcredit2').prop('disabled', true);
            $('#crf_creditterm2').prop('disabled', true); // Dynamic element
            // Clear values (but not crf_creditterm - keep original value)
            $('#crf_condition_credit').val('');
            $('#showcredit2').val('');
        }
        
        // Check submit button availability
        checkAndUpdateSubmitButton();
    });

    // Control if change expected date payment is clicked
    // Note: ใช้ crf_arcustdueid เท่านั้น ไม่ใช้ crf_new_arcustdueid
    $(document).on('click', 'input[name=crf_change_expected_date]', function () {
        if ($(this).is(':checked')) {
            // Enable expected date field when checked
            $('#crf_arcustdueid').prop('disabled', false);
        } else {
            // Disable expected date field when unchecked
            $('#crf_arcustdueid').prop('disabled', true);
        }
        
        // Check submit button availability (แค่ติ๊กพอ ไม่ต้องรอเลือก dropdown)
        checkAndUpdateSubmitButton();
    });
    
    // Monitor changes to credit term condition dropdown
    // Note: filterCreditTerm() is defined in addth-api.js
    $(document).on('change', '#crf_condition_credit', function () {
        $(".showcredit2").remove();
        var creditMethod = $(this).val();
        var oldCredit = $("#oldCreditTerm").val();
        
        // Call filterCreditTerm and then handle the dynamic element
        filterCreditTerm(oldCredit, creditMethod);
        
        // Wait for AJAX to complete and apply disabled state to dynamic element
        setTimeout(function() {
            // Check if checkbox is checked to determine disabled state
            var isChecked = $('input[name=crf_change_creditterm]').is(':checked');
            $('#crf_creditterm2').prop('disabled', !isChecked);
            
            // Update submit button state
            checkAndUpdateSubmitButton();
        }, 100);
    });
    
    // Monitor changes to credit term selects
    $(document).on('change', '#showcredit2, #crf_creditterm2', function () {
        checkAndUpdateSubmitButton();
    });
    
    // ========================================================================
    // Old Customer - Change Credit Term Main Checkbox Handler
    // ========================================================================
    
    // Control กรณีเลือกปรับ Credit term สำหรับลูกค้าเก่า
    $('input:checkbox[name="crf_sub_oldcus_changecredit"]').change(function () {
        if ($(this).prop("checked") == true) {
            // แสดงส่วนของการเปลี่ยน Credit term
            $(".change_credit").css("display", "");
            $("input[name=crf_change_creditterm]").prop("checked", true);
            $(".change_credit_detail").css("display", "");
            $("#crf_condition_credit").attr("required", "");
            
            // Keep crf_creditterm disabled (ข้อมูลจาก DB ไม่ต้องการให้แก้ไข)
            // Enable condition fields only
            $('#crf_condition_credit').prop('disabled', false);
            $('#showcredit2').prop('disabled', false);
            $('#crf_creditterm2').prop('disabled', false); // Dynamic element
            
            // Check submit button availability
            checkAndUpdateSubmitButton();
            
            // ไม่ disable crf_file1 หากมีการเลือก "เปลี่ยนที่อยู่" หรือ "แก้ไขข้อมูลลูกค้า"
            if (!$('input:checkbox[name="crf_sub_oldcus_changeaddress"]').prop("checked") && 
                !$('input:checkbox[name="crf_sub_oldcus_editcustomer"]').prop("checked")) {
                $("#crf_file1").prop("disabled", true);
            }
        } else {
            // ซ่อนส่วนของการเปลี่ยน Credit term
            $(".change_credit").css("display", "none");
            $("input[name=crf_change_creditterm]").prop("checked", false);
            $(".change_credit_detail").css("display", "none");
            
            // Disable fields
            $('#crf_creditterm').prop('disabled', true);
            $('#crf_condition_credit').prop('disabled', true);
            $('#showcredit2').prop('disabled', true);
            $('#crf_creditterm2').prop('disabled', true); // Dynamic element
        }
    });
    
});
