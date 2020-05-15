<?php

class HomeController extends Controller {
	
	public function index ($param) {
		//This is a proof of concept - we do NOT want HTML in the controllers!
		echo '<br><br>Home Controller Index Method<br>';
		echo 'Param: ' . $param . '<br><br>';
		$user = $this->model('User')->getAll();
		
	}

	public function login()
	{
		$this->view('home/login');
		if (isset($_POST['username']) && isset($_POST['password'])) {
			if ($this->model('User')->login($_POST['username'], $_POST['password'])) {
				if ($_SESSION['usertype'] == 'Manager') {
					header('Location: /brewsoft/mvc/public/manager/index');
				}
				if ($_SESSION['usertype'] == 'Worker') {
					header('Location: /brewsoft/mvc/public/MachineApi/index');
				}
				if ($_SESSION['usertype'] == 'Admin') {
					header('Location: /brewsoft/mvc/public/admin/index');
				}
			} else {
				echo 'please fill in the right information';
			}
		}
	}
	
	public function restricted () {
		echo 'Welcome - you must be logged in';
	}
	
	public function login($username) {
		if($this->model('User')->login($username)) {
			$_SESSION['logged_in'] = true;
			$this->view('home/login');
		}
	}
	
	public function logout() {
		
		//if($this->post()) {
			session_unset();
			header('Location: /Exercises/mvc/public/home/loggedout');
		//} else {
		//	echo 'You can only log out with a post method';
		//}
	}
	
	public function loggedout() {
		echo 'You are now logged out';
	}
	
}