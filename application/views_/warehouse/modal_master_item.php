<div class="modal fade" id="modal-master-item">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Master Item In PK</h4>
            </div>
            <div class="modal-body table-responsive table-bordered">
                <table class="table" id="table_master_item">
                    <thead>
                        <tr>
                            <th>Item Code</th>
                            <th>Barcode</th>
                            <th>Item Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <body>
                        <?php foreach ($item->data as $data) { ?>
                            <tr>
                                <td><?=$data->ItemCode?></td>
                                <td><?=$data->FrgnName?></td>
                                <td width="100%"><?=$data->ItemName?></td>
                                <td>
                                    <button id="btn-add-item" class="btn btn-primary btn-flat btn-sm" 
                                        data-item-code="<?=$data->ItemCode?>"
                                        data-barcode="<?=$data->FrgnName?>"
                                        data-brand-code="<?=$data->ItmsGrpCod?>"
                                        >
                                        Add</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </body>
                </table>
            </div>
        </div>
    </div>
</div>