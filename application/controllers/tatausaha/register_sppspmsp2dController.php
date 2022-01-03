<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class register_sppspmsp2dController extends CI_Controller {

	function __construct()
	{	 
		parent::__construct();
		$this->load->model('public_model','Mpublic');	
	}  
	
	
    function index(){ 
/*         $reg = $this->session->userdata('kdskpd');
        $cek_reg = substr($reg,9,2);        
        
        if($cek_reg=="00"){ */
        $data['page_title']= 'REGISTER S P 2 D';
        $this->template->set('title', 'REGISTER S P 2 D');   
        $this->template->load('template','tukd/sp2d/register/sp2d_global',$data) ;     
       /*  }else{
        $data['page_title']= 'REGISTER S P 2 D';
        $this->template->set('title', 'REGISTER S P 2 D');   
        $this->template->load('template','tukd/sp2d/register/sp2d',$data) ;     
        }         		        
 */
    }	

  function skpd() {
    $skpd = $this->session->userdata('kdskpd');
    $lccr = $this->input->post('q');

    if ($lccr == '') {
      $where = '';
    } else {
      $where = "WHERE upper(kd_skpd) like upper('%$lccr%') or upper(nm_skpd) like upper('%$lccr%')";
    }

    $sql = "SELECT kd_skpd,nm_skpd FROM ms_skpd $where";
    $query1 = $this->db->query($sql);  
    $result = array();
    $ii = 0;
    foreach($query1->result_array() as $resulte)
    { 

      $result[] = array(
        'id' => $ii,        
        'kd_skpd' => $resulte['kd_skpd'],  
        'nm_skpd' => $resulte['nm_skpd'],  

      );
      $ii++;
    }

    echo json_encode($result);
    $query1->free_result(); 	   
  }
    
    function bulan() {
        for ($count = 1; $count <= 12; $count++)
        {
            $result[]= array(
                     'bln' => $count,
                     'nm_bulan' => $this->tukd_model->getBulan($count)
                     );    
        }
        echo json_encode($result);
    }

      
      function load_skpd_camat(){
        //$kd_skpd = $this->session->userdata('kdskpd'); 		
		$sql = "select 'X' as kd_skpd,'CETAK SELURUH' as nm_skpd
				union ALL
				select kd_skpd,nm_skpd from ms_skpd";
//where LEFT (kd_skpd,4)='7.01'";

        $mas = $this->db->query($sql);
        $result = array();
        $ii = 0;        
        foreach($mas->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_skpd' => $resulte['kd_skpd'],  
                        'nm_skpd' => $resulte['nm_skpd']
                        );
                        $ii++;
        }           
           
        echo json_encode($result);
        $mas->free_result();
    	   
	}

    
	function load_ttd($ttd){
    $kd_skpd = $this->session->userdata('kdskpd'); 		
    $sql = "SELECT * FROM ms_ttd WHERE kode='$ttd'";

        $mas = $this->db->query($sql);
        $result = array();
        $ii = 0;        
        foreach($mas->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'nip' => $resulte['nip'],  
                        'nama' => $resulte['nama'],
                        'jabatan' => $resulte['jabatan']
                        );
                        $ii++;
        }           
           
        echo json_encode($result);
        $mas->free_result();
    	   
	}
	
    function pgiat($cskpd='') {
        
        $sql = "SELECT DISTINCT kd_subkegiatan,nm_subkegiatan FROM trskpd WHERE kd_skpd = '$cskpd' AND jns_kegiatan = '5' GROUP BY kd_subkegiatan,nm_subkegiatan ORDER BY kd_subkegiatan";
        
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_subkegiatan' => $resulte['kd_subkegiatan'],  
                        'nm_subkegiatan' => $resulte['nm_subkegiatan'],  
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}

    function ld_rek($giat='') {
    
        $sql = " SELECT a.kd_rek6 as kd_rek6,b.nm_rek6 as nm_rek6 FROM trdrka a inner join ms_rek6 b on a.kd_rek6=b.kd_rek6 where a.kd_subkegiatan='$giat' order by a.kd_rek6 ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_rek6' => $resulte['kd_rek6'],  
                        'nm_rek6' => $resulte['nm_rek6']
                       
                        );
                        $ii++;
        }
           
        echo json_encode($result);
     $query1->free_result();	   
	}
  
     function config_skpd(){
        $skpd     = $this->session->userdata('kdskpd');
        $sql = "SELECT a.kd_skpd,a.nm_skpd,b.status_rancang,b.statu,b.status_sempurna,b.status_ubah FROM  ms_skpd a LEFT JOIN trhrka b ON a.kd_skpd=b.kd_skpd WHERE a.kd_skpd = '$skpd'";
        $query1 = $this->db->query($sql);  
        
        $test = $query1->num_rows();
        
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result = array(
                        'id' => $ii,        
                        'kd_skpd' => $resulte['kd_skpd'],
                        'nm_skpd' => $resulte['nm_skpd'],
                        'statu' => $resulte['statu'],
                        'status_ubah' => $resulte['status_ubah'],
                        'status_rancang' => $resulte['status_rancang'],
                        'status_sempurna' => $resulte['status_sempurna']
                        );
                        $ii++;
        }
        

        
        
        echo json_encode($result);
        $query1->free_result();   
    } 


}	