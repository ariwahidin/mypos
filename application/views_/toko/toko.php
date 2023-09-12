<section class="content-header">
    <h1>Toko
        <small>Pengaturan Toko</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
        <li class="active">Toko</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <?php $this->view('messages') ?>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Toko</h3>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped" id="table1">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Store</th>
                        <th>Whs Code</th>
                        <th>Nama Toko</th>
                        <th>Cabang</th>
                        <th>Alamat</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($toko->result() as $tk => $data) { ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data->code_store ?></td>
                            <td><?= $data->whs_code ?></td>
                            <td><?= $data->nama_toko ?></td>
                            <td><?= $data->toko_cabang ?></td>
                            <td><?= $data->alamat_toko ?></td>
                            <td>
                                <button class="btn btn-flat btn-primary" data-toggle="modal" id="edit_toko" data-target="#modal-edit-toko" data-id_toko="<?= $data->id ?>" data-whs_code="<?= $data->whs_code ?>" data-kode_store="<?= $data->code_store ?>" data-nama_toko="<?= $data->nama_toko ?>" data-cabang="<?= $data->toko_cabang ?>" data-alamat="<?= $data->alamat_toko ?>">
                                    Update
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Modal Edit Toko -->
<div class="modal fade" id="modal-edit-toko">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Edit Toko</h4>
            </div>

            <div class="modal-body">
                <form action="<?= site_url('toko/edit_toko') ?>" method="post">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nama Toko*</label>
                                <input type="text" class="form-control" id="nama_toko" name="nama_toko" required>
                                <input type="hidden" name="id_toko" id="id_toko">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Kode Store*</label>
                                <input type="text" class="form-control" id="kode_store" name="kode_store" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Whs Code*</label>
                                <select name="whs_code" id="whs_code" class="form-control">
                                    <?php foreach ($whs_code->result() as $whs) { ?>
                                        <option value="<?= $whs->whs_code ?>"><?= $whs->whs_name ?></option>
                                    <?php } ?>
                                </select>
                                <!-- <input type="text" class="form-control" id="whs_code" name="whs_code" required> -->
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Cabang *</label>
                                <input type="text" name="cabang_toko" id="cabang_toko" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Alamat Toko *</label>
                                <textarea type="text" name="alamat" id="alamat" class="form-control" required></textarea>
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

<script>
    $(document).on('click', '#edit_toko', function() {
        $('#id_toko').val($(this).data('id_toko'))
        $('#kode_store').val($(this).data('kode_store'))
        $('#whs_code').val($(this).data('whs_code'))
        $('#nama_toko').val($(this).data('nama_toko'))
        $('#cabang_toko').val($(this).data('cabang'))
        $('#alamat').val($(this).data('alamat'))
    })
</script>