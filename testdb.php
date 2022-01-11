<?php


// PHP Data Objects(PDO) Sample Code:
/*
try {
    $conn = new PDO("sqlsrv:server = tcp:mpap018usa1.database.windows.net,1433; Database = bdportalcreditos", "sysadmindb", "portalcreditos2021!");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    print("Error connecting to SQL Server.");
    die(print_r($e));
}
*/
// SQL Server Extension Sample Code:
$connectionInfo = array("UID" => "sysadmindb", "pwd" => "portalcreditos2021!", "Database" => "bdportalcreditos", "LoginTimeout" => 60, "Encrypt" => 1, "TrustServerCertificate" => 0);
$serverName = "tcp:mpap018usa1.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);

if( $conn ) {
     echo "Conexión establecida.<br />";
}else{
     echo "Conexión no se pudo establecer.<br />";
     print "<pre>";
     print_r( sqlsrv_errors());
     print "</pre>";
     die();
}

/*
//$serverName = "localhost"; //serverName\instanceName
$serverName = "mpap018usa1.database.windows.net"; //serverName\instanceName

// Puesto que no se han especificado UID ni PWD en el array  $connectionInfo,
// La conexión se intentará utilizando la autenticación Windows.
//$connectionInfo = array( "Database"=>"portal_leterago", "CharacterSet" => "UTF-8");
$connectionInfo = array( 
                    "Database"=>"dbportalcreditos", 
                    "UID"=>"sysadmindb", 
                    "PWD"=>'portalcreditos2021!', 
                    //"Authentication"=>'SqlPassword',
                    //"CharacterSet" => "UTF-8"
                    ); 

print "<pre>";
print_r($serverName);                   
print "</pre>";
print "<pre>";
print_r($connectionInfo);                   
print "</pre>";
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
     echo "Conexión establecida.<br />";
}else{
     echo "Conexión no se pudo establecer.<br />";
     print "<pre>";
     print_r( sqlsrv_errors());
     print "</pre>";
     die();
}   
*/
?>