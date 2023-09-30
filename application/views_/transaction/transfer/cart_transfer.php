<?php if ($item_cart->num_rows() > 0) { ?>
    <?php $no = 1;
    foreach ($item_cart->result() as $data) { ?>
        <tr>
            <td><?=$no++?></td>
            <td>
                <?=$data->barcode?>
            </td>
            <td>
                <?=$data->name?>
            </td>
            <td>
                <?=$data->qty?>
            </td>
            <td>
                <?=$data->exp_date?>
            </td>
            <td>
            &nbsp;
                <button id="update_qty" 
                data-toggle="modal" 
                data-target="#modal_edit" 
                data-cartid="<?= $data->id?>" 
                data-qty = "<?= $data->qty?>" 
                data-stock = "<?= $data->stock?>" 
                class="btn btn-xs btn-primary">
                    <i class="fa fa-pencil"></i> Edit
                </button>
                <button class="btn btn-danger btn-xs" id="delete_cart" 
                data-id_item_detail = "<?=$data->item_id_detail?>"
                data-cart_id = "<?=$data->id?>"
                >
                    Delete
                </button>
            </td>
        </tr>

<?php }
} ?>