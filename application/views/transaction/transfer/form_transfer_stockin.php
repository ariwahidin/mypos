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
                                    <input type="text" name="whs_code" class="form-control">
                                    <input type="hidden" name="cari">
                                </div>
                                <div class="col-md-4">
                                    <label for="">Docnum:</label>
                                    <input type="text" name="docnum" class="form-control">
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
                                <th>Barcode</th>
                                <th>Desc</th>
                                <th>Qty</th>
                                <th>Exp Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="cart_tranfer">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>