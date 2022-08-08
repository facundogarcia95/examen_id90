<?php

class ModelAdm{

	/*=============================================
	LOGIN ADMINISTRADOR
	=============================================*/

	static public function mdlLoginAdm($request){
		
		$request["remember_me"] = isset($request["remember_me"]) ? '1' : '0';
		//SETEO LA FUNCIÓN COMO TRUE para que siga el proceso
		$resp = ($temp = ID90Api::loginAirline($request)) ? $temp : true;

		return $resp;

	}




}