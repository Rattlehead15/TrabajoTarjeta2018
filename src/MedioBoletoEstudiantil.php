<?php

namespace TrabajoTarjeta;

class MedioBoletoEstudiantil extends Tarjeta {

    public $anteriorTiempo = null;

    public function __construct($tiempo) {
        $this->precio = ((new Tarjeta(new TiempoFalso(0)))->precio) / 2;
        $this->tiempo = $tiempo;
    }

    /**
     * Devuelve el tiempo del anterior viaje hecho.
     *
     * @return TiempoInterface
     */
    public function obtenerAntTiempo() {
        return $this->anteriorTiempo;
    }

    public function puedePagar($linea, $empresa, $numero) {
        $actual = $this->tiempo->time();
        $diferencia = (($actual)-($this->obtenerAntTiempo()));
        if ($diferencia >= 300 || $this->obtenerAntTiempo() === null) {
            $resultado = parent::puedePagar($linea, $empresa, $numero);
            if ($resultado != "no") {
                $this->anteriorTiempo = $actual;
            }
            return $resultado;
        }
        return "no";
    }
}