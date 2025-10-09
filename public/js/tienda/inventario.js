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
        columnDefs: [
            {
                targets: [0,5],
                visible: false,
                searchable: false,
            },
            {
                width: "30%",
                targets: [1], // Descripción
            },
        ],
        ajax: {
            url: "inventario",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": formToken,
            },
            data: function (d) {
                return $("#formproductos").serialize(); // si tienes filtros
            },
        },

        columns: [
            { data: "IdProducto" }, // ID del producto
            { data: "Descripcion" }, // Descripción del producto
            { data: "Stock" }, // Cantidad en inventario
            { data: "PrecioVenta" }, // Precio de venta
            { data: "Estatus" }, // Estatus desde cat_estatus_inventario
            { data: "IdMarca" }, // ID de la marca desde cat_marcas
            { data: "MarcaNombre" }, // Nombre de la marca desde cat_marcas
            { data: "categoria" }, // Categoría desde cat_categorias
        ],
    });
});
