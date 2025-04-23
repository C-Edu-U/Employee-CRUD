<?php
ob_start(); // Intenta con output buffering si nada más funciona
include("../../db.php");

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

// Obtener lista de puestos
$puestos_stmt = $conexion->query("SELECT id, nombredelpuesto FROM puestos");
$puestos = $puestos_stmt->fetch_all(MYSQLI_ASSOC);

// Obtener datos actuales del empleado
$empleado_stmt = $conexion->prepare("SELECT * FROM empleados WHERE id = ?");
$empleado_stmt->bind_param("i", $id);
$empleado_stmt->execute();
$resultado = $empleado_stmt->get_result();

if ($resultado->num_rows === 0) {
    header("Location: error.php?mensaje=Empleado no encontrado");
    exit;
}

$empleado = $resultado->fetch_assoc();

if ($_POST) {
    $primernombre = $_POST['primernombre'];
    $segundonombre = $_POST['segundonombre'];
    $primerapellido = $_POST['primerapellido'];
    $segundoapellido = $_POST['segundoapellido'];
    $idpuesto = $_POST['idpuesto'];
    $fechadeingreso = $_POST['fechadeingreso'];

    // Ruta absoluta a la carpeta uploads
    $upload_dir = __DIR__ . '/../../uploads/';

    // Manejo de nueva foto (si se sube)
    if ($_FILES["foto"]["name"]) {
        $nombre_foto = time() . "_" . $_FILES["foto"]["name"];
        move_uploaded_file($_FILES["foto"]["tmp_name"], $upload_dir . $nombre_foto);

        // Eliminar la foto anterior si existe
        if ($empleado['foto'] && file_exists($upload_dir . $empleado['foto'])) {
            unlink($upload_dir . $empleado['foto']);
        }
    } else {
        $nombre_foto = $empleado['foto'];
    }

    // Manejo de nuevo CV (si se sube)
    if ($_FILES["cv"]["name"]) {
        $nombre_cv = time() . "_" . $_FILES["cv"]["name"];
        move_uploaded_file($_FILES["cv"]["tmp_name"], $upload_dir . $nombre_cv);

        // Eliminar el CV anterior si existe
        if ($empleado['cv'] && file_exists($upload_dir . $empleado['cv'])) {
            unlink($upload_dir . $empleado['cv']);
        }
    } else {
        $nombre_cv = $empleado['cv'];
    }

    // Actualizar la base de datos
    $stmt = $conexion->prepare("UPDATE empleados SET
        primernombre=?, segundonombre=?, primerapellido=?, segundoapellido=?,
        foto=?, cv=?, idpuesto=?, fechadeingreso=?
        WHERE id=?");

    $stmt->bind_param("ssssssisi", $primernombre, $segundonombre, $primerapellido, $segundoapellido,
        $nombre_foto, $nombre_cv, $idpuesto, $fechadeingreso, $id);
    $stmt->execute();

    header("Location: index.php");
    exit;
}

include("../../templates/header.php");
?>

<h1 class="mb-4">Editar Empleado</h1>

<form action="" method="post" enctype="multipart/form-data" id="form-editar">
    <div class="mb-3">
        <label class="form-label">Primer Nombre</label>
        <input type="text" class="form-control" name="primernombre" value="<?= $empleado['primernombre'] ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Segundo Nombre</label>
        <input type="text" class="form-control" name="segundonombre" value="<?= $empleado['segundonombre'] ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Primer Apellido</label>
        <input type="text" class="form-control" name="primerapellido" value="<?= $empleado['primerapellido'] ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Segundo Apellido</label>
        <input type="text" class="form-control" name="segundoapellido" value="<?= $empleado['segundoapellido'] ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Foto Actual</label><br>
        <?php if ($empleado['foto']): ?>
            <img src="../../uploads/<?= $empleado['foto'] ?>" width="60" class="img-thumbnail">
        <?php else: ?>
            <span class="text-muted">Sin foto</span>
        <?php endif; ?>
        <input type="file" class="form-control mt-2" name="foto" accept="image/*">
    </div>
    <div class="mb-3">
        <label class="form-label">CV Actual</label><br>
        <?php if ($empleado['cv']): ?>
            <a href="../../uploads/<?= $empleado['cv'] ?>" target="_blank" class="btn btn-outline-secondary btn-sm">Ver CV</a>
        <?php else: ?>
            <span class="text-muted">Sin CV</span>
        <?php endif; ?>
        <input type="file" class="form-control mt-2" name="cv">
    </div>
    <div class="mb-3">
        <label class="form-label">Puesto</label>
        <select class="form-select" name="idpuesto" required>
            <option value="">Selecciona un puesto</option>
            <?php foreach ($puestos as $puesto): ?>
                <option value="<?= $puesto['id'] ?>" <?= $empleado['idpuesto'] == $puesto['id'] ? 'selected' : '' ?>>
                    <?= $puesto['nombredelpuesto'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Fecha de Ingreso</label>
        <input type="date" class="form-control" name="fechadeingreso" value="<?= $empleado['fechadeingreso'] ?>" required>
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
</form>

<script>
function confirmarGuardar() {
    return confirm("💾 ¿Estás seguro de que deseas guardar los cambios?");
}
</script>

<!-- ✅ Confirmación al guardar -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('form-editar').addEventListener('submit', function (e) {
    e.preventDefault();

    Swal.fire({
        title: '¿Guardar cambios?',
        text: "Se actualizarán los datos del empleado.",
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


<?php
include("../../templates/footer.php");
ob_end_flush(); // Intenta con output buffering si nada más funciona
?>


