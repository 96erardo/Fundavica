<?php 

namespace App\Formats;

use \Exception;

class Error {

    public static function format(Exception $e, $status = null) {
        
        $error = ['error' => []];

        $error['error']['title'] = utf8_encode($e->getMessage());

        $error['error']['code'] = $e->getCode();

        $error['error']['status'] = $status;

        $error['error']['detail'] = array_slice($e->getTrace(), 0, 10);

        return $error;
    }
}
?>