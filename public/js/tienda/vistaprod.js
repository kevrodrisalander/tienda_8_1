document.addEventListener('DOMContentLoaded', function () {

    // Selecciona todos los botones de observaciones
    document.querySelectorAll('.btn-observaciones').forEach(btn => {
        btn.addEventListener('click', function () {

            const productoId = this.dataset.id; // id del producto
            const modalBody = document.getElementById('modal-body-' + productoId);

            // Mensaje mientras carga
            modalBody.innerHTML = '<p class="text-muted">Cargando observaciones...</p>';

            // Petición AJAX a la ruta del controlador
            fetch(`/producto/${productoId}/observaciones`)
                .then(response => response.json())
                .then(data => {
                    // Reemplaza saltos de línea por <br> para HTML
                    modalBody.innerHTML = data.observaciones
                        ? data.observaciones.replace(/\n/g, '<br>')
                        : '<p class="text-muted">Sin observaciones</p>';
                })
                .catch(() => {
                    modalBody.innerHTML = '<p class="text-danger">Error al cargar observaciones</p>';
                });

        });
    });

});
