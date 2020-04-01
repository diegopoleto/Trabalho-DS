<?php

    require_once("Models/BD.php");
    $bd = new BD;
    $bd->initializeBD();
    //$bd->dropAndInitializeBD();
    
    require_once("routes.php");
?>
