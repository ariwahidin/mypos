<section class="content-header">
    <h1>Info Stock Barang
        <small>Laporan Stock</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
        <li><a href="#">Reports</a></li>
        <li class="active">Stock</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <?php $this->view('messages') ?>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Data Stock</h3>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped" id="table-stock">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Barcode</th>
                        <th>Item Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $this->load->view('report/data_stock_ajax.php'); ?>
                </tbody>
            </table>
        </div>
    </div>
</section>


<!-- Modal Stock In -->
<div class="modal fade" id="modal-stock-in">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Stok In Item</h4>
            </div>
            <div class="modal-body">

                <form action="<?= site_url('stock/process_stock') ?>" method="post">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date *</label>
                                <input type="date" name="date" value="<?= date('Y-m-d') ?>" class="form-control" required readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <label for="barcode">Barcode *</label>
                            </div>
                            <div class="form-group input-group">
                                <input type="hidden" name="item_id" id="item_id">
                                <input type="text" name="barcode" id="barcode" class="form-control" required readonly>
                                <!-- <span class="input-group-btn">
                                    <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-item">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span> -->
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="item_name">Item Name *</label>
                                <input type="text" name="item_name" id="item_name" class="form-control" readonly>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="unit_name">Item Unit</label>
                                <input type="text" name="unit_name" id="unit_name" value="-" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="stock">Initial Stock</label>
                                <input type="text" name="stock" id="stock" value="-" class="form-control" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Info *</label>
                                <input type="text" name="detail" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Supplier</label>
                                <select name="supplier" class="form-control">
                                    <option value="">- Pilih -</option>
                                    <?php foreach ($supplier as $i => $data) {
                                        echo '<option value="' . $data->supplier_id . '">' . $data->name . '</option>';
                                    } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Qty *</label>
                                <input type="number" name="qty" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label>Exp Date *</label>
                                <input type="date" name="exp_date" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" align="right">
                        <button type="submit" name="in_add" class="btn btn-success btn-flat">
                            <i class="fa fa-paper-plane"></i> Save
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>





<!-- Modal Stock Out -->
<div class="modal fade" id="modal-stock-out">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Stok Out Item</h4>
            </div>
            <div class="modal-body">

                <form action="<?= site_url('stock/process_stock') ?>" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date *</label>
                                <input type="date" name="date" value="<?= date('Y-m-d') ?>" class="form-control" required readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <label for="barcode">Barcode *</label>
                            </div>
                            <div class="form-group input-group">
                                <input type="hidden" name="item_id" id="item_id_out">
                                <input type="text" name="barcode" id="barcode_out" class="form-control" required readonly>
                                <!-- <span class="input-group-btn">
                            <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-item">
                                <i class="fa fa-search"></i>
                            </button>
                        </span> -->
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="item_name">Item Name *</label>
                        <input type="text" name="item_name" id="item_name_out" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="unit_name">Item Unit</label>
                                <input type="text" name="unit_name" id="unit_name_out" value="-" class="form-control" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="stock">Initial Stock</label>
                                <input type="text" name="stock" id="stock_out" value="-" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Info *</label>
                        <input type="text" name="detail" class="form-control" placeholder="Rusak / hilang / kadaluwarsa / etc" required>
                    </div>
                    <div class="form-group">
                        <label>Qty *</label>
                        <input type="number" name="qty" class="form-control" required>
                    </div>

                    <div class="form-group" align="right">
                        <button type="submit" name="out_add" class="btn btn-success btn-flat">
                            <i class="fa fa-paper-plane"></i> Save
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>







<script>
    $(document).ready(function() {
        $('#table-stock').DataTable();
    })

    $(document).ready(function() {
        $(document).on('click', '#select', function() {
            var item_id = $(this).data('id');
            var barcode = $(this).data('barcode');
            var name = $(this).data('name');
            var unit_name = $(this).data('unit');
            var stock = $(this).data('stock');
            $('#item_id').val(item_id);
            $('#barcode').val(barcode);
            $('#item_name').val(name);
            $('#unit_name').val(unit_name);
            $('#stock').val(stock);
            $('#modal-item').modal('hide');
        })
    })

    $(document).ready(function() {
        $(document).on('click', '#select_out', function() {
            var item_id = $(this).data('id_out');
            var barcode = $(this).data('barcode_out');
            var name = $(this).data('name_out');
            var unit_name = $(this).data('unit_out');
            var stock = $(this).data('stock_out');
            $('#item_id_out').val(item_id);
            $('#barcode_out').val(barcode);
            $('#item_name_out').val(name);
            $('#unit_name_out').val(unit_name);
            $('#stock_out').val(stock);
            $('#modal-item_out').modal('hide');
        })
    })
</script>