<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller master data fungsi
 */

class Uti extends CI_Controller {
    
	function simekbang()
    {
        $data['page_title'] = 'DATA SIMEKBANG';
        $this->template->set('title', 'DATA SIMEKBANG');
        $this->template->load('template', 'uti/simekbang', $data);
    }
    
    function ambil_tetap()
    {
        $data['page_title'] = 'DATA PENETAPAN DAN PENERIMAAN';
        $this->template->set('title', 'DATA PENETAPAN DAN PENERIMAAN');
        $this->template->load('template', 'uti/tetap', $data);
    }


function pindah_giat()
    {
        $data['page_title'] = 'PINDAH KEGIATAN SIPP';
        $this->template->set('title', 'PINDAH KEGIATAN SIPP');
        $this->template->load('template', 'uti/pindah_kegiatan', $data);
    }
	
	
	function skpduser_sipp() {
        $lccr = $this->input->post('q');
        $id  = $this->session->userdata('pcUser');
        $sql = " select a.id_user,a.kd_skpd,a.nama as nm_skpd,b.user_id,b.akses,b.menu_id from [user] a left join otori b
on a.id_user=b.user_id
where right(a.user_name,3)='/an'
and b.menu_id ='152a'
group by a.id_user,a.kd_skpd,a.nama,b.user_id,b.akses,b.menu_id
order by a.kd_Skpd
";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_skpd' => $resulte['kd_skpd'],  
                        'nm_skpd' => $resulte['nm_skpd']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
            $query1->free_result();
    }
	
	function kegiatan_sipp($skpd='') {
		
		$kd_skpd = $skpd; 
        $lccr = $this->input->post('q');
        $id  = $this->session->userdata('pcUser');
        $sql = " select left(kode,22) kd_lama,nm_kegiatan nm_lama from(
			select kd_kegiatan+nm_kegiatan kode ,nm_kegiatan  from trdrka where kd_kegiatan+nm_kegiatan not in
			(select kd_kegiatan+nm_kegiatan from trskpd)
			and kd_kegiatan+nm_kegiatan like '%$kd_skpd%'
			group by kd_kegiatan+nm_kegiatan,nm_kegiatan
			)x
";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_lama' => $resulte['kd_lama'],  
                        'nm_lama' => $resulte['nm_lama']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
            $query1->free_result();
    }
	
	
	function kegiatan_fix($skpd='') {
		
		$kd_skpd = $skpd; 
        $lccr = $this->input->post('q');
        $id  = $this->session->userdata('pcUser');
        
		$sql = " 
		
		select kd_kegiatan kd_baru, nm_kegiatan as nm_baru from trskpd where kd_kegiatan like '%$kd_skpd%' and 
		(UPPER(kd_kegiatan) LIKE UPPER('%$lccr%') OR UPPER(nm_kegiatan) LIKE UPPER('%$lccr%'))
			
		";
		
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_baru' => $resulte['kd_baru'],  
                        'nm_baru' => $resulte['nm_baru']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
            $query1->free_result();
    }
	
	function request_simpan_pemindahan(){
        $kode_baru = $this->uri->segment(3);
		$kode_lama = $this->uri->segment(4);
		
        
		
		//input anggaran kas ro
                $sql1 = "update trdskpd_ro set kd_kegiatan ='$kode_baru', kd_gabungan = kd_skpd+'.'+'$kode_baru'
						 where kd_kegiatan ='$kode_lama'";
                $query1 = $this->db->query($sql1); 
				
        //input anggaran kas
                $sql2 = "update trdskpd set kd_kegiatan ='$kode_baru', kd_gabungan = kd_skpd+'.'+'$kode_baru'
						 where kd_kegiatan ='$kode_lama'";
                $query2 = $this->db->query($sql2);
        
		//input ro
                $sql3 = "update trdpo set kd_kegiatan ='$kode_baru', 
						 no_trdrka = left(no_trdrka,10)+'.'+'$kode_baru'+'.'+kd_rek5
						 where kd_kegiatan ='$kode_lama'";
                $query3 = $this->db->query($sql3);
				
				
		//input ro
                $sql4 = "update trdrka set kd_kegiatan ='$kode_baru',
						 no_trdrka = kd_skpd+'.'+'$kode_baru'+'.'+kd_rek5
						 where kd_kegiatan ='$kode_lama'";
                $query4 = $this->db->query($sql4);
				
				
				if($query4){
            echo '1';
          }else{
            echo '2';
          }  
        
            }


}
