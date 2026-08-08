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

{{--
    El modal de pago solamente captura datos operativos. Por seguridad nunca se
    solicita el número completo de tarjeta, CVV o NIP.
--}}
<div class="modal fade" id="pagoModal" tabindex="-1" aria-labelledby="pagoModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="formPago" novalidate>
                <div class="modal-header">
                    <h5 class="modal-title" id="pagoModalLabel">Seleccionar forma de pago</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-light border d-flex justify-content-between align-items-center">
                        <span>Total de la compra</span>
                        <strong id="pagoTotal">$0.00</strong>
                    </div>

                    <label for="pagoMetodo" class="form-label">Forma de pago</label>
                    <select class="form-select mb-3" id="pagoMetodo" required>
                        <option value="">Selecciona una opción</option>
                        <option value="efectivo">Efectivo</option>
                        <option value="tarjeta">Tarjeta bancaria</option>
                        <option value="vales">Vales de despensa</option>
                    </select>

                    <div id="pagoEfectivo" class="pago-campos d-none">
                        <label for="montoRecibido" class="form-label">Efectivo recibido</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" id="montoRecibido" min="0" step="0.01">
                        </div>
                        <div class="mt-2 text-end">Cambio: <strong id="pagoCambio">$0.00</strong></div>
                    </div>

                    <div id="pagoTarjeta" class="pago-campos d-none">
                        <div class="row g-3">
                            <div class="col-6">
                                <label for="tipoTarjeta" class="form-label">Tipo</label>
                                <select class="form-select" id="tipoTarjeta">
                                    <option value="credito">Crédito</option>
                                    <option value="debito">Débito</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="marcaTarjeta" class="form-label">Marca</label>
                                <select class="form-select" id="marcaTarjeta">
                                    <option value="visa">Visa</option>
                                    <option value="mastercard">Mastercard</option>
                                    <option value="amex">American Express</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="ultimosCuatro" class="form-label">Últimos 4 dígitos</label>
                                <input type="text" inputmode="numeric" maxlength="4" pattern="[0-9]{4}"
                                    class="form-control" id="ultimosCuatro" placeholder="1234">
                            </div>
                            <div class="col-6">
                                <label for="referenciaTarjeta" class="form-label">Autorización</label>
                                <input type="text" maxlength="100" class="form-control" id="referenciaTarjeta">
                            </div>
                        </div>
                        <p class="small text-muted mt-3 mb-0">No captures el número completo, CVV ni NIP.</p>
                    </div>

                    <div id="pagoVales" class="pago-campos d-none">
                        <label for="emisorVale" class="form-label">Emisor</label>
                        <select class="form-select mb-3" id="emisorVale">
                            <option value="Edenred">Edenred</option>
                            <option value="Sí Vale">Sí Vale</option>
                            <option value="Pluxee">Pluxee</option>
                            <option value="Otro">Otro</option>
                        </select>
                        <label for="referenciaVale" class="form-label">Número de autorización o referencia</label>
                        <input type="text" maxlength="100" class="form-control" id="referenciaVale">
                    </div>

                    <div id="pagoError" class="alert alert-danger d-none mt-3 mb-0"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Confirmar pago</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="envioModal" tabindex="-1" aria-labelledby="envioModalLabel" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="envioModalLabel">🚚 ¡Te lo enviamos a casa!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="formEnvio">
                    @csrf
                    <div class="mb-3">
                        <label for="direccion" class="form-label">**Dirección de entrega**</label>
                        <input type="text" class="form-control" id="direccion" name="direccion"
                            placeholder="Calle, número, colonia..." required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">**Teléfono de contacto**</label>
                        <input type="tel" class="form-control" id="telefono" name="telefono"
                            placeholder="Ej. 5512345678" required>
                    </div>
                    <div class="mb-3">
                        <label for="referencias" class="form-label">**Referencias (Opcional)**</label>
                        <textarea class="form-control" id="referencias" name="referencias" rows="2"
                            placeholder="Color de casa, entre qué calles, etc."></textarea>
                    </div>
                    <div class="modal-footer px-0 pb-0 pt-3 d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Regresar</button>
                        <button type="submit" class="btn btn-success" id="btnGuardarEnvio">Confirmar Envío y Ticket
                            🎉</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
