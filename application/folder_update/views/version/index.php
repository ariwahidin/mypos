<section class="content-header">
    <h1>Version
        <small>Versi aplikasi</small>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <button id="btnCekUpdate" onclick="updateAplikasi()" class="btn btn-primary">Check update</button>
        </div>
    </div>
</section>
<script>
    function updateAplikasi() {
        showLoading()
        $.ajax({
            url: "<?= base_url('version/checkingVersion') ?>",
            method: "POST",
            data: {},
            dataType: "JSON",
            success: function(response) {
                if (response.success == true) {
                    hideLoading()
                    Swal.fire({
                        icon: 'question',
                        title: response.message,
                        text: response.note,
                        showCancelButton: true,
                        confirmButtonText: 'Ya, update!',
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            showLoading()
                            $.ajax({
                                url: "<?= base_url('version/updateAplikasi') ?>",
                                method: 'POST',
                                data: {
                                    'new_version': response.data.new_version,
                                    'url': response.data.url,
                                    'zip_name': response.data.zip_name,
                                },
                                dataType: 'JSON',
                                success: function(res) {
                                    if (res.success == true) {
                                        hideLoading();
                                        Swal.fire({
                                            position: 'center',
                                            icon: 'success',
                                            title: res.message,
                                            text: res.updated_table + ' Table updated',
                                            showConfirmButton: false,
                                            timer: 2000
                                        }).then(function() {
                                            window.location.href = "<?= base_url('version') ?>";
                                        })
                                    } else {
                                        hideLoading();
                                        Swal.fire({
                                            position: 'center',
                                            icon: 'error',
                                            title: res.message,
                                        })
                                    }
                                }
                            })
                        } else if (result.isDenied) {
                            // Swal.fire('Changes are not saved', '', 'info')
                        }
                    })
                } else {
                    hideLoading()
                    Swal.fire(
                        response.message,
                        response.note,
                        'warning'
                    )
                }
            }
        })
    }
</script>