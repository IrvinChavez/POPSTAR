<?php
session_set_cookie_params([
    'httponly' => true,
    'samesite' => 'Lax',
    'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    'path' => '/',
]);
session_start();

function cuentaLongitud(string $valor): int
{
    return function_exists('mb_strlen') ? mb_strlen($valor, 'UTF-8') : strlen($valor);
}

$cuentaActual = $_SESSION['cuenta'] ?? null;
$historialQuiz = [];
$mensajeCuenta = $_SESSION['mensaje_cuenta'] ?? null;
unset($_SESSION['mensaje_cuenta']);

if (!isset($_SESSION['csrf_cuenta'])) {
    $_SESSION['csrf_cuenta'] = bin2hex(random_bytes(32));
}
$csrfCuenta = $_SESSION['csrf_cuenta'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion_cuenta'])) {
    $accionCuenta = is_string($_POST['accion_cuenta']) ? $_POST['accion_cuenta'] : '';
    $tabCuenta = match ($accionCuenta) {
        'iniciar' => 'iniciar',
        'editar', 'eliminar' => 'perfil',
        default => 'registrar',
    };
    $fallarCuenta = static function (string $mensaje) use ($tabCuenta): void {
        $_SESSION['mensaje_cuenta'] = ['tipo' => 'error', 'texto' => $mensaje];
        header('Location: ' . basename($_SERVER['PHP_SELF']) . '?cuenta=1&tab=' . $tabCuenta);
        exit;
    };
    $leerCampo = static function (string $campo): string {
        return isset($_POST[$campo]) && is_string($_POST[$campo]) ? $_POST[$campo] : '';
    };

    if (!in_array($accionCuenta, ['registrar', 'iniciar', 'cerrar', 'editar', 'eliminar'], true)) {
        http_response_code(400);
        exit('Acción de cuenta no válida.');
    }

    $tokenEnviado = $leerCampo('csrf_cuenta');
    if (!hash_equals($csrfCuenta, $tokenEnviado)) {
        $fallarCuenta('La sesión del formulario venció. Inténtalo de nuevo.');
    }

    if ($accionCuenta === 'cerrar') {
        $_SESSION = [];
        session_regenerate_id(true);
        $_SESSION['csrf_cuenta'] = bin2hex(random_bytes(32));
        $_SESSION['mensaje_cuenta'] = ['tipo' => 'exito', 'texto' => 'Has cerrado sesión.'];
        header('Location: ' . basename($_SERVER['PHP_SELF']) . '?cuenta=1&tab=registrar');
        exit;
    }

    require_once __DIR__ . '/../conexion.php';

    if ($accionCuenta === 'registrar') {
        $nombreCuenta = trim($leerCampo('nombre_cuenta'));
        $correoCuenta = strtolower(trim($leerCampo('correo_cuenta')));
        $contrasenaCuenta = $leerCampo('contrasena_cuenta');
        $confirmarContrasena = $leerCampo('confirmar_contrasena');
        $telefonoCuenta = trim($leerCampo('telefono_cuenta'));
        $aceptaPromociones = $leerCampo('acepta_promociones') === '1';

        if ($nombreCuenta === '' || cuentaLongitud($nombreCuenta) > 120) {
            $fallarCuenta('Escribe tu nombre completo (máximo 120 caracteres).');
        }
        if (strlen($correoCuenta) > 254 || !filter_var($correoCuenta, FILTER_VALIDATE_EMAIL)) {
            $fallarCuenta('Escribe una dirección de correo electrónico válida.');
        }
        if (strlen($contrasenaCuenta) < 8 || strlen($contrasenaCuenta) > 72) {
            $fallarCuenta('La contraseña debe tener entre 8 y 72 caracteres.');
        }
        if (!hash_equals($contrasenaCuenta, $confirmarContrasena)) {
            $fallarCuenta('Las contraseñas no coinciden.');
        }
        if ($telefonoCuenta !== '' && (cuentaLongitud($telefonoCuenta) > 30 || !preg_match('/^[0-9+\s().-]+$/', $telefonoCuenta))) {
            $fallarCuenta('Revisa el número de teléfono. Puedes dejarlo vacío.');
        }
        if (!$aceptaPromociones) {
            $fallarCuenta('Debes aceptar recibir promociones para crear tu cuenta.');
        }

        try {
            $consulta = $conexion->prepare(
                'INSERT INTO usuarios_popstar (nombre, correo, contrasena_hash, telefono, acepta_promociones)
                 VALUES (:nombre, :correo, :contrasena_hash, :telefono, :acepta_promociones)'
            );
            $consulta->execute([
                ':nombre' => $nombreCuenta,
                ':correo' => $correoCuenta,
                ':contrasena_hash' => password_hash($contrasenaCuenta, PASSWORD_DEFAULT),
                ':telefono' => $telefonoCuenta !== '' ? $telefonoCuenta : null,
                ':acepta_promociones' => 1,
            ]);
            $idCuenta = (int) $conexion->lastInsertId();
        } catch (PDOException $error) {
            if ($error->getCode() !== '23000') {
                throw $error;
            }
            $fallarCuenta('Ya existe una cuenta con ese correo. Inicia sesión.');
        }

        session_regenerate_id(true);
        $_SESSION['cuenta'] = [
            'id' => $idCuenta,
            'nombre' => $nombreCuenta,
            'correo' => $correoCuenta,
            'telefono' => $telefonoCuenta,
            'acepta_promociones' => true,
        ];
        $_SESSION['csrf_cuenta'] = bin2hex(random_bytes(32));
        $_SESSION['mensaje_cuenta'] = ['tipo' => 'exito', 'texto' => '¡Tu cuenta está lista! Ya tienes 10% de descuento en discos.'];
    } elseif ($accionCuenta === 'iniciar') {
        $correoCuenta = strtolower(trim($leerCampo('correo_inicio')));
        $contrasenaCuenta = $leerCampo('contrasena_inicio');

        if (strlen($correoCuenta) > 254 || !filter_var($correoCuenta, FILTER_VALIDATE_EMAIL)
            || $contrasenaCuenta === '' || strlen($contrasenaCuenta) > 72) {
            $fallarCuenta('Correo o contraseña incorrectos.');
        }

        $consulta = $conexion->prepare(
            'SELECT id, nombre, correo, contrasena_hash, telefono, acepta_promociones
             FROM usuarios_popstar
             WHERE correo = :correo'
        );
        $consulta->execute([':correo' => $correoCuenta]);
        $usuarioCuenta = $consulta->fetch();

        if (!$usuarioCuenta || !password_verify($contrasenaCuenta, $usuarioCuenta['contrasena_hash'])) {
            $fallarCuenta('Correo o contraseña incorrectos.');
        }

        session_regenerate_id(true);
        $_SESSION['cuenta'] = [
            'id' => (int) $usuarioCuenta['id'],
            'nombre' => $usuarioCuenta['nombre'],
            'correo' => $usuarioCuenta['correo'],
            'telefono' => $usuarioCuenta['telefono'] ?? '',
            'acepta_promociones' => (bool) $usuarioCuenta['acepta_promociones'],
        ];
        $_SESSION['csrf_cuenta'] = bin2hex(random_bytes(32));
        $_SESSION['mensaje_cuenta'] = ['tipo' => 'exito', 'texto' => '¡Bienvenido de nuevo! Tu 10% de descuento está activo.'];
        $tabCuenta = 'iniciar';
    } elseif ($accionCuenta === 'editar' || $accionCuenta === 'eliminar') {
        $idCuenta = $cuentaActual['id'] ?? null;
        if (!is_int($idCuenta) || $idCuenta < 1) {
            $fallarCuenta('Inicia sesión para administrar tu cuenta.');
        }

        $consulta = $conexion->prepare(
            'SELECT id, contrasena_hash FROM usuarios_popstar WHERE id = :id'
        );
        $consulta->execute([':id' => $idCuenta]);
        $usuarioCuenta = $consulta->fetch();

        if (!$usuarioCuenta) {
            unset($_SESSION['cuenta']);
            $fallarCuenta('La cuenta ya no está disponible. Inicia sesión de nuevo.');
        }

        $contrasenaActual = $leerCampo('contrasena_actual');
        if (!password_verify($contrasenaActual, $usuarioCuenta['contrasena_hash'])) {
            $fallarCuenta('La contraseña actual no es correcta.');
        }

        if ($accionCuenta === 'editar') {
            $nombreCuenta = trim($leerCampo('nombre_cuenta'));
            $correoCuenta = strtolower(trim($leerCampo('correo_cuenta')));
            $telefonoCuenta = trim($leerCampo('telefono_cuenta'));
            $aceptaPromociones = $leerCampo('acepta_promociones') === '1';
            $nuevaContrasena = $leerCampo('nueva_contrasena');
            $confirmarContrasena = $leerCampo('confirmar_nueva_contrasena');

            if ($nombreCuenta === '' || cuentaLongitud($nombreCuenta) > 120) {
                $fallarCuenta('Escribe tu nombre completo (máximo 120 caracteres).');
            }
            if (strlen($correoCuenta) > 254 || !filter_var($correoCuenta, FILTER_VALIDATE_EMAIL)) {
                $fallarCuenta('Escribe una dirección de correo electrónico válida.');
            }
            if ($telefonoCuenta !== '' && (cuentaLongitud($telefonoCuenta) > 30 || !preg_match('/^[0-9+\s().-]+$/', $telefonoCuenta))) {
                $fallarCuenta('Revisa el número de teléfono. Puedes dejarlo vacío.');
            }
            if ($nuevaContrasena !== '' || $confirmarContrasena !== '') {
                if (strlen($nuevaContrasena) < 8 || strlen($nuevaContrasena) > 72) {
                    $fallarCuenta('La nueva contraseña debe tener entre 8 y 72 caracteres.');
                }
                if (!hash_equals($nuevaContrasena, $confirmarContrasena)) {
                    $fallarCuenta('Las nuevas contraseñas no coinciden.');
                }
            }

            try {
                if ($nuevaContrasena !== '') {
                    $consulta = $conexion->prepare(
                        'UPDATE usuarios_popstar
                         SET nombre = :nombre, correo = :correo, telefono = :telefono,
                             acepta_promociones = :acepta_promociones, contrasena_hash = :contrasena_hash
                         WHERE id = :id'
                    );
                    $consulta->execute([
                        ':nombre' => $nombreCuenta,
                        ':correo' => $correoCuenta,
                        ':telefono' => $telefonoCuenta !== '' ? $telefonoCuenta : null,
                        ':acepta_promociones' => $aceptaPromociones ? 1 : 0,
                        ':contrasena_hash' => password_hash($nuevaContrasena, PASSWORD_DEFAULT),
                        ':id' => $idCuenta,
                    ]);
                } else {
                    $consulta = $conexion->prepare(
                        'UPDATE usuarios_popstar
                         SET nombre = :nombre, correo = :correo, telefono = :telefono,
                             acepta_promociones = :acepta_promociones
                         WHERE id = :id'
                    );
                    $consulta->execute([
                        ':nombre' => $nombreCuenta,
                        ':correo' => $correoCuenta,
                        ':telefono' => $telefonoCuenta !== '' ? $telefonoCuenta : null,
                        ':acepta_promociones' => $aceptaPromociones ? 1 : 0,
                        ':id' => $idCuenta,
                    ]);
                }
            } catch (PDOException $error) {
                if ($error->getCode() !== '23000') {
                    throw $error;
                }
                $fallarCuenta('Ya existe una cuenta con ese correo.');
            }

            if ($nuevaContrasena !== '') {
                session_regenerate_id(true);
            }
            $_SESSION['cuenta'] = [
                'id' => $idCuenta,
                'nombre' => $nombreCuenta,
                'correo' => $correoCuenta,
                'telefono' => $telefonoCuenta,
                'acepta_promociones' => $aceptaPromociones,
            ];
            $_SESSION['csrf_cuenta'] = bin2hex(random_bytes(32));
            $_SESSION['mensaje_cuenta'] = ['tipo' => 'exito', 'texto' => 'Los datos de tu cuenta se actualizaron correctamente.'];
        } else {
            if ($leerCampo('confirmar_eliminacion') !== '1') {
                $fallarCuenta('Confirma que deseas eliminar tu cuenta.');
            }

            $consulta = $conexion->prepare('DELETE FROM usuarios_popstar WHERE id = :id');
            $consulta->execute([':id' => $idCuenta]);
            if ($consulta->rowCount() !== 1) {
                $fallarCuenta('No se pudo eliminar la cuenta. Inténtalo de nuevo.');
            }

            $_SESSION = [];
            session_regenerate_id(true);
            $_SESSION['csrf_cuenta'] = bin2hex(random_bytes(32));
            $_SESSION['mensaje_cuenta'] = ['tipo' => 'exito', 'texto' => 'Tu cuenta se eliminó correctamente.'];
            $tabCuenta = 'registrar';
        }
    }

    header('Location: ' . basename($_SERVER['PHP_SELF']) . '?cuenta=1&tab=' . $tabCuenta);
    exit;
}

$cuentaActual = $_SESSION['cuenta'] ?? null;
if ($cuentaActual && is_int($cuentaActual['id'] ?? null)) {
    require_once __DIR__ . '/../conexion.php';
    $consultaHistorialQuiz = $conexion->prepare(
        'SELECT id, perfil, realizado_en
         FROM resultados_quiz
         WHERE usuario_id = :usuario_id
         ORDER BY realizado_en DESC
         LIMIT 20'
    );
    $consultaHistorialQuiz->execute([':usuario_id' => $cuentaActual['id']]);
    $historialQuiz = $consultaHistorialQuiz->fetchAll();
}
