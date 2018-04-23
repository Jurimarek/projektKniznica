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
        $data['autor'] = $this->autor_model->getRows();
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

    // pridanie zaznamu
    public function add(){
        $data = array();
        $postData = array();
//zistenie, ci bola zaslana poziadavka na pridanie zaznamu
        if($this->input->post('postSubmit')){
//definicia pravidiel validacie
            $this->form_validation->set_rules('meno_autora', 'meno_autora', 'required');
            $this->form_validation->set_rules('priezvisko_autora', 'priezvisko_autora', 'required');

            //$this->form_validation->set_rules('user', 'user id', 'required');
//priprava dat pre vlozenie
            $postData = array(
                'meno_autora' => $this->input->post('meno_autora'),
                'priezvisko_autora' => $this->input->post('priezvisko_autora'),
            );
//validacia zaslanych dat
            if($this->form_validation->run() == true){
//vlozenie dat
                $insert = $this->autor_model->insert($postData);
                if($insert){
                    $this->session->set_userdata('success_msg', 'Autor bol vložený úspešne');
                    redirect('/temperatures');
                }else{
                    $data['error_msg'] = 'Vyskitol sa problém, skúste znova.';
                }
            }
        }
        $data['post'] = $postData;
        $data['title'] = 'Vytvor autora';

$data['action'] = 'Add';
//zobrazenie formulara pre vlozenie a editaciu dat
$this->load->view('templates/header', $data);
$this->load->view('temperatures/add-edit', $data);
$this->load->view('templates/footer');
}

// aktualizacia dat
    public function edit($id){
        $data = array();
//ziskanie dat z tabulky
        $postData = $this->autor_model->getRows($id);
//zistenie, ci bola zaslana poziadavka na aktualizaciu
        if($this->input->post('postSubmit')){
//definicia pravidiel validacie
            $this->form_validation->set_rules('meno_autora', 'meno_autora', 'required');
            $this->form_validation->set_rules('priezvisko_autora', 'priezvisko_autora', 'required');
// priprava dat pre aktualizaciu
            $postData = array(
                'meno_autora' => $this->input->post('meno_autora'),
                'priezvisko_autora' => $this->input->post('priezvisko_autora'),
            );
//validacia zaslanych dat
            if($this->form_validation->run() == true){
//aktualizacia dat
                $update = $this->autor_model->update($postData, $id);
                if($update){
                    $this->session->set_userdata('success_msg', 'Autor bol upravený');

redirect('/autori');
}else{
                    $data['error_msg'] = 'Vyskitol sa problém';
                }
            }
        }
        $data['post'] = $postData;
        $data['title'] = 'Upraviť autora';
        $data['action'] = 'Edit';
//zobrazenie formulara pre vlozenie a editaciu dat
        $this->load->view('templates/header', $data);
        $this->load->view('temperatures/add-edit', $data);
        $this->load->view('templates/footer');
    }

    // odstranenie dat
    public function delete($id){
//overenie, ci id nie je prazdne
        if($id){
//odstranenie zaznamu
            $delete = $this->autor_model->delete($id);
            if($delete){
                $this->session->set_userdata('success_msg', 'Autor bol odstránený');
            }else{
                $this->session->set_userdata('error_msg', 'Vyskitol sa problém');
            }
        }
        redirect('/autori');
    }



}
