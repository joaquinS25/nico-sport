<div class="container-fluid px-4">
    <h1 class="mt-4">Lista de Clientes</h1>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
                Clientes
        </div>
        <div class="card-body">
            <form action="cliente_listar.php" method="post">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Celular</th>
                            <th>Nº Tienda</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Celular</th>
                            <th>Nº Tienda</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php 
                            $n=0;
                            foreach ($cliente as $key => $value) 
                            {
                                $n++;
                                $id_cliente = $value['id_cliente'];
                                $nom_cliente = $value['nom_cliente'];
                                $cel_cliente = $value['cel_cliente'];
                                $tienda_cliente = $value['tienda_cliente'];
                                ?>
                                <tr>
                                    <td><?php echo $n; ?></td>
                                    <td><?php echo $id_cliente; ?></td>
                                    <td><?php echo $nom_cliente; ?></td>
                                    <td><?php echo $cel_cliente; ?></td>
                                    <td><?php echo $tienda_cliente; ?></td>
                                    <td>
                                        <button name="editar" type="submit" value="<?php echo $id_cliente; ?>" class="btn btn-sm btn-primary">Editar</button>
                                    </td>
                                    <td>
                                        <button name="eliminar" type="submit" value="<?php echo $id_cliente; ?>"  class="btn btn-sm btn-danger" onclick="return confirm('Esta seguro de eliminar?');">Eliminar</button>
                                    </td>
                                </tr>
                                


                            <?php 
                            }
                            ?>

                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>