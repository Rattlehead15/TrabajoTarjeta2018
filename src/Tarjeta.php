<?php

namespace TrabajoTarjeta;

class Tarjeta implements TarjetaInterface {
    protected $saldo;

    public function recargar($monto) {
      //Chequea si es alguno de los valores aceptados que no cargan dinero extra
      if($monto == 10 || $monto == 20 || $monto == 30 || $monto == 50 || $monto == 100){
        $this->saldo += $monto;
        return true;
      }
      //Chequea si es alguno de los que sí cargan extra
      if($monto == 510.15){
        $this->saldo += $monto + 81.93;
        return true;
      }
      if($monto == 962.59){
        $this->saldo += $monto + 221.58;
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

    /**
     * Reduce el saldo segun la cantidad especificada
     */
    public function reducirSaldo($monto){
      $this->saldo -= $monto;
    }
}
