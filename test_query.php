<?php
// Incluir el archivo de conexión
require_once __DIR__ . '/db.php';

// Consulta para obtener los datos de la tabla empleados junto con el nombre del puesto
$query = "
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
";

// Ejecutar la consulta
$result = $conexion->query($query);

if ($result) {
    if ($result->num_rows > 0) {
        echo "<h2>Lista de Empleados</h2>";
        echo "<table border='1' cellspacing='0' cellpadding='8'>";
        echo "<tr>
                <th>ID</th>
                <th>Primer Nombre</th>
                <th>Segundo Nombre</th>
                <th>Primer Apellido</th>
                <th>Segundo Apellido</th>
                <th>Foto</th>
                <th>CV</th>
                <th>Puesto</th>
                <th>Fecha de Ingreso</th>
              </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['primernombre']}</td>
                    <td>{$row['segundonombre']}</td>
                    <td>{$row['primerapellido']}</td>
                    <td>{$row['segundoapellido']}</td>
                    <td>{$row['foto']}</td>
                    <td>{$row['cv']}</td>
                    <td>{$row['nombredelpuesto']}</td>
                    <td>{$row['fechadeingreso']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron registros en la tabla empleados.";
    }
} else {
    echo "Error en la consulta: " . $conexion->error;
}

// Cerrar la conexión
$conexion->close();
?>
