const pantallas = {
    inicio: document.getElementById("pantalla-inicio"),
    preguntas: document.getElementById("pantalla-preguntas"),
    procesando: document.getElementById("pantalla-procesando"),
    resultado: document.getElementById("pantalla-resultado"),
};

const preguntas = [
    {
        titulo: "¿Qué ambiente prefieres para escuchar música?",
        opciones: [
            { titulo: "Una noche tranquila en casa", detalle: "Un sonido íntimo y envolvente", icono: "fa-solid fa-moon", generos: ["indie", "soul", "electronica"] },
            { titulo: "Una fiesta con mucha energía", detalle: "Ritmos que no dejan quedarse quieto", icono: "fa-solid fa-bolt", generos: ["pop", "electronica", "latin"] },
            { titulo: "Un viaje mirando por la ventana", detalle: "Canciones para perderse en el camino", icono: "fa-solid fa-car-side", generos: ["indie", "rock", "latin"] },
            { titulo: "Un concierto lleno de gente", detalle: "Guitarras, coros y emoción", icono: "fa-solid fa-people-group", generos: ["rock", "pop", "hiphop"] },
        ],
    },
    {
        titulo: "¿Qué valoras más de una canción?",
        opciones: [
            { titulo: "El ritmo y el beat", detalle: "Que me haga mover desde el primer segundo", icono: "fa-solid fa-drum", generos: ["hiphop", "electronica", "latin"] },
            { titulo: "La letra y su significado", detalle: "Una historia que se quede conmigo", icono: "fa-solid fa-pen-nib", generos: ["indie", "soul", "latin"] },
            { titulo: "La atmósfera y los instrumentos", detalle: "Un mundo en el que pueda sumergirme", icono: "fa-solid fa-guitar", generos: ["rock", "indie", "soul"] },
            { titulo: "La originalidad del sonido", detalle: "Algo distinto, inesperado y memorable", icono: "fa-solid fa-sliders", generos: ["electronica", "pop", "indie"] },
        ],
    },
    {
        titulo: "Elige la banda sonora de tu día perfecto",
        opciones: [
            { titulo: "Un pop que me suba el ánimo", detalle: "Melodías brillantes y pegadizas", icono: "fa-solid fa-sun", generos: ["pop", "latin"] },
            { titulo: "Indie para ir a mi propio ritmo", detalle: "Descubrir algo que no todos conocen", icono: "fa-solid fa-compass", generos: ["indie", "rock"] },
            { titulo: "Un beat que marque el paso", detalle: "Bajos profundos y ritmo constante", icono: "fa-solid fa-headphones", generos: ["hiphop", "electronica"] },
            { titulo: "Clásicos que nunca fallan", detalle: "Grandes voces y canciones atemporales", icono: "fa-solid fa-star", generos: ["rock", "soul", "pop"] },
        ],
    },
    {
        titulo: "¿Qué instrumento te llama más la atención?",
        opciones: [
            { titulo: "Una guitarra con carácter", detalle: "Distorsión, riffs o acordes acústicos", icono: "fa-solid fa-guitar", generos: ["rock", "indie"] },
            { titulo: "Sintetizadores y sonidos digitales", detalle: "Texturas electrónicas y futuristas", icono: "fa-solid fa-wave-square", generos: ["electronica", "pop"] },
            { titulo: "Un bajo que se sienta", detalle: "El pulso profundo de la canción", icono: "fa-solid fa-compact-disc", generos: ["hiphop", "soul", "latin"] },
            { titulo: "Una voz que lo diga todo", detalle: "Emoción, actitud y personalidad", icono: "fa-solid fa-microphone", generos: ["soul", "pop", "latin"] },
        ],
    },
    {
        titulo: "¿Cómo te gustaría sentirte al terminar una canción?",
        opciones: [
            { titulo: "Con energía para seguir", detalle: "Motivado y con ganas de más", icono: "fa-solid fa-fire", generos: ["rock", "hiphop", "pop"] },
            { titulo: "En paz y en mi propio mundo", detalle: "Como si el tiempo se hubiera detenido", icono: "fa-solid fa-cloud-moon", generos: ["indie", "soul"] },
            { titulo: "Con ganas de bailar", detalle: "Que el ritmo se quede en el cuerpo", icono: "fa-solid fa-person-rays", generos: ["latin", "electronica", "pop"] },
            { titulo: "Con una historia en la cabeza", detalle: "Pensando en cada palabra y detalle", icono: "fa-solid fa-book-open", generos: ["soul", "indie", "hiphop"] },
        ],
    },
];

