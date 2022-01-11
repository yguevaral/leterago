<script>
    setTimeout(subtotal, 100);
    function subtotal() {
        var subtotal = [];

        $("td.sumSubTotal").each(function () {
            subtotal.push(parseFloat($(this).text()));
        });

        var sumSubtotal = subtotal.reduce(function (a, b) {
            return a + b;
        }, 0);
        sumSubtotal = sumSubtotal.toFixed(2);

        $('#sumaTotal').html(sumSubtotal);
        $('#txt_subtotal').val(sumSubtotal);
    }
    
    function modalProducto() {
        $('#modalProducto').modal('show');
    }

    function addProducto() {

        var producto = $("#opt_producto").val();
        var cantidad = $("#txt_cantidad").val();

        // Arma el Formulario de datos
        var formData = new FormData();
        formData.append("opt_producto", producto);
        formData.append("txt_cantidad", cantidad);

        if (producto || cantidad) {
            //alert("Algun texto esta lleno");
            $.ajax({
                url: "<?= base_url ?>venta/&getAddArray=true&key=1",
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {

                    $("#listaProductos").html(result);

                }
            });

            $("#txt_cantidad").val('');
            $("#opt_producto").val('').selectpicker('refresh');

        } else {
            console.log("Algun valor no viene lleno");
        }
    }
    
    function eliminarElemento(indice) {

        $.ajax({
            url: "<?= base_url ?>venta/&getAddArray=true&key=3&indice=" + indice,
            success: function (result) {

                $("#listaProductos").html(result);

            }
        });
    }
    
    function guardarBajas(){
        
        window.location = "<?= base_url ?>inventario/procesaBaja";
    }
    
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
<div class="row">
    <div class="col-md-8 ml-auto mr-auto">
        <div class="card ">
            <div class="card-header card-header-info card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">menu_book</i>
                </div>
                <h4 class="card-title">Marcar productos de baja</h4>
            </div>
            &nbsp;<br/>&nbsp;
            <div class="card-body ">
                <div class="row justify-content-center">
                    <a href="javascript:void(0)" class="btn btn-success btn-link" onclick="modalProducto();">Agregar productos</a>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive" id="listaProductos">
                            <table class="table" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Codigo</th>
                                        <th>Cantidad</th>
                                        <th>Subtotal</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($_SESSION['orden_detalle'])): ?>
                                        <?php foreach ($_SESSION['orden_detalle'] as $clave => $valor): ?>
                                            <tr>
                                                <td><?= $no = $clave + 1; ?></td>
                                                <td><?= $valor['codigoProducto']; ?></td>
                                                <td><?= $valor['cantidad']; ?></td>
                                                <td class="sumSubTotal text-center"><?= $valor['subtotal']; ?></td>
                                                <td>
                                                    <a href="javascript:void(0)" onclick="eliminarElemento(<?= $clave ?>);">Eliminar</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>

                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 text-right">
                        <button type="submit" class="btn btn-fill btn-info" onclick="guardarBajas();">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal que agrega producto -->
<div class="modal fade" id="modalProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 50%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Agregar producto
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="material-icons">clear</i>
                </button>
            </div>                   
            <div class="modal-body">
                <br/>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <select class="selectpicker" data-style="select-with-transition" data-show-subtext="true" data-live-search="true" name="opt_producto" id="opt_producto" title="Seleccione Producto">
                                <?php while ($data = $lista_productos->fetch_object()): ?>
                                    <option value="<?= $data->codigoProducto ?>"> <?= $data->codigoProducto . " - " . $data->descripcion . " " . $data->nombrePrendaArticulo . " " . $data->nombreTallaTamano . " " . $data->nombreColor . " <strong> - STOCK: " . $data->cantidad . "</strong>"; ?> </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="bmd-label-floating">Cantidad</label>
                            <input type="number" class="form-control" name="txt_cantidad" id="txt_cantidad" step="any" />
                        </div>
                    </div>
                    <div class="col-md-2" align="right">
                        <div class="form-group">
                            <button type="sumbit" class="btn btn-info btn-round btn-fab" onclick="addProducto();">
                                <i class="material-icons">add</i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                &nbsp;
            </div>
        </div>
    </div>
</div>
<!-- Fin del Modal -->