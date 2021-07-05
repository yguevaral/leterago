<?php             
require_once 'models/cliente_model.php';

class cliente_view {

    var $objModel;
    
    public function __construct() {

        $this->objModel = new cliente_model();
    }
    
    function fntDrawIndex(){
        
        $arrEstadoCredito = utils::getSolicitudCreditoEstado();
        
        $arrPais = $this->objModel->getPais();
        $arrAsesorUsuario = $this->objModel->getAsesorUsuario();
        
        ?>
        
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    
                    <!-- div class="card-header card-header-info card-header-icon">
                        
                        <div class="card-icon">
                            <i class="material-icons">menu_book</i>
                        </div>
                        <h4 class="card-title">Solicitud de Crédito</h4>
                    </div -->
                    
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-12">
                                <button onclick="fntShowModalAdminCredito(0);" class="btn btn-fill btn-info">
                                    Apertura de Codigo Cliente Nuevo
                                </button>
                                <button onclick="fntShowModalAdminCreditoClientePOtencial(0);" class="btn btn-fill btn-info">
                                    Cliente potencial
                                </button>
                            </div>    
                        </div>
                        
                        <form method="POST" onsubmit="return false;" enctype="multipart/form-data" id="fmrFiltroCredito" autocomplete="off">
                        <div class="row">
                        
                            <div class="col-md-3">
                                <select name="slcFiltroPais[]" id="slcFiltroPais" class="selectpicker" data-style="select-with-transition" title="Pais" data-size="3" multiple>
                                    <?php
                                    
                                    while( $rTMP = each($arrPais) ){
                                        
                                        if( isset($_SESSION["leterago"]["id_pais"][$rTMP["key"]]) ){
                                            
                                            ?>
                                            <option value="<?php print $rTMP["key"]?>"><?php print $rTMP["value"]["nombre"]?></option>
                                            <?php
                                        }
                                        
                                            
                                    }
                                    
                                    ?>
                                </select>
                                    
                            </div>
                        
                            <div class="col-md-3">
                                <select name="slcFiltroAsesor[]" id="slcFiltroAsesor" class="selectpicker" data-style="select-with-transition" title="Asesor" data-size="3" multiple>
                                    <?php
                                    
                                    while( $rTMP = each($arrAsesorUsuario) ){
                                        
                                        ?>
                                        <option value="<?php print $rTMP["key"]?>"><?php print $rTMP["value"]["nombres"]." ".$rTMP["value"]["apellidos"]?></option>
                                        <?php
                                                                                    
                                    }
                                    
                                    ?>
                                </select>
                                    
                            </div>
                        
                            <div class="col-md-3">
                                <select name="slcEstadoCredito[]" id="slcEstadoCredito" class="selectpicker" data-style="select-with-transition" title="Estado Cliente" data-size="<?php print count($arrEstadoCredito) / 2 ?>" multiple>
                                    <?php
                                    
                                    
                                    while( $rTMP = each($arrEstadoCredito) ){
                                        ?>
                                        <option value="<?php print $rTMP["key"]?>"><?php print $rTMP["value"]["nombre"]?></option>
                                        <?php
                                    }
                                    
                                    ?>
                                </select>
                                    
                            </div>
                            
                            <div class="col-md-3">
                                
                                <button onclick="fntDrawListPerfil();" class="btn btn-fill btn-info">
                                    Filtrar
                                </button>                                    
                            </div>
                            
                        </div>
                        </form>
                        <div class="row">
                            <div class="col-12 table-responsive" id="divContenido">
                                
                            </div>    
                        </div>    
                        
                    </div>
                </div>
            </div>
        </div>
    
              
        <!-- Modal para buscar empresas -->
        <div class="modal fade" id="mlAdminCredito" style="" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 700px !important;">
                <div class="modal-content" id="mlContentAdminPerfil">
                    
                </div>
            </div>
        </div>
        <!-- Fin del Modal -->
        
        <div class="modal fade" id="mlSolCredito" style="" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 80% !important;">
                <div class="modal-content" id="mlSolCreditoContent">
                    
                </div>
            </div>
        </div>

        <script>

            $(document).ready(function () {
                
                fntDrawListPerfil();
                    
            });
            
            function fntShowModalAdminCredito(intCredito){
                
                $.ajax({
                    
                    url: "<?= base_url ?>cliente/&drawAdminModalCredito=true&credito="+intCredito,
                    success: function (result) {

                        
                        $("#mlContentAdminPerfil").html(result);
                        $("#mlAdminCredito").modal("show");
                        
                        
                    }
                });
                   
            }

            function fntDrawListPerfil( ){
                  
                var formData = new FormData(document.getElementById("fmrFiltroCredito"));

                $.ajax({
                    url: "<?= base_url ?>cliente/&drawListCredito=true",
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        
                        $("#divContenido").html(result);

                    },
                    error: function (result) {

                    }
                });
                
                   
            }
            
            function fntShowModalAdminCreditoClientePOtencial(intCredito){
                
                $.ajax({
                    
                    url: "<?= base_url ?>cliente/&drawAdminModalCreditoClientePotencial=true&credito="+intCredito,
                    success: function (result) {

                        $("#mlContentAdminPerfil").html(result);
                        $("#mlAdminCredito").modal("show");
                        
                    }
                });
                   
            }

