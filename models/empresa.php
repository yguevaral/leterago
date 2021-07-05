<?php

class empresa {

    private $id;
    private $nombreEmpresa;
    private $nit;
    private $idDepartamento;
    private $idMunicipio;
    private $direccion;
    private $zona;
    private $telefono;
    private $nombreContacto;
    private $correoContacto;
    private $telefonoContacto;
    private $fechaAlta;
    private $fechaModificacion;
    private $fechaBaja;
    private $inventario;
    private $mensajeria;
    private $rutas;
    private $administracion;
    private $estado;
    private $db;

    function __construct() {
        $this->db = Database::connect();
    }

    function getId() {
        return $this->id;
    }

    function getNombreEmpresa() {
        return $this->nombreEmpresa;
    }

    function getNit() {
        return $this->nit;
    }

    function getIdDepartamento() {
        return $this->idDepartamento;
    }

    function getIdMunicipio() {
        return $this->idMunicipio;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getZona() {
        return $this->zona;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getNombreContacto() {
        return $this->nombreContacto;
    }

    function getCorreoContacto() {
        return $this->correoContacto;
    }

    function getTelefonoContacto() {
        return $this->telefonoContacto;
    }

    function getFechaAlta() {
        return $this->fechaAlta;
    }

    function getFechaModificacion() {
        return $this->fechaModificacion;
    }

    function getFechaBaja() {
        return $this->fechaBaja;
    }

    function getInventario() {
        return $this->inventario;
    }

    function getMensajeria() {
        return $this->mensajeria;
    }

    function getRutas() {
        return $this->rutas;
    }

    function getAdministracion() {
        return $this->administracion;
    }

    function getEstado() {
        return $this->estado;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombreEmpresa($nombreEmpresa) {
        $this->nombreEmpresa = $nombreEmpresa;
    }

    function setNit($nit) {
        $this->nit = $nit;
    }

    function setIdDepartamento($idDepartamento) {
        $this->idDepartamento = $idDepartamento;
    }

    function setIdMunicipio($idMunicipio) {
        $this->idMunicipio = $idMunicipio;
    }

    function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    function setZona($zona) {
        $this->zona = $zona;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function setNombreContacto($nombreContacto) {
        $this->nombreContacto = $nombreContacto;
    }

    function setCorreoContacto($correoContacto) {
        $this->correoContacto = $correoContacto;
    }

    function setTelefonoContacto($telefonoContacto) {
        $this->telefonoContacto = $telefonoContacto;
    }

    function setFechaAlta($fechaAlta) {
        $this->fechaAlta = $fechaAlta;
    }

    function setFechaModificacion($fechaModificacion) {
        $this->fechaModificacion = $fechaModificacion;
    }

    function setFechaBaja($fechaBaja) {
        $this->fechaBaja = $fechaBaja;
    }

    function setInventario($inventario) {
        $this->inventario = $inventario;
    }

    function setMensajeria($mensajeria) {
        $this->mensajeria = $mensajeria;
    }

    function setRutas($rutas) {
        $this->rutas = $rutas;
    }
    
    function setAdministracion($administracion) {
        $this->administracion = $administracion;
    }

        function setEstado($estado) {
        $this->estado = $estado;
    }

    public function getAll() {
        $query = "Select * From empresa";
        $execute = $this->db->query($query);

        $result = false;
        if ($execute) {
            $result = $execute;
        }

        return $result;
    }

    public function getEmpresaById() {
        $query = "Select * From empresa Where id = {$this->getId()}";
        $execute = $this->db->query($query);

        $result = false;
        if ($execute) {
            $result = $execute;
        }

        return $result;
    }

    public function getInvByEmpresa() {
        $query = "Select inventario From empresa Where id = {$this->getId()}";
        $execute = $this->db->query($query);

        $result = false;
        if ($execute) {
            $result = $execute;
        }

        return $result;
    }

    public function getAllByName() {
        $query = "Select * From empresa Where nombreEmpresa like '%{$this->getNombreEmpresa()}%'";
        $execute = $this->db->query($query);

        $result = false;
        if ($execute) {
            $result = $execute;
        }

        return $result;
    }

    public function getEquals() {
        $query = "Select Count(*) cantidad From empresa "
                . "Where nombreEmpresa = '{$this->getNombreEmpresa()}';";
        $execute = $this->db->query($query);

        $execute = $execute->fetch_object();

        $result = 0;
        if ($execute) {
            $result = $execute->cantidad;
        }

        return $result;
    }
        public function getSucursales() {
        $query = "select * from empresa where estado = 1;";
        $execute = $this->db->query($query);
        

        $result = false;
        if ($execute) {
            $result = $execute;
        }

        return $result;
    }

    public function getDeptoMuni() {
        $query = "Select idDepartamento, idMunicipio From empresa Where id = {$this->getId()};";
        $execute = $this->db->query($query);

        $result = false;
        if ($execute) {
            $result = $execute->fetch_object();
        }

        return $result;
    }

    public function save() {
        $insert = "Insert Into empresa Values(null, "
                . "Upper('{$this->getNombreEmpresa()}'), "
                . "'{$this->getNit()}', "
                . "{$this->getIdDepartamento()}, "
                . "{$this->getIdMunicipio()}, "
                . "Upper('{$this->getDireccion()}'), "
                . "{$this->getZona()}, "
                . "'{$this->getTelefono()}', "
                . "Upper('{$this->getNombreContacto()}'), "
                . "Lower('{$this->getCorreoContacto()}'), "
                . "'{$this->getTelefonoContacto()}', "
                . "CURDATE(), null, null, "
                . "{$this->getInventario()}, "
                . "{$this->getMensajeria()}, "
                . "{$this->getRutas()}, "
                . "{$this->getAdministracion()},  "
                . "1)";
        $execute = $this->db->query($insert);

      if( $execute ){
          $execute = $this->db->query("Select @@identity AS id;");
          $execute = $execute->fetch_object();
          return intval($execute->id);
      }
      return 0;
    }

    public function update() {
        $update = "Update empresa Set nombreEmpresa = Upper('{$this->getNombreEmpresa()}'), "
                . "nit = '{$this->getNit()}', "
                . "idDepartamento = {$this->getIdDepartamento()}, "
                . "idMunicipio = {$this->getIdMunicipio()}, "
                . "direccion = Upper('{$this->getDireccion()}'), "
                . "zona = {$this->getZona()}, "
                . "telefono = '{$this->getTelefono()}', "
                . "nombreContacto = Upper('{$this->getNombreContacto()}'), "
                . "correoContacto = Lower('{$this->getCorreoContacto()}'), "
                . "telefonoContacto = '{$this->getTelefonoContacto()}', "
                . "fechaModificacion = CURDATE(), "
                . "inventario = {$this->getInventario()}, "
                . "mensajeria = {$this->getMensajeria()}, "
                . "rutas = {$this->getRutas()}, "
                . "administracion = {$this->getAdministracion()}, "
                . "estado = {$this->getEstado()} "
                . "Where id = {$this->getId()}";
        $execute = $this->db->query($update);

        $result = false;
        if ($execute) {
            $result = $execute;
        }

        return $result;
    }

    public function getEmpresaUsuario($intIdUsuario, $boolAsignada = true, $intIdEmpresaAsignada = 0, $boolAll = false) {

        $intIdEmpresaAsignada = intval($intIdEmpresaAsignada);

        if ($boolAll) {

            $strQuery = "SELECT     *
                       FROM     empresa
                       ";
        } elseif ($boolAsignada) {

            $strQuery = "SELECT   empresa.*
                       FROM     usuario_empresa,
                                empresa
                       WHERE    usuario_empresa.idEmpresa = empresa.id
                       AND      usuario_empresa.idUsuario IN({$intIdUsuario})";
        } else {

            $strQuery = "SELECT     *
                       FROM     empresa
                       WHERE    empresa.id NOT IN({$intIdEmpresaAsignada})";
            $strQuery = "SELECT   empresa.*
                       FROM     usuario_empresa,
                                empresa
                       WHERE    usuario_empresa.idEmpresa = empresa.id
                       AND      usuario_empresa.idUsuario IN({$intIdUsuario})
                       AND      empresa.id NOT IN({$intIdEmpresaAsignada})";
        }

        $execute = $this->db->query($strQuery);
        $result = false;
        if ($execute)
            $result = $execute;
        return $result;
    }

}
