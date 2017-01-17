<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pendientes_model
 *
 * @author jose
 */
class Pendientes_model extends CI_Model 
{
    function __construct() 
    {
        parent::__construct();
        $this->load->helper('url');
    }
    
    //devuelve el próximo valor a asignar en auto_increment de pendientes.
    function next_id(){
        $sql = "SHOW TABLE STATUS from contabilidad WHERE name='pendientes' ";
        $consulta = $this->db->query($sql);
        $row = $consulta->row();
        return $row->Auto_increment;
    }
    
    function add($data){
        return $this->db->insert('pendientes',$data);
    }
    
    function lista()
    {
        $this->db->where('estado !=',9);
        $consulta = $this->db->get('pendientes');     
        foreach ($consulta->result() as $fila){
           $data[]= $fila;
        }
        return $data;
    }
    
    function autoriza($id, $nuevo_estado=1){
        if (substr($id,0,1)=='c') 
        {
            $nuevo_estado=9;
            $id = substr($id,1);
        }
        $this->db->where('id',$id);
        $this->db->update('pendientes',['estado'=>$nuevo_estado]);//pasa a autorizado a pagar
        if ($nuevo_estado == 9)
        {
            //renombro fichero fichero
            //rename('factura/'.pend$i.'.pdf','factura/'.$algo.'.pdf');
        }
    }
            
}
