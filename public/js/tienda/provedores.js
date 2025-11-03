$(document).ready(function () {
    const formToken = $('meta[name="csrf-token"]').attr("content");

    $("#tbl_provedores").DataTable({
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
                targets: [0, 5],
                visible: false,
                searchable: false,
            },
            {
                width: "30%",
                targets: [], // puedes especificar columnas si lo deseas
            },
        ],
        ajax: {
            url: "provedores",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": formToken,
            },
            data: function (d) {
                return $("#formproductos").serialize(); // si tienes filtros
            },
        },
        columns: [
            { data: "id_proveedor" },     // ID del proveedor
            { data: "nombre_marca" },     // ID del proveedor
            { data: "nombre_proveedor" }, // Nombre del proveedor
            { data: "contacto" },         // Contacto
            { data: "telefono" },         // Teléfono
            { data: "email" },            // Email
            { data: "direccion" },        // Dirección
        ],
    });
});
