<section class="content-header">
    <h1>
        Transfer Stock Out
    </h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12 table responsinve">
            <?php $this->load->view('messages') ?>
            <div class="box">
                <div class="box-header">
                    <a href="<?= base_url('transfer') ?>" class="btn btn-primary btn-flat pull-right">
                       <i class="fa fa-plus"></i> Buat Baru
                    </a>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Doc id</th>
                                <th>Tujuan</th>
                                <th>Type</th>
                                <th>Total Item</th>
                                <th>User </th>
                                <th>Tanggal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($stockout->result() as $data) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $data->docnum ?></td>
                                    <td><?= $data->tujuan ?></td>
                                    <td><?= $data->type_transfer ?></td>
                                    <td><?= $data->total_qty ?></td>
                                    <td><?= $data->name ?></td>
                                    <td><?= date('d-m-Y', strtotime($data->created)) ?></td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" id="btn_detail" data-docnum="<?= $data->docnum ?>">
                                            Detail
                                        </button>
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
    $(document).on('click', '#btn_detail', function() {
        var docnum = $(this).data('docnum')
        $("#modal_space").load('<?= base_url('transfer/show_detail_transfer_stockout') ?>', {
            docnum
        }, function() {
            // alert("Load was performed.");
        });
    })
</script>