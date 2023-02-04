<section class="content-header">
    <h1>Printer
        <small>Pengaturan Printer</small>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div id="flash" data-flash="<?= $this->session->flashdata('success') ?>"></div>
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Printer</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($printer->result() as $data) { ?>
                                <form method="POST">
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td>
                                            <input type="text" class="form-control" name="printer_name" value="<?= $data->printer_name ?>" required>
                                            <input type="hidden" name="id" value="<?= $data->id ?>">
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-primary btn-sm" id="btn_edit" data-id="<?= $data->id ?>">Edit</button>
                                            <a href="<?=base_url('cetak')?>" class="btn btn-info btn-sm">Test Print</a>
                                        </td>
                                    </tr>
                                </form>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>