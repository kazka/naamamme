<?php

class Kayttaja extends BaseModel{

    public $id, $nick, $nimi, $salasana;

    public function __construct($attributes){
        parent::__construct($attributes);

        $this->validators = array('validate_nick', 'validate_nimi');
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

    public static function create($attributes) {
        $nick = $attributes['nick'];
        $nimi = $attributes['nimi'];
        $salasana = $attributes['salasana'];

        $kayttaja = DB::query("INSERT INTO Kayttaja (nick, nimi, salasana) VALUES('$nick', '$nimi', '$salasana') RETURNING id");

        return $kayttaja[0]['id'];
    }

    public static function destroy($id) {
        DB::query("DELETE FROM Kayttaja WHERE id = :id", array('id' => $id));
    }

    public static function update($id, $attributes) {
        //$nick = $attributes['nick'];
        $nimi = $attributes['nimi'];
        $salasana = $attributes['salasana'];

        DB::query("UPDATE Kayttaja SET nimi = :nimi, salasana = :salasana WHERE id = :id", array('id' => $id, 'nimi' => $nimi, 'salasana' => $salasana));
    }

    public static function authenticate($nick, $salasana) {
        $rivit = DB::query("SELECT * FROM Kayttaja WHERE nick = :nick AND salasana = :salasana", array('nick' => $nick, 'salasana' => $salasana));

        if(count($rivit) == 0) {
            return false;
        } else {
            $rivi = $rivit[0];

            $kayttaja = new Kayttaja(array(
                'id' => $rivi['id'],
                'nick' => $rivi['nick'],
                'nimi' => $rivi['nimi'],
                'salasana' => $rivi['salasana']
            ));

            return $kayttaja;
        }
    }

    public function kuvat() {
        return Kuva::find_by_kayttaja($this->id);
    }

//    public function get_nick($id) {
//        $rivit = DB::query("SELECT * FROM Kayttaja WHERE id = :id", array('id' => $id));
//
//        if (count($rivit) > 0) {
//            $rivi = $rivit[0];
//
//            $nick = $rivi['nick'];
//
//            return $nick;
//        }
//
//        return null;
//    }

    public function validate_nick() {
        $errors = array();

        if($this->nick == '' || $this->nick == null) {
            $errors[] = 'Nick ei saa olla tyhjä.';
        }
        if(strlen($this->nick) < 3) {
            $errors[] = 'Nickin on oltava vähintään 3 merkkiä pitkä.';
        }

        $rivit = DB::query("SELECT COUNT(*) as riveja FROM Kayttaja WHERE nick = :nick", array('nick' => $this->nick));

        if(($rivit[0]['riveja']) > 0 ) {
            $errors[] = 'Nick on varattu.';
        }

        return $errors;
    }

    public function validate_nimi() {
        $errors = array();

        if($this->nimi == '' || $this->nimi == null) {
            $errors[] = 'Nimi ei saa olla tyhjä.';
        }
        if(strlen($this->nimi) < 3) {
            $errors[] = 'Nimen on oltava vähintään 3 merkkiä pitkä.';
        }

        return $errors;
    }

}

?>