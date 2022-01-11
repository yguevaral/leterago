<?php

class Acceso {

    private $id_acceso;
    private $codigo_acceso;
    private $tipo_acceso;
    private $db;

    function __construct() {
        $this->db = Database::connect();
    }

    function getId_acceso() {
        return $this->id_acceso;
    }

    function getCodigo_acceso() {
        return $this->codigo_acceso;
    }

    function getTipo_acceso() {
        return $this->tipo_acceso;
    }

    function setId_acceso($id_acceso) {
        $this->id_acceso = $id_acceso;
    }

    function setCodigo_acceso($codigo_acceso) {
        $this->codigo_acceso = $codigo_acceso;
    }

    function setTipo_acceso($tipo_acceso) {
        $this->tipo_acceso = $tipo_acceso;
    }

    public function getAll() {

        $strQuery = "select * from acceso;";
        $execute = $this->db->query($strQuery);

        $result = false;
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    public function getOneById() {

        $strQuery = "select * from acceso where id_acceso = {$this->getId_acceso()};";
        $execute = $this->db->query($strQuery);

        $result = false;
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    public function save() {

        $strQuery = "insert into acceso values (null, '{$this->getCodigo_acceso()}' , {$this->getTipo_acceso()});";
        $execute = $this->db->query($strQuery);

        $result = false;
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    public function update() {

        $strQuery = "update acceso set codigo_acceso = '{$this->codigo_acceso}' , tipo_acceso = {$this->tipo_acceso} where id_acceso = {$this->getId_acceso()};";
        $execute = $this->db->query($strQuery);

        $result = false;
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

}
?>

