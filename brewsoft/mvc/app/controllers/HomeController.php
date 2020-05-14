<?php

class HomeController extends Controller
{

	public function index()
	{
		$this->view('home/login');
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

	public function register()
	{
		$this->view('home/register');
		if (isset($_POST['Signup'])) {
			if ($this->model('User')->createUser($_POST['username'], $_POST['password'], $_POST['usertype'])) {
				header('Location: /brewsoft/mvc/public/home/login');
			} else {
				echo 'error at register user';
			}
		}
	}

	public function restricted()
	{
		$this->view('partials/restricted');
	}
}
