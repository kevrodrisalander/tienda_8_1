$(document).ready(function () {
    const formToken = $('meta[name="csrf-token"]').attr("content");

    $("#tbl_usuarios").DataTable({
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
                targets: [],
                visible: false,
                searchable: false,
            },
            {
                width: "30%",
                targets: [], // puedes especificar columnas si lo deseas
            },
        ],
        ajax: {
            url: "usuarios",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": formToken,
            },
            data: function (d) {
                return $("#formusuarios").serialize(); // si tienes filtros
            },
        },
        columns: [
            { data: "usuario" },                // Usuario
            { data: "correo" },                 // Correo
            { data: "id_rol" },                 // Id de rol
            { data: "nombre_rol" },             // Nombre rol
            { data: "descripcion_rol" },        // Descripcion rol
        ],
    });
});
