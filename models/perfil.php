<?php

class perfil_model {

    private $db;

    function __construct() {
        $this->db = Database::connect();
    }
    
    function getPerfil($intPerfil){

        $strQuery = "SELECT *
                     FROM   perfil
                     WHERE  id_perfil = {$intPerfil}  ";
                     
        $qTMP = sqlsrv_query($this->db, $strQuery);
        
        #Fetching Data by array
        $rTMP = sqlsrv_fetch_array($qTMP, SQLSRV_FETCH_ASSOC);
        sqlsrv_free_stmt($qTMP);

        return $rTMP;

    }    
    
    function getPerfilAcceso($intPerfil){

        $strQuery = "SELECT acceso,
                            acceso_accion
                     FROM   perfil_acceso
                     WHERE  id_perfil = {$intPerfil} ";
                     
        $qTMP = sqlsrv_query($this->db, $strQuery);
        $arr = array();
        while( $rTMP = sqlsrv_fetch_array($qTMP, SQLSRV_FETCH_ASSOC) ){
            
            $arr[$rTMP["acceso"]] = $rTMP;
                        
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
    
    function fntSetPerfil($strNombrePerfil, $strEstado){
        
        $strQuery = "INSERT INTO perfil(nombre, estado)
                                  VALUES('{$strNombrePerfil}', '{$strEstado}')";
        sqlsrv_query($this->db, $strQuery);
        return utils::getLastPK($this->db);
        
        
    }
    
    function fntSetUpdatePerfil($intPerfil, $strNombrePerfil, $strEstado){
        
        $strQuery = "UPDATE perfil
                     SET    nombre = '{$strNombrePerfil}',
                            estado = '{$strEstado}'
                     WHERE  id_perfil = {$intPerfil} ";
        sqlsrv_query($this->db, $strQuery);
        
    }
    
    function deletePerfilAcceso($intPerfil){
        
        $strQuery = "DELETE FROM perfil_acceso WHERE id_perfil = {$intPerfil} ";
        sqlsrv_query($this->db, $strQuery);    
    }
    
    function setPerfilAcceso($intPerfil, $strAcceso){
        
        $strQuery = "INSERT INTO perfil_acceso(id_perfil, acceso, acceso_accion)
                                  VALUES('{$intPerfil}', '{$strAcceso}', 'T' )";
        sqlsrv_query($this->db, $strQuery);
        
    }

}
?>

