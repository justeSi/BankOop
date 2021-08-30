<?php
namespace Bank\Home\Controllers;

use Bank\Router\App;
/**
    * Pagrindinio puslapio rodymas
    */
class HomeController
{
    public function home()
    {
        return App::view('home');
    }
}