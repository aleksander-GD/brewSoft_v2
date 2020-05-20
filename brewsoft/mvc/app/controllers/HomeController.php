<?php

class HomeController extends Controller
{

	public function index()
	{
		$this->view('home/login');
	}

	public function login()
	{
        $_SESSION['usertype'] = null;
		$this->view('home/login');
		if (isset($_POST['username']) && isset($_POST['password'])) {
			if ($this->model('User')->login()) {
				if ($_SESSION['usertype'] == 'Manager') {
					header('Location: /brewsoft/mvc/public/manager/index');
				} else if ($_SESSION['usertype'] == 'Worker') {
					header('Location: /brewsoft/mvc/public/MachineApi/index');
				} else if ($_SESSION['usertype'] == 'Admin') {
					header('Location: /brewsoft/mvc/public/admin/index');
				} else {
				    echo 'Login failed. Check network connection.';
                }
			} else {
				echo 'Login failed. Invalid username or password.';
			}
		}
	}

	public function register()
	{
		$this->view('home/register');
		if (isset($_POST['Signup'])) {
			if ($this->model('User')->createUser($_POST['username'], $_POST['password'], $_POST['usertype'])) {
				header('Location: /brewsoft/mvc/public/home/login');
			} else {
				//echo 'Error at register user';
			}
		}
	}

	public function restricted()
	{
		$this->view('partials/restricted');
	}
}
