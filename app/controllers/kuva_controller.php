<?php

class KuvaController extends BaseController {

//    public static function index() {
//        $kuvat = Kuva::all();
//
//        self::render_view('home.html', array('kayttajat' => $kayttajat));
//    }

    public static function find($id) {
        $kuva = Kuva::find($id);

        self::render_view('kuva/kuvantiedot.html', array('kuva' => $kuva));
    }

    public static function manage($kayttaja_id){
        self::check_logged_in();
        //$kayttaja = Kayttaja::find($kayttaja_id);
        $kuvat = Kuva::find_by_kayttaja($kayttaja_id);

        self::render_view('kuva/hallinta.html', array('kuvat' => $kuvat, 'kayttaja_id' => $kayttaja_id));
    }

    public static function update($kayttaja_id) {
        $paakuva = $_POST['paakuva'];

        $errors = array();

        Kuva::set_paakuva($paakuva, $kayttaja_id);

        if (isset($_POST['poista']) && is_array($_POST['poista']) ) {
            foreach($_POST['poista'] as $poistettava) {
                if ($poistettava != $paakuva) {
                    Kuva::destroy($poistettava);
                } else {
                    $errors[] = 'Et voi poistaa oletuskuvaasi.';
                }
            }
        }

        if(count($errors) == 0) {
            self::redirect_to('/kayttaja/' . $kayttaja_id, array('message' => 'Kuvien tiedot päivitetty.'));
        } else {
            $kuvat = Kuva::find_by_kayttaja($kayttaja_id);
            self::render_view('kuva/hallinta.html', array('errors' => $errors, 'kayttaja_id' => $kayttaja_id, 'kuvat' => $kuvat));
        }
    }

    public static function store($kayttaja_id) {
       // $params = $_POST;

        $errors = array();

        if (empty($_FILES['kuva']['name'])) {
            $errors[] = 'Kuva ei saa olla tyhjä.';
        }

        if(count($errors) == 0) {
        //    $kayttaja_id = $params['kayttaja_id'];

            $url = Kuva::upload($_FILES['kuva']);
            Kuva::create($kayttaja_id, $url);

            self::redirect_to('/kayttaja/' . $kayttaja_id, array('message' => 'Kuva on lisätty.'));
        } else {
            $kuvat = Kuva::find_by_kayttaja($kayttaja_id);
            self::render_view('kuva/hallinta.html', array('errors' => $errors, 'kayttaja_id' => $kayttaja_id, 'kuvat' => $kuvat));
        }

    }
}

?>