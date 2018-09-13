<?php

namespace TrabajoTarjeta;

class MedioBoletoUniversitario extends Tarjeta {

    protected $anteriorTiempo = NULL;

    protected $viajesDiarios;

    protected $diaAnterior = NULL;

    protected $diaActual;

    public function __construct() {
        $this->precio = ( (new Tarjeta())->precio ) / 2;
    }

    public function puedePagar(){
        cambioDeDia();
        if($this->viajesDiarios<2){
            if(($this->tiempo->time()-$this->anteriorTiempo->time())>300 || $this->anteriorTiempo == NULL) {
                if($this->obtenerSaldo() >= $this->precio){
                    $this->bajarSaldo();
                    $this->anteriorTiempo = $this->tiempo->time();
                    return "normal";
                }
                else{
                    if($this->obtenerPlus() != 2){
                        $this->aumentarPlus();
                        return "plus";
                    }
                }
                return "no";
            }
        }
        else{
            if($this->obtenerSaldo() >= $this->precio){
                $this->bajarSaldo();
                $this->bajarSaldo();
                $this->anteriorTiempo = $this->tiempo->time();
                return "normal";
            }
            else{
                if($this->obtenerPlus() != 2){
                    $this->aumentarPlus();
                    return "plus";
                }
            }
            return "no";
        }
    }

    public function cambioDeDia() {
        if($this->diaAnterior!=NULL) {
            $this->diaAnterior = date( "d", $this->diaAnterior);
            
            $this->diaActual = date( "d", $this->tiempo->time());
            
            if($this->diaAnterior<$this->diaActual){
                $this->diaAnterior=$this->tiempo->time();
            }
        }
        else{
            $this->diaAnterior=$this->tiempo->time();
        }
    }
}