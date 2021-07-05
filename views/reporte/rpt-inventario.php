<script>

    function backPage() {

        location.href = "<?= base_url ?>reporte/index";
    }

    function notification() {

        var type = $("#txtType").val();
        var message = $("#txtMessage").val();

        md.showCustomNotification('top', 'right', type, message);
    }

    function rptInventario() {

    }
    $(document).ready(function () {
        $('#datatableInventario').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {extend: 'excelHtml5', footer: true}
            ]
        });
    });

</script>
<!-- Inputs ocultos que almacenan las variables de sesion de notificacion -->
<input type="hidden" name="txtType" id="txtType" value="<?= $_SESSION['noti_tipo'] ?>" />
<input type="hidden" name="txtMessage" id="txtMessage" value="<?= $_SESSION['noti_mensaje'] ?>" />

<?php if (isset($_SESSION['noti_tipo'])): ?>
    <script>notification();</script>
<?php endif; ?>
<?php Utils::deleteSession('noti_tipo'); ?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary card-header-icon">
                <h4 class="card-title"><?= $titulo ?></h4>
            </div>
            <div class="card-body">
                <div class="toolbar">
                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                </div>
                <div class="material-datatables table-responsive">
                    <table id="datatableInventario" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                            <tr>
                                <th>Cod. Producto</th>
                                <th>Producto</th>
                                <?php
                                
                                if( count($arrEmpresa) > 0 ){
                                    
                                    while( $rTMP = each($arrEmpresa) ){
                                        ?>
                                        <th nowrap><?php print $rTMP["value"]["nombre"]?></th>
                                        <?php
                                    }
                                    
                                }
                                
                                ?>
                                <th>Total</th>
                                
                            </tr>
                        </thead>
                        <tbody>        
                            <?php 
                                if( count($arrInventario) > 0 ){
                                    while ($data = each($arrInventario)){
                                        ?>
                                        <tr>
                                            <td><?= $data["value"]["codigoProducto"]; ?></td>
                                            <td><?= $data["value"]["descripcion"]; ?></td>
                                            
                                            <?php 
                                            
                                            $intTotal = 0;
                                            if( count($arrEmpresa) > 0 ){
                                                
                                                reset($arrEmpresa);
                                                while( $rTMP = each($arrEmpresa) ){
                                                    ?>
                                                    <td>
                                                        <?php
                                                        
                                                        if( isset($data["value"]["empresas"][$rTMP["key"]]) ){
                                                            print( $data["value"]["empresas"][$rTMP["key"]]["cantidad"] );
                                                            $intTotal += $data["value"]["empresas"][$rTMP["key"]]["cantidad"]; 
                                                        }
                                                        else{
                                                            print "N/A";
                                                        }
                                                        
                                                        ?>
                                                    
                                                    </td>  
                                                    <?php
                                                }
                                                
                                            }
                                            
                                            ?>
                                            <td><?= $intTotal; ?></td>
                                            
                                        </tr>
                                        <?php     
                                    }    
                                }
                                ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Cod. Producto</th>
                                <th>Producto</th>
                                <?php
                                
                                if( count($arrEmpresa) > 0 ){
                                    
                                    reset($arrEmpresa);
                                    while( $rTMP = each($arrEmpresa) ){
                                        ?>
                                        <th nowrap><?php print $rTMP["value"]["nombre"]?></th>
                                        <?php
                                    }
                                    
                                }
                                
                                ?>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <!-- end content-->
        </div>
        <!--  end card  -->
    </div>
</div>