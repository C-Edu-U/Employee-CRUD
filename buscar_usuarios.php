<?php
include("db.php");

$termino = $_GET['q'] ?? '';

if ($termino !== '') {
    $stmt = $conexion->prepare("SELECT usuario FROM usuarios WHERE usuario LIKE CONCAT(?, '%') LIMIT 10");
    $stmt->bind_param("s", $termino);
    $stmt->execute();
    $resultado = $stmt->get_result();

    $usuarios = [];
    while ($fila = $resultado->fetch_assoc()) {
        $usuarios[] = $fila['usuario'];
    }

    header('Content-Type: application/json');
    echo json_encode($usuarios);
}
