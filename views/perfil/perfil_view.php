<?php

class perfil_view {

    function fntDrawIndex(){
        
        ?>
    
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">menu_book</i>
                        </div>
                        <h4 class="card-title">Mantenimiento</h4>
                    </div>
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-12">
                                <button onclick="fntShowModalAdminPerfil(0);" class="btn btn-fill btn-info">
                                    Agregar Perfil
                                </button>
                            </div>    
                        </div>
                        
                        
                        <div class="row">
                            <div class="col-12 table-responsive" id="divContenidoUsuarios">
                                
                            </div>    
                        </div>    
                        
                    </div>
                </div>
            </div>
        </div>
    
              
        <!-- Modal para buscar empresas -->
        <div class="modal fade" id="mlAdminPerfil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
            
            function fntShowModalAdminPerfil(intPerfil){
                
                $.ajax({
                    
                    url: "<?= base_url ?>perfil/&drawAdminModalPerfil=true&perfil="+intPerfil,
                    success: function (result) {

                        $("#mlContentAdminPerfil").html(result);
                        $("#mlAdminPerfil").modal("show");
                        
                    }
                });
                   
            }

            function fntDrawListPerfil( ){
                
                $.ajax({
                    url: "<?= base_url ?>perfil/&drawListPerfil=true",
                    success: function (result) {

                        $("#divContenidoUsuarios").html(result);
                        
                        
                        
                    }
                });
                   
            }

        </script>
        <?php      
    
    }
    
    public function drawListPerfil($arrUsuario){
        
        ?>
        <table id="tblPerfil" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th class="disabled-sorting text-right">Acciones</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th class="text-right">Acciones</th>
                </tr>
            </tfoot>
            <tbody>
                <?php
                
                $arrEstado = utils::getPerfilEstado();
                while( $rTMP = each($arrUsuario) ){
                    ?>
                    <tr>
                        <td><?php print $rTMP["value"]["nombre"]?></td>
                        <td><?php print $arrEstado[$rTMP["value"]["estado"]]["nombre"]?></td>
                        <td class="text-right">
                            <a href="javascript: void(0)" onclick="fntShowModalAdminPerfil('<?php print $rTMP["value"]["id_perfil"]?>');" class="btn btn-link btn-info btn-just-icon edit"><i class="material-icons">edit</i></a>
                            <a href="javascript: void(0)" onclick="fntEliminarPerfil('<?php print $rTMP["value"]["id_perfil"]?>');" class="btn btn-link btn-danger btn-just-icon remove"><i class="material-icons">close</i></a>
                        </td>
                    </tr> 
                    <?php
                }
                
                ?>
                    
            </tbody>
        </table>
        <script>
            $('#tblPerfil').DataTable();
            
            function fntEliminarPerfil(intPerfil){
                
                $.ajax({
                    url: "<?= base_url ?>usuario/&setEliminarPerfil=true&perfil="+intPerfil,
                    success: function (result) {

                        md.showCustomNotification('top', 'right', "success", "Perfil Actualizado, Estado Eliminado");
                        fntDrawListPerfil();
                        
                        
                    }
                });        
                
            }
            
        </script>
        <?php
    }
    
    public function drawAdminModalPerfil($intPerfil, $arrPefil, $arrAcceso, $arrPerfilAcceso){
        
        ?>
        <form method="POST" onsubmit="return false;" enctype="multipart/form-data" id="frmPerfil" autocomplete="off">
        <input type="hidden" name="hidPerfil" id="hidPerfil" value="<?php print $intPerfil;?>">
        <div class="modal-header">
            <h4 class="modal-title" style="font-weight: bold;">
                Perfil
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <i class="material-icons">clear</i>
            </button>
        </div>
        <div class="modal-body" id="mlBodyAdminUsuario">
            
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="bmd-label-floating">Nombre</label>
                        <input type="text" class="form-control" name="txtNombrePerfil" id="txtNombrePerfil" autocomplete="off" value="<?php print isset($arrPefil["nombre"]) ? $arrPefil["nombre"] : ""?>" >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <select name="slcAcceso[]" class="selectpicker" data-style="select-with-transition" multiple title="Acceso" data-size="<?php print count($arrAcceso)?>">
                            <?php
                            
                            while( $rTMP = each($arrAcceso) ){
                                $strSelected = isset($arrPerfilAcceso[$rTMP["key"]]) ? "selected" : "";
                                ?>
                                <option <?php print $strSelected;?> value="<?php print $rTMP["key"]?>"><?php print $rTMP["value"]["nombre"]?></option>
                                <?php
                            }
                            
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <select name="slcEstado" class="selectpicker" data-style="select-with-transition" title="Estado" data-size="2">
                            <?php
                            
                            $arrEstado = utils::getPerfilEstado();
                            while( $rTMP = each($arrEstado) ){
                                $strSelected = isset($arrPefil["estado"]) && $arrPefil["estado"] ===  $rTMP["key"] ? "selected" : "";
                                ?>
                                <option <?php print $strSelected;?> value="<?php print $rTMP["key"]?>"><?php print $rTMP["value"]["nombre"]?></option>
                                <?php
                            }
                            
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-12 text-right">
                    <button onclick="fntSavePerfil();" class="btn btn-fill btn-info">
                        Guardar
                    </button>
                    <button onclick="fntCloseModalPerfil();" class="btn btn-fill btn-default">
                        Cancelar
                    </button>
                </div>
            </div>
            
        </div>
        </form>
        <script>
            
            $('.selectpicker').selectpicker();
            
            function fntCloseModalPerfil(){
                $('#mlAdminPerfil').modal('hide');    
            }
            
            function fntSavePerfil(){
                
                var formData = new FormData(document.getElementById("frmPerfil"));

                $.ajax({
                    url: "<?= base_url ?>perfil/&setPerfil=true",
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function (result) {

                        if ( !result["error"] ) {

                            md.showCustomNotification('top', 'right', "success", result["msg"]);
                            fntDrawListPerfil();

                        } else {
                            md.showCustomNotification('top', 'right', "error", "Error");    
                        }
                        
                        fntCloseModalPerfil();

                    },
                    error: function (result) {

                        md.showCustomNotification('top', 'right', "error", "Error");
                        fntCloseModalUsuario();

                    }
                });
                
            }
            
        </script>
        <?php
        
    } 

    

}