const perfiles = {
    indie: {
        nombre: "Indie introspectivo",
        descripcion: "Te atraen los sonidos envolventes, las letras que transmiten emociones y la música que convierte cualquier momento en una experiencia personal.",
        generos: ["Indie Rock", "Dream Pop", "Alternative", "Indie Folk"],
        artistas: ["ARCTIC MONKEYS", "TAME IMPALA", "THE STROKES", "LORDE", "RADIOHEAD", "COLDPLAY", "GORILLAZ"],
    },
    pop: {
        nombre: "Pop camaleónico",
        descripcion: "Te gustan las melodías memorables, las grandes voces y los discos que convierten cualquier día en algo especial.",
        generos: ["Pop", "Electropop", "R&B", "Dance Pop"],
        artistas: ["THE WEEKND", "BILLIE EILISH", "MICHAEL JACKSON", "LANA DEL REY", "DUA LIPA", "BEYONCÉ", "KATY PERRY"],
    },
    rock: {
        nombre: "Rock de espíritu libre",
        descripcion: "Buscas canciones con fuerza y personalidad: guitarras que se sienten, grandes coros y discos que siempre revelan algo nuevo.",
        generos: ["Alternative Rock", "Classic Rock", "Grunge", "Indie Rock"],
        artistas: ["NIRVANA", "THE BEATLES", "QUEEN", "PINK FLOYD", "GREEN DAY", "MUSE", "LINKIN PARK", "THE STROKES"],
    },
    electronica: {
        nombre: "Electrónica nocturna",
        descripcion: "Te envuelven las texturas, los beats y los paisajes sonoros que transforman una escucha casual en un viaje.",
        generos: ["Electrónica", "Synthpop", "House", "Downtempo"],
        artistas: ["DAFT PUNK", "AVICII", "PORTER ROBINSON", "ODESZA", "FLUME", "DISCLOSURE", "APHEX TWIN", "MOBY"],
    },
    hiphop: {
        nombre: "Hip-hop consciente",
        descripcion: "Te conectas con el ritmo y con las historias. Para ti, una gran producción y una voz auténtica van de la mano.",
        generos: ["Hip-hop", "Rap", "R&B", "Neo Soul"],
        artistas: ["KENDRICK LAMAR", "NAS", "THE NOTORIOUS B.I.G.", "KANYE WEST", "TRAVIS SCOTT", "DRAKE", "J. COLE"],
    },
    latin: {
        nombre: "Ritmo latino alternativo",
        descripcion: "Te atraen los sonidos con identidad, las mezclas inesperadas y la música que se siente tan cercana como emocionante.",
        generos: ["Latino Alternativo", "Pop Latino", "Rock en Español", "Urbano"],
        artistas: ["SODA STEREO", "BAD BUNNY", "ROSALÍA", "GUSTAVO CERATI", "CAFÉ TACVBA", "NATALIA LAFOURCADE", "MON LAFERTE"],
    },
    soul: {
        nombre: "Soul de madrugada",
        descripcion: "Buscas voces que transmiten y melodías que se quedan contigo. Disfrutas los discos que invitan a escuchar con calma.",
        generos: ["Soul", "R&B", "Jazz", "Neo Soul"],
        artistas: ["FRANK OCEAN", "NINA SIMONE", "MILES DAVIS", "JOHN COLTRANE", "ADELE", "SZA", "BRYSON TILLER"],
    },
};

const tituloPregunta = document.getElementById("titulo-pregunta");
const opcionesPregunta = document.getElementById("opciones-pregunta");
const etapaPregunta = document.getElementById("pregunta-etapa");
const progresoBarra = document.getElementById("progreso-barra");
const progresoTexto = document.getElementById("progreso-texto");
const botonSiguiente = document.getElementById("pregunta-siguiente");
const botonAnterior = document.getElementById("pregunta-anterior");
const carritoContador = document.getElementById("cart-count");
const modalQuiz = document.getElementById("quiz-modal");
const porcentajeDescuentoMiembro = Number(document.body.dataset.descuentoMiembro || 0);
const mensajeQuiz = document.getElementById("quiz-mensaje");
const avisoQuiz = document.getElementById("quiz-aviso");
const textoAvisoQuiz = document.getElementById("quiz-aviso-texto");
const claveQuizPendiente = "popstarQuizPendiente";
let indicePregunta = 0;
let respuestas = Array(preguntas.length).fill(null);

