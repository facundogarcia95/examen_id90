<?php


class DestinationModel {


	public static function searchDestination($data){

		$resp = ID90Api::searchDestination($data);

		return $resp;

	}


	public static function validateSearch($request){

		$validate = [];

		if((!isset($request["guests"]) || intval($request["guests"]) > 4)){
			array_push($validate,"La cantidad de pasajeros debe ser menor a 4");
		}

		if((!isset($request["guests"]) || intval($request["guests"]) < 1)){
			array_push($validate,"La cantidad de pasajeros debe ser mayor a 1");
		}

		if(!isset($request["reservation"]) || empty($request["reservation"])){
			array_push($validate,"Debe elegir fecha Desde y Hasta");
		}

		if(!isset($request["destination"]) || empty($request["destination"])){
			array_push($validate,"Debe colocar un destino");
		}

		return $validate;
	}
}