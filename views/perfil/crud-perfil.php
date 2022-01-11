<script>

    $(document).ready(function () {

        ///

    });
    function ejemploAJAPOSTGuadarSinSubmit() {

        // form no necesita action
        // form evento onSubmit="return false;"
        // boton no tiene que ser tipi submit y en el onclick llamar a esta funcion

        var formData = new FormData(document.getElementById('el id de tu form'));
        formData.append('llave', 'valor');
        $.ajax({
            url: "<?= base_url ?>traslado/&setGuardarDatosasdfadsfdsf=true",
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (result) {

                if (result["error"]) {

                } else {

                }

            }

        });
    }


    function notification() {

        var type = $("#txtType").val();
        var message = $("#txtMessage").val();
        md.showCustomNotification('top', 'right', type, message);
    }

    function fntShowModalPerfil(intPerfil) {

        $.ajax({
            url: "<?= base_url ?>perfil/&drawContenidoModalPerfil=true&perfil=" + intPerfil,
            success: function (result) {
                $("#modalContentPerfil").html(result);
                $("#modalPerfil").modal("show");
            }
        });
    }
    function fntShowModalAccesos(intAcceso) {

        $.ajax({
            url: "<?= base_url ?>perfil/&drawContenidoModalAcceso=true&acceso=" + intAcceso,
            success: function (result) {
                $("#modalContentAcceso").html(result);
                $("#modalAcceso").modal("show");
            }
        });
    }
    function fntShowModalAccesosPerfil(intPerfil) {

        $.ajax({
            url: "<?= base_url ?>perfil/&drawContenidoModalAccesoPerfil=true&perfil=" + intPerfil,
            success: function (result) {
                $("#modalContentAccesoPerfil").html(result);
                $("#modalAccesoPerfil").modal("show");
            }
        });
    }
    function findEmpresa() {
        alert("Modal para buscar empresa");
    }
    function buscarEmpresa() {
        var nombre = $("#txt_buscarEmpresa").val();
        if (nombre) {
            //alert("Algun texto esta lleno");
            $.ajax({
                url: "<?= base_url ?>perfil/&getAddArray=true&key=1&nombreEmpresa=" + nombre,
                success: function (result) {

                    $("#listaEmpresas").html(result);
                }
            });
            document.getElementById("txt_buscarEmpresa").value = "";
            $("#txt_buscarEmpresa").focus();
        } else {
            alert("No has enviado nada en empresa");
        }
    }
    function agregarEmpresa() {
        console.log("Con esto se agrega empresa");
    }
</script>
<!-- Inputs ocultos que almacenan las variables de sesion de notificacion -->
<input type="hidden" name="txtType" id="txtType" value="<?= $_SESSION['noti_tipo'] ?>" />
<input type="hidden" name="txtMessage" id="txtMessage" value="<?= $_SESSION['noti_mensaje'] ?>" />
<?php if (isset($_SESSION['noti_tipo'])): ?>
    <script>notification();</script>
<?php endif; ?>
<?php
Utils::deleteSession('noti_tipo');
Utils::deleteSession('noti_mensaje');
?>
<div class="modal fade" id="modalPerfil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 50%;">
        <div class="modal-content" id="modalContentPerfil">

        </div>
    </div>
</div>
<div class="modal fade" id="modalAcceso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 50%;">
        <div class="modal-content" id="modalContentAcceso">

        </div>
    </div>
</div>
<div class="modal fade" id="modalAccesoPerfil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 50%;">
        <div class="modal-content" id="modalContentAccesoPerfil">

        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <input type="button" class="btn btn-info btn-wd" onclick="fntShowModalPerfil('0');" value="Crear Nuevo Perfil">
        <input type="button" class="btn btn-info btn-wd" onclick="fntShowModalAccesos('0');" value="Crear Nuevo Acceso">
    </div>
</div>

<!-- Lista de Perfiles -->
<div class="row">
    <div class="col-md-12">
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
                                <th>Id Perfil</th>
                                <th>Nombre</th>
                                <th>Estado</th>
                                <th>Acceso</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($data = $lista_perfiles->fetch_object()): ?>

                                <tr>
                                    <td>
                                        <span class="badge badge-info h5" onclick="fntShowModalPerfil('<?= $data->id_perfil; ?>');" style="cursor: pointer"><?= $data->id_perfil; ?></span>
                                    </td>
                                    <td><?= $data->nombre; ?></td>
                                    <td><?= utils::getEstadoAIById($data->estado); ?></td>
                                    <td>
                                            <button class="btn btn-info" onclick="fntShowModalAccesosPerfil('<?= $data->id_perfil ?>');">Ver Accesos</button>
                                    </td>
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
<!-- Modal para buscar empresas -->
<div class="modal fade" id="infoEmpresas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 700px !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="font-weight: bold;">
                    Busqueda de Empresa
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="material-icons">clear</i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group">
                            <label class="bmd-label-floating">Nombre Empresa</label>
                            <input type="text" class="form-control" name="txt_buscarEmpresa" id="txt_buscarEmpresa"/>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <button class="btn btn-info btn-link" onclick="buscarEmpresa();">Buscar</button>
                        </div>
                    </div>
                </div>
                <div class="row" id="listaEmpresas">
                    <div class="col-md-12">
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre Empresa</th>
                                        <th>Nombre Contacto</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <!-- end content-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalIngresoPerfil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 50%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Ingreso de Perfil
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="material-icons">clear</i>
                </button>
            </div>                   
            <div class="modal-body" id="divBodyModalIngresoPerfil">

            </div>
        </div>
    </div>
</div>


