<?php
//============================================================+
// File name   : example_006.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 006 for TCPDF class
//               WriteHTML and RTL support
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: WriteHTML and RTL support
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
require_once('assets/TCPDF-main/config/tcpdf_config.php');
require_once('assets/TCPDF-main/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 002');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(2, 2, 2);

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
$pdf->SetFont('helvetica', '', 8);

// add a page
$pdf->AddPage();


// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// create some HTML content
$html = '<table style="width: 100%;" cellspacing="0" cellpadding="0">
            <tr>
                <td style="width: 100%; background-color: #013a7d;">
                    <table style="width: 100%;" cellspacing="0" cellpadding="0">
                        <tr>
                            <td style="width: 30%; background-color: #013a7d;">
                                <img src="assets/img/logo_azul.png">
                                
                            </td>
                            <td style="width: 70%; background-color: #013a7d; text-align: right; vertical-align: middle;">
                                <br>
                                <br>
                                <span style="color: #FFFFFF; font-size: 20px; font-weight: bold;" >SOLICITUD DE CRÉDITO No.</span>
                                <span style="background-color: #FFFFFF; font-size: 25px; color: #013a7d; padding: 5px; border-radius: 2px; font-weight: bold;">2356</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="width: 100%; padding-top: 30px;">
                    <table style="width: 100%;" cellspacing="0" cellpadding="0">
                        <tr>
                            <td style="width: 50%;">
                                
                                <p style="color: #013a7d; text-align: left;">
                                    <span style="font-weight: bold;">OFICINAS ADMINISTRATIVAS</span>
                                    <br>
                                    2a. Calle 23-80, Zona 15, Colonia Vista Hermosa 11,
                                    <br>
                                    Edificio Avante Nivel 10, Guatemala, Guatemala
                                    <br>
                                    PBX: +502 2429-5700 - Fax: +502 2429-5701
                                    <br>
                                    www.leterago.com.gt
                                </p>
                                
                            </td>
                            <td style="width: 50%; text-align: right;">
                                <p style="color: #013a7d; text-align: right;">
                                    <span style="font-weight: bold;">OFICINAS ADMINISTRATIVAS</span>
                                    <br>
                                    Boulevard El Naranjo 28-51
                                    <br>
                                    Zona 4 de Mixco, Guatemala
                                    <br>
                                    PBX: +502 2329-6900
                                    <br>
                                    FAX: +502 2329-6900
                                </p>
                                <br>
                                <br>
                                <br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="width: 100%; padding-top: 30px;">
                    <table style="width: 100%; border: 2px solid #013a7d; border-radius: 5px;" cellspacing="0" cellpadding="0">
                        <tr>
                            <td style="width: 100%; color: #013a7d; text-align: center;">
                                <span style="font-weight: bold;">POR FAVOR LLENAR ESTA SOLICITUD</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 100%; border-top: 2px solid #013a7d; margin: 0px; background-color: #013a7d; color: #FFFFFF; text-align: center;">
                                    <span style="font-weight: bold;">DATOS PERSONALES</span>
                            </td>
                        </tr>
                        <tr>                   
                            <td style="width: 100%;  margin: 0px;">
                                <table style="width: 100%; " cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td style="width: 25%; border-right: 1px solid #013a7d; padding: 5px; ">
                                            <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                PRIMER NOMBRE
                                            </span>
                                            <br>
                                            Yordi
                                        </td>
                                        <td style="width: 25%; border-right: 1px solid #013a7d; padding: 5px; ">
                                            <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                SEGUNDO NOMBRE
                                            </span>
                                            <br>
                                            Roberto
                                        </td>
                                        <td style="width: 25%; border-right: 1px solid #013a7d; padding: 5px; ">
                                            <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                PRIMER APELLIDO
                                            </span>
                                            <br>
                                            Guevara
                                        </td>
                                        <td style="width: 25%; padding: 5px; ">
                                            <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                SEGUNDO APELLIDO
                                            </span>
                                            <br>
                                            Lopez
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 25%; border-right: 1px solid #013a7d; border-top: 1px solid #013a7d; padding: 5px; ">
                                            <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                APELLIDO CASADA
                                            </span>
                                            <br>
                                            Perez
                                        </td>
                                        <td style="width: 25%; border-right: 1px solid #013a7d; border-top: 1px solid #013a7d; padding: 5px; ">
                                            <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                ESTADO CIVIL
                                            </span>
                                            <br>
                                            Unido
                                        </td>
                                        <td style="width: 25%; border-right: 1px solid #013a7d; border-top: 1px solid #013a7d; padding: 5px; ">
                                            <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                FECHA NACIMIENTO
                                            </span>
                                            <br>
                                            20/12/2020
                                        </td>
                                        <td style="width: 25%;  border-top: 1px solid #013a7d; padding: 5px; ">
                                            <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                DPI O PASAPORTE
                                            </span>
                                            <br>
                                            2389025010101
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 25%; border-right: 1px solid #013a7d; border-top: 1px solid #013a7d; padding: 5px; ">
                                            <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                EXTENDIDO EN
                                            </span>
                                            <br>
                                            Guatemala
                                        </td>
                                        <td style="width: 25%; border-right: 1px solid #013a7d; border-top: 1px solid #013a7d; padding: 5px; ">
                                            <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                No. TELEFONO
                                            </span>
                                            <br>
                                            568956568
                                        </td>
                                        <td colspan="2" style=" border-top: 1px solid #013a7d; padding: 5px; ">
                                            <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                ESTADO CIVIL
                                            </span>
                                            <br>
                                            UNIDO
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style=" border-top: 1px solid #013a7d; padding: 5px; ">
                                            <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                DIRECCION COMPLETA DE SU RESIDENCIA
                                            </span>
                                            <br>
                                            Guatemala zONA 11
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 100%; border-top: 2px solid #013a7d; margin: 0px; background-color: #013a7d; color: #FFFFFF; text-align: center;">
                                <span style="font-weight: bold;">DATOS DEL NEGOCIO</span>
                            </td>
                        </tr>
                        <tr>                   
                            <td style="width: 100%;  margin: 0px;">
                                <table style="width: 100%; " cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td colspan="4" style=" padding: 5px; ">
                                            <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                NOMBRE COMERCIAL
                                            </span>
                                            <br>
                                            Yordi
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="border-top: 1px solid #013a7d; padding: 5px; ">
                                            <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                DIRECCION COMPLETA DEL NEGOCIO
                                            </span>
                                            <br>
                                            Yordi
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 25%; border-top: 1px solid #013a7d; border-right: 1px solid #013a7d; padding: 5px; ">
                                            <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                NIT
                                            </span>
                                            <br>
                                            Yordi
                                        </td>
                                        <td style="width: 25%; border-top: 1px solid #013a7d; border-right: 1px solid #013a7d; padding: 5px; ">
                                            <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                PATENTE DE COMERCIO
                                            </span>
                                            <br>
                                            Yordi
                                        </td>
                                        <td style="width: 25%; border-top: 1px solid #013a7d; border-right: 1px solid #013a7d; padding: 5px; ">
                                            <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                CLASE DE NEGOCIO
                                            </span>
                                            <br>
                                            Yordi
                                        </td>
                                        <td style="width: 25%;  border-top: 1px solid #013a7d; padding: 5px; ">
                                            <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                LOCAL
                                            </span>
                                            <br>
                                            Yordi
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style=" border-top: 1px solid #013a7d; border-right: 1px solid #013a7d; padding: 5px; ">
                                            <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                TIEMPO DE TENER EL NEGOCIO
                                            </span>
                                            <br>
                                            Yordi
                                        </td>
                                        <td colspan="3" style=" border-top: 1px solid #013a7d;  padding: 5px; ">
                                            <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                OTROS NEGOCIOS
                                            </span>
                                            <br>
                                            Yordi
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style=" border-top: 1px solid #013a7d;  padding: 5px; ">
                                            <span style="color: #013a7d; text-align: center; font-weight: bold;">
                                                MONTO DE CREDITO SOLICITADO:
                                            </span>
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <span style="color: #013a7d; text-align: center; font-weight: bold;">
                                                Q. 1,000.00
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 100%; border-top: 2px solid #013a7d; margin: 0px; background-color: #013a7d; color: #FFFFFF; text-align: center;">
                                <span style="font-weight: bold;">REFERENCIAS COMERCIALES</span>
                            </td>
                        </tr>
                        <tr>                   
                            <td style="width: 100%;  margin: 0px;">
                                <table style="width: 100%; " cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td style="width: 50%; border-top: 1px solid #013a7d; border-right: 1px solid #013a7d; padding: 5px; ">
                                            <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                NOMBRE DE LA EMPRESA
                                            </span>
                                            <br>
                                            Yordi
                                        </td>
                                        <td style="width: 50%; border-top: 1px solid #013a7d; border-right: 1px solid #013a7d; padding: 5px; ">
                                            <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                TELEFONO No.
                                            </span>
                                            <br>
                                            Yordi
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 100%; border-top: 2px solid #013a7d; margin: 0px; background-color: #013a7d; color: #FFFFFF; text-align: center;">
                                <span style="font-weight: bold;">CONTACTOS INTERNOS CON EL CLIENTE</span>
                            </td>
                        </tr>
                        <tr>                   
                            <td style="width: 100%;  margin: 0px;">
                                <table style="width: 100%; " cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td colspan="3" style="border-top: 1px solid #013a7d; border-right: 1px solid #013a7d; padding: 5px; ">
                                            <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                ENCARGADO DE COMPRAS
                                            </span>
                                            <br>
                                            Yordi
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="border-top: 1px solid #013a7d; border-right: 1px solid #013a7d; padding: 5px; ">
                                            <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                ENCARGADO DE PAGOS
                                            </span>
                                            <br>
                                            Yordi
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 25%; border-top: 1px solid #013a7d; border-right: 1px solid #013a7d; padding: 5px; ">
                                            <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                FORMA DE PAGO
                                            </span>
                                            <br>
                                            Yordi
                                        </td>
                                        <td style="width: 50%; border-top: 1px solid #013a7d; border-right: 1px solid #013a7d; padding: 5px; ">
                                            
                                            <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                PLAZO DEL CREDITO
                                            </span>
                                            <br>
                                            Yordi
                                        </td>
                                        <td style="width: 25%; border-top: 1px solid #013a7d; border-right: 1px solid #013a7d; padding: 5px; ">
                                            <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                DIAS
                                            </span>
                                            <br>
                                            Yordi
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="width: 100%; padding: 30px 10px 10px 10px;">
                    <br>
                    <p style="color: #013a7d; text-align: justify;">
                        AUTORIZO A QUE EN FORMA PERSONAL O POR MEDIO DE TERCEROS SEAN CONFIRMADOS TODOS MIS DATOS POR LA ENTIDAD
                        LETERAGO, S.A., YA SEA EN INFORNET O EN CUALQUIER OTRA ENTIDAD QUE CONSIDERE CONVENIENTE.
                    </p>
                </td>
            </tr>
            <tr>
                <td style="width: 100%; padding: 150px 10px 10px 10px;">
                    <br><br><br><br><br><br><br>
                    <table style="width: 100%; " cellspacing="0" cellpadding="0">
                        <tr>
                            <td style="width: 45%; text-align: center;">
                                <img src="files/5/firma_5_20210518104120.png" style="width: 400px; height: 200px">
                            </td>
                            <td style="width: 10%; ">
                                &nbsp;
                            </td>
                            <td style="width: 45%; text-align: center;">
                                <img src="files/5/firma_5_20210518104120.png" style="width: 400px; height: 200px">
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 45%; color: #013a7d; text-align: center; border-top: 2px solid #013a7d;">
                                FIRMA Y SELLO DEL SOLICITANTE
                            </td>
                            <td style="width: 10%; ">
                                &nbsp;
                            </td>
                            <td style="width: 45%; color: #013a7d; text-align: center; border-top: 2px solid #013a7d;">
                                FIRMA Y SELLO DEL SOLICITANTE
                            </td>
                        </tr>
                    </table>
                    <br>
                    <br>
                </td>
            </tr>
            <tr>
                <td style="width: 100%; padding: 10px 10px 10px 10px; color: #013a7d; text-align: justify; font-size: 10px;">
                    1. Adjuntar fotocopia de patente de comercio, patente de sociedad, DPI de Representante Legal, Representacion Legal, Licencia Sanitaria, RTU actualizado
                </td>
            </tr>
            <tr>
                <td style="width: 100%; padding: 10px 10px 10px 10px; color: #013a7d; text-align: justify; font-size: 10px;">
                    2. El tramite de su solicitud llevara aproximadamente 5 dias habiles para cualquier consulta sobre el tramite de su solicitud llame al 2429-5700
                </td>
            </tr>
            
        </table>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');


