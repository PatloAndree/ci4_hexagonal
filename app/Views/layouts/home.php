<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <h1>Bienvenido a la página de inicio</h1>
    <p>Contenido dinámico aquí, lo que quieras mostrar.</p>
<?= $this->endSection() ?>

<?= $this->section('extra_css') ?>
    <link rel="stylesheet" href="<?= base_url('css/home.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('extra_js') ?>
    <script src="<?= base_url('js/home.js') ?>"></script>
<?= $this->endSection() ?>
