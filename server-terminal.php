<?php    
	//header('Content-Type: text/javascript; charset=utf8');
    header('Access-Control-Allow-Origin:*');
    header('Access-Control-Max-Age: 3628800');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
	header('Content-type: text/plain');

	
	require_once("server.php");

	if(!isset($_REQUEST["comander"])){
		echo "_REQUEST[comander] not fainded";
		goto fim;
	}
	$comStr = $_REQUEST["comander"];
	if($comStr == ""){
		echo "-------------  Cloto Server  ------------- \n";
		echo "Bem vindo {$user->nick}!\n";
		echo "help, Para obter ajuda";
		goto fim;
	}
	$term->chamada($comStr);
	fim:
