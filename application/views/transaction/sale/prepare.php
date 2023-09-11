<section class="content-header">
    <h1>Sales
        <small>Penjualan</small>
        <a href="<?= base_url('sale') ?>" class="btn btn-success btn-flat pull-right">Mulai Transaksi</a>
        <button onclick="updateItemDiscount()" class="btn btn-info btn-flat pull-right" style="margin-right: 5px;">Update Item Discount</button>
    </h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="callout" style="text-align: center;">
                <h3>Tekan Enter Atau Klik Mulai Transaksi Untuk Memulai Transaksi Baru</h3>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>

    <?php if ($promo->num_rows() > 0) { ?>
        <div class="row">
            <div class="col-md-3">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Informasi Promo</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th style="width: 10px">#</th>
                                <th>Nama promo</th>
                                <th>Status</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($promo->result() as $data) { ?>
                                    <tr>
                                        <td><?= $no++  ?></td>
                                        <td><?= $data->nama_promo ?></td>
                                        <td><?= $data->is_active == 'y' ? 'active' : '' ?></td>
                                        <td>
                                            <button onclick="loadDetail(this)" data-kode_promo="<?= $data->kode_promo ?>" class="btn btn-xs btn-info">detail</button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-9" id="detailPromo">

            </div>
        </div>
    <?php } ?>

</section>
<script>
    $(document).ready(function() {
        $(document).on('keypress', function(e) {
            if (e.which === 13) {
                window.location.href = '<?= base_url('sale') ?>'
            }
        });
    });

    function loadDetail(button) {
        var kode_promo = $(button).data('kode_promo')
        $('#detailPromo').load("<?= base_url('sale/loadDetailPromo') ?>", {kode_promo}, function() {

        })
    }

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
                    }).then(function() {})
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