$(document).ready(function () {
    const formToken = $('meta[name="csrf-token"]').attr("content");

    // 🔹 DataTable ÚNICO
    const tabla = $("#tbl_productos").DataTable({
        processing: true,
        serverSide: false,

        language: {
            url: "es-MX.json",
            sSearch: "Buscar:",
            sEmptyTable: "No hay productos en inventario",
        },

        pageLength: 10,
        order: [[1, "asc"]],

        columnDefs: [
            {
                targets: [0, 5], // id, id_marca
                visible: false,
                searchable: false,
            },
            {
                className: "text-center",
                targets: [2, 8],
            },
        ],

        ajax: {
            url: "/inventario",
            type: "POST",
            headers: { "X-CSRF-TOKEN": formToken },
            data: function (d) {
                d.marca = $("#filtro_marca").val();
                d.categoria = $("#filtro_categoria").val();
                d.status = $("#filtro_status").val();
                d.stock = $("#filtro_stock").val();
                d.descripcion = $("#filtro_descripcion").val(); // ← NUEVO
            },
            dataSrc: "data",
        },
        columns: [
            { data: "id" }, // 0
            { data: "descripcion" }, // 1
            {
                data: "stock_actual", // 2
                render: function (data) {
                    let stock = parseInt(data);
                    if (isNaN(stock)) stock = 0;

                    if (stock <= 0) {
                        return '<span class="badge bg-danger">0</span>';
                    }
                    return (
                        '<span class="badge bg-success">' + stock + "</span>"
                    );
                },
                className: "text-center",
            },
            {
                data: "precio_venta", // 3
                render: (data) => `$${parseFloat(data).toFixed(2)}`,
            },
            {
                data: "activo",
                render: function (data) {
                    return data == 1
                        ? '<span class="badge bg-success">Disponible</span>'
                        : '<span class="badge bg-danger">No disponible</span>';
                },
            },
            { data: "id_marca" }, // 5
            { data: "marca" }, // 6
            { data: "categoria" }, // 7
            {
                data: null, // 8
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                <button
                    class="btn btn-sm btn btn-detalles"
                    data-descripcion="${row.descripcion}"
                    data-detalles="${
                        row.id_observaciones ?? "Sin observaciones"
                    }"
                >
                    🔎
                </button>
            `;
                },
            },
        ],
    });

    // 🔹 Click en detalles
    $(document).on("click", ".btn-detalles", function () {
        $("#modalProducto").text($(this).data("descripcion"));
        $("#modalDetalles").text($(this).data("detalles"));
        $("#modalDetallesProducto").modal("show");
    });

    // 🔹 Cargar combos
    cargarMarcas();
    cargarCategorias();

    function cargarMarcas() {
        $.get("/inventario/marcas", function (data) {
            $("#filtro_marca").html('<option value="">Todas</option>');
            data.forEach((m) => {
                $("#filtro_marca").append(
                    `<option value="${m.id}">${m.nombre}</option>`
                );
            });
        });
    }

    function cargarCategorias() {
        $.get("/inventario/categorias", function (data) {
            $("#filtro_categoria").html('<option value="">Todas</option>');
            data.forEach((c) => {
                $("#filtro_categoria").append(
                    `<option value="${c.id}">${c.nombre}</option>`
                );
            });
        });
    }

    // 🔹 Aplicar filtros
    $("#btnAplicarFiltros").on("click", function () {
        tabla.ajax.reload();
        $("#modalFiltrosInventario").modal("hide");
    });
});

// $(document).on("click", ".btn-ver-observaciones", function() {
//     const productoId = $(this).data("id");

//     // Consultamos las observaciones vía AJAX
//     $.get(`/inventario/observaciones/${productoId}`, function(response) {
//         $("#modalProducto").text("Producto #" + productoId); // o el nombre si lo tienes
//         $("#modalDetalles").text(response.observaciones);
//         $("#modalDetallesProducto").modal("show");
//     });
// });



