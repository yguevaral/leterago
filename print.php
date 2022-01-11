
<table style="width: 100%; ">
    <tr>
        <td style="width: 50%; text-align: left; font-weight: bold;  ">
            Nombre
        </td>
        <td style="width: 50%; text-align: center;">
            ASdfasdf
        </td>
    </tr>
    
    <tr>
        <td style="width: 50%; text-align: left; font-weight: bold; ">
            Email
        </td>
        <td style="width: 50%; text-align: center;">
            ASdfasdf
        </td>
    </tr>
    
    <tr>
        <td style="width: 50%; text-align: left; font-weight: bold; ">
            Contraseña
        </td>
        <td style="width: 50%; text-align: center;">
            ASdfasdf
        </td>
    </tr>
    
    <tr>
        <td style="width: 50%; text-align: left; font-weight: bold; ">
            # Credito
        </td>
        <td style="width: 50%; text-align: center;">
            ASdfasdf
        </td>
    </tr>
    
    <tr>
        <td colspan="2" style="text-align: center; font-weight: bold; ">
            Navega a <a href="http://leterago.com/" target="_blank">leterago.com</a> con he ingresa con tu email y clave para completar el formulacion de solicitud de credito
        </td>
    </tr>
    
</table>
<?php
die();
$strJson = '[
    {
        "_id": "SEM3-2020",
        "count": 41
    },
    {
        "_id": "SEM28-2020",
        "count": 94
    },
    {
        "_id": "SEM39-2020",
        "count": 86
    },
    {
        "_id": "SEM43-2020",
        "count": 93
    },
    {
        "_id": "SEM16-2020",
        "count": 39
    },
    {
        "_id": "SEM11-2020",
        "count": 77
    },
    {
        "_id": "SEM34-2020",
        "count": 90
    },
    {
        "_id": "SEM27-2020",
        "count": 80
    },
    {
        "_id": "SEM25-2020",
        "count": 82
    },
    {
        "_id": "SEM19-2020",
        "count": 87
    },
    {
        "_id": "SEM45-2020",
        "count": 106
    },
    {
        "_id": "SEM2-2020",
        "count": 40
    },
    {
        "_id": "SEM46-2020",
        "count": 116
    },
    {
        "_id": "SEM1-2020",
        "count": 23
    },
    {
        "_id": "SEM33-2020",
        "count": 100
    },
    {
        "_id": "SEM14-2020",
        "count": 36
    },
    {
        "_id": "SEM36-2020",
        "count": 75
    },
    {
        "_id": "SEM35-2020",
        "count": 63
    },
    {
        "_id": "SEM31-2020",
        "count": 62
    },
    {
        "_id": "SEM44-2020",
        "count": 88
    },
    {
        "_id": "SEM41-2020",
        "count": 95
    },
    {
        "_id": "SEM30-2020",
        "count": 60
    },
    {
        "_id": "SEM7-2020",
        "count": 60
    },
    {
        "_id": "SEM6-2020",
        "count": 72
    },
    {
        "_id": "SEM53-2020",
        "count": 32
    },
    {
        "_id": "SEM26-2020",
        "count": 91
    },
    {
        "_id": "SEM13-2020",
        "count": 69
    },
    {
        "_id": "SEM52-2020",
        "count": 52
    },
    {
        "_id": "SEM51-2020",
        "count": 86
    },
    {
        "_id": "SEM21-2020",
        "count": 67
    },
    {
        "_id": "SEM20-2020",
        "count": 72
    },
    {
        "_id": "SEM50-2020",
        "count": 85
    },
    {
        "_id": "SEM40-2020",
        "count": 113
    },
    {
        "_id": "SEM12-2020",
        "count": 57
    },
    {
        "_id": "SEM4-2020",
        "count": 82
    },
    {
        "_id": "SEM42-2020",
        "count": 93
    },
    {
        "_id": "SEM37-2020",
        "count": 101
    },
    {
        "_id": "SEM38-2020",
        "count": 79
    },
    {
        "_id": "SEM47-2020",
        "count": 93
    },
    {
        "_id": "SEM5-2020",
        "count": 61
    },
    {
        "_id": "SEM10-2020",
        "count": 80
    },
    {
        "_id": "SEM48-2020",
        "count": 89
    },
    {
        "_id": "SEM22-2020",
        "count": 62
    },
    {
        "_id": "SEM15-2020",
        "count": 29
    },
    {
        "_id": "SEM8-2020",
        "count": 72
    },
    {
        "_id": "SEM9-2020",
        "count": 68
    },
    {
        "_id": "SEM23-2020",
        "count": 75
    },
    {
        "_id": "SEM17-2020",
        "count": 65
    },
    {
        "_id": "SEM18-2020",
        "count": 49
    },
    {
        "_id": "SEM24-2020",
        "count": 86
    },
    {
        "_id": "SEM49-2020",
        "count": 124
    },
    {
        "_id": "SEM29-2020",
        "count": 72
    },
    {
        "_id": "SEM32-2020",
        "count": 62
    }
]';


