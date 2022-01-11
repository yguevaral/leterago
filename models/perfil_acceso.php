<?php

class perfil_acceso {

    private $id;
    private $id_perfil;
    private $id_acceso;
    private $db;

    function __construct() {
        $this->db = Database::connect();
    }

    function getId() {
        return $this->id;
    }

    function getId_perfil() {
        return $this->id_perfil;
    }

    function getId_acceso() {
        return $this->id_acceso;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setId_perfil($id_perfil) {
        $this->id_perfil = $id_perfil;
    }

    function setId_acceso($id_acceso) {
        $this->id_acceso = $id_acceso;
    }

    public function getAll() {
        $strQuery = "select * from perfil_acceso;";
        $execute = $this->db->query($strQuery);

        $result = FALSE;
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    public function getNoAccesos() {
        $srtQuery = "select * from acceso where id_acceso not in (select id_acceso from perfil_acceso where id_perfil = {$this->getId_perfil()});";
        $execute = $this->db->query($srtQuery);

        $result = false;
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    public function getByPerfilId() {
        $strQuery = "select pa.id_acceso , a.codigo_acceso , a.tipo_acceso
                     from perfil_acceso as pa
                     inner join perfil as p ON p.id_perfil = pa.id_perfil
                     inner join acceso as a on a.id_acceso = pa.id_acceso where p.id_perfil = {$this->getId_perfil()};";
        $execute = $this->db->query($strQuery);
        //utils::drawDebug($strQuery);
        //die();
        $result = FALSE;
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    public function clearAccess() {
        $strQuery = "delete from perfil_acceso where id_perfil = {$this->getId_perfil()};";
        $excute = $this->db->query($strQuery);
        $result = false;
        if ($excute) {
            $result = $excute;
        }
        return $result;
    }

    public function save() {

        $strQuery = "insert into perfil_acceso values ({$this->getId_perfil()},{$this->getId_acceso()}) ;";
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

