<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>.::Sistema de Lavanderia 1.0::.</title>
    <link href="<?=base_url()?>assets/bootstrap5/bootstrap.min.css" rel="stylesheet">
    <?php
    foreach ($css_files as $file): ?>
        <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
    <?php endforeach; ?>
    <!-- SASS -->
    <link href="<?= base_url() ?>assets/custom_theme/style.css" rel="stylesheet">
    <!-- Select2 styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <!-- Select2 bootstrap theme -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="d-flex flex-column min-vh-100 <?php echo isset($css_class) ? $css_class : ''; ?>">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">LAVANDERIA VJS
                <?php if (session()->get('role_id') == 1)
                    echo ' (Admin)'; ?>
            </a>
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
                            <li><a class="dropdown-item" href="<?= base_url() ?>registrar_comprobante">COMPROBANTE</a>
                            </li>
                            <li><a class="dropdown-item" href="<?= base_url() ?>clientes/add">CLIENTE</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown hover-dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="consultarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            CONSULTAR
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="consultarDropdown">
                            <li><a class="dropdown-item" href="<?= base_url() ?>comprobantes">COMPROBANTES TODOS</a></li>
                            <li><a class="dropdown-item" href="<?= base_url() ?>comprobantes_en_curso">COMPROBANTES EN CURSO</a></li>
                            <li><a class="dropdown-item" href="<?= base_url() ?>comprobantes_pagados">COMPROBANTES PAGADOS</a></li>
                            <li><a class="dropdown-item" href="<?= base_url() ?>comprobantes_pendiente_pago">COMPROBANTES PENDIENTE DE PAGO</a></li>
                            <li><a class="dropdown-item" href="<?= base_url() ?>comprobantes_recojo">COMPROBANTES PARA RECOJO</a></li>
                            <li><a class="dropdown-item" href="<?= base_url() ?>clientes">CLIENTES</a></li>
                        </ul>
                    </li>
                    <?php if (session()->get('role_id') == 1) { ?>
                        <li class="nav-item dropdown hover-dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="consultarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                OPCIONES AVANZADAS
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="consultarDropdown">
                                <li><a class="dropdown-item" href="<?= base_url() ?>estado_comprobantes">ESTADO COMPROBANTES</a></li>
                                <li><a class="dropdown-item" href="<?= base_url() ?>estado_ropa">ESTADO ROPA</a></li>
                                <li><a class="dropdown-item" href="<?= base_url() ?>locales">LOCALES</a></li>
                                <li><a class="dropdown-item" href="<?= base_url() ?>metodo_pago">MÉTODOS DE PAGO</a></li>
                                <li><a class="dropdown-item" href="<?= base_url() ?>roles">ROLES</a></li>
                                <li><a class="dropdown-item" href="<?= base_url() ?>servicios">SERVICIOS</a></li>
                                <li><a class="dropdown-item" href="<?= base_url() ?>users">USUARIOS</a></li>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() ?>logout">Cerrar Sesion</a>
                    </li>
                </ul>
            </div>
            <!-- Bootstrap modal structure -->
            <div class="modal" id="printModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-fullscreen" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Vista de Impresion</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link active" id="nav-58mm-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-58mm" type="button" role="tab" aria-controls="nav-58mm"
                                        aria-selected="true">58MM</button>
                                    <button class="nav-link" id="nav-a4-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-a4" type="button" role="tab" aria-controls="nav-a4"
                                        aria-selected="false">A4</button>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-58mm" role="tabpanel"
                                    aria-labelledby="nav-58mm-tab" tabindex="0">
                                    <iframe id="printIframe" width="100%" height="100%" frameborder="0"></iframe>
                                </div>
                                <div class="tab-pane fade" id="nav-a4" role="tabpanel" aria-labelledby="nav-a4-tab"
                                    tabindex="0">
                                    <iframe id="printIframe2" width="100%" height="100%" frameborder="0"></iframe>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <main class="flex-fill">
        <div class="container mt-5 mb-5">
            <?php echo $output; ?>
        </div>
    </main>
    <!-- Footer -->
    <footer class="bg-light text-center py-4 footer">
        <div class="container">
            <p class="mt-4">Sistema de Lavanderia 1.0</p>
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
    <!-- Select2 CSS and JS files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- CUSTOM JS -->
    <script type="text/javascript" src="<?= base_url() ?>assets/custom_theme/theme.js"></script>
</body>

</html>