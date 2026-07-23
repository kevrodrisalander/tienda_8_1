let verEliminados = false;

$(document).ready(function () {
    const formToken = $('meta[name="csrf-token"]').attr("content");

    const tabla = $("#tbl_clientes").DataTable({
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json",
        },

        pageLength: 10,
        processing: true,
        serverSide: false,

        ajax: {
            url: "/clientes/consulta",
            type: "GET",
            dataSrc: "",
            headers: {
                "X-CSRF-TOKEN": formToken,
            },

            data: function (d) {
                d.eliminados = verEliminados ? 1 : 0;
                d.nombre = $("#filtroNombre").val();
                d.correo = $("#filtroCorreo").val();
                d.telefono = $("#filtroTelefono").val();
            },
        },

        columns: [
            { data: "nombre_cliente" },
            { data: "correo", defaultContent: "Sin correo" },
            {
                data: "telefono",
                render: function (data) {
                    return data
                        ? data
                        : '<span class="badge bg-warning text-dark">Sin teléfono</span>';
                },
            },

            {
                data: "direccion",
                render: function (data) {
                    return data
                        ? data
                        : '<span class="badge bg-warning text-dark">Sin dirección</span>';
                },
            },

            { data: "fecha_registro" },
            { data: "id_usuario" },
            { data: "observaciones", defaultContent: "N/A" },
            {
                data: null,
                className: "text-center",
                orderable: false,
                render: function (data, type, row) {
                    if (row.activo == true || row.activo == 1) {
                        return `
                            <button
                                class="btn btn-sm editar-cliente"
                                data-id="${row.id_cliente}">
                                ✏️
                            </button>


                            <button
                                class="btn btn-sm desactivar-cliente"
                                data-id="${row.id_cliente}">
                                🗑️
                            </button>

                        `;
                    } else {
                        return `

                            <button
                                class="btn btn-sm btn-success restaurar-cliente"
                                data-id="${row.id_cliente}">
                                ♻️
                            </button>

                        `;
                    }
                },
            },
        ],
    });

    //Filtros
    $("#btnAplicarFiltros").on("click", function () {
        tabla.ajax.reload();

        $("#modalFiltrosClientes").modal("hide");
    });

    //Eliminados

    $("#btnVerEliminados").on("click", function () {
        verEliminados = !verEliminados;

        if (verEliminados) {
            $(this)
                .removeClass("btn-danger")
                .addClass("btn-success")
                .text("Ver activos");
        } else {
            $(this)
                .removeClass("btn-success")
                .addClass("btn-danger")
                .text("Ver eliminados");
        }

        tabla.ajax.reload();
    });

    //Editar clientes

    $(document).on("click", ".editar-cliente", function (e) {
        e.preventDefault();

        const data = tabla.row($(this).closest("tr")).data();

        $("#edit_id_cliente").val(data.id_cliente);
        $("#edit_nombre").val(data.nombre_cliente);
        $("#edit_telefono").val(data.telefono);
        $("#edit_direccion").val(data.direccion);
        $("#edit_activo").prop(
            "checked",
            data.activo == true || data.activo == 1,
        );
        $("#modalEditarCliente").modal("show");
    });

    //Guardar cambios
    $("#formEditarCliente").on("submit", function (e) {
        e.preventDefault();

        const id = $("#edit_id_cliente").val();

        $.ajax({
            url: `/clientes/update/${id}`,
            type: "POST",
            data: $(this).serialize(),
            headers: {
                "X-CSRF-TOKEN": formToken,
            },
            success: function () {
                $("#modalEditarCliente").modal("hide");
                tabla.ajax.reload();
                alert("Cliente actualizado correctamente");
            },

            error: function () {
                alert("Error al actualizar cliente");
            },
        });
    });

    //Desactivar clientes
    $(document).on("click", ".desactivar-cliente", function () {
        const id = $(this).data("id");

        if (!confirm("¿Deseas desactivar este cliente?")) {
            return;
        }

        $.ajax({
            url: `/clientes/desactivar/${id}`,
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": formToken,
            },

            success: function () {
                tabla.ajax.reload();
            },

            error: function () {
                alert("No se pudo desactivar el cliente");
            },
        });
    });

    //restaurar clientes

    $(document).on("click", ".restaurar-cliente", function () {
        const id = $(this).data("id");

        $.ajax({
            url: `/clientes/restaurar/${id}`,
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": formToken,
            },

            success: function () {
                tabla.ajax.reload();
            },

            error: function () {
                alert("No se pudo restaurar el cliente");
            },
        });
    });
});
