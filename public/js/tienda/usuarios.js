let verEliminados = false;

$(document).ready(function () {
    const formToken = $('meta[name="csrf-token"]').attr("content");

    const tabla = $("#tbl_usuarios").DataTable({
        language: {
            url: "es-MX.json",
        },
        pageLength: 10,

        ajax: {
            url: "/usuarios/consulta",
            type: "GET",
            headers: {
                "X-CSRF-TOKEN": formToken,
            },
            data: function (d) {
                d.eliminados = verEliminados ? 1 : 0;
            },
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
                },
            },
        ],
    });

    //Editar usuario activo
    $("#tbl_usuarios").on("click", ".editar-usuario", function (e) {
        e.preventDefault();

        const id = $(this).data("id");

        $.get(`/usuarios/${id}`, function (data) {
            $("#formEditarUsuario").attr("action", `/usuarios/${id}`);

            $('[name="usuario"]').val(data.usuario);
            $('[name="correo"]').val(data.correo);
            $('[name="id_rol"]').val(data.id_rol);

            $("#modalUsuario").modal("show");
        });
    });

    //Desactivar usuario activo
    $("#tbl_usuarios").on("click", ".desactivar-usuario", function (e) {
        e.preventDefault();

        const id = $(this).data("id");

        Swal.fire({
            title: "¿Desactivar usuario?",
            text: "El usuario no se eliminará, solo se desactivará",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, desactivar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/usuarios/${id}`,
                    type: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": formToken,
                    },
                    success: function () {
                        Swal.fire("Desactivado", "Usuario desactivado", "success");
                        tabla.ajax.reload();
                    },
                });
            }
        });
    });

    //Restaurar usuario eliminado
    $("#tbl_usuarios").on("click", ".restaurar-usuario", function (e) {
        e.preventDefault();

        const id = $(this).data("id");

        Swal.fire({
            title: "¿Restaurar usuario?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Sí, restaurar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/usuarios/${id}/restaurar`,
                    type: "PUT",
                    headers: {
                        "X-CSRF-TOKEN": formToken,
                    },
                    success: function () {
                        Swal.fire("Restaurado", "Usuario activo nuevamente", "success");
                        tabla.ajax.reload();
                    },
                });
            }
        });
    });


    // Botón para usuarios eliminados/activos

    $("#btnVerUsuariosEliminados").on("click", function () {
        verEliminados = !verEliminados;
        $(this).text(verEliminados ? "Ver activos" : "Ver eliminados");
        tabla.ajax.reload();
    });
});
