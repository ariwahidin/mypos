<section class="content-header">
    <h1>
       Data Stock Out
    </h1>
</section>

<section class="content">
    <div class="box">
        <div class="box-header">
            <form action="" method="post">
                <input type="hidden" name="download_stock_out">
                <button class="btn btn-success btn-flat pull-right">
                    <i class="fa fa-file-excel-o"></i> Download Excel
                </button>
            </form>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped" id="table1">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Barcode</th>
                        <th>Product Item</th>
                        <th>Qty</th>
                        <th>Info</th>
                        <th>Exp Date</th>
                        <th>Tanggal Stock Out</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($row as $key => $data) { ?>
                        <tr>
                            <td style="width:5%;"><?= $no++ ?>.</td>
                            <td><?= $data->barcode ?></td>
                            <td><?= $data->name ?></td>
                            <td class=""><?= $data->qty ?></td>
                            <td><?= $data->info ?></td>
                            <td class="">
                                <?= date('d-m-Y', strtotime($data->expired_date)) ?>
                            </td>
                            <td class="text-center" width="160px">
                                <?= date('d-m-Y', strtotime($data->created)) ?>
                            </td>
                        </tr>
                    <?php
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>