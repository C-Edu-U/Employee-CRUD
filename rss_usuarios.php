<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("HTTP/1.1 403 Forbidden");
    exit("Acceso denegado. Debes iniciar sesión.");
}

header("Content-Type: application/rss+xml; charset=UTF-8");
include("db.php");


echo "<?xml version='1.0' encoding='UTF-8' ?>";
?>
<rss version="2.0">
  <channel>
    <title>Usuarios del Sistema</title>
    <link>http://localhost:8081/TECNOLOGIA/rss_usuarios.php</link>
    <description>Lista de usuarios registrados en el sistema</description>
    <language>es</language>

    <?php
    $usuarios = $conexion->query("SELECT usuario, correo FROM usuarios");
    while ($row = $usuarios->fetch_assoc()):
    ?>
    <item>
      <title><?= htmlspecialchars($row['usuario']) ?></title>
      <description><?= htmlspecialchars($row['correo']) ?></description>
    </item>
    <?php endwhile; ?>
  </channel>
</rss>
