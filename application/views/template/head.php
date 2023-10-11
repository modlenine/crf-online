<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />


    <script src="<?= base_url("js/jquery.min.js") ?>"></script>
    <!--     <script src="<?= base_url('js/fontawsome.js') ?>"></script> -->



    <link href="<?= base_url() ?>main.css" rel="stylesheet">
    <link href="<?= base_url('css/custom.css') ?>" rel="stylesheet">

    <!-- Data table -->
    <link rel="stylesheet" href="<?= base_url('css/jquery.dataTables.min.css') ?>">
    <script src="<?= base_url("js/jquery.dataTables.min.js") ?>"></script>
    <script src="<?= base_url("js/dataTables.responsive.min.js") ?>"></script>
    <link rel="stylesheet" type="text/css" href="<?= base_url('css/responsive.dataTables.min.css') ?>" />
    <script src="<?= base_url("js/dataTables2.responsive.min.js") ?>"></script>
    <!-- Data table -->






    <!-- Date picker -->
    <script src="<?=base_url()?>assets/dist/zebra_datepicker.min.js"></script>
    <link rel="stylesheet" href="<?=base_url()?>assets/dist/css/default/zebra_datepicker.min.css" type="text/css" />


    <style>
        /* thai */
        @font-face {
            font-family: 'Sarabun';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: local('Sarabun Regular'), local('Sarabun-Regular'), url(<?= base_url('assets/fonts/DtVjJx26TKEr37c9aAFJn2QN.woff2') ?>) format('woff2');
            unicode-range: U+0E01-0E5B, U+200C-200D, U+25CC;
        }

        /* vietnamese */
        @font-face {
            font-family: 'Sarabun';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: local('Sarabun Regular'), local('Sarabun-Regular'), url(<?= base_url('assets/fonts/DtVjJx26TKEr37c9aBpJn2QN.woff2') ?>) format('woff2');
            unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
        }

        /* latin-ext */
        @font-face {
            font-family: 'Sarabun';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: local('Sarabun Regular'), local('Sarabun-Regular'), url(<?= base_url('assets/fonts/DtVjJx26TKEr37c9aBtJn2QN.woff2') ?>) format('woff2');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        /* latin */
        @font-face {
            font-family: 'Sarabun';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: local('Sarabun Regular'), local('Sarabun-Regular'), url(<?= base_url('assets/fonts/DtVjJx26TKEr37c9aBVJnw.woff2') ?>) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        * {
            font-family: 'Sarabun', sans-serif;
        }

        body {
            font-size: .85rem !important;
        }

        thead input {
            width: 100%;
        }
    </style>
</head>
<?php
date_default_timezone_set("Asia/Bangkok");
getModal();
?>

<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        <div class="app-header header-shadow topmenu">
            <div class="app-header__logo">
                <div class=""><span style="font-size:18px;"><b><span style="color:white">CRF</span> ONLINE</b></span></div>
                <div class="header__pane ml-auto">
                    <div>
                        <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>

            </div>
            <div class="app-header__mobile-menu">
                <div>
                    <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="app-header__menu">
                <span>
                    <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                        <span class="btn-icon-wrapper">
                            <i class="fa fa-ellipsis-v fa-w-6"></i>
                        </span>
                    </button>
                </span>
            </div>
            <div class="app-header__content">
                <!-- <div class="app-header-left">
                    <div class="search-wrapper">
                        <div class="input-holder">
                            <input type="text" class="search-input" placeholder="Type to search">
                            <button class="search-icon"><span></span></button>
                        </div>
                        <button class="close"></button>
                    </div>
                </div> -->
                <div class="app-header-right">
                    <div class="header-btn-lg pr-0">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">

                                </div>
                                <!-- Check Dept For use in jQuery ################################################-->
                                <input hidden type="text" name="checkDept" id="checkDept" value="">

                                <!-- Check Position For use in jQuery ################################################-->
                                <input hidden type="text" name="checkPosi" id="checkPosi" value="">


                                <div class="widget-content-left  ml-3 header-user-info">

                                </div>
                                <div class="widget-content-right header-user-info ml-3">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <div class="app-main  scroll-area-sm">
            <div class="app-sidebar sidebar-shadow scrollbar-container">
                <div class="app-header__logo">
                    <div class=""></div>
                    <div class="header__pane ml-auto">
                        <div>
                            <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>



                <div class="scrollbar-sidebar">
                    <div class="app-sidebar__inner">
                        <ul class="vertical-nav-menu">
                            <!-- <li class="app-sidebar__heading">Dashboards</li>
                            <li>
                                <a href="" class="">
                                    <i class="metismenu-icon fas fa-chart-line"></i>
                                    Dashboard
                                </a>
                            </li> -->
                            <li class="app-sidebar__heading">Program</li>
                            <li>
                                <a href="<?= base_url() ?>" class="">
                                    <i class="metismenu-icon fas fa-home"></i>
                                    หน้าหลัก
                                </a>
                            </li>
                            <li class="app-sidebar__heading">ในประเทศ</li>
                            <li>
                                <a href="<?= base_url('main/showlist') ?>" class="">
                                    <i class="metismenu-icon fas fa-list-alt"></i><b>TH</b>
                                    แสดงรายการ ในประเทศ
                                </a>
                            </li>

                            <li>
                                <a href="<?= base_url('main/addTH') ?>" class="">
                                    <i class="metismenu-icon fas fa-plus-square"></i><b>TH</b>
                                    เพิ่มรายการ ในประเทศ
                                </a>
                            </li>

                            <li>
                                <a href="<?= base_url('customers/addCustomer') ?>" class="">
                                    <i class="metismenu-icon fas fa-database"></i><b>TH</b>
                                    เพิ่มฐานข้อมูลลูกค้า (Manual)
                                </a>
                            </li>

                            <li>
                                <a href="<?= base_url('customers/customerList') ?>" class="">
                                    <i class="metismenu-icon fas fa-th-list"></i><b>TH</b>
                                    รายชื่อลูกค้าในประเทศ
                                </a>
                            </li>

                            <li>
                                <a href="<?= base_url('main/report/reportTH') ?>" class="">
                                    <i class="metismenu-icon fas fa-print"></i>
                                    รายงาน
                                </a>
                            </li>


                            <li class="app-sidebar__heading">ต่างประเทศ</li>
                            <li>
                                <a href="<?= base_url('main/listex') ?>" class="">
                                    <i class="metismenu-icon fas fa-list-alt"></i><b>EX</b>
                                    แสดงรายการ ต่างประเทศ
                                </a>
                            </li>

                            <li>
                                <a href="<?= base_url('main/addEx') ?>" class="">
                                    <i class="metismenu-icon fas fa-plus-circle"></i><b>EX</b>
                                    เพิ่มรายการ ต่างประเทศ
                                </a>
                            </li>

                            <li>
                                <a href="<?= base_url('customers/addCustomerEx') ?>" class="">
                                    <i class="metismenu-icon fas fa-database"></i><b>EX</b>
                                    เพิ่มฐานข้อมูลลูกค้า (Manual)
                                </a>
                            </li>

                            <li>
                                <a href="<?= base_url('customers/customerListEx') ?>" class="">
                                    <i class="metismenu-icon fas fa-th-list"></i><b>EX</b>
                                    รายชื่อลูกค้า ต่างประเทศ
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url('main/report/reportEX') ?>" class="">
                                    <i class="metismenu-icon fas fa-print"></i>
                                    รายงาน
                                </a>
                            </li>


                            <?php
                            $emailShow = "";
                            if (getUser()->ecode != "M1809") {
                                $emailShow = ' style="display:none;" ';
                            } else {
                                $emailShow = '';
                            }

                            ?>


                            <li class="app-sidebar__heading">User Profile</li>

                            <li <?= $emailShow ?>>
                                <a href="javascript:voide(0)">
                                    <i class="metismenu-icon fas fa-cog"></i>
                                    ตั้งค่า
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                </a>
                                <ul>
                                    <li>
                                        <a href="<?= base_url('main/configemail') ?>" class="">
                                            <i class="metismenu-icon fas fa-print"></i>
                                            ตั้งค่า Email
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a>
                                    <i class="metismenu-icon fas fa-user"></i>
                                    สวัสดีคุณ &nbsp;<?= getUser()->Fname ?>
                                </a>
                            </li>
                            <!-- <li>
                                <a href="<?= base_url('Training.pdf') ?>" target="_blank">
                                    <i class="metismenu-icon fas fa-book"></i>
                                    คู่มือการใช้งาน
                                </a>
                            </li> -->
                            <li>
                                <a href="<?= base_url('login/logout') ?>">
                                    <i class="metismenu-icon fas fa-sign-out-alt"></i>
                                    <button class="btn btn-danger btnlogout">Logout</button>
                                </a>
                            </li>

                            <hr>
                            <div style="margin-top:50px;"></div>
                        </ul>
                    </div><!-- app-sidebar__inner -->
                </div><!-- scrollbar-sidebar -->
            </div><!-- app-sidebar -->



            <div class="app-main__outer">
                <div class="app-main__inner">

                    <!-- HEAD ZONE ###############################################
        #####################################################################
    ##########################################################################
#################################################################
        #####################################################################
    ##########################################################################
#################################################################
#################################################################-->