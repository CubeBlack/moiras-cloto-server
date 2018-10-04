<?php
global $user;
class Terminal{
	public function __construct($vars,$echo=true){
		$this->vars = $vars;
		$this->echo = $echo;
	}
	public function chamada($com) {
		$com = Terminal::parce($com);
		$com = Terminal::call($com,$this->vars);
		if($this->echo) {
			if(is_string($com)) echo $com;
			else var_dump($com);
				
		}
		return $com;
	}
	static function parce($comStr) {
			$comArr = [];
			$params = [];
			$nods = [];
			$aCom = 0;
			$get = "";
			$tGet = "node";
			
			
			//--------
			for($i = 0; $i < strlen($comStr);$i++){
				//----- getnos -- 
				if($tGet=="node") {
					//ignorar linha e espacos
					if($comStr[$i] == " "||$comStr[$i] == "\n"){
						continue;
					}
					if($comStr[$i]==".") {
						if($get!="") $nods[] = $get;
						$get = "";
						continue;
					}
					if($comStr[$i]=="(") {
						if($get!="") $nods[] = $get;
						$comArr[$aCom]["nodes"] = $nods;
						$comArr[$aCom]["tipo"] = "funcion";
						$tGet = "param";
						$get = "";
						continue;					
					}
					if($comStr[$i]==";") {
						if($get!="") $nods[] = $get;
						$comArr[$aCom]["nodes"] = $nods;
						$get = "";
						$nods = [];
						$params = [];
						$aCom++;
						continue;	
					}
				}
				//----- params -- 
				if($tGet=="param") {
					if($comStr[$i]==",") {
						if($get!="") $params[] = $get;
						//$params[] = $get;
						$get = "";
						continue;			
					}
					if($comStr[$i]==")") {
						if($get!="") $params[] = $get;
						$comArr[$aCom]["params"] = $params;
						$tGet = "node";
						$get = "";
						continue;	
					}
					///------
					if(strlen($get)>7){
						if(
							$comStr[$i-8] == "s"&
							$comStr[$i-7] == "t"&
							$comStr[$i-6] == "r"&
							$comStr[$i-5] == "B"&
							$comStr[$i-4] == "e"&
							$comStr[$i-3] == "g"&
							$comStr[$i-2] == "i"&
							$comStr[$i-1] == "n"&
							$comStr[$i-0] == "\""){
							$tGet = "paramStr";
							$get = "";
							continue;
							
							//echo "+++";
						}
					}
					//------
				}
				if($tGet=="paramStr") {
					if(strlen($comStr)>7){
						if(
							$comStr[$i-6] == "\""&
							$comStr[$i-5] == "s"&
							$comStr[$i-4] == "t"&
							$comStr[$i-3] == "r"&
							$comStr[$i-2] == "E"&
							$comStr[$i-1] == "n"&
							$comStr[$i-0] == "d"){
							$tGet = "param";
							$get = substr($get,0,-6);
							//if($get!="") $params[] = $get;
							$params[] = $get;
							$get = "";
							continue;
						}
					}
				}
				$get .=  $comStr[$i];
			}
			//ends
			if($comStr[strlen($comStr)-1]!=";") {
				if($tGet=="node") {
					if($get!="") $nods[] = $get;
					$comArr[$aCom]["nodes"] = $nods;
				}
				if($tGet=="param") {
					if($get!="") $params[] = $get;
					$comArr[$aCom]["params"] = $params;
				}
			}

			//--------
			return $comArr;
	}
	static function call($coms,$vars=[]) {
		//var_dump($coms);
		//---------- varives globais -----
		foreach($vars as $var){
			global ${$var};
		}
		//-------------------------
		$retorno = [];
		foreach($coms as $keyCom => $com){
			if(!isset($com["tipo"])) $com["tipo"] = "var";
			$var = null;
			//pegar variavel a aprtir dos nos
			foreach($com["nodes"] as $keyNod => $nod){
				//se for o ultimo e for do tipo fun;'ao
				if($com["tipo"] == "funcion"&& $keyNod == sizeof($com["nodes"])-1) {
					continue;
				}
				//se for o primeiro
				if($keyNod == 0) {
					if(!isset(${$nod})) {
						$retorno[] = "Erro = O no $keyNod do comando $keyCom [$nod] não foi reconhecido";
						break;			
					}
					$var = ${$nod};
					continue;
				}
				
				if(!isset($var->{$nod})) {
					$retorno[] = "Erro = O no $keyNod do comando $keyCom [$nod] não foi reconhecido";
					break;			
				}
				$var = $var->{$nod};
			}
			
			//executar funcao
			
			// ----functions
			$uNod =  $com["nodes"][sizeof($com["nodes"])-1];
			if($com["tipo"] == "funcion") {
				switch(sizeof($com["params"])) {
					case 0: $retorno[] = $var->{$uNod}();
						break;
					case 1: $retorno[] = $var->{$uNod}($com["params"][0]);
						break;
					case 2: $retorno[] = $var->{$uNod}($com["params"][0],$com["params"][1]);
						break;
					case 3: $retorno[] = $var->{$uNod}($com["params"][0],$com["params"][1],$com["params"][2]);
						break;
					case 4: $retorno[] = $var->{$uNod}($com["params"][0],$com["params"][1],$com["params"][2],$com["params"][3]);
						break;
					case 5: $retorno[] = $var->{$uNod}($com["params"][0],$com["params"][1],$com["params"][2],$com["params"][3],$com["params"][4]);
						break;
					case 6: $retorno[] = $var->{$uNod}($com["params"][0],$com["params"][1],$com["params"][2],$com["params"][3],$com["params"][4],$com["params"][5]);
						break;
					case 7: $retorno[] = $var->{$uNod}($com["params"][0],$com["params"][1],$com["params"][2],$com["params"][3],$com["params"][4],$com["params"][5],$com["params"][6]);
						break;
					case 8: $retorno[] = $var->{$uNod}($com["params"][0],$com["params"][1],$com["params"][2],$com["params"][3],$com["params"][4],$com["params"][5],$com["params"][6],$com["params"][7]);
						break;
					default: $retorno[] = "Erro = Numero de parametros nao suportado pelo terminal";
						break;
				}
			}
			elseif($com["tipo"] == "var") {
				$retorno[] = $var;
			}
			
		}
		if(sizeof($retorno)==0) $retorno = "Empty!";
		if(sizeof($retorno)==1) $retorno = $retorno[0];
		//$retorno["type"] = "RetornoList";
		return $retorno;
	}
}
