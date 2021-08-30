<?php
namespace Bank\Login\Controllers;

use Bank\Router\App;
use Bank\Darbuotojai\Login\Json;
use Bank\Maria\Maria;
use Bank\Sign\SignController;

class LoginController
{
    /**
    * Kreipimasis į MariaDb
    */
    private $settings = 'Maria';

    private function get()
    {
        $db = 'Bank\\Maria\\'.$this->settings;
        return $db::get();
    }
    /**
    * Prisijungimo puslapio rodymas
    */

    public function showLogin()
    {
        return App::view('login');
    }
    /**
    * Naujo vartotojo sukūrimo puslapio rodymas
    */
    public function showSignIn()
    {
        return App::view('signup');
    }
    /**
    * Ištraukiama darbuotojo data iš DB pagal darbuotojo el. paštą
    */
    public function show($email)
    {
        $users = $this->get()->read($email);
        return $users;
        // _d($users);
    
    }
    /**
    * Prisijungimo duomenų tikrinimas ir vykdymas
    */
    public function login()
    {
        $email = $_POST['email'] ?? ''; 
        $pass = md5($_POST['pass']) ?? '';
        //Slaptažodžio ištraukimas iš DB pagal el. paštą
        $password = $this->show($email);
        if (empty($email)||empty($pass)) {
            App::addMessage('danger', 'Įveskite duomenis!');
            App::redirect('login');
        }
        //Prisijungiama kai duomenys sutampa
        if ($password == $pass) {
            $_SESSION['login'] = 1;
            App::addMessage('success', 'Sėkmingai prisijungta');
            App::redirect('list');
        }
        App::addMessage('danger', 'El. paštas ar slaptažodis neteisingas');
        App::redirect('login');
    }
    /**
    * Atsijungimas
    */
    public function logout()
    {
        unset($_SESSION['login'], $_SESSION['email']);
        App::addMessage('success', 'Sėkmės!!!');
        App::redirect('login');
    }
}