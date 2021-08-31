<?php
namespace Bank\Sign;
use Bank\Maria\Maria;
use Acc\Admin\Admin;
use Bank\Router\App;
use PDO;

class SignController
{    /**
    * Kreipimasis į MariaDb
    */
    private $settings = 'Maria';

    private function get()
    {
        $db = 'Bank\\Maria\\'.$this->settings;
        return $db::get();
    }
/**
 * Darbuotojo pridęjimas į mariaDB
 */
    public function create()
    {   
        if(empty($_POST['name']||
        $_POST['email']||
        $_POST['password']||
        $_POST['pass'] )) {
            App::addMessage('danger', 'Įveskite informaciją');}
        else {
            $name = strtolower($_POST['name'] ?? 0);
            $email = strtolower($_POST['email'] ?? 0);
            $password = md5($_POST['password'] ?? 0);
            $pass = md5($_POST['pass'] ?? 0);
            // Validaciniu metodu iskvietimas ir tikrinimas
            if ( $this -> checkPass($password, $pass) &&
            $this -> checkEmail($email)&&
            $this -> uniqEmail($email)&&
            $this -> checkName($name) ){

                Maria::get()->write($name, $email, $password);
                App::addMessage('success', 'Darbuotojas pridėtas');
                App::redirect('login');
            }
        }
        
        // redirektina atgal į save
        App::redirect('signin');
    }   
/**
 * Tikrinama ar varde nėra skaičių ar tuščių tarpų
 */
    private function checkName(string $name) 
    {
        
        if (( preg_match('/\d|\s/', $name))) {
            App::addMessage('danger', 'Varde/pavardėje skaitmenys/tarpai neleidziami');
            return 0;
        } else {
            return 1;
        }
    } 
/**
 * Tikrinama ar sutampa slaptažodžio pakartojimas su slaptažodžiu
 */
    private function checkPass(string $pass1, string $pass2) 
    {
        if ($pass1 === $pass2) {
            return 1;
        } else {
            App::addMessage('danger', 'Slaptažodžiai nesutampa');
            return 0;
        }
    }
    /**
 * Tikrinama ar el. paštas atitinka el. pašto standartus
 */
    private function checkEmail(string $email) 
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            App::addMessage('danger', 'El. paštas netitinka reikalavimų');
            return 0;
        }
        return 1;
    }
    private function uniqEmail($email)
    {
        $users = $this->get()->read($email);
        _d($email);
         //Tikrinama ar el. paštas yra sukurtus (sukurtam slaptažodiui gržinamas slaptažodis..)
         
            if ( $users != '') {
                App::addMessage('danger', 'Vartotojas su tokiu el. paštu jau yra sistemoje');
                return  0;
            }
            else {
                return 1;
            }
        }
    
}