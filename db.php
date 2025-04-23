<?php
// Configuración de la conexión
$host     = 'db';             // Nombre del servicio en Docker Compose para MariaDB
$username = 'root';           // Usuario (puedes crear uno específico si lo prefieres)
$password = 'notSecureChangeMe';  // Contraseña definida para el usuario root
$dbname   = 'app';            // Nombre de la base de datos a la que quieres conectarte

// Crear la conexión con mysqli
$conexion = new mysqli($host, $username, $password, $dbname);

// Verificar si la conexión se realizó correctamente
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// echo "¡Conexión exitosa a la base de datos '{$dbname}'!";
?>
