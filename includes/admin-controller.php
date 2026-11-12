<?php
require_once __DIR__ . '/../conexion.php';

$idCuentaAdmin = $cuentaActual['id'] ?? null;
if (!is_int($idCuentaAdmin) || $idCuentaAdmin < 1) {
    header('Location: ./tienda.php?cuenta=1&tab=iniciar');
    exit;
}

$consultaRolAdmin = $conexion->prepare(
    'SELECT rol FROM usuarios_popstar WHERE id = :id'
);
$consultaRolAdmin->execute([':id' => $idCuentaAdmin]);
$rolAdmin = $consultaRolAdmin->fetchColumn();

if (!in_array($rolAdmin, ['administrador', 'empleado'], true)) {
    http_response_code(403);
    exit('No tienes permisos para acceder al panel de gestión.');
}

$cuentaActual['rol'] = $rolAdmin;
$_SESSION['cuenta']['rol'] = $rolAdmin;

$mensajeAdmin = $_SESSION['mensaje_admin'] ?? null;
unset($_SESSION['mensaje_admin']);

$redirigirAdmin = static function (string $tipo, string $texto): void {
    $_SESSION['mensaje_admin'] = ['tipo' => $tipo, 'texto' => $texto];
    header('Location: ./admin.php');
    exit;
};

$leerCampoAdmin = static function (string $campo): string {
    return isset($_POST[$campo]) && is_string($_POST[$campo]) ? trim($_POST[$campo]) : '';
};

