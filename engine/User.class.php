<?php
class User{
	const pDesvinculado = 0;
	const pNormal = 1;
	const pTester = 2;
	const pDesenvolvedor = 3;
	const pAdm = 5;
	
	public function __construct(){
		global $dbl;
		$this->id = 0;
		$this->nick = "Anonymous-" . rand(1111,9999);
		$this->email = "asdf@qwer.zx";
		$this->poder = 0;
		$this->titulo = $this->fTitulo();
		
		if(!$dbl->get("user")){
			$dbl->clear();
			$dbl->set("user",$this);
		}
		else{
			$tUser = $dbl->get("user");
			$this->id = $tUser->id;
			$this->nick = $tUser->nick;
			$this->email = $tUser->email;
			$this->poder = $tUser->poder;
			$this->titulo = $this->fTitulo();
		}
	}
	public function get($id=0,$tRetorno=""){
		if($id==0){
			$nUser = new User();
			$nUser->id = 0;
			$nUser->nick = "Anonymous";
			$nUser->email = "asdf@qwer.zx";
			$nUser->poder = 0;
			$nUser->titulo = $this->fTitulo();
			return $nUser;
		}
		global $db;
		$sql = "SELECT * FROM `cloto_user` WHERE `id`=$id";
		$retorno = $db->query($sql);
		$retorno = $retorno->fetchAll();
		if($tRetorno == "json") return json_encode($retorno[0]);
		return $retorno[0];
	}
	public function me($rTipo=""){
		if($rTipo == "json")
			return json_encode($this);
		return $this;
	}
	public function listar($rTipo=""){
		global $db, $dbl;
		$sql = "SELECT * FROM `cloto_user`";
		$retorno = $db->query($sql);
		$retorno = $retorno->fetchAll();
		if($rTipo=="json"){
			return json_encode($retorno);
		}
		return $retorno;
	}
	
	public function login($login,$senha){
		global $db, $dbl;
		//evitar ingeção msql
		$login = urlencode($login);
		$senha = urlencode($senha);
		//SELECT * FROM `cloto_user` WHERE (`nick`='asdf' or `email`='asdf') AND `senha`='asdf'
		$sql = "SELECT * FROM `cloto_user` WHERE (`nick`='$login' or `email`='$login') AND `senha`='$senha';";
		$retorno = $db->query($sql);
		$retorno = $retorno->fetchAll();
		foreach($retorno as $u){
			$this->id = $u["id"];
			$this->nick = $u["nick"];
			$this->email = $u["email"];
			$this->poder = $u["poder"];
			$this->titulo = $this->fTitulo();
		}
		//return $tRetorno;
		if($this->id != 0){
			$dbl->set("user",$this);
			return "Ok!";
			
		}
		return "N'ao foi posivel efetuar o login. Verifique usuario e(ou) senha.";
	}
	public function logued(){
		if($this->id !=0){
			return "Ok!";
		}
	}
	public function novo($nick,$email,$pass){
		//INSERT INTO `cloto_user` (`id`, `nick`, `email`, `senha`) VALUES (1, 'asdf', 'asdf@asdf', 'asdf');
	}
	public function sair(){
		global $dbl;
		$dbl->clear();
		return "Ok!";
	}
	public function setPower($id,$valor){
		
	}
	public function fTitulo(){
		if($this->poder == User::pDesvinculado){
			return "Sr.";
		}
		if($this->poder == User::pNormal){
			return "complheiro";
		}
		if($this->poder == User::pTester){
			return "Mestre";
		}
		if($this->poder >= User::pDesenvolvedor){
			return "Grand-mestre";
		}
	}
		
	//---------- help ---------------//
	public function help(){
		return <<<'EOT'
>> User(user) - Dados e funções de usuario
.id
.nick
.email

.login([user/email],[password])
.logued()
.get([$rTipo:json/])
.novo([nick],[email],[senha])
.sair()
.setPower([id],[valor])
.desafiar([id]);

EOT;
	}
}