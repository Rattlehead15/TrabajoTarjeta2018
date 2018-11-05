<?php

namespace TrabajoTarjeta;

interface TiempoInterface {

    /**
     * Devuelve el tiempo.
     *
     * @return int
     */
    public function time();

    /**
     * Devuelve el tiempo avanzado en los segundos especificados en tiempo.
     *
     * @param int $segundos
     * 
     * @return int
     */
    public function avanzar($segundos);
}