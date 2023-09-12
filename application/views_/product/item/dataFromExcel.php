<section class="content-header">
    <h1>
        Data From Excel
    </h1>
</section>
<section class="content">
    <div class="box">
        <?php $this->load->view('messages') ?>
        <div class="box-header">
            <form method="POST" action="<?= base_url('item/uploadExcel') ?>">
                <input type="hidden" name="file_target" value="<?=$target_file?>">
                <button name="submitProses" class="btn btn-info btn-flat pull"> Proses</button>
            </form>
            &nbsp;
        </div>
        <div class="box-body table-responsive">
            <table class="table table-striped" id="table1">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item Code</th>
                        <th>Barcode</th>
                        <th>Item Name</th>
                        <th>Qty</th>
                        <th>Expired Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach($excel_data as $data) { ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data['item_code'] ?></td>
                            <td><?= $data['barcode'] ?></td>
                            <td><?= $data['name'] ?></td>
                            <td><?= $data['qty'] ?></td>
                            <td><?= $data['expired_date'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>