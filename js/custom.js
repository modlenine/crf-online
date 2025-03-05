$(document).ready(function () {
    // แก้ไขใหม่ ค่าตั้งต้น
    //  Config permission
    if ($('#checkPageAddTH').val() == "addTH") {

        $('input:radio[name="crf_type"]').change(function () {
            if ($(this).val() == 1) {

                $('#crf_customercode , #crf_cusid , #crf_customername , #crf_cuscompanycreate , #crf_customertaxid , #crf_customerbranch , #crf_addressname , #crf_namecontact , #crf_telcontact , #crf_faxcontact , #crf_emailcontact , #crf_regiscost , #crf_mapurl , #crf_mapfile , #crf_customer_product , #crf_forecast , #crf_file1 ,#crf_file2 , #crf_file3 , #crf_file4 , #crf_file5 , #crf_file6 , #crf_finance_req_number , #oldCreditTerm , #crf_creditterm').val('');

                $('#crf_salesreps').val($('#crf_userecodepost').val())

                $('#crf_customercode').prop('disabled', true);
                $('.crf_condition_bill2 , .crf_condition_bill3').css('display', 'none');

                $('input:radio[name="crf_addresstype"]').prop('checked', false);
                $('input:radio[name="crf_companytype"]').prop('checked', false);
                $('input:radio[name="crf_typeofbussi"]').prop('checked', false);
                $('input:radio[name="crf_condition_bill"]').prop('checked', false);
                $('input:radio[name="crf_condition_money"]').prop('checked', false);
                $('input:radio[class="crf_financev1"]').prop('checked', true);

                $('input:checkbox').prop('checked', false);
                $('.suboldcustomer').css('display', 'none');
            } else if ($(this).val() == 2) {
                $('#crf_customercode , #crf_cusid , #crf_salesreps , #crf_customername , #crf_cuscompanycreate , #crf_customertaxid , #crf_customerbranch , #crf_addressname , #crf_namecontact , #crf_telcontact , #crf_faxcontact , #crf_emailcontact , #crf_regiscost , #crf_mapurl , #crf_mapfile , #crf_customer_product , #crf_forecast , #crf_file1 ,#crf_file2 , #crf_file3 , #crf_file4 , #crf_file5 , #crf_file6 ,  #crf_finance_req_number ,#oldCreditTerm').val('');

                $('#crf_customercode').prop('disabled', false);

                $('input:radio[name="crf_addresstype"]').prop('checked', false);
                $('input:radio[name="crf_companytype"]').prop('checked', false);
                $('input:radio[name="crf_typeofbussi"]').prop('checked', false);
                $('input:radio[name="crf_condition_bill"]').prop('checked', false);
                $('input:radio[name="crf_condition_money"]').prop('checked', false);
                $('input:radio[name="crf_finance"]').prop('checked', false);

                $('#crf_textmemo').prop('readonly', true);
            }
        });

    }

    if ($('#checkPageAddTH').val() == "addTH") {

        // ช่องประเภทลูกค้า
        $('input:radio[name="crf_type"]').prop('disabled', true);

        // ช่อง Sales reps
        $('#crf_salesreps').prop('disabled', true);

        // ชื่อลูกค้า
        $('#crf_customername').prop('disabled', true);

        // วันที่ก่อตั้ง
        $('#crf_cuscompanycreate').prop('disabled', true);

        // เลขผู้เสียภาษี
        $('#crf_customertaxid').prop('disabled', true);

        // สาขา
        $('#crf_customerbranch').prop('disabled', true);

        // ประเภทที่อยู่
        $('input:radio[name="crf_addresstype"]').prop('disabled', true);
        $('#crf_addressname').prop('disabled', true);

        // ผู้ติดต่อ
        $('#crf_namecontact').prop('disabled', true);

        // เบอร์โทรของผู้ติดต่อ
        $('#crf_telcontact').prop('disabled', true);

        // เบอร์แฟ็ก
        $('#crf_faxcontact').prop('disabled', true);

        // Email
        $('#crf_emailcontact').prop('disabled', true);

        // ทุนจดทะเบียน
        $('#crf_regiscost').prop('disabled', true);

        // แผนที่ลิ้งจาก google
        $('#crf_mapurl').prop('disabled', true);

        // แผนที่ไฟล์อัพโหลด
        $('#crf_mapfile').prop('disabled', true);

        // ประเภทบริษัท
        $('input:radio[name="crf_companytype"]').prop('disabled', true);

        // ประเภทของธุรกิจ
        $('input:radio[name="crf_typeofbussi"]').prop('disabled', true);

        // ผลิตภัณฑ์ของลูกค้า
        $('#crf_customer_product').prop('disabled', true);

        // การคาดการ
        $('#crf_forecast').prop('disabled', true);

        // ไฟล์1
        $('#crf_file1').prop('disabled', true);

        // ไฟล์1
        $('#crf_file2').prop('disabled', true);

        // ไฟล์1
        $('#crf_file3').prop('disabled', true);

        // ไฟล์1
        $('#crf_file4').prop('disabled', true);

        // ไฟล์1
        $('#crf_file5').prop('disabled', true);

        // ไฟล์1
        $('#crf_file6').prop('disabled', true);

        // credit term
        $('#crf_creditterm').prop('disabled', true);

        // เงื่อนไขการวางบิล
        $('input:radio[name="crf_condition_bill"]').prop('disabled', true);


        // เงื่อนไขการรับชำระเงิน
        $('input:radio[name="crf_condition_money"]').prop('disabled', true);

        // วงเงินการค้า
        $('input:radio[name="crf_finance"]').prop('disabled', true);

        // ปุ่ม Submit
        $('#user_submit').prop('disabled', true);


        // เช็คหลังกดเลือกบริษัท
        $('input:radio[name="crf_company"]').change(function () {
            if ($(this).val() != '') {
                // ช่องประเภทลูกค้า
                $('input:radio[name="crf_type"]').prop('disabled', false);
                console.log($(this).val());
                getCusProcess($(this).val());
            } else {
                $('input:radio[name="crf_type"]').prop('disabled', true);
            }
        });




        //Control Radio crf_type Control หัวข้อ ลูกค้าใหม่ , ลูกค้าเดิม //Control Radio crf_type Control หัวข้อ ลูกค้าใหม่ , ลูกค้าเดิม
        //Control Radio crf_type Control หัวข้อ ลูกค้าใหม่ , ลูกค้าเดิม //Control Radio crf_type Control หัวข้อ ลูกค้าใหม่ , ลูกค้าเดิม

        $('.suboldcustomer').css('display', 'none');


            ///////////////////////////////////////////////////////////
            /////////Zone Click เลือกลูกค้าใหม่ และ ลูกค้าเดิม
            //////////////////////////////////////////////////////////
        $('input[name=crf_type]').change(function () {
            $('#checkCompany').val($(this).val());
            $('#checkCusType').val($(this).val());



            // Check การเลือกบริษัท หากไม่ได้เลือกจะไม่สามารถไป Step ต่อไปได้
            var crf_company = $('input[type="radio"][name=crf_company]:checked');
            if (crf_company.length < 1) {
                $('#alert_company').html('<div class="alert alert-danger" role="alert">กรุณาเลือกบริษัทด้วยค่ะ</div>');;
                $('input[name=crf_type]').prop('checked', false);
                exit;
            } else {
                $('#alert_company').fadeOut();
            }
            // Check การเลือกบริษัท หากไม่ได้เลือกจะไม่สามารถไป Step ต่อไปได้

            //Control credit term
            // Control Sub old customer กรณีลูกค้าเดิม
            // 2 = ลูกค้าเดิม
            if ($(this).val() == 2) {

                // ช่อง Sales reps
                $('#crf_salesreps').prop('disabled', true);

                // ชื่อลูกค้า
                $('#crf_customername').prop('disabled', true);

                // วันที่ก่อตั้ง
                $('#crf_cuscompanycreate').prop('disabled', true);

                // เลขผู้เสียภาษี
                $('#crf_customertaxid').prop('disabled', true);

                // สาขา
                $('#crf_customerbranch').prop('disabled', true);

                // ประเภทที่อยู่
                $('input:radio[name="crf_addresstype"]').prop('disabled', true);
                $('#crf_addressname').prop('disabled', true);

                // ผู้ติดต่อ
                $('#crf_namecontact').prop('disabled', true);

                // เบอร์โทรของผู้ติดต่อ
                $('#crf_telcontact').prop('disabled', true);

                // เบอร์แฟ็ก
                $('#crf_faxcontact').prop('disabled', true);

                // Email
                $('#crf_emailcontact').prop('disabled', true);

                // ทุนจดทะเบียน
                $('#crf_regiscost').prop('disabled', true);

                // แผนที่ลิ้งจาก google
                $('#crf_mapurl').prop('disabled', true);

                // แผนที่ไฟล์อัพโหลด
                $('#crf_mapfile').prop('disabled', true);

                // ประเภทบริษัท
                $('input:radio[name="crf_companytype"]').prop('disabled', true);

                // ประเภทของธุรกิจ
                $('input:radio[name="crf_typeofbussi"]').prop('disabled', true);

                // ผลิตภัณฑ์ของลูกค้า
                $('#crf_customer_product').prop('disabled', true);

                // การคาดการ
                $('#crf_forecast').prop('disabled', true);

                // ไฟล์1
                $('#crf_file1').prop('disabled', true);

                // ไฟล์1
                $('#crf_file2').prop('disabled', true);

                // ไฟล์1
                $('#crf_file3').prop('disabled', true);

                // ไฟล์1
                $('#crf_file4').prop('disabled', true);

                // ไฟล์1
                $('#crf_file5').prop('disabled', true);

                // ไฟล์1
                $('#crf_file6').prop('disabled', true);

                // credit term
                $('#crf_creditterm').prop('disabled', true);

                // เงื่อนไขการวางบิล
                $('input:radio[name="crf_condition_bill"]').prop('disabled', true);


                // เงื่อนไขการรับชำระเงิน
                $('input:radio[name="crf_condition_money"]').prop('disabled', true);

                // วงเงินการค้า
                $('input:radio[name="crf_finance"]').prop('disabled', true);

                // ปุ่ม Submit
                $('#user_submit').prop('disabled', true);



                ///////////////////////////////////////////////
                // Control ปุ่มลูกค้าธรรมดา และ ลูกค้านิติบุคคล
                //////////////////////////////////////////////
                $('input:radio[name="crf_person_type"]').change(function () {

                    if ($(this).val() == "natural") {
                        $('#for_natural').css('display', '');
                        $('#for_juristic').css('display', 'none');
                        // ไฟล์1
                        $('#crf_file_person').prop('disabled' , false);
                        $('#crf_file1 , crf_file2 , crf_file3 , crf_file4 , crf_file5 , crf_file6').prop('disabled', true);
                    }else{
                        $('#for_natural').css('display', 'none');
                        $('#for_juristic').css('display', '');
                        $('#crf_file1 , crf_file2 , crf_file3 , crf_file4 , crf_file5 , crf_file6').prop('disabled', false);
                        $('#crf_file_person').prop('disabled' , true);
                    }

                    // ส่วนนี้เชื่อมโยงกับ Focus Customercode
                    if($(this).val() != ""){
                        $('#crf_customercode').prop('disabled' , false);
                    }
                    // ส่วนนี้เชื่อมโยงกับ Focus Customercode
                });
                ///////////////////////////////////////////////
                // Control ปุ่มลูกค้าธรรมดา และ ลูกค้านิติบุคคล
                //////////////////////////////////////////////


                var unclick = 'return false';


                // Control Save Data ลูกค้าเก่า
                $('#crf_customercode').on('keyup', function () {
                    var cusCode = $(this).val();
                    if (cusCode != '') {
                        autoSearchCustomerDetail(cusCode);
                    } else {
                        $('#autoCusCode').html('')
                    }

                });



                // Auto search customer name
                $('#crf_customername').on('keyup', function () {
                    var cusname = $(this).val();

                    if (cusname != '') {
                        autoSearchCustomerDetailName(cusname);
                    } else {
                        $('#autoCusname').html('')
                    }
                });



                $('input:radio[name="crf_person_type"]').change(function () {
                    if ($('input:checkbox[name="crf_sub_oldcus_editcustomer"]:checked').val() == 5) {
                        if ($(this).val() == "natural") {
                            $('#for_natural').css('display', '');
                            $('#for_juristic').css('display', 'none');
                            // ไฟล์1
                            $('#crf_file_person').prop('disabled', false);


                        } else if ($(this).val() == "juristic") {
                            $('#for_natural').css('display', 'none');
                            $('#for_juristic').css('display', '');
                            // ไฟล์1
                            $('#crf_file_person').prop('disabled', true);
                            // ไฟล์1
                            $('#crf_file1').prop('disabled', false);

                            // ไฟล์1
                            $('#crf_file2').prop('disabled', false);

                            // ไฟล์1
                            $('#crf_file3').prop('disabled', false);

                            // ไฟล์1
                            $('#crf_file4').prop('disabled', false);

                            // ไฟล์1
                            $('#crf_file5').prop('disabled', false);

                            // ไฟล์1
                            $('#crf_file6').prop('disabled', false);
                        }
                    }

                });





                // $('#alert_custype').html('');

                $('.suboldcustomer').css('display', '');

                // // Set Readonly

                // Customer Code
                $('#crf_customercode').prop('readonly', false);

                // // Sales Reps
                // $('#crf_salesreps').prop('readonly', true);

                // ชื่อลูกค้า :
                $('#crf_customername').prop('disabled', false);

                //วงเงิน
                $('.finance_request_detail').css('display', '');
                $('#crf_finance_req_number').prop('readonly', true);



                // Control กรณีเลือก เปลี่ยนเขตการขาย
                $('input:checkbox[name="crf_sub_oldcus_changearea"]').change(function () {
                    if ($(this).prop("checked") == true) {
                        $('#crf_salesreps').prop('disabled', false);
                        $('inpur:checkbox').prop('disabled', true);
                        $('#crf_salesreps').keyup(function () {
                            if ($(this).val() != '') {
                                $('#user_submit').prop('disabled', false);
                            }
                        });
                    } else {
                        $('#crf_salesreps').prop('disabled', true);
                        // $('.crf_file1 , .crf_file2 , .crf_file3 , .crf_file4 , .crf_file5 , .crf_file6').css('display', '');
                    }

                    // เช็คความถูกต้องของการกรอกข้อมูล
                    $('#crf_salesreps').blur(function () {
                        if ($(this).val() == '') {
                            $('#alert_salesreps').html('<div class="alert alert-danger" role="alert">กรุณาระบุข้อมูล Sales Reps ด้วยค่ะ</div>');
                            $('#crf_customername').val('');
                        } else {
                            // เช็คความถูกต้องของการกรอก sales reps
                            if (minsalesreps($(this).val()) == false) {
                                $('#alert_salesreps').html('<div class="alert alert-danger" role="alert">กรุณาระบุข้อมูล Sales Reps ให้ถูกต้องด้วยค่ะ ต้องขึ้นต้นด้วย M หรือ D แล้วตามด้วยตัวเลข 4</div>');
                                // $(this).val('');
                                $('#user_submit').prop('disabled', true);
                            } else {
                                $('#alert_salesreps').html('');
                                $('#user_submit').prop('disabled', false);
                            }
                        }
                    });
                    $('#crf_salesreps').focusout(function () {
                        if ($(this).val() == '') {
                            $('#alert_salesreps').html('<div class="alert alert-danger" role="alert">กรุณาระบุข้อมูล Sales Reps ด้วยค่ะ</div>');
                            $('#crf_customername').val('');
                        } else {
                            // เช็คความถูกต้องของการกรอก sales reps
                            if (minsalesreps($(this).val()) == false) {
                                $('#alert_salesreps').html('<div class="alert alert-danger" role="alert">กรุณาระบุข้อมูล Sales Reps ให้ถูกต้องด้วยค่ะ ต้องขึ้นต้นด้วย M หรือ D แล้วตามด้วยตัวเลข 4</div>');
                                // $(this).val('');
                                $('#user_submit').prop('disabled', true);
                            } else {
                                $('#alert_salesreps').html('');
                                $('#user_submit').prop('disabled', false);

                            }
                        }
                    });
                    $('#crf_salesreps').keyup(function () {
                        if ($(this).val() == '') {
                            $('#alert_salesreps').html('<div class="alert alert-danger" role="alert">กรุณาระบุข้อมูล Sales Reps ด้วยค่ะ</div>');
                            $('#crf_customername').val('');
                        } else {
                            $('#alert_salesreps').html('');
                        }
                    });
                    // Check ข้อมูลช่อง Sale Rep ว่ามีการกรอกข้อมูลหรือไม่
                });





                // Control กรณีเลือก เปลี่ยนที่อยู่
                $('input:checkbox[name="crf_sub_oldcus_changeaddress"]').change(function () {

                    if ($(this).prop("checked") == true) {
                        $('#crf_addressname').prop('disabled', false);
                        $('#crf_file1').prop('disabled', false);
                        $('#crf_file1').attr('required', '');
                        $('input:radio[name="crf_addresstype"]').prop('disabled', false);

                        $('#crf_addressname').blur(function () {
                            if ($(this).val() == '') {
                                $('#crf_file1').prop('disabled', true);
                                $('#user_submit').prop('disabled', true);
                            } else {
                                $('#crf_file1').prop('disabled', false);
                            }
                        });

                        if ($('input:radio[name="crf_person_type"]:checked').val() == "natural"){
                            $('#crf_file1').removeAttr('required');
                            $('#crf_file_person').change(function () {
                                if ($(this).val() != '') {
                                    $('#user_submit').prop('disabled', false);
                                } else {
                                    $('#user_submit').prop('disabled', true);
                                }
                            });
                        }else if ($('input:radio[name="crf_person_type"]:checked').val() == "juristic"){
                            $('#crf_file1').change(function () {
                                if ($(this).val() != '') {
                                    $('#user_submit').prop('disabled', false);
                                } else {
                                    $('#user_submit').prop('disabled', true);
                                }
                            });
                        }

                        

                    } else {
                        $('#crf_addressname').prop('disabled', true);
                        $('input:radio[name="crf_addresstype"]').prop('disabled', true);
                        $('.crf_file1').prop('disabled', true);
                    }
                });



                // Control กรณีแก้ไขข้อมูลลูกค้า
                $('input:checkbox[name="crf_sub_oldcus_editcustomer"]').change(function () {
                    if ($(this).prop("checked") == true) {


                        $('#crf_textmemo').prop('readonly', false);
                        $('#crf_namecontact , #crf_telcontact , #crf_faxcontact , #crf_emailcontact , #crf_regiscost , #crf_mapurl , #crf_mapfile').prop('disabled', false);
                        $('#editMapFile_addpage , #editMapUrl_addpage , #editPrimanage_addpage').css('display', '');
                        $('#editMapUrl_addpage').click(function () {
                            $('#foredit1').toggle('display', '');
                        });
                        $('#editMapFile_addpage').click(function () {
                            $('#foredit2').toggle('display', '');
                        });

                        $('#editPrimanage_addpage').click(function () {
                            $('.newPrimanage').show();
                            $('#showPrimanage').html('');
                            $('#checkprimanagenull').val('1');
                        });


                        if ($('input:radio[name="crf_person_type"]:checked').val() == "natural") {
                            $('#for_natural').css('display', '');
                            $('#for_juristic').css('display', 'none');
                            $('#crf_file_person').prop('disabled', false);
                        } else if ($('input:radio[name="crf_person_type"]:checked').val() == "juristic") {
                            $('#for_natural').css('display', 'none');
                            $('#for_juristic').css('display', '');
                            $('#crf_file_person').prop('disabled', true);
                            // ไฟล์1
                            $('#crf_file1').prop('disabled', false);

                            // ไฟล์1
                            $('#crf_file2').prop('disabled', false);

                            // ไฟล์1
                            $('#crf_file3').prop('disabled', false);

                            // ไฟล์1
                            $('#crf_file4').prop('disabled', false);

                            // ไฟล์1
                            $('#crf_file5').prop('disabled', false);

                            // ไฟล์1
                            $('#crf_file6').prop('disabled', false);
                        }



                        // $('#crf_file1 , #crf_file2 , #crf_file3 , #crf_file4 , #crf_file5 , #crf_file6').prop('disabled', false);

                        var checkpointchange = 0;
                        $('#crf_namecontact').change(function () {
                            checkpointchange = 1;
                            if (checkpointchange == 1) {
                                $('#user_submit').prop('disabled', false);
                            }
                        });

                        $('#crf_customername').change(function () {
                            checkpointchange = 1;
                            if (checkpointchange == 1) {
                                $('#user_submit').prop('disabled', false);
                            }
                        });

                        $('#crf_telcontact').change(function () {
                            checkpointchange = 1;
                            if (checkpointchange == 1) {
                                $('#user_submit').prop('disabled', false);
                            }
                        });

                        $('#crf_faxcontact').change(function () {
                            checkpointchange = 1;
                            if (checkpointchange == 1) {
                                $('#user_submit').prop('disabled', false);
                            }
                        });

                        $('#crf_emailcontact').change(function () {
                            checkpointchange = 1;
                            if (checkpointchange == 1) {
                                $('#user_submit').prop('disabled', false);
                            }
                        });

                        $('#crf_regiscost').change(function () {
                            checkpointchange = 1;
                            if (checkpointchange == 1) {
                                $('#user_submit').prop('disabled', false);
                            }
                        });

                        $('#crf_mapurl').change(function () {
                            checkpointchange = 1;
                            if (checkpointchange == 1) {
                                $('#user_submit').prop('disabled', false);
                            }
                        });

                        $('#crf_mapfile').change(function () {
                            checkpointchange = 1;
                            if (checkpointchange == 1) {
                                $('#user_submit').prop('disabled', false);
                            }
                        });

                        $('#crf_file1 , #crf_file2 , #crf_file3 , #crf_file4 , #crf_file5 , #crf_file6').change(function () {
                            checkpointchange = 1;
                            if (checkpointchange == 1) {
                                $('#user_submit').prop('disabled', false);
                            }
                        });



                    } else {
                        $('#crf_namecontact , #crf_telcontact , #crf_faxcontact , #crf_emailcontact , #crf_regiscost , #crf_mapurl , #crf_mapfile').prop('disabled', true);
                        $('#editMapFile_addpage , #editMapUrl_addpage , #editPrimanage_addpage').css('display', 'none');
                        $('#crf_file1 , #crf_file2 , #crf_file3 , #crf_file4 , #crf_file5 , #crf_file6 , #crf_file_person').prop('disabled', true);

                    }
                });
                // Control กรณีแก้ไขข้อมูลลูกค้า




                // Control กรณีเลือกปรับ Credit term
                $('input:checkbox[name="crf_sub_oldcus_changecredit"]').change(function () {

                    if ($(this).prop("checked") == true) {
                        $('.change_credit').css('display', '');
                        $('input[name=crf_change_creditterm]').prop('checked', true);
                        $('.change_credit_detail').css('display', '');
                        $('#crf_condition_credit').attr('required', '');
                        $('#crf_creditterm').prop('readonly', true);
                        if ($('#crf_condition_credit').val() == '') {
                            $('#user_submit').prop('disabled', true);
                        } else {
                            $('#user_submit').prop('disabled', false);
                        }
                        $('#crf_file1').prop('disabled' , true);
                    } else {
                        $('.change_credit').css('display', 'none');
                        $('input[name=crf_change_creditterm]').prop('checked', false);
                        $('.change_credit_detail').css('display', 'none');
                    }

                    $('#crf_condition_credit').change(function () {
                        $('.showcredit2').remove();
                        var creditMethod = $(this).val();
                        var oldCredit = $('#oldCreditTerm').val();
                        filterCreditTerm(oldCredit, creditMethod);
                        if ($(this).val() != '') {
                            $('#user_submit').prop('disabled', false);
                        } else {
                            $('#user_submit').prop('disabled', true);
                        }
                    });
                });



                // Control กรณีเลือกปรับ ปรับวงเงิน
                $('input:checkbox[name="crf_sub_oldcus_changefinance"]').change(function () {

                    if ($(this).prop("checked") == true) {
                        $('.finance_change_detail').css('display', '');
                        $('input[name=crf_finance]').prop('checked', true);

                        $('#crf_finance_change_status').change(function () {
                            $('#showChangeStatus').val($(this).val());
                        });

                        $('#value_crf_finance').val('ปรับวงเงิน');

                        $('#crf_file1').prop('disabled' , true);

                        $('#crf_finance_change_number').keyup(function () {
                            var oldmoney = parseInt($('#crf_finance_req_number_calc').val());
                            var newmoney = parseInt($(this).val())
                            if ($('#showChangeStatus').val() == 'เพิ่ม') {
                                $('#crf_finance_change_total').val(oldmoney + newmoney);
                            } else if ($('#showChangeStatus').val() == 'ลด') {
                                $('#crf_finance_change_total').val(oldmoney - newmoney);
                            }

                            $('#crf_finance_change_total').val(function (index, value) {
                                return value
                                    .replace(/\D/g, "")
                                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                                    ;
                            });
                            if ($(this).val() != '') {
                                $('#user_submit').prop('disabled', false);
                            } else {
                                $('#user_submit').prop('disabled', true);
                            }
                        });


                    } else {
                        $('.finance_change_detail').css('display', 'none');
                        $('input[name=crf_finance]').prop('checked', false);
                    }
                });


                $('input:checkbox[id="crf_sub_oldcus"]').change(function(){
                    const check_crf_sub_oldcus = $('input:checkbox[id="crf_sub_oldcus"]:checked');
                    if(check_crf_sub_oldcus.val() != ""){
                        $('#crf_customercode').prop('disabled' , false);
                    }
                });



                // Check Sub old Customer ว่ามีการเลือกประเภทหรือไม่
                $('#crf_customercode').focus(function () {
                    if ($('#checkCusType').val() == 2) {

                        var crf_sub_oldcus = $('input[type="checkbox"][id="crf_sub_oldcus"]:checked');
                        var crf_person_type = $('input[type="radio"][name="crf_person_type"]:checked');

                        if (crf_person_type.length < 1) {
                            $('#alert_crf_sub_oldcus').html('<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทลูกค้าด้วยค่ะ</div>');
                            $('#crf_customercode').val('').prop('disabled' , true);
                            $('#autoCusCode').html('');
                        }else if(crf_sub_oldcus.length < 1){
                            $('#alert_crf_sub_oldcus').html('<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทการดำเนินการด้วยค่ะ</div>');
                            $('#crf_customercode').val('').prop('disabled' , true);
                            $('#autoCusCode').html('');
                        } else {
                            $('#crf_customercode').prop('disabled' , false);
                        }
                    }
                });


                $('#crf_customername').focus(function () {
                    if ($('#checkCusType').val() == 2) {
                        var crf_sub_oldcus = $('input[type="checkbox"][id="crf_sub_oldcus"]:checked');
                        if (crf_sub_oldcus.length < 1) {
                            $('#alert_crf_sub_oldcus').html('<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทการดำเนินการด้วยค่ะ</div>');
                            $('#crf_customername').val('');
                        } else {
                            $('#alert_crf_sub_oldcus').html('');
                        }
                    }
                });
                $('#crf_customercode').keyup(function () {
                    if ($('#checkCusType').val() == 2) {
                        var crf_sub_oldcus = $('input[type="checkbox"][id="crf_sub_oldcus"]:checked');
                        if (crf_sub_oldcus.length < 1) {
                            $('#alert_crf_sub_oldcus').html('<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทการดำเนินการด้วยค่ะ</div>');
                            $('#crf_customercode').val('');
                        } else {
                            $('#alert_crf_sub_oldcus').html('');
                        }
                    }
                });
                $('#crf_customername').keyup(function () {
                    if ($('#checkCusType').val() == 2) {
                        var crf_sub_oldcus = $('input[type="checkbox"][id="crf_sub_oldcus"]:checked');
                        if (crf_sub_oldcus.length < 1) {
                            $('#alert_crf_sub_oldcus').html('<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทการดำเนินการด้วยค่ะ</div>');
                            $('#crf_customername').val('');
                        } else {
                            $('#alert_crf_sub_oldcus').html('');
                        }
                    }
                });
                $('#alert_crf_sub_oldcus').fadeIn();
                // Check Sub old Customer ว่ามีการเลือกประเภทหรือไม่




                $('#crf_finance').prop('checked', false);
                // $('.finance_request_detail').css('display', 'none');


                // Alert Sales Reps
                $('#alert_salesreps').html('');
                // Clear Sales Reps
                $('#crf_salesreps').val('');


                // Check ข้อมูลช่อง Sale Rep ว่ามีการกรอกข้อมูลหรือไม่
                // $('#crf_salesreps').blur(function () {
                //     if ($(this).val() == '') {
                //         $('#alert_salesreps').html('<div class="alert alert-danger" role="alert">กรุณาระบุข้อมูล Sales Reps ด้วยค่ะ</div>');
                //         $('#crf_customername').val('');
                //     }
                // });
                // $('#crf_customername').focus(function () {
                //     if ($('#crf_salesreps').val() == '') {
                //         $('#alert_salesreps').html('<div class="alert alert-danger" role="alert">กรุณาระบุข้อมูล Sales Reps ด้วยค่ะ</div>');
                //     } else {
                //         $('#alert_salesreps').html('');
                //     }
                // });
                // $('#crf_customername').keyup(function () {
                //     if ($('#crf_salesreps').val() == '') {
                //         $('#alert_salesreps').html('<div class="alert alert-danger" role="alert">กรุณาระบุข้อมูล Sales Reps ด้วยค่ะ</div>');
                //         $('#crf_customername').val('');
                //     } else {
                //         $('#alert_salesreps').html('');
                //         $('#alert_customername').html('');
                //     }
                // });
                // Check ข้อมูลช่อง Sale Rep ว่ามีการกรอกข้อมูลหรือไม่


                // Check ข้อมูลช่อง ชื่อลูกค้าว่ามีการกรอกข้อมูลหรือไม่
                $('#crf_cuscompanycreate').focus(function () {
                    if ($('#crf_customername').val() == '') {
                        $('#alert_customername').html('<div class="alert alert-danger" role="alert">กรุณาระบุชื่อลูกค้าด้วยค่ะ</div>');
                        $('#crf_cuscompanycreate').val('');
                    } else {
                        $('#alert_customername').html('');
                    }
                });
                // $('#crf_customername').blur(function () {
                //     if ($(this).val() == '') {
                //         $('#alert_customername').html('<div class="alert alert-danger" role="alert">กรุณาระบุชื่อลูกค้าด้วยค่ะ</div>');
                //     } else {
                //         $('#alert_customername').html();
                //     }
                // });
                // Check ข้อมูลช่อง ชื่อลูกค้าว่ามีการกรอกข้อมูลหรือไม่


                // Check วันที่ก่อตั้งว่ามีการเลือกหรือไม่ // Check วันที่ก่อตั้งว่ามีการเลือกหรือไม่
                $('#crf_cuscompanycreate').blur(function () {
                    if ($(this).val() == '') {
                        $('#alert_cuscompanycreate').html('<div class="alert alert-danger" role="alert">กรุณาระบุวันที่ก่อตั้งด้วยค่ะ</div>');
                    } else {
                        $('#alert_cuscompanycreate').html('');
                    }
                });

                $('#crf_cuscompanycreate').change(function () {
                    if ($(this).val() == '') {
                        $('#alert_cuscompanycreate').html('<div class="alert alert-danger" role="alert">กรุณาระบุวันที่ก่อตั้งด้วยค่ะ</div>');
                    } else {
                        $('#alert_cuscompanycreate').html('');
                    }
                });

                $('#crf_addressname').focus(function () {
                    if ($('#crf_cuscompanycreate').val() == '') {
                        $('#alert_cuscompanycreate').html('<div class="alert alert-danger" role="alert">กรุณาระบุวันที่ก่อตั้งด้วยค่ะ</div>');
                        $('#crf_addressname').val('');
                    } else {
                        $('#alert_cuscompanycreate').html('');
                    }

                    var crf_addresstype = $('input:radio[name="crf_addresstype"]:checked');
                    if (crf_addresstype.length < 1) {
                        $('#alert_addresstype').html('<div class="alert alert-danger" role="alert">กรุณาเลือกที่อยู่สำหรับเปิดใบกำกับภาษีด้วยค่ะ</div>');
                        $('#crf_addressname').val('');
                    } else {
                        $('#alert_addresstype').html('');
                    }
                });

                $('#crf_addressname').keyup(function () {
                    if ($('#crf_cuscompanycreate').val() == '') {
                        $('#alert_cuscompanycreate').html('<div class="alert alert-danger" role="alert">กรุณาระบุวันที่ก่อตั้งด้วยค่ะ</div>');
                        $('#crf_addressname').val('');
                    }

                    var crf_addresstype = $('input:radio[name="crf_addresstype"]:checked');
                    if (crf_addresstype.length < 1) {
                        $('#alert_addresstype').html('<div class="alert alert-danger" role="alert">กรุณาเลือกที่อยู่สำหรับเปิดใบกำกับภาษีด้วยค่ะ</div>');
                        $('#crf_addressname').val('');
                    } else {
                        $('#alert_addresstype').html('');
                    }
                });
                // Check วันที่ก่อตั้งว่ามีการเลือกหรือไม่ // Check วันที่ก่อตั้งว่ามีการเลือกหรือไม่


                // Check Address Name Check Address Name Check Address Name
                $('#crf_addressname').blur(function () {
                    if ($(this).val() == '') {
                        $('#alert_addressname').html('<div class="alert alert-danger" role="alert">กรุณาระบุที่อยู่สำหรับการเปิดใบกำกับภาษีด้วยค่ะ</div>');
                    } else {
                        $('#alert_addressname').html('');
                    }
                });
                $('#crf_addressname').keyup(function () {
                    if ($(this).val() != '') {
                        $('#alert_addressname').html('');
                    }
                });
                $('#crf_namecontact').focus(function () {
                    if ($('#crf_addressname').val() == '') {
                        $('#alert_addressname').html('<div class="alert alert-danger" role="alert">กรุณาระบุที่อยู่สำหรับการเปิดใบกำกับภาษีด้วยค่ะ</div>');
                        $('#crf_namecontact').val('');
                    } else {
                        $('#alert_addressname').html('');
                    }
                });
                $('#crf_namecontact').keyup(function () {
                    if ($('#crf_addressname').val() == '') {
                        $('#alert_addressname').html('<div class="alert alert-danger" role="alert">กรุณาระบุที่อยู่สำหรับการเปิดใบกำกับภาษีด้วยค่ะ</div>');
                        $('#crf_namecontact').val('');
                    } else {
                        $('#alert_addressname').html('');
                    }
                });
                // Check Address Name Check Address Name Check Address Name


                // Check ช่องผู้ติดต่อว่ามีการกรอกข้อมูลเข้ามาหรือไม่
                $('#crf_namecontact').blur(function () {
                    if ($(this).val() == '') {
                        $('#alert_namecontact').html('<div class="alert alert-danger" role="alert">กรุณาระบุชื่อผู้ติดต่อด้วยค่ะ</div>');
                    } else {
                        $('#alert_namecontact').html('');
                    }
                });
                $('#crf_telcontact').focus(function () {
                    if ($('#crf_namecontact').val() == '') {
                        $('#alert_namecontact').html('<div class="alert alert-danger" role="alert">กรุณาระบุชื่อผู้ติดต่อด้วยค่ะ</div>');
                        $('#crf_telcontact').val('');
                    } else {
                        $('#alert_namecontact').html('');
                    }
                });
                $('#crf_telcontact').keyup(function () {
                    if ($('#crf_namecontact').val() == '') {
                        $('#alert_namecontact').html('<div class="alert alert-danger" role="alert">กรุณาระบุชื่อผู้ติดต่อด้วยค่ะ</div>');
                        $('#crf_telcontact').val('');
                    } else {
                        $('#alert_namecontact').html('');
                    }
                });
                $('#crf_namecontact').keyup(function () {
                    if ($(this).val() != '') {
                        $('#alert_namecontact').html('');
                    }
                });
                // Check ช่องผู้ติดต่อว่ามีการกรอกข้อมูลเข้ามาหรือไม่



                // Check ช่องเบอร์โทรว่ามีการกรอกข้อมูลหรือไม่
                $('#crf_telcontact').blur(function () {
                    if ($(this).val() == '') {
                        $('#alert_telcontact').html('<div class="alert alert-danger" role="alert">กรุณาระบุเบอร์ผู้ติดต่อด้วยค่ะ</div>');
                    } else {
                        $('#alert_telcontact').html('');
                    }
                });
                $('#crf_emailcontact').focus(function () {
                    if ($('#crf_telcontact').val() == '') {
                        $('#alert_telcontact').html('<div class="alert alert-danger" role="alert">กรุณาระบุเบอร์ผู้ติดต่อด้วยค่ะ</div>');
                        $('#crf_emailcontact').val('');
                    } else {
                        $('#alert_telcontact').html('');
                    }
                });
                $('#crf_emailcontact').keyup(function () {
                    if ($('#crf_telcontact').val() == '') {
                        $('#alert_telcontact').html('<div class="alert alert-danger" role="alert">กรุณาระบุเบอร์ผู้ติดต่อด้วยค่ะ</div>');
                        $('#crf_emailcontact').val('');
                    } else {
                        $('#alert_telcontact').html('');
                    }
                });
                $('#crf_telcontact').keyup(function () {
                    if ($(this).val() != '') {
                        $('#alert_telcontact').html('');
                    }
                });
                // Check ช่องเบอร์โทรว่ามีการกรอกข้อมูลหรือไม่


                // Check ช่อง อีเมลว่ามีการกรอกข้อมูลหรือไม่
                // $('#crf_emailcontact').blur(function () {
                //     if ($(this).val() == '') {
                //         $('#alert_emailcontact').html('<div class="alert alert-danger" role="alert">กรุณาระบุอีเมลผู้ติดต่อด้วยค่ะ</div>');
                //     } else {
                //         $('#alert_emailcontact').html('');
                //     }
                // });
                // $('#crf_regiscost').focus(function () {
                //     if ($('#crf_emailcontact').val() == '') {
                //         $('#alert_emailcontact').html('<div class="alert alert-danger" role="alert">กรุณาระบุอีเมลผู้ติดต่อด้วยค่ะ</div>');
                //         $('#crf_regiscost').val('');
                //     } else {
                //         $('#alert_emailcontact').html('');
                //     }
                // });
                // $('#crf_regiscost').keyup(function () {
                //     if ($('#crf_emailcontact').val() == '') {
                //         $('#alert_emailcontact').html('<div class="alert alert-danger" role="alert">กรุณาระบุอีเมลผู้ติดต่อด้วยค่ะ</div>');
                //         $('#crf_regiscost').val('');
                //     } else {
                //         $('#alert_emailcontact').html('');
                //     }
                // });
                // $('#crf_emailcontact').keyup(function () {
                //     if ($(this).val() != '') {
                //         $('#alert_emailcontact').html('');
                //     }
                // });
                // Check ช่อง อีเมลว่ามีการกรอกข้อมูลหรือไม่


                // Check ช่อง ทุนจดทะเบียน
                $('#crf_regiscost').blur(function () {
                    if ($(this).val() == '') {
                        $('#alert_regiscost').html('<div class="alert alert-danger" role="alert">กรุณาระบุทุนจดทะเบียนด้วยค่ะ</div>');
                    } else {
                        $('#alert_regiscost').html('');
                    }
                });
                $('input:radio[name="crf_companytype"]').click(function () {
                    if ($('#crf_regiscost').val() == '') {
                        $('#alert_regiscost').html('<div class="alert alert-danger" role="alert">กรุณาระบุทุนจดทะเบียนด้วยค่ะ</div>');
                        $('#crf_regiscost').val('');
                    } else {
                        $('#alert_regiscost').html('');
                    }

                    $('#crf_companytype2 , #crf_companytype3_1_1 , #crf_companytype3_1_2 , #crf_companytype3_2_1 , #crf_companytype3_2_2').val('');
                });
                // $('#crf_regiscost').keyup(function(){
                //     if($('#crf_emailcontact').val() == ''){
                //         $('#alert_emailcontact').html('<div class="alert alert-danger" role="alert">กรุณาระบุอีเมลผู้ติดต่อด้วยค่ะ</div>');
                //         $('#user_submit').prop('disabled' , true);
                //         $('#crf_regiscost').val('');
                //     }else{
                //         $('#alert_emailcontact').html('');
                //         $('#user_submit').prop('disabled' , false);
                //     }
                // });
                $('#crf_regiscost').keyup(function () {
                    if ($(this).val() != '') {
                        $('#alert_regiscost').html('');
                    }
                });
                // Check ช่อง ทุนจดทะเบียน



                // Check ช่องรายชื่อบุคคลในแต่ระดับบริหารที่สำคัญ
                // $('#crf_primanage_dept , #crf_primanage_name , #crf_primanage_posi , #crf_primanage_email').blur(function () {
                //     if ($(this).val() == '') {
                //         $('#alert_primanage').html('<div class="alert alert-danger" role="alert">กรุณาระบุข้อมูลให้ครบถ้วนด้วยค่ะ</div>');
                //         // $('input:radio[name="crf_typeofbussi"]').prop('checked', false);
                //         $('#user_submit').prop('disabled' , true);
                //         exit;
                //     } else {
                //         $('#alert_primanage').html('');
                //         $('#user_submit').prop('disabled' , false);
                //     }
                // });


                $('input:radio[name="crf_typeofbussi"]').click(function () {
                    if ($('#crf_primanage_dept').val() == '' || $('#crf_primanage_name').val() == '' || $('#crf_primanage_posi').val() == '' || $('#crf_primanage_email').val() == '') {
                        $('#alert_primanage').html('<div class="alert alert-danger" role="alert">กรุณาระบุข้อมูลให้ครบถ้วนด้วยค่ะ</div>');
                        // $('input:radio[name="crf_typeofbussi"]').prop('checked', false);
                        exit;
                    } else {
                        $('#alert_primanage').html('');
                    }
                });

                // $('#crf_regiscost').keyup(function(){
                //     if($('#crf_emailcontact').val() == ''){
                //         $('#alert_emailcontact').html('<div class="alert alert-danger" role="alert">กรุณาระบุอีเมลผู้ติดต่อด้วยค่ะ</div>');
                //         $('#user_submit').prop('disabled' , true);
                //         $('#crf_regiscost').val('');
                //     }else{
                //         $('#alert_emailcontact').html('');
                //         $('#user_submit').prop('disabled' , false);
                //     }
                // });
                $('#crf_primanage_dept , #crf_primanage_name , #crf_primanage_posi , #crf_primanage_email').keyup(function () {
                    if ($(this).val() != '') {
                        $('#alert_primanage').html('');
                    }

                    var crf_companytype = $('input:radio[name="crf_companytype"]:checked');
                    if (crf_companytype.length < 1) {
                        $(this).val('');
                        $('#alert_companytype').html('<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทบริษัทด้วยค่ะ</div>');
                    } else {
                        $('#alert_primanage').html('');
                        $('#alert_companytype').html('');
                    }
                });
                // Check ช่องรายชื่อบุคคลในแต่ระดับบริหารที่สำคัญ




                // Check ประเภทของ ธุรกิจว่ามีการเลือกข้อมูลหรือไม่
                $(document).on('change', 'input[type="checkbox"][id="crf_process"]:checked', function () {
                    var crf_typeofbussi = $('input:radio[name="crf_typeofbussi"]:checked');
                    if (crf_typeofbussi.length < 1) {
                        $('#alert_typeofbussi').html('<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทธุรกิจด้วยค่ะ</div>');
                        $(this).prop('checked', false);
                        exit;
                    } else {
                        $('#alert_typeofbussi').html('');
                    }

                });
                // Check ประเภทของ ธุรกิจว่ามีการเลือกข้อมูลหรือไม่


                // Check กระบวนการผลิตว่ามีการเลือกข้อมูลเข้ามาหรือไม่
                $('#crf_forecast').focus(function () {
                    var crf_process = $('input[type="checkbox"][id="crf_process"]:checked');
                    if (crf_process.length < 1) {
                        $('#alert_process').html('<div class="alert alert-danger" role="alert">กรุณาเลือกกระบวนการผลิตหลักด้วยค่ะ</div>');
                        $(this).val('');
                    } else {
                        $('#alert_process').html('');
                    }
                });
                $('#crf_forecast').keyup(function () {
                    var crf_process = $('input[type="checkbox"][id="crf_process"]:checked');
                    if (crf_process.length < 1) {
                        $('#alert_process').html('<div class="alert alert-danger" role="alert">กรุณาเลือกกระบวนการผลิตหลักด้วยค่ะ</div>');
                        $(this).val('');
                    } else {
                        $('#alert_process').html('');
                    }

                    if ($(this).val() != '') {
                        $('#alert_forecast').html('');
                    }
                });
                // Check กระบวนการผลิตว่ามีการเลือกข้อมูลเข้ามาหรือไม่


                // Check คาดการปริมาณการขายว่ามีการกรอกข้อมูลงไปหรือไม่
                $('#crf_forecast').blur(function () {
                    if ($(this).val() == '') {
                        $('#alert_forecast').html('<div class="alert alert-danger" role="alert">กรุณาระบุรายละเอียดคาดการปริมาณการขายด้วยค่ะ</div>');
                    } else {
                        $('#alert_forecast').html('');
                    }
                });
                // Check คาดการปริมาณการขายว่ามีการกรอกข้อมูลงไปหรือไม่



                // Check File Upload ว่ามีการอัพโหลดไฟล์หรือยังก่อ่นที่จะเลือก Credit term
                // $('#crf_creditterm').change(function () {

                //     if ($(this).val() != '') {
                //         $('#alert_creditterm').html('');
                //         $('input:radio[name="crf_condition_bill"]').prop('disabled', false);
                //     } else {
                //         $('#alert_creditterm').html('<div class="alert alert-danger" role="alert">กรุณาเลือก Credit Term ด้วยค่ะ</div>');
                //         $('input:radio[name="crf_condition_bill"]').prop('checked', false);
                //         $('input:radio[name="crf_condition_bill"]').prop('disabled', true);

                //         $('input:radio[name="crf_condition_money"]').prop('checked', false);
                //     }

                //     if ($('#crf_file1').val() == '') {
                //         $('#alert_file1').html('<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ ภพ.20 ด้วยค่ะ</div>');
                //         $('#crf_creditterm').val('');
                //     } else {
                //         $('#alert_file1').html('');
                //     }

                //     if ($('#crf_file2').val() == '') {
                //         $('#alert_file2').html('<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ หนังสือรับรอง ด้วยค่ะ</div>');
                //         $('#crf_creditterm').val('');
                //     } else {
                //         $('#alert_file2').html('');
                //     }

                //     if ($('#crf_file3').val() == '') {
                //         $('#alert_file3').html('<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ ข้อมูลทั่วไป ด้วยค่ะ</div>');
                //         $('#crf_creditterm').val('');
                //     } else {
                //         $('#alert_file3').html('');
                //     }

                //     if ($('#crf_file4').val() == '') {
                //         $('#alert_file4').html('<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ งบแสดงฐานะทางการเงิน ด้วยค่ะ</div>');
                //         $('#crf_creditterm').val('');
                //     } else {
                //         $('#alert_file4').html('');
                //     }

                //     if ($('#crf_file5').val() == '') {
                //         $('#alert_file5').html('<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ งบกำไรขาดทุน ด้วยค่ะ</div>');
                //         $('#crf_creditterm').val('');
                //     } else {
                //         $('#alert_file5').html('');
                //     }

                //     if ($('#crf_file6').val() == '') {
                //         $('#alert_file6').html('<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ อัตราส่วนสภาพคล่อง ด้วยค่ะ</div>');
                //         $('#crf_creditterm').val('');
                //     } else {
                //         $('#alert_file6').html('');
                //     }
                // });
                // Check File Upload ว่ามีการอัพโหลดไฟล์หรือยังก่อ่นที่จะเลือก Credit term


                // Check Upload File 1 - 6 Element
                $('#crf_file1').change(function () {
                    if ($(this).val() != '') {
                        $('#alert_file1').html('');
                    }
                });

                $('#crf_file2').change(function () {
                    if ($(this).val() != '') {
                        $('#alert_file2').html('');
                    }
                });

                $('#crf_file3').change(function () {
                    if ($(this).val() != '') {
                        $('#alert_file3').html('');
                    }
                });

                $('#crf_file4').change(function () {
                    if ($(this).val() != '') {
                        $('#alert_file4').html('');
                    }
                });

                $('#crf_file5').change(function () {
                    if ($(this).val() != '') {
                        $('#alert_file5').html('');
                    }
                });

                $('#crf_file6').change(function () {
                    if ($(this).val() != '') {
                        $('#alert_file6').html('');
                    }
                });
                // Check Upload File 1 - 6 Element


                // Check Credit Term ว่ามีการเลือกหรือไม่
                $('input:radio[name="crf_condition_bill"]').click(function () {
                    if ($('#crf_creditterm').val() == '') {
                        $('#alert_creditterm').html('<div class="alert alert-danger" role="alert">กรุณาเลือก Credit Term ด้วยค่ะ</div>');
                        $('input:radio[name="crf_condition_bill"]').prop('checked', false);
                        $('input:radio[name="crf_condition_bill"]').prop('disabled', true);
                        exit;
                    } else {
                        $('#alert_creditterm').html('');
                    }


                });
                // Check Credit Term ว่ามีการเลือกหรือไม่


                // Check เงื่อนไขการวางบิล ว่าได้มีการเลือกแล้วหรือยัง
                $('input:radio[name="crf_condition_money"]').click(function () {
                    var crf_condition_bill = $('input:radio[name=crf_condition_bill]:checked');
                    if (crf_condition_bill.length < 1) {
                        $('#alert_condition_bill').html('<div class="alert alert-danger" role="alert">กรุณาเลือกเงื่อนไขการวางบิลด้วยค่ะ</div>');
                        $('input:radio[name="crf_condition_money"]').prop('checked', false);
                        exit;
                    } else {
                        $('#alert_condition_bill').html('');
                    }
                });
                // Check เงื่อนไขการวางบิล ว่าได้มีการเลือกแล้วหรือยัง


                // Check เงื่อนไขการรับชำระเงินว่ามีการเลือกข้อมูลถูกต้องหรือไม่
                // $('#crf_finance_req_number').focus(function () {
                //     var crf_condition_money = $('input:radio[name="crf_condition_money"]:checked');
                //     if (crf_condition_money.length < 1) {
                //         $('#alert_condition_money').html('<div class="alert alert-danger" role="alert">กรุณาเลือกเงื่อนไขการชำระเงินด้วยค่ะ</div>');
                //         $('#crf_finance_req_number').val('');
                //     } else {
                //         if (crf_condition_money.val() == 'รับเช็ค') {
                //             if ($('#crf_recive_cheuqetable').val() == '') {
                //                 $('#alert_recive_cheuqetable').html('<div class="alert alert-danger" role="alert">กรุณา แนบตารางวางบิล / รับเช็ค ด้วยค่ะ</div>');
                //                 $('#crf_finance_req_number').val('');
                //             } else {
                //                 $('#alert_recive_cheuqetable').html('');
                //             }

                //             if ($('#crf_recive_cheuqedetail').val() == '') {
                //                 $('#alert_recive_cheuqedetail').html('<div class="alert alert-danger" role="alert">กรุณา รายละเอียดเพิ่มเติม ด้วยค่ะ</div>');
                //                 $('#crf_finance_req_number').val('');
                //             } else {
                //                 $('#alert_recive_cheuqedetail').html('');
                //             }
                //         } else {
                //             $('#alert_condition_money').html('');
                //         }
                //     }
                // });

                // $('#crf_finance_req_number').keyup(function () {
                //     var crf_condition_money = $('input:radio[name="crf_condition_money"]:checked');
                //     if (crf_condition_money.length < 1) {
                //         $('#alert_condition_money').html('<div class="alert alert-danger" role="alert">กรุณาเลือกเงื่อนไขการชำระเงินด้วยค่ะ</div>');
                //         $('#crf_finance_req_number').val('');
                //     } else {
                //         if (crf_condition_money.val() == 'รับเช็ค') {
                //             if ($('#crf_recive_cheuqetable').val() == '') {
                //                 $('#alert_recive_cheuqetable').html('<div class="alert alert-danger" role="alert">กรุณา แนบตารางวางบิล / รับเช็ค ด้วยค่ะ</div>');
                //                 $('#crf_finance_req_number').val('');
                //             } else {
                //                 $('#alert_recive_cheuqetable').html('');
                //             }

                //             if ($('#crf_recive_cheuqedetail').val() == '') {
                //                 $('#alert_recive_cheuqedetail').html('<div class="alert alert-danger" role="alert">กรุณา รายละเอียดเพิ่มเติม ด้วยค่ะ</div>');
                //                 $('#crf_finance_req_number').val('');
                //             } else {
                //                 $('#alert_recive_cheuqedetail').html('');
                //             }
                //         } else {
                //             $('#alert_condition_money').html('');
                //         }
                //     }
                // });
                // Check เงื่อนไขการรับชำระเงินว่ามีการเลือกข้อมูลถูกต้องหรือไม่



                // Check ช่องวงเงินที่ต้องการว่ามีการกรอกข้อมูลหรือไม่
                $('#crf_finance_req_number').keyup(function () {
                    if ($('#crf_finance_req_number').val() != '') {
                        // $('#user_submit').prop('disabled', false);
                    }
                });

                $('#crf_finance_req_number').blur(function () {
                    if ($('#crf_finance_req_number').val() != '') {
                        // $('#user_submit').prop('disabled', false);
                    } else {
                        // $('#user_submit').prop('disabled', true);
                    }
                });
                // Check ช่องวงเงินที่ต้องการว่ามีการกรอกข้อมูลหรือไม่


                // test check file 1
                $('#user_submit').click(function () {
                    if ($('input:checkbox[name="crf_sub_oldcus_changeaddress"]').prop('checked')) {
                        if ($('input:radio[name="crf_person_type"]:checked').val() == "natural"){
                            if ($('#crf_file_person').val() == '') {
                                alert('กรุณาอัพโหลดไฟล์ สำเนาบัตรประชาชน ด้วยค่ะ');
                                $('#user_submit').prop('disabled', true);
                                $('#alert_file1').html('<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ สำเนาบัตรประชาชน ด้วยค่ะ</div>');
                                exit;
                            } else {
                                $('#user_submit').prop('disabled', false);
                                $('#alert_file1').html('');
                            }
                        }else if($('input:radio[name="crf_person_type"]:checked').val() == "juristic"){
                            if ($('#crf_file1').val() == '') {
                                alert('กรุณาอัพโหลดไฟล์ ภพ20 ด้วยค่ะ');
                                $('#user_submit').prop('disabled', true);
                                $('#alert_file1').html('<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ ภพ20 ด้วยค่ะ</div>');
                                exit;
                            } else {
                                $('#user_submit').prop('disabled', false);
                                $('#alert_file1').html('');
                            }
                        }
                        
                    }

                    if ($('input:checkbox[name="crf_sub_oldcus_changecredit"]').prop('checked')) {
                        if ($('#crf_condition_credit').val() == '') {
                            alert('กรุณาเลือกเงื่อนไขการขอปรับ Credit term ด้วย ค่ะ');
                            $('#alert_crf_condition_credit').html('<div class="alert alert-danger" role="alert">กรุณาเลือกเงื่อนไขการขอปรับ Credit term ด้วย ค่ะ</div>');
                            $('#user_submit').prop('disabled', true);
                            exit;
                        } else {
                            $('#alert_crf_condition_credit').html('');
                            $('#user_submit').prop('disabled', false);
                        }

                        if ($('#showcredit2').val() == '') {
                            alert('กรุณาเลือก Credit term ที่ต้องการด้วย ค่ะ');
                            $('#alert_showcredit2').html('<div class="alert alert-danger" role="alert">กรุณาเลือก Credit term ที่ต้องการด้วย ค่ะ</div>');
                            $('#user_submit').prop('disabled', true);
                            exit;
                        } else {
                            $('#alert_showcredit2').html('');
                            $('#user_submit').prop('disabled', false);
                        }
                    }

                    if ($('input:checkbox[name="crf_sub_oldcus_changefinance"]').prop('checked')) {
                        if ($('#crf_finance_change_total').val() == '') {
                            alert('กรุณาระบุ รายละเอียดการขอเปลี่ยนแปลงแก้ไขวงเงิน ด้วยค่ะ');
                            $('#alert_crf_finance_status').html('<div class="alert alert-danger" role="alert">กรุณาเลือก สถานะวงเงิน ด้วยค่ะ</div>');
                            $('#alert_crf_finance_change_status').html('<div class="alert alert-danger" role="alert">กรุณาเลือก สถานะการขอวงเงิน ด้วยค่ะ</div>');
                            $('#alert_crf_finance_change_number').html('<div class="alert alert-danger" role="alert">กรุณาระบุ จำนวนเงิน ที่ต้องการด้วยค่ะ</div>');
                            $('#user_submit').prop('disabled', true);
                            exit;
                        } else {
                            $('#alert_crf_finance_status').html('');
                            $('#alert_crf_finance_change_status').html('');
                            $('#alert_crf_finance_change_number').html('');
                            $('#user_submit').prop('disabled', false);
                        }
                    }

                });


            } else if ($(this).val() == 1) {
                // Zone ลูกค้าใหม่ Control input // Zone ลูกค้าใหม่ Control input// Zone ลูกค้าใหม่ Control input // Zone ลูกค้าใหม่ Control input
                // Zone ลูกค้าใหม่ Control input // Zone ลูกค้าใหม่ Control input // Zone ลูกค้าใหม่ Control input // Zone ลูกค้าใหม่ Control input
                // Zone ลูกค้าใหม่ Control input // Zone ลูกค้าใหม่ Control input // Zone ลูกค้าใหม่ Control input // Zone ลูกค้าใหม่ Control input

                // New code update 04-06-2020
                $('input:radio[class="crf_financev1"]').prop('checked', true);
                // $('input:radio[class="crf_financev2"]').prop('disabled', true);

                $('.finance_request_detail').css('display', '');


                // ช่อง Sales reps
                $('#crf_salesreps').prop('disabled', false);

                // ชื่อลูกค้า
                $('#crf_customername').prop('disabled', false);

                // วันที่ก่อตั้ง
                $('#crf_cuscompanycreate').prop('disabled', false);

                // เลขผู้เสียภาษี
                $('#crf_customertaxid').prop('disabled', false);

                // สาขา
                $('#crf_customerbranch').prop('disabled', false);

                // ประเภทที่อยู่
                $('input:radio[name="crf_addresstype"]').prop('disabled', false);
                $('#crf_addressname').prop('disabled', false);

                // ผู้ติดต่อ
                $('#crf_namecontact').prop('disabled', false);

                // เบอร์โทรของผู้ติดต่อ
                $('#crf_telcontact').prop('disabled', false);

                // เบอร์แฟ็ก
                $('#crf_faxcontact').prop('disabled', false);

                // Email
                $('#crf_emailcontact').prop('disabled', false);

                // ทุนจดทะเบียน
                $('#crf_regiscost').prop('disabled', false);

                // แผนที่ลิ้งจาก google
                $('#crf_mapurl').prop('disabled', false);

                // แผนที่ไฟล์อัพโหลด
                $('#crf_mapfile').prop('disabled', false);

                // ประเภทบริษัท
                $('input:radio[name="crf_companytype"]').prop('disabled', false);

                // ประเภทของธุรกิจ
                $('input:radio[name="crf_typeofbussi"]').prop('disabled', false);

                // ผลิตภัณฑ์ของลูกค้า
                $('#crf_customer_product').prop('disabled', false);

                // การคาดการ
                $('#crf_forecast').prop('disabled', false);



                $('input:radio[name="crf_person_type"]').click(function () {

                    if ($(this).val() == "natural") {
                        $('#for_natural').css('display', '');
                        $('#for_juristic').css('display', 'none');
                        // ไฟล์1
                        $('#crf_file_person').prop('disabled', false);
                        // ไฟล์1
                        $('#crf_file1').prop('disabled', true);

                        // ไฟล์1
                        $('#crf_file2').prop('disabled', true);

                        // ไฟล์1
                        $('#crf_file3').prop('disabled', true);

                        // ไฟล์1
                        $('#crf_file4').prop('disabled', true);

                        // ไฟล์1
                        $('#crf_file5').prop('disabled', true);

                        // ไฟล์1
                        $('#crf_file6').prop('disabled', true);

                        $('#crf_file_person').change(function(){
                            if($(this).val() != "")
                            {
                                $('#user_submit').prop('disabled', false);
                            }
                        });
                        
                    } else if ($(this).val() == "juristic") {
                        $('#for_natural').css('display', 'none');
                        $('#for_juristic').css('display', '');
                        // ไฟล์1
                        $('#crf_file_person').prop('disabled', true);
                        // ไฟล์1
                        $('#crf_file1').prop('disabled', false);

                        // ไฟล์1
                        $('#crf_file2').prop('disabled', false);

                        // ไฟล์1
                        $('#crf_file3').prop('disabled', false);

                        // ไฟล์1
                        $('#crf_file4').prop('disabled', false);

                        // ไฟล์1
                        $('#crf_file5').prop('disabled', false);

                        // ไฟล์1
                        $('#crf_file6').prop('disabled', false);
                    }

                });







                // credit term
                $('#crf_creditterm').prop('disabled', false);

                // เงื่อนไขการวางบิล
                $('input:radio[name="crf_condition_bill"]').prop('disabled', false);


                // เงื่อนไขการรับชำระเงิน
                $('input:radio[name="crf_condition_money"]').prop('disabled', false);

                // วงเงินการค้า
                $('input:radio[name="crf_finance"]').prop('disabled', false);

                // ช่องวงเงิน
                $('#crf_finance_req_number').prop('readonly', false);

                // Check ข้อมูลช่อง Sale Rep ว่ามีการกรอกข้อมูลหรือไม่

                $('.newPrimanage').css('display', '');
                $('#showPrimanage').css('display', 'none');


                $('#crf_salesreps').blur(function () {
                    if ($(this).val() == '') {
                        $('#alert_salesreps').html('<div class="alert alert-danger" role="alert">กรุณาระบุข้อมูล Sales Reps ด้วยค่ะ</div>');
                        $('#crf_customername').val('');
                    } else {
                        // เช็คความถูกต้องของการกรอก sales reps
                        if (minsalesreps($(this).val()) == false) {
                            $('#alert_salesreps').html('<div class="alert alert-danger" role="alert">กรุณาระบุข้อมูล Sales Reps ให้ถูกต้องด้วยค่ะ ต้องขึ้นต้นด้วย M หรือ D แล้วตามด้วยตัวเลข 4</div>');
                            $(this).val('');
                        } else {
                            $('#alert_salesreps').html('');
                            $('#user_submit').prop('disabled', false);
                        }
                    }
                });
                $('#crf_salesreps').focusout(function () {
                    if ($(this).val() == '') {
                        $('#alert_salesreps').html('<div class="alert alert-danger" role="alert">กรุณาระบุข้อมูล Sales Reps ด้วยค่ะ</div>');
                        $('#crf_customername').val('');
                    } else {
                        // เช็คความถูกต้องของการกรอก sales reps
                        if (minsalesreps($(this).val()) == false) {
                            $('#alert_salesreps').html('<div class="alert alert-danger" role="alert">กรุณาระบุข้อมูล Sales Reps ให้ถูกต้องด้วยค่ะ ต้องขึ้นต้นด้วย M หรือ D แล้วตามด้วยตัวเลข 4</div>');
                            $(this).val('');
                        } else {
                            $('#alert_salesreps').html('');
                            $('#user_submit').prop('disabled', false);

                        }
                    }
                });
                $('#crf_salesreps').keyup(function () {
                    if ($(this).val() == '') {
                        $('#alert_salesreps').html('<div class="alert alert-danger" role="alert">กรุณาระบุข้อมูล Sales Reps ด้วยค่ะ</div>');
                        $('#crf_customername').val('');
                    } else {
                        $('#alert_salesreps').html('');
                    }
                });
                // Check ข้อมูลช่อง Sale Rep ว่ามีการกรอกข้อมูลหรือไม่






                // Check ข้อมูลช่อง ชื่อลูกค้าว่ามีการกรอกข้อมูลหรือไม่
                $('#crf_customername').blur(function () {
                    var cusname = $('#crf_customername').val();
                    var comname = $('input:radio[name="crf_company"]:checked').val();
                    if ($(this).val() == '') {
                        $('#alert_customername').html('<div class="alert alert-danger" role="alert">กรุณาระบุชื่อลูกค้าด้วยค่ะ</div>');
                    } else {
                        $('#alert_customername').html('');
                        // checkDuplicateNameCustomer(cusname, comname);
                        $('#user_submit').prop('disabled', false);
                    }
                });
                $('#crf_customername').focusout(function () {
                    var cusname = $('#crf_customername').val();
                    var comname = $('input:radio[name="crf_company"]:checked').val();
                    if ($(this).val() == '') {
                        $('#alert_customername').html('<div class="alert alert-danger" role="alert">กรุณาระบุชื่อลูกค้าด้วยค่ะ</div>');
                    } else {
                        $('#alert_customername').html('');
                        if ($('#checkCompany').val() == 1) {
                            checkDuplicateNameCustomer(cusname, comname);
                        }
                        $('#user_submit').prop('disabled', false);
                    }
                });
                // Check ข้อมูลช่อง ชื่อลูกค้าว่ามีการกรอกข้อมูลหรือไม่





                // Check วันที่ก่อตั้งว่ามีการเลือกหรือไม่ // Check วันที่ก่อตั้งว่ามีการเลือกหรือไม่
                $('#crf_cuscompanycreate').blur(function () {
                    if ($(this).val() == '') {
                        $('#alert_cuscompanycreate').html('<div class="alert alert-danger" role="alert">กรุณาระบุวันที่ก่อตั้งด้วยค่ะ</div>');
                    } else {
                        $('#alert_cuscompanycreate').html('');
                        $('#user_submit').prop('disabled', false);
                    }
                });
                $('#crf_cuscompanycreate').focusout(function () {
                    if ($(this).val() == '') {
                        $('#alert_cuscompanycreate').html('<div class="alert alert-danger" role="alert">กรุณาระบุวันที่ก่อตั้งด้วยค่ะ</div>');
                    } else {
                        $('#alert_cuscompanycreate').html('');
                        $('#user_submit').prop('disabled', false);
                    }
                });

                $('#crf_cuscompanycreate').change(function () {
                    if ($(this).val() == '') {
                        $('#alert_cuscompanycreate').html('<div class="alert alert-danger" role="alert">กรุณาระบุวันที่ก่อตั้งด้วยค่ะ</div>');
                    } else {
                        $('#alert_cuscompanycreate').html('');
                        $('#user_submit').prop('disabled', false);
                    }
                });
                // Check วันที่ก่อตั้งว่ามีการเลือกหรือไม่ // Check วันที่ก่อตั้งว่ามีการเลือกหรือไม่



                // check เลขที่ผู้เสียภาษี
                $('#crf_customertaxid').blur(function () {
                    if ($(this).val() == '') {
                        $('#alert_crf_customertaxid').html('<div class="alert alert-danger" role="alert">กรุณาระบุเลขที่ประจำตัวผู้เสียภาษีด้วยค่ะ</div>');
                    } else {
                        if (checktax($(this).val()) == false) {
                            $('#alert_crf_customertaxid').html('<div class="alert alert-danger" role="alert">กรุณาระบุเลขที่ประจำตัวผู้เสียภาษีให้ครบถ้วยทั้ง 13 หลักโดยต้องระบุเป็นตัวเลขเท่านั้น</div>');
                            // $('#crf_customertaxid').val('');
                            $('#user_submit').prop('disabled', true);
                            $('#checkSubmitBtn').val(1);
                        } else {
                            $('#alert_crf_customertaxid').html('');
                            $('#user_submit').prop('disabled', false);
                        }
                    }
                });
                $('#crf_customertaxid').focusout(function () {
                    if ($(this).val() == '') {
                        $('#alert_crf_customertaxid').html('<div class="alert alert-danger" role="alert">กรุณาระบุเลขที่ประจำตัวผู้เสียภาษีด้วยค่ะ</div>');
                    } else {
                        if (checktax($(this).val()) == false) {
                            $('#alert_crf_customertaxid').html('<div class="alert alert-danger" role="alert">กรุณาระบุเลขที่ประจำตัวผู้เสียภาษีให้ครบถ้วยทั้ง 13 หลักโดยต้องระบุเป็นตัวเลขเท่านั้น</div>');
                            // $(this).val('');
                            $('#user_submit').prop('disabled', true);
                        } else {
                            $('#alert_crf_customertaxid').html('');
                            $('#user_submit').prop('disabled', false);
                        }
                    }
                });
                // check เลขที่ผู้เสียภาษี



                // Check สาขา
                $('#crf_customerbranch').blur(function () {
                    if ($(this).val() == '') {
                        $('#alert_crf_customerbranch').html('<div class="alert alert-danger" role="alert">กรุณาระบุสาขา ด้วยค่ะ</div>');
                    } else {
                        $('#alert_crf_customerbranch').html('');
                        $('#user_submit').prop('disabled', false);
                    }
                });
                $('#crf_customerbranch').focusout(function () {
                    if ($(this).val() == '') {
                        $('#alert_crf_customerbranch').html('<div class="alert alert-danger" role="alert">กรุณาระบุสาขา ด้วยค่ะ</div>');
                    } else {
                        $('#alert_crf_customerbranch').html('');
                        $('#user_submit').prop('disabled', false);
                    }
                });
                //Check สาขา




                // Check เลือกประเภทที่อยู่
                $('#crf_addressname').focus(function () {
                    var crf_addresstype = $('input:radio[name="crf_addresstype"]:checked');
                    if (crf_addresstype.length < 1) {
                        $('#alert_addresstype').html('<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทที่อยู่ด้วยค่ะ ด้วยค่ะ</div>');
                    } else {
                        $('#alert_addresstype').html('');
                        $('#user_submit').prop('disabled', false);
                    }
                });
                $('input:radio[name="crf_addresstype"]').click(function () {
                    if ($(this).val() == '') {
                        $('#alert_addresstype').html('<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทที่อยู่ด้วยค่ะ ด้วยค่ะ</div>');
                    } else {
                        $('#alert_addresstype').html('');
                        $('#user_submit').prop('disabled', false);
                    }
                });

                // Check เลือกประเภทที่อยู่





                // Check Address Name Check Address Name Check Address Name
                $('#crf_addressname').blur(function () {
                    if ($(this).val() == '') {
                        $('#alert_addressname').html('<div class="alert alert-danger" role="alert">กรุณาระบุที่อยู่สำหรับการเปิดใบกำกับภาษีด้วยค่ะ</div>');
                    } else {
                        $('#alert_addressname').html('');
                        $('#user_submit').prop('disabled', false);
                    }
                });
                $('#crf_addressname').focusout(function () {
                    if ($(this).val() == '') {
                        $('#alert_addressname').html('<div class="alert alert-danger" role="alert">กรุณาระบุที่อยู่สำหรับการเปิดใบกำกับภาษีด้วยค่ะ</div>');
                    } else {
                        $('#alert_addressname').html('');
                        $('#user_submit').prop('disabled', false);
                    }
                });
                $('#crf_addressname').keyup(function () {
                    if ($(this).val() == '') {
                        $('#alert_addressname').html('<div class="alert alert-danger" role="alert">กรุณาระบุที่อยู่สำหรับการเปิดใบกำกับภาษีด้วยค่ะ</div>');
                    } else {
                        $('#alert_addressname').html('');
                    }
                });
                // Check Address Name Check Address Name Check Address Name






                // Check ช่องผู้ติดต่อว่ามีการกรอกข้อมูลเข้ามาหรือไม่
                $('#crf_namecontact').blur(function () {
                    if ($(this).val() == '') {
                        $('#alert_namecontact').html('<div class="alert alert-danger" role="alert">กรุณาระบุชื่อผู้ติดต่อด้วยค่ะ</div>');
                    } else {
                        $('#alert_namecontact').html('');
                        $('#user_submit').prop('disabled', false);
                    }
                });
                $('#crf_namecontact').focusout(function () {
                    if ($(this).val() == '') {
                        $('#alert_namecontact').html('<div class="alert alert-danger" role="alert">กรุณาระบุชื่อผู้ติดต่อด้วยค่ะ</div>');
                    } else {
                        $('#alert_namecontact').html('');
                        $('#user_submit').prop('disabled', false);
                    }
                });

                $('#crf_namecontact').keyup(function () {
                    if ($(this).val() == '') {
                        $('#alert_namecontact').html('<div class="alert alert-danger" role="alert">กรุณาระบุชื่อผู้ติดต่อด้วยค่ะ</div>');
                    } else {
                        $('#alert_namecontact').html('');
                    }
                });
                // Check ช่องผู้ติดต่อว่ามีการกรอกข้อมูลเข้ามาหรือไม่





                // Check ช่องเบอร์โทรว่ามีการกรอกข้อมูลหรือไม่
                $('#crf_telcontact').blur(function () {
                    if ($(this).val() == '') {
                        $('#alert_telcontact').html('<div class="alert alert-danger" role="alert">กรุณาระบุเบอร์ผู้ติดต่อด้วยค่ะ</div>');
                    } else {
                        if (checkTelPat($(this).val()) == false) {
                            $('#alert_telcontact').html('<div class="alert alert-danger" role="alert">กรุณาระบุเฉพาะตัวเลขเท่านั้น</div>');
                            $('#user_submit').prop('disabled', true);
                        } else {
                            $('#alert_telcontact').html('');
                            $('#user_submit').prop('disabled', false);
                        }
                    }
                });

                $('#crf_telcontact').focusout(function () {
                    if ($(this).val() == '') {
                        $('#alert_telcontact').html('<div class="alert alert-danger" role="alert">กรุณาระบุเบอร์ผู้ติดต่อด้วยค่ะ</div>');
                    } else {
                        if (checkTelPat($(this).val()) == false) {
                            $('#alert_telcontact').html('<div class="alert alert-danger" role="alert">กรุณาระบุเฉพาะตัวเลขเท่านั้น</div>');
                            $('#user_submit').prop('disabled', true);
                        } else {
                            $('#alert_telcontact').html('');
                            $('#user_submit').prop('disabled', false);
                        }
                    }
                });

                $('#crf_telcontact').keyup(function () {
                    if ($(this).val() != '') {
                        $('#alert_telcontact').html('<div class="alert alert-danger" role="alert">กรุณาระบุเบอร์ผู้ติดต่อด้วยค่ะ</div>');
                    } else {
                        $('#alert_telcontact').html('');
                    }
                });
                // Check ช่องเบอร์โทรว่ามีการกรอกข้อมูลหรือไม่






                // Check ช่อง อีเมลว่ามีการกรอกข้อมูลหรือไม่
                // $('#crf_emailcontact').blur(function () {
                //     if ($(this).val() == '') {
                //         $('#alert_emailcontact').html('<div class="alert alert-danger" role="alert">กรุณาระบุอีเมลผู้ติดต่อด้วยค่ะ</div>');
                //     } else {
                //         $('#alert_emailcontact').html('');
                //     }
                // });
                // $('#crf_regiscost').focus(function () {
                //     if ($('#crf_emailcontact').val() == '') {
                //         $('#alert_emailcontact').html('<div class="alert alert-danger" role="alert">กรุณาระบุอีเมลผู้ติดต่อด้วยค่ะ</div>');
                //         $('#crf_regiscost').val('');
                //     } else {
                //         $('#alert_emailcontact').html('');
                //     }
                // });
                // $('#crf_regiscost').keyup(function () {
                //     if ($('#crf_emailcontact').val() == '') {
                //         $('#alert_emailcontact').html('<div class="alert alert-danger" role="alert">กรุณาระบุอีเมลผู้ติดต่อด้วยค่ะ</div>');
                //         $('#crf_regiscost').val('');
                //     } else {
                //         $('#alert_emailcontact').html('');
                //     }
                // });
                // $('#crf_emailcontact').keyup(function () {
                //     if ($(this).val() != '') {
                //         $('#alert_emailcontact').html('');
                //     }
                // });
                // Check ช่อง อีเมลว่ามีการกรอกข้อมูลหรือไม่






                // Check ช่อง ทุนจดทะเบียน
                $('#crf_regiscost').blur(function () {
                    if ($(this).val() == '') {
                        $('#alert_regiscost').html('<div class="alert alert-danger" role="alert">กรุณาระบุทุนจดทะเบียนด้วยค่ะ</div>');
                    } else {
                        $('#alert_regiscost').html('');
                        $('#user_submit').prop('disabled', false);
                    }
                });
                $('#crf_regiscost').focusout(function () {
                    if ($(this).val() == '') {
                        $('#alert_regiscost').html('<div class="alert alert-danger" role="alert">กรุณาระบุทุนจดทะเบียนด้วยค่ะ</div>');
                    } else {
                        $('#alert_regiscost').html('');
                        $('#user_submit').prop('disabled', false);
                    }
                });

                $('#crf_regiscost').keyup(function () {
                    if ($(this).val() == '') {
                        $('#alert_regiscost').html('<div class="alert alert-danger" role="alert">กรุณาระบุทุนจดทะเบียนด้วยค่ะ</div>');
                    } else {
                        $('#alert_regiscost').html('');
                    }
                });
                // Check ช่อง ทุนจดทะเบียน



                // Check ประเภทบริษัท

                // Check ประเภทบริษัท


                // Check ช่องรายชื่อบุคคลในแต่ระดับบริหารที่สำคัญ
                $('#crf_primanage_dept , #crf_primanage_name , #crf_primanage_posi , #crf_primanage_email').blur(function () {
                    if ($(this).val() == '') {
                        $('#alert_primanage').html('<div class="alert alert-danger" role="alert">กรุณาระบุข้อมูลให้ครบถ้วนด้วยค่ะ</div>');
                        $('input:radio[name="crf_typeofbussi"]').prop('checked', false);
                        exit;
                    } else {
                        $('#alert_primanage').html('');
                    }
                });

                $('input:radio[name="crf_typeofbussi"]').click(function () {
                    if ($('#crf_primanage_dept').val() == '' || $('#crf_primanage_name').val() == '' || $('#crf_primanage_posi').val() == '' || $('#crf_primanage_email').val() == '') {
                        $('#alert_primanage').html('<div class="alert alert-danger" role="alert">กรุณาระบุข้อมูลให้ครบถ้วนด้วยค่ะ</div>');
                        $('input:radio[name="crf_typeofbussi"]').prop('checked', false);
                        exit;
                    } else {
                        $('#alert_primanage').html('');
                    }
                });


                $('#crf_primanage_dept , #crf_primanage_name , #crf_primanage_posi , #crf_primanage_email').keyup(function () {
                    if ($(this).val() != '') {
                        $('#alert_primanage').html('');
                    }

                    var crf_companytype = $('input:radio[name="crf_companytype"]:checked');
                    if (crf_companytype.length < 1) {
                        $(this).val('');
                        $('#alert_companytype').html('<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทบริษัทด้วยค่ะ</div>');
                    } else {
                        $('#alert_primanage').html('');
                        $('#alert_companytype').html('');
                    }
                });
                // Check ช่องรายชื่อบุคคลในแต่ระดับบริหารที่สำคัญ




                // Check ประเภทของ ธุรกิจว่ามีการเลือกข้อมูลหรือไม่
                $(document).on('change', 'input[type="checkbox"][id="crf_process"]:checked', function () {
                    var crf_typeofbussi = $('input:radio[name="crf_typeofbussi"]:checked');
                    if (crf_typeofbussi.length < 1) {
                        $('#alert_typeofbussi').html('<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทธุรกิจด้วยค่ะ</div>');
                        $(this).prop('checked', false);
                        exit;
                    } else {
                        $('#alert_typeofbussi').html('');
                    }

                });
                // Check ประเภทของ ธุรกิจว่ามีการเลือกข้อมูลหรือไม่




                // Check กระบวนการผลิตว่ามีการเลือกข้อมูลเข้ามาหรือไม่
                $('#crf_forecast').focus(function () {
                    var crf_process = $('input[type="checkbox"][id="crf_process"]:checked');
                    if (crf_process.length < 1) {
                        $('#alert_process').html('<div class="alert alert-danger" role="alert">กรุณาเลือกกระบวนการผลิตหลักด้วยค่ะ</div>');
                        $(this).val('');
                    } else {
                        $('#alert_process').html('');
                    }
                });
                $('#crf_forecast').keyup(function () {
                    var crf_process = $('input[type="checkbox"][id="crf_process"]:checked');
                    if (crf_process.length < 1) {
                        $('#alert_process').html('<div class="alert alert-danger" role="alert">กรุณาเลือกกระบวนการผลิตหลักด้วยค่ะ</div>');
                        $(this).val('');
                    } else {
                        $('#alert_process').html('');
                    }

                    if ($(this).val() != '') {
                        $('#alert_forecast').html('');
                    }
                });
                // Check กระบวนการผลิตว่ามีการเลือกข้อมูลเข้ามาหรือไม่


                // Check คาดการปริมาณการขายว่ามีการกรอกข้อมูลงไปหรือไม่
                $('#crf_forecast').blur(function () {
                    if ($(this).val() == '') {
                        $('#alert_forecast').html('<div class="alert alert-danger" role="alert">กรุณาระบุรายละเอียดคาดการปริมาณการขายด้วยค่ะ</div>');
                    } else {
                        $('#alert_forecast').html('');
                    }
                });
                // Check คาดการปริมาณการขายว่ามีการกรอกข้อมูลงไปหรือไม่



                // Check File Upload ว่ามีการอัพโหลดไฟล์หรือยังก่อ่นที่จะเลือก Credit term
                $('#crf_creditterm').change(function () {


                    /////////////////////////////////////////////////////
                    // Check เงื่อนไขว่าเป็นลูกค้า บุคคล หรือ นิติบุคคล
                    ////////////////////////////////////////////////////

                    if ($('input:radio[name="crf_person_type"]:checked').val() == "natural") {
                        if ($('#crf_file_person').val() == '') {
                            $('#alert_file_person').html('<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ สำเนาบัตรประชาชน ด้วยค่ะ</div>');
                            $('#crf_creditterm').val('');
                        } else {
                            $('#alert_file_person').html('');
                            $('#user_submit').prop('disabled', false);
                        }
                    } else if ($('input:radio[name="crf_person_type"]:checked').val() == "juristic") {
                        if ($('#crf_file1').val() == '') {
                            $('#alert_file1').html('<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ ภพ.20 ด้วยค่ะ</div>');
                            $('#crf_creditterm').val('');
                        } else {
                            $('#alert_file1').html('');
                            $('#user_submit').prop('disabled', false);
                        }

                        if ($('#crf_file2').val() == '') {
                            $('#alert_file2').html('<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ หนังสือรับรอง ด้วยค่ะ</div>');
                            $('#crf_creditterm').val('');
                        } else {
                            $('#alert_file2').html('');
                            $('#user_submit').prop('disabled', false);
                        }

                        if ($('#crf_file3').val() == '') {
                            $('#alert_file3').html('<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ ข้อมูลทั่วไป ด้วยค่ะ</div>');
                            $('#crf_creditterm').val('');
                        } else {
                            $('#alert_file3').html('');
                            $('#user_submit').prop('disabled', false);
                        }

                        if ($('#crf_file4').val() == '') {
                            $('#alert_file4').html('<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ งบแสดงฐานะทางการเงิน ด้วยค่ะ</div>');
                            $('#crf_creditterm').val('');
                        } else {
                            $('#alert_file4').html('');
                            $('#user_submit').prop('disabled', false);
                        }

                        if ($('#crf_file5').val() == '') {
                            $('#alert_file5').html('<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ งบกำไรขาดทุน ด้วยค่ะ</div>');
                            $('#crf_creditterm').val('');
                        } else {
                            $('#alert_file5').html('');
                            $('#user_submit').prop('disabled', false);
                        }

                        if ($('#crf_file6').val() == '') {
                            $('#alert_file6').html('<div class="alert alert-danger" role="alert">กรุณาอัพโหลดไฟล์ อัตราส่วนสภาพคล่อง ด้วยค่ะ</div>');
                            $('#crf_creditterm').val('');
                        } else {
                            $('#alert_file6').html('');
                            $('#user_submit').prop('disabled', false);
                        }
                    }

                    /////////////////////////////////////////////////////
                    // Check เงื่อนไขว่าเป็นลูกค้า บุคคล หรือ นิติบุคคล
                    ////////////////////////////////////////////////////

                    if ($(this).val() != '') {
                        $('#alert_creditterm').html('');
                        $('input:radio[name="crf_condition_bill"]').prop('disabled', false);
                    } else {
                        $('#alert_creditterm').html('<div class="alert alert-danger" role="alert">กรุณาเลือก Credit Term ด้วยค่ะ</div>');
                        $('input:radio[name="crf_condition_bill"]').prop('checked', false);
                        $('input:radio[name="crf_condition_bill"]').prop('disabled', true);

                        $('input:radio[name="crf_condition_money"]').prop('checked', false);
                    }


                });
                // Check File Upload ว่ามีการอัพโหลดไฟล์หรือยังก่อ่นที่จะเลือก Credit term


                // Check Upload File 1 - 6 Element
                $('#crf_file1').change(function () {
                    if ($(this).val() != '') {
                        $('#alert_file1').html('');
                        $('#user_submit').prop('disabled', false);
                    }
                });

                $('#crf_file2').change(function () {
                    if ($(this).val() != '') {
                        $('#alert_file2').html('');
                        $('#user_submit').prop('disabled', false);
                    }
                });

                $('#crf_file3').change(function () {
                    if ($(this).val() != '') {
                        $('#alert_file3').html('');
                        $('#user_submit').prop('disabled', false);
                    }
                });

                $('#crf_file4').change(function () {
                    if ($(this).val() != '') {
                        $('#alert_file4').html('');
                        $('#user_submit').prop('disabled', false);
                    }
                });

                $('#crf_file5').change(function () {
                    if ($(this).val() != '') {
                        $('#alert_file5').html('');
                        $('#user_submit').prop('disabled', false);
                    }
                });

                $('#crf_file6').change(function () {
                    if ($(this).val() != '') {
                        $('#alert_file6').html('');
                        $('#user_submit').prop('disabled', false);
                    }
                });

                // Check Upload File 1 - 6 Element


                // Check Credit Term ว่ามีการเลือกหรือไม่
                $('input:radio[name="crf_condition_bill"]').click(function () {
                    if ($('#crf_creditterm').val() == '') {
                        $('#alert_creditterm').html('<div class="alert alert-danger" role="alert">กรุณาเลือก Credit Term ด้วยค่ะ</div>');
                        $('input:radio[name="crf_condition_bill"]').prop('checked', false);
                        $('input:radio[name="crf_condition_bill"]').prop('disabled', true);
                        exit;
                    } else {
                        $('#alert_creditterm').html('');
                    }


                });
                // Check Credit Term ว่ามีการเลือกหรือไม่


                // Check เงื่อนไขการวางบิล ว่าได้มีการเลือกแล้วหรือยัง
                $('input:radio[name="crf_condition_money"]').click(function () {
                    var crf_condition_bill = $('input:radio[name=crf_condition_bill]:checked');
                    if (crf_condition_bill.length < 1) {
                        $('#alert_condition_bill').html('<div class="alert alert-danger" role="alert">กรุณาเลือกเงื่อนไขการวางบิลด้วยค่ะ</div>');
                        $('input:radio[name="crf_condition_money"]').prop('checked', false);
                        exit;
                    } else {
                        $('#alert_condition_bill').html('');
                    }
                });
                // Check เงื่อนไขการวางบิล ว่าได้มีการเลือกแล้วหรือยัง


                // Check เงื่อนไขการรับชำระเงินว่ามีการเลือกข้อมูลถูกต้องหรือไม่
                if ($('#checkCusType').val() == 1) {
                    $('#crf_finance_req_number').focus(function () {
                        var crf_condition_money = $('input:radio[name="crf_condition_money"]:checked');
                        if (crf_condition_money.length < 1) {
                            $('#alert_condition_money').html('<div class="alert alert-danger" role="alert">กรุณาเลือกเงื่อนไขการชำระเงินด้วยค่ะ</div>');
                            $('#crf_finance_req_number').val('');
                        } else {
                            if (crf_condition_money.val() == 'รับเช็ค') {
                                if ($('#crf_recive_cheuqetable').val() == '') {
                                    $('#alert_recive_cheuqetable').html('<div class="alert alert-danger" role="alert">กรุณา แนบตารางวางบิล / รับเช็ค ด้วยค่ะ</div>');
                                    $('#crf_finance_req_number').val('');
                                } else {
                                    $('#alert_recive_cheuqetable').html('');
                                }

                                if ($('#crf_recive_cheuqedetail').val() == '') {
                                    $('#alert_recive_cheuqedetail').html('<div class="alert alert-danger" role="alert">กรุณา รายละเอียดเพิ่มเติม ด้วยค่ะ</div>');
                                    $('#crf_finance_req_number').val('');
                                } else {
                                    $('#alert_recive_cheuqedetail').html('');
                                }
                            } else {
                                $('#alert_condition_money').html('');
                            }
                        }
                    });

                    $('#crf_finance_req_number').keyup(function () {
                        var crf_condition_money = $('input:radio[name="crf_condition_money"]:checked');
                        if (crf_condition_money.length < 1) {
                            $('#alert_condition_money').html('<div class="alert alert-danger" role="alert">กรุณาเลือกเงื่อนไขการชำระเงินด้วยค่ะ</div>');
                            $('#crf_finance_req_number').val('');
                        } else {
                            if (crf_condition_money.val() == 'รับเช็ค') {
                                if ($('#crf_recive_cheuqetable').val() == '') {
                                    $('#alert_recive_cheuqetable').html('<div class="alert alert-danger" role="alert">กรุณา แนบตารางวางบิล / รับเช็ค ด้วยค่ะ</div>');
                                    $('#crf_finance_req_number').val('');
                                } else {
                                    $('#alert_recive_cheuqetable').html('');
                                }

                                if ($('#crf_recive_cheuqedetail').val() == '') {
                                    $('#alert_recive_cheuqedetail').html('<div class="alert alert-danger" role="alert">กรุณา รายละเอียดเพิ่มเติม ด้วยค่ะ</div>');
                                    $('#crf_finance_req_number').val('');
                                } else {
                                    $('#alert_recive_cheuqedetail').html('');
                                }
                            } else {
                                $('#alert_condition_money').html('');
                            }
                        }
                    });
                    // Check เงื่อนไขการรับชำระเงินว่ามีการเลือกข้อมูลถูกต้องหรือไม่
                }




                // Check ช่องวงเงินที่ต้องการว่ามีการกรอกข้อมูลหรือไม่
                $('#crf_finance_req_number').keyup(function () {
                    if ($('#crf_finance_req_number').val() != '') {
                        $('#user_submit').prop('disabled', false);
                    }
                });

                $('#crf_finance_req_number').blur(function () {
                    if ($('#crf_finance_req_number').val() != '') {
                        $('#user_submit').prop('disabled', false);
                    } else {
                        $('#user_submit').prop('disabled', true);
                    }
                });
                // Check ช่องวงเงินที่ต้องการว่ามีการกรอกข้อมูลหรือไม่


                // Check ขั้นตอนสุดท้าย
                // $('#user_submit').click(function(){
                //     checkBeforeSave();
                // })






            } else {

            }
            //Control credit term


        });

    }
    // End Control Add page

    //Control Radio crf_type Control หัวข้อ ลูกค้าใหม่ , ลูกค้าเดิม //Control Radio crf_type Control หัวข้อ ลูกค้าใหม่ , ลูกค้าเดิม
    //Control Radio crf_type Control หัวข้อ ลูกค้าใหม่ , ลูกค้าเดิม //Control Radio crf_type Control หัวข้อ ลูกค้าใหม่ , ลูกค้าเดิม


    // Remove Alert เมื่อมีการเลือกบริษัท
    $('input[type="radio"][name=crf_company]').click(function () {
        var crf_company = $('input[type="radio"][name=crf_company]:checked');
        if (crf_company.length > 0) {
            $('#alert_company').fadeOut();
        }
    });


    // Check การเลือกประเภทลูกค้า หากไม่ได้เลือกอะไรเลยจะไม่สามารถดำเนินการขั้นต่อไปได้
    $('#crf_salesreps').focus(function () {
        var crf_type = $('input[type="radio"][name=crf_type]:checked');
        if (crf_type.length < 1) {
            $('#alert_custype').html('<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทลูกค้าด้วยค่ะ</div>');
            $('#crf_salesreps').val('');
        } else {
            $('#alert_custype').fadeOut();
        }
    });

    $('#crf_salesreps').keyup(function () {
        var crf_type = $('input[type="radio"][name=crf_type]:checked');
        if (crf_type.length < 1) {
            $('#alert_custype').html('<div class="alert alert-danger" role="alert">กรุณาเลือกประเภทลูกค้าด้วยค่ะ</div>');
            $('#crf_salesreps').val('');

        } else {
            $('#alert_custype').fadeOut();
        }
    });
    // Check การเลือกประเภทลูกค้า หากไม่ได้เลือกอะไรเลยจะไม่สามารถดำเนินการขั้นต่อไปได้










    // Check Element Zone Check Element Zone Check Element Zone
    // Check Element Zone Check Element Zone Check Element Zone



    // Check Element Zone Check Element Zone Check Element Zone
    // Check Element Zone Check Element Zone Check Element Zone






    //Control if change credit term is clicked
    $(document).on('click', 'input[name=crf_change_creditterm]', function () {
        $('.change_credit_detail').toggle();
    });





    //Control Form Main ประเภทบริษัท
    $(document).on('click', '#crf_companytype:checked', function () {
        if ($(this).val() == 2) {
            $('#companytype2').css('display', '');
        } else {
            $('#companytype2').css('display', 'none');
        }

        if ($(this).val() == 3) {
            $('#companytype3').css('display', '');
        } else {
            $('#companytype3').css('display', 'none');
        }

    });





    //Zone Customer Profile
    var iPri = 1;
    $('#add_more_primanage').click(function (e) {
        iPri++;
        e.preventDefault();
        $(this).before('<div id="priManage' + iPri + '" class="row form-group">' +
            '<div class="col-md-3">' +
            '<label for="">หน่วยงาน</label>' +
            '<input type="text" name="crf_primanage_dept[]" id="crf_primanage_dept" class="form-control form-control-sm" required>' +
            '</div>' +
            '<div class="col-md-3">' +
            '<label for="">ชื่อ-สกุล</label>' +
            '<input type="text" name="crf_primanage_name[]" id="crf_primanage_name" class="form-control form-control-sm" required>' +
            '</div>' +
            '<div class="col-md-3">' +
            '<label for="">ตำแหน่ง</label>' +
            '<input type="text" name="crf_primanage_posi[]" id="crf_primanage_posi" class="form-control form-control-sm" required>' +
            '</div>' +
            '<div class="col-md-2">' +
            '<label for="">อีเมล</label>' +
            '<input type="text" name="crf_primanage_email[]" id="crf_primanage_email" class="form-control form-control-sm" required>' +
            '</div>' +
            '<div class="col-md-1 mt-4"><a href="javascript:void(0)"><button type="button" class="btn btn-danger"><i name="remove_pri" id="' + iPri + '" class="fas fa-trash-alt remove_pri"></i></button></a></div>' +
            '</div>');
    });

    $(document).on('click', '.remove_pri', function () {
        var buttonid = $(this).attr("id");
        $('#priManage' + buttonid + '').remove();
    });





    //Condition of bill Control
    $(document).on('click', 'input[name=crf_condition_bill]', function () {
        if ($(this).val() == 'วางบิลตามตาราง') {
            $('.crf_condition_bill2').css('display', '');
        } else {
            $('.crf_condition_bill2').css('display', 'none');
        }
        if ($(this).val() == 'วางบิลทุกวันที่') {
            $('.crf_condition_bill3').css('display', '');
        } else {
            $('.crf_condition_bill3').css('display', 'none');
        }
    });


    //Condition of recive money control (Transfer , cheuqe)
    $(document).on('click', 'input[name=crf_condition_money]', function () {

        if ($(this).val() == 'รับเช็ค') {
            $('.recive_cheuqe').css('display', '');
        } else {
            $('.recive_cheuqe').css('display', 'none');
        }
    });


    // Condition of finance type
    $(document).on('click', 'input[name=crf_finance]', function () {
        if ($(this).val() == 'ขอวงเงิน') {
            $('.finance_request_detail').css('display', '');
        } else {
            $('.finance_request_detail').css('display', 'none');
        }

        if ($(this).val() == 'ปรับวงเงิน') {
            $('.finance_change_detail').css('display', '');
        } else {
            $('.finance_change_detail').css('display', 'none');
        }
    });



    //Calculate up and down finance
    $('#finance_change_number').keyup(function () {
        var finance_change_number = $(this).val();
        var finance_change_old = $('#finance_change_old').val();
        if ($('#finance_change_status').val() == 'เพิ่ม') {
            var total = parseInt(finance_change_old) + parseInt(finance_change_number);
        } else if ($('#finance_change_status').val() == 'ลด') {
            var total = parseInt(finance_change_old) - parseInt(finance_change_number);
        }

        $('#finance_change_total').val(total);
    });




    // Convert Currency to comma
    $('input[name=crf_finance_req_number]').keyup(function (event) {/*****Comma function*******/

        // skip for arrow keys
        if (event.which >= 37 && event.which <= 40)
            return;

        // format number
        $(this).val(function (index, value) {
            return value
                .replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                ;
        });
    });

    // Convert Currency to comma
    $('input[name=crf_regiscost]').keyup(function (event) {/*****Comma function*******/

        // skip for arrow keys
        if (event.which >= 37 && event.which <= 40)
            return;

        // format number
        $(this).val(function (index, value) {
            return value
                .replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                ;
        });
    });


    // format number
    $('#crf_finance_req_number_view , #crf_regiscost_view  , #crf_finance_change_number_view , #crf_finance_change_total_view').val(function (index, value) {
        return value
            .replace(/\D/g, "")
            .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            ;
    });






    //Check File Format And Size //Check File Format And Size
    //Check File Format And Size //Check File Format And Size
    $('input[type=file][name=crf_file1],[name=crf_file2],[name=crf_file3],[name=crf_file4],[name=crf_file5],[name=crf_file6]').change(function () {
        var ext = $(this).val().split('.').pop().toLowerCase();
        //Allowed file types
        if ($.inArray(ext, ['pdf', 'jpg', 'png' , 'jpeg' , 'JPG' , 'PNG']) == -1) {
            alert('อัพโหลดได้เฉพาะไฟล์นามสกุล .pdf , .jpg , .png เท่านั้น !!'+ext);
            $(this).val("");
        }
        if (this.files[0].size > 20971520) {
            alert("Maximum File size is 10MB !!");
            this.value = "";
            exit;
        }
    });
    //Check File Format And Size //Check File Format And Size
    //Check File Format And Size //Check File Format And Size




    // $('input[type=file][name=crf_file2]').change(function (){
    //     var ext = $(this).val().split('.').pop().toLowerCase();
    // //Allowed file types
    // if ($.inArray(ext, ['pdf' , 'jpg' , 'png']) == -1) {
    //     alert('The file type is invalid!');
    //     $(this).val("");
    // }
    // if (this.files[0].size > 10485760) {
    //     alert("Maximum File size is 10MB !!");
    //     this.value = "";
    //     exit;
    // }
    // });


    ///////////////////////////////////////////////////////////////////
    /////////////////// Control View page
    //////////////////////////////////////////////////////////////////
    // Company Section Select
    if ($('#forcrf_company_view').val() == "sln") {
        $('input:radio[id="view_crf_company_sln"]').prop('checked', true);
    } else if ($('#forcrf_company_view').val() == "poly") {
        $('input:radio[id="view_crf_company_poly"]').prop('checked', true);
    } else if ($('#forcrf_company_view').val() == "ca") {
        $('input:radio[id="view_crf_company_ca"]').prop('checked', true);
    }else if($('#forcrf_company_view').val() == "tb"){
        $('input:radio[id="view_crf_company_tb"]').prop('checked', true);
    }else if($('#forcrf_company_view').val() == "st"){
        $('input:radio[id="view_crf_company_st"]').prop('checked', true);
    }


    // Customer Section Select
    if ($('#forcrf_type_view').val() == 1) {
        $('input:radio[id="crf_type1_view"]').prop('checked', true);
        $('.accForcus2').css('display', '');
    } else if ($('#forcrf_type_view').val() == 2) {
        $('input:radio[id="crf_type2_view"]').prop('checked', true);
        $('.cs_br').remove();
        // $('.account_staff').remove();
        $('.accForcus1').css('display', 'none');
    }


    /////////////////////////////////////////
    // Check personal type 
    /////////////////////////////////////////

    if ($('#forcrf_personal_type_view').val() == "natural") {
        $('input:radio[id="crf_person_type_natural"]').prop('checked', true);
        $('#view_file_juristic').css('display', 'none');
    } else if ($('#forcrf_personal_type_view').val() == "juristic") {
        $('input:radio[id="crf_person_type_juristic"]').prop('checked', true);
        $('#view_file_natural').css('display', 'none');
    }else{
        $('#view_file_natural').css('display', 'none');
    }

    /////////////////////////////////////////
    // Check personal type 
    /////////////////////////////////////////


    // Customer Old Select Section
    if ($('#forcrf_sub_oldcus_changearea_view').val() == 1) {
        $('input:checkbox[id="crf_sub_oldcus_changearea_view"]').prop('checked', true);
    }
    if ($('#forcrf_sub_oldcus_changeaddress_view').val() == 2) {
        $('input:checkbox[id="crf_sub_oldcus_changeaddress_view"]').prop('checked', true);
    }
    if ($('#forcrf_sub_oldcus_changecredit_view').val() == 3) {
        $('input:checkbox[id="crf_sub_oldcus_changecredit_view"]').prop('checked', true);
        $('.change_credit_detail , .change_credit').css('display', '');
        // if($('#checkStatus').val() == "Completed"){
        //     $('.change_credit_detail , .change_credit').css('display' , 'none');
        // }
    }
    if ($('#forcrf_sub_oldcus_changefinance_view').val() == 4) {
        $('input:checkbox[id="crf_sub_oldcus_changefinance_view"]').prop('checked', true);
    }

    if ($('#forcrf_sub_oldcus_editcustomer_view').val() == 5) {
        $('input:checkbox[id="crf_sub_oldcus_editcustomer_view"]').prop('checked', true);
    }


    // Control ที่อยู่สำหรับการเปิดใบกำกับภาษี
    if ($('#forcrf_addresstype_view').val() == "ตาม ภ.พ.20") {
        $('input:radio[id="crf_addresstype1_view"]').prop('checked', true);
    } else if ($('#forcrf_addresstype_view').val() == "อื่นๆ") {
        $('input:radio[id="crf_addresstype2_view"]').prop('checked', true);
    }


    // Control ประเภทบริษัท
    if ($('#forcrf_companytype_view').val() == 1) {
        $('input:radio[id="crf_companytype1_view"]').prop('checked', true);
    } else if ($('#forcrf_companytype_view').val() == 2) {
        $('#companytype2_view').css('display', '');
        $('input:radio[id="crf_companytype2_view"]').prop('checked', true);
    } else if ($('#forcrf_companytype_view').val() == 3) {
        $('#companytype3_view').css('display', '');
        $('input:radio[id="crf_companytype3_view"]').prop('checked', true);
    }



    // Control ประเภทธุระกิจ
    if ($('#forcrf_typeofbussi_view').val() == "ผู้ผลิต") {
        $('input:radio[id="crf_typeofbussi1_view"]').prop('checked', true);
    } else if ($('#forcrf_typeofbussi_view').val() == "ผู้ค้า") {
        $('input:radio[id="crf_typeofbussi2_view"]').prop('checked', true);
    }


    // Check mapfile upload
    if ($('#checkmapfile').val() == "") {
        $('#viewmapfile').css('display', 'none');
        $('#mapfilelink').attr('data-target', '');
    }
    if ($('#checkfilelink').val() == "") {
        $('#viewmapurl').css('display', 'none');
        $('#maplink').attr('href', 'javascript:voide(0)').removeAttr('target');
    }


    // Controle show file upload to modal
    $('#datafile1').click(function () {
        var dataFile1 = $(this).attr('data_file1');
        var url = '/intsys/crf/upload/';

        // $('#embedshowfile1').attr('src', url + dataFile1);

        var cutFileType1 = dataFile1.substr(-3, 4);
        if (cutFileType1 == 'jpg' || cutFileType1 == 'JPG' || cutFileType1 == 'png' || cutFileType1 == 'PNG') {
            $('#embedshowfile1Img').attr('src', url + dataFile1);
            $('#embedshowfile1').hide();
        } else {
            $('#embedshowfile1').attr('src', url + dataFile1);
            $('#embedshowfile1Img').hide();
        }
    });
    $('#datafile2').click(function () {
        var dataFile2 = $(this).attr('data_file2');
        var url = '/intsys/crf/upload/';

        // $('#embedshowfile2').attr('src', url + dataFile2);
        var cutFileType2 = dataFile2.substr(-3, 4);
        if (cutFileType2 == 'jpg' || cutFileType2 == 'JPG' || cutFileType2 == 'png' || cutFileType2 == 'PNG') {
            $('#embedshowfile2Img').attr('src', url + dataFile2);
            $('#embedshowfile2').hide();
        } else {
            $('#embedshowfile2').attr('src', url + dataFile2);
            $('#embedshowfile2Img').hide();
        }
    });
    $('#datafile3').click(function () {
        var dataFile3 = $(this).attr('data_file3');
        var url = '/intsys/crf/upload/';

        // $('#embedshowfile3').attr('src', url + dataFile3);
        var cutFileType3 = dataFile3.substr(-3, 4);
        if (cutFileType3 == 'jpg' || cutFileType3 == 'JPG' || cutFileType3 == 'png' || cutFileType3 == 'PNG') {
            $('#embedshowfile3Img').attr('src', url + dataFile3);
            $('#embedshowfile3').hide();
        } else {
            $('#embedshowfile3').attr('src', url + dataFile3);
            $('#embedshowfile3Img').hide();
        }
    });
    $('#datafile4').click(function () {
        var dataFile4 = $(this).attr('data_file4');
        var url = '/intsys/crf/upload/';

        // $('#embedshowfile4').attr('src', url + dataFile4);
        var cutFileType4 = dataFile4.substr(-3, 4);
        if (cutFileType4 == 'jpg' || cutFileType4 == 'JPG' || cutFileType4 == 'png' || cutFileType4 == 'PNG') {
            $('#embedshowfile4Img').attr('src', url + dataFile4);
            $('#embedshowfile4').hide();
        } else {
            $('#embedshowfile4').attr('src', url + dataFile4);
            $('#embedshowfile4Img').hide();
        }
    });
    $('#datafile5').click(function () {
        var dataFile5 = $(this).attr('data_file5');
        var url = '/intsys/crf/upload/';

        // $('#embedshowfile5').attr('src', url + dataFile5);
        var cutFileType5 = dataFile5.substr(-3, 4);
        if (cutFileType5 == 'jpg' || cutFileType5 == 'JPG' || cutFileType5 == 'png' || cutFileType5 == 'PNG') {
            $('#embedshowfile5Img').attr('src', url + dataFile5);
            $('#embedshowfile5').hide();
        } else {
            $('#embedshowfile5').attr('src', url + dataFile5);
            $('#embedshowfile5Img').hide();
        }
    });
    $('#datafile6').click(function () {
        var dataFile6 = $(this).attr('data_file6');
        var url = '/intsys/crf/upload/';

        // $('#embedshowfile6').attr('src', url + dataFile6);
        var cutFileType6 = dataFile6.substr(-3, 4);
        if (cutFileType6 == 'jpg' || cutFileType6 == 'JPG' || cutFileType6 == 'png' || cutFileType6 == 'PNG') {
            $('#embedshowfile6Img').attr('src', url + dataFile6);
            $('#embedshowfile6').hide();
        } else {
            $('#embedshowfile6').attr('src', url + dataFile6);
            $('#embedshowfile6Img').hide();
        }
    });


    // Control Condition of bill เงื่อนไขการวางบิล
    if ($('#forcrf_condition_bill_view').val() == 'ส่งของพร้อมวางบิล') {
        $('input:radio[id="crf_condition_bill1_view"]').prop('checked', true);
    } else if ($('#forcrf_condition_bill_view').val() == 'วางบิลตามตาราง') {
        $('input:radio[id="crf_condition_bill2_view"]').prop('checked', true);
        $('.crf_condition_bill2').css('display', '');
    } else if ($('#forcrf_condition_bill_view').val() == 'วางบิลทุกวันที่') {
        $('input:radio[id="crf_condition_bill3_view"]').prop('checked', true);
        $('.crf_condition_bill3').css('display', '');
    }

    // Show file on modal
    $('#tablebill').click(function () {
        var tablebill = $(this).attr('data_tablebill');
        var url = 'http://intranet.saleecolour.com/intsys/crf/upload/';

        // $('#embedshowfile7').attr('src', url + tablebill);
        var cutFileType7 = tablebill.substr(-3, 4);
        if (cutFileType7 == 'jpg' || cutFileType7 == 'JPG' || cutFileType7 == 'png' || cutFileType7 == 'PNG') {
            $('#embedshowfile7Img').attr('src', url + tablebill);
            $('#embedshowfile7').hide();
        } else {
            $('#embedshowfile7').attr('src', url + tablebill);
            $('#embedshowfile7Img').hide();
        }
    });
    $('#mapbill').click(function () {
        var mapbill = $(this).attr('data_mapbill');
        var url = 'http://intranet.saleecolour.com/intsys/crf/upload/';

        // $('#embedshowfile8').attr('src', url + mapbill);
        var cutFileType8 = mapbill.substr(-3, 4);
        if (cutFileType8 == 'jpg' || cutFileType8 == 'JPG' || cutFileType8 == 'png' || cutFileType8 == 'PNG') {
            $('#embedshowfile8Img').attr('src', url + mapbill);
            $('#embedshowfile8').hide();
        } else {
            $('#embedshowfile8').attr('src', url + mapbill);
            $('#embedshowfile8Img').hide();
        }
    });
    $('#mapbill2').click(function () {
        var mapbill2 = $(this).attr('data_mapbill2');
        var url = 'https://intranet.saleecolour.com/intsys/crf/upload/';

        // $('#embedshowfile9').attr('src', url + mapbill2);
        var cutFileType9 = mapbill2.substr(-3, 4);
        if (cutFileType9 == 'jpg' || cutFileType9 == 'JPG' || cutFileType9 == 'png' || cutFileType9 == 'PNG') {
            $('#embedshowfile9Img').attr('src', url + mapbill2);
            $('#embedshowfile9').hide();
        } else {
            $('#embedshowfile9').attr('src', url + mapbill2);
            $('#embedshowfile9Img').hide();
        }
    });



    // Control เงื่อนไขการรับชำระเงิน
    if ($('#forcrf_condition_money_view').val() == "โอนเงิน") {
        $('input:radio[id="crf_condition_money1_view"]').prop('checked', true);
    } else if ($('#forcrf_condition_money_view').val() == "รับเช็ค") {
        $('input:radio[id="crf_condition_money2_view"]').prop('checked', true);
        $('.recive_cheuqe').css('display', '');
    }
    $('#recive_cheuqetable').click(function () {
        var recive_cheuqetable = $(this).attr('data_recive_cheuqetable');
        var url = 'https://intranet.saleecolour.com/intsys/crf/upload/';

        // $('#embedshowfile10').attr('src', url + recive_cheuqetable);
        var cutFileType10 = recive_cheuqetable.substr(-3, 4);
        if (cutFileType10 == 'jpg' || cutFileType10 == 'JPG' || cutFileType10 == 'png' || cutFileType10 == 'PNG') {
            $('#embedshowfile10Img').attr('src', url + recive_cheuqetable);
            $('#embedshowfile10').hide();
        } else {
            $('#embedshowfile10').attr('src', url + recive_cheuqetable);
            $('#embedshowfile10Img').hide();
        }
    });




    // Control หัวข้อของวงเงินการค้า
    if ($('#forcrf_finance_view').val() == "ขอวงเงิน") {
        $('input:radio[id="crf_finance1_view"]').prop('checked', true);
        $('.finance_request_detail').css('display', '');
        $('#crf_finance_old_view , .labelcrf_finance_old_view').css('display', 'none');
    } else if ($('#forcrf_finance_view').val() == "ปรับวงเงิน") {
        $('input:radio[id="crf_finance2_view"]').prop('checked', true);
        $('.finance_change_detail').css('display', '');
    }


    // Master input Control Section
    // Master input Control Section
    var checkStatus = $('#checkStatus').val();
    var checkUserPost = $('#checkUserPost').val();
    var checkDeptCode = $('#checkDeptCode').val();
    var checkUserecode = $('#checkUserecode').val();

    var checkDeptCodeL = $('#checkDeptCodeL').val();
    var checkUserecodeL = $('#checkUserecodeL').val();
    var checkUserPosi = $('#checkUserPosi').val();

    var changeSales = $('#forcrf_sub_oldcus_changearea_view').val();
    var changeAddress = $('#forcrf_sub_oldcus_changeaddress_view').val();
    var changeCreditTerm = $('#forcrf_sub_oldcus_changecredit_view').val();
    var changeFinance = $('#forcrf_sub_oldcus_changefinance_view').val();
    var editCustomer = $('#forcrf_sub_oldcus_editcustomer_view').val();
    // Master input Control Section
    // Master input Control Section


    // Control btn edit
    if (checkStatus == "Open" || checkStatus == "Edited") {
        $('#btnEditZone').css('display', '');
    }


    // Control credit term complate
    if (checkStatus == "Completed") {
        $('.creditTermComplete').css('display', '');
        $('.creditTermOpen').css('display', 'none');
    }

    // Control Cancel status
    if (checkStatus == "Cancel") {
        $('#cancel').remove();
    }


    // Control CS , Sales Approve

    if (checkDeptCodeL == checkDeptCode && checkUserecodeL != checkUserecode && checkUserPosi > 15) {//ตรวจสอบเงื่อนไขการ อนุมัติของผู้จัดการ Sales และผู้จัดการ CS โดยเงื่อนไขคือ เช็คว่า ที่ Login เข้ามานั้นใช่ของแผนกตัวเองหรือไม่ หากใช่ เช็คอีกว่าคนแจ้งกับคนอนุมัติ คนๆเดียวกันหรือไม่ จากนั้นเช็คอีกว่าไม่ใช่ Staff ใช่หรือไม่ หากตรงตามเงื่อนหมด เข้าสู่อีกขั้นตอนหนึ่ง
        if(checkUserecodeL == "M0051" || checkUserecodeL == "M0112" || checkUserecodeL == "M0040" || checkUserecodeL == "M1848"){
            $('.author_manager').css('display', '');
        }
    }else if(checkUserecode == "M1848"){
        //สำหรับการสร้างเองอนุมัติเอง
        if(checkUserecodeL == "M1848"){
            $('.author_manager').css('display', '');
        }
    }else if(checkUserecode == "M0051"){
        //สำหรับการสร้างเองอนุมัติเอง
        if(checkUserecodeL == "M0051"){
            $('.author_manager').css('display', '');
        }
    }else if(checkUserecodeL == "M1848"){
        //ปรับให้สามารถอนุมัติแทนพี่พลได้
        $('.author_manager').css('display', '');
    }
    else if (checkStatus == "Manager Approved" || checkStatus == "CS POST BR" || checkStatus == "Account Manager Approved" || checkStatus == "Directors approved" || checkStatus == "Waiting for second director approve" || checkStatus == "Completed" || checkStatus == "Account staff process" || checkStatus == "Manager Not Approve" || checkStatus == "Account Manager Not approve" || checkStatus == "Director Not approve") {
        $('.author_manager').css('display', '');
    }
    else {
        $('.author_manager').css('display', 'none');
    }


    if ($('#formgr_appro').val() != "") {
        $('#crf_mgrapprovedetail , #crf_mgrapprove_name , #crf_mgrapprove_datetime , #mgr_submit ,#mgr_appro').css('display', 'none');
        if ($('#formgr_appro').val() == "อนุมัติ") {
            $('input:radio[id="formgr_appro1"]').prop('checked', true);
        } else if ($('#formgr_appro').val() == "ไม่อนุมัติ") {
            $('input:radio[id="formgr_appro0"]').prop('checked', true);
        } else {

        }
    } else {
        $('#forcrf_mgrapprovedetail , #forcrf_mgrapprove_name , #forcrf_mgrapprove_datetime ,#formgr_appro , #forcrf_mgrapprove_detail').css('display', 'none');
    }


    // validate submit button
    $('#mgr_submit').prop('disabled', true);
    $('input:radio[name="mgr_appro"]').click(function () {
        if ($(this).val() != '') {
            $('#mgr_submit').prop('disabled', false);
        } else {
            $('#mgr_submit').prop('disabled', true);
        }
    });






    // Control CS Form
    if (checkDeptCodeL == 1010 && $('#formgr_appro').val() == "อนุมัติ" && changeSales != 1 && changeAddress != 2 && changeCreditTerm != 3 && changeFinance != 4 || checkUserecodeL == "M0019" && $('#formgr_appro').val() == "อนุมัติ" || 
    checkUserecodeL == "M1905" && $('#formgr_appro').val() == "อนุมัติ" || 
    checkUserecodeL == "M2119" && $('#formgr_appro').val() == "อนุมัติ") {
        $('.cs_br').css('display', '');

    } else if (checkStatus == "CS POST BR" || checkStatus == "Account Manager Approved" || checkStatus == "Waiting for second director approve" || checkStatus == "Directors approved" || checkStatus == "Completed") {
        $('.cs_br').css('display', '');
    } else {
        $('.cs_br').css('display', 'none');
    }

    if ($('#forcheckcrf_brcode').val() == "") {
        $('#forcrf_brcode , #forcrf_brcode_userpost , #forcrf_becode_datetime').css('display', 'none');
    } else {
        $('#crf_brcode , #crf_brcode_userpost , #crf_becode_datetime , #br_submit').css('display', 'none');
    }

    $('#br_submit').prop('disabled', true);
    $('#crf_brcode').click(function () {
        if ($('#crf_brcode').val() == '') {
            $('#br_submit').prop('disabled', true);
        } else {
            $('#br_submit').prop('disabled', false);
        }
    });
    $('#crf_brcode').keyup(function () {
        if ($('#crf_brcode').val() == '') {
            $('#br_submit').prop('disabled', true);
        } else {
            $('#br_submit').prop('disabled', false);
        }
    });
    $('#crf_brcode').blur(function () {
        if ($('#crf_brcode').val() == '') {
            $('#br_submit').prop('disabled', true);
        } else {
            $('#br_submit').prop('disabled', false);
        }
    });






    // Control Account Manager
    if (checkStatus == "CS POST BR" && checkDeptCodeL == 1003 && checkUserPosi > 15 || 
    checkStatus == "CS POST BR" && checkUserecodeL == "M1260" || checkStatus == "CS POST BR" && checkUserecodeL == "M2217") {
        $('.acc_manager').css('display', '');
        if ($('#formgraccappro').val() == "") {
            $('.formgr_appro , #forcrf_accmgr_detail , #forcrf_accmgr_name , #forcrf_accmgr_datatime').css('display', 'none');
        }
    } else if (checkStatus == "Manager Approved" && checkDeptCodeL == 1003 && checkUserPosi > 15 && changeSales == 1 || 
    checkStatus == "Manager Approved" && checkDeptCodeL == 1003 && checkUserPosi > 15 && changeAddress == 2 || 
    checkStatus == "Manager Approved" && checkDeptCodeL == 1003 && checkUserPosi > 15 && changeCreditTerm == 3 || 
    checkStatus == "Manager Approved" && checkDeptCodeL == 1003 && checkUserPosi > 15 && changeFinance == 4 || 
    checkStatus == "Manager Approved" && checkDeptCodeL == 1003 && checkUserPosi > 15 && editCustomer == 5) {
        $('.acc_manager').css('display', '');
        if ($('#formgraccappro').val() == "") {
            $('.formgr_appro , #forcrf_accmgr_detail , #forcrf_accmgr_name , #forcrf_accmgr_datatime').css('display', 'none');
        }
    }else if(checkStatus == "Manager Approved" && checkUserecodeL == "M2217" && changeSales == 1 || 
    checkStatus == "Manager Approved" && checkUserecodeL == "M2217" && changeAddress == 2 || 
    checkStatus == "Manager Approved" && checkUserecodeL == "M2217" && changeCreditTerm == 3 || 
    checkStatus == "Manager Approved" && checkUserecodeL == "M2217" && changeFinance == 4 || 
    checkStatus == "Manager Approved" && checkUserecodeL == "M2217" && editCustomer == 5){
        $('.acc_manager').css('display', '');
        if ($('#formgraccappro').val() == "") {
            $('.formgr_appro , #forcrf_accmgr_detail , #forcrf_accmgr_name , #forcrf_accmgr_datatime').css('display', 'none');
        }
    }

    if (checkStatus == "Account Manager Approved" || checkStatus == "Waiting for second director approve" || checkStatus == "Directors approved" || checkStatus == "Completed" || checkStatus == "Account staff process" || checkStatus == "Account Manager Not approve" || checkStatus == "Director Not approve") {
        $('.acc_manager').css('display', '');
        if ($('#formgraccappro').val() == "") {
            $('.formgr_appro , #forcrf_accmgr_detail , #forcrf_accmgr_name , #forcrf_accmgr_datatime').css('display', 'none');
        } else {
            $('.mgr_appro , #crf_accmgr_detail , #crf_accmgr_name ,#crf_accmgr_datatime ,#accmgr_submit').css('display', 'none')
        }
    }

    if ($('#formgraccappro').val() == "อนุมัติ") {
        $('input:radio[id="formgracc_appro1"]').prop('checked', true);
    } else if ($('#formgraccappro').val() == "ไม่อนุมัติ") {
        $('input:radio[id="formgracc_appro2"]').prop('checked', true);
    } else {

    }

    // validate submit form
    $('#accmgr_submit').prop('disabled', true);
    $('input:radio[name="mgracc_appro"]').click(function () {
        if ($(this).val() != '') {
            $('#accmgr_submit').prop('disabled', false);
        } else {
            $('#accmgr_submit').prop('disabled', true);
        }
    });




    // Control Director1 Approve Section
    if (checkStatus == "Account Manager Approved" && checkUserPosi > 75 || checkStatus == "Waiting for second director approve" && checkUserPosi > 75 || checkStatus == "Account Manager Approved" && checkUserecodeL == "M0025" || checkStatus == "Waiting for second director approve" && checkUserecodeL == "M0025" || checkStatus == "Account Manager Approved" && checkUserecodeL == "M0015" || checkStatus == "Waiting for second director approve" && checkUserecodeL == "M0015") {
        $('.director1').css('display', '');
        if ($('#checkfordirector1_appro').val() == "") {
            $('.fordirector1_appro , #forcrf_director_detail1 ,#forcrf_director_name1 , #forcrf_director_datatime1').css('display', 'none');
        } else {
            $('.director1_appro , #crf_director_detail1 ,#crf_director_name1 , #crf_director_datatime1 , #director_submit1').css('display', 'none');
        }
    } else if (checkStatus == "Waiting for second director approve" || checkStatus == "Second director approved" || checkStatus == "Directors approved" || checkStatus == "Director Not approve" || checkStatus == "Completed") {
        $('.director1').css('display', '');
        $('.director1_appro , #crf_director_detail1 ,#crf_director_name1 , #crf_director_datatime1 , #director_submit1').css('display', 'none');
    }


    if ($('#checkfordirector1_appro').val() == "อนุมัติ") {
        $('input:radio[id="fordirector1_appro1"]').prop('checked', true);
    } else if ($('#checkfordirector1_appro').val() == "ไม่อนุมัติ") {
        $('input:radio[id="fordirector1_appro2"]').prop('checked', true);
    }

    // validate submit button
    $('#director_submit1').prop('disabled', true);
    if ($('#crf_director_name1').val() == $('#forcrf_director_name2').val()) {
        $('#director_submit1').hide();
    } else {
        $('input:radio[name="director1_appro"]').click(function () {
            if ($(this).val() != '') {
                $('#director_submit1').prop('disabled', false);
            } else {
                $('#director_submit1').prop('disabled', true);
            }
        });
    }






    // Control Director2 Approve Section
    if (checkStatus == "Account Manager Approved" && checkUserPosi > 75 || checkStatus == "Waiting for second director approve" && checkUserPosi > 75 || checkStatus == "Account Manager Approved" && checkUserecodeL == "M0025" || checkStatus == "Waiting for second director approve" && checkUserecodeL == "M0025" || checkStatus == "Account Manager Approved" && checkUserecodeL == "M0015" || checkStatus == "Waiting for second director approve" && checkUserecodeL == "M0015") {
        $('.director2').css('display', '');
        if ($('#checkfordirector2_appro').val() == "") {
            $('.fordirector2_appro , #forcrf_director_detail2 ,#forcrf_director_name2 , #forcrf_director_datatime2').css('display', 'none');
        } else {
            $('.director2_appro , #crf_director_detail2 ,#crf_director_name2 , #crf_director_datatime2 , #director_submit2').css('display', 'none');
        }
    } else if (checkStatus == "Waiting for second director approve" || checkStatus == "Directors approved" || checkStatus == "Director Not approve" || checkStatus == "Completed") {
        $('.director2').css('display', '');
        $('.director2_appro , #crf_director_detail2 ,#crf_director_name2 , #crf_director_datatime2 , #director_submit2').css('display', 'none');
    }

    if ($('#checkfordirector2_appro').val() == "อนุมัติ") {
        $('input:radio[id="fordirector2_appro1"]').prop('checked', true);
    } else if ($('#checkfordirector2_appro').val() == "ไม่อนุมัติ") {
        $('input:radio[id="fordirector2_appro2"]').prop('checked', true);
    }

    // validate submit button
    $('#director_submit2').prop('disabled', true);
    if ($('#crf_director_name2').val() == $('#forcrf_director_name1').val()) {
        $('#director_submit2').hide();
    } else {
        $('input:radio[name="director2_appro"]').click(function () {
            if ($(this).val() != '') {
                $('#director_submit2').prop('disabled', false);
            } else {
                $('#director_submit2').prop('disabled', true);
            }
        });
    }





    // Account staff process.
    // Directors approved
    // Completed
    // Control Account Staff Section
    if (checkStatus == "Directors approved" && checkDeptCodeL == 1003 || checkStatus == "Account staff process" && checkDeptCodeL == 1003) {
        $('.account_staff').css('display', '');
        if ($('#checkCustomercode').val() == "") {
            $('#forcusCode ,#forcusCode_userPost , #fcusCode_datetimePost , #foraccStaffMemo').css('display', 'none');
        }
    } else if (checkStatus == "Completed") {
        $('.account_staff').css('display', '');
        $('#cusCode ,#cusCode_userPost , #cusCode_datetimePost , #acc_staff , #accStaffMemo').css('display', 'none');
    }

    $('#goto_cuscode_form').on('click', function () {
        var data_crf_id = $(this).attr('data_crf_id');
        $('#accstaff_crfid').val(data_crf_id);
    });


    // validate submit button
    $('#acc_staff').prop('disabled', true);
    $('#cusCode').click(function () {
        // if ($(this).val() != '') {
        //     $('#acc_staff').prop('disabled', false);
        // } else {
        //     $('#acc_staff').prop('disabled', true);
        // }

        if($('#forcrf_company_view').val() == "tb"){
            if (checkTBDC($(this).val()) != true) {
                $('#acc_staff').prop('disabled', true);
                $('#alertCheckTH').html('<div class="alert alert-danger" role="alert">กรุณากรอก TBDC ให้ถูกต้องค่ะ (ตัวอย่าง TBDC-0000)</div>');
            } else {
                $('#acc_staff').prop('disabled', false);
                $('#alertCheckTH').html('');
            }
        }else if($('#forcrf_company_view').val() == "st"){
            if (checkSTDC($(this).val()) != true) {
                $('#acc_staff').prop('disabled', true);
                $('#alertCheckTH').html('<div class="alert alert-danger" role="alert">กรุณากรอก STDC ให้ถูกต้องค่ะ (ตัวอย่าง STDC-0000)</div>');
            } else {
                $('#acc_staff').prop('disabled', false);
                $('#alertCheckTH').html('');
            }
        }else{
            if (checkTH($(this).val()) != true) {
                $('#acc_staff').prop('disabled', true);
                $('#alertCheckTH').html('<div class="alert alert-danger" role="alert">กรุณากรอก TH ให้ถูกต้องค่ะ (ตัวอย่าง TH-0000)</div>');
            } else {
                $('#acc_staff').prop('disabled', false);
                $('#alertCheckTH').html('');
            }
        }

        
    });

    if($('#forcrf_type_view').val() == "2"){
        $('#accStaffMemo').click(function () {
            if ($(this).val() != '') {
                $('#acc_staff').prop('disabled', false);
            } else {
                $('#acc_staff').prop('disabled', true);
            }
        });
    }
    
    $('#cusCode').keyup(function () {
        // if ($(this).val() != '') {
        //     $('#acc_staff').prop('disabled', false);
        // } else {
        //     $('#acc_staff').prop('disabled', true);
        // }

        if($('#forcrf_company_view').val() == "tb"){
            if (checkTBDC($(this).val()) != true) {
                $('#acc_staff').prop('disabled', true);
                $('#alertCheckTH').html('<div class="alert alert-danger" role="alert">กรุณากรอก TBDC ให้ถูกต้องค่ะ (ตัวอย่าง TBDC-0000)</div>');
            } else {
                $('#acc_staff').prop('disabled', false);
                $('#alertCheckTH').html('');
            }
        }else if($('#forcrf_company_view').val() == "st"){
            if (checkSTDC($(this).val()) != true) {
                $('#acc_staff').prop('disabled', true);
                $('#alertCheckTH').html('<div class="alert alert-danger" role="alert">กรุณากรอก STDC ให้ถูกต้องค่ะ (ตัวอย่าง STDC-0000)</div>');
            } else {
                $('#acc_staff').prop('disabled', false);
                $('#alertCheckTH').html('');
            }
        }else{
            if (checkTH($(this).val()) != true) {
                $('#acc_staff').prop('disabled', true);
                $('#alertCheckTH').html('<div class="alert alert-danger" role="alert">กรุณากรอก TH ให้ถูกต้องค่ะ (ตัวอย่าง TH-0000)</div>');
            } else {
                $('#acc_staff').prop('disabled', false);
                $('#alertCheckTH').html('');
            }
        }

        
    });

    if($('#forcrf_type_view').val() == "2"){
        $('#accStaffMemo').keyup(function () {
            if ($(this).val() != '') {
                $('#acc_staff').prop('disabled', false);
            } else {
                $('#acc_staff').prop('disabled', true);
            }
        });
    }
    
    $('#cusCode').blur(function () {
        // if ($(this).val() != '') {
        //     $('#acc_staff').prop('disabled', false);
        // } else {
        //     $('#acc_staff').prop('disabled', true);
        // }

        if($('#forcrf_company_view').val() == "tb"){
            if (checkTBDC($(this).val()) != true) {
                $('#acc_staff').prop('disabled', true);
                $('#alertCheckTH').html('<div class="alert alert-danger" role="alert">กรุณากรอก TBDC ให้ถูกต้องค่ะ (ตัวอย่าง TBDC-0000)</div>');
            } else {
                $('#acc_staff').prop('disabled', false);
                $('#alertCheckTH').html('');
            }
        }else if($('#forcrf_company_view').val() == "st"){
            if (checkSTDC($(this).val()) != true) {
                $('#acc_staff').prop('disabled', true);
                $('#alertCheckTH').html('<div class="alert alert-danger" role="alert">กรุณากรอก STDC ให้ถูกต้องค่ะ (ตัวอย่าง STDC-0000)</div>');
            } else {
                $('#acc_staff').prop('disabled', false);
                $('#alertCheckTH').html('');
            }
        }else{
            if (checkTH($(this).val()) != true) {
                $('#acc_staff').prop('disabled', true);
                $('#alertCheckTH').html('<div class="alert alert-danger" role="alert">กรุณากรอก TH ให้ถูกต้องค่ะ (ตัวอย่าง TH-0000)</div>');
            } else {
                $('#acc_staff').prop('disabled', false);
                $('#alertCheckTH').html('');
            }
        }
    });





    // Control Save Data ลูกค้าเก่า
    // $('#crf_customercode').on('keyup', function () {
    //     var cusCode = $(this).val();
    //     if (cusCode != '') {
    //         autoSearchCustomerDetail(cusCode);
    //     } else {
    //         $('#autoCusCode').html('')
    //     }

    // });

    $(document).on('click', '.selectCusCode', function () {

        var data_crf_salesreps = $(this).attr('data_crf_salesreps');
        var data_crf_customername = $(this).attr('data_crf_customername');
        var data_crf_cuscompanycreate = $(this).attr('data_crf_cuscompanycreate');
        var data_crf_addressname = $(this).attr('data_crf_addressname');
        var data_crf_namecontact = $(this).attr('data_crf_namecontact');
        var data_crf_telcontact = $(this).attr('data_crf_telcontact');
        var data_crf_faxcontact = $(this).attr('data_crf_faxcontact');
        var data_crf_emailcontact = $(this).attr('data_crf_emailcontact');
        var data_crf_regiscost = $(this).attr('data_crf_regiscost');
        var data_crf_customercode = $(this).attr('data_crf_customercode');
        var data_oldcfr_addresstype = $(this).attr('data_oldcfr_addresstype');
        var data_crf_companytype = $(this).attr('data_crf_companytype');
        var data_crf_companytype3_1_1 = $(this).attr('data_crf_companytype3_1_1');
        var data_crf_companytype3_1_2 = $(this).attr('data_crf_companytype3_1_2');
        var data_crf_companytype3_2_1 = $(this).attr('data_crf_companytype3_2_1');
        var data_crf_companytype3_2_2 = $(this).attr('data_crf_companytype3_2_2');
        var data_crf_companytype2 = $(this).attr('data_crf_companytype2');
        var data_crf_typeofbussi = $(this).attr('data_crf_typeofbussi');
        var data_crf_forecast = $(this).attr('data_crf_forecast');

        // เพิ่มข้อมูลใหม่ 04/08/2020
        var data_crf_textmemo = $(this).attr('data_crf_textmemo');

        var data_credit_name = $(this).attr('data_credit_name');
        var data_credit_id = $(this).attr('data_credit_id');
        var data_crf_condition_bill = $(this).attr('data_crf_condition_bill');
        var data_crf_tablebill = $(this).attr('data_crf_tablebill');
        var data_crf_mapbill = $(this).attr('data_crf_mapbill');
        var data_crf_datebill = $(this).attr('data_crf_datebill');
        var data_crf_mapbill2 = $(this).attr('data_crf_mapbill2');
        var data_crf_condition_money = $(this).attr('data_crf_condition_money');
        var data_crf_recive_cheuqetable = $(this).attr('data_crf_recive_cheuqetable');
        var data_crf_recive_cheuqedetail = $(this).attr('data_crf_recive_cheuqedetail');
        // var data_crf_finance = $(this).attr('data_crf_finance');
        var data_crf_finance_req_number = $(this).attr('data_crf_finance_req_number');
        var data_crf_cusid = $(this).attr('data_crf_cusid');
        var data_crf_creditterm2 = $(this).attr('data_crf_creditterm2');
        var data_crf_creditterm2name = $(this).attr('data_crf_creditterm2name');
        var data_crf_moneylimit = $(this).attr('data_crf_moneylimit');
        var data_crf_area = $(this).attr('data_crf_area');
        var data_crf_file1 = $(this).attr('data_crf_file1');
        var data_crf_taxid = $(this).attr('data_crf_taxid');
        var data_crf_branch = $(this).attr('data_crf_branch');
        var data_crf_mapurl = $(this).attr('data_crf_mapurl');
        var data_crf_mapfile = $(this).attr('data_crf_mapfile');
        var data_crfcus_products = $(this).attr('data_crfcus_products');
        var data_crfcus_personal = $(this).attr('data_crfcus_personal');
        var data_crfcus_file1 = $(this).attr('data_crfcus_file1');
        var data_crfcus_file2 = $(this).attr('data_crfcus_file2');
        var data_crfcus_file3 = $(this).attr('data_crfcus_file3');
        var data_crfcus_file4 = $(this).attr('data_crfcus_file4');
        var data_crfcus_file5 = $(this).attr('data_crfcus_file5');
        var data_crfcus_file6 = $(this).attr('data_crfcus_file6');

        var base_url = $('#checkbaseurl').val();

        // check money limit
        


        // For not change attach file
        $('#editcusoldpersonal').val(data_crfcus_personal);
        $('#editcusoldfile1').val(data_crfcus_file1);
        $('#editcusoldfile2').val(data_crfcus_file2);
        $('#editcusoldfile3').val(data_crfcus_file3);
        $('#editcusoldfile4').val(data_crfcus_file4);
        $('#editcusoldfile5').val(data_crfcus_file5);
        $('#editcusoldfile6').val(data_crfcus_file6);


        // Zone get file to add page


        $('#cus2showfilePersonal').html('<span><a id="custype2filePersonal" href="' + base_url + 'upload/' + data_crfcus_personal + '" target="_blank">' + data_crfcus_personal + '</a></span>');

        // $('#custype2filePersonal').click(function () {
        //     var dataFilePersonal = $(this).attr('data_cus2filePersonal');
        //     var url = base_url + 'upload/';

        //     // $('#embedshowfile1').attr('src', url + dataFile1);

        //     var cutFileTypePersonal = dataFilePersonal.substr(-3, 4);
        //     if (cutFileTypePersonal == 'jpg' || cutFileTypePersonal == 'JPG' || cutFileTypePersonal == 'png' || cutFileTypePersonal == 'PNG') {
        //         $('#embedshowfilePersonalImg').attr('src', url + cutFileTypePersonal);
        //         $('#embedshowfilePersonal').hide();
        //     } else {
        //         $('#embedshowfilePersonal').attr('src', url + cutFileTypePersonal);
        //         $('#embedshowfilePersonalImg').hide();
        //     }
        // });




        $('#cus2showfile1').html('<span><a id="custype2file1" href="#" data-toggle="modal" data-target="#show_file1" data_cus2file1="' + data_crfcus_file1 + '">' + data_crfcus_file1 + '</a></span>');

        $('#custype2file1').click(function () {
            var dataFile1 = $(this).attr('data_cus2file1');
            var url = base_url + 'upload/';

            // $('#embedshowfile1').attr('src', url + dataFile1);

            var cutFileType1 = dataFile1.substr(-3, 4);
            if (cutFileType1 == 'jpg' || cutFileType1 == 'JPG' || cutFileType1 == 'png' || cutFileType1 == 'PNG') {
                $('#embedshowfile1Img').attr('src', url + dataFile1);
                $('#embedshowfile1').hide();
            } else {
                $('#embedshowfile1').attr('src', url + dataFile1);
                $('#embedshowfile1Img').hide();
            }
        });


        $('#cus2showfile2').html('<span><a id="custype2file2" href="#" data-toggle="modal" data-target="#show_file2" data_cus2file2="' + data_crfcus_file2 + '">' + data_crfcus_file2 + '</a></span>');

        $('#custype2file2').click(function () {
            var dataFile2 = $(this).attr('data_cus2file2');
            var url = base_url + 'upload/';

            // $('#embedshowfile1').attr('src', url + dataFile1);

            var cutFileType2 = dataFile2.substr(-3, 4);
            if (cutFileType2 == 'jpg' || cutFileType2 == 'JPG' || cutFileType2 == 'png' || cutFileType2 == 'PNG') {
                $('#embedshowfile2Img').attr('src', url + dataFile2);
                $('#embedshowfile2').hide();
            } else {
                $('#embedshowfile2').attr('src', url + dataFile2);
                $('#embedshowfile2Img').hide();
            }
        });


        $('#cus2showfile3').html('<span><a id="custype2file3" href="#" data-toggle="modal" data-target="#show_file3" data_cus2file3="' + data_crfcus_file3 + '">' + data_crfcus_file3 + '</a></span>');

        $('#custype2file3').click(function () {
            var dataFile3 = $(this).attr('data_cus2file3');
            var url = base_url + 'upload/';

            // $('#embedshowfile1').attr('src', url + dataFile1);

            var cutFileType3 = dataFile3.substr(-3, 4);
            if (cutFileType3 == 'jpg' || cutFileType3 == 'JPG' || cutFileType3 == 'png' || cutFileType3 == 'PNG') {
                $('#embedshowfile3Img').attr('src', url + dataFile3);
                $('#embedshowfile3').hide();
            } else {
                $('#embedshowfile3').attr('src', url + dataFile3);
                $('#embedshowfile3Img').hide();
            }
        });


        $('#cus2showfile4').html('<span><a id="custype2file4" href="#" data-toggle="modal" data-target="#show_file4" data_cus2file4="' + data_crfcus_file4 + '">' + data_crfcus_file4 + '</a></span>');

        $('#custype2file4').click(function () {
            var dataFile4 = $(this).attr('data_cus2file4');
            var url = base_url + 'upload/';

            // $('#embedshowfile1').attr('src', url + dataFile1);

            var cutFileType4 = dataFile4.substr(-3, 4);
            if (cutFileType4 == 'jpg' || cutFileType4 == 'JPG' || cutFileType4 == 'png' || cutFileType4 == 'PNG') {
                $('#embedshowfile4Img').attr('src', url + dataFile4);
                $('#embedshowfile4').hide();
            } else {
                $('#embedshowfile4').attr('src', url + dataFile4);
                $('#embedshowfile4Img').hide();
            }
        });


        $('#cus2showfile5').html('<span><a id="custype2file5" href="#" data-toggle="modal" data-target="#show_file5" data_cus2file5="' + data_crfcus_file5 + '">' + data_crfcus_file5 + '</a></span>');

        $('#custype2file5').click(function () {
            var dataFile5 = $(this).attr('data_cus2file5');
            var url = base_url + 'upload/';

            // $('#embedshowfile1').attr('src', url + dataFile1);

            var cutFileType5 = dataFile5.substr(-3, 4);
            if (cutFileType5 == 'jpg' || cutFileType5 == 'JPG' || cutFileType5 == 'png' || cutFileType5 == 'PNG') {
                $('#embedshowfile5Img').attr('src', url + dataFile5);
                $('#embedshowfile5').hide();
            } else {
                $('#embedshowfile5').attr('src', url + dataFile5);
                $('#embedshowfile5Img').hide();
            }
        });


        $('#cus2showfile6').html('<span><a id="custype2file6" href="#" data-toggle="modal" data-target="#show_file6" data_cus2file6="' + data_crfcus_file6 + '">' + data_crfcus_file6 + '</a></span>');

        $('#custype2file6').click(function () {
            var dataFile6 = $(this).attr('data_cus2file6');
            var url = base_url + 'upload/';

            // $('#embedshowfile1').attr('src', url + dataFile1);

            var cutFileType6 = dataFile6.substr(-3, 4);
            if (cutFileType6 == 'jpg' || cutFileType6 == 'JPG' || cutFileType6 == 'png' || cutFileType6 == 'PNG') {
                $('#embedshowfile6Img').attr('src', url + dataFile6);
                $('#embedshowfile6').hide();
            } else {
                $('#embedshowfile6').attr('src', url + dataFile6);
                $('#embedshowfile6Img').hide();
            }
        });



        $('#crf_customercode').val(data_crf_customercode);
        $('#crf_salesreps').val(data_crf_salesreps);
        $('#crf_customername').val(data_crf_customername);
        $('#crf_cuscompanycreate').val(data_crf_cuscompanycreate);
        $('#crf_addressname').val(data_crf_addressname);
        $('#crf_namecontact').val(data_crf_namecontact);
        $('#crf_telcontact').val(data_crf_telcontact);
        $('#crf_faxcontact').val(data_crf_faxcontact);
        $('#crf_emailcontact').val(data_crf_emailcontact);
        $('#crf_regiscost').val(data_crf_regiscost);
        $('#crf_forecast').val(data_crf_forecast);

        // เพิ่มข้อมูลใหม่ 04/08/2020
        $('#crf_textmemo').val(data_crf_textmemo);

        $('#crf_customertaxid').val(data_crf_taxid);
        $('#crf_customerbranch').val(data_crf_branch);
        $('#getmapurl_addpage').val(data_crf_mapurl);
        $('#getlinkgooglemap').attr('href', data_crf_mapurl);
        $('#mapfilelink').attr('data_mapfile', data_crf_mapfile);
        $('#getmapfile_addpage').val(data_crf_mapfile);
        $('#crf_customer_product').val(data_crfcus_products);

        // $('#value_crf_finance').val(data_crf_finance);

        $('#crf_creditterm option:selected').val(data_credit_id).text(data_credit_name);
        $('#oldCreditTerm').val(data_credit_id);


        $('#crf_finance_req_number , #crf_finance_req_number_calc').val(data_crf_moneylimit);
        $('#crf_cusid').val(data_crf_cusid);

        if (data_crf_area == 'sln') {
            $('#crf_company_sln').prop('checked', true);
        }
        if (data_crf_area == 'poly') {
            $('#crf_company_poly').prop('checked', true);
        }
        if (data_crf_area == 'ca') {
            $('#crf_company_ca').prop('checked', true);
        }

        $('#addThArea').val(data_crf_area);



        if (data_oldcfr_addresstype == "ตาม ภ.พ.20") {
            $('input:radio[id="crf_addresstype1"]').prop('checked', true);
        } else {
            $('input:radio[id="crf_addresstype2"]').prop('checked', true);
        }


        if (data_crf_companytype == 1) {
            $('input:radio[class="crf_companytype1"]').prop('checked', true);
        } else if (data_crf_companytype == 2) {
            $('input:radio[class="crf_companytype2"]').prop('checked', true);
            $('#companytype2').css('display', '');
            $('#crf_companytype2').val(data_crf_companytype2);
        } else {
            $('input:radio[class="crf_companytype3"]').prop('checked', true);
            $('#companytype3').css('display', '');
            $('#crf_companytype3_1_1').val(data_crf_companytype3_1_1);
            $('#crf_companytype3_1_2').val(data_crf_companytype3_1_2);
            $('#crf_companytype3_2_1').val(data_crf_companytype3_2_1);
            $('#crf_companytype3_2_2').val(data_crf_companytype3_2_2);
        }


        if (data_crf_typeofbussi == 'ผู้ผลิต') {
            $('input:radio[class="crf_typeofbussi1"]').prop('checked', true);
        } else {
            $('input:radio[class="crf_typeofbussi2"]').prop('checked', true);
        }

        $('.newPrimanage').css('display', 'none');
        $('#showPrimanage').css('display', '');
        queryProcessUse(data_crf_cusid);
        queryPrimanageUse(data_crf_cusid);


        if (data_crf_condition_bill == 'ส่งของพร้อมวางบิล') {
            $('input:radio[class="crf_condition_billv1"]').prop('checked', true);
        } else if (data_crf_condition_bill == 'วางบิลตามตาราง') {
            $('input:radio[class="crf_condition_billv2"]').prop('checked', true);
            $('.crf_condition_bill2').css('display', '');
            $('.oldcustomer1').css('display', '').val(data_crf_tablebill);
            $('.oldcustomer1').prop('readonly', true);
            $('.oldcustomer2').css('display', '').val(data_crf_mapbill);
            $('.oldcustomer2').prop('readonly', true);
            $('.newcustomer1').remove();
            $('.newcustomer2').remove();
        } else if (data_crf_condition_bill == 'วางบิลทุกวันที่') {
            $('input:radio[class="crf_condition_billv3"]').prop('checked', true);
            $('.crf_condition_bill3').css('display', '');
            $('#crf_datebill').val(data_crf_datebill);
            $('.newcustomer3').remove();
            $('.oldcustomer3').css('display', '').val(data_crf_mapbill2);
        }

        if (data_crf_condition_money == "โอนเงิน") {
            $('input:radio[class="crf_condition_moneyv1"]').prop('checked', true);
        } else if (data_crf_condition_money == "รับเช็ค") {
            $('input:radio[class="crf_condition_moneyv2"]').prop('checked', true);
            $('.recive_cheuqe').css('display', '');
            $('.newcustomer4').remove();
            $('.oldcustomer4').css('display', '').val(data_crf_recive_cheuqetable);
            $('.oldcustomer4').prop('readonly', true);
            $('#crf_recive_cheuqedetail').val(data_crf_recive_cheuqedetail);
            $('#crf_recive_cheuqedetail').prop('readonly', true);
        }


        // if (data_crf_finance == "ขอวงเงิน") {
        //     $('input:radio[class="crf_financev1"]').prop('checked', true);
        //     $('.finance_request_detail').css('display', '');
        //     $('#crf_finance_req_number').val(data_crf_finance_req_number);
        // } else if (data_crf_finance == "ปรับวงเงิน") {
        //     $('input:radio[class="crf_financev2"]').prop('checked', true);
        // }

        $('#crf_finance_req_number , #crf_regiscost').val(function (index, value) {
            return value
                .replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                ;
        });



        $('#autoCusCode').html('')
        $('input:checkbox[id="crf_sub_oldcus"]').attr('onclick' , 'return false');

    });




    // Auto search customer name
    // $('#crf_customername').on('keyup', function () {
    //     var cusname = $(this).val();

    //     if (cusname != '') {
    //         autoSearchCustomerDetailName(cusname);
    //     } else {
    //         $('#autoCusname').html('')
    //     }
    // });


    $(document).on('click', '.selectCusName', function () {
        var data_crf_salesreps = $(this).attr('data_crf_salesreps');
        var data_crf_customername = $(this).attr('data_crf_customername');
        var data_crf_cuscompanycreate = $(this).attr('data_crf_cuscompanycreate');
        var data_crf_addressname = $(this).attr('data_crf_addressname');
        var data_crf_namecontact = $(this).attr('data_crf_namecontact');
        var data_crf_telcontact = $(this).attr('data_crf_telcontact');
        var data_crf_faxcontact = $(this).attr('data_crf_faxcontact');
        var data_crf_emailcontact = $(this).attr('data_crf_emailcontact');
        var data_crf_regiscost = $(this).attr('data_crf_regiscost');
        var data_crf_customercode = $(this).attr('data_crf_customercode');
        var data_oldcfr_addresstype = $(this).attr('data_oldcfr_addresstype');
        var data_crf_companytype = $(this).attr('data_crf_companytype');
        var data_crf_companytype3_1_1 = $(this).attr('data_crf_companytype3_1_1');
        var data_crf_companytype3_1_2 = $(this).attr('data_crf_companytype3_1_2');
        var data_crf_companytype3_2_1 = $(this).attr('data_crf_companytype3_2_1');
        var data_crf_companytype3_2_2 = $(this).attr('data_crf_companytype3_2_2');
        var data_crf_companytype2 = $(this).attr('data_crf_companytype2');
        var data_crf_typeofbussi = $(this).attr('data_crf_typeofbussi');
        var data_crf_forecast = $(this).attr('data_crf_forecast');

        // เพิ่มข้อมูลใหม่ 04/08/2020
        var data_crf_textmemo = $(this).attr('data_crf_textmemo');

        var data_credit_name = $(this).attr('data_credit_name');
        var data_credit_id = $(this).attr('data_credit_id');
        var data_crf_condition_bill = $(this).attr('data_crf_condition_bill');
        var data_crf_tablebill = $(this).attr('data_crf_tablebill');
        var data_crf_mapbill = $(this).attr('data_crf_mapbill');
        var data_crf_datebill = $(this).attr('data_crf_datebill');
        var data_crf_mapbill2 = $(this).attr('data_crf_mapbill2');
        var data_crf_condition_money = $(this).attr('data_crf_condition_money');
        var data_crf_recive_cheuqetable = $(this).attr('data_crf_recive_cheuqetable');
        var data_crf_recive_cheuqedetail = $(this).attr('data_crf_recive_cheuqedetail');
        // var data_crf_finance = $(this).attr('data_crf_finance');
        var data_crf_finance_req_number = $(this).attr('data_crf_finance_req_number');
        var data_crf_cusid = $(this).attr('data_crf_cusid');
        var data_crf_creditterm2 = $(this).attr('data_crf_creditterm2');
        var data_crf_creditterm2name = $(this).attr('data_crf_creditterm2name');
        var data_crf_moneylimit = $(this).attr('data_crf_moneylimit');
        var data_crf_area = $(this).attr('data_crf_area');
        var data_crf_file1 = $(this).attr('data_crf_file1');
        var data_crf_taxid = $(this).attr('data_crf_taxid');
        var data_crf_branch = $(this).attr('data_crf_branch');
        var data_crf_mapurl = $(this).attr('data_crf_mapurl');
        var data_crf_mapfile = $(this).attr('data_crf_mapfile');
        var data_crfcus_products = $(this).attr('data_crfcus_products');
        var data_crfcus_personal = $(this).attr('data_crfcus_personal');
        var data_crfcus_file1 = $(this).attr('data_crfcus_file1');
        var data_crfcus_file2 = $(this).attr('data_crfcus_file2');
        var data_crfcus_file3 = $(this).attr('data_crfcus_file3');
        var data_crfcus_file4 = $(this).attr('data_crfcus_file4');
        var data_crfcus_file5 = $(this).attr('data_crfcus_file5');
        var data_crfcus_file6 = $(this).attr('data_crfcus_file6');

        var base_url = $('#checkbaseurl').val();


        // For not change attach file
        $('#editcusoldpersonal').val(data_crfcus_personal);
        $('#editcusoldfile1').val(data_crfcus_file1);
        $('#editcusoldfile2').val(data_crfcus_file2);
        $('#editcusoldfile3').val(data_crfcus_file3);
        $('#editcusoldfile4').val(data_crfcus_file4);
        $('#editcusoldfile5').val(data_crfcus_file5);
        $('#editcusoldfile6').val(data_crfcus_file6);


        // Zone get file to add page
        $('#cus2showfilePersonal').html('<span><a id="custype2filePersonal" href="' + base_url + 'upload/' + data_crfcus_personal + '" target="_blank">' + data_crfcus_personal + '</a></span>');


        $('#cus2showfile1').html('<span><a id="custype2file1" href="#" data-toggle="modal" data-target="#show_file1" data_cus2file1="' + data_crfcus_file1 + '">' + data_crfcus_file1 + '</a></span>');

        $('#custype2file1').click(function () {
            var dataFile1 = $(this).attr('data_cus2file1');
            var url = base_url + 'upload/';

            // $('#embedshowfile1').attr('src', url + dataFile1);

            var cutFileType1 = dataFile1.substr(-3, 4);
            if (cutFileType1 == 'jpg' || cutFileType1 == 'JPG' || cutFileType1 == 'png' || cutFileType1 == 'PNG') {
                $('#embedshowfile1Img').attr('src', url + dataFile1);
                $('#embedshowfile1').hide();
            } else {
                $('#embedshowfile1').attr('src', url + dataFile1);
                $('#embedshowfile1Img').hide();
            }
        });


        $('#cus2showfile2').html('<span><a id="custype2file2" href="#" data-toggle="modal" data-target="#show_file2" data_cus2file2="' + data_crfcus_file2 + '">' + data_crfcus_file2 + '</a></span>');

        $('#custype2file2').click(function () {
            var dataFile2 = $(this).attr('data_cus2file2');
            var url = base_url + 'upload/';

            // $('#embedshowfile1').attr('src', url + dataFile1);

            var cutFileType2 = dataFile2.substr(-3, 4);
            if (cutFileType2 == 'jpg' || cutFileType2 == 'JPG' || cutFileType2 == 'png' || cutFileType2 == 'PNG') {
                $('#embedshowfile2Img').attr('src', url + dataFile2);
                $('#embedshowfile2').hide();
            } else {
                $('#embedshowfile2').attr('src', url + dataFile2);
                $('#embedshowfile2Img').hide();
            }
        });


        $('#cus2showfile3').html('<span><a id="custype2file3" href="#" data-toggle="modal" data-target="#show_file3" data_cus2file3="' + data_crfcus_file3 + '">' + data_crfcus_file3 + '</a></span>');

        $('#custype2file3').click(function () {
            var dataFile3 = $(this).attr('data_cus2file3');
            var url = base_url + 'upload/';

            // $('#embedshowfile1').attr('src', url + dataFile1);

            var cutFileType3 = dataFile3.substr(-3, 4);
            if (cutFileType3 == 'jpg' || cutFileType3 == 'JPG' || cutFileType3 == 'png' || cutFileType3 == 'PNG') {
                $('#embedshowfile3Img').attr('src', url + dataFile3);
                $('#embedshowfile3').hide();
            } else {
                $('#embedshowfile3').attr('src', url + dataFile3);
                $('#embedshowfile3Img').hide();
            }
        });


        $('#cus2showfile4').html('<span><a id="custype2file4" href="#" data-toggle="modal" data-target="#show_file4" data_cus2file4="' + data_crfcus_file4 + '">' + data_crfcus_file4 + '</a></span>');

        $('#custype2file4').click(function () {
            var dataFile4 = $(this).attr('data_cus2file4');
            var url = base_url + 'upload/';

            // $('#embedshowfile1').attr('src', url + dataFile1);

            var cutFileType4 = dataFile4.substr(-3, 4);
            if (cutFileType4 == 'jpg' || cutFileType4 == 'JPG' || cutFileType4 == 'png' || cutFileType4 == 'PNG') {
                $('#embedshowfile4Img').attr('src', url + dataFile4);
                $('#embedshowfile4').hide();
            } else {
                $('#embedshowfile4').attr('src', url + dataFile4);
                $('#embedshowfile4Img').hide();
            }
        });


        $('#cus2showfile5').html('<span><a id="custype2file5" href="#" data-toggle="modal" data-target="#show_file5" data_cus2file5="' + data_crfcus_file5 + '">' + data_crfcus_file5 + '</a></span>');

        $('#custype2file5').click(function () {
            var dataFile5 = $(this).attr('data_cus2file5');
            var url = base_url + 'upload/';

            // $('#embedshowfile1').attr('src', url + dataFile1);

            var cutFileType5 = dataFile5.substr(-3, 4);
            if (cutFileType5 == 'jpg' || cutFileType5 == 'JPG' || cutFileType5 == 'png' || cutFileType5 == 'PNG') {
                $('#embedshowfile5Img').attr('src', url + dataFile5);
                $('#embedshowfile5').hide();
            } else {
                $('#embedshowfile5').attr('src', url + dataFile5);
                $('#embedshowfile5Img').hide();
            }
        });


        $('#cus2showfile6').html('<span><a id="custype2file6" href="#" data-toggle="modal" data-target="#show_file6" data_cus2file6="' + data_crfcus_file6 + '">' + data_crfcus_file6 + '</a></span>');

        $('#custype2file6').click(function () {
            var dataFile6 = $(this).attr('data_cus2file6');
            var url = base_url + 'upload/';

            // $('#embedshowfile1').attr('src', url + dataFile1);

            var cutFileType6 = dataFile6.substr(-3, 4);
            if (cutFileType6 == 'jpg' || cutFileType6 == 'JPG' || cutFileType6 == 'png' || cutFileType6 == 'PNG') {
                $('#embedshowfile6Img').attr('src', url + dataFile6);
                $('#embedshowfile6').hide();
            } else {
                $('#embedshowfile6').attr('src', url + dataFile6);
                $('#embedshowfile6Img').hide();
            }
        });



        $('#crf_customercode').val(data_crf_customercode);
        $('#crf_salesreps').val(data_crf_salesreps);
        $('#crf_customername').val(data_crf_customername);
        $('#crf_cuscompanycreate').val(data_crf_cuscompanycreate);
        $('#crf_addressname').val(data_crf_addressname);
        $('#crf_namecontact').val(data_crf_namecontact);
        $('#crf_telcontact').val(data_crf_telcontact);
        $('#crf_faxcontact').val(data_crf_faxcontact);
        $('#crf_emailcontact').val(data_crf_emailcontact);
        $('#crf_regiscost').val(data_crf_regiscost);
        $('#crf_forecast').val(data_crf_forecast);

        // เพิ่มข้อมูลใหม่ 04/08/2020
        $('#crf_textmemo').val(data_crf_textmemo);

        $('#crf_customertaxid').val(data_crf_taxid);
        $('#crf_customerbranch').val(data_crf_branch);
        $('#getmapurl_addpage').val(data_crf_mapurl);
        $('#getlinkgooglemap').attr('href', data_crf_mapurl);
        $('#mapfilelink').attr('data_mapfile', data_crf_mapfile);
        $('#getmapfile_addpage').val(data_crf_mapfile);
        $('#crf_customer_product').val(data_crfcus_products);

        // $('#value_crf_finance').val(data_crf_finance);

        $('#crf_creditterm option:selected').val(data_credit_id).text(data_credit_name);
        $('#oldCreditTerm').val(data_credit_id);

        $('#crf_finance_req_number , #crf_finance_req_number_calc').val(data_crf_moneylimit);
        $('#crf_cusid').val(data_crf_cusid);

        if (data_crf_area == 'sln') {
            $('#crf_company_sln').prop('checked', true);
        }
        if (data_crf_area == 'poly') {
            $('#crf_company_poly').prop('checked', true);
        }
        if (data_crf_area == 'ca') {
            $('#crf_company_ca').prop('checked', true);
        }

        $('#addThArea').val(data_crf_area);



        if (data_oldcfr_addresstype == "ตาม ภ.พ.20") {
            $('input:radio[id="crf_addresstype1"]').prop('checked', true);
        } else {
            $('input:radio[id="crf_addresstype2"]').prop('checked', true);
        }


        if (data_crf_companytype == 1) {
            $('input:radio[class="crf_companytype1"]').prop('checked', true);
        } else if (data_crf_companytype == 2) {
            $('input:radio[class="crf_companytype2"]').prop('checked', true);
            $('#companytype2').css('display', '');
            $('#crf_companytype2').val(data_crf_companytype2);
        } else {
            $('input:radio[class="crf_companytype3"]').prop('checked', true);
            $('#companytype3').css('display', '');
            $('#crf_companytype3_1_1').val(data_crf_companytype3_1_1);
            $('#crf_companytype3_1_2').val(data_crf_companytype3_1_2);
            $('#crf_companytype3_2_1').val(data_crf_companytype3_2_1);
            $('#crf_companytype3_2_2').val(data_crf_companytype3_2_2);
        }


        if (data_crf_typeofbussi == 'ผู้ผลิต') {
            $('input:radio[class="crf_typeofbussi1"]').prop('checked', true);
        } else {
            $('input:radio[class="crf_typeofbussi2"]').prop('checked', true);
        }

        $('.newPrimanage').css('display', 'none');

        queryProcessUse(data_crf_cusid);
        queryPrimanageUse(data_crf_cusid);


        if (data_crf_condition_bill == 'ส่งของพร้อมวางบิล') {
            $('input:radio[class="crf_condition_billv1"]').prop('checked', true);
        } else if (data_crf_condition_bill == 'วางบิลตามตาราง') {
            $('input:radio[class="crf_condition_billv2"]').prop('checked', true);
            $('.crf_condition_bill2').css('display', '');
            $('.oldcustomer1').css('display', '').val(data_crf_tablebill);
            $('.oldcustomer1').prop('readonly', true);
            $('.oldcustomer2').css('display', '').val(data_crf_mapbill);
            $('.oldcustomer2').prop('readonly', true);
            $('.newcustomer1').remove();
            $('.newcustomer2').remove();
        } else if (data_crf_condition_bill == 'วางบิลทุกวันที่') {
            $('input:radio[class="crf_condition_billv3"]').prop('checked', true);
            $('.crf_condition_bill3').css('display', '');
            $('#crf_datebill').val(data_crf_datebill);
            $('.newcustomer3').remove();
            $('.oldcustomer3').css('display', '').val(data_crf_mapbill2);
        }

        if (data_crf_condition_money == "โอนเงิน") {
            $('input:radio[class="crf_condition_moneyv1"]').prop('checked', true);
        } else if (data_crf_condition_money == "รับเช็ค") {
            $('input:radio[class="crf_condition_moneyv2"]').prop('checked', true);
            $('.recive_cheuqe').css('display', '');
            $('.newcustomer4').remove();
            $('.oldcustomer4').css('display', '').val(data_crf_recive_cheuqetable);
            $('.oldcustomer4').prop('readonly', true);
            $('#crf_recive_cheuqedetail').val(data_crf_recive_cheuqedetail);
            $('#crf_recive_cheuqedetail').prop('readonly', true);
        }


        // if (data_crf_finance == "ขอวงเงิน") {
        //     $('input:radio[class="crf_financev1"]').prop('checked', true);
        //     $('.finance_request_detail').css('display', '');
        //     $('#crf_finance_req_number').val(data_crf_finance_req_number);
        // } else if (data_crf_finance == "ปรับวงเงิน") {
        //     $('input:radio[class="crf_financev2"]').prop('checked', true);
        // }

        $('#crf_finance_req_number').val(function (index, value) {
            return value
                .replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                ;
        });



        $('#autoCusname').html('')
    });





    //////////// Search Zone Search Zone Search Zone Search Zone //////////////////
    //////////// Search Zone Search Zone Search Zone Search Zone //////////////////
    $('#searchdata').change(function () {
        if ($(this).val() == 'จากวันที่สร้างรายการ') {
            $('.searchByDate').css('display', '');
        } else {
            $('.searchByDate').css('display', 'none');
        }

        if ($(this).val() == 'จากเลขที่คำขอ') {
            $('.searchByForm').css('display', '');
        } else {
            $('.searchByForm').css('display', 'none');
        }

        if ($(this).val() == 'จากชื่อบริษัท') {
            $('.searchByCompany').css('display', '');
        } else {
            $('.searchByCompany').css('display', 'none');
        }
    });





    $('#searchdataex').change(function () {
        if ($(this).val() == 'bydatecreate') {
            $('.searchByDate').css('display', '');
        } else {
            $('.searchByDate').css('display', 'none');
        }

        if ($(this).val() == 'byformno') {
            $('.searchByForm').css('display', '');
        } else {
            $('.searchByForm').css('display', 'none');
        }

        if ($(this).val() == 'bycompanyname') {
            $('.searchByCompany').css('display', '');
        } else {
            $('.searchByCompany').css('display', 'none');
        }
    });
    //////////// Search Zone Search Zone Search Zone Search Zone //////////////////
    //////////// Search Zone Search Zone Search Zone Search Zone //////////////////






    // Export Zone Export Zone Export Zone Export Zone Export Zone Export Zone
    // Export Zone Export Zone Export Zone Export Zone Export Zone Export Zone// Export Zone Export Zone Export Zone Export Zone Export Zone Export Zone
    // Export Zone Export Zone Export Zone Export Zone Export Zone Export Zone// Export Zone Export Zone Export Zone Export Zone Export Zone Export Zone
    // Export Zone Export Zone Export Zone Export Zone Export Zone Export Zone// Export Zone Export Zone Export Zone Export Zone Export Zone Export Zone
    // Export Zone Export Zone Export Zone Export Zone Export Zone Export Zone// Export Zone Export Zone Export Zone Export Zone Export Zone Export Zone
    // Export Zone Export Zone Export Zone Export Zone Export Zone Export Zone
    // Add Comma to number
    $('#crfex_creditlimit , #crfex_creditlimit2').val(function (index, value) {
        return value
            .replace(/\D/g, "")
            .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            ;
    });

    $('#usercrfex_submit').prop('disabled', true);

    $('input[name="crfex_company"]').click(function () {
        if ($('input[name="crfex_company"]:checked').length > 0) {
            $('#alert_crfex_company').html('');
        }
    });

    $('#crfex_salesreps').click(function () {
        if ($('input[name="crfex_custype"]:checked').length < 1) {
            $('#alert_crfex_custype').html('<div class="alert alert-danger" role="alert">Please choose customer type.</div>');
            $('#crfex_salesreps').val('');
            exit;
        }
    });
    $('#crfex_salesreps').keyup(function () {
        if ($('input[name="crfex_custype"]:checked').length < 1) {
            $('#alert_crfex_custype').html('<div class="alert alert-danger" role="alert">Please choose customer type.</div>');
            $('#crfex_salesreps').val('');
            exit;
        }
    });


    $('input[name="crfex_custype"]').click(function () {
        if ($('input[name="crfex_custype"]:checked').length > 0) {
            $('#alert_crfex_custype').html('');
        }
    });



    // Add page Zone
    if ($('#checkAddPage').val() == 'addEx') {
        // Hidden current credit
        $('.currentCredit').css('display', 'none');

        $('.calCurrentCus , .SumCurrentCus').css('display', 'none');

        $('#crfex_salesreps , #crfex_cusnameEN , #crfex_cusnameTH , #crfex_address , #crfex_tel , #crfex_fax , #crfex_email , #crfex_creditlimit , #crfex_term , #crfex_discount , #crfex_creditlimit2 , #crfex_term2 , #crfex_discount2 , #crfex_payment , #crfex_customercode ').prop('readonly', true);




        $('input[name="crfex_custype"]').click(function () {
            var crfex_company = $('input:radio[name="crfex_company"]:checked');
            if (crfex_company.length < 1) {
                $('#alert_crfex_company').html('<div class="alert alert-danger" role="alert">Please choose company name.</div>');
                $('input[name="crfex_custype"]').prop('checked', false);
                exit;
            } else {
                $('#alert_crfex_company').html('');
            }







            // When click new customer // When click new customer// When click new customer
            // When click new customer // When click new customer// When click new customer
            // When click new customer // When click new customer// When click new customer


            if ($(this).val() == 1) {


                $('#crfex_cusnameEN').blur(function () {
                    var cusname = $(this).val();
                    var comName = $('input:radio[name="crfex_company"]:checked').val();
                    if (cusname != '') {
                        checkDuplicateNameCustomerEx(cusname, comName);
                        checkCustomersNameEn(cusname);
                    } else {
                        $('#alert_crfex_cusnameEN').html('');
                    }
                });

                $('#crfex_cusnameTH').blur(function () {
                    var cusname = $(this).val();
                    if (cusname != '') {
                        checkCustomersNameTH(cusname);
                    } else {
                        $('#alert_crfex_cusnameTH').html('');
                    }
                });

                $('#crfex_customercode').prop('readonly', true);

                $('#crfex_his_month1 , #crfex_his_month2 , #crfex_his_month3 , #crfex_his_tvolume1 , #crfex_his_tvolume2 , #crfex_his_tvolume3 , #crfex_histsales1 , #crfex_histsales2 , #crfex_histsales3 , #crfex_creditlimit2 , #crfex_term2 , #crfex_discount2').prop('readonly', true);

                // check sales rep
                $('#crfex_cusnameEN').click(function () {
                    if ($('#crfex_salesreps').val() == '') {
                        $('#alert_crfex_salesreps').html('<div class="alert alert-danger" role="alert">Please fill sales reps.</div>');
                        $('#crfex_cusnameEN').val('');
                        exit;
                    }
                });
                $('#crfex_cusnameEN').keyup(function () {
                    if ($('#crfex_salesreps').val() == '') {
                        $('#alert_crfex_salesreps').html('<div class="alert alert-danger" role="alert">Please fill sales reps.</div>');
                        $('#crfex_cusnameEN').val('');
                        exit;
                    }
                });
                $('#crfex_salesreps').keyup(function () {
                    if ($(this).val() != '') {
                        $('#alert_crfex_salesreps').html('');
                    }
                });





                // check customer name
                $('#crfex_address').click(function () {
                    if ($('#crfex_cusnameEN').val() == '') {
                        $('#alert_crfex_cusnameEN').html('<div class="alert alert-danger" role="alert">Please fill customer name (EN).</div>');
                        $('#crfex_address').val('');
                        exit;
                    }
                });
                $('#crfex_address').keyup(function () {
                    if ($('#crfex_cusnameEN').val() == '') {
                        $('#alert_crfex_cusnameEN').html('<div class="alert alert-danger" role="alert">Please fill customer name (EN).</div>');
                        $('#crfex_address').val('');
                        exit;
                    }
                });
                $('#crfex_cusnameEN').keyup(function () {
                    if ($(this).val() != '') {
                        $('#alert_crfex_cusnameEN').html('');
                    }
                });


                // check address
                $('#crfex_tel').click(function () {
                    if ($('#crfex_address').val() == '') {
                        $('#alert_crfex_address').html('<div class="alert alert-danger" role="alert">Please fill address.</div>');
                        $('#crfex_tel').val('');
                        exit;
                    }
                });
                $('#crfex_tel').keyup(function () {
                    if ($('#crfex_address').val() == '') {
                        $('#alert_crfex_address').html('<div class="alert alert-danger" role="alert">Please fill address.</div>');
                        $('#crfex_tel').val('');
                        exit;
                    }
                });
                $('#crfex_address').keyup(function () {
                    if ($(this).val() != '') {
                        $('#alert_crfex_address').html('');
                    }
                });


                // check tel
                $('#crfex_email').click(function () {
                    if ($('#crfex_tel').val() == '') {
                        $('#alert_crfex_tel').html('<div class="alert alert-danger" role="alert">Please fill Tel.</div>');
                        $('#crfex_email').val('');
                        exit;
                    }

                });
                $('#crfex_email').keyup(function () {
                    if ($('#crfex_tel').val() == '') {
                        $('#alert_crfex_tel').html('<div class="alert alert-danger" role="alert">Please fill Tel.</div>');
                        $('#crfex_email').val('');
                        exit;
                    }
                });
                $('#crfex_tel').keyup(function () {
                    if ($(this).val() != '') {
                        $('#alert_crfex_tel').html('');
                    }
                });



                // check email
                $('#crfex_creditlimit').click(function () {
                    if ($('#crfex_email').val() == '') {
                        $('#alert_crfex_email').html('<div class="alert alert-danger" role="alert">Please fill Email.</div>');
                        $('#crfex_creditlimit').val('');
                        exit;
                    }
                });
                $('#crfex_creditlimit').keyup(function () {
                    if ($('#crfex_email').val() == '') {
                        $('#alert_crfex_email').html('<div class="alert alert-danger" role="alert">Please fill Email.</div>');
                        $('#crfex_creditlimit').val('');
                        exit;
                    }
                });
                $('#crfex_email').keyup(function () {
                    if ($(this).val() != '') {
                        $('#alert_crfex_email').html('');
                    }
                });


                // check credit
                $('#crfex_term').click(function () {
                    if ($('#crfex_creditlimit').val() == '') {
                        $('#alert_crfex_creditlimit').html('<div class="alert alert-danger" role="alert">Please fill propose credit limit.</div>');
                        $('#crfex_term').val('');
                        exit;
                    }
                });
                $('#crfex_term').keyup(function () {
                    if ($('#crfex_creditlimit').val() == '') {
                        $('#alert_crfex_creditlimit').html('<div class="alert alert-danger" role="alert">Please fill propose credit limit.</div>');
                        $('#crfex_term').val('');
                        exit;
                    }
                });
                $('#crfex_creditlimit').keyup(function () {
                    if ($(this).val() != '') {
                        $('#alert_crfex_creditlimit').html('');
                    }
                });



                // check term
                $('#crfex_term').blur(function () {
                    if ($('#crfex_term').val() == '') {
                        $('#alert_crfex_term').html('<div class="alert alert-danger" role="alert">Please fill credit term.</div>');
                        $('#usercrfex_submit').prop('disabled', true);
                        exit;
                    }
                });
                $('#crfex_creditlimit').keyup(function () {
                    if ($(this).val() != '') {
                        $('#alert_crfex_term').html('');
                        $('#usercrfex_submit').prop('disabled', false);
                    }
                });

                $('#crfex_term').blur(function () {
                    if ($(this).val() != '') {
                        $('#usercrfex_submit').prop('disabled', false);
                    }
                });


                $('input[name=crfex_creditlimit]').keyup(function (event) {/*****Comma function*******/
                    var price = $(this).val();
                    var checkNumber = /[^A-Za-zก-เ]/.test(price);
                    // alert(checkNumber);
                    if (checkNumber == true) {
                        // skip for arrow keys
                        if (event.which >= 37 && event.which <= 40)
                            return;

                        // format number
                        $(this).val(function (index, value) {
                            return value
                                .replace(/\D/g, "")
                                .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                                ;
                        });
                    } else {
                        alert('Please fill number only!');
                        $('input[name=crfex_creditlimit]').val('');
                    }

                });




                $('#curcustopic_addpage').css('display', 'none');

                $('#crfex_salesreps , #crfex_cusnameEN , #crfex_cusnameTH , #crfex_address , #crfex_tel , #crfex_fax , #crfex_email , #crfex_creditlimit , #crfex_term , #crfex_discount , #crfex_creditlimit2 , #crfex_term2 , #crfex_discount2 , #crfex_payment').prop('readonly', false);



            } else if ($(this).val() == 2) {


                $('.currentCredit').css('display', '');
                $('.proposeCredit').css('display', 'none');

                $('#curcustopic_addpage').css('display', '');
                $('#crfex_customercode , #crfex_cusnameEN').prop('readonly', false);
                $('.crfex_topic').css('display', '');

                $('#crfex_salesreps  , #crfex_cusnameTH , #crfex_address , #crfex_tel , #crfex_fax , #crfex_email , #crfex_creditlimit , #crfex_term , #crfex_discount , #crfex_creditlimit2 , #crfex_term2 , #crfex_discount2 , #crfex_payment').prop('readonly', true);

                $('#alert_crfex_salesreps , #alert_crfex_cusnameEN , #alert_crfex_address , #alert_crfex_tel , #alert_crfex_email , #alert_crfex_creditlimit , #alert_crfex_term').html('');


                // check topic select
                $('#crfex_customercode , #crfex_cusnameEN').click(function () {
                    var crfex_curcustopic = $('input[type="checkbox"][id="crfex_curcustopic_add"]:checked');
                    if (crfex_curcustopic.length < 1) {
                        $('#alert_crfex_topic').html('<div class="alert alert-danger" role="alert">Please select the topic.</div>');
                        $('#crfex_customercode , #crfex_cusnameEN').val('');
                        $('#autoCusCodeEx , #alert_crfex_cusnameEN').html('');
                    }
                });
                $('#crfex_customercode , #crfex_cusnameEN').blur(function () {
                    var crfex_curcustopic2 = $('input[type="checkbox"][id="crfex_curcustopic_add"]:checked');
                    if (crfex_curcustopic2.length < 1) {
                        $('#alert_crfex_topic').html('<div class="alert alert-danger" role="alert">Please select the topic.</div>');
                        $('#crfex_customercode, #crfex_cusnameEN').val('');
                        $('#autoCusCodeEx , #alert_crfex_cusnameEN').html('');
                    }
                });


                $('input[name="crfex_curcustopic1_add"]').click(function () {
                    if ($(this).prop('checked') == true) {
                        $('#alert_crfex_topic').html('');
                        $('#crfex_salesreps , #crfex_cusnameEN , #crfex_cusnameTH , #crfex_address , #crfex_tel , #crfex_fax , #crfex_email').prop('readonly', false);
                        // $('#crfex_creditlimit , #crfex_term , #crfex_discount , #crfex_creditlimit2 , #crfex_term2 , #crfex_discount2').prop('readonly' , true);
                        $('#crfex_address').blur(function () {
                            if ($(this).val() != '') {
                                $('#usercrfex_submit').prop('disabled', false);
                            } else {
                                alert('Please fill address');
                                $('#usercrfex_submit').prop('disabled', true);
                            }
                        });
                        $('#crfex_salesreps').blur(function () {
                            if ($(this).val() != '') {
                                $('#usercrfex_submit').prop('disabled', false);
                            } else {
                                alert('Please fill address');
                                $('#usercrfex_submit').prop('disabled', true);
                            }
                        });
                        $('#crfex_tel').blur(function () {
                            if ($(this).val() != '') {
                                $('#usercrfex_submit').prop('disabled', false);
                            } else {
                                alert('Please fill address');
                                $('#usercrfex_submit').prop('disabled', true);
                            }
                        });
                        $('#crfex_email').blur(function () {
                            if ($(this).val() != '') {
                                $('#usercrfex_submit').prop('disabled', false);
                            } else {
                                alert('Please fill address');
                                $('#usercrfex_submit').prop('disabled', true);
                            }
                        });
                    } else {
                        $('#crfex_salesreps , #crfex_cusnameEN , #crfex_cusnameTH , #crfex_address , #crfex_tel , #crfex_fax , #crfex_email').prop('readonly', true);
                    }
                });

                $('input[name="crfex_curcustopic2_add"]').click(function () {
                    if ($(this).prop('checked') == true) {
                        $('#alert_crfex_topic').html('');
                        $('#crfex_creditlimit , #crfex_term , #crfex_discount , #crfex_creditlimit2 , #crfex_term2 , #crfex_discount2').prop('readonly', true);
                        $('#crfex_payment').prop('readonly', false);
                        // $('#crfex_salesreps , #crfex_cusnameEN , #crfex_cusnameTH , #crfex_address , #crfex_tel , #crfex_fax , #crfex_email').prop('readonly' , true);
                        $('.calCurrentCus , .SumCurrentCus , .creditlimitCondition').css('display', '');

                        // Calculate credit limit
                        $('#cal_crfex_creditlimit2').keyup(function () {
                            var oldcreditlimit = parseInt($('#crfex_creditlimit2usecal').val());
                            var requestcredit = parseInt($('#cal_crfex_creditlimit2').val());
                            var sumCreditlimit = 0;
                            if ($('#creditlimit_condition').val() == 'writeup') {
                                sumCreditlimit = oldcreditlimit + requestcredit;
                            } else if ($('#creditlimit_condition').val() == 'writedown') {
                                sumCreditlimit = oldcreditlimit - requestcredit;
                            }
                            $('#sum_crfex_creditlimit2').val(sumCreditlimit);
                            $('#sum_crfex_creditlimit2').val(function (index, value) {
                                return value
                                    .replace(/\D/g, "")
                                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                                    ;
                            });

                            $('#usercrfex_submit').prop('disabled', false);
                        });
                        // Calculate credit limit


                        // Calculate credit term
                        $('#cal_crfex_term2').keyup(function () {
                            var oldterm = parseInt($('#crfex_term2').val());
                            var requestterm = parseInt($('#cal_crfex_term2').val());
                            var sumterm = 0;
                            if ($('#term_condition').val() == 'writeup') {
                                sumterm = oldterm + requestterm;
                            } else if ($('#term_condition').val() == 'writedown') {
                                if (requestterm >= oldterm) {
                                    alert('Please check request term!!');
                                    $('#cal_crfex_term2').val('');
                                } else {
                                    sumterm = oldterm - requestterm;
                                }
                            }
                            $('#sum_crfex_term2').val(sumterm);
                            $('#usercrfex_submit').prop('disabled', false);
                        });
                        $('#cal_crfex_term2').change(function () {
                            var oldterm = parseInt($('#crfex_term2').val());
                            var requestterm = parseInt($('#cal_crfex_term2').val());
                            var sumterm = 0;
                            if ($('#term_condition').val() == 'writeup') {
                                sumterm = oldterm + requestterm;
                            } else if ($('#term_condition').val() == 'writedown') {
                                if (requestterm >= oldterm) {
                                    alert('Please check request term!!');
                                    $('#cal_crfex_term2').val('');
                                } else {
                                    sumterm = oldterm - requestterm;
                                }
                            }
                            $('#sum_crfex_term2').val(sumterm);
                            $('#usercrfex_submit').prop('disabled', false);
                        });
                        // Calculate credit term



                        $('#cal_crfex_discount2').keyup(function () {
                            var olddiscount = parseInt($('#crfex_discount2').val());
                            var requestdiscount = parseInt($('#cal_crfex_discount2').val());
                            var sumdiscount = 0;
                            if ($('#discount_condition').val() == 'writeup') {
                                sumdiscount = olddiscount + requestdiscount;
                            } else if ($('#discount_condition').val() == 'writedown') {
                                if (requestdiscount > olddiscount) {
                                    alert('Please check request discount!!');
                                    $('#cal_crfex_discount2').val('');
                                } else {
                                    sumdiscount = olddiscount - requestdiscount;
                                }
                            }
                            $('#sum_crfex_discount2').val(sumdiscount);
                            $('#usercrfex_submit').prop('disabled', false);
                        });
                        $('#cal_crfex_discount2').change(function () {
                            var olddiscount = parseInt($('#crfex_discount2').val());
                            var requestdiscount = parseInt($('#cal_crfex_discount2').val());
                            var sumdiscount = 0;
                            if ($('#discount_condition').val() == 'writeup') {
                                sumdiscount = olddiscount + requestdiscount;
                            } else if ($('#discount_condition').val() == 'writedown') {
                                if (requestdiscount > olddiscount) {
                                    alert('Please check request discount!!');
                                    $('#cal_crfex_discount2').val('');
                                } else {
                                    sumdiscount = olddiscount - requestdiscount;
                                }
                            }
                            $('#sum_crfex_discount2').val(sumdiscount);
                            $('#usercrfex_submit').prop('disabled', false);
                        });




                    } else {
                        $('#crfex_creditlimit , #crfex_term , #crfex_discount , #crfex_creditlimit2 , #crfex_term2 , #crfex_discount2').prop('readonly', true);
                    }

                });





                // Get Old customer information to form when keyup
                $('#crfex_customercode').on('keyup', function () {
                    var cusCode = $(this).val();
                    if (cusCode != '') {
                        autoSearchCustomerDetailEx(cusCode);
                    } else {
                        $('#autoCusCodeEx').html('')
                    }

                });

                $(document).on('click', '.selectCusCodeEx', function () {

                    var data_crfex_salesreps = $(this).attr('data_crfex_salesreps');
                    var data_crfex_cusnameEN = $(this).attr('data_crfex_cusnameEN');
                    var data_crfex_cusnameTH = $(this).attr('data_crfex_cusnameTH');
                    var data_crfex_address = $(this).attr('data_crfex_address');
                    var data_crfex_tel = $(this).attr('data_crfex_tel');
                    var data_crfex_fax = $(this).attr('data_crfex_fax');
                    var data_crfex_email = $(this).attr('data_crfex_email');
                    var data_crfex_file = $(this).attr('data_crfex_file');
                    var data_crfex_creditlimit = $(this).attr('data_crfex_creditlimit');
                    var data_crfex_term = $(this).attr('data_crfex_term');
                    var data_crfex_discount = $(this).attr('data_crfex_discount');
                    var data_crfex_bg = $(this).attr('data_crfex_bg');
                    var data_crfex_cuscode = $(this).attr('data_crfex_cuscode');
                    var data_crfex_cusid = $(this).attr('data_crfex_cusid');
                    var data_crfex_cuspayment = $(this).attr('data_crfex_cuspayment');
                    var data_crfexcus_area = $(this).attr('data_crfexcus_area');


                    $('#crfex_salesreps').val(data_crfex_salesreps);
                    $('#crfex_cusnameEN').val(data_crfex_cusnameEN);
                    $('#crfex_cusnameTH').val(data_crfex_cusnameTH);
                    $('#crfex_address').val(data_crfex_address);
                    $('#crfex_tel').val(data_crfex_tel);
                    $('#crfex_fax').val(data_crfex_fax);
                    $('#crfex_email').val(data_crfex_email);
                    $('#crfex_fileShow').text(data_crfex_file);
                    $('#crfex_creditlimit2').val(data_crfex_creditlimit);
                    $('#crfex_creditlimit2usecal').val(data_crfex_creditlimit);
                    $('#crfex_term2').val(data_crfex_term);
                    $('#crfex_discount2').val(data_crfex_discount);
                    $('#crfex_combg').val(data_crfex_bg);
                    $('#crfex_customercode').val(data_crfex_cuscode);
                    $('#getCusid').val(data_crfex_cusid);
                    $('#crfex_payment').val(data_crfex_cuspayment);
                    $('#checkAreaAddEn').val(data_crfexcus_area);

                    if (data_crfexcus_area == 'sln') {
                        $('#crf_company_sln').prop('checked', true);
                    }
                    if (data_crfexcus_area == 'poly') {
                        $('#crf_company_poly').prop('checked', true);
                    }
                    if (data_crfexcus_area == 'ca') {
                        $('#crf_company_ca').prop('checked', true);
                    }
                    if(data_crfexcus_area == 'tb'){
                        $('#crf_company_tb').prop('checked', true);
                    }
                    if(data_crfexcus_area == 'st'){
                        $('#crf_company_st').prop('checked', true);
                    }

                    $('#crfex_creditlimit2').val(function (index, value) {
                        return value
                            .replace(/\D/g, "")
                            .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                            ;
                    });



                    $('#autoCusCodeEx').html('');

                });




                // Get Old customer information to form when keyup
                $('#crfex_cusnameEN').on('keyup', function () {
                    var cusName = $(this).val();
                    if (cusName != '') {
                        autoSearchCustomerDetailExName(cusName);
                    } else {
                        $('#autoCusCodeExName').html('')
                    }

                });

                $(document).on('click', '.selectCusCodeExName', function () {

                    var data_crfex_salesreps = $(this).attr('data_crfex_salesreps');
                    var data_crfex_cusnameEN = $(this).attr('data_crfex_cusnameEN');
                    var data_crfex_cusnameTH = $(this).attr('data_crfex_cusnameTH');
                    var data_crfex_address = $(this).attr('data_crfex_address');
                    var data_crfex_tel = $(this).attr('data_crfex_tel');
                    var data_crfex_fax = $(this).attr('data_crfex_fax');
                    var data_crfex_email = $(this).attr('data_crfex_email');
                    var data_crfex_file = $(this).attr('data_crfex_file');
                    var data_crfex_creditlimit = $(this).attr('data_crfex_creditlimit');
                    var data_crfex_term = $(this).attr('data_crfex_term');
                    var data_crfex_discount = $(this).attr('data_crfex_discount');
                    var data_crfex_bg = $(this).attr('data_crfex_bg');
                    var data_crfex_cuscode = $(this).attr('data_crfex_cuscode');
                    var data_crfex_cusid = $(this).attr('data_crfex_cusid');
                    var data_crfex_cuspayment = $(this).attr('data_crfex_cuspayment');
                    var data_crfexcus_area = $(this).attr('data_crfexcus_area');


                    $('#crfex_salesreps').val(data_crfex_salesreps);
                    $('#crfex_cusnameEN').val(data_crfex_cusnameEN);
                    $('#crfex_cusnameTH').val(data_crfex_cusnameTH);
                    $('#crfex_address').val(data_crfex_address);
                    $('#crfex_tel').val(data_crfex_tel);
                    $('#crfex_fax').val(data_crfex_fax);
                    $('#crfex_email').val(data_crfex_email);
                    $('#crfex_fileShow').text(data_crfex_file);
                    $('#crfex_creditlimit2').val(data_crfex_creditlimit);
                    $('#crfex_creditlimit2usecal').val(data_crfex_creditlimit);
                    $('#crfex_term2').val(data_crfex_term);
                    $('#crfex_discount2').val(data_crfex_discount);
                    $('#crfex_combg').val(data_crfex_bg);
                    $('#crfex_customercode').val(data_crfex_cuscode);
                    $('#getCusid').val(data_crfex_cusid);
                    $('#crfex_payment').val(data_crfex_cuspayment);
                    $('#checkAreaAddEn').val(data_crfexcus_area);

                    if (data_crfexcus_area == 'sln') {
                        $('#crf_company_sln').prop('checked', true);
                    }
                    if (data_crfexcus_area == 'poly') {
                        $('#crf_company_poly').prop('checked', true);
                    }
                    if (data_crfexcus_area == 'ca') {
                        $('#crf_company_ca').prop('checked', true);
                    }

                    $('#crfex_creditlimit2').val(function (index, value) {
                        return value
                            .replace(/\D/g, "")
                            .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                            ;
                    });



                    $('#autoCusCodeExName').html('');

                });




            }
            // End Section current customer

        });

    }
    // Add page Zone







    // Control view export page
    if ($('#checkPage').val() == 'viewdataEx') {

        $('.view_currentCredit').css('display', 'none');

        $('#crf_company_sln_view , #crf_company_poly_view , #crf_company_ca_view').attr('onclick', 'return false');

        if ($('#check_crf_company').val() == 'sln') {
            $('#crf_company_sln_view').prop('checked', true);
        } else if ($('#check_crf_company').val() == 'poly') {
            $('#crf_company_poly_view').prop('checked', true);
        } else if ($('#check_crf_company').val() == 'ca') {
            $('#crf_company_ca_view').prop('checked', true);
        }else if($('#check_crf_company').val() == 'tb'){
            $('#crf_company_tb_view').prop('checked', true);
        }else if($('#check_crf_company').val() == 'st'){
            $('#crf_company_st_view').prop('checked', true);
        }
        // End check company




        // Add Comma to number
        $('#crfex_creditlimit , #crfex_creditlimit2 , #sum_crfex_creditlimit2 , #cal_crfex_creditlimit2').val(function (index, value) {
            return value
                .replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                ;
        });



        if ($('#check_crfex_custype').val() == 1) {
            // Un check radio button
            $('input:radio[id="crfex_custype2v"]').attr('onclick', 'return false');
            $('#crfex_custype1v').prop('checked', true);
            $('.view_currentCredit , .creditlimitCondition_view , .calCurrentCus_view , .SumCurrentCus_view').remove();
        } else if ($('#check_crfex_custype').val() == 2) {
            $('input:radio[id="crfex_custype2v"]').prop('checked', true);
            $('.excurcusmethod').css('display', '');

            if ($('#checkcurcustopic1').val() != '') {
                $('input:checkbox[name="crfex_curcustopic1"]').prop('checked', true);
            } else {
                $('input:checkbox[name="crfex_curcustopic1"]').prop('checked', false);
            }

            if ($('#checkcurcustopic2').val() != '') {
                $('input:checkbox[name="crfex_curcustopic2"]').prop('checked', true);
                $('.creditlimitCondition_view , .calCurrentCus_view , .SumCurrentCus_view').css('display', '');
            } else {
                $('input:checkbox[name="crfex_curcustopic2"]').prop('checked', false);
            }

            $('.view_currentCredit').css('display', '');
            $('.view_proposeCredit').css('display', 'none');
        }




        // Control Approve Section
        var checkStatus = $('#checkStatusView').val();
        var checkUserDeptView = $('#checkUserDeptView').val();
        var checkCusType = $('#checkCusType').val();
        var checkCusPosi = $('#checkCusPosi').val();

        if (checkStatus == 'Open' && checkUserDeptView == 1006 && checkCusPosi == 75 || checkStatus == 'Open' && checkUserDeptView == 1010 && checkCusPosi == 75 || checkStatus == 'Open' && checkUserDeptView == 1004 && checkCusPosi == 75 || checkStatus == 'Open' && checkUserDeptView == 1012 && checkCusPosi == 75) {
            $('.managerSection').css('display', '');
            $('#ex_mgrSubmit').prop('disabled', true);
            $('input:radio[name="ex_mgrApprove"]').click(function () {
                if ($(this).val() != '') {
                    $('#ex_mgrSubmit').prop('disabled', false);
                } else {
                    $('#ex_mgrSubmit').prop('disabled', true);
                }
            });
        } else if (checkStatus == 'Edited' && checkUserDeptView == 1006 && checkCusPosi == 75 || checkStatus == 'Edited' && checkUserDeptView == 1010 && checkCusPosi == 75 || checkStatus == 'Edited' && checkUserDeptView == 1004 && checkCusPosi == 75 || checkStatus == 'Edited' && checkUserDeptView == 1012 && checkCusPosi == 75) {

            $('.managerSection').css('display', '');
            $('#ex_mgrSubmit').prop('disabled', true);
            $('input:radio[name="ex_mgrApprove"]').click(function () {
                if ($(this).val() != '') {
                    $('#ex_mgrSubmit').prop('disabled', false);
                } else {
                    $('#ex_mgrSubmit').prop('disabled', true);
                }
            });

        }
        else if (checkStatus == 'Manager approved' || checkStatus == 'CS Added BR CODE' || checkStatus == 'Account Manager Approved' || checkStatus == 'Director Approved' || checkStatus == 'Completed' || checkStatus == 'Waiting for second director approve' || checkStatus == 'Manager Not Approve' || checkStatus == 'Account Manager Not Approve' || checkStatus == 'Director Not Approve' || checkStatus == "Wait account staff process") {
            $('.managerSection').css('display', 'none');
            $('.managerSection1').css('display', '');

            $('#ex_mgrApprove1 , #ex_mgrApprove2').attr('onclick', 'return false');
            if ($('#show_crfex_mgrapp_status').val() == "Approve") {
                $('#ex_mgrApprove1').prop('checked', true);
            } else {
                $('#ex_mgrApprove2').prop('checked', true);
            }
        }

        if (checkStatus == 'Manager approved' && checkUserDeptView == 1010 || checkStatus == 'Manager approved' && checkUserDeptView == 1012 || checkStatus == 'Manager approved' && checkUserDeptView == 1004 || checkStatus == 'Manager approved' && $('#checkUserEcodeEx').val() == "M2119") {
            if (checkCusType == 2) {
                $('.csAddBrDection').remove();
            } else {
                $('.csAddBrDection').css('display', '');
            }
        } else if (checkStatus == 'CS Added BR CODE' || checkStatus == 'Account Manager Approved' || checkStatus == 'Director Approved' || checkStatus == 'Completed' || checkStatus == 'Waiting for second director approve') {
            if (checkCusType == 2) {
                $('.csAddBrDection1').remove();
            } else {
                $('.csAddBrDection1').css('display', '');
            }
        }

        if (checkStatus == 'CS Added BR CODE' && checkUserDeptView == 1003 && checkCusPosi > 55 ||
        checkStatus == 'CS Added BR CODE' && $('#checkUserEcodeEx').val() == "M1767" ||
        checkStatus == 'CS Added BR CODE' && $('#checkUserEcodeEx').val() == "M1260" || 
        checkStatus == 'CS Added BR CODE' && $('#checkUserEcodeEx').val() == "M2217") {
            $('.accManagerApprove').css('display', '');
            $('#ex_accManagerSubmit').prop('disabled', true);
            $('input:radio[name="ex_accMgrApprove"]').click(function () {
                if ($(this).val() != '') {
                    $('#ex_accManagerSubmit').prop('disabled', false);
                } else {
                    $('#ex_accManagerSubmit').prop('disabled', true);
                }
            });
        } else if (checkStatus == 'Manager approved' && checkUserDeptView == 1003 && checkCusPosi > 55) {
            $('.accManagerApprove').css('display', '');
            $('#ex_accManagerSubmit').prop('disabled', true);
            $('input:radio[name="ex_accMgrApprove"]').click(function () {
                if ($(this).val() != '') {
                    $('#ex_accManagerSubmit').prop('disabled', false);
                } else {
                    $('#ex_accManagerSubmit').prop('disabled', true);
                }
            });

        }else if(checkStatus == 'Manager approved' && $('#checkUserEcodeEx').val() == "M1767" ||
        checkStatus == 'Manager approved' && $('#checkUserEcodeEx').val() == "M1260" || 
        checkStatus == 'Manager approved' && $('#checkUserEcodeEx').val() == "M2217"){
            $('.accManagerApprove').css('display', '');
            $('#ex_accManagerSubmit').prop('disabled', true);
            $('input:radio[name="ex_accMgrApprove"]').click(function () {
                if ($(this).val() != '') {
                    $('#ex_accManagerSubmit').prop('disabled', false);
                } else {
                    $('#ex_accManagerSubmit').prop('disabled', true);
                }
            });
        }
        else if (checkStatus == 'Account Manager Approved' || checkStatus == 'Director Approved' || checkStatus == 'Completed' || checkStatus == 'Waiting for second director approve' || checkStatus == 'Account Manager Not Approve' || checkStatus == 'Director Not Approve' || checkStatus == "Wait account staff process") {
            $('.accManagerApprove1').css('display', '');
        }


        // Control account manager approve section
        $('#ex_accMgrApprove1 , #ex_accMgrApprove2').attr('onclick', 'return false');
        if ($('#check_ex_accMgrApprove').val() == 'Approve') {
            $('#ex_accMgrApprove1').prop('checked', true);
        } else if ($('#check_ex_accMgrApprove').val() == 'Not approve') {
            $('#ex_accMgrApprove2').prop('checked', true);
        }


        // Control director approve section
        if (checkStatus == 'Account Manager Approved' && checkCusPosi > 75 || checkStatus == 'Account Manager Approved' && $('#checkUserEcodeEx').val() == "M0025" || checkStatus == 'Account Manager Approved' && $('#checkUserEcodeEx').val() == "M0015") {
            $('.directorApprove').css('display', '');
            $('.directorApprove2').css('display', '');
            $('#ex_directorSubmit , #ex_directorSubmit2').prop('disabled', true);
            $('input:radio[name="ex_directorApprove"]').click(function () {
                if ($(this).val() != '') {
                    $('#ex_directorSubmit').prop('disabled', false);
                } else {
                    $('#ex_directorSubmit').prop('disabled', true);
                }
            });
            $('input:radio[name="ex_directorApprove2"]').click(function () {
                if ($(this).val() != '') {
                    $('#ex_directorSubmit2').prop('disabled', false);
                } else {
                    $('#ex_directorSubmit2').prop('disabled', true);
                }
            });
        } else if (checkStatus == 'Director Approved' || checkStatus == 'Completed' || checkStatus == 'Waiting for second director approve') {

            // เช็คว่าเป็นลูกค้าเก่าที่แก้ไขข้อมูลลูกค้าหรือไม่
            if ($('#acc_curcustopic1').val() == '' || $('#acc_curcustopic2').val() != '') {
                if ($('#check_director_status').val() == 'Approve') {
                    $('.directorApprove1show').css('display', '');
                } else {
                    $('.directorApprove').css('display', '');
                }
                if ($('#check_director_status2').val() == 'Approve') {
                    $('.directorApprove2show').css('display', '');
                } else {
                    $('.directorApprove2').css('display', '');
                }
            } else {

            }
        } else if (checkStatus == 'Director Not Approve') {
            $('.directorApprove1show').css('display', '');
            $('.directorApprove2show').css('display', '');
        }

        if ($('#check_director_status').val() == 'Approve') {
            $('#ex_directorApprove1').prop('checked', true);
        } else if ($('#check_director_status').val() == 'Not approve') {
            $('#ex_directorApprove2').prop('checked', true);
        }

        if ($('#check_director_status2').val() == 'Approve') {
            $('#ex_directorApprove21').prop('checked', true);
        } else if ($('#check_director_status2').val() == 'Not approve') {
            $('#ex_directorApprove22').prop('checked', true);
        }


        // Control account staff when add new customer
        if (checkStatus == 'Director Approved' && checkUserDeptView == 1003 || checkStatus == 'Wait account staff process' && checkUserDeptView == 1003) {
            $('.accAddCustomerCode').css('display', '');
            if (checkCusType == 2) {
                $('.filcuscode').css('display', 'none');
                $('#ex_accSubmit').prop('disabled', true);
                $('#ex_accMemo').keyup(function () {
                    if ($(this).val() != '') {
                        $('#ex_accSubmit').prop('disabled', false);
                    } else {
                        $('#ex_accSubmit').prop('disabled', true);
                    }
                });
            } else if (checkCusType == 1) {
                $('.filcuscode').css('display', '');
                $('#ex_accSubmit').prop('disabled', true);

                $('#ex_accCostomerCode').keyup(function () {
                    if ($(this).val() != '') {
                        $('#ex_accSubmit').prop('disabled', false);
                    } else {
                        $('#ex_accSubmit').prop('disabled', true);
                    }
                });
                $('#ex_accCostomerCode').blur(function () {
                    if ($(this).val() != '') {
                        $('#ex_accSubmit').prop('disabled', false);
                    } else {
                        $('#ex_accSubmit').prop('disabled', true);
                    }
                });
            }

        } else if (checkStatus == 'Completed') {
            if (checkCusType == 2) {
                $('.accAddCustomerCode1').css('display', '');
                $('.showcuscodeacc').remove();
            } else {
                $('.accAddCustomerCode1').css('display', '');
            }

        }

        if (checkStatus == "Open" && checkUserDeptView == 1006 || checkStatus == "Open" && checkUserDeptView == 1010 || checkStatus == "Open" && checkUserDeptView == 1004 || checkStatus == "Open" && checkUserDeptView == 1012) {
            $('#btnEditZoneEx').css('display', '');
        } else if (checkStatus == "Edited" && checkUserDeptView == 1006 || checkStatus == "Edited" && checkUserDeptView == 1010 || checkStatus == "Edited" && checkUserDeptView == 1004 || checkStatus == "Edited" && checkUserDeptView == 1012) {
            $('#btnEditZoneEx').css('display', '');
        }
        else {
            $('#btnEditZoneEx').css('display', 'none');
        }

        $('#fileExView').click(function () {

            var data_file = $(this).attr('data_file');

            $('#embedshow_viewEx').attr('src', data_file);

            var viewExfile = data_file.substr(-3, 4);
            if (viewExfile == 'jpg' || viewExfile == 'JPG' || viewExfile == 'png' || viewExfile == 'PNG') {
                $('#embedshow_viewExImg').attr('src', data_file);
                $('#embedshow_viewEx').hide();
            } else {
                $('#embedshow_viewEx').attr('src', data_file);
                $('#embedshow_viewExImg').hide();
            }

        });


    }
    // End View page




    // Edit page  // Edit page  // Edit page  // Edit page  // Edit page 
    // Edit page  // Edit page  // Edit page  // Edit page  // Edit page 
    // Edit page  // Edit page  // Edit page  // Edit page  // Edit page 


    if ($('#checkEditPage').val() == "editdataEx") {

        $('.edit_currentCredit').css('display', 'none');
        // Add Comma to number
        $('#crfex_creditlimit , #crfex_creditlimit2').val(function (index, value) {
            return value
                .replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                ;
        });
        $('input[name=crfex_creditlimit]').keyup(function (event) {/*****Comma function*******/
            var price = $(this).val();
            var checkNumber = /[^A-Za-zก-เ]/.test(price);
            // alert(checkNumber);
            if (checkNumber == true) {
                // skip for arrow keys
                if (event.which >= 37 && event.which <= 40)
                    return;

                // format number
                $(this).val(function (index, value) {
                    return value
                        .replace(/\D/g, "")
                        .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                        ;
                });
            } else {
                alert('Please fill number only!');
                $('input[name=crfex_creditlimit]').val('');
            }

        });




        // Check Company name
        if ($('#checkEdit_crfex_company').val() == "sln") {

            $('#crf_company_sln').prop('checked', true);

        } else {
            $('#crf_company_sln').prop('checked', false);
        }
        if ($('#checkEdit_crfex_company').val() == "poly") {

            $('#crf_company_poly').prop('checked', true);

        } else {
            $('#crf_company_poly').prop('checked', false);
        }
        if ($('#checkEdit_crfex_company').val() == "ca") {
            $('#crf_company_ca').prop('checked', true);
        } else {
            $('#crf_company_ca').prop('checked', false);
        }
        if ($('#checkEdit_crfex_company').val() == "tb") {
            $('#crf_company_tb').prop('checked', true);
        } else {
            $('#crf_company_tb').prop('checked', false);
        }
        if ($('#checkEdit_crfex_company').val() == "st") {
            $('#crf_company_st').prop('checked', true);
        } else {
            $('#crf_company_st').prop('checked', false);
        }
        // Check Company name


        $('#crfex_cusnameEN').blur(function () {
            var cusname = $(this).val();
            if (cusname != '') {
                checkCustomersNameEn(cusname);
            } else {
                $('#alert_crfex_cusnameEN').html('');
            }
        });

        $('#crfex_cusnameTH').blur(function () {
            var cusname = $(this).val();
            if (cusname != '') {
                checkCustomersNameTH(cusname);
            } else {
                $('#alert_crfex_cusnameTH').html('');
            }
        });

        if ($('#crfex_fileShowOld').val() == "ไม่มีไฟล์อยู่ในระบบ") {
            $('#linkFileEx').attr('href', 'javascript:void(0)');
            $('#linkFileEx').attr('target', '');
        }


        // Add Comma edit page export
        // $('#crfex_creditlimit').val(function (index, value) {
        //     return value
        //         .replace(/\D/g, "")
        //         .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        //         ;
        // });



        // Check ประเภทลูกค้า
        if ($('#checkEdit_crfex_custype').val() == 1) {
            $('#crfex_custype1').prop('checked', true);
            $('.cusHistory').prop('readonly', true);
            $('input:checkbox').attr('onclick', 'return false');
            $('#crfex_creditlimit2 , #crfex_term2 , #crfex_discount2').prop('readonly', true);
            $('.exEditcurrentCredit , .creditlimitCondition , .calCurrentCus , .SumCurrentCus').remove();

        } else {
            $('#crfex_custype1').prop('checked', false);
            $('.cusHistory').prop('readonly', false);
        }


        if ($('#checkEdit_crfex_custype').val() == 2) {
            $('#crfex_custype2').prop('checked', true);
            $('.exEditCreditlimitPro').css('display', 'none');
            $('.exEditcurrentCredit , .creditlimitCondition').css('display', '');

            $('#sum_crfex_creditlimit2Edit , #cal_crfex_creditlimit2Edit').val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });

            // Check Current customer method

            if ($('#checkEdit_crfex_curcustopic1').val() != '') {
                $('#crfex_curcustopic1').prop('checked', true);
                $('#crfex_salesreps , #crfex_cusnameEN , #crfex_cusnameTH , #crfex_address , #crfex_tel , #crfex_fax , #crfex_email , #crfex_file , #crfex_combg , #crfex_his_month1 , #crfex_his_tvolume1 , #crfex_histsales1 , #crfex_his_month2 , #crfex_his_tvolume2 , #crfex_histsales2 , #crfex_his_month3 , #crfex_his_tvolume3 , #crfex_histsales3').prop('readonly', false);
                // $('#crfex_creditlimit , #crfex_term , #crfex_discount , #crfex_payment , #crfex_creditlimit2 , #crfex_term2 , #crfex_discount2').prop('readonly' , true);
            } else {
                $('#crfex_curcustopic1').prop('checked', false);
                // $('#crfex_creditlimit , #crfex_term , #crfex_discount , #crfex_payment , #crfex_creditlimit2 , #crfex_term2 , #crfex_discount2').prop('readonly' , false);
                $('#crfex_salesreps , #crfex_cusnameEN , #crfex_cusnameTH , #crfex_address , #crfex_tel , #crfex_fax , #crfex_email , #crfex_file , #crfex_combg , #crfex_his_month1 , #crfex_his_tvolume1 , #crfex_histsales1 , #crfex_his_month2 , #crfex_his_tvolume2 , #crfex_histsales2 , #crfex_his_month3 , #crfex_his_tvolume3 , #crfex_histsales3').prop('readonly', true);
            }


            if ($('#checkEdit_crfex_curcustopic2').val() != '') {
                $('#crfex_curcustopic2').prop('checked', true);
                $('#crfex_creditlimit , #crfex_term , #crfex_discount , #crfex_payment').prop('readonly', false);
                $('#crfex_creditlimit2 , #crfex_term2Edit , #crfex_discount2Edit').prop('readonly', true);


                // Calculate credit limit
                $('#cal_crfex_creditlimit2Edit').keyup(function () {
                    var oldcreditlimit = parseInt($('#crfex_creditlimit2usecalEdit').val());
                    var requestcredit = parseInt($('#cal_crfex_creditlimit2Edit').val());
                    var sumCreditlimit = 0;
                    if ($('#creditlimit_conditionEdit').val() == 'writeup') {
                        sumCreditlimit = oldcreditlimit + requestcredit;
                    } else if ($('#creditlimit_conditionEdit').val() == 'writedown') {
                        sumCreditlimit = oldcreditlimit - requestcredit;
                    }
                    $('#sum_crfex_creditlimit2Edit').val(sumCreditlimit);
                    $('#sum_crfex_creditlimit2Edit').val(function (index, value) {
                        return value
                            .replace(/\D/g, "")
                            .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                            ;
                    });

                });
                // Calculate credit limit


                // Calculate credit term
                $('#cal_crfex_term2Edit').keyup(function () {
                    var oldterm = parseInt($('#crfex_term2Edit').val());
                    var requestterm = parseInt($('#cal_crfex_term2Edit').val());
                    var sumterm = 0;
                    if ($('#term_conditionEdit').val() == 'writeup') {
                        sumterm = oldterm + requestterm;
                    } else if ($('#term_conditionEdit').val() == 'writedown') {
                        if (requestterm >= oldterm) {
                            alert('Please check request term!!');
                            $('#cal_crfex_term2Edit').val('');
                        } else {
                            sumterm = oldterm - requestterm;
                        }
                    }
                    $('#sum_crfex_term2Edit').val(sumterm);
                });
                $('#cal_crfex_term2Edit').change(function () {
                    var oldterm = parseInt($('#crfex_term2Edit').val());
                    var requestterm = parseInt($('#cal_crfex_term2Edit').val());
                    var sumterm = 0;
                    if ($('#term_conditionEdit').val() == 'writeup') {
                        sumterm = oldterm + requestterm;
                    } else if ($('#term_conditionEdit').val() == 'writedown') {
                        if (requestterm >= oldterm) {
                            alert('Please check request term!!');
                            $('#cal_crfex_term2Edit').val('');
                        } else {
                            sumterm = oldterm - requestterm;
                        }
                    }
                    $('#sum_crfex_term2Edit').val(sumterm);
                });
                // Calculate credit term



                $('#cal_crfex_discount2Edit').keyup(function () {
                    var olddiscount = parseInt($('#crfex_discount2Edit').val());
                    var requestdiscount = parseInt($('#cal_crfex_discount2Edit').val());
                    var sumdiscount = 0;
                    if ($('#discount_conditionEdit').val() == 'writeup') {
                        sumdiscount = olddiscount + requestdiscount;
                    } else if ($('#discount_conditionEdit').val() == 'writedown') {
                        if (requestdiscount > olddiscount) {
                            alert('Please check request discount!!');
                            $('#cal_crfex_discount2Edit').val('');
                        } else {
                            sumdiscount = olddiscount - requestdiscount;
                        }
                    }
                    $('#sum_crfex_discount2Edit').val(sumdiscount);
                });
                $('#cal_crfex_discount2Edit').change(function () {
                    var olddiscount = parseInt($('#crfex_discount2Edit').val());
                    var requestdiscount = parseInt($('#cal_crfex_discount2Edit').val());
                    var sumdiscount = 0;
                    if ($('#discount_conditionEdit').val() == 'writeup') {
                        sumdiscount = olddiscount + requestdiscount;
                    } else if ($('#discount_conditionEdit').val() == 'writedown') {
                        if (requestdiscount > olddiscount) {
                            alert('Please check request discount!!');
                            $('#cal_crfex_discount2Edit').val('');
                        } else {
                            sumdiscount = olddiscount - requestdiscount;
                        }
                    }
                    $('#sum_crfex_discount2Edit').val(sumdiscount);
                });




            } else {
                $('#crfex_curcustopic2').prop('checked', false);
                $('#crfex_creditlimit , #crfex_term , #crfex_discount , #crfex_payment , #crfex_creditlimit2 , #crfex_term2 , #crfex_discount2').prop('readonly', true);

            }

        } else {
            $('#crfex_custype2').prop('checked', false);
        }
        $('.custype1e , .custype2e').attr('onclick', 'return false');
        // Check ประเภทลูกค้า







        $('#crfex_curcustopic1').click(function () {
            if ($(this).prop('checked')) {
                $('#crfex_salesreps , #crfex_cusnameEN , #crfex_cusnameTH , #crfex_address , #crfex_tel , #crfex_fax , #crfex_email , #crfex_file , #crfex_combg , #crfex_his_month1 , #crfex_his_tvolume1 , #crfex_histsales1 , #crfex_his_month2 , #crfex_his_tvolume2 , #crfex_histsales2 , #crfex_his_month3 , #crfex_his_tvolume3 , #crfex_histsales3').prop('readonly', false);
            } else {
                $('#crfex_salesreps , #crfex_cusnameEN , #crfex_cusnameTH , #crfex_address , #crfex_tel , #crfex_fax , #crfex_email , #crfex_file , #crfex_combg , #crfex_his_month1 , #crfex_his_tvolume1 , #crfex_histsales1 , #crfex_his_month2 , #crfex_his_tvolume2 , #crfex_histsales2 , #crfex_his_month3 , #crfex_his_tvolume3 , #crfex_histsales3').prop('readonly', true);
            }
        });

        $('#crfex_curcustopic2').click(function () {
            if ($(this).prop('checked')) {
                $('#crfex_creditlimit , #crfex_term , #crfex_discount , #crfex_payment').prop('readonly', false);
            } else {
                $('#crfex_creditlimit , #crfex_term , #crfex_discount , #crfex_payment , #crfex_creditlimit2 , #crfex_term2 , #crfex_discount2').prop('readonly', true);
            }
        });

        // Check Current customer method





        // Edit page  // Edit page  // Edit page  // Edit page  // Edit page 
        // Edit page  // Edit page  // Edit page  // Edit page  // Edit page 
        // Edit page  // Edit page  // Edit page  // Edit page  // Edit page

    }

    // Export Zone Export Zone Export Zone Export Zone Export Zone Export Zone
    // Export Zone Export Zone Export Zone Export Zone Export Zone Export Zone
    // Export Zone Export Zone Export Zone Export Zone Export Zone Export Zone
    // Export Zone Export Zone Export Zone Export Zone Export Zone Export Zone// Export Zone Export Zone Export Zone Export Zone Export Zone Export Zone
    // Export Zone Export Zone Export Zone Export Zone Export Zone Export Zone// Export Zone Export Zone Export Zone Export Zone Export Zone Export Zone













    // Edit Internal Zone
    // Edit page Internal // Edit page Internal // Edit page Internal // Edit page Internal
    // Edit page Internal // Edit page Internal // Edit page Internal // Edit page Internal


    $('#edit_regiscost ,#crf_finance_req_number , #crf_finance_change_total').val(function (index, value) {
        return value
            .replace(/\D/g, "")
            .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            ;
    });


    // Edit sales reps
    // Get data
    $('.edit_salesreps').click(function () {
        var data_edit_cusid = $(this).attr('data_edit_cusid');
        var data_edit_salesreps = $(this).attr('data_edit_salesreps');

        $('#edit_salesrepV').val(data_edit_salesreps);
        $('#edit_cusid').val(data_edit_cusid);

    });

    // Update data
    $('#btnEditSaleRep').click(function () {
        var editview_cusid = $('#edit_cusid').val();
        var editview_salesrepV = $('#edit_salesrepV').val();
        // var cusId = "test";

        //call ajax function
        edit_salesreps(editview_cusid, editview_salesrepV);

    });


    // Edit page    // Edit page    // Edit page    // Edit page    // Edit page
    // Edit page    // Edit page    // Edit page    // Edit page    // Edit page
    // Edit page    // Edit page    // Edit page    // Edit page    // Edit page
    // Check edit บริษัท
    if ($('#check_editcom').val() == 'sln') {
        $('#edit_company_sln').prop('checked', true);
    } else if ($('#check_editcom').val() == 'poly') {
        $('#edit_company_poly').prop('checked', true);
    } else if ($('#check_editcom').val() == 'ca') {
        $('#edit_company_ca').prop('checked', true);
    }else if($('#check_editcom').val() == 'tb'){
        $('#edit_company_tb').prop('checked', true);
    }else if($('#check_editcom').val() == 'st'){
        $('#edit_company_st').prop('checked', true);
    }


    $(document).on('click', '#remove_pri', function () {
        var btnid = $(this).attr('data-btnid');
        $('#priManage' + btnid).remove();
    });



    // Check edit ลูกค้าเก่า , ลูกค้าใหม่
    if ($('#check_editcustype').val() == 1) {
        $('.suboldcustomer').remove();
        $('#edit_custype1').prop('checked', true);
        $('input:radio[name="crf_type"]').prop('disabled', true);
        // Check ที่อยู่สำหรับการเปิดใบกำกับภาษี
        if ($('#check_addtype').val() == "ตาม ภ.พ.20") {
            $('#edit_addresstype1').prop('checked', true);
        } else if ($('#check_addtype').val() == "อื่นๆ") {
            $('#edit_addresstype2').prop('checked', true);
        }


        // Check ประเภทบริษัท
        if ($('#check_comtype').val() == 1) {
            $('.crf_companytype1').prop('checked', true);
        } else if ($('#check_comtype').val() == 2) {
            $('.crf_companytype2').prop('checked', true);
            $('#companytype2').css('display', '');
        } else if ($('#check_comtype').val() == 3) {
            $('.crf_companytype3').prop('checked', true);
            $('#companytype3').css('display', '');
        }

        $('input:radio[name="crf_companytype"]').click(function () {
            if ($(this).val() == 1) {
                $('#crf_companytype2 , #crf_companytype3_1_1 , #crf_companytype3_1_2 , #crf_companytype3_2_1 , #crf_companytype3_2_2').val('');
            }
            if ($(this).val() == 2) {
                $('#crf_companytype3_1_1 , #crf_companytype3_1_2 , #crf_companytype3_2_1 , #crf_companytype3_2_2').val('');
            }
            if ($(this).val() == 3) {
                $('#crf_companytype2').val('');
            }
        });



        // Check ประเภทของธุรกิจ
        if ($('#check_busitype').val() == "ผู้ผลิต") {
            $('.crf_typeofbussi1').prop('checked', true);
        } else if ($('#check_busitype').val() == "ผู้ค้า") {
            $('.crf_typeofbussi2').prop('checked', true);
        }


        // Check เงื่อนไขการวางบิล
        if ($('#check_conditionbill').val() == "ส่งของพร้อมวางบิล") {
            $('.crf_condition_billv1').prop('checked', true);
        } else if ($('#check_conditionbill').val() == "วางบิลตามตาราง") {
            $('.crf_condition_billv2').prop('checked', true);
            $('.crf_condition_bill2edit').css('display', '');
        } else if ($('#check_conditionbill').val() == "วางบิลทุกวันที่") {
            $('.crf_condition_billv3').prop('checked', true);
            $('.crf_condition_bill3').css('display', '');
        }
        $('input:radio[name="crf_condition_bill"]').click(function () {
            if ($(this).val() == 'ส่งของพร้อมวางบิล') {

            }

            if ($(this).val() == 'วางบิลตามตาราง') {
                $('.crf_condition_bill2edit').css('display', '');
            } else {
                $('.crf_condition_bill2edit').css('display', 'none');
            }

            if ($(this).val() == 'วางบิลทุกวันที่') {
                $('.crf_condition_bill3').css('display', '');
            } else {
                $('.crf_condition_bill3').css('display', 'none');
            }

        });


        // Check เงื่อนไขการรับชำระเงิน
        if ($('#check_conditionmoney').val() == "โอนเงิน") {
            $('.crf_condition_moneyv1').prop('checked', true);
        } else if ($('#check_conditionmoney').val() == "รับเช็ค") {
            $('.crf_condition_moneyv2').prop('checked', true);
            $('.recive_cheuqe').css('display', '');
        }
        $('input:radio[name="edit_condition_money"]').click(function () {
            if ($(this).val() == 'รับเช็ค') {
                $('.recive_cheuqe').css('display', '');
            } else {
                $('.recive_cheuqe').css('display', 'none');
            }
        });


        // Check วงเงินการค้าและเงื่อนไขที่ขอเสนอ
        if ($('#check_editfinance').val() == "ขอวงเงิน") {
            $('.crf_financev1').prop('checked', true);
            $('input:radio[name="crf_finance"]').prop('disabled', true);
        } else if ($('#check_editfinance').val() == "ปรับวงเงิน") {
            $('.crf_financev2').prop('checked', true);
        }


        // For view file


        // Zone Edit page when current customer
    } else if ($('#check_editcustype').val() == 2) {
        $('#edit_custype2').prop('checked', true);
        $('.suboldcustomer').css('display', '');
        $('input:radio[name="crf_type"]').prop('disabled', true);

        // Check ที่อยู่สำหรับการเปิดใบกำกับภาษี
        if ($('#check_addtype').val() == "ตาม ภ.พ.20") {
            $('#edit_addresstype1').prop('checked', true);
        } else if ($('#check_addtype').val() == "อื่นๆ") {
            $('#edit_addresstype2').prop('checked', true);
        }


        // Check ประเภทบริษัท
        if ($('#check_comtype').val() == 1) {
            $('.crf_companytype1').prop('checked', true);
        } else if ($('#check_comtype').val() == 2) {
            $('.crf_companytype2').prop('checked', true);
        } else if ($('#check_comtype').val() == 3) {
            $('.crf_companytype3').prop('checked', true);
        }



        // Check ประเภทของธุรกิจ
        if ($('#check_busitype').val() == "ผู้ผลิต") {
            $('.crf_typeofbussi1').prop('checked', true);
        } else if ($('#check_busitype').val() == "ผู้ค้า") {
            $('.crf_typeofbussi2').prop('checked', true);
        }


        // Check เงื่อนไขการวางบิล
        if ($('#check_conditionbill').val() == "ส่งของพร้อมวางบิล") {
            $('.crf_condition_billv1').prop('checked', true);
        } else if ($('#check_conditionbill').val() == "วางบิลตามตาราง") {
            $('.crf_condition_billv2').prop('checked', true);
            $('.crf_condition_bill2edit').css('display', '');
        } else if ($('#check_conditionbill').val() == "วางบิลทุกวันที่") {
            $('.crf_condition_billv3').prop('checked', true);
            $('.crf_condition_bill3').css('display', '');
        }


        // Check เงื่อนไขการรับชำระเงิน
        if ($('#check_conditionmoney').val() == "โอนเงิน") {
            $('.crf_condition_moneyv1').prop('checked', true);
        } else if ($('#check_conditionmoney').val() == "รับเช็ค") {
            $('.crf_condition_moneyv2').prop('checked', true);
            $('.recive_cheuqe').css('display', '');
        }


        // Check วงเงินการค้าและเงื่อนไขที่ขอเสนอ
        if ($('#check_editfinance').val() == "ขอวงเงิน") {
            $('.crf_financev1').prop('checked', true);
        } else if ($('#check_editfinance').val() == "ปรับวงเงิน") {
            $('.crf_financev2').prop('checked', true);
        }


        $('.edit_salesrepsCur').remove();
        $('#edit_customername , #edit_cuscompanycreate , #edit_addressname , #edit_namecontact , #edit_telcontact , #edit_faxcontact , #edit_emailcontact  ,  #edit_forecast , #crf_recive_cheuqedetail , #crf_finance_req_number , #edit_salesreps').prop('readonly', true);
        $('#crf_file1 , #crf_file2 , #crf_file3 , #crf_file4 , #crf_file5 , #crf_file6 , #crf_file7 , #crf_file8 , #crf_file9 , #crf_recive_cheuqetable').css('display', 'none');
        // $('#add_more_primanage').css('display', 'none');
        // $('input:radio').attr('onclick', 'return false');
        // $('input:checkbox[id="crf_process"]').attr('onclick', 'return false');
        $('#crf_creditterm').hide();
        $('#showCreditname').css('display', '');

        // กรณีที่เป็นลูกค้าเก่า
        // Control subold customer method
        if ($('#check_changearea').val() == 1) {
            $('input[name="crf_sub_oldcus_changearea"]').prop('checked', true);
            $('#edit_salesreps').prop('readonly', false);
        } else {
            $('#edit_salesreps').prop('readonly', true);
        }

        if ($('#check_changeaddress').val() == 2) {
            $('input[name="crf_sub_oldcus_changeaddress"]').prop('checked', true);
            $('#edit_addressname , #edit_namecontact , #edit_telcontact , #edit_faxcontact , #edit_emailcontact').prop('readonly', false);
            $('#crf_file1').css('display', '');
            $('input:radio[name="edit_addresstype"]').attr('onclick', '');
        } else {
            $('#edit_addressname , #edit_namecontact , #edit_telcontact , #edit_faxcontact , #edit_emailcontact').prop('readonly', true);
            $('#crf_file1').css('display', 'none');
            $('input:radio[name="edit_addresstype"]').attr('onclick', 'return false');
        }

        if ($('#check_changecredit').val() == 3) {
            $('input[name="crf_sub_oldcus_changecredit"]').prop('checked', true);
            $('.change_credit , .change_credit_detail').css('display', '');
            $('#crf_change_creditterm').prop('checked', true);
        } else {
            $('.change_credit , .change_credit_detail').css('display', 'none');
            $('#crf_change_creditterm').prop('checked', false);
        }

        if ($('#check_changefinance').val() == 4) {
            $('input[name="crf_sub_oldcus_changefinance"]').prop('checked', true);
            $('.finance_change_detail').css('display', '');
        } else {
            $('.finance_change_detail').css('display', 'none');
        }

        if ($('#check_editcustomerdetail').val() == 5) {
            $('input:checkbox[name="crf_sub_oldcus_editcustomer"]').prop('checked', true);
            $('#crf_file1 , #crf_file2 , #crf_file3 , #crf_file4 , #crf_file5 , #crf_file6 , #crf_file7 , #crf_file8 , #crf_file9 , #crf_recive_cheuqetable').css('display', '');
            $('#edit_namecontact , #edit_telcontact , #edit_faxcontact , #edit_emailcontact').prop('readonly' , false);
            $('#edit_customername').prop('readonly', false);
        }



        $('input:checkbox[name="crf_sub_oldcus_changearea"]').click(function () {
            if ($(this).prop('checked') == true) {
                $('#edit_salesreps').prop('readonly', false);
            } else {
                $('#edit_salesreps').prop('readonly', true);
            }
        });

        $('input:checkbox[name="crf_sub_oldcus_changeaddress"]').click(function () {
            if ($(this).prop('checked') == true) {
                $('#edit_addressname , #edit_namecontact , #edit_telcontact , #edit_faxcontact , #edit_emailcontact').prop('readonly', false);
                $('#crf_file1').css('display', '');
                $('input:radio[name="edit_addresstype"]').attr('onclick', '');
            } else {
                $('#edit_addressname , #edit_namecontact , #edit_telcontact , #edit_faxcontact , #edit_emailcontact').prop('readonly', true);
                $('#crf_file1').css('display', 'none');
                $('input:radio[name="edit_addresstype"]').attr('onclick', 'return false');
            }
        });

        $('input:checkbox[name="crf_sub_oldcus_changecredit"]').click(function () {
            if ($(this).prop('checked') == true) {
                $('.change_credit , .change_credit_detail').css('display', '');
                $('#crf_change_creditterm').prop('checked', true);
            } else {
                $('.change_credit').css('display', 'none');
                $('.change_credit , .change_credit_detail').css('display', 'none');
            }
        });

        $('input:checkbox[name="crf_sub_oldcus_changefinance"]').click(function () {
            if ($(this).prop('checked') == true) {
                $('.finance_change_detail , #crf_finance_req_number').css('display', '');
                $('input:radio[name="crf_finance"]').attr('onclick', '');
                $('.crf_financev2').prop('checked', true);
            } else {
                $('.finance_change_detail , #crf_finance_req_number').css('display', 'none');
                $('.crf_financev2').prop('checked', false);
            }
        });

        $('input:checkbox[name="crf_sub_oldcus_editcustomer"]').click(function(){
            if($(this).prop('checked') == true){
                console.log('test');
                $('#edit_namecontact , #edit_telcontact , #edit_faxcontact , #edit_emailcontact').prop('readonly' , false);
                $('.crf_file1_edit').css('display' , '');
                $('.crf_file2_edit').css('display' , '');
                $('.crf_file3_edit').css('display' , '');
                $('.crf_file4_edit').css('display' , '');
                $('.crf_file5_edit').css('display' , '');
                $('.crf_file6_edit').css('display' , '');
            }else{
                $('#edit_namecontact , #edit_telcontact , #edit_faxcontact , #edit_emailcontact').prop('readonly' , true);
            }
        });


        $('#crf_finance_change_number').keyup(function () {
            var oldmoney = parseInt($('#crf_finance_req_number_calc').val());
            var newmoney = parseInt($(this).val())
            if ($('#crf_finance_change_status').val() == 'เพิ่ม') {
                $('#crf_finance_change_total').val(oldmoney + newmoney);
            } else if ($('#crf_finance_change_status').val() == 'ลด') {
                $('#crf_finance_change_total').val(oldmoney - newmoney);
            }

            $('#crf_finance_change_total').val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
            if ($(this).val() != '') {
                $('#user_submit').prop('disabled', false);
            } else {
                $('#user_submit').prop('disabled', true);
            }
        });











    }
    // End check
    // Edit page Internal // Edit page Internal // Edit page Internal // Edit page Internal
    // Edit page Internal // Edit page Internal // Edit page Internal // Edit page Internal




    /////////////////////////////////////////////////////////
    //////////// edit page (กรณีเลือกประเภทลูกค้า)
    ////////////////////////////////////////////////////////

    if ($('#edit_checkCusType').val() == "natural") {

        $('#edit_crf_person_type_natural').prop('checked', true);
        $('#edit_file_juristic').css('display', 'none');
        $('#crf_file_person').prop('disabled' , true);

    } else if ($('#edit_checkCusType').val() == "juristic") {

        $('#edit_crf_person_type_juristic').prop('checked', true);
        $('#edit_file_natural').css('display', 'none');

    }


    /////////////////////////////////////////////////////////
    //////////// edit page (กรณีเลือกประเภทลูกค้า)
    ////////////////////////////////////////////////////////







    // Report page

    // Control color status
    $('table#report_list').each(function () {
        if ($('td:contains(Open)').text()) {
            $('.statuscolor').css('color', '#0066FF');
        }
    });
    // Control color status

    // Control show table export
    loadreportEx();
    $('#btnSearch').click(function () {
        var datestart = $('#dateStart').val();
        var dateend = $('#dateEnd').val();
        if (datestart != '' || dateend != '') {
            loadreportExdate(datestart, dateend);
        } else {
            loadreportEx();
        }

    });


    loadreport();
    $('#btnSearchTH').click(function () {
        var datestart = $('#dateStart').val();
        var dateend = $('#dateEnd').val();
        if (datestart != '' || dateend != '') {
            loadreportdate(datestart, dateend);
        } else {
            loadreport();
        }

    });





    // Setting page
    $('#btnSysEmail').click(function () {
        var email_account = $('#email_account').val();
        var email_password = $('#email_password').val();

        if ($(this).text() == "Submit") {
            insertEmailSystem(email_account, email_password);
        } else {
            alert("That false.");
        }
    });





    //Customer map to modal
    $('#mapfilelink').on('click', function () {
        var data_mapfile = $(this).attr('data_mapfile');
        var url = 'http://intranet.saleecolour.com/intsys/crf/upload/';

        var cutFileType = data_mapfile.substr(-3, 4);
        if (cutFileType == 'jpg' || cutFileType == 'JPG' || cutFileType == 'png' || cutFileType == 'PNG') {
            $('#showmapfileImg_output').attr('src', url + data_mapfile);
            $('#showmapfile_output').hide();
        } else {
            $('#showmapfile_output').attr('src', url + data_mapfile);
            $('#showmapfileImg_output').hide();
        }

    });




    // Button edit map url and map file
    $('#editMapUrl , #editMapFile').mouseover(function () {
        $(this).css('color', '#FF6600');
    });
    $('#editMapUrl , #editMapFile').mouseout(function () {
        $(this).css('color', 'orange');
    });
    $('#editMapUrl').click(function () {
        $('.notEdit1').css('display', 'none');
        $('.canEdit1').css('display', '');
    });

    $('#editMapFile').click(function () {
        $('.notEdit2').css('display', 'none');
        $('.canEdit2').css('display', '');
    });
    // Button edit map url and map file



    // Zone load customer list
    if ($('#checkPagecuslist').val() == "customerList") {
        loadcustomerlist();
    }







    // Export
    if ($('#checkPagecuslistEx').val() == "customerListEx") {
        loadcustomerlistEx();
    }




