
        <div class="datatable-container">
            
            <table name="report_listEx" id="report_listEx" class="table table-striped table-bordered table-responsive" width="100%">

                <thead>
                    <tr>
                        <th>Form no.</th>
                        <th>Customer code.</th>
                        <th>Customer name.</th>
                        <th>Customer type.</th>
                        <th>Topic.</th>
                        <th>Sales reps.</th>
                        <th>Date create.</th>
                        <th>Status.</th>

                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($rss as $rs) {
                        $topicRs = $rs->crfex_topic;
                        if ($rs->crfex_curcustopic1 != '') {
                            $topicRs .= " / " . $rs->crfex_curcustopic1;
                        }
                        if ($rs->crfex_curcustopic2 != '') {
                            $topicRs .= " / " . $rs->crfex_curcustopic2;
                        }



                    ?>
                        <tr>
                            <td><?= $rs->crfex_formno ?></td>
                            <td><?= $rs->crfexcus_code ?></td>
                            <td><?= $rs->crfexcus_nameEN ?></td>
                            <td><?= $rs->crf_alltype_subnameEN ?></td>
                            <td><?= $topicRs ?></td>
                            <td><?= $rs->crfexcus_salesreps ?></td>
                            <td><?= conDateFromDb($rs->crfex_datecreate) ?></td>
                            <td class="statuscolor"><b><?= $rs->crfex_status ?></b></td>
                        </tr>
                    <?php }; ?>
                </tbody>

            </table>
        </div>