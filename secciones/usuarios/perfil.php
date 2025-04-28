<?php
session_start();
include("../../db.php");
include("../../templates/header.php");

$usuario = $_SESSION['usuario'] ?? '';
$perfil = null;

if ($usuario) {
    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $perfil = $stmt->get_result()->fetch_assoc();
}
?>

<h2 class="mb-4">👤 Mi Perfil</h2>

<?php if ($perfil): ?>
    <ul class="list-group">
        <li class="list-group-item"><strong>Usuario:</strong> <?= $perfil['usuario'] ?></li>
        <li class="list-group-item"><strong>Correo:</strong> <?= $perfil['correo'] ?></li>
    </ul>

    <a href="editar.php?id=<?= $perfil['id'] ?>" class="btn btn-warning mt-3">✏️ Editar mis datos</a>
<?php else: ?>
    <div class="alert alert-warning">No se encontró la información del usuario.</div>
<?php endif; ?>

<a href="../empleados/index.php" class="btn btn-secondary mt-3">Volver</a>

<?php include("../../templates/footer.php"); ?>

