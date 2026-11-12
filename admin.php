<?php
require_once __DIR__ . '/includes/cuenta-controller.php';
require_once __DIR__ . '/includes/admin-controller.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POPSTAR | Gestión</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="./estilos/tienda.css?v=3">
    <link rel="stylesheet" href="./estilos/admin.css?v=3">
    <link rel="stylesheet" href="./estilos/cuenta.css?v=6">
    <link rel="stylesheet" href="./estilos/transiciones.css?v=1">
</head>
<body>
    <header class="encabezado">
        <a href="./index.php" class="logo"><span>✦</span> POPSTAR <span>✦</span></a>
        <nav class="navegacion">
            <a href="./index.php">INICIO</a>
            <a href="./tienda.php">TIENDA</a>
            <a href="./admin.php" class="activo">GESTIÓN</a>
            <?php require __DIR__ . '/includes/boton-cuenta.php'; ?>
        </nav>
    </header>

    <main class="panel-gestion">
        <h1>Panel de gestión</h1>
        <p>Sesión: <?= htmlspecialchars($cuentaActual['nombre'], ENT_QUOTES, 'UTF-8') ?>
            (<?= $rolAdmin === 'administrador' ? 'Administrador' : 'Empleado' ?>)</p>

        <?php if ($mensajeAdmin): ?>
            <p class="gestion-mensaje <?= htmlspecialchars($mensajeAdmin['tipo'], ENT_QUOTES, 'UTF-8') ?>" role="<?= $mensajeAdmin['tipo'] === 'error' ? 'alert' : 'status' ?>">
                <?= htmlspecialchars($mensajeAdmin['texto'], ENT_QUOTES, 'UTF-8') ?>
            </p>
        <?php endif; ?>

        <section class="gestion-seccion">
            <h2>Agregar empleado</h2>
            <form class="gestion-formulario" method="post">
                <input type="hidden" name="csrf_cuenta" value="<?= htmlspecialchars($csrfCuenta, ENT_QUOTES, 'UTF-8') ?>">
                <input type="hidden" name="accion_admin" value="agregar_empleado">
                <label>Nombre completo<input name="nombre_empleado" type="text" maxlength="120" required></label>
                <label>Correo electrónico<input name="correo_empleado" type="email" maxlength="254" required></label>
                <label>Contraseña inicial<input name="contrasena_empleado" type="password" minlength="8" maxlength="72" autocomplete="new-password" required></label>
                <button type="submit">Crear empleado</button>
            </form>
            <h3>Empleados registrados (<?= count($empleados) ?>)</h3>
            <?php if ($empleados): ?>
                <ul class="gestion-empleados">
                    <?php foreach ($empleados as $empleado): ?>
                        <li>
                            <strong><?= htmlspecialchars($empleado['nombre'], ENT_QUOTES, 'UTF-8') ?></strong>
                            <span><?= htmlspecialchars($empleado['correo'], ENT_QUOTES, 'UTF-8') ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Aún no hay empleados registrados.</p>
            <?php endif; ?>
        </section>

        <section class="gestion-seccion">
            <h2>Agregar disco al catálogo</h2>
            <p class="gestion-ayuda">Completa los datos del disco. Para el código usa letras minúsculas y guiones, por ejemplo <code>album-artista</code>.</p>
            <form class="gestion-formulario gestion-formulario--disco" method="post">
                <input type="hidden" name="csrf_cuenta" value="<?= htmlspecialchars($csrfCuenta, ENT_QUOTES, 'UTF-8') ?>">
                <input type="hidden" name="accion_admin" value="agregar_disco">
                <label>Código único<input name="codigo" type="text" maxlength="180" pattern="[a-z0-9]+(-[a-z0-9]+)*" placeholder="album-artista" data-codigo-disco required></label>
                <label>Título<input name="titulo" type="text" maxlength="200" data-titulo-disco required></label>
                <label>Artista<input name="artista" type="text" maxlength="200" data-artista-disco required></label>
                <label>Precio (MXN)<input name="precio" type="number" min="0.01" max="99999999.99" step="0.01" placeholder="850.00" required></label>
                <label>Ruta de imagen o URL HTTPS<input name="imagen" type="text" maxlength="1024" placeholder="./imagenes/albums/album.webp" required></label>
                <label>Existencias<input name="stock" type="number" min="0" max="1000000" step="1" value="5" required></label>
                <button type="submit"><i class="fa-solid fa-plus"></i> Agregar disco</button>
            </form>
        </section>

        <section class="gestion-seccion" id="inventario-discos">
            <h2>Inventario de discos</h2>
            <div class="gestion-filtros">
                <label for="buscar-disco">Buscar por título, artista o código</label>
                <input id="buscar-disco" type="search" placeholder="Ej. After Hours, The Weeknd..." autocomplete="off">
                <label for="filtro-estado-disco">Mostrar</label>
                <select id="filtro-estado-disco">
                    <option value="todos">Todos los discos</option>
                    <option value="disponible">Solo disponibles</option>
                    <option value="retirado">Solo retirados</option>
                </select>
                <p id="contador-discos" class="gestion-ayuda" role="status" aria-live="polite">
                    Mostrando <?= count($productosAdmin) ?> de <?= count($productosAdmin) ?> discos
                </p>
            </div>
            <p id="sin-resultados-discos" class="gestion-sin-resultados" hidden>No se encontraron discos con esa búsqueda.</p>
            <div id="lista-discos-admin">
            <?php foreach ($productosAdmin as $producto): ?>
                <article
                    class="gestion-disco <?= (int) $producto['activo'] === 1 ? '' : 'gestion-disco--retirado' ?>"
                    data-busqueda="<?= htmlspecialchars($producto['titulo'] . ' ' . $producto['artista'] . ' ' . $producto['codigo'], ENT_QUOTES, 'UTF-8') ?>"
                    data-estado="<?= (int) $producto['activo'] === 1 ? 'disponible' : 'retirado' ?>">
                    <div class="gestion-disco__titulo">
                        <h3><?= htmlspecialchars($producto['titulo'], ENT_QUOTES, 'UTF-8') ?></h3>
                        <span><?= (int) $producto['activo'] === 1 ? 'Disponible' : 'Retirado' ?></span>
                    </div>
                    <details class="gestion-edicion">
                        <summary>Editar detalles</summary>
                        <form class="gestion-formulario gestion-formulario--disco" method="post">
                            <input type="hidden" name="csrf_cuenta" value="<?= htmlspecialchars($csrfCuenta, ENT_QUOTES, 'UTF-8') ?>">
                            <input type="hidden" name="accion_admin" value="actualizar_disco">
                            <input type="hidden" name="id_disco" value="<?= (int) $producto['id'] ?>">
                            <label>Código único<input name="codigo" type="text" maxlength="180" pattern="[a-z0-9]+(-[a-z0-9]+)*" value="<?= htmlspecialchars($producto['codigo'], ENT_QUOTES, 'UTF-8') ?>" required></label>
                            <label>Título<input name="titulo" type="text" maxlength="200" value="<?= htmlspecialchars($producto['titulo'], ENT_QUOTES, 'UTF-8') ?>" required></label>
                            <label>Artista<input name="artista" type="text" maxlength="200" value="<?= htmlspecialchars($producto['artista'], ENT_QUOTES, 'UTF-8') ?>" required></label>
                            <label>Precio (MXN)<input name="precio" type="number" min="0.01" max="99999999.99" step="0.01" value="<?= htmlspecialchars((string) $producto['precio'], ENT_QUOTES, 'UTF-8') ?>" required></label>
                            <label>Imagen<input name="imagen" type="text" maxlength="1024" value="<?= htmlspecialchars($producto['imagen'], ENT_QUOTES, 'UTF-8') ?>" required></label>
                            <label>Existencias<input name="stock" type="number" min="0" max="1000000" step="1" value="<?= (int) $producto['stock'] ?>" required></label>
                            <button type="submit">Guardar cambios</button>
                        </form>
                    </details>
                    <form class="gestion-estado" method="post">
                        <input type="hidden" name="csrf_cuenta" value="<?= htmlspecialchars($csrfCuenta, ENT_QUOTES, 'UTF-8') ?>">
                        <input type="hidden" name="id_disco" value="<?= (int) $producto['id'] ?>">
                        <?php if ((int) $producto['activo'] === 1): ?>
                            <input type="hidden" name="accion_admin" value="retirar_disco">
                            <button class="gestion-boton--peligro" type="submit">Retirar de la tienda</button>
                        <?php else: ?>
                            <input type="hidden" name="accion_admin" value="restaurar_disco">
                            <button type="submit">Volver a publicar</button>
                        <?php endif; ?>
                    </form>
                </article>
            <?php endforeach; ?>
            </div>
            <nav id="paginacion-discos" class="gestion-paginacion" aria-label="Paginación del inventario" hidden>
                <button id="pagina-anterior-discos" type="button" aria-label="Página anterior">
                    <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
                    Anterior
                </button>
                <div id="numeros-pagina-discos" class="gestion-paginacion__numeros" role="group" aria-label="Seleccionar página"></div>
                <span id="estado-paginacion-discos" aria-live="polite"></span>
                <button id="pagina-siguiente-discos" type="button" aria-label="Página siguiente">
                    Siguiente
                    <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
                </button>
            </nav>
        </section>
    </main>

    <?php require __DIR__ . '/includes/modal-cuenta.php'; ?>
    <script src="./js/admin.js?v=3"></script>
    <script src="./js/cuenta.js?v=5"></script>
    <script src="./js/transiciones.js?v=1"></script>
</body>
</html>
