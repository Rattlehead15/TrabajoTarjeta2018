<?php
namespace TrabajoTarjeta;
class TiempoFalso implements TiempoInterface {
    protected $time;
    public function __construct($iniciar) {
        $this->time = $iniciar;
    }

    /**
     * Devuelve el tiempo avanzado en los segundos especificados en tiempo.
     *
     * @param int $segundos
     * 
     * @return int
     */
    public function avanzar($segundos) {
        $this->time += $segundos;
    }
    
    public function time() {
        return $this->time;
    }
}