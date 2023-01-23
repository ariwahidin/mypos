<section class="content-header">
    <h1>Sales Report
        <small>Laporan Penjualan</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
        <li><a href="#">Reports</a></li>
        <li class="active">Sales</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <?php $this->view('messages') ?>
    <div class="box">
        <div class="box-header width-border">
            <h3 class="box-title">Filter Data</h3>
        </div>
        <div class="box-body">

            <form action="" method="post">

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Date</label>
                                <div class="col-sm-8">
                                    <input type="date" name="date1" value="<?= @$post['date1'] ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">s/d</label>
                                <div class="col-sm-8">
                                    <input type="date" name="date2" value="<?= @$post['date2'] ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Invoice</label>
                                <div class="col-sm-8">
                                    <input type="text" name="invoice" value="<?= @$post['invoice'] ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="pull-right">
                            <button type="submit" name="reset" class="btn btn-flat">Reset</button>
                            <button type="submit" name="filter" class="btn btn-info btn-flat">
                                <i class="fa fa-search"></i> Filter
                            </button>
                            <button class="btn btn-flat btn-primary" type="submit" name="summary_sales">
                                <i class=" fa fa-file-excel-o"></i> Summary Sales
                            </button>
                            <button class="btn btn-flat btn-success" type="submit" name="summary_detail">
                                <i class="fa fa-file-excel-o"></i> Summary Sales Detail
                            </button>
                            <button type="submit" name="cms_bri" class="btn btn-flat btn-warning">
                                cms BRI
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Data Penjualan</h3>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Invoice</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Discount</th>
                        <th>Service</th>
                        <th>Tax</th>
                        <th>Grand Total</th>
                        <!-- <th>Total Bayar</th> -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = $this->uri->segment(3) ? $this->uri->segment(3) + 1 : 1;
                    foreach ($row->result() as $key => $data) { ?>
                        <tr>
                            <td style="width:5%;"><?= $no++ ?>.</td>
                            <td><?= $data->invoice ?></td>
                            <td><?= indo_date($data->date) ?></td>
                            <td><?= $data->customer_id == null ? 'Umum' : $data->customer_name ?></td>
                            <td class="text-right"><?= indo_currency($data->total_price) ?></td>
                            <td class="text-right"><?= indo_currency($data->discount) ?></td>
                            <td class="text-right"><?= indo_currency($data->service) ?></td>
                            <td class="text-right"><?= indo_currency($data->tax) ?></td>
                            <td class="text-right"><?= indo_currency($data->final_price) ?></td>
                            <!-- <td class="text-right"><?= indo_currency($data->total_bayar) ?></td> -->
                            <td class="text-center" width="200px">
                                <button id="detail" data-target="#modal-detail" data-toggle="modal" class="btn btn-default btn-xs" width="200px" data-invoice="<?= $data->invoice ?>" data-date="<?= indo_date($data->date) ?>" data-time="<?= substr($data->sale_created, 11, 5) ?>" data-customer="<?= $data->customer_id == null ? "Umum" : $data->customer_name ?>" data-total="<?= indo_currency($data->total_price) ?>" data-discount="<?= indo_currency($data->discount) ?>" data-grandtotal="<?= indo_currency($data->final_price) ?>" data-cash="<?= indo_currency($data->cash) ?>" data-remaining="<?= indo_currency($data->remaining) ?>" data-note="<?= $data->note ?>" data-cashier="<?= ucfirst($data->user_name) ?>" data-saleid="<?= $data->sale_id ?>" data-tax="<?= indo_currency($data->tax) ?>" data-service="<?= indo_currency($data->service) ?>" data-total_bayar="<?= indo_currency($data->total_bayar) ?>" data-type_bayar="<?= $data->type_bayar_name ?>" data-nomor_kartu="<?= $data->nomor_kartu ?>">
                                    <i class="fa fa-eye"></i> Detail
                                </button>
                                <a href="<?= site_url('sale/cetak/' . $data->sale_id) ?>" target="_self" class="btn btn-primary btn-xs">
                                    <i class="fa fa-print"></i> Print
                                </a>
                                <a href="<?= site_url('sale/del/' . $data->sale_id) ?>" onclick="return confirm('Yakin hapus data?')" class="btn btn-danger btn-xs">
                                    <i class="fa fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                    <?php
                    } ?>
                </tbody>
            </table>
        </div>
        <div class="box-footer clearfix">
            <ul class="pagination pagination-sm no-margin pull-right">
                <?= $pagination ?>
            </ul>
        </div>
    </div>
