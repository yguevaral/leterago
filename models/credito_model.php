<?php

class credito_model {

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
    
    function setCredito($intUsuario, $strEstado, $intUsuarioAsesor){
        
        $strQuery = "INSERT INTO sol_credito(id_usuario, estado, fecha_creacion, id_usuario_asesor)
                                  VALUES('{$intUsuario}', '{$strEstado}', GETDATE(), {$intUsuarioAsesor})";
        sqlsrv_query($this->db, $strQuery);
        return utils::getLastPK($this->db);
        
        
    }
    
    function getCreditos($intUsuario){

        $strQuery = "SELECT sol_credito.id_sol_credito,
                            sol_credito.id_usuario,
                            sol_credito.estado,
                            FORMAT (sol_credito.fecha_creacion, 'dd/MM/yyyy, hh:mm:ss ') fecha_creacion,
                            usuario.nombres,
                            usuario.apellidos,
                            usuario.email
                            
                     FROM   sol_credito,
                            usuario
                     WHERE  sol_credito.id_usuario = usuario.id_usuario
                     AND    sol_credito.id_usuario = {$intUsuario}";
                     
        $qTMP = sqlsrv_query($this->db, $strQuery);
        $arr = array();
        while( $rTMP = sqlsrv_fetch_array($qTMP, SQLSRV_FETCH_ASSOC) ){
            
            $arr[$rTMP["id_sol_credito"]] = $rTMP;
                        
        }
        sqlsrv_free_stmt($qTMP);

        return $arr;

    }
    
    function getCreditosAdmin($strFiltroPais = "", $strFiltroAsesor = "", $strFiltroEstadoCredito = ""){
        
        
        if( !empty($strFiltroPais) ){
            
            $strFiltroPais = " AND usuario_pais.id_pais IN({$strFiltroPais}) ";
            
        }
        
        if( !empty($strFiltroAsesor) ){
            
            $strFiltroAsesor = " AND sol_credito.id_usuario_asesor IN({$strFiltroAsesor}) ";
            
        }
        
        if( !empty($strFiltroEstadoCredito) ){
            
            $strFiltroEstadoCredito = " AND sol_credito.estado IN({$strFiltroEstadoCredito}) ";
            
        }
        

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
                     {$strFiltroPais}
                     {$strFiltroAsesor}
                     {$strFiltroEstadoCredito}
                     ";
                     
        $qTMP = sqlsrv_query($this->db, $strQuery);
        $arr = array();
        while( $rTMP = sqlsrv_fetch_array($qTMP, SQLSRV_FETCH_ASSOC) ){
            
            $arr[$rTMP["id_sol_credito"]] = $rTMP;
                        
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
    
    function getSolCreditoCliente($intIdUsuario, $intSolCredito = 0 ){
        
        $intSolCredito = intval($intSolCredito);
        $strFiltro = $intSolCredito ? " AND sol_credito.id_sol_credito = {$intSolCredito} " : "";
        $strFiltro2 = !$intSolCredito ? " AND sol_credito.id_usuario = {$intIdUsuario}  " : "";

        $strQuery = "SELECT sol_credito.id_sol_credito,
                            sol_credito.id_usuario,
                            sol_credito.id_usuario_asesor,
                            sol_credito.estado,
                            sol_credito.nota_rechazo,
                            FORMAT (sol_credito.fecha_creacion, 'dd/MM/yyyy, hh:mm:ss ') fecha_creacion,
                            usuario.nombres,
                            usuario.apellidos,
                            usuario.email
                            
                     FROM   sol_credito,
                            usuario
                     WHERE  1 = 1
                     {$strFiltro2}
                     AND    sol_credito.id_usuario = usuario.id_usuario
                     {$strFiltro}
                     ORDER BY id_sol_credito DESC
                     ";
        $qTMP = sqlsrv_query($this->db, $strQuery);
        $arr = array();
        while( $rTMP = sqlsrv_fetch_array($qTMP, SQLSRV_FETCH_ASSOC) ){
            
            $arr[$rTMP["id_sol_credito"]] = $rTMP;
                        
        }
        sqlsrv_free_stmt($qTMP);

        return $arr;

    }
    
    function getSolCreditoClienteKey($intSolCredito){
        
        $intSolCredito = intval($intSolCredito);

        $strQuery = "SELECT sol_credito.id_sol_credito,
                            sol_credito.id_usuario,
                            sol_credito.id_usuario_asesor,
                            sol_credito.estado,
                            FORMAT (sol_credito.fecha_creacion, 'dd/MM/yyyy, hh:mm:ss ') fecha_creacion,
                            usuario.nombres,
                            usuario.apellidos,
                            usuario.email
                            
                     FROM   sol_credito,
                            usuario
                     WHERE  sol_credito.id_sol_credito = {$intSolCredito} 
                     AND    sol_credito.id_usuario = usuario.id_usuario
                     ORDER BY id_sol_credito DESC
                     ";
                     
        $qTMP = sqlsrv_query($this->db, $strQuery);
        $arr = array();
        while( $rTMP = sqlsrv_fetch_array($qTMP, SQLSRV_FETCH_ASSOC) ){
            
            $arr[$rTMP["id_sol_credito"]] = $rTMP;
                        
        }
        sqlsrv_free_stmt($qTMP);

        return $arr;

    }
    
    function setInsertSolCreditoDato($intSolCredito, $strLlave, $strValor, $intBloque){
        
        $strQuery = "INSERT INTO sol_credito_dato(id_sol_credito, llave_input, valor_input, bloque, fecha_mod, fecha_cre)
                                           VALUES('{$intSolCredito}', '{$strLlave}', '{$strValor}', {$intBloque}, GETDATE(), GETDATE() )";
        sqlsrv_query($this->db, $strQuery);
        return utils::getLastPK($this->db);
            
    }
    
    function setUpdateSolCreditoDato($intSolCreditoDato, $strValor){
        
        $strQuery = "UPDATE sol_credito_dato
                     SET    valor_input = '{$strValor}',    
                            fecha_mod = GETDATE() 
                     WHERE  id_sol_credito_dato = {$intSolCreditoDato}";
        sqlsrv_query($this->db, $strQuery);
            
    }
    
    function setDeleteSolCreditoDato($intSolCredito, $strllave){
        
        $strQuery = "DELETE FROM  sol_credito_dato WHERE id_sol_credito = {$intSolCredito} AND llave_input = '{$strllave}'";
        sqlsrv_query($this->db, $strQuery);
            
    }
    
    function setUpdateSolCreditoEstado($intSolCredito, $strEstado){
        
        $strQuery = "UPDATE sol_credito
                     SET    estado = '{$strEstado}'
                     WHERE  id_sol_credito = {$intSolCredito}";
        sqlsrv_query($this->db, $strQuery);
            
    }
    
    function setUpdateSolCreditoEstadoNotaRechazo($intSolCredito, $strNotaRechazo){
        
        $strQuery = "UPDATE sol_credito
                     SET    nota_rechazo = '{$strNotaRechazo}'
                     WHERE  id_sol_credito = {$intSolCredito}";
        sqlsrv_query($this->db, $strQuery);
            
    }
    
    function getSolCreditoDato($intSolCredito){
            
        $strQuery = "SELECT *
                     FROM   sol_credito_dato
                     WHERE  id_sol_credito = {$intSolCredito}";
                     
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

