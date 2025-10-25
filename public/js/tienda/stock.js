$(document).ready(function () {
    const formToken = $('meta[name="csrf-token"]').attr("content");

    $("#tbl_stock").DataTable({
        language: {
            url: "es-MX.json",
            sLoadingRecords:
                '<span style="width:100%;"><img src="/images/ajaxload.gif"></span>',
            sSearchPlaceholder: "Ingresa un dato",
            sSearch: "Buscar:",
            sEmptyTable: "Ningún dato disponible en esta tabla",
            sZeroRecords: "No se encontraron resultados intenta de nuevo KIMIN",
            sInfoEmpty:
                "Mostrando registros del 0 al 0 de un total de 0 registros",
            oPaginate: {
                sNext: "Siguiente",
                sPrevious: "Anterior",
            },
        },
        pageLength: 10,
        scrollX: true,
        ajax: {
            // url: "stock", // Usa la ruta correcta aquí
            url: "stock/consulta",
            type: "GET",            // Asegúrate que coincida con tu route
            headers: {
                "X-CSRF-TOKEN": formToken,
            },
        },
        columns: [
            { data: "nombre_producto" },
            { data: "cantidad" },
            { data: "ubicacion" },
            { data: "estado" },
            { data: "minimo_seguro" },
            { data: "maximo_permitido" },
            { data: "fecha_ingreso" },
            { data: "fecha_vencimiento" },
            { data: "lote" },
            { data: "observaciones" },
            { data: "tipo_movimiento" },
            {
                data: null,
                className: "text-center",
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                        <a href="#" class="btn btn-sm btn editar-stock" data-id="${row.id}" title="Editar">
                            ✏️
                        </a>
                    `;
                },
            },
        ],
    });

    // Delegar evento click para el botón Editar
    $('#tbl_stock').on('click', '.editar-stock', function (e) {
        e.preventDefault();
        const stockId = $(this).data('id');

        // Aquí puedes lanzar un modal o hacer una petición para obtener los datos del stock
        console.log("Editar stock con ID:", stockId);
    });
});
