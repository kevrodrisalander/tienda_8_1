console.log("1. El archivo reportes.js se ha cargado correctamente");

$(document).ready(function () {
    console.log("2. jQuery y el DOM están listos");

    const $tabla = $("#tblReportes");
    const urlConsulta = $tabla.data("url-consulta");
    const urlExportar = $tabla.data("url-exportar");

    if (!urlConsulta) {
        console.error(
            "Error: No se encontró la URL de consulta en el atributo 'data-url-consulta' de la tabla #tblReportes.",
        );
    }

    // Inicialización de DataTables
    const tabla = $tabla.DataTable({
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json",
        },
        pageLength: 10,
        processing: true,
        serverSide: false,
        ajax: {
            url: urlConsulta,
            type: "GET",
            dataSrc: function (json) {
                // Adapta automáticamente si el backend responde con un array [ ... ] o con { data: [ ... ] }
                if (Array.isArray(json)) return json;
                if (json && json.data) return json.data;
                return [];
            },
            data: function (d) {
                d.filter_nombre = $("#filter_nombre").val();
                d.filter_ubicacion = $("#filter_ubicacion").val();
                d.filter_estado = $("#filter_estado").val();
                d.filter_lote = $("#filter_lote").val();
                d.filter_fecha_ingreso_desde = $(
                    "#filter_fecha_ingreso_desde",
                ).val();
                d.filter_fecha_ingreso_hasta = $(
                    "#filter_fecha_ingreso_hasta",
                ).val();
            },
        },
        columns: [
            { data: "id" },
            { data: "nombre_producto" },
            {
                data: "lote",
                render: function (data) {
                    return data
                        ? `<span class="badge bg-secondary">${data}</span>`
                        : '<span class="text-muted">N/A</span>';
                },
            },
            {
                data: "cantidad",
                render: function (data, type, row) {
                    const cant = parseInt(data) || 0;
                    const min = parseInt(row.minimo_seguro) || 0;
                    if (cant <= min) {
                        return `<strong class="text-danger">${cant}</strong>`;
                    }
                    return `<strong>${cant}</strong>`;
                },
            },
            { data: "minimo_seguro" },
            { data: "ubicacion" },
            {
                data: "estado",
                render: function (data) {
                    const est = (data || "").toLowerCase();
                    let badge = "bg-secondary";
                    if (est === "disponible") badge = "bg-success";
                    if (est === "agotado") badge = "bg-danger";
                    if (est === "reservado") badge = "bg-warning text-dark";
                    return `<span class="badge ${badge}">${(data || "").toUpperCase()}</span>`;
                },
            },
            { data: "tipo_movimiento" },
            { data: "fecha_ingreso" },
        ],
    });

    // 1. Evento de Filtrar (Submit del Formulario)
    $("#formFiltrosReportes").on("submit", function (e) {
        e.preventDefault();
        console.log("Aplicando filtros y recargando tabla...");
        tabla.ajax.reload();
    });

    // 2. Evento de Limpiar Filtros
    $("#btnLimpiarFiltros").on("click", function () {
        console.log("Limpiando filtros...");
        $("#formFiltrosReportes")[0].reset();
        tabla.ajax.reload();
    });

    // 3. Evento para Exportar a Excel
    $("#btnExportarExcel").on("click", function (e) {
        e.preventDefault();
        console.log("Generando descarga de Excel...");

        const params = new URLSearchParams({
            filter_nombre: $("#filter_nombre").val() || "",
            filter_ubicacion: $("#filter_ubicacion").val() || "",
            filter_estado: $("#filter_estado").val() || "",
            filter_lote: $("#filter_lote").val() || "",
            filter_fecha_ingreso_desde:
                $("#filter_fecha_ingreso_desde").val() || "",
            filter_fecha_ingreso_hasta:
                $("#filter_fecha_ingreso_hasta").val() || "",
        });

        window.location.href = urlExportar + "?" + params.toString();
    });
});
