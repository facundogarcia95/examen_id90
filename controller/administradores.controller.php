<?php

class ControladorAdministradores{

	/*=============================================
	LOGIN DE ADMINISTRADOR
	=============================================*/

	public function ctrLoginAdministrador(){

		if(isset($_POST["username"])){
			   
			$respuesta = ModelAdm::mdlLoginAdm($_POST);


			if($respuesta === true){

				$_SESSION["validarSesionBackend"] = "ok";
				$_SESSION["username"] = $_POST["username"];
				$_SESSION["airline"] = $_POST["airline"];

				echo '<script>

					window.location = "index";

				</script>';

			}else{

				echo '<br>
				<div class="alert alert-danger">Usuario o contraseña incorrectos</div>';

			}

		}

	}

}

