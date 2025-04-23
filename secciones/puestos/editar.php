<?php
include("../../db.php");

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

// Obtener puesto actual
$sentencia = $conexion->prepare("SELECT * FROM puestos WHERE id = ?");
$sentencia->bind_param("i", $id);
$sentencia->execute();
$resultado = $sentencia->get_result();

if ($resultado->num_rows === 0) {
    echo "<div class='alert alert-danger'>Puesto no encontrado.</div>";
    include("../../templates/footer.php");
    exit;
}

$puesto = $resultado->fetch_assoc();

if ($_POST) {
    $nombre = $_POST['nombredelpuesto'];

    $update = $conexion->prepare("UPDATE puestos SET nombredelpuesto = ? WHERE id = ?");
    $update->bind_param("si", $nombre, $id);
    $update->execute();

    header("Location: index.php");
    exit;
}

include("../../templates/header.php");
?>

<h1 class="mb-4">Editar Puesto</h1>

<form method="post" id="form-editar">
    <div class="mb-3">
        <label for="nombredelpuesto" class="form-label">Nombre del Puesto</label>
        <input type="text" class="form-control" name="nombredelpuesto" value="<?= $puesto['nombredelpuesto'] ?>" required>
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
        text: "Se actualizará el nombre del puesto.",
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
