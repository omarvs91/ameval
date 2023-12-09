<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>A4</title>

    <link rel="stylesheet" href="<?= base_url() ?>assets/bootstrap3/bootstrap.min.css">

    <style>
        .invoice-header {
            text-align: center;
            background: #dedede;
            border-radius: 10px;
            padding-bottom: 10px;
            padding-top: 5px;
            border: 1px solid #a8a8a8;
            margin-bottom: 1.5rem;
        }

        .invoice-title {
            font-size: 15px;
            font-weight: bold;
            line-height: 4px;
        }

        .invoice-table {
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .invoice-table th,
        .invoice-table td {
            border: 1px solid #ccc;
            padding: 5px;
        }

        .invoice-table th {
            background-color: #eee;
            text-align: center;
        }

        .invoice-notes {
            margin-top: 20px;
        }

        .comprobante-contact p {
            line-height: 1.25rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-xs-5">
                <img class="img-responsive" src="<?= base_url() ?>assets/img/main_logo.jpeg">
            </div>
            <div class="col-xs-5 col-xs-offset-1 invoice-header">
                <h2 class="invoice-title">R.U.C. N° 20602340466</h2>

                <?php
                $comprobanteTypes = [
                    'B' => ['label' => 'BOLETA DE VENTA ELECTRÓNICA'],
                    'F' => ['label' => 'FACTURA DE VENTA ELECTRÓNICA'],
                    'N' => ['label' => 'NOTA DE VENTA ELECTRÓNICA']
                ];
                $tipoComprobante = $comprobante['tipo_comprobante'];
                if (array_key_exists($tipoComprobante, $comprobanteTypes)) {
                    $typeInfo = $comprobanteTypes[$tipoComprobante];
                ?>
                <h2 class="invoice-title"><?=$typeInfo['label']?></h2>
                <h2 class="invoice-title"><?=$comprobante['cod_comprobante']?></h2>
                <?php
                } else {
                    echo 'Unknown type';
                }
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-5 comprobante-company-contact" style="padding-top: 1rem;">
                <p><b>VJS LAUNDRY S.A.C.<b></p>
                <p>Av. Agustín de la Rosa Toro 318, San Luis 15021</p>
                <p><b>Teléfono:</b> 913 027 176</p>
            </div>
            <div class="col-xs-5 col-xs-offset-1 comprobante-contact"
                style="border: 1px solid #a8a8a8;border-radius: 10px;padding-top: 1rem;margin-bottom: 2rem;">
                <p><b>Fecha emisión: </b>
                    <?= $comprobante['fecha'] ?>
                </p>
                <?php
                    if ($tipoComprobante === 'F') {
                ?>
                <p><b>N° DE RUC:</b>
                    <?= $comprobante['num_ruc'] ?>
                </p>
                <p><b>RAZON SOCIAL:</b>
                    <?= $comprobante['razon_social'] ?>
                </p>
                <?php
                    }
                ?>
                <p><b>Señor(a): </b>
                    <?= $comprobante['nombres'] ?>
                </p>
                <p><b>DNI: </b>
                    <?= $comprobante['dni'] ?>
                </p>
                <p><b>Dirección: </b>
                    <?= $comprobante['direccion'] ?>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table invoice-table">
                    <thead>
                        <tr>
                            <th>SERVICIO</th>
                            <th>PESO (KG)</th>
                            <th>COSTO POR KG (S/.)</th>
                            <th>TOTAL (S/.)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        foreach ($details as $detail) {
                            $costoTotal = $detail['peso_kg'] * $detail['costo_kilo'];
                            $total += $costoTotal;
                            ?>
                            <tr>
                                <td>
                                    <?= $detail['nom_servicio'] ?>
                                </td>
                                <td>
                                    <center>
                                        <?= $detail['peso_kg'] ?>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <?= number_format($detail['costo_kilo'], 2); ?>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <?= number_format($costoTotal, 2); ?>
                                    </center>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-2">
                <p>SUB TOTAL</p>
                <p>IG.V</p>
                <p><b>TOTAL</b></p>
            </div>
            <div class="col-xs-10">
                <p>S/. <?= number_format($total - $total * 0.18, 2); ?></p>
                <p>S/. <?= number_format($total * 0.18, 2); ?></p>
                <p><b>S/. <?= number_format($total, 2); ?></b></p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 invoice-notes">
                <p>¡Gracias por su preferencia!</p>
            </div>
        </div>
    </div>
</body>

</html>