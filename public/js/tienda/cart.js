// public/js/tienda/cart.js
window.CartApp = (function () {
    const cartKey = "miCarrito";
    const $ = document.querySelector.bind(document);
    const $$ = document.querySelectorAll.bind(document);

    const readCart = () => JSON.parse(localStorage.getItem(cartKey)) || [];
    const writeCart = (cart) =>
        localStorage.setItem(cartKey, JSON.stringify(cart));
    const formatMoney = (n) =>
        n.toLocaleString("es-MX", { style: "currency", currency: "MXN" });

    const updateCartCount = () => {
        const cart = readCart();
        const count = cart.reduce((sum, item) => sum + (item.cantidad || 0), 0);
        const badge = $("#cartCount");
        if (badge) badge.textContent = count;
    };

    const showToast = (message = "Producto añadido al carrito ✅") => {
        const toastEl = $("#cartToast");
        if (!toastEl) return;
        const body = toastEl.querySelector(".toast-body");
        if (body) body.textContent = message;
        const toast = new bootstrap.Toast(toastEl);
        toast.show();
    };

    const renderCart = () => {
        const cart = readCart();
        const cartBody = $("#cartBody");
        if (!cartBody) return;

        if (cart.length === 0) {
            cartBody.innerHTML =
                '<p class="text-center">Tu carrito está vacío 🛍️</p>';
            return;
        }

        let total = 0;
        let html = `<div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th class="text-center">Cantidad</th>
                                    <th class="text-end">Precio</th>
                                    <th class="text-end">Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>`;

        cart.forEach((item) => {
            const subtotal = item.precio * item.cantidad;
            total += subtotal;
            html += `
                <tr data-id="${item.id}">
                    <td>${item.nombre}</td>
                    <td class="text-center">
                        <input type="number" class="form-control form-control-sm quantity-input"
                               data-id="${item.id}" value="${
                item.cantidad
            }" min="1" style="width: 60px; margin:auto;">
                    </td>
                    <td class="text-end">${formatMoney(item.precio)}</td>
                    <td class="text-end subtotal">${formatMoney(subtotal)}</td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-danger btn-remove" data-id="${
                            item.id
                        }">x</button>
                    </td>
                </tr>`;
        });

        html += `</tbody>
                 <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total:</th>
                        <th id="cartTotal" class="text-end">${formatMoney(
                            total
                        )}</th>
                        <th></th>
                    </tr>
                 </tfoot>
                 </table></div>`;

        cartBody.innerHTML = html;

        // Inputs de cantidad
        const quantityInputs = cartBody.querySelectorAll(".quantity-input");
        quantityInputs.forEach((input) => {
            input.addEventListener("change", (e) => {
                const id = e.target.dataset.id;
                let cantidad = parseInt(e.target.value);
                if (isNaN(cantidad) || cantidad < 1) cantidad = 1;

                const cart = readCart();
                const index = cart.findIndex(
                    (p) => String(p.id) === String(id)
                );
                if (index >= 0) {
                    cart[index].cantidad = cantidad;
                    writeCart(cart);
                }

                updateCartCount();
                renderCart(); // refresca subtotal y total
            });
        });

        // Botones eliminar
        const removeBtns = cartBody.querySelectorAll(".btn-remove");
        removeBtns.forEach((btn) => {
            btn.addEventListener("click", (e) => {
                const id = btn.dataset.id;
                removeItem(id);
            });
        });
    };

    const addItem = ({ id, nombre, precio, cantidad = 1 }) => {
        if (!id) return;
        let cart = readCart();
        const idx = cart.findIndex((p) => String(p.id) === String(id));
        if (idx >= 0) {
            cart[idx].cantidad += cantidad;
        } else {
            cart.push({ id, nombre, precio, cantidad });
        }
        writeCart(cart);
        updateCartCount();
        showToast(`${nombre} añadido al carrito ✅`);
        renderCart();
    };

    const removeItem = (id) => {
        let cart = readCart();
        cart = cart.filter((p) => String(p.id) !== String(id));
        writeCart(cart);
        updateCartCount();
        renderCart();
    };

    const clearCart = () => {
        localStorage.removeItem(cartKey);
        updateCartCount();
        renderCart();
    };

    const checkout = () => {
        const cart = readCart();
        if (cart.length === 0) {
            Swal.fire("Tu carrito está vacío", "", "info");
            return;
        }
        const total = cart.reduce((s, p) => s + p.precio * p.cantidad, 0);
        Swal.fire({
            title: "Confirmar compra",
            text: `Total: ${total.toLocaleString("es-MX", {
                style: "currency",
                currency: "MXN",
            })}`,
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Sí, comprar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                clearCart();
                const modal = bootstrap.Modal.getInstance($("#cartModal"));
                if (modal) modal.hide();
                Swal.fire(
                    "Compra realizada",
                    "Gracias por tu compra 🎉",
                    "success"
                );
            }
        });
    };

    const setupListeners = () => {
        document.addEventListener("click", (e) => {
            const addBtn = e.target.closest(".btn-add");
            if (addBtn) {
                e.preventDefault();
                const id = addBtn.dataset.id;
                const nombre = addBtn.dataset.nombre;
                const precio = parseFloat(addBtn.dataset.precio) || 0;
                const input = document.querySelector(`#cantidad-${id}`);
                const cantidad = Math.max(1, parseInt(input?.value) || 1);
                addItem({ id, nombre, precio, cantidad });
                return;
            }
        });

        const clearBtn = $("#clearCartBtn");
        if (clearBtn) {
            clearBtn.addEventListener("click", () => {
                Swal.fire({
                    title: "Vaciar carrito? 🛍️ ",
                    showCancelButton: true,
                    confirmButtonText: "Sí, vaciar",
                    cancelButtonText: "Cancelar",
                }).then((res) => {
                    if (res.isConfirmed) clearCart();
                });
            });
        }

        const checkoutBtn = $("#checkoutBtn");
        if (checkoutBtn) checkoutBtn.addEventListener("click", checkout);

        const cartModalEl = $("#cartModal");
        if (cartModalEl) {
            cartModalEl.addEventListener("show.bs.modal", renderCart);
        }
    };

    const init = () => {
        setupListeners();
        updateCartCount();
        renderCart();
    };

    document.addEventListener("DOMContentLoaded", init);

    return { addItem, removeItem, clearCart, renderCart, updateCartCount };
})();
