<?php

class TykkaysController extends BaseController {


    public static function store($kayttaja_id, $kuva_id) {
        $params = $_POST;

        $tykkaaja_id = '';
        if(isset($_SESSION['kayttaja'])) {
            $tykkaaja_id = $_SESSION['kayttaja'];
        }

        $attributes = array(
            'tykkaaja_id' => $tykkaaja_id,
            'tykattava_id' => $kuva_id
        );

        Tykkays::create($attributes);

        self::redirect_to('/kayttaja/' . $kayttaja_id . '/kuva/' . $kuva_id, array('message' => 'Tykkäyksesi on lisätty.'));

    }

}

?>