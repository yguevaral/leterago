<?php

class orden {

    private $id;
    private $idEmpresa;
    private $idVendedor;
    private $idCliente;
    private $fechaOrden;
    private $fechaEnvio;
    private $subtotal;
    private $envio;
    private $idMensajeria;
    private $total;
    private $idTipoPago;
    private $idCuenta;
    private $comprobante;
    private $numeroGuia;
    private $observacion;
    private $estadoOrden;
    private $estadoVenta;
    private $db;
    private $fechaInicial;
    private $fechaFinal;
    private $iva;
    private $idOrdenDevolucion;
    private $descuentoDevolucion;

    function __construct() {
        $this->db = Database::connect();
    }

    function getidOrdenDevolucion() {
        return $this->idOrdenDevolucion;
    }

    function setidOrdenDevolucion($intIdOrdenDevolucion) {

        $this->idOrdenDevolucion = $intIdOrdenDevolucion;
    }

    function getDescuentoDevolucion() {
        return $this->descuentoDevolucion;
    }

    function setDescuentoDevolucion($descuentoDevolucion) {

        $this->descuentoDevolucion = $descuentoDevolucion;
    }

    function getIva() {

        return $this->iva;
    }

    function getId() {
        return $this->id;
    }

    function getIdEmpresa() {
        return $this->idEmpresa;
    }

    function getIdVendedor() {
        return $this->idVendedor;
    }

    function getIdCliente() {
        return $this->idCliente;
    }

    function getFechaOrden() {
        return $this->fechaOrden;
    }

    function getFechaEnvio() {
        return $this->fechaEnvio;
    }

    function getSubtotal() {
        return $this->subtotal;
    }

    function getEnvio() {
        return $this->envio;
    }

    function getIdMensajeria() {
        return $this->idMensajeria;
    }

    function getTotal() {
        return $this->total;
    }

    function getIdTipoPago() {
        return $this->idTipoPago;
    }

    function getIdCuenta() {
        return $this->idCuenta;
    }

    function getComprobante() {
        return $this->comprobante;
    }

    function getNumeroGuia() {
        return $this->numeroGuia;
    }

    function getObservacion() {
        return $this->observacion;
    }

    function getEstadoOrden() {
        return $this->estadoOrden;
    }

    function getEstadoVenta() {
        return $this->estadoVenta;
    }

    function getFechaInicial() {
        return $this->fechaInicial;
    }

    function getFechaFinal() {
        return $this->fechaFinal;
    }

