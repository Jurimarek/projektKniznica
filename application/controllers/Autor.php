<?php
/**
 * Created by PhpStorm.
 * User: Jurik
 * Date: 16.4.2018
 * Time: 22:06
 */

class Autor extends CI_Controller {


    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        6
        $this->load->model('autor_model');
}

    public function index(){
        $data = array();
//ziskanie sprav zo session
        if($this->session->userdata('success_msg')){
            $data['success_msg'] = $this->session->userdata('success_msg');
            $this->session->unset_userdata('success_msg');
        }
        if($this->session->userdata('error_msg')){
            $data['error_msg'] = $this->session->userdata('error_msg');
            $this->session->unset_userdata('error_msg');
        }
        $data['temperatures'] = $this->autor_model->getRows();
        $data['title'] = 'Zoznam autorov';
//nahratie zoznamu teplot
        $this->load->view('templates/header', $data);
        $this->load->view('temperatures/index', $data);
        $this->load->view('templates/footer');
    }

    // Zobrazenie detailu o teplote
    public function view($id){
        $data = array();
//kontrola, ci bolo zaslane id riadka
        if(!empty($id)){
            $data['autor'] = $this->autor_model->getRows($id);
            $data['title'] = $data['autor']['meno_autora'];
//nahratie detailu zaznamu
            $this->load->view('templates/header', $data);
            $this->load->view('temperatures/view', $data);
            $this->load->view('templates/footer');
        }else {
            redirect('/temperatures');
        }

    }



}
