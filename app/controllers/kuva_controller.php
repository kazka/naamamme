<?php

class KuvaController extends BaseController {

//    public static function index() {
//        $kuvat = Kuva::all();
//
//        self::render_view('home.html', array('kayttajat' => $kayttajat));
//    }

    public static function tiedot($id) {
        $kuva = Kuva::find($id);

        //self::render_view('tiedot.html', array('kayttaja' => $kayttaja));
    }
}

?>