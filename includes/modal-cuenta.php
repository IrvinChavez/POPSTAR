<dialog class="modal-cuenta" id="modal-cuenta" aria-labelledby="titulo-modal-cuenta">
    <div class="modal-cuenta__contenido">
        <button class="modal-cuenta__cerrar" type="button" data-cerrar-cuenta aria-label="Cerrar">&times;</button>
        <div class="modal-cuenta__pestanas" role="tablist" aria-label="Opciones de cuenta" <?= $cuentaActual ? 'hidden' : '' ?>>
            <button class="modal-cuenta__pestana" id="pestana-registrar" type="button" role="tab" aria-controls="panel-registrar" aria-selected="true" data-pestana="registrar">Registrarse</button>
            <button class="modal-cuenta__pestana" id="pestana-iniciar" type="button" role="tab" aria-controls="panel-iniciar" aria-selected="false" data-pestana="iniciar">Iniciar sesión</button>
        </div>

        <h1 class="modal-cuenta__sr-only" id="titulo-modal-cuenta">Cuenta POPSTAR</h1>
        <div id="aviso-quiz-cuenta" class="modal-cuenta__mensaje modal-cuenta__aviso-quiz" role="status" data-aviso hidden>
            <p></p>
            <button type="button" data-cerrar-aviso="aviso-quiz-cuenta" aria-label="Cerrar aviso">&times;</button>
        </div>

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
                <h2>Administra tu cuenta</h2>
                <p class="modal-cuenta__pie">Tu descuento de miembro del 10% está activo en la tienda y el carrito.</p>
                <?php
                $nombresPerfiles = [
                    'indie' => 'Indie introspectivo',
                    'pop' => 'Pop camaleónico',
                    'rock' => 'Rock de espíritu libre',
                    'electronica' => 'Electrónica nocturna',
                    'hiphop' => 'Hip-hop consciente',
                    'latin' => 'Ritmo latino alternativo',
                    'soul' => 'Soul de madrugada',
                ];
                ?>
                <section class="modal-cuenta__historial" aria-labelledby="titulo-historial-quiz">
                    <h3 id="titulo-historial-quiz">Historial de POPSTAR VIBE</h3>
                    <ol id="historial-quiz-list" <?= !$historialQuiz ? 'hidden' : '' ?>>
                        <?php foreach ($historialQuiz as $resultadoQuiz): ?>
                            <li>
                                <span><?= htmlspecialchars($nombresPerfiles[$resultadoQuiz['perfil']] ?? 'Perfil musical', ENT_QUOTES, 'UTF-8') ?></span>
                                <time datetime="<?= htmlspecialchars($resultadoQuiz['realizado_en'], ENT_QUOTES, 'UTF-8') ?>">
                                    <?= htmlspecialchars(date('d/m/Y H:i', strtotime($resultadoQuiz['realizado_en'])), ENT_QUOTES, 'UTF-8') ?>
                                </time>
                                <a class="modal-cuenta__ver-catalogo" href="./quiz.php?resultado=<?= (int) $resultadoQuiz['id'] ?>">VER CATÁLOGO</a>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                    <p id="sin-historial-quiz" class="modal-cuenta__pie" <?= $historialQuiz ? 'hidden' : '' ?>>Todavía no has realizado ningún quiz.</p>
                </section>
                <form class="modal-cuenta__formulario" action="" method="post" novalidate>
                    <input type="hidden" name="csrf_cuenta" value="<?= htmlspecialchars($csrfCuenta, ENT_QUOTES, 'UTF-8') ?>">
                    <input type="hidden" name="accion_cuenta" value="editar">
                    <label for="nombre-editar-cuenta">Nombre completo</label>
                    <input id="nombre-editar-cuenta" name="nombre_cuenta" type="text" autocomplete="name" value="<?= htmlspecialchars($cuentaActual['nombre'], ENT_QUOTES, 'UTF-8') ?>">
                    <label for="correo-editar-cuenta">Correo electrónico</label>
                    <input id="correo-editar-cuenta" name="correo_cuenta" type="email" autocomplete="email" value="<?= htmlspecialchars($cuentaActual['correo'], ENT_QUOTES, 'UTF-8') ?>">
                    <label for="telefono-editar-cuenta">Teléfono (opcional)</label>
                    <input id="telefono-editar-cuenta" name="telefono_cuenta" type="tel" autocomplete="tel" value="<?= htmlspecialchars($cuentaActual['telefono'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    <label class="modal-cuenta__consentimiento" for="promociones-editar-cuenta">
                        <input id="promociones-editar-cuenta" name="acepta_promociones" type="checkbox" value="1" <?= !empty($cuentaActual['acepta_promociones']) ? 'checked' : '' ?>>
                        <span>Acepto recibir promociones de POPSTAR por correo electrónico.</span>
                    </label>
                    <label for="contrasena-actual-editar">Contraseña actual (requerida para guardar cambios)</label>
                    <input id="contrasena-actual-editar" name="contrasena_actual" type="password" autocomplete="current-password">
                    <label for="nueva-contrasena-cuenta">Nueva contraseña (opcional)</label>
                    <input id="nueva-contrasena-cuenta" name="nueva_contrasena" type="password" autocomplete="new-password" placeholder="Déjala vacía para conservarla">
                    <label for="confirmar-nueva-contrasena-cuenta">Confirmar nueva contraseña</label>
                    <input id="confirmar-nueva-contrasena-cuenta" name="confirmar_nueva_contrasena" type="password" autocomplete="new-password">
                    <button class="modal-cuenta__submit" type="submit">Guardar cambios</button>
                </form>

                <form class="modal-cuenta__formulario modal-cuenta__eliminar" action="" method="post" novalidate>
                    <input type="hidden" name="csrf_cuenta" value="<?= htmlspecialchars($csrfCuenta, ENT_QUOTES, 'UTF-8') ?>">
                    <input type="hidden" name="accion_cuenta" value="eliminar">
                    <h3>Eliminar cuenta</h3>
                    <p>Esta acción es permanente y eliminará los datos de tu cuenta.</p>
                    <label for="contrasena-eliminar-cuenta">Confirma tu contraseña</label>
                    <input id="contrasena-eliminar-cuenta" name="contrasena_actual" type="password" autocomplete="current-password">
                    <label class="modal-cuenta__consentimiento" for="confirmar-eliminar-cuenta">
                        <input id="confirmar-eliminar-cuenta" name="confirmar_eliminacion" type="checkbox" value="1">
                        <span>Entiendo que no podré recuperar mi cuenta.</span>
                    </label>
                    <button class="modal-cuenta__submit modal-cuenta__submit--peligro" type="submit">Eliminar mi cuenta</button>
                </form>

                <form class="modal-cuenta__cerrar-sesion" action="" method="post">
                    <input type="hidden" name="csrf_cuenta" value="<?= htmlspecialchars($csrfCuenta, ENT_QUOTES, 'UTF-8') ?>">
                    <input type="hidden" name="accion_cuenta" value="cerrar">
                    <button class="modal-cuenta__enlace" type="submit">Cerrar sesión</button>
                </form>
            </section>
        <?php else: ?>
            <form class="modal-cuenta__formulario" id="panel-registrar" role="tabpanel" aria-labelledby="pestana-registrar" action="" method="post" data-panel="registrar" novalidate>
                <input type="hidden" name="csrf_cuenta" value="<?= htmlspecialchars($csrfCuenta, ENT_QUOTES, 'UTF-8') ?>">
                <input type="hidden" name="accion_cuenta" value="registrar">
                <label for="nombre-cuenta">Nombre completo</label>
                <input id="nombre-cuenta" name="nombre_cuenta" type="text" autocomplete="name" placeholder="Tu nombre">
                <label for="correo-cuenta">Correo electrónico</label>
                <input id="correo-cuenta" name="correo_cuenta" type="email" autocomplete="email" placeholder="correo@ejemplo.com">
                <label for="contrasena-cuenta">Contraseña</label>
                <input id="contrasena-cuenta" name="contrasena_cuenta" type="password" autocomplete="new-password" placeholder="Mínimo 8 caracteres">
                <label for="confirmar-contrasena-cuenta">Confirmar contraseña</label>
                <input id="confirmar-contrasena-cuenta" name="confirmar_contrasena" type="password" autocomplete="new-password">
                <label for="telefono-cuenta">Teléfono (opcional)</label>
                <input id="telefono-cuenta" name="telefono_cuenta" type="tel" autocomplete="tel" placeholder="+52 614 000 0000">
                <label class="modal-cuenta__consentimiento" for="acepta-promociones">
                    <input id="acepta-promociones" name="acepta_promociones" type="checkbox" value="1">
                    <span>Acepto recibir promociones de POPSTAR por correo electrónico.</span>
                </label>
                <button class="modal-cuenta__submit" type="submit">Crear cuenta gratis</button>
                <p class="modal-cuenta__pie">¿Ya tienes cuenta? <button class="modal-cuenta__enlace" type="button" data-pestana="iniciar">Inicia sesión</button></p>
            </form>

            <form class="modal-cuenta__formulario" id="panel-iniciar" role="tabpanel" aria-labelledby="pestana-iniciar" action="" method="post" data-panel="iniciar" novalidate hidden>
                <input type="hidden" name="csrf_cuenta" value="<?= htmlspecialchars($csrfCuenta, ENT_QUOTES, 'UTF-8') ?>">
                <input type="hidden" name="accion_cuenta" value="iniciar">
                <label for="correo-inicio">Correo electrónico</label>
                <input id="correo-inicio" name="correo_inicio" type="email" autocomplete="email" placeholder="correo@ejemplo.com">
                <label for="contrasena-inicio">Contraseña</label>
                <input id="contrasena-inicio" name="contrasena_inicio" type="password" autocomplete="current-password">
                <button class="modal-cuenta__submit" type="submit">Iniciar sesión</button>
                <p class="modal-cuenta__pie">¿Aún no tienes cuenta? <button class="modal-cuenta__enlace" type="button" data-pestana="registrar">Regístrate</button></p>
            </form>
        <?php endif; ?>
    </div>
</dialog>
