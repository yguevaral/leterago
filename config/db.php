<?php

class Database {
          
    public function connect() {
        /*
        $db = new mysqli('localhost', 'root', '', 'imfutbol_salesys');
        # $db = new mysqli('68.66.226.79', 'imfutbol_salesysadmin', 'S@l35y5@dmin', 'imfutbol_salesys');
        $db->query("SET NAMES 'utf8'");

        return $db;
        */
        
        $serverName = "localhost"; //serverName\instanceName

        // Puesto que no se han especificado UID ni PWD en el array  $connectionInfo,
        // La conexión se intentará utilizando la autenticación Windows.
        $connectionInfo = array( "Database"=>"portal_leterago", "CharacterSet" => "UTF-8");
        $conn = sqlsrv_connect( $serverName, $connectionInfo);

        if( $conn ) {
             //echo "Conexión establecida.<br />";
        }else{
             echo "Conexión no se pudo establecer.<br />";
             die( print_r( sqlsrv_errors(), true));
        }
        
        //$this->setConDb($conn);
        return $conn;
        
    }
         

}
