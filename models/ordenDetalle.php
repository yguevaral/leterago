<?php

class ordenDetalle {

    private $id;
    private $idOrden;
    private $codigoProducto;
    private $idPrendaArticulo;
    private $idTallaTamano;
    private $idColor;
    private $descripcion;
    private $cantidad;
    private $precio;
    private $subtotal;
    private $estadoVenta;
    private $db;
    private $iva;

    function __construct() {
        $this->db = Database::connect();
    }

    function getIva() {
        return $this->iva;
    }
    
    function getId() {
        return $this->id;
    }

    function getIdOrden() {
        return $this->idOrden;
    }

    function getCodigoProducto() {
        return $this->codigoProducto;
    }

    function getIdPrendaArticulo() {
        return $this->idPrendaArticulo;
    }

    function getIdTallaTamano() {
        return $this->idTallaTamano;
    }

    function getIdColor() {
        return $this->idColor;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getCantidad() {
        return $this->cantidad;
    }

    function getPrecio() {
        return $this->precio;
    }

    function getSubtotal() {
        return $this->subtotal;
    }

    function getEstadoVenta() {
        return $this->estadoVenta;
    }

    function setIva($iva) {
        $this->iva = $iva;
    }


    function setId($id) {
        $this->id = $id;
    }

    function setIdOrden($idOrden) {
        $this->idOrden = $idOrden;
    }

    function setCodigoProducto($codigoProducto) {
        $this->codigoProducto = $codigoProducto;
    }

    function setIdPrendaArticulo($idPrendaArticulo) {
        $this->idPrendaArticulo = $idPrendaArticulo;
    }

    function setIdTallaTamano($idTallaTamano) {
        $this->idTallaTamano = $idTallaTamano;
    }

    function setIdColor($idColor) {
        $this->idColor = $idColor;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    function setPrecio($precio) {
        $this->precio = $precio;
    }

    function setSubtotal($subtotal) {
        $this->subtotal = $subtotal;
    }

    function setEstadoVenta($estadoVenta) {
        $this->estadoVenta = $estadoVenta;
    }

    public function getAllById() {
        $query = "Select id, codigoProducto, descripcion, cantidad, precio, subtotal "
                . "From orden_detalle Where idOrden = {$this->getIdOrden()};";
        $execute = $this->db->query($query);

        $result = false;
        if ($execute) {
            $result = $execute;
        }

        return $result;
    }
    
    public function getAllByIdDevolucionModal() {
        $query = "SELECT    id, 
                            codigoProducto, 
                            descripcion, 
                            cantidad, 
                            precio, 
                            subtotal 
                  FROM      orden_detalle 
                  WHERE     idOrden = {$this->getIdOrden()} 
                  AND       devolucion = 'N'";
        $execute = $this->db->query($query);

        $result = false;
        if ($execute) {
            $result = $execute;
        }

        return $result;
    }

    public function getOneOrden() {
        $query = "Select * From orden_detalle Where idOrden = {$this->getIdOrden()}";
    }

    public function codProdDevolucion() {
        $query = "Select codigoProducto, cantidad, precio, subtotal, descripcion From orden_detalle "
                . "Where idOrden = {$this->getIdOrden()};";
        $execute = $this->db->query($query);
//        utils::drawDebug($query);
//        die();

        $result = false;
        if ($execute) {
            $result = $execute;
        }

        return $result;
    }

    public function codProdDevolucionId() {
        $query = "Select codigoProducto, cantidad, precio, subtotal, descripcion From orden_detalle "
                . "Where idOrden = {$this->getIdOrden()} And id = {$this->getId()};";
        $execute = $this->db->query($query);
        $result = false;
        if ($execute) {
            $result = $execute;
        }
//        var_dump($result);
//        die();
        return $result;
    }
    
    public function setUpdateOrdenDetalleDevolucion(){
        
        $strQuery = "UPDATE orden_detalle
                     SET    devolucion = 'Y'
                     WHERE  id = {$this->getId()}";
        $this->db->query($strQuery);
    }

    public function save() {
        foreach ($_SESSION['orden_detalle'] as $key => $value) {
            
            if( $this->getIva() > 0 ){
                $value['subtotal'] += $value['subtotal'] * ($this->getIva() / 100);                
            }
            
            $insert = "Insert Into orden_detalle (idOrden, codigoProducto, idPrendaArticulo, "
                    . "idTallaTamano, idColor, descripcion, cantidad, precio, subtotal, estadoVenta, iva) "
                    . "Values({$this->getIdOrden()}, "
                    . "Case When Instr('{$value['codigoProducto']}', ' ') > 1 Then 'S/C' Else '{$value['codigoProducto']}' End, "
                    . "{$value['idPrendaArticulo']}, "
                    . "{$value['idTallaTamano']}, {$value['idColor']}, Upper('{$value['descripcion']}'), "
                    . "{$value['cantidad']}, {$value['precio']}, {$value['subtotal']}, {$value['estadoVenta']}, {$this->getIva()});";
            $exec = $this->db->query($insert);
        }

        $result = false;
        if ($exec) {
            $result = $exec;
        }

        return $result;
    }

    public function saveSM($sinTotalDevolucion = 0) {
        
        if( $sinTotalDevolucion > 0 ){
            $sinTotalDevolucion = $sinTotalDevolucion /  count($_SESSION['orden_detalle']);
        }
        
        foreach ($_SESSION['orden_detalle'] as $key => $value) {
            
            
            if( $this->getIva() > 0 ){
                $value['subtotal'] += $value['subtotal'] * ($this->getIva() / 100);                
            }
            
            $insert = "Insert Into orden_detalle (idOrden, codigoProducto, idPrendaArticulo, "
                    . "idTallaTamano, idColor, descripcion, cantidad, precio, subtotal, estadoVenta, iva, descuento_devolucion) "
                    . "Values({$this->getIdOrden()}, "
                    . "Case When Instr('{$value['codigoProducto']}', ' ') > 1 Then 'S/C' Else '{$value['codigoProducto']}' End, "
                    . "{$value['idPrendaArticulo']}, "
                    . "{$value['idTallaTamano']}, {$value['idColor']}, Upper('{$value['descripcion']}'), "
                    . "{$value['cantidad']}, {$value['precio']}, {$value['subtotal']}, 3, {$this->getIva()}, {$sinTotalDevolucion});";
            $exec = $this->db->query($insert);
        }

        $result = false;
        if ($exec) {
            $result = $exec;
        }

        return $result;
    }

    public function devolucion() {
        $update = "Update orden_detalle set estadoVenta = 4 Where idOrden = {$this->getIdOrden()};";
        $execute = $this->db->query($update);

        $result = false;
        if ($execute) {
            $result = $execute;
        }

        return $result;
    }

    public function devolucionDetalle() {
        $update = "Update orden_detalle set estadoVenta = 4 Where id = {$this->getId()} And idOrden = {$this->getIdOrden()}";
        $execute = $this->db->query($update);
        var_dump($update);

        $result = false;
        if ($execute) {
            $result = $execute;
        }

        return $result;
    }

    public function deleteOrdenDetalle() {
        
        $strQuery = "DELETE FROM orden_detalle WHERE  idOrden = {$this->getIdOrden()} AND codigoProducto = '{$this->getCodigoProducto()}'";
        $execute = $this->db->query($strQuery);
        $result = false;

        if ($execute) {
            $result = $execute;
        }
        return $result;
//       var_dump($strQuery);
//        die();
    }

    public function updateOrdenDetalleCantidad() {

        $strQuery = "UPDATE orden_detalle
                     SET    cantidad = {$this->getCantidad()},
                            subtotal = '{$this->getSubtotal()}'
                     WHERE  idOrden = {$this->getIdOrden()} 
                     AND    codigoProducto = '{$this->getCodigoProducto()}'";

        $this->db->query($strQuery);
    }

    public function insertOrdenDetalle() {

        $strQuery = "INSERT INTO    orden_detalle(idOrden, codigoProducto, idPrendaArticulo,
                                                  idTallaTamano, idColor, descripcion, 
                                                  cantidad, precio, subtotal, 
                                                  estadoVenta, iva  )
                                           VALUES({$this->getIdOrden()}, '{$this->getCodigoProducto()}', '{$this->getIdPrendaArticulo()}',
                                                  '{$this->getIdTallaTamano()}','{$this->getIdColor()}', '{$this->getDescripcion()}',
                                                  '{$this->getCantidad()}', '{$this->getPrecio()}', '{$this->getSubtotal()}',
                                                  '{$this->getEstadoVenta()}', '{$this->getIva()}'  )       ";
        $this->db->query($strQuery);
    }
    
    public function setUpdateFechaDevolucion(){
        
        $strQuery = "UPDATE orden
                     SET    fechaDespacho = CURDATE()
                     WHERE  id = {$this->getIdOrden()}";
        $this->db->query($strQuery);
    }

}
