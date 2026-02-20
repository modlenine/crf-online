/**
 * edit_view.js - Main Controller for Edit View Page
 * 
 * Purpose: Central controller for edit_view.php page
 * - Lock all fields initially (STRICT MODE)
 * - Enable only fields for selected checkboxes
 * - Coordinate with specialized modules
 * 
 * Load Order:
 * 1. jQuery
 * 2. custom.js (initial state from DB)
 * 3. edit_view.js (THIS FILE - locks everything)
 * 4. edit_changecreditterm.js (credit term specific logic)
 */

(function($) {
    'use strict';

    // ========================================================================
    // Check if we're on edit page
    // ========================================================================
    
    $(document).ready(function() {
        
        var isEditPage = $('#check_EditFormNo').length > 0;
        if (!isEditPage) {
            console.log('⚠ Not edit page - edit_view.js skipped');
            return;
        }

        console.log('=== Edit View Main Controller Loaded ===');
        
        // ========================================================================
        // PHASE 1: LOCK ALL FIELDS (Strict Mode)
        // ========================================================================
        
        console.log('Phase 1: Locking all editable fields...');
        lockAllEditableFields();
        
        // ========================================================================
        // PHASE 2: LOCK MAIN CHECKBOXES (Cannot change topics)
        // ========================================================================
        
        console.log('Phase 2: Locking main checkboxes...');
        lockMainCheckboxes();
        
        // ========================================================================
        // PHASE 3: ENABLE FIELDS FOR SELECTED CHECKBOXES
        // ========================================================================
        
        console.log('Phase 3: Enabling fields for selected topics...');
        enableFieldsForSelectedTopics();
        
        console.log('✓ Edit View Controller Initialized');
        console.log('==========================================');
    });
    
    // ========================================================================
    // Helper Function: Lock All Editable Fields
    // ========================================================================
    
    function lockAllEditableFields() {
        
        // =====================================================================
        // 1. Text/Textarea Fields → readonly
        // =====================================================================
        
        // Customer Profile Section
        $('#edit_customername').prop('readonly', true);
        $('#edit_cuscompanycreate').prop('readonly', true);
        $('#edit_customertaxid').prop('readonly', true);
        $('#edit_customerbranch').prop('readonly', true);
        $('#edit_regiscost').prop('readonly', true);
        
        // Address & Contact Section
        $('#edit_addressname').prop('readonly', true);
        $('#edit_namecontact').prop('readonly', true);
        $('#edit_telcontact').prop('readonly', true);
        $('#edit_faxcontact').prop('readonly', true);
        $('#edit_emailcontact').prop('readonly', true);
        $('#edit_etax_emailcontact').prop('readonly', true);
        
        // Sales & Area Section
        $('#edit_salesreps').prop('readonly', true);
        $('#edit_customercode').prop('readonly', true);
        
        // Product & Forecast Section
        $('#edit_crf_customer_products').prop('readonly', true);
        $('#edit_forecast').prop('readonly', true);
        $('#edit_crf_textmemo').prop('readonly', true);
        $('#crfcus_memo2_edit').prop('readonly', true);
        
        // =====================================================================
        // 2. Radio Buttons → disabled
        // =====================================================================
        
        // Company Selection
        $('input[name="crf_company"]').prop('disabled', true);
        
        // Company Type
        $('input[name="crf_companytype"]').prop('disabled', true);
        $('#crf_companytype2').prop('readonly', true);
        $('#crf_companytype3_1_1, #crf_companytype3_1_2, #crf_companytype3_2_1, #crf_companytype3_2_2').prop('readonly', true);
        
        // Business Type
        $('input[name="edit_typeofbussi"]').prop('disabled', true);
        
        // Address Type
        $('input[name="edit_addresstype"]').prop('disabled', true);
        
        // Billing Condition
        $('input[name="crf_condition_bill"]').prop('disabled', true);
        $('#crf_datebill').prop('readonly', true);
        
        // Payment Condition
        $('input[name="edit_condition_money"]').prop('disabled', true);
        $('#crf_recive_cheuqedetail').prop('readonly', true);
        
        // Finance Type
        $('input[name="crf_finance"]').prop('disabled', true);
        $('#crf_finance_req_number').prop('readonly', true);
        $('#crf_finance_status').prop('disabled', true);
        $('#crf_finance_change_status').prop('disabled', true);
        $('#crf_finance_change_number').prop('readonly', true);
        $('#crf_finance_change_total').prop('readonly', true);
        $('#crf_finance_change_detail').prop('readonly', true);
        
        // =====================================================================
        // 3. Checkboxes → disabled
        // =====================================================================
        
        // Process Checkboxes
        $('input[name="crf_process[]"]').prop('disabled', true);
        
        // Credit Term Sub-Checkboxes (will be controlled by changecreditterm.js)
        $('#crf_change_creditterm').prop('disabled', true);
        $('#crf_change_expected_payment').prop('disabled', true);
        
        // =====================================================================
        // 4. Dropdowns/Selects → disabled
        // =====================================================================
        
        // Credit Term Dropdowns
        $('#crf_creditterm').prop('disabled', true);
        $('#crf_condition_credit').prop('disabled', true);
        $('#showcredit2').prop('disabled', true);
        $('#crf_arcustdueid_edit').prop('disabled', true);
        
        // =====================================================================
        // 5. File Uploads → hidden
        // =====================================================================
        
        // Customer Files
        $('#crf_file_person').hide();
        $('#crf_file1, #crf_file2, #crf_file3, #crf_file4, #crf_file5, #crf_file6').hide();
        
        // Billing Files
        $('#crf_file7, #crf_file8, #crf_file9').hide();
        
        // Payment Files
        $('#crf_recive_cheuqetable').hide();
        
        // Map Files
        $('.canEdit1, .canEdit2').hide();
        
        // =====================================================================
        // 6. Special Controls
        // =====================================================================
        
        // Hide Expected Date Payment section (will be shown if checkbox is checked)
        $('.expected_payment_section').hide();
        
        // Hide credit term display (show readonly instead)
        $('#crf_creditterm').hide();
        $('#showCreditname').show();
        
        // Disable primanage add button
        $('#add_more_primanage').prop('disabled', true);
        
        console.log('  ✓ All fields locked');
    }
    
    // ========================================================================
    // Helper Function: Lock Main Checkboxes
    // ========================================================================
    
    function lockMainCheckboxes() {
        
        // Checked state already set by PHP in edit_view.php
        // Just disable the checkboxes here
        $('input[name="crf_sub_oldcus_changearea"]').prop('disabled', true);
        $('input[name="crf_sub_oldcus_changeaddress"]').prop('disabled', true);
        $('input[name="crf_sub_oldcus_editcustomer"]').prop('disabled', true);
        $('input[name="crf_sub_oldcus_changecredit"]').prop('disabled', true);
        $('input[name="crf_sub_oldcus_changefinance"]').prop('disabled', true);
        
        console.log('  ✓ Main checkboxes locked (checked state from PHP)');
    }
    
    // ========================================================================
    // Helper Function: Enable Fields For Selected Topics
    // ========================================================================
    
    function enableFieldsForSelectedTopics() {
        
        // Get selected topics from hidden inputs
        var check_changearea = $('#check_changearea').val();
        var check_changeaddress = $('#check_changeaddress').val();
        var check_changecredit = $('#check_changecredit').val();
        var check_changefinance = $('#check_changefinance').val();
        var check_editcustomerdetail = $('#check_editcustomerdetail').val();
        
        console.log('  Initial States:', {
            changearea: check_changearea,
            changeaddress: check_changeaddress,
            changecredit: check_changecredit,
            changefinance: check_changefinance,
            editcustomer: check_editcustomerdetail
        });
        
        // Enable fields based on selected topics
        
        // 1. เปลี่ยนเขตการขาย (Change Area)
        if (check_changearea == '1') {
            enableAreaFields();
        }
        
        // 2. เปลี่ยนที่อยู่ (Change Address)
        if (check_changeaddress == '2') {
            enableAddressFields();
        }
        
        // 3. ปรับ Credit term (Change Credit)
        if (check_changecredit == '3') {
            enableCreditSection();
            // Note: Detailed credit term logic is handled by edit_changecreditterm.js
        }
        
        // 4. ปรับวงเงิน (Change Finance)
        if (check_changefinance == '4') {
            enableFinanceFields();
        }
        
        // 5. แก้ไขข้อมูลลูกค้า (Edit Customer Data)
        if (check_editcustomerdetail == '5') {
            enableCustomerDataFields();
        }
        
        console.log('  ✓ Fields enabled for selected topics');
    }
    
    // ========================================================================
    // Enable Functions for Each Section
    // ========================================================================
    
    function enableAreaFields() {
        // Sales Rep field
        $('#edit_salesreps, #crf_salesreps').prop('readonly', false);
        console.log('    ✓ Area fields enabled');
    }
    
    function enableAddressFields() {
        // Address Type - Enable radio buttons and unlock onclick
        $('input[name="edit_addresstype"], input[name="crf_addresstype"]').prop('disabled', false);
        $('input[name="edit_addresstype"], input[name="crf_addresstype"]').attr('onclick', ''); // Remove onclick=false
        
        // Address & Contact Fields
        $('#edit_addressname, #crf_addressname').prop('readonly', false);
        $('#edit_namecontact, #crf_namecontact').prop('readonly', false);
        $('#edit_telcontact, #crf_telcontact').prop('readonly', false);
        $('#edit_faxcontact, #crf_faxcontact').prop('readonly', false);
        $('#edit_emailcontact, #crf_emailcontact').prop('readonly', false);
        $('#edit_etax_emailcontact, #crf_etax_emailcontact').prop('readonly', false);
        
        // File Upload
        $('#crf_file1').show();
        
        console.log('    ✓ Address fields enabled');
    }
    
    function enableCreditSection() {
        // Show credit term section
        $('.change_credit').show();
        $('.change_credit_detail').show();
        
        // Enable credit term sub-checkboxes
        // Note: These will be further controlled by edit_changecreditterm.js
        $('#crf_change_creditterm').prop('disabled', false);
        $('#crf_change_expected_payment').prop('disabled', false);
        
        // Show expected payment section if checkbox is already checked
        if ($('#crf_change_expected_payment').is(':checked')) {
            $('.expected_payment_section').show();
        }
        
        // Enable billing & payment conditions (always needed for credit)
        $('input[name="crf_condition_bill"]').prop('disabled', false);
        $('input[name="edit_condition_money"]').prop('disabled', false);
        
        // Show condition detail sections if already selected
        var selectedBilling = $('input[name="crf_condition_bill"]:checked').val();
        if (selectedBilling == 'วางบิลตามตาราง') {
            $('.crf_condition_bill2edit').show();
            $('#crf_file7, #crf_file8').show();
        } else if (selectedBilling == 'วางบิลทุกวันที่') {
            $('.crf_condition_bill3').show();
            $('#crf_datebill').prop('readonly', false);
            $('#crf_file9').show();
        }
        
        var selectedPayment = $('input[name="edit_condition_money"]:checked').val();
        if (selectedPayment == 'รับเช็ค') {
            $('.recive_cheuqe').show();
            $('#crf_recive_cheuqetable').show();
            $('#crf_recive_cheuqedetail').prop('readonly', false);
        }
        
        console.log('    ✓ Credit section enabled');
    }
    
    function enableFinanceFields() {
        // Finance Type Radio
        $('input[name="crf_finance"]').prop('disabled', false);
        
        // Finance Request Number
        $('#crf_finance_req_number').prop('readonly', false);
        $('#crf_finance_req_number_calc').prop('readonly', false);
        
        // Check selected type and enable accordingly
        var selectedFinance = $('input[name="crf_finance"]:checked').val();
        
        if (selectedFinance == 'ขอวงเงิน') {
            $('.finance_request_detail').show();
        } else if (selectedFinance == 'ปรับวงเงิน') {
            $('.finance_change_detail').show();
            $('#crf_finance_status').prop('disabled', false);
            $('#crf_finance_change_status').prop('disabled', false);
            $('#crf_finance_change_number').prop('readonly', false);
            $('#crf_finance_change_detail').prop('readonly', false);
        }
        
        console.log('    ✓ Finance fields enabled');
    }
    
    function enableCustomerDataFields() {
        // Customer Name
        $('#edit_customername, #crf_customername').prop('readonly', false);
        
        // Contact Info
        $('#edit_namecontact, #crf_namecontact').prop('readonly', false);
        $('#edit_telcontact, #crf_telcontact').prop('readonly', false);
        $('#edit_faxcontact, #crf_faxcontact').prop('readonly', false);
        $('#edit_emailcontact, #crf_emailcontact').prop('readonly', false);
        $('#edit_etax_emailcontact, #crf_etax_emailcontact').prop('readonly', false);
        
        // Files (including billing/payment files for edit customer data)
        $('#crf_file1, #crf_file2, #crf_file3, #crf_file4, #crf_file5, #crf_file6').show();
        $('#crf_file7, #crf_file8, #crf_file9').show();
        $('#crf_recive_cheuqetable').show();
        
        // Company Data
        $('#edit_regiscost, #crf_regiscost').prop('readonly', false);
        
        // Map Edit
        $('.canEdit1, .canEdit2').show();
        
        // Primanage
        $('#add_more_primanage').prop('disabled', false);
        
        console.log('    ✓ Customer data fields enabled');
    }
    
    // ========================================================================
    // PHASE 4: MODAL FILE DISPLAY HANDLERS
    // ========================================================================
    
    console.log('Phase 4: Setting up modal file display handlers...');
    setupEditFileModalHandlers();
    
    /**
     * Setup modal handlers for all edit page file displays
     * Handles image/PDF selection and modal population
     */
    function setupEditFileModalHandlers() {
        var base_url = $('body').data('base-url') || window.location.origin + '/intsys/crf/';
        var uploadUrl = base_url + 'upload/';
        
        // Personal file modal handler
        $('#edit_datafilePersonal').click(function() {
            var dataFile = $(this).attr('data_editfilepersonal');
            var fileExt = dataFile.substr(-3, 4).toLowerCase();
            
            if (fileExt == 'jpg' || fileExt == 'png') {
                $('#embedshow_editfilePersonalImg').attr('src', uploadUrl + dataFile).show();
                $('#embedshow_editfilePersonal').hide();
            } else {
                $('#embedshow_editfilePersonal').attr('src', uploadUrl + dataFile).show();
                $('#embedshow_editfilePersonalImg').hide();
            }
        });
        
        // File 1-9 modal handlers (loop through for efficiency)
        for (var i = 1; i <= 9; i++) {
            (function(fileNum) {
                $('#edit_datafile' + fileNum).click(function() {
                    var dataFile = $(this).attr('data_editfile' + fileNum);
                    var fileExt = dataFile.substr(-3, 4).toLowerCase();
                    
                    if (fileExt == 'jpg' || fileExt == 'png') {
                        $('#embedshow_editfile' + fileNum + 'Img').attr('src', uploadUrl + dataFile).show();
                        $('#embedshow_editfile' + fileNum).hide();
                    } else {
                        $('#embedshow_editfile' + fileNum).attr('src', uploadUrl + dataFile).show();
                        $('#embedshow_editfile' + fileNum + 'Img').hide();
                    }
                });
            })(i);
        }
        
        console.log('    ✓ Modal file display handlers configured');
    }
    
    // ========================================================================
    // Expose functions globally for other modules if needed
    // ========================================================================
    
    window.EditView = {
        lockAllFields: lockAllEditableFields,
        enableAreaFields: enableAreaFields,
        enableAddressFields: enableAddressFields,
        enableCreditSection: enableCreditSection,
        enableFinanceFields: enableFinanceFields,
        enableCustomerDataFields: enableCustomerDataFields
    };

})(jQuery);
