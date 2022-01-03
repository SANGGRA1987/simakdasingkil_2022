<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class cetak_dpa_rekap_geserController extends CI_Controller {

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

 
    function cetak_dpa_rekap_geser($jenis=''){
        $data['jenis']=$jenis;
        $data['page_title']= 'CETAK';
        $this->template->set('title', 'Cetak '.$jenis.' SKPD Pergeseran');   
        $this->template->load('template','anggaran/dpa/pergeseran/dpa_skpd_rekap',$data) ; 
    }

    function skpduser_induk(){
        $lccr = $this->input->post('q');
        $data = $this->mpublic->skpduser_induk($lccr);  
        echo json_encode($data);
    }
	
	
	function preview_dpa_skpd_pergeseran(){
        $tgl_ttd= $this->uri->segment(4);
        $ttd1   = $this->uri->segment(5);
        $ttd2   = $this->uri->segment(6);
        $id     = $this->uri->segment(7);
        $cetak  = $this->uri->segment(8);
        $detail = $this->uri->segment(9);
        $doc    = $this->uri->segment(10);
        $gaji   = $this->uri->segment(11);
        $status1= $this->uri->segment(12);
        $status2= $this->uri->segment(13);
        $tanggal_ttd = $this->support->tanggal_format_indonesia($tgl_ttd);
        echo $this->cetak_dpa_model->preview_dpa_skpd_pergeseran($tgl_ttd,$ttd1,$ttd2,$id,$cetak,$detail,$tanggal_ttd,$doc,$gaji, $status1, $status2);
                
    } 

	function load_tanda_tangan($skpd=''){ 
		$lccr = $this->input->post('q');    
		echo $this->mpublic->load_tanda_tangan($skpd,$lccr); 
	}
    function load_tanda_tangan_bud($skpd=''){ 
        $lccr = $this->input->post('q');    
        echo $this->mpublic->load_tanda_tangan_bud($skpd,$lccr); 
    } 
	
}