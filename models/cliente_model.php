<?php

class cliente_model {

    private $db;

    function __construct() {
        $this->db = Database::connect();
    }
    
    function fntSetUsuario($strNombre, $strApellido, $strSexo, $strEmail, $strClave, $strTipo, $strEstado){
        
        $strQuery = "INSERT INTO usuario(nombres, apellidos, sexo, email, 
                                         clave, estado, tipo)
                                  VALUES('{$strNombre}', '{$strApellido}', '{$strSexo}', '{$strEmail}',
                                         CONVERT(NVARCHAR(32),HashBytes('MD5', '{$strClave}'),2) , '{$strEstado}', '{$strTipo}')";
        sqlsrv_query($this->db, $strQuery);
        return utils::getLastPK($this->db);
        
    }
    
    function setCliente($intUsuario, $strEstado, $intUsuarioAsesor, $strClientePotencial = 'N'){
        
        $strQuery = "INSERT INTO cliente(id_usuario, estado, fecha_creacion, id_usuario_asesor, cliente_potencial)
                                  VALUES('{$intUsuario}', '{$strEstado}', GETDATE(), {$intUsuarioAsesor}, '{$strClientePotencial}')";
        sqlsrv_query($this->db, $strQuery);
        return utils::getLastPK($this->db);
        
        
    }
    
    function getClientes($intUsuario){

        $strQuery = "SELECT cliente.id_cliente,
                            cliente.id_usuario,
                            cliente.estado,
                            FORMAT (cliente.fecha_creacion, 'dd/MM/yyyy, hh:mm:ss ') fecha_creacion,
                            usuario.nombres,
                            usuario.apellidos,
                            usuario.email,
                            cliente_dato.valor_input nombre_empresa
                            
                     FROM   cliente
                                LEFT JOIN cliente_dato
                                    ON  cliente_dato.id_cliente = cliente.id_cliente
                                    AND cliente_dato.llave_input = 'NOMBRE_COMERCIAL',
                            usuario
                     WHERE  cliente.id_usuario = usuario.id_usuario
                     AND    cliente.id_usuario = {$intUsuario}";
                     
        $qTMP = sqlsrv_query($this->db, $strQuery);
        $arr = array();
        while( $rTMP = sqlsrv_fetch_array($qTMP, SQLSRV_FETCH_ASSOC) ){
            
            $arr[$rTMP["id_cliente"]] = $rTMP;
                        
        }
        sqlsrv_free_stmt($qTMP);

        return $arr;

    }
    
    function getCreditosAdmin($strFiltroPais = "", $strFiltroAsesor = "", $strFiltroEstadoCredito = ""){
        
        
        if( !empty($strFiltroPais) ){
            
            $strFiltroPais = " AND usuario_pais.id_pais IN({$strFiltroPais}) ";
            
        }
        
        if( !empty($strFiltroAsesor) ){
            
            $strFiltroAsesor = " AND cliente.id_usuario_asesor IN({$strFiltroAsesor}) ";
            
        }
        
        if( !empty($strFiltroEstadoCredito) ){
            
            $strFiltroEstadoCredito = " AND cliente.estado IN({$strFiltroEstadoCredito}) ";
            
        }
        

        $strQuery = "SELECT cliente.id_cliente,
                            cliente.id_usuario,
                            cliente.estado,
                            FORMAT (cliente.fecha_creacion, 'dd/MM/yyyy, hh:mm:ss ') fecha_creacion,
                            usuario.nombres,
                            usuario.apellidos,
                            usuario.email,
                            
                            usuario_asesor.nombres nombres_asesor,
                            usuario_asesor.apellidos apellidos_asesor,
                            
                            cliente_dato.valor_input nombre_empresa
                            
                     FROM   cliente
                                LEFT JOIN cliente_dato
                                    ON  cliente_dato.id_cliente = cliente.id_cliente
                                    AND cliente_dato.llave_input = 'NOMBRE_COMERCIAL',
                            usuario usuario_asesor,
                            usuario
                                LEFT JOIN usuario_pais  
                                    ON  usuario_pais.id_usuario = usuario.id_usuario
                     WHERE  cliente.id_usuario = usuario.id_usuario
                     AND    usuario_asesor.id_usuario = cliente.id_usuario_asesor
                     {$strFiltroPais}
                     {$strFiltroAsesor}
                     {$strFiltroEstadoCredito}
                     ";
                     
        $qTMP = sqlsrv_query($this->db, $strQuery);
        $arr = array();
        while( $rTMP = sqlsrv_fetch_array($qTMP, SQLSRV_FETCH_ASSOC) ){
            
            $arr[$rTMP["id_cliente"]] = $rTMP;
                        
        }
        sqlsrv_free_stmt($qTMP);

        return $arr;

    }
    
    function getCreditosAsesor($intUsuario, $strFiltroEstadoCredito = ""){
        
        
        $strQuery = "SELECT sol_credito.id_sol_credito,
                            sol_credito.id_usuario,
                            sol_credito.estado,
                            FORMAT (sol_credito.fecha_creacion, 'dd/MM/yyyy, hh:mm:ss ') fecha_creacion,
                            usuario.nombres,
                            usuario.apellidos,
                            usuario.email,
                            
                            usuario_asesor.nombres nombres_asesor,
                            usuario_asesor.apellidos apellidos_asesor
                            
                     FROM   sol_credito,
                            usuario usuario_asesor,
                            usuario
                                LEFT JOIN usuario_pais  
                                    ON  usuario_pais.id_usuario = usuario.id_usuario
                     WHERE  sol_credito.id_usuario = usuario.id_usuario
                     AND    usuario_asesor.id_usuario = sol_credito.id_usuario_asesor
                     AND    sol_credito.id_usuario_asesor = {$intUsuario}
                     ";
                     
        $qTMP = sqlsrv_query($this->db, $strQuery);
        $arr = array();
        while( $rTMP = sqlsrv_fetch_array($qTMP, SQLSRV_FETCH_ASSOC) ){
            
            $arr[$rTMP["id_sol_credito"]] = $rTMP;
                        
        }
        sqlsrv_free_stmt($qTMP);

        return $arr;

    }
    
    function getCreditosCliente($intIdUsuario){
        
        $intIdUsuario = intval($intIdUsuario);

        $strQuery = "SELECT sol_credito.id_sol_credito,
                            sol_credito.id_usuario,
                            sol_credito.estado,
                            FORMAT (sol_credito.fecha_creacion, 'dd/MM/yyyy, hh:mm:ss ') fecha_creacion,
                            usuario.nombres,
                            usuario.apellidos,
                            usuario.email
                            
                     FROM   sol_credito,
                            usuario
                     WHERE  sol_credito.id_usuario = {$intIdUsuario}
                     AND    sol_credito.id_usuario = usuario.id_usuario";
                     
        $qTMP = sqlsrv_query($this->db, $strQuery);
        $arr = array();
        while( $rTMP = sqlsrv_fetch_array($qTMP, SQLSRV_FETCH_ASSOC) ){
            
            $arr[$rTMP["id_sol_credito"]] = $rTMP;
                        
        }
        sqlsrv_free_stmt($qTMP);

        return $arr;

    }
    
    function getCliente($intIdUsuario, $intSolCredito = 0 ){
        
        $intSolCredito = intval($intSolCredito);
        $strFiltro = $intSolCredito ? " AND cliente.id_cliente = {$intSolCredito} " : "";
        $strFiltro2 = !$intSolCredito ? " AND cliente.id_usuario = {$intIdUsuario}  " : "";

        $strQuery = "SELECT cliente.id_cliente,
                            cliente.id_usuario,
                            cliente.id_usuario_asesor,
                            cliente.estado,
                            cliente.cliente_potencial,
                            cliente.nota_rechazo,
                            FORMAT (cliente.fecha_creacion, 'dd/MM/yyyy, hh:mm:ss ') fecha_creacion,
                            usuario.nombres,
                            usuario.apellidos,
                            usuario.email
                            
                     FROM   cliente,
                            usuario
                     WHERE  1 = 1
                     {$strFiltro2}
                     AND    cliente.id_usuario = usuario.id_usuario
                     {$strFiltro}
                     ORDER BY id_cliente DESC
                     ";
        $qTMP = sqlsrv_query($this->db, $strQuery);
        $arr = array();
        while( $rTMP = sqlsrv_fetch_array($qTMP, SQLSRV_FETCH_ASSOC) ){
            
            $arr[$rTMP["id_cliente"]] = $rTMP;
                        
        }
        sqlsrv_free_stmt($qTMP);

        return $arr;

    }
    
    function getSolCreditoClienteKey($intSolCredito){
        
        $intSolCredito = intval($intSolCredito);

        $strQuery = "SELECT cliente.id_cliente,
                            cliente.id_usuario,
                            cliente.id_usuario_asesor,
                            cliente.estado,
                            FORMAT (cliente.fecha_creacion, 'dd/MM/yyyy, hh:mm:ss ') fecha_creacion,
                            usuario.nombres,
                            usuario.apellidos,
                            usuario.email
                            
                     FROM   cliente,
                            usuario
                     WHERE  cliente.id_cliente = {$intSolCredito} 
                     AND    cliente.id_usuario = usuario.id_usuario
                     ORDER BY id_cliente DESC
                     ";
                     
        $qTMP = sqlsrv_query($this->db, $strQuery);
        $arr = array();
        while( $rTMP = sqlsrv_fetch_array($qTMP, SQLSRV_FETCH_ASSOC) ){
            
            $arr[$rTMP["id_cliente"]] = $rTMP;
                        
        }
        sqlsrv_free_stmt($qTMP);

        return $arr;

    }
    
    function setInsertSolCreditoDato($intCliente, $strLlave, $strValor, $intBloque){
        
        $strQuery = "INSERT INTO cliente_dato(id_cliente, llave_input, valor_input, bloque, fecha_mod, fecha_cre)
                                           VALUES('{$intCliente}', '{$strLlave}', '{$strValor}', {$intBloque}, GETDATE(), GETDATE() )";
        sqlsrv_query($this->db, $strQuery);
        return utils::getLastPK($this->db);
            
    }
    
    function setUpdateSolCreditoDato($intSolCreditoDato, $strValor){
        
        $strQuery = "UPDATE cliente_dato
                     SET    valor_input = '{$strValor}',    
                            fecha_mod = GETDATE() 
                     WHERE  id_cliente_dato = {$intSolCreditoDato}";
        sqlsrv_query($this->db, $strQuery);
            
    }
    
    function setDeleteSolCreditoDato($intSolCredito, $strllave){
        
        $strQuery = "DELETE FROM  cliente_dato WHERE id_cliente_dato = {$intSolCredito} AND llave_input = '{$strllave}'";
        sqlsrv_query($this->db, $strQuery);
            
    }
    
    function setUpdateSolCreditoEstado($intSolCredito, $strEstado){
        
        $strQuery = "UPDATE cliente
                     SET    estado = '{$strEstado}'
                     WHERE  id_cliente = {$intSolCredito}";
        sqlsrv_query($this->db, $strQuery);
            
    }
    
    function setUpdateSolCreditoEstadoNotaRechazo($intSolCredito, $strNotaRechazo){
        
        $strQuery = "UPDATE sol_credito
                     SET    nota_rechazo = '{$strNotaRechazo}'
                     WHERE  id_sol_credito = {$intSolCredito}";
        sqlsrv_query($this->db, $strQuery);
            
    }
    
    function getClienteDato($intCliente){
            
        $strQuery = "SELECT *
                     FROM   cliente_dato
                     WHERE  id_cliente = {$intCliente}";
                     
        $qTMP = sqlsrv_query($this->db, $strQuery);
        $arr = array();
        while( $rTMP = sqlsrv_fetch_array($qTMP, SQLSRV_FETCH_ASSOC) ){
            
            $arr[$rTMP["llave_input"]] = $rTMP;
                        
        }
        sqlsrv_free_stmt($qTMP);

        return $arr;
        
    }
    
    function getUsuarioPais($intUsuario){

        $strQuery = "SELECT id_pais
                     FROM   usuario_pais
                     WHERE  id_usuario = {$intUsuario} ";
                     
        $qTMP = sqlsrv_query($this->db, $strQuery);
        $arr = array();
        while( $rTMP = sqlsrv_fetch_array($qTMP, SQLSRV_FETCH_ASSOC) ){
            
            $arr[$rTMP["id_pais"]] = $rTMP;
            $intPais = $rTMP["id_pais"];
                        
        }
        sqlsrv_free_stmt($qTMP);

        return $intPais;

    }
    
    function getPais(){

        $strQuery = "SELECT *
                     FROM   pais
                     WHERE  activo = 'Y'
                     ORDER BY nombre ASC";
                     
        $qTMP = sqlsrv_query($this->db, $strQuery);
        $arr = array();
        while( $rTMP = sqlsrv_fetch_array($qTMP, SQLSRV_FETCH_ASSOC) ){
            
            $arr[$rTMP["id_pais"]] = $rTMP;
                        
        }
        sqlsrv_free_stmt($qTMP);

        return $arr;

    }
    
    function getEstado($intPais){

        $strQuery = "SELECT *
                     FROM   estado
                     WHERE  id_pais = {$intPais}
                     ORDER BY nombre ASC";
        $qTMP = sqlsrv_query($this->db, $strQuery);
        $arr = array();
        while( $rTMP = sqlsrv_fetch_array($qTMP, SQLSRV_FETCH_ASSOC) ){
            
            $arr[$rTMP["id_estado"]] = $rTMP;
                        
        }
        sqlsrv_free_stmt($qTMP);

        return $arr;

    }
    
    function getCiudad($intDepartamento){

        $strQuery = "SELECT *
                     FROM   ciudad
                     WHERE  id_estado = {$intDepartamento}
                     ORDER BY nombre ASC";
                     
        $qTMP = sqlsrv_query($this->db, $strQuery);
        $arr = array();
        while( $rTMP = sqlsrv_fetch_array($qTMP, SQLSRV_FETCH_ASSOC) ){
            
            $arr[$rTMP["id_ciudad"]] = $rTMP;
                        
        }
        sqlsrv_free_stmt($qTMP);

        return $arr;

    }
    
    function getAsesorUsuario(){

        $strQuery = "SELECT *
                     FROM   usuario
                     WHERE  tipo = 'AS'
                     ORDER BY id_usuario DESC";
                     
        $qTMP = sqlsrv_query($this->db, $strQuery);
        $arr = array();
        while( $rTMP = sqlsrv_fetch_array($qTMP, SQLSRV_FETCH_ASSOC) ){
            
            $arr[$rTMP["id_usuario"]] = $rTMP;
                        
        }
        sqlsrv_free_stmt($qTMP);

        return $arr;

    }
    
}
?>

