<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("HTTP/1.1 403 Forbidden");
    exit("Acceso denegado. Debes iniciar sesión.");
}

require_once __DIR__ . '/../vendor/autoload.php';
include("../db.php");


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$tipo = $_GET['tipo'] ?? '';
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

switch ($tipo) {
    case 'empleados':
        $resultado = $conexion->query("
            SELECT e.id, CONCAT(e.primernombre, ' ', e.primerapellido) AS nombre, p.nombredelpuesto, e.fechadeingreso
            FROM empleados e
            LEFT JOIN puestos p ON e.idpuesto = p.id
        ");
        $sheet->setTitle('Empleados');
        $sheet->fromArray(['ID', 'Nombre', 'Puesto', 'Fecha de ingreso'], NULL, 'A1');
        break;

    case 'puestos':
        $resultado = $conexion->query("SELECT id, nombredelpuesto FROM puestos");
        $sheet->setTitle('Puestos');
        $sheet->fromArray(['ID', 'Nombre del puesto'], NULL, 'A1');
        break;

    case 'usuarios':
        $resultado = $conexion->query("SELECT id, usuario, correo FROM usuarios");
        $sheet->setTitle('Usuarios');
        $sheet->fromArray(['ID', 'Usuario', 'Correo'], NULL, 'A1');
        break;

    default:
        die("Tipo de reporte no válido.");
}

$fila = 2;
while ($row = $resultado->fetch_row()) {
    $sheet->fromArray($row, NULL, "A$fila");
    $fila++;
}

$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename={$tipo}_reporte.xlsx");
$writer->save("php://output");
exit;
