<section class="content-header">
    <h1>
        Data Transfer Stock In
    </h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12 table responsinve">
            <div class="box">
                <div class="box-header">
                    <a href="<?=base_url('transfer/in')?>" class="btn btn-primary btn-flat pull-right">Buat Baru</a>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Doc id</th>
                                <th>Pengirim</th>
                                <th>Type</th>
                                <th>Total Item</th>
                                <th>User</th>
                                <th>Tanggal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($transfer_in->result() as $data) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $data->docnum ?></td>
                                    <td><?= $data->pengirim ?></td>
                                    <td><?= $data->type ?></td>
                                    <td><?= $data->total_qty ?></td>
                                    <td><?= $data->user ?></td>
                                    <td><?= date('d-m-Y', strtotime($data->created)) ?></td>
                                    <td>
                                        <button id="btn_detail" class="btn btn-primary btn-flat btn-sm" data-docnum="<?= $data->docnum ?>">Detail</button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="modal_space"></div>
<script>
    $(document).on('click', '#btn_detail', function(){
        var docnum = $(this).data('docnum');
        $("#modal_space").load('<?= base_url('transfer/show_detail_transfer_stockin') ?>', {
            docnum
        }, function() {
            // alert("Load was performed.");
        });
    });
</script>