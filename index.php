<?php
session_start();
include("templates/header.php");
?>


<div class="container mt-5">
    <h1 class="text-center mb-4">Sistema de Gestión de Personal</h1>

    <!-- Sección de accesos rápidos con grillas -->
    <div class="row g-4">
        <!-- Empleados -->
        <div class="col-md-4">
            <div class="card text-center shadow-sm border-primary">
                <div class="card-body">
                    <h5 class="card-title">👨‍💼 Empleados</h5>
                    <p class="card-text">Ver, agregar o editar los empleados registrados.</p>
                    <a href="secciones/empleados/index.php" class="btn btn-outline-primary w-100">Ir a Empleados</a>
                </div>
            </div>
        </div>

        <!-- Puestos -->
        <div class="col-md-4">
            <div class="card text-center shadow-sm border-success">
                <div class="card-body">
                    <h5 class="card-title">🧰 Puestos</h5>
                    <p class="card-text">Gestiona los distintos puestos de trabajo.</p>
                    <a href="secciones/puestos/index.php" class="btn btn-outline-success w-100">Ir a Puestos</a>
                </div>
            </div>
        </div>

        <!-- Usuarios -->
        <div class="col-md-4">
            <div class="card text-center shadow-sm border-warning">
                <div class="card-body">
                    <h5 class="card-title">🔐 Usuarios</h5>
                    <p class="card-text">Administra los usuarios del sistema.</p>
                    <a href="secciones/usuarios/index.php" class="btn btn-outline-warning w-100">Ir a Usuarios</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección RSS -->
    <div class="card mt-5">
    <div class="card-header bg-info text-white">
        📡 Usuarios en formato RSS
    </div>
    <div class="card-body">
        <p>Visualiza o descarga el listado de usuarios en formato XML RSS:</p>
        <a href="rss_usuarios.php" class="btn btn-outline-info" target="_blank">Ver RSS de usuarios</a>
    </div>
    </div>


    <!-- Sección de descarga de reportes -->
    <div class="card mt-4">
        <div class="card-header bg-success text-white">
            📥 Descarga de Reportes en Excel
        </div>
        <div class="card-body">
            <p>Puedes exportar los registros en formato Excel para respaldo o análisis:</p>
            <a href="reportes/descargar_reporte.php?tipo=empleados" class="btn btn-outline-primary me-2">📄 Empleados</a>
            <a href="reportes/descargar_reporte.php?tipo=puestos" class="btn btn-outline-success me-2">📄 Puestos</a>
            <a href="reportes/descargar_reporte.php?tipo=usuarios" class="btn btn-outline-warning">📄 Usuarios</a>
        </div>
    </div>

    <div class="text-center mt-5">
        <p class="text-muted">Desarrollado por Carlos Eduardo · Proyecto UPDS</p>
    </div>
</div>

<?php include("templates/footer.php"); ?>

