$(document).ready(function () {
    const formToken = $('meta[name="csrf-token"]').attr('content');


    $('#tbl_productos').DataTable({
        language: {
            url: "es-MX.json",
            sLoadingRecords: '<span style="width:100%;"><img src="/images/ajaxload.gif"></span>',
            sSearchPlaceholder: "Ingresa un dato",
            sSearch: "Buscar:",
            sEmptyTable: "Ningún dato disponible en esta tabla",
            sZeroRecords: "No se encontraron resultados intenta de nuevo KIMIN",
            sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            oPaginate: {
                sNext: "Siguiente",
                sPrevious: "Anterior",
            }
        },
        pageLength: 10,
        columnDefs: [
            {
                targets: [0],
                visible: false,
                searchable: false
            },
            {
                width: '40%',
                targets: [1] // Descripción
            }
        ],
        ajax: {
            url: 'productos',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': formToken
            },
            data: function (d) {
                return $('#formproductos').serialize(); // si tienes filtros
            }
        },
        columns: [
            { data: "IdProducto" },
            { data: "Descripcion" },
            { data: "Stock" },
            { data: "PrecioVenta" },
            { data: "Estatus" },       // ← nombre desde cat_estatus_venta
            { data: "categoria" }      // ← nombre desde cat_categorias
        ]
    });
});
