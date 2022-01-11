<?php

class viewsRuta {

  public function drawMunicipio($array_municipios) {
    ?>
    <div class="form-group">
      <select class="selectpicker dropdown" data-live-search="true" data-style="select-with-transition" title="Municipio" name="opt_municipio" id="opt_municipio">
        <option disabled>Seleccione una opcion...</option>
        <?php while ($data = $array_municipios->fetch_object()): ?>
          <option value="<?= $data->codMunicipio ?>"> <?= $data->nombre ?> </option>
        <?php endwhile; ?>
      </select>
    </div>
    <script>

      $("#opt_municipio").selectpicker();

    </script>
    <?php
  }

  public function drawArrayRuta($array_ruta) {
    ?>
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
        <?php if (isset($array_ruta)): ?>
          <?php foreach ($array_ruta as $clave => $valor): ?>
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
        <?php else : ?>
          <tr>

          </tr>
        <?php endif; ?>
      </tbody>
    </table>
    <div class="col-md-5">
      <div class="form-group">
        <input type="text" class="form-control" name="txt_envio" id="txt_envio" placeholder="Costo"/>
        <button class="btn btn-info btn-sm" onclick="saveRuta();">Guardar</button>
      </div>
    </div>
    <?php
  }

}