function mostrarPantalla(nombre) {
    Object.entries(pantallas).forEach(([clave, pantalla]) => {
        pantalla.hidden = clave !== nombre;
    });
    document.getElementById("quiz-modal").scrollTop = 0;
}

function mostrarAvisoQuiz(mensaje) {
    textoAvisoQuiz.textContent = mensaje;
    avisoQuiz.hidden = false;
}

function renderizarPregunta() {
    const pregunta = preguntas[indicePregunta];
    const continuacion = indicePregunta >= 2;
    etapaPregunta.textContent = `${continuacion ? "CONTINUACIÓN DEL QUIZ · " : ""}PREGUNTA ${indicePregunta + 1}`;
    tituloPregunta.textContent = pregunta.titulo;
    progresoTexto.textContent = `${indicePregunta + 1} / ${preguntas.length}`;
    progresoBarra.style.width = `${((indicePregunta + 1) / preguntas.length) * 100}%`;
    botonAnterior.hidden = indicePregunta === 0;
    botonSiguiente.innerHTML = indicePregunta === preguntas.length - 1
        ? 'VER MI RESULTADO <i class="fa-solid fa-arrow-right"></i>'
        : 'SIGUIENTE <i class="fa-solid fa-arrow-right"></i>';
    botonSiguiente.disabled = respuestas[indicePregunta] === null;
    opcionesPregunta.replaceChildren();

    pregunta.opciones.forEach((opcion, indice) => {
        const boton = document.createElement("button");
        boton.type = "button";
        boton.className = `opcion${respuestas[indicePregunta] === indice ? " seleccionada" : ""}`;
        boton.setAttribute("aria-pressed", String(respuestas[indicePregunta] === indice));
        const icono = document.createElement("i");
        icono.className = opcion.icono;
        const texto = document.createElement("span");
        texto.className = "opcion-texto";
        const titulo = document.createElement("strong");
        titulo.textContent = opcion.titulo;
        const detalle = document.createElement("small");
        detalle.textContent = opcion.detalle;
        texto.append(titulo, detalle);
        const check = document.createElement("i");
        check.className = "fa-solid fa-circle-check opcion-check";
        check.setAttribute("aria-hidden", "true");
        boton.append(icono, texto, check);
        boton.addEventListener("click", () => {
            respuestas[indicePregunta] = indice;
            renderizarPregunta();
        });
        opcionesPregunta.appendChild(boton);
    });
}

function leerCarrito() {
    try {
        const carrito = JSON.parse(localStorage.getItem("popstar-carrito") || "[]");
        return Array.isArray(carrito) ? carrito : [];
    } catch {
        return [];
    }
}

function actualizarContador() {
    const cantidad = leerCarrito().reduce((total, producto) => total + (Number(producto.cantidad) || 0), 0);
    carritoContador.textContent = cantidad;
}

function agregarAlCarrito(producto) {
    const carrito = leerCarrito();
    const existente = carrito.find((item) => item.id === producto.id
        || (item.titulo === producto.titulo && item.artista === producto.artista));
    if (existente) {
        if (existente.cantidad >= producto.stock) return false;
        Object.assign(existente, producto);
        existente.cantidad = (Number(existente.cantidad) || 0) + 1;
    } else {
        if (producto.stock < 1) return false;
        carrito.push({ ...producto, cantidad: 1 });
    }
    localStorage.setItem("popstar-carrito", JSON.stringify(carrito));
    actualizarContador();
    return true;
}

