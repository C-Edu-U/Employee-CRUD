<?php
include("../../db.php");

session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login.php");
    exit;
}

// Intento de eliminación
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];

    $verifica = $conexion->prepare("SELECT COUNT(*) as total FROM empleados WHERE idpuesto = ?");
    $verifica->bind_param("i", $id);
    $verifica->execute();
    $resultado = $verifica->get_result()->fetch_assoc();

    if ($resultado['total'] == 0) {
        $sentencia = $conexion->prepare("DELETE FROM puestos WHERE id = ?");
        $sentencia->bind_param("i", $id);
        $sentencia->execute();
        header("Location: index.php");
    } else {
        // Error: puesto tiene empleados
        header("Location: index.php?error=asignado");
    }
    exit;
}

// Obtener todos los puestos
$consulta = $conexion->query("SELECT * FROM puestos");
$puestos = $consulta->fetch_all(MYSQLI_ASSOC);

include("../../templates/header.php");
?>

<h1 class="mb-4">Puestos</h1>

<a href="crear.php" class="btn btn-primary mb-3">➕ Nuevo Puesto</a>

<div class="table-responsive">
    <table id="tablaDatos" class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre del Puesto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($puestos as $puesto): ?>
                <tr>
                    <td><?= $puesto['id'] ?></td>
                    <td><?= $puesto['nombredelpuesto'] ?></td>
                    <td>
                        <a href="editar.php?id=<?= $puesto['id'] ?>" class="btn btn-warning btn-sm">✏️ Editar</a>
                        <button class="btn btn-danger btn-sm btn-eliminar" data-id="<?= $puesto['id'] ?>">🗑️ Eliminar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- ✅ DataTables init -->
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

<!-- ✅ SweetAlert2 confirmación al eliminar -->
<script>
document.querySelectorAll('.btn-eliminar').forEach(btn => {
    btn.addEventListener('click', function () {
        const id = this.getAttribute('data-id');

        Swal.fire({
            title: '¿Eliminar puesto?',
            text: "Solo se eliminará si no tiene empleados asignados.",
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

<!-- ✅ SweetAlert2 error si hay empleados asignados -->
<?php if (isset($_GET['error']) && $_GET['error'] === 'asignado'): ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'No se puede eliminar',
    text: 'Este puesto tiene empleados asignados.',
    confirmButtonColor: '#d33'
});
</script>
<?php endif; ?>

<?php include("../../templates/footer.php"); ?>


