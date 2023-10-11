<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{title}</title>

    <script src="<?= base_url('js/datatable/dataTables.buttons.min.js') ?>"></script>
    <script src="<?= base_url('js/datatable/buttons.flash.min.js') ?>"></script>
    <script src="<?= base_url('js/datatable/buttons.html5.min.js') ?>"></script>
    <script src="<?= base_url('js/datatable/buttons.print.min.js') ?>"></script>
    <script src="<?= base_url('js/datatable/jszip.min.js') ?>"></script>
    <script src="<?= base_url('js/datatable/pdfmake.min.js') ?>"></script>
    <script src="<?= base_url('js/datatable/vfs_fonts.js') ?>"></script>

</head>

<body>
    <input hidden type="text" name="checkPagecuslist" id="checkPagecuslist" value="{geturl}">
    <div class="container-fulid bg-white p-3">
    <h2>รายชื่อลูกค้า</h2>
    <!-- <div class="row form-group">
        <div class="col-md-3">
            <label for="">Date Start</label>
            <input type="date" name="dateStart" id="dateStart" class="form-control form-control-sm">
        </div>
        <div class="col-md-3">
            <label for="">Date End</label>
        <input type="date" name="dateEnd" id="dateEnd" class="form-control form-control-sm">
        </div>
        <div class="col-md-2">
            <button id="btnSearchTH" name="btnSearchTH" class="btn btn-primary mt-4">Search</button>
        </div>
    </div> -->
    <div id="showCustomersList"></div>

    
    </div>
</body>

</html>