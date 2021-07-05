<?php

require_once 'models/usuario.php';
require_once 'models/empresa.php';
require_once 'views/usuario/view_empresa.php';
require_once 'models/usuario_perfil.php';
require_once 'models/perfil.php';
require_once 'views/usuario/crud-usuario.php';

class usuarioController {
    
    private $objView;
    
    function __construct (){
        
        $this->objView = new usuarioView();
        $this->objModel = new usuario();
        
    }

    public function getAjax() {
        
        if( isset($_GET["drawListUsuario"]) ){
            
            $arrUsuario = $this->objModel->getUsuario();
            
            $this->objView->drawListUsuario($arrUsuario);
            
            die();
        }
        
        if( isset($_GET["drawAdminModalUsuario"]) ){
            
            $intUsuario = isset($_GET["usuario"]) ? intval($_GET["usuario"]) : 0;
            
            $arrUsuario = $this->objModel->fntGetUsuario($intUsuario);
            $arrPais = $this->objModel->getPais();
            $arrUsuarioPais = $this->objModel->getUsuarioPais($intUsuario);
            $arrPerfil = $this->objModel->getPerfiles();
            $arrUsuarioPerfil = $this->objModel->getUsuarioPerfil($intUsuario);
            
            $this->objView->drawAdminModalUsuario($intUsuario, $arrUsuario, $arrPais, $arrUsuarioPais, $arrPerfil, $arrUsuarioPerfil);
            
            die();
        }
        
        if( isset($_GET["setEliminarUsuario"]) ){
            
            $intUsuario = isset($_GET["usuario"]) ? intval($_GET["usuario"]) : 0;
            
            $arrUsuario = $this->objModel->setEliminarUsuario($intUsuario);
            
            die();
        }
        
        if( isset($_GET["setUsuario"]) ){
            
            $intUsuario = isset($_POST["hidUsuario"]) ? intval($_POST["hidUsuario"]) : 0;
            $strNombre = isset($_POST["txtNombreUsuario"]) ? trim($_POST["txtNombreUsuario"]) : "";
            $strApellido = isset($_POST["txtApellido"]) ? trim($_POST["txtApellido"]) : "";
            $strEmail = isset($_POST["txtEmailUsuario"]) ? trim($_POST["txtEmailUsuario"]) : "";
            $strClave = isset($_POST["txtClaveUsuario"]) ? trim($_POST["txtClaveUsuario"]) : "";
            $strTipo = isset($_POST["slcTipo"]) ? trim($_POST["slcTipo"]) : "";
            $strEstado = isset($_POST["slcEstado"]) ? trim($_POST["slcEstado"]) : "";
            $strSexo = isset($_POST["slcSexo"]) ? trim($_POST["slcSexo"]) : "";
            
            if( $intUsuario ){
                
                $this->objModel->fntSetUpdateUsuario($intUsuario, $strNombre, $strApellido, $strSexo, $strEmail, $strClave, $strTipo, $strEstado);
                
                $arr["msg"] = "Usuario actualizado";
            }
            else{
                
                $intUsuario = $this->objModel->fntSetUsuario($strNombre, $strApellido, $strSexo, $strEmail, $strClave, $strTipo, $strEstado);
                $arr["msg"] = "Usuario creado";    
            }
            
            
            if( $intUsuario ){
                
                $this->objModel->deleteUsuarioPais($intUsuario);
                
                if( isset($_POST["slcPais"]) ){
                    
                    while( $rTMP = each($_POST["slcPais"]) ){
                        
                        $this->objModel->setUsuarioPais($intUsuario, $rTMP["value"]);
                        
                        
                    }
                    
                }
                
                $this->objModel->deleteUsuarioPerfil($intUsuario);
                
                if( isset($_POST["slcPerfil"]) ){
                    
                    while( $rTMP = each($_POST["slcPerfil"]) ){
                        
                        $this->objModel->setUsuarioPerfil($intUsuario, $rTMP["value"]);
                        
                        
                    }
                    
                }
                
            }
            
            $arr["error"] = false;
            
            
            print json_encode($arr);            
            
            die();
        }
        
    }

