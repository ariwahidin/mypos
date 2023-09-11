<!-- Modal -->
<div class="modal fade" id="modal_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Detail Order</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-response">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No Order</th>
                            <th>Barcode</th>
                            <th>Item Name</th>
                            <th>Qty Order</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($detail->result() as $data) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $data->no_order ?></td>
                                <td><?= $data->barcode ?></td>
                                <td><?= $data->item_name ?></td>
                                <td><?= $data->qty_order ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>