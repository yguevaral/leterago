<?php

require_once 'models/cliente_model.php';
require_once 'views/cliente/cliente_view.php';

class clienteController {

    var $objView;
    var $objModel;

    public function __construct() {

        $this->objView = new cliente_view();
        $this->objModel = new cliente_model();
    }
    
    public function index() {
        
        utils::isIdentity();
        
        //utils::drawDebug($_SESSION["leterago"]["tipo"]);
        if ( $_SESSION["leterago"]["tipo"] == "CL" ){
                    
            $arrCredito = $this->objModel->getCliente($_SESSION['leterago']['id']);
            
            $boolSolCreditoBloque1 = false;
            $intCliente = 0;
            while( $rTMP = each($arrCredito) ){
                
                if( $rTMP["value"]["estado"] == "ISC" ){
                    
                    $intCliente = $rTMP["value"]["id_cliente"];
                    $boolSolCreditoBloque1 = true;
                    
                }
                
            }
            
            if( $boolSolCreditoBloque1 ){
                
                $arrCreditoDato = $this->objModel->getClienteDato($intCliente);    
                $this->objView->fntSolCreditoFormBloque1($intCliente, $arrCredito[$intCliente], $arrCreditoDato);    
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
        
        if( isset($_GET["drawAdminModalCreditoClientePotencial"]) ){
            
            $intCredito = isset($_GET["credito"]) ? intval($_GET["credito"]) : 0;
            
            $this->objView->drawAdminModalCredito($intCredito, true);
            
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
            
            $intCliente = isset($_POST["hidCredito"]) ? intval($_POST["hidCredito"]) : 0;
            
            $strPrimerNombre = isset($_POST["txtPrimerNombre"]) ? trim($_POST["txtPrimerNombre"]) : "";
            $strSegundoNombre = isset($_POST["txtSegundoNombre"]) ? trim($_POST["txtSegundoNombre"]) : "";
            $strPrimerApellido = isset($_POST["txtPrimerApellido"]) ? trim($_POST["txtPrimerApellido"]) : "";
            $strSegundoApellido = isset($_POST["txtSegundoApellido"]) ? trim($_POST["txtSegundoApellido"]) : "";
            
            $strNombreComercial = isset($_POST["txtNombreEmpresa"]) ? trim($_POST["txtNombreEmpresa"]) : "";
            $strClientePotencial = isset($_POST["hidClientePotencial"]) ? trim($_POST["hidClientePotencial"]) : "N";
            
            $strNombre = $strPrimerNombre." ".$strSegundoNombre;
            $strApellido = $strPrimerApellido." ".$strSegundoApellido;
            
            $strEmail = isset($_POST["txtEmailUsuario"]) ? trim($_POST["txtEmailUsuario"]) : "";
            $strClave = rand(1000, 9999);
            $strTipo = "CL";
            $strEstado = "AC";
            $strSexo = isset($_POST["slcSexo"]) ? trim($_POST["slcSexo"]) : "";
            
            $intUsuarioAsesor = $_SESSION['leterago']['id']; 
            
            
            if( !$intCliente ){
                
                $intUsuario = $this->objModel->fntSetUsuario($strNombre, $strApellido, $strSexo, $strEmail, $strClave, $strTipo, $strEstado);
                
                $arr["error"] = true;    
                $arr["msg"] = "Error";
                if( $intUsuario ){
                    
                    $intCliente = $this->objModel->setCliente($intUsuario, "ISP", $intUsuarioAsesor, $strClientePotencial);
                    
                    $this->objModel->setInsertSolCreditoDato($intCliente, "PRIMER_NOMBRE", $strPrimerNombre, 1);                
                    $this->objModel->setInsertSolCreditoDato($intCliente, "SEGUNDO_NOMBRE", $strSegundoNombre, 1);                

                    $this->objModel->setInsertSolCreditoDato($intCliente, "PRIMER_APELLIDO", $strPrimerApellido, 1);                
                    $this->objModel->setInsertSolCreditoDato($intCliente, "SEGUNDO_APELLIDO", $strSegundoApellido, 1);          

                    $this->objModel->setInsertSolCreditoDato($intCliente, "NOMBRE_COMERCIAL", $strNombreComercial, 2);    
                    
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
                                            # Cliente
                                        </td>
                                        <td nowrap style="width: 50%; text-align: center; border: 1px solid black;">
                                            '.$intCliente.'
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td nowrap colspan="2" style="text-align: center; font-weight: bold; ">
                                            Navega a <a href="http://leterago.com/" target="_blank">leterago.com</a> con he ingresa con tu email y clave para completar el formulacion de solicitud de credito
                                        </td>
                                    </tr>
                                    
                                </table>';
                                
                    utils::sendEmail("idroys4@gmail.com", "Alta de Cliente #".$intCliente, $strBody, false);
                    
                    $arr["error"] = false;    
                    $arr["msg"] = "Alta de Cliente Creada, email enviado a cliente";
                        
                }
                
            }
            
            print json_encode($arr);            
            die();
            
        }
        
        if( isset($_GET["showSolCreditoConsolidado"]) ){
            
            $intSolCredito = isset($_GET["credito"]) ? intval($_GET["credito"]) : 0;
            $arrSolCredito = $this->objModel->getCliente($_SESSION['leterago']['id'], $intSolCredito);
            
            $arrSolCreditoDato = $this->objModel->getClienteDato($intSolCredito);    
            $this->objView->fntSolCreditoConsolidado($intSolCredito, ( isset($arrSolCredito[$intSolCredito]) ? $arrSolCredito[$intSolCredito] : array() ), $arrSolCreditoDato);
            
            die();
        }
        
        if( isset($_GET["showSolCreditoFormBloque1"]) ){
            
            $intSolCredito = isset($_GET["credito"]) ? intval($_GET["credito"]) : 0;
            $arrSolCredito = $this->objModel->getCliente($_SESSION['leterago']['id'], $intSolCredito);
            
            $arrSolCreditoDato = $this->objModel->getClienteDato($intSolCredito);    
            $this->objView->fntSolCreditoFormBloque1($intSolCredito, ( isset($arrSolCredito[$intSolCredito]) ? $arrSolCredito[$intSolCredito] : array() ), $arrSolCreditoDato);
            
            die();
        }
        
        if( isset($_GET["showSolCreditoFormBloque2"]) ){
            
            $intSolCredito = isset($_GET["credito"]) ? intval($_GET["credito"]) : 0;
            $arrSolCredito = $this->objModel->getCliente($_SESSION['leterago']['id'], $intSolCredito);
            
            $arrSolCreditoDato = $this->objModel->getClienteDato($intSolCredito);    
            $this->objView->fntSolCreditoFormBloque2($intSolCredito, $arrSolCredito[$intSolCredito], $arrSolCreditoDato);
            
            die();
        }
        
        if( isset($_GET["showSolCreditoFormBloque3"]) ){
            
            $intSolCredito = isset($_GET["credito"]) ? intval($_GET["credito"]) : 0;
            $arrSolCredito = $this->objModel->getCliente($_SESSION['leterago']['id'], $intSolCredito);
            
            $arrSolCreditoDato = $this->objModel->getClienteDato($intSolCredito);    
            $this->objView->fntSolCreditoFormBloque3($intSolCredito, $arrSolCredito[$intSolCredito], $arrSolCreditoDato);
            
            die();
        }
        
        if( isset($_GET["showSolCreditoFormBloque4"]) ){
            
            $intSolCredito = isset($_GET["credito"]) ? intval($_GET["credito"]) : 0;
            $arrSolCredito = $this->objModel->getCliente($_SESSION['leterago']['id'], $intSolCredito);
            
            $arrSolCreditoDato = $this->objModel->getClienteDato($intSolCredito);    
            $this->objView->fntSolCreditoFormBloque4($intSolCredito, $arrSolCredito[$intSolCredito], $arrSolCreditoDato);
            
            die();
        }
        
        if( isset($_GET["showSolCreditoFormBloque5"]) ){
            
            $intSolCredito = isset($_GET["credito"]) ? intval($_GET["credito"]) : 0;
            $arrSolCredito = $this->objModel->getCliente($_SESSION['leterago']['id'], $intSolCredito);
            
            $arrSolCreditoDato = $this->objModel->getClienteDato($intSolCredito);    
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
            $boolOnlyDocs = isset($_GET["docs"]) && $_GET["docs"] == "true" ? true : false;
            
            $strFirmaCarpeta = "files/{$intSolCredito}";
            $strDate = date("YmdGis");
            if( !$boolOnlyDocs ){
                
                
                if( !file_exists($strFirmaCarpeta) ) mkdir($strFirmaCarpeta, 0777, true);
                
                
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
                
            }
                
            //////////////////////
            
            
            $arrfl = array();
            
            $arrflTMP["keyfl"] = "CRL";    
            $arrflTMP["keydb"] = "CEDULA_REPRESENTANTE_LEGAL";
            $arrflTMP["keyflinput"] = "flCEDULA_REPRESENTANTE_LEGAL";
            array_push($arrfl, $arrflTMP);
            
            $arrflTMP["keyfl"] = "NL";    
            $arrflTMP["keydb"] = "NOMBRAMIENTO_LEGAL";
            $arrflTMP["keyflinput"] = "flNOMBRAMIENTO_LEGAL";
            array_push($arrfl, $arrflTMP);
            
            
            $arrflTMP["keyfl"] = "DPJ";    
            $arrflTMP["keydb"] = "DPI_PERSONA_JUDIRICA";
            $arrflTMP["keyflinput"] = "flDPI_PERSONA_JUDIRICA";
            array_push($arrfl, $arrflTMP);
            
            
            $arrflTMP["keyfl"] = "PO";    
            $arrflTMP["keydb"] = "PERMISO_OPERACIONES";
            $arrflTMP["keyflinput"] = "flPERMISO_OPERACIONES";
            array_push($arrfl, $arrflTMP);
            
            
            $arrflTMP["keyfl"] = "LS";    
            $arrflTMP["keydb"] = "LICENCIA_SANITARIA";
            $arrflTMP["keyflinput"] = "flLICENCIA_SANITARIA";
            array_push($arrfl, $arrflTMP);
            
            
            $arrflTMP["keyfl"] = "LR";    
            $arrflTMP["keydb"] = "LICENCIA_REGENTE";
            $arrflTMP["keyflinput"] = "flLICENCIA_REGENTE";
            array_push($arrfl, $arrflTMP);
            
            $arrflTMP["keyfl"] = "PCSC";    
            $arrflTMP["keydb"] = "PERMISO_COMERCIALIZAR_SUSTANCIAS_CONTROLADAS";
            $arrflTMP["keyflinput"] = "flPERMISO_COMERCIALIZAR_SUSTANCIAS_CONTROLADAS";
            array_push($arrfl, $arrflTMP);
            
            $arrflTMP["keyfl"] = "GC";    
            $arrflTMP["keydb"] = "GESTIONA_COORDENADA";
            $arrflTMP["keyflinput"] = "flGESTIONA_COORDENADA";
            array_push($arrfl, $arrflTMP);
            
            
            while( $rTMP = each($arrfl) ){
                
                
                if( isset($_FILES[$rTMP["value"]["keyflinput"]]) && $_FILES[$rTMP["value"]["keyflinput"]]["size"] > 0 ){
                    
                    $strKeyFile = "{$strFirmaCarpeta}/{$rTMP["value"]["keyfl"]}_{$intSolCredito}_{$strDate}.png";    
                    
                    rename($_FILES[$rTMP["value"]["keyflinput"]]["tmp_name"], $strKeyFile);
                    $this->objModel->setDeleteSolCreditoDato($intSolCredito, $rTMP["value"]["keydb"]);                    
                    $this->objModel->setInsertSolCreditoDato($intSolCredito, $rTMP["value"]["keydb"], $strKeyFile, 5);                    
                }
            }
            
            
            if( !$boolOnlyDocs ){
                
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
                            
                utils::sendEmail("idroys4@gmail.com", "Alta de Cliente #".$intSolCredito.", Datos Enviados", $strBody, false);
                                
                $arr["error"] = false;    
                $arr["msg"] = "Formulario enviado correctamente, pronto tendras respuesta via email ( {$arrSolCredito["email"]} )";
            }
            else{
                
                $arr["error"] = false;    
                $arr["msg"] = "Documentos actualizados correctamente";
            }
            
            
            print json_encode($arr);    
            die();
        }
            
        if( isset($_GET["drawListCreditoCliente"]) ){
            
            $arrClientes = $this->objModel->getClientes($_SESSION['leterago']['id']);
            
            $this->objView->drawListCreditosCliente($arrClientes);
            
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
                        
            utils::sendEmail("idroys4@gmail.com", "Alta de Cliente #".$intSolCredito.", Rechazada", $strBody, false);
                            
            $arr["error"] = false;    
            $arr["msg"] = "Alta de Cliente Rechazada";
            
            print json_encode($arr);    
            die();
        }
        
        if( isset($_GET["setCreditoAprobacion"]) ){
            
            $intSolCredito = isset($_POST["hidSolCredito"]) ? intval($_POST["hidSolCredito"]) : 0;
            
            $this->objModel->setUpdateSolCreditoEstado($intSolCredito, "CCA");
            $this->objModel->setUpdateSolCreditoEstadoNotaRechazo($intSolCredito, "");
            
            $arrSolCredito = $this->objModel->getSolCreditoClienteKey($intSolCredito);
            $arrSolCreditoDato = $this->objModel->getClienteDato($intSolCredito); 
            
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
            
            
                        
            utils::sendEmail("idroys4@gmail.com", "Alta de Cliente #".$intSolCredito.", Aprobada", $strBody, false, $strPDFConvenio, 'credito-'.$intSolCredito.'.pdf');
                            
            $arr["error"] = false;    
            $arr["msg"] = "Alta de Cliente Aprobado, documento enviado";
            
            print json_encode($arr);    
            die();
        }
        
        if( isset($_GET["setCreditoAprobacionCredito"]) ){
            
            $intSolCredito = isset($_POST["hidSolCredito"]) ? intval($_POST["hidSolCredito"]) : 0;
            
            $this->objModel->setUpdateClienteCreditoEstado($intSolCredito, "FCA");
            $this->objModel->setUpdateSolCreditoEstadoNotaRechazo($intSolCredito, "");
            
            $arrSolCredito = $this->objModel->getSolCreditoClienteKey($intSolCredito);
            $arrSolCreditoDato = $this->objModel->getClienteDato($intSolCredito); 
            
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
            
            
                        
            utils::sendEmail("idroys4@gmail.com", "Solicitud Credito, Cliente #".$intSolCredito.", Aprobada", $strBody, false, $strPDFConvenio, 'credito-'.$intSolCredito.'.pdf');
                            
            $arr["error"] = false;    
            $arr["msg"] = "Credito Aprobado, documento enviado";
            
            print json_encode($arr);    
            die();
        }
        
        if( isset($_GET["setEnviarFormularioCredito"]) ){
            
            $intCliente = isset($_GET["cliente"]) ? intval($_GET["cliente"]) : 0;
            
            $arrCreditos = $this->objModel->getCreditosAdmin("", "", "", $intCliente );
            $this->objModel->setSolClienteCredito($intCliente);
            $arrCreditos = $arrCreditos[$intCliente];
            
            $strBody = '<table style="width: 30%; border: 1px solid black;">
                            <tr>
                                <td nowrap style="width: 50%; text-align: left; font-weight: bold; border: 1px solid black;">
                                    Cliente
                                </td>
                                <td nowrap style="width: 50%; text-align: center; border: 1px solid black;">
                                    '.$arrCreditos["nombre_empresa"].'
                                </td>
                            </tr>
                            
                            <tr>
                                <td nowrap style="width: 50%; text-align: left; font-weight: bold; border: 1px solid black; ">
                                    # Credito
                                </td>
                                <td nowrap style="width: 50%; text-align: center; border: 1px solid black;">
                                    Completa el formulario 03-F04 para solicitar tu credito
                                </td>
                            </tr>
                            
                            <tr>
                                <td nowrap colspan="2" style="text-align: center; font-weight: bold; ">
                                    Navega a <a href="http://leterago.com/" target="_blank">leterago.com</a> para ver los datos ingresados en el Formulario de Credito
                                </td>
                            </tr>
                            
                        </table>';
              
            
            utils::sendEmail("idroys4@gmail.com", "Cliente #".$intCliente.", solicitud de credito", $strBody, false);
            
            die();
        }
        
        if( isset($_GET["drawFormCredito1"]) ){
            
            $intCliente = isset($_GET["cliente"]) ? intval($_GET["cliente"]) : 0;
            $arrSolCredito = $this->objModel->getCliente($_SESSION['leterago']['id'], $intCliente);
            
            $arrSolCreditoDato = $this->objModel->getClienteDato($intCliente);    
            $this->objView->drawFormCredito1($intCliente, ( isset($arrSolCredito[$intCliente]) ? $arrSolCredito[$intCliente] : array() ), $arrSolCreditoDato);
            
            die();
        }
        
        if( isset($_GET["setFormCredito1"]) ){
            
            $intCliente = isset($_POST["hidCliente"]) ? intval($_POST["hidCliente"]) : 0;
            
            $strRazonSocial = isset($_POST["txtC_RAZON_SOCIAL"]) ? utils::getStringQuery($_POST["txtC_RAZON_SOCIAL"]) : "";
            $intRazonSocial = isset($_POST["hidC_RAZON_SOCIAL"]) ? intval($_POST["hidC_RAZON_SOCIAL"]) : 0;
            
            if( $intRazonSocial )
                $this->objModel->setUpdateSolCreditoDato($intRazonSocial, $strRazonSocial);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, "C_RAZON_SOCIAL", $strRazonSocial, 1);                
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strRazonSocialAntiguedad = isset($_POST["txtC_RAZON_SOCIAL_ACTIGUEDAD"]) ? utils::getStringQuery($_POST["txtC_RAZON_SOCIAL_ACTIGUEDAD"]) : "";
            $intRazonSocialAntiguedad = isset($_POST["hidC_RAZON_SOCIAL_ACTIGUEDAD"]) ? intval($_POST["hidC_RAZON_SOCIAL_ACTIGUEDAD"]) : 0;
            
            if( $intRazonSocialAntiguedad )
                $this->objModel->setUpdateSolCreditoDato($intRazonSocialAntiguedad, $strRazonSocialAntiguedad);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, "C_RAZON_SOCIAL_ACTIGUEDAD", $strRazonSocialAntiguedad, 1);                
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strNombreComercial = isset($_POST["txtC_NOMBRE_COMERCIAL"]) ? utils::getStringQuery($_POST["txtC_NOMBRE_COMERCIAL"]) : "";
            $intNombreComercial = isset($_POST["hidC_NOMBRE_COMERCIAL"]) ? intval($_POST["hidC_NOMBRE_COMERCIAL"]) : 0;
            
            if( $intNombreComercial )
                $this->objModel->setUpdateSolCreditoDato($intNombreComercial, $strNombreComercial);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, "C_NOMBRE_COMERCIAL", $strNombreComercial, 1);                
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strNumRegistroTributario = isset($_POST["txtC_NUM_REGISTRO_TRIBUTARIO"]) ? utils::getStringQuery($_POST["txtC_NUM_REGISTRO_TRIBUTARIO"]) : "";
            $intNumRegistroTributario = isset($_POST["hidC_NUM_REGISTRO_TRIBUTARIO"]) ? intval($_POST["hidC_NUM_REGISTRO_TRIBUTARIO"]) : 0;
            
            if( $intNumRegistroTributario )
                $this->objModel->setUpdateSolCreditoDato($intNumRegistroTributario, $strNumRegistroTributario);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, "C_NUM_REGISTRO_TRIBUTARIO", $strNumRegistroTributario, 1);                
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strNumRegistroTributarioActividad = isset($_POST["txtC_NUM_REGISTRO_TRIBUTARIO_ACTIVIDAD"]) ? utils::getStringQuery($_POST["txtC_NUM_REGISTRO_TRIBUTARIO_ACTIVIDAD"]) : "";
            $intNumRegistroTributarioActividad = isset($_POST["hidC_NUM_REGISTRO_TRIBUTARIO_ACTIVIDAD"]) ? intval($_POST["hidC_NUM_REGISTRO_TRIBUTARIO_ACTIVIDAD"]) : 0;
            
