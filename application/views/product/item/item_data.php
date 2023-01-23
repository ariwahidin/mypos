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
                <a class="btn btn-flat btn-primary" href="<?= site_url('Warehouse/get_harga_item') ?>">Check Item PK</a>
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
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach($item->result() as $data){ ?>
                            <tr>
                                <td><?=$no++?></td>
                                <td><?=$data->item_code?></td>
                                <td><?=$data->barcode?></td>
                                <td><?=$data->name?></td>
                                <td><?=number_format($data->harga_jual)?></td>
                                <td>
                                    <a href="<?=base_url('item/item_stock_detail/').$data->item_code?>"><?=$data->stock?></a>
                                </td>
                            </tr>
                        <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>



<script>
    $(document).ready(function(){
        $('#table1xx').DataTable();
    })
    // $(document).ready(function() {
    //     $('#table1').DataTable({
    //         "processing": true,
    //         "serverSide": true,
    //         "ajax": {
    //             "url": "",
    //             "type": "POST"
    //         },
    //         "columnDefs": [
    //             // {
    //             //     "targets": [5, 6],
    //             //     "className": 'text-right'
    //             // },
    //             // {
    //             //     "targets": [7, -1],
    //             //     "className": 'text-center'
    //             // },
    //             // {
    //             //     "targets": [0, -1],
    //             //     "orderable": false
    //             // }
    //         ],
    //         "order": []
    //     })
    // })

    // $(document).on('keydown', '#harga_jual', function(e){
    //     isNumber(e)
    // })

    // $(document).on('keyup', '#harga_jual', function() {
    //     var tax = parseFloat('');
    //     var harga_bersih = ($(this).val() / tax) * 100;
    //     $('#harga_bersih').val(harga_bersih.toFixed(2));
    // })

    // $('#modal-tambah-item').on('shown.bs.modal', function(e) {
    //     $('#item_code').focus();
    // })

    // function number_with_commas(x) {
    //     return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    // }


    // function number_without_commas(x) {
    //     return x.replace(/,/g, '');
    // }

    // function isNumber(evt) {
    //     evt = (evt) ? evt : window.event;
    //     var charCode = (evt.which) ? evt.which : evt.keyCode;
    //     if (charCode > 31 && (charCode < 48 || charCode > 57)) {
    //         return false;
    //     }
    //     return true;
    // }

    // function isMoney(elem) {
    //     var is_float = parseFloat(number_without_commas(elem.value));
    //     if (isNaN(is_float)) {
    //         elem.value = 0;
    //     } else {
    //         elem.value = number_with_commas(is_float)
    //     }
    // }

    // function is_number(x) {
    //     return Math.round(parseFloat(x.replace(/,/g, '')));
    // }
</script>