<div class="container-fluid px-4">
    <h1 class="mt-4">Medios de Pago</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
        <li class="breadcrumb-item active">Medios de Pago</li>
    </ol>

    <div class="card mb-4">
       <div class="card-header">
            <i class="fas fa-table me-1"></i>Regstro de Medio de Pago
        </div>
        <div class="card-body">


            <form action="mediopago_registrar.php" method="post">

                <div class="row g-3">
                  
                  <div class="col-md-6">
                    <input type="text" name="nom_mediopago" class="form-control" placeholder="Nombre" aria-label="Nombre" required="required">
                  </div>

                  <div class="col-md-12">
                    <button type="submit" name="registrar" class="btn btn-primary">Registrar</button>
                  </div>

                </div>

            </form>

    


        </div>
    </div>  
</div>      