            if( $intNumRegistroTributarioActividad )
                $this->objModel->setUpdateSolCreditoDato($intNumRegistroTributarioActividad, $strNumRegistroTributarioActividad);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, "C_NUM_REGISTRO_TRIBUTARIO_ACTIVIDAD", $strNumRegistroTributarioActividad, 1);                
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strDireccionComercial = isset($_POST["txtC_DIRECCION_COMERCIAL"]) ? utils::getStringQuery($_POST["txtC_DIRECCION_COMERCIAL"]) : "";
            $intDireccionComercial = isset($_POST["hidC_DIRECCION_COMERCIAL"]) ? intval($_POST["hidC_DIRECCION_COMERCIAL"]) : 0;
            
            if( $intDireccionComercial )
                $this->objModel->setUpdateSolCreditoDato($intDireccionComercial, $strDireccionComercial);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, "C_DIRECCION_COMERCIAL", $strDireccionComercial, 1);                
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strDireccionComercialDepartamento = isset($_POST["slcC_DIRECCION_COMERCIAL_DEPARTAMENTO"]) ? utils::getStringQuery($_POST["slcC_DIRECCION_COMERCIAL_DEPARTAMENTO"]) : "";
            $intDireccionComercialDepartamento = isset($_POST["hidC_DIRECCION_COMERCIAL_DEPARTAMENTO"]) ? intval($_POST["hidC_DIRECCION_COMERCIAL_DEPARTAMENTO"]) : 0;
            
            if( $intDireccionComercialDepartamento )
                $this->objModel->setUpdateSolCreditoDato($intDireccionComercialDepartamento, $strDireccionComercialDepartamento);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, "C_DIRECCION_COMERCIAL_DEPARTAMENTO", $strDireccionComercialDepartamento, 1);                
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strDireccionComercialCiudad = isset($_POST["slcC_DIRECCION_COMERCIAL_CIUDAD"]) ? utils::getStringQuery($_POST["slcC_DIRECCION_COMERCIAL_CIUDAD"]) : "";
            $intDireccionComercialCiudad = isset($_POST["hidC_DIRECCION_COMERCIAL_CIUDAD"]) ? intval($_POST["hidC_DIRECCION_COMERCIAL_CIUDAD"]) : 0;
            
            if( $intDireccionComercialCiudad )
                $this->objModel->setUpdateSolCreditoDato($intDireccionComercialCiudad, $strDireccionComercialCiudad);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, "C_DIRECCION_COMERCIAL_CIUDAD", $strDireccionComercialCiudad, 1);                
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strClaseContribuyente = isset($_POST["txtC_CLASE_CONTRIBUYENTE"]) ? utils::getStringQuery($_POST["txtC_CLASE_CONTRIBUYENTE"]) : "";
            $intClaseContribuyente = isset($_POST["hidC_CLASE_CONTRIBUYENTE"]) ? intval($_POST["hidC_CLASE_CONTRIBUYENTE"]) : 0;
            
            if( $intClaseContribuyente )
                $this->objModel->setUpdateSolCreditoDato($intClaseContribuyente, $strClaseContribuyente);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, "C_CLASE_CONTRIBUYENTE", $strClaseContribuyente, 1);                
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strLocal = isset($_POST["rdC_LOCAL"]) ? utils::getStringQuery($_POST["rdC_LOCAL"]) : "";
            $intLocal = isset($_POST["hidC_LOCAL"]) ? intval($_POST["hidC_LOCAL"]) : 0;
            
            if( $intLocal )
                $this->objModel->setUpdateSolCreditoDato($intLocal, $strLocal);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, "C_LOCAL", $strLocal, 1);                
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strNit = isset($_POST["txtC_NIT"]) ? utils::getStringQuery($_POST["txtC_NIT"]) : "";
            $intNit = isset($_POST["hidC_NIT"]) ? intval($_POST["hidC_NIT"]) : 0;
            
            if( $intNit )
                $this->objModel->setUpdateSolCreditoDato($intNit, $strNit);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, "C_NIT", $strNit, 1);                
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strTelefonoCelular = isset($_POST["txtC_TELEFONO_CELULAR"]) ? utils::getStringQuery($_POST["txtC_TELEFONO_CELULAR"]) : "";
            $intTelefonoCelular = isset($_POST["hidC_TELEFONO_CELULAR"]) ? intval($_POST["hidC_TELEFONO_CELULAR"]) : 0;
            
            if( $intTelefonoCelular )
                $this->objModel->setUpdateSolCreditoDato($intTelefonoCelular, $strTelefonoCelular);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, "C_TELEFONO_CELULAR", $strTelefonoCelular, 1);                
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strEmail = isset($_POST["txtC_EMAIL"]) ? utils::getStringQuery($_POST["txtC_EMAIL"]) : "";
            $intEmail = isset($_POST["hidC_EMAIL"]) ? intval($_POST["hidC_EMAIL"]) : 0;
            
            if( $intEmail )
                $this->objModel->setUpdateSolCreditoDato($intEmail, $strEmail);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, "C_EMAIL", $strEmail, 1);                
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            
            
                                    
            $this->objModel->setUpdateClienteCreditoEstado($intCliente, "FI1");                
            
            $arr["error"] = false;    
            $arr["msg"] = "Datos Bloque 1 Guardados Correctamente";
            
            print json_encode($arr);    
            die();
            
        }
        
        if( isset($_GET["drawFormCredito2"]) ){
            
            $intCliente = isset($_GET["cliente"]) ? intval($_GET["cliente"]) : 0;
            $arrSolCredito = $this->objModel->getCliente($_SESSION['leterago']['id'], $intCliente);
            
            $arrSolCreditoDato = $this->objModel->getClienteDato($intCliente);    
            $this->objView->drawFormCredito2($intCliente, ( isset($arrSolCredito[$intCliente]) ? $arrSolCredito[$intCliente] : array() ), $arrSolCreditoDato);
            
            die();
        }
        
        if( isset($_GET["setFormCredito2"]) ){
            
            $intCliente = isset($_POST["hidCliente"]) ? intval($_POST["hidCliente"]) : 0;
            
            $strNombrePropietario = isset($_POST["txtC_NOMBRE_PROPIETARIO"]) ? utils::getStringQuery($_POST["txtC_NOMBRE_PROPIETARIO"]) : "";
            $intNombrePropietario = isset($_POST["hidC_NOMBRE_PROPIETARIO"]) ? intval($_POST["hidC_NOMBRE_PROPIETARIO"]) : 0;
            
            if( $intNombrePropietario )
                $this->objModel->setUpdateSolCreditoDato($intNombrePropietario, $strNombrePropietario);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, "C_NOMBRE_PROPIETARIO", $strNombrePropietario, 1);                
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strNombrePropietarioNacionalidad = isset($_POST["txtC_NOMBRE_PROPIETARIO_NACIONALIDAD"]) ? utils::getStringQuery($_POST["txtC_NOMBRE_PROPIETARIO_NACIONALIDAD"]) : "";
            $intNombrePropietarioNacionalidad = isset($_POST["hidC_NOMBRE_PROPIETARIO_NACIONALIDAD"]) ? intval($_POST["hidC_NOMBRE_PROPIETARIO_NACIONALIDAD"]) : 0;
            
            if( $intNombrePropietarioNacionalidad )
                $this->objModel->setUpdateSolCreditoDato($intNombrePropietarioNacionalidad, $strNombrePropietarioNacionalidad);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, "C_NOMBRE_PROPIETARIO_NACIONALIDAD", $strNombrePropietarioNacionalidad, 1);                
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////                   
            
            $strNumeroCedula = isset($_POST["txtC_NUMERO_CEDULA"]) ? utils::getStringQuery($_POST["txtC_NUMERO_CEDULA"]) : "";
            $intNumeroCedula = isset($_POST["hidC_NUMERO_CEDULA"]) ? intval($_POST["hidC_NUMERO_CEDULA"]) : 0;
            
            if( $intNumeroCedula )
                $this->objModel->setUpdateSolCreditoDato($intNumeroCedula, $strNumeroCedula);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, "C_NUMERO_CEDULA", $strNumeroCedula, 1);                
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////                   
            
            $strEmail = isset($_POST["txtC_PEMAIL"]) ? utils::getStringQuery($_POST["txtC_PEMAIL"]) : "";
            $intEmail = isset($_POST["hidC_PEMAIL"]) ? intval($_POST["hidC_PEMAIL"]) : 0;
            
            if( $intEmail )
                $this->objModel->setUpdateSolCreditoDato($intEmail, $strEmail);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, "C_PEMAIL", $strEmail, 1);                
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////                   
            
            $strPDepartamento = isset($_POST["slcC_PDEPARTAMENTO"]) ? utils::getStringQuery($_POST["slcC_PDEPARTAMENTO"]) : "";
            $intPDepartamento = isset($_POST["hidC_PDEPARTAMENTO"]) ? intval($_POST["hidC_PDEPARTAMENTO"]) : 0;
            
            if( $intPDepartamento )
                $this->objModel->setUpdateSolCreditoDato($intPDepartamento, $strPDepartamento);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, "C_PDEPARTAMENTO", $strPDepartamento, 1);                
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////                   
            
            $strPCiudad = isset($_POST["slcC_PCIUDAD"]) ? utils::getStringQuery($_POST["slcC_PCIUDAD"]) : "";
            $intPCiudad = isset($_POST["hidC_PCIUDAD"]) ? intval($_POST["hidC_PCIUDAD"]) : 0;
            
            if( $intPCiudad )
                $this->objModel->setUpdateSolCreditoDato($intPCiudad, $strPCiudad);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, "C_PCIUDAD", $strPCiudad, 1);                
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////                   
            
            $strPDireccionDomicilio = isset($_POST["txtC_PDIRECCION_DOMICILIO"]) ? utils::getStringQuery($_POST["txtC_PDIRECCION_DOMICILIO"]) : "";
            $intPDireccionDomicilio = isset($_POST["hidC_PDIRECCION_DOMICILIO"]) ? intval($_POST["hidC_PDIRECCION_DOMICILIO"]) : 0;
            
            if( $intPDireccionDomicilio )
                $this->objModel->setUpdateSolCreditoDato($intPDireccionDomicilio, $strPDireccionDomicilio);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, "C_PDIRECCION_DOMICILIO", $strPDireccionDomicilio, 1);                
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////                   
            
            $strPCelular = isset($_POST["txtC_PCELULAR"]) ? utils::getStringQuery($_POST["txtC_PCELULAR"]) : "";
            $intPCelular = isset($_POST["hidC_PCELULAR"]) ? intval($_POST["hidC_PCELULAR"]) : 0;
            
            if( $intPCelular )
                $this->objModel->setUpdateSolCreditoDato($intPCelular, $strPCelular);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, "C_PCELULAR", $strPCelular, 1);                
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////                   
            
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////                   
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////                   
            
            $strRLNombrePropietario = isset($_POST["txtC_RLNOMBRE_PROPIETARIO"]) ? utils::getStringQuery($_POST["txtC_RLNOMBRE_PROPIETARIO"]) : "";
            $intRLNombrePropietario = isset($_POST["hidC_RLNOMBRE_PROPIETARIO"]) ? intval($_POST["hidC_RLNOMBRE_PROPIETARIO"]) : 0;
            
            if( $intRLNombrePropietario )
                $this->objModel->setUpdateSolCreditoDato($intRLNombrePropietario, $strRLNombrePropietario);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, "C_RLNOMBRE_PROPIETARIO", $strRLNombrePropietario, 1);                
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////                   
            
            $strRLNombrePropietarioNacionalidad = isset($_POST["txtC_RLNOMBRE_PROPIETARIO_NACIONALIDAD"]) ? utils::getStringQuery($_POST["txtC_RLNOMBRE_PROPIETARIO_NACIONALIDAD"]) : "";
            $intRLNombrePropietarioNacionalidad = isset($_POST["hidC_RLNOMBRE_PROPIETARIO_NACIONALIDAD"]) ? intval($_POST["hidC_RLNOMBRE_PROPIETARIO_NACIONALIDAD"]) : 0;
            
            if( $intRLNombrePropietarioNacionalidad )
                $this->objModel->setUpdateSolCreditoDato($intRLNombrePropietarioNacionalidad, $strRLNombrePropietarioNacionalidad);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, "C_RLNOMBRE_PROPIETARIO_NACIONALIDAD", $strRLNombrePropietarioNacionalidad, 1);                
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////                   
            
            $strRLNumeroCedula = isset($_POST["txtC_RLNUMERO_CEDULA"]) ? utils::getStringQuery($_POST["txtC_RLNUMERO_CEDULA"]) : "";
            $intRLNumeroCedula = isset($_POST["hidC_RLNUMERO_CEDULA"]) ? intval($_POST["hidC_RLNUMERO_CEDULA"]) : 0;
            
            if( $intRLNumeroCedula )
                $this->objModel->setUpdateSolCreditoDato($intRLNumeroCedula, $strRLNumeroCedula);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, "C_RLNUMERO_CEDULA", $strRLNumeroCedula, 1);                
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////                   
            
            $strRLEmail = isset($_POST["txtC_RLPEMAIL"]) ? utils::getStringQuery($_POST["txtC_RLPEMAIL"]) : "";
            $intRLEmail = isset($_POST["hidC_RLPEMAIL"]) ? intval($_POST["hidC_RLPEMAIL"]) : 0;
            
            if( $intRLEmail )
                $this->objModel->setUpdateSolCreditoDato($intRLEmail, $strRLEmail);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, "C_RLPEMAIL", $strRLEmail, 1);                
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////                   
            
            $strRLDepartamento = isset($_POST["slcC_RLPDEPARTAMENTO"]) ? utils::getStringQuery($_POST["slcC_RLPDEPARTAMENTO"]) : "";
            $intRLDepartamento = isset($_POST["hidC_RLPDEPARTAMENTO"]) ? intval($_POST["hidC_RLPDEPARTAMENTO"]) : 0;
            
            if( $intRLDepartamento )
                $this->objModel->setUpdateSolCreditoDato($intRLDepartamento, $strRLDepartamento);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, "C_RLPDEPARTAMENTO", $strRLDepartamento, 1);                
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////                   
            
            $strRLCiudad = isset($_POST["slcC_RLPCIUDAD"]) ? utils::getStringQuery($_POST["slcC_RLPCIUDAD"]) : "";
            $intRLCiudad = isset($_POST["hidC_RLPCIUDAD"]) ? intval($_POST["hidC_RLPCIUDAD"]) : 0;
            
            if( $intRLCiudad )
                $this->objModel->setUpdateSolCreditoDato($intRLCiudad, $strRLCiudad);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, "C_RLPCIUDAD", $strRLCiudad, 1);                
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////                   
            
            $strRLDireccionDomicilio = isset($_POST["txtC_RLPDIRECCION_DOMICILIO"]) ? utils::getStringQuery($_POST["txtC_RLPDIRECCION_DOMICILIO"]) : "";
            $intRLDireccionDomicilio = isset($_POST["hidC_RLPDIRECCION_DOMICILIO"]) ? intval($_POST["hidC_RLPDIRECCION_DOMICILIO"]) : 0;
            
            if( $intRLDireccionDomicilio )
                $this->objModel->setUpdateSolCreditoDato($intRLDireccionDomicilio, $strRLDireccionDomicilio);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, "C_RLPDIRECCION_DOMICILIO", $strRLDireccionDomicilio, 1);                
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////                   
            
            $strRLPCelular = isset($_POST["txtC_RLPCELULAR"]) ? utils::getStringQuery($_POST["txtC_RLPCELULAR"]) : "";
            $intRLPCelular = isset($_POST["hidC_RLPCELULAR"]) ? intval($_POST["hidC_RLPCELULAR"]) : 0;
            
            if( $intRLPCelular )
                $this->objModel->setUpdateSolCreditoDato($intRLPCelular, $strRLPCelular);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, "C_RLPCELULAR", $strRLPCelular, 1);                
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////                   
            
            
            
            
                                    
            $this->objModel->setUpdateClienteCreditoEstado($intCliente, "FI1");                
            
            $arr["error"] = false;    
            $arr["msg"] = "Datos Bloque 1 Guardados Correctamente";
            
            print json_encode($arr);    
            die();
            
        }
        
        if( isset($_GET["drawFormCredito3"]) ){
            
            $intCliente = isset($_GET["cliente"]) ? intval($_GET["cliente"]) : 0;
            $arrSolCredito = $this->objModel->getCliente($_SESSION['leterago']['id'], $intCliente);
            
            $arrSolCreditoDato = $this->objModel->getClienteDato($intCliente);    
            $this->objView->drawFormCredito3($intCliente, ( isset($arrSolCredito[$intCliente]) ? $arrSolCredito[$intCliente] : array() ), $arrSolCreditoDato);
            
            die();
        }
        
        if( isset($_GET["setFormCredito3"]) ){
            
            $intCliente = isset($_POST["hidCliente"]) ? intval($_POST["hidCliente"]) : 0;
            
            $strEncargadoPagos = isset($_POST["txtC_ENCARGADO_PAGOS"]) ? utils::getStringQuery($_POST["txtC_ENCARGADO_PAGOS"]) : "";
            $intEncargadoPagos = isset($_POST["hidC_ENCARGADO_PAGOS"]) ? intval($_POST["hidC_ENCARGADO_PAGOS"]) : 0;
            
            if( $intEncargadoPagos )
                $this->objModel->setUpdateSolCreditoDato($intEncargadoPagos, $strEncargadoPagos);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, "C_ENCARGADO_PAGOS", $strEncargadoPagos, 3);
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strEncargadoPagosEmail = isset($_POST["txtC_ENCARGADO_PAGOS_EMAIL"]) ? utils::getStringQuery($_POST["txtC_ENCARGADO_PAGOS_EMAIL"]) : "";
            $intEncargadoPagosEmail = isset($_POST["txtC_ENCARGADO_PAGOS_EMAIL"]) ? intval($_POST["txtC_ENCARGADO_PAGOS_EMAIL"]) : 0;
            
            if( $intEncargadoPagosEmail )
                $this->objModel->setUpdateSolCreditoDato($intEncargadoPagosEmail, $strEncargadoPagosEmail);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, "C_ENCARGADO_PAGOS_EMAIL", $strEncargadoPagosEmail, 3);
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strEncargadoCompras = isset($_POST["txtC_ENCARGADO_COMPRAS"]) ? utils::getStringQuery($_POST["txtC_ENCARGADO_COMPRAS"]) : "";
            $intEncargadoCompras = isset($_POST["hidC_ENCARGADO_COMPRAS"]) ? intval($_POST["hidC_ENCARGADO_COMPRAS"]) : 0;
            
            if( $intEncargadoCompras )
                $this->objModel->setUpdateSolCreditoDato($intEncargadoCompras, $strEncargadoCompras);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, "C_ENCARGADO_COMPRAS", $strEncargadoCompras, 3);
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strEncargadoComprasEmail = isset($_POST["txtC_ENCARGADO_COMPRAS_EMAIL"]) ? utils::getStringQuery($_POST["txtC_ENCARGADO_COMPRAS_EMAIL"]) : "";
            $intEncargadoComprasEmail = isset($_POST["hidC_ENCARGADO_COMPRAS_EMAIL"]) ? intval($_POST["hidC_ENCARGADO_COMPRAS_EMAIL"]) : 0;
            
            if( $intEncargadoComprasEmail )
                $this->objModel->setUpdateSolCreditoDato($intEncargadoComprasEmail, $strEncargadoComprasEmail);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, "C_ENCARGADO_COMPRAS_EMAIL", $strEncargadoComprasEmail, 3);
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strFormaPago = isset($_POST["rdC_FORMA_PAGO"]) ? utils::getStringQuery($_POST["rdC_FORMA_PAGO"]) : "";
            $intFormaPago = isset($_POST["hidC_FORMA_PAGO"]) ? intval($_POST["hidC_FORMA_PAGO"]) : 0;
            
            if( $intFormaPago )
                $this->objModel->setUpdateSolCreditoDato($intFormaPago, $strFormaPago);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, "C_FORMA_PAGO", $strFormaPago, 3);
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strMontoSolicitado = isset($_POST["txtC_MONTO_SOLICITADO"]) ? utils::getStringQuery($_POST["txtC_MONTO_SOLICITADO"]) : "";
            $intMontoSolicitado = isset($_POST["hidC_MONTO_SOLICITADO"]) ? intval($_POST["hidC_MONTO_SOLICITADO"]) : 0;
            
            if( $intMontoSolicitado )
                $this->objModel->setUpdateSolCreditoDato($intMontoSolicitado, $strMontoSolicitado);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, "C_MONTO_SOLICITADO", $strMontoSolicitado, 3);
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strMontoLimite = isset($_POST["txtC_MONTO_LIMITE_APROBADO"]) ? utils::getStringQuery($_POST["txtC_MONTO_LIMITE_APROBADO"]) : "";
            $intMontoLimite = isset($_POST["hidC_MONTO_LIMITE_APROBADO"]) ? intval($_POST["hidC_MONTO_LIMITE_APROBADO"]) : 0;
            
            if( $intMontoLimite )
                $this->objModel->setUpdateSolCreditoDato($intMontoLimite, $strMontoLimite);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, "C_MONTO_LIMITE_APROBADO", $strMontoLimite, 3);
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
            
            
            
                                    
            $this->objModel->setUpdateClienteCreditoEstado($intCliente, "FI1");                
            
            $arr["error"] = false;    
            $arr["msg"] = "Datos Bloque 1 Guardados Correctamente";
            
            print json_encode($arr);    
            die();
            
        }
    
        if( isset($_GET["drawFormCredito4"]) ){
            
            $intCliente = isset($_GET["cliente"]) ? intval($_GET["cliente"]) : 0;
            $arrSolCredito = $this->objModel->getCliente($_SESSION['leterago']['id'], $intCliente);
            
            $arrSolCreditoDato = $this->objModel->getClienteDato($intCliente);    
            $this->objView->drawFormCredito4($intCliente, ( isset($arrSolCredito[$intCliente]) ? $arrSolCredito[$intCliente] : array() ), $arrSolCreditoDato);
            
            die();
        }
        
        if( isset($_GET["setFormCredito4"]) ){
            
            $intCliente = isset($_POST["hidCliente"]) ? intval($_POST["hidCliente"]) : 0;
            
            
            for( $i = 1; $i <= 3; $i++ ){
                
                $strEncargadoPagos = isset($_POST["txtC_REFERENCIA_NOMBRE_EMPRESA_{$i}"]) ? utils::getStringQuery($_POST["txtC_REFERENCIA_NOMBRE_EMPRESA_{$i}"]) : "";
                $intEncargadoPagos = isset($_POST["hidC_REFERENCIA_NOMBRE_EMPRESA_{$i}"]) ? intval($_POST["hidC_REFERENCIA_NOMBRE_EMPRESA_{$i}"]) : 0;
                
                if( $intEncargadoPagos )
                    $this->objModel->setUpdateSolCreditoDato($intEncargadoPagos, $strEncargadoPagos);                
                else
                    $this->objModel->setInsertSolCreditoDato($intCliente, "C_REFERENCIA_NOMBRE_EMPRESA_{$i}", $strEncargadoPagos, 3);
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                
                $strEncargadoPagos = isset($_POST["txtC_REFERENCIA_DESDE_COMPRA_EMPRESA_{$i}"]) ? utils::getStringQuery($_POST["txtC_REFERENCIA_DESDE_COMPRA_EMPRESA_{$i}"]) : "";
                $intEncargadoPagos = isset($_POST["hidC_REFERENCIA_DESDE_COMPRA_EMPRESA_{$i}"]) ? intval($_POST["hidC_REFERENCIA_DESDE_COMPRA_EMPRESA_{$i}"]) : 0;
                
                if( $intEncargadoPagos )
                    $this->objModel->setUpdateSolCreditoDato($intEncargadoPagos, $strEncargadoPagos);                
                else
                    $this->objModel->setInsertSolCreditoDato($intCliente, "C_REFERENCIA_DESDE_COMPRA_EMPRESA_{$i}", $strEncargadoPagos, 3);
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                
                
                $strEncargadoPagos = isset($_POST["txtC_REFERENCIA_TELEFONO_EMPRESA_{$i}"]) ? utils::getStringQuery($_POST["txtC_REFERENCIA_TELEFONO_EMPRESA_{$i}"]) : "";
                $intEncargadoPagos = isset($_POST["hidC_REFERENCIA_TELEFONO_EMPRESA_{$i}"]) ? intval($_POST["hidC_REFERENCIA_TELEFONO_EMPRESA_{$i}"]) : 0;
                
                if( $intEncargadoPagos )
                    $this->objModel->setUpdateSolCreditoDato($intEncargadoPagos, $strEncargadoPagos);                
                else
                    $this->objModel->setInsertSolCreditoDato($intCliente, "C_REFERENCIA_TELEFONO_EMPRESA_{$i}", $strEncargadoPagos, 3);
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                
                $strEncargadoPagos = isset($_POST["txtC_REFERENCIA_LIMITE_CREDITO_EMPRESA_{$i}"]) ? utils::getStringQuery($_POST["txtC_REFERENCIA_LIMITE_CREDITO_EMPRESA_{$i}"]) : "";
                $intEncargadoPagos = isset($_POST["hidC_REFERENCIA_LIMITE_CREDITO_EMPRESA_{$i}"]) ? intval($_POST["hidC_REFERENCIA_LIMITE_CREDITO_EMPRESA_{$i}"]) : 0;
                
                if( $intEncargadoPagos )
                    $this->objModel->setUpdateSolCreditoDato($intEncargadoPagos, $strEncargadoPagos);                
                else
                    $this->objModel->setInsertSolCreditoDato($intCliente, "C_REFERENCIA_LIMITE_CREDITO_EMPRESA_{$i}", $strEncargadoPagos, 3);
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                
                $strEncargadoPagos = isset($_POST["txtC_REFERENCIA_CUANTO_COMPRA_EMPRESA_{$i}"]) ? utils::getStringQuery($_POST["txtC_REFERENCIA_CUANTO_COMPRA_EMPRESA_{$i}"]) : "";
                $intEncargadoPagos = isset($_POST["hidC_REFERENCIA_CUANTO_COMPRA_EMPRESA_{$i}"]) ? intval($_POST["hidC_REFERENCIA_CUANTO_COMPRA_EMPRESA_{$i}"]) : 0;
                
                if( $intEncargadoPagos )
                    $this->objModel->setUpdateSolCreditoDato($intEncargadoPagos, $strEncargadoPagos);                
                else
                    $this->objModel->setInsertSolCreditoDato($intCliente, "C_REFERENCIA_CUANTO_COMPRA_EMPRESA_{$i}", $strEncargadoPagos, 3);
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                
                
            }
            
            $strValor = isset($_POST["txtC_BANCO_NOMBRE"]) ? utils::getStringQuery($_POST["txtC_BANCO_NOMBRE"]) : "";
            $intKey = isset($_POST["hidC_BANCO_NOMBRE"]) ? intval($_POST["hidC_BANCO_NOMBRE"]) : 0;
            
            if( $intKey )
                $this->objModel->setUpdateSolCreditoDato($intKey, $strValor);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, "C_BANCO_NOMBRE", $strValor, 3);
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strLlave = "C_BANCO_TIPO_CUENTA";
            $strValor = isset($_POST["txt{$strLlave}"]) ? utils::getStringQuery($_POST["txt{$strLlave}"]) : "";
            $intKey = isset($_POST["hid{$strLlave}"]) ? intval($_POST["hid{$strLlave}"]) : 0;
            
            if( $intKey )
                $this->objModel->setUpdateSolCreditoDato($intKey, $strValor);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, $strLlave, $strValor, 3);
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strLlave = "C_BANCO_NUMERO_CUENTA";
            $strValor = isset($_POST["txt{$strLlave}"]) ? utils::getStringQuery($_POST["txt{$strLlave}"]) : "";
            $intKey = isset($_POST["hid{$strLlave}"]) ? intval($_POST["hid{$strLlave}"]) : 0;
            
            if( $intKey )
                $this->objModel->setUpdateSolCreditoDato($intKey, $strValor);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, $strLlave, $strValor, 3);
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strLlave = "C_BANCO_ENCARGADO_CUENTA";
            $strValor = isset($_POST["txt{$strLlave}"]) ? utils::getStringQuery($_POST["txt{$strLlave}"]) : "";
            $intKey = isset($_POST["hid{$strLlave}"]) ? intval($_POST["hid{$strLlave}"]) : 0;
            
            if( $intKey )
                $this->objModel->setUpdateSolCreditoDato($intKey, $strValor);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, $strLlave, $strValor, 3);
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            $strLlave = "C_BANCO_TELEFONO_BANCO";
            $strValor = isset($_POST["txt{$strLlave}"]) ? utils::getStringQuery($_POST["txt{$strLlave}"]) : "";
            $intKey = isset($_POST["hid{$strLlave}"]) ? intval($_POST["hid{$strLlave}"]) : 0;
            
            if( $intKey )
                $this->objModel->setUpdateSolCreditoDato($intKey, $strValor);                
            else
                $this->objModel->setInsertSolCreditoDato($intCliente, $strLlave, $strValor, 3);
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                 
            
            $this->objModel->setUpdateClienteCreditoEstado($intCliente, "FI4");                
            
            $arr["error"] = false;    
            $arr["msg"] = "Datos Bloque 1 Guardados Correctamente";
            
            print json_encode($arr);    
            die();
            
        }
        
        if( isset($_GET["drawFormCredito5"]) ){
            
            $intCliente = isset($_GET["cliente"]) ? intval($_GET["cliente"]) : 0;
            $arrSolCredito = $this->objModel->getCliente($_SESSION['leterago']['id'], $intCliente);
            
            $arrSolCreditoDato = $this->objModel->getClienteDato($intCliente);    
            $this->objView->drawFormCredito5($intCliente, ( isset($arrSolCredito[$intCliente]) ? $arrSolCredito[$intCliente] : array() ), $arrSolCreditoDato);
            
            die();
        }
        
        if( isset($_GET["setFormCredito5"]) ){
            
            $intCliente = isset($_POST["hidCliente"]) ? intval($_POST["hidCliente"]) : 0;
            
            $arrSolCredito = $this->objModel->getSolCreditoClienteKey($intCliente);
                
            $arrSolCredito = $arrSolCredito[$intCliente];
                
            
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
                                    '.$intCliente.'
                                </td>
                            </tr>
                            
                            <tr>
                                <td nowrap colspan="2" style="text-align: center; font-weight: bold; ">
                                    Navega a <a href="http://leterago.com/" target="_blank">leterago.com</a> para ver los datos ingresados en el Formulario de Credito
                                </td>
                            </tr>
                            
                        </table>';
                        
            utils::sendEmail("idroys4@gmail.com", "Credito de Cliente #".$intCliente.", Datos Enviados", $strBody, false);
            
            $this->objModel->setUpdateClienteCreditoEstado($intCliente, "FPA");                                    
            
            $arr["error"] = false;
            $arr["msg"] = "Formulario enviado correctamente, pronto tendras respuesta via email ( {$arrSolCredito["email"]} )";
            
            print json_encode($arr);    
            die();
            
        }
        
        if( isset($_GET["setCodigoSacAx365"]) ){
        
            $intCliente = isset($_GET["cliente"]) ? intval($_GET["cliente"]) : 0;
            
            $this->objView->setCodigoSacAx365($intCliente);
            
            die();
        }
        
        if( isset($_GET["setCodigo365ClienteForm"]) ){
        
            $intCliente = isset($_POST["cliente"]) ? intval($_POST["cliente"]) : 0;
            $strCodigio = isset($_POST["codigo365"]) ? trim($_POST["codigo365"]) : 0;
            
            $this->objModel->setCodigo365($intCliente, $strCodigio);
            
            $arr["intCliente"] = $intCliente;
            $arr["strCodigio"] = $strCodigio;
            $arr["error"] = false;
            
            print json_encode($arr);
            
            die();
        }
        
    }
              
}

?>
