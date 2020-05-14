<?php

class HomeController extends Controller {
	
	public function index ($param) {
		//This is a proof of concept - we do NOT want HTML in the controllers!
		echo '<br><br>Home Controller Index Method<br>';
		echo 'Param: ' . $param . '<br><br>';
		//$user = $this->model('User')->getAll();
		
	}
	
	public function other ($param1 = 'first parameter', $param2 = 'second parameter') {
		$user = $this->model('User');
		$user->name = $param1;
		$viewbag['username'] = $user->name;
		//$viewbag['pictures'] = $this->model('pictures')->getUserPictures($user);
		$this->view('home/index', $viewbag);
	}
	
	public function restricted () {
		echo 'Welcome - you must be logged in';
	}
	
	public function logout() {
		if($this->post()) {
			session_unset();
		} else {
			echo 'You can only log out with a post method';
		}
	}
	
	public function loggedout() {
		echo 'You are now logged out';
	}

	public function login() {
		$this->view('home/login');
		if (isset($_POST['username']) && isset($_POST['password'])) {
			if ($this->model('User')->login($_POST['username'], $_POST['password'])) {
				if ($_SESSION['usertype']=='Manager')
				{
					header('Location: /brewsoft/mvc/public/manager/index');		
				}
				if ($_SESSION['usertype']=='Worker')
				{
					header('Location: /brewsoft/mvc/public/brewworker/index');		
				}
				if ($_SESSION['usertype']=='Admin')
				{
					header('Location: /brewsoft/mvc/public/admin/index');		
				}			
			
			} else 
			{
				echo 'please fill in the right information';
			}
		}
	}

	public function register () {
		$this->view('home/register');
		if (isset($_POST['Signup'])){
			if ($this->model('User')->createUser($_POST['username'], $_POST['password'], $_POST['usertype']))
			{
				header('Location: /brewsoft/mvc/public/home/login');
			} else {
				echo 'what a pleb';
			}
		}
	}
}