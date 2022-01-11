<script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>

<script>

    function backPage() {

        location.href = "<?= base_url ?>venta/index";
    }

    function notification() {

        var type = $("#txtType").val();
        var message = $("#txtMessage").val();

        md.showCustomNotification('top', 'right', type, message);
    }

    function rptVentas() {

    }
    $(document).ready(function () {
        
        fntInitDatable();
    });
    
    function fntInitDatable(){
        $('#datatableVenta').DataTable({
            dom: 'Bfrtip',
            "button-export": false,
            buttons: [
                {extend: 'excelHtml5', footer: true}
            ]
        });
        
        $(".buttons-excel").hide();
    }
    
    function fntExportExcel(){
        $('#datatableVenta').DataTable().destroy();
        var table = $("#datatableVenta");
        console.log(table);
        if(table && table.length){
                var preserveColors = (table.hasClass('table2excel_with_colors') ? true : false);
                let current_datetime = new Date()
                let formatted_date = current_datetime.getFullYear() + "-" + (current_datetime.getMonth() + 1) + "-" + current_datetime.getDate() + " " + current_datetime.getHours() + ":" + current_datetime.getMinutes() + ":" + current_datetime.getSeconds() 
                
                $(table).table2excel({
                        exclude: ".noExl",
                        name: "<?php print utils::getEmpresaById($_SESSION['identity-imsalesys']->idEmpresa)?>-Ingresos-" + formatted_date,
                        filename: "<?php print utils::getEmpresaById($_SESSION['identity-imsalesys']->idEmpresa)?>-Ingresos-" + formatted_date + ".xls",
                        fileext: ".xls",
                        exclude_img: true,
                        exclude_links: true,
                        exclude_inputs: true,
                        preserveColors: preserveColors
                });
        }
        fntInitDatable();
    }

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
                    <button class="btn btn-info" onclick="fntExportExcel();">Excel</button>
                    <table id="datatableVenta" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Vendedor</th>
                                <th>Cod. Producto</th>
                                <th>Categoría</th>
                                <th>Descripción</th>
                                <th>Observación</th>
                                <th>Cantidad</th>
                                <?php if (utils::getIssetAcceso("Reportes_leer_foot", "LEER")) : ?>                                
                                    <th>Costo</th>
                                    <th>Total Costo</th>
                                <?php endif; ?>
                                <th>Precio Venta</th>
                                <th>Total Venta</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($lista_ventas): ?>
                                <?php
                                $Cantidad = 0;
                                $totalC = 0;
                                $totalV = 0;
                                while ($data = $lista_ventas->fetch_object()){
                                    
                                    $TotalCosto = $data->precioCosto * $data->cantidad;
                                    $totalVenta = $data->precioVenta * $data->cantidad;
                                    
                                    ?>
                                    <tr>
                                        <td><?= $data->id; ?></td>
                                        <td><?= $data->nombreUsuario; ?></td>
                                        <td><?= $data->codigoProducto; ?></td>
                                        <td><?= $data->nombreCategoria; ?></td>
                                        <td><?= $data->descripcion; ?></td>
                                        <td><?= $data->observacion; ?></td>
                                        <td><?= $data->cantidad; ?></td>
                                            <?php if (utils::getIssetAcceso("Reportes_leer_foot", "LEER")) : ?>
                                            <td><?= isset($data->precioCosto) ? $data->precioCosto : 'N/A'; ?></td>
                                            <td><?= $TotalCosto; ?></td>    
                                        <?php endif; ?>
                                        <td><?= $data->precioVenta; ?></td>
                                        <td><?= $totalVenta; ?></td>
                                        <td><?= utils::DB2Fecha($data->fechaMovimiento); ?></td>
                                        <?php
                                        $totalC += $TotalCosto;
                                        $totalV += $totalVenta;
                                        $Cantidad += $data->cantidad;
                                        ?>
                                    </tr>
                                    <?php                                 
                                } 
                                
                                ?>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Vendedor</th>
                                <th>Cod. Producto</th>
                                <th>Categoría</th>
                                <th>Descripción</th>
                                <th>Observación</th>
                                <th><?=$Cantidad?></th>
                                <?php if (utils::getIssetAcceso("Reportes_leer_foot", "LEER")) : ?>
                                <th>Costo</th>
                                <th><?=$totalC;?></th>
                                <?php endif; ?>
                                <th>Precio Venta</th>
                                <th><?=$totalV;?></th>
                                <th>Fecha</th>
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