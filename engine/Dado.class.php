<?php
class Dado{
	function novo($dado="", $tag=""){
		global $db,$user;
		$dado = urlencode($dado);
		$tag = Tag::strToStr($tag);
		$tag = urlencode($tag);
		if($dado==""){
			return false;
		}
		//$dado=urlencode($dado);
		$sql = "INSERT INTO `cloto_dados` (`user`, `dado`, `tag`) VALUES ('{$user->id}','{$dado}', '{$tag}');";
		$db->query($sql);
		return "Ok";
	}
	function drop($id){
		//DELETE FROM `cloto_dados` WHERE `cloto_dados`.`id` = 4
		global $db;
		$sql = "DELETE FROM `cloto_dados` WHERE `cloto_dados`.`id` = $id";
		$db->query($sql);
		return "ok";
		
	}
	function get($id,$tRetorno=""){
		global $db;
		$id = urlencode($id);
		$sql = "SELECT * FROM `cloto_dados` WHERE `id`='$id'";
		
		$retorno = $db->query($sql);
		if(!$retorno){
			return "Erro ao acessar banco de dados";
		}
		$retorno = $retorno->fetchAll();
		$retorno2 = array();
		if(isset($retorno[0])){
			$retorno2["id"] = urldecode($retorno[0]["id"]);
			$retorno2["dado"] = urldecode($retorno[0]["dado"]);
			$retorno2["tag"] = Tag::stringToTags(urldecode($retorno[0]["tag"]));
		}


		if($tRetorno == "json"){
			//$retorno["time"] = time();
			$retorno2 = json_encode($retorno2);
			return $retorno2;
		}
		return $retorno2;

	}
	function update($id,$dado,$tag){
		global $db;
		$id = urlencode($id);
		$dado = urlencode($dado);
		$tag = Tag::strToStr($tag);
		$tag = urlencode($tag);
		//UPDATE `cloto_dados` SET `dado` = '* Criar o Repositorio para dominação.\r\n* Atulalizar repositorios.', `tag` = 'GitHub;Projetos;' WHERE `cloto_dados`.`id` = 106;
		$sql = "UPDATE `cloto_dados` SET `dado` = '$dado', `tag` = '$tag' WHERE `cloto_dados`.`id` = $id;";
		//$retorno = null;
		$retorno = $db->query($sql);
		return "ok";
	}
	function search($criterio="",$tRetorno=""){
		global $db, $user;
		$sql = "SELECT * FROM `cloto_dados` where `user` = {$user->id} ";
		if($criterio != ""){
			$qTags = Tag::stringToTags($criterio);
            //var_dump($qTags);
			$sql .="and ";
			for($i = 0; $i < sizeof($qTags); $i++){
                $sql .="tag like ";
				$sql .="'%{$qTags[$i]}%'";
				if(sizeof($qTags)-1 != $i){
					$sql .=" and ";
				}
			}
		}
		$sql .=" ORDER by id DESC;";

		$retorno = $db->query($sql);
		$retorno = $retorno->fetchAll();
		$retorno2 = array();
		
		foreach($retorno as $linha){
			//$nLinha["id"] = urldecode($linha["id"]);
			//$nLinha["dado"] = urldecode($linha["dado"]);
			//$nLinha["tag"] = Tag::stringToTags(urldecode($linha["tag"]));
			
			$retorno2[] = Dado::byBd($linha);
		}
		if($tRetorno==""||$tRetorno=="array"){
			return $retorno2;
		}
		if($tRetorno == "json"){
			$retorno2 = json_encode($retorno2);
			return $retorno2;
		}
		return "Enpty!";
	}
	static function byBd($row){
		global $user;
		$dado = array();
		$dado["id"] = urldecode($row["id"]);
		$dado["user"] = $user->get($row["user"]);
		$dado["dado"] = urldecode($row["dado"]);
		$dado["tag"] = Tag::stringToTags(urldecode($row["tag"]));
	return $dado;
	}
    function dump(){
        header("Content-Type: text/plain");
        header('Content-Disposition: attachment; filename=moiras-cloto-server[dump].txt');
header('Pragma: no-cache');
        global $user, $db;
        $sql = "SELECT * FROM `cloto_dados` where `user` = {$user->id} ";
        $dados = $db->query($sql);
        $retorno = "";
        foreach($dados as $dado){
            $dado["dado"] = urldecode($dado["dado"]);
            $retorno .= "dado.novo(strBegin\"{$dado["dado"]}\"strEnd,strBegin\"{$dado["tag"]}\"strEnd);\n";
            
        }
        return $retorno;
    }
	public function help(){
		return <<<'EOT'
_______________
.novo([string:dado],[string:tag]="")
.get([int/string:id])
.update([int/string:id],[string:dado],[string:tag])
.drop([int/string:id])
.search([string:criterios/tags],[string:tipo de retorno]) - tipo de retornon = ''/'aray','json',
_______________
EOT;
	}
}