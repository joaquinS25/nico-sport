<style>
    /* 🔹 Contenedor del logo dentro del navbar */
    .navbar-brand-logo {
        display: flex;
        align-items: center;      /* centra verticalmente */
        height: 70px;             /* 🔸 un poco más alto que el navbar estándar */
        margin-left: 10px;
    }

    /* 🔹 Estilos del logo */
    .logo-nico {
        width: 150px;
        height: auto;
        display: block;
        margin-top: 4px;          /* 🔸 pequeño espacio superior */
    }

    /* 🔹 Ajustes responsivos */
    @media (max-width: 768px) {
        .logo-nico {
            width: 110px;
            margin-top: 3px;
        }
    }

    @media (max-width: 576px) {
        .logo-nico {
            width: 90px;
            margin-top: 2px;
        }
    }

    /* 🔹 Aumenta la altura del navbar un poco */
    .sb-topnav.navbar {
        height: 70px !important;  /* 🔸 más espacio vertical */
        padding-top: 3px;
        padding-bottom: 3px;
    }
</style>

<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Logo de Nico Sports -->
    <div class="navbar-brand-logo">
        <img src="./logo/logo.png" alt="Nico Sports" class="logo-nico">
    </div>

    <!-- Botón de toggle (sidebar) -->
    <button class="btn btn-link btn-sm order-1 order-lg-0 ms-3" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Buscador -->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <div class="input-group">
            <input class="form-control" type="text" placeholder="Buscar..." aria-label="Buscar" />
            <button class="btn btn-primary" id="btnNavbarSearch" type="button">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>

    <!-- Menú de usuario -->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
               data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user fa-fw"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#!">Configuración</a></li>
                <li><a class="dropdown-item" href="#!">Registro de actividad</a></li>
                <li><hr class="dropdown-divider" /></li>
                <li><a class="dropdown-item" href="logout.php">Cerrar sesión</a></li>
            </ul>
        </li>
    </ul>
</nav>
