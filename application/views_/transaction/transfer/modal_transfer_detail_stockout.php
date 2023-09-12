<div id="myModal" class="modal flip" role="dialog">

    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Detail Item</h4>
            </div>
            <div class="modal-body">
                <table class="table table-responsive table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Barcode</th>
                            <th>Item Name</th>
                            <th>Qty</th>
                            <th>Exp Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1;
                        foreach ($detail->result() as $data) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $data->barcode ?></td>
                                <td><?= $data->name ?></td>
                                <td><?= $data->qty ?></td>
                                <td><?= date('d-m-Y', strtotime($data->exp_date)) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<script>
    $(document).ready(function() {
        $('#myModal').modal('show')
    })
</script>