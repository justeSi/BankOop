<?php
namespace Bank\Router;
use Bank\Router\Controllers\BankController;
use Bank\Login\Controllers\LoginController;
use Bank\Home\Controllers\HomeController;
use Bank\Sign\SignController;

class App 
{
    
    public static function start()
    {
        self::router();
    }
    /**
     * Router - pagal metodus ir raktinius žodžius "judėjimas" tarp puslapių
     */
    
    public static function router()
    {
        $url = str_replace(INSTALL, '', $_SERVER['REQUEST_URI']);
        $url = explode('/', $url);
        // _d($url, '===========>');

        
        if ('GET' == $_SERVER['REQUEST_METHOD'] && 1 == count($url) && '' === $url[0]) {
            return (new HomeController)->home();
        }
        if ('GET' == $_SERVER['REQUEST_METHOD'] && 1 == count($url) && 'list' === $url[0]) {
            return (new BankController)->index();
        }
        if ('GET' == $_SERVER['REQUEST_METHOD'] && 1 == count($url) && 'create' === $url[0]) {
            return (new BankController)->createAcc();
        }
        if ('POST' == $_SERVER['REQUEST_METHOD'] && 1 == count($url) && 'create' === $url[0]) {
            return (new BankController)->store();
        }
        if ('GET' == $_SERVER['REQUEST_METHOD'] && 2 == count($url) && 'add' === $url[0]) {
            return (new BankController)->addAmount($url[1]);
        }
        if ('POST' == $_SERVER['REQUEST_METHOD'] && 2 == count($url) && 'add' === $url[0]) {
            return (new BankController)->update($url[0], $url[1]);
        }
        if ('GET' == $_SERVER['REQUEST_METHOD'] && 2 == count($url) && 'rem' === $url[0]) {
            return (new BankController)->remAmount($url[1]);
        }
        if ('POST' == $_SERVER['REQUEST_METHOD'] && 2 == count($url) && 'rem' === $url[0]) {
            return (new BankController)->update($url[0], $url[1]);
        }
        if ('POST' == $_SERVER['REQUEST_METHOD'] && 2 == count($url) && 'delete' === $url[0]) {
            return (new BankController)->delete($url[1]);
        }
        if ('GET' == $_SERVER['REQUEST_METHOD'] && 1 == count($url) && 'login' === $url[0]) {
            return (new LoginController)->showLogin();
        }
        if ('GET' == $_SERVER['REQUEST_METHOD'] && 1 == count($url) && 'signin' === $url[0]) {
            return (new LoginController)->showSignIn();
        }
        if ('POST' == $_SERVER['REQUEST_METHOD'] && 1 == count($url) && 'signin' === $url[0]) {
            return (new SignController)->create();
        }
        if ('POST' == $_SERVER['REQUEST_METHOD'] && 1 == count($url) && 'login' === $url[0]) {
            return (new LoginController)->login();
        }
        if ('POST' == $_SERVER['REQUEST_METHOD'] && 1 == count($url) && 'logout' === $url[0]) {
            return (new LoginController)->logout();
        }
    }
    /**
     * Paduodama informacija iš DB tam tikram puslapiui
     */
    public static function view($name, $data = []) 
    {
        extract($data);
        require DIR . "views/$name.php";
    }
    /**
     * peradrasivimo metodas
     */
    public static function redirect($url) 
    {
        header('Location: '.URL.$url);
        die;
    }
    /**
     *  Sąskaiton Nr. generatorius
     */
    public static function accountNumber()   
    {
        
        $checkedNum = '01';
        $bankCode = '88000';
        $randNumb = '';
        for ($i = 0; $i <= 10; $i++) {
            $rand = (string) rand(0, 9);
            $randNumb .= $rand;
        }
        $accNumber = 'LT' . $checkedNum . $bankCode . $randNumb;
        $accNumber = (string) $accNumber;
        return $accNumber;
    }
    /**
     *  Id Nr. generatorius
     */
    public static function id() : string
    {
        $id = '';
        foreach (range(1, 1) as $nr) {
            $id = rand(1000000000, 9999999999);
        }
        $id = (string) $id;
        return $id;
    }
    /**
     * Pranešimų įrašymas į masyvą
     */
    public static function addMessage(string $type, string $msg) : void
    {
        $_SESSION['msg'][] = ['type' => $type, 'msg' => $msg];
    }
    /**
     * Pranešimų "nunulinimas"
     */
    public static function clearMessages() : void
    {
        $_SESSION['msg'] = [];
    }
    /**
     * Pranešimų atvaizdavimas
     */
    public static function showMessages() : void
    {
        $messages = $_SESSION['msg'];
        self::clearMessages();
        self::view('msg', ['messages' => $messages]);
    }
    /**
     * Patikrinimas ar darbuotojas yra prisijungęs
     */
    public static function isLogged()
    {
        return isset($_SESSION['login']) && $_SESSION['login'] == 1;
    }

}