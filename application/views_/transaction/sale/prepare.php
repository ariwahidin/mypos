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

    <?php if ($item_bonus_acitve->num_rows() > 0){ ?>
    <div class="row">
        <div class="col-md-4">
            <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Informasi Item Bonus</h4>
                Bonus <?=$item_bonus_acitve->row()->name?>, minimal belanja <?=number_format($item_bonus_acitve->row()->min_sales)?>
            </div>
        </div>
        <div class="col-md-6"></div>
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
</script>