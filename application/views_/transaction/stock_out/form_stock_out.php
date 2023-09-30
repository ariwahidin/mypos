<?php
// var_dump($item->result())
?>
<section class="content-header">
    <h1>
        Stock Out
    </h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php $this->load->view('messages') ?>
            <div class="box">
                <div class="box-header">
                    <form action="<?= base_url('stockout/process') ?>" method="post">
                        <button type="button" class="btn btn-flat btn-primary" data-toggle="modal" data-target="#modal-item">Daftar Item</button>

                        <input type="hidden" name="proccess_stock_out">
                        <button type="submit" class="btn btn-flat btn-success pull-right">Process Stock Out</button>
                    </form>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Barcode</th>
                                <th>Desc</th>
                                <th>Qty</th>
                                <th>Exp Date</th>
                                <th>Info</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="cart_stock_out">
                            <?php $this->view('transaction/stock_out/cart_stock_out') ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Add Product Item -->
<div class="modal flip" id="modal-item">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Add Product Item</h4>
            </div>
            <div class="modal-body table-responsive">
                <table class="table table-bordered table-striped" id="table1xx">
                    <thead>
                        <tr>
                            <th>Barcode</th>
                            <th>Name</th>
                            <th>Stock</th>
                            <th>Exp Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($item->result() as $i => $data) { ?>
                            <tr>
                                <td><?= $data->barcode ?></td>
                                <td width="80%"><?= $data->item_name ?></td>
                                <td><?= $data->qty ?></td>
                                <td width="80%"><?= date('d-m-Y', strtotime($data->exp_date)) ?></td>
                                <td class="text-right">
                                    <button class="btn btn-xs btn-info" id="select" data-item_id="<?= $data->item_id ?>" data-id_item_detail="<?= $data->id ?>" data-harga_jual="<?= $data->harga_jual ?>" data_stock="<?= $data->qty ?>" data-exp_date="<?= $data->exp_date ?>">
                                        <i class="fa fa-check"></i> Select
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <script>
                $('#table1xx').DataTable()
            </script>
        </div>
    </div>
</div>

<!-- Modal Edit Info-->
<div class="modal flip" id="modal_edit_info">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Edit Item Stock Out</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="qty_item">Qty</label>
                            <input type="number" id="input_edit_qty" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="qty_item">Stock</label>
                            <input type="number" id="input_edit_stock" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="qty_item">Info</label>
                            <input type="text" id="input_edit_info" class="form-control">
                            <input type="hidden" id="input_edit_info_cart_id">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="pull-right">
                    <button type="button" id="btn_save_edit_info" class="btn btn-flat btn-warning">
                        <i class="fa fa-paper-plane"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('click', '#select', function(e) {
        var id_item_detail = $(this).data('id_item_detail');
        add_cart(id_item_detail)
    })

    $(document).on('click', '#delete_cart', function() {
        var id_item_detail = $(this).data('id_item_detail')
        var id_cart = $(this).data('cart_id')
        delete_item_cart(id_cart)
    })

    $(document).on('click', '#update_qty', function() {
        $('#input_edit_info_cart_id').val($(this).data('cartid'))
        $('#input_edit_info').val($(this).data('info'))
        $('#input_edit_qty').val($(this).data('qty'))
        $('#input_edit_stock').val($(this).data('stock'))
    })

    $(document).on('click', '#btn_save_edit_info', function() {
        var info = $('#input_edit_info').val()
        var cart_id = $('#input_edit_info_cart_id').val()
        var qty = parseInt($('#input_edit_qty').val())
        var stock = parseInt($('#input_edit_stock').val())

        // console.log(qty);
        // console.log(stock);

        if (qty > stock) {
            alert('Stok tidak Cukup')
        } else {
            edit_info(cart_id, info, qty)
            $('#modal_edit_info').modal('hide')
        }
    })

    function delete_item_cart(id_cart) {
        $.ajax({
            type: 'POST',
            url: '<?= site_url('stockout/process') ?>',
            data: {
                'delete_item_cart': true,
                'cart_id': id_cart,
            },
            dataType: 'json',

            success: function(result) {
                if (result.success == true) {
                    $('#cart_stock_out').load('<?= site_url('stockout/cart_stockout_data') ?>', function() {})
                } else {
                    alert('Gagal Hapus')
                }
            }
        });
    }

    function edit_info(id_cart, info, qty) {
        $.ajax({
            type: 'POST',
            url: '<?= site_url('stockout/process') ?>',
            data: {
                'edit_info': true,
                'id_cart': id_cart,
                'info': info,
                'qty': qty
            },
            dataType: 'json',

            success: function(result) {
                if (result.success == true) {
                    $('#cart_stock_out').load('<?= site_url('stockout/cart_stockout_data') ?>', function() {})
                } else {
                    alert('Tidak Terupdate')
                }
            }
        });
    }

    function add_cart(item_id_detail) {
        $.ajax({
            type: 'POST',
            url: '<?= site_url('stockout/process') ?>',
            data: {
                'add_cart': true,
                'item_id_detail': item_id_detail,
            },
            dataType: 'json',

            success: function(result) {
                if (result.success == true) {
                    $('#cart_stock_out').load('<?= site_url('stockout/cart_stockout_data') ?>', function() {

                    })
                } else if (result.success == false && result.stock_cukup == false) {
                    alert('Stock Tidak cukup');
                } else {
                    alert('Gagal tambah item cart')
                }
            }
        });
    }
</script>