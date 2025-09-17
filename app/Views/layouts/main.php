<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= isset($title) ? $title : 'Mi sitio' ?></title>
    <!-- Aquí podrías incluir CSS generales -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.css" rel="stylesheet">

    <!-- <link rel="stylesheet" href="<?= base_url('css/app.css') ?>"> -->
    <?= $this->renderSection('extra_css') ?>
</head>
<body>
    <!-- Header común -->
    <?= $this->include('left/header') ?>

    <main class="container mt-4">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer común -->
    <?= $this->include('left/footer') ?>

    <!-- Scripts generales -->
    <!-- <script src="<?= base_url('js/app.js') ?>"></script> -->
        <!-- LIBRERIAS JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.min.js"></script>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.16.1/sweetalert2.all.min.js"></script>
    <?= $this->renderSection('extra_js') ?>
</body>
</html>
