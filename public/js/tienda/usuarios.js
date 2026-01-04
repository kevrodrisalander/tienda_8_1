let verEliminados = false;

$(document).ready(function () {
    const formToken = $('meta[name="csrf-token"]').attr("content");


    // DataTable Usuarios
    const tabla = $("#tbl_usuarios").DataTable({
        language: { url: "es-MX.json" },
        pageLength: 10,
        processing: true,
        serverSide: false,
        ajax: {
            url: "/usuarios/consulta",
            type: "GET",
            headers: { "X-CSRF-TOKEN": formToken },
            data: function (d) {
                d.eliminados = verEliminados ? 1 : 0;
                d.usuario = $('#filtro_usuario').val();
                d.correo  = $('#filtro_correo').val();
                d.rol     = $('#filtro_rol').val();
            }
        },
        columns: [
            { data: "usuario" },
            { data: "correo" },
            { data: "id_rol" },
            { data: "nombre_rol" },
            { data: "descripcion_rol" },
            {
                data: null,
                className: "text-center",
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    if (row.activo == 1) {
                        return `
                            <a href="#" class="btn btn-sm editar-usuario" data-id="${row.id}">✏️</a>
                            <a href="#" class="btn btn-sm desactivar-usuario" data-id="${row.id}">🗑️</a>
                        `;
                    } else {
                        return `
                            <a href="#" class="btn btn-sm restaurar-usuario" data-id="${row.id}">♻️</a>
                        `;
                    }
                }
            }
        ]
    });

  //Cargar roles

    let rolesCargados = false;

function cargarRolesFiltro() {
    if (rolesCargados) return; // evita doble petición

    $.get("/roles", function (roles) {
        const select = $("#filtro_rol");

        select.empty();
        select.append('<option value="">Todos los roles</option>');

        roles.forEach(function (rol) {
            select.append(
                `<option value="${rol.id_rol}">${rol.nombre}</option>`
            );
        });

        // Inicializar Select2 SOLO una vez

        rolesCargados = true; //marca como cargado
    });
}

$('#modalFiltrosUsuarios').one('shown.bs.modal', function () {
    cargarRolesFiltro();
});




    // Editar usuario
    $("#tbl_usuarios").on("click", ".editar-usuario", function (e) {
        e.preventDefault();
        const id = $(this).data("id");

        $.get(`/usuarios/${id}`, function (usuario) {
            $("#usuarioId").val(usuario.id);
            $("#usuario").val(usuario.usuario);
            $("#correo").val(usuario.correo);

            $.get("/roles", function (roles) {
                const select = $("#id_rol");
                select.empty();
                select.append('<option value="">Selecciona un rol</option>');

                roles.forEach(function (rol) {
                    const selected = rol.id_rol == usuario.id_rol ? "selected" : "";
                    select.append(
                        `<option value="${rol.id_rol}" ${selected}>${rol.nombre}</option>`
                    );
                });

                const modal = new bootstrap.Modal(
                    document.getElementById("modalEditarUsuario")
                );
                modal.show();
            });
        });
    });


    // Guardar edición

    $("#formEditarUsuario").on("submit", function (e) {
        e.preventDefault();
        const id = $("#usuarioId").val();

        $.ajax({
            url: `/usuarios/${id}`,
            type: "PUT",
            headers: { "X-CSRF-TOKEN": formToken },
            data: {
                usuario: $("#usuario").val(),
                correo: $("#correo").val(),
                id_rol: $("#id_rol").val()
            },
            success: function () {
                Swal.fire("Éxito", "Usuario actualizado correctamente", "success");
                tabla.ajax.reload();

                const modal = bootstrap.Modal.getInstance(
                    document.getElementById("modalEditarUsuario")
                );
                modal.hide();
            },
            error: function () {
                Swal.fire("Error", "No se pudo actualizar el usuario", "error");
            }
        });
    });


    // Ver eliminados

    $("#btnVerUsuariosEliminados").on("click", function () {
        verEliminados = !verEliminados;
        $(this).text(verEliminados ? "Ver activos" : "Ver eliminados");
        tabla.ajax.reload();
    });

    // Filtros
    $("#btnAplicarFiltros").on("click", function () {
        verEliminados = false;
        $("#btnVerUsuariosEliminados").text("Ver eliminados");
        tabla.ajax.reload();
        $("#modalFiltrosUsuarios").modal("hide");
    });

    $("#btnLimpiarFiltros").on("click", function () {
        $("#formFiltrosUsuarios")[0].reset();
        $('#filtro_rol').val(null).trigger('change');
        verEliminados = false;
        $("#btnVerUsuariosEliminados").text("Ver eliminados");
        tabla.ajax.reload();
    });


    const modalNuevoUsuario = document.getElementById('modalNuevoUsuario');
const selectRolNuevo = document.getElementById('nuevo_id_rol');

modalNuevoUsuario.addEventListener('show.bs.modal', () => {
    cargarRolesNuevo();
});

function cargarRolesNuevo() {
    selectRolNuevo.innerHTML = '<option value="">Cargando...</option>';

    fetch('/roles')
        .then(res => res.json())
        .then(data => {
            selectRolNuevo.innerHTML =
                '<option value="">Selecciona un rol</option>';

            data.forEach(rol => {
                selectRolNuevo.innerHTML += `
                    <option value="${rol.id}">
                        ${rol.nombre}
                    </option>`;
            });
        })
        .catch(() => {
            selectRolNuevo.innerHTML =
                '<option value="">Error al cargar roles</option>';
        });
}

const formNuevoUsuario = document.getElementById('formNuevoUsuario');

formNuevoUsuario.addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const token = document.querySelector(
        'meta[name="csrf-token"]'
    ).getAttribute('content');

    fetch('/usuarios', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.ok) {
            alert(data.mensaje);

            bootstrap.Modal.getInstance(
                document.getElementById('modalNuevoUsuario')
            ).hide();

            formNuevoUsuario.reset();

            // Recargar DataTable
            $('#tbl_usuarios').DataTable().ajax.reload();
        }
    })
    .catch(err => {
        console.error(err);
        alert('Error al guardar usuario');
    });
});


});
