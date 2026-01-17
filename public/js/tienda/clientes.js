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
                d.usuario = $("#filtro_usuario").val();
                d.correo = $("#filtro_correo").val();
                d.rol = $("#filtro_rol").val();
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
});
