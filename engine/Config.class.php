<?php
class Config{
  public function __construct(){
	if(file_exists("../config_server.php")){
		require_once "../config_server.php";
		$this->show_error = true;
		//--------- banco de dados
		$this->db_host = $config_db_host;
		$this->db_user = $config_db_user;
		$this->db_password = $config_db_password;
		$this->db_name = $config_db_name;
		return;
	 }
	 else{
		$this->show_error = true;
		//--------- banco de dados
		$this->db_host = "localhost";
		$this->db_user = "root";
		$this->db_password = "";
		$this->db_name = "cubeblack";
	 }
	 $this->show_error = true;
    //--------- Error
		if($this->show_error){
			ini_set('display_errors',1);
			ini_set('display_startup_erros',1);
			error_reporting(E_ALL);
		}
			
  }
	public function auto(){
		global $db,$config;
		$sql = file_get_contents("engine/db.sql");
		$db->query($sql);
		if($db->errorInfo()[1] != null){
			if($config->show_error){
				return "Mysql Erro ".$db->errorInfo()[1] . ":". $db->errorInfo()[2];
			}
			return "fail";
		}
		return "ok";

	}
	public function help(){
		return <<<'EOT'
>> class Config(config)
.show_error - Bool - caso verdadeiro, os erros são exibidos
.db_host
.db_user
.db_password
.db_name

.auto() - reconfigura o banco de dados msql executando o o script db.sql
EOT;
	}
}
