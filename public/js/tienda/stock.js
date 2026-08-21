/**************************************************
 * UTILIDADES
 **************************************************/

/**
 * Convierte datetime a fecha compatible con input[type=date]
 * @param {string|null} f
 * @returns {string}
 */
function soloFecha(f) {
    return f ? f.split(" ")[0] : "";
}

/**
 * PostgreSQL entrega estas columnas sin zona horaria. Se interpretan como
 * hora local de la tienda; no se debe agregar "Z" (UTC).
 */
function fechaHoraLocal(f) {
    if (!f) return "-";
    const coincidencia = String(f).match(
        /^(\d{4})-(\d{2})-(\d{2})[ T](\d{2}):(\d{2})(?::(\d{2}))?/,
    );
    if (!coincidencia) return f;
    const [, anio, mes, dia, hora, minuto, segundo = "00"] = coincidencia;
    return `${dia}/${mes}/${anio}, ${hora}:${minuto}:${segundo}`;
}

function fechaLocal(f) {
    if (!f) return "-";
    const partes = String(f).substring(0, 10).split("-");
    return partes.length === 3
        ? `${partes[2]}/${partes[1]}/${partes[0]}`
        : f;
}

/**************************************************
 * VARIABLES DE CONTROL
 **************************************************/

// Flag para mostrar activos / eliminados
let verEliminados = false;

/**************************************************
 * MAIN (auto-ejecutable)
 **************************************************/
