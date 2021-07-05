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

    function fntSetGuiaOrden(intOrden) {

        var formData = new FormData();
        formData.append("orden", intOrden);
        formData.append("guia", $("#txtGuia_" + intOrden).val());

        $.ajax({
            url: "<?= base_url ?>reporte/&setGuiaOrden=true",
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (result) {
                md.showCustomNotification('top', 'right', result["type"], result["mensaje"]);
            },
            error: function (result) {
                md.showCustomNotification('top', 'right', "error", "Error");
            }
        });


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
                <h4 class="card-title"><?php print "Despacho de {$fecha_inicial} al {$fecha_final}" ?></h4>
            </div>
            <div class="card-body">
                <div class="toolbar">
                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                </div>
                <div class="material-datatables">
                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                            <tr>
                                <th>Orden</th>
                                <th>Cliente</th>
                                <th>Comprobante</th>
                                <th>Observación</th>
                                <th>Factura</th>
                                <th>Dirección</th>
                                <th>Departamento</th>
                                <th>Municipio</th>
                                <th>Telefono</th>
                                <th>Productos</th>
                                <th>Subtotal</th>
                                <th>Total</th>
                                <th>Guía</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Orden</th>
                                <th>Cliente</th>
                                <th>Comprobante</th>
                                <th>Observación</th>
                                <th>Factura</th>
                                <th>Dirección</th>
                                <th>Departamento</th>
                                <th>Municipio</th>
                                <th>Telefono</th>
                                <th>Productos</th>
                                <th>Subtotal</th>
                                <th>Total</th>
                                <th>Guía</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php if ($lista_despacho): ?>
                                <?php while ($data = each($lista_despacho)): ?>
                                    <tr>
                                        <td><?= $data["value"]["id"]; ?></td>
                                        <td><?= $data["value"]["nombre"]; ?></td>
                                        <td><?= $data["value"]["comprobante"]; ?></td>
                                        <td><?= $data["value"]["observacion"]; ?></td>
                                        <td><?= $data["value"]["iva"] > 0 ? "Si" : "No"; ?></td>
                                        <td><?= $data["value"]["direccion"] . " Zona " . $data["value"]["zona"] . " / " . $data["value"]["observacionOrden"]; ?></td>
                                        <td><?= $data["value"]["departamento"]; ?></td>
                                        <td><?= $data["value"]["municipio"]; ?></td>
                                        <td><?= $data["value"]["telefono"]; ?></td>
                                        <td>
                                            <?php
                                            $strInv = "";
                                            while ($arrTMP = each($data["value"]["inventario"])) {

                                                $strInv .= ( $strInv == "" ? "" : "<br>" ) . "{$arrTMP["value"]["codigoProducto"]} - {$arrTMP["value"]["descripcion"]}: *" . number_format($arrTMP["value"]["cantidad"], 0) . "*";
                                            }

                                            print $strInv;
                                            ?>
                                        </td>
                                        <td><?= $data["value"]["subtotal"]; ?></td>
                                        <?php if ($data["value"]["total"] == null) { ?>
                                            <td><?= $data["value"]["subtotal"]; ?></td>
                                        <?php } else { ?>
                                            <td><?= $data["value"]["total"]; ?></td>
                                        <?php } ?>
                                        <td>
                                            <div class="form-group bmd-form-group input-group">
                                                <input type="text" class="form-control" placeholder="Guía" id="txtGuia_<?php print $data["value"]["id"] ?>" value="<?= $data["value"]["numeroGuia"]; ?>">
                                                <div class="input-group-append">

                                                    <button class="btn btn-just-icon btn-link btn-twitter" onclick="fntSetGuiaOrden('<?php print $data["value"]["id"] ?>');">
                                                        <i class="material-icons">check</i>
                                                    </button>

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- end content-->
        </div>
        <!--  end card  -->
    </div>
</div>