<?php

class Router {
	
	protected $controller = 'HomeController';
	protected $method = 'index';
	protected $params = [];
	
	function __construct () {
		$url = $this->parseUrl();
		
		if(isset($url[0])) {
			$url[0] = ucfirst($url[0]);
		}

		if(file_exists('../app/controllers/' . $url[0] . 'Controller.php')) {
			$this->controller = $url[0] . 'Controller';
			unset($url[0]);
		}
		
		require_once '../app/controllers/' . $this->controller . '.php';
		$this->controller = new $this->controller;
		
		if(isset($url[1])) {
			if(method_exists($this->controller, $url[1])) {
				$this->method = $url[1];
				unset($url[1]);
			}
		}
		
		$this->params = $url ? array_values($url) : [];
		
		require_once 'Restricted.php';
		if(restricted(get_class($this->controller), $this->method)) {
			header('Location: /brewsoft/mvc/public/home/restricted');
		} else {
			call_user_func_array([$this->controller, $this->method], $this->params);
		}
		
	}
	
	public function parseUrl () {
		
		$url = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
		if(substr($url, -1) !== "/") {
			$url = $url . "/";
		}
		$url = explode('/', $url);
		return array_slice($url, 4);
	}
	
}
	

