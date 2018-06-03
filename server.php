<?php
function __autoload($className){
  $url = "engine/$className.class.php";
  require_once $url;
}
// variaveis globais
$config = new Config();
$dbl = new DBLocal();
$user = new User();
$dado = new Dado();

try {
	$db = new PDO("mysql:host={$config->db_host};dbname={$config->db_name}", $config->db_user, $config->db_password);
	
} catch (PDOException $e) {
	echo "Error!: " . $e->getMessage() . "\n";
}




$help = "
_________________________
* help
* Config: Configurações do sistema
* User: usario
* dado:
* db:

obs.: Para obter ajuda de um objeto especifico, basta digitar a função padrão 'help'. Por exemplo 'user.help()'.
_________________________
";
//array com asas variaveis que poderam ser acesadas pelo terminal
//por enquanto sem restrição de usuario
$vars = array("config","user","dado","db","dbl","help");
$term = New Terminal($vars);
