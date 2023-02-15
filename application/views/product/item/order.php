<section class="content-header">
    <h1>
        Order
    </h1>
</section>
<section class="content">
    <?php $this->view('messages') ?>
    <div class="box">
        <div class="box-header">
            <button class="btn btn-flat btn-success" id="btn_list_item">List Item</button>
            <button class="btn btn-primary pull-right" id="btn_proses_order">Proses Order</button>
        </div>
        <div id="wadah_table" class="box-body table-responsive">
            <?php $this->view('product/item/table_order') ?>
        </div>
    </div>
</section>

<div class="modal flip" id="modal_list_item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">List Item Suggest</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped" id="table_list_item">
                    <thead>
                        <tr>
                            <th>Item Code</th>
                            <th>Barcode</th>
                            <th>Name</th>
                            <th>Stock</th>
                            <th>Min Stock</th>
                            <th>Qty Suggest</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($item_suggest->result() as $data) { ?>
                            <tr>
                                <td><?= $data->item_code ?></td>
                                <td><?= $data->barcode ?></td>
                                <td width="100%"><?= $data->name ?></td>
                                <td><?= $data->stock ?></td>
                                <td><?= $data->min_stock ?></td>
                                <td><?= $data->suggest_qty ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" id="btn_add" class="btn btn-success">Add</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('click', '#btn_list_item', function() {
        $('#modal_list_item').modal('show')
    })

    $(document).ready(function() {
        var table = $('#table_list_item').DataTable({
            // 'ajax': '/lab/jquery-datatables-checkboxes/ids-arrays.txt',
            'columnDefs': [{
                'targets': 0,
                'checkboxes': {
                    'selectRow': true
                }
            }],
            'select': {
                'style': 'multi'
            },
            'order': [
                [1, 'asc']
            ]
        })

        // get item code ketika tombol add ditekan
        $('#btn_add').on('click', function(e) {
            var item_code = []
            var rows_selected = table.column(0).checkboxes.selected();
            $.each(rows_selected, function(index, rowId) {
                item_code.push(rowId)
            });
            if (item_code == '') {
                alert('Item Belum Dipilih')
            } else {
                add_cart(item_code)
            }
        });
    });

    $(document).on('click', '#btn_delete', function() {
        var id = $(this).data('id');
        delete_cart(id)
    })

    $(document).on('click', '#btn_proses_order', function() {
        proses_order()
    })

    function add_cart(item_code) {
        $('#wadah_table').load('<?= base_url('item/add_cart') ?>', {
            item_code
        }, function(response) {
            // var res = JSON.parse(response)
            $('#modal_list_item').modal('hide')
        })
    }

    function delete_cart(id) {
        $('#wadah_table').load('<?= base_url('item/delete_cart') ?>', {
            id
        }, function(response) {
            // var res = JSON.parse(response)
        })
    }

    function proses_order() {
        $.ajax({
            url: '<?= base_url('item/proses_order') ?>',
            method: 'POST',
            data: {},
            dataType: 'JSON',
            success: function(response) {
                if (response.success == true) {
                    window.location.href = '<?=base_url('item/order_item')?>'
                } else {
                    alert("Gagal Proses")
                }
            }
        })
    }
</script>