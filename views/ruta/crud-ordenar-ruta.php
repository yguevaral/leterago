<script>

  function notification() {

    var type = $("#txtType").val();
    var message = $("#txtMessage").val();

    md.showCustomNotification('top', 'right', type, message);
  }

  function ordenEntregas() {
    
    var intCount = 1;
    var ordenamiento = "";
    var id_ordenes = "";

    $("[id*=txt_asignar_]").each(function () {

      if ($("#txt_asignar_" + intCount).val()> 0) {

        ordenamiento += $('#txt_asignar_' + intCount).val() + ",";
        id_ordenes += $('#hdd_asignar_' + intCount).val() + ",";
      }

      intCount++;
    });
    
    ordenamiento = ordenamiento.slice(0, -1);
    //console.log(ordenamiento);

    if (ordenamiento) {

      window.location = "<?= base_url ?>ruta/ordenRutaSave&ordenamiento=" + ordenamiento + "&id_ordenes="+ id_ordenes;
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
    <button class="btn btn-info" onclick="ordenEntregas();">
      <i class="material-icons">get_app</i>
      &nbsp;Ordenar Enregas
    </button>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Ordenamiento de rutas</h4>
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
                <div class="card-header" role="tab" id="heading_<?= $data->idMensajero; ?>">
                  <h5 class="mb-0">
                    <a data-toggle="collapse" href="#collapse_<?= $data->idMensajero; ?>" aria-expanded="false" aria-controls="collapse_<?= $data->idMensajero; ?>" class="collapsed">
                      Mis Entregas
                      <i class="material-icons">keyboard_arrow_down</i>
                    </a>
                  </h5>
                </div>
                <div id="collapse_<?= $data->idMensajero; ?>" class="collapse" role="tabpanel" aria-labelledby="heading_<?= $data->idMensajero; ?>" data-parent="#accordion" style="">
                  <div class="card-body">
                    <table class="table" width="100%">
                      <thead>
                        <tr>
                          <th>Cliente</th>
                          <th>Total</th>
                          <th>Departamento</th>
                          <th>Municipio</th>
                          <th>Dirección</th>
                          <th>Zona</th>
                          <th>Seleccionar</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php while ($data_2 = $detalle[$cont + 1]->fetch_object()): ?>
                          <tr>
                            <td data-toggle="tooltip" data-placement="top" title="Orden # <?= $data_2->id; ?>">
                              <?= $data_2->NombreCliente; ?>
                            </td>
                            <td><?= $data_2->total; ?></td>
                            <td><?= $data_2->Departamento; ?></td>
                            <td><?= $data_2->Municipio; ?></td>
                            <td><?= $data_2->direccion; ?></td>
                            <td><?= $data_2->zona; ?></td>
                            <td>
                              <div class="form-check text-center">
                                <input type="text" class="form-control" name="txt_asignar_" id="txt_asignar_<?= $int_count ?>"/>
                              </div>
                              <input type="hidden" id="hdd_asignar_<?= $int_count ?>" value="<?= $data_2->id; ?>" />
                              <input type="hidden" id="hdd_mensajero_<?= $int_count ?>" value="<?= $data->idMensajero; ?>" />
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