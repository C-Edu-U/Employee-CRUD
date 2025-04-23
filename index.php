<?php include("templates/header.php"); ?>

<div class="text-center py-5">
    <h1 class="display-4 mb-3">Bienvenido al Sistema de Gestión de Empleados</h1>
    <p class="lead mb-4">Administra fácilmente tus empleados, puestos y usuarios con este sistema web construido en PHP + Bootstrap.</p>

    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="card border-primary">
                <div class="card-body">
                    <h5 class="card-title">👥 Empleados</h5>
                    <p class="card-text">Gestiona el personal de la empresa.</p>
                    <a href="secciones/empleados/index.php" class="btn btn-primary">Ver Empleados</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-success">
                <div class="card-body">
                    <h5 class="card-title">🏷️ Puestos</h5>
                    <p class="card-text">Administra los distintos roles y cargos.</p>
                    <a href="secciones/puestos/index.php" class="btn btn-success">Ver Puestos</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-dark">
                <div class="card-body">
                    <h5 class="card-title">🔐 Usuarios</h5>
                    <p class="card-text">Controla el acceso al sistema.</p>
                    <a href="secciones/usuarios/index.php" class="btn btn-dark">Ver Usuarios</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("templates/footer.php"); ?>
