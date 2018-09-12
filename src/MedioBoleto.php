<?php

namespace TrabajoTarjeta;

class MedioBoleto extends Tarjeta {
    public function __construct(){
        $this->precio = ( (new Tarjeta())->precio ) / 2;
    }
}