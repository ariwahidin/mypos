<div class="box box-info">
    <div class="box-header">
        <h3 class="box-title">Detail promo</h3>
    </div>
    <div class="box-body">
        <table class="table table-bordered table-striped" id="tableDetail">
            <thead>
                <th style="width: 10px">#</th>
                <th>Promo</th>
                <th>Barcode</th>
                <th>Item Name</th>
                <th>Discount</th>
                <th>Promo Periode</th>
                <th>Exp Periode</th>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($detail->result() as $data) { ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $data->nama_promo ?></td>
                        <td><?= $data->barcode ?></td>
                        <td><?= $data->name ?></td>
                        <td><?= $data->discount ?></td>
                        <td><?= $data->exp_date_from . " s/d " . $data->exp_date_to ?></td>
                        <td><?= $data->start_periode . " s/d " . $data->end_periode ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#tableDetail').DataTable()
    })
</script>