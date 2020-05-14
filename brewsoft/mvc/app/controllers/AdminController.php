<?php

class AdminController extends Controller
{
    public function index()
    {
        $viewbag = array();

        if (isset($_SESSION['username']) && isset($_SESSION['logged_in'])) {
            $viewbag['logged_in'] = true;

            $this->view('admin/index', $viewbag);
        } else {
            $this->view('partials/restricted', $viewbag);
        }
    }

    public function logout()
    {
        session_destroy();
        header('Location: /brewSoft/mvc/public/home/login');
    }
}
