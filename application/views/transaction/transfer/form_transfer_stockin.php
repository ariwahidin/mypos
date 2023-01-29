<section class="content-header">
    <h1>
        Transfer Stock In
    </h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-header"></div>
                <div class="box-body">
                    <form action="" method="post">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="">Whs Code:</label>
                                    <input type="text" name="whs_code" class="form-control" value="<?= isset($whs_code) ? $whs_code : '' ?>">
                                    <input type="hidden" name="cari">
                                </div>
                                <div class="col-md-4">
                                    <label for="">Docnum:</label>
                                    <input type="text" name="docnum" class="form-control" value="<?= isset($docnum) ? $docnum : '' ?>">
                                </div>
                                <div class="col-md-4">
                                    <br>
                                    <button class="btn btn-primary btn-flat" style="margin-top:5px">Cari</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php $this->load->view('messages') ?>
            <div class="box">
                <div class="box-header">
                    <!-- <button type="button" class="btn btn-flat btn-primary" data-toggle="modal" data-target="#modal-item">Daftar Item</button> -->
                    <button type="button" id="btn_proccess" class="btn btn-flat btn-success pull-right">Process Transfer Stock In</button>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Docnum</th>
                                <th>Barcode</th>
                                <th>Desc</th>
                                <th>Qty</th>
                                <th>Exp Date</th>
                            </tr>
                        </thead>
                        <tbody id="cart_tranfer">
                            <?php if ($item->num_rows() > 0) { ?>
                                <?php $no = 1;
                                foreach ($item->result() as $data) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $data->docnum ?></td>
                                        <td><?= $data->barcode ?></td>
                                        <td><?= $data->item_code ?></td>
                                        <td><?= $data->qty ?></td>
                                        <td><?= $data->exp_date ?></td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="6" style="text-align:center">Tidak Ada Data</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>