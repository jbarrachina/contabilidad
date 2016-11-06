<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Apuntes_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //obtenemos el total de filas para hacer la paginación
    function filas() {
        $consulta = $this->db->get('apuntes');
        return $consulta->num_rows();
    }

    //obtenemos todas las provincias a paginar con la función
    //total_posts_paginados pasando la cantidad por página y el segmento
    //como parámetros de la misma   
    function total_paginados($por_pagina, $segmento) {
        $sql = <<< SQL
        SELECT apuntes.apunte as apunte, fechaApunte, fechaPago, fechaFactura,tipo, recurso, destino, cuenta, concepto, numDocumento,
        observaciones, tipoDocumento, titular, apuntes.importe as importe, 
        GROUP_CONCAT(CONCAT_WS(':',desgloses.codCuenta,cuentas.descripcion,desgloses.Importe) SEPARATOR '|') as desglose 
        FROM `apuntes` 
        LEFT JOIN desgloses ON apuntes.anyo=desgloses.anyo AND apuntes.apunte=desgloses.apunte
        LEFT JOIN cuentas ON desgloses.codCuenta=cuentas.codCuenta
        GROUP BY apuntes.anyo,apuntes.apunte
        ORDER BY apunte
        LIMIT ?, ?
SQL;
        $consulta = $this->db->query($sql, array((int)$segmento, $por_pagina));
        if ($consulta->num_rows() > 0) {
            foreach ($consulta->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    function updateObservaciones($apunte,$observaciones) {
        $this->db->set('observaciones', $observaciones);
        $this->db->where('anyo', 2016);
        $this->db->where('apunte', $apunte);
        $this->db->update('apuntes');
    }

    function actualizarObservaciones($apuntes,$observaciones) {
        for($i=0;$i<count($apuntes);$i++) {
            $this->updateObservaciones($apuntes[$i],$observaciones[$i]);
            log_message('error','USER_INFO '.$apuntes[$i]." - ".$observaciones[$i]);
        }
        
    }
    
    //obtenemos el total de filas para hacer la paginación
    function getCuentas() {
        $query = $this->db->get('cuentas');
        foreach ($query->result() as $fila) {
            $data[] = $fila;
        }
        return $data;
    }

}
