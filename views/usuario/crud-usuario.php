<?php

class usuarioView {
    
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
                                <button onclick="fntShowModalAdminUsuario(0);" class="btn btn-fill btn-info">
                                    Agregar Usuario
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
        <div class="modal fade" id="mlAdminUsuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 700px !important;">
                <div class="modal-content" id="mlContentAdminUsuario">
                    
                </div>
            </div>
        </div>
        <!-- Fin del Modal -->

        <script>

            $(document).ready(function () {
                
                fntDrawListUsuario();
                    
            });
            
            function fntShowModalAdminUsuario(intUsuario){
                
                $.ajax({
                    
                    url: "<?= base_url ?>usuario/&drawAdminModalUsuario=true&usuario="+intUsuario,
                    success: function (result) {

                        $("#mlContentAdminUsuario").html(result);
                        $("#mlAdminUsuario").modal("show");
                        
                    }
                });
                   
            }

            function fntDrawListUsuario( ){
                
                $.ajax({
                    url: "<?= base_url ?>usuario/&drawListUsuario=true",
                    success: function (result) {

                        $("#divContenidoUsuarios").html(result);
                        
                        
                        
                    }
                });
                   
            }

        </script>
        <?php      
    
    }
    
    public function drawListUsuario($arrUsuario){
        ?>
        <table id="tblUsuario" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th class="disabled-sorting text-right">Acciones</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th class="text-right">Acciones</th>
                </tr>
            </tfoot>
            <tbody>
                <?php
                
                $arrTipo = utils::getUsuarioTipo();
                $arrEstado = utils::getUsuarioEstado();
                while( $rTMP = each($arrUsuario) ){
                    ?>
                    <tr>
                        <td><?php print $rTMP["value"]["nombres"]?></td>
                        <td><?php print $rTMP["value"]["apellidos"]?></td>
                        <td><?php print $rTMP["value"]["email"]?></td>
                        <td><?php print $arrTipo[$rTMP["value"]["tipo"]]["nombre"]?></td>
                        <td><?php print $arrEstado[$rTMP["value"]["estado"]]["nombre"]?></td>
                        <td class="text-right">
                            <a href="javascript: void(0)" onclick="fntShowModalAdminUsuario('<?php print $rTMP["value"]["id_usuario"]?>');" class="btn btn-link btn-info btn-just-icon edit"><i class="material-icons">edit</i></a>
                            <a href="javascript: void(0)" onclick="fntEliminarUsuario('<?php print $rTMP["value"]["id_usuario"]?>');" class="btn btn-link btn-danger btn-just-icon remove"><i class="material-icons">close</i></a>
                        </td>
                    </tr> 
                    <?php
                }
                
                ?>
                    
            </tbody>
        </table>
        <script>
            $('#tblUsuario').DataTable();
            
            function fntEliminarUsuario(intUsuario){
                
                $.ajax({
                    url: "<?= base_url ?>usuario/&setEliminarUsuario=true&usuario="+intUsuario,
                    success: function (result) {

                        md.showCustomNotification('top', 'right', "success", "Usuario Actualizado, Estado Eliminado");
                        fntDrawListUsuario();
                        
                        
                    }
                });        
                
            }
            
        </script>
        <?php
    }
    
    public function drawAdminModalUsuario($intUsuario, $arrUsuario = array(), $arrPais = array(), $arrUsuarioPais = array(),
                                          $arrPerfil, $arrUsuarioPerfil){
        
        ?>
        <form method="POST" onsubmit="return false;" enctype="multipart/form-data" id="frmUsuario" autocomplete="off">
        <input type="hidden" name="hidUsuario" id="hidUsuario" value="<?php print $intUsuario;?>">
        <div class="modal-header">
            <h4 class="modal-title" style="font-weight: bold;">
                Usuario
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <i class="material-icons">clear</i>
            </button>
        </div>
        <div class="modal-body" id="mlBodyAdminUsuario">
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="bmd-label-floating">Nombres</label>
                        <input type="text" class="form-control" name="txtNombreUsuario" id="txtNombreUsuario" autocomplete="off" value="<?php print isset($arrUsuario["nombres"]) ? $arrUsuario["nombres"] : ""?>" >
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="bmd-label-floating">Apellidos</label>
                        <input type="text" class="form-control" name="txtApellido" id="txtApellido" autocomplete="off" value="<?php print isset($arrUsuario["apellidos"]) ? $arrUsuario["apellidos"] : ""?>">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="bmd-label-floating">Email</label>
                        <input type="email" class="form-control" name="txtEmailUsuario" id="txtEmailUsuario" autocomplete="off" value="<?php print isset($arrUsuario["email"]) ? $arrUsuario["email"] : ""?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="bmd-label-floating">Contraseña</label>
                        <input type="password" class="form-control" name="txtClaveUsuario" id="txtClaveUsuario" autocomplete="off">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <select name="slcTipo" class="selectpicker" data-style="select-with-transition" title="Tipo Usuario" data-size="3">
                            <?php
                            
                            $arrTipo = utils::getUsuarioTipo();
                            while( $rTMP = each($arrTipo) ){
                                
                                $strSelected = isset($arrUsuario["tipo"]) && $arrUsuario["tipo"] ===  $rTMP["key"] ? "selected" : "";
                                ?>
                                <option <?php print $strSelected;?> value="<?php print $rTMP["key"]?>" ><?php print $rTMP["value"]["nombre"]?></option>
                                <?php
                            }
                            
                            ?>
                            
                          </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <select name="slcSexo" class="selectpicker" data-style="select-with-transition" title="Sexo" data-size="3">
                            <?php
                            
                            $arrTipo = utils::getSexo();
                            while( $rTMP = each($arrTipo) ){
                                $strSelected = isset($arrUsuario["sexo"]) && $arrUsuario["sexo"] ===  $rTMP["key"] ? "selected" : "";
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
                        <select name="slcPais[]" class="selectpicker" data-style="select-with-transition" multiple title="Países" data-size="<?php print count($arrPais)?>">
                            <?php
                            
                            while( $rTMP = each($arrPais) ){
                                $strSelected = isset($arrUsuarioPais[$rTMP["key"]]) ? "selected" : "";
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
                <div class="col-md-6">
                    <div class="form-group">
                        <select name="slcPerfil[]" class="selectpicker" data-style="select-with-transition" multiple title="Perfiles" data-size="<?php print count($arrPerfil)?>">
                            <?php
                            
                            while( $rTMP = each($arrPerfil) ){
                                $strSelected = isset($arrUsuarioPerfil[$rTMP["key"]]) ? "selected" : "";
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
                            
                            $arrTipo = utils::getUsuarioEstado();
                            while( $rTMP = each($arrTipo) ){
                                $strSelected = isset($arrUsuario["estado"]) && $arrUsuario["estado"] ===  $rTMP["key"] ? "selected" : "";
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
                    <button onclick="fntSaveUsuario();" class="btn btn-fill btn-info">
                        Guardar
                    </button>
                    <button onclick="fntCloseModalUsuario();" class="btn btn-fill btn-default">
                        Cancelar
                    </button>
                </div>
            </div>
            
        </div>
        </form>
        <script>
            
            $('.selectpicker').selectpicker();
            
            function fntCloseModalUsuario(){
                $('#mlAdminUsuario').modal('hide');    
            }
            
            function fntSaveUsuario(){
                
                var formData = new FormData(document.getElementById("frmUsuario"));

                $.ajax({
                    url: "<?= base_url ?>usuario/&setUsuario=true",
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function (result) {

                        if ( !result["error"] ) {

                            md.showCustomNotification('top', 'right', "success", result["msg"]);
                            fntDrawListUsuario();

                        } else {
                            md.showCustomNotification('top', 'right', "error", "Error");    
                        }
                        
                        fntCloseModalUsuario();

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

?>
