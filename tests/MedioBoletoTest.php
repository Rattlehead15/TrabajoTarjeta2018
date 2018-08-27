<?php

namespace TrabajoTarjeta;

use PHPUnit\Framework\TestCase;

class MedioBoletoTest extends TestCase {
    /**
     * Comprueba que siempre se pueda pagar con una tarjeta de franquicia completa
     */
    public function testPagarMitad(){
        $medio = new MedioBoleto();
        $medio->recargar(962.59);
        $saldoAntesDePagar = $medio->obtenerSaldo();
        $medio->bajarSaldo();
        $tarjeta = new Tarjeta();
        $this->assertEquals($saldoAntesDePagar-$medio->obtenerSaldo(),($tarjeta->precio)/2);
    }
}
