<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายงานลูกค้าในประเทศ</title>

    <script src="<?= base_url('js/datatable/dataTables.buttons.min.js') ?>"></script>
    <script src="<?= base_url('js/datatable/buttons.flash.min.js') ?>"></script>
    <script src="<?= base_url('js/datatable/buttons.html5.min.js') ?>"></script>
    <script src="<?= base_url('js/datatable/buttons.print.min.js') ?>"></script>
    <script src="<?= base_url('js/datatable/jszip.min.js') ?>"></script>
    <script src="<?= base_url('js/datatable/pdfmake.min.js') ?>"></script>
    <script src="<?= base_url('js/datatable/vfs_fonts.js') ?>"></script>

    <script>
        $(document).ready(function() {
            // $('#report_list thead th').each(function() {
            //     var title = $(this).text();
            //     $(this).html(title + ' <input type="text" class="col-search-input" placeholder="Search ' + title + '" />');
            // });

            // var table = $('#report_list').DataTable({
            //     "columnDefs": [{
            //         "searching": false,
            //         "orderable": false,
            //         "targets": "_all"
            //     }],
            //     dom: 'Bfrtip',
            //     "buttons": [{
            //             extend: 'copyHtml5',
            //             title: 'Credit request form'
            //         },
            //         {
            //             extend: 'excelHtml5',
            //             autoFilter: true,
            //             title: 'Credit request form'
            //         }
            //     ],
            //     "order": [
            //         [0, 'desc']
            //     ]
            // });


            // table.columns().every(function() {
            //     var table = this;
            //     $('input', this.header()).on('keyup change', function() {
            //         if (table.search() !== this.value) {
            //             table.search(this.value).draw();
            //         }
            //     });
            // });




        });
    </script>
</head>

<body>
    <div class="container-fulid bg-white p-3">
    <h2>Report Credit Request Form</h2>
    <div class="row form-group">
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
    </div>
    <div id="showTableTH"></div>

    
    </div>
</body>

</html>