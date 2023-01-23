<section class="content-header">
    <h1>
        Stock Detail
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <!-- <?php $this->view('messages') ?> -->
    <div id="flash" data-flash="<?= $this->session->flashdata('success') ?>"></div>
    <div class="box">
        <div class="box-header">
            <!-- <h3 class="box-title">Data Stock Detail</h3> -->
            <form action="" method="post">
                <input type="hidden" name="download_stock_detail">
                <button class="btn btn-success btn-flat pull-right">
                    <i class="fa fa-file-excel-o"></i> Download Excel
                </button>
            </form>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped" id="table_stock">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Barcode</th>
                        <th>Desc</th>
                        <th>Stock</th>
                        <th>Exp Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($stock->result() as $key => $data) { ?>
                        <tr>
                            <td><?= $no++ ?>.</td>
                            <td><?= $data->barcode ?></td>
                            <td><?= $data->item_name ?></td>
                            <td><?= $data->qty ?></td>
                            <td><?= date('d-m-Y', strtotime($data->exp_date)) ?></td>
                        </tr>
                    <?php
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<script>
    $('#table_stock').DataTable();
</script>