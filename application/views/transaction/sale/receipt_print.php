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
                <b style="font-size:15pt"><?= ucwords($toko->nama_toko) ?></b>
                <br>
                <span style="font-size:12pt"><?= ucwords($toko->toko_cabang) ?></span>
            </div>
            <div class="head">
                <table cellspacing="0" cellpadding="0">
                    <tr>
                        <td style="width:200px">
                            <?php
                            echo Date("d/m/Y", strtotime($sale->date)) . " " . Date("H:i", strtotime($sale->sale_created));
                            ?>
                        </td>
                        <td>Cashier</td>
                        <td style="text-align:center; width:10px">:</td>
                        <td style="text-align:right">
                            <?= ucfirst($sale->user_name) ?>&nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?= $sale->invoice ?>
                        </td>
                        <td>Customer</td>
                        <td style="text-align:center">:</td>
                        <td style="text-align:right">
                            <?= $sale->customer_id == null ? "Umum" : $sale->customer_name ?>&nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            Printed : <?= indo_date_time() ?> <?= $sale->printed > 1 ? '(copy)' : '' ?>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="transaction">
                <table class="transaction-table" cellspacing="0" cellpadding="0">
                    <?php
                    $arr_discount = array();
                    $total_discount_item = 0;
                    $total_before_discount = 0 + $sale->service;
                    foreach ($sale_detail as $key => $value) {
                        $total_discount_item += $value->discount_item;
                        $total_before_discount +=  ($value->price * $value->qty);
                    ?>
                        <tr>
                            <td style="width:165px; padding-top:8px !important;"><?= $value->name ?></td>
                            <td><?= $value->qty ?></td>
                            <td style="text-align:right; width:60px">
                                <?= number_format($value->price) ?>
                            </td>
                            <td style="text-align:right;padding-left:10px !important; width:60px">
                                <?php if ($value->discount_item > 0) {
                                    echo number_format($value->price * $value->qty);
                                } else {
                                    echo number_format($value->total);
                                }
                                ?>
                                &nbsp;
                            </td>
                        </tr>
                        <?php if ($value->discount_item > 0) { ?>
                            <tr>
                                <td></td>
                                <td colspan="" style="text-align:right"></td>
                                <td></td>
                                <td style="text-align:right; width:60px" ;"><?= '-' . number_format($value->discount_item) ?>&nbsp;</td>
                            </tr>
                    <?php }
                    } ?>
                    <tr>
                        <td style="padding-top:5px">Service</td>
                        <td colspan="2"></td>
                        <td style="text-align:right; padding-top:5px">
                            <?= number_format($sale->service) ?>&nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="border-bottom: 1px dashed;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding-top:5px"> Total Item </td>
                        <td colspan="2"><?= get_total_item($sale_id) ?></td>
                        <td style="text-align:right; padding-top:5px">
                            &nbsp;<?= number_format($total_before_discount) ?>&nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top:5px"> Disc. Item </td>
                        <td colspan="2"></td>
                        <td style="text-align:right; padding-top:5px">
                            &nbsp;<?= '-'.number_format($total_discount_item) ?>&nbsp;
                        </td>
                    </tr>
                    <?php if ($sale->discount > 0) { ?>
                        <tr style="padding-top: 5px">
                            <td>Disc. Sale</td>
                            <td colspan="2"></td>
                            <td style="text-align:right; padding-bottom:5px">
                                <?= '-' . number_format($sale->discount) ?>&nbsp;
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="4" style="border-bottom: 1px dashed; padding-top:5px;"></td>
                    </tr>
                    <tr>
                        <td style="padding-bottom:5px;">Grand Total</td>
                        <td colspan="2"></td>
                        <td style="text-align:right;">
                            <?= number_format($sale->final_price) ?>&nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="border-bottom: 1px dashed; padding-top:5px;"></td>
                    </tr>
                    <tr>
                        <td style="padding-top:5px 0"><?= ucfirst(type_bayar($sale->type_bayar)) ?></td>
                        <td colspan="2"></td>
                        <td style="text-align:right; padding-top:5px">
                            <?= number_format($sale->cash) ?>&nbsp;
                        </td>
                    </tr>
                    <td>Kembalian</td>
                    <td colspan="2"></td>
                    <td style="text-align:right">
                        <?= number_format($sale->remaining) ?>&nbsp;
                    </td>
                    </tr>
                    <tr>
                        <td style="padding-bottom:5px">Harga termasuk PPN</td>
                        <td colspan="2"></td>
                        <td>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="thanks">
                ---Thank You---
                <!-- <br>
            Pandurasa Kharisma -->
            </div>
        </div>
    <?php } ?>
</body>

</html>