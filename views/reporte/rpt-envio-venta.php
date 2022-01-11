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

<div class="row">
  <div class="col-md-7 ml-auto mr-auto">
    <div class="card">
      <div class="card-header card-header-primary card-header-icon">
        <h4 class="card-title">Cobro de mensajería por orden vendida</h4>
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
                <th>Fecha envío</th>
                <th>Total envío</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Orden</th>
                <th>Fecha envío</th>
                <th>Total envío</th>
              </tr>
            </tfoot>
            <tbody>
              <?php if ($lista_ventas): ?>
                <?php while ($data = $lista_ventas->fetch_object()): ?>
                  <tr>
                    <td><?= $data->id ?> </td>
                    <td><?= $data->fechaEnvio ?> </td>
                    <td><?= $data->envio ?> </td>
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