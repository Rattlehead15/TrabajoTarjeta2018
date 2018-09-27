<?php

namespace TrabajoTarjeta;

class MedioBoletoEstudiantil extends Tarjeta {

    public $anteriorTiempo = NULL;

    public function __construct($tiempo) {
        $this->precio = ( (new Tarjeta())->precio ) / 2;
        $this->tiempo = $tiempo;
    }

    public function obtenerAntTiempo() {
        return $this->anteriorTiempo;
    }

    public function puedePagar(){
        $actual = $this->tiempo->time();
        $diferencia = (($actual) - ($this->anteriorTiempo));
        if( $diferencia >= 300 || $this->anteriorTiempo === NULL ) {
            $resultado = parent::puedePagar();
            if($resultado != "no"){
                $this->anteriorTiempo = $actual;
            }
            return $resultado;
        }
        return "no";
    }
}