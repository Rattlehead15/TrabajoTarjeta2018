<?php

namespace TrabajoTarjeta;

use PHPUnit\Framework\TestCase;

class FranquiciaCompletaTest extends TestCase {
    /**
     * Comprueba que siempre se pueda pagar con una tarjeta de franquicia completa
     */
    public function testSiemprePagar(){
        $completitoDeJamonYQueso = new FranquiciaCompleta(new TiempoFalso(0));
        $saldo = $completitoDeJamonYQueso->obtenerSaldo();
        $completitoDeJamonYQueso->bajarSaldo($completitoDeJamonYQueso->precio);
        $this->assertEquals($saldo,$completitoDeJamonYQueso->obtenerSaldo());
    }
}