    public function validate() {

        if (isset($_POST)) {
            
            $strEmail = isset($_POST["txtEmail"]) ? trim($_POST["txtEmail"]) : "";
            $strClave = isset($_POST["txtClave"]) ? trim($_POST["txtClave"]) : "";
            
            $objUsuario = new usuario();
            $arrUsuario = $objUsuario->fntGetLogIn($strEmail, $strClave);
            
            
            if( intval($arrUsuario["id_usuario"]) ){
                
                $arrUsuarioPais = $objUsuario->getUsuarioPais($arrUsuario["id_usuario"]);
                    
                $_SESSION['leterago']['id'] = $arrUsuario["id_usuario"];    
                $_SESSION['leterago']['nombres'] = $arrUsuario["nombres"];    
                $_SESSION['leterago']['apellidos'] = $arrUsuario["apellidos"];    
                $_SESSION['leterago']['email'] = $arrUsuario["email"];    
                $_SESSION['leterago']['tipo'] = $arrUsuario["tipo"];    
                $_SESSION['leterago']['id_pais'] = $arrUsuarioPais;    
                
                if( $_SESSION['leterago']['tipo'] == "CL" ){
                    
                    $objUsuario->setClienteISP($arrUsuario["id_usuario"]);
                    header("Location:" . base_url . 'cliente/index');
                        
                }
                else{
                    
                    header("Location:" . base_url . 'home/index');
                        
                }
                
            } else {

                $_SESSION['error_login'] = 'Identificacion Fallida';
                
                header("Location:" . base_url);
                
            }
            
        } else {

            header("Location:" . base_url);
        }
    }

    public function logout() {

        if (isset($_SESSION['leterago'])) {
            unset($_SESSION['leterago']);
        }

        header("Location:" . base_url);
    }

    public function index() {
        utils::isIdentity();
        
        $this->objView->fntDrawIndex();

        
    }

    public function edit() {
        utils::isIdentity();
        if (utils::whatRol() != 1) {
            header("Location:" . base_url . "home/index");
        }

        // Validamos si existe el GET
        if ($_GET) {
            // Almacena variable de id de la empresa
            $id_usuario = isset($_GET['id']) ? intval($_GET['id']) : 0;


            // Instanciamos el modelo de la empresa para consultar una unica empresa
            $usuario = new usuario();
            $usuario->setId($id_usuario);
            $_usuario = $usuario->getUsuarioById();
            $_usuario = $_usuario->fetch_object();
            // Dividimos el numero de telefono del contacto que recuperamos
            $telefono = $_usuario->telefono;
            $telefono = explode(" ", $telefono);
            // Listar usuarios
            $lista_usuarios = $usuario->getAll();
            // Listar Roles
            $rol = new catRol();
            $lista_roles = $rol->getAll();
            // Listar Estados
            $estado = new catEstadoAI();
            $lista_estados = $estado->getAll();
            #Listado de perfiles#
            $perfil = new Perfil();
            $lista_perfiles = $perfil->getAll();

            $perfiles_usuario = new usuarioPerfil();
            $perfiles_usuario->setId_usuario($id_usuario);
            $yes_perfiles = $perfiles_usuario->getUserById();
//            utils::drawDebug($yes_perfiles);
//            die();

            $perfiles = array();
            while ($row = $yes_perfiles->fetch_object()) {
                $perfiles[] = $row;
            }
//            utils::drawDebug($perfiles);
//            die();

            $arrPerfiles = array();
            while ($row1 = $lista_perfiles->fetch_object()) {
                $arrPerfiles[] = $row1;
            }

            function compare_by_perfil($perfil, $usuario) {
                $perfilId = $perfil->id_perfil;
                $usuarioId = $usuario->id_perfil;
                if ($usuarioId == $perfilId) {
                    return 0;
                }
                return -1;
            }

//            utils::drawDebug($arrPerfiles);
//            die();
            //$no_perfil = array_diff_key($arrPerfiles, $perfiles);
            $no_perfil = array_udiff($arrPerfiles, $perfiles, 'compare_by_perfil');
//            utils::drawDebug($no_perfil);
//            die();


            require_once 'views/usuario/crud-usuario.php';
        } else {
            $_SESSION['noti_tipo'] = 'danger';
            $_SESSION['noti_mensaje'] = 'Problemas al capturar el ID por GET';
            header('Location:' . base_url . 'usuario/index');
        }
    }

