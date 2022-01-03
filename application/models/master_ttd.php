<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 
 */

class master_ttd extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    function load_ttd_unit($skpd='',$lccr='') {
        if($skpd=='xxx'){
            $where='';
        }else{
            $where= "kd_skpd='$skpd' AND";
        }
        $sql = "SELECT * FROM ms_ttd WHERE $where (UPPER(kode) LIKE UPPER('%$lccr%') OR UPPER(nama) LIKE UPPER('%$lccr%'))";
        
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;        
        foreach($query1->result_array() as $resulte)
        { 
            
            $result[] = array(
                        'id' => $ii,        
                        'nip' => $resulte['nip'],
                        'urut' => $resulte['id'],   
                        'nama' => $resulte['nama']      
                        );
                        $ii++;
        }                     
        return json_encode($result);      
    }

    function load_ttd_bud(){
        $sql = "SELECT * FROM ms_ttd WHERE kode='bud'";

        $mas = $this->db->query($sql);
        $result = array();
        $ii = 0;        
        foreach($mas->result_array() as $resulte){     
            $result[] = array(
                        'id' => $ii,        
                        'nip' => $resulte['nip'],  
                        'nama' => $resulte['nama'],
                        'urut' => $resulte['id'],                           
                        'jabatan' => $resulte['jabatan']
                        );
                        $ii++;
        }           
           
        return json_encode($result);
           
    }


    function load_skpd_bp(){ 
        $kriteria = $this->input->post('q');  
        $where ='';
        if ($kriteria <> ''){                               
            $where="where (upper(kd_skpd) like upper('%$kriteria%') or upper(nm_skpd) like upper('%$kriteria%')) ";            
        } 
        $sql = "select kd_skpd,nm_skpd from ms_skpd $where order by kd_skpd";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte){ 
            $result[] = array(
                        'id' => $ii,        
                        'kd_skpd' => $resulte['kd_skpd'],  
                        'nm_skpd' => $resulte['nm_skpd'],  
                       
                        );
                        $ii++;
        }
           
        return json_encode($result);
    }

    function load_skpd_bp_pemb(){ 
        $id    = $this->session->userdata('kdskpd');
        $kriteria = $this->input->post('q');  
        $where ='';
        if ($kriteria <> ''){                               
            $where="where (upper(kd_skpd) like upper('%$kriteria%') or upper(nm_skpd) like upper('%$kriteria%')) ";            
        } 
        $sql = "select kd_skpd,nm_skpd from ms_skpd where kd_skpd='$id' order by kd_skpd";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte){ 
            $result[] = array(
                        'id' => $ii,        
                        'kd_skpd' => $resulte['kd_skpd'],  
                        'nm_skpd' => $resulte['nm_skpd'],  
                       
                        );
                        $ii++;
        }
           
        return json_encode($result);
    }

    function load_tanda_tangan($skpd,$lccr) {       
        
        if($skpd==''){
            $skpd=$this->session->userdata('kdskpd');
        }

        $sql = "SELECT * FROM ms_ttd WHERE (left(kd_skpd,20)= left('$skpd',20) AND kode in ('PA','KPA'))  AND (UPPER(kode) LIKE UPPER('%$lccr%') OR UPPER(nama) LIKE UPPER('%$lccr%'))";   
        
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;        
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'nip' => $resulte['nip'],  
                        'nama' => $resulte['nama'],
                        'jabatan' => $resulte['jabatan'],
                        'id_ttd' => $resulte['id']       
                        );
                        $ii++;
        }           
           
        return json_encode($result);
           
    }

    function load_bendahara_p($kdskpd){
    
        $query1 = $this->db->query("select nip,nama,id from ms_ttd where kd_skpd='$kdskpd' AND kode='BK'");  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'nip' => $resulte['nip'],  
                        'nama' => $resulte['nama'],
                        'id_ttd' => $resulte['id']
                        );
                        $ii++;
        }
           
           //return $result;
           echo json_encode($result);   
    }
}