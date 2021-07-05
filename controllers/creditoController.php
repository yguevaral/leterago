<?php

require_once 'models/credito_model.php';
require_once 'views/credito/credito_view.php';

class creditoController {

    var $objView;
    var $objModel;

    public function __construct() {

        $this->objView = new credito_view();
        $this->objModel = new credito_model();
    }
    
    public function index() {
        
        utils::isIdentity();
        
        //utils::drawDebug($_SESSION["leterago"]["tipo"]);
        if ( $_SESSION["leterago"]["tipo"] == "CL" ){
                    
            $arrSolCredito = $this->objModel->getSolCreditoCliente($_SESSION['leterago']['id']);
            
            $boolSolCreditoBloque1 = false;
            $intSolCredito = 0;
            while( $rTMP = each($arrSolCredito) ){
                
                if( $rTMP["value"]["estado"] == "ISC" ){
                    
                    $intSolCredito = $rTMP["value"]["id_sol_credito"];
                    $boolSolCreditoBloque1 = true;
                    
                }
                
            }
            
            if( $boolSolCreditoBloque1 ){
                
                $arrSolCreditoDato = $this->objModel->getSolCreditoDato($intSolCredito);    
                $this->objView->fntSolCreditoFormBloque1($intSolCredito, $arrSolCredito[$intSolCredito], $arrSolCreditoDato);    
                //$this->objView->fntSolCreditoFormBloque2($intSolCredito, $arrSolCredito);    
                
            }
            else{
                
                
                $this->objView->fntDrawIndexCliente();
                    
            }
                        
        }
        elseif ( $_SESSION["leterago"]["tipo"] == "AS" ){
            
            $this->objView->fntDrawIndexAsesor();
            
        }
        else{
            
            $this->objView->fntDrawIndex();
                
        }
        
    }
    
