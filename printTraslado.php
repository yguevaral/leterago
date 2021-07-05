<?php
$idTraslado = isset($_GET["k"]) ? intval($_GET["k"]) : 0;

require_once 'config/db.php';
$objDB = Database::connect();
    
$strQuery = "SELECT traslado.id idTraslado,
                    traslado.idUsuario,
                    usuario.nombre nombre_usuario,
                    traslado.idEmpresa_sale,
                    traslado.idEmpresa_entra,
                    traslado.estado,
                    DATE_FORMAT( traslado.fechaAlta, '%d/%m/%Y' ) fechaAlta,
                    
                    traslado_nota.id idTrasladoNota,
                    traslado_nota.nota,
                    traslado_nota.add_fecha add_fechaNota,
                    
                    traslado_inventario.id idTrasladoInventario,
                    traslado_inventario.cantidad,
                    traslado_inventario.idInventario,
                    inventario.codigoProducto,
                    inventario.descripcion,
                    inventario.precioCosto,
                    
                    empresaSale.nombreEmpresa nombreEmpresaSale,
                    empresaEntra.nombreEmpresa nombreEmpresaEntra
                    
                    
           FROM     traslado
                        LEFT JOIN traslado_nota
                            ON  traslado.id = traslado_nota.idTraslado
                            
                        LEFT JOIN traslado_inventario
                            
                            LEFT JOIN inventario
                                ON  traslado_inventario.idInventario = inventario.id
                            
                            ON  traslado.id = traslado_inventario.idTraslado,
                    usuario,
                    empresa empresaSale,            
                    empresa empresaEntra
                            
           WHERE    traslado.id = {$idTraslado}
           AND      traslado.idUsuario = usuario.id 
           AND      traslado.idEmpresa_sale = empresaSale.id 
           AND      traslado.idEmpresa_entra = empresaEntra.id      
             ";
$arr = array();
$qTMP = $objDB->query($strQuery);
while( $rTMP = $qTMP->fetch_object() ){
  
  $arr["idTraslado"] = $rTMP->idTraslado;
  $arr["idUsuario"] = $rTMP->idUsuario;
  $arr["nombre_usuario"] = $rTMP->nombre_usuario;
  $arr["idEmpresa_sale"] = $rTMP->idEmpresa_sale;
  $arr["idEmpresa_entra"] = $rTMP->idEmpresa_entra;
  $arr["estado"] = $rTMP->estado ;
  $arr["fechaAlta"] = $rTMP->fechaAlta;   
  $arr["nombreEmpresaSale"] = $rTMP->nombreEmpresaSale;   
  $arr["nombreEmpresaEntra"] = $rTMP->nombreEmpresaEntra;   
         
  $arr["nota"][$rTMP->idTrasladoNota]["nota"] = $rTMP->nota;
  $arr["nota"][$rTMP->idTrasladoNota]["add_fechaNota"] = $rTMP->add_fechaNota;
  
  $arr["inventario"][$rTMP->idTrasladoInventario]["idTrasladoInventario"] = $rTMP->idTrasladoInventario;
  $arr["inventario"][$rTMP->idTrasladoInventario]["idInventario"] = $rTMP->idInventario ;
  $arr["inventario"][$rTMP->idTrasladoInventario]["codigoProducto"] = $rTMP->codigoProducto ;
  $arr["inventario"][$rTMP->idTrasladoInventario]["descripcion"] = $rTMP->descripcion ;
  $arr["inventario"][$rTMP->idTrasladoInventario]["precioCosto"] = $rTMP->precioCosto ;
  $arr["inventario"][$rTMP->idTrasladoInventario]["cantidad"] = $rTMP->cantidad ;
  
}

if( !isset($arr["idTraslado"]) ){
    ?>
    <script>
        window.close();
    </script>
    <?php
}

?>
<table style="width: 100%;">
    <tr>
        <td style="width: 100%; text-align: center; font-weight: bold; font-size: 30px;">
            Traslado <?php print $idTraslado;?>
        </td>
    </tr>
    <tr>
        <td style="width: 100%; text-align: center;">
            <?php print $arr["fechaAlta"]?>
        </td>
    </tr>
    
    <tr>
        <td style="width: 100%; text-align: left;">
            Empresa Sale: <?php print $arr["nombreEmpresaSale"];?>
        </td>
    </tr>
    <tr>
        <td style="width: 100%; text-align: left;">
            Empresa Entra: <?php print $arr["nombreEmpresaEntra"];?>
        </td>
    </tr>
    <tr>
        <td style="width: 100%; text-align: left;">
            Usuario Envia: <?php print $arr["nombre_usuario"];?>
        </td>
    </tr>
    <tr>
        <td style="width: 100%; text-align: left;">
            <br>
        </td>
    </tr>
    
    <tr>
        <td style="width: 100%; text-align: center;">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 80%; text-align: left;">Producto</td>
                    <td style="width: 10%; text-align: center;">Cantidad</td>
                </tr>
                <?php
                
                while( $rTMP = each($arr["inventario"]) ){
                    ?>
                    <tr>
                        <td style="text-align: left;"><?php print "{$rTMP["value"]["codigoProducto"]} - {$rTMP["value"]["descripcion"]}"?></td>
                        <td style="text-align: center;"><?php print intval($rTMP["value"]["cantidad"])?></td>
                    </tr>
                    <?php    
                }
                
                ?>
                
            </table>
        </td>
    </tr>
    <tr>
        <td style="width: 100%; text-align: left;">
            <br>
        </td>
    </tr>
</table>
<script>
    window.print();
</script>
