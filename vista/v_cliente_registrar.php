<div class="container-fluid px-4">

    <h1 class="mt-4">Cliente</h1>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
        <li class="breadcrumb-item active">Cliente</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i> Registro de Cliente
        </div>

        <div class="card-body">

            <form action="cliente_registrar.php" method="post">

                <div class="row g-3">

                    <div class="col-md-6">
                        <input type="text" name="nom_cliente" class="form-control" placeholder="Nombre" required>
                    </div>

                    <div class="col-md-6">
                        <input type="text" name="cel_cliente" class="form-control" placeholder="Celular" required>
                    </div>

                    <div class="col-md-6">
                        <input type="text" name="tienda_cliente" class="form-control" placeholder="Nº Tienda" required>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" name="registrar" class="btn btn-primary">
                            Registrar Cliente
                        </button>
                    </div>

                </div>

            </form>

        </div>
    </div>

</div>
