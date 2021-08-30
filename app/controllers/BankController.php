<?php
namespace Bank\Router\Controllers;
use Bank\Router\App;
use Acc\User\User;
use Json\Db\Json;

class BankController
{   
    /**
    * Kreipimasis į Json
    */
    private $settings = 'Json';
    private function get()
    {
        $db = 'Json\\Db\\'.$this->settings;
        return $db::get();
    }
    /**
    * Patikrinimas ar vartotojas prisijungęs. "Durų" atrakinimas.
    */
    public function __construct()
    {
        if (!App::isLogged()) {
            App::redirect('login');
        }
    }
    /**
    * Vartotojių atvaizdavimas "list" tinklapyje
    */
    public function index()
    {
        $users = $this->get()->showAll();

        return App::view('list', ['users' => $users]);
    }
    /**
    * Nukreipimas į Vartotojių atvaizdavimo "list" tinklapyje
    */ 
    public function showList()
    {
        return App::view('list');
    }

    /**
    * Nukreipimas į naujo vartotojo pridėjimo puslapį
    */ 
    public function createAcc()
    {
        return App::view('create');
    }
    /**
    * Nukreipimas į vartotojo sąskaitos puslapį ir pateikiama jo esama informacija
    */
    public function addAmount($id)
    {
        $users = $this->get()->show($id);
        
        return App::view('addAmount', ['users' => $users]);
    }
    /**
    * Nukreipimas į vartotojo sąskaitos puslapį ir pateikiama jo esama informacija
    */
    public function remAmount($id)
    {
        $users = $this->get()->show($id);
        return App::view('remAmount', ['users' => $users]);
    }

    /**
    * Atnaujinama vartotojo sąskaitos informacija po piniginės operacijos
    */
    public function update($action, $id)
    {
        $user = $this->get()->show($id);
        //įvedimo validacija
        if ((($_POST['add'] === '') ||  ($_POST['add'] < 0 ))|| !is_numeric($_POST['add'])) {
            App::addMessage('danger', 'Neteisingas įvedimas');
        } 
        else {
            if ($action == 'add' ){
                $user['balance'] += round((float)$_POST['add'], 2);
                App::addMessage('success', 'Pinigai prideti');
            }
            elseif ($action == 'rem'){
                if (($user['balance'] - (float)$_POST['add'] < 0)) {//tikrinama ar įvesta suma nedidesnė nei likutis sąskaitoje
                    App::addMessage('danger', 'Sąskaitoje nepakankamas likutis operacijai įvykdyti');
                }
                else {
                    (float)$user['balance'] -= round((float)$_POST['add'], 2);
                    App::addMessage('success', 'Pinigai nuskaičiuoti');
                }
            }
            
        }
        $this->get()->update($id, $user);
        App::redirect('list');
    }
    /**
    * Surenkama naujo vartotojo informacija, ji patikrinama ir įrašoma į Json
    */
    public function store()     
    {
        if(!empty($_POST) 
        && 
        self::validName($_POST['fname']) 
        &&
        self::validName($_POST['lname'])
        &&
        self::validPersonalId($_POST['ak']) ){
        

            $user = new User;
            $user -> id = ($_POST['id'] ?? 0);
            $user -> name = ucfirst(strtolower($_POST['fname'] ?? 0));
            $user -> surname = ucfirst(strtolower($_POST['lname'] ?? 0));
            $user -> acc = ($_POST['acc'] ?? 0);
            $user -> personalId = ($_POST['ak'] ?? 0);
            $user -> balance = ($_POST['balance'] ?? 0);
            $data =  json_decode(json_encode($user), 1); //konvertacija iš objekto i masyvą
            Json::get()->create($data); 
            
            
            App::addMessage('success', 'Vartotojas pridėtas į sistemą');
            App::redirect('create');
        }
        else 
            App::redirect('create'); 
        }
    /**
    * Vartotojo pašalinimas iš sąrašo
    */    
    public function delete($id)
    {   
        $data = $this->get()->show($id);
        if ($data['balance'] == 0){
            $this->get()->delete($id);
            App::addMessage('success', 'Vartotojas pašalintas iš sistemos');
        }
        else {
            App::addMessage('danger', 'Sąskaitos, kurioje yra pinigų ištrinti negalima');
        }
        App::redirect('list');
    }
    /**
    * Vardo / Pavardės tikrinimas
    */
    public static function validName(string $name) 
    {   
        if ((strlen($name) < 3))  {
            App::addMessage('danger', 'Vartotojas nesukurtas, nes vardas/pavardė turi būti ilgesni');
            return 0;
        } elseif (( preg_match('/\d|\s/', $name) )) {//jei yra skaičių arba tarpų
            App::addMessage('danger', 'Varde/pavardėje skaitmenys/tarpai neleidziami');
            return 0;
        } else {
            return 1;
        }
    }
    /**
    * Asmens kodo tikrinimas
    */
    public function validPersonalId($ak) 
    {
        $data = Json::get()->showAk($ak);
        _d($data);

        if (strlen($ak) == 11 && (( preg_match('/[a-z, A-Z]/', $ak) == 0))) // vien tik skaičiai ir ilgis ąą simbilių
        {   
            //ar asmens kodas nesikartoja
            foreach ($data as $key => $val) {
                if ( $data['personalId'] == $ak) {
                    App::addMessage('danger', 'Vartotojas su tokiu asmens kodu jau yra sistemoje');
                    return  0;
                }
            }
            // pirmo skaitmens pagal įmanoma gyvenimo amžių (teoriškai ir lytį) validacija 
            if (substr($ak, 0,1) > 7 || substr($ak, 0,1) < 2) {

                App::addMessage('danger', 'Asmens kodas negaliojantis');
                return 0;
            }
            //Kontrolinio skaičiaus apskaičiavimas
            $arr  = array_map('intval', str_split($ak));
            $sum = ($arr[0] * 1) + ($arr[1] * 2) + ($arr[2] * 3) + ($arr[3] * 4) + ($arr[4] * 5) + ($arr[5] * 6) + ($arr[6] * 7) +
            ($arr[7] * 8) + ($arr[8] * 9) + ($arr[9] * 1);
            
            if ($sum % 11 == 10) {
                $sum = ($arr[0] * 3) + ($arr[1] * 4) + ($arr[2] * 5) + ($arr[3] * 6) + ($arr[4] * 7) + ($arr[5] * 8) + ($arr[6] * 9) + ($arr[7] * 1) + ($arr[8] * 2) + ($arr[9] * 3);
            }
            if ($sum % 11 != 10) {
                if ($sum % 11 == $arr[10]) {
                        return 1;
                    }
                }
                
                if($sum % 11 == 10 && $arr[10] == 0) {
                    return 1;
                }
                else {
                    App::addMessage('danger', 'Neteisingas kontrolinis skaičius ');
                }
        }
    else {
        App::addMessage('danger', 'Asmens kodas neatitinka nustatytų LR taisyklių');
        return 0;
        }
    }
}
        
        
        
    
        
    

    