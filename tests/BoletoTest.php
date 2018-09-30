<?php

namespace TrabajoTarjeta;

use PHPUnit\Framework\TestCase;

class BoletoTest extends TestCase {

    public function testMensajesBoletos() {
        $tiempo = new TiempoFalso(0);
        $colectivo = new Colectivo("K", "Empresa genérica", 3, $tiempo);
        $tarjeta = new Tarjeta($tiempo);
        $valor = $tarjeta->precio;
        $tarjeta->recargar(100);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerColectivo(), $colectivo);
        $this->assertEquals($boleto->obtenerTarjeta(), $tarjeta);
        $this->assertEquals($boleto->obtenerValor(), $valor);
        $this->assertEquals($boleto->obtenerTipoTarjeta(), get_class($tarjeta));
        $this->assertEquals($boleto->obtenerFecha(), $tiempo->time());
        $this->assertEquals($boleto->obtenerDescripcion(), "");
        $tarjeta->aumentarPlus();
        $tiempo->avanzar(6000); // Avanzamos para que no te cobre un transbordo
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerDescripcion(),"Abona viaje plus ".$tarjeta->precio." y");
        $tarjeta->recargar(962.59);
        $tarjeta->aumentarPlus();
        $tarjeta->aumentarPlus();
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerDescripcion(), "Abona viajes plus ".(($tarjeta->precio)*2)." y");
    }
}
