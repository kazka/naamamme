<?php

class Tykkays extends BaseModel{

    public $tykkaaja_id, $tykattava_id;

    public function __construct($attributes){
        parent::__construct($attributes);
    }

//    public static function find($id) {
//        $rivit = DB::query('SELECT * FROM Kommentti WHERE id = :id LIMIT 1', array('id' => $id));
//
//        if (count($rivit) > 0) {
//            $rivi = $rivit[0];
//
//            $kommentti = new Kommentti(array(
//                'id' => $rivi['id'],
//                'kayttaja_id' => $rivi['kayttaja_id'],
//                'kuva_id' => $rivi['kuva_id'],
//                'kommenttiteksti' => $rivi['kommenttiteksti'],
//                'aika' => $rivi['aika']
//            ));
//
//            return $kommentti;
//        }
//
//        return null;
//    }

    public static function create($attributes) {
        $tykkaaja_id = $attributes['tykkaaja_id'];
        $tykattava_id = $attributes['tykattava_id'];

        DB::query("INSERT INTO Tykkays (tykkaaja_id, tykattava_id) VALUES ('$tykkaaja_id', '$tykattava_id')");
    }

    public static function find_by_kuva($kuva_id) {
        $tykkaykset = array();

        $rivit = DB::query('SELECT * FROM Tykkays WHERE tykattava_id = :tykattava_id', array('tykattava_id' => $kuva_id));

        foreach ($rivit as $rivi) {
            $tykkaykset[] = new Tykkays(array(
                'tykkaaja_id' => $rivi['tykkaaja_id'],
                'tykattava_id' => $rivi['tykattava_id']
            ));
        }

        return $tykkaykset;
    }

    public static function find_by_kayttaja($kayttaja_id) {
        $tykkaykset = array();

        $rivit = DB::query('SELECT * FROM Tykkays WHERE kayttaja_id = :kayttaja_id', array('kayttaja_id' => $kayttaja_id));

        foreach ($rivit as $rivi) {
            $tykkaykset[] = new Tykkays(array(
                'tykkaaja_id' => $rivi['tykkaaja_id'],
                'tykattava_id' => $rivi['tykattava_id']
            ));
        }

        return $tykkaykset;
    }

    public static function destroy($tykkaaja_id, $tykattava_id) {
        DB::query("DELETE FROM Tykkays WHERE tykkaaja_id = :tykkaaja_id, tykattava_id = :tykattava_id", array('tykkaaja_id' => $tykkaaja_id, 'tykattava_id' => $tykattava_id));
    }

}

?>