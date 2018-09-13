<?php

namespace TrabajoTarjeta;

class MedioBoletoUniversitario extends Tarjeta {

    protected $anteriorTiempo = NULL;

    public $viajesDiarios = 0;

    protected $diaAnterior = NULL;

    public function __construct($tiempo) {
        $this->precio = ( (new Tarjeta())->precio ) / 2;
        $this->tiempo = $tiempo;
    }

    public function puedePagar(){
        $this->cambioDeDia();
        $actual = $this->tiempo->time();
        $diferencia = $actual - ($this->anteriorTiempo);
        if($this->viajesDiarios>=2){
            $this->precio = (new Tarjeta())->precio;
        }else{
            $this->precio = ((new Tarjeta())->precio) / 2;
        }
        if( ($diferencia>=300) || $this->anteriorTiempo === NULL) {
            if($this->obtenerSaldo() >= $this->precio){
                switch($this->obtenerPlus()){
                    case 0:
                        $this->bajarSaldo();
                        $this->anteriorTiempo = $actual;
                        $this->viajesDiarios++;
                        return "normal";
                        break;
                    case 1:
                        if($this->obtenerSaldo() >= $this->precio * 2){
                            $this->bajarSaldo();
                            $this->bajarSaldo();
                            $this->plus--;
                            $this->anteriorTiempo = $actual;
                            $this->viajesDiarios++;
                            return "paga un plus";
                        }else{
                            $this->bajarSaldo();
                            $this->anteriorTiempo = $actual;
                            $this->viajesDiarios++;
                            return "normal";
                        }
                        break;
                    case 2:
                        if($this->obtenerSaldo() >= $this->precio * 3){
                            $this->bajarSaldo();
                            $this->bajarSaldo();
                            $this->bajarSaldo();
                            $this->plus-=2;
                            $this->anteriorTiempo = $actual;
                            $this->viajesDiarios++;
                            return "paga dos plus";
                        }else if($this->obtenerSaldo() >= $this->precio * 2){
                            $this->bajarSaldo();
                            $this->bajarSaldo();
                            $this->plus--;
                            $this->anteriorTiempo = $actual;
                            $this->viajesDiarios++;
                            return "paga un plus";
                        }else{
                            $this->bajarSaldo();
                            $this->anteriorTiempo = $actual;
                            $this->viajesDiarios++;
                            return "normal";
                        }
                        break;
                }
            }
            else {
                if($this->obtenerPlus() != 2){
                    $this->aumentarPlus();
                    $this->anteriorTiempo = $actual;
                    $this->viajesDiarios++;
                    return "usa plus";
                }
            }
            return "no";
        }
        return "no";
    }

    public function cambioDeDia() {
        if($this->diaAnterior!=NULL) {
            if( (($this->tiempo->time()) - ($this->diaAnterior)) >= (3600*24) ){
                $this->viajesDiarios = 0;
                $this->diaAnterior = $this->tiempo->time();
            }
        }
        else{
            $this->diaAnterior=$this->tiempo->time();
        }
    }
}