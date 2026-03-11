let verEliminados = false;

$(document).ready(function () {
    const formToken = $('meta[name="csrf-token"]').attr("content");

    // 1. Inicializar DataTable Clientes
    const tabla = $("#tbl_clientes").DataTable({
        language: { url: "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json" },
        pageLength: 10,
        processing: true,
        serverSide: false, // Cambiar a true si tienes miles de clientes
        ajax: {
            url: "/clientes/consulta", // Esta ruta debe devolver el JSON que vimos antes
            type: "GET",
            dataSrc: "", // Importante: Si el JSON es un array directo [], usa ""
            headers: { "X-CSRF-TOKEN": formToken },
            data: function (d) {
                d.eliminados = verEliminados ? 1 : 0;
            },
        },
        columns: [
            { data: "nombre_cliente" },
            { data: "correo" },
            {
                data: "telefono",
                render: function(data) {
                    // Manejo del NULL que vimos en tu imagen
                    return data ? data : '<span class="badge bg-warning text-dark">Sin telefono</span>';
                }
            },
            {
                data: "direccion",
                render: function(data) {
                    // Manejo del NULL que vimos en tu imagen
                    return data ? data : '<span class="badge bg-warning text-dark">Sin dirección</span>';
                }
            },
            { data: "fecha_registro" },
            { data: "id_usuario" },
            { data: "observaciones", defaultContent: "N/A" },
            {
                data: null,
                className: "text-center",
                render: function (data, type, row) {
                    if (row.activo == 1) {
                        return `
                            <button class="btn btn-sm editar-cliente" data-id="${row.id_cliente}">✏️</button>
                            <button class="btn btn-sm desactivar-cliente" data-id="${row.id_cliente}">🗑️</button>
                        `;
                    } else {
                        return `
                            <button class="btn btn-sm restaurar-cliente" data-id="${row.id_cliente}">♻️</button>
                        `;
                    }
                },
            },
        ],
    });

    // 2. Acción: Editar cliente (Cargar datos en el Modal)
    $(document).on("click", ".editar-cliente", function (e) {
        e.preventDefault();
        const id = $(this).data("id");

        // Buscamos los datos de la fila actual en la tabla
        const data = tabla.row($(this).parents('tr')).data();

        // Llenamos el modal (Asegúrate de que los IDs coincidan con el modal que te pasé)
        $("#edit_id_cliente").val(data.id_cliente);
        $("#edit_nombre").val(data.nombre_cliente);
        $("#edit_telefono").val(data.telefono);
        $("#edit_direccion").val(data.direccion);
        $("#edit_activo").prop('checked', data.activo == 1);

        // Mostramos el modal
        $("#modalEditarCliente").modal("show");
    });

    // 3. Acción: Guardar cambios del Modal
    $("#formEditarCliente").on("submit", function(e) {
        e.preventDefault();
        const id = $("#edit_id_cliente").val();

        $.ajax({
            url: `/clientes/update/${id}`, // Debes crear esta ruta POST
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                $("#modalEditarCliente").modal("hide");
                tabla.ajax.reload();
                alert("Datos actualizados correctamente");
            },
            error: function() {
                alert("Error al actualizar los datos");
            }
        });
    });
});
