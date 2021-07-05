<?php

require_once 'models/perfil.php';
require_once 'views/perfil/perfil_view.php';

class perfilController {

    var $objView;
    var $objModel;

    public function __construct() {

        $this->objView = new perfil_view();
        $this->objModel = new perfil_model();
    }
    
    public function index() {
        utils::isIdentity();
        
        $this->objView->fntDrawIndex();

        
    }
    
    public function getAjax() {
        
        if( isset($_GET["drawListPerfil"]) ){
            
            $arrPerfil = $this->objModel->getPerfiles();
            
            $this->objView->drawListPerfil($arrPerfil);
            
            die();
        }
        
        if( isset($_GET["drawAdminModalPerfil"]) ){
            
            $intPerfil = isset($_GET["perfil"]) ? intval($_GET["perfil"]) : 0;
            
            $arrPefil = $this->objModel->getPerfil($intPerfil);
            $arrAcceso = utils::getAcceso();
            $arrPerfilAcceso = $this->objModel->getPerfilAcceso($intPerfil);
            
            $this->objView->drawAdminModalPerfil($intPerfil, $arrPefil, $arrAcceso, $arrPerfilAcceso);
            
            die();
        }
        
        if( isset($_GET["setEliminarUsuario"]) ){
            
            $intUsuario = isset($_GET["usuario"]) ? intval($_GET["usuario"]) : 0;
            
            $arrUsuario = $this->objModel->setEliminarUsuario($intUsuario);
            
            die();
        }
        
        if( isset($_GET["setPerfil"]) ){
            
            $intPerfil = isset($_POST["hidPerfil"]) ? intval($_POST["hidPerfil"]) : 0;
            $strNombrePerfil = isset($_POST["txtNombrePerfil"]) ? trim($_POST["txtNombrePerfil"]) : "";
            $strEstado = isset($_POST["slcEstado"]) ? trim($_POST["slcEstado"]) : "";
            
            if( $intPerfil ){
                
                $this->objModel->fntSetUpdatePerfil($intPerfil, $strNombrePerfil, $strEstado);
                
                $arr["msg"] = "Perfil actualizado";
            }
            else{
                
                $intPerfil = $this->objModel->fntSetPerfil($strNombrePerfil, $strEstado);
                $arr["msg"] = "Perfil creado";    
            }
            
            
            if( $intPerfil ){
                
                $this->objModel->deletePerfilAcceso($intPerfil);
                
                if( isset($_POST["slcAcceso"]) ){
                    
                    while( $rTMP = each($_POST["slcAcceso"]) ){
                        
                        $this->objModel->setPerfilAcceso($intPerfil, $rTMP["value"]);
                        
                        
                    }
                    
                }
                
            }
            
            $arr["error"] = false;
            
            
            print json_encode($arr);            
            
            die();
        }
        
    }

              
}

?>
