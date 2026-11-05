const CLAVE_CARRITO = "popstar-carrito";
const COSTO_ENVIO = 120;

const listaProductos = document.getElementById("lista-productos");
const listaRecomendados = document.getElementById("lista-recomendados");
const contenido = document.getElementById("carrito-contenido");
const carritoVacio = document.getElementById("carrito-vacio");
const compraExitosa = document.getElementById("compra-exitosa");
const cartCount = document.getElementById("cart-count");
const mensajeCarrito = document.getElementById("mensaje-carrito");

const totalProductos = document.getElementById("total-productos");
const resumenArticulos = document.getElementById("resumen-articulos");
const resumenSubtotal = document.getElementById("resumen-subtotal");
const resumenEnvio = document.getElementById("resumen-envio");
const resumenTotal = document.getElementById("resumen-total");
const filaDescuentoMiembro = document.getElementById("fila-descuento-miembro");
const resumenDescuentoMiembro = document.getElementById("resumen-descuento-miembro");
const porcentajeDescuentoMiembro = Number(document.body.dataset.descuentoMiembro || 0);

const finalizarBtn = document.getElementById("finalizar-compra");
const flechaPrev = document.querySelector(".flecha-prev");
const flechaNext = document.querySelector(".flecha-next");

function leerCarrito() {
    try {
        return JSON.parse(localStorage.getItem(CLAVE_CARRITO)) || [];
    } catch {
        return [];
    }
}

function guardarCarrito() {
    try {
        localStorage.setItem(CLAVE_CARRITO, JSON.stringify(carrito));
    } catch {
    }
}

let carrito = leerCarrito().map((articulo) => {
    const productoCatalogo = productos.find((producto) =>
        producto.id === Number(articulo.id)
        || (producto.titulo === articulo.titulo && producto.artista === articulo.artista)
    );
    return productoCatalogo
        ? { ...productoCatalogo, cantidad: Math.max(1, Math.floor(Number(articulo.cantidad) || 1)) }
        : { ...articulo, id: Number(articulo.id) || 0, cantidad: Math.max(1, Math.floor(Number(articulo.cantidad) || 1)) };
});

function mostrarMensajeCarrito(mensaje) {
    mensajeCarrito.textContent = mensaje;
    mensajeCarrito.hidden = false;
}

function ocultarMensajeCarrito() {
    mensajeCarrito.textContent = "";
    mensajeCarrito.hidden = true;
}

function formatoPrecio(cantidad) {
    return `$${cantidad.toLocaleString("es-MX")} MXN`;
}

function precioConDescuento(precio) {
    return Math.round(precio * (1 - porcentajeDescuentoMiembro / 100) * 100) / 100;
}

function tipoTitulo(texto) {
    return texto.toLowerCase().replace(/(^|\s)\S/g, (letra) => letra.toUpperCase());
}

function crearProducto(producto, i) {
    const li = document.createElement("li");
    li.classList.add("producto");

    li.innerHTML = `
        <div class="producto-info">
            <button class="btn-eliminar" aria-label="Eliminar producto">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <img class="producto-portada" alt="">
            <div class="producto-texto">
                <h3></h3>
                <p class="artista"></p>
                <p class="formato">Vinilo | Nuevo</p>
                <p class="stock-articulo"></p>
            </div>
        </div>

        <p class="precio"></p>

        <div class="cantidad">
            <button class="menos" aria-label="Quitar uno"><i class="fa-solid fa-minus"></i></button>
            <span></span>
            <button class="mas" aria-label="Agregar uno"><i class="fa-solid fa-plus"></i></button>
        </div>

        <p class="subtotal"></p>
    `;

    const img = li.querySelector("img");
    img.src = producto.imagen;
    img.alt = `${producto.titulo} - ${producto.artista}`;

    li.querySelector("h3").textContent = producto.titulo;
    li.querySelector(".artista").textContent = tipoTitulo(producto.artista);
    li.querySelector(".stock-articulo").textContent = producto.stock > 0
        ? `Existencias: ${producto.stock}`
        : "AGOTADO";
    li.querySelector(".precio").textContent = formatoPrecio(precioConDescuento(producto.precio));
    li.querySelector(".cantidad span").textContent = producto.cantidad;
    li.querySelector(".subtotal").textContent = formatoPrecio(precioConDescuento(producto.precio) * producto.cantidad);

    li.querySelector(".menos").addEventListener("click", () => cambiarCantidad(i, -1));
    const botonMas = li.querySelector(".mas");
    botonMas.disabled = producto.cantidad >= producto.stock;
    botonMas.addEventListener("click", () => cambiarCantidad(i, 1));
    li.querySelector(".btn-eliminar").addEventListener("click", () => eliminarProducto(i));

    return li;
}

