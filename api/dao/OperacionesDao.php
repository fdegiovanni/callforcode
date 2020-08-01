<?php

require_once 'mysql.php';
class OperacionesDao extends MySQL{
    
    public function registrarPago($nroOperecion,$transaccion){
        $query = "INSERT INTO tbl_referencias_tigo(nro_operacion,transaccion_id) "
                . "VALUES('$nroOperecion','$transaccion')";
        
        $resultado = $this->realizarOperacion($query, false);
        return $resultado; 
    }
    
    public function getConfiguracionTigo(){
        $query = "SELECT e.* FROM tbl_empresas_cobros e 
                INNER JOIN tbl_metodos_cobro c ON e.metodoCobroId = c.id
                WHERE c.codigo = 'TM'";
        
        $respuesta = $this->consultaRegistroArray($query);
        
        if(empty($respuesta)){
            return array();
        }else{
            return $respuesta[0];
        }
    }
}