for( $i = 1; $i <= 52; $i++ ){
    
    $str = "SEM{$i}-2020";
    $arrSemanas[$str] = false;
       
}




$arr = json_decode($strJson);

while( $rTMP = each($arr) ){
    
    $arrSemanas[$rTMP["value"]->_id] = true;
    
}

while( $rTMP = each($arrSemanas) ){
    
    if( !$rTMP["value"] ){
        
        print("<pre>");
        print_r($rTMP["key"]);
        print("</pre>");
        
    }
    
}



die();
$intOrden = isset($_GET["k"]) ? intval($_GET["k"]) : 0;

require_once 'config/db.php';
$objDB = Database::connect();
    
$strQuery = "SELECT orden.id,
                    orden.idVendedor,
                    orden.idCliente,
                    orden.fechaOrden,
                    orden.fechaEnvio,
                    orden.subtotal,
                    orden.envio,
                    orden.total,
                    orden.idMensajeria,
                    orden.idTipoPago,
                    orden.idCuenta,
                    orden.numeroGuia,
                    orden.estadoVenta,
                    orden.estadoOrden,
                    orden.idOrdenDevolucion,
                    orden.descuento_devolucion,
                    
                    cliente.nit,
                    cliente.mail,
                    cliente.telefono,
                    cliente.nombre,
                    cliente.idDepartamento,
                    cliente.idMunicipio,
                    cliente.zona,
                    cliente.direccion,
                    cliente.telefono,
                    
                    cat_departamento.nombre nombre_departamento,
                    cat_municipio.nombre nombre_municipio,
                    
                    orden_detalle.id idOrdenDetalle,
                    orden_detalle.codigoProducto,
                    orden_detalle.cantidad,
                    orden_detalle.precio,
                    orden_detalle.subtotal,
                    orden_detalle.codigoProducto,
                    orden_detalle.descripcion,
                    orden_detalle.subtotal subtotalDetalle,
                    orden_detalle.iva ivaDetalle,
                    orden_detalle.devolucion,
                    orden_detalle.descuento_devolucion descuento_devolucion_detalle,
                    
                    empresa.nombreEmpresa
                    
                    
             FROM   orden
                        LEFT JOIN empresa
                            ON  orden.idEmpresa = empresa.id
                        
                        LEFT JOIN cliente
                            ON  orden.idCliente = cliente.id
                        
                        LEFT JOIN cat_departamento
                            ON  cliente.idDepartamento = cat_departamento.id
                            
                        LEFT JOIN cat_municipio
                            ON  cliente.idMunicipio = cat_municipio.codMunicipio
                            
                        LEFT JOIN orden_detalle
                            ON  orden.id = orden_detalle.idOrden
                            
             WHERE  orden.id = {$intOrden}         
             ";
$arr = array();
$qTMP = $objDB->query($strQuery);
while( $rTMP = $qTMP->fetch_object() ){
    
    $arr["id"] = $rTMP->id;
    $arr["nombre"] = $rTMP->nombre;
    $arr["nit"] = $rTMP->nit;
    $arr["telefono"] = $rTMP->telefono;
    $arr["direccion"] = $rTMP->direccion;
    $arr["nombre_departamento"] = $rTMP->nombre_departamento;
    $arr["nombre_municipio"] = $rTMP->nombre_municipio;
    $arr["zona"] = $rTMP->zona;
    $arr["nombreEmpresa"] = $rTMP->nombreEmpresa;
    $arr["fechaOrden"] = $rTMP->fechaOrden;
    $arr["descuento_devolucion"] = $rTMP->descuento_devolucion;
    
    $arr["cliente"]["nombre"] = $rTMP->nombre;
    $arr["cliente"]["nit"] = $rTMP->nit;
    
    if( !isset($arr["total"]) )
        $arr["total"] = 0;
        
    $arr["total"] += $rTMP->subtotalDetalle;
    
    $arr["producto"][$rTMP->idOrdenDetalle]["idOrdenDetalle"] = $rTMP->idOrdenDetalle;
    $arr["producto"][$rTMP->idOrdenDetalle]["codigoProducto"] = $rTMP->codigoProducto;
    $arr["producto"][$rTMP->idOrdenDetalle]["descripcion"] = $rTMP->descripcion;
    $arr["producto"][$rTMP->idOrdenDetalle]["cantidad"] = $rTMP->cantidad;
    $arr["producto"][$rTMP->idOrdenDetalle]["precio"] = $rTMP->precio;
    $arr["producto"][$rTMP->idOrdenDetalle]["subtotal"] = $rTMP->subtotal;
    $arr["producto"][$rTMP->idOrdenDetalle]["ivaDetalle"] = $rTMP->ivaDetalle;
    $arr["producto"][$rTMP->idOrdenDetalle]["descuento_devolucion_detalle"] = $rTMP->descuento_devolucion_detalle;
    
}

