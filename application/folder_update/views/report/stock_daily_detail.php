<section class="content-header">
    <h1>Stock Daily Detail
        <small>Data stock detail yang sudah diupload</small>
        <button onclick="window.history.back()" class="btn btn-warning btn-sm pull-right">Back</button>
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header"></div>
                <div class="box-body table-responsive">
                    <table class="table table-bordered table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Whs Code</th>
                                <th>Barcode</th>
                                <th>Item Name</th>
                                <th>Qty</th>
                                <th>Exp Date</th>
                                <th>Tanggal Upload</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($stock) > 0) { ?>
                                <?php $no = 1;
                                foreach ($stock as $data) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $data['whs_code'] ?></td>
                                        <td><?= $data['barcode'] ?></td>
                                        <td><?= $data['item_name'] ?></td>
                                        <td><?= $data['qty'] ?></td>
                                        <td><?= $data['exp_date'] ?></td>
                                        <td><?= $data['date'] ?></td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>