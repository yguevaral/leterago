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
        $('#datatableBajas').DataTable({
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
                <div class="material-datatables">
                    <table id="datatableBajas" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Usuario</th>
                                <th>Cod. Producto</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <?php if (utils::getIssetAcceso("Reportes_leer_foot", "LEER")) : ?>
                                    <th>Precio Costo</th>
                                    <th>Total Costo</th>
                                <?php endif; ?>
                                <th>Precio Venta</th>
                                <th>Total Venta</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($lista_bajas): ?>
                                <?php
                                $totalC = 0;
                                $totalV = 0;
                                $cantidad = 0;
                                while ($data = $lista_bajas->fetch_object()):
                                    $totalCosto = $data->precioCosto * $data->cantidad;
                                    ?>
                                    <tr>
                                        <td><?= $data->id; ?></td>
                                        <td><?= $data->nombre; ?></td>
                                        <td><?= $data->idProducto; ?></td>
                                        <td><?= $data->descripcion; ?></td>
                                        <td><?= $data->cantidad; ?></td>
                                        <?php if (utils::getIssetAcceso("Reportes_leer_foot", "LEER")) : ?>
                                            <td><?= $data->precioCosto; ?></td>
                                            <td><?= $totalCosto; ?></td>
                                        <?php endif; ?>
                                        <td><?= $data->precio; ?></td>
                                        <td><?= $data->subtotal; ?></td>
                                        <td><?= utils::DB2Fecha($data->fechaMovimiento); ?></td>
                                        <?php
                                        $totalC += $totalCosto;
                                        $totalV += $data->subtotal;
                                        $cantidad += $data->cantidad;
                                        ?>
                                    </tr>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Usuario</th>
                                <th>Cod. Producto</th>
                                <th>Producto</th>
                                <th><?= $cantidad ?></th>
                                <?php if (utils::getIssetAcceso("Reportes_leer_foot", "LEER")) : ?>
                                    <th>Precio Costo</th>
                                    <th><?= $totalC ?></th>
                                <?php endif; ?>
                                <th>Precio Venta</th>
                                <th><?= $totalV ?></th>
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