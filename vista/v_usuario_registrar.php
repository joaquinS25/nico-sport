<div class="container-fluid px-4">

    <h1 class="mt-4">Usuario</h1>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
        <li class="breadcrumb-item active">Usuario</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i> Registro de Usuario
        </div>

        <div class="card-body">

            <form action="usuario_registrar.php" method="post">

                <div class="row g-3">

                    <div class="col-md-6">
                        <input type="text" name="nom_usuario" class="form-control" placeholder="Nombre" required>
                    </div>

                    <div class="col-md-6">
                        <input type="text" name="ape_usuario" class="form-control" placeholder="Apellido" required>
                    </div>

                    <div class="col-md-6">
                        <input type="text" name="email_usuario" class="form-control" placeholder="Email" required>
                    </div>

                    <div class="col-md-6">
                        <input type="text" name="user_usuario" class="form-control" placeholder="User" required>
                    </div>

                    <div class="col-md-6">
                        <input type="text" name="pass_usuario" class="form-control" placeholder="Password" required>
                    </div>

                    <div class="col-md-12">
                        <button type="submit" name="registrar" class="btn btn-primary">
                            Registrar Usuario
                        </button>
                    </div>

                </div>

            </form>

        </div>
    </div>

</div>