$longitudAdmin = static function (string $valor): int {
    return function_exists('mb_strlen') ? mb_strlen($valor, 'UTF-8') : strlen($valor);
};

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tokenAdmin = $leerCampoAdmin('csrf_cuenta');
    if (!hash_equals($csrfCuenta, $tokenAdmin)) {
        $redirigirAdmin('error', 'La sesión del formulario venció. Inténtalo de nuevo.');
    }

    $accionAdmin = $leerCampoAdmin('accion_admin');
    if ($accionAdmin === 'agregar_empleado') {
        $nombreEmpleado = $leerCampoAdmin('nombre_empleado');
        $correoEmpleado = strtolower($leerCampoAdmin('correo_empleado'));
        $contrasenaEmpleado = isset($_POST['contrasena_empleado']) && is_string($_POST['contrasena_empleado'])
            ? $_POST['contrasena_empleado']
            : '';

        if ($nombreEmpleado === '' || $longitudAdmin($nombreEmpleado) > 120) {
            $redirigirAdmin('error', 'Escribe el nombre del empleado (máximo 120 caracteres).');
        }
        if (strlen($correoEmpleado) > 254 || !filter_var($correoEmpleado, FILTER_VALIDATE_EMAIL)) {
            $redirigirAdmin('error', 'Escribe un correo electrónico válido para el empleado.');
        }
        if (strlen($contrasenaEmpleado) < 8 || strlen($contrasenaEmpleado) > 72) {
            $redirigirAdmin('error', 'La contraseña del empleado debe tener entre 8 y 72 caracteres.');
        }

        try {
            $crearEmpleado = $conexion->prepare(
                'INSERT INTO usuarios_popstar (nombre, correo, contrasena_hash, acepta_promociones, rol)
                 VALUES (:nombre, :correo, :contrasena_hash, 0, :rol)'
            );
            $crearEmpleado->execute([
                ':nombre' => $nombreEmpleado,
                ':correo' => $correoEmpleado,
                ':contrasena_hash' => password_hash($contrasenaEmpleado, PASSWORD_DEFAULT),
                ':rol' => 'empleado',
            ]);
        } catch (PDOException $error) {
            if ($error->getCode() !== '23000') {
                throw $error;
            }
            $redirigirAdmin('error', 'Ya existe una cuenta con ese correo.');
        }

        $redirigirAdmin('exito', 'La cuenta del empleado quedó creada.');
    }

    if (in_array($accionAdmin, ['agregar_disco', 'actualizar_disco'], true)) {
        $codigoDisco = strtolower($leerCampoAdmin('codigo'));
        $tituloDisco = $leerCampoAdmin('titulo');
        $artistaDisco = $leerCampoAdmin('artista');
        $precioDisco = $leerCampoAdmin('precio');
        $imagenDisco = $leerCampoAdmin('imagen');
        $stockDisco = $leerCampoAdmin('stock');

        if (!preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/D', $codigoDisco)
            || $longitudAdmin($codigoDisco) > 180) {
            $redirigirAdmin('error', 'El código debe usar letras minúsculas, números y guiones.');
        }
        if ($tituloDisco === '' || $longitudAdmin($tituloDisco) > 200
            || $artistaDisco === '' || $longitudAdmin($artistaDisco) > 200) {
            $redirigirAdmin('error', 'El título y el artista son obligatorios (máximo 200 caracteres cada uno).');
        }
        if (!preg_match('/^\d+(?:\.\d{1,2})?$/D', $precioDisco)
            || (float) $precioDisco <= 0
            || (float) $precioDisco > 99999999.99) {
            $redirigirAdmin('error', 'Escribe un precio válido, mayor que cero y con máximo dos decimales.');
        }
        $imagenPartes = parse_url($imagenDisco);
        $imagenLocalValida = preg_match('/^\.\/imagenes\/(?!.*\.\.)[A-Za-z0-9._\/-]+$/D', $imagenDisco) === 1;
        $imagenRemotaValida = is_array($imagenPartes)
            && filter_var($imagenDisco, FILTER_VALIDATE_URL)
            && strtolower($imagenPartes['scheme'] ?? '') === 'https';
        if (strlen($imagenDisco) > 1024 || (!$imagenLocalValida && !$imagenRemotaValida)) {
            $redirigirAdmin('error', 'La imagen debe ser una ruta dentro de ./imagenes/ o una URL HTTPS.');
        }
        if (!preg_match('/^\d+$/D', $stockDisco) || (int) $stockDisco > 1000000) {
            $redirigirAdmin('error', 'El inventario debe ser un número entero entre 0 y 1,000,000.');
        }

        try {
            if ($accionAdmin === 'agregar_disco') {
                $guardarDisco = $conexion->prepare(
                    'INSERT INTO catalogo_discos (codigo, titulo, artista, precio, imagen, stock)
                     VALUES (:codigo, :titulo, :artista, :precio, :imagen, :stock)'
                );
            } else {
                $idDisco = filter_var($leerCampoAdmin('id_disco'), FILTER_VALIDATE_INT);
                if ($idDisco === false || $idDisco < 1) {
                    $redirigirAdmin('error', 'El disco seleccionado no es válido.');
                }
                $guardarDisco = $conexion->prepare(
                    'UPDATE catalogo_discos
                     SET codigo = :codigo, titulo = :titulo, artista = :artista,
                         precio = :precio, imagen = :imagen, stock = :stock
                     WHERE id = :id'
                );
            }

            $datosDisco = [
                ':codigo' => $codigoDisco,
                ':titulo' => $tituloDisco,
                ':artista' => $artistaDisco,
                ':precio' => $precioDisco,
                ':imagen' => $imagenDisco,
                ':stock' => (int) $stockDisco,
            ];
            if ($accionAdmin === 'actualizar_disco') {
                $datosDisco[':id'] = $idDisco;
            }
            $guardarDisco->execute($datosDisco);
        } catch (PDOException $error) {
            if ($error->getCode() !== '23000') {
                throw $error;
            }
            $redirigirAdmin('error', 'Ya existe un disco con ese código.');
        }

        $redirigirAdmin('exito', $accionAdmin === 'agregar_disco'
            ? 'El disco se agregó al catálogo.'
            : 'Los cambios del disco quedaron guardados.');
    }

    if (in_array($accionAdmin, ['retirar_disco', 'restaurar_disco'], true)) {
        $idDisco = filter_var($leerCampoAdmin('id_disco'), FILTER_VALIDATE_INT);
        if ($idDisco === false || $idDisco < 1) {
            $redirigirAdmin('error', 'El disco seleccionado no es válido.');
        }

        $activoDisco = $accionAdmin === 'restaurar_disco' ? 1 : 0;
        $cambiarEstadoDisco = $conexion->prepare(
            'UPDATE catalogo_discos SET activo = :activo WHERE id = :id'
        );
        $cambiarEstadoDisco->execute([':activo' => $activoDisco, ':id' => $idDisco]);
        if ($cambiarEstadoDisco->rowCount() === 0) {
            $consultaDisco = $conexion->prepare('SELECT id FROM catalogo_discos WHERE id = :id');
            $consultaDisco->execute([':id' => $idDisco]);
            if (!$consultaDisco->fetch()) {
                $redirigirAdmin('error', 'El disco seleccionado ya no existe.');
            }
        }

        $redirigirAdmin('exito', $activoDisco
            ? 'El disco volvió a estar disponible en la tienda.'
            : 'El disco se retiró de la tienda; el historial de pedidos se conservó.');
    }

    $redirigirAdmin('error', 'La acción solicitada no es válida.');
}

$empleados = $conexion->query(
    "SELECT id, nombre, correo, creado_en
     FROM usuarios_popstar
     WHERE rol = 'empleado'
     ORDER BY nombre"
)->fetchAll();

$productosAdmin = $conexion->query(
    'SELECT id, codigo, titulo, artista, precio, imagen, stock, activo
     FROM catalogo_discos
     ORDER BY activo DESC, titulo'
)->fetchAll();
