<?php

namespace TrabajoTarjeta;

use PHPUnit\Framework\TestCase;

class ColectivoTest extends TestCase {

    public function testPagarConSaldo() {
        $bondi = new Colectivo("K", "Empresa generica", 3, new TiempoFalso(0));
        $tarjeta = new Tarjeta();
        $tarjeta->recargar(100);
        $this->assertEquals($bondi->pagarCon($tarjeta), new Boleto($tarjeta->precio, $bondi, $tarjeta, $bondi->tiempo(), "normal"));
        $this->assertEquals($tarjeta->obtenerPlus(), 0);
    }
    
    public function testInfoColectivo(){
        $colectivo = new Colectivo("K", "Empresa generica", 3, new TiempoFalso(0));
        $this->assertEquals($colectivo->linea(), "K");
        $this->assertEquals($colectivo->empresa(), "Empresa generica");
        $this->assertEquals($colectivo->numero(), 3);
    }
    
    public function testPagarSinSaldo() {
        $bondi = new Colectivo("K", "Empresa generica", 3, new TiempoFalso(0));
        $tarjeta = new Tarjeta();
        $tarjeta->recargar(20);
        $valordebido = 20 - $tarjeta->precio;
        $this->assertEquals($bondi->pagarCon($tarjeta), new Boleto($tarjeta->precio, $bondi, $tarjeta, $bondi->tiempo(), "normal"));
        $this->assertEquals($tarjeta->obtenerSaldo(), $valordebido);
        $this->assertEquals($tarjeta->obtenerPlus(), 0);
        $this->assertEquals($bondi->pagarCon($tarjeta), new Boleto(0, $bondi, $tarjeta, $bondi->tiempo(), "usa plus"));
        $this->assertEquals($tarjeta->obtenerSaldo(), $valordebido);
        $this->assertEquals($tarjeta->obtenerPlus(), 1);
        $this->assertEquals($bondi->pagarCon($tarjeta), new Boleto(0, $bondi, $tarjeta, $bondi->tiempo(), "usa plus"));
        $this->assertEquals($tarjeta->obtenerSaldo(), $valordebido);
        $this->assertEquals($tarjeta->obtenerPlus(), 2);
        $this->assertEquals($bondi->pagarCon($tarjeta), false);
        $this->assertEquals($tarjeta->obtenerSaldo(), $valordebido);
        $this->assertEquals($tarjeta->obtenerPlus(), 2);
    }
}
