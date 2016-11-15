<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Desglose_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //obtenemos el total de filas para hacer la paginación
    function getCuentas() {
        $query = $this->db->get('cuentas');
        foreach ($query->result() as $fila) {
            $data[] = $fila;
        }
        return $data;
    }
    
    function addCuentas($data){
        $this->db->replace('desgloses', $data);
    }
    
    function deleteCuentas($data){
        //log_message('info', 'USER_INFO accion ' . 'Location: /desglose/delete/'.$data['apunte']."-".$data['codCuenta']);
        $this->db->delete('desgloses', $data);
    }

}