//$pdf->Image('files/5/firma_5_20210518104120.png', 0, 0, 75, 23, 'PNG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);


// add a page
$pdf->AddPage();


// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// create some HTML content
$html = '<table style="width: 100%;">
            <tr>
                <td style="width: 100%; background-color: #013a7d; text-align: center;">
                    <span style="color: #FFFFFF; font-size: 20px; font-weight: bold;" >CONVENIO</span>
                    <br>
                </td>
            </tr>
            
            <tr>
                <td style="width: 100%; text-align: justify; margin-top: 0px;">
                        
                        CLIENTE:______________________________________________________________________________________________________________________
                        <br>
                        El presente convenio mercantil se celebra bajo los principios de verdad sabida y buena fe guardada a manera de conservar y proteger las rectas y honorables intensiones y
                        deseos de los contratantes entre LETERAGO, S.A. entidad dedicada a la distribucion de medicamentos, a traves de su representante legar y EL CLIENTE AL CREDITO, que
                        es la persona que recibe el beneficio de que LETERAGO, S.A., le otorgue financiamiento o credito bajo ciertas reglas o condiciones establecidad en el presente documento y
                        leyes mercantiles, para efectos del presente documento se le doniminara EL CLIENTE, Bajo las siguientes clausulas 
                        
                        <b>PRIMERA:</b> LETERAGO, S.A., comparece a travez de
                        su presentante legal, el señor Juan Francisco Letona, casado, de nacionalidad guatemalteca, de <u>&nbsp;&nbsp;&nbsp;&nbsp;20 años&nbsp;&nbsp;&nbsp;&nbsp;</u>, con domicilio en
                        <u>&nbsp;&nbsp;&nbsp;&nbsp;12calle A 3-36 Zona 10&nbsp;&nbsp;&nbsp;&nbsp;</u>, quien se identifica con el codigo unico de identidad, dos mil doscientos ocho espacio setenta y cuatro mil
                        sesenta y nueve espacio cero ciento uno ( 2208 74069 0101 ) y EL CLIENTE quien se identifica como <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>, y
                        es <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>, de nacionalidad <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>, de
                        <u>&nbsp;&nbsp;&nbsp;20 años;&nbsp;&nbsp;&nbsp;&nbsp;</u> de edad, con domicilio en, <u>&nbsp;&nbsp;&nbsp;&nbsp; 20 calle 25-69 zona 10 guatemala&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                        quien se identifica con documento personal de identificacion cuyo codigo personal de identificacion es <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>, extentido
                        por el Registro Nacional de las Personas, 
                        
                        <b>SEGUNDA:</b> LETERAGO, S.A., se compromete a proveer al EL CLIENTE, de los medicamentos que distribuye, de acuerdo al cumplimiento del presente 
                        convenio y de acuerdo a las condiciones economicas del mercado.
                        
                        <b>TERCERA:</b> CREDITO en el financiamiento que LETERAGO, S.A. otorga de buena fe, hasta por el monto y por el plazo establecidos en cada factura cambiaria que se emita por cada despacho y son los
                        documentos que respaldan cada ventas realizada al EL CLIENTE, entendiendose el presente convenio como adicional. El credito otorgado no devengara interes siempre y cuando se cumpla con el plazo pactado.
                        EL CLIENTE hace uso del credito que le otorga LETERAGO, S.A. y acepta las clausuras incluidas en el presente convenio, comprometiendose a cumplir con el pago, dentro del plazo y
                        forma acordadas. La forma de pago puede ser en efectivo, con cheque personal, cheque certificado de caja o de gerencia o mediante deposito efectuado a la cuenta
                        bancaria de <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>. 
                        
                        <b>CUARTA:</b> El despacho de las mercaderias solicitadas por el cliente, se hara de acuerdo a las
                        condiciones establecidas por el departamento de creditos y cobros. LETERAGO, S.A., no despachara un nuevo pedido cuando el clientes muestre saldos vencidos o cuando
                        haya proporcionado un cheque pre-fechado o post-fechado.
                        
                        <b>QUINTA:</b> Cuando el cliente efectue el pago con cheque o este resultare rechazado por caracer de provision de fontos, reserva de cobro, firma, redaccion o fecha incorrecta o cuenta cancelada,
                        este debera cancelar el recargo por gastos administrativos que LETERAGO, S.A. establezca, despues de dos cheques rechazados en adelante no se le aceptaran los pagos con cheque, unicamente en efectivo,
                        deposito en cuenta, cheque de caja o de gerencia.
                        
                        <b>SEXTA:</b> Cuando el cliente incurra en mora, es decir, cuando no cumpla con los pagos en el tiempo establecido, su credito sera suspendido. En tal caso LETERAGO, S.A., cobrara interes por mora de
                        dos por ciento(2.%) mensual sobre saldos atrasados. En caso de que el pago de la obligacion deba ser exigido judicialmente se cobrara interes por financiamiento de conformidad con la tasa
                        promedio de las operaciones activas en el sistema bancario que rija en ese momento de la liquidacion.
                        
                        <b>SEPTIMA:</b> Todos los procentajes, tasa, montos, pagos, limites de credito, plazos y demas condiciones previstas en este convenio en al solicitud de credito o en documentos anexos,
                        podran ser variados por LETERAGO, S.A., a solicitud del cliente o de acuerdo a la situacion cambiante del cliente, sin que esto signifique alteracion con motivo del incumplimiento del presente convenio.
                        
                        <b>OCTAVA:</b> EL CLIENTE asume la obligacion de pagar todos los gastos, recargo o impuestos que se causen con motivo del imcumplimiento del presente convenio.
                        
                        <b>NOVENA:</b> EL CLIENTE se compromete con todos sus bienes al cumplimiento de la presente obligacion, y garantiza que con estos se cubriran la resporibilidad de pagar el salo pendiente
                        en caso de fallecimiento, enfermedad, incapacidad, quiebra o cualquier otro tipo de impedimento del obligado.
                        
                        <b>DECIMO:</b> LETERAGO, S.A. queda autorizado a acceder los creditos y demas derechos provenientes de este convenio por principal o accesorios, total o parcialmente, sin necesidad de previo aviso o
                        porterior notificacion al cliente o al codeudor.
                        
                        <b>DECIMO PRIMERA:</b> Para los efectos de este convenio, EL CLIENTE acepta que en todo tiempo se consideren como saldos verdaderos los que arrojen, los controsl internos de LETERAGO, S.A., en consecuencia
                        en caso de accion judicial para el cobro de saldo vencidos, LETERAGO, S.A. no estara obligada o probar de forma distinta que el saldo vencido y no pagado es el que se expresa en la demanda. Acepta
                        tambien que para los efectos del aviso escrito enviado al clientes, la fecha que expresa dicha copia es la fecha en que el aviso fue dado y recibido. Es facultad de LETERAGO, S.A., el señalamiento del saldo
                        liquido exigible y EL CLIENTE acepta el saldo que asi se señale, servira como titulo ejecutivo acta notarial faccionada por Notario en la cual conste el saldo deudor que arroje la contabilidad 
                        de LETERAGO, S.A.
                        
                        <b>DECIMO SEGUNDA:</b> LETERAGO, S.A., podra rescindir el presente convenio en los casos siguientes: a) Cuando EL CLIENTE se niegue en cualquier forma o figura, a cancelar los saldo vencidos;
                        b) cuando EL CLIENTE haya sufrido pignoracion, hipoteca, embargo o disminucion de bienes decretados en virtud de acciones judiciales iniciadas por terceros o que caiga en quiebra.
                        
                        <b>DECIMO TERCERA:</b> EL CLIENTE se compromete a que respetara en todo momento el plazo establecido de credito, y que el mismo sera plasmado en cada factura que ampare los despachos realizados, asi como
                        que el hecho de que las personas que laboran para el, Al hacer pedidos, lo comprometen directamente, y que se considera valida la recepcion del producto, con la firma de cualquier
                        empleado que plasme su firma en la factura o ducmento de envio, reconociendo desde ya su obligacion de pago para con LETERAGO, S.A., en estos casos.
                        
                        <b>DECIMO CUARTA:</b> El CLIENTE y el codeudor, para los efectos del presente convenio, renuncian al fuero de su domicilio y se sujetan a los Tribunales que el Departamento de Guatemala,
                        LETERAGO, S.A., elija, aceptando desde ya como buenas, y exactas las cuentas que se le presente con relacion a este convenio y como liquidado, ejecutivo y de plazo vencido el pago
                        que se le demande, siendo por su cuenta cualquier gasto ya sea extrajudicail o judicial que del incumplimiento de este convenio se derive, señalando como lugar
                        para recibir notificaciones la indicada en la parte informativa del presente convenio, debiendo comunicar a LETERAGO, S.A., de cualquier cambioque de ella hicieren el entendido
                        de que sino lo hiciere seran validas y bien hechas las que se hagan en el lugar señalado.
                        
                        <b>DECIMO QUINTA:</b> En caso de conflictos relativos a la cancelacion de los despachos pendientes de cobro ya vencidos, incluyendo cargos y penalizaciones, El CLIENTE, renuncia al fuero de su domicilio,
                        incurriendo en DELITO DE APROPIACION Y RETENCION INDEBIDA sometiendose a los Tribunales correspondientes, y para constancia de LETERAGO, S.A., a travez de su representante legal.
                        EL CLIENTE y el codeudor ratifican y acepten todas las clausulas de este convenio, firmado el presente docuemtno en la Ciudad de Guatemal a los <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> dias
                        del mes de <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> de dos mil <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>.                
                            
                        
                </td>
            </tr>
            <tr>
                <td style="width: 100%; padding: 150px 10px 10px 10px;">
                    <br>
                    <br>
                    <br>
                    <br>
                    <table style="width: 100%; " cellspacing="0" cellpadding="0">
                        <tr>
                            <td style="width: 45%; text-align: center;">
                                <img src="files/5/firma_5_20210518104120.png" style="width: 400px; height: 200px">
                            </td>
                            <td style="width: 10%; ">
                                &nbsp;
                            </td>
                            <td style="width: 45%; text-align: center;">
                                <img src="files/5/firma_5_20210518104120.png" style="width: 400px; height: 200px">
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 45%; color: #013a7d; text-align: center; border-top: 2px solid #013a7d;">
                                EL CLIENTE
                            </td>
                            <td style="width: 10%; ">
                                &nbsp;
                            </td>
                            <td style="width: 45%; color: #013a7d; text-align: center; border-top: 2px solid #013a7d;">
                                LETERAGO, S.A.
                            </td>
                        </tr>
                    </table>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    
                    <br><br><br><br><br>
                </td>
            </tr>
            
            <tr>
                <td style="width: 100%; text-align: center; color: #013a7d; margin-bottom: 0px; font-weight: bold; font-size: 20px;">
                        
                        ACTA DE LEGALIZACION DE FIRMAS
                </td>
            </tr>
            
            <tr>
                <td style="width: 100%; padding-top: 20px; text-align: justify; margin-top: 0px;">
                        
                    En la Ciudad de Guatemala a los <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> dias del mes de <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                    de dos mil <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> YO, el infrascito Notario DOY FE: que las
                    firmas que anteceden son AUTENTICAS, por haber sido puestas en mi presencia el dia de hoy por los señores: EL CLIENTE quien se
                    identifica como <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>, y se identifica con el documento personal
                    de identificacion, cuyo codigo unico de identificacion es <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>, extendido
                    por el Registro Nacional de las Personas, por EL CODEUDOR quien se identifica como <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>, y
                    se identifica con docuemnto personal de identificacion, cuyo codigo unico de identificacion es <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>, extendido
                    por el Registro Nacional de las Personas, y por el Representante Legal de entidad LETERAGO, Sociedad Anonima, señor Juan Francisco Letona, casado, de nacionalidad
                    guatemalteca, quien se identifica con codigo unico de identidad, dos mil doscientes ocho espacio setenta y cuantromil sesenta y nuevo espacio
                    cero ciento uno (2208 74069 0101). Los signatarios en señal de buenafe firman con el
                         
                            
                </td>
            </tr>
            
            <tr>
                <td style="width: 100%; padding: 100px 10px 10px 10px;">
                    <table style="width: 100%; " cellspacing="0" cellpadding="0">
                        <tr>
                            <td style="width: 45%; ">
                                <br><br><br>
                                <table style="width: 100%; " cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td style="width: 100%; text-align: center;">
                                            <img src="files/5/firma_5_20210518104120.png" style="width: 400px; height: 200px">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100%; color: #013a7d; text-align: center; border-top: 2px solid #013a7d;">
                                            EL CLIENTE
                                            <br><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100%; text-align: center;">
                                            <img src="files/5/firma_5_20210518104120.png" style="width: 400px; height: 200px">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100%; color: #013a7d; text-align: center; border-top: 2px solid #013a7d;">
                                            LETERAGO, S.A.
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width: 10%; ">
                                &nbsp;
                            </td>
                            <td style="width: 45%; ">
                            <br><br><br><br><br>
                                <p style="text-align: center; color: #013a7d; margin-bottom: 0px; font-weight: bold; font-size: 20px;">
                                    ANTE MI;
                                </p>
                                <p style="padding-top: 30px; text-align: justify; margin-top: 0px;">
                                    Autorizo voluntariamente que la informacion recopilada y/o proporcionada por entidades publicas
                                    o privadas y la generada de relaciones contractuales, credicticias o comerciales, sea reportada
                                    a centrales de registro o buros de credito para ser tratada, almacenada o transferida; y autorizo
                                    expresamente a las entidades que presntan servicios de informacion, centrales de riesgo y buros
                                    de credito, a recopilar, difundir o comercializar reportes o estudios que contengan informacion
                                    sobre mi persona. 
                                </p>    
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
        </table>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

           

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// reset pointer to the last page
//$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
//$pdf->Output('example_006.pdf', 'I'); // E email
//$pdf->Output('example_006.pdf', 'I');
$strBAse64 = $pdf->Output('example_006.pdf', 'S');

