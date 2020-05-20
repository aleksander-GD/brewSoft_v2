<?php

class WorkerController extends Controller
{

	public function index()
	{
		header('Location: /brewSoft/mvc/public/worker/dashboardWorker');
	}

    public function dashboardWorker() {
        
        header('Location: /brewSoft/mvc/public/machineapi/index');
    }

    public function logout()
	{
		session_destroy();
		header('Location: /brewSoft/mvc/public/home/login');
	}
}
