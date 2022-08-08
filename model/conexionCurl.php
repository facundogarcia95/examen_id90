<?php

abstract class ConexionCurl{
	
	/** @var ConexionCurl:: */
	protected static $instance= array();
/** @var string */
	private $endpoint		= null;
/** @var Object Curl*/
	private $curl	= null;
/** @var int */
	private $status_code	= null;
/** @var array */
	private $query_params	=[];
/** @var boolean */
	private $debug			= false;
	

	
	const METHOD_GET	= 'GET';
	const METHOD_POST	= 'POST';
	const METHOD_PUT	= 'PUT';
	const METHOD_DELETE	= 'DELETE';

	static protected $METODOS_PERMITIDOS	= [
		self::METHOD_GET	=> self::METHOD_GET,
		self::METHOD_POST	=> self::METHOD_POST,
		self::METHOD_PUT	=> self::METHOD_PUT,
		self::METHOD_DELETE	=> self::METHOD_DELETE,
	];
	
	final public function __construct(){}
	final public function __destruct(){
		curl_close($this->curl);
	}
/**
 * Sirve para trabajar siempre sobre la misma instancia inicializada.
 * @return ApiCURL::
*/
	static public function getInstance(){
		$hije	= get_called_class();
		if(!(isset(static::$instance[$hije]) && static::$instance[$hije] !== null)){
			return static::$instance[$hije]	= new static();
		}
		return static::$instance[$hije];
	}

/**
 * Interfaz para inicializar el objeto.
 * @param string $endpoint - Endpoint donde realizar la consulta.
 * @param array  $curl_setopt - Parametros extra para `curl_setopt`.
 * @return ApiCURL::
*/
	public static function init($endpoint=null, $curl_setopt=null){
		static::getInstance()->_init($endpoint, $curl_setopt);
		return static::getInstance();
	}

	/**
 * Setea el endpoint de consulta y los seteos principales para inicializar CURL.
 *
 * @param string	$endpoint	- URL de consulta
 * @return void
*/
	private function _init($endpoint = null, $curl_setopt=null){
		$this->endpoint	= $endpoint;
		$this->curl		= \curl_init();
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($this->curl, CURLOPT_HEADER, false);
		curl_setopt($this->curl, CURLOPT_FORBID_REUSE, 1); /// Testear si rompe
		curl_setopt($this->curl, CURLOPT_FRESH_CONNECT, true);

		if(!empty($curl_setopt)){
			foreach($curl_setopt as $name_option => $value) {
				if(constant($name_option) !== null){
					curl_setopt($this->curl, constant($name_option), $value);
				}
			}
		}
	}

	/**
	 * Checkea que el objeto este inicializado correctamente,
	 *
	 * @throws Exception - En caso de no estar iniciliazado correctamente.
	*/
	private function checkInit(){
		if($this->endpoint === null){
			throw new \Exception("El api no fue inicializada correctamente", 1);
		}
	}

	final protected function debug(){
		$this->debug	= true;
	}

	
	/**
	 * Permite debugear la respuesta del API. 
	 * Retorna lo que el servidor de destino genere en formato crudo y corta la ejecucion.
	 * No afecta el comportamiento, simplemente no parsea la respuesta.
	 *
	 * @return void
	 */
	final static public function activarDebug(){
		static::getInstance()->debug();
	}

