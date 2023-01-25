<section class="content-header">
    <h1>
        Produksi
    </h1>
    <span>Item Exists</span>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-8">
            <div class="box">
                <div class="box-header"></div>
                <div class="box-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-5">
                                <label for="">Item Produksi</label>
                                <select name="" id="item_produksi" class="form-control">
                                    <option value="">--Pilih Item Produksi--</option>
                                    <?php foreach ($item_produksi->result() as $produksi) { ?>
                                        <option value="<?= $produksi->id ?>"><?= $produksi->item_name.' ('.$produksi->item_code.'-'.$produksi->id.')' ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="qty_item">Qty</label>
                                <input type="number" id="qty_item_produksi" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label for="qty_item">Exp Date</label>
                                <input type="date" id="exp_date" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <br>
                                <button id="btn_add" class="btn btn-primary btn-flat" style="margin-top: 5px; display: none;">Add</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php $this->load->view('messages') ?>
            <div class="box">
                <div class="box-header">
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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="cart_produksi">
                            <?php $this->view('transaction/produksi/cart_produksi_ready') ?>
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <button type="button" class="btn btn-flat btn-success pull-right" id="btn_proses_produksi">Proses Produksi</button>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="wadah_modal"></div>
<script>
    // $(document).on('click', '#btn_add', function() {
    //     var item_produksi = $('#item_produksi').val();
    //     if (item_produksi == '') {
    //         alert('Item Produksi Kosong')
    //     } else {
    //         add_cart(item_produksi)
    //     }
    // })

    $(document).on('change', '#item_produksi', function() {
        var item_produksi = $('#item_produksi').val();
        if (item_produksi == '') {
            alert('Item Produksi Kosong')
        } else {
            add_cart(item_produksi)
        }
    })

    $(document).on('click', '#btn_proses_produksi', function() {
        // alert('simpan')
        var item_produksi = $('#item_produksi').val()
        var qty_item_produksi = $('#qty_item_produksi').val()
        var exp_date = $('#exp_date').val()
        if(item_produksi == '' || qty_item_produksi == '' || qty_item_produksi < 1 || exp_date == ''){
            alert('Item Produksi, Qty, dan Exp Date Tidak boleh kosong')
        }else{
            proses_produksi(item_produksi, qty_item_produksi, exp_date)
        }
    })

    $(document).on('click', '#btn_update', function() {
        var item_id = $(this).data('item_id');
        var qty = $(this).data('qty');
        var cart_id = $(this).data('cartid');
        $('#wadah_modal').load('<?= site_url('produksi/show_modal_item') ?>', {
            item_id
        }, function() {
            $('#modal-item').modal('show')
        })

        $(document).on("shown.bs.modal", "#modal-item", function() {
            $('.select').attr('data-qty', qty);
            $('.select').attr('data-cartid', cart_id);
        });
    })

    $(document).on('click', '#select', function() {
        var id_item_detail = $(this).data('id_item_detail')
        var item_id = $(this).data('item_id')
        var stock = $(this).data('stock')
        var qty = $(this).data('qty')
        var cart_id = $(this).data('cartid')
        var exp_date = $(this).data('exp_date')
        if (qty > stock) {
            alert("stock tidak cukup")
        } else {
            // alert("stock cukup")
            edit_cart(id_item_detail, item_id, exp_date, cart_id)
        }
    })

    function proses_produksi(item_produksi, qty, exp_date) {
        $.ajax({
            type: 'POST',
            url: '<?= site_url('produksi/process_exists') ?>',
            data: {
                'proses_produksi': true,
                item_produksi,
                qty,
                exp_date
            },
            dataType: 'json',

            success: function(result) {
                if (result.success == true) {
                    alert('Produksi berhasil disimpan');
                    window.location.href = '<?=base_url('produksi/ready')?>';
                } else if (result.success == false && result.cart == 0) {
                    alert('Cart Kosong')
                } else if (result.success == false && result.complete == false){
                    alert('Item bahan tidak sesuai stock')
                }else {
                    alert('Gagal proses produksi')
                }
            }
        });
    }

    function edit_cart(id_item_detail, item_id, exp_date, cart_id) {
        $.ajax({
            type: 'POST',
            url: '<?= site_url('produksi/process_exists') ?>',
            data: {
                'edit_cart': true,
                'id_item_detail': id_item_detail,
                'item_id': item_id,
                'exp_date': exp_date,
                'cart_id': cart_id
            },
            dataType: 'json',

            success: function(result) {
                if (result.success == true) {
                    $('#cart_produksi').load('<?= site_url('produksi/cart_produksi_data_ready') ?>', function() {
                        $('#modal-item').modal('hide');
                    })
                } else {
                    alert('Gagal edit cart')
                }
            }
        });
    }

    function add_cart(item_produksi) {
        $.ajax({
            type: 'POST',
            url: '<?= site_url('produksi/process_exists') ?>',
            data: {
                'add_cart': true,
                'item_produksi': item_produksi,
            },
            dataType: 'json',

            success: function(result) {
                if (result.success == true) {
                    $('#cart_produksi').load('<?= site_url('produksi/cart_produksi_data_ready') ?>', function() {
                        // $('#item_produksi').prop("disabled", true)
                        // $('#btn_add').prop("disabled", true)
                    })
                } else {
                    alert('Gagal tambah item cart')
                }
            }
        });
    }
</script>