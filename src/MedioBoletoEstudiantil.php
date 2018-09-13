<?php

namespace TrabajoTarjeta;

class MedioBoletoEstudiantil extends Tarjeta {

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
        }
        return "no";
    }
}