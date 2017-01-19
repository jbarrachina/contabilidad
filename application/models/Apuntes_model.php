<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Apuntes_model extends CI_Model {

    function __construct() {
        parent::__construct();
        //$this->load->library('ion_auth');
    }

    //obtenemos el total de filas para hacer la paginación
    function filas($filtro = NULL) {
        if ($filtro === NULL) $filtro = "";
        $this->db->from('apuntes');
        $this->db->where('anyo',$this->session->userdata('anyo'));
        $this->db->group_start();
        $this->db->like('concepto',$filtro);
        $this->db->or_like('titular',$filtro);
        $this->db->or_like('tipoDocumento',$filtro);
        $this->db->or_like('cuenta',$filtro);
        $this->db->group_end();
        //log_message('info', 'USER_INFO '.$this->db->get_compiled_select('apuntes'));       
        //$consulta = $this->db->get('apuntes');
        $filas = $this->db->count_all_results();
        log_message('info', 'USER_INFO filas: '.$filas);
        return $filas;
    }
    
    //obtenemos el total de filas para hacer la paginación
    function suma($filtro = NULL) {
        if ($filtro == NULL) $filtro = "";
        $this->db->select('tipo');
        $this->db->select_sum('importe');
        $this->db->where('apunte >',4);
        $this->db->where('recurso !=','T');
        $this->db->where('anyo',$this->session->userdata('anyo'));
        $this->db->group_start();               
            $this->db->like('concepto',$filtro);
            $this->db->or_like('titular',$filtro);
            $this->db->or_like('tipoDocumento',$filtro);
            $this->db->or_like('cuenta',$filtro);
        $this->db->group_end();
        $this->db->group_by('tipo');
        $consulta = $this->db->get('apuntes');
        $data=['Ingreso' => 0,'Gasto' => 0];
        foreach ($consulta->result() as $fila){
            if ($fila->tipo=='Ingreso' ){
                $data['Ingreso']+=$fila->importe;
            }
            else
            {
                $data['Gasto']+=$fila->importe;
            }
            //log_message('info', 'USER_INFO totalpaginados '.$fila->tipo." - ".$fila->importe);
        }
        return $data;
    }

    //total_posts_paginados pasando la cantidad por página y el segmento
    //como parámetros de la misma   
    function total_paginados($por_pagina, $segmento, $filtro = NULL) {
        
        $sql = <<< SQL
        SELECT *
        FROM mis_apuntes 
        WHERE anyo = ? 
            AND IF(?=0,
                TRUE,
                esta_en_rango(?,?,codCuenta)>0)
            AND(concepto LIKE ? OR titular LIKE ? OR tipoDocumento LIKE ? OR cuenta LIKE ?)
        LIMIT ?, ?
SQL;
        if ($filtro == NULL) $filtro = "";
        $filtro ="%$filtro%";
        //log_message('info', 'USER_INFO totalpaginados ' . $filtro."(".$segmento.")".$por_pagina);
        $consulta = $this->db->query($sql, [$this->session->userdata('anyo'),
            $this->ion_auth->user()->row()->desde,
            $this->ion_auth->user()->row()->desde,
            $this->ion_auth->user()->row()->hasta,
            $filtro, $filtro, $filtro, $filtro, (int)$segmento, $por_pagina]);
        if ($consulta->num_rows() > 0) {
            foreach ($consulta->result() as $fila) { 
                $data[] = $fila;
            }
            return $data;
        } else {
            return NULL;
        }         
    }

    function updateObservaciones($apunte,$observaciones) {
        //log_message('error','USER_INFO updateObservaciones: '.$apunte." - ".$observaciones);
        $this->db->set('observaciones', $observaciones);
        $this->db->where('anyo', $this->session->userdata('anyo'));
        $this->db->where('apunte', $apunte);
        $this->db->update('apuntes');
    }

    function actualizarObservaciones($apuntes,$observaciones) {
        for($i=0;$i<count($apuntes);$i++) {
            $this->updateObservaciones($apuntes[$i],$observaciones[$i]);
            //log_message('error','USER_INFO '.$apuntes[$i]." - ".$observaciones[$i]);
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
    
    function estaApunte($anyo, $apunte){
        $esta=FALSE;
        $this->db->where("anyo = $anyo AND apunte = $apunte");
        $consulta = $this->db->get('apuntes');
        foreach ($consulta->result() as $fila){
            $esta=TRUE;
        }
        return $esta;
    }
    
    function actualizaApunte($anyo, $apunte, $data){
        $this->db->update('apuntes', $data, "anyo = $anyo AND apunte = $apunte");
    }
    
    function insertaApunte($data){
        $this->db->insert('apuntes', $data);
    }
    
    function getImporte($apunte){
        $importe = 0;
        $this->db->where("anyo = ".$this->session->userdata('anyo')." AND apunte = $apunte");
        $consulta = $this->db->get('apuntes');
        foreach ($consulta->result() as $fila){
            $importe = $fila->importe;
        }
        return $importe;
    }
    
    function mostrarDetalle(){
        $sql = <<< SQL
        SELECT  c2.descripcion as grupo, cuentas.descripcion,  
            CONCAT(LPAD(apuntes.apunte,6,'0'),':',apuntes.concepto," ",apuntes.titular) as apunte, 
            sum(desgloses.Importe) as importe
        FROM apuntes 
        LEFT JOIN desgloses ON apuntes.anyo = desgloses.anyo AND apuntes.apunte = desgloses.apunte
        LEFT JOIN cuentas ON cuentas.codCuenta = desgloses.codCuenta
        LEFT JOIN cuentas as c2 ON c2.codCuenta = conv(concat(LEFT(lpad(conv(desgloses.codCuenta,10,2),8,0),4),'0000'),2,10)
        WHERE apuntes.anyo = ? AND cuentas.descripcion IS NOT NULL AND tipo='Gasto'
        GROUP BY c2.descripcion, cuentas.descripcion, apunte WITH ROLLUP
SQL;
        $consulta = $this->db->query($sql,array($this->session->userdata('anyo')));
        if ($consulta->num_rows() > 0) {
            foreach ($consulta->result() as $fila) { 
                $data[] = $fila;
            }
            return $data;
        } else {
            return 0;
        }         
        
    }

}
