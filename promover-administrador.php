<?php
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

require_once __DIR__ . '/conexion.php';

$correoAdministrador = 'admin@gmail.com';
$buscarAdministrador = $conexion->prepare(
    'SELECT id, rol FROM usuarios_popstar WHERE correo = :correo'
);
$buscarAdministrador->execute([':correo' => $correoAdministrador]);
$administrador = $buscarAdministrador->fetch();

if (!$administrador) {
    fwrite(STDERR, "No existe la cuenta {$correoAdministrador}. Regístrala primero desde la tienda.\n");
    exit(1);
}

if ($administrador['rol'] === 'administrador') {
    fwrite(STDOUT, "La cuenta {$correoAdministrador} ya es administradora.\n");
    exit(0);
}

$promoverAdministrador = $conexion->prepare(
    "UPDATE usuarios_popstar SET rol = 'administrador' WHERE id = :id"
);
$promoverAdministrador->execute([':id' => $administrador['id']]);
fwrite(STDOUT, "La cuenta {$correoAdministrador} ahora tiene rol de administradora.\n");
