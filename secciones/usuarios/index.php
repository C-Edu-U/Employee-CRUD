<?php
include("../../db.php");

// Eliminar usuario
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $stmt = $conexion->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: index.php");
    exit;
}

// Obtener usuarios
$consulta = $conexion->query("SELECT * FROM usuarios");
$usuarios = $consulta->fetch_all(MYSQLI_ASSOC);

include("../../templates/header.php");
?>

<h1 class="mb-4">Usuarios</h1>

<a href="crear.php" class="btn btn-primary mb-3">➕ Nuevo Usuario</a>

<div class="table-responsive">
    <table id="tablaDatos" class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Correo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= $usuario['id'] ?></td>
                    <td><?= $usuario['usuario'] ?></td>
                    <td><?= $usuario['correo'] ?></td>
                    <td>
                        <a href="editar.php?id=<?= $usuario['id'] ?>" class="btn btn-warning btn-sm">✏️ Editar</a>
                        <button class="btn btn-danger btn-sm btn-eliminar" data-id="<?= $usuario['id'] ?>">🗑️ Eliminar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- ✅ Inicialización de DataTables v2.2.2 -->
<script>
$(document).ready(function () {
    new DataTable('#tablaDatos', {
        responsive: true,
        language: {
            url: "//cdn.datatables.net/plug-ins/2.0.0/i18n/es-ES.json"
        }
    });
});
</script>

<!-- ✅ Confirmación SweetAlert2 para eliminación -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.btn-eliminar').forEach(btn => {
    btn.addEventListener('click', function () {
        const id = this.getAttribute('data-id');

        Swal.fire({
            title: '¿Eliminar usuario?',
            text: "Esta acción no se puede deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `index.php?eliminar=${id}`;
            }
        });
    });
});
</script>

<?php include("../../templates/footer.php"); ?>
