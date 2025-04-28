<?php
include("../../db.php");

session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login.php");
    exit;
}

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
    <div class="mb-3 position-relative">
        <label for="correo" class="form-label">Correo *</label>
        <input type="text" class="form-control" name="correo" id="correo" autocomplete="off">
        <ul id="sugerencias-correo" class="list-group position-absolute w-100 d-none" style="z-index:1000;"></ul>
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

<script>
const inputCorreo = document.getElementById('correo');
const listaCorreo = document.getElementById('sugerencias-correo');

const dominios = ['@gmail.com', '@outlook.com', '@hotmail.com', '@yahoo.com'];

inputCorreo.addEventListener('input', function () {
    const valor = this.value;
    listaCorreo.innerHTML = '';

    if (valor.includes('@') || valor.trim() === '') {
        listaCorreo.classList.add('d-none');
        return;
    }

    dominios.forEach(dominio => {
        const sugerido = valor + dominio;
        const li = document.createElement('li');
        li.classList.add('list-group-item', 'list-group-item-action');
        li.textContent = sugerido;
        li.addEventListener('click', () => {
            inputCorreo.value = sugerido;
            listaCorreo.innerHTML = '';
            listaCorreo.classList.add('d-none');
        });
        listaCorreo.appendChild(li);
    });

    listaCorreo.classList.remove('d-none');
});

document.addEventListener('click', (e) => {
    if (!inputCorreo.contains(e.target) && !listaCorreo.contains(e.target)) {
        listaCorreo.innerHTML = '';
        listaCorreo.classList.add('d-none');
    }
});
</script>


<?php include("../../templates/footer.php"); ?>
