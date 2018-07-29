<?php 

namespace App\Formats;

use \Exception;

class CustomError {

    public static function format($title, $status, $detail = [], $code = null) {

        $code = ($code == null) ? $status : $code;
        
        $error = ['error' => []];

        $error['error']['title'] = $title;

        $error['error']['code'] = $code;

        $error['error']['status'] = $status;

        $error['error']['detail'] = $detail;

        return $error;
    }
}
?>