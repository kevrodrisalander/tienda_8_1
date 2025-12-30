let verEliminados = false;

$(document).ready(function () {
    const formToken = $('meta[name="csrf-token"]').attr("content");

    // Inicializar DataTable
    const tabla = $("#tbl_provedores").DataTable({
        language: { url: "es-MX.json" },
        pageLength: 10,
        columnDefs: [
            { targets: [0], visible: false, searchable: false }, // id_proveedor oculto
            { targets: -1, orderable: false, searchable: false, className: "text-center" }, // Acciones
        ],
        ajax: {
            url: "/provedores",
            type: "POST",
            headers: { "X-CSRF-TOKEN": formToken },
            data: function (d) {
                d.eliminados = verEliminados ? 1 : 0;
            },
        },
        columns: [
            { data: "id_proveedor" },
            { data: "nombre_marca" },
            { data: "nombre_proveedor" },
            { data: "contacto" },
            { data: "telefono" },
            { data: "email" },
            { data: "direccion" },
            {
                data: null,
                className: "text-center",
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    if (row.activo == 1) {
                        return `
                            <a href="#" class="btn btn-sm editar-proveedor" data-id="${row.id_proveedor}">✏️</a>
                            <a href="#" class="btn btn-sm eliminar-proveedor" data-id="${row.id_proveedor}">🗑️</a>
                        `;
                    } else {
                        return `<a href="#" class="btn btn-sm restaurar-proveedor" data-id="${row.id_proveedor}">♻️</a>`;
                    }
                },
            },
        ],
    });

    // ========================= ELIMINAR PROVEEDOR =========================
    $("#tbl_provedores").on("click", ".eliminar-proveedor", function (e) {
        e.preventDefault();
        const id = $(this).data("id");

        Swal.fire({
            title: "¿Eliminar proveedor?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/provedores/${id}`,
                    type: "DELETE",
                    headers: { "X-CSRF-TOKEN": formToken },
                    success: function () {
                        Swal.fire("Eliminado", "Proveedor eliminado correctamente", "success");
                        tabla.ajax.reload();
                    },
                });
            }
        });
    });

    // ========================= RESTAURAR PROVEEDOR =========================
    $("#tbl_provedores").on("click", ".restaurar-proveedor", function (e) {
        e.preventDefault();
        const id = $(this).data("id");

        $.ajax({
            url: `/provedores/${id}/restaurar`,
            type: "PUT",
            headers: { "X-CSRF-TOKEN": formToken },
            success: function () {
                Swal.fire("Restaurado", "Proveedor restaurado correctamente", "success");
                tabla.ajax.reload();
            },
        });
    });

    // ========================= VER ELIMINADOS / ACTIVOS =========================
    $("#btnVerProveedoresEliminados").on("click", function () {
        verEliminados = !verEliminados;
        $(this).text(verEliminados ? "Ver activos" : "Ver eliminados");
        tabla.ajax.reload();
    });

    // ========================= EDITAR PROVEEDOR =========================
    $("#tbl_provedores").on("click", ".editar-proveedor", function (e) {
        e.preventDefault();
        const id = $(this).data("id");

        // 1️ Obtener datos del proveedor usando POST en vez de GET
        $.post('/provedores', { id: id, _token: $('meta[name="csrf-token"]').attr("content") }, function (proveedor) {
            $("#proveedorId").val(proveedor.id_proveedor);
            $("#nombre_proveedor").val(proveedor.nombre_proveedor);
            $("#contacto").val(proveedor.contacto);
            $("#telefono").val(proveedor.telefono);
            $("#email").val(proveedor.email);
            $("#direccion").val(proveedor.direccion);

            // 2️  Cargar marcas dinámicamente
            $.get("/provedores/marcas", function (marcas) {
                const select = $("#id_cat_marcas");
                select.empty();
                select.append('<option value="">Selecciona una marca</option>');
                marcas.forEach(function (marca) {
                    const selected = marca.id == proveedor.id_cat_marcas ? "selected" : "";
                    select.append(`<option value="${marca.id}" ${selected}>${marca.nombre}</option>`);
                });

                // 3️ Mostrar modal (Bootstrap 5)
                const modal = new bootstrap.Modal(document.getElementById('modalEditarProveedor'));
                modal.show();
            });
        });
    });


    // ========================= GUARDAR CAMBIOS DEL MODAL =========================
    $("#formEditarProveedor").on("submit", function (e) {
        e.preventDefault();
        const id = $("#proveedorId").val();

        $.ajax({
            url: `/provedores/${id}`,
            type: "PUT",
            headers: { "X-CSRF-TOKEN": formToken },
            data: {
                nombre_proveedor: $("#nombre_proveedor").val(),
                contacto: $("#contacto").val(),
                telefono: $("#telefono").val(),
                email: $("#email").val(),
                direccion: $("#direccion").val(),
                id_cat_marcas: $("#id_cat_marcas").val()
            },
            success: function () {
                Swal.fire("Éxito", "Proveedor actualizado correctamente", "success");
                tabla.ajax.reload();
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalEditarProveedor'));
                modal.hide();
            },
            error: function () {
                Swal.fire("Error", "No se pudo actualizar el proveedor", "error");
            }
        });
    });
});
