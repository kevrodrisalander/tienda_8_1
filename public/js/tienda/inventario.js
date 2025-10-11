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
                // targets: [],
                visible: false,
                searchable: false,
            },
            {
                width: "30%",
                targets: [], // Descripción
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
            { data: "estatus" }, // Estatus desde cat_estatus_inventario
            { data: "id_marca" }, // ID de la marca desde cat_marcas
            { data: "MarcaNombre" }, // Nombre de la marca desde cat_marcas
            { data: "categoria" }, // Nombre de la categoría desde cat_categorias
            { data: "IdSeccion" }, // ID de la sección desde cat_secciones
            { data: "SeccionNombre" }, // Nombre de la sección desde cat_secciones
            { data: "SeccionSlug" }, // Slug de la sección (opcional para navegación)
        ],
    });
});
