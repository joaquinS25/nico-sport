<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Sistema de Ventas - Login" />
    <meta name="author" content="Tecno Joaquin" />
    <title>Iniciar Sesión</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Íconos -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Estilos personalizados -->
    <style>
        body {
            background: linear-gradient(135deg, #007bff, #6610f2);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: "Poppins", sans-serif;
        }
        .card {
            border: none;
            border-radius: 1.5rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-header {
            background: transparent;
            border-bottom: none;
            text-align: center;
            padding-top: 1.5rem;
        }
        .card-header h3 {
            font-weight: 600;
            color: #333;
        }
        .form-control {
            border-radius: 0.75rem;
        }
        .btn-primary {
            width: 100%;
            border-radius: 0.75rem;
            background: linear-gradient(135deg, #007bff, #6610f2);
            border: none;
            font-weight: 500;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #6610f2, #007bff);
        }
        .small a {
            text-decoration: none;
            color: #6610f2;
        }
        .small a:hover {
            text-decoration: underline;
        }
        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: rgba(255,255,255,0.1);
            color: #fff;
            text-align: center;
            padding: 0.5rem;
        }
        @media (max-width: 768px) {
            .card {
                margin: 1rem;
            }
        }
    </style>
</head>
<body>
    <main class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card mt-4">
                    <div class="card-header">
                        <h3><i class="fas fa-user-circle text-primary"></i> Iniciar Sesión</h3>
                    </div>
                    <div class="card-body px-4 py-3">
                        <form action="autentificacion.php" method="post">
                            <div class="form-floating mb-3">
                                <input class="form-control" name="user" id="inputEmail" type="text" placeholder="Usuario" required />
                                <label for="inputEmail"><i class="fas fa-user me-2"></i>Usuario</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" name="pass" id="inputPassword" type="password" placeholder="Contraseña" required />
                                <label for="inputPassword"><i class="fas fa-lock me-2"></i>Contraseña</label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" id="inputRememberPassword" type="checkbox" />
                                <label class="form-check-label" for="inputRememberPassword">Recordar sesión</label>
                            </div>
                            <button class="btn btn-primary" name="ingresar" type="submit">Ingresar</button>
                        </form>
                    </div>
                    <div class="card-footer text-center py-3">
                        <div class="small">
                            <a href="register.html">¿No tienes una cuenta? Regístrate</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div>© <?php echo date('Y'); ?> - Sistema de Ventas | Desarrollado por Tecno Joaquin</div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error de acceso',
                text: 'Usuario o contraseña incorrectos.',
                confirmButtonColor: '#007bff'
            });
        </script>
    <?php endif; ?>
</body>
</html>
