<!DOCTYPE html>
<html lang="es">



<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>POPSTAR</title>

    <!-- Precarga de imagen para móviles -->
    <link
        rel="preload"
        as="image"
        href="./imagenes/movil.webp"
        media="(max-width: 600px)"
        fetchpriority="high"
    >

    <!-- Precarga de imagen para escritorio -->
    <link
        rel="preload"
        as="image"
        href="./imagenes/imagen.webp"
        media="(min-width: 601px)"
        fetchpriority="high"
    >

    <link rel="stylesheet" href="./estilos/index.css?v=3">
    <link rel="stylesheet" href="./estilos/transiciones.css?v=1">
</head>



<body>
    <main class="general">
        <section id="inicio" class="contenido">

            <h1><span>✦</span>POPSTAR<span>✦</span></h1>

            <nav class="navegacion">
                
                <a href="./index.php">INICIO</a>

                <span>•</span>

                <a href="./tienda.php">TIENDA</a>

                <span>•</span>

                <a href="./quiz.php">QUIZ</a>

                <span>•</span>

                <a href="./contacto.php">CONTACTO</a>

            </nav>

        </section>

    </main>

    <script src="./js/transiciones.js?v=1"></script>
</body>

</html>