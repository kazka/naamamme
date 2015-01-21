<?php

class Kuva extends BaseModel{

    public $id, $kayttaja_id, $url, $aika;

    public function __construct($attributes){
        parent::__construct($attributes);
    }

    public static function all() {
        $kuvat = array();

        $rivit = DB::query('SELECT * FROM Kuva');

        foreach ($rivit as $rivi) {
            $kuvat[] = new Kuva(array(
                'id' => $rivi['id'],
                'kayttaja_id' => $rivi['kayttaja_id'],
                'url' => $rivi['url'],
                'aika' => $rivi['aika']
            ));
        }

        return $kuvat;
    }

    public static function find($id) {
        $rivit = DB::query('SELECT * FROM Kuva WHERE id = :id LIMIT 1', array('id' => $id));

        if (count($rivit) > 0) {
            $rivi = $rivit[0];

            $kuva = new Kuva(array(
                'id' => $rivi['id'],
                'kayttaja_id' => $rivi['kayttaja_id'],
                'url' => $rivi['url'],
                'aika' => $rivi['aika']
            ));

            return $kuva;
        }

        return null;
    }

    public static function create() {

    }

    // haetaan tietyn käyttäjän kuvat
    public static function kayttajankuvat($kayttaja_id) {
        $kuvat = array();

        $rivit = DB::query('SELECT * FROM Kuva WHERE kayttaja_id = :kayttaja_id');

        foreach ($rivit as $rivi) {
            $kuvat[] = new Kuva(array(
                'id' => $rivi['id'],
                'kayttaja_id' => $rivi['kayttaja_id'],
                'url' => $rivi['url'],
                'aika' => $rivi['aika']
            ));
        }

        return $kuvat;
    }

}

?>