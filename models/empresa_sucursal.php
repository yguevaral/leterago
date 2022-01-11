<?php

class empresaSucursal {

    private $idEmpresa;
    private $idSucursal;
    private $db;

    function __construct() {
        $this->db = Database::connect();
    }

    function getIdEmpresa() {
        return $this->idEmpresa;
    }

    function getIdSucursal() {
        return $this->idSucursal;
    }

    function setIdEmpresa($idEmpresa) {
        $this->idEmpresa = $idEmpresa;
    }

    function setIdSucursal($idSucursal) {
        $this->idSucursal = $idSucursal;
    }

    public function getAll() {
        $strQuery = "select * from empresa_sucursal;";
        $execute = $this->db->query($strQuery);

        $result = FALSE;
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    public function getEmpresaById() {
        $strQuery = "select * from empresa_sucursal where id_empresa = {$this->getIdEmpresa()} ;";
        $execute = $this->db->query($strQuery);

        $result = FALSE;
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    public function clearAccess() {
        $strQuery = "delete from empresa_sucursal where id_empresa = {$this->getIdEmpresa()};";
        $excute = $this->db->query($strQuery);
        $result = false;
        if ($excute) {
            $result = $excute;
        }
        return $result;
    }

    public function save() {

        $strQuery = "insert into empresa_sucursal values ({$this->getIdEmpresa()} , {$this->getIdSucursal()});";
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


