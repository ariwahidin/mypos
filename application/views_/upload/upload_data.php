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
        <div class="col-md-7">
            <div class="box">
                <div class="box-header">
                    <h4>Upload Data Penjualan</h4>
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
                                <td>Upload Data Sales</td>
                                <form action="<?= base_url('upload/upload_data') ?>" method="POST" id="form_upload">
                                    <td>
                                        <input type="date" name="start_date" id="start_date" class="form-control" value="<?= ($this->session->flashdata('start_date')) ? $this->session->flashdata('start_date') : date('Y-m-d') ?>">
                                    </td>
                                    <td>
                                        <input type="date" name="end_date" id="end_date" class="form-control" value="<?= ($this->session->flashdata('end_date')) ? $this->session->flashdata('end_date') : date('Y-m-d') ?>">
                                    </td>
                                </form>
                                <td>
                                    <button id="btn_upload" class="btn btn-primary btn-flat btn-sm">
                                        Upload
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box">
                <div class="box-header">
                    <h4>Upload Data Stock Harian</h4>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Activity</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Upload Data Stock Harian</td>
                                <td><span id="status_upload"><?= $status_upload ?></span></td>
                                <td>
                                    <button id="btnUploadStock" class="btn btn-success btn-flat btn-sm">
                                        Upload
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
<script>
    $(document).ready(function() {
        var status_upload = "<?= $status_upload ?>";
        if (status_upload === 'sudah upload') {
            $("#btnUploadStock").prop('disabled', true);
        }
    })

    $(document).on("click", "#btn_upload", function() {
        var start_date = $("#start_date").val()
        var end_date = $("#end_date").val()

        if (start_date == "" || end_date == "") {
            alert("Tanggal Tidak Boleh Kososng")
        } else {
            showLoading()
            $("#form_upload").submit()
        }

    })


    $(document).on("click", "#btnUploadStock", function() {
        Swal.fire({
            icon: 'question',
            title: 'Yakin upload data stock hari ini? \n Setelah stock diupload, tidak bisa upload ulang',
            // showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Ya, upload',
            // denyButtonText: `Don't save`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                // Swal.fire('Saved!', '', 'success')
                showLoading()
                $.ajax({
                    url: '<?= base_url('upload/uploadStock') ?>',
                    type: 'POST',
                    data: {},
                    dataType: 'JSON',
                    success: function(response) {
                        hideLoading()
                        // console.log(response)
                        if (response.success == true) {
                            $("#status_upload").text("sudah upload")
                            $("#btnUploadStock").prop('disabled', true);
                            Swal.fire('Data stock berhasil diupload', '', 'success')
                        } else {
                            Swal.fire('Gagal upload data stock', '', 'error')
                        }
                    },
                    error: function(xhr, status, error) {

                    }
                })
            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }
        })
    })
</script>