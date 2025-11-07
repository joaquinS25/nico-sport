<div class="container-fluid px-4">
    <h1 class="mt-4">Lista de Usuarios</h1>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
                Usuarios
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th>Usuario</th>
                        <th>Pasword</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                       <th>#</th>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th>Usuario</th>
                        <th>Pasword</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php 
                        $n=0;
                        foreach ($usuario as $key => $value) 
                        {
                            $n++;
                            $id_usuario = $value['id_usuario'];
                            $nom_usuario = $value['nom_usuario'];
                            $ape_usuario = $value['ape_usuario'];
                            $email_usuario = $value['email_usuario'];
                            $usu_usuario = $value['user_usuario'];
                            $pass_usuario = $value['pass_usuario'];
                            ?>
                            <tr>
                                <td><?php echo $n; ?></td>
                                <td><?php echo $id_usuario; ?></td>
                                <td><?php echo $nom_usuario; ?></td>
                                <td><?php echo $ape_usuario; ?></td>
                                <td><?php echo $email_usuario; ?></td>
                                <td><?php echo $usu_usuario; ?></td>
                                <td><?php echo $pass_usuario; ?></td>
                                 <td>
                                    <button name="editar" type="submit" value="<?php echo $id_usuario; ?>" class="btn btn-sm btn-primary">Editar</button>
                                </td>
                                <td>
                                    <button name="eliminar" type="submit" value="<?php echo $id_usuario; ?>"  class="btn btn-sm btn-danger" onclick="return confirm('Esta seguro de eliminar?');">Eliminar</button>
                                </td>
                            </tr>
                            


                        <?php 
                        }
                        ?>

                </tbody>
            </table>
        </div>
    </div>
</div>