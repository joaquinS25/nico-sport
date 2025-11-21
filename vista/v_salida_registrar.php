<div class="container-fluid px-4">
    <h1 class="mt-4">Salida de Mercaderia</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
        <li class="breadcrumb-item active">Salida de Mercaderia</li>
    </ol>

    <div class="card mb-4">
       <div class="card-header">
            <i class="fas fa-table me-1"></i>Regstro de Salida de Mercaderia
        </div>
        <div class="card-body">


            <form action="salida_registrar.php" method="post">

                <div class="row g-3">
                  
                  <div class="col-md-6">
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre" aria-label="Nombre" required="required">
                  </div>

                  <div class="col-md-6">
                    <input type="text" name="cantidad" class="form-control" placeholder="Cantidad" aria-label="Cantidad" required="required">
                  </div>
                  
                  <div class="col-md-6">
                    <input type="text" name="producto" class="form-control" placeholder="Producto" aria-label="Producto" required="required">
                  </div>
                  
                  <div class="col-md-6">
                    <input type="text" name="precio" class="form-control" placeholder="Precio" aria-label="Precio" required="required">
                  </div>
                  
                  <div class="col-md-6">
                    <input type="date" name="fecha_registro" class="form-control" placeholder="Fecha de Registro" aria-label="Fecha de Registro" required="required">
                  </div>
                  
                  
                  <div class="col-md-12">
                    <button type="submit" name="registrar" class="btn btn-primary">Registrar</button>
                  </div>

                </div>

            </form>

    


        </div>
    </div>  
</div>      