<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Fotocopias_controller
 *
 * @author jose
 */
class Fotocopias_controller extends CI_Controller{
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        if($this->ion_auth->logged_in()===FALSE)
        {
          redirect('auth/login');
        }
        $this->load->helper('url');
        $this->load->model('fotocopias_model');
    }
    
    function porFamilias(){
        $data['title'] = 'Resumen de fotocopias ';
        $this->load->view('common/cabecera', $data);
        $desde = $this->uri->segment(3);
        $hasta = $this->uri->segment(4);
        $data['gastos'] = $this->fotocopias_model->getporFamilias($desde, $hasta);
        $data['periodo']=['desde'=>$desde,'hasta'=>$hasta];
        $this->load->view('fotocopias_familias_view', $data);     
    }
    
    function porProfesores(){
        $data['title'] = 'Fotocopias por profesor ';
        $this->load->view('common/cabecera', $data);
        $desde = $this->uri->segment(3);
        $hasta = $this->uri->segment(4);
        $fam = $this->uri->segment(5);
        $data['gastos'] = $this->fotocopias_model->getporProfesores($desde, $hasta, $fam);
        $this->load->view('fotocopias_profesores_view', $data);     
    }
}
