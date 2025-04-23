<?php
include("../../db.php");

// Lógica para eliminar empleado y archivos asociados
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];

    $stmt = $conexion->prepare("SELECT foto, cv FROM empleados WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $empleado = $result->fetch_assoc();
        $ruta_foto = __DIR__ . '/../../uploads/' . $empleado['foto'];
        $ruta_cv = __DIR__ . '/../../uploads/' . $empleado['cv'];

        if ($empleado['foto'] && file_exists($ruta_foto)) {
            unlink($ruta_foto);
        }
        if ($empleado['cv'] && file_exists($ruta_cv)) {
            unlink($ruta_cv);
        }

        $delete_stmt = $conexion->prepare("DELETE FROM empleados WHERE id = ?");
        $delete_stmt->bind_param("i", $id);
        $delete_stmt->execute();
    }

    header("Location: index.php");
    exit;
}

// Obtener empleados con su puesto
$sentencia = $conexion->query("
    SELECT 
        e.id,
        e.primernombre,
        e.segundonombre,
        e.primerapellido,
        e.segundoapellido,
        e.foto,
        e.cv,
        p.nombredelpuesto,
        e.fechadeingreso
    FROM empleados e
    LEFT JOIN puestos p ON e.idpuesto = p.id
");

$empleados = $sentencia->fetch_all(MYSQLI_ASSOC);

include("../../templates/header.php");
?>

<h1 class="mb-4">Lista de Empleados</h1>

<a href="crear.php" class="btn btn-primary mb-3">➕ Nuevo Empleado</a>

<div class="table-responsive">
    <table id="tablaDatos" class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre Completo</th>
                <th>Puesto</th>
                <th>Fecha de Ingreso</th>
                <th>Foto</th>
                <th>CV</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($empleados as $empleado): ?>
                <tr>
                    <td><?= $empleado['id'] ?></td>
                    <td><?= $empleado['primernombre'] ?> <?= $empleado['segundonombre'] ?> <?= $empleado['primerapellido'] ?> <?= $empleado['segundoapellido'] ?></td>
                    <td><?= $empleado['nombredelpuesto'] ?></td>
                    <td><?= $empleado['fechadeingreso'] ?></td>
                    <td>
                        <?php if ($empleado['foto']): ?>
                            <img src="../../uploads/<?= $empleado['foto'] ?>" width="60" class="img-thumbnail" />
                        <?php else: ?>
                            <span class="text-muted">Sin foto</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($empleado['cv']): ?>
                            <a href="../../uploads/<?= $empleado['cv'] ?>" target="_blank" class="btn btn-outline-secondary btn-sm">Ver CV</a>
                        <?php else: ?>
                            <span class="text-muted">Sin CV</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="editar.php?id=<?= $empleado['id'] ?>" class="btn btn-warning btn-sm">✏️ Editar</a>
                        <button class="btn btn-danger btn-sm btn-eliminar" data-id="<?= $empleado['id'] ?>">🗑️ Eliminar</button>
                        <a href="carta.php?id=<?= $empleado['id'] ?>" class="btn btn-info btn-sm" target="_blank">📄 Carta</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- ✅ SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.btn-eliminar').forEach(btn => {
    btn.addEventListener('click', function () {
        const id = this.getAttribute('data-id');

        Swal.fire({
            title: '¿Eliminar empleado?',
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

<!-- ✅ DataTables (ya cargado en header.php) -->
<script>
$(document).ready(function () {
    $('#tablaDatos').DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        }
    });
});
</script>

<?php include("../../templates/footer.php"); ?>
