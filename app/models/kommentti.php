<?php

class Kommentti extends BaseModel{

    public $id, $kayttaja_id, $kuva_id, $kommenttiteksti, $aika;

    public function __construct($attributes){
        parent::__construct($attributes);
    }

    public static function all() {
        $kommentit = array();

        $rivit = DB::query('SELECT * FROM Kommentti');

        foreach ($rivit as $rivi) {
            $kommentit[] = new Kommentti(array(
                'id' => $rivi['id'],
                'kayttaja_id' => $rivi['kayttaja_id'],
                'kuva_id' => $rivi['kuva_id'],
                'kommenttiteksti' => $rivi['kommenttiteksti'],
                'aika' => $rivi['aika']
            ));
        }

        return $kommentit;
    }

    public static function find($id) {
        $rivit = DB::query('SELECT * FROM Kommentti WHERE id = :id LIMIT 1', array('id' => $id));

        if (count($rivit) > 0) {
            $rivi = $rivit[0];

            $kommentti = new Kommentti(array(
                'id' => $rivi['id'],
                'kayttaja_id' => $rivi['kayttaja_id'],
                'kuva_id' => $rivi['kuva_id'],
                'kommenttiteksti' => $rivi['kommenttiteksti'],
                'aika' => $rivi['aika']
            ));

            return $kommentti;
        }

        return null;
    }

    public static function create() {

    }

    // haetaan tietyn kuvan kommentit
    public static function kuvankommentit($kuva_id) {
        $kommentit = array();

        $rivit = DB::query('SELECT * FROM Kommentti WHERE kuva_id = :kuva_id');

        foreach ($rivit as $rivi) {
            $kommentit[] = new Kommentti(array(
                'id' => $rivi['id'],
                'kayttaja_id' => $rivi['kayttaja_id'],
                'kuva_id' => $rivi['kuva_id'],
                'kommenttiteksti' => $rivi['kommenttiteksti'],
                'aika' => $rivi['aika']
            ));
        }

        return $kommentit;
    }

}

?>