print base64_encode($strBAse64);

//============================================================+
// END OF FILE
//============================================================+
die();
?>
<table style="width: 60%;">
    <tr>
        <td style="width: 100%; background-color: #013a7d;">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 100%; background-color: #013a7d; text-align: center;">
                        <span style="color: #FFFFFF; font-size: 30px; font-weight: bold;" >CONVENIO</span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    
    <tr>
        <td style="width: 100%; padding-top: 20px;">
                
            <p style="text-align: justify; margin-bottom: 0px;">
                CLIENTE:______________________________________________________________________________________________________________________________
            </p>
                
            <p style="text-align: justify; margin-top: 0px;">
                El presente convenio mercantil se celebra bajo los principios de verdad sabida y buena fe guardada a manera de conservar y proteger las rectas y honorables intensiones y
                deseos de los contratantes entre LETERAGO, S.A. entidad dedicada a la distribucion de medicamentos, a traves de su representante legar y EL CLIENTE AL CREDITO, que
                es la persona que recibe el beneficio de que LETERAGO, S.A., le otorgue financiamiento o credito bajo ciertas reglas o condiciones establecidad en el presente documento y
                leyes mercantiles, para efectos del presente documento se le doniminara EL CLIENTE, Bajo las siguientes clausulas 
                
                <b>PRIMERA:</b> LETERAGO, S.A., comparece a travez de
                su presentante legal, el señor Juan Francisco Letona, casado, de nacionalidad guatemalteca, de <u>&nbsp;&nbsp;&nbsp;&nbsp;20 años&nbsp;&nbsp;&nbsp;&nbsp;</u>, con domicilio en
                <u>&nbsp;&nbsp;&nbsp;&nbsp;12calle A 3-36 Zona 10&nbsp;&nbsp;&nbsp;&nbsp;</u>, quien se identifica con el codigo unico de identidad, dos mil doscientos ocho espacio setenta y cuatro mil
                sesenta y nueve espacio cero ciento uno ( 2208 74069 0101 ) y EL CLIENTE quien se identifica como <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>, y
                es <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>, de nacionalidad <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>, de
                <u>&nbsp;&nbsp;&nbsp;20 años;&nbsp;&nbsp;&nbsp;&nbsp;</u> de edad, con domicilio en, <u>&nbsp;&nbsp;&nbsp;&nbsp; 20 calle 25-69 zona 10 guatemala&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                quien se identifica con documento personal de identificacion cuyo codigo personal de identificacion es <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>, extentido
                por el Registro Nacional de las Personas, 
                
                <b>SEGUNDA:</b> LETERAGO, S.A., se compromete a proveer al EL CLIENTE, de los medicamentos que distribuye, de acuerdo al cumplimiento del presente 
                convenio y de acuerdo a las condiciones economicas del mercado.
                
                <b>TERCERA:</b> CREDITO en el financiamiento que LETERAGO, S.A. otorga de buena fe, hasta por el monto y por el plazo establecidos en cada factura cambiaria que se emita por cada despacho y son los
                documentos que respaldan cada ventas realizada al EL CLIENTE, entendiendose el presente convenio como adicional. El credito otorgado no devengara interes siempre y cuando se cumpla con el plazo pactado.
                EL CLIENTE hace uso del credito que le otorga LETERAGO, S.A. y acepta las clausuras incluidas en el presente convenio, comprometiendose a cumplir con el pago, dentro del plazo y
                forma acordadas. La forma de pago puede ser en efectivo, con cheque personal, cheque certificado de caja o de gerencia o mediante deposito efectuado a la cuenta
                bancaria de <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>. 
                
                <b>CUARTA:</b> El despacho de las mercaderias solicitadas por el cliente, se hara de acuerdo a las
                condiciones establecidas por el departamento de creditos y cobros. LETERAGO, S.A., no despachara un nuevo pedido cuando el clientes muestre saldos vencidos o cuando
                haya proporcionado un cheque pre-fechado o post-fechado.
                
                <b>QUINTA:</b> Cuando el cliente efectue el pago con cheque o este resultare rechazado por caracer de provision de fontos, reserva de cobro, firma, redaccion o fecha incorrecta o cuenta cancelada,
                este debera cancelar el recargo por gastos administrativos que LETERAGO, S.A. establezca, despues de dos cheques rechazados en adelante no se le aceptaran los pagos con cheque, unicamente en efectivo,
                deposito en cuenta, cheque de caja o de gerencia.
                
                <b>SEXTA:</b> Cuando el cliente incurra en mora, es decir, cuando no cumpla con los pagos en el tiempo establecido, su credito sera suspendido. En tal caso LETERAGO, S.A., cobrara interes por mora de
                dos por ciento(2.%) mensual sobre saldos atrasados. En caso de que el pago de la obligacion deba ser exigido judicialmente se cobrara interes por financiamiento de conformidad con la tasa
                promedio de las operaciones activas en el sistema bancario que rija en ese momento de la liquidacion.
                
                <b>SEPTIMA:</b> Todos los procentajes, tasa, montos, pagos, limites de credito, plazos y demas condiciones previstas en este convenio en al solicitud de credito o en documentos anexos,
                podran ser variados por LETERAGO, S.A., a solicitud del cliente o de acuerdo a la situacion cambiante del cliente, sin que esto signifique alteracion con motivo del incumplimiento del presente convenio.
                
                <b>OCTAVA:</b> EL CLIENTE asume la obligacion de pagar todos los gastos, recargo o impuestos que se causen con motivo del imcumplimiento del presente convenio.
                
                <b>NOVENA:</b> EL CLIENTE se compromete con todos sus bienes al cumplimiento de la presente obligacion, y garantiza que con estos se cubriran la resporibilidad de pagar el salo pendiente
                en caso de fallecimiento, enfermedad, incapacidad, quiebra o cualquier otro tipo de impedimento del obligado.
                
                <b>DECIMO:</b> LETERAGO, S.A. queda autorizado a acceder los creditos y demas derechos provenientes de este convenio por principal o accesorios, total o parcialmente, sin necesidad de previo aviso o
                porterior notificacion al cliente o al codeudor.
                
                <b>DECIMO PRIMERA:</b> Para los efectos de este convenio, EL CLIENTE acepta que en todo tiempo se consideren como saldos verdaderos los que arrojen, los controsl internos de LETERAGO, S.A., en consecuencia
                en caso de accion judicial para el cobro de saldo vencidos, LETERAGO, S.A. no estara obligada o probar de forma distinta que el saldo vencido y no pagado es el que se expresa en la demanda. Acepta
                tambien que para los efectos del aviso escrito enviado al clientes, la fecha que expresa dicha copia es la fecha en que el aviso fue dado y recibido. Es facultad de LETERAGO, S.A., el señalamiento del saldo
                liquido exigible y EL CLIENTE acepta el saldo que asi se señale, servira como titulo ejecutivo acta notarial faccionada por Notario en la cual conste el saldo deudor que arroje la contabilidad 
                de LETERAGO, S.A.
                
                <b>DECIMO SEGUNDA:</b> LETERAGO, S.A., podra rescindir el presente convenio en los casos siguientes: a) Cuando EL CLIENTE se niegue en cualquier forma o figura, a cancelar los saldo vencidos;
                b) cuando EL CLIENTE haya sufrido pignoracion, hipoteca, embargo o disminucion de bienes decretados en virtud de acciones judiciales iniciadas por terceros o que caiga en quiebra.
                
                <b>DECIMO TERCERA:</b> EL CLIENTE se compromete a que respetara en todo momento el plazo establecido de credito, y que el mismo sera plasmado en cada factura que ampare los despachos realizados, asi como
                que el hecho de que las personas que laboran para el, Al hacer pedidos, lo comprometen directamente, y que se considera valida la recepcion del producto, con la firma de cualquier
                empleado que plasme su firma en la factura o ducmento de envio, reconociendo desde ya su obligacion de pago para con LETERAGO, S.A., en estos casos.
                
                <b>DECIMO CUARTA:</b> El CLIENTE y el codeudor, para los efectos del presente convenio, renuncian al fuero de su domicilio y se sujetan a los Tribunales que el Departamento de Guatemala,
                LETERAGO, S.A., elija, aceptando desde ya como buenas, y exactas las cuentas que se le presente con relacion a este convenio y como liquidado, ejecutivo y de plazo vencido el pago
                que se le demande, siendo por su cuenta cualquier gasto ya sea extrajudicail o judicial que del incumplimiento de este convenio se derive, señalando como lugar
                para recibir notificaciones la indicada en la parte informativa del presente convenio, debiendo comunicar a LETERAGO, S.A., de cualquier cambioque de ella hicieren el entendido
                de que sino lo hiciere seran validas y bien hechas las que se hagan en el lugar señalado.
                
                <b>DECIMO QUINTA:</b> En caso de conflictos relativos a la cancelacion de los despachos pendientes de cobro ya vencidos, incluyendo cargos y penalizaciones, El CLIENTE, renuncia al fuero de su domicilio,
                incurriendo en DELITO DE APROPIACION Y RETENCION INDEBIDA sometiendose a los Tribunales correspondientes, y para constancia de LETERAGO, S.A., a travez de su representante legal.
                EL CLIENTE y el codeudor ratifican y acepten todas las clausulas de este convenio, firmado el presente docuemtno en la Ciudad de Guatemal a los <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> dias
                del mes de <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> de dos mil <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>.                
            </p>
                    
        </td>
    </tr>
    <tr>
        <td style="width: 100%; padding: 150px 10px 10px 10px;">
            <table style="width: 100%; " cellspacing="0" cellpadding="0">
                <tr>
                    <td style="width: 45%; ">
                        <p style="color: #013a7d; text-align: center; border-top: 2px solid #013a7d;">
                            EL CLIENTE
                        </p>
                    </td>
                    <td style="width: 10%; ">
                        &nbsp;
                    </td>
                    <td style="width: 45%; ">
                        <p style="color: #013a7d; text-align: center; border-top: 2px solid #013a7d;">
                            LETERAGO, S.A.
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    
    <tr>
        <td style="width: 100%; padding-top: 20px;">
                
            <p style="text-align: center; color: #013a7d; margin-bottom: 0px; font-weight: bold; font-size: 20px;">
                ACTA DE LEGALIZACION DE FIRMAS
            </p>
                
            <p style="text-align: justify; margin-top: 0px;">
                En la Ciudad de Guatemala a los <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> dias del mes de <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                de dos mil <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> YO, el infrascito Notario DOY FE: que las
                firmas que anteceden son AUTENTICAS, por haber sido puestas en mi presencia el dia de hoy por los señores: EL CLIENTE quien se
                identifica como <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>, y se identifica con el documento personal
                de identificacion, cuyo codigo unico de identificacion es <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>, extendido
                por el Registro Nacional de las Personas, por EL CODEUDOR quien se identifica como <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>, y
                se identifica con docuemnto personal de identificacion, cuyo codigo unico de identificacion es <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>, extendido
                por el Registro Nacional de las Personas, y por el Representante Legal de entidad LETERAGO, Sociedad Anonima, señor Juan Francisco Letona, casado, de nacionalidad
                guatemalteca, quien se identifica con codigo unico de identidad, dos mil doscientes ocho espacio setenta y cuantromil sesenta y nuevo espacio
                cero ciento uno (2208 74069 0101). Los signatarios en señal de buenafe firman con el
                 
            </p>
                    
        </td>
    </tr>
    
    <tr>
        <td style="width: 100%; padding: 100px 10px 10px 10px;">
            <table style="width: 100%; " cellspacing="0" cellpadding="0">
                <tr>
                    <td style="width: 45%; ">
                        <p style="color: #013a7d; text-align: center; border-top: 2px solid #013a7d;">
                            EL CLIENTE
                        </p>
                        
                        <p style="margin-top: 100px; color: #013a7d; text-align: center; border-top: 2px solid #013a7d;">
                            LETERAGO, S.A.
                        </p>
                        
                    </td>
                    <td style="width: 10%; ">
                        &nbsp;
                    </td>
                    <td style="width: 45%; ">
                        <p style="text-align: center; color: #013a7d; margin-bottom: 0px; font-weight: bold; font-size: 20px;">
                            ANTE MI;
                        </p>
                        <p style="padding-top: 30px; text-align: justify; margin-top: 0px;">
                            Autorizo voluntariamente que la informacion recopilada y/o proporcionada por entidades publicas
                            o privadas y la generada de relaciones contractuales, credicticias o comerciales, sea reportada
                            a centrales de registro o buros de credito para ser tratada, almacenada o transferida; y autorizo
                            expresamente a las entidades que presntan servicios de informacion, centrales de riesgo y buros
                            de credito, a recopilar, difundir o comercializar reportes o estudios que contengan informacion
                            sobre mi persona. 
                        </p>    
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    
</table>

