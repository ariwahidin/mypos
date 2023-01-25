<section class="content-header">
    <h1>Sales
        <small>Penjualan</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
        <li>Transaction</li>
        <li class="active">Sales</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-lg-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-body table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Barcode</th>
                                        <th>Manual Item</th>
                                        <!-- <th>Price</th>
                                        <th>Qty</th>
                                        <th>Exp. Date</th>
                                        <th></th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="">
                                                <!-- <input type="hidden" id="item_id">
                                                <input type="hidden" id="price">
                                                <input type="hidden" id="stock">
                                                <input type="hidden" id="qty_cart"> -->
                                                <input type="text" id="barcode" class="form-control" autofocus autocomplete="off" placeholder="Input Barcode Lalu Enter">
                                                <!-- <span class="input-group-btn">
                                                    <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-item">
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                </span> -->
                                            </div>
                                        </td>

                                        <td width="30%">
                                            <div class="form-group">
                                                <button class="btn btn-flat btn-primary" data-toggle="modal" data-target="#modal-item">Pilih Product Manual</button>
                                            </div>
                                        </td>
                                        <!-- 
                                        <td width="15%">
                                            <div class="form-group">
                                                <input class="form-control" type="text" id="price_item" readonly>
                                            </div>
                                        </td>
                                        <td width="10%">
                                            <div class="form-group">
                                                <input type="number" id="qty" value="1" min="1" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" id="expired_date" class="form-control" data-inputmask="'alias': 'date'">
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <button type="button" id="add_cart" class="btn btn-primary">
                                                    <i class="fa fa-cart-plus"></i> Add
                                                </button>
                                            </div>
                                        </td> -->
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-body">

                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Invoice : <b><span id="invoice"><?= $invoice ?></span></b></h5>
                                    <h5>Date : <b><?= indo_date_only() ?></b></h5>
                                </div>
                                <div class="col-md-6">
                                    <div align="right">
                                        <h4>
                                            <b><span id="grand_total2" style="font-size: 30pt">0</span></b>
                                        </h4>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <button id="prepare_bayar" class="btn btn-flat btn-md btn-primary pull-right" style="margin-right:5px;" data-toggle="modal" data-target="#modal-prepare-bayar">
                                        <i class="fa fa-money"></i> Pay (F9)
                                    </button>
                                    <button id="cancel_payment" class="btn btn-flat btn-warning pull-right" style="margin-right:5px;">
                                        <i class="fa fa-refresh"></i> Cancel
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-widget">
                <div class="box box-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Barcode</th>
                                <th>Product Item</th>
                                <th>Harga Jual</th>
                                <th width="auto">Disc.</th>
                                <th>Qty</th>
                                <th width="auto">Total</th>
                                <th>Exp Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="cart_table">
                            <?php $this->view('transaction/sale/cart_data') ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <input type="hidden" id="nomor_kartu" class="form-control" readonly>
    <input type="hidden" id="input_jenis_kartu" class="form-control" readonly>
    <input type="hidden" id="date" value="<?= date('Y-m-d') ?>" class="form-control">
    <input type="hidden" id="user" value="<?= $this->fungsi->user_login()->name ?>" class="form-control" readonly>
    <textarea style="display:none" name="" id="note" rows="3" class="form-control"></textarea>
    <select name="" id="customer" class="form-control" style="display:none">
        <option value="">Umum</option>
        <?php foreach ($customer as $cust => $value) { ?>
            <option value="<?= $value->customer_id ?>"><?= $value->name ?></option>
        <?php } ?>
    </select>
</section>

