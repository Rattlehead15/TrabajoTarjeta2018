<?php

namespace TrabajoTarjeta;

use PHPUnit\Framework\TestCase;

class ColectivoTest extends TestCase {

    public function testPagarConSaldo() {
        $bondi = new Colectivo();
        $tarjeta = new Tarjeta();
        $tarjeta->recargar(20);
        $this->assertEquals($bondi->pagarCon($tarjeta), new Boleto(14.80, $bondi, $tarjeta));
        $this->assertEquals($tarjeta->obtenerPlus(), 0);
    }
    
    public function testInfoColectivo(){
        $colectivo = new Colectivo();
        $this->assertEquals($colectivo->linea(), NULL);
        $this->assertEquals($colectivo->empresa(), NULL);
        $this->assertEquals($colectivo->numero(), NULL);
    }
    
    public function testPagarSinSaldo() {
        $bondi = new Colectivo();
        $tarjeta = new Tarjeta();
        $tarjeta->recargar(10);
        $this->assertEquals($bondi->pagarCon($tarjeta), new Boleto(14.80, $bondi, $tarjeta));
        $this->assertEquals($tarjeta->obtenerPlus(), 1);
        $this->assertEquals($bondi->pagarCon($tarjeta), new Boleto(14.80, $bondi, $tarjeta));
        $this->assertEquals($tarjeta->obtenerPlus(), 2);
        $this->assertEquals($bondi->pagarCon($tarjeta), false);
        $this->assertEquals($tarjeta->obtenerPlus(), 2);
    }
}
