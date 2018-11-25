<?php
namespace TrabajoTarjeta;
class TiempoReal implements TiempoInterface {
    public function time() {
        return time();
    }
}