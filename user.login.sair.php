<?php
	require_once"server.php";
	$str_retorno = $_REQUEST["return"];
	header("location:$str_retorno");
	