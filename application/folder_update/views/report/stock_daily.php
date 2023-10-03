<section class="content-header">
    <h1>Stock Daily
        <small>Data stock toko harian yang sudah diupload</small>
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header"></div>
                <div class="box-body table-responsive">
                    <table class="table table-bordered table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Whs Code</th>
                                <th>Total Item</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($stock) > 0) { ?>
                                <?php $no = 1;
                                foreach ($stock as $data) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $data['whs_code'] ?></td>
                                        <td><?= number_format($data['total_item']) ?></td>
                                        <td><?= $data['date'] ?></td>
                                        <td>
                                            <button onclick="getStockDailyDetail(this)" class="btn btn-sm btn-primary" data-whs-code="<?= $data['whs_code'] ?>" data-date="<?= $data['date'] ?>">Detail</button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function getStockDailyDetail(button) {
        showLoading()
        var whs_code = $(button).data('whs-code')
        var date = $(button).data('date')
        var url = "report/stockdailydetail?whs_code=" + whs_code + "&date=" + date
        window.location.href = "<?= base_url() ?>" + url;
    }
</script>