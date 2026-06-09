let verEliminados = false;

$(document).ready(function () {
    const formToken = $('meta[name="csrf-token"]').attr("content");

    // Inicializar DataTable
    const tabla = $("#tbl_provedores").DataTable({
        language: { url: "es-MX.json" },
        pageLength: 10,
        columnDefs: [
            { targets: [0], visible: false, searchable: false }, // id_proveedor oculto
            // { targets: [1], visible: false, searchable: false }, // id_proveedor oculto
            {
                targets: -1,
                orderable: false,
                searchable: false,
                className: "text-center",
            }, // Acciones
        ],
        ajax: {
            // url: "/provedores",
            url: "/provedores/lista", // ruta nueva solo para DataTable
            // type: "POST",
            type: "GET",
            headers: { "X-CSRF-TOKEN": formToken },
            data: function (d) {
                d.eliminados = verEliminados ? 1 : 0;
                d.marca = $("#filtroMarca").val();
                d.nombre = $("#filtroNombre").val();
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
            // { data: "activo" },
            {
                data: null,
                className: "text-center",
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    // Mostrar botones según el estado del proveedor
                    if (row.activo == 1) {
                        // Mostrar botones de editar y eliminar
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

    // Eliminar proveedor (lógica de eliminación suave)
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
                        Swal.fire(
                            "Eliminado",
                            "Proveedor eliminado correctamente",
                            "success",
                        );
                        tabla.ajax.reload();
                    },
                });
            }
        });
    });

    // Restaurar proveedor
    $("#tbl_provedores").on("click", ".restaurar-proveedor", function (e) {
        e.preventDefault();
        const id = $(this).data("id");

        $.ajax({
            url: `/provedores/${id}/restaurar`,
            type: "PUT",
            headers: { "X-CSRF-TOKEN": formToken },
            success: function () {
                Swal.fire(
                    "Restaurado",
                    "Proveedor restaurado correctamente",
                    "success",
                );
                tabla.ajax.reload();
            },
        });
    });

    // Eliminar o ver proveedores eliminados
    $("#btnVerProveedoresEliminados").on("click", function () {
        verEliminados = !verEliminados;
        $(this).text(verEliminados ? "Ver activos" : "Ver eliminados");
        tabla.ajax.reload();
    });

    // Editar proveedor - Abrir modal y cargar datos

    $("#tbl_provedores").on("click", ".editar-proveedor", function (e) {
        e.preventDefault();
        const id = $(this).data("id");

        $.get(`/provedores/${id}`, function (proveedor) {
            $("#proveedorId").val(proveedor.id_proveedor);
            $("#nombre_proveedor").val(proveedor.nombre_proveedor);
            $("#contacto").val(proveedor.contacto);
            $("#telefono").val(proveedor.telefono);
            $("#email").val(proveedor.email);
            $("#direccion").val(proveedor.direccion);

            // Cargar marcas dinámicamente
            $.get("/provedores/marcas", function (marcas) {
                const select = $("#id_cat_marcas");
                select.empty();
                select.append('<option value="">Selecciona una marca</option>');
                marcas.forEach(function (marca) {
                    const selected =
                        marca.id == proveedor.id_cat_marcas ? "selected" : "";
                    select.append(
                        `<option value="${marca.id}" ${selected}>${marca.nombre}</option>`,
                    );
                });

                // Mostrar modal
                const modal = new bootstrap.Modal(
                    document.getElementById("modalEditarProveedor"),
                );
                modal.show();
            });
        });
    });

    // Guardar cambios al editar proveedor
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
                id_cat_marcas: $("#id_cat_marcas").val(),
            },
            success: function () {
                Swal.fire(
                    "Éxito",
                    "Proveedor actualizado correctamente",
                    "success",
                );
                tabla.ajax.reload();
                const modal = bootstrap.Modal.getInstance(
                    document.getElementById("modalEditarProveedor"),
                );
                modal.hide();
            },
            error: function () {
                Swal.fire(
                    "Error",
                    "No se pudo actualizar el proveedor",
                    "error",
                );
            },
        });
    });

    // Abrir modal de filtros
    $("#btnFiltrosProveedores").on("click", function () {
        const modal = new bootstrap.Modal(
            document.getElementById("modalFiltrosProveedores"),
        );
        modal.show();
    });

    // Cargar marcas para el filtro
    function cargarMarcasFiltro() {
        $.get("/provedores/marcas", function (marcas) {
            const select = $("#filtroMarca");
            select.empty();
            select.append('<option value="">Todas</option>');

            marcas.forEach(function (marca) {
                select.append(
                    `<option value="${marca.id}">${marca.nombre}</option>`,
                );
            });
        });
    }

    // cargar marcas al iniciar
    cargarMarcasFiltro();

    // Aplicar filtros y recargar tabla
    $("#formFiltrosProveedores").on("submit", function (e) {
        e.preventDefault();
        tabla.ajax.reload();

        const modal = bootstrap.Modal.getInstance(
            document.getElementById("modalFiltrosProveedores"),
        );
        modal.hide();
    });

    // Abrir modal de registro de proveedor
    $("#btnRegistrarProveedor").on("click", function () {
        const modal = $("#modalRegistrarProveedor");

        // Limpiar todos los campos
        modal.find("input, textarea").val("");
        modal.find("select").val("");

        // Cargar marcas en el select
        $.get("/provedores/marcas", function (marcas) {
            const select = $("#nuevoIdCatMarcas");
            select.empty();
            select.append('<option value="">Selecciona una marca</option>');
            marcas.forEach(function (marca) {
                select.append(
                    `<option value="${marca.id}">${marca.nombre}</option>`,
                );
            });
        });

        // Mostrar modal
        new bootstrap.Modal(
            document.getElementById("modalRegistrarProveedor"),
        ).show();
    });

    // Enviar formulario de registro de proveedor
    $("#formRegistrarProveedor").on("submit", function (e) {
        e.preventDefault();
        const formToken = $('meta[name="csrf-token"]').attr("content");

        $.ajax({
            url: "/provedores", // ruta POST en web.php
            type: "POST",
            headers: { "X-CSRF-TOKEN": formToken },
            data: {
                nombre_proveedor: $("#nuevoNombre").val(),
                contacto: $("#nuevoContacto").val(),
                telefono: $("#nuevoTelefono").val(),
                email: $("#nuevoEmail").val(),
                direccion: $("#nuevaDireccion").val(),
                id_cat_marcas: $("#nuevoIdCatMarcas").val(),
            },
            success: function () {
                Swal.fire(
                    "Éxito",
                    "Proveedor registrado correctamente",
                    "success",
                );
                tabla.ajax.reload();
                const modal = bootstrap.Modal.getInstance(
                    document.getElementById("modalRegistrarProveedor"),
                );
                modal.hide();
            },
            error: function (xhr) {
                console.log(xhr.responseJSON); // para depuración
                Swal.fire(
                    "Error",
                    "No se pudo registrar el proveedor",
                    "error",
                );
            },
        });
    });
});
