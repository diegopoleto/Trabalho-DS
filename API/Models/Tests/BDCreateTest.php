<?php

	require_once("BD.php");

	$bd = new BD;
	$bd->dropDatabase();
	$bd->createBDIfNotExists();
	$bd->createTables();

?>