function crearRecomendado(producto) {
    const li = document.createElement("li");
    li.classList.add("recomendado");

    li.innerHTML = `
        <img alt="">
        <div class="recomendado-texto">
            <h3></h3>
            <p class="artista"></p>
            <p class="precio-reco"></p>
        </div>
        <button class="btn-agregar" aria-label="Agregar al carrito">
            <i class="fa-solid fa-cart-shopping"></i>
        </button>
    `;

    const img = li.querySelector("img");
    img.src = producto.imagen;
    img.alt = `${producto.titulo} - ${producto.artista}`;

    li.querySelector("h3").textContent = producto.titulo;
    li.querySelector("h3").title = producto.titulo;
    li.querySelector(".artista").textContent = tipoTitulo(producto.artista);
    li.querySelector(".precio-reco").textContent = formatoPrecio(precioConDescuento(producto.precio));
    const enCarrito = carrito.find((articulo) => articulo.id === producto.id)?.cantidad || 0;
    const stock = document.createElement("p");
    stock.className = "stock-recomendado";
    stock.textContent = producto.stock > 0 ? `Existencias: ${producto.stock}` : "AGOTADO";
    li.querySelector(".recomendado-texto").appendChild(stock);

    const botonAgregar = li.querySelector(".btn-agregar");
    botonAgregar.disabled = producto.stock < 1 || enCarrito >= producto.stock;
    botonAgregar.addEventListener("click", (e) => {
        li.classList.add("saliendo");
        if (!agregarProducto(producto)) {
            li.classList.remove("saliendo");
            botonAgregar.disabled = true;
            mostrarMensajeCarrito("No hay más existencias disponibles de ese disco.");
            return;
        }
        e.currentTarget.disabled = true;
        animarAlCarrito(img, mostrarCarrito);
    });

    return li;
}

function mostrarCarrito() {
    const articulos = carrito.reduce((suma, p) => suma + p.cantidad, 0);
    cartCount.textContent = articulos;

    mostrarRecomendados();

    if (carrito.length === 0) {
        contenido.classList.add("oculto");
        if (compraExitosa.classList.contains("oculto")) {
            carritoVacio.classList.remove("oculto");
        }
        return;
    }

    contenido.classList.remove("oculto");
    carritoVacio.classList.add("oculto");
    compraExitosa.classList.add("oculto");

    listaProductos.innerHTML = "";
    carrito.forEach((producto, i) => {
        listaProductos.appendChild(crearProducto(producto, i));
    });

    const subtotalOriginal = carrito.reduce((suma, p) => suma + p.precio * p.cantidad, 0);
    const subtotal = carrito.reduce((suma, p) => suma + precioConDescuento(p.precio) * p.cantidad, 0);
    const descuentoMiembro = subtotalOriginal - subtotal;

    totalProductos.textContent = articulos;
    resumenArticulos.textContent = articulos;
    resumenSubtotal.textContent = formatoPrecio(subtotalOriginal);
    filaDescuentoMiembro.hidden = porcentajeDescuentoMiembro === 0;
    resumenDescuentoMiembro.textContent = `-${formatoPrecio(descuentoMiembro)}`;
    resumenEnvio.textContent = formatoPrecio(COSTO_ENVIO);
    resumenTotal.textContent = formatoPrecio(subtotalOriginal - descuentoMiembro + COSTO_ENVIO);
}

function mostrarRecomendados() {
    const recomendados = productos.filter(
        (producto) => !carrito.some((p) => p.id === producto.id && p.cantidad >= producto.stock)
    );

    listaRecomendados.innerHTML = "";
    recomendados.forEach((producto) => {
        listaRecomendados.appendChild(crearRecomendado(producto));
    });
}

function agregarProducto(producto) {
    const enCarrito = carrito.find((p) => p.id === producto.id);

    if (enCarrito) {
        if (enCarrito.cantidad >= producto.stock) return false;
        enCarrito.cantidad++;
    } else {
        if (producto.stock < 1) return false;
        carrito.push({ ...producto, cantidad: 1 });
    }

    guardarCarrito();
    return true;
}

