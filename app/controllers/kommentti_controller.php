<?php

class KommenttiController extends BaseController {

    public static function store($kayttaja_id, $kuva_id) {
        $params = $_POST;

        $kommentoija_id = '';
        if(isset($_SESSION['kayttaja'])) {
            $kommentoija_id = $_SESSION['kayttaja'];
        }

        $attributes = array(
            'kayttaja_id' => $kommentoija_id,
            'kuva_id' => $kuva_id,
            'kommenttiteksti' => $params['kommenttiteksti']
        );

        $kommentti = new Kommentti($attributes);

        $errors = $kommentti->errors();

        if(count($errors) == 0) {
            Kommentti::create($attributes);

            self::redirect_to('/kayttaja/' . $kayttaja_id . '/kuva/' . $kuva_id, array('message' => 'Kommenttisi on lisätty.'));
        } else {
            self::redirect_to('/kayttaja/' . $kayttaja_id . '/kuva/' . $kuva_id, array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function destroy($kayttaja_id, $kuva_id, $id) {
        Kommentti::destroy($id);

        self::redirect_to('/kayttaja/' . $kayttaja_id . '/kuva/' . $kuva_id, array('message' => 'Kommentti on poistettu.'));
    }

}

?>