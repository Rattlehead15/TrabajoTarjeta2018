<?php

namespace TrabajoTarjeta;

class MedioBoletoUniversitario extends Tarjeta {

    protected $viajesDiarios = 0;

    protected $diaAnterior = null;

    public function __construct($tiempo) {
        $this->precio = ((new Tarjeta(new TiempoFalso(0)))->precio) / 2;
        $this->tiempo = $tiempo;
    }

    public function puedePagar($linea, $empresa, $numero) {
        $this->cambioDeDia();
        $actual = $this->tiempo->time();
        $diferencia = $actual-($this->anteriorTiempo);
        if ($this->viajesDiarios >= 2) {
            $this->precio = (new Tarjeta(new TiempoFalso(0)))->precio;
        } else {
            $this->precio = ((new Tarjeta(new TiempoFalso(0)))->precio) / 2;
        }
        if (($diferencia >= 300) || $this->anteriorTiempo === null) {
            $resultado = parent::puedePagar($linea, $empresa, $numero);
            if ($resultado != "no") {
                $this->anteriorTiempo = $actual;
                $this->viajesDiarios++;
            }
            return $resultado;
        }
        return "no";
    }

    /**
     * Cambia "diaAnterior" al tiempo actual.
     * Cambia "viejesDiarios" a 0 si nunca se viajo o si ya paso un dia entero desde el ultimo viaje.
     */
    public function cambioDeDia() {
        if ($this->diaAnterior != null) {
            if ((($this->tiempo->time())-($this->diaAnterior)) >= (3600 * 24)) {
                $this->viajesDiarios = 0;
            }
        }
        $this->diaAnterior = $this->tiempo->time();
    }
}