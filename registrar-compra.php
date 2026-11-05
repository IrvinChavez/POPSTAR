<?php
require_once __DIR__ . '/includes/cuenta-controller.php';
header('Content-Type: application/json; charset=utf-8');

$responder = static function (int $estado, array $datos): void {
    http_response_code($estado);
    echo json_encode($datos, JSON_UNESCAPED_UNICODE);
    exit;
};

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Allow: POST');
    $responder(405, ['error' => 'Método no permitido.']);
}

$tokenEnviado = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
if (!is_string($tokenEnviado) || !hash_equals($csrfCuenta, $tokenEnviado)) {
    $responder(403, ['error' => 'La sesión del carrito venció. Recarga la página e inténtalo de nuevo.']);
}

$datos = json_decode(file_get_contents('php://input'), true);
$articulos = $datos['articulos'] ?? null;
if (!is_array($articulos) || count($articulos) < 1 || count($articulos) > 100) {
    $responder(400, ['error' => 'El carrito está vacío o no es válido.']);
}

$cantidades = [];
foreach ($articulos as $articulo) {
    if (!is_array($articulo)
        || !isset($articulo['id'], $articulo['cantidad'])
        || !is_int($articulo['id'])
        || $articulo['id'] < 1
        || !is_int($articulo['cantidad'])
        || $articulo['cantidad'] < 1
        || $articulo['cantidad'] > 99
        || isset($cantidades[$articulo['id']])) {
        $responder(400, ['error' => 'Los artículos del carrito no son válidos.']);
    }
    $cantidades[$articulo['id']] = $articulo['cantidad'];
}

require_once __DIR__ . '/conexion.php';
$costoEnvioCentavos = 12000;
$descuentoMiembro = $cuentaActual ? 10 : 0;
$stocksActuales = [];

try {
    $conexion->beginTransaction();
    $seleccionarDisco = $conexion->prepare(
        'SELECT id, titulo, artista, precio, stock
         FROM catalogo_discos
         WHERE id = :id
         FOR UPDATE'
    );
    $discosOrden = [];
    $subtotalCentavos = 0;

    foreach ($cantidades as $idDisco => $cantidad) {
        $seleccionarDisco->execute([':id' => $idDisco]);
        $disco = $seleccionarDisco->fetch();
        if (!$disco) {
            $conexion->rollBack();
            $responder(400, ['error' => 'Uno de los discos del carrito ya no está disponible.']);
        }

        $stocksActuales[$idDisco] = (int) $disco['stock'];
        if ($cantidad > (int) $disco['stock']) {
            $conexion->rollBack();
            $responder(409, [
                'error' => 'No hay suficientes unidades de ' . $disco['titulo'] . '. Se actualizaron las existencias disponibles.',
                'stocks' => $stocksActuales,
            ]);
        }

        $disco['precio_centavos'] = (int) round((float) $disco['precio'] * 100);
        $discosOrden[] = [$disco, $cantidad];
        $subtotalCentavos += $disco['precio_centavos'] * $cantidad;
    }

    $descuentoCentavos = (int) round($subtotalCentavos * $descuentoMiembro / 100);
    $totalCentavos = $subtotalCentavos - $descuentoCentavos + $costoEnvioCentavos;
    $insertarOrden = $conexion->prepare(
        'INSERT INTO ordenes (usuario_id, subtotal, descuento, envio, total, estado)
         VALUES (:usuario_id, :subtotal, :descuento, :envio, :total, :estado)'
    );
    $insertarOrden->execute([
        ':usuario_id' => $cuentaActual['id'] ?? null,
        ':subtotal' => $subtotalCentavos / 100,
        ':descuento' => $descuentoCentavos / 100,
        ':envio' => $costoEnvioCentavos / 100,
        ':total' => $totalCentavos / 100,
        ':estado' => 'confirmado_demo',
    ]);
    $idOrden = (int) $conexion->lastInsertId();
    $descontarStock = $conexion->prepare(
        'UPDATE catalogo_discos
         SET stock = stock - :cantidad_restar
         WHERE id = :id AND stock >= :cantidad_disponible'
    );
    $insertarDetalle = $conexion->prepare(
        'INSERT INTO ordenes_discos (orden_id, disco_id, titulo, artista, precio_unitario, cantidad)
         VALUES (:orden_id, :disco_id, :titulo, :artista, :precio_unitario, :cantidad)'
    );

    foreach ($discosOrden as [$disco, $cantidad]) {
        $descontarStock->execute([
            ':cantidad_restar' => $cantidad,
            ':cantidad_disponible' => $cantidad,
            ':id' => $disco['id'],
        ]);
        if ($descontarStock->rowCount() !== 1) {
            throw new RuntimeException('No se pudo actualizar el inventario del disco ' . $disco['id'] . '.');
        }

        $insertarDetalle->execute([
            ':orden_id' => $idOrden,
            ':disco_id' => $disco['id'],
            ':titulo' => $disco['titulo'],
            ':artista' => $disco['artista'],
            ':precio_unitario' => $disco['precio_centavos'] / 100,
            ':cantidad' => $cantidad,
        ]);
        $stocksActuales[$disco['id']] -= $cantidad;
    }

    $conexion->commit();
} catch (RuntimeException $error) {
    if ($conexion->inTransaction()) {
        $conexion->rollBack();
    }
    error_log('No se pudo registrar el pedido de POPSTAR: ' . $error->getMessage());
    $responder(500, ['error' => 'No se pudo confirmar el pedido. No se modificó el inventario; inténtalo de nuevo.']);
}

$responder(200, [
    'pedido' => $idOrden,
    'stocks' => $stocksActuales,
    'mensaje' => 'Pedido de prueba registrado. No se realizó ningún cobro.',
]);
