<?php
require_once __DIR__ . '/includes/cuenta-controller.php';
require_once __DIR__ . '/includes/quiz-result.php';
require_once __DIR__ . '/includes/catalogo-controller.php';

$catalogoHistorico = null;
$errorCatalogoHistorico = '';
$resultadoSolicitado = $_GET['resultado'] ?? null;
if ($resultadoSolicitado !== null) {
    if (!is_string($resultadoSolicitado) || !ctype_digit($resultadoSolicitado) || (int) $resultadoSolicitado < 1) {
        http_response_code(400);
        $errorCatalogoHistorico = 'El resultado solicitado no es válido.';
    } elseif (!$cuentaActual || !is_int($cuentaActual['id'] ?? null)) {
        http_response_code(401);
        $errorCatalogoHistorico = 'Inicia sesión con la cuenta que realizó este quiz para ver su catálogo.';
    } else {
        require_once __DIR__ . '/conexion.php';
        $consultaCatalogo = $conexion->prepare(
            'SELECT respuestas_json
             FROM resultados_quiz
             WHERE id = :id AND usuario_id = :usuario_id'
        );
        $consultaCatalogo->execute([
            ':id' => (int) $resultadoSolicitado,
            ':usuario_id' => $cuentaActual['id'],
        ]);
        $respuestasCatalogo = json_decode((string) $consultaCatalogo->fetchColumn(), true);
        $catalogoHistorico = is_array($respuestasCatalogo)
            ? perfilesDeRespuestasQuiz($respuestasCatalogo)
            : null;

        if ($catalogoHistorico === null) {
            http_response_code(404);
            $errorCatalogoHistorico = 'No se encontró el catálogo para ese resultado en tu cuenta.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POPSTAR | Descubre tu vibe</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Playfair+Display:wght@500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="./estilos/quiz.css?v=6">
    <link rel="stylesheet" href="./estilos/cuenta.css?v=6">
    <link rel="stylesheet" href="./estilos/transiciones.css?v=1">
</head>

<body data-descuento-miembro="<?= $cuentaActual ? '10' : '0' ?>"
    data-cuenta-iniciada="<?= $cuentaActual ? '1' : '0' ?>"
    data-csrf-quiz="<?= htmlspecialchars($csrfCuenta, ENT_QUOTES, 'UTF-8') ?>"
    data-catalogo-historico="<?= htmlspecialchars(json_encode($catalogoHistorico, JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8') ?>"
    data-error-historico="<?= htmlspecialchars($errorCatalogoHistorico, ENT_QUOTES, 'UTF-8') ?>">
    <header class="encabezado">
        <a href="./index.php" class="logo"><span>✦</span> POPSTAR</a>
        <nav class="navegacion" aria-label="Navegación principal">
            <a href="./index.php">INICIO</a>
            <a href="./tienda.php">TIENDA</a>
            <a href="./quiz.php" class="activo" aria-current="page">QUIZ</a>
            <a href="./contacto.php">CONTACTO</a>
            <?php require __DIR__ . '/includes/boton-cuenta.php'; ?>
        </nav>
        <a href="./carrito.php" class="icono carrito" aria-label="Ir al carrito">
            <i class="fa-solid fa-cart-shopping"></i>
            <span id="cart-count" class="contador">0</span>
        </a>
    </header>

    <dialog id="quiz-modal" class="quiz-modal" open aria-label="Quiz POPSTAR VIBE">
        <a class="quiz-modal__cerrar" href="./index.php" aria-label="Cerrar quiz">&times;</a>
        <main class="quiz">
        <aside id="quiz-aviso" class="quiz-aviso" role="alert" aria-live="assertive" hidden>
            <p id="quiz-aviso-texto"></p>
            <button type="button" class="quiz-aviso__cerrar" data-cerrar-aviso="quiz-aviso" aria-label="Cerrar aviso">&times;</button>
        </aside>
        <section id="pantalla-inicio" class="pantalla inicio" aria-labelledby="titulo-inicio">
            <div class="inicio-contenido">
                <p class="sobrelinea">POPSTAR VIBE</p>
                <h1 id="titulo-inicio">DESCUBRE<br>TU SONIDO</h1>
                <p class="intro-texto">Responde unas preguntas y descubre qué tipo de música encaja contigo.</p>
                <ul class="beneficios">
                    <li><i class="fa-solid fa-music"></i><span>Preguntas sobre<br>tu estilo de vida</span></li>
                    <li><i class="fa-solid fa-chart-simple"></i><span>Resultados<br>personalizados</span></li>
                    <li><i class="fa-solid fa-record-vinyl"></i><span>Álbumes de nuestra<br>tienda para ti</span></li>
                </ul>
                <button id="comenzar-quiz" class="boton boton-principal">COMENZAR QUIZ <i class="fa-solid fa-arrow-right"></i></button>
            </div>
            <div class="portada-decorativa" aria-hidden="true"><i class="fa-solid fa-record-vinyl"></i></div>
        </section>

        <section id="pantalla-preguntas" class="pantalla preguntas" hidden aria-labelledby="titulo-pregunta">
            <div class="preguntas-cabecera">
                <button id="volver-inicio" class="enlace-volver"><i class="fa-solid fa-arrow-left"></i> SALIR</button>
                <div class="progreso" aria-label="Progreso del quiz">
                    <div class="progreso-fondo"><span id="progreso-barra"></span></div>
                    <span id="progreso-texto">1 / 5</span>
                </div>
            </div>
            <p id="pregunta-etapa" class="sobrelinea">PREGUNTA 1</p>
            <h1 id="titulo-pregunta"></h1>
            <div id="opciones-pregunta" class="opciones"></div>
            <div class="preguntas-acciones">
                <button id="pregunta-anterior" class="boton boton-secundario" hidden><i class="fa-solid fa-arrow-left"></i> ANTERIOR</button>
                <button id="pregunta-siguiente" class="boton boton-principal" disabled>SIGUIENTE <i class="fa-solid fa-arrow-right"></i></button>
            </div>
        </section>

        <section id="pantalla-procesando" class="pantalla procesando" hidden aria-live="polite">
            <div class="disco-animado"><i class="fa-solid fa-record-vinyl"></i></div>
            <p class="sobrelinea">POPSTAR VIBE</p>
            <h1>ANALIZANDO<br>TUS RESPUESTAS...</h1>
            <p>Estamos encontrando el estilo musical que mejor se adapta a ti.</p>
            <p id="quiz-mensaje" role="alert" hidden></p>
            <button id="quiz-reintentar" class="boton boton-principal" type="button" hidden>REINTENTAR</button>
        </section>

        <section id="pantalla-resultado" class="pantalla resultado" hidden aria-labelledby="titulo-resultado">
            <div class="resultado-portada" aria-hidden="true"><i class="fa-solid fa-headphones-simple"></i></div>
            <div class="resultado-cuerpo">
                <p class="sobrelinea">POPSTAR VIBE · TU RESULTADO</p>
                <h1 id="titulo-resultado">Tu vibe es:<br><span id="perfil-vibe"></span></h1>
                <p id="descripcion-vibe" class="descripcion-vibe"></p>
                <h2>TUS GÉNEROS RECOMENDADOS</h2>
                <div id="generos-vibe" class="generos"></div>
                <div class="recomendaciones-cabecera">
                    <h2>ÁLBUMES QUE PODRÍAN GUSTARTE</h2>
                    <a href="./tienda.php">VER TODA LA TIENDA <i class="fa-solid fa-arrow-right"></i></a>
                </div>
                <div id="albumes-resultado" class="albumes"></div>
                <div class="final-quiz">
                    <div>
                        <p class="sobrelinea">¿TE GUSTARÍA EXPLORAR OTRO ESTILO?</p>
                        <p>Puedes volver a hacer el quiz cuando quieras.</p>
                    </div>
                    <button id="repetir-quiz" class="boton boton-principal">REALIZAR QUIZ DE NUEVO</button>
                </div>
            </div>
        </section>
        </main>
    </dialog>

    <?php require __DIR__ . '/includes/modal-cuenta.php'; ?>
    <script>window.popstarProductos = <?= $jsonProductosCatalogo ?>;</script>
    <script src="./js/productos.js?v=2"></script>
    <script src="./js/quiz.js?v=6"></script>
    <script src="./js/cuenta.js?v=5"></script>
    <script src="./js/transiciones.js?v=1"></script>
</body>

</html>
