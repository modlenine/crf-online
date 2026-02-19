/**
 * ไฟล์สำหรับจัดการการแก้ไขข้อมูลลูกค้าเดิม (Old Customer Edit Data)
 * แยกออกมาจาก addth.js เพื่อให้จัดการและดูแลรักษาง่ายขึ้น
 * 
 * @created 2026-02-19
 */

(function ($) {
    'use strict';

    // ============================================
    // ฟังก์ชันสำหรับเปิด/ปิดการแก้ไขฟิลด์ข้อมูลพื้นฐาน
    // ============================================
    function toggleBasicInfoFields(enabled) {
        const fieldAction = enabled ? 'removeClass' : 'addClass';
        
        $("#crf_customername, #crf_cuscompanycreate, #crf_customertaxid, #crf_customerbranch")
            .prop("readonly", !enabled)
            [fieldAction]("bg-light");
        
        $("#crf_textmemo").prop("readonly", !enabled);
    }

    // ============================================
    // ฟังก์ชันสำหรับเปิด/ปิดการแก้ไขข้อมูลติดต่อ
    // ============================================
    function toggleContactFields(enabled) {
        const fields = "#crf_namecontact, #crf_telcontact, #crf_faxcontact, #crf_emailcontact, #crf_regiscost, #crf_mapurl";
        
        if (enabled) {
            $(fields).prop("readonly", false);
            $("#crf_mapfile").prop("disabled", false);
        } else {
            $(fields + ", #crf_mapfile").prop("disabled", true);
        }
    }

    // ============================================
    // ฟังก์ชันสำหรับเปิด/ปิดปุ่มแก้ไข
    // ============================================
    function toggleEditButtons(visible) {
        const display = visible ? "" : "none";
        $("#editMapFile_addpage, #editMapUrl_addpage, #editPrimanage_addpage").css("display", display);
    }

    // ============================================
    // ฟังก์ชันสำหรับเปิด/ปิดเงื่อนไขการวางบิลและการรับชำระเงิน
    // ============================================
    function toggleBillingConditions(enabled) {
        $('input:radio[name="crf_condition_bill"]').prop("disabled", !enabled);
        $('input:radio[name="crf_condition_money"]').prop("disabled", !enabled);
    }

    // ============================================
    // ฟังก์ชันสำหรับจัดการไฟล์ตามประเภทบุคคล
    // ============================================
    function handlePersonTypeFiles() {
        const personType = $('input:radio[name="crf_person_type"]:checked').val();
        
        if (personType === "natural") {
            // บุคคลธรรมดา
            $("#for_natural").show();
            $("#for_juristic").hide();
            $("#crf_file_person").prop("disabled", false);
        } else if (personType === "juristic") {
            // นิติบุคคล
            $("#for_natural").hide();
            $("#for_juristic").show();
            $("#crf_file_person").prop("disabled", true);
            
            // เปิดให้อัปโหลดไฟล์เอกสารนิติบุคคล
            $("#crf_file1, #crf_file2, #crf_file3, #crf_file4, #crf_file5, #crf_file6")
                .prop("disabled", false);
        }
    }

    // ============================================
    // ฟังก์ชันสำหรับปิดการแก้ไขไฟล์ทั้งหมด
    // ============================================
    function disableAllFiles() {
        // เรียกใช้ฟังก์ชันอัปเดตสถานะ crf_file1 (ถ้ามี)
        if (typeof updateCrfFile1Status === 'function') {
            updateCrfFile1Status();
        }
        
        // ปิดไฟล์อื่นๆ
        $("#crf_file2, #crf_file3, #crf_file4, #crf_file5, #crf_file6, #crf_file_person")
            .prop("disabled", true);
    }

    // ============================================
    // ฟังก์ชันสำหรับ Setup Edit Buttons Event Handlers
    // ============================================
    function setupEditButtonHandlers() {
        // ลบ event handlers เก่าก่อนเพื่อป้องกัน duplicate
        $("#editMapUrl_addpage").off("click").on("click", function () {
            $("#foredit1").toggle();
        });

        $("#editMapFile_addpage").off("click").on("click", function () {
            $("#foredit2").toggle();
        });

        $("#editPrimanage_addpage").off("click").on("click", function () {
            $(".newPrimanage").show();
            $("#showPrimanage").html("");
            $("#checkprimanagenull").val("1");
        });
    }

    // ============================================
    // ฟังก์ชันสำหรับ Setup Field Change Handlers
    // เมื่อมีการเปลี่ยนแปลงข้อมูล จะเปิดปุ่ม Submit
    // ============================================
    function setupFieldChangeHandlers() {
        // รายการฟิลด์ทั้งหมดที่ต้องติดตาม
        const watchedFields = [
            "#crf_namecontact",
            "#crf_customername",
            "#crf_telcontact",
            "#crf_faxcontact",
            "#crf_emailcontact",
            "#crf_regiscost",
            "#crf_mapurl",
            "#crf_mapfile",
            "#crf_file1",
            "#crf_file2",
            "#crf_file3",
            "#crf_file4",
            "#crf_file5",
            "#crf_file6"
        ].join(", ");

        // ลบ event handlers เก่าก่อนเพื่อป้องกัน duplicate
        $(watchedFields).off("change.editCustomer").on("change.editCustomer", function () {
            $("#user_submit").prop("disabled", false);
        });
    }

    // ============================================
    // ฟังก์ชันหลักสำหรับเปิดโหมดแก้ไข
    // ============================================
    function enableEditMode() {
        // เปิดให้แก้ไขข้อมูลพื้นฐาน
        toggleBasicInfoFields(true);
        
        // เปิดให้แก้ไขข้อมูลติดต่อ
        toggleContactFields(true);
        
        // แสดงปุ่มแก้ไข
        toggleEditButtons(true);
        
        // เปิดเงื่อนไขการวางบิลและการรับชำระเงิน
        toggleBillingConditions(true);
        
        // อัปเดตสถานะไฟล์
        if (typeof updateCrfFile1Status === 'function') {
            updateCrfFile1Status();
        }
        
        // Setup event handlers สำหรับปุ่มแก้ไข
        setupEditButtonHandlers();
        
        // จัดการไฟล์ตามประเภทบุคคล
        handlePersonTypeFiles();
        
        // Setup field change handlers
        setupFieldChangeHandlers();
    }

    // ============================================
    // ฟังก์ชันหลักสำหรับปิดโหมดแก้ไข
    // ============================================
    function disableEditMode() {
        // ปิดการแก้ไขข้อมูลพื้นฐาน
        toggleBasicInfoFields(false);
        
        // ปิดการแก้ไขข้อมูลติดต่อ
        toggleContactFields(false);
        
        // ซ่อนปุ่มแก้ไข
        toggleEditButtons(false);
        
        // ปิดเงื่อนไขการวางบิลและการรับชำระเงิน
        toggleBillingConditions(false);
        
        // ปิดการแก้ไขไฟล์ทั้งหมด
        disableAllFiles();
    }

    // ============================================
    // Main Event Handler
    // ============================================
    function initOldCustomerEditControl() {
        $('input:checkbox[name="crf_sub_oldcus_editcustomer"]').off("change.editCustomer").on("change.editCustomer", function () {
            if ($(this).prop("checked")) {
                enableEditMode();
            } else {
                disableEditMode();
            }
        });
    }

    // ============================================
    // Initialize เมื่อ Document Ready
    // ============================================
    $(document).ready(function () {
        initOldCustomerEditControl();
    });

    // Export functions สำหรับใช้งานภายนอก (ถ้าจำเป็น)
    window.OldCustomerEdit = {
        init: initOldCustomerEditControl,
        enableEdit: enableEditMode,
        disableEdit: disableEditMode
    };

})(jQuery);
