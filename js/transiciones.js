(() => {
    const duracionSalida = 230;
    const movimientoReducido = window.matchMedia("(prefers-reduced-motion: reduce)");

    window.addEventListener("pageshow", () => {
        document.body.classList.remove("pagina-saliendo");
    });

    document.addEventListener("click", (evento) => {
        if (
            evento.defaultPrevented ||
            evento.button !== 0 ||
            evento.metaKey ||
            evento.ctrlKey ||
            evento.shiftKey ||
            evento.altKey ||
            movimientoReducido.matches
        ) {
            return;
        }

        const enlace = evento.target instanceof Element
            ? evento.target.closest("a[href]")
            : null;
        if (
            !enlace ||
            enlace.hasAttribute("download") ||
            (enlace.target && enlace.target !== "_self")
        ) {
            return;
        }

        const destino = new URL(enlace.href, window.location.href);
        if (
            destino.origin !== window.location.origin ||
            (destino.pathname === window.location.pathname &&
                destino.search === window.location.search)
        ) {
            return;
        }

        evento.preventDefault();
        document.body.classList.add("pagina-saliendo");
        window.setTimeout(() => {
            window.location.assign(destino.href);
        }, duracionSalida);
    });
})();
