<section class="content-header">
    <h1>
        Item Discount
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <?php $this->view('messages') ?>
    <div class="box">
        <div class="box-header">
            <button onclick="updateItemDiscount()" class="btn btn-primary btn-sm pull-right">
                Update
            </button>
        </div>
        <div class="box-body table-responsive" id="box-item-discount">

        </div>
    </div>
</section>

<script>
    $('#box-item-discount').load("<?= base_url('item/loadItemDiscount') ?>")

    function updateItemDiscount() {
        showLoading()
        $.ajax({
            url: "<?= base_url('item/getDiscountItem') ?>",
            method: "POST",
            data: {},
            dataType: "JSON",
            success: function(response) {
                if (response.success == true) {
                    hideLoading()
                    Swal.fire({
                        position: 'center',
                        icon: response.icon,
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        $('#box-item-discount').load("<?= base_url('item/loadItemDiscount') ?>")
                    })
                } else {
                    hideLoading()
                    Swal.fire({
                        position: 'center',
                        icon: response.icon,
                        title: response.message,
                    }).then(function() {})
                }
            }
        })
    }
</script>