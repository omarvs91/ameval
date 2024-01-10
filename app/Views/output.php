<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SISTEMA DE OP</title>
    <link href="<?= base_url() ?>assets/bootstrap5/bootstrap.min.css" rel="stylesheet">
    <!-- SASS -->
    <link href="<?= base_url() ?>assets/custom_theme/style.css" rel="stylesheet">
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="d-flex flex-column min-vh-100 <?php echo isset($css_class) ? $css_class : ''; ?>">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">AMEVAL</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item dropdown hover-dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="registrarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            REGISTRAR
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="registrarDropdown">
                            <li><a class="dropdown-item" href="<?= base_url() ?>op/add">ORDEN DE PRODUCCION</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown hover-dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="consultarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            CONSULTAR / EDITAR
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="consultarDropdown">
                            <li><a class="dropdown-item" href="<?= base_url() ?>op">TODAS LAS OP</a></li>
                            <li><a class="dropdown-item" href="<?= base_url() ?>clientes">CLIENTES</a></li>

                            <li><a class="dropdown-item" href="<?= base_url() ?>empleados">EMPLEADOS</a></li>

                            <li><a class="dropdown-item" href="<?= base_url() ?>estados">ESTADOS DE OP</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown hover-dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="consultarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            OPCIONES AVANZADAS
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="consultarDropdown">
                            <li><a class="dropdown-item" href="<?= base_url() ?>users">USUARIOS DEL SISTEMA</a></li>
                            <li><a class="dropdown-item" href="<?= base_url() ?>roles">ROLES DE USUARIOS</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person"></i>
                            <?= session()->get('username') ?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item"
                                    href="<?= base_url() ?>change_password/edit/<?= session()->get('user_id') ?>">CAMBIAR
                                    CONTRASEÑA</a></li>
                            <li><a class="dropdown-item" href="<?= base_url() ?>logout">SALIR DEL SISTEMA</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="flex-fill">
        <div class="container mt-5 mb-5">
            <?php
            $uri = service('uri');
            $uri->setSilent();
            $segment1 = $uri->getSegment(1);
            $segment2 = $uri->getSegment(2);
            $regresar = '<h4 class="mt-5 text-center"><a class="regresar" href="' . base_url() . 'op">REGRESAR</a></h4>';

            $db = \Config\Database::connect();

            // Calculate the sum of the total field of the tables
            $sumQuery = $db->query("
                SELECT 
                COALESCE((SELECT SUM(total) FROM op_gastos_indirectos WHERE op_id = ?), 0) + 
                COALESCE((SELECT SUM(total) FROM op_mano_obra WHERE op_id = ?), 0) +
                COALESCE((SELECT SUM(total) FROM op_materiales WHERE op_id = ?), 0) AS total_sum
                ",
                [$segment2, $segment2, $segment2]
            );

            $sumResult = $sumQuery->getRowArray();

            $totalSum = $sumResult['total_sum'];

            // Get the costo_total field of the op table
            $costoQuery = $db->query("SELECT costo_total FROM op WHERE id = ?", $segment2);
            $costoResult = $costoQuery->getRowArray();
            if ($costoResult !== null && isset($costoResult['costo_total'])) {
                $costoTotal = $costoResult['costo_total'];
                // Subtract the costo_total from the total sum
                $result = $costoTotal - $totalSum;
            } else {
                $result = "Data not available";
            }

            if ($costoResult !== null && isset($costoTotal)) {
                $p_total = '<p class="mb-2"><b>PRESUPUESTO TOTAL DE OP:</b> S/. ' . number_format($costoTotal, 2, '.', ',') . '</p>';
                $p_restante = '<p class="mb-4"><b>PRESUPUESTO RESTANTE:</b> S/. ' . number_format($result, 2, '.', ',') . '</p>';
            } else {
                $p_total = '<p class="mb-2"><b>PRESUPUESTO TOTAL DE OP:</b> Data not available</p>';
                $p_restante = '<p class="mb-2"><b>PRESUPUESTO TOTAL DE OP:</b> Data not available</p>';
            }

            switch ($segment1) {
                case 'op_mano_obra':
                    // Code to be executed if $segment is 'value1'
                    echo '<h2 class="mb-2 d-inline-block pe-2">OP 0' . $segment2 . ': MANO DE OBRA</h2><span>(<a class="regresar" href="' . base_url() . 'op">REGRESAR</a>)</span>';
                    echo $p_total;
                    echo $p_restante;
                    echo $output;
                    echo $regresar;
                    break;
                case 'op_materiales':
                    // Code to be executed if $segment is 'value2'
                    echo '<h2 class="mb-4 d-inline-block pe-2">OP 0' . $segment2 . ': MATERIALES</h2><span>(<a class="regresar" href="' . base_url() . 'op">REGRESAR</a>)</span>';
                    echo $p_total;
                    echo $p_restante;
                    echo $output;
                    echo $regresar;
                    break;
                case 'op_gastos_indirectos':
                    // Code to be executed if $segment is 'value2'
                    echo '<h2 class="mb-4 d-inline-block pe-2">OP 0' . $segment2 . ': GASTOS INDIRECTOS</h2><span>(<a class="regresar" href="' . base_url() . 'op">REGRESAR</a>)</span>';
                    echo $p_total;
                    echo $p_restante;
                    echo $output;
                    echo $regresar;
                    break;
                case 'op':
                    echo '<h2 class="mb-4 d-inline-block pe-2">LISTA DE OPs</h2>';
                    echo $output;
                    break;
                case 'users':
                    echo '<h2 class="mb-4 d-inline-block pe-2">USUARIOS DEL SISTEMA</h2>';
                    echo $output;
                    break;
                case 'roles':
                    echo '<h2 class="mb-4 d-inline-block pe-2">ROLES DE USUARIOS</h2>';
                    echo $output;
                    break;
                case 'clientes':
                    echo '<h2 class="mb-4 d-inline-block pe-2">LISTA DE CLIENTES</h2>';
                    echo $output;
                    break;
                case 'empleados':
                    echo '<h2 class="mb-4 d-inline-block pe-2">LISTA DE EMPLEADOS</h2>';
                    echo $output;
                    break;
                case 'estados':
                    echo '<h2 class="mb-4 d-inline-block pe-2">LISTA DE ESTADOS DE OP</h2>';
                    echo $output;
                    break;
                default:
                    // Code to be executed if $segment is different from all labels
                    echo $output;
                    break;
            }
            ?>
        </div>
    </main>
    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4 footer">
        <div class="container">
            <p class="mt-4">SISTEMA DE OP 1.0</p>
        </div>
    </footer>
    <!-- JQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <!-- Grocery Crud js files -->
    <?php foreach ($js_files as $file): ?>
        <script src="<?php echo $file; ?>"></script>
    <?php endforeach; ?>
    <!-- CUSTOM JS -->
    <script type="text/javascript" src="<?= base_url() ?>assets/custom_theme/theme.js"></script>
</body>

</html>