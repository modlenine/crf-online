/**
 * edit_view.js - Main Controller for Edit View Page
 * 
 * Purpose: Central controller for edit_view.php page
 * - Lock all fields initially (STRICT MODE)
 * - Enable only fields for selected checkboxes
 * - Implement Union Logic Pattern (same as addth.js)
 * - Credit term specific logic (checkbox control, AJAX filtering, validation)
 * - Finance specific controls
 * - Form validation before submit
 * 
 * Core Concept: Union Logic Pattern (same structure as add_th.js)
 * Step 1: Read checkbox states from hidden inputs (checkboxes are disabled in edit mode)
 * Step 2: Reset ALL fields to disabled/readonly
 * Step 3: Enable fields for EACH selected checkbox (Union logic - no conflicts)
 * Step 4: Handle special cases (file inputs based on person type)
 * Step 5: Enable memos (always available for all checkboxes)
 * 
 * This ensures multiple checkboxes work together without "fighting" each other.
 * E.g., "Change Address" + "Edit Customer" → both sets of fields are enabled.
 * 
 * Load Order:
 * 1. jQuery
 * 2. custom.js (initial state from DB)
 * 3. edit_view.js (THIS FILE - complete controller with Union Logic)
 * 
 * Page: edit_view.php
 * Dependencies: jQuery
 * 
 * Key Function: updateFieldStatesBasedOnConditions() - Core Union Logic
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
        // PHASE 1.5: HANDLE PERSON TYPE FILE CONTAINERS
        // ========================================================================
        // Show/hide file containers based on person type from DB
        // In edit mode, person type cannot be changed, so we only need to set initial state
        
        console.log('Phase 1.5: Setting up person type file containers...');
        handlePersonTypeFileContainers();
        
        // ========================================================================
        // PHASE 2: LOCK MAIN CHECKBOXES (Cannot change topics)
        // ========================================================================
        
        // DISABLED: Checkboxes now locked via onclick="return false" in PHP template
        // console.log('Phase 2: Locking main checkboxes...');
        // lockMainCheckboxes();
        
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
        $('#edit_customername').prop('readonly', true).addClass('bg-light');
        $('#edit_cuscompanycreate').prop('readonly', true).addClass('bg-light');
        $('#edit_customertaxid').prop('readonly', true).addClass('bg-light');
        $('#edit_customerbranch').prop('readonly', true).addClass('bg-light');
        $('#edit_regiscost').prop('readonly', true).addClass('bg-light');
        
        // Address & Contact Section
        $('#edit_addressname').prop('readonly', true).addClass('bg-light');
        $('#edit_namecontact').prop('readonly', true).addClass('bg-light');
        $('#edit_telcontact').prop('readonly', true).addClass('bg-light');
        $('#edit_faxcontact').prop('readonly', true).addClass('bg-light');
        $('#edit_emailcontact').prop('readonly', true).addClass('bg-light');
        $('#edit_etax_emailcontact').prop('readonly', true).addClass('bg-light');
        
        // Sales & Area Section
        $('#edit_salesreps').prop('readonly', true).addClass('bg-light');
        $('#edit_customercode').prop('readonly', true).addClass('bg-light');
        
        // Product & Forecast Section
        $('#edit_crf_customer_products').prop('readonly', true).addClass('bg-light');
        $('#edit_forecast').prop('readonly', true).addClass('bg-light');
        $('#edit_crf_textmemo').prop('readonly', true).addClass('bg-light');
        $('#crfcus_memo2_edit').prop('readonly', true).addClass('bg-light');
        
        // =====================================================================
        // 2. Radio Buttons → disabled
        // =====================================================================
        
        // Company Selection
        // DISABLED: Company radio buttons now locked via onclick="return false" in PHP template
        // $('input[name="crf_company"]').prop('disabled', true);
        
        // Company Type
        $('input[name="crf_companytype"]').prop('disabled', true);
        $('#crf_companytype2').prop('readonly', true).addClass('bg-light');
        $('#crf_companytype3_1_1, #crf_companytype3_1_2, #crf_companytype3_2_1, #crf_companytype3_2_2').prop('readonly', true).addClass('bg-light');
        
        // Business Type
        $('input[name="edit_typeofbussi"]').prop('disabled', true);
        
        // Address Type
        $('input[name="edit_addresstype"]').prop('disabled', true);
        
        // Billing Condition
        $('input[name="crf_condition_bill"]').prop('disabled', true);
        // Note: crf_datebill is NOT readonly - it's always editable when section is visible (same as add_th.php)
        
        // Payment Condition
        $('input[name="edit_condition_money"]').prop('disabled', true);
        $('#crf_recive_cheuqedetail').prop('readonly', true).addClass('bg-light');
        
        // Finance Type
        $('input[name="crf_finance"]').prop('disabled', true);
        $('#crf_finance_req_number').prop('readonly', true).addClass('bg-light');
        $('#crf_finance_status').prop('disabled', true);
        $('#crf_finance_change_status').prop('disabled', true);
        $('#crf_finance_change_number').prop('readonly', true).addClass('bg-light');
        $('#crf_finance_change_total').prop('readonly', true).addClass('bg-light');
        $('#crf_finance_change_detail').prop('readonly', true).addClass('bg-light');
        
        // =====================================================================
        // 3. Checkboxes → disabled
        // =====================================================================
        
        // Process Checkboxes
        $('input[name="crf_process[]"]').prop('disabled', true);
        
        // Credit Term Sub-Checkboxes (will be controlled by changecreditterm.js)
        $('#edit_crf_change_creditterm').prop('disabled', true);
        $('#edit_crf_change_expected_payment').prop('disabled', true);
        
        // =====================================================================
        // 4. Dropdowns/Selects → disabled
        // =====================================================================
        
        // Credit Term Dropdowns
        $('#edit_crf_creditterm').prop('disabled', true);
        $('#edit_crf_condition_credit').prop('disabled', true);
        $('#edit_showcredit2').prop('disabled', true);
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
        
        // NOTE: Expected Date Payment section is always visible (controlled by disabled state)
        // No need to hide/show section - JavaScript only controls dropdown enabled state
        
        // NOTE: Credit term dropdown is always visible in HTML (controlled by disabled state)
        // No need to show/hide - JavaScript only controls enabled state
        
        // Disable primanage add button
        $('#add_more_primanage').prop('disabled', true);
        
        console.log('  ✓ All fields locked');
    }
    
    // ========================================================================
    // Helper Function: Handle Person Type File Containers (Same as add_th.js)
    // ========================================================================
    // Show/hide file containers based on person type
    // In edit mode, person type radio is disabled, so we only set initial state
    
    function handlePersonTypeFileContainers() {
        // Read person type from hidden input (same as add_th uses for checked value)
        const personType = $('#edit_checkCusType').val();
        
        console.log('  Person type from DB:', personType);
        
        if (personType === "natural") {
            // บุคคลธรรมดา
            $("#for_natural").show();
            $("#for_juristic").hide();
            console.log('  ✓ Showing natural person files container');
        } else if (personType === "juristic") {
            // นิติบุคคล
            $("#for_natural").hide();
            $("#for_juristic").show();
            console.log('  ✓ Showing juristic person files container');
        } else {
            // No person type selected - hide both
            $("#for_natural").hide();
            $("#for_juristic").hide();
            console.log('  ⚠ No person type - hiding all file containers');
        }
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
        
        // =================================================================
        // ALWAYS ENABLE: textmemo & memo2 (all checkboxes need memo access)
        // =================================================================
        $('#edit_crf_textmemo').prop('readonly', false).removeClass('bg-light');
        $('#crfcus_memo2_edit').prop('readonly', false).removeClass('bg-light');
        console.log('  ✓ Memos always enabled');
        
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
            // Note: Detailed credit term logic is handled in Phase 5
        }
        
        // 4. ปรับวงเงิน (Change Finance)
        if (check_changefinance == '4') {
            enableFinanceFields();
        }
        
        // 5. แก้ไขข้อมูลลูกค้า (Edit Customer Data)
        if (check_editcustomerdetail == '5') {
            enableCustomerDataFields();
        }
        
        // =================================================================
        // Phase 3 Complete - Now apply Union Logic
        // =================================================================
        
        console.log('  ✓ Fields enabled for selected topics');
        
        // Apply Union Logic to ensure fields don't conflict
        // This is critical - same pattern as addth.js
        updateFieldStatesBasedOnConditions();
    }
    
    // ========================================================================
    // Enable Functions for Each Section
    // ========================================================================
    
    /**
     * Enable Area Fields (Checkbox 1: เปลี่ยนเขตการขาย)
     * - Sales Reps only
     * - textmemo, memo2 (already enabled globally)
     */
    function enableAreaFields() {
        // Sales Rep field
        $('#edit_salesreps').prop('readonly', false).removeClass('bg-light');
        console.log('    ✓ Area fields enabled (Sales Reps only)');
    }
    
    /**
     * Enable Address Fields (Checkbox 2: เปลี่ยนที่อยู่)
     * - Address type radios
     * - Address textarea
     * - All contact fields (name, tel, fax, email, e-tax email)
     * - ภพ.20 file (crf_file1) only
     * - textmemo, memo2 (already enabled globally)
     */
    function enableAddressFields() {
        // Address Type - Enable radio buttons
        $('input[name="edit_addresstype"]').prop('disabled', false);
        
        // Address & Contact Fields
        $('#edit_addressname').prop('readonly', false).removeClass('bg-light');
        $('#edit_namecontact').prop('readonly', false).removeClass('bg-light');
        $('#edit_telcontact').prop('readonly', false).removeClass('bg-light');
        $('#edit_faxcontact').prop('readonly', false).removeClass('bg-light');
        $('#edit_emailcontact').prop('readonly', false).removeClass('bg-light');
        $('#edit_etax_emailcontact').prop('readonly', false).removeClass('bg-light');
        
        // File Upload - ภพ.20 only
        $('#crf_file1').show();
        
        console.log('    ✓ Address fields enabled');
    }
    
    /**
     * Enable Credit Section (Checkbox 3: ปรับ Credit term)
     * - Credit term dropdown
     * - Credit change checkbox + condition dropdown + new credit dropdown
     * - Expected payment checkbox + dropdown
     * - textmemo, memo2 (already enabled globally)
     * 
     * NOTE: Billing & payment conditions are ONLY enabled in editcustomer (checkbox 5)
     * NOTE: Detailed credit term logic is handled in Phase 5 (setupCreditTermControls)
     */
    function enableCreditSection() {
        // Show credit term section
        $('.change_credit').show();
        
        // NOTE: Main dropdown is always visible in HTML - no need to show/hide
        // Only controlled by disabled/enabled state via checkbox
        
        // Enable credit term sub-checkboxes
        // Note: These will be further controlled in Phase 5
        $('#edit_crf_change_creditterm').prop('disabled', false);
        $('#edit_crf_change_expected_payment').prop('disabled', false);
        
        // If checkbox is already checked, enable dropdowns
        // NOTE: edit_crf_creditterm always remains disabled - never enable it
        // Otherwise, Phase 5 will handle enabling when checkbox is ticked
        if ($('#edit_crf_change_creditterm').is(':checked')) {
            $('#edit_crf_condition_credit').prop('disabled', false);
            $('#edit_showcredit2').prop('disabled', false);
        }
        
        // If expected payment checkbox is already checked, enable dropdown
        // Section is always visible - no need to show/hide
        if ($('#edit_crf_change_expected_payment').is(':checked')) {
            $('#crf_arcustdueid_edit').prop('disabled', false);
        }
        
        console.log('    ✓ Credit section enabled');
    }
    
    /**
     * Enable Finance Fields (Checkbox 4: ปรับวงเงิน)
     * - Finance type radios
     * - Finance request number (if ขอวงเงิน)
     * - Finance change controls (if ปรับวงเงิน)
     * - textmemo, memo2 (already enabled globally)
     */
    function enableFinanceFields() {
        // Finance Type Radio
        $('input[name="crf_finance"]').prop('disabled', false);
        
        // Check selected type and enable accordingly
        var selectedFinance = $('input[name="crf_finance"]:checked').val();
        
        if (selectedFinance == 'ขอวงเงิน') {
            // Show finance request section
            $('.finance_request_detail').show();
            $('#crf_finance_req_number').prop('readonly', false).removeClass('bg-light');
            $('#crf_finance_req_number_calc').prop('readonly', false).removeClass('bg-light');
        } else if (selectedFinance == 'ปรับวงเงิน') {
            // Show finance change section
            $('.finance_change_detail').show();
            $('#crf_finance_status').prop('disabled', false);
            $('#crf_finance_change_status').prop('disabled', false);
            $('#crf_finance_change_number').prop('readonly', false).removeClass('bg-light');
            $('#crf_finance_change_detail').prop('readonly', false).removeClass('bg-light');
            // Note: crf_finance_change_total is readonly (auto-calculated)
        }
        
        console.log('    ✓ Finance fields enabled');
    }
    
    /**
     * Enable Customer Data Fields (Checkbox 5: แก้ไขข้อมูลลูกค้า)
     * - Full customer profile (name, tax, branch, etc.)
     * - Contact fields ONLY (no address - must check "เปลี่ยนที่อยู่" separately)
     * - Company type & business type
     * - Primanage section (add button)
     * - All document files (file1-6)
     * - Map URL/File edit buttons (ONLY for editcustomer)
     * - Billing condition section (ONLY for editcustomer)
     * - Payment condition section (ONLY for editcustomer)
     * - Product & forecast
     * - textmemo, memo2 (already enabled globally)
     */
    function enableCustomerDataFields() {
        // =================================================================
        // Customer Profile Section
        // =================================================================
        $('#edit_customername').prop('readonly', false).removeClass('bg-light');
        $('#edit_cuscompanycreate').prop('readonly', false).removeClass('bg-light');
        $('#edit_customertaxid').prop('readonly', false).removeClass('bg-light');
        $('#edit_customerbranch').prop('readonly', false).removeClass('bg-light');
        $('#edit_regiscost').prop('readonly', false).removeClass('bg-light');
        
        // =================================================================
        // Contact Section (NO ADDRESS - address controlled by "เปลี่ยนที่อยู่" checkbox)
        // =================================================================
        $('#edit_namecontact').prop('readonly', false).removeClass('bg-light');
        $('#edit_telcontact').prop('readonly', false).removeClass('bg-light');
        $('#edit_faxcontact').prop('readonly', false).removeClass('bg-light');
        $('#edit_emailcontact').prop('readonly', false).removeClass('bg-light');
        $('#edit_etax_emailcontact').prop('readonly', false).removeClass('bg-light');
        
        // =================================================================
        // Map Edit Buttons (ONLY for editcustomer)
        // =================================================================
        $('.canEdit1, .canEdit2').show();
        
        // =================================================================
        // Company Type & Business Type
        // =================================================================
        $('input[name="crf_companytype"]').prop('disabled', false);
        $('#crf_companytype2').prop('readonly', false).removeClass('bg-light');
        $('#crf_companytype3_1_1, #crf_companytype3_1_2, #crf_companytype3_2_1, #crf_companytype3_2_2').prop('readonly', false).removeClass('bg-light');
        $('input[name="edit_typeofbussi"]').prop('disabled', false);
        
        // =================================================================
        // Primanage Section
        // =================================================================
        $('input[name="crf_primanage_dept[]"]').prop('readonly', false).removeClass('bg-light');
        $('input[name="crf_primanage_name[]"]').prop('readonly', false).removeClass('bg-light');
        $('input[name="crf_primanage_posi[]"]').prop('readonly', false).removeClass('bg-light');
        $('input[name="crf_primanage_email[]"]').prop('readonly', false).removeClass('bg-light');
        $('#add_more_primanage').prop('disabled', false);
        
        // =================================================================
        // Product & Forecast
        // =================================================================
        $('#edit_crf_customer_products').prop('readonly', false).removeClass('bg-light');
        $('#edit_forecast').prop('readonly', false).removeClass('bg-light');
        
        // =================================================================
        // Document Files (file1-6)
        // =================================================================
        $('#crf_file_person').show(); // For natural person
        $('#crf_file1, #crf_file2, #crf_file3, #crf_file4, #crf_file5, #crf_file6').show();
        
        // =================================================================
        // Billing Condition Section (ONLY for editcustomer)
        // =================================================================
        $('input[name="crf_condition_bill"]').prop('disabled', false);
        
        // Show condition detail sections if already selected
        var selectedBilling = $('input[name="crf_condition_bill"]:checked').val();
        if (selectedBilling == 'วางบิลตามตาราง') {
            $('.crf_condition_bill2edit').show();
            $('#crf_file7, #crf_file8').show();
        } else if (selectedBilling == 'วางบิลทุกวันที่') {
            $('.crf_condition_bill3').show();
            $('#crf_file9').show();
            // Note: crf_datebill is always editable when section is visible
        }
        
        // =================================================================
        // Payment Condition Section (ONLY for editcustomer)
        // =================================================================
        $('input[name="edit_condition_money"]').prop('disabled', false);
        
        var selectedPayment = $('input[name="edit_condition_money"]:checked').val();
        if (selectedPayment == 'รับเช็ค') {
            $('.recive_cheuqe').show();
            $('#crf_recive_cheuqetable').show();
            $('#crf_recive_cheuqedetail').prop('readonly', false).removeClass('bg-light');
        }
        
        console.log('    ✓ Customer data fields enabled (full access)');
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
    // PHASE 5: UNION LOGIC - Core Field Control Pattern
    // ========================================================================
    // Same concept as addth.js: Reset → Apply Union → Special Cases
    // This ensures fields are enabled ONLY for selected checkboxes
    // and multiple checkboxes work together (Union, not conflict)
    // ========================================================================
    
    console.log('Phase 5: Setting up Union Logic...');
    
    /**
     * updateFieldStatesBasedOnConditions()
     * 
     * Core function for managing field states based on selected checkboxes
     * Implements Union Logic Pattern (same as addth.js):
     * 
     * Step 1: Read checkbox states from hidden inputs (not from checkbox itself - disabled)
     * Step 2: Reset ALL fields to disabled/readonly
     * Step 3: Enable fields for EACH selected checkbox (Union logic)
     * Step 4: Handle special cases (file inputs based on person type)
     * Step 5: Enable memos (always available for all checkboxes)
     * 
     * Called whenever:
     * - Page loads (initialization)
     * - User changes checkbox sub-options (credit term, expected payment)
     * - Billing/Payment/Company type changes (to re-apply union logic)
     */
    function updateFieldStatesBasedOnConditions() {
        
        // =====================================================================
        // Step 1: Read checkbox states from hidden inputs
        // =====================================================================
        // Note: Checkboxes are disabled in edit mode, so we read from hidden inputs
        const isChangeArea = $('#check_changearea').val() == '1';
        const isChangeAddress = $('#check_changeaddress').val() == '2';
        const isChangeCredit = $('#check_changecredit').val() == '3';
        const isChangeFinance = $('#check_changefinance').val() == '4';
        const isEditCustomer = $('#check_editcustomerdetail').val() == '5';
        
        // Get person type
        const isJuristicPerson = $('#edit_checkCusType').val() === 'juristic';
        
        // If no conditions selected, return early
        if (!isChangeArea && !isChangeAddress && !isChangeCredit && !isChangeFinance && !isEditCustomer) {
            console.log('  ⚠ No conditions selected - skipping update');
            return;
        }
        
        console.log('  Conditions:', {
            changeArea: isChangeArea,
            changeAddress: isChangeAddress,
            changeCredit: isChangeCredit,
            changeFinance: isChangeFinance,
            editCustomer: isEditCustomer,
            personType: isJuristicPerson ? 'juristic' : 'natural'
        });
        
        // =====================================================================
        // Step 2: Reset ALL fields to disabled/readonly state
        // =====================================================================
        
        // Text/Textarea fields → readonly + bg-light
        $('#edit_salesreps').prop('readonly', true).addClass('bg-light');
        $('#edit_customercode').prop('readonly', true).addClass('bg-light');
        $('#edit_customername').prop('readonly', true).addClass('bg-light');
        $('#edit_cuscompanycreate').prop('readonly', true).addClass('bg-light');
        $('#edit_customertaxid').prop('readonly', true).addClass('bg-light');
        $('#edit_customerbranch').prop('readonly', true).addClass('bg-light');
        $('#edit_addressname').prop('readonly', true).addClass('bg-light');
        $('#edit_namecontact').prop('readonly', true).addClass('bg-light');
        $('#edit_telcontact').prop('readonly', true).addClass('bg-light');
        $('#edit_faxcontact').prop('readonly', true).addClass('bg-light');
        $('#edit_emailcontact').prop('readonly', true).addClass('bg-light');
        $('#edit_etax_emailcontact').prop('readonly', true).addClass('bg-light');
        $('#edit_regiscost').prop('readonly', true).addClass('bg-light');
        $('#edit_crf_customer_products').prop('readonly', true).addClass('bg-light');
        $('#edit_forecast').prop('readonly', true).addClass('bg-light');
        $('#edit_crf_textmemo').prop('readonly', true).addClass('bg-light');
        $('#crfcus_memo2_edit').prop('readonly', true).addClass('bg-light');
        
        // Map edit buttons → hide
        $('.canEdit1, .canEdit2').hide();
        
        // Radio buttons → disabled
        $('input[name="edit_addresstype"]').prop('disabled', true);
        $('input[name="crf_companytype"]').prop('disabled', true);
        $('input[name="edit_typeofbussi"]').prop('disabled', true);
        $('input[name="crf_condition_bill"]').prop('disabled', true);
        $('input[name="edit_condition_money"]').prop('disabled', true);
        $('input[name="crf_finance"]').prop('disabled', true);
        
        // Credit term fields → disabled
        $('#edit_crf_creditterm').prop('disabled', true);
        $('#edit_crf_condition_credit').prop('disabled', true);
        $('#edit_showcredit2').prop('disabled', true);
        $('#crf_arcustdueid_edit').prop('disabled', true);
        
        // Credit term sub-checkboxes → disabled
        $('#edit_crf_change_creditterm').prop('disabled', true);
        $('#edit_crf_change_expected_payment').prop('disabled', true);
        
        // Finance fields → disabled/readonly + bg-light
        $('#crf_finance_req_number').prop('readonly', true).addClass('bg-light');
        $('#crf_finance_status').prop('disabled', true);
        $('#crf_finance_change_status').prop('disabled', true);
        $('#crf_finance_change_number').prop('readonly', true).addClass('bg-light');
        $('#crf_finance_change_total').prop('readonly', true).addClass('bg-light');
        $('#crf_finance_change_detail').prop('readonly', true).addClass('bg-light');
        
        // Process checkboxes → disabled
        $('input[name="crf_process[]"]').prop('disabled', true);
        
        // Primanage fields → readonly + bg-light, add button disabled
        $('input[name="crf_primanage_dept[]"]').prop('readonly', true).addClass('bg-light');
        $('input[name="crf_primanage_name[]"]').prop('readonly', true).addClass('bg-light');
        $('input[name="crf_primanage_posi[]"]').prop('readonly', true).addClass('bg-light');
        $('input[name="crf_primanage_email[]"]').prop('readonly', true).addClass('bg-light');
        $('#add_more_primanage').prop('disabled', true);
        
        // Company type fields → disabled/readonly + bg-light
        $('#crf_companytype2').prop('readonly', true).addClass('bg-light');
        $('#crf_companytype3_1_1, #crf_companytype3_1_2, #crf_companytype3_2_1, #crf_companytype3_2_2').prop('readonly', true).addClass('bg-light');
        
        // Billing detail fields → disabled/readonly + bg-light
        $('#crf_datebill').prop('readonly', true).addClass('bg-light');
        $('#crf_recive_cheuqedetail').prop('readonly', true).addClass('bg-light');
        
        // File inputs → disabled (will be enabled in Step 4 based on conditions + person type)
        $('#crf_file_person').prop('disabled', true);
        $('#crf_file1').prop('disabled', true);
        $('#crf_file2').prop('disabled', true);
        $('#crf_file3').prop('disabled', true);
        $('#crf_file4').prop('disabled', true);
        $('#crf_file5').prop('disabled', true);
        $('#crf_file6').prop('disabled', true);
        $('#crf_file7').prop('disabled', true);
        $('#crf_file8').prop('disabled', true);
        $('#crf_file9').prop('disabled', true);
        $('#crf_mapfile_edit').prop('disabled', true);
        $('#crf_recive_cheuqetable').prop('disabled', true);
        $('#crf_mapurl_edit').prop('readonly', true).addClass('bg-light');
        
        // =====================================================================
        // Step 3: Enable fields for EACH selected checkbox (Union Logic)
        // =====================================================================
        
        // --- Condition 1: เปลี่ยนเขตการขาย (Change Area) ---
        if (isChangeArea) {
            $('#edit_salesreps').prop('readonly', false).removeClass('bg-light');
            console.log('    ✓ Area fields enabled');
        }
        
        // --- Condition 2: เปลี่ยนที่อยู่ (Change Address) ---
        if (isChangeAddress) {
            $('input[name="edit_addresstype"]').prop('disabled', false);
            $('#edit_addressname').prop('readonly', false).removeClass('bg-light');
            $('#edit_namecontact').prop('readonly', false).removeClass('bg-light');
            $('#edit_telcontact').prop('readonly', false).removeClass('bg-light');
            $('#edit_faxcontact').prop('readonly', false).removeClass('bg-light');
            $('#edit_emailcontact').prop('readonly', false).removeClass('bg-light');
            $('#edit_etax_emailcontact').prop('readonly', false).removeClass('bg-light');
            
            // File - ภพ.20 handled in Step 4 (based on person type)
            
            console.log('    ✓ Address fields enabled');
        }
        
        // --- Condition 3: ปรับ Credit term (Change Credit) ---
        if (isChangeCredit) {
            // Main dropdown stays disabled (display only - from DB)
            $('#edit_crf_creditterm').prop('disabled', true);
            
            // Enable sub-checkboxes
            $('#edit_crf_change_creditterm').prop('disabled', false);
            $('#edit_crf_change_expected_payment').prop('disabled', false);
            
            // Enable fields based on sub-checkbox state (will be handled by Phase 6)
            // If already checked, enable now
            if ($('#edit_crf_change_creditterm').is(':checked')) {
                $('#edit_crf_condition_credit').prop('disabled', false);
                $('#edit_showcredit2').prop('disabled', false);
            }
            
            if ($('#edit_crf_change_expected_payment').is(':checked')) {
                $('#crf_arcustdueid_edit').prop('disabled', false);
            }
            
            console.log('    ✓ Credit section enabled');
        }
        
        // --- Condition 4: ปรับวงเงิน (Change Finance) ---
        if (isChangeFinance) {
            $('input[name="crf_finance"]').prop('disabled', false);
            
            // Enable fields based on selected type
            var selectedFinance = $('input[name="crf_finance"]:checked').val();
            
            if (selectedFinance == 'ขอวงเงิน') {
                $('#crf_finance_req_number').prop('readonly', false).removeClass('bg-light');
            } else if (selectedFinance == 'ปรับวงเงิน') {
                $('#crf_finance_status').prop('disabled', false);
                $('#crf_finance_change_status').prop('disabled', false);
                $('#crf_finance_change_number').prop('readonly', false).removeClass('bg-light');
                $('#crf_finance_change_detail').prop('readonly', false).removeClass('bg-light');
                // Note: crf_finance_change_total is readonly (auto-calculated)
            }
            
            console.log('    ✓ Finance fields enabled');
        }
        
        // --- Condition 5: แก้ไขข้อมูลลูกค้า (Edit Customer Data) ---
        if (isEditCustomer) {
            // Customer code (edit page specific)
            $('#edit_customercode').prop('readonly', false).removeClass('bg-light');
            
            // Basic info
            $('#edit_customername').prop('readonly', false).removeClass('bg-light');
            $('#edit_cuscompanycreate').prop('readonly', false).removeClass('bg-light');
            $('#edit_customertaxid').prop('readonly', false).removeClass('bg-light');
            $('#edit_customerbranch').prop('readonly', false).removeClass('bg-light');
            
            // Contact info
            $('#edit_namecontact').prop('readonly', false).removeClass('bg-light');
            $('#edit_telcontact').prop('readonly', false).removeClass('bg-light');
            $('#edit_faxcontact').prop('readonly', false).removeClass('bg-light');
            $('#edit_emailcontact').prop('readonly', false).removeClass('bg-light');
            $('#edit_etax_emailcontact').prop('readonly', false).removeClass('bg-light');
            $('#edit_regiscost').prop('readonly', false).removeClass('bg-light');
            
            // Map URL - use mapurl edit input (hidden by default, shown via edit button)
            $('#crf_mapurl_edit').prop('readonly', false).removeClass('bg-light');
            $('#crf_mapfile_edit').prop('disabled', false);
            
            // Address type - DISABLED: Address fields should only be unlocked with "เปลี่ยนที่อยู่" checkbox
            // $('input[name="edit_addresstype"]').prop('disabled', false);
            // $('#edit_addressname').prop('readonly', false).removeClass('bg-light');
            
            // Company Type & Business Type
            $('input[name="crf_companytype"]').prop('disabled', false);
            $('#crf_companytype2').prop('readonly', false).removeClass('bg-light');
            $('#crf_companytype3_1_1, #crf_companytype3_1_2, #crf_companytype3_2_1, #crf_companytype3_2_2').prop('readonly', false).removeClass('bg-light');
            $('input[name="edit_typeofbussi"]').prop('disabled', false);
            
            // Process checkboxes
            $('input[name="crf_process[]"]').prop('disabled', false);
            
            // Primanage section
            $('input[name="crf_primanage_dept[]"]').prop('readonly', false).removeClass('bg-light');
            $('input[name="crf_primanage_name[]"]').prop('readonly', false).removeClass('bg-light');
            $('input[name="crf_primanage_posi[]"]').prop('readonly', false).removeClass('bg-light');
            $('input[name="crf_primanage_email[]"]').prop('readonly', false).removeClass('bg-light');
            $('#add_more_primanage').prop('disabled', false);
            
            // Product & Forecast
            $('#edit_crf_customer_products').prop('readonly', false).removeClass('bg-light');
            $('#edit_forecast').prop('readonly', false).removeClass('bg-light');
            
            // Billing conditions (radio buttons)
            $('input:radio[name="crf_condition_bill"]').prop('disabled', false);
            $('input:radio[name="edit_condition_money"]').prop('disabled', false);
            
            // Billing detail fields (enable all - specific sections shown/hidden by radio handlers)
            $('#crf_datebill').prop('readonly', false).removeClass('bg-light');
            $('#crf_file9').prop('disabled', false);
            $('#crf_recive_cheuqetable').prop('disabled', false);
            $('#crf_recive_cheuqedetail').prop('readonly', false).removeClass('bg-light');
            
            // Files based on person type handled in Step 4 below
            // Memos handled in Step 5 (always enabled for all checkboxes)
            
            console.log('    ✓ Customer data fields enabled');
        }
        
        // =====================================================================
        // Step 4: Handle Special Cases (File inputs based on person type)
        // =====================================================================
        // Same pattern as add_th.js: Files enabled based on conditions + person type
        
        // File handling ตามประเภทบุคคล
        if (isJuristicPerson) {
            // นิติบุคคล
            if (isChangeAddress) {
                $('#crf_file1').prop('disabled', false); // ภพ.20
            }
            
            if (isEditCustomer) {
                // เปิดไฟล์เอกสารนิติบุคคลทั้งหมด
                $('#crf_file1').prop('disabled', false);
                $('#crf_file2').prop('disabled', false);
                $('#crf_file3').prop('disabled', false);
                $('#crf_file4').prop('disabled', false);
                $('#crf_file5').prop('disabled', false);
                $('#crf_file6').prop('disabled', false);
                
                // Billing files (for juristic person)
                $('#crf_file7').prop('disabled', false); // ตารางวางบิล
                $('#crf_file8').prop('disabled', false); // แผนที่วางบิล
            }
        } else {
            // บุคคลธรรมดา
            if (isEditCustomer) {
                $('#crf_file_person').prop('disabled', false); // สำเนาบัตรประชาชน
            }
        }
        
        // ซ่อน/แสดง edit buttons ถ้าเลือก "แก้ไขข้อมูลลูกค้า"
        if (isEditCustomer) {
            $('.canEdit1, .canEdit2').show();
            $('#editMapFile, #editMapUrl').show();
        } else {
            $('.canEdit1, .canEdit2').hide();
            $('#editMapFile, #editMapUrl').hide();
        }
        
        console.log('  ✓ Step 4: Special cases handled');
        
        // =====================================================================
        // Step 5: ALWAYS enable memos (all checkboxes need memo access)
        // =====================================================================
        $('#edit_crf_textmemo').prop('readonly', false).removeClass('bg-light');
        $('#crfcus_memo2_edit').prop('readonly', false).removeClass('bg-light');
        
        console.log('  ✓ Step 5: Memos enabled');
        console.log('  ✓ Union Logic fully applied');
    }
    
    // ========================================================================
    // PHASE 6: CREDIT TERM SPECIFIC CONTROLS
    // ========================================================================
    // Specialized logic for Credit Term section
    // - Handles credit term checkbox logic with DISABLED/ENABLED pattern
    // - Handles expected date payment checkbox logic
    // - AJAX for filtering credit terms
    // - Validation for credit term changes
    // ========================================================================
    
    console.log('Phase 6: Setting up credit term controls...');
    setupCreditTermControls();
    
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
    
    /**
     * Setup Credit Term Controls
     * Handles credit term and expected payment checkbox logic
     */
    function setupCreditTermControls() {
        
        // Check if main "ปรับ Credit term" checkbox is selected
        var isChangeCreditSelected = $('#check_changecredit').val() == '3';
        
        if (!isChangeCreditSelected) {
            console.log('    ✓ Credit term fields disabled (main checkbox not selected)');
        } else {
            console.log('    ✓ Credit term section enabled (main checkbox selected)');
            console.log('    ℹ Main dropdown controlled by "ปรับ Credit term" checkbox');
        }
        
        // =====================================================================
        // Credit Term Checkbox Control (Disabled/Enabled pattern)
        // =====================================================================
        
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
        
        // =====================================================================
        // Page Load Initialization - Enable fields if checkboxes are checked
        // =====================================================================
        
        // Only initialize if main checkbox (changecredit) is selected
        if (isChangeCreditSelected) {
            // Initialize Expected Date Payment field state
            if ($('#edit_crf_change_expected_payment').is(':checked')) {
                $('#crf_arcustdueid_edit').prop('disabled', false);
                console.log('    ✓ Expected date payment enabled (checkbox checked)');
            } else {
                $('#crf_arcustdueid_edit').prop('disabled', true);
            }
            
            // Initialize Credit Term Change field state
            // NOTE: edit_crf_creditterm always remains disabled
            if ($('#edit_crf_change_creditterm').is(':checked')) {
                // Enable condition + showcredit2 only (not main dropdown)
                $('#edit_crf_condition_credit').prop('disabled', false);
                $('#edit_showcredit2').prop('disabled', false);
                console.log('    ✓ Credit term change enabled (checkbox checked)');
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
        
        // =====================================================================
        // Finance Specific Controls
        // =====================================================================
        
        $('input[name="crf_finance"]').change(function() {
            if ($(this).val() == 'ปรับวงเงิน') {
                $('.finance_change_detail').show();
                // Re-apply union logic to enable fields properly
                updateFieldStatesBasedOnConditions();
            } else if ($(this).val() == 'ขอวงเงิน') {
                $('.finance_change_detail').hide();
                // Re-apply union logic to enable fields properly
                updateFieldStatesBasedOnConditions();
            }
        });
        
        // =====================================================================
        // Form Validation Before Submit
        // =====================================================================
        
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
        
        console.log('    ✓ Credit term controls initialized');
    }
    
    // ========================================================================
    // PHASE 7: ADDITIONAL EVENT HANDLERS  
    // ========================================================================
    // Handle events that should trigger Union Logic re-application
    // ========================================================================
    
    console.log('Phase 7: Setting up additional event handlers...');
    
    // Billing Condition Changes - Re-apply union logic to show/hide sections
    $('input:radio[name="crf_condition_bill"]').on('change', function() {
        // Let updateFieldStatesBasedOnConditions handle field states
        updateFieldStatesBasedOnConditions();
        console.log('  ✓ Billing condition changed, union logic reapplied');
    });
    
    // Payment Condition Changes - Re-apply union logic to show/hide sections
    $('input:radio[name="edit_condition_money"]').on('change', function() {
        // Let updateFieldStatesBasedOnConditions handle field states
        updateFieldStatesBasedOnConditions();
        console.log('  ✓ Payment condition changed, union logic reapplied');
    });
    
    // Company Type Changes - May affect which files are shown
    $('input:radio[name="crf_companytype"]').on('change', function() {
        updateFieldStatesBasedOnConditions();
        console.log('  ✓ Company type changed, union logic reapplied');
    });
    
    console.log('  ✓ Additional event handlers initialized');
    console.log('==========================================');
    console.log('✅ Edit View Controller Fully Initialized with Union Logic');
    console.log('==========================================');
    
    // ========================================================================
    // Expose functions globally for other modules if needed
    // ========================================================================
    
    window.EditView = {
        lockAllFields: lockAllEditableFields,
        enableAreaFields: enableAreaFields,
        enableAddressFields: enableAddressFields,
        enableCreditSection: enableCreditSection,
        enableFinanceFields: enableFinanceFields,
        enableCustomerDataFields: enableCustomerDataFields,
        updateFieldStates: updateFieldStatesBasedOnConditions  // ⭐ Core Union Logic function
    };

})(jQuery);
