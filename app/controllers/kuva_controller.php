<?php

class KuvaController extends BaseController {

    public static function find($id, $kayttaja_id) {
//        $kayttaja = Kayttaja::find($kayttaja_id);
//        $kuvat = Kuva::find_by_kayttaja($kayttaja_id);
//
//        self::render_view('kayttaja/tiedot.html', array('kuvat' => $kuvat, 'kayttaja' => $kayttaja, 'valittukuva' => $id));
    }

    public static function manage($kayttaja_id){
        self::check_logged_in();
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
                    $url = Kuva::find($poistettava)->url;
                    $tiedosto = '/home/kazkaupp/htdocs/tsoha/uploads/' . substr($url, strrpos($url, '/') + 1);

                    if (file_exists($tiedosto)) {
                        unlink($tiedosto);
                    } else {
                        $errors[] = 'Kuvatiedoston poisto ei onnistunut.';
                    }

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
        $errors = Kuva::validate_kuva($_FILES['kuva']['name']);

        if(count($errors) == 0) {
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