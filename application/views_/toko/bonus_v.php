<section class="content-header">
    <h1>
        Setting Bonus
    </h1>
</section>

<section class="content">
    <?php $this->view('messages') ?>
    <div class="box">
        <div class="box-header">
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped" id="">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Min Belanja</th>
                        <th>Start Periode</th>
                        <th>End Periode</th>
                        <th>Item Bonus</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($bonus->result() as $data) { ?>
                        <tr>
                            <td><?=$no;?></td>
                            <td><?=number_format($data->min_sales)?></td>
                            <td><?=date('d-m-Y', strtotime($data->start_periode))?></td>
                            <td><?=date('d-m-Y', strtotime($data->end_periode))?></td>
                            <td><?=$data->name?></td>
                            <td><?=$data->is_active == 'y' ? 'Aktif' : 'Tidak Aktif'?></td>
                            <td>
                                <button class="btn btn-primary btn-xs btn-flat" 
                                id="btn_edit"
                                data-toggle="modal" 
                                data-target="#modal_edit_bonus"
                                data-start_periode = "<?=date('d-m-Y', strtotime($data->start_periode))?>"
                                data-end_periode = "<?=date('d-m-Y', strtotime($data->end_periode))?>"
                                data-status="<?=$data->is_active?>"
                                data-item="<?=$data->item_code?>"
                                data-min_belanja="<?=$data->min_sales?>"
                                data-id="<?=$data->id_event?>"
                                >
                                Edit
                            </button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>


<!-- Modal Edit Bonus-->
<div class="modal flip" id="modal_edit_bonus">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"> Edit Bonus</h4>
            </div>

            <div class="modal-body">
                <form action="<?=base_url('bonus/edit')?>" method="post" id="form_edit">
                <div class="form-group">
                    <label for="">Minimal Belanja</label>
                    <input name="min_belanja" type="number" id="min_belanja" class="form-control">
                    <input name="id_event" type="hidden" id="id_event" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Item Bonus</label>
                    <select name="item_bonus" id="item_bonus" class="form-control">
                        <option value="">--Pilih--</option>
                        <?php foreach($item->result() as $res) {?>
                            <option value="<?=$res->item_code?>"><?=$res->name?></option>
                            <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Start Periode </label>
                            <input name="start_periode" type="text" id="start_periode" class="form-control" data-inputmask="'alias': 'date'">
                        </div>
                        <div class="col-md-6">
                            <label for="ed">End Periode</label>
                            <input name="end_periode" type="text" id="end_periode" data-inputmask="'alias': 'date'" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">--Pilih Status--</option>
                        <option value="y">Aktif</option>
                        <option value="n">Tidak Aktif</option>
                    </select>
                </div>
                </form>

            </div>
            <div class="modal-footer">
                <div class="pull-right">
                    <button type="button" id="btn_save_edit" class="btn btn-flat btn-success">
                        <i class="fa fa-paper-plane"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('transaction/sale/myjs') ?>
<script src="<?= base_url() ?>assets/myjs/input_mask.js"></script>
<script src="<?= base_url() ?>assets/myjs/myjs.js"></script>
<script>
    $(":input").inputmask();
    $(document).on('click', '#btn_edit', function(){
        var status = $(this).data('status')
        var start_periode = $(this).data('start_periode')
        var end_periode = $(this).data('end_periode')
        var min_belanja = $(this).data('min_belanja')
        var item = $(this).data('item')
        var id_event = $(this).data('id')
        $('#id_event').val(id_event)
        $('#item_bonus').val(item)
        $('#min_belanja').val(min_belanja)
        $('#start_periode').val(start_periode)
        $('#end_periode').val(end_periode)
        $('#status').val(status)
    })

    $(document).on('click', '#btn_save_edit', function(){
        var form = $('#form_edit')
        form.submit()
    })
</script>