<?php
namespace TrabajoTarjeta;
class TiempoFalso implements TiempoInterface{
    protected $time;
    public function __construct($iniciar){
        $this->time = $iniciar;
    }
    public function avanzar($segundos){
        $this->time += segundos;
    }
    public function time(){
        return $this->time;
    }
}