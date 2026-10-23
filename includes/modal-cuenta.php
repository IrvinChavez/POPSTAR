<dialog class="modal-cuenta" id="modal-cuenta" aria-labelledby="titulo-modal-cuenta">
    <div class="modal-cuenta__contenido">
        <button class="modal-cuenta__cerrar" type="button" data-cerrar-cuenta aria-label="Cerrar">&times;</button>
        <div class="modal-cuenta__pestanas" role="tablist" aria-label="Opciones de cuenta" <?= $cuentaActual ? 'hidden' : '' ?>>
            <button class="modal-cuenta__pestana" id="pestana-registrar" type="button" role="tab" aria-controls="panel-registrar" aria-selected="true" data-pestana="registrar">Registrarse</button>
            <button class="modal-cuenta__pestana" id="pestana-iniciar" type="button" role="tab" aria-controls="panel-iniciar" aria-selected="false" data-pestana="iniciar">Iniciar sesión</button>
        </div>

        <h1 class="modal-cuenta__sr-only" id="titulo-modal-cuenta">Cuenta POPSTAR</h1>

        <?php if ($mensajeCuenta): ?>
            <p class="modal-cuenta__mensaje <?= htmlspecialchars($mensajeCuenta['tipo'], ENT_QUOTES, 'UTF-8') ?>" role="<?= $mensajeCuenta['tipo'] === 'error' ? 'alert' : 'status' ?>">
                <?= htmlspecialchars($mensajeCuenta['texto'], ENT_QUOTES, 'UTF-8') ?>
            </p>
        <?php endif; ?>

        <section class="modal-cuenta__beneficios" aria-label="Beneficios de miembro">
            <h2>♥ Beneficios de miembro</h2>
            <ul>
                <li>10% de descuento en discos</li>
                <li>Contraseña protegida mediante cifrado</li>
                <li>Precio de miembro visible en la tienda</li>
            </ul>
        </section>

        <?php if ($cuentaActual): ?>
            <section class="modal-cuenta__cuenta" aria-label="Tu cuenta">
                <h2>Hola, <?= htmlspecialchars($cuentaActual['nombre'], ENT_QUOTES, 'UTF-8') ?></h2>
                <p class="modal-cuenta__correo"><?= htmlspecialchars($cuentaActual['correo'], ENT_QUOTES, 'UTF-8') ?></p>
                <p class="modal-cuenta__pie">Tu descuento de miembro del 10% está activo en la tienda y el carrito.</p>
                <form action="" method="post">
                    <input type="hidden" name="csrf_cuenta" value="<?= htmlspecialchars($csrfCuenta, ENT_QUOTES, 'UTF-8') ?>">
                    <input type="hidden" name="accion_cuenta" value="cerrar">
                    <button class="modal-cuenta__submit" type="submit">Cerrar sesión</button>
                </form>
            </section>
        <?php else: ?>
            <form class="modal-cuenta__formulario" id="panel-registrar" role="tabpanel" aria-labelledby="pestana-registrar" action="" method="post" data-panel="registrar">
                <input type="hidden" name="csrf_cuenta" value="<?= htmlspecialchars($csrfCuenta, ENT_QUOTES, 'UTF-8') ?>">
                <input type="hidden" name="accion_cuenta" value="registrar">
                <label for="nombre-cuenta">Nombre completo</label>
                <input id="nombre-cuenta" name="nombre_cuenta" type="text" autocomplete="name" maxlength="120" placeholder="Tu nombre" required>
                <label for="correo-cuenta">Correo electrónico</label>
                <input id="correo-cuenta" name="correo_cuenta" type="email" autocomplete="email" maxlength="254" placeholder="correo@ejemplo.com" required>
                <label for="contrasena-cuenta">Contraseña</label>
                <input id="contrasena-cuenta" name="contrasena_cuenta" type="password" autocomplete="new-password" minlength="8" maxlength="72" placeholder="Mínimo 8 caracteres" required>
                <label for="telefono-cuenta">Teléfono (opcional)</label>
                <input id="telefono-cuenta" name="telefono_cuenta" type="tel" autocomplete="tel" maxlength="30" placeholder="+52 614 000 0000">
                <label class="modal-cuenta__consentimiento" for="acepta-promociones">
                    <input id="acepta-promociones" name="acepta_promociones" type="checkbox" value="1" required>
                    <span>Acepto recibir promociones de POPSTAR por correo electrónico.</span>
                </label>
                <button class="modal-cuenta__submit" type="submit">Crear cuenta gratis</button>
                <p class="modal-cuenta__pie">¿Ya tienes cuenta? <button class="modal-cuenta__enlace" type="button" data-pestana="iniciar">Inicia sesión</button></p>
            </form>

            <form class="modal-cuenta__formulario" id="panel-iniciar" role="tabpanel" aria-labelledby="pestana-iniciar" action="" method="post" data-panel="iniciar" hidden>
                <input type="hidden" name="csrf_cuenta" value="<?= htmlspecialchars($csrfCuenta, ENT_QUOTES, 'UTF-8') ?>">
                <input type="hidden" name="accion_cuenta" value="iniciar">
                <label for="correo-inicio">Correo electrónico</label>
                <input id="correo-inicio" name="correo_inicio" type="email" autocomplete="email" maxlength="254" placeholder="correo@ejemplo.com" required>
                <label for="contrasena-inicio">Contraseña</label>
                <input id="contrasena-inicio" name="contrasena_inicio" type="password" autocomplete="current-password" required>
                <button class="modal-cuenta__submit" type="submit">Iniciar sesión</button>
                <p class="modal-cuenta__pie">¿Aún no tienes cuenta? <button class="modal-cuenta__enlace" type="button" data-pestana="registrar">Regístrate</button></p>
            </form>
        <?php endif; ?>
    </div>
</dialog>