if( !isset($arr["id"]) ){
    ?>
    <script>
        window.close();
    </script>
    <?php
}
//print "<pre>";
//print_r($arr);
//print "</pre>";

?>
<table style="width: 100%;">
    <tr>
        <td style="width: 100%; text-align: center; font-weight: bold; font-size: 30px;">
            <?php print $arr["nombreEmpresa"];?>
        </td>
    </tr>
    <tr>
        <td style="width: 100%; text-align: center;">
            <?php print $arr["fechaOrden"];?>
        </td>
    </tr>
    <tr>
        <td style="width: 100%; text-align: center;">
            Codigo Venta
            <br>
            <span style="font-weight: bold; font-size: 20px;">
                <?php print str_pad($arr["id"], 10, "0", STR_PAD_LEFT);?>
            </span>
        </td>
    </tr>
    <tr>
        <td style="width: 100%; text-align: left;">
            Nombre: <?php print $arr["nombre"];?>
        </td>
    </tr>
    <tr>
        <td style="width: 100%; text-align: left;">
            NIT: <?php print $arr["nit"];?>
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
                    <td style="width: 10%; text-align: right;" nowrap>Sub-Total</td>
                </tr>
                <?php
                
                while( $rTMP = each($arr["producto"]) ){
                    ?>
                    <tr>
                        <td style="text-align: left;"><?php print "{$rTMP["value"]["codigoProducto"]} - {$rTMP["value"]["descripcion"]}"?></td>
                        <td style="text-align: center;"><?php print intval($rTMP["value"]["cantidad"])?></td>
                        <td style="text-align: right;" nowrap><?php print number_format($rTMP["value"]["subtotal"], 2)?></td>
                    </tr>
                    <?php    
                }
                
                ?>
                    
                
                <tr>
                    <td colspan="3" style="text-align: right; border-top: 1px solid black; ">Total: Q <?php print number_format($arr["total"], 2)?><td>
                    
                </tr>
                <?php
                
                if( $arr["descuento_devolucion"] > 0 ){
                    
                    ?>
                    
                    <tr>
                        <td colspan="3" style="text-align: right; ">Total Descuento: Q -<?php print number_format($arr["descuento_devolucion"], 2)?><td>
                    </tr>    
                    
                    <?php
                    
                    if( $arr["descuento_devolucion"] > $arr["total"] ){
                        ?>
                        <tr>
                            <td colspan="3" style="text-align: right; ">Total Devolucion: Q <?php print number_format($arr["descuento_devolucion"] - $arr["total"], 2)?><td>
                        </tr>
                        <?php    
                    }
                    else{
                        ?>
                        <tr>
                            <td colspan="3" style="text-align: right; ">Total Con Descuento: Q <?php print number_format($arr["total"] - $arr["descuento_devolucion"], 2)?><td>
                        </tr>
                        <?php        
                    }
                    
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
    <tr>
        <td style="width: 100%; text-align: center;">
            Gracias por tu compra
        </td>
    </tr>    
</table>
<script>
    window.print();
</script>
<?php
die();

require_once('assets/tcpdf/tcpdf_config_alt.php');
require_once('assets/tcpdf/tcpdf.php');

$custom_layout = array(50, 50);
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
//$pdf->SetAuthor('Nicola Asuni');
//$pdf->SetTitle('TCPDF Example 002');
//$pdf->SetSubject('TCPDF Tutorial');
//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', 'BI', 20);

// add a page
$pdf->AddPage();

// set some text to print
$txt = <<<EOD
TCPDF Example 002

Default page header and footer are disabled using setPrintHeader() and setPrintFooter() methods.
EOD;

// print a block of text using Write()
$pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_002.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+


?>