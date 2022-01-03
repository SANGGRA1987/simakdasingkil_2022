<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Rka_sbiaya extends CI_Controller {
	function __contruct()
	{	
		parent::__construct();
	}
    
    function tambah_rka()
    {
        $jk   = $this->rka_model->combo_skpd();
        $ry   =  $this->rka_model->combo_giat();
        $cRet = '';
        
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" >
                   <tr >                       
                        <td>INPUT ANGGARAN$jk</td>
                        <td>$ry</td>
                        </tr>
                  ";         
        $cRet .="</table>";
        $data['prev']= $cRet;
        $data['page_title']= 'INPUT RENCANA KEGIATAN ANGGARAN';
        $this->template->set('title', 'INPUT RKA');   
         $sql = "select a.kd_rek5,b.nm_rek5,a.nilai,a.nilai as total from trdrka a inner join ms_rek5 b on a.kd_rek5=b.kd_rek5";                   
        
        $query1 = $this->db->query($sql);  
        $results = array();
        $i = 1;
        foreach($query1->result_array() as $resulte)
        { 
            $results[] = array(
                       'id' => $i,
                        'kd_rek5' => $resulte['kd_rek5'],  
                        'nm_rek5' => $resulte['nm_rek5'],  
                        'nilai' => $resulte['nilai'] ,
                        'total' => $resulte['total']                            
                        );
                        $i++;
        }
        $this->template->load('template','anggaran/rka/tambah_rka_sbiaya',$data) ; 
        $query1->free_result();
   }
   
   function ld_rek($rek='') {
    
        $initrek = substr($rek,0,5);
        $lcc = $this->input->post('q');
        if ($rek==''){
            $dan='';
            $dan2="where (UPPER(a.uraian) LIKE UPPER('%$lcc%'))";
        }else{
            $dan="where e.kd_rek5 like '%$initrek%'";
            $dan2="and (UPPER(a.uraian) LIKE UPPER('%$lcc%'))";
        }
        
        $sql = "select 
                e.kd_harga AS kodeHargaUtama,e.uraian AS namaHargaUtama,
                d.kd_harga AS kodeHargaKelompok,'- '+d.uraian AS namaHargaKelompok,
                c.kd_harga AS kodeHargaJenis,'-- '+c.uraian AS namaHargaJenis,
                b.kd_harga AS kodeHargaObjek,'--- '+b.uraian AS namaHargaObjek,
                a.kd_harga AS kodeHargaRincian,a.uraian AS namaHargaRincian,a.satuan,a.harga
                from ms_harga4 a
                left join ms_harga3 b on b.kd_harga=left(a.kd_harga,7)
                left join ms_harga2 c on c.kd_harga=left(a.kd_harga,5)
                left join ms_harga1 d on d.kd_harga=left(a.kd_harga,3)
                left join ms_harga e on e.kd_harga=left(a.kd_harga,1) $dan $dan2 order by a.kd_harga";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'namaHargaUtama' => $resulte['namaHargaUtama'],  
                        'namaHargaKelompok' => $resulte['namaHargaKelompok'],                          
                        'namaHargaJenis' => $resulte['namaHargaJenis'],
                        'namaHargaObjek' => $resulte['namaHargaObjek'],                        
                        'kodeHargaRincian' => $resulte['kodeHargaRincian'],  
                        'namaHargaRincian' => $resulte['namaHargaRincian'],
                        'satuan' => $resulte['satuan'],
                        'harga' => number_format($resulte['harga'],"2",".",","),
                       
                        );
                        $ii++;
        }
           
        echo json_encode($result);
            $query1->free_result();
    } 
    
    function ld_rek_biaya() {
        $nmrek = $this->input->post('nmrek');
        $lcc = $this->input->post('q');
        if ($nmrek==''){
            $dan='';
            $dan2="where (UPPER(a.uraian) LIKE UPPER('%$lcc%'))";
        }else{
            $dan="where a.uraian = '$nmrek'";
            $dan2="and (UPPER(a.uraian) LIKE UPPER('%$lcc%'))";
        }
        
        $sql = "select 
                e.kd_harga AS kodeHargaUtama,e.uraian AS namaHargaUtama,
                d.kd_harga AS kodeHargaKelompok,'- '+d.uraian AS namaHargaKelompok,
                c.kd_harga AS kodeHargaJenis,'-- '+c.uraian AS namaHargaJenis,
                b.kd_harga AS kodeHargaObjek,'--- '+b.uraian AS namaHargaObjek,
                a.kd_harga AS kodeHargaRincian,a.uraian AS namaHargaRincian,a.satuan,a.harga
                from ms_harga4 a
                left join ms_harga3 b on b.kd_harga=left(a.kd_harga,7)
                left join ms_harga2 c on c.kd_harga=left(a.kd_harga,5)
                left join ms_harga1 d on d.kd_harga=left(a.kd_harga,3)
                left join ms_harga e on e.kd_harga=left(a.kd_harga,1) $dan $dan2 order by a.kd_harga";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'namaHargaUtama' => $resulte['namaHargaUtama'],  
                        'namaHargaKelompok' => $resulte['namaHargaKelompok'],                          
                        'namaHargaJenis' => $resulte['namaHargaJenis'],
                        'namaHargaObjek' => $resulte['namaHargaObjek'],                        
                        'kodeHargaRincian' => $resulte['kodeHargaRincian'],  
                        'namaHargaRincian' => $resulte['namaHargaRincian'],
                        'satuan' => $resulte['satuan'],
                        'harga' => number_format($resulte['harga'],"2",".",","),
                       
                        );
                        $ii++;
        }
           
        echo json_encode($result);
            $query1->free_result();
    }
   
    
}