<!-- Modal konfirmasi pembayaran -->
<div class="modal fade" id="modal-prepare-bayar">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Konfirmasi Pembayaran</h4>
            </div>
            <div class="modal-body table-responsive">
                <div class="row">
                    <div class="col-md-6">
                        <div align="left">
                            <h4 style="display:none"><b>Subtotal : <span id="subtotal">0</span></b></h4>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div align="right">
                            <h4><b><span id="">Grand Total</span></b></h4>
                            <h2><b><span id="total_bayar" style="font-size: 50pt">0</span></b></h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-responsive" width="100%">
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label>Discount (Rp)</label>
                                        <div class="input-group">
                                            <input type="text" onkeypress="return isNumber(event);" onkeyup="isMoney(this)" id="discount" value="0" min="0" maxlength="10" class="form-control">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label>Service</label>
                                        <div class="input-group">
                                            <input type="text" id="service" onkeypress="return isNumber(event);" onkeyup="isMoney(this)" class="form-control" min="0" value="0">
                                            <input type="hidden" id="tax" class="form-control" min="0" value="0" readonly>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label>Type Bayar</label>
                                        <select class="form-control" name="" id="type_bayar" width="30%">
                                            <!-- <option value="">--pilih--</option> -->
                                            <?php foreach ($type_bayar->result() as $typ => $data) { ?>
                                                <option value="<?= $data->id ?>"><?= $data->type_bayar ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label>Nomor Kartu</label>
                                        <div class="input-group">
                                            <input class="form-control" id="cc" type="text" data-inputmask="'mask': '9999 9999 9999 9999'" readonly />
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <div class="input-group">
                                            <input type="text" id="nama_pemilik_kartu" class="form-control" readonly>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label>Jumlah Cash</label>
                                        <div class="input-group">
                                            <input type="text" onkeypress="return isNumber(event);" onkeyup="isMoney(this)" id="cash" value="0" min="0" class="form-control">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label>Change</label>
                                        <div class="input-group">
                                            <input type="text" id="change" min="0" value="0" class="form-control" readonly>
                                        </div>
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button id="submit_bayar" class="btn btn-primary btn-flat pull-right">
                            Confirm
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="show_modal_item">
    <?php $this->view('transaction/sale/modal_item_data') ?>
</div>
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
                        <?php foreach ($item as $i => $data) { ?>
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

<!-- Modal Edit Cart Item -->
<div class="modal fade" id="modal-item-edit">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"> Update Cart</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="cartid_item">
                <div class="form-group">
                    <label for="product_item">Product Item</label>
                    <div class="row">
                        <div class="col-md-5">
                            <input type="text" id="barcode_item" class="form-control" readonly>
                        </div>
                        <div class="col-md-7">
                            <input type="text" id="product_item" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="price_item">Exp Date (POS)</label>
                            <!-- <select name="" id="so_edit_exp_date" class="form-control">
                                <option value=""></option>
                                <option value="7">2023-05-23</option>
                                <option value="12">2023-03-02</option>
                            </select> -->
                            <input type="text" id="expired" class="form-control" data-inputmask="'alias': 'date'" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="price_item">Exp Date (Edit)</label>
                            <input type="text" id="exp_edit" class="form-control" data-inputmask="'alias': 'date'">
                            <input type="hidden" id="price_item_edit" min="0" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="discount_item">Disc. (%)</label>
                            <input type="number" id="discount_item_percent_edit" min="0" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>Price Disc.</label>
                            <input type="number" id="discount_item_edit" min="0" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-7">
                            <label for="qty_item">Qty</label>
                            <input type="number" id="qty_item_edit" min="1" class="form-control">
                        </div>
                        <div class="col-md-5">
                            <label for="qty_item">Stock Item</label>
                            <input type="number" id="stock_item_edit" min="1" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="total_before">Total before Discount</label>
                    <input type="number" id="total_before_edit" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="total_item_edit">Total after Discount</label>
                    <input type="number" id="total_item_edit" class="form-control" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <div class="pull-right">
                    <button type="button" id="edit_cart" class="btn btn-flat btn-success">
                        <i class="fa fa-paper-plane"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Qty-->
<div class="modal flip" id="modal_edit_qty">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"> Update Qty</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="qty_item">Qty</label>
                            <input type="number" id="qty_edit" min="1" class="form-control">
                            <input type="hidden" id="input_edit_qty_cart_id">
                        </div>
                        <div class="col-md-6">
                            <label for="qty_item">Stock Item</label>
                            <input type="number" id="qty_stock" class="form-control" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="pull-right">
                    <button type="button" id="btn_save_edit_qty" class="btn btn-flat btn-success">
                        <i class="fa fa-paper-plane"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Disc-->
<div class="modal flip" id="modal_edit_disc">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"> Update Discount</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="qty_item">Discount (%)</label>
                            <input type="number" id="input_edit_disc" min="1" class="form-control">
                            <input type="hidden" id="input_edit_disc_cart_id">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="pull-right">
                    <button type="button" id="btn_save_edit_disc" class="btn btn-flat btn-success">
                        <i class="fa fa-paper-plane"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Ed-->
<div class="modal flip" id="modal_edit_ed">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"> Edit Expired Date</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Expired Date (Ori) </label>
                            <input type="text" id="input_edit_ed_ori" data-inputmask="'alias': 'date'" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="ed">Expired Date (Edit)</label>
                            <input type="text" id="input_edit_ed" data-inputmask="'alias': 'date'" class="form-control">
                            <input type="hidden" id="input_edit_ed_cart_id">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="pull-right">
                    <button type="button" id="btn_save_edit_ed" class="btn btn-flat btn-success">
                        <i class="fa fa-paper-plane"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $this->load->view('transaction/sale/myjs') ?>
<script src="<?= base_url() ?>assets/myjs/input_mask.js"></script>
<script src="<?= base_url() ?>assets/myjs/myjs.js"></script>

<script>
    $(document).on('keyup', '#input_edit_disc', function(e) {
        if (e.target.value == '') {
            e.target.value = 0;
        } else {
            e.target.value = parseFloat(e.target.value);
        }
    });

    $(document).on('keyup', '#qty_edit', function(e) {
        e.target.value = parseFloat(e.target.value);
    });

    function total_item() {
        var total_belanja = 0;
        var total_item = document.querySelectorAll('.total_item');
        for (var i = 0; i < total_item.length; i++) {
            total_belanja += is_number(total_item[i].innerText);
        }
        return total_belanja;
    }

    function tax() {
        var tax = parseFloat('<?= $tax ?>');
        // console.log(total_item() * tax);
        return total_item() * tax;
    }

    function sugest_total_bayar() {
        var subtotal = (total_item() + is_number($('#service').val())) - is_number($('#discount').val());
        // var tax_value = Math.round(parseFloat('<?= $tax ?>') * subtotal);
        var grand_total = Math.round(subtotal);
        var total_bayar = 0;

        return number_with_commas(grand_total);
    }

    function total_bayar() {
        var subtotal = (total_item() + is_number($('#service').val())) - is_number($('#discount').val());
        // var tax_value = Math.round(parseFloat('<?= $tax ?>') * subtotal);
        var grand_total = Math.round(subtotal);
        $('#subtotal').text(number_with_commas(subtotal))
        $('#total_bayar').text(number_with_commas(grand_total));
        var change = is_number($('#cash').val()) - grand_total;
        $('#change').val(number_with_commas(change));
        // $('#tax').val(number_with_commas(tax_value));

    }

    $(document).on('click', '#prepare_bayar', function() {
        check_event();
        $('#cash').val(sugest_total_bayar());
        total_bayar();
    })

    function check_event() {
        $.ajax({
            type: 'POST',
            url: '<?= site_url('sale/check_event') ?>',
            data: {},
            dataType: 'json',
            success: function(result) {
                if (result.success == true) {
                    $('#cart_table').load('<?= site_url('sale/cart_data') ?>', function() {
                        sugest_total_bayar()
                        total_bayar()
                        calculate()
                    })
                } else {
                    // alert('tidak ada bonus')
                }
            }
        })
    }

    $(document).on('keyup change', '#discount, #service, #cash, #type_bayar', function() {
        total_bayar();
    })

    $(document).on('click', '#select', function() {
        var qty = 1;
        var item_id = $(this).data('item_id')
        var id_detail_item = $(this).data('id_item_detail')
        var harga_jual = $(this).data('harga_jual')
        var exp_date = $(this).data('exp_date')


        add_cart(item_id, id_detail_item, harga_jual, qty, exp_date)
        $('#modal-item').modal('hide')

    })

    $(":input").inputmask();

    function get_cart_qty(barcode) {
        $('#cart_table tr').each(function() {
            // var qty_cart = $(this).find("td").eq(4).html()
            var qty_cart = $("#cart_table td.barcode:contains('" + barcode + "')").parent().find("td").eq(5).html()
            if (qty_cart != null) {
                $('#qty_cart').val(qty_cart)
            } else {
                $('#qty_cart').val(0)
            }
        })
    }



    $(document).on('change', '#type_bayar', function() {
        if ($(this).val() != '1') {
            $('#cc').removeAttr('readonly');
            $('#nama_pemilik_kartu').removeAttr('readonly');
            $('#cash').val($('#total_bayar').text());
        } else {
            $('#cc').attr('readonly', 'readonly');
            $('#nama_pemilik_kartu').attr('readonly', 'readonly');
            $('#cc').val('');
            $('#nama_pemilik_kartu').val('');
        }
        calculate()
        total_bayar();
    })

    $('#cc').on('keyup', function(e) {
        var panjang_char = $(this).val().replace(/[_\s]/g, '').length
        if (panjang_char == 16 && e.keyCode == 13) {
            $('#nama_pemilik_kartu').focus()
        }
    })

    $('#modal-prepare-bayar').on('shown.bs.modal', function() {
        $('#cash').focus();
        $('#discount').on('keyup', function(e) {
            if (e.keyCode == 13 || e.keyCode == 40) {
                $('#type_bayar').focus()
            }
        })

        $('#type_bayar').on('change', function(e) {
            if ($(this).val() == '1' || $(this).val() == '8' || $(this).val() == '9') {
                $('#cash').focus()
            } else {
                $('#cc').focus()
            }
        })

        $('#cash').on('keyup', function(e) {

            if (e.keyCode == 13) {
                $('#submit_bayar').click()
            }

        })

        $('#nama_pemilik_kartu').on('keyup', function(e) {
            if (e.keyCode == 13) {
                $('#cash').focus()
            }
        })

    })

    $(document).on('keyup', function(e) {
        if (e.keyCode == 120) { // F9
            $('#prepare_bayar').click()
        }
    })



    $('#discount_item_percent_edit').on('keydown keyup change', function(e) {
        if ($(this).val() > 100) {
            e.preventDefault();
            $('#discount_item_percent_edit').val(100);
        } else if ($(this).val() == '') {
            $('#discount_item_percent_edit').val(0);
        }
        $('#discount_item_percent_edit').val(parseFloat($(this).val()));
    })



    $(document).on('click', '#del_cart', function() {
        Swal.fire({
            title: 'Apakah anda yakin?',
            // text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                var cart_id = $(this).data('cartid');
                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('sale/cart_del') ?>',
                    dataType: 'JSON',
                    data: {
                        'cart_id': cart_id
                    },
                    success: function(result) {
                        if (result.success == true) {
                            $('#cart_table').load('<?= site_url('sale/cart_data') ?>', function() {
                                calculate()
                            })
                        } else {
                            alert('Gagal hapus item cart')
                        }
                    }
                })
            }
        })
    })

    $(document).on('click', '#update_cart', function() {
        $('#cartid_item').val($(this).data('cartid'))
        $('#barcode_item').val($(this).data('barcode'))
        $('#product_item').val($(this).data('product'))
        $('#stock_item_edit').val($(this).data('stock'))
        $('#price_item_edit').val($(this).data('price'))
        $('#qty_item_edit').val($(this).data('qty'))
        $('#total_before_edit').val(($(this).data('price') * $(this).data('qty')).toFixed(0))
        $('#discount_item_percent_edit').val(($(this).data('discount') / $(this).data('price')) * 100)
        $('#discount_item_edit').val($(this).data('discount'))
        $('#total_item_edit').val($(this).data('total'))
        $('#expired').val($(this).data('expired'))

    })

    $(document).on('click', '#update_qty', function() {
        var qty = $(this).data('qty')
        var stock = $(this).data('stock')
        var cart_id = $(this).data('cartid')
        $('#qty_edit').val(qty)
        $('#qty_stock').val(stock)
        $('#input_edit_qty_cart_id').val(cart_id);
        $("#modal_edit_qty").on('shown.bs.modal', function() {
            $('#qty_edit').focus();
            $('#btn_save_edit_qty').attr({
                "data-qty": qty,
                "data-stock": stock,
            });
        });
    })

    $(document).on('click', '#btn_save_edit_qty', function() {
        // alert('edit_qty');
        var stock = $('#qty_stock').val();
        var qty = $('#qty_edit').val()
        var cart_id = $('#input_edit_qty_cart_id').val();

        if (qty == '' || qty == 0) {
            alert('Qty Tidak Boleh Kosong')
        } else {
            $.ajax({
                type: 'POST',
                url: '<?= site_url('sale/process') ?>',
                data: {
                    'edit_qty': true,
                    'cart_id': cart_id,
                    'qty': qty,
                },
                dataType: 'json',
                success: function(result) {
                    if (result.success == true) {
                        $('#cart_table').load('<?= site_url('sale/cart_data') ?>', function() {
                            calculate()
                        })
                        // alert('Item cart berhasil ter-update')
                        // Swal.fire('Item cart berhasil ter-update')
                        $('#modal_edit_qty').modal('hide');
                    } else if (result.success == false && result.stock == false) {
                        Swal.fire('Stock tidak mencukupi')
                    } else {
                        // alert('Data item cart tidak ter-update')
                        Swal.fire('Data item cart tidak ter-update')
                        $('#modal_edit_qty').modal('hide');
                    }
                }
            })
        }
    })


    $(document).on('click', '#update_ed', function() {
        var cart_id = $(this).data('cartid')
        var ed = $(this).data('ed')
        var ed_ori = $(this).data('ed_ori')
        $('#input_edit_ed').val(ed)
        $('#input_edit_ed_ori').val(ed_ori)
        $("#modal_edit_ed").on('shown.bs.modal', function() {
            $('#input_edit_ed').focus();
            $('#input_edit_ed_cart_id').val(cart_id);
        });
    })

    function today() {
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();

        today = mm + '/' + dd + '/' + yyyy;
        return today
    }

    $(document).on('click', '#update_disc', function() {
        var cart_id = $(this).data('cartid')
        var disc = $(this).data('disc')
        $('#input_edit_disc').val(disc)
        $("#modal_edit_disc").on('shown.bs.modal', function() {
            $('#input_edit_disc').focus();
            $('#input_edit_disc_cart_id').val(cart_id);
        });
    })

    function isValidDate(d) {
        return d instanceof Date && !isNaN(d);
    }

    $(document).on('click', '#btn_save_edit_ed', function() {
        var ed = $('#input_edit_ed').val()
        var cart_id = $('#input_edit_ed_cart_id').val()

        var split = ed.split('/');
        new_ed = split[1] + '/' + split[0] + '/' + split[2]
        var x = new Date(new_ed)
        var y = new Date(today())
        // console.log(ed)
        // console.log(today())

        // console.log(x);
        // console.log(x.getDate())
        // console.log(isValidDate(x));

        // console.log(isValidDate(y));
        console.log(x.getTime());
        if (x.getTime() < y.getTime()) {
            alert('Exp Date tidak boleh lebih kecil dari hari ini')
        } else if (isValidDate(x) == false) {
            alert('Tanggal tidak valid')
        } else {
            $.ajax({
                type: 'POST',
                url: '<?= site_url('sale/process') ?>',
                data: {
                    'edit_ed': true,
                    'ed': ed,
                    'cart_id': cart_id,
                },
                dataType: 'json',
                success: function(result) {
                    if (result.success == true) {
                        $('#cart_table').load('<?= site_url('sale/cart_data') ?>', function() {
                            calculate()
                        })
                        // alert('Item cart berhasil ter-update')
                        // Swal.fire('Item cart berhasil ter-update')
                        $('#modal_edit_ed').modal('hide');
                    } else {
                        // alert('Data item cart tidak ter-update')
                        Swal.fire('Data item cart tidak ter-update')
                        $('#modal_edit_ed').modal('hide');
                    }
                }
            })
        }

    })

    $(document).on('keyup', '#input_edit_disc', function(e) {
        // console.log(e.keyCode);
        if (e.keyCode == '13') {
            $('#btn_save_edit_disc').click()
        }
    })


    $(document).on('keyup', '#qty_edit', function(e) {
        // console.log(e.keyCode);
        if (e.keyCode == '13') {
            $('#btn_save_edit_qty').click()
        }
    })

    $(document).on('keyup', '#input_edit_ed', function(e) {
        // console.log(e.keyCode);
        if (e.keyCode == '13') {
            $('#btn_save_edit_ed').click()
        }
    })

    $(document).on('click', '#btn_save_edit_disc', function() {
        // alert('edit_qty');
        var disc = $('#input_edit_disc').val()
        var cart_id = $('#input_edit_disc_cart_id').val()
        if (disc > 100) {
            alert('Tidak boleh dari 100%');
        } else {
            $.ajax({
                type: 'POST',
                url: '<?= site_url('sale/process') ?>',
                data: {
                    'edit_disc': true,
                    'disc': disc,
                    'cart_id': cart_id,
                },
                dataType: 'json',
                success: function(result) {
                    if (result.success == true) {
                        $('#cart_table').load('<?= site_url('sale/cart_data') ?>', function() {
                            calculate()
                        })
                        // alert('Item cart berhasil ter-update')
                        //Swal.fire('Item cart berhasil ter-update')
                        $('#modal_edit_disc').modal('hide');
                    } else {
                        // alert('Data item cart tidak ter-update')
                        Swal.fire('Data item cart tidak ter-update')
                        $('#modal_edit_disc').modal('hide');
                    }
                }
            })
        }
    })



    $('#modal-bayar-pake-kartu').on('shown.bs.modal', function() {
        $('#owner').focus()
    });

    function count_edit_modal() {
        var price = $('#price_item_edit').val()
        var qty = $('#qty_item_edit').val()
        var discount_percent = $('#discount_item_percent_edit').val()

        var discount_value = parseFloat(discount_percent / 100) * parseFloat(price)
        // console.log(discount_value)
        if (!isNaN(discount_value)) {
            $('#discount_item_edit').val(discount_value)
        }

        var discount = $('#discount_item_edit').val()


        total_before = price * qty
        $('#total_before_edit').val(total_before.toFixed(0))

        total = (price - discount) * qty
        $('#total_item_edit').val(total.toFixed(0))

        if (discount == '') {
            $('#discount_item_edit').val(0)
        }
    }

    $(document).on('keyup mouseup', '#price_item_edit, #qty_item_edit, #discount_item_edit, #discount_item_percent_edit', function() {
        count_edit_modal()
    })

    $(document).on('click', '#edit_cart', function() {
        var cart_id = $('#cartid_item').val()
        var price = $('#price_item_edit').val()
        var qty = $('#qty_item_edit').val()
        var discount = $('#discount_item_edit').val()
        var total = $('#total_item_edit').val()
        var stock = $('#stock_item_edit').val()
        var expired = $('#exp_edit').val()
        if (price == '' || price < 1) {
            alert('Harga tidak boleh kosong')
            $('#price_item_edit').focus()
        } else if (qty == '' || qty < 1) {
            alert('Qty tidak boleh kosong')
            $('#qty_item_edit').focus()
        } else if (parseInt(qty) > parseInt(stock)) {
            alert('Stock tidak mencukupi')
            $('#qty_item_edit').focus()
        } else {
            $.ajax({
                type: 'POST',
                url: '<?= site_url('sale/process') ?>',
                data: {
                    'edit_cart': true,
                    'cart_id': cart_id,
                    'price': price,
                    'qty': qty,
                    'discount': is_number(discount),
                    'total': is_number(total),
                    'expired': expired
                },
                dataType: 'json',
                success: function(result) {
                    if (result.success == true) {
                        $('#cart_table').load('<?= site_url('sale/cart_data') ?>', function() {
                            calculate()
                        })
                        // alert('Item cart berhasil ter-update')
                        Swal.fire('Item cart berhasil ter-update')
                        $('#modal-item-edit').modal('hide');
                    } else {
                        // alert('Data item cart tidak ter-update')
                        Swal.fire('Data item cart tidak ter-update')
                        $('#modal-item-edit').modal('hide');
                    }
                }
            })
        }
    })

    function calculate() {
        $('#grand_total2').text(number_with_commas(total_item()));
    }

    $(document).ready(function() {
        calculate()
    })



    // Proses payment
    $(document).on('click', '#submit_bayar', function() {

        var total_item = $('#grand_total2').text()
        var discount = $('#discount').val()
        var service = $('#service').val()
        var tax = $('#tax').val()
        var subtotal = $('#subtotal').text()
        var grand_total = $('#total_bayar').text()
        var total_bayar = $('#cash').val()
        var change = $('#change').val()

        var type_bayar = $('#type_bayar').val()
        var jenis_kartu = $('#input_jenis_kartu').val()
        var nomor_kartu = $('#cc').val()
        var nama_pemilik_kartu = $('#nama_pemilik_kartu').val()
        var customer_id = $('#customer').val()
        var note = $('#note').val()
        var date = $('#date').val()
        if (subtotal < 1) {
            // alert('Belum ada product item yang dipilih')
            Swal.fire('Belum ada product item yang dipilih')
            $('barcode').focus()
        } else if (total_bayar < 1) {
            // alert('Jumlah uang belum diinput')
            // Swal.fire('Jumlah uang belum diinput')

            Swal.fire({
                // position: 'top-end',
                icon: 'warning',
                title: 'Jumlah uang belum diinput',
                showConfirmButton: false,
                timer: 1000
            })

        } else if (is_number(total_bayar) < is_number(grand_total)) {
            // alert('Pembayaran kurang')
            Swal.fire('Pembayaran kurang')
        } else {

            Swal.fire({
                title: 'Yakin proses transaksi ini?',
                // text: "You won't be able to revert this!",
                // icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, proses!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: '<?= site_url('sale/process') ?>',
                        data: {
                            'process_payment': true,
                            'total_item': total_item,
                            'subtotal': is_number(subtotal),
                            'discount': is_number(discount),
                            'service': is_number(service),
                            'tax': is_number(tax),
                            'grand_total': is_number(grand_total),
                            'total_bayar': is_number(total_bayar),
                            'change': is_number(change),
                            'type_bayar': type_bayar,
                            'nomor_kartu': nomor_kartu.replace(/ /g, ""),
                            'nama_pemilik_kartu': nama_pemilik_kartu,
                            'customer_id': customer_id,
                            'total_bayar': is_number(total_bayar),
                            'note': note,
                            'date': date,
                        },
                        dataType: 'JSON',
                        success: function(hasil) {
                            if (hasil.success) {
                                Swal.fire({
                                    title: 'Transaksi Berhasil',
                                    text: "Kembalian : " + change,
                                    icon: 'success',
                                    showDenyButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Print Nota',
                                    denyButtonText: 'Back',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.open('<?= site_url('sale/cetak/') ?>' + hasil.sale_id, '_self')
                                    } else if (result.isDenied) {
                                        location.href = '<?= site_url('sale') ?>'
                                    }
                                    if (result.isDismissed) {
                                        location.href = '<?= site_url('sale') ?>'
                                    }
                                })
                            } else {
                                // alert('Transaksi gagal');
                                Swal.fire('Transaksi gagal')
                                location.href = '<?= site_url('sale') ?>'
                            }
                            // location.href = '<?= site_url('sale') ?>'
                        }
                    })
                }
            })
        }
    })

    $(document).on('click', '#cancel_payment', function() {

        Swal.fire({
            title: 'Apakah anda yakin untuk cancel transaksi ini?',
            // text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Yakin!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('sale/cart_del') ?>',
                    dataType: 'JSON',
                    data: {
                        'cancel_payment': true
                    },
                    success: function(result) {
                        if (result.success == true) {
                            $('#cart_table').load('<?= site_url('sale/cart_data') ?>', function() {
                                calculate()
                            })
                        }
                    }
                })
                $('#discount').val(0)
                $('#cash').val(0)
                $('#customer').val('').change()
                $('#barcode').val('')
                $('#barcode').focus()
                $('#input_jenis_kartu').val('')
                $('#nomor_kartu').val('')
                $('#nama_pemilik_kartu').val('')

            }
        })

        // if (confirm('Apakah anda yakin untuk cancel?')) {
        // }
    })

    function show_table(result) {
        console.log(result);
        var tbodyRef = document.getElementById("tbody_item_");

        for (var i = 0; i < result.item.length; i++) {
            var button = document.createElement('button');
            button.innerHTML = 'Select';
            button.classList.add('btn', 'btn-primary', 'btn-sm');
            button.setAttribute('data-id_item_detail', (result.item[i].id));
            button.setAttribute('data-stock', (result.item[i].qty));
            button.setAttribute('data-item_id', (result.item[i].item_id));
            button.setAttribute('data-exp_date', (result.item[i].exp_date));
            button.setAttribute('data-barcode', (result.item[i].barcode));
            button.setAttribute('data-harga_jual', (result.item[i].harga_jual));
            button.setAttribute('onclick', 'tambah_keranjang(this)');
            var newRow = tbodyRef.insertRow();
            var newCell1 = newRow.insertCell();
            var newCell2 = newRow.insertCell();
            // var newCell3 = newRow.insertCell();
            var newCell4 = newRow.insertCell();
            var newCell5 = newRow.insertCell();
            var newCell6 = newRow.insertCell();
            var newText1 = document.createTextNode(result.item[i].barcode);
            var newText2 = document.createTextNode(result.item[i].item_name);
            // var newText3 = document.createTextNode('');
            var newText4 = document.createTextNode(result.item[i].qty);
            var newText5 = document.createTextNode(date_format(result.item[i].exp_date));
            var newText6 = button;
            newCell1.appendChild(newText1);
            newCell2.appendChild(newText2);
            // newCell3.appendChild(newText3);
            newCell4.appendChild(newText4);
            newCell5.appendChild(newText5);
            newCell6.appendChild(newText6);
            // tbodyRef.appendChild("<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>");
        }
    }

    function date_format(date_time) {
        // Parse the MySQL date string and create a Date object
        let date = new Date(date_time);

        // Extract the day, month, and year from the Date object
        let day = date.getDate().toString().padStart(2, '0');
        let month = (date.getMonth() + 1).toString().padStart(2, '0');
        let year = date.getFullYear();

        // Return the formatted date string
        return `${day}-${month}-${year}`;
    }

    function tambah_keranjang(e) {
        var id_detail_item = e.getAttribute('data-id_item_detail');
        var stock = e.getAttribute('data-stock');
        var item_id = e.getAttribute('data-item_id');
        var exp_date = e.getAttribute('data-exp_date');
        var harga_jual = e.getAttribute('data-harga_jual');
        var qty = 1;

        add_cart(item_id, id_detail_item, harga_jual, qty, exp_date)

        $('#barcode').focus()
        $('#modal-item-found').modal('hide');

    }

    function add_cart(item_id, id_detail_item, harga_jual, qty, exp_date) {
        $.ajax({
            type: 'POST',
            url: '<?= site_url('sale/process') ?>',
            data: {
                'add_cart': true,
                'item_id': item_id,
                'item_id_detail': id_detail_item,
                'price': harga_jual,
                'qty': qty,
                'exp_date': exp_date,
            },
            dataType: 'json',

            success: function(result) {
                if (result.success == true) {
                    $('#cart_table').load('<?= site_url('sale/cart_data') ?>', function() {
                        calculate()
                    })
                } else if (result.success == false && result.stock_cukup == false) {
                    alert('Stock Tidak cukup');
                } else {
                    alert('Gagal tambah item cart')
                }
            }
        });
    }


    $('#barcode').keypress(function(e) {
        var key = e.which;
        var barcode = $(this).val();
        if (key == 13) {
            if (barcode == '') {
                // alert('input barcode kosong')
                Swal.fire('Input barcode kosong!')
            } else {
                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('sale/get_item_detail') ?>',
                    data: {
                        'barcode': barcode
                    },
                    dataType: 'json',
                    success: function(result) {
                        if (result.success == true) {
                            $('#show_modal_item').load('<?= base_url('sale/md_show_item') ?>', function() {
                                show_table(result);
                                $('#modal-item-found').modal('show');
                                $('#barcode').val('');
                            });
                            // alert('product ditemukan');
                            // $('#modal-item').modal('show');
                            // $('#item_id').val(result.item.item_id)
                            // $('#barcode').val(barcode)
                            // $('#desc').val(result.item.name)
                            // $('#price_item').val(result.item.price)
                            // $('#price').val(result.item.price)
                            // $('#stock').val(result.item.stock)
                            // $('#qty_cart').val($("#cart_table td.barcode:contains('" + barcode + "')").parent().find("td").eq(5).html())
                            // $('#expired_date').val(result.item.exp_date)
                            // $('#add_cart').click();
                        } else {
                            // alert('Product tidak ditemukan')
                            Swal.fire('Product tidak ditemukan')
                            // $('#item_id').val('')
                            // $('#barcode').val('')
                            // $('#price').val('')
                            // $('#stock').val('')
                            // $('#qty_cart').val('')
                            // $('#desc').val('')
                            // $('#price_item').val('')
                            // $('#expired_date').val('')
                            // $('#qty').val(1)
                            // $('#barcode').focus()
                        }
                    }
                })
            }
        }
    })



    function number_with_commas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }


    function number_without_commas(x) {
        return x.replace(/,/g, '');
    }

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    function isMoney(elem) {
        var is_float = parseFloat(number_without_commas(elem.value));
        if (isNaN(is_float)) {
            elem.value = 0;
        } else {
            elem.value = number_with_commas(is_float)
        }
    }

    function is_number(x) {
        return Math.round(parseFloat(x.replace(/,/g, '')));
    }
</script>