<table class="table table-bordered table-striped" id="table1">
    <thead>
        <tr>
            <th>#</th>
            <th>Barcode</th>
            <th>Item Name</th>
            <th>Exp Date</th>
            <th>Disc (%)</th>
            <th>Start Periode</th>
            <th>End Periode</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        foreach ($item->result() as $data) { ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $data->barcode ?></td>
                <td><?= $data->item_name ?></td>
                <td><?= date('d M Y',strtotime($data->exp_date)) ?></td>
                <td><?= $data->discount ?></td>
                <td><?= date('d M Y', strtotime($data->start_periode)) ?></td>
                <td><?= date('d M Y', strtotime($data->end_periode)) ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<script>
    $(document).ready(function() {
        $('#table1').DataTable()
    })
</script>