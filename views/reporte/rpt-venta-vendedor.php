    <script>
  function verDetalle(id_orden) {

    var id_orden = id_orden;

    $.ajax({
      url: "<?= base_url ?>reporte/&getDetalleVenta&id_orden=" + id_orden,
      success: function (result) {

        $("#modalInfoDetalle").html(result);
      }
    });

    $(".bs-example-modal-lg").modal();
  }
</script>
<div class="row">
  <div class="col-md-10 ml-auto mr-auto">
    <div class="card">
      <div class="card-header card-header-primary card-header-icon">
        <h4 class="card-title">Reporte de vendedores</h4>
      </div>
      <div class="card-body">
        <div class="toolbar">
          <!-- Here you can write extra buttons/actions for the toolbar -->
        </div>
        <div class="material-datatables">
          <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
            <thead>
              <tr>
                <th>Orden</th>
                <th>Cliente</th>
                <th>Tipo Pago</th>
                <th>Comprobante</th>
                <th>Subtotal</th>
                <th>Fecha Venta</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($data = $lista_ventas->fetch_object()): ?>
                <tr>
                  <td><a href="javascript:void(0)" onclick="verDetalle(<?= $data->id; ?>)"><?= $data->id; ?></a></td>
                  <td><?= $data->nombre; ?></td>
                  <td><?= $data->nombreTipoPago; ?></td>
                  <td><?= $data->comprobante; ?></td>
                  <td><?= $data->subtotal; ?></td>
                  <td><?= utils::DB2Fecha($data->fechaOrden); ?></td>
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
<!-- sample modal content -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Detalle de compra</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" id="modalInfoDetalle">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">cerrar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->