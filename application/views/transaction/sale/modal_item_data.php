<div class="modal flip" id="modal-item-found">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Item product</h4>
                <!-- <?php if ($item->num_rows() > 0) { ?>
                    <?php if ($item->row()->kode_promo != null) { ?>
                        <span style="font-size: 16px;" class="label bg-green">Item ini sedang ada promo <?= $item->row()->nama_promo ?></span>
                    <?php } else { ?>
                        <h4 class="modal-title">Item</h4>
                    <?php } ?>
                <?php } ?> -->
            </div>
            <div class="modal-body table-responsive">
                <?php if ($item->num_rows() > 0) { ?>
                    <!-- <?php var_dump($item->result()) ?> -->
                    <style>
                        /* CSS untuk mengatur warna latar belakang tombol ketika dalam fokus */
                        .myButton:focus {
                            background-color: green;
                        }
                    </style>
                    <table class="table table-bordered table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>Barcode</th>
                                <th>Name</th>
                                <th>Stock</th>
                                <th>Exp date</th>
                                <th>Disc(%)</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($item->result() as $data) { ?>
                                <tr>
                                    <td><?= $data->barcode ?></td>
                                    <td style="width: 60%"><?= $data->item_name ?>
                                        <?php
                                        $promo = get_nama_promo($data->item_code, $data->exp_date);
                                        if ($promo->num_rows() > 0) { ?>
                                            <span style="margin-left: 5px;" class="label bg-green"><?= $promo->row()->nama_promo ?></span>
                                        <?php } ?>
                                    </td>
                                    <td style="text-align: right;"><?= $data->qty ?></td>
                                    <td style="width: 12%; text-align: right;"><?= date('d-m-Y', strtotime($data->exp_date)) ?></td>
                                    <td style="text-align: right;"><?= $data->discount ?></td>
                                    <td style="width: 15%">
                                        <button style="display: inline;" class="btn btn-xs btn-info myButton" id="item_found_select" data-item_id="<?= $data->item_id ?>" data-id_item_detail="<?= $data->id ?>" data-harga_jual="<?= $data->harga_jual ?>" data_stock="<?= $data->qty ?>" data-exp_date="<?= $data->exp_date ?>" data-discount="<?= $data->discount ?>" data-kode_promo="<?= $data->kode_promo ?>">
                                            <i class="fa fa-plus"></i> &nbsp;Add
                                        </button>
                                        <!-- <?php if (!is_null($data->kode_promo)) { ?>
                                            <button style="display: inline;" class="btn-success btn btn-xs">get promo</button>
                                        <?php } ?> -->
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <script>
                        $('#table1').DataTable()
                        // $(document).ready(function() {
                        //     // Menaruh fokus awal pada button pertama dengan kelas "myButton"
                        //     $("#item_found_select").focus();

                        //     // Menggunakan event keydown untuk mendeteksi tombol panah
                        //     $(document).keydown(function(e) {
                        //         if (e.keyCode == 40) { // Tombol panah bawah
                        //             var focusedButton = $(".myButton:focus");
                        //             var nextButton = focusedButton.next(".myButton");
                        //             if (nextButton.length > 0) {
                        //                 nextButton.focus();
                        //             }
                        //             // alert('panah bawah')
                        //             // $("#item_found_select").focus();
                        //         } else if (e.keyCode == 38) { // Tombol panah atas
                        //             var focusedButton = $(".myButton:focus");
                        //             var prevButton = focusedButton.prev(".myButton");
                        //             if (prevButton.length > 0) {
                        //                 prevButton.focus();
                        //             }
                        //         }
                        //     });
                        // });
                    </script>
                    <script>
                        $(document).ready(function() {
                            var buttons = $(".myButton"); // Ambil semua tombol dengan kelas "myButton"
                            var currentIndex = -1; // Inisialisasi indeks saat ini

                            // Fungsi untuk mengatur fokus ke tombol dengan indeks tertentu
                            function setFocus(index) {
                                if (index >= 0 && index < buttons.length) {
                                    buttons.eq(index).focus();
                                    currentIndex = index;
                                }
                            }

                            // Menaruh fokus awal pada button pertama dengan kelas "myButton"
                            setFocus(0);

                            // Menggunakan event keydown untuk mendeteksi tombol panah
                            $(document).keydown(function(e) {
                                if (e.keyCode == 40) { // Tombol panah bawah
                                    setFocus(currentIndex + 1); // Pindahkan fokus ke tombol berikutnya
                                } else if (e.keyCode == 38) { // Tombol panah atas
                                    setFocus(currentIndex - 1); // Pindahkan fokus ke tombol sebelumnya
                                }
                            });
                        });
                    </script>
                    <script>
                        $('#modal-item-found').on('hidden.bs.modal', function() {
                            $('#barcode').focus()
                        });
                    </script>
                <?php } else { ?>
                    <p>Item tidak ditemukan</p>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<script>

</script>