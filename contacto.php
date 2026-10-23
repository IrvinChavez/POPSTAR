<?php
require_once __DIR__ . '/includes/cuenta-controller.php';
require_once __DIR__ . '/conexion.php';
$notificacion = '';
$tipoNotificacion = '';
$nombre = '';
$correo = '';
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $mensaje = trim($_POST['mensaje'] ?? '');
    $destinatario = getenv('POPSTAR_CONTACT_EMAIL');

    if ($nombre === '' || strlen($nombre) > 120) {
        $notificacion = 'Escribe tu nombre (máximo 120 caracteres).';
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $notificacion = 'Escribe una dirección de correo electrónico válida.';
    } elseif ($mensaje === '' || strlen($mensaje) > 5000) {
        $notificacion = 'Escribe tu mensaje (máximo 5000 caracteres).';
    } elseif (!$destinatario || !filter_var($destinatario, FILTER_VALIDATE_EMAIL)) {
        $notificacion = 'El formulario aún no está configurado para recibir mensajes.';
    } else {
        $consulta = $conexion->prepare(
            'INSERT INTO mensajes_contacto (nombre, correo, mensaje)
             VALUES (:nombre, :correo, :mensaje)'
        );

        $consulta->execute([
            ':nombre' => $nombre,
            ':correo' => $correo,
            ':mensaje' => $mensaje,
        ]);
        $asunto = '=?UTF-8?B?' . base64_encode('Mensaje de contacto - POPSTAR') . '?=';
        $contenido = "Nombre: {$nombre}\r\nCorreo: {$correo}\r\n\r\nMensaje:\r\n{$mensaje}";
        $cabeceras = "From: POPSTAR <{$destinatario}>\r\nReply-To: {$correo}\r\nContent-Type: text/plain; charset=UTF-8";

        if (mail($destinatario, $asunto, $contenido, $cabeceras)) {
            $notificacion = 'Tu mensaje fue enviado. Gracias por contactarnos.';
            $tipoNotificacion = 'exito';
            $nombre = '';
            $correo = '';
            $mensaje = '';
        } else {
            $notificacion = 'No se pudo enviar el mensaje. Inténtalo más tarde.';
        }
    }
}

function escapar($valor)
{
    return htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto | POPSTAR</title>
    <link rel="stylesheet" href="./estilos/contacto.css">
    <link rel="stylesheet" href="./estilos/cuenta.css">
</head>
<body data-descuento-miembro="<?= $cuentaActual ? '10' : '0' ?>">
    <header class="encabezado">
        <a class="marca" href="./index.php">POPSTAR</a>
        <nav class="navegacion" aria-label="Navegación principal">
            <a href="./index.php">Inicio</a>
            <a href="./tienda.php">Tienda</a>
            <a href="./contacto.php" aria-current="page">Contacto</a>
            <?php require __DIR__ . '/includes/boton-cuenta.php'; ?>
        </nav>
    </header>

    <main class="contacto">
        <section class="presentacion">
            <p class="sobrelinea">POPSTAR</p>
            <h1>Contacto</h1>
            <p>Visítanos</p>
        </section>

        <section class="ubicacion" aria-labelledby="titulo-ubicacion">
            <div class="encabezado-seccion">
                <p class="sobrelinea">Encuéntranos</p>
                <h2 id="titulo-ubicacion">Nuestra ubicación</h2>
            </div>
            <div class="mapa">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3501.8309729538137!2d-106.07804732241178!3d28.634827583972843!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x86ea434d97d19423%3A0xd504b74876bc0f1e!2sLa%20nube%20records!5e0!3m2!1ses-419!2smx!4v1790713573640!5m2!1ses-419!2smx"
                    title="Mapa con la ubicación de la tienda ficticia"
                    loading="lazy"
                    referrerpolicy="strict-origin-when-cross-origin"
                    allowfullscreen>
                </iframe>
            </div>
        </section>

        <div class="contacto-detalles">
            <section class="preguntas" aria-labelledby="titulo-preguntas">
                <div class="encabezado-seccion">
                    <p class="sobrelinea">Antes de escribirnos</p>
                    <h2 id="titulo-preguntas">Preguntas frecuentes</h2>
                </div>
                <details>
                    <summary>¿Cuál es el horario de atención?</summary>
                    <p>Nuestro horario de atención es de lunes a viernes de 9:00 a.m. a 6:00 p.m.</p>
                </details>
                <details>
                    <summary>¿Puedo preguntar por la disponibilidad de un álbum?</summary>
                    <p>Sí. Envíanos el nombre del álbum y te ayudaremos a consultar su disponibilidad.</p>
                </details>
                <details>
                    <summary>¿Cómo puedo comunicarme con la tienda?</summary>
                    <p>Puedes llamarnos al número indicado en esta página o enviarnos un mensaje desde el formulario.</p>
                </details>
            </section>

            <section class="datos-contacto" aria-labelledby="titulo-contacto">
                <div class="encabezado-seccion">
                    <p class="sobrelinea">Estamos para ayudarte</p>
                    <h2 id="titulo-contacto">Escríbenos</h2>
                </div>
                <p class="dato"><span>Teléfono</span><a href="tel:+520000000000">+52 000 000 0000</a></p>
                <p class="nota-numero">Reemplaza este ejemplo por tu número personal.</p>

                <?php if ($notificacion !== ''): ?>
                    <p class="notificacion <?= $tipoNotificacion ?>" role="<?= $tipoNotificacion === 'exito' ? 'status' : 'alert' ?>">
                        <?= escapar($notificacion) ?>
                    </p>
                <?php endif; ?>

                <form action="./contacto.php" method="post" novalidate>
                    <label for="nombre">Nombre</label>
                    <input id="nombre" name="nombre" autocomplete="name" maxlength="120" value="<?= escapar($nombre) ?>" required>

                    <label for="correo">Correo electrónico</label>
                    <input id="correo" name="correo" type="email" autocomplete="email" value="<?= escapar($correo) ?>" required>

                    <label for="mensaje">Mensaje</label>
                    <textarea id="mensaje" name="mensaje" rows="5" maxlength="5000" required><?= escapar($mensaje) ?></textarea>

                    <button type="submit">Enviar mensaje</button>
                </form>
                <p class="nota-formulario">Los mensajes se envían al correo configurado en el servidor.</p>
            </section>
        </div>
    </main>
    <?php require __DIR__ . '/includes/modal-cuenta.php'; ?>
    <script src="./js/cuenta.js"></script>
</body>
</html>