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
        $normal = new Tarjeta($tiempo,1000);
        $normal->aumentarPlus();
        $normal->aumentarPlus();
        $this->assertNotEquals(false, $colectivo->pagarCon($normal));
        $this->assertEquals($normal->obtenerPlus(), 0);
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

    public function testTransbordo(){
        $tiempo = new TiempoFalso(0);
        $tarjeta = new Tarjeta($tiempo);
        $colectivo = new Colectivo("K","Empresa Genérica",3,$tiempo);
        $tarjeta->recargar(962.59);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($tarjeta->precio, $boleto->obtenerValor());
        $colectivo = new Colectivo("106","Empresa Genérica",3,$tiempo);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals(($tarjeta->precio)/3, $boleto->obtenerValor());
        $tarjeta->aumentarPlus();
        $colectivo = new Colectivo("112","Empresa Genérica",3,$tiempo);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals(($tarjeta->precio)/3, $boleto->obtenerValor());
        $tarjeta->aumentarPlus();
        $tarjeta->aumentarPlus();
        $colectivo = new Colectivo("K","Empresa Genérica",3,$tiempo);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals(($tarjeta->precio)/3, $boleto->obtenerValor());
        $tarjeta = new Tarjeta($tiempo,14.8*2+3);
        $boleto = $colectivo->pagarCon($tarjeta);
        $tarjeta->aumentarPlus();
        $colectivo = new Colectivo("106","Empresa Genérica",3,$tiempo);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals(($tarjeta->precio)/3, $boleto->obtenerValor());
        $tarjeta = new Tarjeta($tiempo,14.8+19.8);
        $boleto = $colectivo->pagarCon($tarjeta);
        $tarjeta->aumentarPlus();
        $tarjeta->aumentarPlus();
        $colectivo = new Colectivo("K","Empresa Genérica",3,$tiempo);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals(($tarjeta->precio)/3, $boleto->obtenerValor());
        $tarjeta = new Tarjeta($tiempo,14.8+14.8);
        $boleto = $colectivo->pagarCon($tarjeta);
        $tarjeta->aumentarPlus();
        $tarjeta->aumentarPlus();
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($tarjeta->precio, $boleto->obtenerValor());// En este test el colectivo sigue siendo el mismo asi que el precio no cambia
        $tarjeta = new Tarjeta($tiempo,14.8+5);
        $colectivo->pagarCon($tarjeta);
        $colectivo = new Colectivo("106","Empresa Genérica",3,$tiempo);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals(($tarjeta->precio)/3, $boleto->obtenerValor());
        $tarjeta = new Tarjeta($tiempo,14.8*2+3);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals(($tarjeta->precio), $boleto->obtenerValor());
        $tarjeta->aumentarPlus();
        $tarjeta->aumentarPlus();
        $colectivo = new Colectivo("K","Empresa Genérica",3,$tiempo);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals(($tarjeta->precio)/3, $boleto->obtenerValor());
    }

    public function testDiasTransbordo(){
        $tiempo = new TiempoFalso(0); // Este timestamp corresponde al 1/1/1970 a las 00:00hs, que fue un jueves. Para avanzar un dia hay que avanzar 86400 segundos
        $tarjeta = new Tarjeta($tiempo,9999999999); // Ponemos mucho dinero en la tarjeta
        $colectivo = new Colectivo("K","Empresa Genérica",3,$tiempo);
        $colectivo->pagarCon($tarjeta); // Ahora tenemos 90 minutos para hacer transbordo ya que son las 00:00hs
        $tiempo->avanzar(3600);
        $colectivo = new Colectivo("106","Empresa Genérica",3,$tiempo);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals(new Boleto($tarjeta->precio / 3,$colectivo,$tarjeta,$tiempo->time(),"transbordo"), $boleto); // Comprobamos que sea un boleto de transbordo
        $tiempo->avanzar(3600*30); // Ahora es viernes a las 7 de la mañana
        $colectivo->pagarCon($tarjeta); // Como es de día solo tenemos 60 minutos para pagar transbordo
        $tiempo->avanzar(60*80); // Esto no debería dejarnos transbordar
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals(new Boleto($tarjeta->precio,$colectivo,$tarjeta,$tiempo->time(),"normal"), $boleto); // No nos deja
        $tiempo->avanzar(86400); // Es sábado a la mañana
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals(new Boleto($tarjeta->precio,$colectivo,$tarjeta,$tiempo->time(),"normal"), $boleto); // Tenemos 60 minutos porque es de mañana
        $tiempo->avanzar(60*80);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals(new Boleto($tarjeta->precio,$colectivo,$tarjeta,$tiempo->time(),"normal"), $boleto); // No pudimos
        $tiempo->avanzar(3600*5); // Avanzamos hasta la tarde
        $colectivo->pagarCon($tarjeta); // Pagamos una vez. Ahora tenemos 90 minutos
        $tiempo->avanzar(60*80); // Esperamos lo mismo que antes, pero ahora es de tarde así que deberíamos poder transbordar
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals(new Boleto($tarjeta->precio,$colectivo,$tarjeta,$tiempo->time(),"transbordo"), $boleto); // No nos deja ya que el colectivo es el mismo
        $tiempo->avanzar(86400); // Avanzamos hasta el domingo
        $colectivo->pagarCon($tarjeta); // Pagamos una vez. Ahora tenemos 90 minutos
        $tiempo->avanzar(60*80); // Esperamos lo mismo que antes, como es domingo nos va a dejar
        $colectivo = new Colectivo("K","Empresa Genérica",3,$tiempo);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals(new Boleto($tarjeta->precio/3,$colectivo,$tarjeta,$tiempo->time(),"transbordo"), $boleto); // Nos deja
    }
}
