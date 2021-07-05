<?php

require_once 'views/envio/views-envio.php';
require_once 'models/cliente.php';
require_once 'models/empresa.php';
require_once 'models/orden.php';
require_once 'models/catDepartamento.php';
require_once 'models/catMensajeria.php';

class envioController {

    public function getAjax() {
        if (isset($_GET['ajaxGuardaEnvio'])) {
            if ($_POST) {

                $id_orden = isset($_POST['id_orden']) ? intval($_POST['id_orden']) : 0;
                $fecha_envio = isset($_POST['fecha_envio']) ? trim($_POST['fecha_envio']) : null;
                $id_mensajeria = isset($_POST['id_mensajeria']) ? intval($_POST['id_mensajeria']) : 0;
                $txt_costo = isset($_POST['txt_costo']) ? trim($_POST['txt_costo']) : 0;
                $txt_comprobante = isset($_POST['txt_comprobante']) ? trim($_POST['txt_comprobante']) : null;
                $numero_guia = "";

                # Se obtiene el id de la empresa
                $id_empresa = $_SESSION['identity-imsalesys']->idEmpresa;

                # Instanciamos la clase de orden
                $orden = new orden();
                $orden->setId($id_orden);

                # Si viene numero de guia externa asignar a la variable $numero_guia
                if ($txt_costo > 0) {
                    $orden->setEnvio($txt_costo);
                } 
                else {

                    # De lo contrario obtiene el numero de correlativo de guia
                    $no_guia = utils::nextGuia();

                    # Obtenemos el id de la empresa y del cliente segun el numero de orden
                    $info_guia = $orden->getInfoGuia();
                    $id_cliente = $info_guia->idCliente;

                    # Obtenemos el departamento de la empresa y del cliente
                    # Empresa
                    $empresa = new empresa();
                    $empresa->setId($id_empresa);
                    $info_empresa = $empresa->getDeptoMuni();
                    $municipio_empresa = $info_empresa->idMunicipio;
                    $departamento_empresa = $info_empresa->idDepartamento;

                    # Cliente
                    $cliente = new cliente();
                    $cliente->setId($id_cliente);
                    $info_cliente = $cliente->getDeptoMuni();
                    $municipio_cliente = $info_cliente->idMunicipio;
                    $departamento_cliente = $info_cliente->idDepartamento;

                    # Obtenemos el codigo de envio
                    # Empresa
                    $cat_departamento = new catDepartamento();
                    $cat_departamento->setCodIso($departamento_empresa);
                    $codigo_envio_empresa = $cat_departamento->getNameCodigoEnvio();
                    $codigo_envio_empresa = $codigo_envio_empresa->codigoEnvio;

                    # Cliente
                    $cat_departamento->setCodIso($departamento_cliente);
                    $codigo_envio_cliente = $cat_departamento->getNameCodigoEnvio();
                    $codigo_envio_cliente = $codigo_envio_cliente->codigoEnvio;

                    # Armamos el numero de guia
                    $encabezado = $codigo_envio_empresa . "-" . $codigo_envio_cliente;
                    $cuerpo = $municipio_empresa . $municipio_cliente;
                    $cuerpo .= str_pad($id_empresa, 3, "0", STR_PAD_LEFT);
                    $pie = str_pad($no_guia, 6, "0", STR_PAD_LEFT);
                    $numero_guia = $encabezado . $cuerpo . $pie;
                }

                # Asigna la orden pendiente de agendar
                $orden->setIdEmpresa($id_empresa);
                $orden->setIdMensajeria($id_mensajeria);
                $orden->setFechaEnvio($fecha_envio);
                $orden->setNumeroGuia($numero_guia);
                $orden->setComprobante($txt_comprobante);
                $result = $orden->setToAssign();

                if ($result) {
                    $siguiente = utils::plusGuia();
                }
                
                
                $boolIssetRutaOrden = $orden->getIssetRutaOrden();

                if( !$boolIssetRutaOrden ){
                    
                    $orden->setOrdenSinRuta();
                    
                } 
                
                
            } else {
                # error de post
            }

            die();
        }

        if (isset($_GET['getMensajeria'])) {
            if ($_GET) {
                $id_mensajeria = isset($_GET['opt_idMensajeria']) ? intval($_GET['opt_idMensajeria']) : 0;
                $id_empresa = $_SESSION['identity-imsalesys']->idEmpresa;

                $objView = new viewsEnvio();

                if (intval($id_empresa) && utils::hasRoutes($id_empresa)) {
                    if ($id_mensajeria == 1) {
                        $objView->drawInputGuia(1);
                    } else {
                        $objView->drawInputGuia(2);
                    }
                }else{
                    $objView->drawInputGuia(2);
                }
            } else {
                # error en get
            }

            die();
        }

        if (isset($_GET['getComprobante'])) {
            if ($_GET) {
                $id_orden = isset($_GET['id_orden']) ? intval($_GET['id_orden']) : 0;

                $orden = new orden();
                $orden->setId($id_orden);
                $var = $orden->validaComprobante();

                $objView = new viewsEnvio();

                if ($var == 1) {
                    $objView->drawInputComprobante(1);
                } else {
                    $objView->drawInputComprobante(0);
                }
            } else {
                # error en get
            }

            die();
        }
    }

    public function index() {
        utils::isIdentity();
        $id_rol = utils::whatRol();
        $id_empresa = $_SESSION['identity-imsalesys']->idEmpresa;

        if ($id_rol == 1 || $id_rol == 2 || $id_rol == 4) {

            $orden = new orden();
            $orden->setIdEmpresa($id_empresa);
            # Lista la informacion que esta disponible para asignar
            $lista_ordenes = $orden->getAllToAssign();
            # Lista la informacion que ya esta asignada o en ruta
            $arrlista_envios = $orden->getAllAssigned();
            $strJsonLista = json_encode($arrlista_envios);
//
//            var_dump($strJsonLista);
//            die();

            $mensajeria = new catMensajeria();
            $lista_mensajerias = $mensajeria->getAll();
            
            
            require_once 'views/envio/crud-envio.php';
        } else {
            header("Location:" . base_url . "home/index");
        }
    }

    public function rastreo() {
        utils::isIdentity();
        $id_rol = utils::whatRol();
        if ($id_rol == 1 || $id_rol == 2 || $id_rol == 3 || $id_rol == 4 || $id_rol == 5) {
            print "Observar como van los pedidos";
        } else {
            header("Location:" . base_url . "home/index");
        }
    }

}
