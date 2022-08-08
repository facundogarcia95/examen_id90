<?php
require_once "conexionCurl.php";

class ID90Api extends ConexionCurl{

	static public function getAirlines() {
		$api = static::getInstance();
		$api->setQuery([]);
		$return = $api->consulta('GET', "/airlines");
		if($api->getStatusCode() != '200'){
				return [];
		}
		return $return;
	}

	static public function loginAirline($data){

		if(empty($data["airline"]) || empty($data["username"]) || empty($data["password"])){
			return false;
		}
		$api = static::getInstance();
		$return 		= $api->consulta('POST', "/session.json", ['data'=>json_encode($data)]);
		if($api->getStatusCode() > 200){
			return false;
		}
		return $return;
	}


	static public function searchDestination($data){

		if(empty($data["guests[]"]) || empty($data["checkin"]) || empty($data["checkout"]) || empty($data["destination"]) ){
			return [];
		}
		$api = static::getInstance();
		$api->setQuery($data);

		$return 		= $api->consulta('GET', "/api/v1/hotels.json");
		if($api->getStatusCode() > 200){
			return [];
		}
		return $return;

	}

}