    public function save() {
        // Validacion si existe post
        if ($_POST) {
            // Variable para notificacion
            $result = false;

            // Si es update seteamos la variable get
            $id_usuario = isset($_GET['id']) ? intval($_GET['id']) : 0;
            // Seteo de los datos del post
            $id_empresa = isset($_POST['id_empresa']) ? intval($_POST['id_empresa']) : 0;
            $nombre = isset($_POST['txt_nombre']) ? trim($_POST['txt_nombre']) : null;
            $nombre_usuario = isset($_POST['txt_usuario']) ? trim($_POST['txt_usuario']) : null;
            $dpi = isset($_POST['txt_dpi']) ? trim($_POST['txt_dpi']) : null;
            $correo = isset($_POST['txt_correo']) ? trim($_POST['txt_correo']) : null;
            $telefono_1 = isset($_POST['txt_telefono1']) ? trim($_POST['txt_telefono1']) : null;
            $telefono_2 = isset($_POST['txt_telefono2']) ? trim($_POST['txt_telefono2']) : null;
            $clave = isset($_POST['txt_password']) ? trim($_POST['txt_password']) : null;
            $rol = isset($_POST['opt_rol']) ? intval($_POST['opt_rol']) : 0;
            $estado = isset($_POST['opt_estado']) ? intval($_POST['opt_estado']) : 0;

            // Validacion de informacion nula (se evalua primero el error).
            if ($nombre == null || $nombre_usuario == null || $rol == 0 || $id_empresa == 0 || $dpi == null || $correo == null) {

                // De encontrarse el campo nulo se envia la notificacion de valores nulos
                $_SESSION['noti_tipo'] = 'danger';
                $_SESSION['noti_mensaje'] = 'No has enviado algun valor requerido';
                header('Location:' . base_url . 'usuario/index');
            } else {

                // Instanseamos el objeto de usuario 
                $usuario = new usuario();
                $usuario->setUsuario($nombre_usuario);
                $usuario->setDpi($dpi);
                $usuario->setCorreoElectronico($correo);
                $existe = $usuario->getEquals();
                $e_dpi = $usuario->getEqualsDPI();
                $e_correo = $usuario->getEqualsCorreo();

                // Validacion de usuario existente, o DPI exitente o Correo existente
                if ($existe >= 1 && $e_dpi >= 1 && $e_correo >= 1 && $id_usuario == 0) {

                    $_SESSION['noti_tipo'] = 'warning';
                    $_SESSION['noti_mensaje'] = 'Información de usuario ya existente';
                    header('Location:' . base_url . 'usuario/index');

                    die();
                } else {

                    $telefono = $telefono_1 . ' ' . $telefono_2;

                    $usuario->setTelefono($telefono);
                    $usuario->setIdEmpresa($id_empresa);
                    $usuario->setNombre($nombre);
                    $usuario->setUsuario($nombre_usuario);
                    $usuario->setClave($clave);
                    $usuario->setIdRol($rol);

                    // si el id del usuario es mayor a cero entonces se procede al update
                    if ($id_usuario > 0) {
                        $usuario->setId($id_usuario);
                        $usuario->setEstado($estado);
                        $result = $usuario->update();
                    } else {
                        $result = $usuario->save();
                    }
                }

                // Valida si el resultado es correcto o no, para armar las notificaciones
                if ($result) {

                    $_SESSION['noti_tipo'] = 'success';
                    $_SESSION['noti_mensaje'] = 'Registro almacenado correctamente';
                    header('Location:' . base_url . 'usuario/index');
                } else {

                    $_SESSION['noti_tipo'] = 'danger';
                    $_SESSION['noti_mensaje'] = 'Registro no se almaceno correctamente';
                    header('Location:' . base_url . 'usuario/index');
                }
            }
        } else {

            $_SESSION['noti_tipo'] = 'danger';
            $_SESSION['noti_mensaje'] = 'Problemas al enviar informacion por POST';
            header('Location:' . base_url . 'empresa/index');
        }
    }

