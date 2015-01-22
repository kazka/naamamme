<?php

class KayttajaController extends BaseController {

    public static function index() {
        $kayttajat = Kayttaja::all();

        self::render_view('home.html', array('kayttajat' => $kayttajat));
    }

    public static function find($id) {
        $kayttaja = Kayttaja::find($id);
        $kuvat = Kuva::kayttajankuvat($id);

        self::render_view('kayttaja/tiedot.html', array('kayttaja' => $kayttaja, 'kuvat' => $kuvat));
    }

    public static function store() {
        $params = $_POST;

        $id = Kayttaja::create(array(
            'nick' => $params['nick'],
            'nimi' => $params['nimi'],
            'salasana' => $params['salasana']
        ));

        self::redirect_to('/kayttaja/' . $id, array('viesti' => 'Kiitos liittymisestä!'));
    }

    public static function destroy($id) {
        Kayttaja::destroy($id);

        self::redirect_to('/kayttaja', array('viesti' => 'Käyttäjä on poistettu.'));
    }

    public static function add() {
        self::render_view('/kayttaja/liity.html');
    }

    public static function edit($id){
        $kayttaja = Kayttaja::find($id);

        self::render_view('/kayttaja/muokkaus.html', array('kayttaja' => $kayttaja));
    }
}

?>