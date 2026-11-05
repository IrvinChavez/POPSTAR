const carousel = document.querySelector(".carousel");
const prevBtn = document.querySelector(".prev");
const nextBtn = document.querySelector(".next");
const albumTitle = document.getElementById("album-title");
const albumArtist = document.getElementById("album-artist");
const albumPrice = document.getElementById("album-price");
const addToCartBtn = document.getElementById("add-to-cart");
const cartCount = document.getElementById("cart-count");
const carouselIndicador = document.getElementById("carousel-indicador");
const etiquetaDescuentoMiembro = document.getElementById("etiqueta-descuento-miembro");
const stockProducto = document.getElementById("stock-producto");
const porcentajeDescuentoMiembro = Number(document.body.dataset.descuentoMiembro || 0);

let currentIndex = 0;

const CLAVE_CARRITO = "popstar-carrito";

// Recupera los productos guardados en el almacenamiento local.
function leerCarrito() {
    try {
        return JSON.parse(localStorage.getItem(CLAVE_CARRITO)) || [];
    } catch {
        return [];
    }
}

// Guarda el carrito actualizado en el almacenamiento local.
function guardarCarrito(carrito) {
    try {
        localStorage.setItem(CLAVE_CARRITO, JSON.stringify(carrito));
    } catch {
    }
}

let carrito = leerCarrito();

function mismoDisco(item, producto) {
    return item.id === producto.id
        || (item.titulo === producto.titulo && item.artista === producto.artista);
}

// Calcula y muestra la cantidad total de productos en el carrito.
function actualizarContador() {
    cartCount.textContent = carrito.reduce((suma, p) => suma + p.cantidad, 0);
}

// Crea una portada interactiva por cada producto disponible.
productos.forEach((producto, i) => {
    const card = document.createElement("div");
    card.classList.add("card");
    card.innerHTML = `<img src="${producto.imagen}" alt="${producto.titulo} - ${producto.artista}">`;
    // Permite seleccionar directamente una portada del carrusel.
    card.addEventListener("click", () => irA(i));
    carousel.appendChild(card);
});

// Acomoda las portadas y actualiza la información del álbum seleccionado.
function updateCarousel() {
    const cards = document.querySelectorAll(".card");
    const total = productos.length;
    const separacion = carousel.offsetWidth / 7;

    cards.forEach((card, i) => {
        let offset = i - currentIndex;
        if (offset > total / 2) offset -= total;
        if (offset < -total / 2) offset += total;

        const distancia = Math.abs(offset);
        const escala = offset === 0 ? 1 : 0.85 - distancia * 0.05;
        const giro = offset === 0 ? 0 : (offset > 0 ? -25 : 25);

        card.style.transform =
            `translate(-50%, -50%) translateX(${offset * separacion}px) scale(${escala}) rotateY(${giro}deg)`;
        card.style.zIndex = 10 - distancia;
        card.style.opacity = distancia > 3 ? 0 : 1 - distancia * 0.15;
        card.style.pointerEvents = distancia > 3 ? "none" : "auto";

        card.classList.toggle("active", offset === 0);
    });

    const actual = productos[currentIndex];
    carouselIndicador.textContent = `${currentIndex + 1} / ${total}`;
    albumTitle.textContent = actual.titulo;
    albumArtist.textContent = actual.artista;
    if (porcentajeDescuentoMiembro > 0) {
        const precioMiembro = Math.round(actual.precio * (1 - porcentajeDescuentoMiembro / 100));
        albumPrice.innerHTML = `<del>$${actual.precio} MXN</del> <strong>$${precioMiembro} MXN</strong>`;
        etiquetaDescuentoMiembro.hidden = false;
    } else {
        albumPrice.textContent = `$${actual.precio} MXN`;
        etiquetaDescuentoMiembro.hidden = true;
    }
    const enCarrito = carrito.find((producto) => mismoDisco(producto, actual))?.cantidad || 0;
    stockProducto.textContent = actual.stock > 0 ? `Existencias: ${actual.stock}` : "AGOTADO";
    addToCartBtn.disabled = actual.stock < 1 || enCarrito >= actual.stock;
}

// Cambia el álbum activo y mantiene el índice dentro de los límites.
function irA(i) {
    currentIndex = (i + productos.length) % productos.length;
    updateCarousel();
}

// Mueve el carrusel al álbum anterior o siguiente.
prevBtn.addEventListener("click", () => irA(currentIndex - 1));
nextBtn.addEventListener("click", () => irA(currentIndex + 1));

// Permite navegar el carrusel con las flechas del teclado.
document.addEventListener("keydown", (e) => {
    if (e.key === "ArrowLeft") irA(currentIndex - 1);
    if (e.key === "ArrowRight") irA(currentIndex + 1);
});

// Añade el álbum seleccionado al carrito e inicia la animación.
addToCartBtn.addEventListener("click", () => {
    const actual = productos[currentIndex];
    const enCarrito = carrito.find((p) => mismoDisco(p, actual));

    if (enCarrito) {
        if (enCarrito.cantidad >= actual.stock) {
            addToCartBtn.disabled = true;
            stockProducto.textContent = "Alcanzaste las existencias disponibles de este disco.";
            return;
        }
        Object.assign(enCarrito, actual);
        enCarrito.cantidad++;
    } else {
        carrito.push({ ...actual, cantidad: 1 });
    }

    guardarCarrito(carrito);
    updateCarousel();

    const portada = document.querySelector(".card.active img");
    animarAlCarrito(portada, actualizarContador);
});

// Anima la portada hacia el carrito y actualiza el contador al terminar.
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

    portada.animate(
        [{ transform: "scale(1)" }, { transform: "scale(0.88)" }, { transform: "scale(1)" }],
        { duration: 450, easing: "ease-out" }
    );

    const vuelo = clon.animate(
        [
            { transform: "translate(0, 0) scale(1) rotate(0deg)", borderRadius: "4px", opacity: 1 },
            { transform: `translate(${dx * 0.15}px, -60px) scale(0.7) rotate(-10deg)`, borderRadius: "20%", opacity: 1, offset: 0.3 },
            { transform: `translate(${dx}px, ${dy}px) scale(0.06) rotate(30deg)`, borderRadius: "50%", opacity: 0.5 }
        ],
        { duration: 900, easing: "cubic-bezier(0.55, 0, 0.35, 1)" }
    );

    let terminado = false;
    // Completa la animación y actualiza el carrito una sola vez.
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

// Reinicia y reproduce la animación visual del icono del carrito.
function rebotarCarrito(icono) {
    icono.classList.remove("rebote");
    void icono.offsetWidth;
    icono.classList.add("rebote");
}

// Recalcula la distribución cuando cambia el tamaño de pantalla.
window.addEventListener("resize", updateCarousel);

actualizarContador();
updateCarousel();
