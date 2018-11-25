<?php

namespace TrabajoTarjeta;

class Colectivo implements ColectivoInterface {
    protected $linea;
    protected $empresa;
    protected $numero;
    protected $tiempo;

    public function __construct($linea, $empresa, $numero, $tiempo) {
        $this->linea = $linea;
        $this->empresa = $empresa;
        $this->numero = $numero;
        $this->tiempo = $tiempo;
    }

    public function linea() {
        return $this->linea;
    }

    public function empresa() {
        return $this->empresa;
    }

    public function numero() {
        return $this->numero;
    }

    public function tiempo() {
        return $this->tiempo->time();
    }

    public function pagarCon(TarjetaInterface $tarjeta) {
        switch ($tarjeta->puedePagar($this->linea, $this->empresa, $this->numero)) {
            case "normal":
                return new Boleto($tarjeta->precio, $this, $tarjeta, $this->tiempo->time(), "normal");
                break;
            case "usa plus":
                return new Boleto(0, $this, $tarjeta, $this->tiempo->time(), "usa plus");
                break;
            case "paga un plus":
                return new Boleto($tarjeta->precio, $this, $tarjeta, $this->tiempo->time(), "un plus");
                break;
            case "paga dos plus":
                return new Boleto($tarjeta->precio, $this, $tarjeta, $this->tiempo->time(), "dos plus");
                break;
            case "transbordo normal":
                return new Boleto(($tarjeta->precio)/3, $this, $tarjeta, $this->tiempo->time(), "transbordo");
                break;
            case "transbordo y paga un plus":
                return new Boleto(($tarjeta->precio)/3, $this, $tarjeta, $this->tiempo->time(), "transbordo y un plus");
                break;
            case "transbordo y paga dos plus":
                return new Boleto(($tarjeta->precio)/3, $this, $tarjeta, $this->tiempo->time(), "transbordo y dos plus");
                break;
            default:
                return false;
        }
    }
}