        </script>
        <?php      
    
    }
    
    function fntDrawIndexAsesor(){
        
        $arrEstadoCredito = utils::getSolicitudCreditoEstado();
        
        ?>
        
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    
                    <div class="card-header card-header-info card-header-icon">
                        
                        <div class="card-icon">
                            <i class="material-icons">menu_book</i>
                        </div>
                        <h4 class="card-title">Gestiones</h4>
                    </div>
                    
                    <div class="card-body ">
                        
                        <form method="POST" onsubmit="return false;" enctype="multipart/form-data" id="fmrFiltroCredito" autocomplete="off">
                        <div class="row">
                            
                            <div class="col-md-3">
                                <select name="slcEstadoCredito[]" id="slcEstadoCredito" class="selectpicker" data-style="select-with-transition" title="Estado Credito" data-size="<?php print count($arrEstadoCredito) / 2 ?>" multiple>
                                    <?php
                                    
                                    
                                    while( $rTMP = each($arrEstadoCredito) ){
                                        ?>
                                        <option value="<?php print $rTMP["key"]?>"><?php print $rTMP["value"]["nombre"]?></option>
                                        <?php
                                    }
                                    
                                    ?>
                                </select>
                                    
                            </div>
                            
                            <div class="col-md-6">
                                
                                <button onclick="fntDrawListPerfil();" class="btn btn-fill btn-info">
                                    Filtrar
                                </button>                                    
                                <button onclick="fntShowModalAdminCredito(0);" class="btn btn-fill btn-success">
                                    Alta de Cliente
                                </button>
                            </div>
                            
                        </div>
                        </form>
                        <div class="row">
                            <div class="col-12 table-responsive" id="divContenido">
                                
                            </div>    
                        </div>    
                        
                    </div>
                </div>
            </div>
        </div>
    
              
        <!-- Modal para buscar empresas -->
        <div class="modal fade" id="mlAdminCredito" style="" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 700px !important;">
                <div class="modal-content" id="mlContentAdminPerfil">
                    
                </div>
            </div>
        </div>
        <!-- Fin del Modal -->
        
        <div class="modal fade" id="mlSolCredito" style="" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 80% !important;">
                <div class="modal-content" id="mlSolCreditoContent">
                    
                </div>
            </div>
        </div>

        <script>

            $(document).ready(function () {
                
                fntDrawListPerfil();
                    
            });
            
            function fntShowModalAdminCredito(intCredito){
                
                $.ajax({
                    
                    url: "<?= base_url ?>cliente/&drawAdminModalCredito=true&credito="+intCredito,
                    success: function (result) {

                        
                        $("#mlContentAdminPerfil").html(result);
                        $("#mlAdminCredito").modal("show");
                        
                        
                    }
                });
                   
            }

            function fntDrawListPerfil( ){
                  
                var formData = new FormData(document.getElementById("fmrFiltroCredito"));

                $.ajax({
                    url: "<?= base_url ?>cliente/&drawListCredito=true",
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        
                        $("#divContenido").html(result);

                    },
                    error: function (result) {

                    }
                });
                
                   
            }

        </script>
        <?php      
    
    }
    
    public function drawListCreditos($arrCreditos){
        
        ?>
        
        <div class="row">
            <div class="col-md-12 table-responsive">
                
                <table id="tblPerfil" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Cliente</th>
                            <th>Asesor</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th class="disabled-sorting text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        
                        $arrEstadoCliente = utils::getSolicitudCreditoEstado();
                        while( $rTMP = each($arrCreditos) ){
                            ?>
                            <tr>
                                <td><?php print $rTMP["value"]["id_cliente"]?></td>
                                <td><?php print $rTMP["value"]["nombre_empresa"]."<br>".$rTMP["value"]["nombres"]." ".$rTMP["value"]["apellidos"]." <br> ".$rTMP["value"]["email"]?></td>
                                <td><?php print $rTMP["value"]["nombres_asesor"]." ".$rTMP["value"]["apellidos_asesor"]?></td>
                                <td><?php print $rTMP["value"]["fecha_creacion"]?></td>
                                <td><?php print $arrEstadoCliente[trim($rTMP["value"]["estado"])]["nombre"]?></td>
                                <td class="text-center">
                                    <?php
                                    
                                    if( $rTMP["value"]["estado"] == "CCA" ){
                                        ?>
                                        <button onclick="fntShowSolCreditoConsolidado('<?php print $rTMP["value"]["id_cliente"]?>');" class="btn btn-sm btn-fill btn-info">
                                            Datos de Cliente
                                        </button>
                                        <br>
                                        <button onclick="fntEnviarFormularioCredito('<?php print $rTMP["value"]["id_cliente"]?>')" class="btn btn-fill btn-info btn-sm">
                                            Apertura de Credito
                                        </button>
                                        <?php
                                    }
                                    elseif( $rTMP["value"]["estado"] == "FEP" || $rTMP["value"]["estado"] == "FRE" ){
                                        ?>
                                        <button onclick="fntShowSolCreditoConsolidado('<?php print $rTMP["value"]["id_cliente"]?>');" class="btn btn-sm btn-fill btn-info">
                                            Alta de Cliente
                                        </button>    
                                        <?php
                                    }
                                    else{
                                        print("N/A");
                                    }
                                    
                                    ?>    
                                </td>
                            </tr> 
                            <?php
                        }
                        
                        ?>
                            
                    </tbody>
                </table>
                
            </div>
        </div>
                
        <script>
            $(document).ready(function () {
                
                $('.selectpicker').selectpicker(); 
                
                $('#tblPerfil').DataTable();
               
            });
            
            function fntShowSolCreditoConsolidado(intCredito){
                
                $.ajax({
                    url: "<?= base_url ?>cliente/&showSolCreditoConsolidado=true&credito="+intCredito,
                    success: function (result) {

                        $("#mlSolCreditoContent").html(result);
                        $("#mlSolCredito").modal("show");
                        
                        
                    }
                });
                
                
            }
            
            function fntEnviarFormularioCredito(){
                swal({
                title: 'Estas seguro?',
                text: 'Se enviara el formulario: 03-F04 Apertura de Crédito a clientes',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
                confirmButtonClass: "btn btn-success",
                cancelButtonClass: "btn btn-danger",
                buttonsStyling: false
              }).then(function() {
                swal({
                  title: 'Deleted!',
                  text: 'Your imaginary file has been deleted.',
                  type: 'success',
                  confirmButtonClass: "btn btn-success",
                  buttonsStyling: false
                }).catch(swal.noop)
              }, function(dismiss) {
                // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
                if (dismiss === 'cancel') {
                  swal({
                    title: 'Cancelled',
                    text: 'Your imaginary file is safe :)',
                    type: 'error',
                    confirmButtonClass: "btn btn-info",
                    buttonsStyling: false
                  }).catch(swal.noop)
                }
              })
            }
            
        </script>
        <?php
    }
    
    public function drawListCreditosAsesor($arrCreditos){
        
        ?>
        
        <div class="row">
            <div class="col-md-12 table-responsive">
                
                <table id="tblPerfil" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                    <thead>
                        <tr>
                            <th># Credito</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th class="disabled-sorting text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th># Solicitud Credito</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th class="text-right">Acciones</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        
                        $arrEstado = utils::getSolicitudCreditoEstado();
                        while( $rTMP = each($arrCreditos) ){
                            ?>
                            <tr>
                                <td><?php print $rTMP["value"]["id_sol_credito"]?></td>
                                <td><?php print $rTMP["value"]["nombres"]." ".$rTMP["value"]["apellidos"]." <br> ".$rTMP["value"]["email"]?></td>
                                <td><?php print $rTMP["value"]["fecha_creacion"]?></td>
                                <td><?php print $arrEstado[$rTMP["value"]["estado"]]["nombre"]?></td>
                                <td class="text-right">
                                    <a href="javascript: void(0)" onclick="fntShowSolCreditoConsolidado('<?php print $rTMP["value"]["id_sol_credito"]?>');" class="btn btn-link btn-info btn-just-icon edit"><i class="material-icons">visibility</i></a>
                                </td>
                            </tr> 
                            <?php
                        }
                        
                        ?>
                            
                    </tbody>
                </table>
                
            </div>
        </div>
                
        <script>
            $(document).ready(function () {
                
                $('.selectpicker').selectpicker(); 
                
                $('#tblPerfil').DataTable();
               
            });
            
            function fntShowSolCreditoConsolidado(intCredito){
                
                $.ajax({
                    url: "<?= base_url ?>cliente/&showSolCreditoConsolidado=true&credito="+intCredito,
                    success: function (result) {

                        $("#mlSolCreditoContent").html(result);
                        $("#mlSolCredito").modal("show");
                        
                        
                    }
                });
                
                
            }
            
        </script>
        <?php
    }
    
    public function drawAdminModalCredito($intCredito, $boolClientePotencial = false){
        
        ?>
        <form method="POST" onsubmit="return false;" enctype="multipart/form-data" id="frmCredito" autocomplete="off">
        <input type="hidden" name="hidCredito" id="hidCredito" value="<?php print $intCredito;?>">
        <input type="hidden" name="hidClientePotencial" id="hidClientePotencial" value="<?php print $boolClientePotencial ? "Y" : "N";?>">
        <div class="modal-header">
            <h4 class="modal-title" style="font-weight: bold;">
                <?php print $boolClientePotencial ? "Cliente Potencial" : "Alta de Cliente"?>
            </h4>
            
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <i class="material-icons">clear</i>
            </button>
        </div>
        <?php
        
        if( $intCredito == 0 ){
            ?>
            <div class="modal-body" id="mlBodyAdminUsuario">
                
                <h5 class="" style="font-weight: bold;">
                    Persona de Contacto
                </h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating">Primer Nombre</label>
                            <input type="text" class="form-control" name="txtPrimerNombre" id="txtPrimerNombre" autocomplete="off" value="" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating">Segundo Nombre</label>
                            <input type="text" class="form-control" name="txtSegundoNombre" id="txtSegundoNombre" autocomplete="off" value="" >
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating">Primer Apellido</label>
                            <input type="text" class="form-control" name="txtPrimerApellido" id="txtPrimerApellido" autocomplete="off" value="" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating">Segundo Apellido</label>
                            <input type="text" class="form-control" name="txtSegundoApellido" id="txtSegundoApellido" autocomplete="off" value="" >
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="bmd-label-floating">Email</label>
                            <input type="email" class="form-control" name="txtEmailUsuario" id="txtEmailUsuario" autocomplete="off" value="<?php print isset($arrUsuario["email"]) ? $arrUsuario["email"] : ""?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <select name="slcSexo" class="selectpicker" data-style="select-with-transition" title="Sexo" data-size="3">
                                <?php
                                
                                $arrSexo = utils::getSexo();
                                while( $rTMP = each($arrSexo) ){
                                    $strSelected = false ? "selected" : "";
                                    ?>
                                    <option <?php print $strSelected;?> value="<?php print $rTMP["key"]?>"><?php print $rTMP["value"]["nombre"]?></option>
                                    <?php
                                }
                                
                                ?>
                            </select>
                            
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="bmd-label-floating">Nombre Empresa</label>
                            <input type="text" class="form-control" name="txtNombreEmpresa" id="txtNombreEmpresa" autocomplete="off" value="" >
                        </div>
                    </div>
                </div>
                
                <div class="row justify-content-center">
                    <div class="col-md-12 text-right">
                        <button id="btnCrearSolCredito" onclick="fntSaveCredito();" class="btn btn-fill btn-info">
                            Enviar Datos
                        </button>
                        <button onclick="fntCloseModalCredito();" class="btn btn-fill btn-default">
                            Cancelar
                        </button>
                    </div>
                </div>
                
            </div>
            <?php
        }
        
        ?>
            
        </form>
        <script>
            
            $('.selectpicker').selectpicker();
            
            function fntCloseModalCredito(){
                $('#mlAdminCredito').modal('hide');    
            }
            
            function fntSaveCredito(){
                
                $("#btnCrearSolCredito").prop('disabled', true);
                $("#btnCrearSolCredito").html('Cargando');
                var formData = new FormData(document.getElementById("frmCredito"));

                $.ajax({
                    url: "<?= base_url ?>cliente/&setCredito=true",
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function (result) {
                        
                        $("#btnCrearSolCredito").prop('disabled', false);
                        $("#btnCrearSolCredito").html('Guardar');
                        if ( !result["error"] ) {

                            md.showCustomNotification('top', 'right', "success", result["msg"]);
                            fntDrawListPerfil();

                        } else {
                            md.showCustomNotification('top', 'right', "error", "Error");    
                        }
                        
                        fntCloseModalCredito();

                    },
                    error: function (result) {

                        md.showCustomNotification('top', 'right', "error", "Error");
                        fntCloseModalCredito();
                        $("#btnCrearSolCredito").prop('disabled', false);
                        $("#btnCrearSolCredito").html('Guardar');

                    }
                });
                
            }
            
        </script>
        <?php
        
    } 
    
    
    /*
    Clientes
    */
    function fntDrawIndexCliente(){
        
        ?>
        
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">menu_book</i>
                        </div>
                        <h4 class="card-title">Gestiones</h4>
                    </div>
                    <div class="card-body ">
                    
                        <div class="row">
                            <div class="col-12" id="divContenido">
                                
                            </div>    
                        </div>    
                        
                    </div>
                </div>
            </div>
        </div>
    
              
        <!-- Modal para buscar empresas -->
        <div class="modal fade" id="mlAdminCredito" style="" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 700px !important;">
                <div class="modal-content" id="mlContentAdminPerfil">
                    
                </div>
            </div>
        </div>
        <!-- Fin del Modal -->

        
        
        
        <script>

            $(document).ready(function () {
                
                fntDrawListPerfil();
                    
            });
            
            function fntShowModalAdminCredito(intCredito){
                
                $.ajax({
                    
                    url: "<?= base_url ?>cliente/&drawAdminModalCredito=true&credito="+intCredito,
                    success: function (result) {

                        $("#mlContentAdminPerfil").html(result);
                        $("#mlAdminCredito").modal("show");
                        
                    }
                });
                   
            }
            
            

            function fntDrawListPerfil( ){
                
                $.ajax({
                    url: "<?= base_url ?>cliente/&drawListCreditoCliente=true",
                    success: function (result) {

                        $("#divContenido").html(result);
                        
                        
                        
                    }
                });
                   
            }

        </script>
        <?php      
    
    }
    
    public function fntSolCreditoConsolidado($intSolCredito, $arrSolCredito, $arrSolCreditoDato = array()){
        
        
        ?>
        <div class="modal-body" id="mlBodyAdminUsuario">
            
            <h3 class="text-center" style="font-weight: bold;">
                Cliente # <?php print $intSolCredito?> 
            </h3>
            <div class="row">
                <div class="col-12">
                    <?php 
                    $this->fntSolCreditoFormBloque1($intSolCredito, $arrSolCredito, $arrSolCreditoDato, true);
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <?php 
                    $this->fntSolCreditoFormBloque2($intSolCredito, $arrSolCredito, $arrSolCreditoDato, true);
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <?php 
                    $this->fntSolCreditoFormBloque3($intSolCredito, $arrSolCredito, $arrSolCreditoDato, true);
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <?php 
                    $this->fntSolCreditoFormBloque4($intSolCredito, $arrSolCredito, $arrSolCreditoDato, true);
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <?php 
                    $this->fntSolCreditoFormBloque5($intSolCredito, $arrSolCredito, $arrSolCreditoDato, true);
                    ?>
                </div>
            </div>
            
            <?php
            
            if( $arrSolCredito["estado"] != "CCA" ){
                ?>
                
                <div class="row">
                    <div class="col-12">
                        
                        <div class="form-group">
                            <label class="bmd-label-floating">Notas de Rechazo</label>
                            <textarea class="form-control" name="txtNotaRechazo" id="txtNotaRechazo" autocomplete="off" rows="4"></textarea>
                            <input type="hidden" name="hidDireccionCompletaKey" value="<?php print isset($arrSolCreditoDato["DIRECCION"]) ? $arrSolCreditoDato["DIRECCION"]["id_sol_credito_dato"] : ""?>" >
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12 text-center">
                        
                        <button id="bntModalRechazo" onclick="fntRechazarSolCredito();" class="btn btn-fill btn-danger">
                            Rechazar
                        </button>   
                        <button id="bntModalAprobar" onclick="fntAprobarSolCredito();" class="btn btn-fill btn-success">
                            Aprobar
                        </button>    
                        
                    </div>
                </div>
                
                <?php
            }
            
            ?>
            
                
        </div>
        <script>    
        
            function fntCloseModalCreditoConsolidado(){
                
                $("#mlSolCreditoContent").html("");
                $("#mlSolCredito").modal("hide");    
            }
        
            function fntRechazarSolCredito(){
                    
                if( $("#txtNotaRechazo").val() == "" ){
                    
                    swal({
                        text: "Ingresa tus notas de rechazo para continuar",
                        buttonsStyling: false,
                        confirmButtonClass: "btn btn-danger",
                        timer: 2000,
                    }).catch(swal.noop)

                }
                else{
                    
                    
                    $("#bntModalRechazo").prop('disabled', true);
                    $("#bntModalRechazo").html('Cargando');
                    var formData = new FormData();
                    formData.append("hidSolCredito", "<?php print $intSolCredito?>");
                    formData.append("txtNotaRechazo", $("#txtNotaRechazo").val());

                    $.ajax({
                        url: "<?= base_url ?>cliente/&setCreditoRechazo=true",
                        type: "POST",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: "json",
                        success: function (result) {
                            
                            $("#bntModalRechazo").prop('disabled', false);
                            $("#bntModalRechazo").html('Guardar');
                            if ( !result["error"] ) {

                                md.showCustomNotification('top', 'right', "success", result["msg"]);
                                fntDrawListPerfil();

                            } else {
                                md.showCustomNotification('top', 'right', "error", "Error");    
                            }
                            
                            fntCloseModalCreditoConsolidado();

                        },
                        error: function (result) {

                            md.showCustomNotification('top', 'right', "error", "Error");
                            fntCloseModalCreditoConsolidado();
                            $("#bntModalRechazo").prop('disabled', false);
                            $("#bntModalRechazo").html('Guardar');

                        }
                    });
                    
                }
                    
                
            
            }
            
            function fntAprobarSolCredito(){
                    
                $("#bntModalAprobar").prop('disabled', true);
                $("#bntModalAprobar").html('Cargando');
                var formData = new FormData();
                formData.append("hidSolCredito", "<?php print $intSolCredito?>");

                $.ajax({
                    url: "<?= base_url ?>cliente/&setCreditoAprobacion=true",
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function (result) {
                        
                        $("#bntModalAprobar").prop('disabled', false);
                        $("#bntModalAprobar").html('Guardar');
                        if ( !result["error"] ) {

                            md.showCustomNotification('top', 'right', "success", result["msg"]);
                            fntDrawListPerfil();

                        } else {
                            md.showCustomNotification('top', 'right', "error", "Error");    
                        }
                        
                        fntCloseModalCreditoConsolidado();

                    },
                    error: function (result) {

                        md.showCustomNotification('top', 'right', "error", "Error");
                        fntCloseModalCreditoConsolidado();
                        $("#bntModalRechazo").prop('disabled', false);
                        $("#bntModalRechazo").html('Guardar');

                    }
                });
                    
            }
            
        </script>
        <?php    
    }
    
    public function drawCiudad($arrCiudad, $intCiudad){
        ?>
        <select name="slcCiudad" class="selectpicker" data-style="select-with-transition" title="Ciudad" data-size="0">
            <?php
            
            while( $rTMP = each($arrCiudad) ){
                $strSelected = $intCiudad == $rTMP["key"] ? "selected" : "";
                ?>
                <option <?php print $strSelected;?> value="<?php print $rTMP["key"]?>"><?php print $rTMP["value"]["nombre"]?></option>
                <?php
            }
            
            ?>
        </select>
        <script>
            $('.selectpicker').selectpicker();
        </script>
        <?php
        
    }
    
    public function fntSolCreditoFormBloque1($intSolCredito, $arrSolCredito, $arrSolCreditoDato = array(), $boolConsolidado = false){
        
        $boolClientePotencial = $arrSolCredito["cliente_potencial"] == "Y" ? true : false;
        
        ?>
        <form method="POST" onsubmit="return false;" enctype="multipart/form-data" id="frmCreditoBloque2" autocomplete="off">
        <input type="hidden" name="hidSolCredito" value="<?php print $intSolCredito?>">
        
        <?php
        
        if( !$boolConsolidado ){
            ?>
            <div class="row justify-content-center">
                
                <div class="col-md-6 col-xs-12 mt-0">
                    <h4 class="title text-center mt-0 mb-0 font-weight-bold">
                        
                        <?php
                        
                        if( $boolClientePotencial ){
                            ?>
                            Cliente Potencial #<?php print $intSolCredito?> Formulario 03-F02
                            <?php
                        }
                        else{
                            ?>
                            Alta de Cliente #<?php print $intSolCredito?> Formulario 03-F02
                            <?php
                        }
                        ?>
                        
                        
                    </h4>

                    <div class="progress progress-line-info mt-0 mb-0">
                        <div class="progress-bar progress-bar-info mt-0 mb-0" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 1%;">
                            <span class="sr-only">1%</span>
                        </div>
                    </div>

                </div>
                
            </div>
            <div class="row">
                
                <div class="col-md-12 text-center mt-4">
                    <button onclick="fntSaveCreditoBloque2();" class="btn btn-fill btn-info">
                        Siguiente &nbsp;&nbsp; <i class="fa fa-arrow-right" aria-hidden="true"></i>

                    </button>
                </div>            
            </div>
            
            <?php
        }
        
        if( !$boolConsolidado && !empty($arrSolCredito["nota_rechazo"]) ){
            ?>
            <div class="row justify-content-center">
                
                <div class="col-12 ">
                    
                    <small class="title text-left font-weight-bold ">
                        Nota de Rechazo:
                    </small>
                    <br>
                    <small class="title text-left font-weight-bold  text-danger">
                        <?php print $arrSolCredito["nota_rechazo"]?>
                    </small>
                    <br>
                    <small class="title text-left font-weight-bold ">
                        Completa los pasos y envia el formulario
                    </small>
                    
                </div>
            </div>
            
            <?php    
        }
        
        
        $intPaisAsesor = $this->objModel->getUsuarioPais($arrSolCredito["id_usuario_asesor"]);
        $arrEstado = $this->objModel->getEstado($intPaisAsesor);
        ?>
        
        <div class="row justify-content-center">
            
            <div class="col-12">
                <h4 class="title text-left font-weight-bold">
                    DATOS DEL NEGOCIO
                </h4>
            </div>
        </div>
        
        
        <div class="row">
            
            <div class="col-md-12">
                <div class="form-group">
                    <label class="bmd-label-floating">Nombre Comercial</label>
                    <input type="text" <?php print $boolConsolidado ? "readonly" : ""?> class="form-control" name="txtNombreComercial" autocomplete="off" value="<?php print isset($arrSolCreditoDato["NOMBRE_COMERCIAL"]) ? $arrSolCreditoDato["NOMBRE_COMERCIAL"]["valor_input"] : ""?>" >
                    <input type="hidden" name="hidNombreComercialKey" value="<?php print isset($arrSolCreditoDato["NOMBRE_COMERCIAL"]) ? $arrSolCreditoDato["NOMBRE_COMERCIAL"]["id_sol_credito_dato"] : ""?>" >
                </div>
            </div>
            
            <div class="col-md-12">
                <div class="form-group">
                    <label class="bmd-label-floating">Direccion Completa del Residencia</label>
                    <textarea class="form-control" <?php print $boolConsolidado ? "readonly" : ""?> name="txtDireccionResidencia" autocomplete="off"><?php print isset($arrSolCreditoDato["DIRECCION_RESIDENCIA"]) ? $arrSolCreditoDato["DIRECCION_RESIDENCIA"]["valor_input"] : ""?></textarea>
                    <input type="hidden" name="hidDireccionResidenciaKey" value="<?php print isset($arrSolCreditoDato["DIRECCION_RESIDENCIA"]) ? $arrSolCreditoDato["DIRECCION_RESIDENCIA"]["id_sol_credito_dato"] : ""?>" >
                </div>
            </div>
            
            
            <div class="col-md-6">
            
                <label class="bmd-label-floating">Departamento</label>
                <input type="hidden" name="slcNegocioDepartamentoKey" value="<?php print isset($arrSolCreditoDato["DIRECCION_NEGOCIO_DEPARTAMENTO"]) ? $arrSolCreditoDato["DIRECCION_NEGOCIO_DEPARTAMENTO"]["id_sol_credito_dato"] : ""?>" >
                <select name="slcNegocioDepartamento" id="slcNegocioDepartamento" <?php print $boolConsolidado ? "disabled" : ""?> class="selectpicker" data-style="select-with-transition" title="Departamento" data-size="<?php print count($arrEstado) / 2?>" onchange="fntDrawCiudad();">
                    <?php
                    
                    
                    while( $rTMP = each($arrEstado) ){
                        $strSelected = isset($arrSolCreditoDato["DIRECCION_NEGOCIO_DEPARTAMENTO"]) && $arrSolCreditoDato["DIRECCION_NEGOCIO_DEPARTAMENTO"]["valor_input"] == $rTMP["key"] ? "selected" : "";
                        ?>
                        <option <?php print $strSelected;?> value="<?php print $rTMP["key"]?>"><?php print $rTMP["value"]["nombre"]?></option>
                        <?php
                    }
                    
                    ?>
                </select>
                
            </div>
            
            <div class="col-md-6">
                
                <label class="bmd-label-floating">Ciudad</label>
                <input type="hidden" name="slcCiudadKey" value="<?php print isset($arrSolCreditoDato["DIRECCION_NEGOCIO_CIUDAD"]) ? $arrSolCreditoDato["DIRECCION_NEGOCIO_CIUDAD"]["id_sol_credito_dato"] : ""?>" >
                <div id="divFormCiudad">
                    <select name="slcCiudad" class="selectpicker" data-style="select-with-transition" title="Ciudad" data-size="0">
                    </select>
                </div>
            </div>
            
        </div>
        
        <div class="row">
            
            <div class="col-md-3">
                <div class="form-group">
                    <label class="bmd-label-floating">NIT</label>
                    <input type="text" <?php print $boolConsolidado ? "readonly" : ""?> class="form-control" name="txtNit" autocomplete="off" value="<?php print isset($arrSolCreditoDato["NIT"]) ? $arrSolCreditoDato["NIT"]["valor_input"] : ""?>" >
                    <input type="hidden" name="hidNitKey" value="<?php print isset($arrSolCreditoDato["NIT"]) ? $arrSolCreditoDato["NIT"]["id_sol_credito_dato"] : ""?>" >
                </div>
            </div>
            
            <div class="col-md-9">
                <div class="form-group">
                    <label class="bmd-label-floating">Patente de comercio ( Numero )</label>
                    <input type="text" <?php print $boolConsolidado ? "readonly" : ""?> class="form-control" name="txtPatenteComercio" autocomplete="off" value="<?php print isset($arrSolCreditoDato["PATENTE_COMERCIO"]) ? $arrSolCreditoDato["PATENTE_COMERCIO"]["valor_input"] : ""?>" >
                    <input type="hidden" name="hidPatenteComercioKey" value="<?php print isset($arrSolCreditoDato["PATENTE_COMERCIO"]) ? $arrSolCreditoDato["PATENTE_COMERCIO"]["id_sol_credito_dato"] : ""?>" >
                </div>
            </div>
        
        </div>
        
        <div class="row">
            
            <div class="col-md-6">
                
                <label class="bmd-label-floating">Clase de Negocio</label>
                <input type="hidden" name="hidPatenteComercioKey" value="<?php print isset($arrSolCreditoDato["CLASE_NEGOCIO"]) ? $arrSolCreditoDato["CLASE_NEGOCIO"]["id_sol_credito_dato"] : ""?>" >
                <br>
                <?php
                                
                $arrClaseNegocio = utils::getClaseNegocio();
                while( $rTMP = each($arrClaseNegocio) ){
                    $strSelected = isset($arrSolCreditoDato["CLASE_NEGOCIO"]) && $arrSolCreditoDato["CLASE_NEGOCIO"]["valor_input"] == $rTMP["key"] ? "checked" : "";
                    ?>
                    <div class="form-check form-check-inline">

                        <label class="form-check-label" for="rdClaseNegocio_<?php print $rTMP["key"]?>">
                            <input class="form-check-input"  <?php print $boolConsolidado ? "disabled" : ""?>  <?php print $strSelected?> type="radio" name="rdClaseNegocio" id="rdClaseNegocio_<?php print $rTMP["key"]?>" value="<?php print $rTMP["key"]?>">
                            <span class="circle">
                                <span class="check"></span>
                            </span>
                            <?php print $rTMP["value"]["nombre"]?>
                        </label>
                    </div>
                    <?php
                }
                
                ?>
                
            </div>
            
            <div class="col-md-6">
                
                <label class="bmd-label-floating">Local</label>
                <input type="hidden" name="hidTipoLocalKey" value="<?php print isset($arrSolCreditoDato["TIPO_LOCAL"]) ? $arrSolCreditoDato["TIPO_LOCAL"]["id_sol_credito_dato"] : ""?>" >
                <br>
                <?php
                                
                $arrTipoLocal = utils::getTipoLocal();
                while( $rTMP = each($arrTipoLocal) ){
                    $strSelected = isset($arrSolCreditoDato["TIPO_LOCAL"]) && $arrSolCreditoDato["TIPO_LOCAL"]["valor_input"] == $rTMP["key"] ? "checked" : "";
                    ?>
                    <div class="form-check form-check-inline">

                        <label class="form-check-label" for="rdTipoLocal_<?php print $rTMP["key"]?>">
                            <input class="form-check-input" <?php print $boolConsolidado ? "disabled" : ""?>  <?php print $strSelected?> type="radio" name="rdTipoLocal" id="rdTipoLocal_<?php print $rTMP["key"]?>" value="<?php print $rTMP["key"]?>">
                            <span class="circle">
                                <span class="check"></span>
                            </span>
                            <?php print $rTMP["value"]["nombre"]?>
                        </label>
                    </div>
                    <?php
                }
                
                ?>
                
            </div>
                        
                        
        </div>
        
        <div class="row">
            
            <div class="col-md-3">
                <div class="form-group">
                    <label class="bmd-label-floating">Tiempo de tener el negocio</label>
                    <input type="text" <?php print $boolConsolidado ? "readonly" : ""?> class="form-control" name="txtTiempoNegocio" autocomplete="off" value="<?php print isset($arrSolCreditoDato["TIEMPO_NEGOCIO"]) ? $arrSolCreditoDato["TIEMPO_NEGOCIO"]["valor_input"] : ""?>" >
                    <input type="hidden" name="hidTiempoNegocioKey" value="<?php print isset($arrSolCreditoDato["TIEMPO_NEGOCIO"]) ? $arrSolCreditoDato["TIEMPO_NEGOCIO"]["id_sol_credito_dato"] : ""?>" >
                </div>
            </div>
            
            <div class="col-md-9">
                <div class="form-group">
                    <label class="bmd-label-floating">Otros Negocios</label>
                    <input type="text" <?php print $boolConsolidado ? "readonly" : ""?> class="form-control" name="txtOtrosNegocios" autocomplete="off" value="<?php print isset($arrSolCreditoDato["OTROS_NEGOCIOS"]) ? $arrSolCreditoDato["OTROS_NEGOCIOS"]["valor_input"] : ""?>" >
                    <input type="hidden" name="hidOtrosNegociosKey" value="<?php print isset($arrSolCreditoDato["OTROS_NEGOCIOS"]) ? $arrSolCreditoDato["OTROS_NEGOCIOS"]["id_sol_credito_dato"] : ""?>" >
                </div>
            </div>
            
        </div>
        
        <div class="row">
            
            <div class="col-md-12">
                <div class="form-group">
                    <label class="bmd-label-floating">Actividad principal del negocio</label>
                    <textarea class="form-control" <?php print $boolConsolidado ? "readonly" : ""?> name="txtActividadPrincipalNegocio" autocomplete="off"><?php print isset($arrSolCreditoDato["ACTIVIDAD_PRINCIPAL_NEGOCIO"]) ? $arrSolCreditoDato["ACTIVIDAD_PRINCIPAL_NEGOCIO"]["valor_input"] : ""?></textarea>
                    <input type="hidden" name="hidActividadPrincipalNegocioKey" value="<?php print isset($arrSolCreditoDato["ACTIVIDAD_PRINCIPAL_NEGOCIO"]) ? $arrSolCreditoDato["ACTIVIDAD_PRINCIPAL_NEGOCIO"]["id_sol_credito_dato"] : ""?>" >
                </div>
            </div>
        
        </div>
        
        <?php
        
        if( false ){
            ?>
            <div class="row">
                
                <div class="col-md-12">
                    <h5 class="text-center font-weight-bold">Monto de Credito Solicitado</h5>
                    <div class="form-group">
                        <label class="bmd-label-floating">Monto de Credito Solicitado Q. </label>
                        <input type="text" <?php print $boolConsolidado ? "readonly" : ""?> class="form-control text-center" name="txtMontoCreditoSolicitado" autocomplete="off" value="<?php print isset($arrSolCreditoDato["MONTO_SOLICITADO"]) ? $arrSolCreditoDato["MONTO_SOLICITADO"]["valor_input"] : "0.00"?>" >
                        <input type="hidden" name="hidMontoCreditoSolicitadoKey" value="<?php print isset($arrSolCreditoDato["MONTO_SOLICITADO"]) ? $arrSolCreditoDato["MONTO_SOLICITADO"]["id_sol_credito_dato"] : ""?>" >
                    </div>
                </div>
                
            </div>
            
            <?php
        }
        
        ?>
            
        
        
        </form>
        <script>    
        
            $(document).ready(function () {
                $('.selectpicker').selectpicker(); 
                
                
                <?php 
                
                if( isset($arrSolCreditoDato["DIRECCION_NEGOCIO_CIUDAD"]) ){
                    ?>
                    fntDrawCiudad();
                    <?php
                }
                
                ?>
                   
            });
            
            function fntDrawCiudad(){
                
                $.ajax({
                    url: "<?= base_url ?>cliente/&drawCiudad=true&ciudad=<?php print isset($arrSolCreditoDato["DIRECCION_NEGOCIO_CIUDAD"]) ? $arrSolCreditoDato["DIRECCION_NEGOCIO_CIUDAD"]["valor_input"] : 0; ?>&departamento="+$("#slcNegocioDepartamento").val(),
                    success: function (result) {

                        $("#divFormCiudad").html(result);
                        
                    }
                });    
                
            }
            
            function fntShowSolCreditoFormBloque1(){
                
                $.ajax({
                    url: "<?= base_url ?>cliente/&showSolCreditoFormBloque1=true&credito=<?php print $intSolCredito?>",
                    success: function (result) {

                        $("#divContainerPrincipal").html(result);
                        
                    }
                });
                
                
            }
        
            function fntShowSolCreditoFormBloque2(){
                
                $.ajax({
                    url: "<?= base_url ?>cliente/&showSolCreditoFormBloque2=true&credito=<?php print $intSolCredito?>",
                    success: function (result) {

                        $("#divContainerPrincipal").html(result);
                        
                    }
                });
                
                
            }
            
            function fntSaveCreditoBloque2(){
                
                $(".mlCargando").fadeIn();
                var formData = new FormData(document.getElementById("frmCreditoBloque2"));

                $.ajax({
                    url: "<?= base_url ?>cliente/&setCreditoBloque2=true",
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function (result) {
                        
                        $(".mlCargando").fadeOut();        
                        if ( !result["error"] ) {

                            md.showCustomNotification('top', 'right', "success", result["msg"]);
                            
                            fntShowSolCreditoFormBloque2();

                        } else {
                            md.showCustomNotification('top', 'right', "error", "Error");    
                        }
                        

                    },
                    error: function (result) {

                        $(".mlCargando").fadeOut();
                        md.showCustomNotification('top', 'right', "error", "Error");

                    }
                });
                
            }
        
        </script>
        <?php
        
    }
    
    public function fntSolCreditoFormBloque2($intSolCredito, $arrSolCredito, $arrSolCreditoDato = array(), $boolConsolidado = false){
        
        $boolClientePotencial = $arrSolCredito["cliente_potencial"] == "Y" ? true : false;
        ?>
        <form method="POST" onsubmit="return false;" enctype="multipart/form-data" id="frmCreditoBloque3" autocomplete="off">
        <input type="hidden" name="hidSolCredito" value="<?php print $intSolCredito?>">
        <?php
        
        if( !$boolConsolidado ){
            ?>
            <div class="row justify-content-center">
                
                <div class="col-md-6 col-xs-12 mt-0">
                    <h4 class="title text-center mt-0 mb-0 font-weight-bold">
                        <?php
                        
                        if( $boolClientePotencial ){
                            ?>
                            Cliente Potencial #<?php print $intSolCredito?> Formulario 03-F02
                            <?php
                        }
                        else{
                            ?>
                            Alta de Cliente #<?php print $intSolCredito?> Formulario 03-F02
                            <?php
                        }
                        ?>
                    </h4>

                    <div class="progress progress-line-info mt-0 mb-0">
                        <div class="progress-bar progress-bar-info mt-0 mb-0" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 25%;">
                            <span class="sr-only">25%</span>
                        </div>
                    </div>

                </div>
                
            </div>
            <div class="row">
                
                <div class="col-md-12 text-center mt-4">
                    <button onclick="fntShowSolCreditoFormBloque1();" class="btn btn-fill btn-info">
                        
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp;&nbsp; Anterior
                    </button>
                    <button onclick="fntSaveCreditoBloque3();" class="btn btn-fill btn-info">
                        Siguiente &nbsp;&nbsp; <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </button>
                </div>            
            </div>
            <?php        }
        
        if( !$boolConsolidado && !empty($arrSolCredito["nota_rechazo"]) ){
            ?>
            <div class="row justify-content-center">
                
                <div class="col-12 ">
                    
                    <small class="title text-left font-weight-bold ">
                        Nota de Rechazo:
                    </small>
                    <br>
                    <small class="title text-left font-weight-bold  text-danger">
                        <?php print $arrSolCredito["nota_rechazo"]?>
                    </small>
                    <br>
                    <small class="title text-left font-weight-bold ">
                        Completa los pasos y envia el formulario
                    </small>
                    
                </div>
            </div>
            
            <?php    
        }
        ?>
            
        <div class="row justify-content-center">
            
            <div class="col-12">
                <h4 class="title text-left font-weight-bold">
                    REFERENCIAS COMERCIALES
                </h4>
            </div>
        </div>
        <?php
        
        for( $i = 1; $i <= 3; $i++ ){
            ?>
            <div class="row">
                
                <div class="col-md-9">
                    <div class="form-group">
                        <label class="bmd-label-floating">Nombre de la Empresa <?php print $i?></label>
                        <input type="text" <?php print $boolConsolidado ? "readonly" : ""?>  class="form-control" name="txtNombreEmpresa_<?php print $i?>" autocomplete="off" value="<?php print isset($arrSolCreditoDato["REFERENCIA_NOMBRE_EMPRESA_{$i}"]) ? $arrSolCreditoDato["REFERENCIA_NOMBRE_EMPRESA_{$i}"]["valor_input"] : ""?>" >
                        <input type="hidden" name="hidNombreEmpresa_<?php print $i?>" value="<?php print isset($arrSolCreditoDato["REFERENCIA_NOMBRE_EMPRESA_{$i}"]) ? $arrSolCreditoDato["REFERENCIA_NOMBRE_EMPRESA_{$i}"]["id_sol_credito_dato"] : ""?>" >
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="bmd-label-floating">No. Telefono <?php print $i?></label>
                        <input type="text" <?php print $boolConsolidado ? "readonly" : ""?> class="form-control" name="txtTelefonoEmpresa_<?php print $i?>" autocomplete="off" value="<?php print isset($arrSolCreditoDato["REFERENCIA_TELEFONO_EMPRESA_{$i}"]) ? $arrSolCreditoDato["REFERENCIA_TELEFONO_EMPRESA_{$i}"]["valor_input"] : ""?>" >
                        <input type="hidden" name="hidTelefonoEmpresa_<?php print $i?>" value="<?php print isset($arrSolCreditoDato["REFERENCIA_NOMBRE_EMPRESA_{$i}"]) ? $arrSolCreditoDato["REFERENCIA_NOMBRE_EMPRESA_{$i}"]["id_sol_credito_dato"] : ""?>" >
                    </div>
                </div>
            </div>
            
            <?php
        }
        
        ?>
             
        <div class="row justify-content-center">
            
            <div class="col-12">
                <h4 class="title text-left font-weight-bold">
                    CONTACTOS INTERNOS CON EL CLIENTE
                </h4>
            </div>
        </div>
        
        <div class="row">
            
            <div class="col-md-12">
                <div class="form-group">
                    <label class="bmd-label-floating">Encargado de compras</label>
                    <input type="text" class="form-control" <?php print $boolConsolidado ? "readonly" : ""?> name="txtEncargadoCompras" autocomplete="off" value="<?php print isset($arrSolCreditoDato["ENCARGADO_COMPRAS"]) ? $arrSolCreditoDato["ENCARGADO_COMPRAS"]["valor_input"] : ""?>" >
                    <input type="hidden" name="hidEncargadoComprasKey" value="<?php print isset($arrSolCreditoDato["ENCARGADO_COMPRAS"]) ? $arrSolCreditoDato["ENCARGADO_COMPRAS"]["id_sol_credito_dato"] : ""?>" >
                </div>
            </div>
            
        </div>
        
        <div class="row">
            
            <div class="col-md-12">
                <div class="form-group">
                    <label class="bmd-label-floating">Encargado de pagos</label>
                    <input type="text" class="form-control" <?php print $boolConsolidado ? "readonly" : ""?> name="txtEncargadoPagos" autocomplete="off" value="<?php print isset($arrSolCreditoDato["ENCARGADO_PAGOS"]) ? $arrSolCreditoDato["ENCARGADO_PAGOS"]["valor_input"] : ""?>" >
                    <input type="hidden" name="hidEncargadoPagosKey" value="<?php print isset($arrSolCreditoDato["ENCARGADO_PAGOS"]) ? $arrSolCreditoDato["ENCARGADO_PAGOS"]["id_sol_credito_dato"] : ""?>" >
                </div>
            </div>
            
        </div>
        
        <?php 
        
        if( false ){
            ?>
            <div class="row">
                
                <div class="col-md-6">
                    
                    <label class="bmd-label-floating">Formas de Pago</label>
                    <input type="hidden" name="hidFormaPagoKey" value="<?php print isset($arrSolCreditoDato["FORMA_PAGO"]) ? $arrSolCreditoDato["FORMA_PAGO"]["id_sol_credito_dato"] : ""?>" >
                    <br>
                    <?php
                                    
                    $arrFormaPago = utils::getFormaPago();
                    while( $rTMP = each($arrFormaPago) ){
                        $strSelected = isset($arrSolCreditoDato["FORMA_PAGO"]) && $arrSolCreditoDato["FORMA_PAGO"]["valor_input"] == $rTMP["key"] ? "checked" : "";
                        ?>
                        <div class="form-check form-check-inline">

                            <label class="form-check-label" for="rdFormaPago_<?php print $rTMP["key"]?>">
                                <input class="form-check-input" <?php print $boolConsolidado ? "disabled" : ""?>  <?php print $strSelected?> type="radio" name="rdFormaPago" id="rdFormaPago_<?php print $rTMP["key"]?>" value="<?php print $rTMP["key"]?>">
                                <span class="circle">
                                    <span class="check"></span>
                                </span>
                                <?php print $rTMP["value"]["nombre"]?>
                            </label>
                        </div>
                        <?php
                    }
                    
                    ?>
                    
                </div>
                
            </div>
            
            <div class="row">
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="bmd-label-floating">Plazo del credito</label>
                        <input type="text" class="form-control" <?php print $boolConsolidado ? "readonly" : ""?>  name="txtPlazoCredito" autocomplete="off" value="<?php print isset($arrSolCreditoDato["PLAZO_CREDITO"]) ? $arrSolCreditoDato["PLAZO_CREDITO"]["valor_input"] : ""?>" >
                        <input type="hidden" name="hidPlazoCreditoKey" value="<?php print isset($arrSolCreditoDato["PLAZO_CREDITO"]) ? $arrSolCreditoDato["PLAZO_CREDITO"]["id_sol_credito_dato"] : ""?>" >
                    </div>
                </div>
                
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="bmd-label-floating">Dias</label>
                        <input type="text" class="form-control" <?php print $boolConsolidado ? "readonly" : ""?> name="txtPlazoDias" autocomplete="off" value="<?php print isset($arrSolCreditoDato["PLAZO_DIAS"]) ? $arrSolCreditoDato["PLAZO_DIAS"]["valor_input"] : ""?>" >
                        <input type="hidden" name="hidPlazoCreditoKey" value="<?php print isset($arrSolCreditoDato["PLAZO_DIAS"]) ? $arrSolCreditoDato["PLAZO_DIAS"]["id_sol_credito_dato"] : ""?>" >
                    </div>
                </div>
                
            </div>
            
            <?php
        }
        
        ?>        
            
        
        
        </form>
        <script>    
        
            $(document).ready(function () {
                
            });
            
            function fntShowSolCreditoFormBloque1(){
                
                $.ajax({
                    url: "<?= base_url ?>cliente/&showSolCreditoFormBloque1=true&credito=<?php print $intSolCredito?>",
                    success: function (result) {

                        $("#divContainerPrincipal").html(result);
                        
                    }
                });
                
                
            }
        
            function fntShowSolCreditoFormBloque3(){
                
                $.ajax({
                    url: "<?= base_url ?>cliente/&showSolCreditoFormBloque3=true&credito=<?php print $intSolCredito?>",
                    success: function (result) {

                        $("#divContainerPrincipal").html(result);
                        
                    }
                });
                
                
            }
            
            function fntSaveCreditoBloque3(){
                
                $(".mlCargando").fadeIn();
                var formData = new FormData(document.getElementById("frmCreditoBloque3"));

                $.ajax({
                    url: "<?= base_url ?>cliente/&setCreditoBloque3=true",
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function (result) {
                        
                        $(".mlCargando").fadeOut();        
                        if ( !result["error"] ) {

                            md.showCustomNotification('top', 'right', "success", result["msg"]);
                            
                            fntShowSolCreditoFormBloque3();

                        } else {
                            md.showCustomNotification('top', 'right', "error", "Error");    
                        }
                        

                    },
                    error: function (result) {

                        $(".mlCargando").fadeOut();
                        md.showCustomNotification('top', 'right', "error", "Error");

                    }
                });
                
            }
        
        </script>
        <?php
        
    }
    
    public function fntSolCreditoFormBloque3($intCliente, $arrCredito, $arrCreditoDato = array(), $boolConsolidado = false){
        
        $boolClientePotencial = $arrSolCredito["cliente_potencial"] == "Y" ? true : false;
        ?>
        <form method="POST" onsubmit="return false;" enctype="multipart/form-data" id="frmCreditoBloque1" autocomplete="off">
        <input type="hidden" name="hidSolCredito" value="<?php print $intCliente?>">
        <?php
        
        if( !$boolConsolidado ){
            ?>
            <div class="row justify-content-center">
            
                <div class="col-md-6 col-xs-12 mt-0">
                    <h4 class="title text-center mt-0 mb-0 font-weight-bold">
                        <?php
                        
                        if( $boolClientePotencial ){
                            ?>
                            Cliente Potencial #<?php print $intSolCredito?> Formulario 03-F02
                            <?php
                        }
                        else{
                            ?>
                            Alta de Cliente #<?php print $intSolCredito?> Formulario 03-F02
                            <?php
                        }
                        ?>
                    </h4>

                    <div class="progress progress-line-info mt-0 mb-0">
                        <div class="progress-bar progress-bar-info mt-0 mb-0" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                            <span class="sr-only">50%</span>
                        </div>
                    </div>

                </div>
                
            </div>
            
            <div class="row">
                
                <div class="col-md-12 text-center mt-4">
                    <button onclick="fntShowSolCreditoFormBloque2();" class="btn btn-fill btn-info">
                        
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp;&nbsp; Anterior
                    </button>
                    <button onclick="fntSaveCreditoBloque1();" class="btn btn-fill btn-info">
                        Siguiente &nbsp;&nbsp; <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </button>
                </div>            
            </div>
                
            <?php
        }
        
        if( !$boolConsolidado && !empty($arrCredito["nota_rechazo"]) ){
            ?>
            <div class="row justify-content-center">
                
                <div class="col-12 ">
                    
                    <small class="title text-left font-weight-bold ">
                        Nota de Rechazo:
                    </small>
                    <br>
                    <small class="title text-left font-weight-bold  text-danger">
                        <?php print $arrCredito["nota_rechazo"]?>
                    </small>
                    <br>
                    <small class="title text-left font-weight-bold ">
                        Completa los pasos y envia el formulario
                    </small>
                    
                </div>
            </div>
            
            <?php    
        }
        
        $intPaisAsesor = $this->objModel->getUsuarioPais($arrCredito["id_usuario_asesor"]);
        $arrEstado = $this->objModel->getEstado($intPaisAsesor);
        
        ?>
        <div class="row justify-content-center">
            
            <div class="col-12">
                <h4 class="title text-left font-weight-bold">
                    DATOS PERSONALES DE REPRESENTANTE LEGAL
                </h4>
                
            </div>
        </div>
        
        
        <div class="row">
            
            <div class="col-md-3">
                <div class="form-group">
                    <label class="bmd-label-floating">Primer Nombre</label>
                    <input type="text" <?php print $boolConsolidado ? "readonly" : ""?> class="form-control" name="txtPrimerNombre" autocomplete="off" value="<?php print isset($arrCreditoDato["PRIMER_NOMBRE"]) ? $arrCreditoDato["PRIMER_NOMBRE"]["valor_input"] : ""?>" >
                    <input type="hidden" name="hidPrimerNombreKey" value="<?php print isset($arrCreditoDato["PRIMER_NOMBRE"]) ? $arrCreditoDato["PRIMER_NOMBRE"]["id_sol_credito_dato"] : ""?>" >
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="form-group">
                    <label class="bmd-label-floating">Segundo Nombre</label>
                    <input type="text" <?php print $boolConsolidado ? "readonly" : ""?> class="form-control" name="txtSegundoNombre" autocomplete="off" value="<?php print isset($arrCreditoDato["SEGUNDO_NOMBRE"]) ? $arrCreditoDato["SEGUNDO_NOMBRE"]["valor_input"] : ""?>" >
                    <input type="hidden" name="hidSegundoNombreKey" value="<?php print isset($arrCreditoDato["SEGUNDO_NOMBRE"]) ? $arrCreditoDato["SEGUNDO_NOMBRE"]["id_sol_credito_dato"] : ""?>" >
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="form-group">
                    <label class="bmd-label-floating">Primer Apellido</label>
                    <input type="text" <?php print $boolConsolidado ? "readonly" : ""?> class="form-control" name="txtPrimerApellido" autocomplete="off" value="<?php print isset($arrCreditoDato["PRIMER_APELLIDO"]) ? $arrCreditoDato["PRIMER_APELLIDO"]["valor_input"] : ""?>" >
                    <input type="hidden" name="hidPrimerApellidoKey" value="<?php print isset($arrCreditoDato["PRIMER_APELLIDO"]) ? $arrCreditoDato["PRIMER_APELLIDO"]["id_sol_credito_dato"] : ""?>" >
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="form-group">
                    <label class="bmd-label-floating">Segundo Apellido</label>
                    <input type="text" <?php print $boolConsolidado ? "readonly" : ""?> class="form-control" name="txtSegundoApellido" autocomplete="off" value="<?php print isset($arrCreditoDato["SEGUNDO_APELLIDO"]) ? $arrCreditoDato["SEGUNDO_APELLIDO"]["valor_input"] : ""?>" >
                    <input type="hidden" name="hidSegundoApellidoKey" value="<?php print isset($arrCreditoDato["SEGUNDO_APELLIDO"]) ? $arrCreditoDato["SEGUNDO_APELLIDO"]["id_sol_credito_dato"] : ""?>" >
                </div>
            </div>
                        
        </div>
        
        <div class="row">
            
            <div class="col-md-3">
                <div class="form-group">
                    <label class="bmd-label-floating">Apellido Casada</label>
                    <input type="text" <?php print $boolConsolidado ? "readonly" : ""?> class="form-control" name="txtApellidoCasada" autocomplete="off" value="<?php print isset($arrCreditoDato["APELLIDO_CASADA"]) ? $arrCreditoDato["APELLIDO_CASADA"]["valor_input"] : ""?>" >
                    <input type="hidden" name="hidApellidoCasadaKey" value="<?php print isset($arrCreditoDato["APELLIDO_CASADA"]) ? $arrCreditoDato["APELLIDO_CASADA"]["id_sol_credito_dato"] : ""?>" >
                </div>
            </div>
            
            <div class="col-md-6">
                
                
                <label class="bmd-label-floating">Estado Civil</label>
                <input type="hidden" name="hidEstadoCivilKey" value="<?php print isset($arrCreditoDato["ESTADO_CIVIL"]) ? $arrCreditoDato["ESTADO_CIVIL"]["id_sol_credito_dato"] : ""?>" >
                <br>
                <?php
                                
                $arrEstadoCivil = utils::getEstadoCivil();
                while( $rTMP = each($arrEstadoCivil) ){
                    $strSelected = isset($arrCreditoDato["ESTADO_CIVIL"]) && $arrCreditoDato["ESTADO_CIVIL"]["valor_input"] == $rTMP["key"] ? "checked" : "";
                    ?>
                    <div class="form-check form-check-inline">

                        <label class="form-check-label" for="rdEstadoCivil_<?php print $rTMP["key"]?>">
                            <input class="form-check-input " <?php print $boolConsolidado ? "disabled" : ""?> <?php print $strSelected?>  type="radio" name="rdEstadoCivil" id="rdEstadoCivil_<?php print $rTMP["key"]?>" value="<?php print $rTMP["key"]?>">
                            <span class="circle">
                                <span class="check"></span>
                            </span>
                            <?php print $rTMP["value"]["nombre"]?>
                        </label>
                    </div>
                    <?php
                }
                
                ?>
                
                
            </div>
            
            <div class="col-md-3">
                <div class="form-group">
                    <label class=" ">Fecha Nacimiento</label>
                    <input type="text" <?php print $boolConsolidado ? "readonly" : ""?> class="form-control datepicker " name="txtFechaNacimiento" autocomplete="off" value="<?php print isset($arrCreditoDato["FECHA_NACIMIENTO"]) ? $arrCreditoDato["FECHA_NACIMIENTO"]["valor_input"] : ""?>" >
                    <input type="hidden" name="hidFechaNacimientoKey" value="<?php print isset($arrCreditoDato["FECHA_NACIMIENTO"]) ? $arrCreditoDato["FECHA_NACIMIENTO"]["id_sol_credito_dato"] : ""?>" >
                </div>
            </div>
        
        </div>
        
        <div class="row">
            
            <div class="col-md-3">
                <div class="form-group">
                    <label class="bmd-label-floating">DPI ó Pasaporte</label>
                    <input type="text" <?php print $boolConsolidado ? "readonly" : ""?> class="form-control" name="txtDpiPasaporte" autocomplete="off" value="<?php print isset($arrCreditoDato["DPI_PASAPORTE"]) ? $arrCreditoDato["DPI_PASAPORTE"]["valor_input"] : ""?>" >
                    <input type="hidden" name="hidDpiPasaporteKey" value="<?php print isset($arrCreditoDato["DPI_PASAPORTE"]) ? $arrCreditoDato["DPI_PASAPORTE"]["id_sol_credito_dato"] : ""?>" >
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="form-group">
                    <label class="bmd-label-floating">Extendido en</label>
                    <input type="text" <?php print $boolConsolidado ? "readonly" : ""?> class="form-control" name="txtDpiPasaporteExtendido" autocomplete="off" value="<?php print isset($arrCreditoDato["DPI_PASAPORTE_EXTENDIDO"]) ? $arrCreditoDato["DPI_PASAPORTE_EXTENDIDO"]["valor_input"] : ""?>" >
                    <input type="hidden" name="hidDpiPasaporteExtendidoKey" value="<?php print isset($arrCreditoDato["DPI_PASAPORTE_EXTENDIDO"]) ? $arrCreditoDato["DPI_PASAPORTE_EXTENDIDO"]["id_sol_credito_dato"] : ""?>" >
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="form-group">
                    <label class="bmd-label-floating">No. Telefono</label>
                    <input type="tel" <?php print $boolConsolidado ? "readonly" : ""?> class="form-control" name="txtNoTelefono" autocomplete="off" value="<?php print isset($arrCreditoDato["NO_TELEFONO"]) ? $arrCreditoDato["NO_TELEFONO"]["valor_input"] : ""?>" >
                    <input type="hidden" name="hidNoTelefonoKey" value="<?php print isset($arrCreditoDato["NO_TELEFONO"]) ? $arrCreditoDato["NO_TELEFONO"]["id_sol_credito_dato"] : ""?>" >
                </div>
            </div>
        
        </div>
        
        <div class="row">
            
            
            <div class="col-md-12">
                <div class="form-group">
                    <label class="bmd-label-floating">Direccion Completa de su Residencia</label>
                    <textarea <?php print $boolConsolidado ? "readonly" : ""?> class="form-control" name="txtDireccionCompleta" autocomplete="off"><?php print isset($arrCreditoDato["DIRECCION"]) ? $arrCreditoDato["DIRECCION"]["valor_input"] : ""?></textarea>
                    <input type="hidden" name="hidDireccionCompletaKey" value="<?php print isset($arrCreditoDato["DIRECCION"]) ? $arrCreditoDato["DIRECCION"]["id_sol_credito_dato"] : ""?>" >
                </div>
            </div>
            
            <div class="col-md-6">
            
                <label class="bmd-label-floating">Departamento</label>
                <input type="hidden" name="slcDepartamentoKey" value="<?php print isset($arrCreditoDato["DIRECCION_DEPARTAMENTO"]) ? $arrCreditoDato["DIRECCION_DEPARTAMENTO"]["id_sol_credito_dato"] : ""?>" >
                <select name="slcDepartamento" id="slcDepartamento" <?php print $boolConsolidado ? "disabled" : ""?>  class="selectpicker" data-style="select-with-transition" title="Departamento" data-size="<?php print count($arrEstado) / 2?>" onchange="fntDrawCiudad();">
                    <?php
                    
                    while( $rTMP = each($arrEstado) ){
                        $strSelected = isset($arrCreditoDato["DIRECCION_DEPARTAMENTO"]) && $arrCreditoDato["DIRECCION_DEPARTAMENTO"]["valor_input"] == $rTMP["key"] ? "selected" : "";
                        ?>
                        <option <?php print $strSelected;?> value="<?php print $rTMP["key"]?>"><?php print $rTMP["value"]["nombre"]?></option>
                        <?php
                    }
                    
                    ?>
                </select>
                
            </div>
            
            <div class="col-md-6">
                
                <label class="bmd-label-floating">Ciudad</label>
                <input type="hidden" name="slcCiudadKey" value="<?php print isset($arrCreditoDato["DIRECCION_CIUDAD"]) ? $arrCreditoDato["DIRECCION_CIUDAD"]["id_sol_credito_dato"] : ""?>" >
                <div id="divFormCiudad">
                    <select name="slcCiudad" class="selectpicker" data-style="select-with-transition" title="Ciudad" data-size="0">
                    </select>
                </div>
            </div>
            
                        
        </div>
        
        </form>
        <script>    
        
            $(document).ready(function () {
                
                $('.datepicker').datetimepicker({
                    format: 'DD/MM/YYYY',
                    icons: {
                        time: "fa fa-clock-o",
                        date: "fa fa-calendar",
                        up: "fa fa-chevron-up",
                        down: "fa fa-chevron-down",
                        previous: 'fa fa-chevron-left',
                        next: 'fa fa-chevron-right',
                        today: 'fa fa-screenshot',
                        clear: 'fa fa-trash',
                        close: 'fa fa-remove'
                    }
                });
                
                <?php 
                
                if( isset($arrCreditoDato["DIRECCION_CIUDAD"]) ){
                    ?>
                    fntDrawCiudad();
                    <?php
                }
                
                ?>
                    
            });
            
            function fntShowSolCreditoFormBloque2(){
                
                $.ajax({
                    url: "<?= base_url ?>cliente/&showSolCreditoFormBloque2=true&credito=<?php print $intCliente?>",
                    success: function (result) {

                        $("#divContainerPrincipal").html(result);
                        
                    }
                });
                
                
            }
        
            function fntShowSolCreditoFormBloque4(){
                
                $.ajax({
                    url: "<?= base_url ?>cliente/&showSolCreditoFormBloque4=true&credito=<?php print $intCliente?>",
                    success: function (result) {

                        $("#divContainerPrincipal").html(result);
                        
                    }
                });
                
                
            }
        
            function fntSaveCreditoBloque1(){
                
                $(".mlCargando").fadeIn();
                var formData = new FormData(document.getElementById("frmCreditoBloque1"));

                $.ajax({
                    url: "<?= base_url ?>cliente/&setCreditoBloque1=true",
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function (result) {
                        
                        $(".mlCargando").fadeOut();        
                        if ( !result["error"] ) {

                            md.showCustomNotification('top', 'right', "success", result["msg"]);
                            
                            fntShowSolCreditoFormBloque4();

                        } else {
                            md.showCustomNotification('top', 'right', "error", "Error");    
                        }
                        

                    },
                    error: function (result) {

                        $(".mlCargando").fadeOut();
                        md.showCustomNotification('top', 'right', "error", "Error");

                    }
                });
                
            }
            
            function fntDrawCiudad(){
                
                $.ajax({
                    url: "<?= base_url ?>cliente/&drawCiudad=true&ciudad=<?php print isset($arrCreditoDato["DIRECCION_CIUDAD"]) ? $arrCreditoDato["DIRECCION_CIUDAD"]["valor_input"] : 0; ?>&departamento="+$("#slcDepartamento").val(),
                    success: function (result) {

                        $("#divFormCiudad").html(result);
                        
                    }
                });    
                
            }
                
        </script>
        <?php
        
    }
    
    public function fntSolCreditoFormBloque4($intSolCredito, $arrSolCredito, $arrSolCreditoDato = array(), $boolConsolidado = false){
        
        $boolClientePotencial = $arrSolCredito["cliente_potencial"] == "Y" ? true : false;
        $strPDFConvenio = utils::getPDFConvenioLeterago($arrSolCredito, $arrSolCreditoDato);
        ?>
        <style> 
            .fileinput .thumbnail {
                display: inline-block;
                margin-bottom: 10px;
                overflow: hidden;
                text-align: center;
                vertical-align: middle;
                max-width: 100%;
                box-shadow: 0 10px 30px -12px rgb(0 0 0 / 42%), 0 4px 25px 0px rgb(0 0 0 / 12%), 0 8px 10px -5px rgb(0 0 0 / 20%);
            }
        </style>
        <form method="POST" onsubmit="return false;" enctype="multipart/form-data" id="frmCreditoBloque4" autocomplete="off">
        <input type="hidden" name="hidSolCredito" value="<?php print $intSolCredito?>">
        
        <?php
        
        if( !$boolConsolidado ){
            ?>
            <div class="row justify-content-center">
                
                <div class="col-md-6 col-xs-12 mt-0">
                    <h4 class="title text-center mt-0 mb-0 font-weight-bold">
                        <?php
                        
                        if( $boolClientePotencial ){
                            ?>
                            Cliente Potencial #<?php print $intSolCredito?> Formulario 03-F02
                            <?php
                        }
                        else{
                            ?>
                            Alta de Cliente #<?php print $intSolCredito?> Formulario 03-F02
                            <?php
                        }
                        ?>
                    </h4>

                    <div class="progress progress-line-info mt-0 mb-0">
                        <div class="progress-bar progress-bar-info mt-0 mb-0" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 75%;">
                            <span class="sr-only">75%</span>
                        </div>
                    </div>

                </div>
                
            </div>
            <div class="row">
                
                <div class="col-md-12 text-center mt-4">
                    <button onclick="fntShowSolCreditoFormBloque3();" class="btn btn-fill btn-info">
                        
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp;&nbsp; ANTERIROR
                    </button>
                    <button onclick="fntShowSolCreditoFormBloque5();" class="btn btn-fill btn-info ">
                        SIGUIENTE <small> Aceptar LOS TERMINOS </small>
                        &nbsp;&nbsp;
                        <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </button>
                </div>            
            </div>
            <?php
        }
        
        if( !$boolConsolidado && !empty($arrSolCredito["nota_rechazo"]) ){
            ?>
            <div class="row justify-content-center">
                
                <div class="col-12 ">
                    
                    <small class="title text-left font-weight-bold ">
                        Nota de Rechazo:
                    </small>
                    <br>
                    <small class="title text-left font-weight-bold  text-danger">
                        <?php print $arrSolCredito["nota_rechazo"]?>
                    </small>
                    <br>
                    <small class="title text-left font-weight-bold ">
                        Completa los pasos y envia el formulario
                    </small>
                    
                </div>
            </div>
            
            <?php    
        }
        
        ?>
        
        
        
        <div class="row justify-content-center">
            
            <div class="col-12">
                <h4 class="title text-left font-weight-bold">
                    CONVENIO
                </h4>
            </div>
        </div>
        
        
        <div class="row justify-content-center">
            
            <div class="col-12 text-center">
                <iframe
                 src="data:application/pdf;base64,<?php print base64_encode($strPDFConvenio)?>"
                 width=100% height=600></iframe>                          
            </div>
        </div>
        
        </form>
        <script> 
        
            function fntShowSolCreditoFormBloque3(){
                
                $.ajax({
                    url: "<?= base_url ?>cliente/&showSolCreditoFormBloque3=true&credito=<?php print $intSolCredito?>",
                    success: function (result) {

                        $("#divContainerPrincipal").html(result);
                        
                    }
                });
                
                
            }
            
            function fntShowSolCreditoFormBloque5(){
                
                $.ajax({
                    url: "<?= base_url ?>cliente/&showSolCreditoFormBloque5=true&credito=<?php print $intSolCredito?>",
                    success: function (result) {

                        $("#divContainerPrincipal").html(result);
                        
                    }
                });
                
                
            }
        
        </script>
        <?php
        
    }
    
    public function fntSolCreditoFormBloque5($intSolCredito, $arrSolCredito, $arrSolCreditoDato = array(), $boolConsolidado = false){
        
        $boolCliente = $_SESSION["leterago"]["tipo"] == "CL";
        $boolClientePotencial = $arrSolCredito["cliente_potencial"] == "Y" ? true : false;                    
        ?>
        <style> 
            .fileinput .thumbnail {
                display: inline-block;
                margin-bottom: 10px;
                overflow: hidden;
                text-align: center;
                vertical-align: middle;
                max-width: 100%;
                box-shadow: 0 10px 30px -12px rgb(0 0 0 / 42%), 0 4px 25px 0px rgb(0 0 0 / 12%), 0 8px 10px -5px rgb(0 0 0 / 20%);
            }
        </style>
        <form method="POST" onsubmit="return false;" enctype="multipart/form-data" id="frmCreditoBloque4" autocomplete="off">
        <input type="hidden" name="hidSolCredito" value="<?php print $intSolCredito?>">
        
        <?php
        
        if( !$boolConsolidado && $boolCliente ){
            ?>
            <div class="row justify-content-center">
                
                <div class="col-md-6 col-xs-12 mt-0">
                    <h4 class="title text-center mt-0 mb-0 font-weight-bold">
                        <?php
                        
                        if( $boolClientePotencial ){
                            ?>
                            Cliente Potencial #<?php print $intSolCredito?> Formulario 03-F02
                            <?php
                        }
                        else{
                            ?>
                            Alta de Cliente #<?php print $intSolCredito?> Formulario 03-F02
                            <?php
                        }
                        ?>
                    </h4>

                    <div class="progress progress-line-info mt-0 mb-0">
                        <div class="progress-bar progress-bar-info mt-0 mb-0" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                            <span class="sr-only">100%</span>
                        </div>
                    </div>

                </div>
                
            </div>
            <div class="row">
                
                <div class="col-md-12 text-center mt-4">
                    <button onclick="fntShowSolCreditoFormBloque4();" class="btn btn-fill btn-info">
                        
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp;&nbsp; Paso 4
                    </button>
                    <button onclick="fntSaveCreditoBloque5();" class="btn btn-fill btn-success">
                        Envia Formulario

                    </button>
                </div>            
            </div>
            <?php
        }
        
        if( !$boolConsolidado && !empty($arrSolCredito["nota_rechazo"]) ){
            ?>
            <div class="row justify-content-center">
                
                <div class="col-12 ">
                    
                    <small class="title text-left font-weight-bold ">
                        Nota de Rechazo:
                    </small>
                    <br>
                    <small class="title text-left font-weight-bold  text-danger">
                        <?php print $arrSolCredito["nota_rechazo"]?>
                    </small>
                    <br>
                    <small class="title text-left font-weight-bold ">
                        Completa los pasos y envia el formulario
                    </small>
                    
                </div>
            </div>
            
            <?php    
        }
        
        ?>
        
        <div class="row justify-content-center">
            
            <div class="col-12 text-center <?php print $boolCliente ? "" : "p-4"?>">
                        
                        
                <div class="row justify-content-center ">
                    
                    <div class="col-12">
                        
                        <?php
                        
                        if( $boolConsolidado ){
                            ?>
                            <img id="imgFirmaEdit" src="<?php print isset($arrSolCreditoDato["FIRMA_URL"]) ? base_url."".$arrSolCreditoDato["FIRMA_URL"]["valor_input"] : base_url."assets/img/image_placeholder.jpg"?>" style="border: 1px solid black;">
                            <?php
                        }
                        elseif( $boolCliente ){
                            ?>
                            <input type="hidden" name="hidTipoFirma" id="hidTipoFirma" value="D">
                            
                            <ul class="nav nav-pills nav-pills-info" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active show" data-toggle="tab" href="#link1" role="tablist" onclick=" $('#hidTipoFirma').val('D') ">
                                        Dibujar Firma
                                    </a>
                                    </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#link2" role="tablist" onclick=" $('#hidTipoFirma').val('A') ">
                                        Adjuntar Firma
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content tab-space">
                                <div class="tab-pane active show" id="link1">
                                    
                                    <script src="<?= base_url ?>assets/signature_pad/signature_pad.js"></script>
                                    <canvas id="cvFirma" style="border: 1px solid black; <?php print isset($arrSolCreditoDato["FIRMA_URL"] ) ? "display: none;" : ""?>"></canvas>
                                    
                                    <?php 
                                    
                                    if( isset($arrSolCreditoDato["FIRMA_URL"] ) ){
                                        ?>
                                        <img id="imgFirmaEdit" src="<?php print isset($arrSolCreditoDato["FIRMA_URL"]) ? base_url."".$arrSolCreditoDato["FIRMA_URL"]["valor_input"] : base_url."assets/img/image_placeholder.jpg"?>" style="border: 1px solid black;">
                                        
                                        
                                        <?php
                                        if( !$boolConsolidado ){
                                            ?>
                                            <br>
                                            <button id="btnEditarFirma" onclick="fntEditarFirma();" class="btn btn-fill btn-info">
                                                Editar Firma
                                            </button>
                                            <?php
                                        }
                                        
                                    }
                                    
                                    ?>
                                    
                                    
                                    
                                </div>
                                <div class="tab-pane" id="link2">
                                    <div class="row justify-content-center">
                                        <div class="col-md-6">
                                            <h5 class="title text-center font-weight-bold">
                                                Firma por Imagen
                                                <br>
                                                <small>Sube una imagen con fondo blanco, utiliza lapicero NEGRO<small>
                                            </h5>
                                        </div>    
                                    </div>    
                                    <div class="row justify-content-center">
                                        <div class="col-md-6">
                                                                                       
                                            
                                                
                                            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                
                                                <div class="fileinput-preview fileinput-exists thumbnail">
                                                    <img src="<?php print isset($arrSolCreditoDato["FIRMA_URL"]) ? base_url."".$arrSolCreditoDato["FIRMA_URL"]["valor_input"] : base_url."assets/img/image_placeholder.jpg"?>" alt="...">
                                                </div>
                                                <?php
                                                
                                                if( !$boolConsolidado ){
                                                    ?>
                                                    <div>
                                                        <span class="btn btn-info btn-round btn-file" style="text-align: center;">
                                                            <span class="fileinput-new" data-dismiss="fileinput___">Seleccionar Imagen</span>
                                                            <span class="fileinput-exists">Cambiar</span>
                                                            <input type="file" name="flFirma">
                                                        </span>
                                                    </div>
                                                    <?php
                                                }
                                                
                                                ?>
                                                    
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <?php
                        }
                        
                        ?>
                        
                        
                    </div>
                </div>
                
                <div class="row justify-content-center ">
                    
                    <div class="col-12">
                        <h4 class="title text-left font-weight-bold">
                            DOCUMENTOS ADJUNTOS
                        </h4>
                    </div>
                </div>
                
                <div class="row justify-content-center mt-0 pt-0">
                    
                    <div class="col-md-4 col-sm-12 col-12 p-2 mt-0 pt-0">
                        
                        <h5 class="title text-center font-weight-bold">
                            Cédula de identidad del dueño o representante legal del negocio.
                        </h5>
                        
                            
                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                            
                            <div class="fileinput-preview fileinput-exists thumbnail">
                                <img src="<?php print isset($arrSolCreditoDato["CEDULA_REPRESENTANTE_LEGAL"]) ? base_url."".$arrSolCreditoDato["CEDULA_REPRESENTANTE_LEGAL"]["valor_input"] : base_url."assets/img/image_placeholder.jpg"?>" alt="...">
                            </div>
                            <?php
                            
                            if( !$boolConsolidado ){
                                ?>
                                <div>
                                    <span class="btn btn-info btn-round btn-file">
                                        <span class="fileinput-new" data-dismiss="fileinput___">Seleccionar Imagen</span>
                                        <span class="fileinput-exists">Cambiar</span>
                                        <input type="file" name="flCEDULA_REPRESENTANTE_LEGAL" accept="image/*" />
                                    </span>
                                </div>
                                <?php
                            }
                            
                            ?>
                                
                        </div>

                    </div>
                    
                    <div class="col-md-4 col-sm-12 col-12 p-2 mt-0 pt-0">
                        
                        <h5 class="title text-center font-weight-bold">
                            Nombramiento de representante legal (en caso de persona jurídica).
                        </h5>
                            
                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                            
                            <div class="fileinput-preview fileinput-exists thumbnail">
                                <img src="<?php print isset($arrSolCreditoDato["NOMBRAMIENTO_LEGAL"]) ? base_url."".$arrSolCreditoDato["NOMBRAMIENTO_LEGAL"]["valor_input"] : base_url."assets/img/image_placeholder.jpg"?>" alt="...">
                            </div>
                            <?php
                            
                            if( !$boolConsolidado ){
                                ?>
                                <div>
                                    <span class="btn btn-info btn-round btn-file" style="text-align: center;">
                                        <span class="fileinput-new" data-dismiss="fileinput___">Seleccionar Imagen</span>
                                        <span class="fileinput-exists">Cambiar</span>
                                        <input type="file" name="flNOMBRAMIENTO_LEGAL" accept="image/*" />
                                    </span>
                                </div>
                                <?php
                            }
                            
                            ?>
                                
                        </div>

                    </div>
                      
                    <div class="col-md-4 col-sm-12 col-12 p-2 mt-0 pt-0">
                        
                        <h5 class="title text-center font-weight-bold">
                            Documento de identificación de persona jurídica
                        </h5>
                            
                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                            
                            <div class="fileinput-preview fileinput-exists thumbnail">
                                <img src="<?php print isset($arrSolCreditoDato["DPI_PERSONA_JUDIRICA"]) ? base_url."".$arrSolCreditoDato["DPI_PERSONA_JUDIRICA"]["valor_input"] : base_url."assets/img/image_placeholder.jpg"?>" alt="...">
                            </div>
                            <?php
                            
                            if( !$boolConsolidado ){
                                ?>
                                <div>
                                    <span class="btn btn-info btn-round btn-file" style="text-align: center;">
                                        <span class="fileinput-new" data-dismiss="fileinput___">Seleccionar Imagen</span>
                                        <span class="fileinput-exists">Cambiar</span>
                                        <input type="file" name="flDPI_PERSONA_JUDIRICA" accept="image/*" />
                                    </span>
                                </div>
                                <?php
                            }
                            
                            ?>
                                
                        </div>

                    </div>
                </div>
                
                <div class="row justify-content-center mt-0 pt-0">
                         
                    <div class="col-md-4 col-sm-12 col-12 p-2 mt-0 pt-0">
                        
                        <h5 class="title text-center font-weight-bold">
                            Permiso de operaciones del negocio (según requisito legal en el país)
                        </h5>
                            
                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                            
                            <div class="fileinput-preview fileinput-exists thumbnail">
                                <img src="<?php print isset($arrSolCreditoDato["PERMISO_OPERACIONES"]) ? base_url."".$arrSolCreditoDato["PERMISO_OPERACIONES"]["valor_input"] : base_url."assets/img/image_placeholder.jpg"?>" alt="...">
                            </div>
                            <?php
                            
                            if( !$boolConsolidado ){
                                ?>
                                <div>
                                    <span class="btn btn-info btn-round btn-file" style="text-align: center;">
                                        <span class="fileinput-new" data-dismiss="fileinput___">Seleccionar Imagen</span>
                                        <span class="fileinput-exists">Cambiar</span>
                                        <input type="file" name="flPERMISO_OPERACIONES" accept="image/*" />
                                    </span>
                                </div>
                                <?php
                            }
                            
                            ?>
                                
                        </div>

                    </div>
                       
                    <div class="col-md-4 col-sm-12 col-12 p-2 mt-0 pt-0">
                        
                        <h5 class="title text-center font-weight-bold">
                            Licencia sanitaria vigente (según requisito legal en el país)
                        </h5>
                            
                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                            
                            <div class="fileinput-preview fileinput-exists thumbnail">
                                <img src="<?php print isset($arrSolCreditoDato["LICENCIA_SANITARIA"]) ? base_url."".$arrSolCreditoDato["LICENCIA_SANITARIA"]["valor_input"] : base_url."assets/img/image_placeholder.jpg"?>" alt="...">
                            </div>
                            <?php
                            
                            if( !$boolConsolidado ){
                                ?>
                                <div>
                                    <span class="btn btn-info btn-round btn-file" style="text-align: center;">
                                        <span class="fileinput-new" data-dismiss="fileinput___">Seleccionar Imagen</span>
                                        <span class="fileinput-exists">Cambiar</span>
                                        <input type="file" name="flLICENCIA_SANITARIA" accept="image/*" />
                                    </span>
                                </div>
                                <?php
                            }
                            
                            ?>
                                
                        </div>

                    </div>
                        
                    <div class="col-md-4 col-sm-12 col-12 p-2 mt-0 pt-0">
                        
                        <h5 class="title text-center font-weight-bold">
                            Licencia del Regente (si es requisito legal en el país)
                        </h5>
                            
                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                            
                            <div class="fileinput-preview fileinput-exists thumbnail">
                                <img src="<?php print isset($arrSolCreditoDato["LICENCIA_REGENTE"]) ? base_url."".$arrSolCreditoDato["LICENCIA_REGENTE"]["valor_input"] : base_url."assets/img/image_placeholder.jpg"?>" alt="...">
                            </div>
                            <?php
                            
                            if( !$boolConsolidado ){
                                ?>
                                <div>
                                    <span class="btn btn-info btn-round btn-file" style="text-align: center;">
                                        <span class="fileinput-new" data-dismiss="fileinput___">Seleccionar Imagen</span>
                                        <span class="fileinput-exists">Cambiar</span>
                                        <input type="file" name="flLICENCIA_REGENTE" accept="image/*" />
                                    </span>
                                </div>
                                <?php
                            }
                            
                            ?>
                                
                        </div>

                    </div>
                </div>
                
                <div class="row justify-content-center mt-0 pt-0">
                      
                    <div class="col-md-4 col-sm-12 col-12 p-2 mt-0 pt-0">
                        
                        <h5 class="title text-center font-weight-bold">
                            Permiso para comercializar sustancias controladas (en caso de que desee comprar sustancias controladas)
                        </h5>
                            
                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                            
                            <div class="fileinput-preview fileinput-exists thumbnail">
                                <img src="<?php print isset($arrSolCreditoDato["PERMISO_COMERCIALIZAR_SUSTANCIAS_CONTROLADAS"]) ? base_url."".$arrSolCreditoDato["PERMISO_COMERCIALIZAR_SUSTANCIAS_CONTROLADAS"]["valor_input"] : base_url."assets/img/image_placeholder.jpg"?>" alt="...">
                            </div>
                            <?php
                            
                            if( !$boolConsolidado ){
                                ?>
                                <div>
                                    <span class="btn btn-info btn-round btn-file" style="text-align: center;">
                                        <span class="fileinput-new" data-dismiss="fileinput___">Seleccionar Imagen</span>
                                        <span class="fileinput-exists">Cambiar</span>
                                        <input type="file" name="flPERMISO_COMERCIALIZAR_SUSTANCIAS_CONTROLADAS" accept="image/*" />
                                    </span>
                                </div>
                                <?php
                            }
                            
                            ?>
                                
                        </div>

                    </div>
                        
                    <div class="col-md-4 col-sm-12 col-12 p-2 mt-0 pt-0">
                        
                        <h5 class="title text-center font-weight-bold">
                            Gestiona las coordenadas del cliente (geolocalización): ubicación principal y secundarias (si posee)
                        </h5>
                            
                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                            
                            <div class="fileinput-preview fileinput-exists thumbnail">
                                <img src="<?php print isset($arrSolCreditoDato["GESTIONA_COORDENADA"]) ? base_url."".$arrSolCreditoDato["GESTIONA_COORDENADA"]["valor_input"] : base_url."assets/img/image_placeholder.jpg"?>" alt="...">
                            </div>
                            <?php
                            
                            if( !$boolConsolidado ){
                                ?>
                                <div>
                                    <span class="btn btn-info btn-round btn-file" style="text-align: center;">
                                        <span class="fileinput-new" data-dismiss="fileinput___">Seleccionar Imagen</span>
                                        <span class="fileinput-exists">Cambiar</span>
                                        <input type="file" name="flGESTIONA_COORDENADA" accept="image/*" />
                                    </span>
                                </div>
                                <?php
                            }
                            
                            ?>
                                
                        </div>

                    </div>
                                
                </div>
                
                <?php
                
                if( $boolConsolidado ){
                    ?>
                    <div class="row justify-content-center ">
                    
                        <div class="col-12">
                            <button onclick="fntShowPasoDoc();" class="btn btn-fill btn-success">
                                Editar Documentos
                            </button>    
                            
                        </div>
                    </div>
                    <?php
                }
                
                
                if( !$boolCliente && !$boolConsolidado ){
                    ?>
                    <div class="row">
                        
                        <div class="col-md-12 text-center mt-4">
                            <button onclick="fntSaveCreditoBloqueDocs();" class="btn btn-fill btn-success">
                                Guardar Cambios
                            </button>
                        </div>            
                    </div>
                    <?php
                }
                
                ?>
                            
            </div>
            
        </div>
        
        </form>
        <script> 
        
            var canvas;
            var signaturePad;
            var boolCargarFirma = "<?php print isset($arrSolCreditoDato["FIRMA_URL"]) ? "false" : "true"?>";
            
            function fntEditarFirma(){
                boolCargarFirma = "true";
                
                $("#btnEditarFirma").hide();
                $("#imgFirmaEdit").hide();
                $("#cvFirma").show();
                
            }

            $(document).ready(function () {
        
                canvas = document.querySelector("canvas");

                signaturePad = new SignaturePad(canvas);

                // Returns signature image as data URL (see https://mdn.io/todataurl for the list of possible parameters)
                signaturePad.toDataURL(); // save image as PNG
                signaturePad.toDataURL("image/jpeg"); // save image as JPEG
                signaturePad.toDataURL("image/svg+xml"); // save image as SVG

                // Draws signature image from data URL.
                // NOTE: This method does not populate internal data structure that represents drawn signature. Thus, after using #fromDataURL, #toData won't work properly.
                //signaturePad.fromDataURL("data:image/png;base64,iVBORw0K...");

                // Returns signature image as an array of point groups
                const data = signaturePad.toData();

                // Draws signature image from an array of point groups
                signaturePad.fromData(data);

                // Clears the canvas
                signaturePad.clear();

                // Returns true if canvas is empty, otherwise returns false
                signaturePad.isEmpty();

                // Unbinds all event handlers
                signaturePad.off();

                // Rebinds all event handlers
                signaturePad.on();
            });    
            
            function getDataUrl(){
                
                var dataURL = signaturePad.toDataURL();
                
                console.log(dataURL);
                
            }   
        
            function fntShowSolCreditoFormBloque4(){
                
                $.ajax({
                    url: "<?= base_url ?>cliente/&showSolCreditoFormBloque4=true&credito=<?php print $intSolCredito?>",
                    success: function (result) {

                        $("#divContainerPrincipal").html(result);
                        
                    }
                });
                
                
            }
            
            function fntSaveCreditoBloque5(){
                
                $(".mlCargando").fadeIn();
                var formData = new FormData(document.getElementById("frmCreditoBloque4"));
                
                if( boolCargarFirma == "true" ){
                    
                    formData.append("dataFirma", signaturePad.toDataURL());    
                }

                $.ajax({
                    url: "<?= base_url ?>cliente/&setCreditoBloque4=true",
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function (result) {
                        
                        $(".mlCargando").fadeOut();        
                        if ( !result["error"] ) {

                            md.showCustomNotification('top', 'right', "success", result["msg"]);
                            
                            //divContainerPrincipal
                
                            $.ajax({
                                url: "<?= base_url ?>cliente/&drawIndexCliente=true",
                                success: function (result) {

                                    $("#divContainerPrincipal").html(result);
                                    
                                    
                                    
                                }
                            });
                            
                        } else {
                            md.showCustomNotification('top', 'right', "error", "Error");    
                        }
                        

                    },
                    error: function (result) {

                        $(".mlCargando").fadeOut();
                        md.showCustomNotification('top', 'right', "error", "Error");

                    }
                });
                
            }
            
            function fntShowPasoDoc(){
                
                $.ajax({
                    url: "<?= base_url ?>cliente/&showSolCreditoFormBloque5=true&credito=<?php print $intSolCredito?>",
                    success: function (result) {

                        $("#mlSolCreditoContent").html(result);
                        
                    }
                });               
            }
            
            function fntSaveCreditoBloqueDocs(){
                
                $("#mlSolCredito").modal("hide");
                
                $(".mlCargando").fadeIn();
                var formData = new FormData(document.getElementById("frmCreditoBloque4"));
                
                $.ajax({
                    url: "<?= base_url ?>cliente/&setCreditoBloque4=true&docs=true",
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function (result) {
                        
                        $(".mlCargando").fadeOut();        
                        if ( !result["error"] ) {

                            md.showCustomNotification('top', 'right', "success", result["msg"]);
                            
                            $.ajax({
                                url: "<?= base_url ?>cliente/&showSolCreditoConsolidado=true&credito=<?php print $intSolCredito?>",
                                success: function (result) {

                                    $("#mlSolCreditoContent").html(result);
                                    $("#mlSolCredito").modal("show");
                                    
                                    
                                }
                            });
                
                        } else {
                            md.showCustomNotification('top', 'right', "error", "Error");    
                        }
                        

                    },
                    error: function (result) {

                        $(".mlCargando").fadeOut();
                        md.showCustomNotification('top', 'right', "error", "Error");

                    }
                });
                
            }
        
        </script>
        <?php
        
    }
    
    public function drawListCreditosCliente($arrClientes){
        
        ?>
        <table id="tblPerfil" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Cliente</th>
                    <th>Fecha Creación</th>
                    <th>Estado</th>
                    <th class="disabled-sorting text-right">Acciones</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Código</th>
                    <th>Cliente</th>
                    <th>Fecha Creación</th>
                    <th>Estado</th>
                    <th class="text-right">Acciones</th>
                </tr>
            </tfoot>
            <tbody>
                <?php
                
                $arrEstado = utils::getSolicitudCreditoEstado();
                while( $rTMP = each($arrClientes) ){
                    ?>
                    <tr>
                        <td><?php print $rTMP["value"]["id_cliente"]?></td>
                        <td><?php print $rTMP["value"]["nombre_empresa"]."<br>".$rTMP["value"]["nombres"]." ".$rTMP["value"]["apellidos"]." <br> ".$rTMP["value"]["email"]?></td>
                        <td><?php print $rTMP["value"]["fecha_creacion"]?></td>
                        <td><?php print $arrEstado[$rTMP["value"]["estado"]]["nombre"]?></td>
                        <td class="text-right">
                            <?php
                            if( $rTMP["value"]["estado"] != "FEP" && $rTMP["value"]["estado"] != "CA" ){
                                ?>
                                <button onclick="fntShowSolCreditoFormBloque1('<?php print $rTMP["value"]["id_cliente"];?>');" class="btn btn-fill btn-info">
                                    Editar
                                </button>
                                <?php
                            }
                            ?>
                            
                        </td>
                    </tr> 
                    <?php
                }
                
                ?>
                    
            </tbody>
        </table>
        <script>
            $('#tblPerfil').DataTable();
            
            function fntShowSolCreditoFormBloque1(intSolCredito){
                
                $.ajax({
                    url: "<?= base_url ?>cliente/&showSolCreditoFormBloque1=true&credito="+intSolCredito,
                    success: function (result) {

                        $("#divContainerPrincipal").html(result);
                        
                    }
                });
                
                
            }
            
        </script>
        <?php
    }

    

}
