<?php

namespace Bank\Darbuotojai\Login;


class Json {

    private static $obj;
    private $data;
    /**
    * Tikrinamas ar Json objektas sukurtas, jei ne sukuriamas naujas ir vienetinis
    */
    public static function get()
    {
        return self::$obj ?? self::$obj = new self;
    }
    
    private function __construct()
    {
        if (!file_exists(DIR.'data/users.json')) { // Tikrinama ar yra Json failas, jei ne jis sukuriamas
            file_put_contents(DIR.'data/users.json', json_encode([]));//konvertavimas ir įrašymas
        }
        $this->data = json_decode(file_get_contents(DIR.'data/users.json'), 1);// įrašoma data į jau egzistuojantį Json failą
    }

    public function __destruct()
    {
        file_put_contents(DIR.'data/users.json', json_encode($this->data));  //konvertavimas ir įrašymas
    }

    /**
     * Gražina informacija apie subjektą naudojant subjekto El. paštą
     */
    function show(string $userEmail) : array
    {
        foreach ($this->data as $user) {
            if ($user['email'] == $userEmail) {
                return $user;
            }
        }
        return [];// neradus atitikmens grąžinamas tuščias masyvas
    }
}