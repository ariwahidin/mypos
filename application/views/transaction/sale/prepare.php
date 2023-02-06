<section class="content-header">
    <h1>Sales
        <small>Penjualan</small>
        <a href="<?= base_url('sale') ?>" class="btn btn-success btn-flat pull-right">Mulai Transaksi</a>
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
</section>
<script>
    $(document).ready(function() {
        $(document).on('keypress', function(e) {
            if (e.which === 13) {
                window.location.href = '<?= base_url('sale') ?>'
            }
        });
    });
</script>