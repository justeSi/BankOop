<?php
session_start();
define('INSTALL', '/Lape/BankOop/public/');
define('DIR', __DIR__. '/');
define('URL', 'http://localhost/Lape/BankOop/public/');

require DIR.'vendor/autoload.php';

function showIban() {
    return Bank\Router\App::accountNumber();
}
function showId() {
    _d(Bank\Router\App::id());
    return Bank\Router\App::id();
}
function showMessages()
{
    return Bank\Router\App::showMessages();
}

function isLogged() 
{
    return Bank\Router\App::isLogged();
}