let verCancelados = false;

$(document).ready(function () {
    const formToken = $('meta[name="csrf-token"]').attr("content");

    // DataTable Envios
    const tabla = $("#tbl_envios").DataTable({
        language: { url: "es-MX.json" },
        pageLength: 10,
        processing: true,
        serverSide: false,
        ajax: {
            url: "/envios/consulta", // Ruta que debes definir en Laravel
            type: "GET",
            headers: { "X-CSRF-TOKEN": formToken },
            data: function (d) {
                d.cancelados = verCancelados ? 1 : 0;
                d.transportista = $("#filtro_transportista").val();
                d.estado_envio = $("#filtro_estado").val();
            },
        },
        columns: [
            { data: "id_envio" },
            { data: "id_pedido" },
            { data: "fecha_pedido" },
            { data: "fecha_envio" },
            { data: "transportista" },
            { data: "numero_guia" },
            { data: "estado_pedido" },
            { data: "estado_envio" },
            {
                data: null,
                className: "text-center",
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    if (row.estado_envio !== "cancelado") {
                        return `
                            <a href="#" class="btn btn-sm editar-envio" data-id="${row.id_envio}">✏️</a>
                            <a href="#" class="btn btn-sm cancelar-envio" data-id="${row.id_envio}">🗑️</a>
                        `;
                    } else {
                        return `
                            <a href="#" class="btn btn-sm restaurar-envio" data-id="${row.id_envio}">♻️</a>
                        `;
                    }
                },
            },
        ],
    });
});