</section>

<div class="modal fade"  id="modal-detail">
    <div class="modal-dialog  modal-lg" tabindex="-1" role="dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Sales Report Detail</h4>
            </div>
            <div class="modal-body table-responsive">
                <table class="table table-bordered no-margin">
                    <tbody>
                        <tr>
                            <th style="width:20%">Invoice</th>
                            <td style="width:30%"><span id="invoice"></span></td>
                            <th>Service</th>
                            <td><span id="service"></span></td>
                            
                        </tr>
                        <tr>
                            <th>Date Time</th>
                            <td><span id="datetime"></span></td>
                            <!-- <th>Tax</th>
                            <td><span id="tax"></span></td> -->
                            <th>Discount</th>
                            <td><span id="discount"></span></td>
                        </tr>
                        <tr>
                            <th style="width:20%">Customer</th>
                            <td style="width:30%"><span id="cust"></span></td>
                            <th>Grand Total</th>
                            <td><span id="grandtotal"></span></td>
                        </tr>
                        <tr>
                            <th>Cashier</th>
                            <td><span id="cashier"></span></td>
                            <th>Total Bayar</th>
                            <td><span id="total_bayar"></span></td>
                           
                        </tr>
                        <tr>
                            
                            <th>Type Bayar</th>
                            <td><span id="type_bayar"></span></td>
                            <th>Change</th>
                            <td><span id="change"></span></td>
                        </tr>
                        <tr>
                            
                            <th>Nomor Kartu</th>
                            <td><span id="nomor_kartu"></span></td>
                            
                        </tr>
                        <tr>
                            
                            <th></th>
                            <td><span></span></td>
                        </tr>
                        <tr>
                            <th>Product</th>
                            <td colspan="3"><span id="product"></span></td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>


    function credit_card_format(x) {
        return x.toString().replace(/\B(?=(\d{4})+(?!\d))/g, "-");
    }

    $(document).on('click', '#detail', function() {
        $('#invoice').text($(this).data('invoice'))
        $('#cust').text($(this).data('customer'))
        $('#datetime').text($(this).data('date') + ' ' + $(this).data('time'))
        $('#total').text($(this).data('total'))
        $('#discount').text($(this).data('discount'))
        $('#change').text($(this).data('remaining'))
        $('#grandtotal').text($(this).data('grandtotal'))
        $('#note').text($(this).data('note'))
        $('#cashier').text($(this).data('cashier'))
        $('#cash').text($(this).data('cash'))
        $('#tax').text($(this).data('tax'))
        $('#service').text($(this).data('service'))
        $('#total_bayar').text($(this).data('total_bayar'))
        $('#type_bayar').text($(this).data('type_bayar'))
        $('#nomor_kartu').text(credit_card_format($(this).data('nomor_kartu')))

        var product = '<table class="table no-margin">'
        product += '<tr><th>Item</th><th>Price</th><th>Qty</th><th>Disc</th><th>Total</th></tr>';
        var subtotal = 0; 
        $.getJSON('<?= site_url('report/sale_product/') ?>' + $(this).data('saleid'), function(data) {
            $.each(data, function(key, val) {
                product += '<tr><td>' + val.name + '</td><td>' + val.price + '</td><td>' + val.qty + '</td><td>' + val.discount_item + '</td><td>' + val.total + '</td></tr>';
                subtotal += parseFloat(val.total);
            })
            product +='<tr><td><strong>Subtotal : </strong></td> <td></td> <td></td> <td></td> <td><strong>'+subtotal+'</strong></td> </tr>'
            product += '</table>'
            $('#product').html(product)
        })
    })

    $('#summary_detail').on('click', function() {

    })
</script>