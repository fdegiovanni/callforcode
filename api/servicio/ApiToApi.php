<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ApiToApi
 *
 * @author fdegiovanni
 */
require_once 'vendor/autoload.php';

use Curl\Curl;

class ApiToApi {

    public function obtener($metodo, $arrayParametros = null) {        
        $curl = new Curl();
        $curl->setHeader('Content-Type', 'application/json');
        if ($arrayParametros == NULL) {
            $curl->get($metodo);
        } else {
            $curl->get($metodo, $arrayParametros);
        }
        
        if ($curl->error) {
            if ($curl->response != null && $curl->response != "") {
                $d = json_decode($curl->response, TRUE);
                $response = array("error" => TRUE, "descipcion" => "", "datos" => $d);   
            }else{
                $response = array("error" => TRUE, "descipcion" => $curl->errorCode . ': ' . $curl->errorMessage);
            } 
        } else {
            $datos = json_decode($curl->response, TRUE);
            $response = array("error" => FALSE, "descipcion" => "", "datos" => $curl->response);          
        }
        return $response;
    }
    
    public function guardar($metodo, $datos, $tipoDatos = "json", $autorizacion = null) {
        $curl = new Curl();
        
        if ($autorizacion != null) {
            $curl->setHeader('Authorization', $autorizacion);
        }
        
        switch ($tipoDatos) {
            case "json":
                $curl->setHeader('Content-Type', 'application/json');
                $curl->post($metodo, $datos);
                break;
            
            case "json_manual_encoding":
                $data = json_encode($datos, JSON_UNESCAPED_UNICODE);
                $curl->setHeader('Content-Type', 'application/json');
                $curl->post($metodo, $data);
                break;
            
            case "array":
                $curl->post($metodo, $datos);
                break;
           
        }
        
        
        if ($curl->error) {
            if ($curl->response != null && $curl->response != "") {
                $d = json_decode($curl->response, TRUE);
                $response = array("error" => TRUE, "descipcion" => "", "datos" => $d);   
            }else{
                $response = array("error" => TRUE, "descipcion" => $curl->errorCode . ': ' . $curl->errorMessage);
            }            
        } else {
            $d = json_decode($curl->response, TRUE);
            $response = array("error" => FALSE, "descipcion" => "", "datos" => $d);          
        }
        return $response;
    }

}
