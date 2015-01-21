<?php

class Kayttaja extends BaseModel{

    public $id, $nick, $nimi, $salasana;

    public function __construct($attributes){
        parent::__construct($attributes);
    }

    public static function all() {
        $kayttajat = array();

        $rivit = DB::query('SELECT * FROM Kayttaja');

        foreach ($rivit as $rivi) {
            $kayttajat[] = new Kayttaja(array(
                'id' => $rivi['id'],
                'nick' => $rivi['nick'],
                'nimi' => $rivi['nimi'],
                'salasana' => $rivi['salasana']
            ));
        }

        return $kayttajat;
    }

    public static function find($id) {
        $rivit = DB::query('SELECT * FROM Kayttaja WHERE id = :id LIMIT 1', array('id' => $id));

        if (count($rivit) > 0) {
            $rivi = $rivit[0];

            $kayttaja = new Kayttaja(array(
                'id' => $rivi['id'],
                'nick' => $rivi['nick'],
                'nimi' => $rivi['nimi'],
                'salasana' => $rivi['salasana']
            ));

            return $kayttaja;
        }

        return null;
    }

    public static function create() {

    }

}

?>