<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class cetak_dpa_belanja_geserController extends CI_Controller {

    function __construct(){  
        parent::__construct();
        if($this->session->userdata('pcNama')==''){
            redirect('welcome');
        }
		
		$this->load->model('master_model','master_model');	
		$this->load->model('public_model','mpublic');
		$this->load->model('cetak_dpa_model');	
		$this->load->model('master_pdf');	
		
		
		
    } 

    function cetak_dpa_belanja_geser($jenis=''){
        $data['jenis']=$jenis;
        $data['page_title']= 'CETAK';
        $this->template->set('title', 'Cetak '.$jenis.' Belanja SKPD Penyusunan');   
        $this->template->load('template','anggaran/dpa/pergeseran/dpa_skpd_belanja',$data) ; 
    }


    function preview_belanja_pergeseran(){
        $tgl_ttd = $this->uri->segment(4);
        $ttd1    = $this->uri->segment(5);
        $ttd2    = $this->uri->segment(6);
        $id      = $this->uri->segment(7);
        $cetak   = $this->uri->segment(8);
        $doc     = $this->uri->segment(9);
        $status1     = $this->uri->segment(10);
        $status2     = $this->uri->segment(11);
        echo $this->cetak_dpa_model->preview_belanja_pergeseran($tgl_ttd,$ttd1,$ttd2,$id,$cetak,$doc,$status1,$status2);
    }
	
	
	
	
}