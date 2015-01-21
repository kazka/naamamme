<?php

class KayttajaController extends BaseController {

    public static function index() {
        $kayttajat = Kayttaja::all();

        self::render_view('home.html', array('kayttajat' => $kayttajat));
    }

    public static function tiedot($id) {
        $kayttaja = Kayttaja::find($id);
        $kuvat = Kuva::kayttajankuvat($id);

        self::render_view('tiedot.html', array('kayttaja' => $kayttaja, 'kuvat' => $kuvat));
    }
}

?>