<?php
include("../../db.php");
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login.php");
    exit;
}

// Obtener los puestos para el <select>
$sentencia = $conexion->query("SELECT id, nombredelpuesto FROM puestos");
$puestos = $sentencia->fetch_all(MYSQLI_ASSOC);

// Procesar formulario
if ($_POST) {
    $primernombre = $_POST['primernombre'];
    $segundonombre = $_POST['segundonombre'];
    $primerapellido = $_POST['primerapellido'];
    $segundoapellido = $_POST['segundoapellido'];
    $idpuesto = $_POST['idpuesto'];
    $fechadeingreso = $_POST['fechadeingreso'];

    $upload_dir = __DIR__ . '/../../uploads/';
    if (!is_dir($upload_dir) || !is_writable($upload_dir)) {
        die("La carpeta 'uploads' no existe o no tiene permisos.");
    }

    $foto = "";
    if ($_FILES["foto"]["name"]) {
        $nombre_foto = time() . "_" . $_FILES["foto"]["name"];
        move_uploaded_file($_FILES["foto"]["tmp_name"], $upload_dir . $nombre_foto);
        $foto = $nombre_foto;
    }

    $cv = "";
    if ($_FILES["cv"]["name"]) {
        $nombre_cv = time() . "_" . $_FILES["cv"]["name"];
        move_uploaded_file($_FILES["cv"]["tmp_name"], $upload_dir . $nombre_cv);
        $cv = $nombre_cv;
    }

    $sentencia = $conexion->prepare("INSERT INTO empleados 
        (primernombre, segundonombre, primerapellido, segundoapellido, foto, cv, idpuesto, fechadeingreso)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $sentencia->bind_param("ssssssis", $primernombre, $segundonombre, $primerapellido, $segundoapellido, $foto, $cv, $idpuesto, $fechadeingreso);
    $sentencia->execute();

    header("Location: ../empleados/index.php");
    exit;
}

include("../../templates/header.php");
?>

<h1 class="mb-4">Crear Empleado</h1>

<form action="" method="post" enctype="multipart/form-data" id="form-crear-empleado" novalidate>
    <div class="mb-3">
        <label for="primernombre" class="form-label">Primer Nombre *</label>
        <input type="text" class="form-control" name="primernombre">
    </div>
    <div class="mb-3">
        <label for="segundonombre" class="form-label">Segundo Nombre</label>
        <input type="text" class="form-control" name="segundonombre">
    </div>
    <div class="mb-3">
        <label for="primerapellido" class="form-label">Primer Apellido *</label>
        <input type="text" class="form-control" name="primerapellido">
    </div>
    <div class="mb-3">
        <label for="segundoapellido" class="form-label">Segundo Apellido</label>
        <input type="text" class="form-control" name="segundoapellido">
    </div>
    <div class="mb-3">
        <label for="foto" class="form-label">Foto</label>
        <input type="file" class="form-control" name="foto" accept="image/*">
    </div>
    <div class="mb-3">
        <label for="cv" class="form-label">CV (PDF, Word, etc.)</label>
        <input type="file" class="form-control" name="cv">
    </div>
    <div class="mb-3">
        <label for="idpuesto" class="form-label">Puesto *</label>
        <select class="form-select" name="idpuesto">
            <option value="">Selecciona un puesto</option>
            <?php foreach ($puestos as $puesto): ?>
                <option value="<?= $puesto['id'] ?>"><?= $puesto['nombredelpuesto'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="fechadeingreso" class="form-label">Fecha de Ingreso</label>
        <input type="date" class="form-control" name="fechadeingreso">
    </div>

    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
</form>

<!-- ✅ Validación con SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('form-crear-empleado').addEventListener('submit', function (e) {
    e.preventDefault(); // Siempre detener envío para validación

    const nombre = document.querySelector('input[name="primernombre"]').value.trim();
    const apellido = document.querySelector('input[name="primerapellido"]').value.trim();
    const puesto = document.querySelector('select[name="idpuesto"]').value;

    if (nombre === '' || apellido === '' || puesto === '') {
        Swal.fire({
            icon: 'warning',
            title: 'Campos incompletos',
            text: 'Por favor completa el nombre, apellido y puesto.',
            confirmButtonColor: '#3085d6'
        });
        return false;
    }

    Swal.fire({
        title: '¿Guardar empleado?',
        text: "Se guardará la información en el sistema.",
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
