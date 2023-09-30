<div class="row">
    <div class="col col-md-8">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Detail promo</h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped" id="tableDetail">
                    <thead>
                        <th style="width: 10px">#</th>
                        <th>Kode promo</th>
                        <th>Nama promo</th>
                        <th>Min belanja</th>
                        <th>Min Qty</th>
                        <th>Qty Bonus</th>
                        <th>Status</th>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($promo->result() as $data) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $data->kode_promo ?></td>
                                <td><?= ucfirst($data->nama_promo) ?></td>
                                <td style="text-align: right;"><?= number_format($data->min_belanja) ?></td>
                                <td style="text-align: right;"><?= $data->min_qty ?></td>
                                <td style="text-align: right;"><?= $data->qty_bonus ?></td>
                                <td><?= $data->is_active == 'y' ? 'Active' : 'Tidak aktif' ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="box box-info">
    <div class="box-header">
        <h3 class="box-title">Detail item promo</h3>
    </div>
    <div class="box-body table-responsive">
        <table class="table table-bordered table-striped" id="tableDetailItemPromo">
            <thead>
                <th style="width: 10px">#</th>
                <th>Promo</th>
                <th>Barcode</th>
                <th>Item Name</th>
                <th>Disc.(%)</th>
                <th>Promo Periode</th>
                <th>Exp Periode</th>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($detail->result() as $data) { ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= ucfirst($data->nama_promo) ?></td>
                        <td style="text-align: right;"><?= $data->barcode ?></td>
                        <td><?= $data->name ?></td>
                        <td style="text-align: right; color: green;"><?= $data->discount ?></td>
                        <td style="text-align: right;"><?= date('d-M-Y', strtotime($data->start_periode)) . " s/d " . date('d-M-Y', strtotime($data->end_periode)) ?></td>
                        <td style="text-align: right;"><?= date(('d-M-Y'), strtotime($data->exp_date_from)) . " s/d " . date('d-M-Y', strtotime($data->exp_date_to)) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#tableDetailItemPromo').DataTable()
    })
</script>