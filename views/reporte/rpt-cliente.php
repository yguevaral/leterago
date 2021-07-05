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
                                <th>#</th>
                                <th>Nombre Cliente</th>
                                <th>Cantidad de Compras</th>
                                <th>Telefono</th>
                                <th>Total</th>
                                <th>Productos</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($info_cliente as $arrCliente): ?>
                                <tr>
                                    <td style="vertical-align: top;"><?= $arrCliente["cliente"][0] ?></td>
                                    <td style="vertical-align: top;"><?= $arrCliente["cliente"][1] ?></td>
                                    <td style="vertical-align: top;"><?= $arrCliente["cliente"][2] ?></td>
                                    <td style="vertical-align: top;"><?= $arrCliente["cliente"][3] ?></td>
                                    <td style="vertical-align: top;"><?= number_format($arrCliente["cliente"][4], 2, ".", ",") ?></td>
                                    <td >

                                        <div style="height: 150px; overflow: auto;">

                                            <?php
                                            $strProductos = "";
                                            foreach ($arrCliente["ventas"] as $arrCompras ) {

                                                $strProductos .= ( $strProductos == "" ? "" : "<br>" ) . "{$arrCompras["codProducto"]} - {$arrCompras["descripcion"]}";
                                            }

                                            print $strProductos;
                                            ?>
                                        </div>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Nombre Cliente</th>
                                <th>Cantidad de Compras</th>
                                <th>Telefono</th>
                                <th>Total</th>
                                <th>Productos</th>
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