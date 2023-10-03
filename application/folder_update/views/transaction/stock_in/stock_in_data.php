<?php
//   var_dump($row) 
?>

<section class="content-header">
    <h1>
        Data Stock In
    </h1>
</section>

<section class="content">
    <?php $this->view('messages') ?>
    <div class="box">
        <div class="box-header">
            <!-- <h3 class="box-title">Data Stock In</h3> -->
            <form action="" method="post">
                <input type="hidden" name="download_stock_in">
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
                        <th>Doc ID</th>
                        <th>Barcode</th>
                        <th>Desc</th>
                        <th>Qty</th>
                        <th>Exp Date</th>
                        <th>Info</th>
                        <th>Tanggal Stock In</th>
                        <th>User</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($row as $key => $data) { ?>
                        <tr>
                            <td style="width:5%;"><?= $no++ ?>.</td>
                            <td><?= $data->doc_id ?></td>
                            <td><?= $data->barcode ?></td>
                            <td><?= $data->item_name ?></td>
                            <td class="text-right"><?= $data->qty ?></td>
                            <td class="text-right"><?= date('d-m-Y', strtotime($data->expired_date)) ?></td>
                            <td class="text-right"><?= $data->info?></td>
                            <td class="text-right"><?= date('d-m-Y', strtotime($data->created)) ?></td>
                            <td class="text-right"><?= $data->user?></td>
                        </tr>
                    <?php
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>