function renderizarResultado(generosSeleccionados) {
    const perfil = perfiles[generosSeleccionados[0]];
    document.getElementById("perfil-vibe").textContent = perfil.nombre;
    document.getElementById("descripcion-vibe").textContent = perfil.descripcion;
    const generos = document.getElementById("generos-vibe");
    generos.replaceChildren();
    perfil.generos.forEach((genero) => {
        const etiqueta = document.createElement("span");
        etiqueta.textContent = genero;
        generos.appendChild(etiqueta);
    });

    const artistasPrincipales = perfiles[generosSeleccionados[0]].artistas;
    const artistasAlternativos = perfiles[generosSeleccionados[1]].artistas;
    const delPerfilPrincipal = productos.filter((producto) =>
        artistasPrincipales.some((artista) => producto.artista.includes(artista))
    );
    const delPerfilAlternativo = productos.filter((producto) =>
        artistasAlternativos.some((artista) => producto.artista.includes(artista))
    );
    const titulosPrincipales = new Set(delPerfilPrincipal.map((producto) => producto.titulo));
    const productosRecomendados = [
        ...delPerfilPrincipal,
        ...delPerfilAlternativo.filter((producto) => !titulosPrincipales.has(producto.titulo)),
    ].slice(0, 4);
    const albumes = document.getElementById("albumes-resultado");
    albumes.replaceChildren();

    productosRecomendados.forEach((producto) => {
        const tarjeta = document.createElement("article");
        tarjeta.className = "album";
        const imagen = document.createElement("img");
        imagen.src = producto.imagen;
        imagen.alt = `${producto.titulo} - ${producto.artista}`;
        imagen.loading = "lazy";
        const titulo = document.createElement("h3");
        titulo.textContent = producto.titulo;
        const artista = document.createElement("p");
        artista.textContent = producto.artista;
        const pie = document.createElement("div");
        pie.className = "album-pie";
        const precio = document.createElement("span");
        const precioFinal = Math.round(producto.precio * (1 - porcentajeDescuentoMiembro / 100));
        precio.textContent = `$${precioFinal.toLocaleString("es-MX")} MXN`;
        const stock = document.createElement("span");
        stock.className = "stock-recomendacion";
        stock.textContent = producto.stock > 0 ? `Existencias: ${producto.stock}` : "AGOTADO";
        const agregar = document.createElement("button");
        agregar.className = "album-agregar";
        agregar.type = "button";
        agregar.disabled = producto.stock < 1;
        agregar.setAttribute("aria-label", `Agregar ${producto.titulo} al carrito`);
        agregar.innerHTML = '<i class="fa-solid fa-cart-plus" aria-hidden="true"></i>';
        agregar.addEventListener("click", () => {
            if (!agregarAlCarrito(producto)) {
                agregar.disabled = true;
                stock.textContent = "No hay más existencias disponibles.";
                return;
            }
            agregar.innerHTML = '<i class="fa-solid fa-check" aria-hidden="true"></i>';
            agregar.setAttribute("aria-label", `${producto.titulo} agregado al carrito`);
            if (producto.stock <= 1) agregar.disabled = true;
        });
        pie.append(precio, stock, agregar);
        tarjeta.append(imagen, titulo, artista, pie);
        albumes.appendChild(tarjeta);
    });
}

function actualizarHistorialQuiz(id, perfil, realizadoEn) {
    const lista = document.getElementById("historial-quiz-list");
    const sinHistorial = document.getElementById("sin-historial-quiz");
    const nombresPerfiles = {
        indie: "Indie introspectivo",
        pop: "Pop camaleónico",
        rock: "Rock de espíritu libre",
        electronica: "Electrónica nocturna",
        hiphop: "Hip-hop consciente",
        latin: "Ritmo latino alternativo",
        soul: "Soul de madrugada",
    };
    const fecha = new Date(realizadoEn.replace(" ", "T"));
    const elemento = document.createElement("li");
    const nombre = document.createElement("span");
    const hora = document.createElement("time");

    nombre.textContent = nombresPerfiles[perfil] || "Perfil musical";
    hora.dateTime = realizadoEn;
    hora.textContent = Number.isNaN(fecha.getTime())
        ? realizadoEn
        : fecha.toLocaleString("es-MX", { dateStyle: "short", timeStyle: "short" });
    const catalogo = document.createElement("a");
    catalogo.className = "modal-cuenta__ver-catalogo";
    catalogo.href = `./quiz.php?resultado=${encodeURIComponent(id)}`;
    catalogo.textContent = "VER CATÁLOGO";
    elemento.append(nombre, hora, catalogo);
    lista.prepend(elemento);
    lista.hidden = false;
    sinHistorial.hidden = true;
    while (lista.children.length > 20) {
        lista.lastElementChild.remove();
    }
}

