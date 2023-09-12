<?php
// var_dump($response);
?>

<section class="content-header">
    <h1>Setting Harga Item
        <small>Data Item dan Harga di PK sesuai kode Counter</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
        <li class="active">Harga</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <?php $this->view('messages') ?>
    <div class="box">
        <div class="box-header">
            <div class="row">
                <div class="col-md-6">
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
                </div>
                <div class="col-md-6">
                    <button id="btn_master_item" class="btn btn-flat btn-primary pull-right">
                        Master Item
                    </button>
                    <div id="div_master_item"></div>
                </div>
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
                <tbody id="tbody_item_harga">
                    <?php $this->view('warehouse/ajax_harga')?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<div class="modal fade" id="modal-update-harga">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Update Harga Item</h4>
            </div>
            <div class="modal-body table-responsive">
                <form action="<?= base_url('warehouse/update_harga') ?>" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Item Code *</label>
                                <input type="text" name="item_code" id="item_code" class="form-control" required readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <label for="barcode">Barcode *</label>
                            </div>
                            <div class="form-group input-group">
                                <input type="hidden" name="id" id="id">
                                <input type="text" name="barcode" id="barcode" class="form-control" required readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Item Name *</label>
                                <input type="text" name="item_name" id="item_name" class="form-control" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Harga Jual *</label>
                                <input type="number" name="harga_jual" id="harga_jual" class="form-control">
                                <input type="hidden" name="harga_bersih" id="harga_bersih" class="form-control" readonly>
                                <input type="hidden" min="0" max="100" name="harga_ppn" id="harga_ppn" class="form-control" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">PPN (%)*</label>
                                <input type="number" min="0" max="100" name="percent_ppn" id="percent_ppn" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group" align="right">
                        <button type="submit" class="btn btn-success btn-flat">
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
        $(document).on('click', '#btn_update', function() {
            var id = $(this).data('id');
            var item_code = $(this).data('item_code');
            var barcode = $(this).data('barcode');
            var item_name = $(this).data('item_name');
            var harga_jual = $(this).data('harga_jual');
            var harga_bersih = $(this).data('harga_bersih');
            var harga_ppn = $(this).data('harga_ppn');
            var percent_ppn = $(this).data('percent_ppn');
            $('#id').val(id);
            $('#item_code').val(item_code);
            $('#barcode').val(barcode);
            $('#item_name').val(item_name);
            $('#harga_jual').val(harga_jual);
            $('#harga_bersih').val(harga_bersih);
            $('#harga_ppn').val(harga_ppn);
            $('#percent_ppn').val(percent_ppn);
        })    
    })

    $(document).on('click','#btn_master_item', function(){
        $('#div_master_item').load('<?=base_url('warehouse/get_master_item')?>',function( response, status, xhr ){
            // console.log(response);
            $('#table_master_item').DataTable({
                responsive: true
            });
            $('#modal-master-item').modal('show');
        });
    })

    $(document).on('click','#btn-add-item', function(){
        var item_code =  $(this).data('item-code')
        var barcode = $(this).data('barcode')
        var brand_code = $(this).data('brand-code')
        $.ajax({
            url : '<?=base_url('warehouse/add_item_to_counter')?>',
            type : 'POST',
            data : {
                item_code,
                barcode,
                brand_code,
            },
            dataType: 'JSON',
            success : function(response){
                if(response.success == true){
                    $('#tbody_item_harga').load('<?=base_url('warehouse/ajax_setting_harga')?>')
                }else{
                    alert('Item Sudah Ada');
                }
            }
        })
    })
</script>