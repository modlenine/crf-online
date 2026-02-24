/**
 * view.js - View Data Display Controller
 * 
 * Purpose: Handle ALL display logic for view_data.php (read-only mode)
 * - Display initial state from database
 * - Show/hide sections based on saved values
 * - Handle file preview modals
 * - Person type file container visibility
 * 
 * Architecture: Phase-based structure (inspired by edit_view.js)
 * Phase 1: Initialize display state from database
 * Phase 2: Person type file containers
 * Phase 3: Section visibility (billing, payment, finance)
 * Phase 4: Modal file display handlers
 * 
 * Key Difference from edit_view.js:
 * - NO lock/unlock logic (everything already readonly)
 * - NO Union Logic (no interactive checkboxes)
 * - NO validation or AJAX
 * - ONLY display initialization
 * 
 * Migrated from: custom.js (lines 287-475)
 * Structure inspired by: edit_view.js
 * 
 * Page: view_data.php (application/modules/main/views/view_data.php)
 * Dependencies: jQuery
 * 
 * Created: 2026-02-24
 * Updated: 2026-02-24 - Refactored with phase-based structure from edit_view.js
 */

(function($) {
    'use strict';

    // ========================================================================
    // Check if we're on view_data page
    // ========================================================================
    
    $(document).ready(function() {
        
        var isViewPage = $('#forcrf_company_view').length > 0 
                        || $('#forcrf_condition_bill_view').length > 0 
                        || $('#forcrf_condition_money_view').length > 0 
                        || $('#forcrf_finance_view').length > 0;
        
        if (!isViewPage) {
            console.log('⚠ Not view_data page - view.js skipped');
            return;
        }

        console.log('=== View Data Display Controller Loaded ===');
        console.log('Initializing display state from database...');
        
        // ====================================================================
        // PHASE 1: DISPLAY INITIAL STATE FROM DATABASE
        // ====================================================================
        
        console.log('Phase 1: Setting initial display state...');
        initializeBasicDisplayState();
        
        // ====================================================================
        // PHASE 2: PERSON TYPE FILE CONTAINERS
        // ====================================================================
        
        console.log('Phase 2: Setting up person type file containers...');
        handlePersonTypeFileContainers();
        
        // ====================================================================
        // PHASE 3: CONDITIONAL SECTIONS (BILLING, PAYMENT, FINANCE)
        // ====================================================================
        
        console.log('Phase 3: Setting up conditional sections...');
        handleConditionalSections();
        
        // ====================================================================
        // PHASE 4: MODAL FILE DISPLAY HANDLERS
        // ====================================================================
        
        console.log('Phase 4: Setting up modal file display handlers...');
        setupFileModalHandlers();
        
        console.log('✓ View Data Display Controller Initialized');
        console.log('==========================================');
    });
    
    // ========================================================================
    // PHASE 1: Initialize Basic Display State
    // ========================================================================
    
    function initializeBasicDisplayState() {
        
        // ====================================================================
        // 1. Company Selection
        // ====================================================================
        
        var selectedCompany = $('#forcrf_company_view').val();
        if (selectedCompany == "sln") {
            $('input:radio[id="view_crf_company_sln"]').prop('checked', true);
        } else if (selectedCompany == "poly") {
            $('input:radio[id="view_crf_company_poly"]').prop('checked', true);
        } else if (selectedCompany == "ca") {
            $('input:radio[id="view_crf_company_ca"]').prop('checked', true);
        } else if (selectedCompany == "tb") {
            $('input:radio[id="view_crf_company_tb"]').prop('checked', true);
        } else if (selectedCompany == "st") {
            $('input:radio[id="view_crf_company_st"]').prop('checked', true);
        }
        console.log('  ✓ Company:', selectedCompany);
        console.log('  ✓ Company:', selectedCompany);
        
        // ====================================================================
        // 2. Customer Type (New/Existing Customer)
        // ====================================================================
        
        var customerType = $('#forcrf_type_view').val();
        if (customerType == 1) {
            $('input:radio[id="crf_type1_view"]').prop('checked', true);
            $('.accForcus2').css('display', '');
            console.log('  ✓ Customer Type: New');
        } else if (customerType == 2) {
            $('input:radio[id="crf_type2_view"]').prop('checked', true);
            $('.cs_br').remove();
            $('.accForcus1').css('display', 'none');
            console.log('  ✓ Customer Type: Existing');
        }
        
        // ====================================================================
        // 3. Old Customer Checkboxes (5 types)
        // ====================================================================
        
        if ($('#forcrf_sub_oldcus_changearea_view').val() == 1) {
            $('input:checkbox[id="crf_sub_oldcus_changearea_view"]').prop('checked', true);
        }
        if ($('#forcrf_sub_oldcus_changeaddress_view').val() == 2) {
            $('input:checkbox[id="crf_sub_oldcus_changeaddress_view"]').prop('checked', true);
        }
        if ($('#forcrf_sub_oldcus_changecredit_view').val() == 3) {
            $('input:checkbox[id="crf_sub_oldcus_changecredit_view"]').prop('checked', true);
            $('.change_credit_detail, .change_credit').css('display', '');
        }
        if ($('#forcrf_sub_oldcus_changefinance_view').val() == 4) {
            $('input:checkbox[id="crf_sub_oldcus_changefinance_view"]').prop('checked', true);
        }
        if ($('#forcrf_sub_oldcus_editcustomer_view').val() == 5) {
            $('input:checkbox[id="crf_sub_oldcus_editcustomer_view"]').prop('checked', true);
        }
        console.log('  ✓ Old customer checkboxes initialized');
        
        // ====================================================================
        // 4. Address Type
        // ====================================================================
        
        var addressType = $('#forcrf_addresstype_view').val();
        if (addressType == "ตาม ภ.พ.20") {
            $('input:radio[id="crf_addresstype1_view"]').prop('checked', true);
        } else if (addressType == "อื่นๆ") {
            $('input:radio[id="crf_addresstype2_view"]').prop('checked', true);
        }
        console.log('  ✓ Address Type:', addressType);
        
        // ====================================================================
        // 5. Company Type (3 variants)
        // ====================================================================
        
        var companyType = $('#forcrf_companytype_view').val();
        if (companyType == 1) {
            $('input:radio[id="crf_companytype1_view"]').prop('checked', true);
            console.log('  ✓ Company Type: ไทย 100%');
        } else if (companyType == 2) {
            $('#companytype2_view').css('display', '');
            $('input:radio[id="crf_companytype2_view"]').prop('checked', true);
            console.log('  ✓ Company Type: ต่างประเทศ 100%');
        } else if (companyType == 3) {
            $('#companytype3_view').css('display', '');
            $('input:radio[id="crf_companytype3_view"]').prop('checked', true);
            console.log('  ✓ Company Type: ร่วมทุน');
        }
        
        // ====================================================================
        // 6. Business Type
        // ====================================================================
        
        var businessType = $('#forcrf_typeofbussi_view').val();
        if (businessType == "ผู้ผลิต") {
            $('input:radio[id="crf_typeofbussi1_view"]').prop('checked', true);
            console.log('  ✓ Business Type: ผู้ผลิต');
        } else if (businessType == "ผู้ค้า") {
            $('input:radio[id="crf_typeofbussi2_view"]').prop('checked', true);
            console.log('  ✓ Business Type: ผู้ค้า');
        }
        
        // ====================================================================
        // 7. Map File Upload Display
        // ====================================================================
        
        if ($('#checkmapfile').val() == "") {
            $('#viewmapfile').css('display', 'none');
            $('#mapfilelink').attr('data-target', '');
        }
        if ($('#checkfilelink').val() == "") {
            $('#viewmapurl').css('display', 'none');
            $('#maplink').attr('href', 'javascript:void(0)').removeAttr('target');
        }
        console.log('  ✓ Map files checked');
        
        console.log('  ✓ Phase 1 Complete - Basic display state initialized');
    }
    
    // ========================================================================
    // PHASE 2: Handle Person Type File Containers
    // ========================================================================
    // Show/hide file containers based on person type from DB
    // Same logic as edit_view.js but using view_data IDs
    
    function handlePersonTypeFileContainers() {
        var personType = $('#forcrf_personal_type_view').val();
        
        console.log('  Person type from DB:', personType);
        
        if (personType == "natural") {
            // บุคคลธรรมดา
            $('input:radio[id="crf_person_type_natural"]').prop('checked', true);
            $('#view_file_juristic').css('display', 'none');
            console.log('  ✓ Showing natural person files, hiding juristic');
        } else if (personType == "juristic") {
            // นิติบุคคล
            $('input:radio[id="crf_person_type_juristic"]').prop('checked', true);
            $('#view_file_natural').css('display', 'none');
            console.log('  ✓ Showing juristic person files, hiding natural');
        } else {
            // No person type selected - hide natural (juristic may be shown by default)
            $('#view_file_natural').css('display', 'none');
            console.log('  ⚠ No person type - hiding natural files');
        }
        
        console.log('  ✓ Phase 2 Complete - Person type containers configured');
    }
    
    // ========================================================================
    // PHASE 3: Handle Conditional Sections
    // ========================================================================
    // Show/hide sections based on saved conditions (billing, payment, finance)
    
    function handleConditionalSections() {
        
        // ====================================================================
        // 1. Billing Conditions (เงื่อนไขการวางบิล)
        // ====================================================================
        
        var storedBilling = $('#forcrf_condition_bill_view').val();
        
        if (storedBilling == 'ส่งของพร้อมวางบิล') {
            $('input:radio[id="crf_condition_bill1_view"]').prop('checked', true);
            $(".crf_condition_bill2").css("display", "none");
            $(".crf_condition_bill3").css("display", "none");
            console.log('  ✓ Billing: ส่งของพร้อมวางบิล');
        } else if (storedBilling == 'วางบิลตามตาราง') {
            $('input:radio[id="crf_condition_bill2_view"]').prop('checked', true);
            $(".crf_condition_bill2").css("display", "");
            $(".crf_condition_bill3").css("display", "none");
            console.log('  ✓ Billing: วางบิลตามตาราง - showing table section');
        } else if (storedBilling == 'วางบิลทุกวันที่') {
            $('input:radio[id="crf_condition_bill3_view"]').prop('checked', true);
            $(".crf_condition_bill2").css("display", "none");
            $(".crf_condition_bill3").css("display", "");
            console.log('  ✓ Billing: วางบิลทุกวันที่ - showing date section');
        }
        
        // ====================================================================
        // 2. Payment Conditions (เงื่อนไขการรับชำระเงิน)
        // ====================================================================
        
        var storedPayment = $('#forcrf_condition_money_view').val();
        
        if (storedPayment == "โอนเงิน") {
            $('input:radio[id="crf_condition_money1_view"]').prop('checked', true);
            $(".recive_cheuqe").css("display", "none");
            console.log('  ✓ Payment: โอนเงิน');
        } else if (storedPayment == "รับเช็ค") {
            $('input:radio[id="crf_condition_money2_view"]').prop('checked', true);
            $(".recive_cheuqe").css("display", "");
            console.log('  ✓ Payment: รับเช็ค - showing cheque section');
        }
        
        // ====================================================================
        // 3. Finance Conditions (วงเงินการค้าและเงื่อนไขที่ขอเสนอ)
        // ====================================================================
        
        var storedFinance = $('#forcrf_finance_view').val();
        
        if (storedFinance == "ขอวงเงิน") {
            $('input:radio[id="crf_finance1_view"]').prop('checked', true);
            $(".finance_request_detail").css("display", "");
            $(".finance_change_detail").css("display", "none");
            $('#crf_finance_old_view, .labelcrf_finance_old_view').css('display', 'none');
            console.log('  ✓ Finance: ขอวงเงิน - showing request section');
        } else if (storedFinance == "ปรับวงเงิน") {
            $('input:radio[id="crf_finance2_view"]').prop('checked', true);
            $(".finance_request_detail").css("display", "none");
            $(".finance_change_detail").css("display", "");
            console.log('  ✓ Finance: ปรับวงเงิน - showing change section');
        }
        
        console.log('  ✓ Phase 3 Complete - Conditional sections configured');
    }
    
    // ========================================================================
    // PHASE 4: Setup File Modal Handlers
    // ========================================================================
    // Setup modal display handlers for all file previews (images & PDFs)
    // Uses efficient loop pattern from edit_view.js
    
    function setupFileModalHandlers() {
        const ATTACH_BASE_URL = '/intsys/crf/upload/';
        
        /**
         * Universal attachment preview function
         * Handles both image (jpg/png) and PDF display in modals
         */
        const previewAttachment = (triggerSelector, dataAttr, imgSelector, embedSelector) => {
            $(triggerSelector).off('click.previewAttachment').on('click.previewAttachment', function() {
                const fileName = $(this).attr(dataAttr);
                if (!fileName) {
                    return;
                }
                const fileExt = fileName.split('.').pop().toLowerCase();
                const isImage = ['jpg', 'jpeg', 'png'].indexOf(fileExt) !== -1;
                const fullPath = ATTACH_BASE_URL + fileName;
                const $img = $(imgSelector);
                const $embed = $(embedSelector);
                
                if (isImage) {
                    $img.attr('src', fullPath).show();
                    $embed.hide();
                } else {
                    $embed.attr('src', fullPath).show();
                    $img.hide();
                }
            });
        };
        
        // ====================================================================
        // File Attachments 1-6 (Document files)
        // ====================================================================
        
        previewAttachment('#datafile1', 'data_file1', '#embedshowfile1Img', '#embedshowfile1');
        previewAttachment('#datafile2', 'data_file2', '#embedshowfile2Img', '#embedshowfile2');
        previewAttachment('#datafile3', 'data_file3', '#embedshowfile3Img', '#embedshowfile3');
        previewAttachment('#datafile4', 'data_file4', '#embedshowfile4Img', '#embedshowfile4');
        previewAttachment('#datafile5', 'data_file5', '#embedshowfile5Img', '#embedshowfile5');
        previewAttachment('#datafile6', 'data_file6', '#embedshowfile6Img', '#embedshowfile6');
        console.log('  ✓ Document file preview handlers (files 1-6)');
        
        // ====================================================================
        // Billing File Attachments 7-9
        // ====================================================================
        
        previewAttachment('#tablebill', 'data_tablebill', '#embedshowfile7Img', '#embedshowfile7');
        previewAttachment('#mapbill', 'data_mapbill', '#embedshowfile8Img', '#embedshowfile8');
        previewAttachment('#mapbill2', 'data_mapbill2', '#embedshowfile9Img', '#embedshowfile9');
        console.log('  ✓ Billing file preview handlers (files 7-9)');
        
        // ====================================================================
        // Payment File Attachment 10
        // ====================================================================
        
        previewAttachment('#recive_cheuqetable', 'data_recive_cheuqetable', '#embedshowfile10Img', '#embedshowfile10');
        console.log('  ✓ Payment file preview handler (file 10)');
        
        console.log('  ✓ Phase 4 Complete - All modal handlers configured');
    }

})(jQuery);
