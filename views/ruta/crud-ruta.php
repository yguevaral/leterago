<script>
  function getDashboard() {

    window.location = "<?= base_url ?>home/index";
  }

  function notification() {

    var type = $("#txtType").val();
    var message = $("#txtMessage").val();

    md.showCustomNotification('top', 'right', type, message);
  }

  function getMunicipio() {

    var opt_departamento = document.getElementById("opt_departamento").value;

//        alert(opt_departamento);

    if (opt_departamento) {
      //alert("Algun texto esta lleno");
      $.ajax({
        url: "<?= base_url ?>ruta/&getMunicipio=true&opt_departamento=" + opt_departamento,
        success: function (result) {

          $("#divMunicipios").html(result);
        }
      });
    }
  }

  function addLocation() {

//    alert("Add Location Works");

    var id_ruta = $("#txt_idRuta").val();
    var departamento = $("#opt_departamento").val();
    var municipcio = $("#opt_municipio").val();
    var zona = $("#txt_zona").val();

//    console.log(id_ruta);
//    console.log(departamento);
//    console.log(municipcio);
//    console.log(zona);

    // Arma el Formulario de datos
    var formData = new FormData();
    formData.append("id_ruta", id_ruta);
    formData.append("opt_departamento", departamento);
    formData.append("opt_municipio", municipcio);
    formData.append("txt_zona", zona);

    if (id_ruta || departamento || municipcio || zona) {
      //alert("Algun texto esta lleno");
      $.ajax({
        url: "<?= base_url ?>ruta/&getAddArray=true",
        type: "POST",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {

          $("#listaRutaNueva").html(result);

        }
      });

      $("#txt_zona").val('');

    } else {
      alert("Algun valor no viene lleno");
    }
  }

  function removeLocation(indice) {

    $.ajax({
      url: "<?= base_url ?>ruta/&getRemoveItem&indice=" + indice,
      success: function (result) {

        $("#listaRutaNueva").html(result);

      }
    });
  }

  function saveRuta() {

    var costo = $("#txt_envio").val();
    var idRuta = $("#txt_idRuta").val();
    
    window.location = "<?= base_url ?>ruta/saveRuta&costo="+costo+"&idRuta="+idRuta;
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
  <div class="col-md-6">
    <div class="card ">
      <div class="card-header card-header-info card-header-icon">
        <div class="card-icon">
          <i class="material-icons">room</i>
        </div>
        <h4 class="card-title">Ingreso de ruta no. <?= $siguiente ?> </h4>
        <input type="hidden" name="txt_idRuta" id="txt_idRuta" value="<?= $siguiente ?>" />
      </div>
      <div class="card-body ">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <select class="selectpicker" name="opt_departamento" data-live-search="true" id="opt_departamento" onchange="getMunicipio();" data-style="select-with-transition" title="Departamento">
                <?php while ($data = $lista_departamentos->fetch_object()): ?>
                  <option value="<?= $data->codIso ?>" <?= isset($_cliente) && $data->codIso == $_cliente->idDepartamento ? 'selected' : ''; ?>> <?= $data->nombre ?> </option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>
          <div class="col-md-5" id="divMunicipios">
            <div class="form-group">                              
              <select class="selectpicker" name="opt_municipio" data-live-search="true" data-style="select-with-transition" title="Municipio">
                <option> Seleccionar </option>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <input type="text" class="form-control" name="txt_zona" id="txt_zona" placeholder="Zona"/>
            </div>
          </div>
          <div class="col-md-5 text-right">
            <div class="form-group">
              <button type="sumbit" class="btn btn-info btn-round btn-fab" onclick="addLocation()">
                <i class="material-icons">add</i>
              </button>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-11">
            <div class="table-responsive" id="listaRutaNueva">
              <table class="table" width="100%">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Departamento</th>
                    <th>Municipio</th>
                    <th>Zona</th>
                    <th>Acción</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (isset($_SESSION['detalle_ruta'])): ?>
                    <?php foreach ($_SESSION['detalle_ruta'] as $clave => $valor): ?>
                      <tr>
                        <td><?= $no = $clave + 1; ?></td>
                        <td><?= utils::getDepartamentoById($valor['codIsoDepartamento']); ?></td>
                        <td class="text-center"><?= utils::getMunicipioById($valor['codIsoDepartamento'], $valor['codIsoMunicipio']); ?></td>
                        <td class="text-center"><?= $valor['zona']; ?></td>
                        <td class="text-center">
                          <a href="javascript:void(0)" onclick="removeLocation(<?= $clave ?>);">Eliminar</a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
                <div class="col-md-5">
                  <div class="form-group">
                    <input type="text" class="form-control" name="txt_envio" id="txt_envio" placeholder="Costo"/>
                    <button class="btn btn-info btn-sm" onclick="saveRuta();">Guardar</button>
                  </div>
                </div>

              <?php else : ?>
                <tr>

                </tr>
                </tbody>
                </table>
              <?php endif; ?>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Rutas disponibles</h4>
      </div>
      <div class="card-body">
        <div id="accordion" role="tablist">
          <?php if (isset($encabezado)): ?>
            <?php $no = 0; ?>
            <?php while ($data = $encabezado->fetch_object()): ?>
              <div class="card-collapse">
                <div class="card-header" role="tab" id="heading_<?= $data->idRuta; ?>">
                  <h5 class="mb-0">
                    <a data-toggle="collapse" href="#collapse_<?= $data->idRuta; ?>" aria-expanded="false" aria-controls="collapse_<?= $data->idRuta; ?>" class="collapsed">
                      Ruta # <?= $data->idRuta; ?> costo: <?= $data->tarifa; ?>
                      <i class="material-icons">keyboard_arrow_down</i>
                    </a>
                  </h5>
                </div>
                <div id="collapse_<?= $data->idRuta; ?>" class="collapse" role="tabpanel" aria-labelledby="heading_<?= $data->idRuta; ?>" data-parent="#accordion" style="">
                  <div class="card-body">
                    <table class="table" width="100%">
                      <thead>
                        <tr>
                          <th>Departamento</th>
                          <th>Municipio</th>
                          <th>Zona</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php while ($data_2 = $detalle[$data->idRuta - 1]->fetch_object()): ?>
                          <tr>
                            <td><?= $data_2->Departamento; ?></td>
                            <td><?= $data_2->Municipio; ?></td>
                            <td><?= $data_2->zona; ?></td>
                          </tr>
                        <?php endwhile ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
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

<!--<button class="btn btn-info btn-round btn-fab" onclick="getDashboard();">
    <i class="material-icons">keyboard_arrow_left</i>
</button>-->