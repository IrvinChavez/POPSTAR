<?php 
$host = 'localhost';
$baseDatos = 'popstar';
$usuario = 'root';
$contraseña = '';

$conexion = new PDO(
    "mysql:host={$host};dbname={$baseDatos};charset=utf8mb4",
    $usuario,
    $contraseña,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]
);
