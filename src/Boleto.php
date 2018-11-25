<?php

namespace TrabajoTarjeta;

class Boleto implements BoletoInterface {

    protected $valor;

    protected $colectivo;

    protected $tarjeta;

    protected $fecha;

    protected $descripcion;

    public function __construct($valor, $colectivo, $tarjeta, $fecha, $tipoPago) {
        $this->valor = $valor;
        $this->colectivo = $colectivo;
        $this->tarjeta = $tarjeta;
        $this->fecha = $fecha;
        switch ($tipoPago) {
            case "un plus":
                $this->descripcion = "Abona viaje plus ".$valor." y";
                break;
            case "dos plus":
                $this->descripcion = "Abona viajes plus ".($valor*2)." y";
                break;
            case "transbordo y un plus":
                $this->descripcion = "Abona viaje plus ".($valor*3)." y";
                break;
            case "transbordo y dos plus":
                $this->descripcion = "Abona viajes plus ".($valor*6)." y";
                break;
        }
    }

    public function obtenerDescripcion() {
        return $this->descripcion;
    }

    public function obtenerValor() {
        return $this->valor;
    }

    public function obtenerTarjeta() {
        return $this->tarjeta;
    }

    public function obtenerFecha() {
        return $this->fecha;
    }

    public function obtenerTipoTarjeta() {
        return get_class($this->tarjeta);
    }

    public function obtenerColectivo() {
        return $this->colectivo;
    }
}