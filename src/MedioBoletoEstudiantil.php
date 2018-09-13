<?php

namespace TrabajoTarjeta;

class MedioBoletoEstudiantil extends Tarjeta {

    protected $anteriorTiempo = NULL;

    public function __construct($tiempo) {
        $this->precio = ( (new Tarjeta())->precio ) / 2;
        $this->tiempo = $tiempo;
    }

    public function obtenerAntTiempo() {
        return $this->anteriorTiempo;
    }

    public function puedePagar(){
        $actual = $this->tiempo->time();
        $diferencia = (($actual) - ($this->anteriorTiempo));
        if( $diferencia >= 300 || $this->anteriorTiempo === NULL ) {
            if($this->obtenerSaldo() >= $this->precio){
                switch($this->obtenerPlus()){
                  case 0:
                    $this->bajarSaldo();
                    $this->anteriorTiempo = $actual;
                    return "normal";
                    break;
                  case 1:
                    if($this->obtenerSaldo() >= $this->precio * 2){
                      $this->bajarSaldo();
                      $this->bajarSaldo();
                      $this->plus--;
                      $this->anteriorTiempo = $actual;
                      return "paga un plus";
                    }else{
                      $this->bajarSaldo();
                      $this->anteriorTiempo = $actual;
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
                      return "paga dos plus";
                    }else if($this->obtenerSaldo() >= $this->precio * 2){
                      $this->bajarSaldo();
                      $this->bajarSaldo();
                      $this->plus--;
                      $this->anteriorTiempo = $actual;
                      return "paga un plus";
                    }else{
                      $this->bajarSaldo();
                      $this->anteriorTiempo = $actual;
                      return "normal";
                    }
                    break;
                }
            }
            else{
                if($this->obtenerPlus() != 2){
                    $this->aumentarPlus();
                    $this->anteriorTiempo = $actual;
                    return "usa plus";
                }
            }
        }
        return "no";
    }
}