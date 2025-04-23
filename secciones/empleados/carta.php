<?php
require '../../vendor/autoload.php';
use Dompdf\Dompdf;

include("../../db.php");

if (!isset($_GET['id'])) {
    die("ID no especificado.");
}

$id = $_GET['id'];

$stmt = $conexion->prepare("SELECT e.*, p.nombredelpuesto FROM empleados e LEFT JOIN puestos p ON e.idpuesto = p.id WHERE e.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    die("Empleado no encontrado.");
}

$empleado = $resultado->fetch_assoc();

// Contenido de la carta
$html = '
    <h2 style="text-align:center;">Carta de Recomendación Laboral</h2>
    <p>La presente tiene como finalidad recomendar al Sr./Sra. <strong>' . $empleado['primernombre'] . ' ' . $empleado['segundonombre'] . ' ' . $empleado['primerapellido'] . ' ' . $empleado['segundoapellido'] . '</strong>, quien ha desempeñado el cargo de <strong>' . $empleado['nombredelpuesto'] . '</strong> en nuestra institución.</p>
    <p>Durante el tiempo de servicio, desde su ingreso el <strong>' . $empleado['fechadeingreso'] . '</strong>, ha demostrado compromiso, responsabilidad y profesionalismo.</p>
    <p>Por tanto, se extiende esta carta como constancia de su buen desempeño y conducta, para los fines que considere convenientes.</p>
    <br><br>
    <p>Atentamente,</p>
    <p><strong>Recursos Humanos</strong><br>UPDS</p>
';

// Generar el PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4');
$dompdf->render();

// Descargar el PDF
$dompdf->stream("Carta_Recomendacion_{$empleado['primernombre']}.pdf", ["Attachment" => false]);
exit;
