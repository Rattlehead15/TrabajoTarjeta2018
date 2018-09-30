<?php

namespace TrabajoTarjeta;

use PHPUnit\Framework\TestCase;

class TarjetaTest extends TestCase {

    /**
     * Comprueba que la tarjeta restaure sus viajes plus al recargarla
     */
    public function testCargaPlus() {
        $tiempo = new TiempoFalso(0);
        $tarjeta = new Tarjeta($tiempo);
        $tarjeta->aumentarPlus();
        $this->assertEquals($tarjeta->obtenerPlus(), 1);
        $tarjeta->recargar(100);
        $this->assertEquals($tarjeta->obtenerPlus(), 0);
        $tarjeta->aumentarPlus();
        $this->assertEquals($tarjeta->obtenerPlus(), 1);
        $tarjeta->aumentarPlus();
        $this->assertEquals($tarjeta->obtenerPlus(), 2);
        $tarjeta->recargar(100);
        $this->assertEquals($tarjeta->obtenerPlus(), 0);
        $tarjeta = new Tarjeta($tiempo);
        $tarjeta->aumentarPlus();
        $tarjeta->aumentarPlus();
        $tarjeta->recargar(30);
    }

    /**
     * Testea que te deje pagar los plus que debés correctamente
     */
    public function testPagarPlus() {
        $tiempo = new TiempoFalso(0);
        $colectivo = new Colectivo("K","Empresa genérica",3,$tiempo);
        $normal = new Tarjeta($tiempo);
        $normal->recargar(20);
        $normal->aumentarPlus();
        $this->assertNotEquals(false,$colectivo->pagarCon($normal));
        $normal = new Tarjeta($tiempo);
        $normal->recargar(20);
        $normal->aumentarPlus();
        $normal->aumentarPlus();
        $this->assertNotEquals(false, $colectivo->pagarCon($normal));
        $normal = new Tarjeta($tiempo);
        $normal->recargar(30);
        $normal->aumentarPlus();
        $normal->aumentarPlus();
        $this->assertNotEquals(false, $colectivo->pagarCon($normal));
        $this->assertEquals($normal->obtenerPlus(), 1);
        $normal = new Tarjeta($tiempo);
        $normal->aumentarPlus();
        $normal->aumentarPlus();
        $normal->recargar(20);
        $this->assertNotEquals(false, $colectivo->pagarCon($normal));
        $this->assertEquals($normal->obtenerPlus(), 2);
    }

    /**
     * Comprueba que la tarjeta aumenta su saldo cuando se carga saldo válido.
     */
    public function testCargaSaldo() {
        $tarjeta = new Tarjeta(new TiempoFalso(0));
        $valordebido = 10;

        $this->assertTrue($tarjeta->recargar(10));
        $this->assertEquals($tarjeta->obtenerSaldo(), $valordebido);

        $valordebido += 20;
        $this->assertTrue($tarjeta->recargar(20));
        $this->assertEquals($tarjeta->obtenerSaldo(), $valordebido);

        $valordebido += 30;
        $this->assertTrue($tarjeta->recargar(30));
        $this->assertEquals($tarjeta->obtenerSaldo(), $valordebido);

        $valordebido += 50;
        $this->assertTrue($tarjeta->recargar(50));
        $this->assertEquals($tarjeta->obtenerSaldo(), $valordebido);

        $valordebido += 100;
        $this->assertTrue($tarjeta->recargar(100));
        $this->assertEquals($tarjeta->obtenerSaldo(), $valordebido);

        $valordebido += 510.15 + 81.93;
        $this->assertTrue($tarjeta->recargar(510.15));
        $this->assertEquals($tarjeta->obtenerSaldo(), $valordebido);

        $valordebido += 962.59 + 221.58;
        $this->assertTrue($tarjeta->recargar(962.59));
        $this->assertEquals($tarjeta->obtenerSaldo(), $valordebido);
    }

    /**
     * Comprueba que la tarjeta no puede cargar saldos invalidos.
     */
    public function testCargaSaldoInvalido() {
      $tarjeta = new Tarjeta(new TiempoFalso(0));

      $this->assertFalse($tarjeta->recargar(15));
      $this->assertEquals($tarjeta->obtenerSaldo(), 0);
  }
}
