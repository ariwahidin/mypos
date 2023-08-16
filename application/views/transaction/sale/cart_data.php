<?php $no = 1;
if ($cart->num_rows() > 0) {
    foreach ($cart->result() as $c => $data) { ?>
        <tr>
            <td><?= $no++ ?></td>
            <td class="barcode"><?= $data->barcode ?></td>
            <td><?= $data->item_name ?></td>
            <td class="text-right"><?= number_format($data->cart_price) ?></td>
            <td class="text-right">
                <?php if ($data->discount_percent > 0) { ?>
                    <span class="text-green">
                        <?= "(" . $data->discount_percent . "%)" ?>
                    </span>
                <?php } ?>
                <?= number_format($data->discount_item) ?>
                &nbsp;
                <button style="display: none;" id="update_disc" data-toggle="modal" data-target="#modal_edit_disc" data-cartid="<?= $data->cart_id ?>" data-disc="<?= $data->discount_percent ?>" class="btn btn-xs btn-success">
                    <i class="fa fa-pencil"></i>
                </button>
            </td>
            <td class="text-center">
                <?= $data->qty ?>
                &nbsp;
                <button id="update_qty" data-toggle="modal" data-target="#modal_edit_qty" data-cartid="<?= $data->cart_id ?>" data-stock="<?= $data->stock ?>" data-qty="<?= $data->qty ?>" class="btn btn-xs btn-primary">
                    <i class="fa fa-pencil"></i>
                </button>
            </td>
            <td class="text-right total_item" id="total"><?= number_format($data->total) ?></td>
            <td class="text-right">
                <?= date('d-m-Y', strtotime($data->item_expired_2)) ?>
                &nbsp;
                <button style="display: none;" id="update_ed" data-toggle="modal" data-target="#modal_edit_ed" data-cartid="<?= $data->cart_id ?>" data-ed_ori="<?= date('d-m-Y', strtotime($data->item_expired)) ?>" data-ed="<?= date('d-m-Y', strtotime($data->item_expired_2)) ?>" class="btn btn-xs btn-warning">
                    <i class="fa fa-pencil"></i>
                </button>
            </td>
            <td class="text-center" width="100px">
                <!-- <button id="update_cart" data-toggle="modal" data-target="#modal-item-edit" 
                data-cartid="<?= $data->cart_id ?>" 
                data-barcode="<?= $data->barcode ?>" 
                data-product="<?= $data->item_name ?>" 
                data-stock="<?= $data->stock ?>" 
                data-price="<?= $data->cart_price ?>" 
                data-qty="<?= $data->qty ?>" 
                data-discount="<?= $data->discount_item ?>" 
                data-total="<?= $data->total ?>"
                data-expired="<?= date('d-m-Y', strtotime($data->item_expired)) ?>"
                class="btn btn-xs btn-primary">
                    <i class="fa fa-pencil"></i> Update
                </button> -->
                <button id="del_cart" data-cartid="<?= $data->cart_id ?>" class="btn btn-xs btn-danger">
                    <i class="fa fa-trash"></i> Delete
                </button>
            </td>
        </tr>
<?php }
} else {
    echo '<tr>
        <td colspan="8" class="text-center">Tidak ada item</td>
    </tr>';
}
?>