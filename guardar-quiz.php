<?php
require_once __DIR__ . '/includes/cuenta-controller.php';
require_once __DIR__ . '/includes/quiz-result.php';
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

if (!$cuentaActual || !is_int($cuentaActual['id'] ?? null)) {
    $responder(401, ['error' => 'Inicia sesión o regístrate para guardar y ver tu resultado.']);
}

$tokenEnviado = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
if (!is_string($tokenEnviado) || !hash_equals($csrfCuenta, $tokenEnviado)) {
    $responder(403, ['error' => 'La sesión del formulario venció. Recarga la página e inténtalo de nuevo.']);
}

$datos = json_decode(file_get_contents('php://input'), true);
$respuestas = $datos['respuestas'] ?? null;
if (!is_array($respuestas) || count($respuestas) !== 5) {
    $responder(400, ['error' => 'Las respuestas del quiz no son válidas.']);
}

$generosSeleccionados = perfilesDeRespuestasQuiz($respuestas);
if ($generosSeleccionados === null) {
    $responder(400, ['error' => 'Las respuestas del quiz no son válidas.']);
}

require_once __DIR__ . '/conexion.php';
$consulta = $conexion->prepare(
    'INSERT INTO resultados_quiz (usuario_id, perfil, respuestas_json)
     VALUES (:usuario_id, :perfil, :respuestas_json)'
);
$consulta->execute([
    ':usuario_id' => $cuentaActual['id'],
    ':perfil' => $generosSeleccionados[0],
    ':respuestas_json' => json_encode($respuestas, JSON_THROW_ON_ERROR),
]);

$idResultado = (int) $conexion->lastInsertId();
$consultaFecha = $conexion->prepare(
    'SELECT realizado_en
     FROM resultados_quiz
     WHERE id = :id AND usuario_id = :usuario_id'
);
$consultaFecha->execute([
    ':id' => $idResultado,
    ':usuario_id' => $cuentaActual['id'],
]);

$responder(200, [
    'id' => $idResultado,
    'perfiles' => $generosSeleccionados,
    'realizado_en' => $consultaFecha->fetchColumn(),
]);