function animarAlCarrito(portada, alTerminar) {
    const icono = cartCount.parentElement;
    const sinMovimiento = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

    if (!portada || sinMovimiento) {
        alTerminar();
        rebotarCarrito(icono);
        return;
    }

    const inicio = portada.getBoundingClientRect();
    const destino = icono.getBoundingClientRect();

    const clon = portada.cloneNode();
    clon.classList.add("disco-volando");
    clon.style.left = `${inicio.left}px`;
    clon.style.top = `${inicio.top}px`;
    clon.style.width = `${inicio.width}px`;
    clon.style.height = `${inicio.height}px`;
    document.body.appendChild(clon);

    const dx = destino.left + destino.width / 2 - (inicio.left + inicio.width / 2);
    const dy = destino.top + destino.height / 2 - (inicio.top + inicio.height / 2);

    const vuelo = clon.animate(
        [
            { transform: "translate(0, 0) scale(1) rotate(0deg)", borderRadius: "4px", opacity: 1 },
            { transform: `translate(${dx * 0.15}px, -60px) scale(0.8) rotate(-10deg)`, borderRadius: "20%", opacity: 1, offset: 0.3 },
            { transform: `translate(${dx}px, ${dy}px) scale(0.1) rotate(30deg)`, borderRadius: "50%", opacity: 0.5 }
        ],
        { duration: 900, easing: "cubic-bezier(0.55, 0, 0.35, 1)" }
    );

    let terminado = false;
    const aterrizar = () => {
        if (terminado) return;
        terminado = true;
        clon.remove();
        alTerminar();
        rebotarCarrito(icono);
    };

    vuelo.onfinish = aterrizar;
    setTimeout(aterrizar, 1000);
}

function rebotarCarrito(icono) {
    icono.classList.remove("rebote");
    void icono.offsetWidth;
    icono.classList.add("rebote");
}

function cambiarCantidad(i, cambio) {
    if (cambio > 0 && carrito[i].cantidad >= carrito[i].stock) {
        mostrarMensajeCarrito("No puedes agregar más unidades: alcanzaste las existencias disponibles.");
        return;
    }

    carrito[i].cantidad += cambio;

    if (carrito[i].cantidad <= 0) {
        carrito.splice(i, 1);
    }

    guardarCarrito();
    mostrarCarrito();
}

function eliminarProducto(i) {
    carrito.splice(i, 1);
    guardarCarrito();
    mostrarCarrito();
}

finalizarBtn.addEventListener("click", async () => {
    ocultarMensajeCarrito();
    finalizarBtn.disabled = true;

    try {
        const respuesta = await fetch("./registrar-compra.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-Token": document.body.dataset.csrfCarrito,
            },
            body: JSON.stringify({
                articulos: carrito.map((articulo) => ({
                    id: Number(articulo.id),
                    cantidad: Number(articulo.cantidad),
                })),
            }),
        });
        const datos = await respuesta.json().catch(() => ({}));

        if (datos.stocks) {
            Object.entries(datos.stocks).forEach(([id, stock]) => {
                const producto = productos.find((articulo) => articulo.id === Number(id));
                if (producto) producto.stock = Number(stock);
            });
            carrito = carrito.map((articulo) => ({
                ...articulo,
                stock: productos.find((producto) => producto.id === articulo.id)?.stock ?? articulo.stock,
            }));
        }

        if (!respuesta.ok || !Number.isInteger(datos.pedido)) {
            throw new Error(datos.error || "No se pudo confirmar el pedido.");
        }

        carrito = [];
        guardarCarrito();
        compraExitosa.classList.remove("oculto");
        mostrarCarrito();
    } catch (error) {
        mostrarMensajeCarrito(error.message || "No se pudo confirmar el pedido. Inténtalo de nuevo.");
        mostrarCarrito();
    } finally {
        finalizarBtn.disabled = false;
    }
});

function moverRecomendados(direccion) {
    const tarjeta = listaRecomendados.querySelector(".recomendado");
    if (!tarjeta) return;

    listaRecomendados.scrollBy({ left: direccion * (tarjeta.offsetWidth + 12) });
}

flechaPrev.addEventListener("click", () => moverRecomendados(-1));
flechaNext.addEventListener("click", () => moverRecomendados(1));

mostrarCarrito();
