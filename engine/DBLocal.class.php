<?php
/**
 * erro ocacionado ao acessar em hppt: nao salva, mas roda de boa em https
 */
 //
class DBLocal
{
public $data;
  function __construct()
  {
	
    global $config;
    if(!isset($_SESSION))
      session_start("moiras-cloto-dblocal");
	if(!isset($_SESSION["m-cloto"]))
		$this->clear();
	$this->data = $_SESSION["m-cloto"];
  }
	public function set($index,$valor){
		$a = $_SESSION["m-cloto"];
		$a[$index] = $valor;
		$_SESSION["m-cloto"] = $a;
		return "ok";
	}
	public function set2($index,$valor){
		$a = $_SESSION["m-cloto"];
		$a[$index] = $valor;
		$_SESSION["m-cloto"] = $a;
		return "ok";
	}
	public function get($index=""){
		if($index == ""){
			return $_SESSION["m-cloto"];
		}
		if(isset($_SESSION["m-cloto"][$index]))
			return $_SESSION["m-cloto"][$index];
		return false;
	}
  public function clear(){
	$_SESSION["m-cloto"] = array();
	return "ok";
  }
	//---------- help ---------------//
	public function help(){
		return <<<'EOT'
>> DBLocal(dbl)
.data	- dados salvos no banco de dados
.set([index],[valor]) - Adiciona ou atualiza iinformações no banco de dados
.help()
.get() - Retorna todo banco de dados
.get([index]) - Retorna dado especifico do banco de dados
.clear() - Apaga is dados salvos

EOT;
	}
}
