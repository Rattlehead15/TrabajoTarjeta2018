<?php

namespace TrabajoTarjeta;

interface BoletoInterface {

    public function obtenerDescripcion();

    /**
     * Devuelve el valor del boleto.
     *
     * @return int
     */
    public function obtenerValor();
    
    /**
     * Devuelve la tarjeta con la que se pago.
     *
     * @return TarjetaInterface
     */
    public function obtenerTarjeta();
    /**
     * Devuelve la fecha en la que se imprimió el boleto.
     *
     * @return 
     */
    public function obtenerFecha();
    
    /**
     * Devuelve el tipo de trajeta con la que se pago.
     *
     * @return 
     */
    public function obtenerTipoTarjeta();
    
    /**
     * Devuelve un objeto que respresenta el colectivo donde se viajó.
     *
     * @return ColectivoInterface
     */
    public function obtenerColectivo();
}