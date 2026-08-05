<div class="container-fluid px-4">
    <h1 class="mt-4">Clientes</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
        <li class="breadcrumb-item active">Clientes</li>
    </ol>

    <div class="card mb-4">
       <div class="card-header">
            <i class="fas fa-table me-1"></i>Edición de Cliente
        </div>
        <div class="card-body">


            <form action="cliente_editar.php" method="post">


                <div class="row g-3">

                  <div class="col-md-5">
                    <input type="text" name="nom_cliente" value="<?php echo $nom_cliente; ?>" class="form-control" placeholder="Nombre" aria-label="Nombres" required="required">
                  </div>

                  <div class="col-md-5">
                    <input type="text" name="cel_cliente" value="<?php echo $cel_cliente; ?>" class="form-control" placeholder="celular" aria-label="Apellidos" required="required">
                  </div>

                  <div class="col-md-4">
                    <input type="text" name="tienda_cliente" value="<?php echo $tienda_cliente; ?>"  class="form-control" placeholder="Nº Tienda" aria-label="Email" required="required">
                  </div>

                  
                  <div class="col-md-12">
                    <button type="submit" name="actualizar" value="<?php echo $id_cliente; ?>" class="btn btn-primary">Actualizar</button>

                  </div>

                </div>

            </form>

    


        </div>
    </div>  
</div>      