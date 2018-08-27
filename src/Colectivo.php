<?php

namespace TrabajoTarjeta;

class Colectivo implements ColectivoInterface{
    protected $linea;
    protected $empresa;
    protected $numero;

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
        if($tarjeta->obtenerSaldo() >= $tarjeta->precio){
            $tarjeta->bajarSaldo();
            return new Boleto($tarjeta->precio, $this, $tarjeta);
        }
        else{
            if($tarjeta->obtenerPlus() != 2){
                $tarjeta->aumentarPlus();
                return new Boleto($tarjeta->precio, $this, $tarjeta);
            }
        }
        return false;
    }
}