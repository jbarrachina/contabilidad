<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Apuntes_controller extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->model('apuntes_model');
    }

    public function index() {
        $data['title'] = 'Paginacion_ci';
        $pages = 10; //Número de registros mostrados por páginas
        $this->load->library('pagination'); //Cargamos la librería de paginación
        $config['base_url'] = base_url() . 'apuntes/pagina/'; // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php
        $config['total_rows'] = $this->apuntes_model->filas(); //calcula el número de filas  
        $config['per_page'] = $pages; //Número de registros mostrados por páginas
        $config['num_links'] = 20; //Número de links mostrados en la paginación
        $config['first_link'] = 'Primera'; //primer link
        $config['last_link'] = 'Última'; //último link
        $config["uri_segment"] = 3; //el segmento de la paginación
        $config['next_link'] = 'Siguiente'; //siguiente link
        $config['prev_link'] = 'Anterior'; //anterior link
        $this->pagination->initialize($config); //inicializamos la paginación		
        $data["records"] = $this->apuntes_model->total_paginados($config['per_page'], $this->uri->segment(3));
        //$query = $this->db->get("apuntes");
        //$data['records'] = $query->result();
        //$this->load->helper('url');
        $this->load->view('Apuntes_view', $data);
    }

    public function accion() {
        log_message('info', 'USER_INFO ' . "accion");
        $this->load->model('apuntes_model');
        $apuntes = $this->input->post('apunte');
        $observaciones = $this->input->post('observaciones');
        $this->apuntes_model->actualizarObservaciones($apuntes, $observaciones);
        
    }

    public function republic() {
        echo "<br><h1>HAPPY REPUBLIC DAY</h1><br>";
    }

}
