<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report TH</title>

<link rel="stylesheet" href="<?=base_url('css/buttons.dataTables.min.css')?>">


<script src="<?= base_url('js/datatable/dataTables.buttons.min.js') ?>"></script>
<script src="<?= base_url('js/datatable/buttons.flash.min.js') ?>"></script>
<script src="<?= base_url('js/datatable/buttons.html5.min.js') ?>"></script>
<script src="<?= base_url('js/datatable/buttons.print.min.js') ?>"></script>
<script src="<?= base_url('js/datatable/jszip.min.js') ?>"></script>
<script src="<?= base_url('js/datatable/pdfmake.min.js') ?>"></script>
<script src="<?= base_url('js/datatable/vfs_fonts.js') ?>"></script>
<style>
    .col-search-input{
        width:100%;
    }
</style>


<script>
        $(document).ready(function ()
        {
            $('#user_data thead th').each(function () {
                var title = $(this).text();
                $(this).html(title+' <input type="text" class="col-search-input" placeholder="Search ' + title + '" />');
            });
            
            var table = $('#user_data').DataTable({
                	"scrollX": true,
            		"pagingType": "numbers",
                "processing": true,
                "serverSide": true,
                "ajax": "<?php echo base_url('main/report/server'); ?>",
                order: [[2, 'asc']],
                columnDefs: [{
                    targets: "_all",
                    orderable: false
                 }],
                //  dom: 'Bfrtip',
                // "buttons": [
                //     {
                //         extend: 'copyHtml5',
                //         title: 'Report OT Online By Department on '
                //     },
                //     {
                //         extend: 'excelHtml5',
                //         autoFilter: true,
                //         title: 'Report OT Online By Department on '
                //     }
                // ]
            });

            table.columns().every(function () {
                var table = this;
                $('input', this.header()).on('keyup change', function () {
                    if (table.search() !== this.value) {
                    	   table.search(this.value).draw();
                    }
                });
            });
        });

    </script>
</head>

<body>
    <div class="container-fulid bg-white p-3">
        <h3><?=$title?></h3>
        <div class="table-responsive">
            <br>
            <table id="user_data" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>เลขที่คำขอ</th>
                        <th>ชื่อลูกค้า</th>
                        <th>ประเภทลูกค้า</th>
                        <th>หัวข้อ</th>
                        <th>ผู้ดูแล</th>
                        <th>วันที่ออกเอกสาร</th>
                        <th>สถานะ</th>
                    </tr>
                </thead>
            </table>

        </div>
    </div>

</body>

</html>
