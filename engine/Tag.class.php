<?php
class Tag{

	public static function stringToTags($str){
		//echo $str;
        $str = Tag::strToStr($str);
		$retorno = array();
		$aTag = "";
		for($i = 0; $i < strlen($str);$i++){
			if($str[$i]==";"){
				$retorno[] = $aTag;
				$aTag = "";
				continue;
			}
			$aTag .= $str[$i];
		}
		if(strlen($str)>0)
			if($str[strlen($str)-1]!= ";"){
				$retorno[] = $aTag;
			}
		return $retorno;
	}
	public static function strToStr($str){
		$nStr = "";
		for($i = 0; $i < strlen($str);$i++){
			if($str[$i]==" "||$str[$i]=="#"||$str[$i]=="'"||$str[$i]=="!"){
				continue;
			}
			if($str[$i]==","||$str[$i]=="|"||$str[$i]=="."||$str[$i]=="."){
				$nStr .=";";
				continue;
			}
			$nStr .= $str[$i];
		}
		return $nStr;
	}
}