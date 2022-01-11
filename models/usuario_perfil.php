<?php

class usuarioPerfil {
   
    private $id_usuario;
    private $id_perfil;
    private $db;
    
    function __construct() {
        $this->db = Database::connect();
    }
    
    function getId_usuario() {
        return $this->id_usuario;
    }

    function getId_perfil() {
        return $this->id_perfil;
    }

    function setId_usuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }

    function setId_perfil($id_perfil) {
        $this->id_perfil = $id_perfil;
    }

    public function getAll() {
        $strQuery = "select * from usuario_perfil;";
        $execute = $this->db->query($strQuery);
        
        $result = FALSE;
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }
        public function getUserById() {
        $strQuery = "select * from usuario_perfil where id_usuario = {$this->getId_usuario()} ;";
        $execute = $this->db->query($strQuery);
        
        $result = FALSE;
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }
        public function clearAccess() {
        $strQuery = "delete from usuario_perfil where id_usuario = {$this->getId_usuario()};";
        $excute = $this->db->query($strQuery);
        $result = false;
        if ($excute) {
            $result = $excute;
        }
        return $result;
    }
        public function save() {

        $strQuery = "insert into usuario_perfil values ({$this->getId_usuario()} , {$this->getId_perfil()}) ;";
        $excute = $this->db->query($strQuery);
//        utils:: drawDebug($strQuery);
//        die();      
        $result = false;
        if ($excute) {
            $result = $excute;
        }
        return $result;
    }

}

?>
