<table class="table table-bordered table-striped" id="table1xx">
    <thead>
        <tr>
            <th>#</th>
            <th>Barcode</th>
            <th>Name</th>
            <th>Stock</th>
            <th>Min Stock</th>
            <th>Qty Order</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        foreach ($cart_order->result() as $cart) { ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $cart->barcode ?></td>
                <td><?= $cart->item_name ?></td>
                <td><?= $cart->stock ?></td>
                <td><?= $cart->min_stock ?></td>
                <td><?= $cart->qty_order ?></td>
                <td>
                    <button class="btn btn-danger btn-xs" id="btn_delete" data-id="<?= $cart->id ?>">Delete</button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>