    public function getAjax() {
        
        if( isset($_GET["drawIndexCliente"]) ){
            
            
            $this->objView->fntDrawIndexCliente();
            
            die();
        }
        if( isset($_GET["drawListCredito"]) ){
            
            $strFiltroPais = "";
            if( isset($_POST["slcFiltroPais"]) && count($_POST["slcFiltroPais"]) > 0 ){
                    
                while( $rTMP = each($_POST["slcFiltroPais"]) ){
                    
                    $strFiltroPais .= ( $strFiltroPais == "" ? "" : "," )."'{$rTMP["value"]}'";
                            
                }
                
            }
            
            $strFiltroAsesor = "";
            if( isset($_POST["slcFiltroAsesor"]) && count($_POST["slcFiltroAsesor"]) > 0 ){
                    
                while( $rTMP = each($_POST["slcFiltroAsesor"]) ){
                    
                    $strFiltroAsesor .= ( $strFiltroAsesor == "" ? "" : "," )."'{$rTMP["value"]}'";
                            
                }
                
            }
            
            $strFiltroEstadoCredito = "";
            if( isset($_POST["slcEstadoCredito"]) && count($_POST["slcEstadoCredito"]) > 0 ){
                    
                while( $rTMP = each($_POST["slcEstadoCredito"]) ){

                    $strFiltroEstadoCredito .= ( $strFiltroEstadoCredito == "" ? "" : "," )."'{$rTMP["value"]}'";
                            
                }
                
            }
            
            
            if ( $_SESSION["leterago"]["tipo"] == "CL" ){
            
                $arrCreditos = $this->objModel->getCreditos($_SESSION['leterago']['id']);
                
                $this->objView->drawListCreditosCliente($arrCreditos);
                
            }
            elseif ( $_SESSION["leterago"]["tipo"] == "AS" ){
            
                $arrCreditos = $this->objModel->getCreditosAsesor($_SESSION['leterago']['id'], $strFiltroEstadoCredito );
                
                $this->objView->drawListCreditosAsesor($arrCreditos);
                
            }
            else{
            
                $arrCreditos = $this->objModel->getCreditosAdmin($strFiltroPais, $strFiltroAsesor, $strFiltroEstadoCredito );
                
                $this->objView->drawListCreditos($arrCreditos);
                
            }
                
            
            die();
        }
        
        if( isset($_GET["drawAdminModalCredito"]) ){
            
            $intCredito = isset($_GET["credito"]) ? intval($_GET["credito"]) : 0;
            
            $this->objView->drawAdminModalCredito($intCredito);
            
            die();
        }
        
        if( isset($_GET["setEliminarUsuario"]) ){
            
            $intUsuario = isset($_GET["usuario"]) ? intval($_GET["usuario"]) : 0;
            
            $arrUsuario = $this->objModel->setEliminarUsuario($intUsuario);
            
            die();
        }
        
        if( isset($_GET["drawCiudad"]) ){
            
            $intDepartamento = isset($_GET["departamento"]) ? intval($_GET["departamento"]) : 0;
            $intCiudad = isset($_GET["ciudad"]) ? intval($_GET["ciudad"]) : 0;
            
            $arrCiudad = $this->objModel->getCiudad($intDepartamento);
            
            $this->objView->drawCiudad($arrCiudad, $intCiudad);
            
            die();
        }
        
        if( isset($_GET["setCredito"]) ){
            
            $intSolCredito = isset($_POST["hidCredito"]) ? intval($_POST["hidCredito"]) : 0;
            
            $strPrimerNombre = isset($_POST["txtPrimerNombre"]) ? trim($_POST["txtPrimerNombre"]) : "";
            $strSegundoNombre = isset($_POST["txtSegundoNombre"]) ? trim($_POST["txtSegundoNombre"]) : "";
            $strPrimerApellido = isset($_POST["txtPrimerApellido"]) ? trim($_POST["txtPrimerApellido"]) : "";
            $strSegundoApellido = isset($_POST["txtSegundoApellido"]) ? trim($_POST["txtSegundoApellido"]) : "";
            
            $strNombreComercial = isset($_POST["txtNombreEmpresa"]) ? trim($_POST["txtNombreEmpresa"]) : "";
            
            $strNombre = $strPrimerNombre." ".$strSegundoNombre;
            $strApellido = $strPrimerApellido." ".$strSegundoApellido;
            
            $strEmail = isset($_POST["txtEmailUsuario"]) ? trim($_POST["txtEmailUsuario"]) : "";
            $strClave = rand(1000, 9999);
            $strTipo = "CL";
            $strEstado = "AC";
            $strSexo = isset($_POST["slcSexo"]) ? trim($_POST["slcSexo"]) : "";
            
            $intUsuarioAsesor = $_SESSION['leterago']['id']; 
            
            
            if( !$intSolCredito ){
                
                $intUsuario = $this->objModel->fntSetUsuario($strNombre, $strApellido, $strSexo, $strEmail, $strClave, $strTipo, $strEstado);
                
                $arr["error"] = true;    
                $arr["msg"] = "Error";
                if( $intUsuario ){
                    
                    $intSolCredito = $this->objModel->setCredito($intUsuario, "ISP", $intUsuarioAsesor);
                    
                    $this->objModel->setInsertSolCreditoDato($intSolCredito, "PRIMER_NOMBRE", $strPrimerNombre, 1);                
                    $this->objModel->setInsertSolCreditoDato($intSolCredito, "SEGUNDO_NOMBRE", $strSegundoNombre, 1);                

                    $this->objModel->setInsertSolCreditoDato($intSolCredito, "PRIMER_APELLIDO", $strPrimerApellido, 1);                
                    $this->objModel->setInsertSolCreditoDato($intSolCredito, "SEGUNDO_APELLIDO", $strSegundoApellido, 1);          

                    $this->objModel->setInsertSolCreditoDato($intSolCredito, "NOMBRE_COMERCIAL", $strNombreComercial, 2);    
                    
                    $strBody = '<table style="width: 30%; border: 1px solid black;">
                                    <tr>
                                        <td nowrap style="width: 50%; text-align: left; font-weight: bold; border: 1px solid black;">
                                            Nombre
                                        </td>
                                        <td nowrap style="width: 50%; text-align: center; border: 1px solid black;">
                                            '.$strNombre.' '.$strApellido.'
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td nowrap style="width: 50%; text-align: left; font-weight: bold; border: 1px solid black; ">
                                            Email
                                        </td>
                                        <td nowrap style="width: 50%; text-align: center; border: 1px solid black;">
                                            '.$strEmail.'
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td nowrap style="width: 50%; text-align: left; font-weight: bold; border: 1px solid black;">
                                            Contraseña
                                        </td>
                                        <td nowrap style="width: 50%; text-align: center; border: 1px solid black;">
                                            '.$strClave.'
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td nowrap style="width: 50%; text-align: left; font-weight: bold; border: 1px solid black; ">
                                            # Credito
                                        </td>
                                        <td nowrap style="width: 50%; text-align: center; border: 1px solid black;">
                                            '.$intSolCredito.'
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td nowrap colspan="2" style="text-align: center; font-weight: bold; ">
                                            Navega a <a href="http://leterago.com/" target="_blank">leterago.com</a> con he ingresa con tu email y clave para completar el formulacion de solicitud de credito
                                        </td>
                                    </tr>
                                    
                                </table>';
                                
                    utils::sendEmail("idroys4@gmail.com", "Solicitud de Credito #".$intSolCredito, $strBody, false);
                    
                    $arr["error"] = false;    
                    $arr["msg"] = "Solicitud de Credito Creada, email enviado a cliente";
                        
                }
                
            }
            
            print json_encode($arr);            
            die();
            
        }
        
        if( isset($_GET["showSolCreditoConsolidado"]) ){
            
            $intSolCredito = isset($_GET["credito"]) ? intval($_GET["credito"]) : 0;
            $arrSolCredito = $this->objModel->getSolCreditoCliente($_SESSION['leterago']['id'], $intSolCredito);
            
            $arrSolCreditoDato = $this->objModel->getSolCreditoDato($intSolCredito);    
            $this->objView->fntSolCreditoConsolidado($intSolCredito, ( isset($arrSolCredito[$intSolCredito]) ? $arrSolCredito[$intSolCredito] : array() ), $arrSolCreditoDato);
            
            die();
        }
        
        if( isset($_GET["showSolCreditoFormBloque1"]) ){
            
            $intSolCredito = isset($_GET["credito"]) ? intval($_GET["credito"]) : 0;
            $arrSolCredito = $this->objModel->getSolCreditoCliente($_SESSION['leterago']['id'], $intSolCredito);
            
            $arrSolCreditoDato = $this->objModel->getSolCreditoDato($intSolCredito);    
            $this->objView->fntSolCreditoFormBloque2($intSolCredito, ( isset($arrSolCredito[$intSolCredito]) ? $arrSolCredito[$intSolCredito] : array() ), $arrSolCreditoDato);
            
            die();
        }
        
        if( isset($_GET["showSolCreditoFormBloque2"]) ){
            
            $intSolCredito = isset($_GET["credito"]) ? intval($_GET["credito"]) : 0;
            $arrSolCredito = $this->objModel->getSolCreditoCliente($_SESSION['leterago']['id'], $intSolCredito);
            
            $arrSolCreditoDato = $this->objModel->getSolCreditoDato($intSolCredito);    
            $this->objView->fntSolCreditoFormBloque2($intSolCredito, $arrSolCredito[$intSolCredito], $arrSolCreditoDato);
            
            die();
        }
        
        if( isset($_GET["showSolCreditoFormBloque3"]) ){
            
            $intSolCredito = isset($_GET["credito"]) ? intval($_GET["credito"]) : 0;
            $arrSolCredito = $this->objModel->getSolCreditoCliente($_SESSION['leterago']['id'], $intSolCredito);
            
            $arrSolCreditoDato = $this->objModel->getSolCreditoDato($intSolCredito);    
            $this->objView->fntSolCreditoFormBloque3($intSolCredito, $arrSolCredito[$intSolCredito], $arrSolCreditoDato);
            
            die();
        }
        
        if( isset($_GET["showSolCreditoFormBloque4"]) ){
            
            $intSolCredito = isset($_GET["credito"]) ? intval($_GET["credito"]) : 0;
            $arrSolCredito = $this->objModel->getSolCreditoCliente($_SESSION['leterago']['id'], $intSolCredito);
            
            $arrSolCreditoDato = $this->objModel->getSolCreditoDato($intSolCredito);    
            $this->objView->fntSolCreditoFormBloque4($intSolCredito, $arrSolCredito[$intSolCredito], $arrSolCreditoDato);
            
            die();
        }
        
        if( isset($_GET["showSolCreditoFormBloque5"]) ){
            
            $intSolCredito = isset($_GET["credito"]) ? intval($_GET["credito"]) : 0;
            $arrSolCredito = $this->objModel->getSolCreditoCliente($_SESSION['leterago']['id'], $intSolCredito);
            
            $arrSolCreditoDato = $this->objModel->getSolCreditoDato($intSolCredito);    
            $this->objView->fntSolCreditoFormBloque5($intSolCredito, $arrSolCredito[$intSolCredito], $arrSolCreditoDato);
            
            die();
        }
        
        if( isset($_GET["setCreditoBloque1"]) ){
            
            $intSolCredito = isset($_POST["hidSolCredito"]) ? intval($_POST["hidSolCredito"]) : 0;
            
            $strPrimerNombre = isset($_POST["txtPrimerNombre"]) ? utils::getStringQuery($_POST["txtPrimerNombre"]) : "";
            $intPrimerNombreKey = isset($_POST["hidPrimerNombreKey"]) ? intval($_POST["hidPrimerNombreKey"]) : 0;
            
            if( $intPrimerNombreKey )
                $this->objModel->setUpdateSolCreditoDato($intPrimerNombreKey, $strPrimerNombre);                
            else
                $this->objModel->setInsertSolCreditoDato($intSolCredito, "PRIMER_NOMBRE", $strPrimerNombre, 1);                
            
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strSegundoNombre = isset($_POST["txtSegundoNombre"]) ? utils::getStringQuery($_POST["txtSegundoNombre"]) : "";
            $intSegundoNombreKey = isset($_POST["hidSegundoNombreKey"]) ? intval($_POST["hidSegundoNombreKey"]) : 0;
            
            if( $intSegundoNombreKey )
                $this->objModel->setUpdateSolCreditoDato($intSegundoNombreKey, $strSegundoNombre);                
            else
                $this->objModel->setInsertSolCreditoDato($intSolCredito, "SEGUNDO_NOMBRE", $strSegundoNombre, 1);                
            
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strPrimerApellido = isset($_POST["txtPrimerApellido"]) ? utils::getStringQuery($_POST["txtPrimerApellido"]) : "";
            $intPrimerApellidoKey = isset($_POST["hidPrimerApellidoKey"]) ? intval($_POST["hidPrimerApellidoKey"]) : 0;
            
            if( $intPrimerApellidoKey )
                $this->objModel->setUpdateSolCreditoDato($intPrimerApellidoKey, $strPrimerApellido);                
            else
                $this->objModel->setInsertSolCreditoDato($intSolCredito, "PRIMER_APELLIDO", $strPrimerApellido, 1);                
            
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strSegundoApellido = isset($_POST["txtSegundoApellido"]) ? utils::getStringQuery($_POST["txtSegundoApellido"]) : "";
            $intSegundoApellidoKey = isset($_POST["hidSegundoApellidoKey"]) ? intval($_POST["hidSegundoApellidoKey"]) : 0;
            
            if( $intSegundoApellidoKey )
                $this->objModel->setUpdateSolCreditoDato($intSegundoApellidoKey, $strSegundoApellido);                
            else
                $this->objModel->setInsertSolCreditoDato($intSolCredito, "SEGUNDO_APELLIDO", $strSegundoApellido, 1);                
            
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strApellidoCasada = isset($_POST["txtApellidoCasada"]) ? utils::getStringQuery($_POST["txtApellidoCasada"]) : "";
            $intApellidoCasadaKey = isset($_POST["hidApellidoCasadaKey"]) ? intval($_POST["hidApellidoCasadaKey"]) : 0;
            
            if( $intApellidoCasadaKey )
                $this->objModel->setUpdateSolCreditoDato($intApellidoCasadaKey, $strApellidoCasada);                
            else
                $this->objModel->setInsertSolCreditoDato($intSolCredito, "APELLIDO_CASADA", $strApellidoCasada, 1);                
            
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strFechaNacimiento = isset($_POST["txtFechaNacimiento"]) ? utils::getStringQuery($_POST["txtFechaNacimiento"]) : "";
            $intFechaNacimientoKey = isset($_POST["hidFechaNacimientoKey"]) ? intval($_POST["hidFechaNacimientoKey"]) : 0;
            
            if( $intFechaNacimientoKey )
                $this->objModel->setUpdateSolCreditoDato($intFechaNacimientoKey, $strFechaNacimiento);                
            else
                $this->objModel->setInsertSolCreditoDato($intSolCredito, "FECHA_NACIMIENTO", $strFechaNacimiento, 1);                
            
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strDpiPasaporte = isset($_POST["txtDpiPasaporte"]) ? utils::getStringQuery($_POST["txtDpiPasaporte"]) : "";
            $intDpiPasaporteKey = isset($_POST["hidDpiPasaporteKey"]) ? intval($_POST["hidDpiPasaporteKey"]) : 0;
            
            if( $intDpiPasaporteKey )
                $this->objModel->setUpdateSolCreditoDato($intDpiPasaporteKey, $strDpiPasaporte);                
            else
                $this->objModel->setInsertSolCreditoDato($intSolCredito, "DPI_PASAPORTE", $strDpiPasaporte, 1);                
            
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strDpiPasaporteExtendido = isset($_POST["txtDpiPasaporteExtendido"]) ? utils::getStringQuery($_POST["txtDpiPasaporteExtendido"]) : "";
            $intDpiPasaporteExtendidoKey = isset($_POST["hidDpiPasaporteExtendidoKey"]) ? intval($_POST["hidDpiPasaporteExtendidoKey"]) : 0;
            
            if( $intDpiPasaporteExtendidoKey )
                $this->objModel->setUpdateSolCreditoDato($intDpiPasaporteExtendidoKey, $strDpiPasaporteExtendido);                
            else
                $this->objModel->setInsertSolCreditoDato($intSolCredito, "DPI_PASAPORTE_EXTENDIDO", $strDpiPasaporteExtendido, 1);                
            
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strNoTelefono = isset($_POST["txtNoTelefono"]) ? utils::getStringQuery($_POST["txtNoTelefono"]) : "";
            $intNoTelefonoKey = isset($_POST["hidNoTelefonoKey"]) ? intval($_POST["hidNoTelefonoKey"]) : 0;
            
            if( $intNoTelefonoKey )
                $this->objModel->setUpdateSolCreditoDato($intNoTelefonoKey, $strNoTelefono);                
            else
                $this->objModel->setInsertSolCreditoDato($intSolCredito, "NO_TELEFONO", $strNoTelefono, 1);                
                
            
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strDireccionCompleta = isset($_POST["txtDireccionCompleta"]) ? utils::getStringQuery($_POST["txtDireccionCompleta"]) : "";
            $intDireccionCompletaKey = isset($_POST["hidDireccionCompletaKey"]) ? intval($_POST["hidDireccionCompletaKey"]) : 0;
            
            if( $intDireccionCompletaKey )
                $this->objModel->setUpdateSolCreditoDato($intDireccionCompletaKey, $strDireccionCompleta);                
            else
                $this->objModel->setInsertSolCreditoDato($intSolCredito, "DIRECCION", $strDireccionCompleta, 1);                
                
            
            ////////
            $strEstadoCivl = isset($_POST["rdEstadoCivil"]) ? utils::getStringQuery($_POST["rdEstadoCivil"]) : "";
            $intEstadoCivlKey = isset($_POST["hidEstadoCivilKey"]) ? intval($_POST["hidEstadoCivilKey"]) : 0;
            
            if( $intEstadoCivlKey )
                $this->objModel->setUpdateSolCreditoDato($intEstadoCivlKey, $strEstadoCivl);                
            else
                $this->objModel->setInsertSolCreditoDato($intSolCredito, "ESTADO_CIVIL", $strEstadoCivl, 1);                
                
            
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strDepartamento = isset($_POST["slcDepartamento"]) ? utils::getStringQuery($_POST["slcDepartamento"]) : "";
            $intDepartamentoKey = isset($_POST["slcDepartamentoKey"]) ? intval($_POST["slcDepartamentoKey"]) : 0;
            
            if( $intDepartamentoKey )
                $this->objModel->setUpdateSolCreditoDato($intDepartamentoKey, $strDepartamento);                
            else
                $this->objModel->setInsertSolCreditoDato($intSolCredito, "DIRECCION_DEPARTAMENTO", $strDepartamento, 1);                
                
            
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strCiudad = isset($_POST["slcCiudad"]) ? utils::getStringQuery($_POST["slcCiudad"]) : "";
            $intCiudadKey = isset($_POST["slcCiudadKey"]) ? intval($_POST["slcCiudadKey"]) : 0;
            
            if( $intCiudadKey )
                $this->objModel->setUpdateSolCreditoDato($intCiudadKey, $strCiudad);                
            else
                $this->objModel->setInsertSolCreditoDato($intSolCredito, "DIRECCION_CIUDAD", $strCiudad, 1);                
                
            
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                        
            $this->objModel->setUpdateSolCreditoEstado($intSolCredito, "FI1");                
            
            $arr["error"] = false;    
            $arr["msg"] = "Datos Bloque 1 Guardados Correctamente";
            
            print json_encode($arr);    
            die();
            
        }
        
        if( isset($_GET["setCreditoBloque2"]) ){
            
            $intSolCredito = isset($_POST["hidSolCredito"]) ? intval($_POST["hidSolCredito"]) : 0;
            
            $strNombreComercial = isset($_POST["txtNombreComercial"]) ? utils::getStringQuery($_POST["txtNombreComercial"]) : "";
            $intNombreComercialKey = isset($_POST["hidNombreComercialKey"]) ? intval($_POST["hidNombreComercialKey"]) : 0;
            
            if( $intNombreComercialKey )
                $this->objModel->setUpdateSolCreditoDato($intNombreComercialKey, $strNombreComercial);                
            else
                $this->objModel->setInsertSolCreditoDato($intSolCredito, "NOMBRE_COMERCIAL", $strNombreComercial, 2);                
            
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strDireccionResidencia = isset($_POST["txtDireccionResidencia"]) ? utils::getStringQuery($_POST["txtDireccionResidencia"]) : "";
            $intDireccionResidenciaKey = isset($_POST["hidDireccionResidenciaKey"]) ? intval($_POST["hidDireccionResidenciaKey"]) : 0;
            
            if( $intDireccionResidenciaKey )
                $this->objModel->setUpdateSolCreditoDato($intDireccionResidenciaKey, $strDireccionResidencia);                
            else
                $this->objModel->setInsertSolCreditoDato($intSolCredito, "DIRECCION_RESIDENCIA", $strDireccionResidencia, 2);                
            
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strNit = isset($_POST["txtNit"]) ? utils::getStringQuery($_POST["txtNit"]) : "";
            $intNitKey = isset($_POST["hidNitKey"]) ? intval($_POST["hidNitKey"]) : 0;
            
            if( $intNitKey )
                $this->objModel->setUpdateSolCreditoDato($intNitKey, $strNit);                
            else
                $this->objModel->setInsertSolCreditoDato($intSolCredito, "NIT", $strNit, 2);                
            
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strPatenteComercio = isset($_POST["txtPatenteComercio"]) ? utils::getStringQuery($_POST["txtPatenteComercio"]) : "";
            $intPatenteComercioKey = isset($_POST["hidPatenteComercioKey"]) ? intval($_POST["hidPatenteComercioKey"]) : 0;
            
            if( $intPatenteComercioKey )
                $this->objModel->setUpdateSolCreditoDato($intPatenteComercioKey, $strPatenteComercio);                
            else
                $this->objModel->setInsertSolCreditoDato($intSolCredito, "PATENTE_COMERCIO", $strPatenteComercio, 2);                
            
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strClaseNegocio = isset($_POST["rdClaseNegocio"]) ? utils::getStringQuery($_POST["rdClaseNegocio"]) : "";
            $intClaseNegocioKey = isset($_POST["hidPatenteComercioKey"]) ? intval($_POST["hidPatenteComercioKey"]) : 0;
            
            if( $intClaseNegocioKey )
                $this->objModel->setUpdateSolCreditoDato($intClaseNegocioKey, $strClaseNegocio);                
            else
                $this->objModel->setInsertSolCreditoDato($intSolCredito, "CLASE_NEGOCIO", $strClaseNegocio, 2);                
            
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strTipoLocal = isset($_POST["rdTipoLocal"]) ? utils::getStringQuery($_POST["rdTipoLocal"]) : "";
            $intTipoLocalKey = isset($_POST["hidTipoLocalKey"]) ? intval($_POST["hidTipoLocalKey"]) : 0;
            
            if( $intTipoLocalKey )
                $this->objModel->setUpdateSolCreditoDato($intTipoLocalKey, $strTipoLocal);                
            else
                $this->objModel->setInsertSolCreditoDato($intSolCredito, "TIPO_LOCAL", $strTipoLocal, 2);                
            
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strTiempoNegocio = isset($_POST["txtTiempoNegocio"]) ? utils::getStringQuery($_POST["txtTiempoNegocio"]) : "";
            $intTiempoNegocioKey = isset($_POST["hidTiempoNegocioKey"]) ? intval($_POST["hidTiempoNegocioKey"]) : 0;
            
            if( $intTiempoNegocioKey )
                $this->objModel->setUpdateSolCreditoDato($intTiempoNegocioKey, $strTiempoNegocio);                
            else
                $this->objModel->setInsertSolCreditoDato($intSolCredito, "TIEMPO_NEGOCIO", $strTiempoNegocio, 2);                
            
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strOtrosNegocio = isset($_POST["txtOtrosNegocios"]) ? utils::getStringQuery($_POST["txtOtrosNegocios"]) : "";
            $intOtrosNegocioKey = isset($_POST["hidOtrosNegociosKey"]) ? intval($_POST["hidOtrosNegociosKey"]) : 0;
            
            if( $intOtrosNegocioKey )
                $this->objModel->setUpdateSolCreditoDato($intOtrosNegocioKey, $strOtrosNegocio);                
            else
                $this->objModel->setInsertSolCreditoDato($intSolCredito, "OTROS_NEGOCIOS", $strOtrosNegocio, 2);                
            
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strActividadPrincipalNegocio = isset($_POST["txtActividadPrincipalNegocio"]) ? utils::getStringQuery($_POST["txtActividadPrincipalNegocio"]) : "";
            $intActividadPrincipalNegocioKey = isset($_POST["hidActividadPrincipalNegocioKey"]) ? intval($_POST["hidActividadPrincipalNegocioKey"]) : 0;
            
            if( $intActividadPrincipalNegocioKey )
                $this->objModel->setUpdateSolCreditoDato($intActividadPrincipalNegocioKey, $strActividadPrincipalNegocio);                
            else
                $this->objModel->setInsertSolCreditoDato($intSolCredito, "ACTIVIDAD_PRINCIPAL_NEGOCIO", $strActividadPrincipalNegocio, 2);                
            
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $sinMontoCreditoSolicitado = isset($_POST["txtMontoCreditoSolicitado"]) ? utils::getStringQuery($_POST["txtMontoCreditoSolicitado"]) : "";
            $intMontoCreditoSolicitadoKey = isset($_POST["hidMontoCreditoSolicitadoKey"]) ? intval($_POST["hidMontoCreditoSolicitadoKey"]) : 0;
            
            if( $intMontoCreditoSolicitadoKey )
                $this->objModel->setUpdateSolCreditoDato($intMontoCreditoSolicitadoKey, $sinMontoCreditoSolicitado);                
            else
                $this->objModel->setInsertSolCreditoDato($intSolCredito, "MONTO_SOLICITADO", $sinMontoCreditoSolicitado, 2);                
            
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strDireccionNegocio = isset($_POST["slcNegocioDepartamento"]) ? utils::getStringQuery($_POST["slcNegocioDepartamento"]) : "";
            $intDireccionNegocioKey = isset($_POST["slcNegocioDepartamentoKey"]) ? intval($_POST["slcNegocioDepartamentoKey"]) : 0;
            
            if( $intDireccionNegocioKey )
                $this->objModel->setUpdateSolCreditoDato($intDireccionNegocioKey, $strDireccionNegocio);                
            else
                $this->objModel->setInsertSolCreditoDato($intSolCredito, "DIRECCION_NEGOCIO_DEPARTAMENTO", $strDireccionNegocio, 2);                
            
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strCiudad = isset($_POST["slcCiudad"]) ? utils::getStringQuery($_POST["slcCiudad"]) : "";
            $intCiudadKey = isset($_POST["slcCiudadKey"]) ? intval($_POST["slcCiudadKey"]) : 0;
            
            if( $intCiudadKey )
                $this->objModel->setUpdateSolCreditoDato($intCiudadKey, $strCiudad);                
            else
                $this->objModel->setInsertSolCreditoDato($intSolCredito, "DIRECCION_NEGOCIO_CIUDAD", $strCiudad, 1);                
                
            
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            
            
            $this->objModel->setUpdateSolCreditoEstado($intSolCredito, "FI2");                
            
            $arr["error"] = false;    
            $arr["msg"] = "Datos Bloque 2 Guardados Correctamente";
            
            print json_encode($arr);    
            die();
            
        }
        
        if( isset($_GET["setCreditoBloque3"]) ){
            
            $intSolCredito = isset($_POST["hidSolCredito"]) ? intval($_POST["hidSolCredito"]) : 0;
            
            for( $i = 1; $i <= 3; $i++ ){
                
                $strNombreEmpresa = isset($_POST["txtNombreEmpresa_{$i}"]) ? utils::getStringQuery($_POST["txtNombreEmpresa_{$i}"]) : "";
                $intNombreEmpresaKey = isset($_POST["hidNombreEmpresa_{$i}"]) ? intval($_POST["hidNombreEmpresa_{$i}"]) : 0;
                
                if( $intNombreEmpresaKey )
                    $this->objModel->setUpdateSolCreditoDato($intNombreEmpresaKey, $strNombreEmpresa);                
                else
                    $this->objModel->setInsertSolCreditoDato($intSolCredito, "REFERENCIA_NOMBRE_EMPRESA_{$i}", $strNombreEmpresa, 3);                
                
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                 
                $strTelefonoEmpresa = isset($_POST["txtTelefonoEmpresa_{$i}"]) ? utils::getStringQuery($_POST["txtTelefonoEmpresa_{$i}"]) : "";
                $intTelefonoEmpresaKey = isset($_POST["hidTelefonoEmpresa_{$i}"]) ? intval($_POST["hidTelefonoEmpresa_{$i}"]) : 0;
                
                if( $intTelefonoEmpresaKey )
                    $this->objModel->setUpdateSolCreditoDato($intTelefonoEmpresaKey, $strTelefonoEmpresa);                
                else
                    $this->objModel->setInsertSolCreditoDato($intSolCredito, "REFERENCIA_TELEFONO_EMPRESA_{$i}", $strTelefonoEmpresa, 3);                
                
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                    
            }
            
            $strEncargadoCompras = isset($_POST["txtEncargadoCompras"]) ? utils::getStringQuery($_POST["txtEncargadoCompras"]) : "";
            $intEncargadoComprasKey = isset($_POST["hidEncargadoComprasKey"]) ? intval($_POST["hidEncargadoComprasKey"]) : 0;
            
            if( $intEncargadoComprasKey )
                $this->objModel->setUpdateSolCreditoDato($intEncargadoComprasKey, $strEncargadoCompras);                
            else
                $this->objModel->setInsertSolCreditoDato($intSolCredito, "ENCARGADO_COMPRAS", $strEncargadoCompras, 3);                
            
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strEncargadoPagos = isset($_POST["txtEncargadoPagos"]) ? utils::getStringQuery($_POST["txtEncargadoPagos"]) : "";
            $intEncargadoPagosKey = isset($_POST["hidEncargadoPagosKey"]) ? intval($_POST["hidEncargadoPagosKey"]) : 0;
            
            if( $intEncargadoPagosKey )
                $this->objModel->setUpdateSolCreditoDato($intEncargadoPagosKey, $strEncargadoPagos);                
            else
                $this->objModel->setInsertSolCreditoDato($intSolCredito, "ENCARGADO_PAGOS", $strEncargadoPagos, 3);                
            
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strFormaPago = isset($_POST["rdFormaPago"]) ? utils::getStringQuery($_POST["rdFormaPago"]) : "";
            $intFormaPagoKey = isset($_POST["hidFormaPagoKey"]) ? intval($_POST["hidFormaPagoKey"]) : 0;
            
            if( $intFormaPagoKey )
                $this->objModel->setUpdateSolCreditoDato($intFormaPagoKey, $strFormaPago);                
            else
                $this->objModel->setInsertSolCreditoDato($intSolCredito, "FORMA_PAGO", $strFormaPago, 3);                
            
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strPlazoCredito = isset($_POST["txtPlazoCredito"]) ? utils::getStringQuery($_POST["txtPlazoCredito"]) : "";
            $intPlazoCreditoKey = isset($_POST["hidPlazoCreditoKey"]) ? intval($_POST["hidPlazoCreditoKey"]) : 0;
            
            if( $intPlazoCreditoKey )
                $this->objModel->setUpdateSolCreditoDato($intPlazoCreditoKey, $strPlazoCredito);                
            else
                $this->objModel->setInsertSolCreditoDato($intSolCredito, "PLAZO_CREDITO", $strPlazoCredito, 3);                
            
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strPlazoDias = isset($_POST["txtPlazoDias"]) ? utils::getStringQuery($_POST["txtPlazoDias"]) : "";
            $intPlazoDiasKey = isset($_POST["hidPlazoCreditoKey"]) ? intval($_POST["hidPlazoCreditoKey"]) : 0;
            
            if( $intPlazoDiasKey )
                $this->objModel->setUpdateSolCreditoDato($intPlazoDiasKey, $strPlazoDias);                
            else
                $this->objModel->setInsertSolCreditoDato($intSolCredito, "PLAZO_DIAS", $strPlazoDias, 3);                
            
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            
            $this->objModel->setUpdateSolCreditoEstado($intSolCredito, "FI3");                
            
            $arr["error"] = false;    
            $arr["msg"] = "Datos Bloque 3 Guardados Correctamente";
            
            print json_encode($arr);    
            die();
            
        }
        
        if( isset($_GET["setCreditoBloque4"]) ){
            
            $intSolCredito = isset($_POST["hidSolCredito"]) ? intval($_POST["hidSolCredito"]) : 0;
            $strTipoFirma = isset($_POST["hidTipoFirma"]) ? trim($_POST["hidTipoFirma"]) : "D";
            
            $strFirmaCarpeta = "files/{$intSolCredito}";
            if( !file_exists($strFirmaCarpeta) ) mkdir($strFirmaCarpeta, 0777, true);
            
            $strDate = date("YmdGis");
            if( $strTipoFirma == "D" && isset($_POST["dataFirma"]) ){
                
                $strDataFirma = isset($_POST["dataFirma"]) ? $_POST["dataFirma"] : "";
                $arrDataFirma = explode(",", $strDataFirma);
                
                $strFirmaUrl = "{$strFirmaCarpeta}/firma_{$intSolCredito}_{$strDate}.png";
                
                $file = fopen($strFirmaUrl, "wb");
                fwrite($file, base64_decode($arrDataFirma[1]));
                fclose($file);
                
                $this->objModel->setDeleteSolCreditoDato($intSolCredito, "FIRMA_URL");                    
                $this->objModel->setInsertSolCreditoDato($intSolCredito, "FIRMA_URL", $strFirmaUrl, 4);                
                
                
            }
                
            if( $strTipoFirma == "A" && isset($_FILES["flFirma"]) && $_FILES["flFirma"]["size"] > 0 ){
                
                $strFirmaUrl = "{$strFirmaCarpeta}/firma_{$intSolCredito}_{$strDate}.png";    
                rename($_FILES["flFirma"]["tmp_name"], $strFirmaUrl);
                $this->objModel->setDeleteSolCreditoDato($intSolCredito, "FIRMA_URL");                    
                $this->objModel->setInsertSolCreditoDato($intSolCredito, "FIRMA_URL", $strFirmaUrl, 4);                    
            }
            
                
            if( isset($_FILES["flDpiPasaporte"]) && $_FILES["flDpiPasaporte"]["size"] > 0 ){
                
                $strDpiPasaporte = "{$strFirmaCarpeta}/dpipasaporte_{$intSolCredito}_{$strDate}.png";    
                rename($_FILES["flDpiPasaporte"]["tmp_name"], $strDpiPasaporte);
                $this->objModel->setDeleteSolCreditoDato($intSolCredito, "DPI_PASAPORTE_URL");                    
                $this->objModel->setInsertSolCreditoDato($intSolCredito, "DPI_PASAPORTE_URL", $strDpiPasaporte, 4);                    
            }
            
            if( isset($_FILES["flPatenteComercio"]) && $_FILES["flPatenteComercio"]["size"] > 0 ){
                
                $strPatente = "{$strFirmaCarpeta}/patente_{$intSolCredito}_{$strDate}.png";    
                rename($_FILES["flPatenteComercio"]["tmp_name"], $strPatente);
                $this->objModel->setDeleteSolCreditoDato($intSolCredito, "PATENTE_URL");                    
                $this->objModel->setInsertSolCreditoDato($intSolCredito, "PATENTE_URL", $strPatente, 4);                    
            }
            
            if( isset($_FILES["flDpiRepresentanteLegal"]) && $_FILES["flDpiRepresentanteLegal"]["size"] > 0 ){
                
                $strDpiRepresentanteLegal = "{$strFirmaCarpeta}/dpi_repres_legal_{$intSolCredito}_{$strDate}.png";    
                rename($_FILES["flDpiRepresentanteLegal"]["tmp_name"], $strDpiRepresentanteLegal);
                $this->objModel->setDeleteSolCreditoDato($intSolCredito, "DPI_REPRESENTANTE_LEGAL_URL");                    
                $this->objModel->setInsertSolCreditoDato($intSolCredito, "DPI_REPRESENTANTE_LEGAL_URL", $strDpiRepresentanteLegal, 4);                    
            }
            
            if( isset($_FILES["flRepresentanteLegal"]) && $_FILES["flRepresentanteLegal"]["size"] > 0 ){
                
                $strRepresentanteLegal = "{$strFirmaCarpeta}/repres_legal_{$intSolCredito}_{$strDate}.png";    
                rename($_FILES["flRepresentanteLegal"]["tmp_name"], $strRepresentanteLegal);
                $this->objModel->setDeleteSolCreditoDato($intSolCredito, "REPRESENTANTE_LEGAL_URL");                    
                $this->objModel->setInsertSolCreditoDato($intSolCredito, "REPRESENTANTE_LEGAL_URL", $strRepresentanteLegal, 4);                    
            }
            
            if( isset($_FILES["flLicenciaSanitaria"]) && $_FILES["flLicenciaSanitaria"]["size"] > 0 ){
                
                $strLicenciaSanitaria = "{$strFirmaCarpeta}/lic_sanitaria_{$intSolCredito}_{$strDate}.png";    
                rename($_FILES["flLicenciaSanitaria"]["tmp_name"], $strLicenciaSanitaria);
                $this->objModel->setDeleteSolCreditoDato($intSolCredito, "LICENCIA_SANITARIA_URL");                    
                $this->objModel->setInsertSolCreditoDato($intSolCredito, "LICENCIA_SANITARIA_URL", $strLicenciaSanitaria, 4);                    
            }
            
            if( isset($_FILES["flRTU"]) && $_FILES["flRTU"]["size"] > 0 ){
                
                $strRTU = "{$strFirmaCarpeta}/rtu_{$intSolCredito}_{$strDate}.png";    
                rename($_FILES["flRTU"]["tmp_name"], $strRTU);
                $this->objModel->setDeleteSolCreditoDato($intSolCredito, "RTU_URL");                    
                $this->objModel->setInsertSolCreditoDato($intSolCredito, "RTU_URL", $strRTU, 4);                    
            }
            
            
            $this->objModel->setUpdateSolCreditoEstado($intSolCredito, "FEP");
            
            $arrSolCredito = $this->objModel->getSolCreditoClienteKey($intSolCredito);
            
            $arrSolCredito = $arrSolCredito[$intSolCredito];
            
            $strBody = '<table style="width: 30%; border: 1px solid black;">
                            <tr>
                                <td nowrap style="width: 50%; text-align: left; font-weight: bold; border: 1px solid black;">
                                    Cliente
                                </td>
                                <td nowrap style="width: 50%; text-align: center; border: 1px solid black;">
                                    '.$arrSolCredito["nombres"].' '.$arrSolCredito["apellidos"].'
                                </td>
                            </tr>
                            
                            <tr>
                                <td nowrap style="width: 50%; text-align: left; font-weight: bold; border: 1px solid black; ">
                                    Email
                                </td>
                                <td nowrap style="width: 50%; text-align: center; border: 1px solid black;">
                                    '.$arrSolCredito["email"].'
                                </td>
                            </tr>
                                  
                            <tr>
                                <td nowrap style="width: 50%; text-align: left; font-weight: bold; border: 1px solid black; ">
                                    # Credito
                                </td>
                                <td nowrap style="width: 50%; text-align: center; border: 1px solid black;">
                                    '.$intSolCredito.'
                                </td>
                            </tr>
                            
                            <tr>
                                <td nowrap colspan="2" style="text-align: center; font-weight: bold; ">
                                    Navega a <a href="http://leterago.com/" target="_blank">leterago.com</a> para ver los datos ingresados en el Formulario de Credito
                                </td>
                            </tr>
                            
                        </table>';
                        
            utils::sendEmail("idroys4@gmail.com", "Solicitud de Credito #".$intSolCredito.", Datos Enviados", $strBody, false);
                            
            $arr["error"] = false;    
            $arr["msg"] = "Formulario enviado correctamente, pronto tendras respuesta via email ( {$arrSolCredito["email"]} )";
            
            print json_encode($arr);    
            die();
        }
            
        if( isset($_GET["drawListCreditoCliente"]) ){
            
            $arrCreditos = $this->objModel->getCreditos($_SESSION['leterago']['id']);
            
            $this->objView->drawListCreditosCliente($arrCreditos);
            
            die();
        }
            
        if( isset($_GET["setCreditoRechazo"]) ){
            
            $intSolCredito = isset($_POST["hidSolCredito"]) ? intval($_POST["hidSolCredito"]) : 0;
            $strNotaRechazo = isset($_POST["txtNotaRechazo"]) ? utils::getStringQuery($_POST["txtNotaRechazo"]) : 0;
            
            $this->objModel->setUpdateSolCreditoEstado($intSolCredito, "FRE");
            $this->objModel->setUpdateSolCreditoEstadoNotaRechazo($intSolCredito, $strNotaRechazo);
            
            $arrSolCredito = $this->objModel->getSolCreditoClienteKey($intSolCredito);
            
            $arrSolCredito = $arrSolCredito[$intSolCredito];
            
            $strBody = '<table style="width: 30%; border: 1px solid black;">
                            <tr>
                                <td nowrap style="width: 50%; text-align: left; font-weight: bold; border: 1px solid black;">
                                    Cliente
                                </td>
                                <td nowrap style="width: 50%; text-align: center; border: 1px solid black;">
                                    '.$arrSolCredito["nombres"].' '.$arrSolCredito["apellidos"].'
                                </td>
                            </tr>
                            
                            <tr>
                                <td nowrap style="width: 50%; text-align: left; font-weight: bold; border: 1px solid black; ">
                                    # Credito
                                </td>
                                <td nowrap style="width: 50%; text-align: center; border: 1px solid black;">
                                    '.$intSolCredito.'
                                </td>
                            </tr>
                            <tr>
                                <td nowrap style="width: 50%; text-align: left; font-weight: bold; border: 1px solid black; ">
                                    Motivo de Rechazo
                                </td>
                                <td nowrap style="width: 50%; text-align: center; border: 1px solid black;">
                                    '.$strNotaRechazo.'
                                </td>
                            </tr>
                            
                            <tr>
                                <td nowrap colspan="2" style="text-align: center; font-weight: bold; ">
                                    Navega a <a href="http://leterago.com/" target="_blank">leterago.com</a> para ver los datos ingresados en el Formulario de Credito
                                </td>
                            </tr>
                            
                        </table>';
                        
            utils::sendEmail("idroys4@gmail.com", "Solicitud de Credito #".$intSolCredito.", Rechazada", $strBody, false);
                            
            $arr["error"] = false;    
            $arr["msg"] = "Solicitud de credito Rechazada";
            
            print json_encode($arr);    
            die();
        }
        
        if( isset($_GET["setCreditoAprobacion"]) ){
            
            $intSolCredito = isset($_POST["hidSolCredito"]) ? intval($_POST["hidSolCredito"]) : 0;
            
            $this->objModel->setUpdateSolCreditoEstado($intSolCredito, "SCA");
            $this->objModel->setUpdateSolCreditoEstadoNotaRechazo($intSolCredito, "");
            
            $arrSolCredito = $this->objModel->getSolCreditoClienteKey($intSolCredito);
            $arrSolCreditoDato = $this->objModel->getSolCreditoDato($intSolCredito); 
            
            $arrSolCredito = $arrSolCredito[$intSolCredito];
            
            $strBody = '<table style="width: 30%; border: 1px solid black;">
                            <tr>
                                <td nowrap style="width: 50%; text-align: left; font-weight: bold; border: 1px solid black;">
                                    Cliente
                                </td>
                                <td nowrap style="width: 50%; text-align: center; border: 1px solid black;">
                                    '.$arrSolCredito["nombres"].' '.$arrSolCredito["apellidos"].'
                                </td>
                            </tr>
                            
                            <tr>
                                <td nowrap style="width: 50%; text-align: left; font-weight: bold; border: 1px solid black; ">
                                    # Credito
                                </td>
                                <td nowrap style="width: 50%; text-align: center; border: 1px solid black;">
                                    '.$intSolCredito.'
                                </td>
                            </tr>
                            
                            <tr>
                                <td nowrap colspan="2" style="text-align: center; font-weight: bold; ">
                                    Navega a <a href="http://leterago.com/" target="_blank">leterago.com</a> para ver los datos ingresados en el Formulario de Credito
                                </td>
                            </tr>
                            
                        </table>';
            
            
            /*********************************************************/
            /*********************************************************/
            /*********************************************************/
            /*********************************************************/
            /*********************************************************/
            $strPDFConvenio = utils::getPDFConvenioLeterago($arrSolCredito, $arrSolCreditoDato);

            /*********************************************************/
            /*********************************************************/
            /*********************************************************/
            /*********************************************************/
            /*********************************************************/
            /*********************************************************/
            
            
                        
            utils::sendEmail("idroys4@gmail.com", "Solicitud de Credito #".$intSolCredito.", Aprobada", $strBody, false, $strPDFConvenio, 'credito-'.$intSolCredito.'.pdf');
                            
            $arr["error"] = false;    
            $arr["msg"] = "Solicitud de credito Aprobado, documento enviado";
            
            print json_encode($arr);    
            die();
        }
            
    }
              
}

?>
