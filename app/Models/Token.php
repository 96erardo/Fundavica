<?php

namespace App\Models;

class Token {

    private $token;

    private $header;

    private $payload;

    private $signature;

    private $attributes;


    public function __construct ($token) {
        
        $jwt = explode('.', $token);
        
        $this->token = $token;
        $this->header = $jwt[0];
        $this->payload = $jwt[1];
        $this->signature = $jwt[2];
        $this->attributes = json_decode(base64_decode($this->payload));
    }

    public function get ($key = null) {
        if ($key != null)
            return $this->attributes->$key;

        return $this->attributes;
    }
}