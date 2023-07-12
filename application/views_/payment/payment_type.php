<section class="content-header">
    <h1>Type Bayar
        <!-- <small>Pengaturan Toko</small> -->
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
        <li class="active">Type Bayar</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <?php $this->view('messages') ?>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Type Bayar</h3>
            <button id="add_type_bayar" class="btn btn-flat btn-primary pull-right" data-toggle="modal" data-target="#modal-form">Tambah Type Bayar</button>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-striped" id="table1">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Type Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($type_bayar->result() as $typ => $data) { ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data->type_bayar ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Modal Add Type bayar -->
<div class="modal fade" id="modal-form">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Tambah Type Bayar</h4>
            </div>

            <div class="modal-body">
                <form action="<?= site_url('payment/insert') ?>" method="post">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Type Bayar*</label>
                                <input type="text" class="form-control" name="type_bayar" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" align="right">
                        <button type="submit" class="btn btn-success btn-flat">
                            <i class="fa fa-paper-plane"></i> Simpan
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>