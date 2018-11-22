<?php

namespace TrabajoTarjeta;

interface TarjetaInterface {

    /**
     * Recarga una tarjeta con un cierto valor de dinero.
     *
     * @param float $monto
     *
     * @return bool
     *   Devuelve TRUE si el monto a cargar es válido, o FALSE en caso de que no
     *   sea valido.
     */
    public function recargar($monto);

    /**
     * Devuelve el saldo que le queda a la tarjeta.
     *
     * @return float
     */
    public function obtenerSaldo();

    /**
     * Devuelve el saldo que le queda a la tarjeta menos el monto pasado.
     * 
     * @param float $montito
     *
     * @return float
     */
    public function bajarSaldo($montito);
    
    /**
     * Devuelve la cantidad de viajes plus que uso la tarjeta.
     *
     * @return int
     */
    public function obtenerPlus();
    
    /**
     * Aumenta la cantidad de viajes plus en 1.
     *
     * @return int
     */
    public function aumentarPlus();
    
    /**
     * Retorna "normal" si puede pagar normalmente,
     * "plus" si paga con un viaje plus,
     * "paga un plus" si paga con saldo y ademas abona un plus,
     * "paga dos plus" si abona dos,
     * "transbordo normal" si usa transbordo,
     * "transbordo y paga un plus" si usa transbordo y tambien paga un plus,
     * "transbordo y paga dos plus" si paga dos,
     * o "no" en caso contrario.
     * Luego, si puede pagar, baja el saldo o los viajes plus de la tarjeta dependiendo del caso.
     * 
     * @param string string int 
     *
     * @return string
     */
    public function puedePagar($linea, $empresa, $numero);
    
    /**
     * Checkea si se cumplen las opciones necesarias para el vieje plus y devuelve true o false segun el caso.
     *
     * @param ColectivoInterface
     * 
     * @return bool
     */
    public function trasbordoPermitido($colectivo);
    
    /**
     * Se fija el tiempo necesario para hacer un transbordo segun el dia o si es feriado o no.
     *
     * @param TiempoInterface
     * 
     * @return int
     */
    function diferenciaNecesaria($tiempo);

    
    /**
     * Se fija si es feriado y retorna true o false segun el caso.
     *
     * @return bool
     */
    function esFeriado();
}