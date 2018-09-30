<?php

namespace TrabajoTarjeta;

use PHPUnit\Framework\TestCase;

class MedioBoletoUniversitarioTest extends TestCase {

    /**
     * Testea que la tarjeta solo pueda usarse cada 5 minutos
     */
    public function testCincoMinutos(){
        $tiempo = new TiempoFalso(0);
        $colectivo = new Colectivo("K","Empresa genérica",3,$tiempo);
        $uni = new MedioBoletoUniversitario($tiempo);
        $uni->recargar(100);
        $boleto = $colectivo->pagarCon($uni);
        $this->assertEquals($boleto,new Boleto($uni->precio,$colectivo,$uni,$tiempo->time(),"normal"));
        $tiempo->avanzar(10);
        $this->assertFalse($colectivo->pagarCon($uni));
        $tiempo->avanzar(6000);
        $boleto = $colectivo->pagarCon($uni);
        $this->assertEquals($boleto,new Boleto($uni->precio,$colectivo,$uni,$tiempo->time(),"normal"));
    }

    /**
     * Testea que el viaje salga la mitad de lo que sale con una tarjeta normal, las primeras dos veces del día.
     * Luego, testea que al día siguiente vuelva a pagar la mitad.
     */
    public function testSaleLaMitad(){
        $tiempo = new TiempoFalso(0);
        $colectivo = new Colectivo("K","Empresa genérica",3,$tiempo);
        $normal = new Tarjeta($tiempo);
        $uni = new MedioBoletoUniversitario($tiempo);
        $normal->recargar(100);
        $uni->recargar(100);
        $boletoNormal = $colectivo->pagarCon($normal);
        $boletoMedio = $colectivo->pagarCon($uni);
        $this->assertEquals($boletoNormal->obtenerValor(),$boletoMedio->obtenerValor() * 2);
        $tiempo->avanzar(6000);
        $boletoMedio = $colectivo->pagarCon($uni);
        $this->assertEquals($boletoNormal->obtenerValor(),$boletoMedio->obtenerValor() * 2);
        $tiempo->avanzar(6000);
        $boletoMedio = $colectivo->pagarCon($uni);
        $this->assertEquals($boletoNormal->obtenerValor(),$boletoMedio->obtenerValor());
        $tiempo->avanzar(3600*25);
        $boletoMedio = $colectivo->pagarCon($uni);
        $this->assertEquals($boletoNormal->obtenerValor(),$boletoMedio->obtenerValor() * 2);
    }
}