<section class="content-header">
    <h1>Tax
        <small>Pengaturan Tax</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
        <li class="active">Tax</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <?php $this->view('messages') ?>
    <!-- <div id="flash" data-flash="<?= $this->session->flashdata('success') ?>"></div> -->
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Tax</h3>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped" id="table1">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tax</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($tax->result() as $data) { ?>
                    <?php $data->tax = (float)$data->tax * 100 ?>
                        <td><?= $no++ ?></td>
                        <td><?= $data->tax ?></td>
                        <td>
                            <button class="btn btn-flat btn-primary"
                            id="edit_tax"
                            data-toggle="modal"
                            data-target="#modal-edit-tax"
                            data-tax="<?=$data->tax?>"
                            data-tax_id="<?=$data->id?>"
                            >
                                Update
                            </button>
                        </td>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Modal Edit Tax -->
<div class="modal fade" id="modal-edit-tax">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Edit Tax</h4>
            </div>

            <div class="modal-body">
                <form action="<?= site_url('tax/edit_tax') ?>" method="post">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Tax*</label>
                                <input type="number" class="form-control" id="tax" name="tax" required>
                                <input type="hidden" name="id_tax" id="id_tax">
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
    $(document).on('click', '#edit_tax', function() {
        $('#id_tax').val($(this).data('tax_id'))
        $('#tax').val($(this).data('tax'))
    })
</script>