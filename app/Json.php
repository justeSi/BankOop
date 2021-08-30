<?php
namespace Json\Db;
use App\DB\DataBase;
class Json implements DataBase
{
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
        if (!file_exists(DIR.'data/accounts.json')) {// Tikrinama ar yra Json failas, jei ne jis sukuriamas
            file_put_contents(DIR.'data/accounts.json', json_encode([]));//konvertavimas ir įrašymas
        }
        $this->data = json_decode(file_get_contents(DIR.'data/accounts.json'), 1);// įrašoma data į jau egzistuojantį Json failą
    }


    public function __destruct()     
    {
        file_put_contents(DIR.'data/accounts.json', json_encode($this->data));//konvertavimas ir įrašymas
    }
    /**
     * Mayvo pridėjimas į Json
     */
    public function create(array $userData) : void
    {
        $this->data[] = $userData;
    }
    /**
     * data atnaujinimas Json faile
     */
    public function update(int $userId, array $userData) : void
    {
        foreach ($this->data as $key => $user) {
            if ($user['id'] == $userId) {
                $this->data[$key] = $userData;
            }
        }
    }
    /**
     * Pašalinimas iš Json failo
     */
    public function delete(int $userId) : void
    {
        foreach ($this->data as $key => $user) {
            if ($user['id'] == $userId) {
                unset($this->data[$key]);
            }
        }
    }
    /**
     * Data suradimas pagal Id Json faile ir gražinamas vartotojo masyvas
     */
    public function show(int $userId) : array
    {
        foreach ($this->data as $user) {
            if ($user['id'] == $userId) {
                return $user;
            }
        }
        return [];// nieko neradus gražinamas tuųčias masyvas
    }
    /**
     * Data suradimas pagal asmens kodą Json faile ir gražinamas vartotojo masyvas
     */
    public function showAk(string $personalId) : array
    {
        foreach ($this->data as $user) {
            if ($user['personalId'] == $personalId) {
                return $user;
            }
        }
        return [];// nieko neradus gražinamas tuųčias masyvas
    }
    /**
     * Visų duomenų esančių Json faile ištraukimas
     */
    public function showAll() : array
    {   
        usort($this->data, function($a, $b){return $a['surname'] <=> $b['surname'];});// Rykiavimas pagal pavardę
        return $this->data;
    }
}