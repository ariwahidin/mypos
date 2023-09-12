<section class="content-header">
    <h1>
        Data Order
    </h1>
</section>
<section class="content">
    <div class="box">
        <?php $this->load->view('messages') ?>
        <div class="box-header">
            <a class="btn btn-info btn-flat pull" href="<?=base_url('item/order')?>">Order</a>
            <a onclick="showLoading()" class="btn btn-success btn-flat pull" href="<?=base_url('item/refresh_order')?>">Refresh</a>
            &nbsp;
        </div>
        <div class="box-body table-responsive">
            <table class="table table-striped" id="table1">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>No Order</th>
                        <th>User</th>
                        <th>Tanggal Order</th>
                        <th>Ket</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($item_order->result() as $data) { ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data->no_order ?></td>
                            <td><?= $data->name ?></td>
                            <td><?= date('d-m-Y', strtotime($data->created)) ?></td>
                            <td><?= $data->is_approve == 'y' ? 'Approved' : '' ?></td>
                            <td>
                                <button class="btn btn-primary btn-xs" id="btn_detail" data-no_order="<?= $data->no_order ?>">Detail</button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<div id="wadah_modal"></div>
<script>
    $(document).on('click', '#btn_detail', function(){
        var no_order = $(this).data('no_order')
        showModal(no_order)
    })

    function showModal(no_order){
        $('#wadah_modal').load("<?=base_url('item/order_detail')?>", {no_order}, function(response){
            $('#modal_detail').modal('show')
        })
    }
</script>