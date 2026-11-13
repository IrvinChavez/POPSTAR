<?php
// En Railway se usan las variables que expone el servicio MySQL.
// Los valores locales mantienen compatibilidad con XAMPP.
$host = getenv('POPSTAR_DB_HOST') ?: getenv('MYSQLHOST') ?: 'localhost';
$puerto = getenv('POPSTAR_DB_PORT') ?: getenv('MYSQLPORT') ?: '3306';
$baseDatos = getenv('POPSTAR_DB_NAME') ?: getenv('MYSQLDATABASE') ?: 'popstar';
$usuario = getenv('POPSTAR_DB_USER') ?: getenv('MYSQLUSER') ?: 'root';
$contraseña = getenv('POPSTAR_DB_PASSWORD') ?: getenv('MYSQLPASSWORD') ?: '';

$conexion = new PDO(
    "mysql:host={$host};port={$puerto};dbname={$baseDatos};charset=utf8mb4",
    $usuario,
    $contraseña,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]
);
