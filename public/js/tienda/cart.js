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
                               data-id="${item.id}" value="${item.cantidad}" min="1"
                               max="${item.stock ?? 0}" style="width: 60px; margin:auto;">
                    </td>
                    <td class="text-end">${formatMoney(item.precio)}</td>
                    <td class="text-end subtotal">${formatMoney(subtotal)}</td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-danger btn-remove" data-id="${item.id}">x</button>
                    </td>
                </tr>`;
        });

        html += `</tbody>
                 <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total:</th>
                        <th id="cartTotal" class="text-end">${formatMoney(total)}</th>
                        <th></th>
                    </tr>
                 </tfoot>
                 </table></div>`;

        cartBody.innerHTML = html;

        // Inputs de cantidad con validación de stock
        const quantityInputs = cartBody.querySelectorAll(".quantity-input");
        quantityInputs.forEach((input) => {
            input.addEventListener("input", (e) => {
                const id = e.target.dataset.id;
                const max = parseInt(e.target.max) || 0;
                const min = parseInt(e.target.min) || 1;
                let cantidad = parseInt(e.target.value) || min;

                if (cantidad > max) cantidad = max;
                if (cantidad < min) cantidad = min;

                e.target.value = cantidad;

                const cart = readCart();
                const index = cart.findIndex(
                    (p) => String(p.id) === String(id),
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

    const addItem = ({ id, nombre, precio, cantidad = 1, stock = 0 }) => {
        if (!id) return;
        let cart = readCart();
        const idx = cart.findIndex((p) => String(p.id) === String(id));
        cantidad = Math.min(cantidad, stock); // no permitir más que stock
        if (cantidad < 1) return;

        if (idx >= 0) {
            cart[idx].cantidad = Math.min(cart[idx].cantidad + cantidad, stock);
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

        const csrfMeta = document.querySelector('meta[name="csrf-token"]');
        const csrfToken = csrfMeta ? csrfMeta.getAttribute("content") : null;

        if (!csrfToken) {
            console.error("CSRF token no encontrado.");
            return;
        }

        const total = cart.reduce((s, p) => s + p.precio * p.cantidad, 0);

        Swal.fire({
            title: "Confirmar compra",
            text: `Total: ${total.toLocaleString("es-MX", { style: "currency", currency: "MXN" })}`,
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Sí, comprar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                fetch("/checkout", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                    },
                    body: JSON.stringify({ cart }),
                })
                    .then((res) => res.json())
                    .then((data) => {
                        const idPedido = data.id_pedido; // 👈 aquí lo tienes
                        // abrir modal de envío y pasar idPedido
                        const envioModal = new bootstrap.Modal(
                            document.getElementById("envioModal"),
                        );
                        envioModal.show();

                        // guardar idPedido en un hidden input del formulario
                        document
                            .getElementById("formEnvio")
                            .insertAdjacentHTML(
                                "beforeend",
                                `<input type="hidden" name="id_pedido" value="${idPedido}">`,
                            );
                    });

                clearCart();
                const modal = bootstrap.Modal.getInstance(
                    document.getElementById("cartModal"),
                );
                if (modal) modal.hide();
                Swal.fire(
                    "Compra realizada",
                    "Gracias por tu compra 🎉",
                    "success",
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
                const stock = parseInt(input?.max) || 0;

                addItem({ id, nombre, precio, cantidad, stock });
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

        //Desabilitar botton
        document.querySelectorAll(".btn-add").forEach((btn) => {
            const id = btn.dataset.id;
            const input = document.querySelector(`#cantidad-${id}`);
            if (parseInt(input?.max) === 0) {
                btn.disabled = true;
                btn.textContent = "Agotado";
                btn.classList.remove("btn-primary"); // quitar azul
                btn.classList.add("btn-danger"); // poner rojo
            }
        });
    };

    const init = () => {
        setupListeners();
        updateCartCount();
        renderCart();
    };

    document.addEventListener("DOMContentLoaded", init);

    return { addItem, removeItem, clearCart, renderCart, updateCartCount };
})();

document.addEventListener("DOMContentLoaded", () => {
    const formEnvio = document.getElementById("formEnvio");
    if (formEnvio) {
        formEnvio.addEventListener("submit", function (e) {
            e.preventDefault();

            const data = {
                direccion: document.getElementById("direccion").value,
                telefono: document.getElementById("telefono").value,
                referencias: document.getElementById("referencias").value,
            };

            fetch("/envios/info", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]',
                    ).content,
                },
                body: JSON.stringify(data),
            })
                .then((res) => res.json())
                .then((res) => {
                    if (res.success) {
                        Swal.fire(
                            "Información guardada ✅",
                            "Tu pedido será enviado a casa",
                            "success",
                        );
                        const envioModal = bootstrap.Modal.getInstance(
                            document.getElementById("envioModal"),
                        );
                        envioModal.hide();
                    }
                })
                .catch((err) => console.error(err));
        });
    }
});
