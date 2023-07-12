<?php $no = 1;
foreach ($item->result() as $itm => $data) { ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $data->barcode ?></td>
        <td><?= $data->name ?></td>
        <td><?= number_format($data->price) ?></td>
        <td><?= $data->stock ?></td>
        <td>
            <button class="btn btn-primary btn-flat btn-xs" 
            id="select" 
            data-toggle="modal" 
            data-target="#modal-stock-in" 
            data-id="<?= $data->item_id ?>" 
            data-barcode="<?= $data->barcode ?>" 
            data-name="<?= $data->name ?>" 
            data-unit="<?= $data->unit_name ?>"
            data-stock="<?= $data->stock ?>">
                <i class="fa fa-plus"></i> Stock In
            </button>
            <button class="btn btn-warning btn-flat btn-xs"
            id="select_out"
            data-toggle="modal" 
            data-target="#modal-stock-out"
            data-id_out="<?=$data->item_id?>"
            data-barcode_out="<?=$data->barcode?>"
            data-name_out="<?=$data->name?>"
            data-unit_out="<?=$data->unit_name?>"
            data-stock_out="<?=$data->stock?>">
                <i class="fa fa-minus"></i> Stock Out
            </button>
        </td>
    </tr>
<?php } ?>