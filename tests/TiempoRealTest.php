<?php

namespace TrabajoTarjeta;

use PHPUnit\Framework\TestCase;

class TiempoRealTest extends TestCase {

    public function testPasoDelTiempo() {
        $time = new TiempoReal();
        $ahora = $time->time();
        sleep(3);
        $this->assertGreaterThanOrEqual($ahora,$time->time());
    }
}
