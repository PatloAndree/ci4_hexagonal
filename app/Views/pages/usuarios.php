<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <h1>Usuarios</h1>
    <p>Listado de usuarios</p>
    <button id="btnNuevoUsuario" class="btn btn-success">Nuevo Usuario</button>
    <div class="table table-striped">
        <table class="table table-striped table-bordered w-100" id="tableUsers">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
              
            </tbody>
        </table>
    </div>


    <!-- modal aqui -->
    <div class="modal fade" id="modalUsuario" tabindex="-1" aria-labelledby="modalUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <form id="formUsuario">
                <div class="modal-header">
                <h5 class="modal-title" id="modalUsuarioLabel">Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                <input type="hidden" name="id" id="usuario_id">
                <div class="mb-3">
                    <label for="usuario_name" class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="name" id="usuario_name" required>
                </div>
                <div class="mb-3">
                    <label for="usuario_email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="usuario_email" required>
                </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" id="guardarUsuarioBtn">Guardar</button>
                </div>
            </form>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>

<?= $this->section('extra_js') ?>
<script>
   $(document).ready(function() {
    console.log("Cargando datatable usuarios...");

    // listar usuarios
    $('#tableUsers').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: "<?= site_url('pages/usuarios/list') ?>",
            type: "GET", 
            dataSrc: ""
        },
        columns: [
            { data: 'name' },
            { data: 'email' },
            { 
                data: null,  // si no tienes campo "acciones" en JSON
                render: function(data, type, row) {
                    // data es el objeto fila completo
                    return `
                        <button class="btn btn-primary btn-sm btnEditarUsuario" data-id="${row.id}">Editar</button>
                        <button class="btn btn-danger btn-sm btnEliminarUsuario" data-id="${row.id}">Eliminar</button>
                    `;
                },
                orderable: false,
                searchable: false
            }
        ]
    });

    // Editar usuario
    $('#btnNuevoUsuario').click(function() {
            $('#modalUsuarioLabel').text('Nuevo Usuario');
            $('#usuario_id').val('');
            $('#usuario_name').val('');
            $('#usuario_email').val('');
            $('#modalUsuario').modal('show');
    });

    // Función abrir modal para editar
    $(document).on('click', '.btnEditarUsuario', function() {
        var id = $(this).data('id');
        $.ajax({
        url: "<?= site_url('pages/usuarios/editar') ?>/" + id,  // la ruta que definimos
        type: "GET",
        success: function(resp) {
            if (resp.success) {
            $('#modalUsuarioLabel').text('Editar Usuario');
            $('#usuario_id').val(resp.data.id);
            $('#usuario_name').val(resp.data.name);
            $('#usuario_email').val(resp.data.email);
            $('#modalUsuario').modal('show');
            } else {
            alert(resp.message);
            }
        }
        });
    });

     // Guardar (crear o editar)
    $('#formUsuario').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
        url: "<?= site_url('pages/usuarios/guardar') ?>",
        type: "POST",
        data: formData,
        success: function(resp) {
            if (resp.success) {
            $('#modalUsuario').modal('hide');
            // recargar DataTable
            $('#tableUsers').DataTable().ajax.reload();
            } else {
            alert(resp.message);
            }
        }
        });
    });

    // Eliminar usuario (status = 0)
    $(document).on('click', '.btnEliminarUsuario', function() {
        if (!confirm('¿Estás seguro de eliminar este usuario?')) return;
        var id = $(this).data('id');
        $.ajax({
        url: "<?= site_url('pages/usuarios/eliminar') ?>",
        type: "POST",
        data: { id: id },
        success: function(resp) {
            if (resp.success) {
            // recargar DataTable
            $('#tableUsers').DataTable().ajax.reload();
            } else {
            alert(resp.message);
            }
        }
        });
    });



    });
</script>
<?= $this->endSection() ?>
