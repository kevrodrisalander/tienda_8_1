/**
 * Administra exclusivamente la captura del pago.
 * Devuelve una promesa para mantener al carrito desacoplado del contenido del modal.
 */
window.PaymentApp = (function () {
    const money = new Intl.NumberFormat("es-MX", {
        style: "currency",
        currency: "MXN",
    });

    let total = 0;
    let resolver = null;

    const byId = (id) => document.getElementById(id);

    function showError(message) {
        const box = byId("pagoError");
        box.textContent = message;
        box.classList.toggle("d-none", !message);
    }

    function showFields(method) {
        document.querySelectorAll(".pago-campos").forEach((section) => {
            section.classList.add("d-none");
        });
        if (method) {
            const section = byId(`pago${method[0].toUpperCase()}${method.slice(1)}`);
            if (section) section.classList.remove("d-none");
        }
        showError("");
    }

    function calculateChange() {
        const received = Number(byId("montoRecibido").value || 0);
        byId("pagoCambio").textContent = money.format(Math.max(0, received - total));
    }

    function paymentData() {
        const method = byId("pagoMetodo").value;
        if (!method) throw new Error("Selecciona una forma de pago.");

        if (method === "efectivo") {
            const received = Number(byId("montoRecibido").value || 0);
            if (received < total) throw new Error("El efectivo recibido es menor al total.");
            return { metodo: method, monto_recibido: received };
        }

        if (method === "tarjeta") {
            const lastFour = byId("ultimosCuatro").value.trim();
            const reference = byId("referenciaTarjeta").value.trim();
            if (!/^\d{4}$/.test(lastFour)) throw new Error("Captura exactamente los últimos 4 dígitos.");
            if (!reference) throw new Error("Captura el número de autorización de la tarjeta.");
            return {
                metodo: method,
                tipo_tarjeta: byId("tipoTarjeta").value,
                marca_tarjeta: byId("marcaTarjeta").value,
                ultimos_cuatro: lastFour,
                referencia: reference,
            };
        }

        const issuer = byId("emisorVale").value;
        const reference = byId("referenciaVale").value.trim();
        if (!reference) throw new Error("Captura la autorización o referencia de los vales.");
        return { metodo: method, emisor_vale: issuer, referencia: reference };
    }

    function open(amount) {
        total = Number(amount);
        const form = byId("formPago");
        form.reset();
        byId("pagoTotal").textContent = money.format(total);
        byId("pagoCambio").textContent = money.format(0);
        showFields("");

        const modal = bootstrap.Modal.getOrCreateInstance(byId("pagoModal"));
        modal.show();

        return new Promise((resolve) => {
            resolver = resolve;
        });
    }

    document.addEventListener("DOMContentLoaded", () => {
        byId("pagoMetodo")?.addEventListener("change", (event) => showFields(event.target.value));
        byId("montoRecibido")?.addEventListener("input", calculateChange);

        byId("formPago")?.addEventListener("submit", (event) => {
            event.preventDefault();
            try {
                const data = paymentData();
                bootstrap.Modal.getInstance(byId("pagoModal"))?.hide();
                const complete = resolver;
                resolver = null;
                complete?.(data);
            } catch (error) {
                showError(error.message);
            }
        });

        byId("pagoModal")?.addEventListener("hidden.bs.modal", () => {
            if (resolver) {
                resolver(null);
                resolver = null;
            }
        });
    });

    return { open };
})();
