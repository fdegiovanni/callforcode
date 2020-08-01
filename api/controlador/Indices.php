<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GoogleMaps
 *
 * @author fdegiovanni
 */


class Indices {
    
    /**
     *  Test
     * 
     * @url POST /indices/carbonfootprint
     */
    public function obtenerHuellaCarbono() {
        $json = filter_var(file_get_contents('php://input'));
        $datos = json_decode($json);
        
        require_once 'servicio/GoogleMaps.php';
        
        $gmapsService = new GoogleMaps();
        $origen = $gmapsService->obtenerCoordenadas($datos->origen);
        $destino = $gmapsService->obtenerCoordenadas($datos->destino);
        
        if ($origen["error"]) {
            http_response_code(409);
            return $origen;
        }
        
        if ($destino["error"]) {
            http_response_code(409);
            return $destino;
        }
      
        $info = $gmapsService->obtenerDistancia($origen["data"], $destino["data"]);

        if ($info["error"]) {
            http_response_code(409);
            return $info;
        }
        
        $distancia = preg_replace("/[^0-9.]/", "", $info["data"]->distance->text);
        $emisionCamion = 158;
        
        $co2 = $emisionCamion*$distancia;
        
        
        
        
        return array("co2" => round($co2/1000, 2)."Kg de CO2 emitidos en el transporte");
        
    }
}
