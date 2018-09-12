<?php

namespace TrabajoTarjeta;

class Boleto implements BoletoInterface {

    protected $valor;

    protected $colectivo;

    protected $tarjeta;

    protected $fecha;

    protected $descripcion;

    public function __construct($valor, $colectivo, $tarjeta, $fecha, $tipo) {
        $this->valor = $valor;
        $this->colectivo = $colectivo;
        $this->tarjeta = $tarjeta;
        $this->fecha = $fecha;
        switch($tipo){
            case "normal":
                $this->descripcion = "Paga 1 viaje normal";
                break;
            case "plus":
                $this->descripcion = "Viaje plus";
                break; 
        }

    }

    /**
     * Devuelve el valor del boleto.
     *
     * @return int
     */
    public function obtenerValor() {
        return $this->valor;
    }

    /**
     * Devuelve la tarjeta con la que se pagó.
     */
    public function obtenerTarjeta() {
        return $this->tarjeta;
    }

    /**
     * Devuelve la fecha en la que se imprimió el boleto.
     */
    public function obtenerFecha() {
        return $this->fecha;
    }

    /**
     * Devuelve el tipo de tarjeta con la que se pagó.
     */
    public function obtenerTipoTarjeta() {
        return get_class($this->tarjeta);
    }

    /**
     * Devuelve un objeto que respresenta el colectivo donde se viajó.
     *
     * @return ColectivoInterface
     */
    public function obtenerColectivo() {
        return $this->colectivo;
    }

}