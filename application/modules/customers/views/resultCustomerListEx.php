<div class="datatable-container">
    <table name="customers_listEx" id="customers_listEx" class="table table-striped table-bordered table-responsive" width="100%">

        <thead>
            <tr>
                <th>Customer code</th>
                <th>Company</th>
                <th>Customer name</th>
                <th>Address</th>
                <th>Sales reps</th>
                <th>Phone</th>

            </tr>
        </thead>

        <tbody>
            <?php foreach ($rss->result() as $rs) {

            ?>
                <tr>
                    <td><b><a href="<?=base_url('customers/view_customerdataEx/').$rs->crfexcus_code."/".$rs->crfexcus_area?>"><?= $rs->crfexcus_code ?></a></b></td>
                    <td><?= $rs->crfexcus_area ?></td>
                    <td><?= $rs->crfexcus_nameEN ?></td>
                    <td><?= $rs->crfexcus_address ?></td>
                    <td><?= $rs->crfexcus_salesreps ?></td>
                    <td><?= $rs->crfexcus_tel ?></td>
                </tr>
            <?php }; ?>
        </tbody>

    </table>
</div>