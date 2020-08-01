<?php
require 'dao/OperacionesDao.php';

class ControladorOperaciones {
    
    /**
     *  Realizar una transaccion
     * 
     * @url POST /tigo/transaccion
     */
    public function transaccion() {
        
        $inputJSON = file_get_contents('php://input');
        $body = json_decode($inputJSON, TRUE); //convert JSON into array
        
//        $resultado = $this->validarCamposTransaccion($body);
//        if(!empty($resultado)){
//            return array("error"=>true,"mensaje"=>$resultado);
//        }
        
        $operacionesDao = new OperacionesDao();
        
        return "Hola mundo";
        
    }
   
    
    
}