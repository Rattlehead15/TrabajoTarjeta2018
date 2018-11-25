<?php

namespace TrabajoTarjeta;

class Tarjeta implements TarjetaInterface {
  protected $saldo;
  
  //Que la variable plus comience desde 0 se refiere a que todavia no se ha usado ningun viaje plus
  protected $plus = 0;

  public $precio = 14.80;

  public $tiempo;

  public $anteriorTiempo = null;

  public $anteriorColectivo = null;

  public $actualColectivo;

  public function __construct($tiempo, $saldo = 0) {
    $this->tiempo = $tiempo;
    $this->saldo = $saldo;
  }

  public function recargar($monto) {
    //Chequea si es alguno de los valores aceptados que no cargan dinero extra
    if ($monto == 10 || $monto == 20 || $monto == 30 || $monto == 50 || $monto == 100) {
      $this->saldo += $monto;
      if ($this->plus == 1 && $this->saldo >= $this->precio) {
        $this->saldo -= $this->precio;
        $this->plus = 0;
      }
      if ($this->plus == 2) {
        if ($this->saldo >= $this->precio && $this->saldo < $this->precio * 2) {
          $this->saldo -= $this->precio;
          $this->plus = 1;
        }
        if ($this->saldo >= $this->precio * 2) {
          $this->saldo -= $this->precio;
          $this->plus = 0;
        }
      }
      return true;
    }
    //Chequea si es alguno de los que sí cargan extra
    if ($monto == 510.15) {
      $this->saldo += $monto + 81.93 - ($this->plus * $this->precio);
      $this->plus = 0;
      return true;
    }
    if ($monto == 962.59) {
      $this->saldo += $monto + 221.58 - ($this->plus * $this->precio);
      $this->plus = 0;
      return true;
    }
    //Si no es ninguno de esos valores entonces no es un valor aceptado y hay que retornar false
    return false;
  }

  public function obtenerSaldo() {
    return $this->saldo;
  }


  public function bajarSaldo($montito) {
    $this->saldo -= $montito;
  }

  public function obtenerPlus() {
    return $this->plus;
  }

  public function aumentarPlus() {
    $this->plus ++;
  }

  public function puedePagar($linea, $empresa, $numero) {
    $this->actualColectivo = array($linea, $empresa, $numero);
    if ($this->obtenerSaldo() >= $this->precio) {
      switch ($this->obtenerPlus()) {
        case 0:
          if ($this->trasbordoPermitido($this->actualColectivo)) {
            $this->bajarSaldo($this->precio / 3);
            return "transbordo normal";
          }
          else {
            $this->bajarSaldo($this->precio);
            return "normal";
          }
          break;
        case 1:
          if ($this->trasbordoPermitido($this->actualColectivo)) {
            if ($this->obtenerSaldo() >= $this->precio * 4/3) {
              $this->bajarSaldo($this->precio / 3);
              $this->bajarSaldo($this->precio);
              $this->plus--;
              return "transbordo y paga un plus";
            } else {
              $this->bajarSaldo($this->precio / 3);
              return "transbordo normal";
            }
          }
          if ($this->obtenerSaldo() >= $this->precio * 2) {
            $this->bajarSaldo($this->precio);
            $this->bajarSaldo($this->precio);
            $this->plus--;
            return "paga un plus";
          } else {
            $this->bajarSaldo($this->precio);
            return "normal";
          }
          break;
        case 2:
          if ($this->trasbordoPermitido($this->actualColectivo)) {
            if ($this->obtenerSaldo() >= $this->precio * 7/3) {
              $this->bajarSaldo($this->precio);
              $this->bajarSaldo($this->precio);
              $this->bajarSaldo($this->precio / 3);
              $this->plus-=2;
              return "transbordo y paga dos plus";
            } else if ($this->obtenerSaldo() >= $this->precio * 4/3) {
              $this->bajarSaldo($this->precio);
              $this->bajarSaldo($this->precio / 3);
              $this->plus--;
              return "transbordo y paga un plus";
            } else {
              $this->bajarSaldo($this->precio / 3);
              return "transbordo normal";
            }
          }
          if ($this->obtenerSaldo() >= $this->precio * 3) {
            $this->bajarSaldo($this->precio);
            $this->bajarSaldo($this->precio);
            $this->bajarSaldo($this->precio);
            $this->plus-=2;
            return "paga dos plus";
          } else if ($this->obtenerSaldo() >= $this->precio * 2) {
            $this->bajarSaldo($this->precio);
            $this->bajarSaldo($this->precio);
            $this->plus--;
            return "paga un plus";
          } else {
            $this->bajarSaldo($this->precio);
            return "normal";
          }
      }
    }
    else {
      if ($this->trasbordoPermitido($this->actualColectivo)) {
        if ($this->obtenerSaldo()>=(($this->precio)/3)) {
          return "transbordo normal";
        }
      }
      if ($this->obtenerPlus() != 2) {
        $this->aumentarPlus();
          return "usa plus";
      }
    }
    return "no";
  }

  public function trasbordoPermitido($colectivo) {
    $actual = $this->tiempo->time();
    $diferencia = (($actual) - ($this->anteriorTiempo));
    // La diferencia que devuelve está en minutos, por eso multiplico por 60
    if ($diferencia < ($this->diferenciaNecesaria($actual) * 60) && (($this->anteriorTiempo) !== null) && $colectivo !== $this->anteriorColectivo && $this->anteriorColectivo !== null) {
      $this->anteriorTiempo = $actual;
      $this->anteriorColectivo = $colectivo;
      return true;
    }
    $this->anteriorTiempo = $actual;
    $this->anteriorColectivo = $colectivo;
    return false;
  }

  public function diferenciaNecesaria($tiempo) {
    $dia = date("D",$tiempo);
    $hora = date("H", $tiempo);
    if ($hora>=22 || $hora<=6) { // Si es de noche hay mas tiempo
      return 90;
    } else {
      if ($dia == "Sat") { // Si es sabado depende si es de mañana o tarde
        if ($hora<14 && !($this->esFeriado())) { // Aunque tambien puede ser feriado un sabado y entonces hay mas tiempo a la mañana tambien
          return 60;
        } else {
          return 90;
        }
      }
      if ($dia == "Sun") { // Los domingos tambien hay mas tiempo
        return 90;
      }
      //if($this->esFeriado()) // Y los otros días depende si es feriado
      //  return 90;
      //else
      //  return 60;
      return 60; // Por ahora no manejamos los feriados
    }
  }

  public function esFeriado() {
    return false;
  }

}