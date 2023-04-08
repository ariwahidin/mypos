<section class="content-header">
    <h1>
        Stock In
    </h1>
</section>

<section class="content">
    <?php $this->view('messages') ?>
    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-body">
                    <form action="" method="POST">
                        <table class="table table-bordered">
                            <tr>
                                <th>Whs Code</th>
                                <th>Docnum</th>
                                <th>Action</th>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="whs_code" value="<?= $whs_code ?>" class="form-control" placeholder="Whs Code" required readonly>
                                </td>
                                <td>
                                    <input type="number" name="surat_jalan" value="<?= empty($_SESSION['surat_jalan']) == true ? $input_search['surat_jalan'] : $_SESSION['surat_jalan'] ?>" class="form-control" class="form-control" placeholder="No Surat Jalan" required>
                                </td>
                                <td>
                                    <button onclick="showLoading()" class="btn btn-flat btn-primary btn-block">Cari</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php if ($result->kode > 0) { ?>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <?php if ($result->kode == 1) { ?>
                            <form action="<?= base_url('stock/proccess_stock_in') ?>" method="POST" id="form_stock_in">
                                <?php foreach ($result->data as $data_input) { ?>
                                    <input type="hidden" name="whs_code[]" value="<?= $data_input->whs_code ?>">
                                    <input type="hidden" name="docnum[]" value="<?= $data_input->docnum ?>">
                                    <input type="hidden" name="item_code[]" value="<?= $data_input->item_code ?>">
                                    <input type="hidden" name="barcode[]" value="<?= $data_input->barcode ?>">
                                    <input type="hidden" name="item_name[]" value="<?= $data_input->description ?>">
                                    <input type="hidden" name="qty_ed[]" value="<?= (int)$data_input->qty_ed ?>">
                                    <input type="hidden" name="exp_date[]" value="<?= $data_input->exp_date ?>">
                                <?php } ?>
                                <button type="button" id="btn_stock_in" class="btn btn-flat btn-primary btn-flat pull-right">Stock In</button>
                            </form>
                        <?php } ?>
                    </div>
                    <div class="box-body table-responsive">

                        <table class="table table-bordered table-striped" id="table1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <td>Whs Code</td>
                                    <td>Surat Jalan</td>
                                    <td>Item Code</td>
                                    <th>Barcode</th>
                                    <th>Description</th>
                                    <th>Qty ED</th>
                                    <th>Exp Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->kode == 1) {
                                    $no = 1;
                                    foreach ($result->data as $data) { ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $data->whs_code ?></td>
                                            <td><?= $data->docnum ?></td>
                                            <td><?= $data->item_code ?></td>
                                            <td><?= $data->barcode ?></td>
                                            <td><?= $data->description ?></td>
                                            <td><?= (int)$data->qty_ed ?></td>
                                            <td><?= date('d-m-Y', strtotime($data->exp_date)) ?></td>
                                        </tr>
                                <?php }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="row">
            <div class="col-md-12">
                <p>Tidak Ada Data</p>
            </div>
        </div>
    <?php } ?>
</section>
<script>
    var btn_stock_in = document.getElementById("btn_stock_in");
    var form_stock_in = document.getElementById("form_stock_in");
    btn_stock_in.addEventListener("click", function() {
        // if (confirm("Yakin akan melakukan Stock In?")) {
        //     showLoading();
        //     form_stock_in.submit();
        // } else {
        //     // the user clicked Cancel, so do nothing
        // }

        Swal.fire({
            title: 'Apakah anda yakin akan melakukan stock in?',
            // text: "You won't be able to revert this!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, yakin!'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoading();
                form_stock_in.submit();
            }
        })

    })
</script>