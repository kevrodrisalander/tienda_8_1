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
                .then(response => {
                    if (!response.ok) {
                        throw new Error('No fue posible obtener la descripción');
                    }

                    return response.json();
                })
                .then(data => {
                    modalBody.textContent = data.detalle || 'Sin descripción disponible';
                })
                .catch(() => {
                    modalBody.innerHTML = '<p class="text-danger">No fue posible cargar la descripción.</p>';
                });

        });
    });

});
