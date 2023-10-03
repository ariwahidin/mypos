<section class="content-header">
    <h1>Stock Detail 
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <!-- <?php $this->view('messages') ?> -->
    <div id="flash" data-flash="<?= $this->session->flashdata('success') ?>"></div>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Detail Stock Item Code : <?=$item_code?></h3>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped" id="table1">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item Code</th>
                        <th>Barcode</th>
                        <th>Desc</th>
                        <th>Qty</th>
                        <th>Expired Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($item->num_rows() > 0) {?>
                        <?php $no = 1; foreach ($item->result() as $data) { ?>
                        <tr>
                            <td><?=$no++?></td>
                            <td><?=$data->item_code?></td>
                            <td><?=$data->barcode?></td>
                            <td><?=$data->item_name?></td>
                            <td><?=$data->qty?></td>
                            <td><?=date('d-m-Y', strtotime($data->exp_date))?></td>
                        </tr>
                    <?php
                    } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>