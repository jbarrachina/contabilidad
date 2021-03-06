<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Desglose_controller extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('desglose_model');
    }
    
    public function index() {
        $data["cuentas"] = $this->desglose_model->getCuentas();
        $data["apunte"]=$this->uri->segment(2); //el parámetro apunte
        $this->load->model('apuntes_model');
        $data["importe"]=$this->apuntes_model->getImporte($data["apunte"]);
        $this->load->view('desglose_view',$data);
    }
    
    public function addDesglose(){
        $this->load->model("desglose_model");
        $data = ['anyo'=>$this->session->userdata('anyo'), 'apunte'=>$this->input->post("apunte"),
            'codCuenta' => $this->input->post("cuenta"),
            'importe' => $this->input->post("importe")]; 
        
        $error = $this->desglose_model->addCuentas($data);
        //log_message('info', 'USER_INFO accion ' . 'Location: /php/contabilidad/apuntes/pagina/'.intdiv($data['apunt'],10)*10);
        header('Location: /php/contabilidad/apuntes/pagina/'.intdiv($data['apunte'],10)*10);  
    }
    
    public function deleteDesglose(){
        $apunte = $this->uri->segment(2);
        $codCuenta = $this->uri->segment(3);        
        $data = ['anyo'=>$this->session->userdata('anyo'), 'apunte'=>$apunte,'codCuenta' => $codCuenta];
        $this->desglose_model->deleteCuentas($data);
        //log_message('info', 'USER_INFO accion ' .$apunte."-".$codCuenta);
        header('Content-type: application/json');
        echo json_encode(true);
    }
}