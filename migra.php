<?php

require_once 'config/db.php';
$objDB = Database::connect();
    
$strQuery = "SELECT *
             FROM   inventario
             WHERE  url_imagen != ''      
             ";
$arr = array();
$qTMP = $objDB->query($strQuery);
while( $rTMP = $qTMP->fetch_object() ){
    
    $arr["id"] = $rTMP->id;
    $strQuery = "INSERT INTO inventario_multimedia(id_inventario, tipo, url, nombre, orden)
                                            VALUES( {$rTMP->id}, 'i', '{$rTMP->url_imagen}', 'I', 1 )";
    $objDB->query($strQuery);
    
}
?>