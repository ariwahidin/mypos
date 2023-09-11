<section class="content-header">
    <h1>Printer
        <small>Pengaturan Printer</small>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
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
                                <th>Jumlah Print</th>
                                <th>Margin Left</th>
                                <th>Print Logo</th>
                                <th>Alternative Text</th>
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
                                            <input type="text" class="form-control" id="printer_name" name="printer_name" value="<?= $data->printer_name ?>" required readonly>
                                            <input type="hidden" name="id" value="<?= $data->id ?>">
                                        </td>
                                        <td width="100px">
                                            <input type="number" class="form-control" id="jumlah_print" name="jumlah_print" value="<?= $data->jumlah_print ?>" required readonly>
                                        </td>
                                        <td width="100px">
                                            <input type="number" class="form-control" id="margin_left" name="margin_left" value="<?= $margin_left ?>" required readonly>
                                        </td>
                                        <td width="100px">
                                            <select class="form-control" id="print_logo" name="print_logo" required readonly disabled>
                                                <option value="">--Pilih--</option>
                                                <option value="true" <?php if(!empty($settings_printer->print_logo)){if($settings_printer->print_logo == 'true'){echo "selected";}} ?>>Ya</option>
                                                <option value="false" <?php if(!empty($settings_printer->print_logo)){if($settings_printer->print_logo == 'false'){echo "selected";}} ?>>Tidak</option>
                                            </select>
                                        </td>
                                        <td width="200px">
                                            <input type="text" class="form-control" id="alt_text" name="alt_text" value="<?php if(!empty($settings_printer->alt_text)){echo $settings_printer->alt_text;} ?>" required readonly>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" id="btn-edit">Edit</button>
                                            <button type="submit" class="btn btn-success btn-sm" id="btn_save" data-id="<?= $data->id ?>" disabled>
                                                Save
                                            </button>
                                            <button type="button" class="btn btn-info btn-info btn-sm" id="btn-test">Test Print</button>
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
<script>
    $(document).on('click', '#btn-edit', function() {
        $('#printer_name').removeAttr('readonly')
        $('#jumlah_print').removeAttr('readonly')
        $('#margin_left').removeAttr('readonly')
        $('#print_logo').removeAttr('readonly')
        $('#print_logo').removeAttr('disabled')
        $('#alt_text').removeAttr('readonly')
        $('#btn_save').removeAttr('disabled')
    })

    $(document).on('click', '#btn-test', function() {
        $.ajax({
            type: "GET",
            url: "<?= base_url('cetak') ?>",
            success: function(data) {
                // do something with the returned data
            }
        });
    })
</script>