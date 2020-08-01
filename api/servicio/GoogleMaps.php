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
require_once 'ApiToApi.php';

class GoogleMaps {    
    
    public function obtenerCoordenadas($address) {
        $googleapi = "AIzaSyBl-SGxl4LQVC0MTfSTfjjr2t0zCEqJ-Fo";

        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$address->zip_code."&components=country:".$address->country."&sensor=false&key=$googleapi";
        $apiToApi = new ApiToApi();
        $r = $apiToApi->obtener($url);
        
        if ($r["error"]) {
            http_response_code(409);
            return $r;
        }else{
            $datos = $r["datos"];
            $coord["lat"] = $datos->results[0]->geometry->location->lat;
            $coord["lng"] = $datos->results[0]->geometry->location->lng;
            $r["data"] = $coord;
            unset($r["datos"]);
        }

        return $r;
    }
    
     public function obtenerDistancia($origen, $destino) {
        $googleapi = "AIzaSyBl-SGxl4LQVC0MTfSTfjjr2t0zCEqJ-Fo";

        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=".$origen["lat"].",".$origen["lng"]."&destinations=".$destino["lat"].",".$destino["lng"]."&key=".$googleapi;
        
      
        
        $apiToApi = new ApiToApi();
        $r = $apiToApi->obtener($url);
        if ($r["error"]) {
            http_response_code(409);
            return $r;
        }else{
            $datos = $r["datos"];
            $info = $datos->rows[0]->elements[0];
            
            $r["data"] = $info;
            unset($r["datos"]);
        }

        return $r;
    }
}
