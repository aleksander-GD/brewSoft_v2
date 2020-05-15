<?php

class AdminController extends Controller
{
    public function index()
    {
        $viewbag = array();
    }

    public function logout()
    {
        session_destroy();
        ob_flush();
        header('Location: /brewSoft/mvc/public/home/login');
    }
}
