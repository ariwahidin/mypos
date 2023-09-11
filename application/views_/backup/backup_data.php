<section class="content-header">
    <h1>Backup
        <small>Backup Data</small>
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
                                <th>Desc</th>
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
                                            Backup data POS
                                        </td>
                                        <td>
                                            <form method="post" action="<?php echo base_url('backup'); ?>">
                                                <button type="submit" name="backup">Backup Database</button>
                                            </form>
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