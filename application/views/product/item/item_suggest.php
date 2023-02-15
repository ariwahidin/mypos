<section class="content-header">
    <h1>
        Qty Suggest Order
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <?php $this->view('messages') ?>
    <div class="box">
        <div class="box-header">
            <div class="pull-right">
                <a class="btn btn-flat btn-success" href="<?= site_url('item/order') ?>">Order</a>
            </div>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped" id="table1">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item Code</th>
                        <th>Barcode</th>
                        <th>Name</th>
                        <th>Harga Jual</th>
                        <th>Stock</th>
                        <th>Min Stock</th>
                        <th>Qty Suggest</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($item_suggest->result() as $data) { ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data->item_code ?></td>
                            <td><?= $data->barcode ?></td>
                            <td><?= $data->name ?></td>
                            <td><?= number_format($data->harga_jual) ?></td>
                            <td>
                                <a href="<?= base_url('item/item_stock_detail/') . $data->item_code ?>"><?= $data->stock ?></a>
                            </td>
                            <td><?= $data->min_stock ?></td>
                            <td><?= $data->suggest_qty ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>