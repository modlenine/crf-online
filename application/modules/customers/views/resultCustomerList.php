<div class="datatable-container">
    <table name="customers_list" id="customers_list" class="table table-striped table-bordered table-responsive" width="100%">

        <thead>
            <tr>
                <th>รหัสลูกค้า</th>
                <th>บริษัท</th>
                <th>ชื่อลูกค้า</th>
                <th>ที่อยู่</th>
                <th>ผู้ดูแล</th>
                <th>ผู้ติดต่อ</th>
                <th>เบอร์โทร</th>

            </tr>
        </thead>

        <tbody>
            <?php foreach ($rss->result() as $rs) {

            ?>
                <tr>
                    <td><b><a href="<?=base_url('customers/view_customerdata/').$rs->crfcus_code?>"><?= $rs->crfcus_code ?></a></b></td>
                    <td><?= $rs->crfcus_area ?></td>
                    <td><?= $rs->crfcus_name ?></td>
                    <td><?= $rs->crfcus_address ?></td>
                    <td><?= $rs->crfcus_salesreps ?></td>
                    <td><?= $rs->crfcus_contactname ?></td>
                    <td><?= $rs->crfcus_phone ?></td>
                </tr>
            <?php }; ?>
        </tbody>

    </table>
</div>