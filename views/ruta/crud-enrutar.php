<script>
    function getGenerar() {

        window.location = "<?= base_url ?>ruta/generaEnrutamiento"
    }

    function notification() {

        var type = $("#txtType").val();
        var message = $("#txtMessage").val();

        md.showCustomNotification('top', 'right', type, message);
    }

    function modalMensajero() {
        $('#modalMensajero').modal('show');
    }

    function asignaMensajero() {

        var intCount = 1;
        var id_ordenes = "";
        var id_mensajero = $("#opt_mensajero").val();
        var sin_envio = "";

        $("[id*=ckb_asignar_]").each(function () {

            if ($("#ckb_asignar_" + intCount).prop('checked')) {

                id_ordenes += $('#hdd_asignar_' + intCount).val() +"_"+ $('#txtOrdenEntrega_' + intCount).val() + ",";
            }

            intCount++;
        });

        var intCount = 1;
        $("[id*=ckb_mensajeria_]").each(function () {

            if ($("#ckb_mensajeria_" + intCount).prop('checked')) {

                sin_envio += $('#hdd_mensajeria_' + intCount).val() + ",";
            }

            intCount++;
        });

        id_ordenes = id_ordenes.slice(0, -1)
        sin_envio = sin_envio.slice(0, -1)
        //console.log(id_ordenes);
        //console.log(sin_envio);
        //return false;
        if (id_ordenes) {

            window.location = "<?= base_url ?>ruta/asignarMensajero&id_ordenes=" + id_ordenes + "&sin_envio=" + sin_envio + "&id_mensajero=" + id_mensajero;
        }
    }
</script>
<!-- Inputs ocultos que almacenan las variables de sesion de notificacion -->
<input type="hidden" name="txtType" id="txtType" value="<?= $_SESSION['noti_tipo'] ?>" />
<input type="hidden" name="txtMessage" id="txtMessage" value="<?= $_SESSION['noti_mensaje'] ?>" />

<?php if (isset($_SESSION['noti_tipo'])): ?>
    <script>notification();</script>
<?php endif; ?>
<?php Utils::deleteSession('noti_tipo'); ?>
<?php Utils::deleteSession('noti_mensaje'); ?>  

<div class="row">
    <div class="col-md-2">
        <button class="btn btn-info" onclick="getGenerar();">
            <i class="material-icons">get_app</i>
            &nbsp;Generar Rutas
        </button>
    </div>
    <?php if (isset($encabezado)): ?>
        <div class="col-md-10">
            <button class="btn" onclick="modalMensajero();">
                <i class="material-icons">two_wheeler</i>
                &nbsp;Asignar Mensajero
            </button>
        </div>
    <?php endif; ?>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Asignación de rutas</h4>
            </div>
            <div class="card-body">
                <div id="accordion" role="tablist">
                    <?php if (isset($encabezado)): ?>
                        <?php
                        $no = 0;
                        $cont = -1;
                        $int_count = 1;
                        ?>
                        <?php while ($data = $encabezado->fetch_object()): ?>
                            <div class="card-collapse">
                                <div class="card-header" role="tab" id="heading_<?= $data->idRuta; ?>">
                                    <h5 class="mb-0">
                                        <a data-toggle="collapse" href="#collapse_<?= $data->idRuta; ?>" aria-expanded="false" aria-controls="collapse_<?= $data->idRuta; ?>" class="collapsed">
                                            Ruta #<?= $data->idRuta; ?>
                                            <i class="material-icons">keyboard_arrow_down</i>
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapse_<?= $data->idRuta; ?>" class="collapse" role="tabpanel" aria-labelledby="heading_<?= $data->idRuta; ?>" data-parent="#accordion" style="">
                                    <div class="card-body">
                                        <table class="table" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Cliente</th>
                                                    <th>Total</th>
                                                    <th>Direccion</th>
                                                    <th class="text-center">Asignar</th>
                                                    <th>Sin Envío</th>
                                                    <th style="width: 10%;">Orden Entrega</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($data_2 = $detalle[$cont + 1]->fetch_object()): ?>
                                                    <tr>
                                                        <td data-toggle="tooltip" data-placement="top" title="Orden # <?= $data_2->id; ?>">
                                                            <?= $data_2->NombreCliente; ?>
                                                        </td>
                                                        <td><?= $data_2->total; ?></td>
                                                        <td><?= $data_2->Departamento. " / ".$data_2->Municipio." / Zona ".$data_2->zona." <br>".$data_2->direccion;; ?></td>
                                                        <td class="text-center">
                                                            <div class="form-check text-center">
                                                                <label class="form-check-label">
                                                                    <input class="form-check-input" type="checkbox" id="ckb_asignar_<?= $int_count ?>" value="">
                                                                    <span class="form-check-sign">
                                                                        <span class="check"></span>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                            <input type="hidden" id="hdd_asignar_<?= $int_count ?>" value="<?= $data_2->id; ?>" />
                                                        </td>
                                                        <td>
                                                            <div class="form-check text-center">
                                                                <label class="form-check-label">
                                                                    <input class="form-check-input" type="checkbox" id="ckb_mensajeria_<?= $int_count ?>" value="">
                                                                    <span class="form-check-sign">
                                                                        <span class="check"></span>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                            <input type="hidden" id="hdd_mensajeria_<?= $int_count ?>" value="<?= $data_2->id; ?>" />
                                                        
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control text-center" name="txtOrdenEntrega_<?= $int_count ?>" id="txtOrdenEntrega_<?= $int_count ?>"  >
                                                        </td>
                                                    </tr>
                                                    <?= $int_count++; ?>
                                                <?php endwhile ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php $cont = $cont + 1; ?>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="card-collapse">
                            <div class="card-header" role="tab" id="heading_1">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" href="#collapse_1" aria-expanded="false" aria-controls="collapse_1" class="collapsed">
                                        No hay rutas disponibles
                                        <i class="material-icons">keyboard_arrow_down</i>
                                    </a>
                                </h5>
                            </div>
                            <div id="collapse_1" class="collapse" role="tabpanel" aria-labelledby="heading_1" data-parent="#accordion" style="">
                                <div class="card-body">

                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Mensajero -->
<div class="modal fade" id="modalMensajero" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 30%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Asignar a mensajero
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="material-icons">clear</i>
                </button>
            </div>                   
            <div class="modal-body">
                <br/>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <select class="selectpicker" name="opt_mensajero" data-live-search="true" id="opt_mensajero" data-style="select-with-transition" title="Seleccione">
                                <?php while ($data = $lista_mensajeros->fetch_object()): ?>
                                    <option value="<?= $data->id ?>"> <?= $data->nombre ?> </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12" align="right">
                        <button class="btn btn-info" onclick="asignaMensajero();">
                            <i class="material-icons">add</i>
                            &nbsp;Asingar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Fin del Modal -->  