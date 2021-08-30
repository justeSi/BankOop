<?php
namespace Bank\Maria;
use PDO;
class Maria

{
    private static $obj;
    private $data = Array(
        'name' => '',
        'email' => '',
        'password' => ''
        );
    
    public static function get()
    {
        return self::$obj ?? self::$obj = new self;
    }
    // public static function access()
    // {
    //     $host = '127.0.0.1';
    //     $db   = 'user';
    //     $user = 'root';
    //     $pass = '';
    //     $charset = 'utf8mb4';
    
    //     $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    //     $options = [
    //         PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    //         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    //         PDO::ATTR_EMULATE_PREPARES   => false,
    //     ];
    // }
    /**
     * Įrašymas į mariaDB
     */
    public function write($name, $email, $password)
    {
        $host = '127.0.0.1';
        $db   = 'user';
        $user = 'root';
        $pass = '';
        $charset = 'utf8mb4';
    
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $pdo = new PDO($dsn, $user, $pass, $options); //tiltas i DB(PDO objektas)
        $sql = "INSERT INTO users
        (`name`, email, `password`)
        VALUES ('$name', '$email', '$password')"; 
        $pdo->query($sql);
    }
    /**
     * Pagal email suranda ir gražina iš mariaDB darbuotojo slaptažodį
     */
    public function read($email)
    {   
        $host = '127.0.0.1';
        $db   = 'user';
        $user = 'root';
        $pass = '';
        $charset = 'utf8mb4';
    
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $pdo = new PDO($dsn, $user, $pass, $options); //tiltas i DB(PDO objektas)
        $sql = "SELECT `id`, email, `password`
        FROM users
        WHERE `email` = '$email'
        ";
        $stmt = $pdo->query($sql);
        $user = [];
        
        while ($row = $stmt->fetch())
        {
            return $row['password'];
        }
        
    }
    
}