<div class="container-fluid px-4">
    <h1 class="mt-4">Lista de Medios de Pago</h1>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
                Medio de Pago
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre Medio Pago</th>
                        
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Nombre Medio Pago</th>
                        
                    </tr>
                </tfoot>
                <tbody>
                    <?php 
                        $n=0;
                        foreach ($mediopago as $key => $value) 
                        {
                            $n++;
                            $id_medio_pago = $value['id_medio_pago'];
                            $nom_medio_pago = $value['nom_medio_pago'];
                            ?>
                            <tr>
                                <td><?php echo $n; ?></td>
                                <td><?php echo $nom_medio_pago; ?></td>
                                
                    
                            </tr>
                            


                        <?php 
                        }
                        ?>

                </tbody>
            </table>
        </div>
    </div>
</div>