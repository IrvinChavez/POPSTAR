<?php require_once __DIR__ . '/includes/cuenta-controller.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>POPSTAR | Tienda</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet" href="./estilos/tienda.css">
    <link rel="stylesheet" href="./estilos/cuenta.css">
</head>

<body data-descuento-miembro="<?= $cuentaActual ? '10' : '0' ?>">

    <header class="encabezado">

        <a href="./index.php" class="logo"><span>✦</span> POPSTAR <span>✦</span></a>

        <nav class="navegacion">

            <a href="./index.php">INICIO</a>

            <a href="./tienda.php" class="activo">TIENDA</a>

            <a href="./contacto.php">CONTACTO</a>

            <?php require __DIR__ . '/includes/boton-cuenta.php'; ?>

        </nav>

        <div class="acciones">

            <button class="icono" aria-label="Buscar">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>

            <span class="separador"></span>

            <a href="./carrito.php" class="icono carrito" aria-label="Carrito">
                <i class="fa-solid fa-cart-shopping"></i>
                <span id="cart-count" class="contador">0</span>
            </a>

        </div>

    </header>

    <main>

        <section class="tienda-hero">

            <h1 class="title"><span>✦</span> TIENDA <span>✦</span></h1>

            <p class="subtitle">VINILOS QUE CUENTAN HISTORIAS</p>

            <div class="linea"></div>

            <div class="carousel-container">

                <button class="nav-btn prev" aria-label="Anterior">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>

                <div class="carousel">
                </div>

                <button class="nav-btn next" aria-label="Siguiente">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>

            </div>

            <div class="product-info">

                <h2 id="album-title">AFTER HOURS</h2>

                <p id="album-artist">THE WEEKND</p>

                <p id="album-price">$850 MXN</p>
                <p id="etiqueta-descuento-miembro" class="etiqueta-descuento-miembro" hidden>PRECIO DE MIEMBRO: 10% MENOS</p>

                <button id="add-to-cart" class="btn-buy">
                    <i class="fa-solid fa-cart-shopping"></i>
                    AGREGAR AL CARRITO
                </button>

            </div>

        </section>



    </main>

    <?php require __DIR__ . '/includes/modal-cuenta.php'; ?>
    <script src="./js/productos.js"></script>
    <script src="./js/tienda.js"></script>
    <script src="./js/cuenta.js"></script>

</body>

</html>
