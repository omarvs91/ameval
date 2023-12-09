<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>.::Sistema de Lavanderia 1.0::.</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- SASS -->
    <link href="<?= base_url() ?>assets/custom_theme/style.css" rel="stylesheet">
</head>

<body class="login-page">
    <div class="container">
        <div class="login-container">
            <img class="img-fluid" src="<?= base_url() ?>assets/img/main_logo.jpeg">
            <form class="login-form" action="/authenticate" method="post">
                <div class="mb-3">
                    <input type="text" class="form-control" id="username" name="username" placeholder="USUARIO"
                        required>
                </div>
                <div class="mb-4">
                    <input type="password" class="form-control" id="password" name="password" placeholder="CONTRASEÑA"
                        required>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary login-button">ACCEDER</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <!-- CUSTOM JS -->
    <script type="text/javascript" src="<?= base_url() ?>assets/custom_theme/theme.js"></script>
</body>

</html>