    public function savePerfilUsuario() {
        if ($_GET) {
#validacion de get accesos y idPerfil#
            $id_usuario = isset($_GET['idUsuario']) ? $_GET['idUsuario'] : 0;
            $id_perfiles = isset($_GET['perfiles']) ? $_GET['perfiles'] : 0;

#Instancia objeto perfil#
            $perfiles_usuario = new usuarioPerfil();
            $perfiles_usuario->setId_usuario($id_usuario);

            $perfiles = explode(',', $id_perfiles);

            $count = count($perfiles);

            $perfiles_usuario->clearAccess();

            for ($i = 0; $i < $count; $i++) {
                $perfiles_usuario->setId_perfil($perfiles[$i]);
                $result = $perfiles_usuario->save();
                // utils::drawDebug($result);
            }

            if ($result) {
                $_SESSION['noti_tipo'] = "success";
                $_SESSION['noti_mensaje'] = "Acceso Guardado con Exito!";
                //  header('Location:' . base_url . 'usuario/index');
            } else {
                $_SESSION['noti_tipo'] = 'warning';
                $_SESSION['noti_mensaje'] = 'Se produjo un error al guardar acceso';
                // header('Location:' . base_url . 'usuario/index');
            }
        } else {
            $_SESSION['noti_tipo'] = 'danger';
            $_SESSION['noti_mensaje'] = 'Error al mandar datos por POST';
            //   header('Location:' . base_url . 'usuario/index');
        }
    }

    public function cambioClave() {
        if ($_POST) {
            // Variable para notificacion
            $result = false;

            // Seteamos la informacion que viene por POST
            $clave = isset($_POST['clave']) ? trim($_POST['clave']) : null;
            $confirmar_clave = isset($_POST['confirmar_clave']) ? trim($_POST['confirmar_clave']) : null;
            $idUsuario = isset($_GET['idUsuario']) ? trim(($_GET['idUsuario'])) : 0;
            if ($clave == $confirmar_clave) {
                $usuario = new usuario();
                $usuario->setClave($clave);
                if (!isset($idUsuario)) {
                    $usuario->setId($_SESSION['identity-imsalesys']->id);
                } else {
                    $usuario->setId($idUsuario);
                }
                $result = $usuario->updateClave();

                if ($result) {
                    $_SESSION['noti_tipo'] = 'success';
                    $_SESSION['noti_mensaje'] = 'Cambio realizado exitosamente';
                    header('Location:' . base_url . 'home/index');
                } else {
                    $_SESSION['noti_tipo'] = 'danger';
                    $_SESSION['noti_mensaje'] = 'No se pudo realizar el cambio exitosamente';
                    header('Location:' . base_url . 'home/index');
                }
            } else {
                $_SESSION['noti_tipo'] = 'warning';
                $_SESSION['noti_mensaje'] = 'Problemas en la confirmacion de clave';
                header('Location:' . base_url . 'home/index');
            }
        } else {
            $_SESSION['noti_tipo'] = 'danger';
            $_SESSION['noti_mensaje'] = 'No pudimos cambiar tu contraseña';
            header('Location:' . base_url . 'home/index');
        }
    }

    public function changeEmpresa() {
        if ($_GET) {
            $id_empresa_new = isset($_GET['opt_empresa']) ? intval($_GET['opt_empresa']) : 0;

            $_SESSION['identity-imsalesys']->idEmpresa = $id_empresa_new;

            if (isset($_SESSION['orden_detalle']))
                unset($_SESSION['orden_detalle']);

            $_SESSION['noti_tipo'] = 'success';
            $_SESSION['noti_mensaje'] = 'Se cambio de empresa exitosamente';
            header('Location:' . base_url . 'home/index');
        } else {
            $_SESSION['noti_tipo'] = 'danger';
            $_SESSION['noti_mensaje'] = 'No se recibe empresa por GET';
            header('Location:' . base_url . 'home/index');
        }
    }

}
