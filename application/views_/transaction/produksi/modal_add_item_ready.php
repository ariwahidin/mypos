<!-- Modal Add Product Item -->
<div class="modal flip" id="modal-item">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Product Item</h4>
            </div>
            <div class="modal-body table-responsive">
                <table class="table table-bordered table-striped" id="table1xx">
                    <thead>
                        <tr>
                            <th>Barcode</th>
                            <th>Name</th>
                            <th>Stock</th>
                            <th>Exp Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($item->result() as $i => $data) { ?>
                            <tr>
                                <td><?= $data->barcode ?></td>
                                <td width="80%"><?= $data->name ?></td>
                                <td><?= $data->qty ?></td>
                                <td width="80%"><?= date('d-m-Y', strtotime($data->exp_date)) ?></td>
                                <td class="text-right">
                                    <button class="btn btn-xs btn-info select" id="select" data-item_id="<?= $data->item_id ?>" data-id_item_detail="<?= $data->id ?>" data-stock="<?= $data->qty ?>" data-exp_date="<?= $data->exp_date ?>">
                                        <i class="fa fa-check"></i> Select
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <script>
                $('#table1xx').DataTable()
            </script>
        </div>
    </div>
</div>