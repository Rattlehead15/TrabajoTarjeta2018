<?php

namespace TrabajoTarjeta;

class MedioBoletoEstidiantil extends Tarjeta {

    protected $anteriorTiempo;

    public function __construct() {
        $this->precio = ( (new Tarjeta())->precio ) / 2;
    }

    public function obtenerAntTiempo() {
        return $this->anteriorTiempo;
    }

    public function puedePagar(){
        if(($this->tiempo->time()-$this->anteriorTiempo->time())>300) {
            if($this->obtenerSaldo() >= $this->precio){
                $this->bajarSaldo();
                return "normal";
            }
            else{
                if($this->obtenerPlus() != 2){
                    $this->aumentarPlus();
                    return "plus";
                }
            }
        }
        return "no";
    }
}