<section class="content-header">
    <h1>
        Upload Data
        <small>Upload data ke kantor pusat</small>
    </h1>
</section>
<!-- Main content -->
<section class="content">
    <?php $this->view('messages') ?>
    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Activity</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Upload Data Sales</td>
                                <td>
                                    <a href="<?=base_url('upload/upload_data')?>" class="btn btn-primary btn-flat btn-sm">Upload</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>