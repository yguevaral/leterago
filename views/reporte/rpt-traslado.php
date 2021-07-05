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

</script>
<!-- Inputs ocultos que almacenan las variables de sesion de notificacion -->
<input type="hidden" name="txtType" id="txtType" value="<?= $_SESSION['noti_tipo'] ?>" />
<input type="hidden" name="txtMessage" id="txtMessage" value="<?= $_SESSION['noti_mensaje'] ?>" />

<?php if (isset($_SESSION['noti_tipo'])): ?>
    <script>notification();</script>
<?php endif; ?>
<?php Utils::deleteSession('noti_tipo'); ?>
<?php

function getEstadoTraslado($estado) {
    if ($estado == "T") {
        $estado = "Tránsito";
    } elseif ($estado == "D") {
        $estado = "Rechazo / Devolución";
    } elseif ($estado == "C") {
        $estado = "Completado";
    }

    return $estado;
}
?>

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
                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                            <tr>
                                <th>Traslado</th>
                                <th>Estado</th>
                                <th>Fecha</th>
                                <th>Empresa Sale</th>
                                <th>Empresa Recibe</th>
                                <th>Cod. Producto</th>
                                <th>Descripción</th>
                                <th>Cantidad</th>
                                <th>Precio Costo</th>
                                <th>Total Costo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($lista_traslados):
                                $Cantidad = 0;
                                $totalCosto = 0;
                                ?>
                                <?php while ($data = $lista_traslados->fetch_object()): ?>
                                    <tr>
                                        <td><?= $data->idTraslado; ?></td>
                                        <td><?= getEstadoTraslado($data->estado); ?></td>
                                        <td><?= $data->fechaAlta; ?></td>
                                        <td><?= $data->nombreEmpresaSale; ?></td>
                                        <td><?= $data->nombreEmpresaEntra; ?></td>
                                        <td><?= $data->codigoProducto; ?></td>
                                        <td><?= $data->descripcionInvetario; ?></td>
                                        <td><?= $data->cantidad; ?></td>
                                        <td><?= $data->precioCosto; ?></td>
                                        <td><?= $totalC = $data->precioCosto * $data->cantidad; ?></td>
                                    </tr>
                                    <?php
                                    $Cantidad += $data->cantidad;
                                    $totalCosto += $totalC;
                                    ?>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Traslado</th>
                                <th>Estado</th>
                                <th>Fecha</th>
                                <th>Empresa Sale</th>
                                <th>Empresa Recibe</th>
                                <th>Cod. Producto</th>
                                <th>Descripción</th>
                                <th><?=$Cantidad?></th>
                                <th>Precio Costo</th>
                                <th><?=$totalCosto?></th>
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