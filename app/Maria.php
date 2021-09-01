<?php
namespace Bank\Maria;
use PDO;
class Maria

{
    private static $obj;
    public  $pdo;
    private $data = Array(
        'name' => '',
        'email' => '',
        'password' => ''
        );
    
    public static function get()
    {
        return self::$obj ?? self::$obj = new self;
    }
    public  function __construct()
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
        $this->pdo = new PDO($dsn, $user, $pass, $options);
    }
    /**
     * Įrašymas į mariaDB
     */
    public function write($name, $email, $password)
    {
        $sql = "INSERT INTO users
        (`name`, email, `password`)
        VALUES (?, ?, ?)"; 
        $stmt=$this->pdo->prepare($sql);
        $stmt->execute([ $name, $email, $password]);
    }
    /**
     * Pagal email suranda ir gražina iš mariaDB darbuotojo slaptažodį
     */
    public function read($email)
    {   
        $sql = "SELECT `id`, email, `password`
        FROM users
        WHERE `email` = ?
        ";
        $stmt=$this->pdo->prepare($sql);
        $stmt->execute([$email]);
        $user = [];
        
        while ($row = $stmt->fetch())
        {
            return $row['password'];
        }
        
    }
    
}