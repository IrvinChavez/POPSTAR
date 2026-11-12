const busquedaDisco = document.getElementById("buscar-disco");
const filtroEstadoDisco = document.getElementById("filtro-estado-disco");
const tarjetasDisco = Array.from(document.querySelectorAll(".gestion-disco"));
const contadorDiscos = document.getElementById("contador-discos");
const sinResultadosDiscos = document.getElementById("sin-resultados-discos");
const paginacionDiscos = document.getElementById("paginacion-discos");
const paginaAnteriorDiscos = document.getElementById("pagina-anterior-discos");
const paginaSiguienteDiscos = document.getElementById("pagina-siguiente-discos");
const numerosPaginaDiscos = document.getElementById("numeros-pagina-discos");
const estadoPaginacionDiscos = document.getElementById("estado-paginacion-discos");
const discosPorPagina = 10;
const botonesPaginaVisibles = 5;
let paginaActualDiscos = 1;
let totalDiscosFiltrados = 0;

function normalizarTextoDisco(texto) {
    return texto
        .normalize("NFD")
        .replace(/[\u0300-\u036f]/g, "")
        .toLocaleLowerCase("es");
}

function actualizarInventarioDiscos() {
    const termino = normalizarTextoDisco(busquedaDisco.value.trim());
    const estadoSeleccionado = filtroEstadoDisco.value;
    const discosFiltrados = tarjetasDisco.filter((tarjeta) => {
        const coincideTexto = normalizarTextoDisco(tarjeta.dataset.busqueda).includes(termino);
        const coincideEstado = estadoSeleccionado === "todos"
            || tarjeta.dataset.estado === estadoSeleccionado;
        return coincideTexto && coincideEstado;
    });
    totalDiscosFiltrados = discosFiltrados.length;
    const totalPaginas = Math.ceil(discosFiltrados.length / discosPorPagina);

    if (paginaActualDiscos > totalPaginas) {
        paginaActualDiscos = Math.max(1, totalPaginas);
    }

    const inicio = (paginaActualDiscos - 1) * discosPorPagina;
    const fin = Math.min(inicio + discosPorPagina, discosFiltrados.length);
    const discosPagina = new Set(discosFiltrados.slice(inicio, fin));

    tarjetasDisco.forEach((tarjeta) => {
        tarjeta.hidden = !discosPagina.has(tarjeta);
    });

    const mostrandoDesde = discosFiltrados.length === 0 ? 0 : inicio + 1;
    contadorDiscos.textContent = `Mostrando ${mostrandoDesde}–${fin} de ${discosFiltrados.length} discos (total: ${tarjetasDisco.length})`;
    sinResultadosDiscos.hidden = discosFiltrados.length !== 0;
    paginacionDiscos.hidden = totalPaginas <= 1;
    estadoPaginacionDiscos.textContent = `Página ${paginaActualDiscos} de ${totalPaginas}`;
    paginaAnteriorDiscos.disabled = paginaActualDiscos <= 1;
    paginaSiguienteDiscos.disabled = paginaActualDiscos >= totalPaginas;

    const primeraPagina = Math.max(
        1,
        Math.min(
            paginaActualDiscos - Math.floor(botonesPaginaVisibles / 2),
            totalPaginas - botonesPaginaVisibles + 1
        )
    );
    const ultimaPagina = Math.min(totalPaginas, primeraPagina + botonesPaginaVisibles - 1);
    const botonesPagina = [];

    for (let pagina = primeraPagina; pagina <= ultimaPagina; pagina += 1) {
        const boton = document.createElement("button");
        boton.type = "button";
        boton.textContent = String(pagina);
        boton.dataset.pagina = String(pagina);
        boton.setAttribute("aria-label", `Página ${pagina}`);
        if (pagina === paginaActualDiscos) {
            boton.setAttribute("aria-current", "page");
        }
        botonesPagina.push(boton);
    }

    numerosPaginaDiscos.replaceChildren(...botonesPagina);
}

if (busquedaDisco && filtroEstadoDisco && contadorDiscos && sinResultadosDiscos
    && paginacionDiscos && paginaAnteriorDiscos && paginaSiguienteDiscos
    && numerosPaginaDiscos && estadoPaginacionDiscos) {
    busquedaDisco.addEventListener("input", () => {
        paginaActualDiscos = 1;
        actualizarInventarioDiscos();
    });
    filtroEstadoDisco.addEventListener("change", () => {
        paginaActualDiscos = 1;
        actualizarInventarioDiscos();
    });
    paginaAnteriorDiscos.addEventListener("click", () => {
        if (paginaActualDiscos > 1) {
            paginaActualDiscos -= 1;
            actualizarInventarioDiscos();
        }
    });
    paginaSiguienteDiscos.addEventListener("click", () => {
        const totalPaginas = Math.ceil(totalDiscosFiltrados / discosPorPagina);
        if (paginaActualDiscos < totalPaginas) {
            paginaActualDiscos += 1;
            actualizarInventarioDiscos();
        }
    });
    numerosPaginaDiscos.addEventListener("click", (evento) => {
        const boton = evento.target.closest("button[data-pagina]");
        if (!boton || !numerosPaginaDiscos.contains(boton)) return;

        paginaActualDiscos = Number(boton.dataset.pagina);
        actualizarInventarioDiscos();
    });
    actualizarInventarioDiscos();
}

const codigoDisco = document.querySelector("[data-codigo-disco]");
const tituloDisco = document.querySelector("[data-titulo-disco]");
const artistaDisco = document.querySelector("[data-artista-disco]");

if (codigoDisco && tituloDisco && artistaDisco) {
    const actualizarCodigo = () => {
        if (codigoDisco.dataset.editado === "true") return;
        codigoDisco.value = [tituloDisco.value, artistaDisco.value]
            .filter(Boolean)
            .join(" ")
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "")
            .toLocaleLowerCase("es")
            .replace(/[^a-z0-9]+/g, "-")
            .replace(/^-|-$/g, "");
    };

    codigoDisco.addEventListener("input", () => {
        codigoDisco.dataset.editado = codigoDisco.value !== "" ? "true" : "false";
        if (codigoDisco.value === "") actualizarCodigo();
    });
    tituloDisco.addEventListener("input", actualizarCodigo);
    artistaDisco.addEventListener("input", actualizarCodigo);
}
