<section class="content-header">
    <h1>Items Toko
        <small>Data Barang Di Toko</small>
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
            <!-- <h3 class="box-title">Data Product Items</h3> -->
            <div class="pull-right">
                <a onclick="showLoading()" class="btn btn-flat btn-primary" href="<?= site_url('Warehouse/get_harga_item') ?>">Refresh</a>
                <!-- <button class="btn btn-flat btn-success" data-toggle="modal" data-target="#modal-tambah-item">Tambah Item Baru</button> -->
            </div>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped" id="table1xx">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item Code</th>
                        <th>Barcode</th>
                        <th>Name</th>
                        <th>Harga Jual</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($item->result() as $data) { ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data->item_code ?></td>
                            <td><?= $data->barcode ?></td>
                            <td><?= $data->name ?></td>
                            <td><?= number_format($data->harga_jual) ?></td>
                            <td>
                                <a href="<?= base_url('item/item_stock_detail/') . $data->item_code ?>"><?= $data->stock ?></a>
                            </td>
                            <td>
                                <button class="btn btn-flat btn-primary btn-xs" id="btn_edit" data-item-code="<?= $data->item_code ?>" data-item-name="<?= $data->name ?>" data-barcode="<?= $data->barcode ?>">
                                    <i class="fa fa-plus"></i> Add Stock
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<!-- Modal -->
<div class="modal flip" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Stock</h4>
            </div>
            <div class="modal-body">
                <!-- Form -->
                <form id="form_add" action="<?= base_url('item/add_stock') ?>" method="POST">
                    <div class="form-group">
                        <label for="">Barcode</label>
                        <input type="hidden" class="form-control" id="item_code" name="item_code" placeholder="">
                        <input type="text" class="form-control" id="barcode" name="barcode" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Item Name</label>
                        <input type="text" class="form-control" id="item_name" name="item_name" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Stock</label>
                        <input type="number" class="form-control" id="stock" name="stock" placeholder="Masukan Jumlah Stock" required>
                    </div>
                    <div class="form-group">
                        <label for="">Expired Date</label>
                        <input type="date" class="form-control" id="exp_date" name="exp_date" placeholder="" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" id="btn_simpan" class="btn btn-success">Simpan</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#table1xx').DataTable();
    })

    $(document).on('click', '#btn_edit', function() {
        var item_code = $(this).data('item-code')
        var item_name = $(this).data('item-name')
        var barcode = $(this).data('barcode')
        $('#myModal').modal('show')
        $('#item_code').val(item_code)
        $('#barcode').val(barcode)
        $('#item_name').val(item_name)
    })

    $(document).on('click', '#btn_simpan', function() {
        if ($('#stock').val() == "" || $('#exp_date').val() == "") {
            alert("Stock dan Expired Date Tidak Boleh Kosong")
        } else {
            $('#form_add').submit()
        }
    })
</script>