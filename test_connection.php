<?php
// Incluir el archivo de conexión
require_once 'db.php';

// Consulta sencilla para testear la conexión (devuelve la fecha y hora actual de la base de datos)
$query = "SELECT NOW() AS now";
$result = $conexion->query($query);

if ($result) {
    // Recuperar el resultado de la consulta
    $row = $result->fetch_assoc();
    echo "Conexión exitosa. Fecha y hora actual de la base de datos: " . $row["now"];
} else {
    // Si ocurre un error en la consulta
    echo "Error al ejecutar la consulta: " . $conexion->error;
}

// Cerrar la conexión
$conexion->close();
?>
