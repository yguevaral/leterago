<script>

    function notification() {

        var type = $("#txtType").val();
        var message = $("#txtMessage").val();

        md.showCustomNotification('top', 'right', type, message);
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

<!--<div class="row">
  <div class="col-md-12">
    <h4 class="title">Proceso de entrega</h4>
    <div class="progress progress-line-info">
      <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 33.33%;">
        <span>10% Completo</span>
      </div>
    </div>
  </div>
</div>-->
<div class="row">
    <?php if (isset($entrega)): ?>
        <form method="POST" action="<?= base_url ?>ruta/actualizaTracking">
            <div class="col-md-6 ml-auto mr-auto">
                <div class="card ">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment_turned_in</i>
                        </div>
                        <h4 class="card-title">Siguiente entrega a realizar</h4>
                    </div>
                    &nbsp;<br/>&nbsp;
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">No. Orden</label>
                                    <input type="text" class="form-control" name="txt_orden" value="<?= isset($entrega) ? $entrega->idOrden : ''; ?>" readonly=""/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Total a pagar</label>
                                    <input type="text" class="form-control" name="txt_total" value="<?= isset($entrega) ? $entrega->total : ''; ?>" readonly=""/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Nombre</label>
                                    <input type="text" class="form-control" name="txt_nombre" value="<?= isset($entrega) ? $entrega->NombreCliente : ''; ?>" readonly=""/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Telefono</label>
                                    <input type="text" class="form-control" name="txt_nombre" value="<?= isset($entrega) ? $entrega->telefono : ''; ?>" readonly=""/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Municipio</label>
                                    <input type="text" class="form-control" name="txt_municipio" value="<?= isset($entrega) ? $entrega->Municipio : ''; ?>" readonly=""/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Zona</label>
                                    <input type="text" class="form-control" name="txt_zona" value="<?= isset($entrega) ? $entrega->zona : ''; ?>" readonly=""/>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Dirección</label>
                                    <input type="text" class="form-control" name="txt_direccion" value="<?= isset($entrega) ? $entrega->direccion : ''; ?>" readonly=""/>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Observación</label>
                                    <input type="text" class="form-control" name="txt_observacion" value="<?= isset($entrega) ? $entrega->observacion : ''; ?>" readonly=""/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <select class="selectpicker dropdown" name="opt_tracking" id="opt_tracking" data-style="select-with-transition" title="Estado">
                                    <?php while ($data = $lista_estados->fetch_object()): ?>
                                        <option value="<?= $data->id ?>"> <?= $data->nombreTracking ?> </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-fill btn-info">Guardar</button>
                                </div>
                            </div>                        
                        </div>
                    </div>
                </div>
            </div>
        </form>
    <?php else : ?>
        <h2>No hay entregas pendientes</h2>
    <?php endif; ?>
</div>