<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Fotocopias_model
 *
 * @author jose
 */
class Fotocopias_model extends CI_Model{
  
   function __construct() {
       parent::__construct();
   }
   
   function getporFamilias($desde, $hasta){
        $sql = <<<SQL
        SELECT familia, ROUND(sum(coste),2) as coste, sum(copias) as copias, 
            SUM(case when job_type = 'PRINT' then copias else 0 end) as print, 
            SUM(case when job_type = 'COPY' then copias else 0 end) as copy, 
            SUM(case when job_type = 'COPY' AND LOCATE('cons',printer_name) > 0 then copias else 0 end) as conserjeria, 
            sum(hojas) as hojas, 
            ROUND((sum(copias)+sum(hojas))/100,2) as costeContable 
            FROM gasto_fotocopias_mes 
            LEFT JOIN profesores ON profesores.login=account_name 
            WHERE NOT login IS NULL AND CONCAT(anyo,LPAD(mes,2,'0')) >= ?  AND CONCAT(anyo,LPAD(mes,2,'0')) <= ? 
            AND familia <> 'INF_A'
            GROUP BY familia 
            ORDER BY familia
SQL;
        $consulta = $this->db->query($sql,array($desde,$hasta));
        if ($consulta->num_rows() > 0) {
            foreach ($consulta->result() as $fila) { 
                $data[] = $fila;
            }
            return $data;
        } else {
            return 0;
        }       
    }
    
    function getporProfesores($desde, $hasta, $fam){
        $sql = <<< SQL
            SELECT apellido1, apellido2, nombre, ROUND(sum(coste),2) as coste, sum(copias) as copias,
                SUM(case when job_type = 'PRINT' then copias else 0 end) as print, 
           	SUM(case when job_type = 'COPY' then copias else 0 end) as copy, 
                SUM(hojas) as hojas 
                FROM gasto_fotocopias_mes 
                LEFT JOIN profesores ON profesores.login=account_name 
                WHERE NOT login IS NULL AND CONCAT(anyo,LPAD(mes,2,'0')) >= ?  AND CONCAT(anyo,LPAD(mes,2,'0')) <= ? 
                AND familia = ? 
                GROUP BY dni 
                ORDER BY apellido1, apellido2, nombre
SQL;
        $consulta = $this->db->query($sql,array($desde,$hasta,$fam));
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
