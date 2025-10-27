<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        {{-- <h5 class="modal-title" id="cartModalLabel">🛒 Carrito</h5> --}}
        <h5 class="modal-title" id="cartModalLabel" style="color: #000;">🛒 Carrito</h5>

        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body" id="cartBody">
        <p class="text-center">Tu carrito está vacío 🛍️</p>
      </div>

      <div class="modal-footer d-flex justify-content-between align-items-center">
        <div>
          <button type="button" class="btn btn-danger" id="clearCartBtn">🗑 Vaciar carrito</button>
        </div>
        <div>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Seguir comprando</button>
          <button type="button" class="btn btn-success" id="checkoutBtn">Finalizar compra</button>
        </div>
      </div>
    </div>
  </div>
</div>
