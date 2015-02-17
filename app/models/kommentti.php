<?php

class Kommentti extends BaseModel{

    public $id, $kayttaja_id, $kuva_id, $kommenttiteksti, $aika;

    public function __construct($attributes){
        parent::__construct($attributes);

        $this->validators = array('validate_kommentti');
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
        $rivit = DB::query('SELECT * FROM Kommentti WHERE id = :id LIMIT 1',
            array('id' => $id));

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

    public static function create($attributes) {
        $kayttaja_id = $attributes['kayttaja_id'];
        $kuva_id = $attributes['kuva_id'];
        $kommenttiteksti = $attributes['kommenttiteksti'];

        DB::query("INSERT INTO Kommentti (kayttaja_id, kuva_id, kommenttiteksti, aika) VALUES (:kayttaja_id, :kuva_id, :kommenttiteksti, 'NOW()')",
            array('kayttaja_id' => $kayttaja_id, 'kuva_id' => $kuva_id, 'kommenttiteksti' => $kommenttiteksti));
    }

    // haetaan tietyn kuvan kommentit
    public static function find_by_kuva($kuva_id) {
        $kommentit = array();

        $rivit = DB::query('SELECT * FROM Kommentti WHERE kuva_id = :kuva_id',
            array('kuva_id' => $kuva_id));

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

    public static function destroy($id) {
        DB::query("DELETE FROM Kommentti WHERE id = :id",
            array('id' => $id));
    }

//    public static function destroy_from_kayttaja($kayttaja_id) {
//        DB::query("DELETE FROM Kommentti WHERE kayttaja_id = :kayttaja_id", array('kayttaja_id' => $kayttaja_id));
//    }
//
//    public static function destroy_from_kuva($kuva_id) {
//        DB::query("DELETE FROM Kommentti WHERE kuva_id = :kuva_id", array('kuva_id' => $kuva_id));
//    }

    public function nick() {
        return Kayttaja::find($this->kayttaja_id)->nick;
    }

    public function validate_kommentti() {
        $errors = array();

        if($this->kommenttiteksti == '' || $this->kommenttiteksti == null) {
            $errors[] = 'Yritit lähettää tyhjän kommentin.';
        }
        if(strlen($this->kommenttiteksti) > 500) {
            $errors[] = 'Kommenttisi on liian pitkä.';
        }

        return $errors;
    }

}

?>