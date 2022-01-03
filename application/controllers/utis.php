<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Uti extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('session');
	}		
	
	function importa(){
        $data['page_title']= 'IMPORT EXCEL';
        $this->template->set('title', 'IMPORT EXCEL');   
        $this->template->load('template','uti/import_excel',$data) ; 
    }
	
	function importb(){
        $data['page_title']= 'IMPORT PORTAL DATA';
        $this->template->set('title', 'IMPORT PORTAL DATA');   
        $this->template->load('template','uti/import_portal',$data) ; 
    }
    
    function config_mskpd(){
        $skpd     = $this->session->userdata('kdskpd');
        $sql = "SELECT kd_skpd,nm_skpd FROM ms_skpd order by kd_skpd,nm_skpd"; 
        $query1 = $this->db->query($sql);  		
		$result = array();
        foreach($query1->result_array() as $resulte)
        { 
            $result[] = array(                                
                        'kd_skpd' => $resulte['kd_skpd'],
						'nm_skpd' => $resulte['nm_skpd']
                        );
                        
        }
        echo json_encode($result); 	
		
    }
    
    function config_mskpd2($dskpd=''){
        $sql = "SELECT kd_skpd,nm_skpd FROM ms_skpd where left(kd_skpd,7)=left('$dskpd',7) order by kd_skpd,nm_skpd"; 
        $query1 = $this->db->query($sql);  		
		$result = array();
        foreach($query1->result_array() as $resulte)
        { 
            $result[] = array(                                
                        'kd_skpd' => $resulte['kd_skpd'],
						'nm_skpd' => $resulte['nm_skpd']
                        );
                        
        }
        echo json_encode($result); 	
		
    }
    
     function config_keg($dskpd=''){
        $sql = "SELECT kd_skpd,kd_kegiatan,nm_kegiatan FROM trskpd where kd_skpd='$dskpd' order by kd_kegiatan"; 
        $query1 = $this->db->query($sql);  		
		$result = array();
        foreach($query1->result_array() as $resulte)
        { 
            $result[] = array(                          
                        'kd_skpd' => $resulte['kd_skpd'],      
                        'kd_kegiatan' => $resulte['kd_kegiatan'],
						'nm_kegiatan' => $resulte['nm_kegiatan']
                        );
                        
        }
        echo json_encode($result); 	
		
    }
    
    
    function proses_menu(){
        
        $skpd = $this->input->post('skpd');
        $skpd2 = $this->input->post('skpd2');
        
        $init = $this->db->query("select id_user from [user] where user_name='$skpd'")->row();
        $nmor_user_utm = $init->id_user;
        
        $init2 = $this->db->query("select id_user from [user] where user_name='$skpd2'")->row();
        $nmor_user_kdua = $init2->id_user;
        
        $init3 = $this->db->query("delete from otori where user_id='$nmor_user_kdua'");
        
        $init4 = $this->db->query("insert into otori 
                                   select '$nmor_user_kdua' as user_id,menu_id,akses from otori where user_id='$nmor_user_utm'");
        
        $init4 = $this->db->query("delete from ms_skpd_cms where kd_skpd='$skpd2'");        
        
        $init4 = $this->db->query("insert into ms_skpd_cms 
                                  select kd_skpd,kd_urusan,nm_skpd,kd_fungsi,bank,rekening,alamat,npwp,sld_awal,kodepos,nilai_kua from ms_skpd where kd_skpd='$skpd2'");
                 
        if($init4){
            echo '1';    
        }else{
            echo '2';
        }
        
    }
	
	//portal data
	
	function request_data_query(){
        $curl = curl_init();
        $par1 = urlencode("getQuery");
        $par2 = urlencode("4e732ced3463d06de0ca9a15b6153677");
        $apikey = "0D610BE3B91DF2B2EDC5EC71787AFA26";
        
        curl_setopt_array($curl, array(
            //CURLOPT_URL => "http://bebas.pontianakkota.online/api/v1",
            CURLOPT_URL => "http://portaldata.pontianakkota.go.id/api/v1",
            
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            //CURLOPT_POSTFIELDS => "app=$par1&query_id=$par2",
            CURLOPT_POSTFIELDS => "app=$par1",            
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded;charset=UTF-8",
                "Accept: application/json",
                "x-api-key: $apikey",),));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            
            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                
				$result = json_decode($response);                
                $json = $result->data;
                $dec = json_encode($json);
                
                print_r($dec);
                
                
            }   
           
	}  
	
	function ld_lokasi() {
        
        $sql = "select 
                kd_skpd kd_lokasi,nm_skpd nm_lokasi from trdrka where left(kd_rek5,1)='4' 
				group by kd_skpd,nm_skpd order by kd_skpd";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_lokasi' => $resulte['kd_lokasi'],  
                        'nm_lokasi' => $resulte['nm_lokasi']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
            
    }


}
