<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Pendientes_controller
 *
 * @author jose
 */
class Pendientes_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->helper('form', 'url');
        $this->load->library('upload');
       
        $this->load->model('pendientes_model');
        $this->load->library('session');
        $this->load->library('pagination'); //Cargamos la librería de paginación
        if ($this->ion_auth->logged_in() === FALSE) {
            redirect('auth/login');
        }
    }

    public function index() {
        $data['title'] = 'Facturas pendientes';
        $this->load->view('common/cabecera', $data);
        $data['lista_pendientes']=$this->pendientes_model->lista();
        $this->load->view('upload_form', $data);
    }

    public function add_pendiente() {
        //recogemos los datos del formulario
        $data['pendiente'] = ["factura" => $this->input->post('factura'), "familia" => $this->input->post('familia'), "estado" => 0];
        //configuramos el nombre del fichero.
        $config['file_name'] = 'pend_'.$this->pendientes_model->next_id();
        $config['upload_path'] = 'facturas/'; //la carpeta donde lo guardamos
        $config['allowed_types'] = 'pdf'; //la extensión
        $config['max_size'] = 500000; //el tamaño máximo
        $config['overwrite'] = TRUE;
        //$this->load->library('upload');
        $this->upload->initialize($config);
        //lo subimos
        if (!$this->upload->do_upload()) 
        {
            $error = array('error' => $this->upload->display_errors());
            log_message('error', 'USER_INFO subir archivo ' . $error['error']);
            $upload_data = $this->upload->data();
            echo "kk";
            echo $upload_data['file_path'],'--',$upload_data['file_name'];
        } else {
            //insertamos el registro en la tabla
            if ($this->pendientes_model->add($data['pendiente'])){
                echo "bien";
            }
            else 
            {
                echo "error database insert";
            }
        }
        
    }
    
    function autoriza()
    {
        $nuevo_estado = 1;
        $idPendiente = $this->uri->segment(3);
        if (substr($idPendiente,0,1)=='c') {
            $idApunte = $this->input->post('apunte_'.substr($idPendiente,1));
            $nuevo_estado=9;
        }
        $this->pendientes_model->autoriza($idPendiente, $nuevo_estado, $idApunte);
        redirect('pendientes');
    }

}
