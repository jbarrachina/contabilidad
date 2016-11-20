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
    
    //pasamos el formato fecha del csv dd/mm/aaaa a aaaa-mm-dd de mysql
    private function convierteFecha($fechaOriginal) {
        $vector = explode('/', $fechaOriginal);
        return $vector[2] . "-" . $vector[1] . "-" . $vector[0];
    }
    
    private function replaceApuntes($campos) {
        $anyo = 2016;
        if (count($campos) == 14 || count($campos) == 13) {
            for($i=0;$i<count($campos);$i++){
                $campos[$i] = ($campos[$i] == "\"" ? substr($campos[$i], 1, -1) : $campos[$i]);
            }
            $apunte = $campos[0];
            $fechaPago = $this->convierteFecha($campos[1]);
            $fechaApunte = $this->convierteFecha($campos[2]);
            $fechaFactura = ($campos[3] == "" ? NULL : $this->convierteFecha($campos[3])); //hay valores vacios
            $tipo = substr($campos[4], 1, -1); //quitamos las comillas
            $recurso = substr($campos[5], 1, -1);
            $destino = ($campos[6] == "" ? NULL : substr($campos[6], 1, -1));
            $cuenta = ($campos[7] == "" ? NULL : substr($campos[7], 1, -1));
            $importe = (float) str_replace(',', '.', ($campos[8][0] == "\"" ? substr($campos[8], 1, -1) : $campos[8]));
            $titular = ($campos[9] == "" ? NULL : substr($campos[9], 1, -1));
            $concepto = ($campos[10] == "" ? NULL : substr($campos[10], 1, -1));
            $tipoDocumento = ($campos[11] == "" ? NULL : substr($campos[11], 1, -1));
            $data = array(
                'anyo' => $anyo,
                'apunte' => $apunte,
                'fechaPago' => $fechaPago,
                'fechaApunte' => $fechaApunte,
                'fechaFactura' => $fechaFactura,
                'tipo' => $tipo,
                'recurso' => $recurso,
                'destino' => $destino,
                'cuenta' => $cuenta,
                'importe' => $importe,
                'titular' => $titular,
                'tipoDocumento' => $tipoDocumento,
                'concepto' => $concepto
            );
            if ($this->apuntes_model->estaApunte($anyo,$apunte)){
                $this->apuntes_model->actualizaApunte($anyo,$apunte,$data);
            } else {
                $this->apuntes_model->insertaApunte($data);
            }
            
        } else {
            // print_r($campos);
            //log_message('info', 'USER_INFO import ' . count($campos));
        }      
    }

    public function index() {
        $data['title'] = 'Paginacion_ci';
        $config['total_rows'] = $this->apuntes_model->filas();
        $config['base_url'] = base_url() . 'apuntes/pagina/';
        $config["uri_segment"] = 3;
        $this->pagination->initialize($config);
        //$pages = 10; //Número de registros mostrados por páginas
        $data["records"] = $this->apuntes_model->total_paginados($this->pages, $this->uri->segment(3));
        $data["total"] = $this->apuntes_model->suma();
        //$query = $this->db->get("apuntes");
        //$data['records'] = $query->result();
        //$this->load->helper('url');
        $this->load->view('Apuntes_view', $data);
    }

    public function search() {
        // get search string
        $search = ($this->input->post("search")) ? $this->input->post("search") : "NIL";
        $search = ($this->uri->segment(3)) ? $this->uri->segment(3) : $search;
        $config['base_url'] =  base_url() . "apuntes/search/$search/";
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->apuntes_model->filas($search);
        $this->pagination->initialize($config);
        $apuntedeinicio = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        log_message('info', 'USER_INFO search ');
        $data["records"] = $this->apuntes_model->total_paginados($this->pages, $apuntedeinicio, $search);
        $data["total"] = $this->apuntes_model->suma($search);
        $this->load->view('Apuntes_view', $data);
    }

    public function accion() {
        $this->load->model('apuntes_model');
        $apuntes = $this->input->post('apunte');
        $observaciones = $this->input->post('observaciones');
        $apuntedeinicio = ($apuntes[0] > 0) ? $apuntes[0] - 1 : 0;
        $config['cur_page'] = $apuntedeinicio;
        $this->pagination->initialize($config);
        //log_message('info', 'USER_INFO accion ' . $apuntedeinicio);
        $this->apuntes_model->actualizarObservaciones($apuntes, $observaciones);
        //volver a la pantalla de partida
        $data["records"] = $this->apuntes_model->total_paginados($this->pages, $apuntedeinicio);
        $data["total"] = $this->apuntes_model->suma();
        $this->load->view('Apuntes_view', $data);
    }

    public function importar(){
        //configuramos los parametros
        $config['upload_path']          = 'files/'; //la carpeta donde lo guardamos
        $config['allowed_types']        = 'csv'; //la extensión
        $config['max_size']             = 500000; //el tamaño máximo
        $this->load->library('upload', $config);
        
        //lo subimos
        if (!$this->upload->do_upload('userfile')) {
            $error = array('error' => $this->upload->display_errors());
            log_message('error','USER_INFO subir archivo '.$error);
            $this->load->view('upload_form', $error);
        } else {
            $upload_data = $this->upload->data();
            $file = fopen('files/' . $upload_data['file_name'], "r");
            while (!feof($file)) {
                //replaceApuntes(explode("|", substr(fgets($file), 0, -1))); //quitamos el último carácter que es un espacio en blanco
                $apunte = substr(fgets($file), 0, -1);
                //echo $apunte . "<br>";
                $campos = explode("|", $apunte);
                log_message('error','USER_INFO  importar '.$apunte);
                $this->replaceApuntes($campos);
            }
            fclose($file);
            $this->index();
        }
    }
    
    function listado(){
        $data["records"] = $this->apuntes_model->mostrarDetalle();
        $this->load->view('listado', $data);
    }
    
    
    public function republic() {
        echo "<br><h1>HAPPY REPUBLIC DAY</h1><br>";
    }

}
