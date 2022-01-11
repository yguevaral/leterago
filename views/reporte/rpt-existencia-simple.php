<div class="row">
  <div class="col-md-10 ml-auto mr-auto">
    <div class="card">
      <div class="card-header card-header-primary card-header-icon">
        <h4 class="card-title">Información almacenada</h4>
      </div>
      <div class="card-body">
        <div class="toolbar">
          <!-- Here you can write extra buttons/actions for the toolbar -->
        </div>
        <div class="material-datatables">
          <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
            <thead>
              <tr>
                <th>Codigo</th>
                <th>Categoria</th>
                <th>Descripcion</th>
                <th>Cantidad</th>
                <th>Precio Costo</th>
                <th>Precio Venta</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($data = $lista_productos->fetch_object()): ?>
                <tr>
                  <td><?= $data->codigoProducto; ?></td>
                  <td><?= $data->nombreCategoria; ?></td>
                  <td><?= $data->descripcion; ?></td>
                  <td><?= $data->cantidad; ?></td>
                  <td><?= $data->precioCosto; ?></td>
                  <td><?= $data->precioVenta; ?></td>
                  <td><?= utils::getEstadoAIById($data->estado); ?></td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </div>
      <!-- end content-->
    </div>
    <!--  end card  -->
  </div>
  <!-- end col-md-12 -->
</div>