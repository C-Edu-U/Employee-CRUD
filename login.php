<?php
session_start();
include("db.php");

if ($_POST) {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    $query = $conexion->prepare("SELECT * FROM usuarios WHERE usuario = ? AND password = ?");
    $query->bind_param("ss", $usuario, $password);
    $query->execute();
    $resultado = $query->get_result();

    if ($resultado->num_rows === 1) {
        $_SESSION['usuario'] = $usuario;
        header("Location: secciones/empleados/index.php");
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>

<?php include("templates/header.php"); ?>

<h2 class="text-center mt-5">Iniciar Sesión</h2>

<div class="container w-50 mt-4">
    <form method="post" novalidate>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <!-- Campo con autocompletado -->
        <div class="mb-3 position-relative">
            <label class="form-label">Usuario</label>
            <input type="text" name="usuario" id="usuario" class="form-control" autocomplete="off">
            <ul id="sugerencias" class="list-group position-absolute w-100 d-none" style="z-index:1000;"></ul>
        </div>

        <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" name="password" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Ingresar</button>
    </form>
</div>

<!-- 🔍 Script de autocompletado visual -->
<script>
const inputUsuario = document.getElementById('usuario');
const sugerencias = document.getElementById('sugerencias');

inputUsuario.addEventListener('input', function () {
    const query = this.value.trim();
    sugerencias.innerHTML = '';
    if (query.length < 1) return;

    fetch(`buscar_usuarios.php?q=${encodeURIComponent(query)}`)
        .then(res => res.json())
        .then(data => {
            sugerencias.innerHTML = '';
            if (data.length === 0) {
                sugerencias.classList.add('d-none');
                return;
            }

            sugerencias.classList.remove('d-none');
            data.forEach(usuario => {
                const li = document.createElement('li');
                li.classList.add('list-group-item', 'list-group-item-action');
                li.textContent = usuario;
                li.addEventListener('click', () => {
                    inputUsuario.value = usuario;
                    sugerencias.innerHTML = '';
                    sugerencias.classList.add('d-none');
                });
                sugerencias.appendChild(li);
            });
        });
});

document.addEventListener('click', (e) => {
    if (!inputUsuario.contains(e.target) && !sugerencias.contains(e.target)) {
        sugerencias.innerHTML = '';
        sugerencias.classList.add('d-none');
    }
});
</script>

<?php include("templates/footer.php"); ?>
