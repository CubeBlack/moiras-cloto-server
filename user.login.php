<?php
	require_once"server.php";
	$str_user = $_REQUEST["user"];
	$str_pass = $_REQUEST["pass"];
	$str_retorno = $_REQUEST["return"];
	$user->login($str_user,$str_pass);
	var_dump($user);
	header("location:$str_retorno");
	