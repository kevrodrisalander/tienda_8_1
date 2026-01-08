$(document).ready(function () {
    const formToken = $('meta[name="csrf-token"]').attr("content");

    // 🔹 Select2 filtros
    $('.select2').select2({
        dropdownParent: $('#modalFiltrosInventario'),
        width: '100%'
    });

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
                d.marca     = $('#filtro_marca').val();
                d.categoria = $('#filtro_categoria').val();
                d.status    = $('#filtro_status').val();
                d.stock     = $('#filtro_stock').val();
            },
            dataSrc: "data",
        },

        columns: [
            { data: "id" },               // 0
            { data: "descripcion" },      // 1
            { data: "stock_actual" },     // 2
            {
                data: "precio_venta",     // 3
                render: data => `$${parseFloat(data).toFixed(2)}`
            },
            { data: "estatus" },          // 4
            { data: "id_marca" },         // 5
            { data: "marca" },            // 6
            { data: "categoria" },        // 7
            {
                data: null,               // 8
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                        <button
                            class="btn btn-sm btn btn-detalles"
                            data-descripcion="${row.descripcion}"
                            data-detalles="${row.detalles ?? 'Sin detalles'}"
                        >
                            🔎
                        </button>
                    `;
                }
            }
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
        $.get('/inventario/marcas', function (data) {
            $('#filtro_marca').html('<option value="">Todas</option>');
            data.forEach(m => {
                $('#filtro_marca').append(`<option value="${m.id}">${m.nombre}</option>`);
            });
        });
    }

    function cargarCategorias() {
        $.get('/inventario/categorias', function (data) {
            $('#filtro_categoria').html('<option value="">Todas</option>');
            data.forEach(c => {
                $('#filtro_categoria').append(`<option value="${c.id}">${c.nombre}</option>`);
            });
        });
    }

    // 🔹 Aplicar filtros
    $('#btnAplicarFiltros').on('click', function () {
        tabla.ajax.reload();
        $('#modalFiltrosInventario').modal('hide');
    });
});
