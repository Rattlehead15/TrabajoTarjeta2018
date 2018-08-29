<?php

namespace TrabajoTarjeta;

class Tarjeta implements TarjetaInterface {
    protected $saldo;
    //Que la variable plus comience desde 0 se refiere a que todavia no se ha usado ningun viaje plus
    protected $plus = 0;

    public $precio = 14.80;

    public function recargar($monto) {
      //Chequea si es alguno de los valores aceptados que no cargan dinero extra
      if($monto == 10 || $monto == 20 || $monto == 30 || $monto == 50 || $monto == 100){
        $this->saldo += $monto;
        if($this->plus == 1 && $this->saldo >= 14.80){
          $this->saldo -= 14.80;
          $this->plus = 0;
        }
        if($this->plus == 2){
          if($this->saldo >= 14.80 && $this->saldo < 29.60){
            $this->saldo -= 14.80;
            $this->plus = 1;
          }
          if($this->saldo >= 29.60){
            $this->saldo -= 29.60;
            $this->plus = 0;
          }
        }
        return true;
      }
      //Chequea si es alguno de los que sí cargan extra
      if($monto == 510.15){
        $this->saldo += $monto + 81.93 - ($this->plus * 14.80);
        $this->plus = 0;
        return true;
      }
      if($monto == 962.59){
        $this->saldo += $monto + 221.58 - ($this->plus * 14.80);
        $this->plus = 0;
        return true;
      }
      //Si no es ninguno de esos valores entonces no es un valor aceptado y hay que retornar false
      return false;
    }

    /**
     * Devuelve el saldo que le queda a la tarjeta.
     *
     * @return float
     */
    public function obtenerSaldo() {
      return $this->saldo;
    }


    public function bajarSaldo(){
      $this->saldo -= $this->precio;
    }

    /**
     * Devuelve la cantidad de viajes plus que uso la tarjeta.
     *
     * @return int
     */
    public function obtenerPlus() {
      return $this->plus;
    }

    /**
     * Aumenta la cantidad de viajes plus usados.
     * 
     */
    public function aumentarPlus(){
      $this->plus ++;
    }

    /**
     * Retorna true si puede pagar o false en saco contrario.
     * 
     */
    public function puedePagar(){
      if($this->obtenerSaldo() >= 14.80){
        return true;
      }
      else{
        if($this->obtenerPlus() != 2){
          $this->aumentarPlus();
            return true;
        }
      }
      return false;
    }
}
