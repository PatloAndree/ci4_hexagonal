<?= $this->extend('layouts/main') ?>

<?= $this->section('extra_css') ?>
    <!-- CSS específico para esta página Vehículos -->
    <link href="<?= base_url('css/vehiculos.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <h1>Vehículos</h1>
    <p>Esta es la página de gestión de vehículos.</p>
    <!-- Ejemplo de contenido dinámico -->
    <ul>
        <li>Vehículo A</li>
        <li>Vehículo B</li>
        <li>Vehículo C</li>
    </ul>
    <div class="table-responsive mt-4">
        <table class="table table-bordered" id="tablaVehiculos">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Año</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Toyota</td>
                    <td>Corolla</td>
                    <td>2020</td>
                    <td><a href="#" class="btn btn-sm btn-primary">Ver</a></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Honda</td>
                    <td>Civic</td>
                    <td>2019</td>
                    <td><a href="#" class="btn btn-sm btn-primary">Ver</a></td>
                </tr>
            </tbody>
        </table>
    </div>
<?= $this->endSection() ?>

<?= $this->section('extra_js') ?>
<script>
   $(document).ready(function() {
    $('#tablaVehiculos').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?= site_url('vehiculos/ajaxList') ?>",
            type: "POST", 
            data: function (d) {
                // si tienes CSRF, puede que necesites enviar el token
                d.<?= csrf_token() ?> = "<?= csrf_hash() ?>";
            }
        },
        columns: [
            { data: 'id' },
            { data: 'marca' },
            { data: 'modelo' },
            { data: 'anio' },
            { data: 'acciones', orderable: false, searchable: false }
        ]
    });
    });
</script>
<?= $this->endSection() ?>
