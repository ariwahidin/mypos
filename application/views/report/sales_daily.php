<section class="content-header">
        <h1>Sales Daily
            <small>Penjualan Hari Ini Tanggal : <?= date('d-m-Y', strtotime($sum->row()->tanggal)) ?></small>
            <a href="<?= site_url('sale/print_receipt_today') ?>" class="btn btn-success btn-flat pull-right"><i class="fa fa-print"></i> Print</a>
        </h1>
</section>

<!-- Main content -->
<section class="content">
    <?php $this->view('messages') ?>
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-bordered table-striped" id="table-stock">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Barcode</th>
                                <th>Item Name</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($daily->result() as $data) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $data->barcode ?></td>
                                    <td><?= $data->item_name ?></td>
                                    <td><?= $data->qty ?></td>
                                    <td><?= number_format($data->total) ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3">TOTAL</th>
                                <th>
                                    <?php
                                    $total_item = 0;
                                    $total_value = 0;
                                    foreach ($daily->result() as $tot) {
                                        $total_item += $tot->qty;
                                        $total_value += $tot->total;
                                    }
                                    echo number_format($total_item);
                                    ?>
                                </th>
                                <th>
                                    <?= number_format($total_value); ?>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-success">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped" id="table-stock">
                        <tr>
                            <td width="30%">Total Service</td>
                            <td><strong><?= number_format($sum->row()->total_discount) ?></strong></td>
                        </tr>
                        <tr>
                            <td>Total Disc Sale</td>
                            <td><strong><?= number_format($sum->row()->total_service) ?></strong></td>
                        </tr>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            $total_sales = 0;
                            $total_sales = $total_value + $sum->row()->total_service - $sum->row()->total_discount;
                            ?>
                            <span style="font-size:20px;font-weight:bold;">Total</span>
                            <span class="pull-right" style="font-size:50px;font-weight:bold;"><?= number_format($total_sales) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>