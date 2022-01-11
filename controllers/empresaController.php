<?php

require_once 'models/catDepartamento.php';
require_once 'models/catMunicipio.php';
require_once 'models/catEstadoAI.php';
require_once 'models/empresa.php';
require_once 'models/empresa_sucursal.php';
require_once 'views/cliente/ajax-views.php';

class empresaController {

    public function getAjax() {
        if (isset($_GET['getMunicipio'])) {
            $cod_iso_departamento = isset($_GET['opt_departamento']) ? intval($_GET['opt_departamento']) : 0;

            $municipio = new catMunicipio();
            $municipio->setCod_iso_departamento($cod_iso_departamento);
            $lista_municipios = $municipio->getAllByIdDepartamento();

            $obj_view = new ajaxViews();
            $obj_view->drawMunicipio($lista_municipios);

            die();
        }
    }

    public function index() {
        utils::isIdentity();
        if (utils::whatRol() != 1) {
            header("Location:" . base_url . "home/index");
        }

        // listamos los departamentos
        $departamento = new catDepartamento();
        $lista_departamentos = $departamento->getAll();
        // listamos las empresas
        $empresa = new empresa();
        $lista_empresas = $empresa->getAll();
        // listamos los estados, recordemos que hay que enviarle el id del modulo
        $estado = new catEstadoAI();
        $lista_estados = $estado->getAll();
        //lista sucursales
        $sucursal = new empresa();
        $lista_sucursales = $sucursal->getSucursales();
        require_once 'views/empresa/crud-empresa.php';
    }

    public function edit() {
        utils::isIdentity();
        if (utils::whatRol() != 1) {
            header("Location:" . base_url . "home/index");
        }

        // Validamos si existe el GET
        if ($_GET) {
            // Almacena variable de id de la empresa
            $id_empresa = isset($_GET['id']) ? intval($_GET['id']) : 0;

            // Instanciamos el modelo de la empresa para consultar una unica empresa
            $empresa = new empresa();
            $empresa->setId($id_empresa);
            $_empresa = $empresa->getEmpresaById();
            $_empresa = $_empresa->fetch_object();
            // Realizamos tambien una consulta a todos las empresas para mostrarlos en lista
            $lista_empresas = $empresa->getAll();
            // Realizamos tambien una consulta a los departamentos para mostrarlos en el listado
            $departamento = new catDepartamento();
            $lista_departamentos = $departamento->getAll();
            // Realizamos tambien una consulta a los municipios para mostrarlos en el listado
            $municipio = new catMunicipio();
            $lista_municipios = $municipio->getAll();
            // Dividimos el numero de telefono del contacto que recuperamos
            $telefono_contacto = $_empresa->telefonoContacto;
            $telefono_contacto = explode(" ", $telefono_contacto);
            // listamos los estados, recordemos que hay que enviarle el id del modulo
            $estado = new catEstadoAI();
            $lista_estados = $estado->getAll();
            //lista sucursales
            $sucursal = new empresa();
            $lista_sucursales = $sucursal->getSucursales();

            require_once 'views/empresa/crud-empresa.php';
        } else {
            $_SESSION['noti_tipo'] = 'danger';
            $_SESSION['noti_mensaje'] = 'Problemas al capturar el ID por GET';
            header('Location:' . base_url . 'empresa/index');
        }
    }

