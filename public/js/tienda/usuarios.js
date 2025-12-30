let verEliminados = false;

$(document).ready(function () {
    const formToken = $('meta[name="csrf-token"]').attr("content");

    const tabla = $("#tbl_usuarios").DataTable({
        language: { url: "es-MX.json" },
        pageLength: 10,
        ajax: {
            url: "/usuarios/consulta",
            type: "GET",
            headers: { "X-CSRF-TOKEN": formToken },
            data: function (d) { d.eliminados = verEliminados ? 1 : 0; },
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
                        return `<a href="#" class="btn btn-sm restaurar-usuario" data-id="${row.id}">♻️</a>`;
                    }
                },
            },
        ],
    });

    // Editar usuario
    $("#tbl_usuarios").on("click", ".editar-usuario", function (e) {
        e.preventDefault();
        const id = $(this).data("id");
        console.log("Editar usuario ID:", id); // para debug

        // 1️ Obtener datos del usuario
        $.get(`/usuarios/${id}`, function (usuario) {
            $("#usuarioId").val(usuario.id); // ID oculto
            $("#usuario").val(usuario.usuario);
            $("#correo").val(usuario.correo);

            // 2 Cargar roles dinámicamente
            $.get("/roles", function (roles) {
                const select = $("#id_rol");
                select.empty();
                select.append('<option value="">Selecciona un rol</option>');
                roles.forEach(function (role) {
                    const selected = role.id_rol == usuario.id_rol ? "selected" : "";
                    select.append(`<option value="${role.id_rol}" ${selected}>${role.nombre}</option>`);
                });

                // 3️ Mostrar modal (Bootstrap 5)
                const modal = new bootstrap.Modal(document.getElementById('modalEditarUsuario'));
                modal.show();
            });
        });
    });

    // Editar usuario
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
                id_rol: $("#id_rol").val(),
            },
            success: function () {
                Swal.fire("Éxito", "Usuario actualizado correctamente", "success");
                $("#tbl_usuarios").DataTable().ajax.reload();
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalEditarUsuario'));
                modal.hide();
            },
            error: function () {
                Swal.fire("Error", "No se pudo actualizar el usuario", "error");
            }
        });
    });

    // Ver usuarios eliminados
    $("#btnVerUsuariosEliminados").on("click", function () {
        verEliminados = !verEliminados;
        $(this).text(verEliminados ? "Ver activos" : "Ver eliminados");
        tabla.ajax.reload();
    });
});
