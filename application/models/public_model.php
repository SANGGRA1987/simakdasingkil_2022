<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Fungsi Model
 */ 

class public_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }


   function get_all_susun(){
        $hasil = '';
        $sql = "select * from(
                    select a.kd_skpd,a.nm_skpd,sum(nilai) [nilai] from ms_skpd a join trdrka b on a.kd_skpd=b.kd_skpd group by a.kd_skpd,a.nm_skpd
                )as c where nilai>0 order by kd_skpd";
        $hasil = $this->db->query($sql);        
        return $hasil;                         
    }

    function get_all_susun_cari($lccari){
        $hasil = '';
        $sql = "select * from(
                    select a.kd_skpd,a.nm_skpd,sum(nilai) [nilai] from ms_skpd a join trdrka b on a.kd_skpd=b.kd_skpd group by a.kd_skpd,a.nm_skpd
                )as c where nilai>0 and kd_skpd like '$lccari%' order by kd_skpd";
        $hasil = $this->db->query($sql);        
        return $hasil;                         
    }
    function get_count_susun(){
        $hasil = '';
        $sql = "select * from(
                    select a.kd_skpd,a.nm_skpd,sum(nilai) [nilai] from ms_skpd a join trdrka b on a.kd_skpd=b.kd_skpd group by a.kd_skpd,a.nm_skpd
                )as c where nilai>0 order by kd_skpd";
        $hasil = $this->db->query($sql)->num_rows();      
        return $hasil;                             
    }

    function get_count_teang_susun($lccari){
        $hasil = '';
        $sql = "select * from(
                    select a.kd_skpd,a.nm_skpd,sum(nilai) [nilai] from ms_skpd a join trdrka b on a.kd_skpd=b.kd_skpd group by a.kd_skpd,a.nm_skpd
                )as c where nilai>0 and kd_skpd='$lccari%' order by kd_skpd";
        $hasil = $this->db->query($sql)->num_rows();      
        return $hasil;                             
    }
	
	// Tampilkan semua master data fungsi
	//function getAll($limit, $offset)
    function getAll($tabel,$field1,$limit, $offset)
	{
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->order_by($field1, 'asc');
		$this->db->limit($limit,$offset);
		return $this->db->get();
	}
	
	function getAll2($tabel,$field1,$limit, $offset)
	{
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where('status', '1');
		$this->db->order_by($field1, 'asc');
		//$this->db->limit($limit,$offset);
		return $this->db->get();
	}
	
	function getAll_bidang($tabel,$field,$data,$field_older,$limit, $offset)
	{
		$this->db->select('a.kd_skpd,a.kunci,
			a.kunci_murni, a.kunci_angkas_m, a.kunci_geser, 
			a.kunci_angkas_g, a.kunci_ubah, a.kunci_angkas_u,
			b.nm_skpd,c.status_rancang,c.status_ubah');
		$this->db->from($tabel.' as a');
		$this->db->join('ms_skpd as b', 'a.kd_skpd = b.kd_skpd');
		$this->db->join('trhrka as c', 'b.kd_skpd = c.kd_skpd');
		$this->db->where('a.'.$field,$data);
		//$this->db->where('a.kunci','0');
		$this->db->group_by('a.kd_skpd,b.nm_skpd,a.kunci,c.status_rancang,c.status_ubah,
			a.kunci_murni, 
			a.kunci_angkas_m, 
			a.kunci_geser, 
			a.kunci_angkas_g, 
			a.kunci_ubah, 
			a.kunci_angkas_u');
		$this->db->order_by('a.'.$field_older, 'asc');
		//$this->db->limit($limit,$offset);
		return $this->db->get();
	}
	
	function getuser($tabel,$field1,$limit, $offset)
	{
		$this->db->query("SELECT id_user,nama,kd_skpd, case when jenis=1 then 'Simakda' else 'Siadinda' end as jns FROM [user] ORDER BY id_user asc");
		$this->db->from($tabel);
		$this->db->order_by($field1, 'asc');
		$this->db->limit($limit,$offset);
		return $this->db->get();
	}
	
    function getcari($tabel,$field,$field1,$limit, $offset,$lccari)
	{
		$this->db->select('*');
		$this->db->from($tabel);
        $this->db->or_like($field, $lccari);  
        $this->db->or_like($field1, $lccari);      
		$this->db->order_by($field, 'asc');
        $this->db->limit($limit,$offset);
		return $this->db->get();
	}

	function getcariskpd($tabel,$field,$data,$field_older,$limit, $offset)
	{
		$this->db->select('kd_skpd');
		$this->db->from($tabel);
		$this->db->where($field,$data);
		$this->db->where('kunci','0');
		$this->db->order_by($field_older, 'asc');
		//$this->db->limit($limit,$offset);
		return $this->db->get();
	}
 
    function getAllc($tabel,$field1)
	{
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->order_by($field1, 'asc');
		//$this->db->limit($limit,$offset);
		return $this->db->get();
	}
	
	// Total jumlah data
	function get_count($tabel)
	{
		return $this->db->get($tabel)->num_rows();
	}
    
	function get_count_cari2($tabel,$field,$data,$field_older)
	{
		$this->db->select('*');
        $this->db->from($tabel);
        $this->db->where($field, $data);
        $this->db->order_by($field_older, 'asc');
        return $this->db->get()->num_rows();
	}
	
	function get_count_cari($tabel,$field1,$field2,$data)
	{
        $this->db->select('*');
		$this->db->from($tabel);
        $this->db->or_like($field1, $data);  
        $this->db->or_like($field2, $data);      
		$this->db->order_by($field1, 'asc');
		return $this->db->get()->num_rows();
		//return $this->db->get('ms_fungsi')->num_rows();
	}
    function get_count_teang($tabel,$field,$field1,$lccari)
	{
        $this->db->select('*');
		$this->db->from($tabel);
        $this->db->or_like($field, $lccari);  
        $this->db->or_like($field1, $lccari);      
		$this->db->order_by($field, 'asc');
		return $this->db->get()->num_rows();
		//return $this->db->get('ms_fungsi')->num_rows();
	}
	// Ambil by ID
	function get_by_id($tabel,$field1,$id)
	{
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($field1, $id);
		return $this->db->get();
	}
    
	function get_by_id_top1($tabel,$field1,$id)
	{
		$this->db->select('top 1 *');
		$this->db->from($tabel);
		$this->db->where($field1, $id);
		return $this->db->get();
	}
        
	//cari
    function cari($tabel,$field1,$field2,$limit, $offset,$data)
	{
		$this->db->select('*');
		$this->db->from($tabel);
        $this->db->or_like($field2, $data);  
        $this->db->or_like($field1, $data);      
		$this->db->order_by($field1, 'asc');
		return $this->db->get();
	}

	// Simpan data
	function save($tabel,$data)
	{
		$this->db->insert($tabel, $data);
	}
	
	// Update data
	function update($tabel,$field1,$id, $data)
	{
		$this->db->where($field1, $id);
		$this->db->update($tabel, $data); 	
	}
	
	// Hapus data
	function delete($tabel,$field1,$id)
	{
		$this->db->where($field1, $id);
		$this->db->delete($tabel);
	}
    
    function getSome($tabel,$field1,$field2,$x)
        {
        $this->db->select('*');
        $this->db->from($tabel);
        $this->db->where($field2, $x);
        $this->db->order_by($field1, 'asc');
        return $this->db->get();
        }
  
    function skpduser($lccr='') {

        $id    = $this->session->userdata('kdskpd');
        $type  = $this->session->userdata('type');
        if($type=='1'){
            $sql = "SELECT kd_skpd,nm_skpd FROM ms_skpd where (upper(kd_skpd) like upper('%$lccr%') or upper(nm_skpd) like upper('%$lccr%')) order by kd_skpd ";
        }else{
            $sql = "SELECT kd_skpd,nm_skpd FROM ms_skpd where kd_skpd='$id' order by kd_skpd ";            
        }
        
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_skpd' => $resulte['kd_skpd'],  
                        'nm_skpd' => $resulte['nm_skpd'],
                        'jns' => '' //$resulte['jns']
                        );
                        $ii++;
        }
           
        return $result;
    }

    function skpduser_induk($lccr='') {

        $id    = $this->session->userdata('kdskpd');
        $type  = $this->session->userdata('type');

        $sql = "SELECT kd_skpd,nm_skpd,'' jns FROM ms_skpd where right(kd_skpd,4)='0000' and (upper(kd_skpd) like upper('%$lccr%') or upper(nm_skpd) like upper('%$lccr%')) order by kd_skpd ";

        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_skpd' => $resulte['kd_skpd'],  
                        'nm_skpd' => $resulte['nm_skpd'],
                        'jns' => $resulte['jns']
                        );
                        $ii++;
        }
           
        return $result;
    }

    function load_tanda_tangan($skpd,$lccr) {       
        
        if($skpd==''){
            $skpd=$this->session->userdata('kdskpd');
        }

        $sql = "SELECT * FROM ms_ttd WHERE (left(kd_skpd,22)= left('$skpd',22) AND kode in ('PA','KPA'))  AND (UPPER(kode) LIKE UPPER('%$lccr%') OR UPPER(nama) LIKE UPPER('%$lccr%'))";   
        
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

    function load_tanda_tangan_bud($kdskpd,$cari=''){
    
        $query1 = $this->db->query("
                    SELECT * from (
        SELECT nip,nama,id, jabatan from ms_ttd where  left(kd_skpd,17)='5.02.0.00.0.00.02' and kode in ('KPA','PA')
        UNION ALL
        SELECT nip, nama, id, jabatan from ms_ttd where kode in ('BUD','PPKD','PA') 
        ) okei where nama like '%$cari%'");  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'nip' => $resulte['nip'],  
                        'nama' => $resulte['nama'],
                        'id_ttd' => $resulte['id'],
                        'jabatan' => $resulte['jabatan'],
                        );
                        $ii++;
        }
           
           //return $result;
           echo json_encode($result);   
    }


 function _mpdf_margin($judul='',$isi='',$lMargin=10,$rMargin=10,$font='',$orientasi='',$hal='', $fonsize='',$atas='', $bawah='', $kiri='', $kanan='') {
                

        ini_set("memory_limit","-1M");
        ini_set("MAX_EXECUTION_TIME","-1");
        $this->load->library('mpdf');
		//$this->mpdf->SetHeader('||Halaman {PAGENO} /{nb}');
        
        
        $this->mpdf->defaultheaderfontsize = 10;	/* in pts */
        $this->mpdf->defaultheaderfontstyle = I;	/* blank, B, I, or BI */
        $this->mpdf->defaultheaderline = 1; 	/* 1 to include line below header/above footer */

        $this->mpdf->defaultfooterfontsize = 3;	/* in pts */
        $this->mpdf->defaultfooterfontstyle = I;	/* blank, B, I, or BI */
        $this->mpdf->defaultfooterline = 1; 
		$sa=1;
		$tes=0;
		if ($hal==''){
		$hal1=1;
		} 
		if($hal!==''){
		$hal1=$hal;
		}
		if ($fonsize==''){
		$size=12;
		}else{
		$size=$fonsize;
		} 
		
		$this->mpdf = new mPDF('utf-8', array(215,330),$size); //folio
        $this->mpdf->AddPage($orientasi,'',$hal,'1','off',$kiri,$kanan,$atas,$bawah);
		if ($hal==''){
			$this->mpdf->SetFooter("");
		}
		else{
			$this->mpdf->SetFooter("Printed on Simakda SKPD || Halaman {PAGENO}  ");
		}
        if (!empty($judul)) $this->mpdf->writeHTML($judul);
        $this->mpdf->writeHTML($isi);         
        $this->mpdf->Output();
               
    }

  function  tanggal_format_indonesia($tgl){
        $tanggal  = explode('-',$tgl); 
        $bulan  = $this->getBulan($tanggal[1]);
        $tahun  =  $tanggal[0];
        return  $tanggal[2].' '.$bulan.' '.$tahun;

        }
         

           
      function  getBulan($bln){
			switch  ($bln){
			case  1:
			return  "Januari";
			break;
			case  2:
			return  "Februari";
			break;
			case  3:
			return  "Maret";
			break;
			case  4:
			return  "April";
			break;
			case  5:
			return  "Mei";
			break;
			case  6:
			return  "Juni";
			break;
			case  7:
			return  "Juli";
			break;
			case  8:
			return  "Agustus";
			break;
			case  9:
			return  "September";
			break;
			case  10:
			return  "Oktober";
			break;
			case  11:
			return  "November";
			break;
			case  12:
			return  "Desember";
			break;
		}
    }
	
		 
        function  tanggal_indonesia($tgl){
        $tanggal  =  substr($tgl,8,2);
        $bulan  = substr($tgl,5,2);
        $tahun  =  substr($tgl,0,4);
        return  $tanggal.'-'.$bulan.'-'.$tahun;
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
 
	function get_nama($kode,$hasil,$tabel,$field)
		{
			$this->db->select($hasil);
			$this->db->where($field, $kode);
			$q = $this->db->get($tabel);
			$data  = $q->result_array();
			$baris = $q->num_rows();
			return $data[0][$hasil];
		}
		
		
	function _mpdf($judul='',$isi='',$lMargin = 10 ,$rMargin=10,$font='',$orientasi='',$hal='', $fonsize='') {
                

        ini_set("memory_limit","-1M");
        ini_set("MAX_EXECUTION_TIME","-1");
        $this->load->library('mpdf');
		//$this->mpdf->SetHeader('||Halaman {PAGENO} /{nb}');
        
        
        $this->mpdf->defaultheaderfontsize = 10;	/* in pts */
        $this->mpdf->defaultheaderfontstyle = I;	/* blank, B, I, or BI */
        $this->mpdf->defaultheaderline = 1; 	/* 1 to include line below header/above footer */

        $this->mpdf->defaultfooterfontsize = 3;	/* in pts */
        $this->mpdf->defaultfooterfontstyle = I;	/* blank, B, I, or BI */
        $this->mpdf->defaultfooterline = 1; 
		$sa=1;
		$tes=0;
		if ($hal==''){
		$hal1=1;
		} 
		if($hal!==''){
		$hal1=$hal;
		}
		if ($fonsize==''){
		$size=12;
		}else{
		$size=$fonsize;
		} 
		
		$this->mpdf = new mPDF('utf-8', array(215,330),$size); //folio
							//$this->mpdf->useOddEven = 1;						

        $this->mpdf->AddPage($orientasi,'',$hal,'1','off');
		if ($hal==''){
			$this->mpdf->SetFooter("");
		}
		else{
			$this->mpdf->SetFooter("Printed on Simakda || Halaman {PAGENO}  ");
		}
        if (!empty($judul)) $this->mpdf->writeHTML($judul);
        $this->mpdf->writeHTML($isi);         
        $this->mpdf->Output();
    }

	function  getBulan_kasda($bln){
        switch  ($bln){
        case  1:
        return  "JANUARI";
        break;
        case  2:
        return  "FEBRUARI";
        break;
        case  3:
        return  "MARET";
        break;
        case  4:
        return  "APRIL";
        break;
        case  5:
        return  "MEI";
        break;
        case  6:
        return  "JUNI";
        break;
        case  7:
        return  "JULI";
        break;
        case  8:
        return  "AGUSTUS";
        break;
        case  9:
        return  "SEPTEMBER";
        break;
        case  10:
        return  "OKTOBER";
        break;
        case  11:
        return  "NOVEMBER";
        break;
        case  12:
        return  "DESEMBER";
        break;
		}
    }		

		
		function  tanggal_format_indonesia_kasda2($tgl){
			$tanggal  = explode('-',$tgl); 
			$bulan  = $this-> getBulan_kasda($tanggal[1]);
			$tahun  =  $tanggal[0];
			return  $tanggal[2].' '.$bulan;
        }


    function _mpdf2($judul='',$isi='',$lMargin=10,$rMargin=10,$font='',$orientasi='',$hal='', $fonsize='') {
                

        ini_set("memory_limit","-1M");
        ini_set("MAX_EXECUTION_TIME","-1");
        $this->load->library('mpdf');
		//$this->mpdf->SetHeader('||Halaman {PAGENO} /{nb}');
        
        
        $this->mpdf->defaultheaderfontsize = 10;	/* in pts */
        $this->mpdf->defaultheaderfontstyle = I;	/* blank, B, I, or BI */
        $this->mpdf->defaultheaderline = 1; 	/* 1 to include line below header/above footer */

        $this->mpdf->defaultfooterfontsize = 3;	/* in pts */
        $this->mpdf->defaultfooterfontstyle = I;	/* blank, B, I, or BI */
        $this->mpdf->defaultfooterline = 1; 
		$sa=1;
		$tes=0;
		if ($hal==''){
		$hal1=1;
		} 
		if($hal!==''){
		$hal1=$hal;
		}
		if ($fonsize==''){
		$size=12;
		}else{
		$size=$fonsize;
		} 
		
		$this->mpdf = new mPDF('utf-8', array(215,330),$size); //folio
							//$this->mpdf->useOddEven = 1;						

        $this->mpdf->AddPage($orientasi,'',$hal1,'1','off');
		if ($hal==''){
			$this->mpdf->SetFooter("Printed on Simakda ||  ");
		}
		else{
			$this->mpdf->SetFooter("Printed on Simakda || Halaman {PAGENO}  ");
		}
        if (!empty($judul)) $this->mpdf->writeHTML($judul);
        $this->mpdf->writeHTML($isi);         
        $this->mpdf->Output();
               
    }
		 

}

/* End of file fungsi_model.php */
/* Location: ./application/models/fungsi_model.php */