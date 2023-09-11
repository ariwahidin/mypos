<section class="content-header">
    <h1>
        Delete Data Sales
    </h1>
</section>
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
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Delete Data Sales</td>
                                <form action="" method="POST" id="form_upload">
                                    <td>
                                        <input type="date" 
                                        name="start_date" id="start_date" 
                                        class="form-control" 
                                        value="<?= ($this->session->flashdata('start_date')) ? $this->session->flashdata('start_date') : date('Y-m-d')?>">
                                    </td>
                                    <td>
                                        <input type="date" 
                                        name="end_date" id="end_date" 
                                        class="form-control" 
                                        value="<?= ($this->session->flashdata('end_date')) ? $this->session->flashdata('end_date') : date('Y-m-d')?>">
                                    </td>
                                </form>
                                <td>
                                    <button id="btn_upload" class="btn btn-danger btn-flat btn-sm">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>