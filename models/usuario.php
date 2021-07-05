<?php

class usuario {

    private $db;

    function __construct() {
        $this->db = Database::connect();
    }

    function fntGetLogIn($strEmail, $strClave){

        $strQuery = "SELECT *
                     FROM   usuario
                     WHERE  email = '{$strEmail}'
                     AND    clave = CONVERT(NVARCHAR(32),HashBytes('MD5', '{$strClave}'),2)  ";
                     
        $qTMP = sqlsrv_query($this->db, $strQuery);
        
        #Fetching Data by array
        $rTMP = sqlsrv_fetch_array($qTMP, SQLSRV_FETCH_ASSOC);
        sqlsrv_free_stmt($qTMP);

        return $rTMP;

    }
    
    function getUsuario(){

        $strQuery = "SELECT *
                     FROM   usuario
                     ORDER BY id_usuario DESC";
                     
        $qTMP = sqlsrv_query($this->db, $strQuery);
        $arr = array();
        while( $rTMP = sqlsrv_fetch_array($qTMP, SQLSRV_FETCH_ASSOC) ){
            
            $arr[$rTMP["id_usuario"]] = $rTMP;
                        
        }
        sqlsrv_free_stmt($qTMP);

        return $arr;

    }
    
    function fntSetUsuario($strNombre, $strApellido, $strSexo, $strEmail, $strClave, $strTipo, $strEstado){
        
        $strQuery = "INSERT INTO usuario(nombres, apellidos, sexo, email, 
                                         clave, estado, tipo)
                                  VALUES('{$strNombre}', '{$strApellido}', '{$strSexo}', '{$strEmail}',
                                         CONVERT(NVARCHAR(32),HashBytes('MD5', '{$strClave}'),2) , '{$strEstado}', '{$strTipo}')";
        sqlsrv_query($this->db, $strQuery);
        return utils::getLastPK($this->db);
        
    }
    
    function fntSetUpdateUsuario($intUsuario, $strNombre, $strApellido, $strSexo, $strEmail, $strClave, $strTipo, $strEstado){
        
        $strQuery = "UPDATE usuario
                     SET    nombres = '{$strNombre}',
                            apellidos = '{$strApellido}',
                            sexo = '{$strSexo}',
                            email = '{$strEmail}',
                            ". ( !empty($strClave) ? " clave = CONVERT(NVARCHAR(32),HashBytes('MD5', '{$strClave}'),2) , " : "" ) ." 
                            estado = '{$strEstado}',
                            tipo = '{$strTipo}'
                     WHERE  id_usuario = {$intUsuario} ";
        sqlsrv_query($this->db, $strQuery);
        
    }
    
    function setEliminarUsuario($intUsuario){
        
        $strQuery = "UPDATE usuario
                     SET    estado = 'EL'
                     WHERE  id_usuario = {$intUsuario} ";
        sqlsrv_query($this->db, $strQuery);
        
    }
    
    function fntGetUsuario($intUsuario){

        $strQuery = "SELECT *
                     FROM   usuario
                     WHERE  id_usuario = {$intUsuario}  ";
                     
        $qTMP = sqlsrv_query($this->db, $strQuery);
        
        #Fetching Data by array
        $rTMP = sqlsrv_fetch_array($qTMP, SQLSRV_FETCH_ASSOC);
        sqlsrv_free_stmt($qTMP);

        return $rTMP;

    }
    
    function getPais(){

        $strQuery = "SELECT *
                     FROM   pais
                     WHERE  activo = 'Y'
                     ORDER BY id_pais DESC";
                     
        $qTMP = sqlsrv_query($this->db, $strQuery);
        $arr = array();
        while( $rTMP = sqlsrv_fetch_array($qTMP, SQLSRV_FETCH_ASSOC) ){
            
            $arr[$rTMP["id_pais"]] = $rTMP;
                        
        }
        sqlsrv_free_stmt($qTMP);

        return $arr;

    }
    
    function deleteUsuarioPais($intUsuario){
        
        $strQuery = "DELETE FROM usuario_pais WHERE  id_usuario = {$intUsuario} ";
        sqlsrv_query($this->db, $strQuery);    
    }
    
    function setUsuarioPais($intUsuario, $intPais){
        
        $strQuery = "INSERT INTO usuario_pais(id_usuario, id_pais)
                                  VALUES('{$intUsuario}', '{$intPais}' )";
        sqlsrv_query($this->db, $strQuery);
        
    }
    
    function getUsuarioPais($intUsuario){

        $strQuery = "SELECT id_pais
                     FROM   usuario_pais
                     WHERE  id_usuario = {$intUsuario} ";
                     
        $qTMP = sqlsrv_query($this->db, $strQuery);
        $arr = array();
        while( $rTMP = sqlsrv_fetch_array($qTMP, SQLSRV_FETCH_ASSOC) ){
            
            $arr[$rTMP["id_pais"]] = $rTMP;
                        
        }
        sqlsrv_free_stmt($qTMP);

        return $arr;

    }
    
    function getPerfiles(){

        $strQuery = "SELECT *
                     FROM   perfil";
                     
        $qTMP = sqlsrv_query($this->db, $strQuery);
        $arr = array();
        while( $rTMP = sqlsrv_fetch_array($qTMP, SQLSRV_FETCH_ASSOC) ){
            
            $arr[$rTMP["id_perfil"]] = $rTMP;
                        
        }
        sqlsrv_free_stmt($qTMP);

        return $arr;

    }
    
    function getUsuarioPerfil($intUsuario){

        $strQuery = "SELECT id_perfil
                     FROM   usuario_perfil
                     WHERE  id_usuario = {$intUsuario} ";
                     
        $qTMP = sqlsrv_query($this->db, $strQuery);
        $arr = array();
        while( $rTMP = sqlsrv_fetch_array($qTMP, SQLSRV_FETCH_ASSOC) ){
            
            $arr[$rTMP["id_perfil"]] = $rTMP;
                        
        }
        sqlsrv_free_stmt($qTMP);

        return $arr;

    }
    
    function deleteUsuarioPerfil($intUsuario){
        
        $strQuery = "DELETE FROM usuario_perfil WHERE  id_usuario = {$intUsuario} ";
        sqlsrv_query($this->db, $strQuery);    
    }
    
    function setUsuarioPerfil($intUsuario, $intPerfil){
        
        $strQuery = "INSERT INTO usuario_perfil(id_usuario, id_perfil)
                                  VALUES('{$intUsuario}', '{$intPerfil}' )";
        sqlsrv_query($this->db, $strQuery);
        
    }
    
    function setClienteISP($intUsuario){

        $strQuery = "UPDATE cliente
                     SET    estado = 'ISC'
                     WHERE  id_usuario = {$intUsuario}
                     AND    estado = 'ISP' ";
                     
        sqlsrv_query($this->db, $strQuery);

    }
    
    

}
