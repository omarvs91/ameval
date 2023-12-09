<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>58mm</title>
    <link href="<?= base_url() ?>assets/bootstrap5/bootstrap.min.css" rel="stylesheet">
    <!-- Other styles -->
    <style>
        /* Additional styles if needed */
        /* Override Bootstrap styles or add custom styles */
        /* Adjust font sizes for smaller screens */

        @page {
            margin: 1.1rem;
        }

        body {
            font-size: 8px;
        }

        /* Adjust widths for tables, divs, or other elements */
        table {
            width: 100%;
            border-spacing: 0 10px;
            /* Add additional styling as needed */
        }

        /* Limit image width */
        img {
            max-width: 100%;
            height: auto;
            /* Additional styles as needed */
        }

        th {
            text-align: center;
            vertical-align: middle;
        }

        tbody tr {
            vertical-align: middle;
        }

        tbody tr td.td_right {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="container">
        <img class="img-fluid mb-2" src="<?= base_url() ?>assets/img/main_logo.jpeg">
        <h1 class="text-center">VJS LAUNDRY S.A.C.</h1>
        <div class="text-center">
            <p class="mt-0 mb-0 pb-0 pt-0">Av. Agustín de la Rosa Toro 318, San Luis 15021</p>
            <p>R.U.C. N° 20602340466</p>
        </div>
            <?php
                $comprobanteTypes = [
                    'B' => ['label' => 'BOLETA DE VENTA ELECTRÓNICA'],
                    'F' => ['label' => 'FACTURA DE VENTA ELECTRÓNICA'],
                    'N' => ['label' => 'NOTA DE VENTA ELECTRÓNICA']
                ];

                $tipoComprobante = $comprobante['tipo_comprobante'];

                if (array_key_exists($tipoComprobante, $comprobanteTypes)) {
                    $typeInfo = $comprobanteTypes[$tipoComprobante];
                    echo '<h3 class="fw-bolder text-center mb-3">';
                    echo $typeInfo['label'] . "<br>";
                    echo $comprobante['cod_comprobante'];
                    echo '</h3>';
            ?>
                <p class="mt-0 pt-0 mb-2 pb-0"><span class="fw-bold">FECHA Y HORA:</span>
                    <?= $comprobante['fecha'] ?>
                </p>
            <?php
                    if ($tipoComprobante === 'F') {
            ?>
                <p class="mt-0 pt-0 mb-2 pb-0"><span class="fw-bold">N° DE RUC:</span>
                    <?= $comprobante['num_ruc'] ?>
                </p>
                <p class="mt-0 pt-0 mb-2 pb-0"><span class="fw-bold">RAZON SOCIAL:</span>
                    <?= $comprobante['razon_social'] ?>
                </p>
            <?php
                    }
                } else {
                    echo 'Unknown type';
                }
            ?>
        <p class="mt-0 pt-0 mb-2 pb-0"><span class="fw-bold">CLIENTE:</span>
            <?= $comprobante['nombres'] ?>
        </p>
        <p class="mt-0 pt-0 mb-2 pb-0"><span class="fw-bold">DNI:</span>
            <?= $comprobante['dni'] ?>
        </p>
        <p class="mt-0 pt-0 mb-3 pb-0"><span class="fw-bold">DIRECCIÓN:</span>
            <?= $comprobante['direccion'] ?>
        </p>
        <h2 class="text-center fw-bolder">DETALLES</h2>
        <!-- Add other comprobante fields as needed... -->
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>SERVICIO</th>
                            <th>PESO x KG</th>
                            <th>COSTO x KG (S/.)</th>
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
                                <td class="td_servicio">
                                    <?= $detail['nom_servicio']; ?>
                                </td>
                                <td>
                                    <center>
                                        <?= $detail['peso_kg']; ?>
                                    </center>
                                </td>
                                <td class="td_right">
                                    <?= number_format($detail['costo_kilo'], 2); ?>
                                </td>
                                <td class="td_right">
                                    <?= number_format($costoTotal, 2); ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-5 mx-auto mb-3" style="width: 60%;">
                <br>
                <table class="table">
                    <tbody>
                        <tr>
                            <th style="text-align: right;">SUBTOTAL</th>
                            <td style="text-align: right;padding-left: 15px;">S/.
                                <?= number_format($total - $total * 0.18, 2); ?>
                            </td>
                        </tr>
                        <tr>
                            <th style="text-align: right;">IGV 18%</th>
                            <td style="text-align: right;padding-left: 15px;">S/.
                                <?= number_format($total * 0.18, 2); ?>
                            </td>
                        </tr>
                        <tr>
                            <th style="text-align: right;">TOTAL</th>
                            <td style="text-align: right;padding-left: 15px;">S/.
                                <?= number_format($total, 2); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-12 text-center">
                <h2 class="fw-bolder">¡Gracias por su preferencia!</h2>
            </div>
        </div>
    </div>
</body>

</html>