const carousel = document.querySelector(".carousel");
const prevBtn = document.querySelector(".prev");
const nextBtn = document.querySelector(".next");
const indicators = document.querySelector(".indicators");

const albumTitle = document.getElementById("album-title");
const albumArtist = document.getElementById("album-artist");
const albumPrice = document.getElementById("album-price");
const addToCartBtn = document.getElementById("add-to-cart");
const cartCount = document.getElementById("cart-count");

let currentIndex = 0;

const CLAVE_CARRITO = "popstar-carrito";

function leerCarrito() {
    try {
        return JSON.parse(localStorage.getItem(CLAVE_CARRITO)) || [];
    } catch {
        return [];
    }
}

function guardarCarrito(carrito) {
    try {
        localStorage.setItem(CLAVE_CARRITO, JSON.stringify(carrito));
    } catch {
    }
}

let carrito = leerCarrito();

function actualizarContador() {
    cartCount.textContent = carrito.reduce((suma, p) => suma + p.cantidad, 0);
}

productos.forEach((producto, i) => {
    const card = document.createElement("div");
    card.classList.add("card");
    card.innerHTML = `<img src="${producto.imagen}" alt="${producto.titulo} - ${producto.artista}">`;
    card.addEventListener("click", () => irA(i));
    carousel.appendChild(card);

    const punto = document.createElement("button");
    punto.setAttribute("aria-label", `Ver ${producto.titulo}`);
    punto.addEventListener("click", () => irA(i));
    indicators.appendChild(punto);
});

function updateCarousel() {
    const cards = document.querySelectorAll(".card");
    const puntos = document.querySelectorAll(".indicators button");
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
        puntos[i].classList.toggle("active", offset === 0);
    });

    const actual = productos[currentIndex];
    albumTitle.textContent = actual.titulo;
    albumArtist.textContent = actual.artista;
    albumPrice.textContent = `$${actual.precio} MXN`;
}

function irA(i) {
    currentIndex = (i + productos.length) % productos.length;
    updateCarousel();
}

prevBtn.addEventListener("click", () => irA(currentIndex - 1));
nextBtn.addEventListener("click", () => irA(currentIndex + 1));

document.addEventListener("keydown", (e) => {
    if (e.key === "ArrowLeft") irA(currentIndex - 1);
    if (e.key === "ArrowRight") irA(currentIndex + 1);
});

addToCartBtn.addEventListener("click", () => {
    const actual = productos[currentIndex];
    const enCarrito = carrito.find((p) => p.titulo === actual.titulo);

    if (enCarrito) {
        enCarrito.cantidad++;
    } else {
        carrito.push({ ...actual, cantidad: 1 });
    }

    guardarCarrito(carrito);

    const portada = document.querySelector(".card.active img");
    animarAlCarrito(portada, actualizarContador);
});

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

window.addEventListener("resize", updateCarousel);

actualizarContador();
updateCarousel();
