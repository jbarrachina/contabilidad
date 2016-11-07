<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Apuntes_controller extends CI_Controller {

    var $pages = 10;
    var $config;

    function __construct() {
        parent::__construct();
        //$this->load->library('../controllers/Desglose_controller.php'); Unable to locate the specified class: Session.php
        $this->load->helper('url');
        $this->load->model('apuntes_model');
        $this->load->library('pagination'); //Cargamos la librería de paginación
        $config['base_url'] = base_url() . 'apuntes/pagina/'; // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php
        $config['total_rows'] = $this->apuntes_model->filas(); //calcula el número de filas  
        $config['per_page'] = $this->pages; //Número de registros mostrados por páginas
        $config['num_links'] = 10; //Número de links mostrados en la paginación
        $config['first_link'] = 'Primera'; //primer link
        $config['last_link'] = 'Última'; //último link
        $config["uri_segment"] = 3; //el segmento de la paginación
        $config['next_link'] = 'Siguiente'; //siguiente link
        $config['prev_link'] = 'Anterior'; //anterior link
        $this->pagination->initialize($config); //inicializamos la paginación	
    }

    public function index() {
        $data['title'] = 'Paginacion_ci';
        //$pages = 10; //Número de registros mostrados por páginas
        $data["records"] = $this->apuntes_model->total_paginados($this->pages, $this->uri->segment(3));
        //$query = $this->db->get("apuntes");
        //$data['records'] = $query->result();
        //$this->load->helper('url');
        $this->load->view('Apuntes_view', $data);
    }

    public function accion() {
        $this->load->model('apuntes_model');
        $apuntes = $this->input->post('apunte');
        $observaciones = $this->input->post('observaciones');
        $apuntedeinicio = $apuntes[0] - 1;
        $config['cur_page'] = $apuntedeinicio;
        $this->pagination->initialize($config);
        log_message('info', 'USER_INFO accion ' . $apuntedeinicio);
        $this->apuntes_model->actualizarObservaciones($apuntes, $observaciones);
        //volver a la pantalla de partida
        $data["records"] = $this->apuntes_model->total_paginados($this->pages, $apuntedeinicio);
        $this->load->view('Apuntes_view', $data);
    }

    public function republic() {
        echo "<br><h1>HAPPY REPUBLIC DAY</h1><br>";
    }

}
