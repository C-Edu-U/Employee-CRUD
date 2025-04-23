<?php
include("../../db.php");

if ($_POST) {
    $usuario = $_POST['usuario'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    $sentencia = $conexion->prepare("INSERT INTO usuarios (usuario, correo, password) VALUES (?, ?, ?)");
    $sentencia->bind_param("sss", $usuario, $correo, $password);
    $sentencia->execute();

    header("Location: index.php");
    exit;
}

include("../../templates/header.php");
?>

<h1 class="mb-4">Crear Usuario</h1>

<form method="post" id="form-crear-usuario" novalidate>
    <div class="mb-3">
        <label for="usuario" class="form-label">Nombre de Usuario *</label>
        <input type="text" class="form-control" name="usuario">
    </div>
    <div class="mb-3">
        <label for="correo" class="form-label">Correo *</label>
        <input type="email" class="form-control" name="correo">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Contraseña *</label>
        <input type="text" class="form-control" name="password">
    </div>

    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('form-crear-usuario').addEventListener('submit', function (e) {
    e.preventDefault();

    const usuario = document.querySelector('input[name="usuario"]').value.trim();
    const correo = document.querySelector('input[name="correo"]').value.trim();
    const password = document.querySelector('input[name="password"]').value.trim();

    if (usuario === '' || correo === '' || password === '') {
        Swal.fire({
            icon: 'warning',
            title: 'Campos incompletos',
            text: 'Completa todos los campos: usuario, correo y contraseña.',
            confirmButtonColor: '#3085d6'
        });
        return false;
    }

    Swal.fire({
        title: '¿Guardar usuario?',
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
