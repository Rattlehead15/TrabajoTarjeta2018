<?php

namespace TrabajoTarjeta;

class Colectivo implements ColectivoInterface{
    protected $linea;
    protected $empresa;
    protected $numero;
    protected $tiempo;

    public function __construct($linea, $empresa, $numero, $tiempo){
        $this->linea = $linea;
        $this->empresa = $empresa;
        $this->numero = $numero;
        $this->tiempo = $tiempo;
    }

    public function linea(){
        return $this->linea;
    }

    public function empresa(){
        return $this->empresa;
    }

    public function numero(){
        return $this->numero;
    }

    public function pagarCon(TarjetaInterface $tarjeta){
        switch($tarjeta->puedePagar()){
            case "normal":
                return new Boleto($tarjeta->precio, $this, $tarjeta, $this->tiempo->time(), "normal");
                break;
            case "plus":
                return new Boleto($tarjeta->precio, $this, $tarjeta, $this->tiempo->time(), "plus");
                break;
            case "no":
                return false;
        }
    }
}