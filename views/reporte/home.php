<script>

    $(document).ready(function () {
        // initialise Datetimepicker
        md.initFormExtendedDatetimepickers();
    });

    function backPage() {

        location.href = "<?= base_url ?>venta/index";
    }

    function notification() {

        var type = $("#txtType").val();
        var message = $("#txtMessage").val();

        md.showCustomNotification('top', 'right', type, message);
    }

    function modalFechas(id) {

        $("#divFiltroTraslado").hide();
        if (id == 8) {
            $("#divFiltroTraslado").show();
        }

        $('#id_reporte').val(id);
        $('#modalFechas').modal('show');

        // location.href = "<?= base_url ?>reporte/ventas";
    }

</script>
<!-- Inputs ocultos que almacenan las variables de sesion de notificacion -->
<input type="hidden" name="txtType" id="txtType" value="<?= $_SESSION['noti_tipo'] ?>" />
<input type="hidden" name="txtMessage" id="txtMessage" value="<?= $_SESSION['noti_mensaje'] ?>" />

<?php if (isset($_SESSION['noti_tipo'])): ?>
    <script>notification();</script>
<?php endif; ?>
<?php Utils::deleteSession('noti_tipo'); ?>

<?php $id_rol = utils::whatRol(); ?>

<div class="row">
    <?php if (utils::getIssetAcceso("REPORTES_REPORTE_TRANSITO")): ?>
        <!--//if ($id_rol == 1 || $id_rol == 2 || $id_rol == 3 || $id_rol == 6)-->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <a href="javascript:void(0)" onclick="modalFechas(7);">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">local_shipping</i>
                        </div>
                        <h4 class="card-title">Transito</h4>
                    </div>
                </a>
                <div class="card-footer">
                    <div class="stats">
                        Filtrado por fecha
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if (utils::getIssetAcceso("REPORTES_REPORTE_VENTAS")): ?>
        <!--if ($id_rol == 1 || $id_rol == 2 || $id_rol == 3 || $id_rol == 6)-->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <a href="javascript:void(0)" onclick="modalFechas(1);">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">shopping_cart</i>
                        </div>
                        <h4 class="card-title">Ventas</h4>
                    </div>
                </a>
                <div class="card-footer">
                    <div class="stats">
                        Filtrado por fecha
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if (utils::getIssetAcceso("REPORTES_REPORTES_TRASLADOS")): ?>
        <!--if ($id_rol == 1 || $id_rol == 2 || $id_rol == 3 || $id_rol == 6)-->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <a href="javascript:void(0)" onclick="modalFechas(8);">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">swap_horiz</i>
                        </div>
                        <h4 class="card-title">Traslados</h4>
                    </div>
                </a>
                <div class="card-footer">
                    <div class="stats">
                        Filtrado por fecha
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if (utils::getIssetAcceso("REPORTES_REPORTES_INGRESOS")): ?> 
        <!--if ($id_rol == 1 || $id_rol == 2 || $id_rol == 3 || $id_rol == 6)-->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <a href="javascript:void(0)" onclick="modalFechas(2);">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">article</i>
                        </div>
                        <h4 class="card-title">Ingresos</h4>
                    </div>
                </a>
                <div class="card-footer">
                    <div class="stats">
                        Filtrado por fecha
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if (utils::getIssetAcceso("REPORTES_REPORTES_BAJAS")): ?> 
        <!--if ($id_rol == 1 || $id_rol == 2 || $id_rol == 3 || $id_rol == 6)-->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <a href="javascript:void(0)" onclick="modalFechas(5);">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">production_quantity_limits</i>
                        </div>
                        <h4 class="card-title">Bajas</h4>
                    </div>
                </a>
                <div class="card-footer">
                    <div class="stats">
                        Filtrado por fecha
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if (utils::getIssetAcceso("REPORTES_REPORTES_DEVOLUCIONES")): ?>
        <!--if ($id_rol == 1 || $id_rol == 2 || $id_rol == 3 || $id_rol == 6)-->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <a href="javascript:void(0)" onclick="modalFechas(6);">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">article</i>
                        </div>
                        <h4 class="card-title">Devoluciones</h4>
                    </div>
                </a>
                <div class="card-footer">
                    <div class="stats">
                        Filtrado por fecha
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if (utils::getIssetAcceso("REPORTES_REPORTES_ENVIOS")): ?>
        <!--// if ($id_rol == 1 || $id_rol == 2 || $id_rol == 3 || $id_rol == 6)--> 
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <a href="javascript:void(0)" onclick="modalFechas(4);">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">moped</i>
                        </div>
                        <h4 class="card-title">Envíos</h4>
                    </div>
                </a>
                <div class="card-footer">
                    <div class="stats">
                        Filtrado por fecha
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if (utils::getIssetAcceso("REPORTES_REPORTES_DESPACHOS")): ?>
        <!--if ($id_rol == 1 || $id_rol == 2 || $id_rol == 3 || $id_rol == 5 || $id_rol == 6): ?>-->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <a href="javascript:void(0)" onclick="modalFechas(10);">
                <!--a href="<?= base_url ?>reporte/despacho"-->
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">article</i>
                        </div>
                        <h4 class="card-title">Despachos</h4>
                    </div>
                </a>
                <div class="card-footer">
                    <div class="stats">
                        Filtrado por fecha
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if (utils::getIssetAcceso("REPORTES_REPORTES_EXISTENCIAS")): ?>
        <!--if ($id_rol == 1 || $id_rol == 2 || $id_rol == 3 || $id_rol == 4 || $id_rol == 6): ?>-->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <a href="<?= base_url ?>reporte/existencias">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">article</i>
                        </div>
                        <h4 class="card-title">Existencias</h4>
                    </div>
                </a>
                <div class="card-footer">
                    <div class="stats">
                        Filtrado por fecha
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if (utils::getIssetAcceso("REPORTES_REPORTES_VENTASXVENDEDOR")): ?>
        <!--if ($id_rol == 1 || $id_rol == 2 || $id_rol == 3 || $id_rol == 4 || $id_rol == 6): ?>-->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <a href="javascript:void(0)" onclick="modalFechas(3);">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">article</i>
                        </div>
                        <h4 class="card-title">Ventas x Vendedor</h4>
                    </div>
                </a>
                <div class="card-footer">
                    <div class="stats">
                        Filtrado por fecha
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if (utils::getIssetAcceso("REPORTES_REPORTES_TRANSITOVENXVENDED")): ?>
        <!--if ($id_rol == 1 || $id_rol == 2 || $id_rol == 3 || $id_rol == 4 || $id_rol == 6): ?>-->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <a href="javascript:void(0)" onclick="modalFechas(9);">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">article</i>
                            x     </div>
                        <h4 class="card-title">Ventas Transito x Vendedor</h4>
                    </div>
                </a>
                <div class="card-footer">
                    <div class="stats">
                        Filtrado por fecha
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if (utils::getIssetAcceso("REPORTES_REPORTES_INVENTARIO")): ?>
        <!--if ($id_rol == 1 || $id_rol == 2 || $id_rol == 3 || $id_rol == 4 || $id_rol == 6): ?>-->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <a href="<?= base_url ?>reporte/inventario">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">article</i>
                        </div>
                        <h4 class="card-title">Inventario</h4>
                    </div>
                </a>
                <div class="card-footer">
                    <div class="stats">
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if (utils::getIssetAcceso("REPORTES_REPORTES_CLIENTES")): ?>
        <!--if ($id_rol == 1 || $id_rol == 2 || $id_rol == 3 || $id_rol == 4 || $id_rol == 6): ?>-->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <a href="<?= base_url ?>reporte/clientes">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">article</i>
                        </div>
                        <h4 class="card-title">Clientes Frecuentes</h4>
                    </div>
                </a>
                <div class="card-footer">
                    <div class="stats">
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!-- Modal fechas a filtrar -->
    <div class="modal fade" id="modalFechas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 40%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Fechas a filtrar
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="material-icons">clear</i>
                    </button>
                </div>                   
                <div class="modal-body">
                    <br/>
                    <form method="POST" action="<?= base_url ?>reporte/tipoReporte" >
                        <div class="row">
                            <input type="hidden" name="id_reporte" id="id_reporte">
                            <div class="col-lg-6 col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Fecha inicial</label>
                                    <input type="text" name="txt_fecha_inicial" id="txt_fecha_inicial" class="form-control datepicker" value="<?= $hoy = Date("m/d/Y"); ?>">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Fecha final</label>
                                    <input type="text" name="txt_fecha_final" id="txt_fecha_final" class="form-control datepicker" value="<?= $hoy = Date("m/d/Y"); ?>">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-3 col-sm-6" id="divFiltroTraslado" style="display: none;">
                                <select class="selectpicker dropdown" data-style="select-with-transition" name="slcTrasladoTipo" id="slcTrasladoTipo" tabindex="-98">
                                    <option value="E"> Traslados Entrantes</option>
                                    <option value="S"> Traslados Salientes</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-3 col-sm-6">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-fill btn-info">Aceptar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin del Modal -->


</div>