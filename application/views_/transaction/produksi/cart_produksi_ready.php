<?php if ($item_cart->num_rows() > 0) { ?>
    <?php $no = 1;
    foreach ($item_cart->result() as $data) { ?>
        <tr>
            <td><?= $no++ ?></td>
            <td>
                <?= $data->barcode ?>
            </td>
            <td>
                <?= $data->name ?>
            </td>
            <td>
                <?= $data->qty ?>
            </td>
            <td>
                <?= $data->exp_date ?>
            </td>
            <td>
                &nbsp;
                <button id="btn_update" data-toggle="modal" data-target="#modal_edit" data-cartid="<?= $data->id ?>" data-qty="<?= $data->qty ?>" data-item_id="<?= $data->item_id ?>" class="btn btn-xs btn-primary">
                    <i class="fa fa-pencil"></i> Edit
                </button>
            </td>
        </tr>

<?php }
} ?>