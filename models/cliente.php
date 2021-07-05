<?php

class cliente {

    private $id;
    private $nit;
    private $mail;
    private $nombre;
    private $idDepartamento;
    private $idMunicipio;
    private $zona;
    private $direccion;
    private $telefono;
    private $fechaAlta;
    private $fechaModificacion;
    private $fechaBaja;
    private $estado;
    private $db;

    function __construct() {
        $this->db = Database::connect();
    }
    
    function getId() {
        return $this->id;
    }

    function getNit() {
        return $this->nit;
    }

    function getMail() {
        return $this->mail;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getIdDepartamento() {
        return $this->idDepartamento;
    }

    function getIdMunicipio() {
        return $this->idMunicipio;
    }

    function getZona() {
        return $this->zona;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getTelefono() {
        return $this->telefono;
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

    function getEstado() {
        return $this->estado;
    }
    
    

    function setId($id) {
        $this->id = $id;
    }

    function setNit($nit) {
        $this->nit = $nit;
    }

    function setMail($mail) {
        $this->mail = $mail;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setIdDepartamento($idDepartamento) {
        $this->idDepartamento = $idDepartamento;
    }

    function setIdMunicipio($idMunicipio) {
        $this->idMunicipio = $idMunicipio;
    }

    function setZona($zona) {
        $this->zona = $zona;
    }

    function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
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

    function setEstado($estado) {
        $this->estado = $estado;
    }

    public function getAll() {
        $query = "Select * From cliente";
        $usuario = $this->db->query($query);

        $result = false;
        if ($usuario) {
            $result = $usuario;
        }

        return $result;
    }

    public function getEqualsPhone() {
        $result = 0;

        $queryI = "Select Count(*) cantidad From cliente "
                . "Where telefono like '%{$this->getTelefono()}%';";
        $execI = $this->db->query($queryI);

        if ($execI) {
            $execI = $execI->fetch_object();
            if ($execI->cantidad > 0) {
                $result = 1;
            }
        }

        return $result;
    }
        public function getEqualsId() {
        $result = 0;

        $queryI = "Select Count(*) cantidad From cliente "
                . "Where id = {$this->getId()};";
        $execI = $this->db->query($queryI);

        if ($execI) {
            $execI = $execI->fetch_object();
            if ($execI->cantidad > 0) {
                $result = 1;
            }
        }

        return $result;
    }

    public function getClienteById() {
        $query = "Select * From cliente "
                . "Where id = {$this->getId()}";
        $execute = $this->db->query($query);

        $result = false;
        if ($execute) {
            $result = $execute;
        }

        return $result;
    }

    public function getNameById() {
        $query = "Select nombre from cliente where id = {$this->getId()}";
        $execute = $this->db->query($query);

        $result = false;
        if ($execute) {
            $result = $execute->fetch_object()->nombre;
        }

        return $result;
    }

    public function getClienteByPhone() {
        $query = "SELECT * FROM cliente WHERE telefono LIKE '%{$this->getTelefono()}%';";
        $execute = $this->db->query($query);
//        utils::drawDebug($execute);
        $result = false;
        if ($execute) {
            $result = $execute;
        }

        return $result;
    }

    public function getDeptoMuni() {
        $query = "Select idDepartamento, idMunicipio From cliente Where id = {$this->getId()};";
        $execute = $this->db->query($query);

        $result = false;
        if ($execute) {
            $result = $execute->fetch_object();
        }

        return $result;
    }

    public function save() {
        $_nit = $this->getNit();

        if (!isset($_nit)) {
            $_nit = "C/F";
        }

        $insert = "Insert Into cliente Values(null, "
                . "'{$_nit}', "
                . "'{$this->getMail()}', "
                . "Upper('{$this->getNombre()}'), "
                . "'{$this->getIdDepartamento()}', "
                . "'{$this->getIdMunicipio()}', "
                . "{$this->getZona()}, "
                . "Upper('{$this->getDireccion()}'), "
                . "'{$this->getTelefono()}', "
                . "CURDATE(), null, null, 1)";
                
        $execute = $this->db->query($insert);

        $result = false;
        if ($execute) {
            $result = $execute;
        }

        return $result;
    }

    public function saveToVenta() {
        $_nit = $this->getNit();

        if (!isset($_nit)) {
            $_nit = "C/F";
        }
        
        $insert = "Insert Into cliente Values(null, "
                . "'{$_nit}', "
                . "'{$this->getMail()}', "
                . "Upper('{$this->getNombre()}'), "
                . "'{$this->getIdDepartamento()}', "
                . "'{$this->getIdMunicipio()}', "
                . "{$this->getZona()}, "
                . "Upper('{$this->getDireccion()}'), "
                . "'{$this->getTelefono()}', "
                . "CURDATE(), null, null, 1)";
        $execute = $this->db->query($insert);

        $result = false;
        if ($execute) {
            $query = "Select @@identity AS id;";
            $exec = $this->db->query($query);
            $exec = $exec->fetch_object();

            if ($exec) {
                $result = $exec->id;
            }
        }

        return $result;
    }

    public function update() {
        $update = "Update cliente Set nit = '{$this->getNit()}', "
                . "mail = '{$this->getMail()}', "
                . "nombre = UPPER('{$this->getNombre()}'), "
                . "idDepartamento = '{$this->getIdDepartamento()}', "
                . "idMunicipio = '{$this->getIdMunicipio()}', "
                . "zona = {$this->getZona()}, "
                . "direccion = UPPER('{$this->getDireccion()}'), "
                . "telefono = '{$this->getTelefono()}', "
                . "fechaModificacion = CURDATE() "
                . "Where id = {$this->getId()};";
        $execute = $this->db->query($update);

        $result = false;
        if ($execute) {
            $result = $execute;
        }

        return $result;
    }
    
    public function updateDireccion() {
        
        $update = "Update cliente Set idDepartamento = '{$this->getIdDepartamento()}', "
                . "nit = '{$this->getNit()}', "
                . "idMunicipio = '{$this->getIdMunicipio()}', "
                . "zona = {$this->getZona()}, "
                . "direccion = UPPER('{$this->getDireccion()}'), "
                . "telefono = '{$this->getTelefono()}', "
                . "fechaModificacion = CURDATE() "
                . "Where id = {$this->getId()};";
        $execute = $this->db->query($update);

        $result = false;
        if ($execute) {
            $result = $execute;
        }

        return $result;
    }
    
    public function getClienteByNombre($str){
        
        $str = trim($str);
        
        $arr = array();
        if( !empty($str) ){
            
            $strQuery = "SELECT *
                         FROM   cliente
                         WHERE  nombre LIKE '%{$str}%'";
            $qTMP = $this->db->query($strQuery);
            while( $rTMP = $qTMP->fetch_object() ){
                
                $arr[$rTMP->id] = $rTMP;
                        
            }
            
        }
        
        return $arr;
    }

}
