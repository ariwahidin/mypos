<?php $no = 1;
foreach ($response->data as $data) { ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $data->item_code ?></td>
        <td><?= $data->barcode ?></td>
        <td><?= $data->item_name ?></td>
        <td><?= number_format($data->harga_jual) ?></td>
        <td><?= number_format($data->harga_bersih) ?></td>
        <td><?= number_format($data->harga_ppn) ?></td>
        <td><?= $data->percent_ppn ?> %</td>
        <td>
            <button class="btn btn-flat btn-primary" id="btn_update" data-toggle="modal" data-target="#modal-update-harga" data-id="<?= $data->id ?>" data-item_code="<?= $data->item_code ?>" data-barcode="<?= $data->barcode ?>" data-item_name="<?= $data->item_name ?>" data-harga_jual="<?= $data->harga_jual ?>" data-harga_bersih="<?= $data->harga_bersih ?>" data-harga_ppn="<?= $data->harga_ppn ?>" data-percent_ppn="<?= $data->percent_ppn ?>">
                Update Harga
            </button>
        </td>
    </tr>
<?php } ?>