(function () {
    const formToken = $('meta[name="csrf-token"]').attr("content");

    /**************************************************
     * DATATABLE
     **************************************************/
    const tabla = $("#tbl_stock").DataTable({
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

        // ajax: {
        //     url: "stock/consulta",
        //     type: "GET",
        //     headers: { "X-CSRF-TOKEN": formToken },
        //     data: function (d) {
        //         d.eliminados = verEliminados ? 1 : 0;
        //     },
        // },

        ajax: {
            url: "stock/consulta",
            type: "GET",
            headers: { "X-CSRF-TOKEN": formToken },
            data: function (d) {
                d.eliminados = verEliminados ? 1 : 0;

                // Con esta función asignamos el valor solo si existe y no está vacío
                const getVal = (selector) => {
                    const el = $(selector);
                    return el.length && el.val() ? el.val().trim() : null;
                };

                d.filter_nombre = getVal('[name="filter_nombre"]');
                d.filter_ubicacion = getVal('[name="filter_ubicacion"]');
                d.filter_lote = getVal('[name="filter_lote"]');
                d.filter_estado = getVal('[name="filter_estado"]');
                d.filter_tipo_movimiento = getVal(
                    '[name="filter_tipo_movimiento"]',
                );
                d.filter_cantidad_min = getVal('[name="filter_cantidad_min"]');
                d.filter_cantidad_max = getVal('[name="filter_cantidad_max"]');
                d.filter_minimo = getVal('[name="filter_minimo"]');
                d.filter_maximo = getVal('[name="filter_maximo"]');
                d.filter_fecha_ingreso_desde = getVal(
                    '[name="filter_fecha_ingreso_desde"]',
                );
                d.filter_fecha_ingreso_hasta = getVal(
                    '[name="filter_fecha_ingreso_hasta"]',
                );
                d.filter_fecha_vencimiento_desde = getVal(
                    '[name="filter_fecha_vencimiento_desde"]',
                );
                d.filter_fecha_vencimiento_hasta = getVal(
                    '[name="filter_fecha_vencimiento_hasta"]',
                );
                d.filter_observaciones = getVal(
                    '[name="filter_observaciones"]',
                );
            },
        },

        columns: [
            { data: "nombre_producto" },
            {
                data: "cantidad",
                className: "text-center",
                render: function (data, type, row) {
                    if (row.tipo_movimiento.toLowerCase() === "entrada") {
                        return `<span class="badge bg-success">${data}</span>`;
                    } else if (row.tipo_movimiento.toLowerCase() === "salida") {
                        return `<span class="badge bg-danger">${data}</span>`;
                    } else {
                        return data;
                    }
                },
            },
            { data: "ubicacion" },
            { data: "estado" },
            { data: "minimo_seguro" },
            { data: "maximo_permitido" },
            {
                data: "fecha_ingreso",
                className: "text-center",
                render: function (data) {
                    return fechaHoraLocal(data);
                },
            },
            {
                data: "fecha_vencimiento",
                className: "text-center",
                render: function (data) {
                    return fechaLocal(data);
                },
            },
            { data: "lote" },
            {
                data: "fecha_salida",
                className: "text-center",
                render: function (data) {
                    return fechaHoraLocal(data);
                },
            },
            { data: "observaciones" },
            {
                data: "tipo_movimiento",
                className: "text-center",
                render: function (data) {
                    if (!data) return "-";
                    const tipos = {
                        entrada: { texto: "Entrada (+)", color: "success" },
                        salida: { texto: "Salida (-)", color: "danger" },
                        ajuste: { texto: "Ajuste", color: "warning text-dark" },
                        traslado: { texto: "Transferencia interna", color: "info text-dark" },
                    };
                    const tipo = tipos[String(data).toLowerCase()] || {
                        texto: data,
                        color: "secondary",
                    };
                    return `<span class="badge bg-${tipo.color}">${tipo.texto}</span>`;
                },
            },
            {
                data: null,
                className: "text-center",
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    if (row.activo == 1) {
                        return `
                        <a href="#" class="btn btn-sm editar-stock" data-id="${row.id}" title="Editar">✏️</a>
                        <a href="#" class="btn btn-sm eliminar-stock" data-id="${row.id}" title="Eliminar">🗑️</a>
                    `;
                    } else {
                        return `
                        <a href="#" class="btn btn-sm restaurar-stock" data-id="${row.id}" title="Restaurar">♻️</a>
                    `;
                    }
                },
            },
        ],
    });

    /**************************************************
     * EDITAR STOCK
     **************************************************/
    $("#tbl_stock").on("click", ".editar-stock", function (e) {
        e.preventDefault();

        const id = $(this).data("id");

        $.get(`/stock/${id}`, function (data) {
            $("#formEditarStock").attr("action", `/stock/${id}`);

            // Producto (solo lectura)
            $('[name="producto_id"]').val(data.producto_id);
            $("#producto_nombre").val(data.nombre_producto);
            $('#formEditarStock [name="detalle_cliente"]').val(data.detalle_cliente);
            $('#formEditarStock [name="detalle_administrativo"]').val(data.detalle_administrativo);

            // Campos editables
            $('[name="cantidad"]').val(data.cantidad);
            $('[name="ubicacion"]').val(data.ubicacion);

            // Estado normalizado
            $('[name="estado"]').val(
                data.estado ? data.estado.toLowerCase().trim() : "",
            );

            // Lote
            $('[name="id_lote"]').val(data.id_lote);

            // Límites
            $('[name="minimos"]').val(data.minimo_seguro);
            $('[name="maximos"]').val(data.maximo_permitido);

            // Fechas
            $('[name="fecha_ingreso"]').val(soloFecha(data.fecha_ingreso));
            $('[name="fecha_vencimiento"]').val(
                soloFecha(data.fecha_vencimiento),
            );

            // Otros
            $('[name="tipo_movimiento"]').val(data.tipo_movimiento);
            $('[name="observaciones"]').val(data.observaciones);

            $("#modalSimple").modal("show");
        });
    });

    $("#tbl_stock").on("click", ".eliminar-stock", function (e) {
        e.preventDefault();

        const id = $(this).data("id");

        Swal.fire({
            title: "¿Eliminar registro?",
            text: "El stock no se perderá, solo se desactivará",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/stock/${id}`,
                    type: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content",
                        ),
                    },
                    success: function () {
                        Swal.fire(
                            "Eliminado",
                            "Registro desactivado",
                            "success",
                        );
                        $("#tbl_stock").DataTable().ajax.reload();
                    },
                });
            }
        });
    });

    /**************************************************
     * RESTAURAR STOCK
     **************************************************/
    $("#tbl_stock").on("click", ".restaurar-stock", function (e) {
        e.preventDefault();

        const id = $(this).data("id");

        Swal.fire({
            title: "¿Restaurar registro?",
            text: "El producto volverá al stock activo",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Sí, restaurar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/stock/${id}/restaurar`,
                    type: "PUT",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content",
                        ),
                    },
                    success: function () {
                        Swal.fire(
                            "Restaurado",
                            "Registro activo nuevamente",
                            "success",
                        );
                        $("#tbl_stock").DataTable().ajax.reload();
                    },
                });
            }
        });
    });

    /**************************************************
     * TOGGLE VER ELIMINADOS / ACTIVOS
     **************************************************/
    $("#btnVerEliminados").on("click", function () {
        verEliminados = !verEliminados;

        $(this).text(verEliminados ? "Ver activos" : "Ver eliminados");

        tabla.ajax.reload();
    });

    /**************************************************
     * PROCESAR FILTROS DEL MODAL (DATATABLES)
     **************************************************/
    // Cuando el usuario pulsa "Aplicar Filtros"
    $("#formFiltrosStock").on("submit", function (e) {
        e.preventDefault(); // Evita que la página se recargue
        tabla.ajax.reload(); // Recarga la tabla enviando los nuevos parámetros
        $("#modalFiltros").modal("hide"); // Cierra el modal de forma limpia
    });

    // Cuando el usuario pulsa "Limpiar Filtros"
    $("#btnLimpiarFiltros").on("click", function (e) {
        e.preventDefault();
        $("#formFiltrosStock")[0].reset(); // Resetea visualmente todos los inputs
        tabla.ajax.reload(); // Recarga la tabla vacía de filtros
        $("#modalFiltros").modal("hide");
    });

    /**************************************************
     * PREVENIR DOBLE SUBMIT EN EDICIÓN
     **************************************************/
    $("#formEditarStock").on("submit", function () {
        $(this).find('button[type="submit"]').prop("disabled", true);
    });
})(); // ← auto-ejecución, no tocar
