<?php
class Common {
	public function stripTojSon($json){
		$jsonVar = "jsonp".$this->time."(";
		$json = str_replace($jsonVar,"",$json);
		$json = str_replace("})","}",$json);
		return json_decode($json,true);
	}
	
	public function setTime($time){
		$this->time = $time;
	}
}