<?php
require_once __DIR__ . '/../conexion.php';

$catalogoSemilla = json_decode(
    file_get_contents(__DIR__ . '/../catalogo-discos.json'),
    true,
    512,
    JSON_THROW_ON_ERROR
);
$codigosCatalogo = array_column($catalogoSemilla, 'codigo');
$marcadoresCatalogo = implode(',', array_fill(0, count($codigosCatalogo), '?'));
$consultaCodigos = $conexion->prepare(
    "SELECT COUNT(DISTINCT codigo)
     FROM catalogo_discos
     WHERE codigo IN ({$marcadoresCatalogo})"
);
$consultaCodigos->execute($codigosCatalogo);

if ((int) $consultaCodigos->fetchColumn() !== count($catalogoSemilla)) {
    $insertarDisco = $conexion->prepare(
        'INSERT IGNORE INTO catalogo_discos (codigo, titulo, artista, precio, imagen, stock)
         VALUES (:codigo, :titulo, :artista, :precio, :imagen, :stock)'
    );

    foreach ($catalogoSemilla as $disco) {
        $insertarDisco->execute([
            ':codigo' => $disco['codigo'],
            ':titulo' => $disco['titulo'],
            ':artista' => $disco['artista'],
            ':precio' => $disco['precio'],
            ':imagen' => $disco['imagen'],
            ':stock' => $disco['stock_inicial'],
        ]);
    }
}

$productosCatalogo = $conexion->query(
    'SELECT id, codigo, titulo, artista, precio, imagen, stock
     FROM catalogo_discos
     ORDER BY id'
)->fetchAll();
$jsonProductosCatalogo = json_encode(
    $productosCatalogo,
    JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR
);
