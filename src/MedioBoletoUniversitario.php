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
                    switch($this->obtenerPlus()){
                      case 0:
                        $this->bajarSaldo();
                        return "normal";
                        break;
                      case 1:
                        if($this->obtenerSaldo() >= $this->precio * 2){
                          $this->bajarSaldo();
                          $this->bajarSaldo();
                          $this->plus--;
                          return "paga un plus";
                        }else{
                          $this->bajarSaldo();
                          return "normal";
                        }
                        break;
                      case 2:
                        if($this->obtenerSaldo() >= $this->precio * 3){
                          $this->bajarSaldo();
                          $this->bajarSaldo();
                          $this->bajarSaldo();
                          $this->plus-=2;
                          return "paga dos plus";
                        }else if($this->obtenerSaldo() >= $this->precio * 2){
                          $this->bajarSaldo();
                          $this->bajarSaldo();
                          $this->plus--;
                          return "paga un plus";
                        }else{
                          $this->bajarSaldo();
                          return "normal";
                        }
                        break;
                    }
                }
                else{
                    if($this->obtenerPlus() != 2){
                        $this->aumentarPlus();
                        return "usa plus";
                    }
                }
                return "no";
            }
        }
        else{
            if($this->obtenerSaldo() >= $this->precio * 2){
                switch($this->obtenerPlus()){
                  case 0:
                    $this->bajarSaldo();
                    $this->bajarSaldo();
                    return "normal";
                    break;
                  case 1:
                    if($this->obtenerSaldo() >= $this->precio * 4){
                      $this->bajarSaldo();
                      $this->bajarSaldo();
                      $this->bajarSaldo();
                      $this->bajarSaldo();
                      $this->plus--;
                      return "paga un plus";
                    }else{
                      $this->bajarSaldo();
                      return "normal";
                    }
                    break;
                  case 2:
                    if($this->obtenerSaldo() >= $this->precio * 6){
                      $this->bajarSaldo();
                      $this->bajarSaldo();
                      $this->bajarSaldo();
                      $this->bajarSaldo();
                      $this->bajarSaldo();
                      $this->bajarSaldo();
                      $this->plus-=2;
                      return "paga dos plus";
                    }else if($this->obtenerSaldo() >= $this->precio * 4){
                      $this->bajarSaldo();
                      $this->bajarSaldo();
                      $this->bajarSaldo();
                      $this->bajarSaldo();
                      $this->plus--;
                      return "paga un plus";
                    }else{
                      $this->bajarSaldo();
                      $this->bajarSaldo();
                      return "normal";
                    }
                    break;
                }
            }
            else{
                if($this->obtenerPlus() != 2){
                    $this->aumentarPlus();
                    return "usa plus";
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