    public function save() {
        // Validacion si existe POST
        if ($_POST) {

            // Variable para notificacion
            $result = false;

            // Si es update seteamos la variable get
            $id_empresa = isset($_GET['id']) ? intval($_GET['id']) : 0;
            // Seteo de los datos del post
            $nombre_empresa = isset($_POST['txt_nombreEmpresa']) ? trim($_POST['txt_nombreEmpresa']) : null;
            $nit_empresa = isset($_POST['txt_nit']) ? trim($_POST['txt_nit']) : null;
            $id_departamento = isset($_POST['opt_departamento']) ? intval($_POST['opt_departamento']) : 0;
            $id_municipio = isset($_POST['opt_municipio']) ? intval($_POST['opt_municipio']) : 0;
            $zona = isset($_POST['txt_zona']) ? intval($_POST['txt_zona']) : 0;
            $direccion = isset($_POST['txt_direccion']) ? trim($_POST['txt_direccion']) : null;
            $telefono_1 = isset($_POST['txt_telefono1']) ? trim($_POST['txt_telefono1']) : null;
            $telefono_2 = isset($_POST['txt_telefono2']) ? trim($_POST['txt_telefono2']) : null;
            $telefono_3 = isset($_POST['txt_telefono3']) ? trim($_POST['txt_telefono3']) : null;
            $nombre_contacto = isset($_POST['txt_nombreContacto']) ? trim($_POST['txt_nombreContacto']) : null;
            $correo_contacto = isset($_POST['txt_correoContacto']) ? trim($_POST['txt_correoContacto']) : null;
            $inventario = isset($_POST['cbx_inventario']) ? intval(1) : 0;
            $mensajeria = isset($_POST['cbx_mensajeria']) ? intval(1) : 0;
            $rutas = isset($_POST['cbx_rutas']) ? intval(1) : 0;
            $administracion = isset($_POST['cbx_administracion']) ? intval(1) : 0;
            $sucursales = isset($_POST['opt_sucursal']) ? $_POST['opt_sucursal'] : array();
            $id_estado = isset($_POST['opt_estado']) ? intval($_POST['opt_estado']) : 0;
            // Validacion de categoria no nula (se evalua primero el error).
            if ($nombre_contacto == null || $nombre_empresa == null || $direccion == null || $telefono_2 == null || $id_departamento == 0 || $id_municipio == 0 || $zona == 0) {

                // De encontrarse el campo nulo se envia la notificacion de valores nulos
                $_SESSION['noti_tipo'] = 'danger';
                $_SESSION['noti_mensaje'] = 'No has enviado algun valor requerido';
                header('Location:' . base_url . 'empresa/index');
            } else {

                // Instanseamos el objeto de empresa 
                $empresa = new empresa();
                $empresa->setNombreEmpresa($nombre_empresa);
                $existe = $empresa->getEquals();

                // Validacion de empresa existente
                if ($existe >= 1 && $id_empresa == 0) {

                    $_SESSION['noti_tipo'] = 'warning';
                    $_SESSION['noti_mensaje'] = 'Empresa ya existe';
                    header('Location:' . base_url . 'empresa/index');

                    die();
                } else {

                    // Llenamos la variable identity con la informacion del inicio de sesion
                    //                $identity = $_SESSION['identity-imsalesys'];
                    // Se arma el string del telefono;
                    $telefono_contacto = $telefono_2 . ' ' . $telefono_3;

                    $empresa->setNombreEmpresa($nombre_empresa);
                    $empresa->setNit($nit_empresa);
                    $empresa->setIdDepartamento($id_departamento);
                    $empresa->setIdMunicipio($id_municipio);
                    $empresa->setDireccion($direccion);
                    $empresa->setZona($zona);
                    $empresa->setTelefono($telefono_1);
                    $empresa->setNombreContacto($nombre_contacto);
                    $empresa->setCorreoContacto($correo_contacto);
                    $empresa->setTelefonoContacto($telefono_contacto);
                    $empresa->setInventario($inventario);
                    $empresa->setMensajeria($mensajeria);
                    $empresa->setRutas($rutas);
                    $empresa->setAdministracion($administracion);

                    // si el id de la empresa es mayor a cero entonces se procede al update
                    if ($id_empresa > 0) {
                        $empresa->setId($id_empresa);
                        $empresa->setEstado($id_estado);
                        $result = $empresa->update();
                    } else {
                        $id_empresa = $empresa->save();
                    }
                    //saveSucursales
                    $sucursalEmpresa = new empresaSucursal();
                    $sucursalEmpresa->setIdEmpresa($id_empresa);
                    $sucursalEmpresa->clearAccess();
                    while ($rTMP = each($sucursales)) {
                        $sucursalEmpresa->setIdSucursal($rTMP["value"]);
                        $sucursalEmpresa->save();
                    }
                }

                // Valida si el resultado es correcto o no, para armar las notificaciones
                if ($id_empresa > 0) {

                    $_SESSION['noti_tipo'] = 'success';
                    $_SESSION['noti_mensaje'] = 'Registro almacenado correctamente';
                    header('Location:' . base_url . 'empresa/index');
                } else {

                    $_SESSION['noti_tipo'] = 'danger';
                    $_SESSION['noti_mensaje'] = 'Registro no se almaceno correctamente';
                    header('Location:' . base_url . 'empresa/index');
                }
            }
        } else {

            $_SESSION['noti_tipo'] = 'danger';
            $_SESSION['noti_mensaje'] = 'Problemas al enviar informacion por POST';
            header('Location:' . base_url . 'empresa/index');
        }
    }

}
