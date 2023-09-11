<?php
// var_dump($item_harga->data);
// die;
?>
<section class="content-header">
    <h1>Data Item PK
        <small>Data Item dan Harga di PK</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
        <li class="active">Items</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <?php $this->view('messages') ?>
    <div class="box">
        <div class="box-header">
            <table>
                <tr>
                    <td>Kode Store</td>
                    <td> : </td>
                    <td>&nbsp;<?= $toko['kode_counter'] ?></td>
                </tr>
                <tr>
                    <td>Nama Store</td>
                    <td> : </td>
                    <td>&nbsp;<?= $toko['store_name'] ?></td>
                </tr>
                <tr>
                    <td>Area</td>
                    <td> : </td>
                    <td>&nbsp;<?= $toko['kode_area'] ?></td>
                </tr>
            </table>
            <div class="">
                <a href="<?= base_url('item') ?>" class="btn btn-flat btn-warning pull-right">Back to Item Toko</a>
            </div>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped" id="table1">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item Code</th>
                        <th>Barcode</th>
                        <th>Item Name</th>
                        <th>Harga Jual</th>
                        <th>Harga Bersih</th>
                        <th>Harga PPN</th>
                        <th>PPN (%)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($item_harga->data as $data) { ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data->item_code ?></td>
                            <td><?= $data->barcode ?></td>
                            <td><?= $data->item_name ?></td>
                            <td><?= number_format($data->harga_jual) ?></td>
                            <td><?= number_format($data->harga_bersih) ?></td>
                            <td><?= number_format($data->harga_ppn) ?></td>
                            <td><?= $data->percent_ppn ?> %</td>
                            <td>
                                <?php if (barcode_exists($data->barcode) == true) { ?>
                                    <?php if (item_is_update($data->barcode, $data->harga_jual, $data->harga_bersih) == true) { ?>
                                        <form action="<?= base_url('Warehouse/sinkronisasi') ?>" method="POST" class="pull-left">
                                            <input type="hidden" name="item_code" value="<?= $data->item_code ?>">
                                            <input type="hidden" name="barcode" value="<?= $data->barcode ?>">
                                            <input type="hidden" name="item_name" value="<?= $data->item_name ?>">
                                            <input type="hidden" name="item_name_toko" value="<?= $data->item_name_toko ?>">
                                            <input type="hidden" name="harga_jual" value="<?= $data->harga_jual ?>">
                                            <input type="hidden" name="harga_bersih" value="<?= $data->harga_bersih ?>">
                                            <input type="hidden" name="harga_harga_ppn" value="<?= $data->harga_ppn ?>">
                                            <button name="sesuaikan" class="btn btn-info btn-flat btn-xs"> Sesuaikan </button>
                                        </form>
                                    <?php } ?>
                                    <button class="btn btn-danger btn-flat btn-xs pull-right">Sudah Ada</button>
                                <?php } else { ?>
                                    <form action="<?= base_url('Warehouse/add_master_item_pos') ?>" method="POST">
                                        <input type="hidden" name="item_code" value="<?= $data->item_code ?>">
                                        <input type="hidden" name="barcode" value="<?= $data->barcode ?>">
                                        <input type="hidden" name="item_name" value="<?= $data->item_name ?>">
                                        <input type="hidden" name="item_name_toko" value="<?= $data->item_name_toko ?>">
                                        <input type="hidden" name="harga_jual" value="<?= $data->harga_jual ?>">
                                        <input type="hidden" name="harga_bersih" value="<?= $data->harga_bersih ?>">
                                        <input type="hidden" name="harga_harga_ppn" value="<?= $data->harga_ppn ?>">
                                        <button type="submit" name="add" class="btn btn-primary btn-flat btn-xs">
                                            Tambahkan
                                        </button>
                                    </form>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>