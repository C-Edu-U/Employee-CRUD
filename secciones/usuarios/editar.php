<?php
include("../../db.php");

session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

// Obtener usuario actual
$stmt = $conexion->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    echo "<div class='alert alert-danger'>Usuario no encontrado.</div>";
    include("../../templates/footer.php");
    exit;
}

$usuario = $resultado->fetch_assoc();

if ($_POST) {
    $nombre = $_POST['usuario'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    $update = $conexion->prepare("UPDATE usuarios SET usuario=?, password=?, correo=? WHERE id=?");
    $update->bind_param("sssi", $nombre, $password, $correo, $id);
    $update->execute();

    header("Location: index.php");
    exit;
}

include("../../templates/header.php");
?>

<h1 class="mb-4">Editar Usuario</h1>

<form method="post" id="form-editar">
    <div class="mb-3">
        <label for="usuario" class="form-label">Nombre de Usuario</label>
        <input type="text" class="form-control" name="usuario" value="<?= $usuario['usuario'] ?>" required>
    </div>
    <div class="mb-3">
        <label for="correo" class="form-label">Correo</label>
        <input type="email" class="form-control" name="correo" value="<?= $usuario['correo'] ?>" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Contraseña</label>
        <input type="text" class="form-control" name="password" value="<?= $usuario['password'] ?>" required>
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
</form>

<!-- ✅ SweetAlert al guardar -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('form-editar').addEventListener('submit', function (e) {
    e.preventDefault();

    Swal.fire({
        title: '¿Guardar cambios?',
        text: "Se actualizará la información del usuario.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, guardar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        }
    });
});
</script>

<?php include("../../templates/footer.php"); ?>

