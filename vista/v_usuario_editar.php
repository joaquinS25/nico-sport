<div class="container-fluid px-4">
    <h1 class="mt-4">Usuarios</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
        <li class="breadcrumb-item active">Usuarios</li>
    </ol>

    <div class="card mb-4">
       <div class="card-header">
            <i class="fas fa-table me-1"></i>Edición de Usuario
        </div>
        <div class="card-body">


            <form action="usuario_editar.php" method="post">


                <div class="row g-3">

                  <div class="col-md-5">
                    <input type="text" name="nom_usuario" value="<?php echo $nom_usuario; ?>" class="form-control" placeholder="Nombres" aria-label="Nombres" required="required">
                  </div>

                  <div class="col-md-5">
                    <input type="text" name="ape_usuario" value="<?php echo $ape_usuario; ?>" class="form-control" placeholder="Apellidos" aria-label="Apellidos" required="required">
                  </div>

                  <div class="col-md-4">
                    <input type="text" name="email_usuario" value="<?php echo $email_usuario; ?>"  class="form-control" placeholder="Email" aria-label="Email" required="required">
                  </div>

                  <div class="col-md-4">
                    <input type="text" name="user_usuario" value="<?php echo $user_usuario; ?>" class="form-control" placeholder="Usuario" aria-label="Usuario" required="required">
                  </div>

                  <div class="col-md-4">
                    <input type="text" name="pass_usuario" value="<?php echo $pass_usuario; ?>" class="form-control" placeholder="Password" aria-label="Password" required="required">
                  </div>

                  <div class="col-md-12">
                    <button type="submit" name="actualizar" value="<?php echo $id_usuario; ?>" class="btn btn-primary">Actualizar</button>

                  </div>

                </div>

            </form>

    


        </div>
    </div>  
</div>      