<br>
<br>
<br>
<br>
<br>
<br>

<table style="width: 60%;">
    <tr>
        <td style="width: 100%; background-color: #013a7d;">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 30%; background-color: #013a7d;">
                        <img src="assets/img/logo_azul.png">
                    </td>
                    <td style="width: 70%; background-color: #013a7d; text-align: right;">
                        <span style="color: #FFFFFF; font-size: 30px; font-weight: bold;" >SOLICITUD DE CRÉDITO No.</span>
                        <span style="background-color: #FFFFFF; font-size: 25px; color: #013a7d; padding: 5px; border-radius: 2px; font-weight: bold;">2356</span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="width: 100%; padding-top: 30px;">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 50%;">
                        
                        <p style="color: #013a7d; text-align: left;">
                            <span style="font-weight: bold;">OFICINAS ADMINISTRATIVAS</span>
                            <br>
                            2a. Calle 23-80, Zona 15, Colonia Vista Hermosa 11,
                            <br>
                            Edificio Avante Nivel 10, Guatemala, Guatemala
                            <br>
                            PBX: +502 2429-5700 - Fax: +502 2429-5701
                            <br>
                            www.leterago.com.gt
                        </p>
                        
                    </td>
                    <td style="width: 50%; text-align: right;">
                        <p style="color: #013a7d; text-align: right;">
                            <span style="font-weight: bold;">OFICINAS ADMINISTRATIVAS</span>
                            <br>
                            Boulevard El Naranjo 28-51
                            <br>
                            Zona 4 de Mixco, Guatemala
                            <br>
                            PBX: +502 2329-6900
                            <br>
                            FAX: +502 2329-6900
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="width: 100%; padding-top: 30px;">
            <table style="width: 100%; border: 2px solid #013a7d; border-radius: 5px;" cellspacing="0" cellpadding="0">
                <tr>
                    <td style="width: 100%; color: #013a7d; text-align: center;">
                        <span style="font-weight: bold;">POR FAVOR LLENAR ESTA SOLICITUD</span>
                    </td>
                </tr>
                <tr>
                    <td style="width: 100%; border-top: 2px solid #013a7d; margin: 0px; background-color: #013a7d; color: #FFFFFF; text-align: center;">
                            <span style="font-weight: bold;">DATOS PERSONALES</span>
                    </td>
                </tr>
                <tr>                   
                    <td style="width: 100%;  margin: 0px;">
                        <table style="width: 100%; " cellspacing="0" cellpadding="0">
                            <tr>
                                <td style="width: 25%; border-right: 1px solid #013a7d; padding: 5px; ">
                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                        PRIMER NOMBRE
                                    </span>
                                    <br>
                                    Yordi
                                </td>
                                <td style="width: 25%; border-right: 1px solid #013a7d; padding: 5px; ">
                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                        SEGUNDO NOMBRE
                                    </span>
                                    <br>
                                    Roberto
                                </td>
                                <td style="width: 25%; border-right: 1px solid #013a7d; padding: 5px; ">
                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                        PRIMER APELLIDO
                                    </span>
                                    <br>
                                    Guevara
                                </td>
                                <td style="width: 25%; padding: 5px; ">
                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                        SEGUNDO APELLIDO
                                    </span>
                                    <br>
                                    Lopez
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 25%; border-right: 1px solid #013a7d; border-top: 1px solid #013a7d; padding: 5px; ">
                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                        APELLIDO CASADA
                                    </span>
                                    <br>
                                    Perez
                                </td>
                                <td style="width: 25%; border-right: 1px solid #013a7d; border-top: 1px solid #013a7d; padding: 5px; ">
                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                        ESTADO CIVIL
                                    </span>
                                    <br>
                                    Unido
                                </td>
                                <td style="width: 25%; border-right: 1px solid #013a7d; border-top: 1px solid #013a7d; padding: 5px; ">
                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                        FECHA NACIMIENTO
                                    </span>
                                    <br>
                                    20/12/2020
                                </td>
                                <td style="width: 25%;  border-top: 1px solid #013a7d; padding: 5px; ">
                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                        DPI O PASAPORTE
                                    </span>
                                    <br>
                                    2389025010101
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 25%; border-right: 1px solid #013a7d; border-top: 1px solid #013a7d; padding: 5px; ">
                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                        EXTENDIDO EN
                                    </span>
                                    <br>
                                    Guatemala
                                </td>
                                <td style="width: 25%; border-right: 1px solid #013a7d; border-top: 1px solid #013a7d; padding: 5px; ">
                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                        No. TELEFONO
                                    </span>
                                    <br>
                                    568956568
                                </td>
                                <td colspan="2" style=" border-top: 1px solid #013a7d; padding: 5px; ">
                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                        ESTADO CIVIL
                                    </span>
                                    <br>
                                    UNIDO
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" style=" border-top: 1px solid #013a7d; padding: 5px; ">
                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                        DIRECCION COMPLETA DE SU RESIDENCIA
                                    </span>
                                    <br>
                                    Guatemala zONA 11
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="width: 100%; border-top: 2px solid #013a7d; margin: 0px; background-color: #013a7d; color: #FFFFFF; text-align: center;">
                        <span style="font-weight: bold;">DATOS DEL NEGOCIO</span>
                    </td>
                </tr>
                <tr>                   
                    <td style="width: 100%;  margin: 0px;">
                        <table style="width: 100%; " cellspacing="0" cellpadding="0">
                            <tr>
                                <td colspan="4" style=" padding: 5px; ">
                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                        NOMBRE COMERCIAL
                                    </span>
                                    <br>
                                    Yordi
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" style="border-top: 1px solid #013a7d; padding: 5px; ">
                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                        DIRECCION COMPLETA DEL NEGOCIO
                                    </span>
                                    <br>
                                    Yordi
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 25%; border-top: 1px solid #013a7d; border-right: 1px solid #013a7d; padding: 5px; ">
                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                        NIT
                                    </span>
                                    <br>
                                    Yordi
                                </td>
                                <td style="width: 25%; border-top: 1px solid #013a7d; border-right: 1px solid #013a7d; padding: 5px; ">
                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                        PATENTE DE COMERCIO
                                    </span>
                                    <br>
                                    Yordi
                                </td>
                                <td style="width: 25%; border-top: 1px solid #013a7d; border-right: 1px solid #013a7d; padding: 5px; ">
                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                        CLASE DE NEGOCIO
                                    </span>
                                    <br>
                                    Yordi
                                </td>
                                <td style="width: 25%;  border-top: 1px solid #013a7d; padding: 5px; ">
                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                        LOCAL
                                    </span>
                                    <br>
                                    Yordi
                                </td>
                            </tr>
                            <tr>
                                <td style=" border-top: 1px solid #013a7d; border-right: 1px solid #013a7d; padding: 5px; ">
                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                        TIEMPO DE TENER EL NEGOCIO
                                    </span>
                                    <br>
                                    Yordi
                                </td>
                                <td colspan="3" style=" border-top: 1px solid #013a7d;  padding: 5px; ">
                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                        OTROS NEGOCIOS
                                    </span>
                                    <br>
                                    Yordi
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" style=" border-top: 1px solid #013a7d;  padding: 5px; ">
                                    <span style="color: #013a7d; text-align: center; font-weight: bold;">
                                        MONTO DE CREDITO SOLICITADO:
                                    </span>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <span style="color: #013a7d; text-align: center; font-weight: bold;">
                                        Q. 1,000.00
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="width: 100%; border-top: 2px solid #013a7d; margin: 0px; background-color: #013a7d; color: #FFFFFF; text-align: center;">
                        <span style="font-weight: bold;">REFERENCIAS COMERCIALES</span>
                    </td>
                </tr>
                <tr>                   
                    <td style="width: 100%;  margin: 0px;">
                        <table style="width: 100%; " cellspacing="0" cellpadding="0">
                            <tr>
                                <td style="width: 50%; border-top: 1px solid #013a7d; border-right: 1px solid #013a7d; padding: 5px; ">
                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                        NOMBRE DE LA EMPRESA
                                    </span>
                                    <br>
                                    Yordi
                                </td>
                                <td style="width: 50%; border-top: 1px solid #013a7d; border-right: 1px solid #013a7d; padding: 5px; ">
                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                        TELEFONO No.
                                    </span>
                                    <br>
                                    Yordi
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="width: 100%; border-top: 2px solid #013a7d; margin: 0px; background-color: #013a7d; color: #FFFFFF; text-align: center;">
                        <span style="font-weight: bold;">CONTACTOS INTERNOS CON EL CLIENTE</span>
                    </td>
                </tr>
                <tr>                   
                    <td style="width: 100%;  margin: 0px;">
                        <table style="width: 100%; " cellspacing="0" cellpadding="0">
                            <tr>
                                <td colspan="3" style="border-top: 1px solid #013a7d; border-right: 1px solid #013a7d; padding: 5px; ">
                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                        ENCARGADO DE COMPRAS
                                    </span>
                                    <br>
                                    Yordi
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="border-top: 1px solid #013a7d; border-right: 1px solid #013a7d; padding: 5px; ">
                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                        ENCARGADO DE PAGOS
                                    </span>
                                    <br>
                                    Yordi
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 25%; border-top: 1px solid #013a7d; border-right: 1px solid #013a7d; padding: 5px; ">
                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                        FORMA DE PAGO
                                    </span>
                                    <br>
                                    Yordi
                                </td>
                                <td style="width: 50%; border-top: 1px solid #013a7d; border-right: 1px solid #013a7d; padding: 5px; ">
                                    
                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                        PLAZO DEL CREDITO
                                    </span>
                                    <br>
                                    Yordi
                                </td>
                                <td style="width: 25%; border-top: 1px solid #013a7d; border-right: 1px solid #013a7d; padding: 5px; ">
                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                        DIAS
                                    </span>
                                    <br>
                                    Yordi
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="width: 100%; padding: 30px 10px 10px 10px;">
            <p style="color: #013a7d; text-align: justify;">
                AUTORIZO A QUE EN FORMA PERSONAL O POR MEDIO DE TERCEROS SEAN CONFIRMADOS TODOS MIS DATOS POR LA ENTIDAD
                LETERAGO, S.A., YA SEA EN INFORNET O EN CUALQUIER OTRA ENTIDAD QUE CONSIDERE CONVENIENTE.
            </p>
        </td>
    </tr>
    <tr>
        <td style="width: 100%; padding: 150px 10px 10px 10px;">
            <table style="width: 100%; " cellspacing="0" cellpadding="0">
                <tr>
                    <td style="width: 45%; ">
                        <p style="color: #013a7d; text-align: center; border-top: 2px solid #013a7d;">
                            FIRMA Y SELLA DEL SOLICITANTE
                        </p>
                    </td>
                    <td style="width: 10%; ">
                        &nbsp;
                    </td>
                    <td style="width: 45%; ">
                        <p style="color: #013a7d; text-align: center; border-top: 2px solid #013a7d;">
                            FIRMA Y SELLA DEL SOLICITANTE
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="width: 100%; padding: 10px 10px 10px 10px; color: #013a7d; text-align: justify; font-size: 14px;">
            1. Adjuntar fotocopia de patente de comercio, patente de sociedad, DPI de Representante Legal, Representacion Legal, Licencia Sanitaria, RTU actualizado
        </td>
    </tr>
    <tr>
        <td style="width: 100%; padding: 10px 10px 10px 10px; color: #013a7d; text-align: justify; font-size: 14px;">
            2. El tramite de su solicitud llevara aproximadamente 5 dias habiles para cualquier consulta sobre el tramite de su solicitud llame al 2429-5700
        </td>
    </tr>
</table>