////////////////////////////////////////////////////////////////////////////
///////////Add customer ex manual
///////////////////////////////////////////////////////////////////////////




    // Check fill add customer manual export zone


    // Check company
    $('#addcusex_customercode').focus(function () {
        var addcusex_company = $('input:radio[name="addcusex_company"]:checked');
        if (addcusex_company.length < 1) {
            $('#alert_addcusex_company').html('<div class="alert alert-danger" role="alert">Please choose company !!</div>');
            $('#addcusex_customercode').val('').prop('disabled' , true);
        } else {
            $('#alert_addcusex_company').html('');
        }
    });

    $('#addcusex_customercode').keyup(function () {
        var addcusex_company = $('input:radio[name="addcusex_company"]:checked');
        if (addcusex_company.length < 1) {
            $('#alert_addcusex_company').html('<div class="alert alert-danger" role="alert">Please choose company !!</div>');
            $('#addcusex_customercode').val('');
        } else {
            $('#alert_addcusex_company').html('');
        }
    });

    ////////////////////////////////////////////
    /////Check การเลือกบริษัทว่ามีการติ๊กเลือกหรือยัง
    $('input:radio[name="addcusex_company"]').change(function(){
        if($(this).val() != ""){
            $('#addcusex_customercode').val('').prop('disabled' , false);
        }
    });
    ////////////////////////////////////////////
    /////Check การเลือกบริษัทว่ามีการติ๊กเลือกหรือยัง


    // Check company
