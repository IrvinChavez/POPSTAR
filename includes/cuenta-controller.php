<?php
session_set_cookie_params([
    'httponly' => true,
    'samesite' => 'Lax',
    'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    'path' => '/',
]);
session_start();

$cuentaActual = $_SESSION['cuenta'] ?? null;
$mensajeCuenta = $_SESSION['mensaje_cuenta'] ?? null;
unset($_SESSION['mensaje_cuenta']);

if (!isset($_SESSION['csrf_cuenta'])) {
    $_SESSION['csrf_cuenta'] = bin2hex(random_bytes(32));
}
$csrfCuenta = $_SESSION['csrf_cuenta'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion_cuenta'])) {
    $accionCuenta = $_POST['accion_cuenta'];
    $tabCuenta = $accionCuenta === 'iniciar' ? 'iniciar' : 'registrar';
    $fallarCuenta = static function (string $mensaje) use ($tabCuenta): void {
        $_SESSION['mensaje_cuenta'] = ['tipo' => 'error', 'texto' => $mensaje];
        header('Location: ' . basename($_SERVER['PHP_SELF']) . '?cuenta=1&tab=' . $tabCuenta);
        exit;
    };

    if (!in_array($accionCuenta, ['registrar', 'iniciar', 'cerrar'], true)) {
        http_response_code(400);
        exit('Acción de cuenta no válida.');
    }

    $tokenEnviado = $_POST['csrf_cuenta'] ?? '';
    if (!is_string($tokenEnviado) || !hash_equals($csrfCuenta, $tokenEnviado)) {
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
        $nombreCuenta = trim($_POST['nombre_cuenta'] ?? '');
        $correoCuenta = strtolower(trim($_POST['correo_cuenta'] ?? ''));
        $contrasenaCuenta = $_POST['contrasena_cuenta'] ?? '';
        $telefonoCuenta = trim($_POST['telefono_cuenta'] ?? '');
        $aceptaPromociones = ($_POST['acepta_promociones'] ?? '') === '1';

        if ($nombreCuenta === '' || strlen($nombreCuenta) > 120) {
            $fallarCuenta('Escribe tu nombre completo (máximo 120 caracteres).');
        }
        if (strlen($correoCuenta) > 254 || !filter_var($correoCuenta, FILTER_VALIDATE_EMAIL)) {
            $fallarCuenta('Escribe una dirección de correo electrónico válida.');
        }
        if (strlen($contrasenaCuenta) < 8 || strlen($contrasenaCuenta) > 72) {
            $fallarCuenta('La contraseña debe tener entre 8 y 72 caracteres.');
        }
        if ($telefonoCuenta !== '' && (strlen($telefonoCuenta) > 30 || !preg_match('/^[0-9+\s().-]+$/', $telefonoCuenta))) {
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
        ];
        $_SESSION['csrf_cuenta'] = bin2hex(random_bytes(32));
        $_SESSION['mensaje_cuenta'] = ['tipo' => 'exito', 'texto' => '¡Tu cuenta está lista! Ya tienes 10% de descuento en discos.'];
    } elseif ($accionCuenta === 'iniciar') {
        $correoCuenta = strtolower(trim($_POST['correo_inicio'] ?? ''));
        $contrasenaCuenta = $_POST['contrasena_inicio'] ?? '';

        $consulta = $conexion->prepare(
            'SELECT id, nombre, correo, contrasena_hash
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
        ];
        $_SESSION['csrf_cuenta'] = bin2hex(random_bytes(32));
        $_SESSION['mensaje_cuenta'] = ['tipo' => 'exito', 'texto' => '¡Bienvenido de nuevo! Tu 10% de descuento está activo.'];
        $tabCuenta = 'iniciar';
    }

    header('Location: ' . basename($_SERVER['PHP_SELF']) . '?cuenta=1&tab=' . $tabCuenta);
    exit;
}

$cuentaActual = $_SESSION['cuenta'] ?? null;
