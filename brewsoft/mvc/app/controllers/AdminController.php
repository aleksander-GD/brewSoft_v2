<?php

class AdminController extends Controller
{
    public function index()
    {
        header('Location: /brewSoft/mvc/public/manager/planBatch');
    }

    public function logout()
    {
        session_destroy();
        ob_flush();
        header('Location: /brewSoft/mvc/public/home/login');
    }
}