////////////////////////////////////////////////////////////////////////////
///////////Add customer ex manual
///////////////////////////////////////////////////////////////////////////



    // control addCustomer
    // Get customer data Zone add customer manual
    if ($('#checkaddcuspage').val() == "addCustomer") {

        // ตรวจสอบเงื่อนไขว่าเป็นบุคคลทั่วไปหรือว่า นิติบุคคล
        $('input:radio[name="crf_person_type"]').change(function(){

            if($(this).val() == "natural"){
                $('#for_natural_manual').css('display' , '');
                $('#labelDateCreate').text("วันเดือนปีเกิด");
                $('#addcus_file1 , #addcus_file2 ,#addcus_file3,#addcus_file4,#addcus_file5,#addcus_file6').prop('disabled' , true);
            }else{
                $('#for_natural_manual').css('display' , 'none');
                $('#labelDateCreate').text("วันที่ก่อตั้ง");
                $('#addcus_file1 , #addcus_file2 ,#addcus_file3,#addcus_file4,#addcus_file5,#addcus_file6').prop('disabled' , false);
            }

            if($(this).val() == "juristic"){
                $('#for_juristic_manual').css('display' , '');
                $('#labelDateCreate').text("วันที่ก่อตั้ง");
                $('#crf_file_person').prop('disabled' , true);
            }else{
                $('#for_juristic_manual').css('display' , 'none');
                $('#labelDateCreate').text("วันเดือนปีเกิด");
                $('#crf_file_person').prop('disabled' , false);
            }
        });


















        $('#addcus_customercode').keyup(function () {

            var cuscode = $(this).val();
            if (cuscode != '') {
                autosearchCustomermanual(cuscode);
            } else {
                $('#autocuscodemanual').html('');
            }

        });


        $('#addcus_customername').keyup(function () {

            var cusname = $(this).val();
            if (cusname != '') {
                autosearchCustomermanualname(cusname);
            } else {
                $('#autocuscodemanualname').html('');
            }

        });

        $(document).on('click', '.selectCusCodeManualcode', function () {
            let data_addcus_code = $(this).attr('data_addcus_code');
            let data_addcus_name = $(this).attr('data_addcus_name');
            let data_addcus_address = $(this).attr('data_addcus_address');
            let data_addcus_phone = $(this).attr('data_addcus_phone');
            let data_addcus_fax = $(this).attr('data_addcus_fax');
            let data_addcus_email = $(this).attr('data_addcus_email');
            let data_addcus_taxid = $(this).attr('data_addcus_taxid');
            let data_addcus_area = $(this).attr('data_addcus_area');
            let data_addcus_branch = $(this).attr('data_addcus_branch');
            let data_addcus_termid = $(this).attr('data_addcus_termid');
            let data_addcus_termname = $(this).attr('data_addcus_termname');
            let data_addcus_creditlimit = $(this).attr('data_addcus_creditlimit');
            let data_addcus_firstname = $(this).attr('data_addcus_firstname');

            let data_addcus_salesgroup = $(this).attr('data_addcus_salesgroup');



            if(data_addcus_termname != ""){
                $('#addcus_creditterm').attr("style", "pointer-events: none;");
                $('#alertOldCusCredit').html('<span style="color:red;">** รายการ Credit term ไม่สามารถแก้ไขได้ เนื่องจากข้อมูลมาจาก ระบบ AX **</span>');
            }
            if(data_addcus_creditlimit != ""){
                $('#crf_finance_req_number').attr("readonly" , true);
            }


            $.ajax({
                url:"/intsys/crf/customers/fetchCustomercode",
                method:"POST",
                data:{
                    cuscode:data_addcus_code,
                    taxid:data_addcus_taxid
                },
                success:function(data){
                    if(JSON.parse(data).result > 0){
                        $('#alertCuscode').fadeIn();
                        $('#alertCuscode').html('<div class="alert alert-danger" role="alert">พบข้อมูลซ้ำในระบบ</div>').fadeOut(3500);
                        $('#addcus_customercode').val('');
                        $('#autocuscodemanual').html('');
                    }else{
                        $('#addcus_customercode').val(data_addcus_code);
                        $('#addcus_customername').val(data_addcus_name);
                        $('#addcus_addressname').val(data_addcus_address);
                        $('#addcus_telcontact').val(data_addcus_phone);
                        $('#addcus_faxcontact').val(data_addcus_fax);
                        $('#addcus_emailcontact').val(data_addcus_email);
                        $('#addcus_customertaxid').val(data_addcus_taxid);
                        $('#addcus_customerbranch').val(data_addcus_branch);
                        $('#addcus_creditterm option:selected').val(data_addcus_termid).text(data_addcus_termname);
                        $('#crf_finance_req_number').val(data_addcus_creditlimit);
                        $('#addcus_namecontact').val(data_addcus_firstname);
                        $('#addcus_salesreps').val(data_addcus_salesgroup).prop('readonly' , true);
            
                        $('input:radio[id="addcus_addresstype1"]').prop('checked', true);

                        // Convert Currency to comma
                        $('input[name=addcus_regiscost]').keyup(function (event) {
                            /*****Comma function*******/
                            // skip for arrow keys
                            if (event.which >= 37 && event.which <= 40)
                                return;

                            // format number
                            $(this).val(function (index, value) {
                                return value
                                    .replace(/\D/g, "")
                                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                                    ;
                            });
                        });


                        if (data_addcus_area == 'sln') {
                            $('input:radio[id="addcus_company_sln"]').prop('checked', true);
                        } else if (data_addcus_area == 'poly') {
                            $('input:radio[id="addcus_company_poly"]').prop('checked', true);
                        } else if (data_addcus_area == 'ca') {
                            $('input:radio[id="addcus_company_ca"]').prop('checked', true);
                        }else if(data_addcus_area == 'tbb'){
                            $('input:radio[id="addcus_company_tb"]').prop('checked' , true);
                        }else if(data_addcus_area == 'st'){
                            $('input:radio[id="addcus_company_st"]').prop('checked' , true);
                        }
            
                        $('#autocuscodemanual').html('');
                        $('#autocuscodemanualname').html('');
                    }
                }
            });

        });

    }
    // Control by page








    if ($('#checkaddcuspageen').val() == 'addCustomerEx') {

        $('#addcusex_customercode').blur(function () {
            var cuscode = $('#addcusex_customercode').val();
            var area = $('input:radio[name="addcusex_company"]:checked').val();
            checkCuscodeManualEx(cuscode, area);
        });
    
        $('#addcusex_customercode').keyup(function () {
            var cuscode = $('#addcusex_customercode').val();
            var area = $('input:radio[name="addcusex_company"]:checked').val();
            checkCuscodeManualEx(cuscode, area);
        });



        $('#addcusex_customercode').keyup(function () {

            var cuscode = $(this).val();
            if (cuscode != '') {
                autosearchCustomermanualex(cuscode);
            } else {
                $('#autocuscodemanualex').html('');
            }

        });


        $('#addcusex_cusnameEN').keyup(function () {

            var cusname = $(this).val();
            if (cusname != '') {
                autosearchCustomermanualnameex(cusname);
            } else {
                $('#autocuscodemanualnameex').html('');
            }

        });


        $(document).on('click', '.selectCusCodeManualcodeex', function () {
            var data_addcus_codeex = $(this).attr('data_addcus_codeex');
            var data_addcus_nameex = $(this).attr('data_addcus_nameex');
            var data_addcus_addressex = $(this).attr('data_addcus_addressex');
            var data_addcus_phoneex = $(this).attr('data_addcus_phoneex');
            var data_addcus_faxex = $(this).attr('data_addcus_faxex');
            var data_addcus_emailex = $(this).attr('data_addcus_emailex');
            var data_addcus_areaex = $(this).attr('data_addcus_areaex');


            $('#addcusex_customercode').val(data_addcus_codeex);
            $('#addcusex_cusnameEN').val(data_addcus_nameex);
            $('#addcusex_address').val(data_addcus_addressex);
            $('#addcusex_tel').val(data_addcus_phoneex);
            $('#addcusex_fax').val(data_addcus_faxex);
            $('#addcusex_email').val(data_addcus_emailex);


            if (data_addcus_areaex == 'sln') {
                $('input:radio[id="addcusex_company_sln"]').prop('checked', true);
            } else if (data_addcus_areaex == 'poly') {
                $('input:radio[id="addcusex_company_poly"]').prop('checked', true);
            } else if (data_addcus_areaex == 'ca') {
                $('input:radio[id="addcusex_company_ca"]').prop('checked', true);
            }

            $('#autocuscodemanualex').html('');
            $('#autocuscodemanualnameex').html('');


        })




    }
    // Export zone control by page







    if ($('#forcrf_sub_oldcus_changearea_view').val() == 1) {
        // $('.director1 , .director2').css('display' , 'none');
    }










});
 // END FUNCTION