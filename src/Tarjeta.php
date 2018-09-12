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
      if($this->plus == 1 && $this->saldo >= $this->precio){
        $this->saldo -= $this->precio;
        $this->plus = 0;
      }
      if($this->plus == 2){
        if($this->saldo >= $this->precio && $this->saldo < $this->precio * 2){
          $this->saldo -= $this->precio;
          $this->plus = 1;
        }
        if($this->saldo >= $this->precio * 2){
          $this->saldo -= $this->precio;
          $this->plus = 0;
        }
      }
      return true;
    }
    //Chequea si es alguno de los que sí cargan extra
    if($monto == 510.15){
      $this->saldo += $monto + 81.93 - ($this->plus * $this->precio);
      $this->plus = 0;
      return true;
    }
    if($monto == 962.59){
      $this->saldo += $monto + 221.58 - ($this->plus * $this->precio);
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
   * Retorna "normal" si puede pagar normalmente,
   * "plus" si paga con un viaje plus,
   * "paga un plus" si paga con saldo y ademas abona un plus,
   * "paga dos plus" si abona dos,
   * o "no" en caso contrario,
   * y si puede pagar baja el saldo o los viajes plus de la tarjeta.
   */
  public function puedePagar(){
    if($this->obtenerSaldo() >= $this->precio){
      switch($this->obtenerPlus){
        case 0:
          $this->bajarSaldo();
          return "normal";
          break;
        case 1:
          if($this->obtenerSaldo() >= $this->precio * 2){
            $this->bajarSaldo();
            $this->bajarSaldo();
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
            return "paga dos plus";
          }else if($this->obtenerSaldo() >= $this->precio * 2){
            $this->bajarSaldo();
            $this->bajarSaldo();
            return "paga un plus";
          }else{
            $this->bajarSaldo();
            return "normal";
          }
        
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