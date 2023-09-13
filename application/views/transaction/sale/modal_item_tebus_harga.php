<div class="modal flip" id="modal-item-tebus-harga">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="callout callout-success">
                    <h4 style="font-size: 26px;">Tebus murah aktif, tawarkan produk ini kepada pelanggan
                        <button style="display: inline; margin-left: 5px;" onclick="lanjutBayar()" class="btn btn-sm btn-primary pull-right">Lanjut bayar</button>
                        <button style="display: inline;" class="btn btn-sm btn-danger pull-right" data-dismiss="modal" aria-label="Close">Tutup</button>
                    </h4>
                    <!-- <p>Tawarkan product tebus murah kepada pelanggan</p> -->
                </div>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
                <!-- <h4 class="modal-title">Data item tebus harga</h4> -->
            </div>
            <div class="modal-body table-responsive">
                <table class="table table-bordered table-striped" id="table_item_tebus_harga">
                    <thead>
                        <tr>
                            <th>Barcode</th>
                            <th style="width: 100%">Name</th>
                            <th>Stock</th>
                            <th>Expired Date</th>
                            <th>Disc (%)</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="">
                        <?php foreach ($item->result() as $data) { ?>
                            <tr>
                                <td><?= $data->barcode ?></td>
                                <td style="width: 100%"><?= $data->item_name ?></td>
                                <td><?= $data->qty ?></td>
                                <td><?= date('d-m-Y', strtotime($data->exp_date)) ?></td>
                                <td><?= $data->discount ?></td>
                                <td>
                                    <button class="btn btn-sm btn-primary" id="select_item_tebus_harga" data-item_id="<?= $data->item_id ?>" data-id_item_detail="<?= $data->id_item_detail ?>" data-harga_jual="<?= $data->harga_jual ?>" data-stock="<?= $data->qty ?>" data-exp_date="<?= $data->exp_date ?>" data-discount="<?= $data->discount ?>" data-kode_promo="<?= $data->kode_promo ?>">
                                        Select
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#table_item_tebus_harga').DataTable()
    })

    function lanjutBayar(){
        $('#modal-item-tebus-harga').modal('hide')
        showConfirmPay()
    }
</script>