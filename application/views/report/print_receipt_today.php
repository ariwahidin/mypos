<?php
if ($receipt->num_rows() < 1) {
    echo "Tidak ada data";
} else {
?>
    <html moznomarginboxes mozdisallowselectionprint>

    <head>
        <title>POS - Print Nota</title>
        <style type="text/css">
            html {
                font-family: Tahoma, Verdana, Segoe, sans-serif;
            }

            .content {
                width: 80mm;
                font-size: 12px;
                padding-right: 15px;
            }

            .title {
                text-align: center;
                font-size: 13px;
                padding-bottom: 5px;
                border-bottom: 1px dashed;
            }

            .head {
                margin-top: 5px;
                margin-bottom: 10px;
                padding-bottom: 10px;
                border-bottom: 1px solid;
            }

            table {
                width: 100%;
                font-size: 12px;
            }

            .thanks {
                margin-top: 10px;
                padding-top: 10px;
                text-align: center;
                border-top: 1px dashed;
            }

            @media print {
                @page {
                    width: 58mm;
                    margin: 0mm;
                }
            }
        </style>
    </head>

    <body onload="window.print(); window.onafterprint = function(event) { window.location.href = '<?= $_SERVER['HTTP_REFERER'] ?>'};">
        <?php for ($i = 0; $i < 1; $i++) { ?>
            <div class="content" style="margin-bottom:10px">
                <div class="title">
                    <img src="<?= base_url('assets/dist/img/DgChocoGallerys.png') ?>" alt="">
                    <br>
                    <b style="font-size:15pt"><?= $receipt->row()->nama_toko ?></b>
                    <br>
                    <span style="font-size:12pt"></span>
                </div>
                <div class="head">
                    <table cellspacing="0" cellpadding="0">
                        <tr>
                            <td>Lokasi : <?= $receipt->row()->toko_cabang ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Date : <?= date('d-m-Y', strtotime($receipt->row()->tanggal_transaksi)) ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Cashier : <?= $receipt->row()->username ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </div>
                <div class="transaction">
                    <table class="transaction-table" cellspacing="0" cellpadding="0">
                        <?php
                        $grand_total = 0;
                        foreach ($receipt->result() as $data) {
                            $grand_total += $data->total;
                        ?>

                            <tr>
                                <td style="width:165px; padding-top:8px !important;"><?= $data->item_name ?></td>
                                <td><?= $data->qty ?></td>
                                <td style="text-align:right; width:60px">
                                    <?= number_format($data->price) ?>
                                </td>
                                <td style="text-align:right;padding-left:10px !important; width:60px">
                                    <?php if ($data->discount_item > 0) {
                                        echo number_format($data->price * $data->qty);
                                    } else {
                                        echo number_format($data->total);
                                    }
                                    ?>
                                    &nbsp;
                                </td>
                            </tr>
                            <?php if ($data->discount_item > 0) { ?>
                                <tr>
                                    <td>Discount:</td>
                                    <td></td>
                                    <td colspan="" style="text-align:right"><?= number_format($data->discount_percent) ?>%</td>
                                    <td style="text-align:right; width:60px" ;"><?= '-' . number_format($data->discount_item) ?>&nbsp;</td>
                                </tr>
                        <?php }
                        } ?>
                        <tr>
                            <td colspan="4" style="border-bottom: 1px dashed;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="padding-top:5px"> GROSS TOTAL </td>
                            <td></td>
                            <td></td>
                            <td style="text-align:right; width:60px"><?= number_format($grand_total / $tax) ?></td>
                        </tr>
                        <tr>
                            <td> SERV&CHARGE </td>
                            <td></td>
                            <td></td>
                            <td style="text-align:right; padding-top:5px">
                                <?= number_format($receipt->row()->total_service) ?>
                            </td>
                        </tr>

                        <tr>
                            <td>DISCOUNT :</td>
                            <td colspan="2"></td>
                            <td style="text-align:right; padding-bottom:5px">
                                <?= number_format($receipt->row()->total_discount) ?>
                            </td>
                        </tr>
                        <tr>
                            <td>TAX</td>
                            <td></td>
                            <td></td>
                            <td style="text-align:right; width:60px"><?= number_format($grand_total - ($grand_total / $tax)) ?></td>
                        </tr>
                        <tr>
                            <td>Grand TOTAL : </td>
                            <td></td>
                            <td></td>
                            <td style="text-align:right; width:60px"><?= number_format($grand_total + ($receipt->row()->total_service) - ($receipt->row()->total_discount)) ?></td>
                        </tr>
                        <tr>
                            <td colspan="4" style="border-bottom: 1px dashed; padding-top:5px;"></td>
                        </tr>
                        <tr>
                            <td>Printed : <?= date('d-m-Y H:i:s', strtotime($this->db->query("select now() as now")->row()->now)) ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </div>
        <?php } ?>
    </body>

    </html>
<?php } ?>