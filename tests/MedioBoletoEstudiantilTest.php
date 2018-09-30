<?php

namespace TrabajoTarjeta;

use PHPUnit\Framework\TestCase;

class MedioBoletoEstudiantilTest extends TestCase {

    /**
     * Testea que la tarjeta solo pueda usarse cada 5 minutos
     */
    public function testCincoMinutos(){
        $tiempo = new TiempoFalso(0);
        $colectivo = new Colectivo("K","Empresa genérica",3,$tiempo);
        $estudiantil = new MedioBoletoEstudiantil($tiempo);
        $estudiantil->recargar(100);
        $boleto = $colectivo->pagarCon($estudiantil);
        $this->assertEquals($boleto,new Boleto($estudiantil->precio,$colectivo,$estudiantil,$tiempo->time(),"normal"));
        $tiempo->avanzar(10);
        $this->assertFalse($colectivo->pagarCon($estudiantil));
        $tiempo->avanzar(6000);
        $boleto = $colectivo->pagarCon($estudiantil);
        $this->assertEquals($estudiantil->obtenerAntTiempo(), 6010);
        $this->assertEquals($boleto,new Boleto($estudiantil->precio,$colectivo,$estudiantil,$tiempo->time(),"normal"));
    }

    /**
     * Testea que el viaje salga la mitad de lo que sale con una tarjeta normal
     */
    public function testSaleLaMitad(){
        $tiempo = new TiempoFalso(0);
        $colectivo = new Colectivo("K","Empresa genérica",3,$tiempo);
        $normal = new Tarjeta($tiempo);
        $estudiantil = new MedioBoletoEstudiantil($tiempo);
        $normal->recargar(100);
        $estudiantil->recargar(100);
        $boletoNormal = $colectivo->pagarCon($normal);
        $boletoMedio = $colectivo->pagarCon($estudiantil);
        $this->assertEquals($boletoNormal->obtenerValor(),$boletoMedio->obtenerValor() * 2);
    }
}