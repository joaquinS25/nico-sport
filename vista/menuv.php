<?php 
// ✅ session_start seguro
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['autentificado']) || !$_SESSION['autentificado']) {
    header('location: index.php');
    exit();
}
?>

<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">

        <div class="sb-sidenav-menu">
            <div class="nav">

                <div class="sb-sidenav-menu-heading">Reportes</div>
                
                <a class="nav-link" href="dashboard.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-bar"></i></div>
                    Dashboard
                </a>

                <div class="sb-sidenav-menu-heading">Gestión de módulos</div>

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#venta"
                   aria-expanded="false">
                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                    Ventas
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="venta" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="venta_listar.php">Listado</a>
                        <a class="nav-link" href="venta_registrar.php">Nuevo</a>
                    </nav>
                </div>

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#usuario"
                   aria-expanded="false">
                    <div class="sb-nav-link-icon"><i class="fas fa-address-book"></i></div>
                    Usuarios
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="usuario" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="usuario_listar.php">Listado</a>
                        <a class="nav-link" href="usuario_registrar.php">Nuevo</a>
                    </nav>
                </div>

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#mp"
                   aria-expanded="false">
                    <div class="sb-nav-link-icon"><i class="fas fa-calculator"></i></div>
                    Medios de Pago
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="mp" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="mediopago_listar.php">Listado</a>
                        <a class="nav-link" href="mediopago_registrar.php">Nuevo</a>
                    </nav>
                </div>

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#tc"
                   aria-expanded="false">
                    <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                    Tipos de Comprobante
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="tc" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="tipocomprobante_listar.php">Listado</a>
                        <a class="nav-link" href="tipocomprobante_registrar.php">Nuevo</a>
                    </nav>
                </div>

            </div>
        </div>

        <div class="sb-sidenav-footer">
            <div class="small">Usuario:</div>
            <?= $_SESSION['nom_session']; ?>
        </div>

    </nav>
</div>
