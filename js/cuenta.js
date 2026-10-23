const modalCuenta = document.getElementById("modal-cuenta");
const pestanasCuenta = document.querySelectorAll("[data-pestana]");

function seleccionarPestanaCuenta(nombre) {
    const formularios = document.querySelectorAll(".modal-cuenta__formulario");
    const formularioSeleccionado = Array.from(formularios).find(
        (formulario) => formulario.dataset.panel === nombre
    );
    document.querySelectorAll(".modal-cuenta__pestana").forEach((pestana) => {
        const seleccionada = pestana.dataset.pestana === nombre;
        pestana.setAttribute("aria-selected", String(seleccionada));
    });

    formularios.forEach((formulario) => {
        if (formulario !== formularioSeleccionado) {
            formulario.hidden = true;
            formulario.inert = true;
            formulario.getAnimations().forEach((animacion) => animacion.cancel());
        }
    });

    if (!formularioSeleccionado) return;

    formularioSeleccionado.hidden = false;
    formularioSeleccionado.inert = false;

    if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) return;

    formularioSeleccionado.getAnimations().forEach((animacion) => animacion.cancel());
    formularioSeleccionado.animate(
        [
            { opacity: 0, transform: "translateY(8px)" },
            { opacity: 1, transform: "translateY(0)" },
        ],
        { duration: 220, easing: "ease-out" }
    );
}

document.querySelectorAll("[data-abrir-cuenta]").forEach((boton) => {
    boton.addEventListener("click", () => {
        seleccionarPestanaCuenta("registrar");
        modalCuenta.showModal();
    });
});

pestanasCuenta.forEach((control) => {
    control.addEventListener("click", () => seleccionarPestanaCuenta(control.dataset.pestana));
});

document.querySelectorAll("[data-cerrar-cuenta]").forEach((boton) => {
    boton.addEventListener("click", () => modalCuenta.close());
});

modalCuenta.addEventListener("click", (evento) => {
    if (evento.target === modalCuenta) {
        modalCuenta.close();
    }
});

const parametrosCuenta = new URLSearchParams(window.location.search);
if (parametrosCuenta.get("cuenta") === "1") {
    seleccionarPestanaCuenta(parametrosCuenta.get("tab") === "iniciar" ? "iniciar" : "registrar");
    modalCuenta.showModal();
    window.history.replaceState(null, "", window.location.pathname);
}
