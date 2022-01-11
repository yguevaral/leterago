<script>

    var intCountImagen = "<?php print isset($lista_productoIMG) && is_array($lista_productoIMG) && count($lista_productoIMG) > 0 ? count($lista_productoIMG) + 1 : 1 ?>";
    $(document).ready(function () {

    });

    function getTallaTamano() {

        var opt_prenda = document.getElementById("opt_PrendaArticulo").value;

        if (opt_prenda) {
            $.ajax({
                url: "<?= base_url ?>inventario/&getAjax=true&key=1&opt_prenda=" + opt_prenda,
                success: function (result) {

                    $("#divTallaTamano").html(result);
                }
            });
        }
    }

    function getBajaProducto() {

        location.href = "<?= base_url ?>inventario/bajaIndex";
    }

    function notification() {

        var type = $("#txtType").val();
        var message = $("#txtMessage").val();

        md.showCustomNotification('top', 'right', type, message);
    }
    
    function fntDeleteRow(strID){
        
        $("#"+strID).remove();
    
    }
    
    function fntAddImagen(){
        
        $("#divRowGaleria").append("<div id=\"rowImagen_"+intCountImagen+"\" class=\"col-md-2 text-center \">     "+
                                   "    <div class=\"form-group text-center \" >       "+
                                   "        <div class=\"fileinput fileinput-new text-center \" style=\"width: 90%;\" data-provides=\"fileinput\">      "+
                                   "            <div class=\"fileinput-new thumbnail \">                                                              "+
                                   "                <img id=\"divImagen_"+intCountImagen+"\" src=\"<?php print base_url . "assets/img/no-image.jpg"  ?>\" > "+
                                   "            </div>                                                                           "+
                                   "            <div class=\"fileinput-preview fileinput-exists thumbnail\"></div>                   "+
                                   "            <div>                                                                               "+
                                   "                <span class=\"btn btn-info btn-round btn-file\" style=\"width: 90%;\">                 "+
                                   "                    <span class=\"fileinput-new\" >+ Imagen</span>                                     "+
                                   "                    <span class=\"fileinput-exists\">Cambiar</span>                                      "+
                                   "                    <input name=\"flImagen_"+intCountImagen+"\" id=\"flImagen_"+intCountImagen+"\" type=\"file\"/>                                  "+
                                   "                </span>                                                                                    "+
                                   "                <a href=\"javascript:void(0)\" class=\"btn btn-danger btn-round \" onclick=\"fntDeleteRow('rowImagen_"+intCountImagen+"');\" data-dismiss=\"divImagen_"+intCountImagen+"\"> "+
                                   "                    <i class=\"fa fa-times\"></i> Eliminar                                                       "+
                                   "                </a>                                                                                             "+
                                   "            </div>                                                                                                 "+
                                   "        </div>                                                                                                       "+
                                   "    </div>                                                                                                             "+
                                   "</div>");
        
        intCountImagen++;
    }
    
    function fntSubmit(){
        
        document.getElementById("frmInventario").submit();
        
    }
    
    function fntDeleteRowDb(strObjRow, strid){
        
        $.ajax({
            url: "<?= base_url ?>inventario/&setDImGInventario=true&key=" + strid,
            success: function (result) {
                fntDeleteRow(strObjRow);
            }
        });    
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
    <div class="col-md-12 text-right">
        <button class="btn btn-info btn-link" onclick="getBajaProducto();">Baja de producto</button>
    </div>
</div>
<?php $url = isset($_producto) ? 'inventario/save&codigo_producto=' . $_producto->codigoProducto : 'inventario/save'; ?>
<form method="POST" action="<?= base_url . $url ?>" enctype="multipart/form-data" onsubmit="return false;" id="frmInventario">
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header card-header-info card-header-icon">
                    <div  class="card-icon">
                        <i class="material-icons">menu_book</i>
                    </div>
                    <h4 class="card-title">Mantenimiento de Inventario</h4>
                </div>
                &nbsp;<br/>&nbsp;
                <div class="card-body ">
                    <div class="row" id="divRowGaleria">
                           
                       <?php
                       
                       $intCountIMG = 1;
                       if( isset($lista_productoIMG) && is_array($lista_productoIMG) && count($lista_productoIMG) > 0 ){
                                           
                           while( $rTMP = each($lista_productoIMG) ){
                               
                               //utils::drawDebug($rTMP["value"]["url"]);
                                                       
                               ?>
                               <div id="rowImagen_<?php print $intCountIMG?>" class="col-md-2 text-center ">       
                                   <div class="form-group text-center " >      
                                       <div class="fileinput fileinput-new text-center " style="width: 90%;" data-provides="fileinput">     
                                           <div class="fileinput-new thumbnail ">                                                             
                                               <img id="divImagen_<?php print $intCountIMG?>" src="<?php print base_url . $rTMP["value"]["url"]  ?>" >
                                           </div>                                                                          
                                           <div class="fileinput-preview fileinput-exists thumbnail"></div>                  
                                           <div>                                                                              
                                               <a href="javascript:void(0)" class="btn btn-danger btn-round " onclick="fntDeleteRowDb('rowImagen_<?php print $intCountIMG?>', '<?php print $rTMP["value"]["id_inventario_multimedia"]?>');" data-dismiss="divImagen_<?php print $intCountIMG?>">
                                                   <i class="fa fa-times"></i> Eliminar                                                      
                                               </a>                                                                                            
                                           </div>                                                                                                
                                       </div>                                                                                                      
                                   </div>                                                                                                            
                               </div>
                               <?php
                               $intCountIMG++;
                               
                           } 
                           
                       }
                       ?>
                        <!-- 
                        <div class="col-md-2 text-center ">     
                            <div class="form-group text-center " >
                                <div class="fileinput fileinput-new text-center " style="width: 90%;" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail ">
                                        <img src="<?php print isset($_producto->url_imagen) && !empty($_producto->url_imagen) ? base_url . $_producto->url_imagen : base_url . "assets/img/no-image.jpg"  ?>" alt="...">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                    <div >
                                        <span class="btn btn-info btn-round btn-file" style="width: 90%;">
                                            <span class="fileinput-new" >+ Imagen</span>
                                            <span class="fileinput-exists">Cambiar</span>
                                            <input type="file" name="flImagen" id="flImagen" />
                                        </span>
                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput">
                                            <i class="fa fa-times"></i> Eliminar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        -->
                    </div>
                    <div class="row">
                            
                        <div class="col-md-2 text-center ">     
                            <button class="btn btn-fill btn-info" onclick="fntAddImagen();">Agregar Imagen</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="selectpicker dropdown" name="opt_categoria" id="opt_categoria" title="Categoría" data-style="select-with-transition" data-live-search="true" />
                                <?php while ($data = $lista_categorias->fetch_object()): ?>
                                    <option value="<?= $data->idCategoria ?>" <?= isset($_producto) && $data->idCategoria == $_producto->idCategoria ? 'selected' : ''; ?>> <?= $data->nombreCategoria ?> </option>
                                <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="selectpicker dropdown" name="opt_PrendaArticulo" id="opt_PrendaArticulo" onchange="getTallaTamano();" title="Prenda/Articulo" data-style="select-with-transition" data-live-search="true" />
                                <?php while ($data = $lista_prendas->fetch_object()): ?>
                                    <option value="<?= $data->idPrendaArticulo ?>" <?= isset($_producto) && $data->idPrendaArticulo == $_producto->idPrendaArticulo ? 'selected' : ''; ?>> <?= $data->nombrePrendaArticulo ?> </option>
                                <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3" id="divTallaTamano">
                            <div class="form-group">
                                <?php if (isset($_producto)): ?>
                                    <select class="selectpicker dropdown" data-style="select-with-transition" data-live-search="true" title="Talla/Tamaño" name="opt_TallaTamano" id="opt_TallaTamano" >
                                        <option disabled>Seleccione una opcion...</option>
                                        <?php while ($data = $lista_tallas_tamanos->fetch_object()): ?>
                                            <option value="<?= $data->idTallaTamano ?>" <?= isset($_producto) && $data->idTallaTamano == $_producto->idTallaTamano ? 'selected' : ''; ?>> <?= $data->nombreTallaTamano ?> </option>
                                        <?php endwhile; ?>
                                    </select>
                                <?php else: ?>
                                    <select class="selectpicker dropdown" data-style="select-with-transition" title="Talla/Tamaño" name="opt_TallaTamano" id="opt_TallaTamano" data-live-search="true">
                                        <option disabled>Seleccione una opcion...</option>
                                    </select>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="selectpicker dropdown" data-style="select-with-transition" title="Color" name="opt_color" id="opt_color" data-live-search="true">
                                    <?php while ($data = $lista_colores->fetch_object()): ?>
                                        <option value="<?= $data->id ?>" <?= isset($_producto) && $data->id == $_producto->idColor ? 'selected' : ''; ?>> <?= $data->nombreColor ?> </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Nombre</label>
                                <input type="text" class="form-control" name="txt_nombre" value="<?= isset($_producto) ? $_producto->nombre : ''; ?>"/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Descripción</label>
                                <input type="text" class="form-control" name="txt_descripcion" value="<?= isset($_producto) ? $_producto->descripcion : ''; ?>"/>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="bmd-label-floating">Cantidad</label>
                                <input type="number" class="form-control" name="txt_cantidad" id="txt_cantidad" step="any" value="" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="bmd-label-floating">Mínimo</label>
                                <input type="number" class="form-control" name="txt_minimo" id="txt_minimo" step="any" value="<?= isset($_producto) ? $_producto->minimo : ''; ?>"/>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="bmd-label-floating">Máximo</label>
                                <input type="number" class="form-control" name="txt_maximo" id="txt_maximo" step="any" value="<?= isset($_producto) ? $_producto->maximo : ''; ?>"/>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="bmd-label-floating">Precio Costo</label>
                                <input type="number" class="form-control" name="txt_costo" id="txt_costo" step="any" value="<?= isset($_producto) ? $_producto->precioCosto : ''; ?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="bmd-label-floating">Precio Venta</label>
                                <input type="number" class="form-control" name="txt_venta" id="txt_venta" step="any" value="<?= isset($_producto) ? $_producto->precioVenta : ''; ?>"/>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="bmd-label-floating">Precio Mínimo de Venta</label>
                                <input type="number" class="form-control" name="txt_ventaMinimo" id="txt_ventaMinimo" step="any" value="<?= isset($_producto) ? $_producto->precioVentaMinimo : ''; ?>"/>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="bmd-label-floating">Código</label>
                                <input type="text" class="form-control" name="txt_codigo" id="txt_codigo" value="<?= isset($_producto) ? $_producto->codigoProducto : ''; ?>"/>
                                <input type="hidden" name="hidCodigo" id="hidCodigo" value="<?= isset($_producto) ? $_producto->codigoProducto : ''; ?>"/>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="togglebutton">
                                    <label>
                                        <input type="checkbox" <?php print isset($_producto) && $_producto->ventaLinea == "Y" ? "checked" : ""  ?> id="chkTiendaEnLinea" name="chkTiendaEnLinea">
                                        <span class="toggle"></span>Tienda en linea?
                                    </label>
                                </div>
                            </div>
                        </div>
                        <?php if (isset($_producto)): ?>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="selectpicker dropdown" data-style="select-with-transition" title="Estado" name="opt_estado" id="opt_estado">
                                        <?php while ($data = $lista_estados_ai->fetch_object()): ?>
                                            <option value="<?= $data->id ?>" <?= isset($_producto) && $data->id == $_producto->estado ? 'selected' : ''; ?>> <?= $data->nombreEstado ?> </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 text-right">
                            <?php else: ?>
                                <div class="col-md-8 text-right">
                                <?php endif; ?>     
                            </div>
                            <div class="col-md-4 text-right">
                                <button onclick="fntSubmit();" class="btn btn-fill btn-info">Guardar</button>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <span>*Se recomienda para crear el código, tomar las primeras 3 letras del tipo de prenda, las primeras 2 del color y la primera letra de la talla</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</form>

<!-- Lista de Categorias -->
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
                                <th>Codigo</th>
                                <th>Imagen</th>
                                <th>Descripcion</th>
                                <th>Cantidad</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($data = $lista_productos->fetch_object()): ?>
                                <tr>
                                    <td>
                                        <a href="<?= base_url ?>inventario/edit&codigo_producto=<?= $data->codigoProducto ?>"><?= $data->codigoProducto; ?></a>
                                        <?php
                                        if ($data->ventaLinea == "Y") {
                                            ?>
                                            <br>
                                            <span class="badge badge-dark">Venta en línea</span>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td style="width: 10%;">
                                        <div class="img-container">
                                            <img src="<?php print isset($lista_productosIMG[$data->id]) ? base_url . $lista_productosIMG[$data->id]["img"][1]["url"] : base_url . "assets/img/no-image.jpg"  ?>" alt="...">
                                        </div>
                                    </td>
                                    <td><?= $data->descripcion . " " . $data->nombrePrendaArticulo . " " . $data->nombreTallaTamano . " " . $data->nombreColor; ?></td>
                                    <td><?= $data->cantidad; ?></td>
                                    <td><?= $data->nombreEstado; ?></td>
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