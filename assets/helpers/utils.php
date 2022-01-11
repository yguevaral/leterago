<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class utils {
    /*     * ******** Metodo para eliminar sesion ********* */

    public static function deleteSession($name) {
        if (isset($_SESSION[$name])) {
            $_SESSION[$name] = null;
            unset($_SESSION[$name]);
        }

        return $name;
    }

    /*     * ******** Metodos para encontrar nombres por medio de id's ********* */

    public static function getTipoDatoPAById($id) {
        $tipo_dato = new tipoDatoPA();
        $tipo_dato->setId($id);
        $nombre_tipo_dato = $tipo_dato->getNameById();

        $nombre_tipo_dato = $nombre_tipo_dato->fetch_object();

        return $nombre_tipo_dato->nombreDato;
    }

    public static function getTipoDatoTTById($id) {
        $tipo_dato = new tipoDatoTT();
        $tipo_dato->setId($id);
        $nombre_tipo_dato = $tipo_dato->getNameById();

        $nombre_tipo_dato = $nombre_tipo_dato->fetch_object();

        return $nombre_tipo_dato->nombreDato;
    }

    public static function getBancoById($id) {
        $catBanco = new catBanco();
        $catBanco->setId($id);
        $nombre_banco = $catBanco->getNameById();

        $nombre_banco = $nombre_banco->fetch_object();

        return $nombre_banco->nombreBanco;
    }

    public static function getDepartamentoById($cod_iso) {
        $departamento = new catDepartamento();
        $departamento->setCodIso($cod_iso);
        $nombre_depto = $departamento->getNameById();

        $nombre_depto = $nombre_depto->fetch_object();

        return $nombre_depto->nombre;
    }

    public static function getMunicipioById($cod_iso_departamento, $cod_municipio) {
        $municipio = new catMunicipio();
        $municipio->setCodIsoDepartamento($cod_iso_departamento);
        $municipio->setCodMunicipio($cod_municipio);
        $nombre_municipio = $municipio->getNameById();

        $nombre_municipio = $nombre_municipio->fetch_object();

        return $nombre_municipio->nombre;
    }

    public static function getPrendaArticuloById($id_prenda_articulo) {
        $idEmpresa = $_SESSION['identity-imsalesys']->idEmpresa;

        if (!isset($id_prenda_articulo)) {
            return " ";
        } else {

            $prenda = new catPrendaArticulo();
            $prenda->setIdEmpresa($idEmpresa);
            $prenda->setIdPrendaArticulo($id_prenda_articulo);
            $nombre_prenda = $prenda->getNameById();

            $nombre_prenda = $nombre_prenda->fetch_object();

            return $nombre_prenda->nombrePrendaArticulo;
        }
    }

    public static function getTallaTamanoById($id_talla_tamano) {
        $idEmpresa = $_SESSION['identity-imsalesys']->idEmpresa;

        if (!isset($id_talla_tamano)) {
            return " ";
        } else {

            $talla = new catTallaTamano();
            $talla->setIdEmpresa($idEmpresa);
            $talla->setIdTallaTamano($id_talla_tamano);
            $nombre_talla = $talla->getNameById();

            $nombre_talla = $nombre_talla->fetch_object();

            return $nombre_talla->nombreTallaTamano;
        }
    }

    public static function getEstadoAIById($id_estado) {
        $estado = new catEstadoAI();
        $estado->setId($id_estado);
        $nombre_estado = $estado->getNameById();
        $nombre_estado = $nombre_estado->fetch_object();

        return $nombre_estado->nombreEstado;
    }

    public static function getAccesoById($id_acceso) {
        $acceso = new catAcceso();
        $acceso->setId($id_acceso);
        $nombre_acceso = $acceso->getOneById();
        $nombre_acceso = $nombre_acceso->fetch_object();

        return $nombre_acceso->nombre;
    }

    public static function getPerfilById($id_perfil) {
        $perfil = new Perfil();
        $perfil->setId($id_perfil);
        $nombre_perfil = $perfil->getOneById();
        $nombre_perfil = $nombre_perfil->fetch_object();

        return $nombre_perfil->nombre;
    }

    public static function getEstadoOrdenById($id_estado) {
        $estado = new catEstadoTracking();
        $estado->setId($id_estado);
        $nombre_estado = $estado->getNameById();
        $nombre_estado = $nombre_estado->fetch_object();

        return $nombre_estado->nombreTracking;
    }

    public static function getColorById($id_color) {
        $idEmpresa = $_SESSION['identity-imsalesys']->idEmpresa;

        if (!isset($id_color)) {
            return " ";
        } else {

            $color = new catColor();
            $color->setIdEmpresa($idEmpresa);
            $color->setId($id_color);
            $nombre_color = $color->getNameById();

            $nombre_color = $nombre_color->fetch_object();

            return $nombre_color->nombreColor;
        }
    }

    public static function getEmpresaById($id_empresa) {
        $empresa = new empresa();
        $empresa->setId($id_empresa);
        $_empresa = $empresa->getEmpresaById();
        $_empresa = $_empresa->fetch_object();
        if ($id_empresa == 0) {
            return "Sin empresa";
        }
        return $_empresa->nombreEmpresa;
    }

    public static function getRolById($id_rol) {
        $rol = new catRol();
        $rol->setId($id_rol);
        $_rol = $rol->getRolById();
        $_rol = $_rol->fetch_object();

        return $_rol->nombreRol;
    }

    /*     * ******** Metodos para validar identificación y roles ********* */

    public static function isIdentity() {
        if (!isset($_SESSION['leterago'])) {
            header("Location:" . base_url);
        } else {
            return true;
        }
    }

    public static function whatRol() {
        $identity = $_SESSION['identity-imsalesys'];

        return $identity->idRol;
    }

    public static function adminCompanies() {
        $identity = $_SESSION['identity-imsalesys'];

        $usuario = new usuario();
        $usuario->setId($identity->id);
        $result = $usuario->getEmpresaByUserAdmin();
        $count = $result->num_rows;

        $response = false;
        if ($count > 0) {
            $response = $result;
        }

        return $response;
    }

    public static function hasDelivery($id_empresa) {
        $empresa = new empresa();
        $empresa->setId($id_empresa);
        $mensajeria = $empresa->getEmpresaById()->fetch_object()->mensajeria;

        return $mensajeria;
    }

    public static function hasRoutes($id_empresa) {
        $empresa = new empresa();
        $empresa->setId($id_empresa);
        $rutas = $empresa->getEmpresaById()->fetch_object()->rutas;

        return $rutas;
    }

    /*     * ***********Metodo para formatear fechas ******************* */

    public static function DB2Fecha($fecha) {
        $fecha = explode("-", $fecha);
        $fecha = $fecha[2] . "/" . $fecha[1] . "/" . $fecha[0];

        return $fecha;
    }

    /*     * ******** Metodo para validar caracteristicas del sistema ********** */

    public static function drawDebug($strContent = "") {


        if ($strContent == "" || $strContent == null || $strContent == false) {
            var_dump($strContent);
        } else {
            print_r("<pre style='text-align: left!important; direction:ltr;'>\r\r");
            print_r($strContent);
            print_r("\r\r</pre>");
        }
    }

    public static function getIssetAcceso($strAcceso, $strTipoAcceso = "CONTROL_TOTAL") {

        if (isset($_SESSION['identity-imsalesys']->perfil_acceso[$strAcceso]) &&
                (
                isset($_SESSION['identity-imsalesys']->perfil_acceso[$strAcceso][$strTipoAcceso]) || isset($_SESSION['identity-imsalesys']->perfil_acceso[$strAcceso]["CONTROL_TOTAL"])
                )) {

            return true;
        }

        return false;
    }
    
    public static function getLastPK($objDb){
        
        $strQuery = "SELECT SCOPE_IDENTITY() id";
        $qTMP = sqlsrv_query($objDb, $strQuery);
        $rTMP = sqlsrv_fetch_array($qTMP, SQLSRV_FETCH_ASSOC);
        sqlsrv_free_stmt($qTMP);
        
        return isset($rTMP["id"]) ? intval($rTMP["id"]) : 0;
        
    }
    
    public static function getSexo(){
        
        $arr["M"]["nombre"] = "Masculino";
        $arr["F"]["nombre"] = "Femenino";
        
        return $arr;
        
    }
    
    public static function getUsuarioEstado(){
        
        $arr["AC"]["nombre"] = "Activo";
        $arr["IN"]["nombre"] = "Inactivo";
        $arr["EL"]["nombre"] = "Eliminado";
        
        return $arr;
        
    }
    
    public static function getUsuarioTipo(){
        
        $arr["SA"]["nombre"] = "Super Admin";
        $arr["AD"]["nombre"] = "Administración";
        $arr["CT"]["nombre"] = "Asesor Comercial / Asesor Telemarketing";
        $arr["AC"]["nombre"] = "Asistente Comercial";
        $arr["JC"]["nombre"] = "Jefe de Creditos y Cobros";
        $arr["JR"]["nombre"] = "Jefe de Regencia y Calidad";
        $arr["CL"]["nombre"] = "Cliente";
        
        return $arr;
        
    }
    
    public static function getAcceso(){
        
        $strKey = "MANT_USUARIO";
        $arr[$strKey]["nombre"] = "Mantenimiento - Usuario";
        
        $strKey = "MANT_PERFIL";
        $arr[$strKey]["nombre"] = "Mantenimiento - Perfil";
                
        return $arr;
        
    }
    
    public static function getPerfilEstado(){
        
        $arr["A"]["nombre"] = "Activo";
        $arr["I"]["nombre"] = "Inactivo";
        $arr["E"]["nombre"] = "Eliminado";
        
        return $arr;
        
    }

    public static function getSolicitudCreditoEstado(){
        
        $arr["ISP"]["nombre"] = "Inicio de sesión Pendiente";
        $arr["ISC"]["nombre"] = "Inicio de sesión Completa";
        $arr["FI1"]["nombre"] = "Formulario Incompleto: Bloque 1";
        $arr["FI2"]["nombre"] = "Formulario Incompleto: Bloque 2";
        $arr["FI3"]["nombre"] = "Formulario Incompleto: Bloque 3";
        $arr["FI4"]["nombre"] = "Formulario Incompleto: Bloque 4";
        $arr["FEP"]["nombre"] = "Enviado por Cliente, Pendiente de Respuesta";
        $arr["FRE"]["nombre"] = "Formulario Rechazado";
        $arr["CCA"]["nombre"] = "Cliente Activo";
        
        return $arr;
        
    }
    
    public static function getEstadoClienteCredito(){
        
        $arr["FEC"]["nombre"] = "Formulario Enviado";
        $arr["FI1"]["nombre"] = "Formulario Incompleto: Bloque 1";
        $arr["FI2"]["nombre"] = "Formulario Incompleto: Bloque 2";
        $arr["FI3"]["nombre"] = "Formulario Incompleto: Bloque 3";
        $arr["FI4"]["nombre"] = "Formulario Incompleto: Bloque 4";
        $arr["FI5"]["nombre"] = "Formulario Incompleto: Bloque 5";
        $arr["FI6"]["nombre"] = "Formulario Incompleto: Bloque 6";
        $arr["FPA"]["nombre"] = "Enviado, Pendiente de Aprobacion";
        $arr["FRR"]["nombre"] = "Formulario Rechazado";
        $arr["FCA"]["nombre"] = "Aprobado";
        
        return $arr;
        
    }
    
    
    public static function sendEmail($strEMail, $strSubject, $strBody, $boolDebug = false, $strAddStringAttachment = "", $strAddStringAttachmentNombre = ""){
        
        //Load Composer's autoloader
        require 'assets/PHPMailer/vendor/autoload.php';

        //Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = $boolDebug ? SMTP::DEBUG_SERVER : false;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'yordirguevara@gmail.com';                     //SMTP username
            $mail->Password   = 'oiram123M';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('yordirguevara@gmail.com', 'Leterago');
            $mail->addAddress($strEMail, '');     //Add a recipient
            //$mail->addAddress('ellen@example.com');               //Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            if( !empty($strAddStringAttachment) )
                $mail->AddStringAttachment($strAddStringAttachment, $strAddStringAttachmentNombre); 
            
            
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $strSubject;
            $mail->Body    = $strBody;
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            
            if( $boolDebug ) echo 'Message has been sent';
            
            return true;
            
        } catch (Exception $e) {
            
            if( $boolDebug ) echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            
            return false;
            
        }
        
        return false;
        
    }
    
    public static function getEstadoCivil(){
        
        $arr["C"]["nombre"] = "Casado(a)";
        $arr["S"]["nombre"] = "Soltero(a)";
        $arr["U"]["nombre"] = "Unido(a)";
        
        return $arr;
        
    }
    
    public static function getClaseNegocio(){
        
        $arr["I"]["nombre"] = "Individual";
        $arr["S"]["nombre"] = "Sociedad Mercantil";
        
        return $arr;
        
    }
    
    public static function getTipoLocal(){
        
        $arr["P"]["nombre"] = "Propio";
        $arr["A"]["nombre"] = "Alquilado";
        
        return $arr;
        
    }
    
    public static function getFormaPago(){
        
        $arr["C"]["nombre"] = "Cheque";
        $arr["D"]["nombre"] = "Deposito a cuenta";
        $arr["T"]["nombre"] = "Transferencia";
        
        return $arr;
        
    }
    
    public static function getStringQuery($str){
        
        $str = str_replace("'", "", $str);
        $str = str_replace('"', "", $str);
        $str = str_replace("*", "", $str);
        $str = str_replace(";", "", $str);
        return $str;
        
    }
    
    public static function getPDFConvenioLeterago($arrSolCredito, $arrSolCreditoDato){
        
        return "";
        
        $arrEstadoCivil = utils::getEstadoCivil();
        $arrClaseNegocio = utils::getClaseNegocio();
        $arrTipoLocal = utils::getTipoLocal();
        $arrFormaPago = utils::getFormaPago();
        // Include the main TCPDF library (search for installation path).
        require_once('assets/TCPDF-main/config/tcpdf_config.php');
        require_once('assets/TCPDF-main/tcpdf.php');
        
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator("PORTAL LETERAGO");
        $pdf->SetAuthor('LETERAGO, S.A.');
        $pdf->SetTitle('SOLICITUD DE CREDITO '.$arrSolCredito["id_cliente"]);
        $pdf->SetSubject('CONVENIO');
        $pdf->SetKeywords('');

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
                                    <td style="width: 29%; background-color: #013a7d;">
                                        <img src="assets/img/logo_azul.png">
                                        
                                    </td>
                                    <td style="width: 70%; background-color: #013a7d; text-align: right; vertical-align: middle;">
                                        <br>
                                        <br>
                                        <span style="color: #FFFFFF; font-size: 20px; font-weight: bold;" >SOLICITUD DE CRÉDITO No.</span>
                                        <span style="background-color: #FFFFFF; font-size: 25px; color: #013a7d; padding: 5px; border-radius: 2px; font-weight: bold;"> '.$arrSolCredito["id_cliente"].' </span>
                                    </td>
                                    <td style="width: 1%; background-color: #013a7d; text-align: right; vertical-align: middle;">
                                        &nbsp;
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
                                                    '.$arrSolCreditoDato["PRIMER_NOMBRE"]["valor_input"].'
                                                </td>
                                                <td style="width: 25%; border-right: 1px solid #013a7d; padding: 5px; ">
                                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                        SEGUNDO NOMBRE
                                                    </span>
                                                    <br>
                                                    '.$arrSolCreditoDato["SEGUNDO_NOMBRE"]["valor_input"].'
                                                </td>
                                                <td style="width: 25%; border-right: 1px solid #013a7d; padding: 5px; ">
                                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                        PRIMER APELLIDO
                                                    </span>
                                                    <br>
                                                    '.$arrSolCreditoDato["PRIMER_APELLIDO"]["valor_input"].'
                                                </td>
                                                <td style="width: 25%; padding: 5px; ">
                                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                        SEGUNDO APELLIDO
                                                    </span>
                                                    <br>
                                                    '.$arrSolCreditoDato["SEGUNDO_APELLIDO"]["valor_input"].'
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 25%; border-right: 1px solid #013a7d; border-top: 1px solid #013a7d; padding: 5px; ">
                                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                        APELLIDO CASADA
                                                    </span>
                                                    <br>
                                                    '.$arrSolCreditoDato["APELLIDO_CASADA"]["valor_input"].'
                                                </td>
                                                <td style="width: 25%; border-right: 1px solid #013a7d; border-top: 1px solid #013a7d; padding: 5px; ">
                                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                        ESTADO CIVIL
                                                    </span>
                                                    <br>
                                                    '.$arrEstadoCivil[$arrSolCreditoDato["ESTADO_CIVIL"]["valor_input"]]["nombre"].'
                                                </td>
                                                <td style="width: 25%; border-right: 1px solid #013a7d; border-top: 1px solid #013a7d; padding: 5px; ">
                                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                        FECHA NACIMIENTO
                                                    </span>
                                                    <br>
                                                    '.$arrSolCreditoDato["FECHA_NACIMIENTO"]["valor_input"].'
                                                </td>
                                                <td style="width: 25%;  border-top: 1px solid #013a7d; padding: 5px; ">
                                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                        DPI O PASAPORTE
                                                    </span>
                                                    <br>
                                                    '.$arrSolCreditoDato["DPI_PASAPORTE"]["valor_input"].'
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 25%; border-right: 1px solid #013a7d; border-top: 1px solid #013a7d; padding: 5px; ">
                                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                        EXTENDIDO EN
                                                    </span>
                                                    <br>
                                                    '.$arrSolCreditoDato["DPI_PASAPORTE_EXTENDIDO"]["valor_input"].'
                                                </td>
                                                <td style="width: 25%; border-right: 1px solid #013a7d; border-top: 1px solid #013a7d; padding: 5px; ">
                                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                        No. TELEFONO
                                                    </span>
                                                    <br>
                                                    '.$arrSolCreditoDato["NO_TELEFONO"]["valor_input"].'
                                                </td>
                                                <td colspan="2" style=" border-top: 1px solid #013a7d; padding: 5px; ">
                                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                        ESTADO CIVIL
                                                    </span>
                                                    <br>
                                                    '.$arrEstadoCivil[$arrSolCreditoDato["ESTADO_CIVIL"]["valor_input"]]["nombre"].'
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" style=" border-top: 1px solid #013a7d; padding: 5px; ">
                                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                        DIRECCION COMPLETA DE SU RESIDENCIA
                                                    </span>
                                                    <br>
                                                    '.$arrSolCreditoDato["DIRECCION_RESIDENCIA"]["valor_input"].'
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
                                                    '.$arrSolCreditoDato["NOMBRE_COMERCIAL"]["valor_input"].'
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" style="border-top: 1px solid #013a7d; padding: 5px; ">
                                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                        DIRECCION COMPLETA DEL NEGOCIO
                                                    </span>
                                                    <br>
                                                    '.$arrSolCreditoDato["DIRECCION"]["valor_input"].'
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 25%; border-top: 1px solid #013a7d; border-right: 1px solid #013a7d; padding: 5px; ">
                                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                        NIT
                                                    </span>
                                                    <br>
                                                    '.$arrSolCreditoDato["NIT"]["valor_input"].'
                                                </td>
                                                <td style="width: 25%; border-top: 1px solid #013a7d; border-right: 1px solid #013a7d; padding: 5px; ">
                                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                        PATENTE DE COMERCIO
                                                    </span>
                                                    <br>
                                                    '.$arrSolCreditoDato["PATENTE_COMERCIO"]["valor_input"].'
                                                </td>
                                                <td style="width: 25%; border-top: 1px solid #013a7d; border-right: 1px solid #013a7d; padding: 5px; ">
                                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                        CLASE DE NEGOCIO
                                                    </span>
                                                    <br>
                                                    '.$arrClaseNegocio[$arrSolCreditoDato["CLASE_NEGOCIO"]["valor_input"]]["nombre"].'
                                                </td>
                                                <td style="width: 25%;  border-top: 1px solid #013a7d; padding: 5px; ">
                                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                        LOCAL
                                                    </span>
                                                    <br>
                                                    '.( isset($arrTipoLocal[$arrSolCreditoDato["TIPO_LOCAL"]["valor_input"]]) ? $arrTipoLocal[$arrSolCreditoDato["TIPO_LOCAL"]["valor_input"]]["nombre"] : "" ).'
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style=" border-top: 1px solid #013a7d; border-right: 1px solid #013a7d; padding: 5px; ">
                                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                        TIEMPO DE TENER EL NEGOCIO
                                                    </span>
                                                    <br>
                                                    '.$arrSolCreditoDato["TIEMPO_NEGOCIO"]["valor_input"].'
                                                </td>
                                                <td colspan="3" style=" border-top: 1px solid #013a7d;  padding: 5px; ">
                                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                        OTROS NEGOCIOS
                                                    </span>
                                                    <br>
                                                    '.$arrSolCreditoDato["OTROS_NEGOCIOS"]["valor_input"].'
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" style=" border-top: 1px solid #013a7d;  padding: 5px; ">
                                                    <span style="color: #013a7d; text-align: center; font-weight: bold;">
                                                        MONTO DE CREDITO SOLICITADO:
                                                    </span>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <span style="color: #013a7d; text-align: center; font-weight: bold;">
                                                        Q. '.( isset($arrSolCreditoDato["MONTO_SOLICITADO"]) && $arrSolCreditoDato["MONTO_SOLICITADO"]["valor_input"] > 0 ? number_format($arrSolCreditoDato["MONTO_SOLICITADO"]["valor_input"], 2) :  0) .'
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
                                                    '.$arrSolCreditoDato["REFERENCIA_NOMBRE_EMPRESA_1"]["valor_input"].'
                                                </td>
                                                <td style="width: 50%; border-top: 1px solid #013a7d; border-right: 1px solid #013a7d; padding: 5px; ">
                                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                        TELEFONO No.
                                                    </span>
                                                    <br>
                                                    '.$arrSolCreditoDato["REFERENCIA_TELEFONO_EMPRESA_1"]["valor_input"].'
                                                </td>
                                            </tr>
                                        </table>
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
                                                    '.$arrSolCreditoDato["REFERENCIA_NOMBRE_EMPRESA_2"]["valor_input"].'
                                                </td>
                                                <td style="width: 50%; border-top: 1px solid #013a7d; border-right: 1px solid #013a7d; padding: 5px; ">
                                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                        TELEFONO No.
                                                    </span>
                                                    <br>
                                                    '.$arrSolCreditoDato["REFERENCIA_TELEFONO_EMPRESA_2"]["valor_input"].'
                                                </td>
                                            </tr>
                                        </table>
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
                                                    '.$arrSolCreditoDato["REFERENCIA_NOMBRE_EMPRESA_3"]["valor_input"].'
                                                </td>
                                                <td style="width: 50%; border-top: 1px solid #013a7d; border-right: 1px solid #013a7d; padding: 5px; ">
                                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                        TELEFONO No.
                                                    </span>
                                                    <br>
                                                    '.$arrSolCreditoDato["REFERENCIA_TELEFONO_EMPRESA_3"]["valor_input"].'
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
                                                    '.$arrSolCreditoDato["ENCARGADO_COMPRAS"]["valor_input"].'
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="border-top: 1px solid #013a7d; border-right: 1px solid #013a7d; padding: 5px; ">
                                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                        ENCARGADO DE PAGOS
                                                    </span>
                                                    <br>
                                                    '.$arrSolCreditoDato["ENCARGADO_PAGOS"]["valor_input"].'
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 25%; border-top: 1px solid #013a7d; border-right: 1px solid #013a7d; padding: 5px; ">
                                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                        FORMA DE PAGO
                                                    </span>
                                                    <br>
                                                    '.( isset($arrFormaPago[$arrSolCreditoDato["FORMA_PAGO"]["valor_input"]]["nombre"]) ?  $arrFormaPago[$arrSolCreditoDato["FORMA_PAGO"]["valor_input"]]["nombre"] : "" ).'
                                                </td>
                                                <td style="width: 50%; border-top: 1px solid #013a7d; border-right: 1px solid #013a7d; padding: 5px; ">
                                                    
                                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                        PLAZO DEL CREDITO
                                                    </span>
                                                    <br>
                                                    '.( isset($arrSolCreditoDato["PLAZO_CREDITO"]) ? $arrSolCreditoDato["PLAZO_CREDITO"]["valor_input"] : "" ).'
                                                </td>
                                                <td style="width: 25%; border-top: 1px solid #013a7d; border-right: 1px solid #013a7d; padding: 5px; ">
                                                    <span style="color: #013a7d; text-align: center; font-size: 10px;">
                                                        DIAS
                                                    </span>
                                                    <br>
                                                    '.( isset($arrSolCreditoDato["PLAZO_DIAS"]) ? $arrSolCreditoDato["PLAZO_DIAS"]["valor_input"] : "" ).'
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
                                        '.( isset($arrSolCreditoDato["FIRMA_URL"]["valor_input"]) ? '<img src="'.base_url.$arrSolCreditoDato["FIRMA_URL"]["valor_input"].'" style="width: 400px; height: 200px">' : "&nbsp;" ).'
                                    </td>
                                    <td style="width: 10%; ">
                                        &nbsp;
                                    </td>
                                    <td style="width: 45%; text-align: center;">
                                        &nbsp;
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
                        <td style="width: 100%; margin-top: 0px;">
                            <table style="width: 100%; " cellspacing="0" cellpadding="0">
                                
                                <tr>
                                    <td style="width: 8%;  text-align: left; margin-top: 0px;">
                                        CLIENTE:
                                    </td>
                                    <td style="width: 92%; text-align: left; margin-top: 0px; border-bottom: 1px solid #000000;">
                                        '.$arrSolCreditoDato["PRIMER_NOMBRE"]["valor_input"].' '.$arrSolCreditoDato["SEGUNDO_NOMBRE"]["valor_input"].' '.$arrSolCreditoDato["PRIMER_APELLIDO"]["valor_input"].' '.$arrSolCreditoDato["SEGUNDO_APELLIDO"]["valor_input"].' '.$arrSolCreditoDato["APELLIDO_CASADA"]["valor_input"].'
                                    </td>
                                </tr>
                            
                            </table>    
                        </td>
                    </tr>
                    
                            
                    
                    <tr>
                        <td style="width: 100%; text-align: justify; margin-top: 0px;">
                            El presente convenio mercantil se celebra bajo los principios de verdad sabida y buena fe guardada a manera de conservar y proteger las rectas y honorables intensiones y
                            deseos de los contratantes entre LETERAGO, S.A. entidad dedicada a la distribución de medicamentos, a través de su representante legar y EL CLIENTE AL CRÉDITO, que
                            es la persona que recibe el beneficio de que LETERAGO, S.A., le otorgue financiamiento o crédito bajo ciertas reglas o condiciones establecida en el presente documento y
                            leyes mercantiles, para efectos del presente documento se le denominará EL CLIENTE, Bajo las siguientes cláusulas 
                            
                            <b>PRIMERA:</b> LETERAGO, S.A., comparece a través de
                            su presentarte legal, el señor Juan Francisco Letona, casado, de nacionalidad guatemalteca, de <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>, con domicilio en
                            <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>, quien se identifica con el código único de identidad, dos mil doscientos ocho espacio setenta y cuatro mil
                            sesenta y nueve espacio cero ciento uno (2208 74069 0101) y EL CLIENTE quien se identifica como <u>'.$arrSolCreditoDato["PRIMER_NOMBRE"]["valor_input"].' '.$arrSolCreditoDato["SEGUNDO_NOMBRE"]["valor_input"].' '.$arrSolCreditoDato["PRIMER_APELLIDO"]["valor_input"].' '.$arrSolCreditoDato["SEGUNDO_APELLIDO"]["valor_input"].' '.$arrSolCreditoDato["APELLIDO_CASADA"]["valor_input"].'</u>, y
                            es <u>'.$arrEstadoCivil[$arrSolCreditoDato["ESTADO_CIVIL"]["valor_input"]]["nombre"].'</u>, de nacionalidad <u>'.$arrSolCreditoDato["DPI_PASAPORTE_EXTENDIDO"]["valor_input"].'</u>, de
                            <u>'.$arrSolCreditoDato["FECHA_NACIMIENTO"]["valor_input"].'</u> de edad, con domicilio en, <u>'.$arrSolCreditoDato["DIRECCION_RESIDENCIA"]["valor_input"].'</u>
                            quien se identifica con documento personal de identificación cuyo código personal de identificación es <u>'.$arrSolCreditoDato["DPI_PASAPORTE"]["valor_input"].'</u>, extendido
                            por el Registro Nacional de las Personas, 
                            
                            <b>SEGUNDA:</b> LETERAGO, S.A., se compromete a proveer al EL CLIENTE, de los medicamentos que distribuye, de acuerdo al cumplimiento del presente 
                            convenio y de acuerdo a las condiciones económicas del mercado.
                            
                            <b>TERCERA:</b> CRÉDITO en el financiamiento que LETERAGO, S.A. otorga de buena fe, hasta por el monto y por el plazo establecidos en cada factura cambiaria que se emita por cada despacho y son los
                            documentos que respaldan cada venta realizada al EL CLIENTE, entendiéndose el presente convenio como adicional. El crédito otorgado no devengará interés siempre y cuando se cumpla con el plazo pactado.
                            EL CLIENTE hace uso del crédito que le otorga LETERAGO, S.A. y acepta las clausuras incluidas en el presente convenio, comprometiéndose a cumplir con el pago, dentro del plazo y
                            forma acordadas. La forma de pago puede ser en efectivo, con cheque personal, cheque certificado de caja o de gerencia o mediante depósito efectuado a la cuenta
                            bancaria de <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>. 
                            
                            <b>CUARTA:</b> El despacho de las mercaderías solicitadas por el cliente, se hará de acuerdo a las
                            condiciones establecidas por el departamento de créditos y cobros. LETERAGO, S.A., no despachará un nuevo pedido cuando el cliente muestre saldos vencidos o cuando
                            haya proporcionado un cheque pre-fechado o post-fechado.
                            
                            <b>QUINTA:</b> Cuando el cliente efectúe el pago con cheque o este resultaré rechazado por carácter de provisión de fondos, reserva de cobro, firma, redacción o fecha incorrecta o cuenta cancelada,
                            este deberá cancelar el recargo por gastos administrativos que LETERAGO, S.A. establezca, después de dos cheques rechazados en adelante no se le aceptaran los pagos con cheque, únicamente en efectivo,
                            depósito en cuenta, cheque de caja o de gerencia.
                            
                            <b>SEXTA:</b> Cuando el cliente incurra en mora, es decir, cuando no cumpla con los pagos en el tiempo establecido, su crédito será suspendido. En tal caso LETERAGO, S.A., cobrará interés por mora de
                            dos por ciento(2.%) mensual sobre saldos atrasados. En caso de que el pago de la obligación deba ser exigido judicialmente se cobrara interés por financiamiento de conformidad con la tasa
                            promedio de las operaciones activas en el sistema bancario que rija en ese momento de la liquidación.
                            
                            <b>SEPTIMA:</b> Todos los porcentajes, tasa, montos, pagos, límites de crédito, plazos y demás condiciones previstas en este convenio en la solicitud de crédito o en documentos anexos,
                            podrán ser variados por LETERAGO, S.A., a solicitud del cliente o de acuerdo a la situación cambiante del cliente, sin que esto signifique alteración con motivo del incumplimiento del presente convenio.
                            
                            <b>OCTAVA:</b> EL CLIENTE asume la obligación de pagar todos los gastos, recargo o impuestos que se causen con motivo del incumplimiento del presente convenio.
                            
                            <b>NOVENA:</b> EL CLIENTE se compromete con todos sus bienes al cumplimiento de la presente obligación, y garantiza que con estos se cubrirán la responsabilidad de pagar él salo pendiente
                            en caso de fallecimiento, enfermedad, incapacidad, quiebra o cualquier otro tipo de impedimento del obligado.
                            
                            <b>DECIMO:</b> LETERAGO, S.A. queda autorizado a acceder los créditos y demás derechos provenientes de este convenio por principal o accesorios, total o parcialmente, sin necesidad de previo aviso o
                            posterior notificación al cliente o al codeudor.
                            
                            <b>DECIMO PRIMERA:</b> Para los efectos de este convenio, EL CLIENTE acepta que en todo tiempo se consideren como saldos verdaderos los que arrojen, los controles internos de LETERAGO, S.A., en consecuencia
                            en caso de acción judicial para el cobro de saldo vencido, LETERAGO, S.A. no estará obligada o probar de forma distinta que el saldo vencido y no pagado es el que se expresa en la demanda. Acepta
                            también que para los efectos del aviso escrito enviado a los clientes, la fecha que expresa dicha copia es la fecha en que el aviso fue dado y recibido. Es facultad de LETERAGO, S.A., el señalamiento del saldo
                            líquido exigible y EL CLIENTE acepta el saldo que así se señale, servirá como título ejecutiva acta notarial fraccionada por Notario en la cual conste el saldo deudor que arroje la contabilidad 
                            de LETERAGO, S.A.
                            
                            <b>DECIMO SEGUNDA:</b> LETERAGO, S.A., podrá rescindir el presente convenio en los casos siguientes: a) Cuando EL CLIENTE se niegue en cualquier forma o figura, a cancelar los saldo vencidos;
                            b) cuando EL CLIENTE haya sufrido pignoración, hipoteca, embargo o disminución de bienes decretados en virtud de acciones judiciales iniciadas por terceros o que caiga en quiebra.
                            
                            <b>DECIMO TERCERA:</b> EL CLIENTE se compromete a que respetara en todo momento el plazo establecido de crédito, y que el mismo será plasmado en cada factura que ampare los despachos realizados, así como
                            que el hecho de que las personas que laboran para él, Al hacer pedidos, lo comprometen directamente, y que se considera válida la recepción del producto, con la firma de cualquier
                            empleado que plasme su firma en la factura o documento de envió, reconociendo desde ya su obligación de pago para con LETERAGO, S.A., en estos casos.
                            
                            <b>DECIMO CUARTA:</b> El CLIENTE y el codeudor, para los efectos del presente convenio, renuncian al fuero de su domicilio y se sujetan a los Tribunales que el Departamento de Guatemala,
                            LETERAGO, S.A., elija, aceptando desde ya como buenas, y exactas las cuentas que se le presente con relación a este convenio y como liquidado, ejecutivo y de plazo vencido el pago
                            que se le demande, siendo por su cuenta cualquier gasto ya sea extrajudicial o judicial que del incumplimiento de este convenio se derive, señalando como lugar
                            para recibir notificaciones la indicada en la parte informativa del presente convenio, debiendo comunicar a LETERAGO, S.A., de cualquier cambio que de ella hicieren el entendido
                            de que si no lo hiciere serán válidas y bien hechas las que se hagan en el lugar señalado.
                            
                            <b>DECIMO QUINTA:</b> En caso de conflictos relativos a la cancelación de los despachos pendientes de cobro ya vencidos, incluyendo cargos y penalizaciones, El CLIENTE, renuncia al fuero de su domicilio,
                            incurriendo en DELITO DE APROPIACIÓN Y RETENCIÓN INDEBIDA sometiéndose a los Tribunales correspondientes, y para constancia de LETERAGO, S.A., a través de su representante legal.
                            EL CLIENTE y el codeudor ratifican y acepten todas las cláusulas de este convenio, firmado el presente documento en la Ciudad de Guatemala los <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> dias
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
                                        '.( isset($arrSolCreditoDato["FIRMA_URL"]["valor_input"]) ? '<img src="'.base_url.$arrSolCreditoDato["FIRMA_URL"]["valor_input"].'" style="width: 400px; height: 200px">' : "&nbsp;" ).'
                                    </td>
                                    <td style="width: 10%; ">
                                        &nbsp;
                                    </td>
                                    <td style="width: 45%; text-align: center;">
                                        &nbsp;
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
                            de dos mil <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> YO, el infrascrito Notario DOY FE: que las
                            firmas que anteceden son AUTÉNTICAS, por haber sido puestas en mi presencia el día de hoy por los señores: EL CLIENTE quien se
                            identifica como <u>'.$arrSolCreditoDato["PRIMER_NOMBRE"]["valor_input"].' '.$arrSolCreditoDato["SEGUNDO_NOMBRE"]["valor_input"].' '.$arrSolCreditoDato["PRIMER_APELLIDO"]["valor_input"].' '.$arrSolCreditoDato["SEGUNDO_APELLIDO"]["valor_input"].' '.$arrSolCreditoDato["APELLIDO_CASADA"]["valor_input"].'</u>, 
                            y se identifica con el documento personal de identificación, cuyo código único de identificación es <u>'.$arrSolCreditoDato["DPI_PASAPORTE"]["valor_input"].'</u>, extendido
                            por el Registro Nacional de las Personas, por EL CODEUDOR quien se identifica como <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>, y
                            se identifica con docuemnto personal de identificacion, cuyo codigo unico de identificacion es <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>, extendido
                            por el Registro Nacional de las Personas, y por el Representante Legal de entidad LETERAGO, Sociedad Anónima, señor Juan Francisco Letona, casado, de nacionalidad
                            guatemalteca, quien se identifica con código único de identidad, dos mil doscientos ocho espacio setenta y cuatromil sesenta y nuevo espacio
                            cero ciento uno (2208 74069 0101). Los signatarios en señal de buena fe firman con él.
                                    
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
                                                    '.( isset($arrSolCreditoDato["FIRMA_URL"]["valor_input"]) ? '<img src="'.base_url.$arrSolCreditoDato["FIRMA_URL"]["valor_input"].'" style="width: 400px; height: 200px">' : "&nbsp;" ).'
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
                                                    &nbsp;
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
                                            Autorizo voluntariamente que la información recopilada y/o proporcionada por entidades públicas
                                            o privadas y la generada de relaciones contractuales, crediticias o comerciales, sea reportada
                                            a centrales de registro o buros de crédito para ser tratada, almacenada o transferida; y autorizo
                                            expresamente a las entidades que presentan servicios de información, centrales de riesgo y buros
                                            de crédito, a recopilar, difundir o comercializar reportes o estudios que contengan información
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
        
        return $pdf->Output('example_006.pdf', 'S');
        
    }
    
}