async function guardarYMostrarResultado(respuestasQuiz) {
    mostrarPantalla("procesando");
    mensajeQuiz.hidden = true;
    document.getElementById("quiz-reintentar").hidden = true;

    try {
        const respuesta = await fetch("./guardar-quiz.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-Token": document.body.dataset.csrfQuiz,
            },
            body: JSON.stringify({ respuestas: respuestasQuiz }),
        });
        const datos = await respuesta.json().catch(() => ({}));

        if (respuesta.status === 401) {
            sessionStorage.setItem(claveQuizPendiente, JSON.stringify(respuestasQuiz));
            const modalCuenta = document.getElementById("modal-cuenta");
            const avisoCuenta = document.getElementById("aviso-quiz-cuenta");
            avisoCuenta.querySelector("p").textContent = "Para guardar y ver tu resultado, regístrate o inicia sesión. Conservamos tus respuestas mientras completas este paso.";
            avisoCuenta.hidden = false;
            document.getElementById("pestana-registrar")?.click();
            modalCuenta.showModal();
            return;
        }

        if (!respuesta.ok || !Array.isArray(datos.perfiles) || datos.perfiles.length !== 2
            || !Number.isInteger(datos.id) || typeof datos.realizado_en !== "string") {
            throw new Error(datos.error || "No se pudo guardar tu quiz.");
        }

        sessionStorage.removeItem(claveQuizPendiente);
        actualizarHistorialQuiz(datos.id, datos.perfiles[0], datos.realizado_en);
        renderizarResultado(datos.perfiles);
        mostrarPantalla("resultado");
    } catch (error) {
        mostrarAvisoQuiz(error.message || "No se pudo guardar tu resultado. Comprueba tu conexión e inténtalo de nuevo.");
        document.getElementById("quiz-reintentar").hidden = false;
    }
}

document.getElementById("comenzar-quiz").addEventListener("click", () => {
    indicePregunta = 0;
    respuestas = Array(preguntas.length).fill(null);
    renderizarPregunta();
    mostrarPantalla("preguntas");
});

document.getElementById("volver-inicio").addEventListener("click", () => mostrarPantalla("inicio"));

botonAnterior.addEventListener("click", () => {
    if (indicePregunta > 0) {
        indicePregunta--;
        renderizarPregunta();
    }
});

botonSiguiente.addEventListener("click", () => {
    if (respuestas[indicePregunta] === null) return;
    if (indicePregunta < preguntas.length - 1) {
        indicePregunta++;
        renderizarPregunta();
        return;
    }

    botonSiguiente.disabled = true;
    window.setTimeout(() => guardarYMostrarResultado(respuestas.slice()), 1200);
});

document.getElementById("repetir-quiz").addEventListener("click", () => {
    document.getElementById("quiz-reintentar").hidden = true;
    respuestas = Array(preguntas.length).fill(null);
    indicePregunta = 0;
    renderizarPregunta();
    mostrarPantalla("inicio");
});

document.getElementById("quiz-reintentar").addEventListener("click", () => {
    guardarYMostrarResultado(respuestas);
});

const quizPendiente = sessionStorage.getItem(claveQuizPendiente);
if (quizPendiente && document.body.dataset.cuentaIniciada === "1") {
    try {
        const respuestasPendientes = JSON.parse(quizPendiente);
        if (Array.isArray(respuestasPendientes)
            && respuestasPendientes.length === preguntas.length
            && respuestasPendientes.every((respuesta) => Number.isInteger(respuesta) && respuesta >= 0 && respuesta < 4)) {
            respuestas = respuestasPendientes;
            const parametrosCuenta = new URLSearchParams(window.location.search);
            if (parametrosCuenta.get("cuenta") === "1") {
                document.getElementById("modal-cuenta").addEventListener("close", () => guardarYMostrarResultado(respuestas), { once: true });
            } else {
                guardarYMostrarResultado(respuestas);
            }
        } else {
            sessionStorage.removeItem(claveQuizPendiente);
        }
    } catch {
        sessionStorage.removeItem(claveQuizPendiente);
    }
}

try {
    const catalogoHistorico = JSON.parse(document.body.dataset.catalogoHistorico || "null");
    if (Array.isArray(catalogoHistorico) && catalogoHistorico.length === 2) {
        renderizarResultado(catalogoHistorico);
        mostrarPantalla("resultado");
    }
} catch {
    mostrarAvisoQuiz("No se pudo cargar el catálogo guardado.");
}

if (document.body.dataset.errorHistorico) {
    mostrarAvisoQuiz(document.body.dataset.errorHistorico);
}

window.addEventListener("storage", (evento) => {
    if (evento.key === "popstar-carrito") actualizarContador();
});

actualizarContador();
if (typeof modalQuiz.showModal === "function") {
    modalQuiz.removeAttribute("open");
    modalQuiz.showModal();
}
modalQuiz.addEventListener("cancel", (evento) => {
    evento.preventDefault();
    window.location.href = "./index.php";
});
