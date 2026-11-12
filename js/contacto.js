(() => {
    const formulario = document.querySelector(".datos-contacto form");
    const notificacion = document.getElementById("notificacion-formulario");

    if (!(formulario instanceof HTMLFormElement) || !(notificacion instanceof HTMLElement)) {
        return;
    }

    formulario.addEventListener("submit", (evento) => {
        evento.preventDefault();

        const nombre = formulario.elements.namedItem("nombre").value.trim();
        const correo = formulario.elements.namedItem("correo").value.trim();
        const mensaje = formulario.elements.namedItem("mensaje").value.trim();
        const correoValido = formulario.elements.namedItem("correo").validity.valid;
        const destinatario = formulario.dataset.destinatario;

        notificacion.classList.remove("exito");
        notificacion.setAttribute("role", "alert");

        if (!nombre || !correo || !mensaje) {
            notificacion.textContent = "Favor de llenar todos los campos.";
            notificacion.hidden = false;
            return;
        }

        if (!correoValido) {
            notificacion.textContent = "Escribe una dirección de correo electrónico válida.";
            notificacion.hidden = false;
            return;
        }

        if (!destinatario) {
            notificacion.textContent = "El formulario aún no está configurado para recibir mensajes.";
            notificacion.hidden = false;
            return;
        }

        const asunto = encodeURIComponent("Mensaje de contacto - POPSTAR");
        const contenido = encodeURIComponent(`Nombre: ${nombre}\nCorreo: ${correo}\n\nMensaje:\n${mensaje}`);
        const urlGmail = `https://mail.google.com/mail/?view=cm&fs=1&to=${encodeURIComponent(destinatario)}&su=${asunto}&body=${contenido}`;

        window.open(urlGmail, "_blank", "noopener,noreferrer");

        notificacion.textContent = "Si Gmail no se abrió automáticamente, ";
        notificacion.setAttribute("role", "status");
        notificacion.hidden = false;

        const enlaceGmail = document.createElement("a");
        enlaceGmail.href = urlGmail;
        enlaceGmail.target = "_blank";
        enlaceGmail.rel = "noopener noreferrer";
        enlaceGmail.textContent = "haz clic aquí para redactar tu correo";
        notificacion.append(enlaceGmail);
    });
})();
