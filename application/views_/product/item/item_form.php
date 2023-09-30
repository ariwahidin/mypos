<section class="content-header">
    <h1>Edit Item
        <!-- <small>Data Barang</small> -->
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
        <li class="active">Edit Item</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <?php $this->view('messages') ?>
    <div class="box">
        <div class="box-header">
            <div class="pull-right">
                <a href="<?= site_url('item') ?>" class="btn btn-warning btn-flat">
                    <i class="fa fa-undo"></i> Back
                </a>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <?php echo form_open_multipart('item/process') ?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Item Code*</label>
                                <input type="text" name="item_code" value="<?= $row->item_code ?>" class="form-control" readonly required>
                            </div>
                            <div class="col-md-6">
                                <label>Barcode *</label>
                                <input type="hidden" name="id" value="<?= $row->item_id ?>">
                                <input type="text" name="barcode" value="<?= $row->barcode ?>" class="form-control" readonly required>
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="product_name">Product Name *</label>
                                <input type="text" name="product_name" id="product_name" value="<?= $row->name ?>" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="product_name">Packing *</label>
                                <input type="text" name="packing" id="packing" value="<?= $row->packing ?>" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Category *</label>
                                <select name="category" class="form-control" required>
                                    <option value="">- Pilih -</option>
                                    <?php foreach ($category->result() as $key => $data) { ?>
                                        <option value="<?= $data->category_id ?>" <?= $data->category_id == $row->category_id ? "selected" : null ?>><?= $data->name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Unit *</label>
                                <?php echo form_dropdown(
                                    'unit',
                                    $unit,
                                    $selectedunit,
                                    ['class' => 'form-control', 'required' => 'required']
                                ) ?>
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <label>Harga Jual (tax <?=$tax->row()->tax *100?>%)*</label>
                        <input type="number" id="harga_jual" name="harga_jual" value="<?= $row->harga_jual ?>" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label>Harga Bersih *</label>
                        <input type="text" id="harga_bersih" name="harga_bersih" value="<?= (float)$row->harga_bersih ?>" class="form-control" readonly required>
                    </div>
                    <div class="form-group" align="right">
                        <button type="submit" name="<?= $page ?>" class="btn btn-success btn-flat">
                            <i class="fa fa-paper-plane"></i> Save
                        </button>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>

</section>

<script>
    $(document).on('keyup', '#harga_jual', function() {
        var tax = parseFloat('<?= $tax->row()->tax_value ?>');
        var harga_bersih = ($(this).val() / tax) * 100;
        $('#harga_bersih').val(harga_bersih.toFixed(2));
    })
</script>