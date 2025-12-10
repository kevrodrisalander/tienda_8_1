$(document).ready(function () {
    const formToken = $('meta[name="csrf-token"]').attr("content");

    $("#tbl_productos").DataTable({
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

        //Se ordena por la columna 1
        order: [[1, "asc"]],

        columnDefs: [
            {
                targets: [0, 5], // ocultar ID y id_marca
                visible: false,
                searchable: false,
            },
            {
                width: "30%",
                targets: [1], // columna Descripción
            },
        ],

        ajax: {
            url: "inventario",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": formToken,
            },
            data: function (d) {
                return $("#formproductos").serialize();
            },
        },

        columns: [
            { data: "IdProducto" },
            { data: "Descripcion" },
            {
                data: "Stock",
                render: function(data, type, row) {
                    return data ? data : 0;
                },
                className: "text-center",
            },
            { data: "PrecioVenta" },
            { data: "estatus" },
            { data: "id_marca" },
            { data: "MarcaNombre" },
            { data: "categoria" },
            { data: "IdSeccion" },
            { data: "SeccionNombre" },
            { data: "SeccionSlug" },
        ],
    });
});