	/**
 * Realiza la consulta CURL segun tipo de metodo especificado. Combina el endpoint, con el recurso solicitado,  mas los parametros pasados por ->setQuery().
 * E.j-1:
   ``` php
   $api->setQuery([
   	'username'	=> $username,
   	'password'		=> $password
   ]);
   $api->consulta('GET', "/userLogin", $data=null);
   ```
* E.j-2:
   ``` php
   $api->consulta('POST',"/arlines/{$name_airline}", $data=null);
   ```
 *
 * @param string	$metodo - Alguno de los metodos
 * @param string	$recurso - Son los parametros que se le agregan a la URL del endpoint.
 * @param array|object		$data - Si es array, cada indice se envia como un campo distinto, si es objeto se convierte a json y se agrega se envia como campo `data`
 *
 * @return bool|array
 * @throws Exception	- Si el metodo no es valido
*/
	final protected function consulta($metodo=null, $recurso=null, $data=false){
		$this->checkInit();

		curl_setopt($this->curl, CURLOPT_URL, $this->endpoint . $recurso . $this->getQuery());
		
		switch ($metodo) {
			case static::METHOD_POST:
				curl_setopt($this->curl, CURLOPT_POST, true);
				curl_setopt($this->curl, CURLOPT_HEADER, 0);
				break;
			case static::METHOD_PUT:
				curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'PUT');
				curl_setopt($this->curl, CURLOPT_HEADER, 0);
				break;
			case static::METHOD_DELETE:
				curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, "DELETE");
				curl_setopt($this->curl, CURLOPT_HEADER, 0);
				break;
			case static::METHOD_GET:
				curl_setopt($this->curl, CURLOPT_HEADER, 0);
				curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true); 
				break;
			default:
				throw new \Exception("El metodo '{$metodo} no esta implementado. Pruebe con 'GET', 'PUT', 'POST' o 'DELETE'", 1);	
		}

		if(is_object($data)){
			$data	= ['data'	=> json_encode($data)];
		}
		if(!empty($data) && is_array($data) && ($metodo == static::METHOD_POST || $metodo == static::METHOD_PUT)){
			if($metodo === static::METHOD_PUT){
				$data = (is_array($data)) ? http_build_query($data) : $data;
			}
			curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
		}
		$return	= curl_exec($this->curl);

		if($this->debug === true){
			$this->setStatusCode(curl_getinfo($this->curl, CURLINFO_HTTP_CODE));
			echo "API Status Code: {$this->getStatusCode()} <br />";
			echo $return;
			$this->reset();
			exit;
		}

		$return	= json_decode($return, true);
		$this->setStatusCode(curl_getinfo($this->curl, CURLINFO_HTTP_CODE));

		$this->reset();
		return $return;
	}


	/**
	 * Setea el status code que devuelva la consulta realizada.
	 *
	 * @param int	$code - status code
	 * @return void
	*/
	protected function setStatusCode($code=null){
		$this->status_code	= $code;
	}

	/**
	* Obtiene el Status Code de la consulta realizada.
	* @return int
	*/
	protected function getStatusCode(){
		return $this->status_code;
	}

	/**
	* Se setean los parametros que seran pasados por url al hacer una consulta.
	*
	* @param array	$query_params	- Parametros con formato ['variable' => 'valor']
	* @return void
	*/
	final protected function setQuery($query_params=null){
		if(!is_array($query_params)){
			throw new \Exception("Solo acepta un array como parametro", 1);
		}
		$this->query_params	= $query_params;
	}

	/**
	* Devuelve los parametros seteados con "$this->setQuery()"  como string parcesado valido para pasarlo como query por URL.
	* E.j: "?variable1=valor1&variable2=valor2"
	*
	* Si $primer_parametro es false, el resultado seria similar a; "&variable1=valor1&variable2=valor2"
	*
	* @param boolean	$primer_parametro	- default: true- En false hace que el primer parametro no empieze con "?".
	* @return string
	*/
	private function getQuery($primer_parametro=true){
		if(empty($this->query_params)){
			return '';
		}
		$aux = '';
		foreach($this->query_params as $campo => $valor){
			if(is_array($valor)) {
				$valor	= json_encode($valor);
			}
			$valor = urlencode($valor);
			if($valor	!== ''){
				if (!empty($aux) || $primer_parametro === false) {
					$aux .= '&' . $campo . '=' . $valor;
				} else {
					$aux .= '?' . $campo . '=' . $valor;
				}
			}
		}
		return $aux;
	}

	/**
	* Vuelve los paramentros a su estado inicial.
	* @return void
	*/
	private function reset(){
		$this->query_params	=[];
		$this->debug		= false;
		curl_close($this->curl);
	}
}
