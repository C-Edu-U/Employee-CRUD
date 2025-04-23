<?php
include("../../db.php");

if ($_POST) {
    $nombre = $_POST['nombredelpuesto'];

    $sentencia = $conexion->prepare("INSERT INTO puestos (nombredelpuesto) VALUES (?)");
    $sentencia->bind_param("s", $nombre);
    $sentencia->execute();

    header("Location: index.php");
    exit;
}

include("../../templates/header.php");
?>

<h1 class="mb-4">Crear Puesto</h1>

<form method="post" id="form-crear-puesto" novalidate>
    <div class="mb-3">
        <label for="nombredelpuesto" class="form-label">Nombre del Puesto *</label>
        <input type="text" class="form-control" name="nombredelpuesto">
    </div>

    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('form-crear-puesto').addEventListener('submit', function (e) {
    e.preventDefault();

    const nombre = document.querySelector('input[name="nombredelpuesto"]').value.trim();

    if (nombre === '') {
        Swal.fire({
            icon: 'warning',
            title: 'Campo obligatorio',
            text: 'Debes ingresar el nombre del puesto.',
            confirmButtonColor: '#3085d6'
        });
        return false;
    }

    Swal.fire({
        title: '¿Guardar puesto?',
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