    function setIva($iva) {
        $this->iva = $iva;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdEmpresa($idEmpresa) {
        $this->idEmpresa = $idEmpresa;
    }

    function setIdVendedor($idVendedor) {
        $this->idVendedor = $idVendedor;
    }

    function setIdCliente($idCliente) {
        $this->idCliente = $idCliente;
    }

    function setFechaOrden($fechaOrden) {
        $this->fechaOrden = $fechaOrden;
    }

    function setFechaEnvio($fechaEnvio) {
        $this->fechaEnvio = $fechaEnvio;
    }

    function setSubtotal($subtotal) {
        $this->subtotal = $subtotal;
    }

    function setEnvio($envio) {
        $this->envio = $envio;
    }

    function setIdMensajeria($idMensajeria) {
        $this->idMensajeria = $idMensajeria;
    }

    function setTotal($total) {
        $this->total = $total;
    }

    function setIdTipoPago($idTipoPago) {
        $this->idTipoPago = $idTipoPago;
    }

    function setIdCuenta($idCuenta) {
        $this->idCuenta = $idCuenta;
    }

    function setComprobante($comprobante) {
        $this->comprobante = $comprobante;
    }

    function setNumeroGuia($numeroGuia) {
        $this->numeroGuia = $numeroGuia;
    }

    function setObservacion($observacion) {
        $this->observacion = $observacion;
    }

    function setEstadoOrden($estadoOrden) {
        $this->estadoOrden = $estadoOrden;
    }

    function setEstadoVenta($estadoVenta) {
        $this->estadoVenta = $estadoVenta;
    }

    function setFechaInicial($fechaInicial) {
        $this->fechaInicial = $fechaInicial;
    }

    function setFechaFinal($fechaFinal) {
        $this->fechaFinal = $fechaFinal;
    }

    public function getNextId() {
        
    }

    public function getOrdenesByDay() {
        
    }

    public function getAllByEmpresa() {
        $query = "SELECT    orden.id, 
                            orden.fechaOrden, 
                            orden.subtotal, 
                            orden.estadoOrden, 
                            cliente.nombre 
                    FROM orden
                        LEFT JOIN cliente ON cliente.id = orden.idCliente 
                    WHERE orden.idEmpresa = {$this->getIdEmpresa()} AND orden.estadoOrden <> 9;";
        $execute = $this->db->query($query);

        $result = false;
        if ($execute) {
            $result = $execute;
        }

        return $result;
    }

    public function getAllToAssign() {
        $query = "Select o.id, o.fechaOrden, o.subtotal, o.estadoOrden, c.nombre, dep.nombre departamento, mun.nombre municipio "
                . "From orden o "
                . "left Join cliente c On c.id = o.idCliente "
                . "left Join cat_departamento dep On dep.codIso = c.idDepartamento "
                . "left Join cat_municipio mun On mun.codMunicipio = c.idMunicipio "
                . "Where o.idEmpresa = {$this->getIdEmpresa()} "
                . "And o.estadoOrden In (1, 7);";
        $execute = $this->db->query($query);

        $result = false;
        if ($execute) {
            $result = $execute;
        }

        return $result;
    }

    public function getAllAssigned() {
        $query = "Select o.id, Concat('Orden no. ', o.id) title, o.fechaEnvio start, o.numeroGuia, c.nombre, "
                . "c.telefono, o.total "
                . "From orden o Inner Join cliente c On c.id = o.idCliente "
                . "Where o.idEmpresa = {$this->getIdEmpresa()} And o.estadoOrden in (2, 3, 5, 6, 10, 4) AND o.fechaEnvio > SYSDATE();";

        $execute = $this->db->query($query);

        $arr = array();
        while ($executeTMP = $execute->fetch_object()) {

            array_push($arr, array(
                "id" => $executeTMP->id,
                "title" => $executeTMP->title,
                "start" => $executeTMP->start,
                "numeroGuia" => $executeTMP->numeroGuia,
                "nombre" => $executeTMP->nombre,
                "telefono" => $executeTMP->telefono,
                "total" => $executeTMP->total
            ));
        }

        return $arr;
    }

    public function getInfoGuia() {
        $query = "Select idEmpresa, idCliente From orden Where id = {$this->getId()};";
        $execute = $this->db->query($query);

        $result = false;
        if ($execute) {
            $result = $execute->fetch_object();
        }

        return $result;
    }

    public function validaOrdenEmpresa() {
        $query = "Select count(*) conteo From orden "
                . "Where id = {$this->getId()} And idEmpresa = {$this->getIdEmpresa()} And estadoOrden in (1,2,10);";
        $execute = $this->db->query($query);

        $result = false;
        if ($execute) {
            $result = $execute->fetch_object();
        }

        return $result;
    }

    public function validaComprobante() {
        $query = "Select Count(*) contador From orden Where id = {$this->getId()} And idTipoPago <> 1;";
        $execute = $this->db->query($query);

        $result = false;
        if ($execute) {
            $result = $execute->fetch_object()->contador;
        }

        return $result;
    }

    public function save() {
        $update = "Insert Into orden(idEmpresa, idVendedor, idCliente, fechaOrden, subtotal, idTipoPago, "
                . "idCuenta, observacion, estadoOrden, estadoVenta, iva) "
                . "Values({$this->getIdEmpresa()}, {$this->getIdVendedor()}, {$this->getIdCliente()}, Curdate(), "
                . "{$this->getSubtotal()}, {$this->getIdTipoPago()}, '{$this->getIdCuenta()}', '{$this->getObservacion()}', "
                . "1, 1, {$this->getIva()});";
        $execute = $this->db->query($update);

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

    public function saveSM() {
        $update = "Insert Into orden(idEmpresa, idVendedor, idCliente, fechaOrden, subtotal, total, idTipoPago, "
                . "idCuenta, comprobante, observacion, estadoVenta, estadoOrden, iva, idOrdenDevolucion, descuento_devolucion) "
                . "Values({$this->getIdEmpresa()}, {$this->getIdVendedor()}, {$this->getIdCliente()}, Curdate(), "
                . "{$this->getSubtotal()}, {$this->getSubtotal()}, {$this->getIdTipoPago()}, '{$this->getIdCuenta()}', "
                . "'{$this->getComprobante()}', '{$this->getObservacion()}', 3, 4, {$this->getIva()}, {$this->getidOrdenDevolucion()}, {$this->getDescuentoDevolucion()});";


        $execute = $this->db->query($update);

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

    public function devolucion() {
        $update = "Update orden Set estadoVenta = 4, estadoOrden = 9 , fechaDespacho = curdate() "
                . "Where idEmpresa = {$this->getIdEmpresa()} And id = {$this->getId()};";
        $execute = $this->db->query($update);
//        utils::drawDebug($update);
//        die();

        $result = false;
        if ($execute) {
            $result = $execute;
        }

        return $result;
    }

    public function envioSinCosto() {
        $update = "Update orden Set envio = 0, total = subtotal "
                . "Where id = {$this->getId()};";
        $execute = $this->db->query($update);

        $result = false;
        if ($execute) {
            $result = $execute;
        }

        return $result;
    }

    public function setToAssign() {
        $_envio = $this->getEnvio();
        $update = "Update orden Set estadoOrden = 4, fechaEnvio = '{$this->getFechaEnvio()}', "
                . "idMensajeria = {$this->getIdMensajeria()}, "
                . "comprobante = '{$this->getComprobante()}'";

        if ($_envio) {
            $update .= ", envio = {$this->getEnvio()}, total = subtotal + envio";
        }

        $update .= " Where id = {$this->getId()} And idEmpresa = {$this->getIdEmpresa()};";

        $execute = $this->db->query($update);

        $result = false;
        if ($execute) {
            $result = $execute;
        }

        return $result;
    }

    public function despacho() {
        $query = "Select o.id, o.fechaEnvio, o.numeroGuia, od.codigoProducto, od.idPrendaArticulo, od.idTallaTamano, o.subtotal, o.total, "
                . "od.idColor, od.descripcion, od.cantidad, ifNull(te.idRuta, 'Externa') ruta, o.observacion, o.comprobante , "
                . "c.nombre, c.telefono, c.direccion, c.zona, cd.nombre departamento, cm.nombre municipio, o.observacion observacionOrden "
                . "From orden o Left Join orden_detalle od On od.idOrden = o.id "
                . "Left Join tracking_envio te On te.idOrden = o.id "
                . "Left Join cliente c On c.id = o.idCliente "
                . "Left Join cat_departamento cd On cd.codIso = c.idDepartamento "
                . "Left Join cat_municipio cm On cm.codMunicipio = c.idMunicipio "
                . "Where o.idEmpresa = {$this->getIdEmpresa()} And o.fechaEnvio = curdate() "
                . "And o.estadoOrden in (2, 3, 10);";

        $query = "Select o.id, o.iva, o.fechaEnvio, o.numeroGuia, od.codigoProducto, od.idPrendaArticulo, od.idTallaTamano, o.subtotal, o.total, "
                . "od.idColor, od.descripcion, od.cantidad, ifNull(te.idRuta, 'Externa') ruta, o.observacion, o.comprobante , "
                . "c.nombre, c.telefono, c.direccion, c.zona, cd.nombre departamento, cm.nombre municipio, o.observacion observacionOrden "
                . "From orden o Left Join orden_detalle od On od.idOrden = o.id "
                . "Left Join tracking_envio te On te.idOrden = o.id "
                . "Left Join cliente c On c.id = o.idCliente "
                . "Left Join cat_departamento cd On cd.codIso = c.idDepartamento "
                . "Left Join cat_municipio cm On cm.codMunicipio = c.idMunicipio "
                . "Where o.idEmpresa = {$this->getIdEmpresa()} And DATE_FORMAT(o.fechaEnvio,'%Y/%m/%d') BETWEEN DATE_FORMAT('{$this->getFechaInicial()}','%Y/%m/%d') AND DATE_FORMAT('{$this->getFechaFinal()}','%Y/%m/%d')"
                . "And o.estadoOrden in (2, 3, 10, 4);";

        //utils::drawDebug($query);
        $execute = $this->db->query($query);

        $arr = array();
        while ($rTMP = $execute->fetch_object()) {

            $arr[$rTMP->id]["id"] = $rTMP->id;
            $arr[$rTMP->id]["iva"] = $rTMP->iva;
            $arr[$rTMP->id]["nombre"] = $rTMP->nombre;
            $arr[$rTMP->id]["comprobante"] = $rTMP->comprobante;
            $arr[$rTMP->id]["observacion"] = $rTMP->observacion;
            $arr[$rTMP->id]["departamento"] = $rTMP->departamento;
            $arr[$rTMP->id]["municipio"] = $rTMP->municipio;
            $arr[$rTMP->id]["zona"] = $rTMP->zona;
            $arr[$rTMP->id]["direccion"] = $rTMP->direccion;
            $arr[$rTMP->id]["observacionOrden"] = $rTMP->observacionOrden;
            $arr[$rTMP->id]["telefono"] = $rTMP->telefono;
            $arr[$rTMP->id]["ruta"] = $rTMP->ruta;
            $arr[$rTMP->id]["subtotal"] = $rTMP->subtotal;
            $arr[$rTMP->id]["total"] = $rTMP->total;
            $arr[$rTMP->id]["numeroGuia"] = $rTMP->numeroGuia;


            $arr[$rTMP->id]["inventario"][$rTMP->codigoProducto]["codigoProducto"] = $rTMP->codigoProducto;
            $arr[$rTMP->id]["inventario"][$rTMP->codigoProducto]["cantidad"] = $rTMP->cantidad;
            $arr[$rTMP->id]["inventario"][$rTMP->codigoProducto]["descripcion"] = $rTMP->descripcion;
        }

        return $arr;


        $result = false;
        if ($execute) {
            $result = $execute;
        }

        return $result;
    }

    public function finalizaManual() {
        $query = "SELECT    orden.id, 
                            cliente.nombre, 
                            orden.fechaOrden, 
                            orden.subtotal, 
                            orden.envio, 
                            orden.total 
                FROM orden
                    LEFT JOIN cliente ON cliente.id = orden.idCliente
                WHERE idEmpresa = 3
                    AND estadoVenta NOT IN (3, 4);";
        $execute = $this->db->query($query);

        $result = true;

        if ($execute) {
            $result = $execute;
        }

        return $result;
    }

    public function saveFinalizaManual() {
        $update_1 = "Update orden Set estadoVenta = 3, estadoOrden = 4 "
                . "Where idEmpresa = {$this->getIdEmpresa()} And id = {$this->getId()} ";
        $execute_1 = $this->db->query($update_1);

        $update_2 = "Update orden_detalle Set estadoVenta = 3, estadoOrden = 4 "
                . "Where idOrden = {$this->getId()} ";
        $execute_2 = $this->db->query($update_2);

        $result = true;

        if ($execute_2) {
            $result = $execute;
        }

        return $result;
    }

    public function envioVenta() {
        $query = "Select o.*, c.nombre From orden o 
                  Inner Join cliente c On c.id = o.idCliente 
                  Where o.idEmpresa = 3 And o.idMensajeria = 1 And o.estadoVenta = 3 
                  AND o.fechaEnvio BETWEEN '{$this->getFechaInicial()}' AND '{$this->getFechaFinal()}';";
        $execute = $this->db->query($query);
//        utils::drawDebug($query);
//        die();
        $result = true;

        if ($execute) {
            $result = $execute;
        }

        return $result;
    }

    public function ordenByVendedor() {
        $query = "SELECT    orden.id, 
                            cliente.nombre, 
                            orden.fechaOrden, 
                            tipo_pago.nombreTipoPago,
                            orden.comprobante,
                            orden.subtotal 
                FROM orden
                    LEFT JOIN cliente ON cliente.id = orden.idCliente 
                    LEFT JOIN tipo_pago ON tipo_pago.id = orden.idTipoPago 
                WHERE orden.idEmpresa = {$this->getIdEmpresa()} And idVendedor = {$this->getIdVendedor()} 
                    AND orden.fechaOrden BETWEEN '{$this->getFechaInicial()}' 
                    AND '{$this->getFechaFinal()}' AND orden.estadoOrden = 4;";
        $execute = $this->db->query($query);

        $result = true;

        if ($execute) {
            $result = $execute;
        }

        return $result;
    }

    public function detalleOrdenByVendedor() {
        $query = "Select o.id, o.fechaEnvio, od.codigoProducto, od.idPrendaArticulo, od.idTallaTamano, "
                . "od.idColor, od.descripcion, od.cantidad, ifNull(te.idRuta, 'Externa') ruta "
                . "From orden o Left Join orden_detalle od On od.idOrden = o.id "
                . "Left Join tracking_envio te On te.idOrden = o.id "
                . "Where o.idEmpresa = {$this->getIdEmpresa()} And o.id = {$this->getId()} ";
        $execute = $this->db->query($query);

        $result = false;
        if ($execute) {
            $result = $execute;
        }

        return $result;
    }

    public function frecuenciaCliente() {
        $query = "SELECT orden.idCliente , cliente.nombre, cliente.telefono,
         COUNT(orden.idCliente) AS frecuencia
        FROM orden
        INNER JOIN cliente ON orden.idCliente = cliente.id
        WHERE cliente.nombre not in ('CONSUMIDOR FINAL', 'CF', 'C/F', 'cf', 'c/f', 'consumidor final')
        GROUP BY orden.idCliente
        ORDER BY frecuencia DESC LIMIT 25";
        $execute = $this->db->query($query);

        $result = false;
        if ($execute) {
            $result = $execute;
        }

        return $result;
    }

    public function getVentasByCliente() {

        $strQuery = "SELECT    orden.id, 
                            orden.idEmpresa, 
                            orden_detalle.codigoProducto, 
                            orden_detalle.descripcion, 
                            orden_detalle.subtotal total
                FROM        orden
                                LEFT JOIN orden_detalle 
                                    ON orden_detalle.idOrden = orden.id
                                LEFT JOIN inventario 
                                    ON  inventario.codigoProducto = orden_detalle.codigoProducto 
                                    And inventario.idEmpresa IN ({$this->getIdEmpresa()})
                                LEFT JOIN usuario 
                                    ON usuario.id = orden.idVendedor
                                LEFT JOIN cliente
                                    ON cliente.id = orden.idCliente
                                LEFT JOIN cat_departamento
                                    ON cat_departamento.codIso = cliente.idDepartamento
                                LEFT JOIN tipo_pago
                                    ON tipo_pago.id = orden.idTipoPago
                WHERE   orden.idEmpresa IN ({$this->getIdEmpresa()})
                AND     orden.estadoOrden = 4
                AND 	orden.idCliente = {$this->getIdCliente()}
                GROUP BY orden.id, orden_detalle.id";
        $execute = $this->db->query($strQuery);
//        utils::drawDebug($strQuery);
//        die();
        $result = false;
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    public function getInfoOrden() {

        $strQuery = "SELECT orden.id,
                            orden.idVendedor,
                            orden.idCliente,
                            orden.fechaOrden,
                            orden.fechaEnvio,
                            orden.subtotal,
                            orden.envio,
                            orden.total,
                            orden.idMensajeria,
                            orden.idTipoPago,
                            orden.idCuenta,
                            orden.numeroGuia,
                            orden.estadoVenta,
                            orden.estadoOrden,
                            orden.iva,
                            
                            cliente.nit,
                            cliente.mail,
                            cliente.telefono,
                            cliente.nombre,
                            cliente.idDepartamento,
                            cliente.idMunicipio,
                            cliente.zona,
                            cliente.direccion,
                            cliente.telefono
                            
                            
                     FROM   orden
                                LEFT JOIN cliente
                                    ON  orden.idCliente = cliente.id
                     WHERE  orden.id = {$this->getId()}
                     AND    orden.idEmpresa = {$this->getIdEmpresa()}";
        $qTMP = $this->db->query($strQuery);

        return $qTMP ? $qTMP->fetch_object() : false;
    }

    public function getInfoOrdenLista() {

        $strQuery = "SELECT orden.id,
                            orden.idVendedor,
                            orden.idCliente,
                            orden.fechaOrden,
                            orden.fechaEnvio,
                            orden.subtotal,
                            orden.envio,
                            orden.total,
                            orden.idMensajeria,
                            orden.idTipoPago,
                            orden.idCuenta,
                            orden.numeroGuia,
                            orden.estadoVenta,
                            orden.estadoOrden,
                            
                            cliente.nit,
                            cliente.mail,
                            cliente.telefono,
                            cliente.nombre,
                            cliente.idDepartamento,
                            cliente.idMunicipio,
                            cliente.zona,
                            cliente.direccion,
                            cliente.telefono,
                            
                            cat_departamento.nombre nombre_departamento,
                            cat_municipio.nombre nombre_municipio,
                            
                            orden_detalle.codigoProducto,
                            orden_detalle.subtotal subtotalDetalle
                            
                            
                     FROM   orden
                                LEFT JOIN cliente
                                    ON  orden.idCliente = cliente.id
                                
                                LEFT JOIN cat_departamento
                                    ON  cliente.idDepartamento = cat_departamento.codIso
                                    
                                LEFT JOIN cat_municipio
                                    ON  cliente.idMunicipio = cat_municipio.codMunicipio
                                    
                                LEFT JOIN orden_detalle
                                    ON  orden.id = orden_detalle.idOrden
                                    
                                    
                     WHERE  orden.idEmpresa = {$this->getIdEmpresa()}         
                     AND    DATE_FORMAT(orden.fechaOrden, '%d/%m/%Y') = DATE_FORMAT(SYSDATE(), '%d/%m/%Y')
                     AND    orden.estadoOrden NOT IN(9) 
                     ";
        $strQuery = "SELECT orden.id,
                            orden.idVendedor,
                            orden.idCliente,
                            orden.fechaOrden,
                            orden.fechaEnvio,
                            orden.subtotal,
                            orden.envio,
                            orden.total,
                            orden.idMensajeria,
                            orden.idTipoPago,
                            orden.idCuenta,
                            orden.numeroGuia,
                            orden.estadoVenta,
                            orden.estadoOrden,
                            
                            CASE WHEN ( orden.fechaEnvio > SYSDATE() ) THEN 'si' ELSE 'no' END editable,
                            
                            cliente.nit,
                            cliente.mail,
                            cliente.telefono,
                            cliente.nombre,
                            cliente.idDepartamento,
                            cliente.idMunicipio,
                            cliente.zona,
                            cliente.direccion,
                            cliente.telefono,
                            
                            cat_departamento.nombre nombre_departamento,
                            cat_municipio.nombre nombre_municipio,
                            
                            orden_detalle.codigoProducto,
                            orden_detalle.subtotal subtotalDetalle
                            
                            
                     FROM   orden
                                LEFT JOIN cliente
                                    ON  orden.idCliente = cliente.id
                                
                                LEFT JOIN cat_departamento
                                    ON  cliente.idDepartamento = cat_departamento.codIso
                                    
                                LEFT JOIN cat_municipio
                                    ON  cliente.idMunicipio = cat_municipio.codMunicipio
                                    
                                LEFT JOIN orden_detalle
                                    ON  orden.id = orden_detalle.idOrden
                                    
                                    
                     WHERE  orden.idEmpresa = {$this->getIdEmpresa()}         
                     AND    DATE_FORMAT(orden.fechaOrden, '%m') = DATE_FORMAT(SYSDATE(), '%m')
                     AND    ( orden.estadoVenta NOT IN(4) OR orden.estadoOrden NOT IN(9) )
                     ";
        $arr = array();
        $qTMP = $this->db->query($strQuery);
        while ($rTMP = $qTMP->fetch_object()) {

            $arr[$rTMP->id]["id"] = $rTMP->id;
            $arr[$rTMP->id]["nombre"] = $rTMP->nombre;
            $arr[$rTMP->id]["telefono"] = $rTMP->telefono;
            $arr[$rTMP->id]["direccion"] = $rTMP->direccion;
            $arr[$rTMP->id]["nombre_departamento"] = $rTMP->nombre_departamento;
            $arr[$rTMP->id]["nombre_municipio"] = $rTMP->nombre_municipio;
            $arr[$rTMP->id]["zona"] = $rTMP->zona;
            $arr[$rTMP->id]["fechaEnvio"] = $rTMP->fechaEnvio;
            $arr[$rTMP->id]["editable"] = $rTMP->editable == "si" ? true : false;
            if (!isset($arr[$rTMP->id]["total"]))
                $arr[$rTMP->id]["total"] = 0;

            $arr[$rTMP->id]["total"] += $rTMP->subtotalDetalle;
        }

        return $arr;
    }

    public function getInfoOrdenDetalle() {

        $strQuery = "SELECT orden_detalle.id,
                            orden_detalle.codigoProducto,
                            orden_detalle.idPrendaArticulo,
                            orden_detalle.idTallaTamano,
                            orden_detalle.idColor,
                            orden_detalle.descripcion,
                            orden_detalle.cantidad,
                            orden_detalle.precio,
                            orden_detalle.subtotal,
                            orden_detalle.estadoVenta,
                            
                            inventario.id idInventario,
                            inventario.idCategoria,
                            inventario.idPrendaArticulo,
                            inventario.idTallaTamano,
                            inventario.idColor,
                            inventario.descripcion
                            
                             FROM   orden_detalle
                                LEFT JOIN inventario ON inventario.codigoProducto = orden_detalle.codigoProducto 
                                AND inventario.idEmpresa = {$this->getIdEmpresa()}
                                WHERE  orden_detalle.idOrden = {$this->getId()} ";


        $qTMP = $this->db->query($strQuery);
        return $qTMP ? $qTMP : false;
    }

    public function updateGuia($intOrden, $strGuia) {

        $strQuery = "UPDATE orden
                     SET    numeroGuia = '{$strGuia}'
                     WHERE  id = {$intOrden}";
        $this->db->query($strQuery);
    }

    public function getIssetRutaOrden() {

        $arrInfoOrden = $this->getInfoOrden();

        $strQuery = "SELECT count(*) contador
                     FROM   ruta,
                            ruta_tarifa   
                     WHERE  ruta.idEmpresa = {$this->getIdEmpresa()}
                     AND    ruta.id = ruta_tarifa.idRuta
                     AND    ruta.codIsoDepartamento = {$arrInfoOrden->idDepartamento}
                     AND    ruta.codIsoMunicipio = {$arrInfoOrden->idMunicipio}
                     AND    ruta.zona = {$arrInfoOrden->zona}
                     ";
        $qTMP = $this->db->query($strQuery);
        $rTMP = $qTMP->fetch_object();

        return isset($rTMP->contador) && intval($rTMP->contador) ? true : false;
    }

    public function setOrdenSinRuta() {

        $strQuery = "UPDATE orden
                     SET    estadoVenta = '3',
                            estadoOrden = '4'
                     WHERE  id = {$this->getId()}";

        $this->db->query($strQuery);
    }

    public function updateObservacion($strObservacion) {

        $strObservacion = trim($strObservacion);

        $strQuery = "UPDATE orden
                     SET    observacion = '{$strObservacion}'
                     WHERE  id = {$this->getId()}";
        $this->db->query($strQuery);
    }

    public function setCaluloTotalOrden() {

        $strQuery = "SELECT SUM( cantidad * precio ) subtotal
                     FROM   orden_detalle
                     WHERE  idOrden = {$this->getId()} ";
        $qTMP = $this->db->query($strQuery);
        $rTMP = $qTMP->fetch_object();

        $sinTotal = $rTMP->subtotal;

        $arrInfoOrden = $this->getInfoOrden();
        $boolAplicaIva = $arrInfoOrden->iva > 0 ? true : false;

        if ($boolAplicaIva) {

            $sinTotal += $sinTotal * ( $arrInfoOrden->iva / 100 );
        }

        $strQuery = "UPDATE orden
                     SET    subtotal = '{$rTMP->subtotal}',
                            total = '{$sinTotal}' 
                     WHERE  id = {$this->getId()} ";
        $this->db->query($strQuery);
    }

    public function getOrdenDevolucion() {

        $strQuery = "SELECT orden.id,
                            orden.estadoOrden,
                            orden.fechaOrden,
                            orden_detalle.devolucion,
                            orden_detalle.codigoProducto,
                            orden_detalle.cantidad,
                            orden_detalle.precio,
                            orden_detalle.subtotal,
                            orden_detalle.iva,
                            cliente.nombre,
                            cliente.telefono
                     FROM   orden_detalle,
                            orden
                                LEFT JOIN cliente
                                    ON cliente.id = orden.idCliente 
                     WHERE  orden_detalle.idOrden = orden.id
                     AND    ( ( orden.estadoOrden = 9 ) OR ( orden_detalle.devolucion = 'Y' ) )
                     ORDER BY orden.fechaDespacho DESC
                     LIMIT 500
                     ";
        $arrDevolucion = array();
        $qTMP = $this->db->query($strQuery);
        while ($rTMP = $qTMP->fetch_object()) {
            $arrDevolucion[$rTMP->id]["idOrden"] = $rTMP->id;
            $arrDevolucion[$rTMP->id]["fechaOrden"] = $rTMP->fechaOrden;
            $arrDevolucion[$rTMP->id]["nombre"] = $rTMP->nombre;
            $arrDevolucion[$rTMP->id]["telefono"] = $rTMP->telefono;
            $arrDevolucion[$rTMP->id]["telefono"] = $rTMP->telefono;

            if (!isset($arrDevolucion[$rTMP->id]["totalDevolucion"]))
                $arrDevolucion[$rTMP->id]["totalDevolucion"] = 0;

            $arrDevolucion[$rTMP->id]["totalDevolucion"] += $rTMP->subtotal;
        }

        return $arrDevolucion;
    }

}
